<!--1)---------------------------------------------------- -->
<!---------------- referenciaS EDITAR -------------------- -->
<!-------------------------------------------------------- -->
<div id="crud-refeditar-popup" class="popup-oculto" data-crud='popup'>
  <div id="crud-refeditar-pop" class="popup-oculto" style="width:30%; min-width: 300px">

    <button id="crud-refeditar-cerrar" data-crud='cerrar'>X</button>

    <section id="crud-refeditar-titulo" data-crud='titulo'>
      EDITAR REFERENCIAS
    </section>

    <div class="filas" style="height: fit-content; position:relative;">

      <div class="personalizacion-b" id="crud-refeditar-personalizacion" data-hidden>
        <section>Personalización</section>
        <section style="width: 100%; border: 1px dashed #fff"></section>
        <span>ENTER: SEPARAR LÍNEA</span>
        <span>°CENTRAR°</span>
        <span>*<b>NEGRITA</b>*</span>
        <span>_ <u>SUBRAYADO</u> _</span>
        <span>~<i>ITÁLICA</i>~</span>

        <div class="previa-b" id="refeditar-previa" data-scroll></div>
      </div>

      <div class="columnas" >

        <div>
          
          <label class="requerido">Referencia para:</label>
          <section data-grupo="cc-referencias-referencia-editar" class="combo-consulta">
            <input type="text" autocomplete="off"  data-limit="" placeholder="Buscar..." class="upper">
            <select class="refeditar-valores upper visual" data-valor="id_referencia" data-scroll style="color:#262626"></select>
          </section>

        </div>

      </div>

      <div class="columnas">
        
        <div>
          <label class="requerido">Motivo de la referencia</label>
          <textarea rows="4" id="refeditar-informacion" data-previa="refeditar-previa" data-valor="motivo" class="refeditar-valores upper lleno textarea-espaciado contenedor-personalizable" style="resize:none; min-height: 15vh;" data-scroll></textarea>
        </div>

      </div>

      <div class="columnas">
        
        <div>
          
          <label>Se recomienda a:</label>
          <section data-grupo="cc-referencias-referido-editar" class="combo-consulta">
            <input type="text" autocomplete="off"  data-limit="" placeholder="Buscar..." class="upper">
            <select class="refeditar-valores upper visual" data-valor="id_medico_referido" data-scroll style="color:#262626"></select>
          </section>

        </div>

      </div>

      <div class="columnas" >
              
        <div>
          <label class="requerido">Se agradece:</label>
          <textarea rows="4" id="refeditar-agradecimiento" data-previa="refeditar-previa" data-valor="agradecimiento" class="refeditar-valores upper lleno textarea-espaciado contenedor-personalizable" style="resize:none; min-height: 15vh;" data-scroll></textarea>
        </div>

      </div>

    </div>

    <section id="crud-refeditar-botones" data-crud='botones' style="column-gap:5px">
      <button class="botones-formularios confirmar btn-editar">CONFIRMAR</button>
      <button class="botones-formularios cerrar">CANCELAR</button>
    </section>

  </div>
</div>

