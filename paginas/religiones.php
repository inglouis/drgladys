<?php 
  
  //---------------------------------------
  //LLAMADO DE LAS CLASES FUNCIONES DE PHP 
  //---------------------------------------
  include_once('../clases/religiones.class.php');

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
      <title>religiones</title>
      <script type="module" src="../js/religiones.js" defer></script>
      <script type="module" src="../js/main.js" defer></script>
  </head>
    
<!------------------------- CUERPO ----------------------- -->
  <!-------------------------------------------------------- -->
  <body data-scroll>

    <!-------------------------------------------------------- -->
    <!--------------------- INFORMARCIÓN  -------------------- -->
    <!-------------------------------------------------------- -->
    <div id="crud-informacion-popup" class="popup-oculto" data-crud='popup'>
      <div id="crud-informacion-pop" class="popup-oculto" data-scroll style="justify-content: flex-start;">

        <button id="crud-informacion-cerrar" data-crud='cerrar'>X</button>

        <section id="crud-informacion-titulo" data-crud='titulo'>
          INFORMACIÓN DE LA RELIGIÒN 
        </section>

        <div class="filas" style="height: fit-content;">
          <div class="columnas">
            <div>
              <label>Nombre</label>
              <input type="text" data-valor="nombre" class="informacion-valores upper visual" disabled="true">
            </div>
          </div>


          <div class="columnas">
            <div>
              <label class="requerido">Estado de la Religiòn</label>
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

    <!-------------------------------------------------------- -->
    <!---------------------------- EDITAR -------------------- -->
    <!-------------------------------------------------------- -->
    <div id="crud-editar-popup" class="popup-oculto" data-crud='popup'>
      <div id="crud-editar-pop" class="popup-oculto" data-scroll style="justify-content: flex-start; min-width: 400px; width: 40%">
        <button id="crud-editar-cerrar" data-crud='cerrar'>X</button>
        <section id="crud-editar-titulo" data-crud='titulo'>
          EDITAR RELIGIÒN
        </section> 

        <div class="filas" style="justify-content: flex-start;">

          <div class="columnas">
            
            <div>
              <label>Nombre</label>
                <input type="text" data-valor="nombre" placeholder="Descripcion de la Religiòn" class="editar-valores lleno iupper">
            </div>
          </div>

          <div class="columnas">
            <div>
              <label class="requerido">Estado de la Religiòn</label>
              <select class="editar-valores lleno" data-valor="status">
                <option value="">SELECCIONAR</option>
                <option value="A">ACTIVA</option>
                <option value="D">DESACTIVADA</option>
              </select>            
            </div>
          </div>

          <section id="crud-editar-botones" data-crud='botones' style="column-gap: 10px; padding: 10px;">
            <button class="botones-formularios editar">CONFIRMAR</button>
            <button class="botones-formularios cerrar">CANCELAR</button> 
          </section>
        </div>
      </div>
    </div>

    <!-------------------------------------------------------- -->
    <!---------------------------- INSERTAR------------------- -->
    <!-------------------------------------------------------- -->
    <div id="crud-insertar-popup" class="popup-oculto" data-crud='popup'>
      <div id="crud-insertar-pop" class="popup-oculto" style="width: 50%">
        <button id="crud-insertar-cerrar" data-crud='cerrar'>X</button>
        <section id="crud-insertar-titulo" data-crud='titulo'>
          AGREGAR RELIGIÒN
        </section> 

        <div class="filas">

          <div class="columnas" style="align-items: baseline;">

            <div>
              <label class="requerido">Nombre</label>  
              <input type="text" placeholder="Descripción de la Religiòn" class="nuevos lleno upper">
            </div>
          </div>
        </div>


        <section id="crud-insertar-botones" data-crud='botones' style="column-gap: 10px">
          <button class="botones-formularios insertar">CONFIRMAR</button>
          <button class="botones-formularios cerrar">CANCELAR</button> 
        </section>

      </div>
    </div>

    <!---------------------------------------------------------------------->
    <!------------                P A G I N A                  ------------->
    <!---------------------------------------------------------------------->
    <div class="container-fluid bg-3 paginas-contenedor">

      <div id="titulo-contenedor">  
        <h3>LISTADO DE RELIGIONES</h3>
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
                
                <button id="religiones-insertar" class="btn btn-nuevo tooltip-filtro">+</button>

              </div>

              <div id="religiones-filtros" class="filtros" style="padding-left: 10px;">

                <div data-grupo="status" class="grupo">

                  <section class="filtro religiones-status">
                    <input type="checkbox" data-name="status" data-familia="global" data-modo="individual" value="A">
                  </section>

                  <section class="filtro religiones-status">
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
              <table id="tabla-religiones" class="table table-bordered table-striped">
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