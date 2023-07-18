<?php
    require('../clases/ppal.class.php');
    
    class Model extends ppal {

        public $schema ='principales';
        public $tabla = 'historias';

        public $filtroMapa = [
            0 => "status = '?'",
            1 => "status = '?'"
        ];

        public function cargar_historias($args) {
            
            $sql = "
                select 
                    id_historia,
                    coalesce(NULLIF(id_correlativo::character varying(10), '0'), '-') AS id_correlativo,
                    id_ocupacion,
                    id_proveniencia,
                    id_medico_referido,
                    id_ocupacion,
                    id_parentesco,
                    id_estado_civil,
                    id_religion,
                    nombres,
                    apellidos,
                    cedula,
                    direccion,
                    sexo,
                    fecha_naci,
                    lugar_naci,
                    telefonos,
                    otros,
                    emergencia_persona,
                    emergencia_informacion,
                    emergencia_contacto,
                    fecha_consulta,
                    fecha,
                    status, 
                    concat(nombres, ' ', apellidos) as nombre_completo,
                    TO_CHAR(fecha_consulta :: DATE, 'dd-mm-yyyy') as fecha_consulta_arreglada,
                    nro_hijo,
                    coalesce(NULLIF(nro_hijo::character varying(10), '0'), '-') AS nro_hijo_visual
                from $this->schema.$this->tabla where status = 'A' order by id_historia desc
                limit 800
            ";
            
            return $this->seleccionar($sql, $args);
        }

        public function buscar_historias($args) {

            $busqueda = $args[0];
                        
            if (is_numeric($busqueda) || gettype($busqueda) == 'integer' || ctype_digit($busqueda)) {
                $historia = "or id_historia = ".(int)$busqueda." or id_correlativo = ".(int)$busqueda;
            } else {
                $historia = '';
            }

            $sql = "
                select 
                    id_historia,
                    coalesce(NULLIF(id_correlativo::character varying(10), '0'), '-') AS id_correlativo,
                    id_ocupacion,
                    id_proveniencia,
                    id_medico_referido,
                    id_ocupacion,
                    id_parentesco,
                    id_estado_civil,
                    id_religion,
                    nombres,
                    apellidos,
                    cedula,
                    direccion,
                    sexo,
                    fecha_naci,
                    lugar_naci,
                    telefonos,
                    otros,
                    emergencia_persona,
                    emergencia_informacion,
                    emergencia_contacto,
                    fecha_consulta,
                    fecha,
                    status, 
                    concat(nombres, ' ', apellidos) as nombre_completo,
                    TO_CHAR(fecha_consulta :: DATE, 'dd-mm-yyyy') as fecha_consulta_arreglada,
                    nro_hijo,
                    coalesce(NULLIF(nro_hijo::character varying(10), '0'), '-') AS nro_hijo_visual
                from $this->schema.$this->tabla
                where cedula like '$busqueda' or concat(nombres, ' ', apellidos) like '%'|| UPPER('$busqueda') ||'%' $historia order by 1 DESC
                limit 800
            ";

            return $this->seleccionar($sql, []);

        }

        public function traer_historia($args) {
            $sql = "
                select 
                    id_historia,
                    coalesce(NULLIF(id_correlativo::character varying(10), '0'), '-') AS id_correlativo,
                    id_ocupacion,
                    id_proveniencia,
                    id_medico_referido,
                    id_ocupacion,
                    id_parentesco,
                    id_estado_civil,
                    id_religion,
                    nombres,
                    apellidos,
                    cedula,
                    direccion,
                    sexo,
                    fecha_naci,
                    lugar_naci,
                    telefonos,
                    otros,
                    emergencia_persona,
                    emergencia_informacion,
                    emergencia_contacto,
                    fecha_consulta,
                    fecha,
                    status, 
                    concat(nombres, ' ', apellidos) as nombre_completo,
                    TO_CHAR(fecha_consulta :: DATE, 'dd-mm-yyyy') as fecha_consulta_arreglada,
                    nro_hijo,
                    coalesce(NULLIF(nro_hijo::character varying(10), '0'), '-') AS nro_hijo_visual
                from $this->schema.$this->tabla where id_historia = ?
            ";
            
            return json_encode($this->i_pdo($sql, $args, true)->fetch(PDO::FETCH_ASSOC));
        }

        public function insertar_historia($args) {

            $cedulaHijo = $args[0].'-'.$args[1];

            $id_ocupacion    = &$args[8];
            $id_proveniencia = &$args[9];
            $id_medico       = &$args[10];
            $id_parentesco   = &$args[11];
            $id_estado_civil = &$args[12];
            $id_religion     = &$args[13];

            $telefonos = &$args[14];
            $otros     = &$args[15];
            
            if (empty($id_ocupacion)) {$id_ocupacion = 0;}
            if (empty($id_proveniencia)) {$id_proveniencia = 0;}
            if (empty($id_medico)) {$id_medico = 0;}
            if (empty($id_parentesco)) {$id_parentesco = 0;}
            if (empty($id_estado_civil)) {$id_estado_civil = 0;}
            if (empty($id_religion)) {$id_religion = 0;}

            foreach ($telefonos as &$t) {
                $t = strval($t['value']);
            };

            foreach ($otros as &$o) {
                $o = strval($o['value']);
            };

            $telefonos = json_encode($telefonos);
            $otros     = json_encode($otros);

            $sql = "select 1 from principales.historias where concat(cedula, '-' ,nro_hijo) = ?";
            $resultado = $this->i_pdo($sql, [$cedulaHijo], true)->fetchColumn();

            if (!$resultado) {

                $sql = "
                    insert into $this->schema.$this->tabla (
                        cedula,
                        nro_hijo,
                        nombres,
                        apellidos,
                        fecha_naci,
                        lugar_naci,
                        sexo,
                        direccion,
                        id_ocupacion,
                        id_proveniencia,
                        id_medico_referido,
                        id_parentesco,
                        id_estado_civil,
                        id_religion,
                        telefonos,
                        otros
                    ) values (
                        trim(upper(?)), 
                        trim(upper(?)),
                        trim(upper(?)), 
                        trim(upper(?)), 
                        ?::date,
                        trim(upper(?)),
                        trim(upper(?)),
                        trim(upper(?)),
                        ?,
                        ?,
                        ?,
                        ?,
                        ?,
                        ?,
                        ?::jsonb,
                        ?::jsonb
                    )
                ";

                return $this->insertar($sql, $args);

            } else {

                return 'repetido';

            }

        }

        public function editar_historia($args) {

            $cedulaHijo = $args[0].'-'.$args[1];

            $id_ocupacion    = &$args[7];
            $id_proveniencia = &$args[8];
            $id_medico       = &$args[9];
            $id_parentesco   = &$args[10];
            $id_estado_civil = &$args[11];
            $id_religion     = &$args[12];

            $telefonos = &$args[15];
            $otros     = &$args[16];

            $id_historia = $args[17];
            
            if (empty($id_ocupacion)) {$id_ocupacion = 0;}
            if (empty($id_proveniencia)) {$id_proveniencia = 0;}
            if (empty($id_medico)) {$id_medico = 0;}
            if (empty($id_parentesco)) {$id_parentesco = 0;}
            if (empty($id_estado_civil)) {$id_estado_civil = 0;}
            if (empty($id_religion)) {$id_religion = 0;}

            foreach ($telefonos as &$t) {
                $t = strval($t['value']);
            };

            foreach ($otros as &$o) {
                $o = strval($o['value']);
            };

            $telefonos = json_encode($telefonos);
            $otros     = json_encode($otros);

            $sql = "select id_historia from principales.historias where concat(cedula, '-' ,nro_hijo) = ?";
            $resultado = $this->i_pdo($sql, [$cedulaHijo], true)->fetchColumn();

            if (!$resultado || $resultado == $id_historia) {

                $sql = "
                    update $this->schema.$this->tabla set
                        cedula = trim(upper(?)),
                        nro_hijo = trim(upper(?)),
                        nombres = trim(upper(?)),
                        apellidos = trim(upper(?)),
                        fecha_naci = ?::date,
                        lugar_naci = trim(upper(?)),
                        direccion = trim(upper(?)),
                        id_ocupacion = ?,
                        id_proveniencia = ?,
                        id_medico_referido = ?,
                        id_parentesco = ?,
                        id_estado_civil = ?,
                        id_religion = ?,
                        sexo = trim(upper(?)), 
                        status = trim(upper(?)),
                        telefonos = ?::jsonb, 
                        otros = ?::jsonb
                    where id_historia = ?
                ";

               return $this->actualizar($sql, $args);

            } else {

                return 'repetido';

            }

        }

        public function filtrar($args) {
            $sql = "
                select 
                    id_historia,
                    coalesce(NULLIF(id_correlativo::character varying(10), '0'), '-') AS id_correlativo,
                    id_ocupacion,
                    id_proveniencia,
                    id_medico_referido,
                    id_ocupacion,
                    id_parentesco,
                    id_estado_civil,
                    id_religion,
                    nombres,
                    apellidos,
                    cedula,
                    direccion,
                    sexo,
                    fecha_naci,
                    lugar_naci,
                    telefonos,
                    otros,
                    emergencia_persona,
                    emergencia_informacion,
                    emergencia_contacto,
                    fecha_consulta,
                    fecha,
                    status, 
                    concat(nombres, ' ', apellidos) as nombre_completo,
                    TO_CHAR(fecha_consulta :: DATE, 'dd-mm-yyyy') as fecha_consulta_arreglada,
                    nro_hijo,
                    coalesce(NULLIF(nro_hijo::character varying(10), '0'), '-') AS nro_hijo_visual
                from $this->schema.$this->tabla";   
            $this->aplicar_filtros([$sql, $args, 0, false]);
        }

    }
?>

