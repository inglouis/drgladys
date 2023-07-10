<?php
    require('../clases/ppal.class.php');
    class Model extends ppal {
        public $schema ='basicas';
        public $tabla = 'medicos';
        public $filtroMapa = [
            0 => "status = '?'",
            1 => "status = '?'"
        ];
     
        public function cargar_medicos($args) {
            $sql = "select id_medico, trim(nombres_apellidos) as nombres_apellidos, trim(direccion) as direccion, trim(status) as status from $this->schema.$this->tabla where status='A' order by id_medico DESC limit 800";
                return $this->seleccionar($sql, $args);
        }

        public function buscar_medicos($args) {
            $busqueda = $args[0];

            if (ctype_digit($busqueda)) {
                $conc = "or id_medico = ".(int)$busqueda;
            } else {
                $conc = '';
            }

            $sql = "select id_medico, trim(nombres_apellidos) as nombres_apellidos, trim(direccion) as direccion, trim(status) as status from $this->schema.$this->tabla where status='A' and nombres_apellidos like '%'|| UPPER('$busqueda') ||'%' $conc order by id_medico DESC limit 8000";
                return $this->seleccionar($sql, []);
        }

        public function crear_medicos($args){

            $resultado = ($this->i_pdo("select id_medico from $this->schema.$this->tabla where nombres_apellidos = upper(trim('$args[0]')) limit 1", [], true))->fetchColumn();

            if(empty($resultado)) {
                $sql = "insert into $this->schema.$this->tabla(id_medico, nombres_apellidos, direccion, status) VALUES(default, trim(upper(?)), trim(upper(?)), 'A')";
                return $this->insertar($sql, $args);
            } else {
                return "repetido";
            }
        }

        public function actualizar_medicos($args) { 

            $resultado = ($this->i_pdo("select id_medico from $this->schema.$this->tabla where nombres_apellidos = upper(trim('$args[0]')) and id_medico != $args[3] limit 1", [], true))->fetchColumn();

            if(empty($resultado)) {
                $sql = "update $this->schema.$this->tabla set nombres_apellidos = trim(upper(?)), direccion = trim(upper(?)), status =trim(upper(?)) where id_medico = ?";
                return $this->actualizar($sql, $args); 
            } else {
                return "repetido";
            }
                    
        }

        public function medico($args){    
           $sql ="delete from $this->schema.$this->tabla where id_medico = ?";
           return $this->eliminar($sql, $args);
        }
        //--------------------------------------------------------------
        //--------------------------------------------------------------
        public function traer_medico($args){     
            $sql = "select * from $this->schema.$this->tabla where id_medico = ?";
            return $this->seleccionar($sql, $args);
        }   

        public function filtrar($args) {
            $sql = "select id_medico, trim(nombres_apellidos) as nombres_apellidos, trim(direccion) as direccion, trim(status) as status from $this->schema.$this->tabla";   
            $this->aplicar_filtros([$sql, $args, 0, false]);
        }
    }
?>

