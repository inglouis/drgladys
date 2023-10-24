<?php
    require('../clases/ppal.class.php');
    
    class Model extends ppal {

        public $schema ='principales';
        public $tabla = 'reportes';

        public $filtroMapa = [
            0 => "status = '?'",
            1 => "status = '?'"
        ];

        /* 1)------------------------------------------------------------------------------------------------*/
        /*                                      informe                                                     */
        /* -------------------------------------------------------------------------------------------------*/

        public function informe_insertar($args) {

            $lista = $args[0];
            $id_historia = $args[1];
            
            $lista['fecha'] = $this->fechaHora('America/Caracas','Y/m/d');;
            $lista['hora'] = $this->fechaHora('America/Caracas','H:i:s');;

            $sql = "
                update $this->schema.$this->tabla 
                SET 
                    informes = jsonb_insert(
                        informes, 
                        '{0}', 
                        ?::jsonb
                        , true
                    )
                WHERE id_historia = ?;
            ";

            $resultado = $this->actualizar($sql, [json_encode($lista), $id_historia]);

            if ($resultado == 'exito') {

                return json_encode($lista);

            } else {

                return 'ERROR'.$resultado;

            }

        }

        public function informe_consultar($args) {

            $sql = "
                select
                    row_number() over () as id,
                    t.nombres,
                    t.apellidos,
                    t.cedula,
                    t.fecha, 
                    t.hora,
                    t.fecha_nacimiento,
                    t.agudeza_od_1,
                    t.agudeza_od_4,
                    t.agudeza_od_lectura,
                    t.agudeza_oi_1,
                    t.agudeza_oi_4,
                    t.agudeza_oi_lectura,
                    t.biomicroscopia,
                    t.contenido,
                    t.control,
                    t.correccion_1,
                    t.correccion_4,
                    t.correccion_lectura,
                    t.diagnosticos,
                    t.estereopsis,
                    t.fondo_ojo,
                    t.motilidad,
                    coalesce(NULLIF(t.pio_od, ''), '0.00')::numeric(7,2) AS pio_od,
                    coalesce(NULLIF(t.pio_oi, ''), '0.00')::numeric(7,2) AS pio_oi,
                    t.plan,
                    t.reflejo,
                    t.rx_od_grados,
                    t.rx_od_resultado,
                    t.rx_od_signo_1,
                    t.rx_od_signo_2,
                    coalesce(NULLIF(t.rx_od_valor_1, ''), '0.00')::numeric(7,2) AS rx_od_valor_1,
                    coalesce(NULLIF(t.rx_od_valor_2, ''), '0.00')::numeric(7,2) AS rx_od_valor_2,
                    t.rx_oi_grados,
                    t.rx_oi_resultado,
                    t.rx_oi_signo_1,
                    t.rx_oi_signo_2,
                    coalesce(NULLIF(t.rx_oi_valor_1, ''), '0.00')::numeric(7,2) AS rx_oi_valor_1,
                    coalesce(NULLIF(t.rx_oi_valor_2, ''), '0.00')::numeric(7,2) AS rx_oi_valor_2,
                    t.rx_cicloplegia,
                    t.test,
                    t.tipo,
                    coalesce(NULLIF(ppal.basicas_diagnosticos_armar_lista(t.diagnosticos), null),'[]'::jsonb) as diagnosticos_procesados,
                    TO_CHAR(t.fecha :: DATE, 'dd-mm-yyyy') as fecha_arreglada
                FROM (
                    SELECT x.*
                    FROM 
                     jsonb_array_elements(
                    (SELECT informes FROM principales.reportes WHERE id_historia = ?)
                     ) AS t(doc),
                     jsonb_to_record(t.doc) as x (
                    nombres character varying(150), 
                    apellidos character varying(150),  
                    cedula character varying(14), 
                    fecha date, 
                    hora time without time zone, 
                    fecha_nacimiento date,
                    agudeza_od_1 character varying(100),
                    agudeza_od_4 character varying(100),
                    agudeza_od_lectura character varying(100),
                    agudeza_oi_1 character varying(100),
                    agudeza_oi_4 character varying(100),
                    agudeza_oi_lectura character varying(100),
                    biomicroscopia jsonb,
                    contenido jsonb,
                    control jsonb,
                    correccion_1 character varying(1),
                    correccion_4 character varying(1),
                    correccion_lectura character varying(1),
                    diagnosticos jsonb,
                    estereopsis character varying(100),
                    fondo_ojo jsonb,
                    motilidad jsonb,
                    pio_od character varying(100),
                    pio_oi character varying(100),
                    plan jsonb,
                    reflejo character varying(100),
                    rx_od_grados character varying(100),
                    rx_od_resultado character varying(100),
                    rx_od_signo_1 character varying(1),
                    rx_od_signo_2 character varying(1),
                    rx_od_valor_1 character varying(100),
                    rx_od_valor_2 character varying(100),
                    rx_oi_grados character varying(100),
                    rx_oi_resultado character varying(100),
                    rx_oi_signo_1 character varying(1),
                    rx_oi_signo_2 character varying(1),
                    rx_oi_valor_1 character varying(100),
                    rx_oi_valor_2 character varying(100),
                    rx_cicloplegia character varying(1),
                    test character varying(100),
                    tipo character varying(1)
                     )
                ) as t
                ORDER BY t.fecha desc, t.hora desc
            ";

            return $this->seleccionar($sql, $args);

        }

        public function informe_editar($args) {

            $sql = "
                update $this->schema.$this->tabla 
                set informes = ?::jsonb
                where id_historia = ?
            ";

            return $this->actualizar($sql, $args);

        }

        public function informe_eliminar($args) {

            $sql = "
                update $this->schema.$this->tabla 
                set informes = ?::jsonb
                where id_historia = ?
            ";

            return $this->actualizar($sql, $args);

        }

        public function estandar_diagnosticos($args) {
            
            $diagnosticos = '';
            
            foreach ($args as $r) {$diagnosticos.= $r['id'].',';}
            
            $diagnosticos = substr($diagnosticos, 0, strlen($diagnosticos) - 1);

            if(strlen($diagnosticos) > 0) {
                
                $lista = [];
                
                $resultado = $this->e_pdo("select id_diagnostico, concat(id_diagnostico,'||',nombre) as nombre from basicas.diagnosticos where id_diagnostico in ($diagnosticos)")->fetchAll(PDO::FETCH_ASSOC);

                foreach ($resultado as $i => &$r) {
                    $lista[$i] = array(
                        "id_diagnostico" => $r['id_diagnostico'],
                        "nombre" => $r['nombre']
                    );
                }

                $args = $lista;

            } else {

                $args = [];

            }

            return json_encode($args);
        }

    }
?>

