<?php 
  include_once('../clases/medicinas.class.php');
  $obj = new Model();

  $dia  = $obj->fechaHora('America/Caracas','d-m-Y');

?>
<!DOCTYPE html>
<html lang="es">
  <head>
      <?php require_once('../estructura/head.php');?>
      <title>ACTUALIZACIÓN DE MEDICAMENTOS DADOS A PACIENTES</title>
      <script type="module" src="../js/medicinas.js" defer></script>
      <script type="module" src="../js/main.js" defer></script>
      <style>
        #tabla-medicamentos tbody tr td:nth-child(1) {
          width: 3% !important;
        }

        #tabla-medicamentos tbody tr td:nth-child(2) {
          width: 10% !important;
        }

        #tabla-medicamentos tbody tr td:nth-child(3) {
          width: 40% !important;
        }

        #tabla-medicamentos tbody tr td:nth-child(4) {
          width: 40% !important;
        }

        #tabla-medicamentos tbody tr td:nth-child(5) {
          width: 10% !important;
          min-width: 100px;
        }
      </style>  
  </head>
  <body data-resaltar class="scroll-form">


    <!--//////////////////////////////////////////////////////////////////////////////////-->
    <!--/////////////                        consultar   ////////////////////////////////////-->
    <!--//////////////////////////////////////////////////////////////////////////////////-->
    <div id="crud-consultar-popup" class="popup-oculto" data-crud='popup'>
      <div id="crud-consultar-pop" class="popup-oculto" style="width: 60%; min-width: 800px;">
        <button id="crud-consultar-cerrar" data-crud='cerrar'>X</button>
        <section id="crud-consultar-titulo" data-crud='titulo'>
          MEDICAMENTO DADOS AL PACIENTE
        </section> 
        <section class="filas">
          <div class="columnas">
            <!--//////////////////////////////////////////////////////////////////////////-->
            <!--/////////////          Datos Principales del paciente ////////////////////-->
            <!--//////////////////////////////////////////////////////////////////////////-->
            <div style="width: fit-content;">
              <label for="consultar-id_historia" class="requerido centro" style="width: 100%; text-align: center; padding: 0px 0px 6px 0px;">Historia</label>  
              <input type="number" id="consultar-id_historia" data-valor="id_historia" class="crud-valores upper centro" readonly="true" style="padding: 8px;" >
            </div>
            <div style="width: fit-content;">
              <label for="consultar-nume_cedu" style="width: 100%; text-align: center; padding: 0px 0px 6px 0px;">No Cédula</label>  
              <input type="text" id="consultar-nume_cedu" data-valor="nume_cedu" class="crud-valores  centro" readonly="true" style="padding: 8px;">
            </div>
            <div style="width: fit-content;">
              <label for="consultar-nume_hijo" style="width: 100%; text-align: center; padding: 0px 0px 6px 0px;">No Hijo</label>  
              <input type="text" id="consultar-nume_hijo" data-valor="nume_hijo"  class="crud-valores lleno centro" readonly="true" style="padding: 8px;">
            </div>
            <div>
              <label for="consultar-apel_nomb" class="requerido" style="width: 100%; text-align: center; padding: 0px 0px 6px 0px;">Apellidos y Nombres</label>  
              <input type="text" id="consultar-apel_nomb" data-valor="apel_nomb" class="crud-valores" readonly="true" style="padding: 8px;">
            </div>
          </div>
          
          <div class="columnas" style="flex-direction: column;align-items: baseline;">
            <label for="">Medicamentos</label>
            <div>
              <section class="buscador-efecto-nh">
                <input type="text" id="medicamentos-busqueda" placeholder="Busqueda">
              </section>
              <section class="tabla-ppal scroll">
                <table id="tabla-medicamentos-datos" class="table table-bordered table-striped">
                  <thead></thead>
                  <tbody></tbody>
                </table>
              </section>
            </div>
          </div>

        </section>
        <style type="text/css">
          #crud-consultar-botones .cerrar {
            background: #0d6efd;
          }

          #crud-consultar-botones .cerrar:hover {
            background: black;
          }
        </style>
        <section id="crud-consultar-botones" data-crud='botones' style="width:100%; justify-content: end;">
          <button class="botones-formularios cerrar">CERRAR</button> 
        </section>
      </div> 
    </div>

    <!--///////////////////////////////////////////////////////////////////////////////-->
    <!--/////////////////////////////// Página  ///////////////////////////////////////-->
    <!--///////////////////////////////////////////////////////////////////////////////-->
    <div class="container-fluid bg-3 paginas-contenedor">
      <div id="titulo-contenedor">  
        <h3>LISTADO DE MEDICAMENTOS DADOS A PACIENTES</h3>
      </div>
      <div id="contenido-contenedor">        
        <div class="panel-body">
          <section>
            <div class="datos">

              <a href="../paginas/consulta_medicamentos_dados_pacientes.php">
                <button id="ir-optica-consulta" style='width: 100px; font-size: 12px; margin-top: -30px;' class="btn btn-primary pull-right btn-nuevo tooltip-filtro-reverso">
                  REDIRIGIR
                  <svg aria-hidden="true" focusable="false" data-prefix="fas" style="width: 20px; padding-left: 5px;" alt="FontAwesome-icon" data-icon="sign-out-alt" class="svg-inline--fa fa-sign-out-alt fa-w-16 iconos" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M497 273L329 441c-15 15-41 4.5-41-17v-96H152c-13.3 0-24-10.7-24-24v-96c0-13.3 10.7-24 24-24h136V88c0-21.4 25.9-32 41-17l168 168c9.3 9.4 9.3 24.6 0 34zM192 436v-40c0-6.6-5.4-12-12-12H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h84c6.6 0 12-5.4 12-12V76c0-6.6-5.4-12-12-12H96c-53 0-96 43-96 96v192c0 53 43 96 96 96h84c6.6 0 12-5.4 12-12z"></path></svg>
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

              <div id="medicamentos_dados_pacientes-filtros" class="filtros">
                <div data-grupo="status" class="grupo">
                  <section class="filtro medicamentos_dados_pacientes-status">
                    <input type="checkbox" data-name="status" data-familia="global" data-modo="individual" value="A">
                  </section>
                  <section class="filtro medicamentos_dados_pacientes-status">
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
              <table id="tabla-medicamentos_dados_pacientes" class="table table-bordered table-striped">
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
  </body>
</html>