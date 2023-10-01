<?php 

	//--------------------------------------------------
	//--------------------------------------------------
	// SISTEMA DE USUARIOS - DATOS
	//--------------------------------------------------

	//--------------------------------------------------
	//COOKIE & SESIÓN 

	//EXISTE GALLETA
	if (isset($_COOKIE["se_cookie"])) {

		// NO EXISTE SESION DEL USUARIO
	    if (!isset($_SESSION['usuario']) && !empty($_COOKIE["se_cookie"])) {

	 		$usuario = ($objeto->i_pdo("select * from miscelaneos.usuarios where cookie like ?;", [$_COOKIE['se_cookie']], true))->fetch(PDO::FETCH_ASSOC);

	 		if (!empty($usuario)) {

	 			$_SESSION['usuario'] = $usuario;

	 		}


	    } else if (isset($_SESSION['usuario'])) { 
	    //ESTO MANTIENE LA GALLETA ACTUALIZADA, PERO SE DISPARA A CADA QUE RECARGA O CARGA UNA PAGINA, CONSIDERAR SI DEJAR O NO
		    	
	    	$id_usuario = $_SESSION['usuario']['id_usuario'];

	    	($objeto->i_pdo("update miscelaneos.usuarios set cookie = ? where id_usuario = ?;", [$_COOKIE['se_cookie'], $id_usuario], true))->fetch(PDO::FETCH_ASSOC);

	    	$_SESSION['usuario']['cookie'] = $_COOKIE["se_cookie"];

	    }

	//NO EXISTE GALLETA
	} else {

		header('Expires: Sun, 01 Jan 2014 00:00:00 GMT');
		header('Cache-Control: no-store, no-cache, must-revalidate');
		header('Cache-Control: post-check=0, pre-check=0', FALSE);
		header('Pragma: no-cache');

		setcookie("se_cookie", bin2hex(random_bytes(4)) , time()+4*12*60*60., "/");

		//USUARIO EXISTE EN SESION Y ACTUALIZA GALLETA
		if (isset($_SESSION['usuario'])) {

			$id_usuario = $_SESSION['usuario']['id_usuario'];

			($objeto->i_pdo("update miscelaneos.usuarios set cookie = ? where id_usuario = ?;", [$_COOKIE['se_cookie'], $id_usuario], true))->fetch(PDO::FETCH_ASSOC);

		}
	}

	//--------------------------------------------------
	//EXCEPCIONES AL ACCESO DENEGADO

	$excepciones_login = array(
		'login.php',
		'login.class.php',
		'controlador.php',
		'ppal.class.php',
		'cbdc.class.php'
	); 

	$ubicacion = basename(strtok($_SERVER["REQUEST_URI"], '?'));

	if (in_array($ubicacion , $excepciones_login, true) != true) {

		if (!isset($_SESSION['usuario'])) {

		   header("Location: ../paginas/login.php?error=acceso-denegado");

		} 

		if ($_SESSION['usuario'] == false) {

		   header("Location: ../paginas/login.php?error=acceso-denegado");

		};

	};

	//bloqueo temporal de opciones equipo recepcion [quitar cuando se añada el sistema de usuarios]
	//------------------------------------------------

	// if ($_SERVER["HTTPS"] != "on") {
	//     $redirect_url = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	//     header("Location: $redirect_url");
	//     exit();
	// }

	$dispararModos = '';

	//cookie que relaciona las variables de sesion con cada dispositivo individualmente
	//------------------------------------------------
	if(!isset($_COOKIE['PHPSESSID'])) {

		session_regenerate_id();
	    setcookie("PHPSESSID", session_id(), time()+4*12*60*60., "/"); //bin2hex(random_bytes(4)) //
	    //$_COOKIE['PHPSESSID'] =  session_id();
	    
	}

	//envio masivo de datos a pdf
	//------------------------------------------------
	if (!isset($_SESSION['datos_pdf'])) {

		$_SESSION['datos_pdf'] = '';

	} 

	if (isset($_SESSION['usuario'])) {

		//modo minimalista
		//------------------------------------------------
		if (!isset($_SESSION['modo_minimalista'])) {

			$_SESSION['modo_minimalista'] = 1;

		}

		if ($_SESSION['modo_minimalista'] == 1) {
			$dispararModos .= "document.querySelector('body').setAttribute('data-minimalista', '');";
		}

		//modo noche
		//------------------------------------------------
		if (!isset($_SESSION['modo_noche'])) {

			$_SESSION['modo_noche'] = 0;

		}

		if ($_SESSION['modo_noche'] == 1) {
			$dispararModos .= "document.querySelector('body').setAttribute('data-noche', '');
			";
		}

		//modo resaltado
		//------------------------------------------------
		if (!isset($_SESSION['modo_resaltado'])) {

			$_SESSION['modo_resaltado'] = 1;

		}

		if ($_SESSION['modo_resaltado'] == 1) {
			$dispararModos .= "document.querySelector('body').setAttribute('data-resaltar', '');
			";
		}

		//modo menu
		//------------------------------------------------
		if (!isset($_SESSION['modo_menu'])) {

			$_SESSION['modo_menu'] = 1;

		}

		$dispararModos = "
			<script type=\"text/javascript\" defer>
				$dispararModos
			</script>
		";

		//modo filas
		//------------------------------------------------
		if (!isset($_SESSION['modo_filas'])) {

			if ($_SESSION['usuario']['usuario'] == 'GLADYS') {

				$_SESSION['modo_filas'] = 14;

			} else if ($_SESSION['usuario']['usuario'] == 'ANDREA') {

				$_SESSION['modo_filas'] = 14;

			} else {

				$_SESSION['modo_filas'] = 14;

			}

		}
		
	}


	//botones
	//------------------------------------------------
	if (!isset($_SESSION['botones'])) { 
		$_SESSION['botones'] = array(
			"reportes_editar" => '
				<svg class="iconos-b" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M497.9 142.1l-46.1 46.1c-4.7 4.7-12.3 4.7-17 0l-111-111c-4.7-4.7-4.7-12.3 0-17l46.1-46.1c18.7-18.7 49.1-18.7 67.9 0l60.1 60.1c18.8 18.7 18.8 49.1 0 67.9zM284.2 99.8L21.6 362.4.4 483.9c-2.9 16.4 11.4 30.6 27.8 27.8l121.5-21.3 262.6-262.6c4.7-4.7 4.7-12.3 0-17l-111-111c-4.8-4.7-12.4-4.7-17.1 0zM124.1 339.9c-5.5-5.5-5.5-14.3 0-19.8l154-154c5.5-5.5 14.3-5.5 19.8 0s5.5 14.3 0 19.8l-154 154c-5.5 5.5-14.3 5.5-19.8 0zM88 424h48v36.3l-64.5 11.3-31.1-31.1L51.7 376H88v48z"></path></svg> 
			',
			"reportes_reimprimir" => '
				<svg class="iconos-b" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M448 192V77.25c0-8.49-3.37-16.62-9.37-22.63L393.37 9.37c-6-6-14.14-9.37-22.63-9.37H96C78.33 0 64 14.33 64 32v160c-35.35 0-64 28.65-64 64v112c0 8.84 7.16 16 16 16h48v96c0 17.67 14.33 32 32 32h320c17.67 0 32-14.33 32-32v-96h48c8.84 0 16-7.16 16-16V256c0-35.35-28.65-64-64-64zm-64 256H128v-96h256v96zm0-224H128V64h192v48c0 8.84 7.16 16 16 16h48v96zm48 72c-13.25 0-24-10.75-24-24 0-13.26 10.75-24 24-24s24 10.74 24 24c0 13.25-10.75 24-24 24z"></path></svg>
			',
			"reportes_eliminar" => '
				<svg class="iconos-b" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M32 464a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128H32zm272-256a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zm-96 0a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zm-96 0a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zM432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16z"></path></svg>
			',
			"desplegable_cerrar" => '
				<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="caret-left" class="svg-inline--fa fa-caret-left fa-w-6 iconos" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 192 512"><path fill="currentColor" d="M192 127.338v257.324c0 17.818-21.543 26.741-34.142 14.142L29.196 270.142c-7.81-7.81-7.81-20.474 0-28.284l128.662-128.662c12.599-12.6 34.142-3.676 34.142 14.142z"></path></svg>
			',
			"reportes_reusar" => '
				<svg class="iconos-b" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><path fill="currentColor" d="M174.7 45.1C192.2 17 223 0 256 0s63.8 17 81.3 45.1l38.6 61.7 27-15.6c8.4-4.9 18.9-4.2 26.6 1.7s11.1 15.9 8.6 25.3l-23.4 87.4c-3.4 12.8-16.6 20.4-29.4 17l-87.4-23.4c-9.4-2.5-16.3-10.4-17.6-20s3.4-19.1 11.8-23.9l28.4-16.4L283 79c-5.8-9.3-16-15-27-15s-21.2 5.7-27 15l-17.5 28c-9.2 14.8-28.6 19.5-43.6 10.5c-15.3-9.2-20.2-29.2-10.7-44.4l17.5-28zM429.5 251.9c15-9 34.4-4.3 43.6 10.5l24.4 39.1c9.4 15.1 14.4 32.4 14.6 50.2c.3 53.1-42.7 96.4-95.8 96.4L320 448v32c0 9.7-5.8 18.5-14.8 22.2s-19.3 1.7-26.2-5.2l-64-64c-9.4-9.4-9.4-24.6 0-33.9l64-64c6.9-6.9 17.2-8.9 26.2-5.2s14.8 12.5 14.8 22.2v32l96.2 0c17.6 0 31.9-14.4 31.8-32c0-5.9-1.7-11.7-4.8-16.7l-24.4-39.1c-9.5-15.2-4.7-35.2 10.7-44.4zm-364.6-31L36 204.2c-8.4-4.9-13.1-14.3-11.8-23.9s8.2-17.5 17.6-20l87.4-23.4c12.8-3.4 26 4.2 29.4 17L182 241.2c2.5 9.4-.9 19.3-8.6 25.3s-18.2 6.6-26.6 1.7l-26.5-15.3L68.8 335.3c-3.1 5-4.8 10.8-4.8 16.7c-.1 17.6 14.2 32 31.8 32l32.2 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-32.2 0C42.7 448-.3 404.8 0 351.6c.1-17.8 5.1-35.1 14.6-50.2l50.3-80.5z"/></svg>
			',
			"reportes_modelo" => '
				<svg class="iconos-b" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><path fill="currentColor" d="M32 96l320 0V32c0-12.9 7.8-24.6 19.8-29.6s25.7-2.2 34.9 6.9l96 96c6 6 9.4 14.1 9.4 22.6s-3.4 16.6-9.4 22.6l-96 96c-9.2 9.2-22.9 11.9-34.9 6.9s-19.8-16.6-19.8-29.6V160L32 160c-17.7 0-32-14.3-32-32s14.3-32 32-32zM480 352c17.7 0 32 14.3 32 32s-14.3 32-32 32H160v64c0 12.9-7.8 24.6-19.8 29.6s-25.7 2.2-34.9-6.9l-96-96c-6-6-9.4-14.1-9.4-22.6s3.4-16.6 9.4-22.6l96-96c9.2-9.2 22.9-11.9 34.9-6.9s19.8 16.6 19.8 29.6l0 64H480z"/></svg>
			'
		);
	}
?>