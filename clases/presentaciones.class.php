<?php
    require('../clases/ppal.class.php');
    class Model extends ppal {
        public $schema ='historias';
        public $tabla = 'presentaciones';
        public $filtroMapa = [
            0 => "a.status = '?'",
            1 => "a.status = '?'"
        ];

        public function cargarPresentaciones($args) {
            $sql = "select * from historias.presentaciones as a
                inner join historias.medicamentos as b using (id_medicamento)
                where a.status = 'A' order by a.id_presentacion desc limit 8000";
                return $this->seleccionar($sql, $args);
        }

        public function buscarPresentaciones($args) {
            $busqueda = $args[0];

            if (ctype_digit($busqueda)) {
                $conc = "or a.id_presentacion = ".(int)$busqueda;
            } else {
                $conc = '';
            }

            $sql = "select * from historias.presentaciones as a
                inner join historias.medicamentos as b using (id_medicamento) 
                where a.status='A' and a.presentaciones::text like '%'|| UPPER('$busqueda') ||'%' 
                or a.status='A' and b.nombre like '%'|| UPPER('$busqueda') ||'%'
                $conc order by a.id_presentacion limit 8000";
                return $this->seleccionar($sql, []);
        }

        public function crearPresentaciones($args){

            $presentaciones = &$args[1];

            foreach ($presentaciones as &$r ) {
                $r = $r['presentacion'];
            }

            $presentaciones = strtoupper(json_encode($presentaciones));

            $resultado = ($this->i_pdo("select id_presentacion from historias.presentaciones where id_medicamento = $args[0] limit 1", [], true))->fetchColumn();

            if(empty($resultado)) {
                $sql = "insert into $this->schema.$this->tabla(id_medicamento, presentaciones, status) VALUES(?, ?::json, 'A')";
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

        public function actualizarPresentaciones($args) { 
            unset($args[0]);
            $args = array_values($args);

            $presentaciones = &$args[1];

            foreach ($presentaciones as &$r ) {
                $r = strtoupper($r['presentacion']);
            }

            $presentaciones = json_encode($presentaciones);

            $sql = "update $this->schema.$this->tabla set status = trim(upper(?)), presentaciones = ?::json where id_presentacion = ?";
            $resultado = $this->actualizar($sql, $args); 

            if(trim($resultado) == 'exito') {
                return 'exito';
            } else {
                return "ERROR".$resultado;
            }         
        }

        //--------------------------------------------------------------
        //--------------------------------------------------------------
        public function filtrar($args) {
            $sql = "select * from historias.presentaciones as a
                inner join historias.medicamentos as b using (id_medicamento)";   
            $this->aplicar_filtros([$sql, $args, 0, false]);
        }

        public function comboMedicamentos ($args) {
            $sql = "select id_medicamento, concat(id_medicamento,' || ', nombre) from historias.medicamentos where id_medicamento not in (select id_medicamento from historias.presentaciones) and status = 'A' order by id_medicamento asc";
            return $this->seleccionar($sql, []);
        }
    }
?>

