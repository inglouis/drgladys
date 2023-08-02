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
		/*           							general 							  					    */
		/* -------------------------------------------------------------------------------------------------*/

        public function general_insertar($args) {

            $lista = $args[0];
            $id_historia = $args[1];
            
            $lista['fecha'] = $this->fechaHora('America/Caracas','Y/m/d');;
            $lista['hora'] = $this->fechaHora('America/Caracas','H:i:s');;

            $sql = "
                update $this->schema.$this->tabla 
                SET 
                    generales = jsonb_insert(
                        generales, 
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

        public function general_consultar($args) {

            $sql = "
                select
                    row_number() over () as id,
                    t.*,
                    TO_CHAR(t.fecha :: DATE, 'dd-mm-yyyy') as fecha_arreglada
                FROM (
                    SELECT x.*
                    FROM 
                     jsonb_array_elements(
                    	(SELECT generales FROM principales.reportes WHERE id_historia = ?)
                     ) AS t(doc),
                     jsonb_to_record(t.doc) as x (
                     	nombres character varying(150), 
                     	apellidos character varying(150),  
                     	cedula character varying(14), 
                     	fecha date, 
                     	hora time without time zone, 
                     	fecha_nacimiento date,
                        titulo character varying(100),
                     	general jsonb
                     )
                ) as t
                ORDER BY t.fecha desc, t.hora desc
            ";

            return $this->seleccionar($sql, $args);

        }

        public function general_editar($args) {

            $sql = "
                update $this->schema.$this->tabla 
                set generales = ?::jsonb
                where id_historia = ?
            ";

            return $this->actualizar($sql, $args);

        }

        public function general_eliminar($args) {

            $sql = "
                update $this->schema.$this->tabla 
                set generales = ?::jsonb
                where id_historia = ?
            ";

            return $this->actualizar($sql, $args);

        }

    }
?>

