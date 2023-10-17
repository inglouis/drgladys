<?php
set_time_limit(300);
ini_set('memory_limit', '-1');
ini_set( "display_errors", "off" );
ini_set('session.gc_maxlifetime', 30*24*60*60);
ini_set('session.cookie_domain', 'localhost');
error_reporting( E_ALL );

session_write_close();
session_start();

// ini_set('session.save_path', realpath(dirname($_SERVER['DOCUMENT_ROOT']) . '/tmp'));
// ini_set('session.save_path', realpath(dirname($_SERVER['DOCUMENT_ROOT']) . '/tmp'));
// ini_set('session.cookie_secure', "1");
// ini_set('session.cookie_samesite', 'None');

// session_set_cookie_params([
//     'expires' => time() + 60*60*24*30,
//     'path' => '/',
//     'domain' => '.domain.com', // leading dot for compatibility or use subdomain
//     'secure' => true, // or false
//     'httponly' => false, // or false
//     'samesite' => 'None' // None || Lax || Strict
// ]);

$directorio = '../';
$ruta1 = 'clases/cbdc.class.php';
$ruta2 = 'clases/opciones.class.php';

$rutaProcesada1 = '';
$rutaProcesada2 = '';

for ($i=0; $i < 5; $i++) { 
	$real = realpath($directorio.$ruta1);
	if (file_exists($real)) {
	  $rutaProcesada1 = $directorio.$ruta1;
	  $rutaProcesada2 = $directorio.$ruta2;
	  break;
	} else {
	  $directorio .= '../';
	}
};

require_once($rutaProcesada1);

//require_once("../clases/cbdc.class.php");
//require_once("../clases/opciones.class.php");

// $_SESSION = []; 
// if (ini_get("session.use_cookies")) { 
//     $params = session_get_cookie_params(); 
//     setcookie(session_name(), '', time() - 42000, 
//         $params["path"], $params["domain"], 
//         $params["secure"], $params["httponly"] 
//     ); 
// }

// session_destroy();

