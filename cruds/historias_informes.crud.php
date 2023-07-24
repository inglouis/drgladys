<!--//////////////////////////////////////////////////////////////////////////////////-->
<!--////////////////////////  INFORMES TEMPLATE //////////////////////////////////-->
<!--//////////////////////////////////////////////////////////////////////////////////-->

<template id="informes-template">

  <section class="informes-contenido">

    <div style="display: flex; flex-direction: column">
    	
    	<div class="informes-subtitulo">
    		DESCRIPCIÓN:

    		<div class="informes-botones">

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

      <div class="informes-informacion">
        
        <label>MOTIVO</label>

        <div class="informes-motivo">
        	
        </div>

      </div>

      <div class="informes-informacion">
        
        <label>ENFERMEDAD</label>

        <div class="informes-enfermedad">
          
        </div>

      </div>

      <div class="informes-informacion">
        
        <label>PLAN</label>

        <div class="informes-plan">
          
        </div>

      </div>

      <div class="informes-informacion">
        
        <label>Diagnósticos</label>

        <div class="informes-diagnostico" style="display: flex; font-weight: bold; color: green; flex-direction: column;">
          
        </div>

      </div>

    </div>


    <div class="informes-datos" title="Click para expandir">
      Ver más información <b>...</b>

      <section class="informes-datos-contenedor" data-hidden data-efecto="cerrar">
      
      	<div style="border-bottom: 1px solid;">HISTORIAL DE DATOS AL MOMENTO DE GENERAR EL REPORTE</div>

      	<div class="informes-dato informe-nombre"></div>
      	<div class="informes-dato informe-apellido"></div>
      	<div class="informes-dato informe-cedula"></div>
      	<div class="informes-dato informe-direccion"></div>
      	<div class="informes-dato informe-edad"></div>
        <div class="informes-dato informe-peso"></div>
        <div class="informes-dato informe-talla"></div>

      </section>

    </div>

  </section>

</template>