<!--2)---------------------------------------------------- -->
<!----------------- REFERENCIAS TEMPLATE ----------------- -->
<!-------------------------------------------------------- -->
<template id="referencia-template">

  <section class="referencia-crud cruds">

  	<div class="crud-contenido">
  		
	    <div style="display: flex; flex-direction: column">

			<div class="crud-botones">

        <button class="reusar btn btn-reusar" title="Reutilizar información del reporte">
          <?php echo $_SESSION['botones']['reportes_reusar']?>
        </button>

				<button class="editar btn btn-editar" title="Editar reporte">
					<?php echo $_SESSION['botones']['reportes_editar']?>
				</button>

				<button class="reimprimir btn btn-imprimir" title="Reimprimir reporte">
					<?php echo $_SESSION['botones']['reportes_reimprimir']?>
				</button>
				
				<div class="crud-eliminar-contenedor">
					
					<button class="eliminar btn btn-eliminar">
						<?php echo $_SESSION['botones']['reportes_eliminar']?>
					</button>
					
				</div>

			</div>

			<div class="crud-informacion">

        <div class="crud-informacion">
          <label>Referencia para:</label>
          <div class="referencia-referencia"></div>
        </div>

        <div class="crud-informacion">
          <label>Motivo de la referencia</label>
          <div class="referencia-motivo"></div>
        </div>

        <div class="crud-informacion">
          <label>Referido</label>
          <div class="referencia-referido"></div>
        </div>

        <div class="crud-informacion">
          <label>Se agradece:</label>
          <div class="referencia-agradecimiento"></div>
        </div>   

			</div>

	    </div>

	    <div class="crud-datos" title="Click para expandir">
	      Ver más información <b>...</b>

	      <section class="crud-datos-contenedor" data-hidden data-efecto="cerrar">
	      
	      	<div style="border-bottom: 1px solid;">Información</div>

	      	<div class="crud-dato nombre"></div>
          <div class="crud-dato apellido"></div>
          <div class="crud-dato cedula"></div>
          <div class="crud-dato edad"></div>

	      </section>

	    </div>

  	</div>


  </section>

</template>

