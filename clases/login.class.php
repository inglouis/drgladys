<?php
	require_once("../clases/ppal.class.php");
	
	class Model extends ppal 
	{
		function iniciar($args) {

			$usuario  = $args[0];

			if (!empty($usuario)) {

				$datos = $this->i_pdo("select * from miscelaneos.usuarios WHERE usuario = trim(upper(?))", [$usuario], true)->fetch(PDO::FETCH_ASSOC);

				if (gettype($datos) == 'array') {

					$resultado = $this->i_pdo("update miscelaneos.usuarios set cookie = ? where id_usuario = ?", [$_COOKIE['se_cookie'], $datos['id_usuario']], true);

					$_SESSION['usuario'] = $datos;

					echo "exito";	
									
				} else {

					echo "usuario";

				} 	 
			}

		}

	}
	
?>