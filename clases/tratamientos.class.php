<?php
    require('../clases/ppal.class.php');
    
    class Model extends ppal {

        public $schema ='historias';
        public $tabla = 'tratamientos';

        public $filtroMapa = [
            0 => "a.status = '?'",
            1 => "a.status = '?'"
        ];
        
        public function cargarTratamientos($args) {
            $sql = "
                select * from historias.tratamientos as a
                inner join historias.medicamentos as b using (id_medicamento)
                where a.status = 'A' order by a.id_tratamiento desc limit 8000
            ";
            return $this->seleccionar($sql, $args);
        }


        public function buscarTratamientos($args) {
            $busqueda = $args[0];

            if (ctype_digit($busqueda)) {
                $tra = "or a.id_tratamiento = ".(int)$busqueda;
            } else {
                $tra = '';
            }

            $sql = "select * from historias.tratamientos as a
                inner join historias.medicamentos as b using (id_medicamento) 
                where a.status='A' and a.tratamientos::text like '%'|| UPPER('$busqueda') ||'%' 
                or a.status='A' and b.nombre like '%'|| UPPER('$busqueda') ||'%' 
                $tra order by id_tratamiento limit 8000";
                return $this->seleccionar($sql, []);
        }

        public function crearTratamientos($args){

            $tratamientos = &$args[1];

            foreach ($tratamientos as &$r ) {
                $r = strtoupper($r['tratamiento']);
            }

            $tratamientos = json_encode($tratamientos);

            $resultado = ($this->i_pdo("select id_tratamiento from historias.tratamientos where id_medicamento = $args[0] limit 1", [], true))->fetchColumn();

            if(empty($resultado)) {
                $sql = "insert into $this->schema.$this->tabla(id_medicamento, tratamientos, status) VALUES(?, ?::json, 'A')";
                $resultado = $this->insertar($sql, $args);

                if(trim($resultado) == 'exito') {
                    return 'exito';
                } else {
                    return "ERROR".$resultado;
                }

            } else {
                return "repetido";
            }
        }

        public function actualizarTratamientos($args) { 
            unset($args[0]);
            $args = array_values($args);

            $tratamientos = &$args[1];

            foreach ($tratamientos as &$r ) {
                $r = strtoupper($r['tratamiento']);
            }

            $tratamientos = json_encode($tratamientos);

            //print_r($args);

            $sql = "update $this->schema.$this->tabla set status = trim(upper(?)), tratamientos = ?::json where id_tratamiento = ?";
            $resultado = $this->actualizar($sql, $args); 

            if(trim($resultado) == 'exito') {
                return 'exito';
            } else {
                return "ERROR".$resultado;
            }         
        }

        public function eliminaTratamiento($args){    
           $sql ="delete from $this->schema.$this->tabla where id_tratamiento = ?";
           return $this->eliminar($sql, $args);
        }
        //--------------------------------------------------------------
        //--------------------------------------------------------------
        public function traerTratamiento($args){     
            $sql = "select * from $this->schema.$this->tabla where id_tratamiento = ?";
            return $this->seleccionar($sql, $args);
        }   

        public function filtrar($args) {
            $sql = "select * from historias.tratamientos as a
                inner join historias.medicamentos as b using (id_medicamento)";   
            $this->aplicar_filtros([$sql, $args, 0, false]);
        }

        public function comboMedicamentos ($args) {
            $sql = "select id_medicamento, concat(id_medicamento,' || ', nombre), status from historias.medicamentos where id_medicamento not in (select id_medicamento from historias.tratamientos) and status = 'A' order by id_medicamento asc";
            return $this->seleccionar($sql, []);
        }
    }
?>

