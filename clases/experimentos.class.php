<?php
    require('../clases/ppal.class.php');
    
    class Model extends ppal {

    	public function imagenes($args) {

    		print_r($args);
    		print_r($_FILES);

    	}

    }
?>

