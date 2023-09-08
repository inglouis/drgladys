<?php
    require('../clases/ppal.class.php');
    
    class Model extends ppal {

        public $schema ='principales';
        public $tabla = 'recipes';

        public $filtroMapa = [
            0 => "status = '?'",
            1 => "status = '?'"
        ];

        /*--------------------------------------------------------*/
        public function cargar_medicamentos($args) {
            
            $sql = "
                select 
                    a.id_medicamento, a.nombre, a.genericos,
                    coalesce(b.genericos_nombres::text, null, '[]')::json as genericos_nombres,
                    a.status, ''::character varying(500) as presentacion, ''::character varying(500) as tratamiento,''::character varying(1) as marcador, ''::character varying(1) as marcador_nueva_presentacion, ''::character varying(1) as marcador_nuevo_tratamiento,
                    case when b.genericos_texto != '' then
                    coalesce(concat(a.nombre, ' O ', b.genericos_texto)::character varying(300), null, '')::character varying(300) 
                    else
                    a.nombre
                    end as medicamentos_genericos
                from basicas.medicamentos as a
                left join (
                    select 
                    b.id_medicamento,
                    json_agg(a.nombre)::json as genericos_nombres,
                    string_agg(a.nombre, ' O ') AS genericos_texto
                    from basicas.genericos as a
                    inner join (
                    select id_medicamento, trim(json_array_elements_text(genericos::json))::bigint as id_generico from basicas.medicamentos where id_medicamento = id_medicamento order by id_medicamento asc
                    ) as b using(id_generico)
                    group by id_medicamento
                ) as b USING (id_medicamento)
                where a.status = 'A'
                order by a.id_medicamento asc
            ";

            return $this->seleccionar($sql, []);
        }

        /*--------------------------------------------------------*/
        public function traer_tratamientos($args) {

            $sql = "select * from basicas.tratamientos where id_medicamento = ?";
            $resultado = json_decode($this->seleccionar($sql, $args), true);

            if(count($resultado) > 0) {

                $tratamientos = json_decode($resultado[0]['tratamientos'], true);

                foreach ($tratamientos as &$r) {
                    $r = array("tratamiento" => $r);
                }

                return json_encode($tratamientos);
            } else {
                return json_encode([]);
            }
        }

        /*--------------------------------------------------------*/
        public function traer_presentaciones($args) {

            $sql = "select * from basicas.presentaciones where id_medicamento = ?";
            $resultado = json_decode($this->seleccionar($sql, $args), true);

            if(count($resultado) > 0) {

                $presentaciones = json_decode($resultado[0]['presentaciones'], true);

                foreach ($presentaciones as &$r) {
                    $r = array("presentacion" => $r);
                }

                return json_encode($presentaciones);
            } else {
                return json_encode([]);
            }
        }

        /*--------------------------------------------------------*/
        public function crear_recipe($args) {

            $id_historia  = &$args[0];

            if ($id_historia == 0) {

                $nombre       = &$args[1];
                $medicamentos = &$args[2];
                $cedula       = &$args[3];

            } else {

                $nombre       = &$args[1];
                $cedula       = &$args[2];
                $medicamentos = &$args[3];

            }

            $pValido = 1;
            $tValido = 1;

            foreach($medicamentos as $r) {
                if($r['marcador_nueva_presentacion'] == 'X') {

                    $sql = "select id_presentacion, presentaciones from historias.presentaciones where id_medicamento = $r[id_medicamento]";

                    //echo $sql;

                    $resultado = $this->e_pdo($sql)->fetch(PDO::FETCH_ASSOC);

                    if ($resultado) {
                        
                        $resultado = json_decode($resultado['presentaciones'], true);
                        $query = "update historias.presentaciones set presentaciones = ?::json where id_medicamento = ?";

                    } else if (!$resultado) {
                        
                        $resultado = [];
                        $query = "insert into historias.presentaciones(id_presentacion, presentaciones, id_medicamento, status) values(default, ?::json, ?, 'A')";

                    }

                    $presentacion = trim(strtoupper($r['presentacion']));

                    if(count($resultado) < 5) {

                        if(!empty($presentacion)) {

                            if (in_array($presentacion, $resultado, false) == false) {
                                array_push($resultado, $presentacion);

                                $this->i_pdo($query, [json_encode($resultado), $r['id_medicamento']], false, true, 'SE ACTUALIZÓ O GENERÓ UNA NUEVA PRESENTACIÓN PARA LOS RECIPES');
                            }

                        }

                        $pValido = 1;
                    
                    } else {

                        $pValido = 0;

                    }     
                    
                }

                if($r['marcador_nuevo_tratamiento'] == 'X') {

                    $sql = "select id_tratamiento, tratamientos from historias.tratamientos where id_medicamento = $r[id_medicamento]";
                    
                    $resultado = $this->e_pdo($sql)->fetch(PDO::FETCH_ASSOC);
                    
                    if ($resultado) {

                        $resultado = json_decode($resultado['tratamientos']);
                        $query = "update historias.tratamientos set tratamientos = ?::json where id_medicamento = ?";


                    } else if (!$resultado) {
                        
                        $resultado = [];
                        $query = "insert into historias.tratamientos(id_tratamiento, tratamientos, id_medicamento, status) values(default, ?::json, ?, 'A')";

                    }

                    $tratamiento = trim(strtoupper($r['tratamiento']));

                    if(count($resultado) < 8) {

                        if(!empty($tratamiento)) {
                            if (in_array($tratamiento, $resultado, false) == false) {
                                array_push($resultado, $tratamiento);

                                $this->i_pdo($query, [json_encode($resultado), $r['id_medicamento']], false, true, 'SE ACTUALIZÓ O GENERÓ UN NUEVO TRATAMIENTO PARA LOS RECIPES');
                            }
                        }

                        $tValido = 1;

                    } else {

                        $tValido = 0;

                    }

                }
            }

            foreach ($medicamentos as &$r) {
                $r = array(
                    "id_medicamento" => $r['id_medicamento'],
                    "genericos" => $r['genericos'],
                    "presentacion" => $r['presentacion'],
                    "tratamiento" => $r['tratamiento'],
                    "medicamentos_genericos" => $r['medicamentos_genericos']
                );
            }

            $medicamentos = json_encode($medicamentos);
            $dia = $this->fechaHora('America/Caracas','d-m-Y');

            if ($id_historia == 0) {
            
                $sql = "insert into historias.recipes(id_historia, nombres, medicamentos, cedula, fecha, status) values(
                    ?,
                    trim(upper(?)),
                    ?::json,
                    trim(?),
                    ?::date,
                    'A'
                ) returning id_recipe";

                $args = [
                    $args[0],
                    $args[1],
                    $medicamentos,
                    $args[3],
                    $dia
                ];

            } else {
            
                $sql = "insert into historias.recipes(id_historia, nombres, cedula, medicamentos, fecha, status) values(
                    ?,
                    trim(upper(?)),
                    trim(?),
                    ?::json,
                    ?::date,
                    'A'
                ) returning id_recipe";

                $args = [
                    $args[0],
                    $args[1],
                    $args[2],
                    $medicamentos,
                    $dia
                ];

            }

            $resultado = $this->insertar($sql, $args, "SE GENERÓ UN NUEVO RÉCIPE PARA LA HISTORIA N° $id_historia")[0]['id_recipe'];

            if(is_numeric($resultado)) {
                return json_encode([$resultado,$pValido,$tValido]);
            } else {
                echo "error: ";
                echo "<br>";
                echo $resultado;
            }
            
        }

        /*-----------------------------------------------------------------------------------*/
        /*-----------------------------------------------------------------------------------*/
        public function mostrarMedicamentos_dados_pacientes($args) { //recipes_cargar
            $sql = "
                select 
                    x.*,
                    coalesce(c.genericos_nombres::text, null, '[]')::json as genericos_nombres,
                    b.nombre, 
                    TO_CHAR(a.fecha :: DATE, 'dd-mm-yyyy') as fecha,
                    case when x.medicamentos_genericos != '' then 
                            x.medicamentos_genericos
                    else 
                           b.nombre 
                    end as medicinas
                FROM 
                    $this->schema.$this->tabla as a, 
                    jsonb_array_elements(medicamentos::jsonb) AS t(doc),
                    jsonb_to_record(t.doc) as x (
                        id_medicamento bigint , 
                        genericos json, 
                        tratamiento character varying(500), 
                        presentacion character varying(500), 
                        medicamentos_genericos character varying(300)
                    )
                left join basicas.medicamentos as b using (id_medicamento)
                left join (
                    select 
                        id_medicamento,
                        json_agg(a.nombre)::json as genericos_nombres
                        from historias.genericos as a
                        left join (
                        select id_medicamento, trim(json_array_elements_text(genericos::json))::bigint as id_generico from historias.medicamentos where id_medicamento = id_medicamento order by id_medicamento asc) as b using(id_generico)
                    group by id_medicamento
                ) as c 
                using(id_medicamento) 
                where a.id_historia = ?
                order by a.fecha desc limit 8000
            ";

            return $this->seleccionar($sql, $args);
        }

        /*-----------------------------------------------------------------------------------*/
        public function cargar_medicamentos_dados_pacientes($args) {

            $sql = "
                select 
                    a.id_historia, 
                    trim(a.nume_cedu) as nume_cedu, 
                    trim(a.nume_hijo) as nume_hijo, 
                    a.nume_hist, trim(a.apel_nomb) as apel_nomb, 
                    trim(a.status) as status 
                from historias.entradas aS A 
                where a.status='A' 
                order by a.id_historia 
                desc 
                limit 8000
            ";

            return $this->seleccionar($sql, $args);
        }

        /*-----------------------------------------------------------------------------------*/
        public function buscar_medicamentos_dados_pacientes($args) {
            $busqueda = $args[0];

            if (is_numeric($busqueda) || gettype($busqueda) == 'integer' || ctype_digit($busqueda)) {
                $hist = "or a.id_historia  = ".(int)$busqueda;
            } else {
                $hist = '';
            }

            $sql = "select a.id_historia, trim(a.nume_cedu) as nume_cedu, trim(a.nume_hijo) as nume_hijo, a.nume_hist, trim(a.apel_nomb) as apel_nomb, trim(a.status) as status from historias.entradas aS A where a.status='A' and apel_nomb like '%'|| UPPER('$busqueda') ||'%' $orden order by id_historia DESC limit 8000";
                return $this->seleccionar($sql, []);
        }

    }
?>

