<!-------------------------------------------------------- -->
<!-------------- NOTIFICACIONES TEMPLATE ----------------- -->
<!-------------------------------------------------------- -->
<template id="notificaciones-template">

  <section class="notificaciones-contenedor">

  	<div class="notificaciones-contenido">
  		
	  	<div class="reporte"></div>
	  	<div class="nombre"></div>

  	</div>

  </section>

</template>


<!-------------------------------------------------------- -->
<!-------------- NOTIFICADOS TEMPLATE ----------------- -->
<!-------------------------------------------------------- -->
<template id="notificados-template">

  <section class="notificados-contenedor">
  	
  	<button class="btn eliminar" title="Confirmar finalización de la revisión del reporte">
  		<svg style="width:10px; height: 10px" class="iconos" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><path fill="currentColor" d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/></svg>
  	</button>

  	<div class="notificados-contenido">
  		
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

				<!-------------------------------------------------------- -->
				<!-------------------- INFORMES CONTENEDOR --------------- -->
				<!-------------------------------------------------------- -->
				<section class="notificaciones-seccion" data-hide data-efecto="aparecer">
				                
				    <div data-familia class="contenedor contenedor-notificaciones" id="informes-contenedor-notificaciones">

				      <div class="subtitulo">
				        Modificar reporte de informe médico
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

				          <div id="informe-previa-notificaciones" data-scroll></div>

				        </div>
				          
				        <div class="filas" style="height: 100%; position: relative">

				          <div class="columnas" >
				          
				            <div>
				              <label class="requerido">Título</label>
				              <input type="text" id="informe-titulo-notificaciones" data-valor="titulo" class="informe-valores-notificaciones upper lleno">
				            </div>        

				          </div>

				          <div class="columnas" style="height: 100%">
				          

				            <div style="height: 100%; margin: 0px">
				              
				              <label class="requerido">Informe</label>
				              <textarea id="informe-informacion-notificaciones" data-previa="informe-previa" data-valor="informe" rows="6" class="informe-valores-notificaciones upper lleno textarea-espaciado contenedor-personalizable" placeholder="Cargar información..." style="resize: none" data-scroll></textarea>

				            </div>

				          </div>

				        </div>

				        <div class="botones-reportes" style="justify-content: center;">
				          <button class="reporte-actualizar">CONFIRMAR CAMBIOS</button>
				        </div>

				      </div>

				    </div>

				</section>

				<!-------------------------------------------------------- -->
				<!---------------- PRESUPUESTOS CONTENEDOR --------------- -->
				<!-------------------------------------------------------- -->
				<section class="notificaciones-seccion" data-hide>
				                
				    <div data-familia class="contenedor contenedor-notificaciones" id="presupuestos-contenedor-notificaciones">

				      <div class="subtitulo">
				        Modificar reporte de presupuesto
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

				          <div id="presupuesto-previa-notificaciones" data-scroll></div>

				        </div>
				          
				        <div class="filas" style="height: 100%; position: relative">

				          <div class="columnas" >
				            
				            <div>
				              <label class="requerido">Nombre completo</label>
				              <input type="text" data-valor="nombre_completo" class="presupuesto-valores-notificaciones upper lleno presupuesto-representante-valores">
				            </div>

				          </div>

				          <div class="columnas" >
				            
				            <div>
				              <label class="requerido">Cédula</label>
				              <input type="text" data-valor="cedula" class="presupuesto-valores-notificaciones upper lleno presupuesto-representante-valores">
				            </div>        

				          </div>

				          <div class="columnas" style="height: 100%">
				            
				            <div style="height: 100%; margin: 0px">
				              
				              <label class="requerido">Presupuesto</label>
				              <textarea id="presupuesto-informacion-notificaciones" data-previa="presupuesto-previa-notificaciones" data-valor="presupuesto" rows="6" class="presupuesto-valores-notificaciones upper lleno textarea-espaciado contenedor-personalizable" placeholder="Cargar información..." style="resize: none" data-scroll></textarea>

				            </div>

				          </div>

				        </div>

				        <div class="botones-reportes" style="justify-content: center;">
				          <button class="reporte-actualizar">CONFIRMAR CAMBIOS</button>
				        </div>

				      </div>

				    </div>

				</section>

				<!-------------------------------------------------------- -->
				<!--------------------- REPOSOS CONTENEDOR --------------- -->
				<!-------------------------------------------------------- -->
				<section class="notificaciones-seccion" data-hide>
				                
				    <div data-familia class="contenedor contenedor-notificaciones" id="reposos-contenedor-notificaciones">

				        <div class="subtitulo">
				          Modificar reporte de reposo
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

				            <div id="reposo-previa-notificaciones" data-scroll></div>

				          </div>
				            
				          <div class="filas" style="position: relative">
				          
				          	<div class="columnas">
        
						        <div>
						          <label class="requerido">Cabecera del reporte</label>
						          <select data-valor="cabecera" class="reposo-valores-notificaciones upper lleno">
						            <option value="0">Por intervención quirúrgica</option>
						            <option value="1">Por presentar un motivo</option>
						          </select>
						        </div>

						    </div>

				            <div class="columnas">
				              
				              <div style="margin: 0px">
				                
				                <label class="requerido">Motivo de la cabecera</label>
				                <textarea id="reposo-informacion-notificaciones" data-previa="reposo-previa-notificaciones" data-valor="reposo" rows="6" class="reposo-valores-notificaciones upper lleno textarea-espaciado contenedor-personalizable" placeholder="Cargar información..." style="resize: none" data-scroll></textarea>

				              </div>

				            </div>

				            <div class="columnas">

						        <div style="margin:0px">
						          <label>Representante</label>        
						          <input type="checkbox" data-valor="representante" class="reposo-valores-notificaciones check checksmall" style="width: 30px; height: 30px">
						        </div>

					      	</div>

				            <div class="columnas">

						        <div style="margin:0px">
						          <label>Recomendaciones</label>        
						          <input type="checkbox" data-valor="recomendaciones" class="reposo-valores-notificaciones check checksmall" style="width: 30px; height: 30px">
						        </div>

					      	</div>

					      	<div class="columnas">
						        <div>
						          <label>Recomendaciones tiempo</label>
						          <input type="text" data-valor="recomendaciones_tiempo" class="reposo-valores-notificaciones upper">
						        </div>
						    </div>

						    <div class="columnas">

						        <div style="margin: 0px" title="FECHA SOBRE LA CUÁL SE APLICAN LOS DÍAS AL CALCULAR EL REPOSO">
						          <label class="requerido">FECHA INICIAL DEL REPOSO:</label>
						          <input type="date" id="reposos-inicio-notificaciones" data-valor="fecha_inicio" class="reposo-valores-notificaciones lleno textarea-espaciado">
						        </div>
					        
					    	</div>

				            <div class="columnas" style="margin: 5px 0px;">

				              <div style="margin: 0px">
				                <label class="requerido">DÍAS DE REPOSO:</label>
				                <input type="text" data-valor="dias" id="reposos-dias-notificaciones" placeholder="0" class="reposo-valores-notificaciones lleno">
				              </div>
				              
				            </div>

				            <div class="columnas" style="margin: 5px 0px;">

				              <div style="margin: 0px">
				                <label class="requerido">FECHA FINAL DEL REPOSO:</label>
				                <input type="date" data-valor="fecha_final" id="reposos-fin-notificaciones" class="reposo-valores-notificaciones lleno" disabled>
				              </div>
				              
				            </div>

				            <div class="columnas" style="margin: 5px 0px;">
				              <div style="margin-bottom: 5px;">
				                <input type="text" data-valor="fecha_simple" id="reposos-fecha-notificaciones" class="reposo-valores-notificaciones lleno visual" disabled style="height: 20px; padding: 5px; border: 1px dashed #262626">
				              </div>
				            </div>

				          </div>

				          <div class="botones-reportes" style="justify-content: center;">
				            <button class="reporte-actualizar">CONFIRMAR CAMBIOS</button>
				          </div>

				        </div>

				    </div>

				</section>

				<!-------------------------------------------------------- -->
				<!----------------- GENERALES CONTENEDOR ----------------- -->
				<!-------------------------------------------------------- -->
				<section class="notificaciones-seccion" data-hide>
				                
				    <div data-familia class="contenedor contenedor-notificaciones" id="generales-contenedor-notificaciones">

				      <div class="subtitulo">
				        Modificar reporte de información general
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

				          <div id="general-previa-notificaciones" data-scroll></div>

				        </div>
				          
				        <div class="filas" style="height: 100%; position: relative">
				        
				          <div class="columnas" >
				            
				            <div>
				              <label class="requerido">Título</label>
				              <input type="text" id="general-titulo-notificaciones" data-valor="titulo" class="general-valores-notificaciones upper lleno">
				            </div>        

				          </div>

				          <div class="columnas" style="height: 100%;">

				            <div style="height: 100%; margin: 0px">
				              <label class="requerido">Información</label>
				              <textarea id="general-informacion-notificaciones" data-previa="general-previa-notificaciones" data-valor="general" rows="6" class="general-valores-notificaciones upper lleno textarea-espaciado contenedor-personalizable" placeholder="Cargar información..." style="resize: none" data-scroll></textarea>
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