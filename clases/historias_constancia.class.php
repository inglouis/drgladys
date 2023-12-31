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
		/*           							CONSTANCIA 							  					    */
		/* -------------------------------------------------------------------------------------------------*/
        public function constancia_insertar($args) {

            $lista = $args[0];
            $id_historia = $args[1];
            
            $lista['fecha'] = $this->fechaHora('America/Caracas','Y/m/d');;
            $lista['hora'] = $this->fechaHora('America/Caracas','H:i:s');;

            $sql = "
                update $this->schema.$this->tabla 
                SET 
                    constancias = jsonb_insert(
                        constancias, 
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

        public function constancia_consultar($args) {

            $sql = "
                select
                    row_number() over () as id,
                    t.*,
                    TO_CHAR(t.fecha :: DATE, 'dd-mm-yyyy') as fecha_arreglada
                FROM (
                    SELECT x.*
                    FROM 
                     jsonb_array_elements(
                    	(SELECT constancias FROM principales.reportes WHERE id_historia = ?)
                     ) AS t(doc),
                     jsonb_to_record(t.doc) as x (
                     	nombres character varying(150), 
                     	apellidos character varying(150),  
                     	cedula character varying(14), 
                     	fecha date, 
                     	hora time without time zone, 
                     	fecha_nacimiento date,
                     	motivo jsonb,
                        recomendaciones jsonb,
                        menor character varying(1),
                        aula character varying(1)
                     )
                ) as t
                ORDER BY t.fecha desc, t.hora desc
            ";

            return $this->seleccionar($sql, $args);

        }

        public function constancia_editar($args) {

            $sql = "
                update $this->schema.$this->tabla 
                set constancias = ?::jsonb
                where id_historia = ?
            ";

            return $this->actualizar($sql, $args);

        }

        public function constancia_eliminar($args) {

            $sql = "
                update $this->schema.$this->tabla 
                set constancias = ?::jsonb
                where id_historia = ?
            ";

            return $this->actualizar($sql, $args);

        }

    }
?>

