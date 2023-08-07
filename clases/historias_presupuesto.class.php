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
		/*           							presupuesto 							  					    */
		/* -------------------------------------------------------------------------------------------------*/

        public function presupuesto_insertar($args) {

            $lista = $args[0];
            $id_historia = $args[1];
            
            $lista['fecha'] = $this->fechaHora('America/Caracas','Y/m/d');;
            $lista['hora'] = $this->fechaHora('America/Caracas','H:i:s');;

            $sql = "
                update $this->schema.$this->tabla 
                SET 
                    presupuestos = jsonb_insert(
                        presupuestos, 
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

        public function presupuesto_consultar($args) {

            $sql = "
                select
                    row_number() over () as id,
                    t.*,
                    TO_CHAR(t.fecha :: DATE, 'dd-mm-yyyy') as fecha_arreglada
                FROM (
                    SELECT x.*
                    FROM 
                     jsonb_array_elements(
                    	(SELECT presupuestos FROM principales.reportes WHERE id_historia = ?)
                     ) AS t(doc),
                     jsonb_to_record(t.doc) as x (
                     	nombre_completo character varying(300), 
                     	cedula character varying(14), 
                     	fecha date, 
                     	hora time without time zone, 
                     	presupuesto jsonb
                     )
                ) as t
                ORDER BY t.fecha desc, t.hora desc
            ";

            return $this->seleccionar($sql, $args);

        }

        public function presupuesto_editar($args) {

            $sql = "
                update $this->schema.$this->tabla 
                set presupuestos = ?::jsonb
                where id_historia = ?
            ";

            return $this->actualizar($sql, $args);

        }

        public function presupuesto_eliminar($args) {

            $sql = "
                update $this->schema.$this->tabla 
                set presupuestos = ?::jsonb
                where id_historia = ?
            ";

            return $this->actualizar($sql, $args);

        }

    }
?>

