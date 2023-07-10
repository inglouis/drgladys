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
      <title>antecedentes</title>
      <script type="module" src="../js/experimentos.js" defer></script>
      <script type="module" src="../js/main.js" defer></script>
  </head>

  <body>
   
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
    

  </body>

  </html>