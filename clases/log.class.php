<?php function manejador_error($nivel, $mensaje, $archivo, $linea) {
	global $objeto;
	switch ($nivel){
		case 2:
			$str = "ADVERTENCIA" ;
			break;
		case 8:
			$str = "NOTIFICACIÓN: VARIABLE INDEFINIDA";
			break;	
		case 256:
			$str = "ERROR GENERADO POR EL USUARIO: FATAL";
			break;	
		case 512:
			$str = "ERROR NO GENERAR POR EL USUARIO: NO FATAL";
			break;	
		default:
			$str = "";	
	}
	//********************************************************************************
	echo "
	<style>
		.error {width: fit-content;display: flex;justify-content: center;position:relative;z-index:1}
		.error-contenedor {max-width:600px;width:100%;display: flex !important;flex-direction: column !important;padding: 10px;margin-top: 10px;box-shadow: 1px 1px 10px lightgrey;background-color: #fff;transition: 0.3s ease all;}
		.error-contenedor span  p {margin:2px;display: flex;font-size: 16px;justify-content: center;transition: 0.3s ease all;}
		.error-contenedor span p:hover {transition: 0.3s ease all;background-color: rgba(0,0,0,0.1);box-sizing: border-box;}
		.error-contenedor:hover {transform: scale(1.05);transition: 0.3s ease all;outline-color: crimson;outline-style:solid;outline-width: 2px;}
		.error-titulo {margin:0px;font-size: 28px;}
	</style>

	<div class=\"error\">
		<div class=\"error-contenedor\">
			<h1 style='text-align:center' class=\"error-titulo\">$str</h1>
			<span class=\"error-nivel\"><p>Error de tipo: $nivel</p></span>
			<span class=\"error-mensaje\"><p>$mensaje</p></span>
			<span style='overflow-wrap: break-word; text-align: center;' class=\"error-archivo\">$archivo</span>
			<span class=\"error-linea\"><p>En la línea: $linea </p></span>
		</div>
	</div>
	";
  	$sql = "insert into miscelaneos.logsphp(mensaje_personalizado,codigo_error,mensaje_php,ruta_error,linea_error,fecha_error, hora) values(?,?,?,?,?, current_date, current_time)";
	$objeto->i_pdo($sql, [$str, $nivel, $mensaje, $archivo, $linea], false);
}

function manejador_excepcion($e) {
	global $objeto;
	$nivel = $e->getCode();  $mensaje = $e->getMessage();  $archivo = $e->getFile();
	$linea = $e->getLine();  $trace = $e->getTrace();
	$error = "
	<style>
		.error {width: fit-content;display: flex;justify-content: center;position:relative;z-index:1}
		.error-contenedor {max-width:600px;width:100%;display: flex !important;flex-direction: column !important;padding: 10px;margin-top: 10px;box-shadow: 1px 1px 10px lightgrey;background-color: #fff;transition: 0.3s ease all;}
		.error-contenedor span  p {margin:2px;display: flex;font-size: 16px;justify-content: center;transition: 0.3s ease all;}
		.error-contenedor span p:hover {transition: 0.3s ease all;background-color: rgba(0,0,0,0.1);box-sizing: border-box;}
		.error-contenedor:hover {transform: scale(1.05);transition: 0.3s ease all;outline-color: crimson;outline-style:solid;outline-width: 2px;}
		.error-titulo {margin:0px;font-size: 28px;}
	</style>
	<div class=\"error\">
		<div class=\"error-contenedor\">
			<h1 style='text-align:center' class=\"error-titulo\">EXCEPCIÓN</h1>
			<span class=\"error-nivel\"><p>Error de tipo: $nivel</p></span>
			<span class=\"error-mensaje\"><p>$mensaje</p></span>
			<span style='overflow-wrap: break-word; text-align: center;' class=\"error-archivo\">$archivo</span>
			<span class=\"error-linea\"><p>En la línea: $linea </p></span>
		</div>
	</div>
	";
	foreach ($trace as $r) {$error .= "<div></div>";}//hacer el mensaje del recorrido de una expcepcion
	echo $error;
	$sql = "insert into miscelaneos.logsphp(mensaje_personalizado,codigo_error,mensaje_php,ruta_error,linea_error,fecha_error, hora, recorrido_error) values(?,?,?,?,?, current_date, current_time, ?)";
	$objeto->i_pdo($sql, ['EXCEPCION', $nivel, $mensaje, $archivo, $linea, json_encode($trace)], false);
}

function mensajeFatal() {
    $error = error_get_last();
    if ( $error["type"] == E_ERROR )
        manejador_error($error["type"], $error["message"], $error["file"], $error["line"] );
}

//--REACTIVAR AL TERMINAR DE PROGRAMAR

// register_shutdown_function("mensajeFatal");
// set_error_handler('manejador_error');
// set_exception_handler("manejador_excepcion");

//-------------------------------------------------------------------
//-------------------------------------------------------------------
//-------------------------------------------------------------------
//-------------------------------------------------------------------
//-------------------------------------------------------------------
//-------------------------------------------------------------------
//-------------------------------------------------------------------
//-------------------------------------------------------------------
//-------------------------------------------------------------------
//-------------------------------------------------------------------
//-------------------------------------------------------------------
//-------------------------------------------------------------------
//AGREGAR LOGS TXT CUANDO EL ESPACIO NO SEA UN PROBLEMA
// /**
// * Error handler, passes flow over the exception logger with new ErrorException.
// */
// function log_error( $num, $str, $file, $line, $context = null )
// {
//     log_exception( new ErrorException( $str, 0, $num, $file, $line ) );
// }

// /**
// * Uncaught exception handler.
// */
// function log_exception( Exception $e )
// {
//     global $config;
   
//     if ( $config["debug"] == true )
//     {
//         print "<div style='text-align: center;'>";
//         print "<h2 style='color: rgb(190, 50, 50);'>Exception Occured:</h2>";
//         print "<table style='width: 800px; display: inline-block;'>";
//         print "<tr style='background-color:rgb(230,230,230);'><th style='width: 80px;'>Type</th><td>" . get_class( $e ) . "</td></tr>";
//         print "<tr style='background-color:rgb(240,240,240);'><th>Message</th><td>{$e->getMessage()}</td></tr>";
//         print "<tr style='background-color:rgb(230,230,230);'><th>File</th><td>{$e->getFile()}</td></tr>";
//         print "<tr style='background-color:rgb(240,240,240);'><th>Line</th><td>{$e->getLine()}</td></tr>";
//         print "</table></div>";
//     }
//     else
//     {
//         $message = "Type: " . get_class( $e ) . "; Message: {$e->getMessage()}; File: {$e->getFile()}; Line: {$e->getLine()};";
//         file_put_contents( $config["app_dir"] . "/tmp/logs/exceptions.log", $message . PHP_EOL, FILE_APPEND );
//         header( "Location: {$config["error_page"]}" );
//     }
   
//     exit();
// }

// /**
// * Checks for a fatal error, work around for set_error_handler not working on fatal errors.
// */
// function check_for_fatal()
// {
//     $error = error_get_last();
//     if ( $error["type"] == E_ERROR )
//         log_error( $error["type"], $error["message"], $error["file"], $error["line"] );
// }

// register_shutdown_function( "check_for_fatal" );
// set_error_handler( "log_error" );
// set_exception_handler( "log_exception" );
// ini_set( "display_errors", "off" );
// error_reporting( E_ALL );

?>