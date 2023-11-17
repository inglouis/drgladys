<?php 
  
  //---------------------------------------
  //LLAMADO DE LAS CLASES FUNCIONES DE PHP 
  //---------------------------------------
  include_once('../clases/evoluciones.class.php');

  //---------------------------------------
  //OBJETO DE CLASE (GENERICO)
  //---------------------------------------
  $obj = new Model();

  //---------------------------------------
  $_SESSION['refrescar'] = '..'.$_SERVER['REQUEST_URI'];
  //---------------------------------------

?>
<!DOCTYPE html>
<html lang="es">

  <!-------------------------------------------------------- -->
  <!---------------------- CABECERA --- -------------------- -->
  <!-------------------------------------------------------- -->
  <head>
      <?php require_once('../estructura/head.php');?>
      <title>EVOLUCIONES</title>
      <script type="module" src="../js/evoluciones.js" defer></script>
      <script type="module" src="../js/main.js" defer></script>
  </head>
    
<!------------------------- CUERPO ----------------------- -->
  <!-------------------------------------------------------- -->
  <body data-scroll>

    <!-------------------------------------------------------- -->
    <!--------------------- INFORMARCIÓN  -------------------- -->
    <!-------------------------------------------------------- -->
    <div id="crud-informacion-popup" class="popup-oculto" data-crud='popup'>
      <div id="crud-informacion-pop" class="popup-oculto" data-scroll style="    
        width: 50%;
        height: fit-content;;
        justify-content: space-between;
      ">

        <button id="crud-informacion-cerrar" data-crud='cerrar'>X</button>

        <section id="crud-informacion-titulo" data-crud='titulo'>
          INFORMACIÓN EVOLUCIONES 
        </section>

        <div class="filas" style="height: fit-content;">
          <div class="columnas">
            <div>
              <label>cedula</label>
              <input type="text" data-valor="cedula" class="informacion-valores upper visual" disabled="true">
            </div>
            <div>
              <label>Historia</label>
              <input type="text" data-valor="id_historia" class="informacion-valores upper visual" disabled="true">
            </div>
            <div>
              <label>Nombres</label>
              <input type="text" data-valor="nombres" class="informacion-valores upper visual" disabled="true">
            </div>
            <div>
              <label>Apellidos</label>
              <input type="text" data-valor="apellidos" class="informacion-valores upper visual" disabled="true">
            </div>
          </div>

          <div class="columnas">
            <div>
              <label>Diagnóstico</label>
              <input type="text" data-valor="diag1" class="informacion-valores upper visual" disabled="true">
            </div>
            <div>
              <label>Diagnóstico</label>
              <input type="text" data-valor="diag2" class="informacion-valores upper visual" disabled="true">
            </div>
            <div>
              <label>fecha</label>
              <input type="text" data-valor="fecha" class="informacion-valores upper visual" disabled="true">
            </div>
          </div>

          <div class="columnas">
            <div>
              <label>Agudeza Visual OD</label>
              <input type="text" data-valor="avod" class="informacion-valores upper visual" disabled="true">
            </div>
            <div>
              <label>Agudeza Visual OI</label>
              <input type="text" data-valor="avoi" class="informacion-valores upper visual" disabled="true">
            </div>
            <div>
              <label>Rx OD</label>
              <input type="text" data-valor="rxod" class="informacion-valores upper visual" disabled="true">
            </div>
            <div>
              <label>Rx OI</label>
              <input type="text" data-valor="rxoi" class="informacion-valores upper visual" disabled="true">
            </div>
          </div>

          <div class="columnas">
            <div>
              <label>Plan</label>
              <input type="text" data-valor="plan" class="informacion-valores upper visual" disabled="true">
            </div>
            <div>
              <label>Evolucion</label>
              <input type="text" data-valor="evo" class="informacion-valores upper visual" disabled="true">
            </div>
          </div>

          <div class="columnas">
            <div>
              <label class="requerido">Estado de la Evolución</label>
              <select class="informacion-valores upper visual" data-valor="status" disabled="true">
                <option value="">SELECCIONAR</option>
                <option value="A">ACTIVA</option>
                <option value="D">DESACTIVADA</option>
              </select>            
            </div>
          </div>
        </div>

        <section id="crud-informacion-botones" data-crud='botones-derecha'>
          <button class="botones-formularios cerrar">CERRAR</button>
        </section>

      </div>
    </div>

    
    <!---------------------------------------------------------------------->
    <!------------                P A G I N A                  ------------->
    <!---------------------------------------------------------------------->
    <div class="container-fluid bg-3 paginas-contenedor">

      <div id="titulo-contenedor">  
        <h3>LISTADO DE evoluciones</h3>
      </div>

       <div id='contenido-contenedor'>

        <div class="panel-body">

          <section>

            <div class="datos">

              <div class="busqueda-estilizada">
                <input type="text" id="busqueda" autocomplete="off" class="upper borde-estilizado">
              </div>

              <div style="position: relative;">

                <button id="modo-buscar" data-estilo="modo-buscar">
                  <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="sort" class="svg-inline--fa fa-sort fa-w-10 iconos-b" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path fill="currentColor" d="M41 288h238c21.4 0 32.1 25.9 17 41L177 448c-9.4 9.4-24.6 9.4-33.9 0L24 329c-15.1-15.1-4.4-41 17-41zm255-105L177 64c-9.4-9.4-24.6-9.4-33.9 0L24 183c-15.1 15.1-4.4 41 17 41h238c21.4 0 32.1-25.9 17-41z"></path></svg>
                </button>
                
              </div>

              <div style="
                display: flex;
                justify-content: center;
                align-items: center;
                padding: 0px 5px;
              ">
                
                <button id="evoluciones-insertar" class="btn btn-nuevo tooltip-filtro" data-hidden>+</button>

              </div>

              <div id="evoluciones-filtros" class="filtros" style="padding-left: 10px;">

                <div data-grupo="status" class="grupo">

                  <section class="filtro evoluciones-status">
                    <input type="checkbox" data-name="status" data-familia="global" data-modo="individual" value="A">
                  </section>

                  <section class="filtro evoluciones-status">
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

            <div id="tabla-principal" class="tabla-ppal table-min">
              <table id="tabla-evoluciones" class="table table-bordered table-striped">
                <thead>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>

            <div style="display: flex; height: 100%;">

              <button id="izquierda" class="botones">
                <?php echo "<"?>
              </button>

              <div id="numeracion" data-estilo="numeracion-contenedor" style="width: 100px">
                <input type="number" class="numeracion" maxlength="3" minlength="0">
                <span class="numeracion"></span> 
              </div>

              <button id="derecha" class="botones">
                <?php echo ">"?>
              </button>

            </div>

          </section>
        </div>
      </div>
    </div>
    <?php echo $dispararModos;?> 
  </body>
</html>