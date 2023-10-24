<?php
	require('../clases/directorios.class.php');
    require('../clases/ppal.class.php');

    class Model extends ppal {

    	public $schema ='principales';
        public $tabla = 'evoluciones';
       	private $directorios;
        public $filtroMapa = [
            0 => "status = '?'",
            1 => "status = '?'"
        ];

	    public function __construct()
	    {
	    	$this->directorios = new Directorios();
	    }

	    public function evoluciones_consultar($args) {

            $sql = "
                select
                    t.*,
				    coalesce(NULLIF(ppal.basicas_diagnosticos_armar_lista(t.diagnosticos), null),'[]'::jsonb) as diagnosticos_procesados,
				    coalesce(NULLIF(ppal.basicas_referencias_armar_lista(t.referencias), null), '[]'::jsonb) as referencias_procesados,
				    TO_CHAR(t.fecha :: DATE, 'dd-mm-yyyy') as fecha_arreglada
                FROM principales.evoluciones as t
                WHERE t.id_historia = ?
                ORDER BY t.fecha desc, t.hora desc
            ";

            $datos = $this->i_pdo($sql, $args, true)->fetchAll(PDO::FETCH_ASSOC);

            foreach ($datos as &$valor) {

            	$ruta = "../imagenes/evoluciones/$valor[id_historia]/$valor[fecha]";

	            $valor['txt_bio'] = $this->directorios->traer_txt($ruta, 'biomicroscopia');
	            $valor['txt_fondo'] = $this->directorios->traer_txt($ruta, 'fondo_ojo');

	            $valor['imagen_biomicroscopia'] = $ruta."/biomicroscopia.png";
	            $valor['imagen_fondo_ojo'] = $ruta."/fondo_ojo.png";

	            $valor['imagenes_antes_cirugia'] = glob($ruta.'/antes_cirugia/*.*');
	            $valor['imagenes_despues_cirugia'] = glob($ruta.'/despues_cirugia/*.*');

            }
            
            return json_encode($datos, true);

        }
     
    	public function cargar_evolucion($args) {

    		///////////////////////////////////////////////////////////////////////////////////////////////////////
    		//DATOS
    		///////////////////////////////////////////////////////////////////////////////////////////////////////

    		// echo "<pre>";
   			// print_r($args);
   			// echo "</pre>";

    		$dia = $this->fechaHora('America/Caracas','Y-m-d');

    		$id_historia = $args[132];

    		$referencia_galeria_antes = $args[124];
    		$referencia_galeria_despues = $args[126];

    		$json_biomicroscopia = $args[128];
    		$json_fondo_ojo = $args[129];

    		$img_biomicroscopia = str_replace('%2B', '+', $args[130]);
    		$img_fondo_ojo = str_replace('%2B', '+', $args[131]);

    		$img_biomicroscopia = str_replace('%27', "'", $img_biomicroscopia);
    		$img_fondo_ojo = str_replace('%27', "'", $img_fondo_ojo);

    		unset($args[124]);
			unset($args[126]);
			unset($args[128]);
			unset($args[129]);
			unset($args[130]);
			unset($args[131]);

			$args = array_values($args);

			$args[2]   = json_encode($args[2]);   //nota
			$args[54]  = json_encode($args[54]);  //pruebas_nota
			$args[67]  = json_encode($args[67]);  //motilidad_nota
			$args[92]  = json_encode($args[92]);  //nota_b_od
			$args[93]  = json_encode($args[93]);  //nota_b_oi
			$args[94]  = json_encode($args[94]);  //nota_f_od
			$args[95]  = json_encode($args[95]);  //nota_f_oi
			$args[98]  = json_encode($args[98]);  //referencias
			$args[99]  = json_encode($args[99]);  //diagnosticos
			$args[123] = json_encode($args[123]); //plan

			//echo "<pre>";
   			//print_r($args);
   			//echo "</pre>";

			///////////////////////////////////////////////////////////////////////////////////////////////////////
    		//COMPROBAR REPETIDOS
    		///////////////////////////////////////////////////////////////////////////////////////////////////////
    		$sql = "select 1 from principales.evoluciones where id_historia = ? and fecha_real = ?";
            
            $repetido = $this->i_pdo($sql, [$id_historia, $dia], true)->fetchColumn();

            if (!$repetido) {

	    		///////////////////////////////////////////////////////////////////////////////////////////////////////
	    		//GENERA LA CARPETA DE IMAGENES DEL PACIENTE
	    		///////////////////////////////////////////////////////////////////////////////////////////////////////

	    		$existe_archivo = $this->directorios->consultar_directorio("../imagenes/evoluciones/$id_historia");

	    		$ruta = "../imagenes/evoluciones/$id_historia/$dia";

	    		if (!$existe_archivo) {

	    			$this->directorios->crear_directorio($id_historia.'/', "../imagenes/evoluciones/");
	    			$this->directorios->crear_directorio($dia, "../imagenes/evoluciones/$id_historia/");
	    			$this->directorios->copiar_directorio("../imagenes/evoluciones/modelo", $ruta);

	    		} else {

	    			$existe_archivo = $this->directorios->consultar_directorio("../imagenes/evoluciones/$id_historia/$dia");

	    			if (!$existe_archivo) {

	    				$this->directorios->crear_directorio($dia, "../imagenes/evoluciones/$id_historia");
	    				$this->directorios->copiar_directorio("../imagenes/evoluciones/modelo", $ruta);

	    			}

	    		}

	    		///////////////////////////////////////////////////////////////////////////////////////////////////////
	    		//ASIGNAR IMAGENES
	    		///////////////////////////////////////////////////////////////////////////////////////////////////////

	    		$galeria_antes = $this->directorios->categorizar_imagenes($referencia_galeria_antes);
	    		$galeria_despues = $this->directorios->categorizar_imagenes($referencia_galeria_despues);

	    		foreach($galeria_antes as $llave => $valor) {

	        		$tmp_name = $valor["tmp_name"];
	        		//$nombre = basename($valor["name"]);
	        		$ext = pathinfo($valor['name'], PATHINFO_EXTENSION);
	        		
	        		move_uploaded_file($tmp_name, "$ruta/antes_cirugia/img-$llave.$ext");

				}

				foreach($galeria_despues as $llave => $valor) {

					$tmp_name = $valor["tmp_name"];
	        		//$nombre = basename($valor["name"]);
	        		$ext = pathinfo($valor['name'], PATHINFO_EXTENSION);
	        		
	        		move_uploaded_file($tmp_name, "$ruta/despues_cirugia/img-$llave.$ext");

				}

				$this->directorios->base64_imagen("$ruta/biomicroscopia.png", $img_biomicroscopia, $flags = 0);
				$this->directorios->base64_imagen("$ruta/fondo_ojo.png", $img_fondo_ojo, $flags = 0);

	    		///////////////////////////////////////////////////////////////////////////////////////////////////////
	    		//ASIGNAR TXT
	    		///////////////////////////////////////////////////////////////////////////////////////////////////////
	    		$this->directorios->editar_txt("$ruta/biomicroscopia.txt", json_encode($json_biomicroscopia), $flags = 0);
	    		$this->directorios->editar_txt("$ruta/fondo_ojo.txt", json_encode($json_fondo_ojo), $flags = 0);

	    		//TRAER DATOS DE TXT -- ESTO ES PARA LA CONSULTA
	    		//$txt_bio = $this->directorios->traer_txt($ruta, 'biomicroscopia');

	    		///////////////////////////////////////////////////////////////////////////////////////////////////////
	    		//INSERTAR HISTORIA
	    		///////////////////////////////////////////////////////////////////////////////////////////////////////
	    		
	    		$sql = "
	    			insert into principales.evoluciones(			
						problematico,
						fecha,
						nota,
						agudeza_od_4,
						agudeza_oi_4,
						correccion_4,
						allen_4,
						jagger_4,
						e_direccional_4,
						numeros_4,
						decimales_4,
						fracciones_4,
						letras_4,
						agudeza_od_1,
						agudeza_oi_1,
						correccion_1,
						allen_1,
						jagger_1,
						e_direccional_1,
						numeros_1,
						decimales_1,
						fracciones_1,
						letras_1,
						agudeza_od_lectura,
						agudeza_oi_lectura,
						correccion_lectura,
						allen_lectura,
						jagger_lectura,
						e_direccional_lectura,
						numeros_lectura,
						decimales_lectura,
						fracciones_lectura,
						letras_lectura,
						estereopsis,
						test,
						reflejo,
						pruebas,
						correccion_pruebas,
						pruebas_od_1,
						pruebas_od_2,
						pruebas_od_3,
						pruebas_od_4,
						pruebas_od_5,
						pruebas_od_6,
						pruebas_od_7,
						pruebas_od_8,
						pruebas_oi_1,
						pruebas_oi_2,
						pruebas_oi_3,
						pruebas_oi_4,
						pruebas_oi_5,
						pruebas_oi_6,
						pruebas_oi_7,
						pruebas_oi_8,
						pruebas_nota,
						motilidad_od_1,
						motilidad_od_2,
						motilidad_od_3,
						motilidad_od_4,
						motilidad_od_5,
						motilidad_od_6,
						motilidad_oi_1,
						motilidad_oi_2,
						motilidad_oi_3,
						motilidad_oi_4,
						motilidad_oi_5,
						motilidad_oi_6,
						motilidad_nota,
						rx_od_signo_1,
						rx_od_valor_1,
						rx_od_signo_2,
						rx_od_valor_2,
						rx_od_grados,
						rx_od_resultado,
						rx_oi_signo_1,
						rx_oi_valor_1,
						rx_oi_signo_2,
						rx_oi_valor_2,
						rx_oi_grados,
						rx_oi_resultado,
						rx_od_signo_1_ciclo,
						rx_od_valor_1_ciclo,
						rx_od_signo_2_ciclo,
						rx_od_valor_2_ciclo,
						rx_od_grados_ciclo,
						rx_od_resultado_ciclo,
						rx_oi_signo_1_ciclo,
						rx_oi_valor_1_ciclo,
						rx_oi_signo_2_ciclo,
						rx_oi_valor_2_ciclo,
						rx_oi_grados_ciclo,
						rx_oi_resultado_ciclo,
						nota_b_od,
						nota_b_oi,
						nota_f_od,
						nota_f_oi,
						pio_od,
						pio_oi,
						referencias,
						diagnosticos,
						formula_od_signo_1_ciclo,
						formula_od_valor_1_ciclo,
						formula_od_signo_2_ciclo,
						formula_od_valor_2_ciclo,
						formula_od_grados_ciclo,
						formula_oi_signo_1_ciclo,
						formula_oi_valor_1_ciclo,
						formula_oi_signo_2_ciclo,
						formula_oi_valor_2_ciclo,
						formula_oi_grados_ciclo,
						curva_od,
						curva_oi,
						altura_pupilar_od,
						altura_pupilar_oi,
						distancia_interpupilar_od,
						distancia_interpupilar_oi,
						distancia_interpupilar_add,
						dip,
						bifocal_kriptok,
						bifocal_flat_top,
						bifocal_ultex,
						multifocal,
						bifocal_ejecutivo,
						plan,
						anexos_antes_lentes,
						anexos_despues_lentes,
						id_historia,
						hora,
						fecha_real
	    			) values (
	    				trim(upper(?)),
	    				?::date,
					    ?::jsonb,
					    trim(upper(?)),
					    trim(upper(?)),
					    trim(upper(?)),
					    trim(upper(?)),
					    trim(upper(?)),
					    trim(upper(?)),
					    trim(upper(?)),
					    trim(upper(?)),
					    trim(upper(?)),
					    trim(upper(?)),
					    trim(upper(?)),
					    trim(upper(?)),
					    trim(upper(?)),
					    trim(upper(?)),
					    trim(upper(?)),
					    trim(upper(?)),
					    trim(upper(?)),
					    trim(upper(?)),
					    trim(upper(?)),
					    trim(upper(?)),
					    trim(upper(?)),
					    trim(upper(?)),
					    trim(upper(?)),
					    trim(upper(?)),
					    trim(upper(?)),
					    trim(upper(?)),
					    trim(upper(?)),
					    trim(upper(?)),
					    trim(upper(?)),
					    trim(upper(?)),
					    trim(upper(?)),
					    trim(upper(?)),
					    trim(upper(?)),
					    trim(upper(?)),
					    trim(upper(?)),
					    trim(upper(?)),
					    trim(upper(?)),
					    trim(upper(?)),
					    trim(upper(?)),
					    trim(upper(?)),
					    trim(upper(?)),
					    trim(upper(?)),
					    trim(upper(?)),
					    trim(upper(?)),
					    trim(upper(?)),
					    trim(upper(?)),
					    trim(upper(?)),
					    trim(upper(?)),
					    trim(upper(?)),
					    trim(upper(?)),
					    trim(upper(?)),
					    ?::jsonb,
					    trim(upper(?)),
					    trim(upper(?)),
					    trim(upper(?)),
					    trim(upper(?)),
					    trim(upper(?)),
					    trim(upper(?)),
					    trim(upper(?)),
					    trim(upper(?)),
					    trim(upper(?)),
					    trim(upper(?)),
					    trim(upper(?)),
					    trim(upper(?)),
					    ?::jsonb,
					    trim(upper(?)),
					    coalesce(NULLIF(?, ''), '0.00')::numeric(7,2),
					    trim(upper(?)),
					    coalesce(NULLIF(?, ''), '0.00')::numeric(7,2),
					    trim(upper(?)),
					    trim(upper(?)),
					    trim(upper(?)),
					    coalesce(NULLIF(?, ''), '0.00')::numeric(7,2),
					    trim(upper(?)),
					    coalesce(NULLIF(?, ''), '0.00')::numeric(7,2),
					    trim(upper(?)),
					    trim(upper(?)),
					    trim(upper(?)),
					    coalesce(NULLIF(?, ''), '0.00')::numeric(7,2),
					    trim(upper(?)),
					    coalesce(NULLIF(?, ''), '0.00')::numeric(7,2),
					    trim(upper(?)),
					    trim(upper(?)),
					    trim(upper(?)),
					    coalesce(NULLIF(?, ''), '0.00')::numeric(7,2),
					    trim(upper(?)),
					    coalesce(NULLIF(?, ''), '0.00')::numeric(7,2),
					    trim(upper(?)),
					    trim(upper(?)),
					    ?::jsonb,
					    ?::jsonb,
					    ?::jsonb,
					    ?::jsonb,
					    coalesce(NULLIF(?, ''), '0.00')::numeric(7,2),
					    coalesce(NULLIF(?, ''), '0.00')::numeric(7,2),
					    ?::jsonb,
					    ?::jsonb,
					    trim(upper(?)),
					    coalesce(NULLIF(?, ''), '0.00')::numeric(7,2),
					    trim(upper(?)),
					    coalesce(NULLIF(?, ''), '0.00')::numeric(7,2),
					    trim(upper(?)),
					    trim(upper(?)),
					    coalesce(NULLIF(?, ''), '0.00')::numeric(7,2),
					    trim(upper(?)),
					    coalesce(NULLIF(?, ''), '0.00')::numeric(7,2),
					    trim(upper(?)),
					    coalesce(NULLIF(?, ''), '0.00')::numeric(7,2),
					    coalesce(NULLIF(?, ''), '0.00')::numeric(7,2),
					    trim(upper(?)),
					    trim(upper(?)),
					    trim(upper(?)),
					    trim(upper(?)),
					    trim(upper(?)),
					    trim(upper(?)),
					    trim(upper(?)),
					    trim(upper(?)),
					    trim(upper(?)),
					    trim(upper(?)),
					    trim(upper(?)),
					    ?::jsonb,
					    trim(upper(?)),
					    trim(upper(?)),
					    ?::bigint,
					    current_time,
					    current_date
	    			)
	    		";

	    		$resultado = $this->insertar($sql, $args);

	            if ($resultado == 'exito') {

	            	return 'exito';

	            } else {

	            	return 'ERROR: '.$resultado;

	            }

            } else {

				return 'repetido';

        	}


    	}

    }

