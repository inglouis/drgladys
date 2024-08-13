<?php 
  include_once('../clases/informes_especiales.class.php');
  $obj = new Model();

  if (isset($_REQUEST['id'])) {
    $id = (int)$_REQUEST['id'];
  } else {
     throw new Exception('operación inválida: ID necesario para imprimir historia'); 
  }

  $sql = "select id_informe, titulo_indice from historias.informes_especiales order by id_informe";
  $informes = $obj->e_pdo($sql)->fetchAll(PDO::FETCH_ASSOC);
  $informesIndice = '<div id="indice-contenido">';

  foreach ($informes as $i) {
    $informesIndice .= "
      <div title='Seleccionar informe' data-id='$i[titulo_indice]'>
        <b style='color:green'>$i[id_informe]&nbsp;-&nbsp;</b>$i[titulo_indice]
      </div>
    ";    
  }

  $informesIndice .= "</div>";

?>
<!DOCTYPE html>
<html lang="es">
  <head>
      <?php require_once('../estructura/head.php');?>
      <title>ACTUALIZACIÓN DE INFORMES ESPECIALES</title>
      <script type="text/javascript">window.id_historia = <?php echo $id?></script>
      <script type="module" src="../js/informes_especiales.js" defer></script>
      <script type="module" src="../js/main.js" defer></script>
      <style type="text/css">
        #tabla-informes_especiales {
          height: 100%;
        }

        .informe-contenedor {
          padding: 15px;
        }

        .contenido-informe {
          position: relative;
          border: 1px solid #ccc;
          display: flex !important;
          flex-direction: column;
          padding: 40px 0px;
        }

        .contenido:hover {
          border: 1px solid black;
          transition: 0.3s ease all;
        }

        .informe-titulo {
          text-align: center;
          -webkit-user-select: none;
          -moz-user-select: none;
          -khtml-user-select: none;
          -ms-user-select: none;
        }

        .informe-detalles {
          min-height: 150px !important;
        }

        .informe-detalles, .informe-editar {
          resize: none;
          height: 100%;
          min-height: 400px;
          border-radius: 0px;
          font-size: 16px !important;
          padding: 0px 10px !important;
          font-weight: 100 !important;
          text-align: justify;
          border: 2px dashed #3e68ff !important;
          -webkit-user-select: none;
          -moz-user-select: none;
          -khtml-user-select: none;
          -ms-user-select: none;
        }

        .informe-codigo {
          -webkit-user-select: none;
          -moz-user-select: none;
          -khtml-user-select: none;
          -ms-user-select: none;
          text-align: center;
        }

        textarea {
          background-image: linear-gradient(#c4c4c4 5%, #ffffff 0%);
          background-size: 100% 25px;
          border: 1px solid #CCC;
          width: 100%;
          height: 400px;
          line-height: 25px;
        }

        #crud-insertar-botones button:nth-child(1), #crud-editar-botones button:nth-child(1) {
          background: #0d6efd;
          margin-right: 0px;
          color: #fff;
        }

        #crud-insertar-botones button:nth-child(2), #crud-editar-botones button:nth-child(2) {
          background: #4caf50;
          color: #fff;
        }

        #crud-insertar-botones button:nth-child(3), #crud-editar-botones button:nth-child(3) {
          background: #f44336 !important;
          color: #fff;
        }

        #editar-contenido-contenedor, #insertar-contenido-contenedor {
          display: flex;
          flex-direction: column;
          position: absolute;
          background: #000000ba;
          padding: 10px;
          color: #fff;
          width: fit-content;
          z-index: 1;
        }

        .vista-previa::after {
          top: 0px !important;
        }
      </style>
  </head>
  <body data-resaltar class="scroll-form">

    <template id="informe-contenedor">
      <section class="contenido-informe">
        <div style="position: absolute; right: 5px; top: 5px;" class="valor-cabecera">
          <label>Código del informe</label>
          <input type="number" class="informe-codigo input-resaltar" readonly="true">
        </div>
        <div style="position: absolute; right: 250px; top: 5px;" class="valor-cabecera">
          <label>Estado</label>
          <input type="text" class="informe-status" readonly="true" style="width: 25px" title="[A]:activo / [D]:inactivo">
        </div>
        <div class="filas" style="height: fit-content">
          <div class="columnas">
            <div>
              <label>Título del informe</label>
              <input type="text" class="informe-titulo" readonly="true">
            </div>  
            <div>
              <label>Título del indice</label>
              <input type="text" class="informe-titulo-indice" style="text-align: center" readonly="true">
            </div>  
          </div>
        </div>
        <div style="width: 100%; height: 100%; display: flex; flex-direction: column; padding: 10px">
          <label style="text-align: left">Contenido del informe</label>
          <textarea class="informe-detalles scroll" readonly="true" row="10" style="box-sizing: content-box; padding: 5px !important;"></textarea>
        </div>
        <div style="position: absolute; bottom: 10px; right: 8px">
          <button class="editar btn btn-success" title="Editar e imprimir informe especial" style="    
            height: 29px;
            width: 150px;
            justify-content: center;
            align-items: center;
            font-size: 15px !important;
            display: inline-flex;
          ">
            Editar e imprimir
            <svg style="padding-left: 3px; width: 25px" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="cog" class="svg-inline--fa fa-cog fa-w-16 iconos" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M487.4 315.7l-42.6-24.6c4.3-23.2 4.3-47 0-70.2l42.6-24.6c4.9-2.8 7.1-8.6 5.5-14-11.1-35.6-30-67.8-54.7-94.6-3.8-4.1-10-5.1-14.8-2.3L380.8 110c-17.9-15.4-38.5-27.3-60.8-35.1V25.8c0-5.6-3.9-10.5-9.4-11.7-36.7-8.2-74.3-7.8-109.2 0-5.5 1.2-9.4 6.1-9.4 11.7V75c-22.2 7.9-42.8 19.8-60.8 35.1L88.7 85.5c-4.9-2.8-11-1.9-14.8 2.3-24.7 26.7-43.6 58.9-54.7 94.6-1.7 5.4.6 11.2 5.5 14L67.3 221c-4.3 23.2-4.3 47 0 70.2l-42.6 24.6c-4.9 2.8-7.1 8.6-5.5 14 11.1 35.6 30 67.8 54.7 94.6 3.8 4.1 10 5.1 14.8 2.3l42.6-24.6c17.9 15.4 38.5 27.3 60.8 35.1v49.2c0 5.6 3.9 10.5 9.4 11.7 36.7 8.2 74.3 7.8 109.2 0 5.5-1.2 9.4-6.1 9.4-11.7v-49.2c22.2-7.9 42.8-19.8 60.8-35.1l42.6 24.6c4.9 2.8 11 1.9 14.8-2.3 24.7-26.7 43.6-58.9 54.7-94.6 1.5-5.5-.7-11.3-5.6-14.1zM256 336c-44.1 0-80-35.9-80-80s35.9-80 80-80 80 35.9 80 80-35.9 80-80 80z"></path></svg>
          </button>
          <button class="eliminar btn btn-danger" title="¡Eliminar informe permanentemente! [BLOQUEADO]" disabled style="border: 1px solid #ccc">
            X
          </button>
        </div>
      </section>
    </template>

    <!--//////////////////////////////////////////////////////////////////////////////////-->
    <!--///////////////////////////- Eliminar  ///////////////////////////////////////////-->
    <!--//////////////////////////////////////////////////////////////////////////////////-->

    <div id="crud-eliminar-popup" class="popup-oculto" data-crud='popup'>
      <div id="crud-eliminar-pop" class="popup-oculto">
        <button id="crud-eliminar-cerrar" data-crud='cerrar'>X</button>
        <section id="crud-eliminar-titulo" data-crud='titulo'>
            ¿Confirma eliminar Informe Especial?
        </section>
        <p style="color:red">Esto eliminará permanentemente el Informe de la Base de Datos, si quieres deshabilitar el Informe lo puedes hacer desde la Opción de Editar</p>
        <section id="crud-eliminar-botones" data-crud='botones'>
            <button class="botones-formularios eliminar">CONFIRMAR</button>
            <button class="botones-formularios cerrar">CANCELAR</button> 
        </section>
      </div>
    </div>
    
    <!--///////////////////////////////////////////////////////////////////////////////-->
    <!--//////////                        insertar   ////////////////////////////////////-->
    <!--///////////////////////////////////////////////////////////////////////////////-->
    <div id="crud-insertar-popup" class="popup-oculto" data-crud='popup'>
      <div id="crud-insertar-pop" class="popup-oculto" style="width: 100%; min-width: 600px; height: 100%; padding: 60px">
        <button id="crud-insertar-cerrar" data-crud='cerrar'>X</button>
        <section id="crud-insertar-titulo" data-crud='titulo'>
          Insertar informe especial
        </section>

        <section class="filas" style="width: 90%">
          <div class="columnas">
            <div title="[H]: Abreviatura del número de historia del paciente">
              <label for="insertar-historia" class="requerido">N° de historia [H]</label>  
              <input type="text" data-valor="id_historia" readonly="true" class="datos-historia lleno upper">
            </div>
            <div title="[c]: Abreviatura del cédula del paciente">
              <label for="insertar-cedula" class="requerido">Cédula [C]</label>  
              <input type="text" data-valor="nume_cedu" readonly="true" class="datos-historia lleno upper">
            </div>
            <div title="[N]: Abreviatura del nombre del paciente">
              <label for="insertar-nombre" class="requerido">Nombre y apellidos o razón social [N]</label>  
              <input type="text" data-valor="apel_nomb" readonly="true" class="datos-historia lleno upper">
            </div>
          </div>
          <div class="columnas" style="flex-direction: column;">
            <div>
              <label>Título del informe</label>
              <input data-valor="titulo" type="text" class="nuevos upper" style="text-align: center">
            </div>
            <div>
              <label>Título del indice</label>
              <input type="text" class="nuevos upper center" style="text-align: center">
            </div>
            <div id="insertar-contenido">
              <label>Contenido del informe</label>
              <textarea spellcheck="true" data-valor="contenido" rows="9" class="nuevos lleno upper informe-insertar scroll" style="
                max-height: 250px;
                min-height: 250px;
                background-repeat: round;
                font-size: 16px !important;
                box-sizing: content-box;
                padding: 5px !important;
                border:3px dashed #3e68ff;
              "></textarea>
            </div>
            <div id="insertar-contenido-contenedor" style="display: flex; flex-direction: column; position: absolute"data-hidden>
              <section>Personalización</section>
              <section>-----------------</section>
              <span>[   ]: ESPACIOS BLANCOS</span>
              <span>[BR]: SEPARAR LÍNEA</span>
              <span>[BR2]: ROMPER LÍNEA</span>
              <span>[-CE]CENTRAR[CE-]</span>
              <span>[-B]<b>NEGRITA</b>[B-]</span>
              <span>[-U]<u>SUBRAYADO</u>[U-]</span>
              <span>[-I]<i>ITÁLICA</i>[I-]</span>
              <span>[E]: EDAD</span>
            </div> 
          </div> 
          <div class="columnas">
            <div>
              <label class="requerido">Pie de página: Información del paciente</label>
               <select class="nuevos lleno" data-valor="informacion">
                  <option value="D">Inactivo</option>
                  <option value="A">Activo</option>
               </select> 
            </div>
            <div>
              <label for="insertar-fecha" class="requerido">Pie de página: fecha</label>
               <select class="nuevos lleno" data-valor="fecha">
                  <option value="D">Inactivo</option>
                  <option value="A">Activo</option>
               </select> 
            </div>
            <div style="width: 50%">
              <label for="insertar-cantidad" class="requerido">Cantidad de páginas</label>
              <input type="number" id="insertar-cantidad" placeholder="1" value="1">
            </div>
          </div>
            
        </section>
        <section id="crud-insertar-botones" data-crud='botones-avanzados'>
          <button class="botones-formularios previa">VISTA PREVIA</button>
          <button class="botones-formularios insertar">GUARDAR E IMPRIMIR</button>
          <button class="botones-formularios cerrar">CANCELAR</button> 
        </section>
      </div> 
    </div>

    <!--///////////////////////////////////////////////////////////////////////////////-->
    <!--//////////                        Editar   ////////////////////////////////////-->
    <!--///////////////////////////////////////////////////////////////////////////////-->
    <div id="crud-editar-popup" class="popup-oculto" data-crud='popup' style=" height: 100%">
      <div id="crud-editar-pop" class="popup-oculto" style="width: 100%; min-width: 600px; height:  100%; padding: 60px; overflow-x: hidden; align-items: center; justify-content: flex-start;" data-scroll>
        <button id="crud-editar-cerrar" data-crud='cerrar'>X</button>
        <section id="crud-editar-titulo" data-crud='titulo'>
          Editar informe especial
        </section>

        <section style="position: absolute; top: 5px;" class="valor-cabecera">
          <label>Código de informe:</label>
          <input type="text" data-valor="id_informe" readonly="true" class="crud-valores upper">
        </section>

        <section class="filas" style="width: 90%; height: fit-content;">
          <div class="columnas">
            <div title="[H]: Abreviatura del número de historia del paciente">
              <label for="editar-historia" class="requerido">N° de historia [H]</label>  
              <input type="text" data-valor="id_historia" readonly="true" class="datos-historia lleno upper">
            </div>
            <div title="[c]: Abreviatura del cédula del paciente">
              <label for="editar-cedula" class="requerido">Cédula [C]</label>  
              <input type="text" data-valor="nume_cedu" readonly="true" class="datos-historia lleno upper">
            </div>
            <div title="[N]: Abreviatura del nombre del paciente">
              <label for="editar-nombre" class="requerido">Nombre y apellidos o razón social [N]</label>  
              <input type="text" data-valor="apel_nomb" readonly="true" class="datos-historia lleno upper">
            </div>
          </div>
          <div class="columnas" style="margin: 0px">

            <div>
              <label>Título del informe</label>
              <input data-valor="titulo" type="text" class="crud-valores upper">
            </div>
            <div>
              <label>Título del indice</label>
              <input data-valor="titulo_indice" type="text" class="crud-valores upper center">
            </div>
          </div>

          <div style="position: relative;">
            <div id="editar-contenido">
              <label>Contenido del informe</label>
              <textarea spellcheck="true" data-valor="contenido" rows="9" class="crud-valores lleno upper informe-editar scroll" style="resize: none; max-height: 250px; min-height: 250px;box-sizing: content-box;
                padding: 5px !important;"></textarea>
            </div>
            <div id="editar-contenido-contenedor" style="display: flex; flex-direction: column; position: absolute; right: 0px; bottom: 93%;">
              <section>Personalización</section>
              <section>-----------------</section>
              <span>[   ]: ESPACIOS BLANCOS</span>
              <span>[BR]: SEPARAR LÍNEA</span>
              <span>[BR2]: ROMPER LÍNEA</span>
              <span>[-CE]CENTRAR[CE-]</span>
              <span>[-B]<b>NEGRITA</b>[B-]</span>
              <span>[-U]<u>SUBRAYADO</u>[U-]</span>
              <span>[-I]<i>ITÁLICA</i>[I-]</span>
              <span>[E]: EDAD</span>
            </div> 
          </div> 
          <div class="columnas">
            <div>
              <label for="editar-estado" class="requerido">Estado</label>
               <select class="crud-valores lleno" data-valor="status">
                  <option value="A">Activo</option>
                  <option value="D">Inactivo</option>
               </select> 
            </div>
            <div>
              <label class="requerido">Pie de página: Información del paciente</label>
               <select class="crud-valores lleno" data-valor="informacion">
                  <option value="A">Activo</option>
                  <option value="D">Inactivo</option>
               </select> 
            </div>
            <div>
              <label for="editar-fecha" class="requerido">Pie de página: fecha</label>
               <select class="crud-valores lleno" data-valor="fecha">
                  <option value="A">Activo</option>
                  <option value="D">Inactivo</option>
               </select> 
            </div>
            <div>
              <label for="editar-cantidad" class="requerido">Cantidad de páginas</label>
              <input type="number" id="editar-cantidad" placeholder="1" value="1">
            </div>
          </div>
            
          <section id="crud-editar-botones" data-crud='botones-avanzados'>
            <button class="botones-formularios previa">VISTA PREVIA</button>
            <button class="botones-formularios editar">GUARDAR E IMPRIMIR</button>
            <button class="botones-formularios cerrar">CANCELAR</button> 
          </section>
        </section>
      </div> 
    </div>

    <!--//////////////////////////////////////////////////////////////////////////////////-->
    <!--///////////////////////////- previa  ///////////////////////////////////////////-->
    <!--//////////////////////////////////////////////////////////////////////////////////-->

    <div id="crud-previa-popup" class="popup-oculto" data-crud='popup'>
      <div id="crud-previa-pop" class="popup-oculto" style="width: fit-content; height: 90%">
        <button id="crud-previa-cerrar" data-crud='cerrar'>X</button>
        <section class="vista-previa section" style="height: 100%">
          <iframe id="crud-previa-informe" src="" width="800px" style="height: inherit;"></iframe>
        </section>
        <section id="crud-previa-botones" style="width: 100%; display: flex; justify-content: end; padding: 15px 0px 0px 0px;">
            <button class="botones-formularios cerrar">CERRAR</button> 
        </section>
      </div>
    </div>

    <!--/////////////////////////////////////////////////////////////////////////////////-->
    <!--///////////////////////////////// Página  ///////////////////////////////////////-->
    <!--/////////////////////////////////////////////////////////////////////////////////-->
    <div class="container-fluid bg-3 paginas-contenedor" style="height: 100%;">
      <div id="titulo-contenedor">  
        <h3>LISTADO DE INFORMES - INSERCIÓN, ACTUALIZACIÓN E IMPRESIÓN</h3>
      </div>
      <div id="contenido-contenedor">

        <button id="desplegable-abrir-indice" class="desplegable-abrir" title="Recibos del paciente" style="left: 0px; right: unset">
          <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="caret-right" class="svg-inline--fa fa-caret-right fa-w-6 iconos" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 192 512"><path fill="currentColor" d="M0 384.662V127.338c0-17.818 21.543-26.741 34.142-14.142l128.662 128.662c7.81 7.81 7.81 20.474 0 28.284L34.142 398.804C21.543 411.404 0 402.48 0 384.662z"></path></svg>
        </button>

        <div id="desplegable-indice" class="desplegable-oculto">
          <section>
            <button id="desplegable-cerrar-indice" class='desplegable-cerrar'>
              <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="caret-left" class="svg-inline--fa fa-caret-left fa-w-6 iconos" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 192 512"><path fill="currentColor" d="M192 127.338v257.324c0 17.818-21.543 26.741-34.142 14.142L29.196 270.142c-7.81-7.81-7.81-20.474 0-28.284l128.662-128.662c12.599-12.6 34.142-3.676 34.142 14.142z"></path></svg>
            </button>
          </section>

          <section class="scroll">
            <div style="padding: 5px; min-width: 60vw; border-bottom: 1px dashed #ccc; font-size: 20px !important">Índice de informes</div>
            <?php echo $informesIndice?>
          </section>
        </div>

        <div class="panel-body">

          <section>
            <div class="datos">
              <button id="insertar-informes_especiales" style='margin-top:-30px' class="btn btn-primary pull-right btn-nuevo tooltip-filtro-reverso">
                +
              </button>
              <button id="actualizacion-masiva" class="btn-masivo" title="Aplicar cambios generales sobre los montos" data-hide data-invisible>Aplicar cambios</button>

              <div class="buscador-efecto">
                <input type="text" name="busqueda" id="busqueda" placeholder="Busqueda">
              </div> 
              <div style="position: relative;">
                <button id="modo-buscar" data-estilo="modo-buscar">
                  <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="sort" class="svg-inline--fa fa-sort fa-w-10 iconos-b" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path fill="currentColor" d="M41 288h238c21.4 0 32.1 25.9 17 41L177 448c-9.4 9.4-24.6 9.4-33.9 0L24 329c-15.1-15.1-4.4-41 17-41zm255-105L177 64c-9.4-9.4-24.6-9.4-33.9 0L24 183c-15.1 15.1-4.4 41 17 41h238c21.4 0 32.1-25.9 17-41z"></path></svg>
                </button>
     <!--            <button id="buscar">
                  <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="search" class="svg-inline--fa fa-search fa-w-16 iconos" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z"></path></svg>  
                </button> -->
              </div>

              <div id="informes_especiales-filtros" class="filtros">
                <div data-grupo="status" class="grupo">
                  <section class="filtro informes_especiales-status">
                    <input type="checkbox" data-name="status" data-familia="global" data-modo="individual" value="A">
                  </section>
                  <section class="filtro informes_especiales-status">
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

            <div id="tabla-principal" class="tabla-ppal table-min scroll" style="min-height: 250px;">
              <table id="tabla-informes_especiales" class="table table-bordered table-striped">
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