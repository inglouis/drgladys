<?php
    require('../clases/ppal.class.php');
    class Model extends ppal {
        public $schema ='miscelaneos';
        public $tabla = 'iva';
        public $filtroMapa = [
            0 => "status = '?'",
            1 => "status = '?'"
        ];
        //--------------------------------------------------------------
        //--------------------------------------------------------------
        public function cargarIva($args) {
            $sql = "select id_iva, porcentaje, TO_CHAR(fecha :: DATE, 'dd-mm-yyyy') as fecha, defecto, trim(status) as status, case when defecto = 1 then 'SI' else 'NO' end as defecto_procesado from $this->schema.$this->tabla where status='A' order by id_iva DESC limit 8000";
                return $this->seleccionar($sql, $args);
        }

        //--------------------------------------------------------------
        //--------------------------------------------------------------
        public function buscarIva($args) {
            $busqueda = $args[0];

            if (is_numeric($busqueda) || gettype($busqueda) == 'integer' || ctype_digit($busqueda)) {
                $conc = "or id_iva = ".(int)$busqueda;
            } else {
                $conc = '';
            }

            $sql = "select id_iva, porcentaje, TO_CHAR(fecha :: DATE, 'dd-mm-yyyy') as fecha, defecto, trim(status) as status from $this->schema.$this->tabla where status='A' and porcentaje like '%'|| UPPER('$busqueda') ||'%' $conc order by id_iva DESC limit 8000";
                return $this->seleccionar($sql, []);
        }
        //--------------------------------------------------------------
        //--------------------------------------------------------------
        public function crearIva($args){

            $resultado = ($this->i_pdo("select id_iva from $this->schema.$this->tabla where porcentaje = $args[0] limit 1", [], true))->fetchColumn();

            if(empty($resultado)) {

                $sql = "select ppal.insertar_iva(?, ?)";
                $resultado = $this->i_pdo($sql, $args, true)->fetchColumn();

                if($resultado == 1) {
                    return 'exito';
                } else {
                    return 'ERROR:'.$resultado;
                }
            } else {
                return "repetido";
            }
        }
        //--------------------------------------------------------------
        //--------------------------------------------------------------
        public function actualizarIva($args) { 

            $resultado = ($this->i_pdo("select id_iva from $this->schema.$this->tabla where porcentaje = $args[0] and id_iva != $args[3] limit 1", [], true))->fetchColumn();

            if(empty($resultado)) {

                $sql = "select ppal.editar_iva(?, ?, ?, ?)";
                $resultado = $this->i_pdo($sql, $args, true)->fetchColumn();

                if($resultado == 1) {
                    return 'exito';
                } else {
                    return 'ERROR:'.$resultado;
                }
            } else {
                return "repetido";
            }
        }
        //--------------------------------------------------------------
        //--------------------------------------------------------------
        public function eliminarIva($args){    
           $sql ="delete from $this->schema.$this->tabla where id_iva = ?";
           return $this->eliminar($sql, $args);
        }
        //--------------------------------------------------------------
        //--------------------------------------------------------------
        public function traerIva($args){     
            $sql = "select * from $this->schema.$this->tabla where id_iva = ?";
            return $this->seleccionar($sql, $args);
        }   
        //--------------------------------------------------------------
        //--------------------------------------------------------------
        public function filtrar($args) {
            $sql = "select id_iva, porcentaje, TO_CHAR(fecha :: DATE, 'dd-mm-yyyy') as fecha, defecto, trim(status) as status from $this->schema.$this->tabla";   
            $this->aplicar_filtros([$sql, $args, 0, false, 'DESC', '8000']);
        }
    }
?>

