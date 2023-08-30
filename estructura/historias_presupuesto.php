<!--1)---------------------------------------------------- -->
<!---------------- presupuestoS EDITAR -------------------- -->
<!-------------------------------------------------------- -->
<div id="crud-preeditar-popup" class="popup-oculto" data-crud='popup'>
  <div id="crud-preeditar-pop" class="popup-oculto" style="width:30%; min-width: 300px">

    <button id="crud-preeditar-cerrar" data-crud='cerrar'>X</button>

    <section id="crud-preeditar-titulo" data-crud='titulo'>
      EDITAR PRESUPUESTO
    </section>

    <div class="filas" style="height: fit-content; position:relative;">

      <div class="personalizacion-b" id="crud-preeditar-personalizacion" data-hidden>
        <section>Personalización</section>
        <section style="width: 100%; border: 1px dashed #fff"></section>
        <span>ENTER: SEPARAR LÍNEA</span>
        <span>°CENTRAR°</span>
        <span>*<b>NEGRITA</b>*</span>
        <span>_ <u>SUBRAYADO</u> _</span>
        <span>~<i>ITÁLICA</i>~</span>

        <div class="previa-b" id="preeditar-previa" data-scroll></div>
      </div>

      <div class="columnas" >

        <div>
          <label class="requerido">Nombre completo</label>
          <input type="text" data-valor="nombre_completo" class="preeditar-valores upper lleno">
        </div>

      </div>

      <div class="columnas">
         <div>
          <label class="requerido">Cédula</label>
          <input type="text" data-valor="cedula" class="preeditar-valores upper lleno">
        </div>
      </div>

      <div class="columnas">
        
        <div>
          <label class="requerido">presupuesto</label>
          <textarea rows="4" id="preeditar-informacion" data-previa="preeditar-previa" data-valor="presupuesto" class="preeditar-valores upper lleno textarea-espaciado contenedor-personalizable" style="resize:none; min-height: 30vh;" data-scroll></textarea>
        </div>

      </div>

    </div>

    <section id="crud-preeditar-botones" data-crud='botones' style="column-gap:5px">
      <button class="botones-formularios confirmar btn-editar">CONFIRMAR</button>
      <button class="botones-formularios cerrar">CANCELAR</button>
    </section>

  </div>
</div>

<!--2)---------------------------------------------------- -->
<!----------------- presupuestoS TEMPLATE ----------------- -->
<!-------------------------------------------------------- -->
<template id="presupuesto-template">

  <section class="presupuesto-crud cruds">

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

				<label class="crud-titulo">presupuesto</label>

				<div class="presupuesto crud-reporte">
				  
				</div>

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
<!----------------- presupuestoS CONTENEDOR --------------- -->
<!-------------------------------------------------------- -->
<section class="reportes-seccion" data-hide>
                
    <div data-familia class="contenedor contenedor-reportes" id="presupuestos-contenedor">

      <div class="izquierda">

        <div class="subtitulo">
          Cargar nuevo presupuesto

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

            <div id="presupuesto-previa" data-scroll></div>

          </div>
            
          <div class="filas" style="height: 100%; position: relative">
            
            <div class="columnas">
              <div id="presupuesto-representante">
                <button class="btn btn-general tooltip-filtro" data-identificador="paciente">
                  <svg class="iconos-b" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 384 512"><path fill="currentColor" d="M256 64A64 64 0 1 0 128 64a64 64 0 1 0 128 0zM152.9 169.3c-23.7-8.4-44.5-24.3-58.8-45.8L74.6 94.2C64.8 79.5 45 75.6 30.2 85.4s-18.7 29.7-8.9 44.4L40.9 159c18.1 27.1 42.8 48.4 71.1 62.4V480c0 17.7 14.3 32 32 32s32-14.3 32-32V384h32v96c0 17.7 14.3 32 32 32s32-14.3 32-32V221.6c29.1-14.2 54.4-36.2 72.7-64.2l18.2-27.9c9.6-14.8 5.4-34.6-9.4-44.3s-34.6-5.5-44.3 9.4L291 122.4c-21.8 33.4-58.9 53.6-98.8 53.6c-12.6 0-24.9-2-36.6-5.8c-.9-.3-1.8-.7-2.7-.9z"/></svg>
                </button>
                <button class="btn btn-general tooltip-filtro" data-identificador="representante">
                  <svg  class="iconos-b" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><path fill="currentColor" d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z"/></svg>
                </button>
              </div>
            </div>

            <div class="columnas" >
              
              <div>
                <label class="requerido">Nombre completo</label>
                <input type="text" data-valor="nombre_completo" class="presupuesto-valores upper lleno presupuesto-representante-valores">
              </div>

            </div>

            <div class="columnas" >
              
              <div>
                <label class="requerido">Cédula</label>
                <input type="text" data-valor="cedula" class="presupuesto-valores upper lleno presupuesto-representante-valores">
              </div>        

            </div>

            <div class="columnas" style="height: 100%">
              
              <div style="height: 100%; margin: 0px">
                
                <label class="requerido">Presupuesto</label>
                <textarea id="presupuesto-informacion" data-previa="presupuesto-previa" data-valor="presupuesto" rows="6" class="presupuesto-valores upper lleno textarea-espaciado contenedor-personalizable" placeholder="Cargar información..." style="resize: none" data-scroll></textarea>

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

          <input type="text" autocomplete="off" id="presupuesto-busqueda" class="upper borde-estilizado boton-busqueda">

        </div>

        <div class="tabla-ppal borde-estilizado" data-scroll>

          <table id="tabla-presupuesto" class="table table-bordered table-striped">
            <thead>
            </thead>
            <tbody>
            </tbody>
          </table>
          
        </div>

      </div>

    </div>

</section>