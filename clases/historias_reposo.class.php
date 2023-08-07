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
		/*           							reposo 							  					    */
		/* -------------------------------------------------------------------------------------------------*/

        public function reposo_insertar($args) {

            $lista = $args[0];
            $id_historia = $args[1];
            
            $lista['fecha'] = $this->fechaHora('America/Caracas','Y/m/d');;
            $lista['hora'] = $this->fechaHora('America/Caracas','H:i:s');;

            $sql = "
                update $this->schema.$this->tabla 
                SET 
                    reposos = jsonb_insert(
                        reposos, 
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

        public function reposo_consultar($args) {

            $sql = "
                select
                    row_number() over () as id,
                    t.*,
                    TO_CHAR(t.fecha :: DATE, 'dd-mm-yyyy') as fecha_arreglada
                FROM (
                    SELECT x.*
                    FROM 
                     jsonb_array_elements(
                    	(SELECT reposos FROM principales.reportes WHERE id_historia = ?)
                     ) AS t(doc),
                     jsonb_to_record(t.doc) as x (
                        nombres character varying(150), 
                        apellidos character varying(150), 
                        cedula character varying(14), 
                        fecha date, 
                        hora time without time zone, 
                        reposo text, 
                        fecha_inicio date, 
                        dias character varying(100), 
                        fecha_final date, 
                        fecha_simple text,
                        fecha_naci date
                    )
                ) as t
                ORDER BY t.fecha desc, t.hora desc
            ";

            return $this->seleccionar($sql, $args);

        }

        public function reposo_editar($args) {

            $sql = "
                update $this->schema.$this->tabla 
                set reposos = ?::jsonb
                where id_historia = ?
            ";

            return $this->actualizar($sql, $args);

        }

        public function reposo_eliminar($args) {

            $sql = "
                update $this->schema.$this->tabla 
                set reposos = ?::jsonb
                where id_historia = ?
            ";

            return $this->actualizar($sql, $args);

        }

    }
?>

