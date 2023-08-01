<?php 

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

	if (!isset($_SESSION['informacion_pie_pagina_reportes_1'])) {

		$_SESSION['informacion_pie_pagina_reportes_1'] = 'Centro comercial El Pinar, nivel Las Acacias, Local AE-1. J-16541912-6';
		$_SESSION['informacion_pie_pagina_reportes_2'] = '0424-7462907 - 04247828603';
		$_SESSION['informacion_pie_pagina_reportes_3'] = '@ros_dermatologa';

	}

	//envio masivo de datos a pdf
	//------------------------------------------------
	if (!isset($_SESSION['datos_pdf'])) {

		$_SESSION['datos_pdf'] = '';

	} 

	//modo minimalista
	//------------------------------------------------
	if (!isset($_SESSION['modo_minimalista'])) {

		$_SESSION['modo_minimalista'] = 1;

	}

	if ($_SESSION['modo_minimalista'] == 1) {
		$dispararModos .= "document.querySelector('body').setAttribute('data-minimalista', '');
		";
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

		$_SESSION['modo_filas'] = 14;

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
			'
		);
	}
?>