<!--3)---------------------------------------------------- -->
<!----------------- REFERENCIAS CONTENEDOR --------------- -->
<!-------------------------------------------------------- -->
<section class="reportes-seccion" data-hide>
                
    <div data-familia class="contenedor contenedor-reportes" id="referencias-contenedor">

      <div class="izquierda">

        <div class="subtitulo">
          Cargar nueva referencia

          <button class="limpiar" title="Limpiar Contenido" data-crud="limpiar">
            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="trash-alt" class="svg-inline--fa fa-trash-alt fa-w-14 iconos-b" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M32 464a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128H32zm272-256a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zm-96 0a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zm-96 0a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zM432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16z"></path></svg>
          </button>
        </div>

        <div class="cargar" title="[TAB] para enforcar">

          <div class="personalizacion" data-hidden>

            <section>Personalización</section>
            <section style="width: 100%; border: 1px dashed #fff"></section>
            <span>ENTER: SEPARAR LÍNEA</span>
            <span>°CENTRAR°</span>
            <span>*<b>NEGRITA</b>*</span>
            <span>_ <u>SUBRAYADO</u> _</span>
            <span>~<i>ITÁLICA</i>~</span>

            <div id="referencia-previa" data-scroll></div>

          </div>
            
          <div class="filas" style="height: 100%; position: relative">
            
            <div class="columnas">

              <div>
              
                <label class="requerido">
                  <button id="insertar-nueva-referencia" class="boton-ver contenedor-resaltar" title="Cargar nueva referencia" style="left: 75px; top: 4px">
                    +  
                  </button>
                  Referencia para:
                </label>

                <section data-grupo="cc-referencias-referencia-insertar" class="combo-consulta">
                  <input id="nombre-referencia" type="text" autocomplete="off" data-limit="" placeholder="Buscar..." class="upper">
                  <select class="referencia-valores upper visual lleno" data-valor="id_referencia" data-scroll style="color:#262626"></select>
                </section>

              </div>

            </div>

            <div class="columnas" style="height: 100%">
              
              <div style="height: 100%">
                <label>Motivo de la referencia</label>
                <textarea rows="4" id="referencia-informacion" data-previa="referencia-previa" data-valor="motivo" class="referencia-valores upper textarea-espaciado contenedor-personalizable" style="resize:none;" data-scroll></textarea>
              </div>

            </div>

            <div class="columnas">
              
              <div>

                <label>
                  <button id="insertar-nueva-referido" class="boton-ver contenedor-resaltar" title="Cargar nuevo referido" style="left: 75px; top: 4px">
                    +  
                  </button>
                  Se recomienda a:
                </label>
                    
                <section data-grupo="cc-referencias-referido-insertar" class="combo-consulta">
                  <input id="nombre-referido" type="text" autocomplete="off"  data-limit="" placeholder="Buscar..." class="upper">
                  <select class="referencia-valores upper visual" data-valor="id_medico_referido" data-scroll style="color:#262626"></select>
                </section>

              </div>

            </div>

            <div class="columnas" >
                    
              <div>

              	<div>
                	<label>Se agradece:</label>
                	<div id="referencias-modelos">
	                    <button class="btn btn-general tooltip-filtro" data-identificador="preoperatorio">
          							<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 640 512" class="iconos-b"><path fill="currentColor" d="M320 368c0 59.5 29.5 112.1 74.8 144H128.1c-35.3 0-64-28.7-64-64V287.6H32c-18 0-32-14-32-32.1c0-9 3-17 10-24L266.4 8c7-7 15-8 22-8s15 2 21 7L522.1 193.9c-8.5-1.3-17.3-1.9-26.1-1.9c-54.7 0-103.5 24.9-135.8 64H320V208c0-8.8-7.2-16-16-16H272c-8.8 0-16 7.2-16 16v48H208c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h48v48c0 8.8 7.2 16 16 16h32c8.8 0 16-7.2 16-16zM496 224a144 144 0 1 1 0 288 144 144 0 1 1 0-288zm0 240a24 24 0 1 0 0-48 24 24 0 1 0 0 48zm0-192c-8.8 0-16 7.2-16 16v80c0 8.8 7.2 16 16 16s16-7.2 16-16V288c0-8.8-7.2-16-16-16z"/></svg>
          							</button>
          						<button class="btn btn-general tooltip-filtro" data-identificador="rx">
          							<svg clas="iconos-b" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><path fill="currentColor" d="M0 64C0 46.3 14.3 32 32 32H480c17.7 0 32 14.3 32 32s-14.3 32-32 32V416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32V96C14.3 96 0 81.7 0 64zM256 96c-8.8 0-16 7.2-16 16v32H160c-8.8 0-16 7.2-16 16s7.2 16 16 16h80v48H128c-8.8 0-16 7.2-16 16s7.2 16 16 16H240v70.6L189.1 307c-5.2-2-10.6-3-16.2-3h-2.1c-23.6 0-42.8 19.2-42.8 42.8c0 9.6 3.2 18.9 9.1 26.4l18.2 23.2c9.7 12.4 24.6 19.6 40.3 19.6H316.4c15.7 0 30.6-7.2 40.3-19.6l18.2-23.2c5.9-7.5 9.1-16.8 9.1-26.4c0-23.6-19.2-42.8-42.8-42.8H339c-5.5 0-11 1-16.2 3L272 326.6V256H384c8.8 0 16-7.2 16-16s-7.2-16-16-16H272V176h80c8.8 0 16-7.2 16-16s-7.2-16-16-16H272V112c0-8.8-7.2-16-16-16zM208 352a16 16 0 1 1 0 32 16 16 0 1 1 0-32zm80 16a16 16 0 1 1 32 0 16 16 0 1 1 -32 0z"/></svg>
          						</button>
          						<button class="btn btn-general tooltip-filtro" data-identificador="cardiovascular">
          							<svg class="iconos-b" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><path fill="currentColor" d="M228.3 469.1L47.6 300.4c-4.2-3.9-8.2-8.1-11.9-12.4h87c22.6 0 43-13.6 51.7-34.5l10.5-25.2 49.3 109.5c3.8 8.5 12.1 14 21.4 14.1s17.8-5 22-13.3L320 253.7l1.7 3.4c9.5 19 28.9 31 50.1 31H476.3c-3.7 4.3-7.7 8.5-11.9 12.4L283.7 469.1c-7.5 7-17.4 10.9-27.7 10.9s-20.2-3.9-27.7-10.9zM503.7 240h-132c-3 0-5.8-1.7-7.2-4.4l-23.2-46.3c-4.1-8.1-12.4-13.3-21.5-13.3s-17.4 5.1-21.5 13.3l-41.4 82.8L205.9 158.2c-3.9-8.7-12.7-14.3-22.2-14.1s-18.1 5.9-21.8 14.8l-31.8 76.3c-1.2 3-4.2 4.9-7.4 4.9H16c-2.6 0-5 .4-7.3 1.1C3 225.2 0 208.2 0 190.9v-5.8c0-69.9 50.5-129.5 119.4-141C165 36.5 211.4 51.4 244 84l12 12 12-12c32.6-32.6 79-47.5 124.6-39.9C461.5 55.6 512 115.2 512 185.1v5.8c0 16.9-2.8 33.5-8.3 49.1z"/></svg>
          						</button>
          						<button class="btn btn-general tooltip-filtro" data-identificador="pediatrica">
          							<svg class="iconos-b" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 384 512"><path fill="currentColor" d="M256 64A64 64 0 1 0 128 64a64 64 0 1 0 128 0zM152.9 169.3c-23.7-8.4-44.5-24.3-58.8-45.8L74.6 94.2C64.8 79.5 45 75.6 30.2 85.4s-18.7 29.7-8.9 44.4L40.9 159c18.1 27.1 42.8 48.4 71.1 62.4V480c0 17.7 14.3 32 32 32s32-14.3 32-32V384h32v96c0 17.7 14.3 32 32 32s32-14.3 32-32V221.6c29.1-14.2 54.4-36.2 72.7-64.2l18.2-27.9c9.6-14.8 5.4-34.6-9.4-44.3s-34.6-5.5-44.3 9.4L291 122.4c-21.8 33.4-58.9 53.6-98.8 53.6c-12.6 0-24.9-2-36.6-5.8c-.9-.3-1.8-.7-2.7-.9z"/></svg>
          						</button>
          						<button class="btn btn-general tooltip-filtro" data-identificador="estrabismo">
          							E
          						</button>
	                </div>
              	</div>
              	<textarea rows="4" id="referencia-agradecimiento" data-previa="referencia-previa" data-valor="agradecimiento" class="referencia-valores upper textarea-espaciado contenedor-personalizable referencia-agradecimiento" style="resize:none; min-height: 15vh;" data-scroll></textarea>
              </div>

            </div>

          </div>

          <div class="botones-reportes">

            <?php 
              if ($_SESSION['usuario']['rol'] == 'DOCTOR') {
            ?>
              <button class="reporte-notificar" title="Envía una notificación de revisión y modificación del reporte al doctor/a" data-hidden>
                <svg style="width: 15px; height: 15px;" class="iconos" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><path fill="currentColor" d="M64 32C64 14.3 49.7 0 32 0S0 14.3 0 32V64 368 480c0 17.7 14.3 32 32 32s32-14.3 32-32V352l64.3-16.1c41.1-10.3 84.6-5.5 122.5 13.4c44.2 22.1 95.5 24.8 141.7 7.4l34.7-13c12.5-4.7 20.8-16.6 20.8-30V66.1c0-23-24.2-38-44.8-27.7l-9.6 4.8c-46.3 23.2-100.8 23.2-147.1 0c-35.1-17.6-75.4-22-113.5-12.5L64 48V32z"/></svg>
              </button>
            <?php 
              } else if ($_SESSION['usuario']['rol'] == 'ADMINISTRACION') {
            ?>
              <button class="reporte-notificar" title="Envía una notificación de revisión y modificación del reporte al doctor/a">
                <svg style="width: 15px; height: 15px;" class="iconos" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><path fill="currentColor" d="M64 32C64 14.3 49.7 0 32 0S0 14.3 0 32V64 368 480c0 17.7 14.3 32 32 32s32-14.3 32-32V352l64.3-16.1c41.1-10.3 84.6-5.5 122.5 13.4c44.2 22.1 95.5 24.8 141.7 7.4l34.7-13c12.5-4.7 20.8-16.6 20.8-30V66.1c0-23-24.2-38-44.8-27.7l-9.6 4.8c-46.3 23.2-100.8 23.2-147.1 0c-35.1-17.6-75.4-22-113.5-12.5L64 48V32z"/></svg>
              </button>

              <div style="
                width: 1px;
                height: 100%;
                border-left: 2px dashed #ff8101;
              "></div>
            <?php 
              }
            ?>

            <button class="reporte-cargar">CARGAR</button>
            <button class="reporte-previa">PREVIA</button>
          </div>

        </div>

        <!------------------------ PREVIA -------------------------- -->
        <!---------------------------------------------------------- -->
        <div class="desplegable-oculto desplegable-contenedor">
          
          <section>

            <div>
              <iframe src="" class="desplegable-iframe"></iframe>
            </div>

            <div>
              <button class='desplegable-cerrar'>
                <?php echo $_SESSION['botones']['desplegable_cerrar']?>
              </button>
            </div>
            
          </section>

        </div>

      </div>

      <div class="derecha">

        <div class="busqueda-estilizada">

          <input type="text" autocomplete="off" id="referencia-busqueda" class="upper borde-estilizado boton-busqueda">

        </div>

        <div class="tabla-ppal borde-estilizado" data-scroll>

          <table id="tabla-referencias" class="table table-bordered table-striped">
            <thead>
            </thead>
            <tbody>
            </tbody>
          </table>
          
        </div>

      </div>

    </div>

