<?php
    require('../clases/ppal.class.php');
    class Model extends ppal {
        public $schema ='basicas';
        public $tabla = 'referencias';
        public $filtroMapa = [
            0 => "status = '?'",
            1 => "status = '?'"
        ];
     
        public function cargar_referencias($args) {
            $sql = "select id_referencia, trim(nombre) as nombre, descripcion, trim(status) as status from $this->schema.$this->tabla where status='A' order by id_referencia DESC limit 8000";
                return $this->seleccionar($sql, $args);
        }

        public function traer_referencias() {

            $datos = json_decode($this->cargar_referencias([]), true);

            $nueva_lista = array();

            foreach ($datos as &$r) {
                
                $nueva_lista[$r['id_referencia']] = null;

                $nueva_lista[$r['id_referencia']] = array(
                    "nombre" => $r['nombre'],
                    "descripcion" => $r['descripcion'],
                    "status" => $r['status']
                ); 

            }

            return json_encode($nueva_lista);

        }

        public function buscar_referencias($args) {
            $busqueda = $args[0];

            if (is_numeric($busqueda) || gettype($busqueda) == 'integer' || ctype_digit($busqueda)) {
                $conc = "or id_referencia = ".(int)$busqueda;
            } else {
                $conc = '';
            }

            $sql = "select id_referencia, trim(nombre) as nombre, descripcion, trim(status) as status from $this->schema.$this->tabla where status='A' and nombre like '%'|| UPPER('$busqueda') ||'%' $conc order by id_referencia DESC limit 8000";
                return $this->seleccionar($sql, []);
        }

        public function crear_referencias($args){

            $resultado = ($this->i_pdo("select id_referencia from $this->schema.$this->tabla where nombre = upper(trim('$args[0]')) limit 1", [], true))->fetchColumn();

            if(empty($resultado)) {

                $sql = "insert into $this->schema.$this->tabla(id_referencia, nombre, descripcion, status) VALUES(default, trim(upper(?)), trim(upper(?)), 'A')";
                return $this->insertar($sql, [$args[0], $args[1]]);

            } else {
                return "repetido";
            }

            
        }

        public function actualizar_referencias($args) { 

            $resultado = ($this->i_pdo("select id_referencia from $this->schema.$this->tabla where nombre = upper(trim('$args[0]')) and id_referencia != $args[3] limit 1", [], true))->fetchColumn();

            if(empty($resultado)) {
                $sql = "update $this->schema.$this->tabla set nombre = trim(upper(?)), descripcion = trim(upper(?)), status =trim(upper(?)) where id_referencia = ?";
                return $this->actualizar($sql, $args); 
            } else {
                return "repetido";
            }
                    
        }

        public function elimina_referencia($args){    
           $sql ="delete from $this->schema.$this->tabla where id_referencia = ?";
           return $this->eliminar($sql, $args);
        }

        //--------------------------------------------------------------
        //--------------------------------------------------------------
        
        public function traer_referencia($args){     
            $sql = "select * from $this->schema.$this->tabla where id_referencia = ?";
            return $this->seleccionar($sql, $args);
        }   

        public function filtrar($args) {
            $sql = "select id_referencia, trim(nombre) as nombre, descripcion, trim(status) as status from $this->schema.$this->tabla";   
            $this->aplicar_filtros([$sql, $args, 0, false, 'DESC', '8000']);
        }
    }
?>

