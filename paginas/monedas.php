<?php 
  include_once('../clases/monedas.class.php');
  $obj = new Model();

  $_SESSION['refrescar'] = '..'.$_SERVER['REQUEST_URI'];

?>
<!DOCTYPE html>
<html lang="es">
  <head>
      <?php require_once('../estructura/head.php');?>
      <title>ACTUALIZACIÓN DE PRECIOS DE CONVERSION DE LAS MONEDAS</title>
      <script type="module" src="../js/monedas.js" defer></script>
      <script type="module" src="../js/main.js" defer></script>
  </head>
  <body data-scroll>

    <!--/////////////////////////////////////////////////////////////////-->
    <!--/////////////////////////////////- Eliminar  ////////////////////-->
    <!--/////////////////////////////////////////////////////////////////-->

    <div id="crud-eliminar-popup" class="popup-oculto" data-crud='popup'>
      <div id="crud-eliminar-pop" class="popup-oculto">
        <button id="crud-eliminar-cerrar" data-crud='cerrar'>X</button>
        <section id="crud-eliminar-titulo" data-crud='titulo'>
            ¿Confirma eliminar Moneda ?
        </section>
        <p style="color:red">Esto eliminará permanentemente la Moneda de la Base de Datos, si quieres deshabilitar la Moneda lo puedes hacer desde la Opción de Editar</p>
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
      <div id="crud-insertar-pop" class="popup-oculto" style="width:50%; min-width:600px ;height: fit-content;">
        <button id="crud-insertar-cerrar" data-crud='cerrar'>X</button>
        <section id="crud-insertar-titulo" data-crud='titulo'>
          <button id="crud-insertar-limpiar" title="Limpiar Contenido" data-crud='limpiar'>
            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="trash-alt" class="svg-inline--fa fa-trash-alt fa-w-14 iconos-b" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M32 464a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128H32zm272-256a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zm-96 0a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zm-96 0a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zM432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16z"></path></svg>
          </button>
          Insertar Tipo Moneda
        </section> 
   
        <section class="filas">
          <div class="columnas">
            <div>
              <label for="insertar-nombre" class="requerido">Nombre de la Moneda</label> 
              <input type="text" name="insertar-nombre" id="insertar-nombre" size="100" minlength="1" maxlength="20" class="nuevos lleno upper" required="true">
            </div>
            <div>
              <label for="insertar-unidad" class="requerido">Unidad</label> 
              <input type="text" name="insertar-unidad" id="insertar-unidad" size="10" minlength="1" maxlength="10" class="nuevos lleno upper" required="true">
            </div>
          </div>

          <div class="columnas">
            <div>
              <label for="insertar-conver" class="requerido" title="DOLAR">Valor de Conversión ($)</label> 
              <input type="number" id="insertar-conver" class="nuevos lleno upper" required="true">
            </div>
            <div>
              <label for="insertar-conver_p" class="requerido" title="PESOS">Valor de Conversión (COL)</label> 
              <input type="number" id="insertar-conver_p" class="nuevos lleno upper" required="true">
            </div>
          </div>
          
        </section>
        <section id="crud-insertar-botones" data-crud='botones'>
          <button class="botones-formularios insertar">CONFIRMAR</button>
          <button class="botones-formularios cerrar">CANCELAR</button> 
        </section>
      </div> 
    </div>

    <!--//////////////////////////////////////////////////////////////////////////////-->
    <!--///////////////////                 Editar          //////////////////////////-->
    <!--//////////////////////////////////////////////////////////////////////////////-->
    <div id="crud-editar-popup" class="popup-oculto" data-crud='popup'>
      <div id="crud-editar-pop" class="popup-oculto" style="width: 50%; min-width: 600px;">
        <button id="crud-editar-cerrar" data-crud='cerrar'>X</button>
        <section id="crud-editar-titulo" data-crud='titulo'>
          EDITAR DATOS DE LA MONEDA
        </section> 

        <section class="filas">

          <div class="columnas">
            <div>
              <label for="editar-nombre" class="requerido">Nombre de la Moneda</label>  
              <input type="text" name="editar-nombre" id="editar-nombre" data-valor="nombre" minlength="1" maxlength="20" class="crud-valores lleno upper">
            </div>
            <div>
              <label for="editar-unidad" class="requerido">Unidad</label> 
              <input type="text" name="editar-unidad" id="editar-unidad" data-valor="unidad" minlength="1" maxlength="10" class="crud-valores lleno upper">
            </div>  
          </div>

          <div class="columnas">
            <div>
              <label for="editar-conver" class="requerido" title="DOLAR">Valor de Conversión ($)</label> 
              <input type="number" step="0,01" min="0" id="editar-conver" data-valor="conver" class="crud-valores lleno">
            </div>
            <div>
              <label for="editar-conver_p" class="requerido" title="PESOS">Valor de Conversión (COL)</label> 
              <input type="number" step="0,000001" min="0" id="editar-conver_p" data-valor="conver_p" class="crud-valores lleno">
            </div>
          </div>

          <div class="columnas">
            <div>
              <label for="editar-estado">Estado</label>
              <select class="crud-valores lleno" name="editar-estado" id="editar-estado" data-valor="status">
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

    <!--////////////////////////////////////////////////////////////////////////-->
    <!--//////////////////////////////////////// Página ////////////////////////-->
    <!--////////////////////////////////////////////////////////////////////////-->
    <div class="container-fluid bg-3 paginas-contenedor">
      <div id="titulo-contenedor">  
        <h3>LISTADO DE CONVERSIÓN MONEDAS</h3>
      </div>
      <div id="contenido-contenedor">        
        <div class="panel-body">
          <section>
            <div class="datos">

              <div style="position: absolute; right: 0px; top: 0px;">
                <div style="position: relative;">
                  <button id="notas-importantes" style='margin-top: -30px; background: #fd5656 !important; border: 1px solid red;' class="btn btn-primary pull-right btn-nuevo tooltip-filtro-reverso input-resaltar">
                    !
                  </button>

                  <div id="notas-importantes-contenedor" data-hidden>
                    <div style="font-size: 20px !important; text-align: left; border-bottom: 1px dashed #ccc; font-weight: bold;">Notas importantes</div>
                    <div style="text-align: left;">
                      <ul style="padding-inline-start: 20px; font-size: 16px;">
                        <li>
                          <b style="color:red">PRECAUCIÓN:</b> Una vez una moneda sea cargada al sistema esta NO PODRÁ ser ELIMINADA, solo podrá ser EDITADA
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>

              <button id="insertar-monedas" style='margin-top:-30px; right: 30px' class="btn btn-primary pull-right btn-nuevo tooltip-filtro-reverso">
                +
              </button>

              <div class="buscador-efecto">
                <input type="text" name="busqueda" id="busqueda" placeholder="Busqueda">
              </div> 
              <div>
                <button id="buscar">
                  <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="search" class="svg-inline--fa fa-search fa-w-16 iconos" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z"></path></svg>  
                </button>
              </div>

              <div id="monedas-filtros" class="filtros">
                <div data-grupo="status" class="grupo">
                  <section class="filtro monedas-status">
                    <input type="checkbox" data-name="status" data-familia="global" data-modo="individual" value="A">
                  </section>
                  <section class="filtro monedas-status">
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
              <table id="tabla-monedas" class="table table-bordered table-striped">
                  <thead>
                  </thead>
                  <tbody>
                  </tbody>
              </table>
            </div>

            <div style="display: flex; height: 100%;">
                <button id="izquierda" class="botones"><?php echo "<"?></button>
                <div id="numeracion">
                   <span class="numeracion"></span>
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