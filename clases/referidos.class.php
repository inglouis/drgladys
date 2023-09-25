<?php
    require('../clases/ppal.class.php');
    class Model extends ppal {
        public $schema ='basicas';
        public $tabla = 'medicos_referidos';
        public $filtroMapa = [
            0 => "status = '?'",
            1 => "status = '?'"
        ];
     
        public function cargar_referidos($args) {
            $sql = "select id_referido, trim(nombre) as nombre, trim(status) as status from $this->schema.$this->tabla where status='A' order by id_referido DESC limit 8000";
            return $this->seleccionar($sql, $args);
        }

        public function traer_referidos() {

            $datos = json_decode($this->cargar_referidos([]), true);

            $nueva_lista = array();

            foreach ($datos as &$r) {
                
                $nueva_lista[$r['id_referido']] = null;

                $nueva_lista[$r['id_referido']] = array(
                    "nombre" => $r['nombre'],
                    "status" => $r['status']
                ); 

            }

            return json_encode($nueva_lista);

        }

        public function buscar_referidos($args) {
            $busqueda = $args[0];

            if (is_numeric($busqueda) || gettype($busqueda) == 'integer' || ctype_digit($busqueda)) {
                $conc = "or id_referido = ".(int)$busqueda;
            } else {
                $conc = '';
            }

            $sql = "select id_referido, trim(nombre) as nombre, trim(status) as status from $this->schema.$this->tabla where status='A' and nombre like '%'|| UPPER('$busqueda') ||'%' $conc order by id_referido DESC limit 8000";
                return $this->seleccionar($sql, []);
        }

        public function crear_referidos($args){

            $resultado = ($this->i_pdo("select id_referido from $this->schema.$this->tabla where nombre = upper(trim('$args[0]')) limit 1", [], true))->fetchColumn();

            if(empty($resultado)) {
                $sql = "insert into $this->schema.$this->tabla(id_referido, nombre, status) VALUES(default, trim(upper(?)), 'A')";
                return $this->insertar($sql, $args);
            } else {
                return "repetido";
            }

            
        }

        public function actualizar_referidos($args) { 

            $resultado = ($this->i_pdo("select id_referido from $this->schema.$this->tabla where nombre = upper(trim('$args[0]')) and id_referido != $args[2] limit 1", [], true))->fetchColumn();

            if(empty($resultado)) {
                $sql = "update $this->schema.$this->tabla set nombre = trim(upper(?)), status =trim(upper(?)) where id_referido = ?";
                return $this->actualizar($sql, $args); 
            } else {
                return "repetido";
            }
                    
        }

        public function elimina_referido($args){    
           $sql ="delete from $this->schema.$this->tabla where id_referido = ?";
           return $this->eliminar($sql, $args);
        }

        //--------------------------------------------------------------
        //--------------------------------------------------------------
        
        public function traer_referido($args){     
            $sql = "select * from $this->schema.$this->tabla where id_referido = ?";
            return $this->seleccionar($sql, $args);
        }   

        public function filtrar($args) {
            $sql = "select id_referido, trim(nombre) as nombre, trim(status) as status from $this->schema.$this->tabla";   
            $this->aplicar_filtros([$sql, $args, 0, false, 'DESC', '8000']);
        }
    }
?>

