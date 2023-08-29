<?php 
  //1)-------------------------------------
  //---------------------------------------
  //LLAMADO DE LAS CLASES FUNCIONES DE PHP 
  //---------------------------------------
  include_once('../clases/historias.class.php');

  //---------------------------------------
  //OBJETO DE CLASE (GENERICO)
  //---------------------------------------
  $obj = new Model();

  //---------------------------------------
  $_SESSION['refrescar'] = '..'.$_SERVER['REQUEST_URI'];
  //---------------------------------------
  $dia = $obj->fechaHora('America/Caracas','Y-m-d');

?>
<!DOCTYPE html>
<html lang="es">

  <!-------------------------------------------------------- -->
  <!---------------------- CABECERA --- -------------------- -->
  <!-------------------------------------------------------- -->
  <head>
      <?php require_once('../estructura/head.php');?>
      <title>HISTORIAS</title>
      <script type="text/javascript">
        window.dia = '<?php echo "$dia"?>'
      </script>
      <script type="module" src="../js/historias.js" defer></script>
      <script type="module" src="../js/historias_evoluciones.js" defer></script>
      <!--<script type="module" src="../js/main.js" defer></script>-->
      <?php
        include_once('../estructura/reportes_scripts.php');
      ?>
  </head>
    
  <!----------------------------------------- CUERPO -------------------------------------- -->
  <!--------------------------------------------------------------------------------------- -->
  <body data-scroll id="body">

    <div id="cruds" style="width: 100%; height: 100%">
      
    <?php 
      include_once('../cruds/historias.crud.php');
      include_once('../cruds/historias_evoluciones.crud.php');
      include_once('../cruds/historias_notificaciones.crud.php');
    ?>

    </div>

    <!--2)----------------------------------------------------------------------------------------->
    <!----------------------------------- CONTENEDOR REPORTES ------------------------------------->
    <!--------------------------------------------------------------------------------------------->
    <div id="crud-reportes-popup" class="popup-oculto" data-crud='popup' style="z-index: 1">
      <div id="crud-reportes-pop" class="popup-oculto">

        <button id="crud-reportes-cerrar" data-crud='cerrar'>X</button>

        <div class="valor-cabecera cabecera-formularios" style="right: 30px;">
          <div>
            <label>N° de historia</label>
            <input type="text" autocomplete="off"  data-valor="id_historia" class="reportes-cargar upper visual" disabled style="width: 65px;">
          </div>

          <div>
            <label>Paciente</label>
            <input type="text" autocomplete="off"  data-valor="nombre_completo" class="reportes-cargar upper visual" disabled style="width: 10vw; min-width: 150px">
          </div>
        </div>

        <div id="crud-reportes-contenedor">

          <div id="crud-reportes-cabecera">

            <div class="boton">

              <button id="reportes-abrir-paginacion" title="Listado de reportes">
                <svg style="height: 20px;" xmlns="http://www.w3.org/2000/svg" class="iconos" height="1em" viewBox="0 0 448 512"><path fill="currentColor" d="M0 96C0 78.3 14.3 64 32 64H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H416c17.7 0 32 14.3 32 32z"/></svg>
              </button>

            </div>

            <div class="contenido">

              <div id="reportes-paginacion" class="desplegable-oculto">

                <div>

                  <div id="reportes-cerrar-paginacion" display="none"></div>
                  
                  <div class="titulo">Seleccionar reporte</div>

                  <div class="botones" id="reportes-paginacion-botones">
                    <button id="constancia">Constancias</button>
                    <button id="informe">Informes médicos</button>
                    <button id="presupuesto">Presupuestos</button>
                    <button id="reposo">Reposos médicos</button>
                    <button id="general">Generales</button>
                  </div>

                </div>

              </div>

            </div>

            <div class="cabecera">CONSTANCIAS</div>

          </div>

          <div class="crud-reportes-cuerpo">
          
            <div id="crud-reportes-secciones">

              <?php 
                include_once('../estructura/reportes_includes.php');
              ?>

            </div>

          </div>
          
        </div>        

      </div>
    </div>

    <!--3)---------------------------------------------------------------------------------------->
    <!-------------------------------------------------------------------------------------------->
    <!------------------------ PAGINACION ENTRE CONTENEDORES ------------------------------------->
    <!-------------------------------------------------------------------------------------------->
    <div id="paginacion-contenedores" data-hidden>
      <button class="informacion" title="Consultar información del paciente"></button>
      <button class="editar" title="Editar historia del paciente"></button>
      <button class="reportes" title="Reportes del paciente"></button>
      <!--
        <button class="recipes" title="Recipes indicaciones"></button>
        <button class="evoluciones" title="Evoluciones"></button>
      -->
    </div>

      <!------------------------------------------------------------------------------------------->
      <!------------------------------ DESPLEGABLE NOTIFICADO ------------------------------------->
      <!------------------------------------------------------------------------------------------->
      <button id="desplegable-abrir-notificados" class="desplegable-abrir" title="Reportes preparados para impresión [NOTIFICADOS]">
        <svg style="width: 15px; height: 15px;" class="iconos" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><path fill="currentColor" d="M64 32C64 14.3 49.7 0 32 0S0 14.3 0 32V64 368 480c0 17.7 14.3 32 32 32s32-14.3 32-32V352l64.3-16.1c41.1-10.3 84.6-5.5 122.5 13.4c44.2 22.1 95.5 24.8 141.7 7.4l34.7-13c12.5-4.7 20.8-16.6 20.8-30V66.1c0-23-24.2-38-44.8-27.7l-9.6 4.8c-46.3 23.2-100.8 23.2-147.1 0c-35.1-17.6-75.4-22-113.5-12.5L64 48V32z"/></svg>
      </button>

      <div id="desplegable-notificados" class="desplegable-oculto">
        
        <section>
          <button id="desplegable-cerrar-notificados" class='desplegable-cerrar'>
            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="caret-right" class="svg-inline--fa fa-caret-right fa-w-6 iconos" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 192 512"><path fill="currentColor" d="M0 384.662V127.338c0-17.818 21.543-26.741 34.142-14.142l128.662 128.662c7.81 7.81 7.81 20.474 0 28.284L34.142 398.804C21.543 411.404 0 402.48 0 384.662z"></path></svg>
          </button>
        </section>


        <div id="tabla-notificados-contenedor" class="tabla-ppal" data-scroll>

          <div class="titulo">
            Reportes notificados corroborados
          </div>

          <table id="tabla-notificados" class="table table-bordered table-striped">
            <thead>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
       
      </div>

    <!---------------------------------------------------------------------->
    <!------------                P A G I N A                  ------------->
    <!---------------------------------------------------------------------->
    <div class="container-fluid bg-3 paginas-contenedor">

      <div id="titulo-contenedor">  
        <h3>LISTADO DE HISTORIAS</h3>
      </div>

       <div id='contenido-contenedor'>

        <div class="panel-body">

          <section>

            <div class="datos">

              <div class="busqueda-estilizada">
                <input type="text" id="busqueda" autocomplete="off" class="upper borde-estilizado" title="Enfocar cajón de texto [Shift > Shift]&#013Abrir insersión de historia &#013Información primer resultado [Shift > ENTER]&#013Limpiar cajón de busqueda [Supr > Supr]">
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
                
                <button id="buscar" class="btn">
                  <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="search" class="svg-inline--fa fa-search fa-w-16 iconos" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z"></path></svg>  
                </button>

              </div>

              <div style="
                display: flex;
                justify-content: center;
                align-items: center;
              ">
                
                <button id="historias-insertar" class="btn btn-nuevo tooltip-filtro">+</button>

              </div>

              <div id="historias-status" class="filtros" style="padding-left: 10px;">

                <div data-grupo="status" class="grupo">

                  <section class="filtro historias-status">
                    <input type="checkbox" data-name="status" data-familia="global" data-modo="individual" value="A">
                  </section>

                  <section class="filtro historias-status">
                    <input type="checkbox" data-name="status" data-familia="global" data-modo="individual" value="D">
                  </section>

                </div>        

                <section class="tooltip-filtro">

                  <button id="procesar" class="aplicar-filtros">
                    <svg aria-hidden="true" style="pointer-events: none" focusable="false" data-prefix="fas" data-icon="check" class="svg-inline--fa fa-check fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z"></path></svg>
                  </button>

                </section>

              </div>

              <div id="historia-notificaciones">
                
                <?php 
                  if ($_SESSION['usuario']['rol'] == 'DOCTOR') {
                ?>
                  <button id="notificacion-doctor">
                    <svg style="width: 15px; height: 15px;" class="iconos" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><path fill="currentColor" d="M64 32C64 14.3 49.7 0 32 0S0 14.3 0 32V64 368 480c0 17.7 14.3 32 32 32s32-14.3 32-32V352l64.3-16.1c41.1-10.3 84.6-5.5 122.5 13.4c44.2 22.1 95.5 24.8 141.7 7.4l34.7-13c12.5-4.7 20.8-16.6 20.8-30V66.1c0-23-24.2-38-44.8-27.7l-9.6 4.8c-46.3 23.2-100.8 23.2-147.1 0c-35.1-17.6-75.4-22-113.5-12.5L64 48V32z"/></svg>
                  </button>  
                <?php 
                  } else if ($_SESSION['usuario']['rol'] == 'ADMINISTRACION') {
                ?>
                  <button id="notificacion-doctor" data-hidden>
                    <svg style="width: 15px; height: 15px;" class="iconos" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><path fill="currentColor" d="M64 32C64 14.3 49.7 0 32 0S0 14.3 0 32V64 368 480c0 17.7 14.3 32 32 32s32-14.3 32-32V352l64.3-16.1c41.1-10.3 84.6-5.5 122.5 13.4c44.2 22.1 95.5 24.8 141.7 7.4l34.7-13c12.5-4.7 20.8-16.6 20.8-30V66.1c0-23-24.2-38-44.8-27.7l-9.6 4.8c-46.3 23.2-100.8 23.2-147.1 0c-35.1-17.6-75.4-22-113.5-12.5L64 48V32z"/></svg>
                  </button>
                <?php 
                  }
                ?>
              </div>

            </div>

            <!--3)---------------------------------------------------------------------------------------->
            <div id="tabla-principal" class="tabla-ppal table-min">
              <table id="tabla-historias" class="table table-bordered table-striped">
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
                <input type="number" class="numeracion" maxlength="3" minlength="0" title="[ENTER] para cargar página">
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