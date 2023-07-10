<?php
    require('../clases/ppal.class.php');
    class Model extends ppal {
        public $schema ='facturacion';
        public $tabla = 'modelos';
        public $filtroMapa = [
            0 => "status = '?'",
            1 => "status = '?'"
        ];
     
        public function cargarModelo($args) {
            $sql = "select id_modelo, trim(nombre) as nombre, cantidad, costo_dolares, trim(status) as status from $this->schema.$this->tabla where status='A' order by id_modelo DESC limit 8000";
                return $this->seleccionar($sql, $args);
        }

        public function buscarModelo($args) {
            $busqueda = $args[0];

            if (is_numeric($busqueda) || gettype($busqueda) == 'integer' || ctype_digit($busqueda)) {
                $conc = "or id_modelo = ".(int)$busqueda;
            } else {
                $conc = '';
            }

            $sql = "select id_modelo, trim(nombre) as nombre, cantidad, costo_dolares, trim(status) as status from $this->schema.$this->tabla where status='A' and nombre like '%'|| UPPER('$busqueda') ||'%' $conc order by id_modelo DESC limit 8000";
                return $this->seleccionar($sql, []);
        }

        public function crearModelo($args){

            $resultado = ($this->i_pdo("select id_modelo from $this->schema.$this->tabla where nombre = upper(trim('$args[0]')) limit 1", [], true))->fetchColumn();

            if(empty($resultado)) {
                $sql = "insert into $this->schema.$this->tabla(id_modelo, nombre, cantidad, costo_dolares, status) VALUES(default, trim(upper(?)), ?, ?, 'A') returning id_modelo";
                $id_modelo = $this->insertar($sql, $args)[0]['id_modelo'];

                if(!empty($id_modelo)) {

                    $sql = "select ppal.nuevo_modelo_paquetes(?)";
                    $resultado = $this->insertar($sql, [$id_modelo]);

                    if(trim($resultado) == 'exito') {
                        return 'exito';
                    } else {
                        return 'error'.$resultado;
                    }

                } else {
                    return 'error'.$resultado;
                }
            } else {
                return "repetido";
            }
        }

        public function actualizarModelo($args) { 
            $resultado = ($this->i_pdo("select id_modelo from $this->schema.$this->tabla where nombre = upper(trim('$args[0]')) and id_modelo != $args[4] limit 1", [], true))->fetchColumn();

            if(empty($resultado)) {
                $sql = "update $this->schema.$this->tabla set nombre = trim(upper(?)), cantidad = ?, costo_dolares = ?, status = trim(upper(?)) where id_modelo = ?";
                return $this->actualizar($sql, $args); 
            } else {
                return "repetido";
            }
                    
        }

        public function actualizarModeloMasivo($args) {
            $procesado = true;

            $resultado = $this->actualizar("select ppal.actualizacion_masiva_modelos_montos(?)", [json_encode($args[0])]);
            if($resultado !== 'exito') {$procesado = false;}

            if ($procesado) {
                return 'exito';
            } else {
                return 'error';
            }
        }

        public function eliminaModelo($args){    
           $sql ="delete from $this->schema.$this->tabla where id_modelo = ?";
           return $this->eliminar($sql, $args);
        }
        //--------------------------------------------------------------
        //--------------------------------------------------------------
        public function traerModelo($args){     
            $sql = "select * from $this->schema.$this->tabla where id_modelo = ?";
            return $this->seleccionar($sql, $args);
        }   

        public function filtrar($args) {
            $sql = "select id_modelo, trim(nombre) as nombre, cantidad, costo_dolares, trim(status) as status from $this->schema.$this->tabla";   
            $this->aplicar_filtros([$sql, $args, 0, false, 'DESC', '8000']);
        }
    }
?>

