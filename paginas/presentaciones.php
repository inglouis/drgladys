<?php 
  
  //---------------------------------------
  //LLAMADO DE LAS CLASES FUNCIONES DE PHP 
  //---------------------------------------
  include_once('../clases/presentaciones.class.php');

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
      <title>PRESENTACIONES</title>
      <script type="module" src="../js/presentaciones.js" defer></script>
      <script type="module" src="../js/main.js" defer></script>

      <style type="text/css">
        .btn-eliminar {
          width: 25px;
        height: 25px;
        background: #f44336;
        border: none;
        align-items: center;
        display: inline-flex;
        justify-content: center;
        color: #fff;
        padding: 0px;
        padding-top: 2px;
        }

        .btn-eliminar:hover {
          background: black;
        }
      </style>

  </head>

  <!------------------------- CUERPO ----------------------- -->
  <!-------------------------------------------------------- -->
  <body data-scroll>

    <!-------------------------------------------------------- -->
    <!------------------------- ELIMINAR  -------------------- -->
    <!-------------------------------------------------------- -->

    <div id="crud-eliminar-popup" class="popup-oculto" data-crud='popup'>
      <div id="crud-eliminar-pop" class="popup-oculto">
        <button id="crud-eliminar-cerrar" data-crud='cerrar'>X</button>
        <section id="crud-eliminar-titulo" data-crud='titulo'>
            ¿Confirma eliminación de la presentaciones?
        </section>
        <p style="color:red">Esto eliminará permanentemente el presentacion del sistema</p>
        <section id="crud-eliminar-botones" data-crud='botones'>
          <button class="botones-formularios eliminar">CONFIRMAR</button>
          <button class="botones-formularios cerrar">CANCELAR</button> 
        </section>
      </div>
    </div>

    <!-------------------------------------------------------- -->
    <!------------------------- INSERTAR  -------------------- -->
    <!-------------------------------------------------------- -->
    <div id="crud-insertar-popup" class="popup-oculto" data-crud='popup'>

      <div id="crud-insertar-pop" class="popup-oculto" style="width:50%; min-width:600px ;height: fit-content;">

        <button id="crud-insertar-cerrar" data-crud='cerrar'>X</button>

        <section id="crud-insertar-titulo" data-crud='titulo'>
          Insertar presentación
        </section> 

        <section class="filas">

          <div class="columnas">
            
            <div>
              <label for="insertar-medicamento" class="requerido">Medicamento:</label>
              <section data-grupo="cc-medicamentos-insertar" class="combo-consulta">
                <input type="text" placeholder="Buscar medicamento" data-limit="">
                <select class="insertar-valores lleno scroll"></select>
              </section>
            </div>

          </div>


          <div class="columnas">

            <div>

              <label>Presentación del medicamento</label>

              <div style="    
                display: flex;
                flex-direction: row;
                column-gap: 5px;
                align-items: center;
               ">
                <input type="text" id="presentaciones-busqueda-insertar" data-estilo="busqueda" placeholder="Busqueda">
                <button style="position: relative; top: 0px; height: 100%;" id="nuevo-presentacion-insertar" class="btn-nuevo btn btn-primary" title="Agregar fila">+</button>
              </div>

              <div class="tabla-ppal scroll" data-estilo="tabla-presentaciones">
                <table id="tabla-presentaciones-insertar" class="table table-bordered table-striped">
                  <thead></thead>
                  <tbody></tbody>
                </table>
              </div>

            </div>

          </div>  

        </section>

        <section id="crud-insertar-botones" data-crud='botones' style="column-gap: 10px; padding: 10px;">
          <button class="botones-formularios insertar">CONFIRMAR</button>
          <button class="botones-formularios cerrar">CANCELAR</button> 
        </section>
      </div> 
    </div>

    <!-------------------------------------------------------- -->
    <!------------------------- EDITAR  ---------------------- -->
    <!-------------------------------------------------------- -->
    <div id="crud-editar-popup" class="popup-oculto" data-crud='popup'>
      <div id="crud-editar-pop" class="popup-oculto" style="width: 50%; min-width: 600px;">
        <button id="crud-editar-cerrar" data-crud='cerrar'>X</button>
        <section id="crud-editar-titulo" data-crud='titulo'>
            Editar presentación
        </section> 

        <section class="filas">

          <div class="columnas" style="width:100%;">
            <div>
              <label>Médicamento</label>  
              <input type="text" id="editar-nombre" data-valor="nombre" readonly="true" class="editar-valores upper visual">
            </div>
          </div>

          <div class="columnas">

            <div>
              
              <label>Presentación del medicamento</label>

              <div style="
                display: flex;
                flex-direction: row;
                column-gap: 5px;
                align-items: center;
              ">
                <input type="text" id="presentaciones-busqueda-editar" data-estilo="busqueda" placeholder="Busqueda" class="upper">
                <button style="position: relative; top: 0px; height: 100%;" id="nuevo-presentacion-editar" class="btn-nuevo btn btn-primary" title="Agregar fila">+</button>
              </div>

              <div class="tabla-ppal scroll" data-estilo="tabla-presentaciones">
                <table id="tabla-presentaciones-editar" class="table table-bordered table-striped">
                  <thead></thead>
                  <tbody></tbody>
                </table>
              </div>

            </div>

          </div>

          <div class="columnas" style="width:100%;">
            <div>
              <label>Estado</label>
               <select class="editar-valores lleno" id="editar-estado" data-valor="status">
                  <option value="A">ACTIVADO</option>
                  <option value="D">DESACTIVADO</option>
               </select> 
            </div>
          </div>

        </section>

        <section id="crud-editar-botones" data-crud='botones' style="column-gap: 10px; padding: 10px;">
          <button class="botones-formularios editar">CONFIRMAR</button>
          <button class="botones-formularios cerrar">CANCELAR</button> 
        </section>
      </div> 
    </div>

    <!---------------------------------------------------------------------->
    <!------------                P A G I N A                  ------------->
    <!---------------------------------------------------------------------->

    <div class="container-fluid bg-3 paginas-contenedor">

      <div id="titulo-contenedor">  
        <h3>LISTADO DE PRESENTACIONES</h3>
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

              <div style="display: flex;justify-content: center;align-items: center;padding: 0px 5px;">
                
                <button id="presentaciones-insertar" class="btn btn-nuevo tooltip-filtro">+</button>

              </div>

              <div style="display: flex;justify-content: center;align-items: center;padding: 0px 5px;">
                
                <a href="../paginas/medicamentos.php" id="regresar-medicamentos">

                  <button style='top: 10px; right: 0px; position: absolute;' class="btn btn-nuevo tooltip-filtro-reverso" title="Regresar a medicamentos">
                    <svg style="width: 10px" xmlns="http://www.w3.org/2000/svg" class="iconos" viewBox="0 0 384 512"><path fill="currentColor" d="M32 448c0 35.2 28.8 64 64 64h192c35.2 0 64-28.8 64-64V128H32V448zM96 304C96 295.2 103.2 288 112 288H160V240C160 231.2 167.2 224 176 224h32C216.8 224 224 231.2 224 240V288h48C280.8 288 288 295.2 288 304v32c0 8.799-7.199 16-16 16H224v48c0 8.799-7.199 16-16 16h-32C167.2 416 160 408.8 160 400V352H112C103.2 352 96 344.8 96 336V304zM360 0H24C10.75 0 0 10.75 0 24v48C0 85.25 10.75 96 24 96h336C373.3 96 384 85.25 384 72v-48C384 10.75 373.3 0 360 0z"/></svg>
                  </button>

                </a>

              </div>

              <div id="presentaciones-status" class="filtros" style="padding-left: 10px;">

                <div data-grupo="status" class="grupo">

                  <section class="filtro presentaciones-status">
                    <input type="checkbox" data-name="status" data-familia="global" data-modo="individual" value="A">
                  </section>

                  <section class="filtro presentaciones-status">
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
              <table id="tabla-presentaciones" class="table table-bordered table-striped">
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