<?php 
	$func  = trim($_REQUEST["funcion"]); //funcion
	$clase = trim($_REQUEST["clase"]);   //modelo
	$datos = json_decode($_REQUEST["datos"], true); //parametros

	require_once("../clases/".$clase.".class.php");

	class Controller {
	    public function llamar(Model $model): Model {
	        return $model;
	    }
	}

	class View {
		public $funcion;
		public $parametros;

		public function __construct($funcion, $datos){
			$this->funcion = $funcion;
			$this->parametros = $datos;
		}

	    public function salida(Model $model) {
	        return $model->{$this->funcion}($this->parametros);
	    }
	}

	$model = new Model();
	$controller = new Controller();
	$view = new View($func, $datos);
	//if (isset($action)) {  $model = $controller->{$action}($model);}
	echo $view->salida($model);
?>