<?php

	header("Cache-control: public, max-age=31536000");
  	//header("Expires: Sat, 1 Apr 2022 05:00:00 GMT");

	ini_set('display_errors', '1');
	ini_set('display_startup_errors', '1');
	error_reporting(E_ALL);

	if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start('ob_gzhandler'); else ob_start();
	
	//$host= gethostname(); //puedo usarlo con una comparación
	//$ip = gethostbyname($host);

	//echo $ip;

	//$my_current_ip=exec("ifconfig | grep -Eo 'inet (addr:)?([0-9]*\.){3}[0-9]*' | grep -Eo '([0-9]*\.){3}[0-9]*' | grep -v '127.0.0.1'");
	//echo $my_current_ip;

	//castillo = 192.168.1.120

	class cbdc {
		private static $conexion=NULL; 

		public static function pdo_conectar(){

			$db = 'drGladys';

			try {
				$host = gethostbyname($_SERVER['SERVER_NAME']);
				$pdo_options[PDO::ATTR_ERRMODE]=PDO::ERRMODE_EXCEPTION;
				$conStr = sprintf("pgsql:host=$host options='--client_encoding=UTF8';port=5432;dbname=$db;user=postgres;password=123456");
				self::$conexion= new PDO($conStr);
				self::$conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
				self::$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				self::$conexion->exec("SET NAMES 'UTF8'");
				return self::$conexion;
			} catch (Exception $e) {
				echo 'Falló la conexión: ' . $e->getMessage();
			}
		}
	}
?>