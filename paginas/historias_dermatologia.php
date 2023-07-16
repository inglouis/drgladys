<?php 
  
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
      <script type="module" src="../js/historias_antecedentes.js" defer></script>
      <script type="module" src="../js/historias_informes.js" defer></script>
      <script type="module" src="../js/historias_recipes.js" defer></script>
      <script type="module" src="../js/historias_reposos.js" defer></script>
      <script type="module" src="../js/main.js" defer></script>
  </head>
    
  <!------------------------- CUERPO ----------------------- -->
  <!-------------------------------------------------------- -->
  <body data-scroll id="body">

    <div id="cruds" style="width: 100%; height: 100%">
      
  	<?php 
  		include_once('../cruds/historias.crud.php'); 
  		include_once('../cruds/historias_antecedentes.crud.php');
  		include_once('../cruds/historias_informes.crud.php');
  		include_once('../cruds/historias_recipes.crud.php');
      include_once('../cruds/historias_reposos.crud.php');
  	?>

    </div>
  	<!-------------------------------------------------------------------------------------------->
    <!------------------------ PAGINACION ENTRE CONTENEDORES ------------------------------------->
    <!-------------------------------------------------------------------------------------------->
    <div id="paginacion-contenedores" data-hidden>
  		<button class="informacion" title="Consultar información del paciente"></button>
  		<button class="editar" title="Editar historia del paciente"></button>
  		<button class="antecedentes" title="Antecedentes del paciente"></button>
  		<button class="informes" title="Informes del paciente"></button>
  		<button class="recipes"title="Récipes del paciente"></button>
      <button class="reposos"title="Reposos del paciente"></button>
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

            </div>

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