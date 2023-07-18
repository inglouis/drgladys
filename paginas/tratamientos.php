<?php 
  include_once('../clases/tratamientos.class.php');
  $obj = new Model();
  $_SESSION['refrescar'] = '..'.$_SERVER['REQUEST_URI'];

?>
<!DOCTYPE html>
<html lang="es">
  <head>
      <?php require_once('../estructura/head.php');?>
      <title>ACTUALIZACIÓN TRATAMIENTOS MÉDICOS</title>
      <script type="module" src="../js/tratamientos.js" defer></script>
      <script type="module" src="../js/main.js" defer></script>
      <style type="text/css">
        /*-----------------------------------------------------*/
        /*-------tratamientos-------------------*/
        /*-----------------------------------------------------*/


        #tabla-tratamientos-editar tbody tr td:nth-child(1), #tabla-tratamientos-insertar tbody tr td:nth-child(1) {
            width:5%;
        }

        #tabla-tratamientos-editar tbody tr td:nth-child(2), #tabla-tratamientos-insertar tbody tr td:nth-child(1) {
            width:90%;
        }

        #tabla-tratamientos-editar tbody tr td:nth-child(3), #tabla-tratamientos-insertar tbody tr td:nth-child(1) {
            width:10%;
            min-width: 30px;
        }

        [data-estilo="tabla-tratamientos"] {
            min-height: 300px;
            border: 1px solid #ccc;
        }

      </style>
  </head>
  <body data-resaltar class="scroll-form">

    <!--////////////////////////////////////////////////////////////////////////////////////////-->
    <!--/////////////////////////////////- Eliminar  ///////////////////////////////////////////-->
    <!--////////////////////////////////////////////////////////////////////////////////////////-->

    <div id="crud-eliminar-popup" class="popup-oculto" data-crud='popup'>
      <div id="crud-eliminar-pop" class="popup-oculto">
        <button id="crud-eliminar-cerrar" data-crud='cerrar'>X</button>
        <section id="crud-eliminar-titulo" data-crud='titulo'>
            ¿Confirma eliminar Tratamientos Médicos ?
        </section>
        <p style="color:red">Esto eliminará permanentemente el Tratamiento Médico de la Base de Datos, si quieres deshabilitar el Tratamiento Médico lo puedes hacer desde la Opción de Editar</p>
        <section id="crud-eliminar-botones" data-crud='botones'>
            <button class="botones-formularios eliminar">CONFIRMAR</button>
            <button class="botones-formularios cerrar">CANCELAR</button> 
        </section>
      </div>
    </div>
    <!--////////////////////////////////////////////////////////////////////////////////////////-->
    <!--/////////////////////////////////- Insertar  ///////////////////////////////////////////-->
    <!--////////////////////////////////////////////////////////////////////////////////////////-->
    <div id="crud-insertar-popup" class="popup-oculto" data-crud='popup'>
      <div id="crud-insertar-pop" class="popup-oculto" style="width:70%; min-width:600px ;height: fit-content;">
        <button id="crud-insertar-cerrar" data-crud='cerrar'>X</button>
        <section id="crud-insertar-titulo" data-crud='titulo'>
          Insertar Tratamiento Médico
        </section> 
        <section class="filas">

          <div>
            <label for="insertar-medicamento" class="requerido">Medicamento:</label>
            <section data-grupo="cc-medicamentos-insertar" class="combo-consulta">
              <input type="text" placeholder="Buscar medicamento" data-limit="">
              <select class="nuevos lleno scroll"></select>
            </section>
          </div>

          <div style="width:100%; padding-top: 10px;">
            <div>
            <label>Tratamiendos del medicamento</label>
            <div style="display: flex;">
              <input type="text" id="tratamientos-busqueda-insertar" data-estilo="busqueda" placeholder="Busqueda">
              <button style="position: relative; top: 0px; height: 100%;" id="nuevo-tratamiento-insertar" class="btn-nuevo btn btn-primary" title="Agregar fila">+</button>
            </div>

            <div class="tabla-ppal scroll" data-estilo="tabla-tratamientos">
              <table id="tabla-tratamientos-insertar" class="table table-bordered table-striped">
                  <thead>
                  </thead>
                  <tbody>
                  </tbody>
              </table>
            </div>
          </div>
          </div>  
        </section>
        <section id="crud-insertar-botones" data-crud='botones'>
          <button class="botones-formularios insertar">CONFIRMAR</button>
          <button class="botones-formularios cerrar">CANCELAR</button> 
        </section>
      </div> 
    </div>

    <!--////////////////////////////////////////////////////////////////////////////////////////-->
    <!--/////////////////// Editar   ////////////////////////////////////-->
    <!--////////////////////////////////////////////////////////////////////////////////////////-->
    <div id="crud-editar-popup" class="popup-oculto" data-crud='popup'>
      <div id="crud-editar-pop" class="popup-oculto" style="width: 70%; min-width: 600px;">
        <button id="crud-editar-cerrar" data-crud='cerrar'>X</button>
        <section id="crud-editar-titulo" data-crud='titulo'>
            Editar datos del Tratamiento Médico
        </section> 

        <section class="filas">
          <div class="columnas" style="width:100%;">
            <div>
              <label for="editar-nombre">Médicamento</label>  
              <input type="text" name="editar-nombre" id="editar-nombre" data-valor="nombre" readonly="true" class="crud-valores upper">
            </div>
          </div>

          <div style="width:100%; padding-top: 10px;">
            <label>Tratamiendos del medicamento</label>
            <div style="display: flex;">
              <input type="text" id="tratamientos-busqueda-editar" data-estilo="busqueda" placeholder="Busqueda">
              <button style="position: relative; top: 0px; height: 100%;" id="nuevo-tratamiento-editar" class="btn-nuevo btn btn-primary" title="Agregar fila">+</button>
            </div>

            <div class="tabla-ppal scroll" data-estilo="tabla-tratamientos">
              <table id="tabla-tratamientos-editar" class="table table-bordered table-striped">
                  <thead>
                  </thead>
                  <tbody>
                  </tbody>
              </table>
            </div>
          </div>

          <div class="columnas" style="width:100%;">
            <div>
              <label for="editar-estado">Estado</label>
               <select class="crud-valores lleno" name="editar-estado" id="editar-estado" data-valor="status" required="true">
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

    <!--////////////////////////////////////////////////////////////////////////////////////////-->
    <!--//////////////////////////////////////// Página  ///////////////////////////////////////-->
    <!--////////////////////////////////////////////////////////////////////////////////////////-->
    <div class="container-fluid bg-3 paginas-contenedor">
      <div id="titulo-contenedor">  
        <h3>LISTADO DE TRATAMIENTOS MÉDICOS</h3>
      </div>
      <div id="contenido-contenedor">        
        <div class="panel-body">
          <section>
            <div class="datos">
              <button id="insertar-tratamientos" style='margin-top:-30px' class="btn btn-primary pull-right btn-nuevo tooltip-filtro-reverso">
                +
              </button>

              <a href="../paginas/medicamentos.php" id="regresar-medicamentos">
                <button style='margin-top:-30px; width: 25px; right: 30px' class="btn btn-primary pull-right btn-nuevo tooltip-filtro-reverso" title="Regresar a medicamentos">
                  <svg style="width: 10px" xmlns="http://www.w3.org/2000/svg" class="iconos" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path fill="currentColor" d="M32 448c0 35.2 28.8 64 64 64h192c35.2 0 64-28.8 64-64V128H32V448zM96 304C96 295.2 103.2 288 112 288H160V240C160 231.2 167.2 224 176 224h32C216.8 224 224 231.2 224 240V288h48C280.8 288 288 295.2 288 304v32c0 8.799-7.199 16-16 16H224v48c0 8.799-7.199 16-16 16h-32C167.2 416 160 408.8 160 400V352H112C103.2 352 96 344.8 96 336V304zM360 0H24C10.75 0 0 10.75 0 24v48C0 85.25 10.75 96 24 96h336C373.3 96 384 85.25 384 72v-48C384 10.75 373.3 0 360 0z"/></svg>
                </button>
              </a>

              <div class="buscador-efecto">
                <input type="text"  id="salto" placeholder="test" style="display: block; position: absolute; top:-4200px" tabindex="1">
                <input type="text" name="busqueda" id="busqueda" placeholder="Busqueda" tabindex="2">
              </div> 
              <div style="position: relative;">
                <button id="buscar">
                  <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="search" class="svg-inline--fa fa-search fa-w-16 iconos" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z"></path></svg>  
                </button>
                <button id="modo-buscar" data-estilo="modo-buscar">
                  <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="sort" class="svg-inline--fa fa-sort fa-w-10 iconos-b" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path fill="currentColor" d="M41 288h238c21.4 0 32.1 25.9 17 41L177 448c-9.4 9.4-24.6 9.4-33.9 0L24 329c-15.1-15.1-4.4-41 17-41zm255-105L177 64c-9.4-9.4-24.6-9.4-33.9 0L24 183c-15.1 15.1-4.4 41 17 41h238c21.4 0 32.1-25.9 17-41z"></path></svg>
                </button>
              </div>

              <div id="tratamientos-filtros" class="filtros">
                <div data-grupo="status" class="grupo">
                  <section class="filtro tratamientos-status">
                    <input type="checkbox" data-name="status" data-familia="global" data-modo="individual" value="A">
                  </section>
                  <section class="filtro tratamientos-status">
                    <input type="checkbox" data-name="status" data-familia="global" data-modo="individual"value="D">
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
              <table id="tabla-tratamientos" class="table table-bordered table-striped">
                  <thead>
                  </thead>
                  <tbody>
                  </tbody>
              </table>
            </div>

            <div style="display: flex; height: 100%;">
              <button id="izquierda" class="botones"><?php echo "<"?></button>
              <div id="numeracion" data-estilo="numeracion-contenedor" style="width: 100px">
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