<?php 

	class Directorios {

		// public function ejemplos($args) {

		// 	$this->crearTxt("../otros/dctTexto/empr$idEmpresa.txt", "
		// 			directorios: empr$idEmpresa,
		// 			nombreSiae: $empresa,
		// 			nacionalidad: $nac,
		// 			primer nombre: $prNombre,
		// 			segundo nombre: $sgNombre,
		// 			primer apellido: $prApellido,
		// 			segundo apellido: $sgApellido,
		// 			sexo: $sexo,
		// 			usuario web/siae: $usuario,
		// 			clave:[[$clave]],
		// 			correo: $correo,
		// 			direccion: $direccion,
		// 			telefono: $telefono
		// 		", LOCK_EX );

		// 	$this->crearDirectorio("../empr2", "../empr$idEmpresa");
		// 	$this->crearDirectorio("../imagenes/empr2", "../imagenes/empr$idEmpresa");
		// 	mkdir("../siae/imagenes/empr$idEmpresa", 0777, true);
		// 	mkdir("../reportes/empr$idEmpresa", 0777, true);  

		// 	$this->eliminarDirectorio("../empr$idEmpresa");
		// 	unlink("../otros/dctTexto/empr$idEmpresa.txt"); 

		// }

		//*******************************************************************
		public function consultar_directorio($source) {
		    if (file_exists($source)) {
		        
		    	clearstatcache();

		    	return true;

		    } else {

		    	clearstatcache();
		        
		    	return false;

		    }
		}

		public function crear_directorio($nombre, $ruta) {

			if (!file_exists($nombre.$ruta)) {

				clearstatcache();
				
				@mkdir($nombre.$ruta, 0777, true);

			}

		}


		//*******************************************************************
		public function copiar_directorio($source, $target) {
		    if ( is_dir( $source ) ) {
		        @mkdir( $target , 0777, true);
		        $d = dir( $source );
		        while ( FALSE !== ( $entry = $d->read() ) ) {
		            if ( $entry == '.' || $entry == '..' ) {
		                continue;
		            }
		            $Entry = $source . '/' . $entry; 
		            if ( is_dir( $Entry ) ) {
		                $this->copiar_directorio( $Entry, $target . '/' . $entry );
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
		public function eliminar_directorio($src) { 
		    $dir = opendir($src);
		    while(false !== ( $file = readdir($dir)) ) { 
		        if (( $file != '.' ) && ( $file != '..' )) { 
		            if ( is_dir($src . '/' . $file) ) { 
		                $this->eliminar_directorio($src . '/' . $file); 
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
		//*******************************************************************
		public function crear_txt($fullPath, $contents, $flags = 0 ){
		    $parts = explode( '/', $fullPath );
		    array_pop( $parts );
		    $dir = implode( '/', $parts );
		   
		    if( !is_dir( $dir ) )
		        mkdir( $dir, 0777, true );
		   
		    file_put_contents( $fullPath, $contents, $flags );
		}

		//*******************************************************************
		public function editar_txt($fullPath, $contents, $flags = 0 ){
 	
 			file_put_contents( $fullPath, '', $flags );
		    file_put_contents( $fullPath, $contents, $flags );

		}

		//*******************************************************************
		public function traer_txt($ruta, $nombre){
 	
 			$txt = "$ruta/$nombre.txt";
			$txt = file($txt);//file in to an array

			return json_decode($txt[0], true);

		}

		//*******************************************************************
		//*******************************************************************
		public function contiene($needle, $haystack){
		    return strpos($haystack, $needle) !== false;
		}

		//*******************************************************************
		public function categorizar_imagenes($referencia) {

			$lista = array();

			foreach($_FILES as $llave => $valor) {

				if ($this->contiene($referencia, $llave)) {

					array_push($lista, $valor);

				}

			}

			return $lista;

		}

		public function eliminar_imagenes($args) {

		}

		public function base64_imagen($ruta, $imagen, $flags = 0 ) {

			file_put_contents( $ruta, file_get_contents($imagen), $flags );

		}

	}

?>