<?php 
	require_once('clases/mantenimiento.class.php');
	//--------------------------------------------------
	//URL
	//--------------------------------------------------
	$url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	if (empty($_GET['mantenimiento'])) {$mantenimiento = '';} else {$mantenimiento = $_GET['mantenimiento'];} 
	//--------------------------------------------------
	if (empty($mantenimiento)) {
		header('HTTP/1.0 403 Forbidden');
		echo 'Acceso denegado';
		exit();
	} else {
		if (strpos($mantenimiento, $url) !== false) {
			header('HTTP/1.0 403 Forbidden');
			echo 'Acceso denegado';
			exit();
		}	
	}
	//--------------------------------------------------
?>
<!DOCTYPE html>
<html>
<head>	
	<meta http-equiv="contet-Type" content="text/html" charset="utf-8">
	<meta name="viewport" user-scalable="no" maximum-scale="5" content="width=device-width, initial-scale=1"/>
	<link   rel="shortcut icon" href="css/svg/wrench-solid.svg">
	<link   type="text/css" rel="stylesheet" href="css/Stylesheet.css">
	<script type="text/javascript">window.e = '<?php echo $mantenimiento;?>'</script>
	<script src="../scripts/jquery-3.5.1.js"></script>
	<script type="module" src="/scripts/mantenimiento.js"></script>
	<title>Mantenimiento</title>
	<style type="text/css">
		body {
		    display: flex;
		    flex-direction: column;
		    height: 100%;
		    justify-content: center;
		    width: 100%;
		    align-items: center;
		}
	</style>
</head>
<body>
	<div id="mantenimiento" style="display: flex; flex-direction: column; justify-content: center;">
		<div id="mantenimiento-contenedor">
			<svg id="mantenimiento-imagen" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="tools" class="svg-inline--fa fa-tools fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="#262626" d="M501.1 395.7L384 278.6c-23.1-23.1-57.6-27.6-85.4-13.9L192 158.1V96L64 0 0 64l96 128h62.1l106.6 106.6c-13.6 27.8-9.2 62.3 13.9 85.4l117.1 117.1c14.6 14.6 38.2 14.6 52.7 0l52.7-52.7c14.5-14.6 14.5-38.2 0-52.7zM331.7 225c28.3 0 54.9 11 74.9 31l19.4 19.4c15.8-6.9 30.8-16.5 43.8-29.5 37.1-37.1 49.7-89.3 37.9-136.7-2.2-9-13.5-12.1-20.1-5.5l-74.4 74.4-67.9-11.3L334 98.9l74.4-74.4c6.6-6.6 3.4-17.9-5.7-20.2-47.4-11.7-99.6.9-136.6 37.9-28.5 28.5-41.9 66.1-41.2 103.6l82.1 82.1c8.1-1.9 16.5-2.9 24.7-2.9zm-103.9 82l-56.7-56.7L18.7 402.8c-25 25-25 65.5 0 90.5s65.5 25 90.5 0l123.6-123.6c-7.6-19.9-9.9-41.6-5-62.7zM64 472c-13.2 0-24-10.8-24-24 0-13.3 10.7-24 24-24s24 10.7 24 24c0 13.2-10.7 24-24 24z"></path></svg>
		</div>
		<section id="mantenimiento-mensaje" align="center">
			<span>Página en mantenimiento</span>
		</section>

		<div style="display:none;">
			<p>Iniciar Sesión</p>
			<input type="text" name="corusi" id="mantenimiento-corusi" maxlength=80 placeholder="Usuario o Correo" title="Usuario">
			<input type="password" name="clave" id="mantenimiento-clave" maxlength=40 placeholder="Contraseña" title="Contraseña">
			<button name="mantenimiento-iniciar" id="mantenimiento-iniciar">Iniciar Sesión</button>
			<div id="mantenimiento-avisos"></div>
		</div>
	</div>
	<input type="hidden" name="estado" id="estado" value="false">
</body>
</html>