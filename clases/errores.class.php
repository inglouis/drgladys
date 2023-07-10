<?php
    require('../clases/ppal.class.php');
    class Model extends ppal {
        public $schema ='miscelaneos';
        public $tabla = 'logsphp';

        public function parches() {
            //('{\"titulo\":\"'||titulo||'\", \"descripcion\": \"'||descripcion||'\"}')::json as parches
            

            $datos = $this->e_pdo($sql);
            $resultado = json_encode($datos->fetchAll(PDO::FETCH_ASSOC));

            return $resultado;
        }
     
        public function cargarErrores($args) {
            //$sql = "select titulo, descripcion, fecha from web.parches order by codi_parche desc";
            $sql = "select * from $this->schema.$this->tabla order by id_error desc limit 8000";
                return $this->seleccionar($sql, $args);
        }

        public function buscarErrores($args) {
            $busqueda = $args[0];

            if (is_numeric($busqueda) || gettype($busqueda) == 'integer' || ctype_digit($busqueda)) {
                $conc = "or id_error = ".(int)$busqueda;
            } else {
                $conc = '';
            }

            $sql = "select * from $this->schema.$this->tabla where mensaje_php like '%'|| UPPER('$busqueda') ||'%' $conc order by id_error DESC limit 8000";
                return $this->seleccionar($sql, []);
        }

        //--------------------------------------------------------------
        //--------------------------------------------------------------

        public function eliminarError($args) {

        	$this->i_pdo("delete from $this->schema.$this->tabla where id_error = ?", $args, false);

        }
    }
?>


