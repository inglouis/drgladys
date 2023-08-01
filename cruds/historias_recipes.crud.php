<!--//////////////////////////////////////////////////////////////////////////////////-->
<!--////////////////////////  RECIPES TEMPLATE //////////////////////////////////-->
<!--//////////////////////////////////////////////////////////////////////////////////-->

<template id="recipes-template">

  <section class="recipes-contenido">

    <div style="display: flex; flex-direction: column">
    	
    	<div class="recipes-subtitulo">
    		DESCRIPCIÓN:

    		<div class="recipes-botones">

          <button class="editar btn btn-editar" style="
            width: 20px !important;
            height: 20px !important;
            padding: 2px;
            top: -3px;
            position: relative;
            right: 10px;
          ">
            <svg class="iconos-b" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
              <path fill="currentColor" d="M497.9 142.1l-46.1 46.1c-4.7 4.7-12.3 4.7-17 0l-111-111c-4.7-4.7-4.7-12.3 0-17l46.1-46.1c18.7-18.7 49.1-18.7 67.9 0l60.1 60.1c18.8 18.7 18.8 49.1 0 67.9zM284.2 99.8L21.6 362.4.4 483.9c-2.9 16.4 11.4 30.6 27.8 27.8l121.5-21.3 262.6-262.6c4.7-4.7 4.7-12.3 0-17l-111-111c-4.8-4.7-12.4-4.7-17.1 0zM124.1 339.9c-5.5-5.5-5.5-14.3 0-19.8l154-154c5.5-5.5 14.3-5.5 19.8 0s5.5 14.3 0 19.8l-154 154c-5.5 5.5-14.3 5.5-19.8 0zM88 424h48v36.3l-64.5 11.3-31.1-31.1L51.7 376H88v48z"></path>
            </svg>          
          </button>

      		<button class="reimprimir btn btn-general" style="
      			width: 20px !important;
  			    height: 20px !important;
  			    padding: 2px;
  			    top: -3px;
  			    position: relative;
  			    right: 5px;
      		">
      			<svg class="iconos-b" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
      				<path fill="currentColor" d="M448 192V77.25c0-8.49-3.37-16.62-9.37-22.63L393.37 9.37c-6-6-14.14-9.37-22.63-9.37H96C78.33 0 64 14.33 64 32v160c-35.35 0-64 28.65-64 64v112c0 8.84 7.16 16 16 16h48v96c0 17.67 14.33 32 32 32h320c17.67 0 32-14.33 32-32v-96h48c8.84 0 16-7.16 16-16V256c0-35.35-28.65-64-64-64zm-64 256H128v-96h256v96zm0-224H128V64h192v48c0 8.84 7.16 16 16 16h48v96zm48 72c-13.25 0-24-10.75-24-24 0-13.26 10.75-24 24-24s24 10.74 24 24c0 13.25-10.75 24-24 24z"></path>
      			</svg>
      		</button>

      		<button class="eliminar btn btn-eliminar" style="
      			width: 20px !important;
  			    height: 20px !important;
  			    padding: 2px;
  			    top: -3px;
  			    position: relative;
      		">
      			<svg class="iconos-b" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M32 464a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128H32zm272-256a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zm-96 0a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zm-96 0a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zM432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16z"></path></svg>
      		</button>

    		</div>

    	</div>

      <div class="recipes-informacion">
        
        <label>RÉCIPE</label>

        <div class="recipes-recipe">
          
        </div>

      </div>

      <div class="recipes-informacion">
        
        <label>INDICACIÓN</label>

        <div class="recipes-indicacion">
          
        </div>

      </div>

    </div>


    <div class="recipes-datos" title="Click para expandir">
      Ver más información <b>...</b>

      <section class="recipes-datos-contenedor" data-hidden data-efecto="cerrar">
      
      	<div style="border-bottom: 1px solid;">HISTORIAL DE DATOS AL MOMENTO DE GENERAR EL REPORTE</div>

      	<div class="recipes-dato recipe-nombre"></div>
      	<div class="recipes-dato recipe-apellido"></div>
      	<div class="recipes-dato recipe-cedula"></div>
      	<div class="recipes-dato recipe-direccion"></div>
      	<div class="recipes-dato recipe-edad"></div>
        <div class="recipes-dato recipe-peso"></div>
        <div class="recipes-dato recipe-talla"></div>

      </section>

    </div>

  </section>

