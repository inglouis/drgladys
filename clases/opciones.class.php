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

?>