<?php
    require('../clases/ppal.class.php');
    
    class Model extends ppal {

        public function miMetodo($args) {
        
        	$x = $args[0];

			if ($x == 1) {

				echo 12312312;


			} else {

				echo "negativo";

			}

        }

    }
?>