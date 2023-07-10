<?php
    require('../clases/ppal.class.php');
    
    class Model extends ppal {

        public $schema ='historias';
        public $tabla = 'tabfor';

        public $filtroMapa = [
            0 => "status = '?'",
            1 => "status = '?'"
        ];
        
        public function cargarTabformulas($args) {
            $sql = "select id_tabfor, trim(descripcion) as descripcion, trim(status) as status from $this->schema.$this->tabla where status='A' order by id_tabfor desc limit 800";
                return $this->seleccionar($sql, $args);
        }


        public function buscarTabformulas($args) {
            $busqueda = $args[0];

            if (ctype_digit($busqueda)) {
                $tra = "or id_tabfor = ".(int)$busqueda;
            } else {
                $tra = '';
            }

            $sql = "select id_tabfor, trim(descripcion) as descripcion, trim(status) as status from $this->schema.$this->tabla where status='A' and descripcion like '%'|| UPPER('$busqueda') ||'%' $tra order by id_tabfor limit 8000";
                return $this->seleccionar($sql, []);
        }

        public function crearTabformulas($args){

            $resultado = ($this->i_pdo("select id_tabfor from $this->schema.$this->tabla where descripcion = upper(trim('$args[0]')) limit 1", [], true))->fetchColumn();

            if(empty($resultado)) {
                $sql = "insert into $this->schema.$this->tabla(id_tabfor, descripcion, status) VALUES(default, trim(upper(?)), 'A')";
            return $this->insertar($sql, $args);
            } else {
                return "repetido";
            }

        }

        public function actualizarTabformulas($args) { 

            $resultado = ($this->i_pdo("select id_tabfor from $this->schema.$this->tabla where descripcion = upper(trim('$args[0]')) and id_tabfor != $args[2] limit 1", [], true))->fetchColumn();

            if(empty($resultado)) {
                $sql = "update $this->schema.$this->tabla set descripcion = trim(upper(?)), status =trim(upper(?)) where id_tabfor = ?";
                return $this->actualizar($sql, $args); 
            } else {
                return "repetido";
            }         
        }

        public function eliminaTabformula($args){    
           $sql ="delete from $this->schema.$this->tabla where id_tabfor = ?";
           return $this->eliminar($sql, $args);
        }
        //--------------------------------------------------------------
        //--------------------------------------------------------------
        public function traerTabformula($args){     
            $sql = "select * from $this->schema.$this->tabla where id_tabfor = ?";
            return $this->seleccionar($sql, $args);
        }   

        public function filtrar($args) {
            $sql = "select id_tabfor, trim(descripcion) as descripcion, trim(status) as status from $this->schema.$this->tabla";   
            $this->aplicar_filtros([$sql, $args, 0, false]);
        }
    }
?>

