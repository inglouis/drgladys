<?php
    require('../clases/ppal.class.php');
    class Model extends ppal {
       
        public function combo_ocupacion($args) {
            $sql = "select id_ocupacion, concat(id_ocupacion,' || ', nombre) from basicas.ocupaciones";
            return $this->combos($args, [$sql, 'nombre', 'nombre ASC', '']);
        }

        public function combo_ocupaciones($args) {
            $sql = "select id_ocupacion, concat(id_ocupacion,' || ', nombre) from basicas.ocupaciones";
            return $this->combos($args, [$sql, 'nombre', 'nombre ASC', '']);
        }

        public function combo_ocupacion_buscar($args) {
            $sql = "select id_ocupacion, concat(id_ocupacion,' || ', nombre) from basicas.ocupaciones where id_ocupacion = ?";
            return $this->seleccionar($sql, $args);
        }

        public function combo_diagnosticos($args) {
            $sql = "select id_diagnostico, concat(id_diagnostico,' || ', nombre) from basicas.diagnosticos";
            return $this->combos($args, [$sql, 'nombre', 'id_diagnostico ASC', '']);
        }

        public function combo_proveniencias($args) {
            $sql = "select id_proveniencia, concat(id_proveniencia,' || ', nombre) from basicas.proveniencias";
            return $this->combos($args, [$sql, 'nombre', 'nombre ASC', '']);
        }

        public function combo_medicos($args) {
            $sql = "select id_medico, concat(id_medico,' || ', nombres_apellidos) from basicas.medicos";
            return $this->combos($args, [$sql, 'nombres_apellidos', 'nombres_apellidos ASC', '']);
        }

        public function combo_parentescos($args) {
            $sql = "select id_parentesco, concat(id_parentesco,' || ', nombre) from basicas.parentescos";
            return $this->combos($args, [$sql, 'nombre', 'nombre ASC', '']);
        }

        public function combo_estados_civiles($args) {
            $sql = "select id_estado_civil, concat(id_estado_civil,' || ', nombre) from basicas.estado_civil";
            return $this->combos($args, [$sql, 'nombre', 'nombre ASC', '']);
        }

        public function combo_religiones($args) {
            $sql = "select id_religion, concat(id_religion,' || ', nombre) from basicas.religiones";
            return $this->combos($args, [$sql, 'nombre', 'nombre ASC', '']);
        }

    }
?>

