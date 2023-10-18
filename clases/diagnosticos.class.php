<?php
    require('../clases/ppal.class.php');
    class Model extends ppal {
        public $schema ='basicas';
        public $tabla = 'diagnosticos';
        public $filtroMapa = [
            0 => "status = '?'",
            1 => "status = '?'"
        ];
     
        public function cargar_diagnosticos($args) {
            $sql = "select id_diagnostico, trim(nombre) as nombre, trim(status) as status from $this->schema.$this->tabla where status='A' order by id_diagnostico DESC limit 800";
                return $this->seleccionar($sql, $args);
        }

        public function buscar_diagnosticos($args) {
            $busqueda = $args[0];

            if (ctype_digit($busqueda)) {
                $conc = "or id_diagnostico = ".(int)$busqueda;
            } else {
                $conc = '';
            }

            $sql = "select id_diagnostico, trim(nombre) as nombre, trim(status) as status from $this->schema.$this->tabla where status='A' and nombre like '%'|| UPPER('$busqueda') ||'%' $conc order by id_diagnostico DESC limit 8000";
                return $this->seleccionar($sql, []);
        }

        public function crear_diagnosticos($args){

            $sql = "
                select id_diagnostico 
                from $this->schema.$this->tabla 
                where nombre = upper(trim(?)) 
                limit 1
            ";

            $resultado = $this->i_pdo($sql, [$args[0]], true)->fetchColumn();

            if(empty($resultado)) {

                $sql = "
                    insert into $this->schema.$this->tabla(
                        nombre
                    ) VALUES(
                        trim(upper(?))
                    )"
                ;

                return $this->insertar($sql, $args);

            } else {
                return "repetido";
            }
        }

        public function actualizar_diagnosticos($args) { 

            $resultado = ($this->i_pdo("select id_diagnostico from $this->schema.$this->tabla where nombre = upper(trim('$args[0]')) and id_diagnostico != $args[2] limit 1", [], true))->fetchColumn();

            if(empty($resultado)) {
                $sql = "update $this->schema.$this->tabla set nombre = trim(upper(?)), status =trim(upper(?)) where id_diagnostico = ?";
                return $this->actualizar($sql, $args); 
            } else {
                return "repetido";
            }
                    
        }

        public function filtrar($args) {
            $sql = "select id_diagnostico, trim(nombre) as nombre, trim(status) as status from $this->schema.$this->tabla";   
            $this->aplicar_filtros([$sql, $args, 0, false]);
        }

        public function traer_diagnosticos() {

            $datos = json_decode($this->cargar_diagnosticos([]), true);

            $nueva_lista = array();

            foreach ($datos as &$r) {
                
                $nueva_lista[$r['id_diagnostico']] = null;

                $nueva_lista[$r['id_diagnostico']] = array(
                    "nombre" => $r['nombre'],
                    "status" => $r['status']
                ); 

            }

            return json_encode($nueva_lista);

        }
    }
?>

