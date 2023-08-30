<?php
    require('../clases/ppal.class.php');
    
    class Model extends ppal {

        public $schema ='miscelaneos';
        public $tabla = 'usuarios';

        public $filtroMapa = [
            0 => "status = '?'",
            1 => "status = '?'"
        ];

        //--------------------------------------------------------------------------------------
        public function notificar($args) {
    
            $lista = array(
                "datos"   => $args[0],
                "reporte" => $args[1]
            );

            $sql = "
                update $this->schema.$this->tabla
                SET 
                    notificacion_reportes = jsonb_insert(
                        notificacion_reportes, 
                        '{0}', 
                        ?::jsonb
                        , false
                    )
                WHERE id_usuario = ?;
            ";

            $resultado = $this->actualizar($sql, [json_encode($lista), $_SESSION['usuario']['notificar_usuario']]);

            if ($resultado == 'exito') {

                $this->controlador_cambios_activar([]);

                return json_encode($lista);

            } else {

                return 'ERROR'.$resultado;

            }
            
        }

        public function notificacion_reportes_cantidad($args) {

            $sql = "select notificacion_reportes from $this->schema.$this->tabla where id_usuario = ?";

            $lista = json_decode($this->i_pdo($sql, [$_SESSION['usuario']['id_usuario']], true)->fetchColumn(), true);

            return count($lista);

        }

        public function notificaciones_consultar($args) {

            $sql = "
                select datos.* from (

                    select
                        (row_number() over ()) - 1 as id,
                        t.*
                    FROM (
                        SELECT x.*
                        FROM 
                            jsonb_array_elements(
                                (SELECT notificacion_reportes FROM $this->schema.$this->tabla WHERE id_usuario = ?)
                        ) AS t(doc),
                        jsonb_to_record(t.doc) as x (
                            reporte character varying(100),
                            datos jsonb
                        )
                    ) as t

                ) as datos
                order by datos.id asc
            ";

            return $this->seleccionar($sql, [$_SESSION['usuario']['id_usuario']]);

        }

        //--------------------------------------------------------------------------------------

        public function notificar_revisado($args) {

            $sql = "select controlador_cambios from miscelaneos.usuarios where id_usuario = ?";

            $procesar = $this->i_pdo($sql, [$_SESSION['usuario']['id_usuario']], true)->fetchColumn();

            if (!$procesar) {

                $datos_notificados    = &$args[0];
                $reporte              = &$args[1];
                $posicion             = (int)$args[2];

                $lista = array(
                    0 => $datos_notificados,
                    1 => $reporte
                );

                $this->notificar($lista);

                $sql = "
                    update $this->schema.$this->tabla 
                        set notificacion_reportes = (select notificacion_reportes - (?)::int from miscelaneos.usuarios where id_usuario = ?)::jsonb
                    where id_usuario = ?;
                ";

                $resultado = $this->actualizar($sql, [ $posicion, (int)$_SESSION['usuario']['id_usuario'], (int)$_SESSION['usuario']['id_usuario'] ]);

                if ($resultado == 'exito') {

                    $this->controlador_cambios_activar([]);

                    return 'exito';

                } else {

                    return 'ERROR'.$resultado;

                }

            } else {

                return 'espera';

            }

        }

        /*--------------------------------------------------------*/

        public function notificado_revisado($args) {

            $sql = "select controlador_cambios from miscelaneos.usuarios where id_usuario = ?";

            $procesar = $this->i_pdo($sql, [$_SESSION['usuario']['id_usuario']], true)->fetchColumn();

            if (!$procesar) {

                $posicion = (int)$args[0];

                $sql = "
                    update $this->schema.$this->tabla 
                        set notificacion_reportes = (select notificacion_reportes - (?)::int from miscelaneos.usuarios where id_usuario = ?)::jsonb
                    where id_usuario = ?;
                ";

                $resultado = $this->actualizar($sql, [ $posicion, (int)$_SESSION['usuario']['id_usuario'], (int)$_SESSION['usuario']['id_usuario'] ]);

                if ($resultado == 'exito') {

                    $this->controlador_cambios_activar([]);

                    return 'exito';

                } else {

                    return 'ERROR'.$resultado;

                }

            } else {

                return 'espera';

            }

        }

    }
?>