<!-------------------------------------------------------- -->
<!----------------------- INFORMES ------------------- -->
<!-------------------------------------------------------- -->
<div id="crud-informes-popup" class="popup-oculto" data-crud='popup'>
  <div id="crud-informes-pop" class="popup-oculto" data-scroll>

    <button id="crud-informes-cerrar" data-crud='cerrar'>X</button>

    <section id="crud-informes-titulo" data-crud='titulo' class='titulo'>
      
      <div>
        Listado de <b>INFORMES</b>
      </div>

      <div class="valor-cabecera">
        
        <div style="width: fit-content; padding-right: 5px">
          <label>Nombres y apellidos:</label>
          <input type="text" data-valor="nombre_completo" class="informes-cargar upper visual" disabled style="width: 200px;">
        </div>

        <div style="width: fit-content;">
          <label>Cédula:</label>
          <input type="text" data-valor="cedula" class="informes-cargar upper visual" disabled style="width: 80px;">
        </div>

      </div>

    </section>

    <section id="crud-informes-contenedor" class="contenedor-reportes">
      
      <div class="izquierda">

        <div class="subtitulo" title="[TAB] para enforcar">
          Cargar nuevo informe

          <button id="informes-limpiar" title="Limpiar Contenido" data-crud="limpiar">
            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="trash-alt" class="svg-inline--fa fa-trash-alt fa-w-14 iconos-b" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M32 464a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128H32zm272-256a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zm-96 0a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zm-96 0a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zM432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16z"></path></svg>
          </button>
        </div>

        <div class="cargar">

          <div id="crud-informes-personalizacion" data-hidden>

            <section>Personalización</section>
            <section style="width: 100%; border: 1px dashed #fff"></section>
            <span>ENTER: SEPARAR LÍNEA</span>
            <span>°CENTRAR°</span>
            <span>*<b>NEGRITA</b>*</span>
            <span>_ <u>SUBRAYADO</u> _</span>
            <span>~<i>ITÁLICA</i>~</span>

            <div id="informes-previa-motivo" data-scroll data-hidden></div>
            <div id="informes-previa-enfermedad" data-scroll data-hidden></div>
            <div id="informes-previa-plan" data-scroll data-hidden></div>

          </div>
            
          <div class="filas" style="height: 100%; position: relative;">
          
            <div class="columnas" style="height: 100%; flex-direction: column;">
              
              <div style="height: 100%; margin: 0px">
                
                <label class="requerido">Motivo</label>
                <textarea id="informes-enfocar"  data-previa="informes-previa-motivo" rows="3" class="informes-valores upper lleno textarea-espaciado contenedor-personalizable" placeholder="Cargar información..." style="resize: none" data-scroll></textarea>

              </div>

              <div style="height: 100%; margin: 0px">
                
                <label>Enfermedad</label>
                <textarea rows="3" id="informes-enfermedad" data-previa="informes-previa-enfermedad" class="informes-valores upper textarea-espaciado contenedor-personalizable" placeholder="Cargar información..." style="resize: none" data-scroll></textarea>

              </div>

              <div style="height: 100%; margin: 0px">
                
                <label>Plan</label>
                <textarea rows="3" id="informes-plan" data-previa="informes-previa-plan" class="informes-valores upper textarea-espaciado contenedor-personalizable" placeholder="Cargar información..." style="resize: none" data-scroll></textarea>

              </div>

              <div style="position:relative;">

                <button id="insertar-nueva-diagnostico" class="boton-ver contenedor-resaltar" title="Cargar nuevo diagnóstico" style="left: 105px;">+</button>

                <label class="requerido">Diagnóstico</label>
                
                <style>
                  #cc-diagnosticos-informes .ccContenedor {
                     width: 95%;
                  }
                </style>  

                <section id="cc-diagnosticos-informes" class="contenedor-consulta informes-valores lleno borde-estilizado" data-valor="diagnosticos">

                  <input type="text" data-estilo="cc-input" class="upper" data-minimo="0" data-ocultar="0" placeholder="Buscar diagnósticos" title="[ENTER] para forzar actualización">
                  <select id="informe-combo" data-limit="" data-estilo="cc-select" placeholder="Buscar diagnóstico" data-size="5" data-ocultar="1" data-hide data-absoluto="1" data-scroll style="
                    height: fit-content;
                    border: 1px dashed #ec6464;
                    border-top: none;
                    background: #ffdddd;
                    padding: 5px;
                    margin: 0px;
                    color: black;
                  "></select>
                  <div data-estilo="cc-div" style="background: #fff; min-height: 80px; max-height: 85px; border: none;" data-scroll></div>

                </section>

              </div>
      
            </div>

          </div>

          <div id="informes-procesar" class="botones-reportes">
            <button class="reporte-cargar">CARGAR</button>
            <button class="reporte-previa">PREVIA</button>
          </div>

        </div>

        <!------------------------------- PREVIA DE informes ------------------------------------->
        <div id="informes-previa-desplegable" class="desplegable-oculto">
          
          <section>

            <div id="informes-iframe-contenedor">
              <iframe src="" id="informes-iframe"></iframe>
            </div>

            <div>
              <button id="informes-previa-cerrar" class='desplegable-cerrar'>
                <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="caret-left" class="svg-inline--fa fa-caret-left fa-w-6 iconos" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 192 512"><path fill="currentColor" d="M192 127.338v257.324c0 17.818-21.543 26.741-34.142 14.142L29.196 270.142c-7.81-7.81-7.81-20.474 0-28.284l128.662-128.662c12.599-12.6 34.142-3.676 34.142 14.142z"></path></svg>
              </button>
            </div>
            
          </section>

        </div>

      </div>

      <div class="derecha">

        <div class="busqueda-estilizada">

          <input type="text" id="informes-busqueda" autocomplete="off" class="upper borde-estilizado">

        </div>

        <div class="tabla-ppal borde-estilizado" data-scroll>

          <table id="tabla-informes" class="table table-bordered table-striped">
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
<!---------------- INFORME EDITAR ------------------- -->
<!-------------------------------------------------------- -->
<div id="crud-infeditar-popup" class="popup-oculto" data-crud='popup'>
  <div id="crud-infeditar-pop" class="popup-oculto" style="width:40%">

    <button id="crud-infeditar-cerrar" data-crud='cerrar'>X</button>

    <section id="crud-infeditar-titulo" data-crud='titulo'>
      EDITAR INFORME
    </section>

    <div class="filas" style="height: fit-content; position:relative;">

      <div id="crud-infeditar-personalizacion" data-hidden>

        <section>Personalización</section>
        <section style="width: 100%; border: 1px dashed #fff"></section>
        <span>ENTER: SEPARAR LÍNEA</span>
        <span>°CENTRAR°</span>
        <span>*<b>NEGRITA</b>*</span>
        <span>_ <u>SUBRAYADO</u> _</span>
        <span>~<i>ITÁLICA</i>~</span>

        <div id="infeditar-previa-motivo" data-scroll data-hidden></div>
        <div id="infeditar-previa-enfermedad" data-scroll data-hidden></div>
        <div id="infeditar-previa-plan" data-scroll data-hidden></div>

      </div>

      <div class="columnas" style="column-gap: 22px">
        
        <div>
          <label class="requerido">MOTIVO</label>
          <textarea rows="3" id="infeditar-motivo" data-previa="infeditar-previa-motivo" data-valor="motivo" class="infeditar-valores upper lleno textarea-espaciado contenedor-personalizable" style="resize:none; min-height: 20vh;" data-scroll></textarea>
        </div>

        <div>
          <label>ENFERMEDAD</label>
          <textarea rows="3" id="infeditar-enfermedad" data-previa="infeditar-previa-enfermedad" data-valor="enfermedad" class="infeditar-valores upper textarea-espaciado contenedor-personalizable" style="resize:none; min-height: 20vh;" data-scroll></textarea>
        </div>

      </div>

      <div class="columnas" style="align-items: baseline;">
        
        <div>
          <label>PLAN</label>
          <textarea rows="3" id="infeditar-plan" data-previa="infeditar-previa-plan" data-valor="plan" class="infeditar-valores upper textarea-espaciado contenedor-personalizable" style="resize:none; min-height: 20vh;" data-scroll></textarea>
        </div>

        <style type="text/css">
          #cc-diagnosticos-editar .ccContenedor {
            width: 95%;
          }
        </style>

        <div>
          <label class="requerido">Diagnóstico:</label>
          <section id="cc-diagnosticos-editar" class="contenedor-consulta infeditar-valores lleno borde-estilizado" data-valor="diagnosticos">

            <input type="text" data-estilo="cc-input" class="upper" data-minimo="0" data-ocultar="0" placeholder="Buscar diagnósticos" title="[ENTER] para forzar actualización">
            <select data-limit="" data-estilo="cc-select" placeholder="Buscar diagnóstico" data-size="5" data-ocultar="1" data-hide data-absoluto="1" data-scroll style="
              height: fit-content;
              border: 1px dashed #ec6464;
              border-top: none;
              background: #ffdddd;
              padding: 5px;
              margin: 0px;
              color: black;
            "></select>
            <div data-estilo="cc-div" style="background: #fff; min-height: 13vh; max-height: 90px;" data-scroll></div>

          </section>
        </div>

      </div>

    </div>

    <section id="crud-infeditar-botones" data-crud='botones' style="column-gap:5px">
      <button class="botones-formularios confirmar btn-editar">CONFIRMAR</button>
      <button class="botones-formularios cerrar">CANCELAR</button>
    </section>

  </div>
