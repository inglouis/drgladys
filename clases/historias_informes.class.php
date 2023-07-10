<?php
    require('../clases/ppal.class.php');
    
    class Model extends ppal {

        public $schema ='historias';
        public $tabla = 'historias';

        public $filtroMapa = [
            0 => "status = '?'",
            1 => "status = '?'"
        ];

        public function informes_estandarizar($lista) {

            unset($lista['id_historia']);
            unset($lista['fecha_cons']);
            unset($lista['sexo']);
            unset($lista['id_ocupacion']);
            unset($lista['informes_patologicos']);
            unset($lista['informes_medicos']);
            unset($lista['recipes_indicaciones']);
            unset($lista['otros']);
            unset($lista['correos']);
            unset($lista['telefonos']);
            unset($lista['status']);

            return $lista;
        }

        public function informes_insertar($args) {

            $motivo         = $args[0];
            $enfermedad     = $args[1];
            $plan           = $args[2];
            $diagnosticos    = $args[3];
            $id_historia    = $args[4];

            $telefonos = &$args[9];

            foreach ($diagnosticos as &$d) {
                $d = array("id_diagnostico" => $d['id']);
            };

            $diagnosticos = json_encode($diagnosticos);

            $sql = "
                select 
                    *, 
                    current_date as fecha, 
                    to_char(current_time::time, 'HH24:MI:SS') as hora
                from $this->schema.$this->tabla 
                where id_historia = ?
            ";

            $lista = $this->i_pdo($sql, [$id_historia], true)->fetch(PDO::FETCH_ASSOC);

            $lista = $this->informes_estandarizar($lista);

            $lista['motivo'] = $motivo;
            $lista['enfermedad'] = $enfermedad;
            $lista['plan'] = $plan;
            $lista['diagnosticos'] = $diagnosticos;

            $sql = "
                update $this->schema.$this->tabla 
                SET 
                    informes_medicos = jsonb_insert(
                        informes_medicos, 
                        '{0}', 
                        ?::jsonb
                        , true
                    ),
                    fecha_cons = current_date
                WHERE id_historia = ?;
            ";

            $resultado = $this->actualizar($sql, [json_encode($lista), $id_historia]);

            if ($resultado == 'exito') {

                return json_encode($lista);

            } else {

                return 'ERROR'.$resultado;

            }

        }

        public function informes_consultar ($args) {

            $sql = "
                select
                    row_number() over () as id,
                    t.*,
                    ppal.historias_diagnosticos_armar_lista(t.diagnosticos) as diagnosticos_procesados,
                    TO_CHAR(t.fecha :: DATE, 'dd-mm-yyyy') as fecha_arreglada
                FROM (
                    SELECT x.*
                    from 
                     jsonb_array_elements(
                    (select informes_medicos from historias.historias where id_historia = ?)
                     ) AS t(doc),
                     jsonb_to_record(t.doc) as x (nombres character varying(150), apellidos character varying(150), direccion character varying(300), cedula character varying(14), fecha date, fecha_nacimiento date, hora time without time zone, peso numeric(5,2), talla numeric(3,2), motivo jsonb, enfermedad jsonb, plan jsonb, diagnosticos jsonb)
                ) as t
                order by t.fecha desc, t.hora desc
            ";

            return $this->seleccionar($sql, $args);

        }

        public function informes_editar($args) {

            $sql = "
                update $this->schema.$this->tabla 
                set 
                    informes_medicos = ?::jsonb
                where id_historia = ?
            ";

            return $this->actualizar($sql, $args);

        }

        public function informes_eliminar($args) {

            $sql = "
                update $this->schema.$this->tabla 
                set informes_medicos = ?::jsonb
                where id_historia = ?
            ";

            return $this->actualizar($sql, $args);

        }

        public function estandar_diagnosticos($args) {
            
            $diagnosticos = '';
            
            foreach ($args as $r) {$diagnosticos.= $r['id_diagnostico'].',';}
            
            $diagnosticos = substr($diagnosticos, 0, strlen($diagnosticos) - 1);

            if(strlen($diagnosticos) > 0) {
                
                $lista = [];
                
                $resultado = $this->e_pdo("select id_diagnostico, concat(id_diagnostico,'||',nombre) as nombre from historias.diagnosticos where id_diagnostico in ($diagnosticos)")->fetchAll(PDO::FETCH_ASSOC);

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

