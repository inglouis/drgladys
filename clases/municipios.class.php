<?php
    require('../clases/ppal.class.php');
    class Model extends ppal {
        public $schema ='basicas';
        public $tabla = 'municipios';
        public $filtroMapa = [
            0 => "status = '?'",
            1 => "status = '?'"
        ];
     
        public function cargar_municipios($args) {
            $sql = "select id_municipio, trim(nombre) as nombre, trim(status) as status from $this->schema.$this->tabla where status='A' order by id_municipio DESC limit 800";
                return $this->seleccionar($sql, $args);
        }

        public function buscar_municipios($args) {
            $busqueda = $args[0];

            if (ctype_digit($busqueda)) {
                $conc = "or id_municipio = ".(int)$busqueda;
            } else {
                $conc = '';
            }

            $sql = "select id_municipio, trim(nombre) as nombre, trim(status) as status from $this->schema.$this->tabla where status='A' and nombre like '%'|| UPPER('$busqueda') ||'%' $conc order by id_municipio DESC limit 8000";
                return $this->seleccionar($sql, []);
        }

        public function crear_municipios($args){

            $resultado = ($this->i_pdo("select id_municipio from $this->schema.$this->tabla where nombre = upper(trim('$args[0]')) limit 1", [], true))->fetchColumn();

            if(empty($resultado)) {
                $sql = "insert into $this->schema.$this->tabla(id_municipio, nombre, status) VALUES(default, trim(upper(?)), 'A')";
                return $this->insertar($sql, $args);
            } else {
                return "repetido";
            }
        }

        public function actualizar_municipios($args) { 

            $resultado = ($this->i_pdo("select id_municipio from $this->schema.$this->tabla where nombre = upper(trim('$args[0]')) and id_municipio != $args[2] limit 1", [], true))->fetchColumn();

            if(empty($resultado)) {
                $sql = "update $this->schema.$this->tabla set nombres_apellidos = trim(upper(?)), direccion = trim(upper(?)), status =trim(upper(?)) where id_municipio = ?";
                return $this->actualizar($sql, $args); 
            } else {
                return "repetido";
            }
                    
        }

        public function elimina_municipio($args){    
           $sql ="delete from $this->schema.$this->tabla where id_municipio = ?";
           return $this->eliminar($sql, $args);
        }
        //--------------------------------------------------------------
        //--------------------------------------------------------------
        public function traer_municipio($args){     
            $sql = "select * from $this->schema.$this->tabla where id_municipio = ?";
            return $this->seleccionar($sql, $args);
        }   

        public function filtrar($args) {
            $sql = "select id_municipio, trim(nombre) as nombre, trim(status) as status from $this->schema.$this->tabla";   
            $this->aplicar_filtros([$sql, $args, 0, false]);
        }
    }
?>

