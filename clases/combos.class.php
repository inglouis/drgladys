<?php
    require('../clases/ppal.class.php');
    class Model extends ppal {
       
        public function combo_ocupacion($args) {
            $sql = "select id_ocupacion, concat(id_ocupacion,' || ', nombre) from historias.ocupaciones";
            return $this->combos($args, [$sql, 'nombre', 'nombre ASC', '']);
        }

        public function combo_ocupaciones($args) {
            $sql = "select id_ocupacion, concat(id_ocupacion,' || ', nombre) from historias.ocupaciones";
            return $this->combos($args, [$sql, 'nombre', 'nombre ASC', '']);
        }

        public function combo_ocupacion_buscar($args) {
            $sql = "select id_ocupacion, concat(id_ocupacion,' || ', nombre) from historias.ocupaciones where id_ocupacion = ?";
            return $this->seleccionar($sql, $args);
        }

        public function combo_diagnosticos($args) {
            $sql = "select id_diagnostico, concat(id_diagnostico,' || ', nombre) from historias.diagnosticos";
            return $this->combos($args, [$sql, 'nombre', 'id_diagnostico ASC', '']);
        }

    }
?>

