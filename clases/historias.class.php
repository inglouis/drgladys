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
                    id_correlativo
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
                    TO_CHAR(fecha_consulta :: DATE, 'dd-mm-yyyy') as fecha_consulta_arreglada 
                from $this->schema.$this->tabla where status = 'A' order by id_historia desc
                limit 800
            ";
            
            return $this->seleccionar($sql, $args);
        }

        public function buscar_historias($args) {

            $busqueda = $args[0];
                        
            if (is_numeric($busqueda) || gettype($busqueda) == 'integer' || ctype_digit($busqueda)) {
                $historia = "or id_historia = ".(int)$busqueda;
            } else {
                $historia = '';
            }

            $sql = "
                select 
                    id_historia,
                    id_ocupacion,
                    id_estado,
                    id_municipio,
                    id_medico,
                    id_ocupacion,
                    id_parentesco,
                    id_estado_civil,
                    id_religion,
                    nombres,
                    apellidos,
                    direccion_paciente,
                    cedula,
                    sexo,
                    parentesco,
                    fecha_naci,
                    lugar_naci,
                    telefonos,
                    otros,
                    persona_emergencia,
                    persona_direccion,
                    fecha_consulta,
                    status, 
                    concat(nombres, ' ', apellidos) as nombre_completo,
                    TO_CHAR(fecha_consulta :: DATE, 'dd-mm-yyyy') as fecha_consulta_arreglada 
                from $this->schema.$this->tabla
                where cedula like '$busqueda' or concat(nombres, ' ', apellidos) like '%'|| UPPER('$busqueda') ||'%' $historia order by 1 DESC
                limit 800
            ";

            return $this->seleccionar($sql, []);

        }

        public function traer_historia($args) {
            $sql = "
                select *, concat(nombres, ' ', apellidos) as nombre_completo from $this->tabla.$this->schema where id_historia = ?
            ";
            
            return json_encode($this->i_pdo($sql, $args, true)->fetch(PDO::FETCH_ASSOC));
        }

        public function insertar_historia($args) {

            $id_ocupacion = &$args[5];
            $telefonos = &$args[9];
            $correos   = &$args[10];
            $otros     = &$args[11];

            if (empty($id_ocupacion)) {
                $id_ocupacion = 0;
            }

            foreach ($otros as &$o) {
                $o = $o['value'];
            };

            foreach ($telefonos as &$t) {
                $t = strval($t['value']);
            };

            foreach ($correos as &$c) {
                $c = $c['value'];
            };

            $telefonos = json_encode($telefonos);
            $correos   = json_encode($correos);
            $otros     = json_encode($otros);

            $sql = "
                insert into $this->schema.$this->tabla (
                    cedula,
                    nombres,
                    apellidos,
                    fecha_nacimiento,
                    direccion,
                    id_ocupacion,
                    sexo,
                    talla,
                    peso,
                    telefonos,
                    correos,
                    otros
                ) values (
                    trim(upper(?)), 
                    trim(upper(?)), 
                    trim(upper(?)), 
                    ?::date,
                    trim(upper(?)),
                    ?,
                    trim(upper(?)), 
                    ?, 
                    ?, 
                    ?::jsonb, 
                    ?::jsonb,
                    ?::jsonb
                )
            ";

           return $this->insertar($sql, $args);

        }

        public function editar_historia($args) {

            $id_ocupacion = &$args[5];
            $telefonos = &$args[10];
            $correos   = &$args[11];
            $otros     = &$args[12];
            
            if (empty($id_ocupacion)) {
                $id_ocupacion = 0;
            }

            foreach ($telefonos as &$t) {
                $t = strval($t['value']);
            };

            foreach ($correos as &$c) {
                $c = strval($c['value']);
            };
            
            foreach ($otros as &$o) {
                $o = strval($o['value']);
            };

            $telefonos = json_encode($telefonos);
            $correos   = json_encode($correos);
            $otros     = json_encode($otros);

            $sql = "
                update $this->schema.$this->tabla set
                    cedula = trim(upper(?)),
                    nombres = trim(upper(?)),
                    apellidos = trim(upper(?)),
                    fecha_nacimiento = ?::date,
                    direccion = trim(upper(?)),
                    id_ocupacion = ?,
                    sexo = trim(upper(?)), 
                    talla = ?,
                    peso = ?,
                    status = trim(upper(?)),
                    telefonos = ?::jsonb, 
                    correos = ?::jsonb, 
                    otros = ?::jsonb
                where id_historia = ?
            ";

           return $this->actualizar($sql, $args);
        }

        public function filtrar($args) {
            $sql = "
                select 
                    id_historia,
                    id_ocupacion,
                    nombres,
                    apellidos,
                    direccion,
                    cedula,
                    sexo,
                    talla,
                    peso,
                    fecha_nacimiento,
                    telefonos,
                    correos,
                    otros,
                    fecha_cons,
                    status, 
                    concat(nombres, ' ', apellidos) as nombre_completo,
                    TO_CHAR(fecha_cons :: DATE, 'dd-mm-yyyy') as fecha_cons_arreglada 
                from $this->schema.$this->tabla";   
            $this->aplicar_filtros([$sql, $args, 0, false]);
        }

    }
?>

