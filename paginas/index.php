<?php 
  include_once('../clases/index.class.php');
  require_once('menu_datos.php');

  $index = new Model();
  $dia = $index->fechaHora('America/Caracas','Y-m-d');

  if(isset($_REQUEST['cambio'])) {

    $cambio = $_REQUEST['cambio'];

  } else {

    $cambio = '';

  }

  //////////////////////////////////////////////////////////////////////
  //////////////////////////////////////////////////////////////////////
  foreach ($lista_menu as $r) {
  
    $index->array_establecer($lista_menu_hover, $r['ruta'], $r['bloquear']);

  };
  //////////////////////////////////////////////////////////////////////
  //////////////////////////////////////////////////////////////////////

?>
<!DOCTYPE html>
<html lang="es">
  <head>
      <?php require_once('../estructura/head.php');?>
      <title>Página de inicio</title>
      <script type="text/javascript">
        window.dia = '<?php echo "$dia"?>'
        window.cambio = '<?php echo $cambio?>'
      </script>
      <script type="module" src="../js/index.js"></script>
      <link rel="stylesheet" type="text/css" href="../css/index.css">
  </head>
  <body id="index-body">

    <?php require_once('../estructura/header.php');?>
    <div id="index-contenedor">

      <!------------------------------------------------------------------------------------------->
      <!------------------------------- DESPLEGABLE CONTACTOS ------------------------------------->
      <!------------------------------------------------------------------------------------------->
      <button id="desplegable-abrir-contactos" class="desplegable-abrir" title="Contactos" style="height: 50px">
        <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="caret-left" class="svg-inline--fa fa-caret-left fa-w-6 iconos" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 192 512"><path fill="currentColor" d="M192 127.338v257.324c0 17.818-21.543 26.741-34.142 14.142L29.196 270.142c-7.81-7.81-7.81-20.474 0-28.284l128.662-128.662c12.599-12.6 34.142-3.676 34.142 14.142z"></path></svg>
      </button>

      <div id="desplegable-contactos" class="desplegable-oculto" style="height: fit-content; background: #ffffffe6;">
        <section>
          <button id="desplegable-cerrar-contactos" class='desplegable-cerrar'>
            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="caret-right" class="svg-inline--fa fa-caret-right fa-w-6 iconos" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 192 512"><path fill="currentColor" d="M0 384.662V127.338c0-17.818 21.543-26.741 34.142-14.142l128.662 128.662c7.81 7.81 7.81 20.474 0 28.284L34.142 398.804C21.543 411.404 0 402.48 0 384.662z"></path></svg>
          </button>
        </section>

        <section class="filas">
          <div class="columnas">
            <h4 style="min-width: 260px;">Información de Contactos</h4>
          </div>
          <div class="columnas">
            <div>
              <label>Rif de la empresa:</label>
              <input type="text" name="rif" readonly value="J-16541912-6" style="border: none; border-bottom: 1px solid #b3b3b3;"> 
            </div>
          </div>

          <div class="columnas" style="align-items: baseline;">
            <div>
              <label>Tlf. Celular</label>
                <input type="text" readonly value="TELEFONO" style="border: none; border-bottom: 1px solid #b3b3b3;"> 
                <input type="text" readonly value="DE A DE" style="background: transparent !important; border: none !important">
            </div>
            <div>
              <label>MPPS / CMT</label>
                <input type="text" readonly value="" style="border: none; border-bottom: 1px solid #b3b3b3;"> 
                <input type="text" readonly value="" style="border: none; border-bottom: 1px solid #b3b3b3;">
            </div>
          </div>

          <div class="columnas">
            <div>
              <label>Correos electrónicos</label>
              <input type="text" name="rif" readonly value="correo@gmail.com" style="border: none; border-bottom: 1px solid #b3b3b3;"> 
              <input type="text" name="rif" readonly value="correo@hotmail.com" style="border: none; border-bottom: 1px solid #b3b3b3;"> 
            </div>
          </div>

          <div class="columnas">
            <div>
              <label>Redes sociales</label>
                <input type="text" readonly value="RED" title="instagram" style="border: none; border-bottom: 1px solid #b3b3b3;"> 
            </div>
            <div style="width: fit-content;margin: 0px; display: flex; flex-direction: column; justify-content: center; align-items: center">
              <img src="../imagenes/instagram.png" width="25px" height="25px">
              <img src="../imagenes/facebook.png" width="20px" height="20px">
            </div>
          </div>

        </section>
      </div>

      <!------------------------------------------------------------------------------------------->
      <!------------------------------- DESPLEGABLE EDICIONES ------------------------------------->
      <!------------------------------------------------------------------------------------------->
      <button id="desplegable-abrir-ediciones" class="desplegable-abrir" title="Edición de parámetros generales" style="top: 155px; background: #198754; height: 50px">
        <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="caret-left" class="svg-inline--fa fa-caret-left fa-w-6 iconos" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 192 512"><path fill="currentColor" d="M192 127.338v257.324c0 17.818-21.543 26.741-34.142 14.142L29.196 270.142c-7.81-7.81-7.81-20.474 0-28.284l128.662-128.662c12.599-12.6 34.142-3.676 34.142 14.142z"></path></svg>
      </button>

      <div id="desplegable-ediciones" class="desplegable-oculto" style="height: 420px; background: linear-gradient(0deg, rgb(234 255 236 / 83%) 0%, rgba(255,255,255,1) 92%, rgb(255 255 255 / 75%) 100%); width: fit-content">
        <section style="height: 100%">
          <button id="desplegable-cerrar-ediciones" class='desplegable-cerrar' style="height: 100%; background: #198754;">
            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="caret-right" class="svg-inline--fa fa-caret-right fa-w-6 iconos" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 192 512"><path fill="currentColor" d="M0 384.662V127.338c0-17.818 21.543-26.741 34.142-14.142l128.662 128.662c7.81 7.81 7.81 20.474 0 28.284L34.142 398.804C21.543 411.404 0 402.48 0 384.662z"></path></svg>
          </button>
        </section>

        <section style="display: flex; flex-direction: column; padding: 10px; min-width: 500px;" data-scroll>
          <div style="display: flex; flex-direction: column; width: 100%; justify-content: space-around; align-items: center;  border-bottom:1px solid lightgray; padding: 5px">
            <h2 style="text-align: left; width: 100%; min-width: 196px; font-size: 18px;">
              Edición rápida de parámetros generales del sistema
            </h2>
            <div style="width: 100%;">
              <button class="parametros-paginacion" id="parametros-izquierda"><</button>
              <button class="parametros-paginacion" id="parametros-derecha">></button>
            </div>
          </div>

          <div id="parametro-animacion" style="width: 100%; height: 300px">
            <section class="contenedor-parametros" style="width: 100%; height: 300px">
              <div data-parametro style="padding: 10px">

                <template id="monedas-parametros-plantilla">
                  <div class="columnas">
                    <div>
                      <label></label>
                      <input type="number" class="monedas-valores">
                    </div>
                  </div>
                </template>

                <div class="subtitulo-parametros">
                  Cambiar valor de conversión de las monedas [Dolar automático según BCV cada 5min]
                </div>

                <div class="filas" id="monedas-contenedor" style="min-height: 100%;">
                  
                </div>

                <div style="width: 100%;">
                  <button id="procesar-monedas">Procesar</button>
                  <button id="reiniciar-monedas">Reiniciar valores</button>
                </div>
                
              </div>
            </section>
      
            <section class="contenedor-parametros" style="width: 100%; height: 300px" data-hide>
              <div data-parametro data-invisible style="padding: 10px; display: flex; flex-direction: column">
                
                <div class="subtitulo-parametros">
                  Agregar o cambiar IVA [impuesto al valor agregado]
                </div>

                <div class="filas">

                  <div class="columnas">
                    <div>
                      <label>Cargar nuevo IVA:</label>
                      <input type="number" id="iva-nuevo" class="iva-nuevo" placeholder="0,00">
                    </div>
                    <div style="width: fit-content">
                      <button id="iva-confirmar-nuevo" title="Cargar nuevo IVA al sistema">
                        ✓
                      </button>
                    </div>
                  </div>

                  <div class="columnas">
                    
                    <div title="Este será el IVA preseleccionado en acciones de compra o carga de inventario">
                      <label>Seleccionar IVA por defecto</label>
                      <select class="iva-seleccionar" id="iva-seleccionar" style="height: fit-content"></select>
                    </div>

                    <div style="width: fit-content">
                      <button id="iva-confirmar-seleccionado" title="Confirmar IVA seleccionado por defecto"> ✓</button>
                    </div>

                  </div>
    
                </div>

              </div>
            </section>
          </div>
          
        </section>
      </div>

      <!------------------------------------------------------------>
      <!-------------------menus de navegacion---------------------->
      <!------------------------------------------------------------>
      <!--para moviles y tablets hay que hacer un menu más directo-->
      <div id="index-izquierda">
        <section class='menu-tree'>
          <nav id="index-navegador" data-familia>
            <ul id="index-menu" class="menu-estr menu-v">

              <?php 
                echo $index->generarMenu($lista_menu_hover);
              ?>

            </ul>
          </nav>
        </section>
      </div>

      <iframe id="index-pagina" src="inicio.php"
          title="página-actual"
          width="300"
          height="200">
      </iframe>
    </div>

    <div id="pollito" data-hide>
      <img src="" title="Pio">
    </div>

    <button id="hot-dog-stand" title="Hot Dog time - the beautiful mistake"></button>

    <button id="necesito-a-pollo" title="It's chicken time"></button>

    <?php 
      require_once('../estructura/footer.php');
    ?>
  </body> 
</html>