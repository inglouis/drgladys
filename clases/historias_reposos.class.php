<?php
    require('../clases/ppal.class.php');
    
    class Model extends ppal {

        public $schema ='historias';
        public $tabla = 'historias';

        public $filtroMapa = [
            0 => "status = '?'",
            1 => "status = '?'"
        ];

        public function reposos_estandarizar($lista) {

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
            unset($lista['direccion']);
            unset($lista['peso']);
            unset($lista['talla']);
            unset($lista['fecha_nacimiento']);
            unset($lista['reposos']);

            return $lista;
        }

        public function reposos_insertar($args) {

            $motivo = $args[0];
            $fecha_inicio = $args[1];
            $dia = $args[2];
            $fecha_final = $args[3];
            $fecha_simple = $args[4];

            $id_historia = $args[5];

            $sql = "
                select 
                    *, 
                    current_date as fecha, 
                    to_char(current_time::time, 'HH24:MI:SS') as hora
                from $this->schema.$this->tabla 
                where id_historia = ?
            ";

            $lista = $this->i_pdo($sql, [$id_historia], true)->fetch(PDO::FETCH_ASSOC);

            $lista = $this->reposos_estandarizar($lista);

            $lista['motivo'] = $motivo;
            $lista['fecha_inicio'] = strtoupper($fecha_inicio);
            $lista['dias'] = trim($dia);
            $lista['fecha_final'] = $fecha_final;
            $lista['fecha_simple'] = $fecha_simple;

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

            //$this->consultar_lista($lista);

            $resultado = $this->actualizar($sql, [json_encode($lista), $id_historia]);

            if ($resultado == 'exito') {

                return json_encode($lista);

            } else {

                return 'ERROR'.$resultado;

            }

        }

        public function reposos_consultar($args) {

            $sql = "
                select
                    row_number() over () as id,
                    t.*,
                    TO_CHAR(t.fecha :: DATE, 'dd-mm-yyyy') as fecha_arreglada
                FROM (
                    SELECT x.*
                    from 
                     jsonb_array_elements(
                    (select reposos from historias.historias where id_historia = ?)
                     ) AS t(doc),
                     jsonb_to_record(t.doc) as x (nombres character varying(150), apellidos character varying(150), cedula character varying(14), fecha date, hora time without time zone, motivo text, fecha_inicio date, dias character varying(100), fecha_final date, fecha_simple text)
                ) as t
                order by t.fecha desc, t.hora desc
            ";

            return $this->seleccionar($sql, $args);

        }

        public function reposos_editar($args) {

            //$this->consultar_lista($args);

            $sql = "
                update $this->schema.$this->tabla 
                set reposos = ?::jsonb
                where id_historia = ?
            ";

            return $this->actualizar($sql, $args);

        }

        public function reposos_eliminar($args) {

            $sql = "
                update $this->schema.$this->tabla 
                set reposos = ?::jsonb
                where id_historia = ?
            ";

            return $this->actualizar($sql, $args);

        }

    }
?>

