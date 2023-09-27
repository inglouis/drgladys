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
		/*           							informe 							  					    */
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
                    t.*,
                    ppal.basicas_diagnosticos_armar_lista(t.diagnosticos) as diagnosticos_procesados,
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
                        agudeza_od_1 numeric(7,2),
                        agudeza_od_4 numeric(7,2),
                        agudeza_od_lectura numeric(7,2),
                        agudeza_oi_1 numeric(7,2),
                        agudeza_oi_4 numeric(7,2),
                        agudeza_oi_lectura numeric(7,2),
                        biomicroscopia character varying(300),
                        contenido jsonb,
                        control jsonb,
                        correccion_1 character varying(1),
                        correccion_4 character varying(1),
                        correccion_lectura character varying(1),
                        diagnosticos jsonb,
                        estereopsis character varying(100),
                        fondo_ojo character varying(300),
                        motilidad jsonb,
                        pio_od numeric(7,2),
                        pio_oi numeric(7,2),
                        plan jsonb,
                        reflejo character varying(100),
                        rx_od_grados numeric(7,2),
                        rx_od_resultado character varying(100),
                        rx_od_signo_1 character varying(1),
                        rx_od_signo_2 character varying(1),
                        rx_od_valor_1 character varying(100),
                        rx_od_valor_2 character varying(100),
                        rx_oi_grados numeric(7,2),
                        rx_oi_resultado character varying(100),
                        rx_oi_signo_1 character varying(1),
                        rx_oi_signo_2 character varying(1),
                        rx_oi_valor_1 character varying(100),
                        rx_oi_valor_2 character varying(100),
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