class ppal extends cbdc 
{
	public $resultado;
	private $year;

//********************************************************************************	
//********************************************************************************
	function i_pdo($sql, $datos, $return, $transaccion = false, $mensaje = null) {
		
		$conn = $this::pdo_conectar(); 
		
		try {

	 		$resultado = $conn->prepare($sql);
			$resultado->execute($datos);

			////////////////////////////////////////////////////////////////
			if ($transaccion) { $this->caputar_transaccion($sql, $datos, $mensaje); }
			////////////////////////////////////////////////////////////////

			if ($return) {

				return $resultado;

			} else {

				return true;

			}

		} catch (Exception $e) {

			echo 'Error en la ejecución: ' . $e->getMessage();
			return false;

		}

		$conn = null;
	}

//********************************************************************************
	function i_pdo_transaction($sql, $datos, $return, $transaccion = false, $mensaje = null) {

		$conn  = $this::pdo_conectar(); 
		
		$trans = $conn->prepare("SET SESSION TRANSACTION ISOLATION LEVEL SERIALIZABLE;");
		$trans->execute();

		try {

			$conn->beginTransaction();

	 		$resultado = $conn->prepare($sql);
			$resultado->execute($datos);

			$conn->commit();

			////////////////////////////////////////////////////////////////
			if ($transaccion) { $this->caputar_transaccion($sql, $datos, $mensaje); }
			////////////////////////////////////////////////////////////////

			if ($return) {

				return $resultado;

			} else {

				return true;

			}

		} catch (PDOException $e) {

			$conn->rollBack();

			echo 'Error en la ejecución: ' . $e->getMessage();

		}

		$conn = null; 

	}
//********************************************************************************
	function init_transaction() {

		$conn  = $this::pdo_conectar(); 
		
		$trans = $conn->prepare("SET SESSION TRANSACTION ISOLATION LEVEL SERIALIZABLE;");
		$trans->execute();

		$conn->beginTransaction();

		return $conn;

	}
//********************************************************************************
	function handle_transaction($conn, $sql, $datos, $return) {

		$resultado = $conn->prepare($sql);
		$resultado->execute($datos);

		if ($return) {

			return $resultado;

		} else {

			return true;

		}

	}


//********************************************************************************
	function e_pdo($sql, $transaccion = false, $mensaje = null) {
	 	try {

	 		$conn=$this::pdo_conectar();
	 		$resultado=$conn->prepare($sql);
	 		$resultado->execute();

	 		////////////////////////////////////////////////////////////////
			if ($transaccion) { $this->caputar_transaccion($sql, '[]', $mensaje); }
			////////////////////////////////////////////////////////////////

	 		return $resultado;

	 	} catch (Exception $e) {
	 		echo 'Error en la ejecución: ' . $e->getMessage();
	 		return false;
	 	}
	}

//********************************************************************************
	public function seleccionar ($sql, $args) {

		$datos = $this->i_pdo($sql, $args, true);
		$resultado = $datos->fetchAll(PDO::FETCH_ASSOC);

    	return json_encode($resultado);

	}

//********************************************************************************
	public function insertar($sql, $args, $mensaje = null) {

		if (stripos($sql,'returning') !== false) {

			$datos = $this->i_pdo($sql, $args, true);
			$resultado = $datos->fetchAll(PDO::FETCH_ASSOC);

        	return $resultado; 

		} else {

			$this->i_pdo($sql, $args, true);
			return 'exito';

		}
	}
//********************************************************************************
	public function actualizar($sql, $args, $mensaje = null) {

		if (stripos($sql,'returning') !== false) {

			$datos = $this->i_pdo($sql, $args, true, true, $mensaje);
			$resultado = $datos->fetchAll(PDO::FETCH_ASSOC);

        	return $resultado; 

		} else {

			$this->i_pdo($sql, $args, true);
			return 'exito';

		}
	}
//********************************************************************************
	public function eliminar($sql, $args, $mensaje = null) {

		if (stripos($sql,'returning') !== false) {

			$datos = $this->i_pdo($sql, $args, true, true, $mensaje);
			$resultado = $datos->fetchAll(PDO::FETCH_ASSOC);

        	return $resultado; 

		} else {

			$this->i_pdo($sql, $args, true);
			return 'exito';

		}

	}
//********************************************************************************	
	public function modificar_sesion($args) {

		// Estructura parametrizada de sesiones para variables simples o complejas

		// Construccion array php
		//----------------------------
		// $test = array(
		// 	array("sesion" => 'mi_sesion' "parametros" => 'hola'),
		// 	array("sesion" => 'mi_sesion' "parametros" => array("ruta" => "[0, 'seccion', ...]", "valor": '...'))
		// );
		//---------------------------
		// Equivalente javascript
		//---------------------------
		// [
		//  {"sesion": 'mi_sesion' "parametros": 'hola'},
		//  {"sesion": 'mi_sesion' "parametros": {"ruta": "[0, 'seccion', ...]", "valor", '...'}}
		// ]

		//echo gettype($args);

		//print_r($args);
		//print_r($_SESSION);

		foreach ($args as $ar) {

			if (gettype($ar['parametros']) == 'array') {

				echo '';
				//esta después, que hasta que no este el sistema de usuarios [sesiones compactadas en json] no lo veo necesario

			} else {

				$valor  = $ar['parametros'];
				$sesion = $ar['sesion'];

				//echo gettype($valor);

				$_SESSION[$sesion] = $valor;

			}

		}

		//print_r($_SESSION);
		// $this->array_establecer($_SESSION[$columna], $ruta, $valor);
		// $resultado = json_encode($_SESSION[$columna], true);

	}

