<?php
    require('../clases/ppal.class.php');
    
    class Model extends ppal {

        public $schema ='miscelaneos';
        public $tabla = 'monedas';

        public $filtroMapa = [
            0 => "status = '?'",
            1 => "status = '?'"
        ];

        public function cargarMonedas($args) {

            $sql = "select id_moneda, trim(nombre) as nombre, conver, trim(unidad) as unidad, trim(status) as status, conver_p from $this->schema.$this->tabla where status='A' order by id_moneda desc limit 800";
                return $this->seleccionar($sql, $args);
        }


        public function buscarMonedas($args) {
            $busqueda = $args[0];

            if (ctype_digit($busqueda)) {
                $tra = "or id_moneda = ".(int)$busqueda;
            } else {
                $tra = '';
            }

            $sql = "select id_moneda, trim(nombre) as nombre, conver, trim(unidad) as unidad, trim(fijo) as fijo, trim(status) as status, conver_p from $this->schema.$this->tabla where status='A' and nombre like '%'|| UPPER('$busqueda') ||'%' $tra order by id_moneda limit 8000";
                return $this->seleccionar($sql, []);
        }

        public function crearMonedas($args){

            $resultado = ($this->i_pdo("select id_moneda from $this->schema.$this->tabla where nombre = upper(trim('$args[0]')) limit 1", [], true))->fetchColumn();

            if(empty($resultado)) {
                $sql = "insert into $this->schema.$this->tabla(nombre, unidad, conver, conver_p, status) VALUES(
                    trim(upper(?)), 
                    trim(upper(?)),
                    ?,
                    ?,   
                    'A')";
            return $this->insertar($sql, $args);
            } else {
                return "repetido";
            }

        }

        public function actualizarMonedas($args) { 
            $resultado = ($this->i_pdo("select id_moneda from $this->schema.$this->tabla where nombre = upper(trim('$args[0]')) and id_moneda != $args[5] limit 1", [], true))->fetchColumn();

            if(empty($resultado)) {
                $sql = "update $this->schema.$this->tabla set nombre = trim(upper(?)), unidad = trim(upper(?)), conver = ?, conver_p = ?, status =trim (upper(?)) where id_moneda = ?";
                return $this->actualizar($sql, $args); 
            } else {
                return "repetido";
            }         
        }

        //--------------------------------------------------------------
        //--------------------------------------------------------------
        public function traerMoneda($args){     
            $sql = "select * from $this->schema.$this->tabla where id_moneda = ?";
            return $this->seleccionar($sql, $args);
        }   

        public function filtrar($args) {
            $sql = "select id_moneda, trim(nombre) as nombre, conver, trim(unidad) as unidad, trim(status) as status, conver_p from $this->schema.$this->tabla";   
            $this->aplicar_filtros([$sql, $args, 0, false]);
        }
    }
?>