</template>

<!-------------------------------------------------------- -->
<!----------------------- recipes ------------------- -->
<!-------------------------------------------------------- -->
<div id="crud-recipes-popup" class="popup-oculto" data-crud='popup'>
  <div id="crud-recipes-pop" class="popup-oculto" data-scroll>

    <button id="crud-recipes-cerrar" data-crud='cerrar'>X</button>

    <section id="crud-recipes-titulo" data-crud='titulo' class='titulo'>
      
      <div>
        Listado de <b>RÉCIPES</b>
      </div>

      <div class="valor-cabecera">
        
        <div style="width: fit-content; padding-right: 5px">
          <label>Nombres y apellidos:</label>
          <input type="text" data-valor="nombre_completo" class="recipes-cargar upper visual" disabled style="width: 200px;">
        </div>

        <div style="width: fit-content;">
          <label>Cédula:</label>
          <input type="text" data-valor="cedula" class="recipes-cargar upper visual" disabled style="width: 80px;">
        </div>

      </div>

    </section>

    <section id="crud-recipes-contenedor" class="contenedor-reportes">
      
      <div class="izquierda">

        <div class="subtitulo" title="[TAB] para enforcar">
          Cargar nuevo récipe

          <button id="recipes-limpiar" title="Limpiar Contenido" data-crud="limpiar">
            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="trash-alt" class="svg-inline--fa fa-trash-alt fa-w-14 iconos-b" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M32 464a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128H32zm272-256a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zm-96 0a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zm-96 0a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zM432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16z"></path></svg>
          </button>
        </div>

        <div class="cargar">

          <div id="crud-recipes-personalizacion" data-hidden>

            <section>Personalización</section>
            <section style="width: 100%; border: 1px dashed #fff"></section>
            <span>ENTER: SEPARAR LÍNEA</span>
            <span>°CENTRAR°</span>
            <span>*<b>NEGRITA</b>*</span>
            <span>_<u>SUBRAYADO</u>_</span>
            <span>~<i>ITÁLICA</i>~</span>

            <div id="recipes-previa-recipes" data-scroll data-hidden style="text-transform: none;"></div>
            <div id="recipes-previa-indicaciones" data-scroll data-hidden style="text-transform: none;"></div>

          </div>
            
          <div class="filas" style="height: 100%; position: relative">
          
            <div class="columnas" style="height: 100%;">
              
              <div style="height: 100%; margin: 0px">
                
                <label class="requerido">Récipe</label>
                <textarea id="recipes-enfocar" data-previa="recipes-previa-recipes" rows="6" placeholder="CARGAR INFORMACIÓN..." class="recipes-valores lleno textarea-espaciado contenedor-personalizable" style="resize: none" data-scroll></textarea>

              </div>

            </div>

            <div class="columnas" style="height: 100%;">
              
              <div style="height: 100%; margin: 0px">
                
                <label class="requerido">Indicaciones</label>
                <textarea id="recipes-indicaciones" data-previa="recipes-previa-indicaciones" rows="6" placeholder="CARGAR INFORMACIÓN..." class="recipes-valores lleno textarea-espaciado contenedor-personalizable" style="resize: none" data-scroll></textarea>

              </div>

            </div>

          </div>

          <div id="recipes-procesar" class="botones-reportes">
            <button class="reporte-cargar">CARGAR</button>
            <button class="reporte-previa">PREVIA</button>
          </div>

        </div>

        <!------------------------------- PREVIA DE recipes ------------------------------------->
        <div id="recipes-previa-desplegable" class="desplegable-oculto">
          
          <section>

            <div id="recipes-iframe-contenedor">
              <iframe src="" id="recipes-iframe"></iframe>
            </div>

            <div>
              <button id="recipes-previa-cerrar" class='desplegable-cerrar'>
                <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="caret-left" class="svg-inline--fa fa-caret-left fa-w-6 iconos" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 192 512"><path fill="currentColor" d="M192 127.338v257.324c0 17.818-21.543 26.741-34.142 14.142L29.196 270.142c-7.81-7.81-7.81-20.474 0-28.284l128.662-128.662c12.599-12.6 34.142-3.676 34.142 14.142z"></path></svg>
              </button>
            </div>
            
          </section>

        </div>

      </div>

      <div class="derecha">

        <div class="busqueda-estilizada">

          <input type="text" id="recipes-busqueda" autocomplete="off" class="upper borde-estilizado">

        </div>

        <div class="tabla-ppal borde-estilizado" data-scroll>

          <table id="tabla-recipes" class="table table-bordered table-striped">
            <thead>
            </thead>
            <tbody>
            </tbody>
          </table>
          
        </div>

      </div>

    </section>
    
  </div>