	public function valor_sesion($args) {

		// $retornar = array();

		// foreach ($args as $ar) {

		// 	$retornar[$ar['sesion']] = $_SESSION[$ar['sesion']];

		// }

		return json_encode($_SESSION);

	}
//********************************************************************************
	public function consultar_lista($lista) {

		echo "<pre>";
        print_r($lista);
        echo "</pre>";
		
	}
//********************************************************************************
	public function str_contains($needle, $haystack){
	    return strpos($haystack, $needle) !== false;
	}
//*******************************************************************************
	public function str_replace_first($search, $replace, $subject) {
	    return implode($replace, explode($search, $subject, 2));
	}
//*******************************************************************************
	public function aplicar_filtros($arg) {

		$sql     = $arg[0];
		$args    = $arg[1]; //cada uno de los elementos y sus datos
		$omision = $arg[2]; //cuantos WHERE omitirá antes del generado}
		$charlen = 0;		//el [origen] define la columna que se va a utilizar
		$temporal= '';

		//echo $sql;
		//print_r($args);
		//echo $omision;

		if(count($arg) > 4) {
			$personalizado = $arg[4];
		} else {
			$personalizado = '';
		}

		for ($i=0; $i < count($args); $i++) {
            if(!empty($args[$i])) {

            	if($personalizado !== 'custom') {	
	            	if($this->str_contains('ORDER BY', $this->filtroMapa[$i])) {

	            		if(gettype($args[$i]) === 'array') {
		                    $order = $this->filtroMapa[$i];

		                    for ($i2=0; $i2 < 2; $i2++) {
		                        $order = $this->str_replace_first("?", $args[$i][$i2], $order);
		                    }
		                } else {
		                    $order = str_replace(["?"], [$args[$i]], $this->filtroMapa[$i]);
		                }

		                //echo $order;
		                $charlen = strlen($order);
		                $temporal = $order;
		                //echo $sql;

					} else {
						$validarOmision = 0;

		            	if($args[$i] === 'true') {
		            		$args[$i] = 1;
		            	} else if ($args[$i] === 'false'){
		            		$args[$i] = 0;
		            	}
		  	
		                if (!$this->str_contains('WHERE', $sql) || $validarOmision < $omision) {
		                	if(substr($sql, -4) !== " AND") {
					            $sql = $sql." WHERE";
					        }
		                    $validarOmision++;
		                } else {
		                	if(substr($sql, -4) !== " AND") {
					            $sql = $sql." AND";
					        }
		                }

		                if(gettype($args[$i]) === 'array') {
		                    $sql = $sql." ".$this->filtroMapa[$i];
		                    for ($i2=0; $i2 < 2; $i2++) {
		                        $sql = $this->str_replace_first("?", $args[$i][$i2], $sql);
		                    }
		                    $sql = $sql." AND";
		                } else {

		                    $sql = $sql." ".str_replace(["?"], [$args[$i]], $this->filtroMapa[$i])." AND";
		                }
					}
            	}

            }
        }

        //echo substr($sql, -3);// == asc;
        if(substr($sql, -3) === "AND") {
            $sql = substr($sql, 0, -4);
        }

    	if(count($arg) > 4) {


    		if (strtolower($arg[4]) == 'custom') {

	        	$sql = $sql." ";

	        } else if (trim($temporal) !== '') {

	        	$sql = $sql." ".$temporal;

	    	} else if (trim($arg[4]) == 'DESC' || trim($arg[4]) == 'ASC') {

	    		$sql = $sql." order by 1 ".$arg[4];

	        } else if ($arg[4] !== 'custom' && $arg[4] !== 'DESC' && $arg[4] !== 'ASC') {

	        	$sql = $sql." ".$arg[4];

	    	} else {

	    		$sql = $sql." order by 1";

	    	}

    	}

    	if(count($arg) > 5) {
    		$sql = $sql." limit $arg[5]";
    	}

    	//echo '--'.$sql.'--';
        
        $datos = $this->e_pdo($sql);
        $resultado = $datos->fetchAll(PDO::FETCH_ASSOC);

        //print_r($resultado);

        if($arg[3]) {
        	return $resultado;
        } else {
        	echo json_encode($resultado);
        }        
	}
//*******************************************************************
	public function combos($args, $sql) {

		if(count($args) > 0) {
			$busqueda  = $args[0];
        	$limitador = $args[1];
		} else {
			$busqueda  = '';
        	$limitador = 10000;
		}

        if(!empty($args[0])) {

        	if (!$this->str_contains('WHERE', $sql[0])) {
            	if(substr($sql[0], -4) !== " AND") {
		            $sql[0] = $sql[0]." WHERE";
		        }
            } else {
            	$sql[0] = $sql[0]." AND";
            }

            $sql[0] = $sql[0]." $sql[1] like '%'|| UPPER(TRIM('$busqueda')) ||'%' order by $sql[2]";
        } else {

        	if (!$this->str_contains('ORDER BY', $sql[0])) {
        		$sql[0] = $sql[0]." order by $sql[2]";
        	} 
            
        }

        if(!empty($limitador)) {
           $sql[0] = $sql[0]." limit $limitador"; 
        }

        return $this->seleccionar($sql[0], []);
    }  
//*******************************************************************
    public function array_establecer(array &$array, $parents, $value, $glue = ',') {

	    if (!is_array($parents)) {
	        $parents = explode($glue, (string) $parents);
	    }

	    $ref = &$array;

	    foreach ($parents as $parent) {
	        if (isset($ref) && !is_array($ref)) {
	            $ref = array();
	        }

	        $ref = &$ref[$parent];
	    }
	    $ref = $value;
	}
//*******************************************************************
	public function array_eliminar(&$array, $parents, $glue = ',') {
	    if (!is_array($parents)) {
	        $parents = explode($glue, $parents);
	    }

	    $key = array_shift($parents);

	    if (empty($parents)) {
	        unset($array[$key]);
	    } else {
	        array_unset_value($array[$key], $parents);
	    }
	}
//*******************************************************************
	public function array_traer(array &$array, $parents, $glue = '.') {
	    if (!is_array($parents)) {
	        $parents = explode($glue, $parents);
	    }

	    $ref = &$array;

	    foreach ((array) $parents as $parent) {
	        if (is_array($ref) && array_key_exists($parent, $ref)) {
	            $ref = &$ref[$parent];
	        } else {
	            return null;
	        }
	    }
	    return $ref;
	}
//*******************************************************************
	public function crearDirectorio($source, $target) {
	    if ( is_dir( $source ) ) {
	        @mkdir( $target , 0777, true);
	        $d = dir( $source );
	        while ( FALSE !== ( $entry = $d->read() ) ) {
	            if ( $entry == '.' || $entry == '..' ) {
	                continue;
	            }
	            $Entry = $source . '/' . $entry; 
	            if ( is_dir( $Entry ) ) {
	                $this->crearDirectorio( $Entry, $target . '/' . $entry );
	                continue;
	            }
	            copy( $Entry, $target . '/' . $entry );
	        }

	        $d->close();
	    }else {
	        copy( $source, $target );
	    }
	}
//*******************************************************************
	public function eliminarDirectorio($src) { 
	    $dir = opendir($src);
	    while(false !== ( $file = readdir($dir)) ) { 
	        if (( $file != '.' ) && ( $file != '..' )) { 
	            if ( is_dir($src . '/' . $file) ) { 
	                $this->eliminarDirectorio($src . '/' . $file); 
	            } 
	            else { 
	                unlink($src . '/' . $file); 
	            } 
	        } 
	    } 
	    closedir($dir); 
	    rmdir($src);
	}
//*******************************************************************
	public function crearTxt($fullPath, $contents, $flags = 0 ){
	    $parts = explode( '/', $fullPath );
	    array_pop( $parts );
	    $dir = implode( '/', $parts );
	   
	    if( !is_dir( $dir ) )
	        mkdir( $dir, 0777, true );
	   
	    file_put_contents( $fullPath, $contents, $flags );
	}
//*******************************************************************
	public function calcularEdad($fecha) {
    	$diff = date_diff(date_create($fecha), date_create(date("d-m-Y")));
    	return $diff->format("%y");
	}

