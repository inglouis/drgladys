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
            <input type="text" autocomplete="off"  data-limit="" data-hide>
            <select class="refeditar-valores upper visual" data-valor="id_referencia" disabled style="color:#262626"></select>
          </section>

        </div>

      </div>

      <div class="columnas">
        
        <div>
          <label class="requerido">Motivo de la referencia</label>
          <textarea rows="4" id="refeditar-informacion" data-previa="refeditar-previa" data-valor="referencia" class="refeditar-valores upper lleno textarea-espaciado contenedor-personalizable" style="resize:none; min-height: 30vh;" data-scroll></textarea>
        </div>

      </div>

      <div class="columnas">
        
        <div>
          
          <label>Se recomienda a:</label>
          <section data-grupo="cc-referencias-referido-editar" class="combo-consulta">
            <input type="text" autocomplete="off"  data-limit="" data-hide>
            <select class="refeditar-valores upper visual" data-valor="id_medico_referido" disabled style="color:#262626"></select>
          </section>

        </div>

      </div>

      <div class="columnas" >
              
        <div>
          <label class="requerido">Se agradece:</label>
          <input type="text" data-valor="agradecimiento" class="refeditar-valores upper lleno">
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
<!----------------- referenciaS TEMPLATE ----------------- -->
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

				<label class="crud-titulo">referencia</label>

        <div class="referencia-para crud-reporte"></div>

				<div class="referencia-motivo"></div>

        <div class="referencia-referido"></div>

        <div class="referencia-agradecimiento"></div>

			</div>

	    </div>

	    <div class="crud-datos" title="Click para expandir">
	      Ver más información <b>...</b>

	      <section class="crud-datos-contenedor" data-hidden data-efecto="cerrar">
	      
	      	<div style="border-bottom: 1px solid;">Información</div>

	      	<div class="crud-dato nombre"></div>
	      	<div class="crud-dato cedula"></div>

	      </section>

	    </div>

  	</div>


  </section>

</template>

<!--3)---------------------------------------------------- -->
<!----------------- referenciaS CONTENEDOR --------------- -->
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
            
            <div class="columnas" >

              <div>
                
                <label class="requerido">Referencia para:</label>
                <section data-grupo="cc-referencias-referencia-insertar" class="combo-consulta">
                  <input type="text" autocomplete="off"  data-limit="" data-hide>
                  <select class="referencia-valores upper visual" data-valor="id_referencia" disabled style="color:#262626"></select>
                </section>

              </div>

            </div>

            <div class="columnas">
              
              <div>
                <label class="requerido">Motivo de la referencia</label>
                <textarea rows="4" id="referencia-informacion" data-previa="referencia-previa" data-valor="referencia" class="referencia-valores upper lleno textarea-espaciado contenedor-personalizable" style="resize:none; min-height: 30vh;" data-scroll></textarea>
              </div>

            </div>

            <div class="columnas">
              
              <div>
                
                <label>Se recomienda a:</label>
                <section data-grupo="cc-referencias-referido-insertar" class="combo-consulta">
                  <input type="text" autocomplete="off"  data-limit="" data-hide>
                  <select class="referencia-valores upper visual" data-valor="id_medico_referido" disabled style="color:#262626"></select>
                </section>

              </div>

            </div>

            <div class="columnas" >
                    
              <div>
                <label class="requerido">
                  Se agradece:

                  <div id="referencia-agradecimientos">
                    <button class="btn btn-general tooltip-filtro" data-identificador="agradecimiento1">
                      A
                    </button>

                    <button class="btn btn-general tooltip-filtro" data-identificador="agradecimiento2">
                      B
                    </button>
                  </div>

                </label>
                <input type="text" data-valor="agradecimiento" class="referencia-valores upper lleno">
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