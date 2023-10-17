<?php 
  //---------------------------------------
  //LLAMADO DE LAS CLASES FUNCIONES DE PHP 
  //---------------------------------------
  include_once('../clases/experimentos.class.php');

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
      <title>experimentos</title>
      
      <link rel="stylesheet" href="../librerias/PhotoSwipe-master/dist/photoswipe.css" defer> 
      <link rel="stylesheet" href="../librerias/PhotoSwipe-master/dist/default-skin/default-skin.css" defer> 
      <script src="../librerias/PhotoSwipe-master/dist/photoswipe.js" defer></script> 
      <script src="../librerias/PhotoSwipe-master/dist/photoswipe-ui-default.js" defer></script>

      <script type="module" src="../js/experimentos.js" defer></script>
      <script type="module" src="../js/main.js" defer></script>

  </head>

  <body>

    <div style="display: flex;">
      
      <label>PRUEBAS DE GALERIA</label>
      <input type="file" id="galeria-cargar" multiple class="galeria-cargar valores">

      <div id="galeria-contenedor" class="galeria-contenedor"></div>

      <button id="galeria-enviar">ENVIAR</button>

    </div>

    <div style="display: flex;">
      
      <label>PRUEBAS DE GALERIA 2</label>
      <input type="file" id="galeria-cargar2" multiple class="galeria-cargar valores">

      <div id="galeria-contenedor2" class="galeria-contenedor"></div>

      <button id="galeria-enviar2">ENVIAR</button>

    </div>
   
    <div>
      
      <div style="display: flex; flex-direction: column;">
        
        <label>prueba de textarea con texto customizable</label>
        <textarea id="textarea" class="textarea-personalizable" style="width: 30%;" rows="5"></textarea> <!--textarea-personalizable: funciones limpiar y procesar-->
        
      </div>
        
      </textarea>

      <div id="textarea-previa" style="
        width: 30%;
        height: 30%;
        border: 1px solid #262626;
        margin: 10px;
        padding: 5px;
      "></div>

    </div>

    <div>
      
      <div style="display: flex; flex-direction: column;">
        
        <label>prueba de textarea con texto customizable</label>
        <textarea id="textarea2" class="textarea-personalizable" style="width: 30%;" rows="5"></textarea> <!--textarea-personalizable: funciones limpiar y procesar-->
        
      </div>
        
      </textarea>

      <div id="textarea-previa2" style="
        width: 30%;
        height: 30%;
        border: 1px solid #262626;
        margin: 10px;
        padding: 5px;
      "></div>

    </div> 
    
    <!---------------------------------------------------------------------------------------->
    <!------------------------------ CONTENEDOR DE GALERIA ----------------------------------->
    <!---------------------------------------------------------------------------------------->
    <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true"> <!--contenedor de la galeria-->
        <div class="pswp__bg"></div>
        <div class="pswp__scroll-wrap">
            <div class="pswp__container">
                <div class="pswp__item"></div>
                <div class="pswp__item"></div>
                <div class="pswp__item"></div>
            </div>
            <div class="pswp__ui pswp__ui--hidden">
                <div class="pswp__top-bar">
                    <div class="pswp__counter"></div>
                    <button class="pswp__button pswp__button--close" title="Cerrar (Esc)"></button>
                    <button class="pswp__button pswp__button--share" title="Compartir"></button>
                    <button class="pswp__button pswp__button--fs" title="Pantalla completa"></button>
                    <button class="pswp__button pswp__button--zoom" title="Zoom +/-"></button>
                    <div class="pswp__preloader">
                        <div class="pswp__preloader__icn">
                          <div class="pswp__preloader__cut">
                            <div class="pswp__preloader__donut"></div>
                          </div>
                        </div>
                    </div>
                </div>
                <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                    <div class="pswp__share-tooltip"></div> 
                </div>
                <button class="pswp__button pswp__button--arrow--left" title="Imagen previa (izquierda)">
                </button>
                <button class="pswp__button pswp__button--arrow--right" title="Imagen siguiente (derecha)">
                </button>
                <div class="pswp__caption">
                    <div class="pswp__caption__center"></div>
                </div>
            </div>
        </div>
    </div>
    <!---------------------------------------------------------------------------------------->
    <!---------------------------------------------------------------------------------------->

    <div class="pswp2 pswp" tabindex="-1" role="dialog" aria-hidden="true"> <!--contenedor de la galeria-->
        <div class="pswp__bg"></div>
        <div class="pswp__scroll-wrap">
            <div class="pswp__container">
                <div class="pswp__item"></div>
                <div class="pswp__item"></div>
                <div class="pswp__item"></div>
            </div>
            <div class="pswp__ui pswp__ui--hidden">
                <div class="pswp__top-bar">
                    <div class="pswp__counter"></div>
                    <button class="pswp__button pswp__button--close" title="Cerrar (Esc)"></button>
                    <button class="pswp__button pswp__button--share" title="Compartir"></button>
                    <button class="pswp__button pswp__button--fs" title="Pantalla completa"></button>
                    <button class="pswp__button pswp__button--zoom" title="Zoom +/-"></button>
                    <div class="pswp__preloader">
                        <div class="pswp__preloader__icn">
                          <div class="pswp__preloader__cut">
                            <div class="pswp__preloader__donut"></div>
                          </div>
                        </div>
                    </div>
                </div>
                <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                    <div class="pswp__share-tooltip"></div> 
                </div>
                <button class="pswp__button pswp__button--arrow--left" title="Imagen previa (izquierda)">
                </button>
                <button class="pswp__button pswp__button--arrow--right" title="Imagen siguiente (derecha)">
                </button>
                <div class="pswp__caption">
                    <div class="pswp__caption__center"></div>
                </div>
            </div>
        </div>
    </div>
    <!---------------------------------------------------------------------------------------->
    <!----------------------------------------------------------------------------------------> 

  </body>

</html>