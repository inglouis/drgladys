<?php
    require('../clases/ppal.class.php');
    
    class Model extends ppal {

        public $schema ='basicas';
        public $tabla = 'tratamientos';

        public $filtroMapa = [
            0 => "a.status = '?'",
            1 => "a.status = '?'"
        ];
        
        public function cargar_tratamientos($args) {
            $sql = "
                select * from $this->schema.$this->tabla as a
                inner join $this->schema.medicamentos as b using (id_medicamento)
                where a.status = 'A' order by a.id_tratamiento desc limit 8000
            ";
            return $this->seleccionar($sql, $args);
        }


        public function buscar_tratamientos($args) {
            $busqueda = $args[0];

            if (ctype_digit($busqueda)) {
                $tra = "or a.id_tratamiento = ".(int)$busqueda;
            } else {
                $tra = '';
            }

            $sql = "select * from $this->schema.$this->tabla as a
                inner join $this->schema.medicamentos as b using (id_medicamento) 
                where a.status='A' and a.tratamientos::text like '%'|| UPPER('$busqueda') ||'%' 
                or a.status='A' and b.nombre like '%'|| UPPER('$busqueda') ||'%' 
                $tra order by id_tratamiento limit 8000";
                return $this->seleccionar($sql, []);
        }

        public function crear_tratamientos($args){

            $tratamientos = &$args[1];

            foreach ($tratamientos as &$r ) {
                $r = strtoupper($r['tratamiento']);
            }

            $tratamientos = json_encode($tratamientos);

            $resultado = ($this->i_pdo("select id_tratamiento from basicas.tratamientos where id_medicamento = $args[0] limit 1", [], true))->fetchColumn();

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

        public function actualizar_tratamientos($args) { 

            unset($args[0]);
            $args = array_values($args);
            $tratamientos = &$args[1];

            foreach ($tratamientos as &$r ) {
                $r = strtoupper($r['tratamiento']);
            }

            $tratamientos = json_encode($tratamientos);

            $sql = "update $this->schema.$this->tabla set status = trim(upper(?)), tratamientos = ?::json where id_tratamiento = ?";
            $resultado = $this->actualizar($sql, $args); 

            if(trim($resultado) == 'exito') {
                return 'exito';
            } else {
                return "ERROR".$resultado;
            }    

        }

        public function elimina_Tratamiento($args){    
           $sql ="delete from $this->schema.$this->tabla where id_tratamiento = ?";
           return $this->eliminar($sql, $args);
        }
        //--------------------------------------------------------------
        //--------------------------------------------------------------
        public function traer_tratamiento($args){     
            $sql = "select * from $this->schema.$this->tabla where id_tratamiento = ?";
            return $this->seleccionar($sql, $args);
        }   

        public function filtrar($args) {
            $sql = "select * from historias.tratamientos as a
                inner join historias.medicamentos as b using (id_medicamento)";   
            $this->aplicar_filtros([$sql, $args, 0, false]);
        }

    }
?>