	public function calcularMeses($fecha) {
    	$diff = date_diff(date_create($fecha), date_create(date("d-m-Y")));
    	return $diff->format("%m");
	}

	public function calcularDias($fecha) {
    	$diff = date_diff(date_create($fecha), date_create(date("d-m-Y")));
    	return $diff->format("%d");
	}
//*******************************************************************
	public function fechaHora($tz, $formato) {
	    $timestamp = time();
	    $dt = new DateTime("now", new DateTimeZone($tz));
	    $dt->setTimestamp($timestamp);
	    return $dt->format($formato);
	}
//*******************************************************************
	public function fechaHoraAjustar($tz, $formato, $ajuste) {
	    $timestamp = time() - ($ajuste * 60);
	    $dt = new DateTime("now", new DateTimeZone($tz));
	    $dt->setTimestamp($timestamp);
	    return $dt->format($formato);
	}
//*******************************************************************
	public function historialArchivos($args) { //mover a ppal
		$extension = $args[0];
		$patron = $args[1];
    	$ruta ="../$args[2]".$patron.'.'.$extension;
    	$lista = glob($ruta);

    	if (count($lista) > 0) {
    		usort( $lista, function( $a, $b ) { return filemtime($b) - filemtime($a); } );
	    	foreach ($lista as &$f) {
			    $f = [
			    	"ruta"  => $f,
			    	"fecha" => date("d-m-Y", fileatime($f)),
			    	"size"  => filesize($f)
			    ];
			}
    	} else {
    		$lista = 'noreport';
    	}
    	return $lista;
    }
    //*******************************************************************
    public function version () {

    	return $this->i_pdo("select version from miscelaneos.version where id_version = 1", [], true)->fetchColumn();

    }
    //*******************************************************************
    public function monedasPpal () {
    	return json_encode($this->e_pdo("select * from miscelaneos.monedas order by id_moneda")->fetchAll(PDO::FETCH_ASSOC));
    }
    //*******************************************************************
    public function consultarCookie($args) {

    	echo $_COOKIE["se_cookie"];

    }

