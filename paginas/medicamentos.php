<?php 
  include_once('../clases/medicamentos.class.php');
  $obj = new Model();
  $_SESSION['refrescar'] = '..'.$_SERVER['REQUEST_URI'];

?>
<!DOCTYPE html>
<html lang="es">
  <head>
      <?php require_once('../estructura/head.php');?>
      <title>ACTUALIZACIÓN DE MEDICAMENTOS</title>
      <script type="module" src="../js/medicamentos.js" defer></script>
      <script type="module" src="../js/main.js" defer></script>
  </head>
  <body data-resaltar class="scroll-form">

    <!--//////////////////////////////////////////////////////////////////-->
    <!--/////////////////////////////////- Eliminar  /////////////////////-->
    <!--//////////////////////////////////////////////////////////////////-->

    <div id="crud-eliminar-popup" class="popup-oculto" data-crud='popup'>
      <div id="crud-eliminar-pop" class="popup-oculto">
        <button id="crud-eliminar-cerrar" data-crud='cerrar'>X</button>
        <section id="crud-eliminar-titulo" data-crud='titulo'>
            ¿Confirma eliminar Medicamento ?
        </section>
        <p style="color:red">Esto eliminará permanentemente el Medicamento de la Base de Datos, si quieres deshabilitar el Medicamento lo puedes hacer desde la Opción de Editar</p>
        <section id="crud-eliminar-botones" data-crud='botones'>
            <button class="botones-formularios eliminar">CONFIRMAR</button>
            <button class="botones-formularios cerrar">CANCELAR</button> 
        </section>
      </div>
    </div>

    <!--//////////////////////////////////////////////////////////////////-->
    <!--/////////////////////////////////- Insertar  /////////////////////-->
    <!--//////////////////////////////////////////////////////////////////-->
    <div id="crud-insertar-popup" class="popup-oculto" data-crud='popup'>
      <div id="crud-insertar-pop" class="popup-oculto" style="width:60%; min-width:600px ;height: fit-content;">
        <button id="crud-insertar-cerrar" data-crud='cerrar'>X</button>
        <section id="crud-insertar-titulo" data-crud='titulo'>
          <button id="crud-insertar-limpiar" title="Limpiar Contenido" data-crud='limpiar'>
            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="trash-alt" class="svg-inline--fa fa-trash-alt fa-w-14 iconos-b" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M32 464a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128H32zm272-256a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zm-96 0a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zm-96 0a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zM432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16z"></path></svg>
          </button>
          Insertar Medicamento
        </section>

        <section class="filas">
          <div class="columnas" style="width:100%;">
            <div>
              <label for="insertar-nombre">Descripción del Medicamento</label>  
              <input type="text" size="100" minlength="1" maxlength="100" class="nuevos upper" required="true">
            </div>
          </div>
          <div class="columnas" style="height: 100%;">
            <div style="width: 150%; height: 200px;">
              <div style="width: 100%; display: flex; flex-direction: row; margin: 0px;">
                <label style="width:50%" for="insertar-genericos">Génericos</label>
                <label style="width:50%" for="insertar-genericos">Kit de Génericos</label>
              </div>
              <section id="cc-insertar-genericos" class="contenedor-consulta nuevos" style="display: flex; flex-direction: row; height: 100%;">
                <span class="tooltip-general1">Presionar [ENTER] para agregar</span>
                <div style="width: 50%;display: flex;">
                  <input data-contenedor="cc-insertar-genericos" type="text" data-estilo="cc-input">
                  <select data-contenedor="cc-insertar-genericos" data-limit="80" data-estilo="cc-select"></select>
                </div>
                
                <div data-contenedor="cc-insertar-genericos" data-estilo="cc-div"></div>

              </section>
            </div>
          </div> 
        </section>
        <section id="crud-insertar-botones" data-crud='botones'>
          <button class="botones-formularios insertar">CONFIRMAR</button>
          <button class="botones-formularios cerrar">CANCELAR</button> 
        </section>
      </div> 
    </div>

    <!--/////////////////////////////////////////////////////////////////////////-->
    <!--////////////////////////////////////////   Editar   /////////////////////-->
    <!--/////////////////////////////////////////////////////////////////////////-->
    <div id="crud-editar-popup" class="popup-oculto" data-crud='popup'>
      <div id="crud-editar-pop" class="popup-oculto" style="width:60%; min-width:600px ;height: 80%;">
        <button id="crud-editar-cerrar" data-crud='cerrar'>X</button>
        <section id="crud-editar-titulo" data-crud='titulo'>
              Editar Medicamento
        </section> 

        <section class="filas">
          <div class="columnas" style="width:100%;">
            <div>
              <label for="editar-nombre" class="requerido">Descripción del Médicamento</label>  
              <input type="text" name="editar-nombre" id="editar-nombre" data-valor="nombre" size="100" minlength="1" maxlength="100" class="crud-valores lleno upper" required="true">
            </div>
          </div>
          <div class="columnas" style="height: 100%;">
            <div style="width: 150%; height: 100%;">
              <div style="width: 100%; display: flex; flex-direction: row; margin: 0px;">
                <label style="width:50%" for="editar-genericos">Génericos</label>
                <label style="width:50%" for="editar-genericos">Kit de Génericos</label>
              </div>
              <section id="cc-editar-genericos" data-valor="genericos" class="contenedor-consulta crud-valores" style="display: flex; flex-direction: row; height: 100%;">
                <span class="tooltip-general1">Presionar [ENTER] para agregar</span>
                <div style="width: 50%;display: flex;">
                  <input data-contenedor="cc-editar-genericos" type="text" data-estilo="cc-input">
                  <select data-contenedor="cc-editar-genericos" data-limit="80" data-estilo="cc-select"></select>
                </div>
                <div data-contenedor="cc-editar-genericos" data-estilo="cc-div"></div>
              </section>
            </div>
          </div> 
          <div class="columnas" style="width:100%;">
            <div>
              <label for="editar-estado">Estado</label>
               <select class="crud-valores lleno" id="editar-estado" data-valor="status" required="true">
                  <option value="A">Activo</option>
                  <option value="D">Inactivo</option>
               </select> 
            </div>
          </div>
        </section>
        <section id="crud-editar-botones" data-crud='botones'>
          <button class="botones-formularios editar">CONFIRMAR</button>
          <button class="botones-formularios cerrar">CANCELAR</button> 
        </section>
      </div> 
    </div>

    <!--//////////////////////////////////////////////////////////////////////-->
    <!--//////////////////////////////////////// Página  /////////////////////-->
    <!--//////////////////////////////////////////////////////////////////////-->
    <div class="container-fluid bg-3 paginas-contenedor">
      <div id="titulo-contenedor">  
        <h3>LISTADO DE MEDICAMENTOS</h3>
      </div>
      <div id="contenido-contenedor">        
        <div class="panel-body">
          <section>
            <div class="datos">
              <button id="insertar-medicamentos" style='margin-top:-30px' class="btn btn-primary pull-right btn-nuevo tooltip-filtro-reverso">
                +
              </button>

              <a href="../paginas/genericos.php">
                <button style='margin-top:-30px; width: fit-content; right: 30px' class="btn btn-primary pull-right btn-nuevo tooltip-filtro-reverso" title="Regresar a genéricos">Genéricos</button>
              </a>

              <a href="../paginas/tratamientos.php">
                <button style='margin-top:-30px; width: fit-content; right: 122px' class="btn btn-primary pull-right btn-nuevo tooltip-filtro-reverso" title="Ir a tratamientos">
                  <svg class="iconos" style="width: 15px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path fill="currentColor" d="M256 0v128h128L256 0zM224 128L224 0H48C21.49 0 0 21.49 0 48v416C0 490.5 21.49 512 48 512h288c26.51 0 48-21.49 48-48V160h-127.1C238.3 160 224 145.7 224 128zM288 301.7v36.57C288 345.9 281.9 352 274.3 352L224 351.1v50.29C224 409.9 217.9 416 210.3 416H173.7C166.1 416 160 409.9 160 402.3V351.1L109.7 352C102.1 352 96 345.9 96 338.3V301.7C96 294.1 102.1 288 109.7 288H160V237.7C160 230.1 166.1 224 173.7 224h36.57C217.9 224 224 230.1 224 237.7V288h50.29C281.9 288 288 294.1 288 301.7z"/></svg>
                </button>
              </a>

              <a href="../paginas/presentaciones.php">
                <button style='margin-top:-30px; width: fit-content; right: 150px' class="btn btn-primary pull-right btn-nuevo tooltip-filtro-reverso" title="Ir a presentaciones">
                  <svg class="iconos" style="width: 15px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path fill="currentColor" d="M112 32C50.12 32 0 82.12 0 143.1v223.1c0 61.88 50.12 111.1 112 111.1s112-50.12 112-111.1V143.1C224 82.12 173.9 32 112 32zM160 256H64V144c0-26.5 21.5-48 48-48s48 21.5 48 48V256zM299.8 226.2c-3.5-3.5-9.5-3-12.38 .875c-45.25 62.5-40.38 150.1 15.88 206.4c56.38 56.25 144 61.25 206.5 15.88c4-2.875 4.249-8.75 .75-12.25L299.8 226.2zM529.5 207.2c-56.25-56.25-143.9-61.13-206.4-15.87c-4 2.875-4.375 8.875-.875 12.38l210.9 210.7c3.5 3.5 9.375 3.125 12.25-.75C590.8 351.1 585.9 263.6 529.5 207.2z"/></svg>
                </button>
              </a>

              <div class="buscador-efecto">
                <input type="text" name="busqueda" id="busqueda" placeholder="Busqueda">
              </div> 
              <div style="position: relative;">
                <button id="modo-buscar" data-estilo="modo-buscar">
                  <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="sort" class="svg-inline--fa fa-sort fa-w-10 iconos-b" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path fill="currentColor" d="M41 288h238c21.4 0 32.1 25.9 17 41L177 448c-9.4 9.4-24.6 9.4-33.9 0L24 329c-15.1-15.1-4.4-41 17-41zm255-105L177 64c-9.4-9.4-24.6-9.4-33.9 0L24 183c-15.1 15.1-4.4 41 17 41h238c21.4 0 32.1-25.9 17-41z"></path></svg>
                </button>
                <button id="buscar">
                  <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="search" class="svg-inline--fa fa-search fa-w-16 iconos" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z"></path></svg>  
                </button>
              </div>

              <div id="medicamentos-filtros" class="filtros">
                <div data-grupo="status" class="grupo">
                  <section class="filtro medicamentos-status">
                    <input type="checkbox" data-name="status" data-familia="global" data-modo="individual" value="A">
                  </section>
                  <section class="filtro medicamentos-status">
                    <input type="checkbox" data-name="status" data-familia="global" data-modo="individual" value="D">
                  </section>
                </div>        

                <section class="tooltip-filtro">
                  <button id="procesar" class="aplicar-filtros">
                    <svg aria-hidden="true" style="pointer-events: none" focusable="false" data-prefix="fas" data-icon="check" class="svg-inline--fa fa-check fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z"></path></svg>
                  </button>
                </section>
              </div>
            </div>

            <div id="tabla-principal" class="tabla-ppal table-min" style="min-height: 250px;">
              <table id="tabla-medicamentos" class="table table-bordered table-striped">
                <thead>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>

            <div style="display: flex; height: 100%;">
                <button id="izquierda" class="botones"><?php echo "<"?></button>
                <div id="numeracion" data-estilo="numeracion-contenedor">
                  <input type="number" class="numeracion" maxlength="3" minlength="0">
                  <span class="numeracion"></span> 
                </div>
                <button id="derecha" class="botones" data-algo="mi dato"><?php echo ">"?></button>       
            </div>
          </section>
        </div>
      </div>
    </div>
    <?php echo $dispararModos;?>
  </body>
</html>