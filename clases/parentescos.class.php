<?php
    require('../clases/ppal.class.php');
    class Model extends ppal {
        public $schema ='basicas';
        public $tabla = 'parentescos';
        public $filtroMapa = [
            0 => "status = '?'",
            1 => "status = '?'"
        ];
     
        public function cargar_parentescos($args) {
            $sql = "select id_parentesco, trim(nombre) as nombre, trim(status) as status from $this->schema.$this->tabla where status='A' order by id_parentesco DESC limit 800";
                return $this->seleccionar($sql, $args);
        }

        public function buscar_parentescos($args) {
            $busqueda = $args[0];

            if (ctype_digit($busqueda)) {
                $conc = "or id_parentesco = ".(int)$busqueda;
            } else {
                $conc = '';
            }

            $sql = "select id_parentesco, trim(nombre) as nombre, trim(status) as status from $this->schema.$this->tabla where status='A' and nombre like '%'|| UPPER('$busqueda') ||'%' $conc order by id_parentesco DESC limit 8000";
                return $this->seleccionar($sql, []);
        }

        public function crear_parentescos($args){

            $resultado = ($this->i_pdo("select id_parentesco from $this->schema.$this->tabla where nombre = upper(trim('$args[0]')) limit 1", [], true))->fetchColumn();

            if(empty($resultado)) {
                $sql = "insert into $this->schema.$this->tabla(id_parentesco, nombre, status) VALUES(default, trim(upper(?)), 'A')";
                return $this->insertar($sql, $args);
            } else {
                return "repetido";
            }
        }

        public function actualizar_parentescos($args) { 

            $resultado = ($this->i_pdo("select id_parentesco from $this->schema.$this->tabla where nombre = upper(trim('$args[0]')) and id_parentesco != $args[2] limit 1", [], true))->fetchColumn();

            if(empty($resultado)) {
                $sql = "update $this->schema.$this->tabla set nombre = trim(upper(?)), status =trim(upper(?)) where id_parentesco = ?";
                return $this->actualizar($sql, $args); 
            } else {
                return "repetido";
            }
                    
        }

        public function elimina_parentesco($args){    
           $sql ="delete from $this->schema.$this->tabla where id_parentesco = ?";
           return $this->eliminar($sql, $args);
        }
        //--------------------------------------------------------------
        //--------------------------------------------------------------
        public function traer_parentesco($args){     
            $sql = "select * from $this->schema.$this->tabla where id_parentesco = ?";
            return $this->seleccionar($sql, $args);
        }   

        public function filtrar($args) {
            $sql = "select id_parentesco, trim(nombre) as nombre, trim(status) as status from $this->schema.$this->tabla";   
            $this->aplicar_filtros([$sql, $args, 0, false]);
        }
    }
?>

