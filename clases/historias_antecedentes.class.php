<?php
    require('../clases/ppal.class.php');
    
    class Model extends ppal {

        public $schema ='historias';
        public $tabla = 'historias';

        public $filtroMapa = [
            0 => "status = '?'",
            1 => "status = '?'"
        ];

        public function antecedentes_estandarizar($lista) {

            unset($lista['id_historia']);
            unset($lista['fecha_cons']);
            unset($lista['sexo']);
            unset($lista['id_ocupacion']);
            unset($lista['antecedentes_patologicos']);
            unset($lista['informes_medicos']);
            unset($lista['recipes_indicaciones']);
            unset($lista['otros']);
            unset($lista['correos']);
            unset($lista['telefonos']);
            unset($lista['status']);

            return $lista;
        }

        public function antecedentes_insertar($args) {

            $antecedente = $args[0];
            $id_historia = $args[1];

            $sql = "
                select 
                    *, 
                    current_date as fecha, 
                    to_char(current_time::time, 'HH24:MI:SS') as hora
                from $this->schema.$this->tabla 
                where id_historia = ?
            ";

            $lista = $this->i_pdo($sql, [$id_historia], true)->fetch(PDO::FETCH_ASSOC);

            $lista = $this->antecedentes_estandarizar($lista);

            $lista['antecedente'] = $antecedente;

            $sql = "
                update $this->schema.$this->tabla 
                SET 
                    antecedentes_patologicos = jsonb_insert(
                        antecedentes_patologicos, 
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

        public function antecedentes_consultar($args) {

            $sql = "
                select
                    row_number() over () as id,
                    t.*,
                    TO_CHAR(t.fecha :: DATE, 'dd-mm-yyyy') as fecha_arreglada
                FROM (
                    SELECT x.*
                    from 
                     jsonb_array_elements(
                    (select antecedentes_patologicos from historias.historias where id_historia = ?)
                     ) AS t(doc),
                     jsonb_to_record(t.doc) as x (nombres character varying(150), apellidos character varying(150), direccion character varying(300), cedula character varying(14), fecha date, fecha_nacimiento date, hora time without time zone, peso numeric(5,2), talla numeric(3,2), antecedente jsonb)
                ) as t
                order by t.fecha desc, t.hora desc
            ";

            return $this->seleccionar($sql, $args);

        }

        public function antecedentes_editar($args) {

            $sql = "
                update $this->schema.$this->tabla 
                set antecedentes_patologicos = ?::jsonb
                where id_historia = ?
            ";

            return $this->actualizar($sql, $args);

        }

        public function antecedentes_eliminar($args) {

            $sql = "
                update $this->schema.$this->tabla 
                set antecedentes_patologicos = ?::jsonb
                where id_historia = ?
            ";

            return $this->actualizar($sql, $args);

        }

    }
?>