</div>

<!-------------------------------------------------------- -->
<!-------------- INFORMES ELIMINAR ------------------- -->
<!-------------------------------------------------------- -->
<div id="crud-infeliminar-popup" class="popup-oculto" data-crud='popup'>
  <div id="crud-infeliminar-pop" class="popup-oculto">

    <button id="crud-infeliminar-cerrar" data-crud='cerrar'>X</button>

    <section id="crud-infeliminar-titulo" data-crud='titulo'>
      ¿DESEA ELIMINAR EL INFORME?
    </section>

    <section id="crud-infeliminar-botones" data-crud='botones' style="padding-top: 10px; column-gap: 5px;">
      <button class="botones-formularios eliminar">ELIMINAR</button>
      <button class="botones-formularios cerrar">CANCELAR</button>
    </section>

  </div>
</div>

<!------------------------------------------------------------------- -->
<!---------------------- INSERTAR DIAGNOSTICOS ---------------------- -->
<!------------------------------------------------------------------- -->
<div id="crud-insertar-diagnosticos-popup" class="popup-oculto" data-crud='popup'>
  <div id="crud-insertar-diagnosticos-pop" class="popup-oculto" style="width:30%;">

    <button id="crud-insertar-diagnosticos-cerrar" data-crud='cerrar'>X</button>

    <section id="crud-insertar-diagnosticos-titulo" data-crud='titulo'>
      Insertar diagnósticos
    </section> 

    <section class="filas">
      <div class="columnas">
        <div>
          <label class="requerido">Nombre del diagnósticos</label>  
          <input type="text" minlength="1" id="nombre-diagnosticos" maxlength="100" class="nuevas-diagnosticos lleno upper" placeholder="...">
        </div>
      </div> 

    </section>
    <section id="crud-insertar-diagnosticos-botones" data-crud='botones' style="column-gap: 10px; padding: 10px;">
      <button class="botones-formularios insertar">CONFIRMAR</button>
      <button class="botones-formularios cerrar">CANCELAR</button> 
    </section>
  </div> 
</div>

<!-------------------------------------------------------- -->
<!----------------- INFORMES PREVIA ---------------------- -->
<!-------------------------------------------------------- -->
<div id="crud-infprevia-popup" class="popup-oculto" data-crud='popup'>
  <div id="crud-infprevia-pop" class="popup-oculto">

    <button id="crud-infprevia-cerrar" data-crud='cerrar'>X</button>

    <section id="crud-infprevia-titulo" data-crud='titulo' style="display: flex; justify-content: center;">
      VISTA PREVIA DEL INFORME MÉDICO
    </section>

    <section id="crud-infprevia-reporte" class="reportes-previa-iframe">
      <iframe src=""></iframe>
    </section>

    <section id="crud-infprevia-botones" data-crud='botones' style="padding-top: 10px; column-gap: 5px;">
      <button class="botones-formularios imprimir">IMPRIMIR</button>
      <button class="botones-formularios cerrar">CANCELAR</button>
    </section>

  </div>
</div>