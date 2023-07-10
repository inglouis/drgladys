<?php
    require('../clases/ppal.class.php');
    class Model extends ppal {
        public $schema ='basicas';
        public $tabla = 'estados';
        public $filtroMapa = [
            0 => "status = '?'",
            1 => "status = '?'"
        ];
     
        public function cargar_estados($args) {
            $sql = "select id_estados, trim(nombre) as nombre, trim(status) as status from $this->schema.$this->tabla where status='A' order by id_estados DESC limit 800";
                return $this->seleccionar($sql, $args);
        }

        public function buscar_estados($args) {
            $busqueda = $args[0];

            if (ctype_digit($busqueda)) {
                $conc = "or id_estados = ".(int)$busqueda;
            } else {
                $conc = '';
            }

            $sql = "select id_estados, trim(nombre) as nombre, trim(status) as status from $this->schema.$this->tabla where status='A' and nombre like '%'|| UPPER('$busqueda') ||'%' $conc order by id_estados DESC limit 8000";
                return $this->seleccionar($sql, []);
        }

        public function crear_estados($args){

            $resultado = ($this->i_pdo("select id_estados from $this->schema.$this->tabla where nombre = upper(trim('$args[0]')) limit 1", [], true))->fetchColumn();

            if(empty($resultado)) {
                $sql = "insert into $this->schema.$this->tabla(id_estados, nombre, status) VALUES(default, trim(upper(?)), 'A')";
                return $this->insertar($sql, $args);
            } else {
                return "repetido";
            }
        }

        public function actualizar_estados($args) { 

            $resultado = ($this->i_pdo("select id_estados from $this->schema.$this->tabla where nombre = upper(trim('$args[0]')) and id_estados != $args[2] limit 1", [], true))->fetchColumn();

            if(empty($resultado)) {
                $sql = "update $this->schema.$this->tabla set nombre = trim(upper(?)), status =trim(upper(?)) where id_estados = ?";
                return $this->actualizar($sql, $args); 
            } else {
                return "repetido";
            }
                    
        }

        public function elimina_estado($args){    
           $sql ="delete from $this->schema.$this->tabla where id_estados = ?";
           return $this->eliminar($sql, $args);
        }
        //--------------------------------------------------------------
        //--------------------------------------------------------------
        public function traer_estado($args){     
            $sql = "select * from $this->schema.$this->tabla where id_estados = ?";
            return $this->seleccionar($sql, $args);
        }   

        public function filtrar($args) {
            $sql = "select id_estados, trim(nombre) as nombre, trim(status) as status from $this->schema.$this->tabla";   
            $this->aplicar_filtros([$sql, $args, 0, false]);
        }
    }
?>

