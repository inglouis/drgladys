<?php
    require('../clases/ppal.class.php');
    class Model extends ppal {
        public $schema ='historias';
        public $tabla = 'medicamentos';
        public $filtroMapa = [
            0 => "status = '?'",
            1 => "status = '?'"
        ];
  
        public function cargarMedicamentos($args) {
            $sql = "select id_medicamento, trim(nombre) as nombre, genericos, trim(status) as status from $this->schema.$this->tabla where status='A' order by nombre asc limit 8000";
            return $this->seleccionar($sql, $args);
        }


        public function buscarMedicamentos($args) {
            $busqueda = $args[0];

            if (is_numeric($busqueda) || gettype($busqueda) == 'integer' || ctype_digit($busqueda)) {
                $conc = "or id_medicamento = ".(int)$busqueda;
            } else {
                $conc = '';
            }

            $sql = "select id_medicamento, trim(nombre) as nombre, genericos, trim(status) as status from $this->schema.$this->tabla where status='A' and nombre like '%'|| UPPER('$busqueda') ||'%' $conc order by id_medicamento DESC limit 8000";
            return $this->seleccionar($sql, []);
        }

        public function crearMedicamentos($args){     

            $genericos = &$args[1];

            foreach ($genericos as &$r) {
                $r = $r['id'];
            }

            $genericos = json_encode($genericos);

            //$resultado = ($this->i_pdo("select id_medicamento from $this->schema.$this->tabla where nombre = upper(trim('$args[0]')) limit 1", [], true))->fetchColumn();

            //if(empty($resultado)) {
                $sql = "insert into $this->schema.$this->tabla(nombre, genericos, status) VALUES(
                        trim(upper(?)), 
                        ?::json, 
                        'A'
                    ) returning id_medicamento";
                $id =  $this->insertar($sql, $args)[0]['id_medicamento'];

                if(is_numeric($id)) {
                    $sql = "insert into historias.presentaciones(id_medicamento, presentaciones, status) VALUES($id, '[]'::json, 'A')";

                    $resultado = $this->insertar($sql, []);

                    if(trim($resultado) == 'exito') {

                        $sql = "insert into historias.tratamientos(id_medicamento, tratamientos, status) VALUES($id, '[]'::json, 'A')";

                        $resultado = $this->insertar($sql, []);

                        if(trim($resultado) == 'exito') {
                            return 'exito';
                        }
                    }
                }
            //} else {
            //    return "repetido";
            //}
        }

        public function actualizarMedicamentos($args) { 
            
            $genericos = &$args[1];
            
            foreach ($genericos as &$r) {
                $r = $r['id'];
            }

            $genericos = json_encode($genericos);

            $resultado = ($this->i_pdo("select id_medicamento from $this->schema.$this->tabla where nombre = upper(trim('$args[0]')) and id_medicamento != $args[3] limit 1", [], true))->fetchColumn();


            if(empty($resultado)) {
                $sql = "update $this->schema.$this->tabla set nombre = trim(upper(?)), genericos = ?::json, status = trim(upper(?)) where id_medicamento = ?";
                return $this->actualizar($sql, $args); 
            } else {
                return "repetido";
            }
                    
        }

        public function eliminaMedicamento($args){    
           $sql ="delete from $this->schema.$this->tabla where id_medicamento = ?";
           return $this->eliminar($sql, $args);
        }
        //--------------------------------------------------------------
        //--------------------------------------------------------------
        public function traerMedicamento($args){     
            $sql = "select * from $this->schema.$this->tabla where id_medicamento = ?";
            return $this->seleccionar($sql, $args);
        } 

        public function filtrar($args) {
            $sql = "select id_medicamento, trim(nombre) as nombre, genericos, trim(status) as status from $this->schema.$this->tabla";   
            $this->aplicar_filtros([$sql, $args, 0, false, 'DESC', '8000']);
        }

        public function comboGenericos($args) {
            $sql = "select id_generico, nombre from historias.genericos";
            echo $this->combos($args, [$sql, 'nombre', 'id_generico']);
        }

        public function estandarGenericos($args) {
            $genericos = '';
            foreach ($args as $r) {$genericos.= $r.',';}
            $genericos = substr($genericos, 0, strlen($genericos) - 1);

            if(strlen($genericos) > 0) {
                $lista = [];
                $resultado = $this->e_pdo("select id_generico, nombre from historias.genericos where id_generico in ($genericos)")->fetchAll(PDO::FETCH_ASSOC);

                foreach ($resultado as $i => &$r) {
                    $lista[$i] = array(
                        "id_generico" => $r['id_generico'],
                        "nombre" => $r['nombre']
                    );
                }

                $args = $lista;

            } else {
                $args = [];
            }   

            return json_encode($args);
        } 

        /*-------------------------------------ELOY-------------------------------------*/

        //-----------------------------------------------------------------------------------------
        /*public function cargarMedicamentos() {
            return $this->seleccionar("select id_medicamento as id, nombre, genericos from historias.medicamentis", []);
        }*/
    }
?>

