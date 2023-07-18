<?php 
  include_once('../clases/inicio.class.php');
  $obj = new Model();

  $version = $obj->version();

  $_SESSION['refrescar'] = '..'.$_SERVER['REQUEST_URI'];

  if ($obj->fechaHora('America/Caracas','d-m') == '06-06') { // 06-06

    $cumple = 'data-cumple';
    $fondo  = 'transparent';

    $sumado = $obj->i_pdo('select sumado from miscelaneos.edad_sistema where id_edad = 1', [], true)->fetchColumn();


    if (!$sumado) {

      $obj->actualizar("update miscelaneos.edad_sistema set edad = edad + 1, sumado = TRUE where id_edad = 1", []);

      $edad = $obj->i_pdo('select edad from miscelaneos.edad_sistema where id_edad = 1', [], true)->fetchColumn();

    } else {

      $edad = $obj->i_pdo('select edad from miscelaneos.edad_sistema where id_edad = 1', [], true)->fetchColumn();

    }

  } else {

    $cumple = '';
    $fondo  = '#f1f1f1';

    $obj->actualizar("update miscelaneos.edad_sistema set sumado = FALSE where id_edad = 1", []);

  }
?>
<!DOCTYPE html>
<html lang="es" <?php echo $cumple?>>
  <head>
      <?php require_once('../estructura/head.php');?>
      <title>PÁGINA DE INICIO</title>
      <script type="module" src="../js/inicio.js" defer></script>
      <script type="module" src="../js/main.js" defer></script>
      <style type="text/css">
        #version {
          z-index: 1;
          position: fixed;
          background: #fff;
          padding: 10px;
          right: 0px;
          color: #6a6a6a;
          border-bottom-left-radius: 10px;
          user-select: none;
          -webkit-user-select: none;
          -moz-user-select: none;
          -khtml-user-select: none;
          -ms-user-select: none;
          box-shadow: 0px 0px 5px -1px #2196f3;
        }

        [data-noche] #index-conversiones span {
          color: #262626;
        }

        h3 {
          color: #262626 !important;
        }

        #inicio-titulo {
          height: 40px;
          display: flex;
          justify-content: left;
          align-items: center;
          font-variant-caps: small-caps;
          font-size: 35px !important;
          color: #393942;
          user-select: none;
          -webkit-user-select: none;
          -moz-user-select: none;
          -khtml-user-select: none;
          -ms-user-select: none;
        }

        #inicio-bienvenida, #inicio-novedades {
          margin: 20px 0px;
          border-radius: 5px;
          background: #fff;
          display: flex;
          flex-direction: column;
          user-select: none;
          -webkit-user-select: none;
          -moz-user-select: none;
          -khtml-user-select: none;
          -ms-user-select: none;
        }

        #inicio-bienvenida-titulo {
          padding: 20px;
          text-align: left;
          user-select: none;
          -webkit-user-select: none;
          -moz-user-select: none;
          -khtml-user-select: none;
          -ms-user-select: none;
        }

        #inicio-bienvenida-fecha {
          color: #747474;
          font-size: 17px !important;
          user-select: none;
          -webkit-user-select: none;
          -moz-user-select: none;
          -khtml-user-select: none;
          -ms-user-select: none;
        }

        #inicio-bienvenida-guia {
          padding: 20px;
          text-align: left;
          display: flex;
          justify-content: flex-start;
          column-gap: 100px;
          align-items: baseline;
          min-height: 181px;
        }

        #inicio-guia {
          padding: 25px;
          margin: 30px 0px 0px 0px;
          background: #3e68ff;
          color: #fff;
          border: none;
          border-radius: 5px;
        }

        #inicio-guia:hover {
          background: black;
        }

        #inicio-guia:after {
          height: 40px;
          top: 12px;
          left: 100%;
        }

        #inicio-guia:hover::after {
          content: "Recomendaciones sobre el uso del sistema";
        }

        #index-conversiones {
          display: grid;
          grid-template-rows: 1fr 1fr 1fr 1fr;
          grid-gap: 10px;
          width: 185px;
          padding-top: 25px;
          padding-left: 30px;
        }

        .inicio-columna {
          display: flex;
          flex-direction: column;
          height: 100%;
        }

        /*---------------------------------------*/
        #inicio-novedades {
          text-align: left;
        }

        #index-mostrar-parche ul {
          font-weight: 100;
          text-align: left;
          padding-inline-start: 25px !important;
        }

        .parches-notas {
          width: 100%;
          min-height: 100px;
          justify-content: center;
          display: flex;
          flex-direction: column;
          height: fit-content;
          border-radius: 5px;
          margin: 10px 0px !important;
          border: 1px dashed #2196f3;
          transition: 0.3s ease all;
          padding: 20px;
          color: #262626;
          background: #fff;
        }

        .parches-notas ul {
            position: relative;
            background: #243447;
            padding-top: 10px;
            padding-bottom: 10px;
            color: #fff;
            border-radius: 5px;
            box-shadow: 2px 2px 5px 1px #a1a1a1;
        }

        .parches-notas ul li {
            list-style-type: square;
            font-size: 15px;
            font-weight: 100;
        }

        .parches-notas div {
            margin: 10px !important;
            text-align: left;
        }

        .parches-notas:hover {
            transition: 0.3s ease all;
            border: 1px dashed #222222;
        }
      </style>
  </head>
  <body data-resaltar class="scroll-form" style="overflow-x: hidden;">

    <!--//////////////////////////////////////////////////////////////////////////////////-->
    <!--///////////////////////////- guia  ///////////////////////////////////////////-->
    <!--//////////////////////////////////////////////////////////////////////////////////-->

    <div id="version">
      VERSIÓN: &nbsp;<?php echo $version;?>
    </div>

    <div id="spinner" style="position: absolute; width: 100%; height: 100%; display: flex; justify-content: center; align-items: center">
      <img src="../imagenes/inicio/spinner.gif" style="width: 50px; height: 50px;">
    </div>

    <!--//////////////////////////////////////////////////////////////////////-->
    <!--//////////////////////////////////////// Página  /////////////////////-->
    <!--//////////////////////////////////////////////////////////////////////-->

    <div class="container-fluid bg-3 paginas-contenedor" data-hidden data-efecto="desaparecer">
      <!--agregar animacion aqui para mostrar esto invisible y dar chance de ver el logo de fondo-->
      <div id="contenido-contenedor">

        <style>.panel-body {display: flex;}</style>

        <div class="panel-body" style="background:<?php echo $fondo?>; padding: 50px;  padding-top: 20px;">
          <section style="grid-template-rows: min-content min-content min-content">

            <div id="inicio-titulo" style="position: relative;">
              Panel principal - dashboard
              <button id="webb" title="Gracias NASA, ESA, CSA, and STScI" style="background: transparent;border: none;position: relative;top: 6px;left: 2px;">
                <svg class="iconos-c" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="width: 18px;"><path fill="currentColor" d="M502.8 264.1l-80.37-80.37l47.87-47.88c13-13.12 13-34.37 0-47.5l-47.5-47.5c-13.12-13.12-34.38-13.12-47.5 0l-47.88 47.88L247.1 9.25C241 3.375 232.9 0 224.5 0c-8.5 0-16.62 3.375-22.5 9.25l-96.75 96.75c-12.38 12.5-12.38 32.62 0 45.12L185.5 231.5L175.8 241.4c-54-24.5-116.3-22.5-168.5 5.375c-8.498 4.625-9.623 16.38-2.873 23.25l107.6 107.5l-17.88 17.75c-2.625-.75-5-1.625-7.75-1.625c-17.75 0-32 14.38-32 32c0 17.75 14.25 32 32 32c17.62 0 32-14.25 32-32c0-2.75-.875-5.125-1.625-7.75l17.75-17.88l107.6 107.6c6.75 6.75 18.62 5.625 23.12-2.875c27.88-52.25 29.88-114.5 5.375-168.5l10-9.873l80.25 80.36c12.5 12.38 32.62 12.38 44.1 0l96.75-96.75C508.6 304.1 512 295.1 512 287.5C512 279.1 508.6 270.1 502.8 264.1zM219.5 197.4L150.6 128.5l73.87-73.75l68.86 68.88L219.5 197.4zM383.5 361.4L314.6 292.5l73.75-73.88l68.88 68.87L383.5 361.4z"></path></svg>
              </button>
            </div>

            <div id="inicio-bienvenida">
                
                <section id="inicio-bienvenida-titulo">

                  <?php if (isset($edad)) {?>

                    <div id="cumple-celebracion">Hoy el sistema cumple <?php echo $edad?> años de edad</div>

                  <?php } ?>

                  <div style="font-size: 18px !important; width: fit-content; color: #484a49; min-width: 400px">
                    Bienvenido/a al sistema <b style="text-decoration: underline;">Dra. Gladys Chaparro, Oftalmología</b>
                  </div>
                  <div id="inicio-bienvenida-fecha">
                    
                  </div>
                </section>

                <section id="inicio-bienvenida-guia">

                  <div class="inicio-columna">
                    <div style="font-size: 18px !important; color: #484a49;">
                      Conversiones del día
                    </div>

                    <div id="index-conversiones">
                      
                    </div>
                  </div>

                </section>

            </div>

          </section>
        </div>

      </div>
    </div>  
    <?php echo $dispararModos;?>
  </body>
</html>