<?php
    require('../clases/ppal.class.php');
    class Model extends ppal {
        public function version () {

        	return $this->i_pdo("select version from miscelaneos.version where id_version = 1", [], true)->fetchColumn();

        }
    }
?>