    //********************************************************************************	
	//********************************************************************************

	function caputar_transaccion($sql, $datos, $mensaje) {

		$this->year = $this->fechaHora('America/Caracas','Y');
		
		if (gettype($datos) == 'array') {

			$datos = json_encode($datos);

		}

		$query = "insert into transacciones.fecha".$this->year."(sql, datos, descripcion, fecha, hora) values(?,?,?, upper(?), current_date, current_time)";

		$this->i_pdo($query, [$sql, $datos, $mensaje], false);

	}

    public function controlador_cambios($args) {

        $sql = "select controlador_cambios from miscelaneos.usuarios where id_usuario = ?";
        
        if ($this->i_pdo($sql, [$_SESSION['usuario']['id_usuario']], true)->fetchColumn()) {
            
            return 1;

        } else {
            
            return 0;
            
        }

    }

    public function controlador_cambios_activar($args) {

        $sql = "update miscelaneos.usuarios set controlador_cambios = true where id_usuario = id_usuario";
        
        return $this->i_pdo($sql, [], false);

    }

    public function controlador_cambios_desactivar($args) {

        $sql = "update miscelaneos.usuarios set controlador_cambios = false where id_usuario = ?";
        
        return $this->i_pdo($sql, [$_SESSION['usuario']['id_usuario']], false);

    }

    public function base64_a_jpeg($base64_string, $output_file) {
	    // open the output file for writing
	    $ifp = fopen( $output_file, 'wb' ); 

	    // split the string on commas
	    // $data[ 0 ] == "data:image/png;base64"
	    // $data[ 1 ] == <actual base64 string>
	    $data = explode( ',', $base64_string );

	    // we could add validation here with ensuring count( $data ) > 1
	    fwrite( $ifp, base64_decode( $data[ 1 ] ) );

	    // clean up the file resource
	    fclose( $ifp ); 

	    return $output_file; 
	}

	//UNA MEJOR SOLUCION QUE DEBO PROBAR
	//file_put_contents($output_file, file_get_contents($base64_string));
	//output_file = NOMBRE DEL ARCHIVO + RUTA
	//base64_string = IMAGENE EN BASE64 CON data:image/png;base64 INCLUIDO 
}

//-------------------------------------------------------
global $objeto;
$objeto = new ppal();
//-------------------------------------------------------
require_once($rutaProcesada2);
//-------------------------------------------------------
require_once('log.class.php');
//-------------------------------------------------------