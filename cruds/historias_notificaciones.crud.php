<!--2)---------------------------------------------------- -->
<!----------------- GENERALES TEMPLATE ----------------- -->
<!-------------------------------------------------------- -->
<template id="notificaciones-template">

  <section class="notificaciones-contenedor">

  	<div class="notificaciones-contenido">
  		
	  	<div class="reporte"></div>
	  	<div class="nombre"></div>

  	</div>

  </section>

</template>

<!------------------------------------------------------------------- -->
<!------------------- NOTIFICACIONES DOCTOR ------------------------- -->
<!------------------------------------------------------------------- -->
<div id="crud-notificaciones-popup" class="popup-oculto" data-crud='popup'>
	
	<div id="crud-notificaciones-pop" class="popup-oculto" style="
		min-height: 80%;
	    display: grid;
	    width: 60%;
	    grid-template-rows: auto 1fr auto;
	    justify-content: stretch;
	">

	    <button id="crud-notificaciones-cerrar" data-crud='cerrar'>X</button>

	    <section id="crud-notificaciones-titulo" data-crud='titulo' style="margin-bottom: 5px; border: none;">
	      REVISIÓN DE REPORTES
	    </section>

	    <section id="crud-notificaciones-contenedor">
	      	
	      	<div id="edicion-notificaciones" class="borde-estilizado">

	      		<!-------------------------------------------------------- -->
				<!----------------- CONSTANCIAS CONTENEDOR --------------- -->
				<!-------------------------------------------------------- -->
				<section class="notificaciones-seccion">
				                
				    <div data-familia class="contenedor contenedor-notificaciones" id="constancias-contenedor-notificaciones">

				        <div class="subtitulo">
				          Modificar reporte de constancia
				        </div>

				        <div class="cargar" title="[TAB] para enforcar">

				          <div class="personalizacion-notificaciones" data-hidden>

				            <section>Personalización</section>
				            <section style="width: 100%; border: 1px dashed #fff"></section>
				            <span>ENTER: SEPARAR LÍNEA</span>
				            <span>°CENTRAR°</span>
				            <span>*<b>NEGRITA</b>*</span>
				            <span>_ <u>SUBRAYADO</u> _</span>
				            <span>~<i>ITÁLICA</i>~</span>

				            <div id="constancia-previa-notificaciones" data-scroll></div>

				          </div>
				            
				          <div class="filas" style="height: 100%; position: relative">
				          
				            <div class="columnas" style="height: 100%">
				              
				              <div style="height: 100%; margin: 0px">
				                
				                <label class="requerido">Constancia</label>
				                <textarea id="constancia-textarea-notificaciones" data-previa="constancia-previa-notificaciones" data-valor="constancia" rows="6" class="constancia-valores-notificaciones upper lleno textarea-espaciado contenedor-personalizable" placeholder="Cargar información..." style="resize: none" data-scroll></textarea>

				              </div>

				            </div>

				          </div>

				          <div class="botones-reportes" style="justify-content: center;">
				            <button class="reporte-actualizar">CONFIRMAR CAMBIOS</button>
				          </div>

				        </div>

				    </div>

				</section>

	      	</div>

			<div id="contenedor-notificaciones" class="tabla-ppal borde-estilizado" data-scroll>

				<table id="tabla-notificaciones" class="table table-bordered table-striped">
					<thead>
					</thead>
					<tbody>
					</tbody>
				</table>

			</div>

	    </section>

  	</div>

</div>