</section>

<!-------------------------------------------------------- -->
<!--------------- INSERTAR REFERENCIA -------------------- -->
<!-------------------------------------------------------- -->
<div id="crud-insertar-referencia-popup" class="popup-oculto" data-crud='popup'>

  <div id="crud-insertar-referencia-pop" class="popup-oculto" style="width:50%; min-width:600px ;height: fit-content;">

    <button id="crud-insertar-referencia-cerrar" data-crud='cerrar'>X</button>

    <section id="crud-insertar-referencia-titulo" data-crud='titulo'>
      Insertar referencia
    </section> 

    <section class="filas">

      <div class="columnas" style="width:100%;">

        <div>
          <label class="requerido">Descripción de la referencia</label>  
          <input type="text" data-valor="nombre" size="100" minlength="1" maxlength="100" class="insertar-referencia-valores lleno upper">
        </div>

      </div>  

      <div class="columnas">

        <div>
          <label class="requerido">Descripción de la referencia</label>
          <textarea  data-valor="descripcion" minlength="1" maxlength="600" class="insertar-referencia-valores lleno upper" style="resize: none" rows="4"></textarea> 
        </div>

      </div> 

    </section>

    <section id="crud-insertar-referencia-botones" data-crud='botones' style="column-gap: 10px; padding: 10px;">
      <button class="botones-formularios insertar">CONFIRMAR</button>
      <button class="botones-formularios cerrar">CANCELAR</button> 
    </section>
  </div> 
</div>

<!-------------------------------------------------------- -->
<!------------------ INSERTAR REFERIDOS ------------------ -->
<!-------------------------------------------------------- -->
<div id="crud-insertar-referido-popup" class="popup-oculto" data-crud='popup'>

  <div id="crud-insertar-referido-pop" class="popup-oculto" style="width:50%; min-width:600px ;height: fit-content;">

    <button id="crud-insertar-referido-cerrar" data-crud='cerrar'>X</button>

    <section id="crud-insertar-referido-titulo" data-crud='titulo'>
      Insertar médico referido
    </section> 

    <section class="filas">

      <div class="columnas" style="width:100%;">

        <div>
          <label class="requerido">Nombre del médico</label>  
          <input id="nombre-referido" type="text" data-valor="nombre" minlength="1" maxlength="100" class="insertar-referido-valores lleno upper">
        </div>

      </div>  

    </section>

    <section id="crud-insertar-referido-botones" data-crud='botones' style="column-gap: 10px; padding: 10px;">
      <button class="botones-formularios insertar">CONFIRMAR</button>
      <button class="botones-formularios cerrar">CANCELAR</button> 
    </section>
  </div> 
</div>