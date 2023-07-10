<?php 
	require_once("../clases/dev.class.php");
	
	$dev = new Model;

	// if(isset($_SESSION['tipo'])) {
	// 	if ($_SESSION['tipo'] != "dev") {
	// 		header("Location: ../../index.php?ERROR=acceso-nativo-denegado");
	// 	}
	// } else {
	// 	header("Location: ../../index.php?ERROR=acceso-nativo-denegado");
	// }

	// $cargarEmpresas = $dev->cargarEmpresas();

?>
<!DOCTYPE html>
<html>
<head>
	<title>---</title>
	<script type="module" src="dev.js"></script>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
	<link type="text/css" rel="stylesheet" href="dev.css">
	<script src="../js/jquery.js"></script>
	<link type="text/css" rel="stylesheet" href="../css/style.css">
	<link rel="icon" href="dev.ico">
	<style type="text/css">	
		#contenedor {
			width: 100%; 
			height: 100%; 
			display: flex; 
			flex-direction: column;
			row-gap: 20px;
		}

		#contenedor label {
			color: #fff !important;
		}

	</style>
</head>
<body class="scroll">

	<!--////////////////////////////////////////////////////////////////////////////////////////-->
    <!--//////////////////////////////////    Editar   ////////////////////////////////////-->
    <!--////////////////////////////////////////////////////////////////////////////////////////-->
    <div id="crud-editar-popup" class="popup-oculto" data-crud='popup'>
      <div id="crud-editar-pop" class="popup-oculto" style="width: 100%; height: 100%">
        <button id="crud-editar-cerrar" data-crud='cerrar'>X</button>
        <section id="crud-editar-titulo" data-crud='titulo'>
            Editar parches de actualización
        </section> 

        <section style="width: 100%; height: 90%; display: flex; flex-direction: row; padding: 10px; padding-bottom: 0px;">
        	<div id="crud-dev-parche-editar">
	        	<section class="filas" style="justify-content: flex-start;">
		          <div class="columnas" style="width:100%;">
		            <div>
		              <label class="requerido">Título</label>  
		              <input type="text" data-valor="titulo"  class="parches-editar lleno">
		            </div>
		          </div>

		          <div class="columnas" style="width:100%; height: 100%;margin-bottom: 0px;">
		            <div style=" height: 100%;    margin-bottom: 0px;">
		              <label class="requerido">Contenido</label>  
		              <textarea type="text" id="crud-parche-contenido" data-valor="descripcion" class="parches-editar lleno scroll" placeholder="Descripción detallada..." onkeydown="return (event.keyCode||event.which) != 9;" style="height: 100%; border:1px dashed #ccc"></textarea>
		            </div>
		          </div>
		        </section>
	        </div>

	        <div id="crud-dev-parche-vivo" class="scroll parches-notas">
	        	
	        </div>
        </section>
        

        <section id="crud-editar-botones" data-crud='botones'>
          <button class="botones-formularios editar">CONFIRMAR</button>
          <button class="botones-formularios cerrar">CANCELAR</button> 
        </section>
      </div> 
    </div>

    <!--////////////////////////////////////////////////////////////////////////////////////////-->
    <!--/////////////////////////////////- PAGINA  ///////////////////////////////////////////-->
    <!--////////////////////////////////////////////////////////////////////////////////////////-->

    <div id="contenedor">
    	
		<div id="dev-titulo" style="position: relative">
			Página developer
		</div>

		<!--////////////////////////////////////////////////////////////////////////////////////////-->
		<div id="dev-parches" class='filas dev-margenes'>

			<div><h2 class="dev-titulos">Anunciar parche de actualización</h2></div>

			<div class="columnas">
				<div>
					<label class="dev">Título</label>
					<input type="text" id="dev-actualizacion-titulo" class='parche' placeholder="Título" value="<b class='parche-titulo'> [BETA Parche X]</b>">
				</div>
				<div>
					<label>Versión</label>
					<input type="text" id="dev-actualizacion-version" class='parche' placeholder="Título" value="">
				</div>
			</div>

			<div class='columnas' style='align-items: baseline;'>
				<div>
					<label>Contenido</label>
					<textarea id="dev-actualizacion-descripcion" class='programar parche' placeholder="Descripción detallada..." style="height: 300px;"></textarea>
				</div>
			</div>

			<div>
				<button style="width: 190px; margin-left: 10px;" class='dev-boton' id="dev-parches-cargar">CARGAR ACTUALIZACIÓN</button>
			</div>

			<div class="separador"></div>
		</div>

		<!--////////////////////////////////////////////////////////////////////////////////////////-->
		<div id="dev-actualizar-parches" class="dev-margenes">

			<div><h2 class="dev-titulos">Parches de actualización</h2></div>

			<div data-subcotenedor style="width: 100%; background: #fff;">
				
				<div style="display: flex; flex-direction: row">
					
					<div class="buscador-efecto">
			            <input type="text"  id="salto" placeholder="test" style="display: block; position: absolute; top:-4200px" tabindex="1">
			            <input type="text" name="busqueda" id="busqueda" placeholder="Busqueda" tabindex="2">
		          	</div> 

					<div style="position: relative;">
			            <button id="buscar">
			              <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="search" class="svg-inline--fa fa-search fa-w-16 iconos" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z"></path></svg>  
			            </button>
		          	</div>

				</div>

	            <div id="tabla-parches-contenedor" data-scroll class="tabla-ppal">
	              <table id="tabla-parches" class="table table-bordered table-striped">
	                  <thead>
	                  </thead>
	                  <tbody>
	                  </tbody>
	              </table>
	            </div>

	            <div style="display: flex; height: 40px;">
	              <button id="izquierda" class="botones"><?php echo "<"?></button>
	              <div id="numeracion" data-estilo="numeracion-contenedor">
	                <input type="number" class="numeracion" maxlength="3" minlength="0">
	                <span class="numeracion"></span> 
	              </div>
	              <button id="derecha" class="botones"><?php echo ">"?></button>       
	            </div>

			</div>

			<div class="separador"></div>
		</div>

		<!--////////////////////////////////////////////////////////////////////////////////////////-->
		<div id="dev-usuarios" class='filas dev-margenes'>

			<div>
				<h2 class="dev-titulos">Crear usuario</h2>
			</div>

			<div class="columnas">
				<div>
					<label class="requerido">NOMBRES:</label>
					<input type="text" maxlength="100" class="usuario-valores lleno upper usuario-limpiar">
				</div>

				<div>
					<label class="requerido">APELLIDOS:</label>
					<input type="text" maxlength="100" class="usuario-valores lleno upper usuario-limpiar">
				</div>

				<div>
					<label class="requerido">USUARIO:</label>
					<input type="text" maxlength="150" class="usuario-valores lleno upper usuario-limpiar">
				</div>
				
			</div>

			<div class="columnas">
				<div>
					<label class="requerido">CONTACTO PRINCIPAL:</label>
					<input type="text" maxlength="100" class="usuario-valores lleno upper usuario-limpiar">
				</div>

				<div>
					<label class="requerido">CORREO PRINCIPAL:</label>
					<input type="text" maxlength="100" class="usuario-valores lleno upper usuario-limpiar">
				</div>
			</div>

			<div class="columnas" style="align-items: baseline;">

				<div style="margin: 0px;">
					<label class="requerido">CONTRASEÑA:</label>
					<input type="text" class="usuario-valores lleno usuario-limpiar" id="usuario-clave">
					<div style="
						padding: 0px;
						display: grid;
						grid-template-columns: 50% 50%;
					">
						<button id="usuario-generar-clave" class="botones-claves">GENERAR CLAVE</button>
						<button id="usuario-copiar-clave" class="botones-claves">PORTAPAPELES</button>
					</div>				
				</div>

				<div style="margin:0px">

					<label class="requerido">ROL DEL USUARIO:</label>
					<div data-grupo="cc-rol-dev" style="margin: 0px">
						<input type="text" placeholder="Buscar Rol" data-limit="" class="usuario-limpiar">
						<select class="usuario-valores lleno usuario-limpiar"></select>
					</div>

				</div>

			</div>

			<div>
				<button style="width: 150px; margin-left: 10px; margin-top: 20px;" class='dev-boton confirmar' id="dev-usuario-cargar">GENERAR USUARIO</button>
			</div>

			<div class="separador"></div>
		</div>

		<style type="text/css">
			#dev-permisos-contenedor, .dev-contenedor {
				display: flex; 
				height: fit-content; 
				width: 100%;
				padding:0px 50px; 
				align-items: flex-end; 
				column-gap: 20px;
				margin-bottom: 10px;
			}

			#dev-permisos-contenedor div, .dev-contenedor div {
				margin: 0px !important;
			}

			#dev-permisos-contenedor button, .dev-contenedor button {
				margin: 0px !important;
			}

			#dev-permisos-contenedor .filas, .dev-contenedor .filas {
			    padding: 11px !important;
			    border: 1px solid #dddddd;
			}
		</style>

		<!--////////////////////////////////////////////////////////////////////////////////////////-->
		<section id="dev-permisos-contenedor" style="">
		<!--////////////////////////////////////////////////////////////////////////////////////////-->	

			<div id="dev-formularios" class='filas dev-margenes' style="padding:0px; justify-content: flex-start; row-gap: 15px;">

				<div>
					<h2 class="dev-titulos">Crear formulario</h2>
				</div>

				<div class="columnas">
					<div>
						<label class="requerido">NOMBRE DEL FORMULARIO:</label>
						<input type="text" maxlength="100" class="formulario-valores lleno upper formulario-limpiar">
					</div>
				</div>

				<div>
					<button style="width: 150px; margin-left: 10px; margin-top: 20px;" class='dev-boton confirmar' id="dev-formulario-cargar">GENERAR FORMULARIO</button>
				</div>

			</div>

			<!--////////////////////////////////////////////////////////////////////////////////////////-->
			<div id="dev-banderas" class='filas dev-margenes' style="padding:0px; row-gap: 10px;">

				<div>
					<h2 class="dev-titulos">Crear bandera</h2>
				</div>

				<div class="columnas">

					<div>
						<label class="requerido">NOMBRE DE LA BANDERA:</label>
						<input type="text" maxlength="100" class="banderas-valores lleno upper banderas-limpiar">
					</div>

					<div style="margin:0px">

						<label class="requerido">FORMULARIO DE LA BANDERA:</label>
						<div data-grupo="cc-formularios-dev" style="margin: 0px">
							<input type="text" placeholder="Buscar formulario" data-limit="" class="banderas-limpiar" data-hidden>
							<select class="banderas-valores lleno banderas-limpiar"></select>
						</div>

					</div>

				</div>

				<div class="columnas">
					
					<div>
						<label class="requerido">DESCRIPCIÓN DE LA BANDERA</label>
						<textarea class="banderas-valores lleno banderas-limpiar lleno upper"></textarea>
					</div>

				</div>

				<div>
					<button style="width: 150px; margin-left: 10px; margin-top: 20px;" class='dev-boton confirmar' id="dev-banderas-cargar">GENERAR BANDERA</button>
				</div>

			</div>


		<!--////////////////////////////////////////////////////////////////////////////////////////-->
		</section>
		<!--////////////////////////////////////////////////////////////////////////////////////////-->

		<!--////////////////////////////////////////////////////////////////////////////////////////-->
		<section class="dev-contenedor">
		<!--////////////////////////////////////////////////////////////////////////////////////////-->
			
			<!--////////////////////////////////////////////////////////////////////////////////////////-->
			<div id="dev-menu" class='filas dev-margenes' style="padding:0px; row-gap: 10px;">

				<div>
					<h2 class="dev-titulos">Crear opción de bloquo de menú</h2>
					<h2 style="color:#fff; font-size: 16px">LAS OPCIONES SON CREADAS MANUALMENTE EN EL SERVIDOR</h2>
				</div>

				<br>
				<div style="color:#fff; font-size: 14px; font-weight: bold">ESTRUCTURA BÁSICA DE LA RUTA DE BLOQUEO:</div>
				<div style="color:#fff; font-size: 12px;">NOMBRE DEL BOTON, UL, LISTA , NOMBRE DEL BOTON , BLOQUEAR</div>
				<div style="color:#fff; font-size: 12px;">NOMBRE DEL BOTON, UL, LISTA , ... , BLOQUEAR</div>
				<br>
		

				<div class="columnas" style="column-gap: 20px; row-gap: 20px">

					<div>
						<label style="text-transform: uppercase;" class="requerido">Ruta del bloqueo:</label>
						<input type="text" maxlength="100" class="menu-valores lleno upper menu-limpiar">
					</div>

					<div style="margin:0px">

						<label style="text-transform: uppercase;" class="requerido">Nombre de la referencia asociativa a la lista fija:</label>
						<input type="text" maxlength="100" class="menu-valores lleno upper menu-limpiar">

					</div>

				</div>

				<div class="columnas">
					
					<div>
						<label style="text-transform: uppercase;">Bloquear edición desde el panel de configuración del sistema</label>
						<input type="checkbox" class="menu-valores menu-limpiar check checklarge" style="width: 30px; height: 30px; margin: 0px;">
					</div>

					<div>
						<label style="text-transform: uppercase;">Bloquear botón por defecto</label>
						<input type="checkbox" class="menu-valores menu-limpiar check checklarge" style="width: 30px; height: 30px; margin: 0px;">
					</div>

				</div>

				<br>

				<div>
					<button style="width: 150px; margin-left: 10px; margin-top: 20px;" class='dev-boton confirmar' id="dev-menu-cargar">GENERAR OPCIÓN</button>
				</div>

			</div>

		<!--////////////////////////////////////////////////////////////////////////////////////////-->
		</section>
		<!--////////////////////////////////////////////////////////////////////////////////////////-->

    </div>
</body>
</html>

<!--
<div>
	<h4>
		<b>1.-numeracion:</b>
	</h4>

	<ul>
		<li>especificaciones1.</li>
		<li>especificaciones2.</li>
		...
	</ul>
    ...
</div>

<h3>Cambios</h3>
...
-->