</div>

<!-------------------------------------------------------- -->
<!---------------- RECIPES EDITAR ------------------- -->
<!-------------------------------------------------------- -->
<div id="crud-receditar-popup" class="popup-oculto" data-crud='popup'>
  <div id="crud-receditar-pop" class="popup-oculto" style="width:50%">

    <button id="crud-receditar-cerrar" data-crud='cerrar'>X</button>

    <section id="crud-receditar-titulo" data-crud='titulo'>
      EDITAR RÉCIPE
    </section>

    <div class="filas" style="height: fit-content; position:relative;">

      <div id="crud-receditar-personalizacion" data-hidden>

        <section>Personalización</section>
        <section style="width: 100%; border: 1px dashed #fff"></section>
        <span>ENTER: SEPARAR LÍNEA</span>
        <span>°CENTRAR°</span>
        <span>*<b>NEGRITA</b>*</span>
        <span>_ <u>SUBRAYADO</u> _</span>
        <span>~<i>ITÁLICA</i>~</span>

        <div id="receditar-previa-recipes" data-scroll data-hidden style="text-transform: none;"></div>
        <div id="receditar-previa-indicaciones" data-scroll data-hidden style="text-transform: none;"></div>

      </div>

      <div class="columnas">
        
        <div>
          <label>Récipe</label>
          <textarea id="receditar-recipes" data-previa="receditar-previa-recipes" rows="4" data-valor="recipe" class="receditar-valores lleno textarea-espaciado contenedor-personalizable" style="resize:none; min-height: 30vh;" data-scroll></textarea>
        </div>

        <div>
          <label>Indicaciones</label>
          <textarea id="receditar-indicaciones" data-previa="receditar-previa-indicaciones" rows="4" data-valor="indicacion" class="receditar-valores lleno textarea-espaciado contenedor-personalizable" style="resize:none; min-height: 30vh;" data-scroll></textarea>
        </div>

      </div>

    </div>

    <section id="crud-receditar-botones" data-crud='botones' style="column-gap:5px">
      <button class="botones-formularios confirmar btn-editar">CONFIRMAR</button>
      <button class="botones-formularios cerrar">CANCELAR</button>
    </section>

  </div>
</div>

<!-------------------------------------------------------- -->
<!-------------- recipes ELIMINAR ------------------- -->
<!-------------------------------------------------------- -->
<div id="crud-receliminar-popup" class="popup-oculto" data-crud='popup'>
  <div id="crud-receliminar-pop" class="popup-oculto">

    <button id="crud-receliminar-cerrar" data-crud='cerrar'>X</button>

    <section id="crud-receliminar-titulo" data-crud='titulo'>
      ¿DESEA ELIMINAR EL RÉCIPE?
    </section>

    <section id="crud-receliminar-botones" data-crud='botones' style="padding-top: 10px; column-gap: 5px;">
      <button class="botones-formularios eliminar">ELIMINAR</button>
      <button class="botones-formularios cerrar">CANCELAR</button>
    </section>

  </div>
</div>

<!-------------------------------------------------------- -->
<!------------------ RECIPES PREVIA ---------------------- -->
<!-------------------------------------------------------- -->
<div id="crud-recprevia-popup" class="popup-oculto" data-crud='popup'>
  <div id="crud-recprevia-pop" class="popup-oculto">

    <button id="crud-recprevia-cerrar" data-crud='cerrar'>X</button>

    <section id="crud-recprevia-titulo" data-crud='titulo' style="display: flex; justify-content: center;">
      VISTA PREVIA DEL RÉCIPE & INDICACIÓN
    </section>

    <section id="crud-recprevia-reporte" class="reportes-previa-iframe">
      <iframe src=""></iframe>
    </section>

    <section id="crud-recprevia-botones" data-crud='botones' style="padding-top: 10px; column-gap: 5px;">
      <button class="botones-formularios imprimir">IMPRIMIR</button>
      <button class="botones-formularios cerrar">CANCELAR</button>
    </section>

  </div>
</div>