/*
(
    [0] => problematico character varying(1)
    [1] => fecha date
    [2] => nota jsonb
    [3] => agudeza_od_4 character varying(10)
    [4] => agudeza_oi_4 character varying(10)
    [5] => correccion_4 character varying(1)
    [6] => allen_4 character varying(1)
    [7] => jagger_4 character varying(1)
    [8] => e_direccional_4 character varying(1)
    [9] => numeros_4 character varying(1)
    [10] => decimales_4 character varying(1)
    [11] => fracciones_4 character varying(1)
    [12] => letras_4 character varying(1)
    [13] => agudeza_od_1 character varying(10)
    [14] => agudeza_oi_1 character varying(10)
    [15] => correccion_1 character varying(1)
    [16] => allen_1 character varying(1)
    [17] => jagger_1 character varying(1)
    [18] => e_direccional_1 character varying(1)
    [19] => numeros_1 character varying(1)
    [20] => decimales_1 character varying(1)
    [21] => fracciones_1 character varying(1)
    [22] => letras_1 character varying(1)
    [23] => agudeza_od_lectura character varying(10)
    [24] => agudeza_oi_lectura character varying(10)
    [25] => correccion_lectura character varying(1)
    [26] => allen_lectura character varying(1)
    [27] => jagger_lectura character varying(1)
    [28] => e_direccional_lectura character varying(1)
    [29] => numeros_lectura character varying(1)
    [30] => decimales_lectura character varying(1)
    [31] => fracciones_lectura character varying(1)
    [32] => letras_lectura character varying(1)
    [33] => estereopsis character varying(30)
    [34] => test character varying(30)
    [35] => reflejo character varying(30)
    [36] => pruebas character varying(10)
    [37] => correccion_pruebas character varying(1)
    [38] => pruebas_od_1 character varying(30)
    [39] => pruebas_od_2 character varying(30)
    [40] => pruebas_od_3 character varying(30)
    [41] => pruebas_od_4 character varying(30)
    [42] => pruebas_od_5 character varying(30)
    [43] => pruebas_od_6 character varying(30)
    [44] => pruebas_od_7 character varying(30)
    [45] => pruebas_od_8 character varying(30)
    [46] => pruebas_oi_1 character varying(30)
    [47] => pruebas_oi_2 character varying(30)
    [48] => pruebas_oi_3 character varying(30)
    [49] => pruebas_oi_4 character varying(30)
    [50] => pruebas_oi_5 character varying(30)
    [51] => pruebas_oi_6 character varying(30)
    [52] => pruebas_oi_7 character varying(30)
    [53] => pruebas_oi_8 character varying(30)
    [54] => motilidad_od_1 character varying(30)
    [55] => motilidad_od_2 character varying(30)
    [56] => motilidad_od_3 character varying(30)
    [57] => motilidad_od_4 character varying(30)
    [58] => motilidad_od_5 character varying(30)
    [59] => motilidad_od_6 character varying(30)
    [60] => motilidad_oi_1 character varying(30)
    [61] => motilidad_oi_2 character varying(30)
    [62] => motilidad_oi_3 character varying(30)
    [63] => motilidad_oi_4 character varying(30)
    [64] => motilidad_oi_5 character varying(30)
    [65] => motilidad_oi_6 character varying(30)
    [66] => rx_od_signo_1 character varying(1)
    [67] => rx_od_valor_1 numeric(7,2)
    [68] => rx_od_signo_2 character varying(1)
    [69] => rx_od_valor_2 numeric(7,2)
    [70] => rx_od_grados character varying(30)
    [71] => rx_od_resultado character varying(30)
    [72] => rx_oi_signo_1 character varying(1)
    [73] => rx_oi_valor_1 numeric(7,2)
    [74] => rx_oi_signo_2 character varying(1)
    [75] => rx_oi_valor_2 numeric(7,2)
    [76] => rx_oi_grados character varying(30)
    [77] => rx_oi_resultado character varying(30)
    [78] => rx_od_signo_1_ciclo character varying(1)
    [79] => rx_od_valor_1_ciclo numeric(7,2)
    [80] => rx_od_signo_2_ciclo character varying(1)
    [81] => rx_od_valor_2_ciclo numeric(7,2)
    [82] => rx_od_grados_ciclo character varying(30)
    [83] => rx_od_resultado_ciclo character varying(30)
    [84] => rx_oi_signo_1_ciclo character varying(1)
    [85] => rx_oi_valor_1_ciclo numeric(7,2)
    [86] => rx_oi_signo_2_ciclo character varying(1)
    [87] => rx_oi_valor_2_ciclo numeric(7,2)
    [88] => rx_oi_grados_ciclo character varying(30)
    [89] => rx_oi_resultado_ciclo character varying(30)
    [90] => nota_b_od jsonb
    [91] => nota_b_oi jsonb
    [92] => nota_f_od jsonb
    [93] => nota_f_oi jsonb
    [94] => pio_od numeric(7,2)
    [95] => pio_oi numeric(7,2)
    [96] => referencias jsonb
    [97] => diagnosticos jsonb
    [98] => formula_od_signo_1_ciclo character varying(1)
    [99] => formula_od_valor_1_ciclo numeric(7,2)
    [100] => formula_od_signo_2_ciclo character varying(1)
    [101] => formula_od_valor_2_ciclo numeric(7,2)
    [102] => formula_od_grados_ciclo character varying(30)
    [103] => formula_oi_signo_1_ciclo character varying(1)
    [104] => formula_oi_valor_1_ciclo numeric(7,2)
    [105] => formula_oi_signo_2_ciclo character varying(1)
    [106] => formula_oi_valor_2_ciclo numeric(7,2)
    [107] => formula_oi_grados_ciclo character varying(30)
    [108] => curva_od numeric(7,2)
    [109] => curva_oi numeric(7,2)
    [110] => distancia_intraocular_od character varying(30)
    [111] => distancia_intraocular_oi character varying(30)
    [112] => distancia_interpupilar_od character varying(30)
    [113] => distancia_interpupilar_oi character varying(30)
    [114] => distancia_interpupilar_add character varying(30)
    [115] => dip character varying(30)
    [116] => bifocal_kriptok character varying(1)
    [117] => bifocal_flat_top character varying(1)
    [118] => bifocal_ultex character varying(1)
    [119] => multifocal character varying(1)
    [120] => bifocal_ejecutivo character varying(1)
    [121] => plan jsonb
    [122] => [ELIMINAR] // anexos-antes-cargar
    [123] => anexos_antes_lentes character varying(1)
    [124] => [ELIMINAR] //anexos-despues-cargar
    [125] => anexos_despues_lentes character varying(1)
    [126] => [ELIMINAR] //dibujo
    [127] => [ELIMINAR] //diujo
    [128] => [ELIMINAR] //dibujo
    [129] => [ELIMINAR] //diujo
    [130] => id_historia bigint
)
*/

?>