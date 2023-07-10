<?php 
  include_once('../clases/errores.class.php');
  $obj = new Model();

?>
<!DOCTYPE html>

<html lang="es">
  <head>
      <?php require_once('../estructura/head.php');?>
      <title>ERRORES: PHP - APACHE - POSTGRESQL</title>
      <script type="module" src="../js/errores.js" defer></script>
      <script type="module" src="../js/main.js" defer></script>
      <style type="text/css">
        .table-min {
          max-height: 85vh !important;
          min-height: 85vh !important;
        }

        #tabla-errores thead tr th:nth-child(3)  {
        	width: 50px;
        }

        #tabla-errores tbody tr td:nth-child(3) {
        	width: 50px;
        	display: inline-flex;
		    justify-content: center;
		    align-items: center;
    		height: 100%;
        }

        .btn-danger:hover {
          background: #f23030 !important;
          color: #fff;
        }
      </style>
  </head>
  <body class="scroll-form">

  	<template id="errores-contenedor">
      <section class="contenido-error" style="position: relative;">

        <div style="position: absolute; right: 5px; top: 5px;" class="valor-cabecera">
          <label>ID DEL ERROR</label>
          <input type="number" class="error-id input-resaltar" readonly="true">
        </div>

        <div class="filas" style="height: fit-content; margin-top: 20px;">
          <div class="columnas">
            <div>
              <label>Ruta del error</label>
              <input type="text" class="error-ruta centro" readonly="true">
            </div>
          </div>
        </div>

        <div class="filas" style="height: fit-content; ">
          <div class="columnas">
            <div>
              <label>Mensaje de error</label>
              <input type="text" class="error-mensaje centro" readonly="true">
            </div>

            <div style="width: 30%;">
              <label>Código del error</label>
              <input type="text" class="error-codigo centro" readonly="true">
            </div>

            <div style="width: 30%">
              <label>Línea del error</label>
              <input type="text" class="error-linea centro" readonly="true">
            </div>   
          </div>
        </div>

        <div class="filas" style="height: fit-content">
          <div class="columnas">
            <div>
              <label>Mensaje personalizado</label>
              <input type="text" class="error-personalizado centro" readonly="true">
            </div>

            <div style="width: 50%;">
              <label>Fecha</label>
              <input type="text" class="error-fecha centro" readonly="true">
            </div>

            <div style="width: 50%;">
              <label>Hora</label>
              <input type="text" class="error-hora centro" readonly="true">
            </div>
          </div>
        </div>

        <div style="width: 100%; height: 100%; display: flex; flex-direction: column; padding: 10px;">
          <label style="text-align: left">Recorrido del error</label>
          <textarea readonly="true" class="error-recorrido scroll" readonly="true" row="20" style="box-sizing: content-box; padding: 5px !important; resize: vertical; height: 120px"></textarea>
        </div>

      </section>
    </template>

    <!---------------------------------------------------------------------->
    <!------------                P A G I N A                  ------------->
    <!---------------------------------------------------------------------->
    <div class="container-fluid bg-3 paginas-contenedor">

      <div id="titulo-contenedor">  
        <h3>ERRORES: PHP - APACHE - POSTGRESQL</h3>
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
                
                <button id="errores-insertar" class="btn btn-nuevo tooltip-filtro">+</button>

              </div>

            </div>

            <div id="tabla-principal" class="tabla-ppal table-min" data-scroll>
              <table id="tabla-errores" class="table table-bordered table-striped">
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