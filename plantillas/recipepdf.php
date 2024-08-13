<?php
  /*MODOS PDF:
    0: traer solo estructura HTML //ESTE SE DESCARTARÁ PARA OTROS REPORTES
    1: solo guardar REPORTE,
    2: traer reporte SIN GUARDAR,
    3: traer reporte Y GUARDAR, 
  */

  ob_start();
  include_once('../clases/historias.class.php');
  $obj = new Model();

  $datos = json_decode($_SESSION['datos_pdf'], true);

  $dia  = $obj->fechaHora('America/Caracas','d-m-Y');
  $hora  = $obj->fechaHora('America/Caracas','H-i-s');

  if (!isset($datos['fecha'])) {
    $datos['fecha'] = $dia;
  }

  if (!isset($datos['hora'])) {
    $datos['hora'] = $hora;
  }

  if (isset($_REQUEST['pdf'])) {
    $pdf = (int)$_REQUEST['pdf'];
  } else {
    $pdf = 1;
  }

  // echo "<pre>";
  // print_r($datos);
  // echo "</pre>";

  if (gettype($datos['recipe']) == 'string') {
    $recipe = json_decode($datos['recipe'], true);
    $indicacion = json_decode($datos['indicacion'], true);
  } else {
    $recipe = $datos['recipe'];
    $indicacion = $datos['indicacion'];
  }
  
  $timestamp = strtotime($datos['fecha']);

  $fecha_arreglada = date("d-m-Y", strtotime($datos['fecha']));

?>

<style>

  div, table {
    color: #723200;
  }

  table {
    font-size: 14px;
    left: 5mm;
    position: relative;
  }

  table tbody {

  }

  #separador {
    margin-top: 0px
  }

  #fecha {
    top: 55px;
    font-weight: 100; 
    color: #5f5f5f;
  }

  #hora {
    top:90px; 
    font-weight: 100; 
    color:#5f5f5f;
  }

  h5, h3, h4 {
    padding:0px; 
    margin: 0px;
    text-align: center;
  }

 .contenedor {
    width: 92%;
    display: flex;
    flex-direction: column;
    font-size: 18px;
    height: 100%
  }

  #subcabecera {
    font-size: 12px;
    width: 100%;
    text-align: center;
  }

  .separador {
    width: 200mm;
    height: 2px;
    border-top: 2px dashed #909090;
    border-bottom: 2px dashed #909090;
    margin: 2px 2px;
  }

  #cabecera {
    top: 25mm;
    position: relative;
    width: 100%; 
    color: #723200;
  }

  #cabecera h5, #cabecera h4, #cabecera div {
    text-align: center;
    font-size: 16px;
  }

  .centro {
    text-align: center;
    font-size: 14px;
    width: 100%;
  }

  .derecha {
    text-align: right !important;
  }

  .small {
    font-size: 9.5px;
    padding-top: 1px;
    width: fit-content;
  }

  .subtitulo {
    font-size: 12px;
    font-weight: bold;
    margin-left: 50px;
    padding-top:10px;
  }

  .fecha {
    position: absolute; 
    bottom: 5px; 
    right: 30px; 
    font-size: 15px;
  }

  #tabla-fecha {
    border: 1px solid #723200;
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
  }

  #tabla-fecha td, #tabla-fecha th {
    padding: 5px;
    text-align:center;
    border: 1px solid #723200;
  }
</style>

<page style="width:138%" backtop="0mm" backbottom="5mm" backleft="2mm" backright="2mm">
  
  <div class="contenedor" style="rotate:90; top: 120px; left: 0px">

     <div style="
      position: relative; 
      width: 47%; 
      text-align: justify; 
      font-size: 12px;
      top: 7mm;
      left: -1.5mm;
     ">
      
      <div style="text-align: center; width: 100%; font-weight: bold;left: 4mm; position:relative">DRA. ROSANA SÁNCHEZ PERNÍA</div>
      <div style="text-align: center; width: 100%; font-weight: bold;left: 4mm; position:relative">DERMATÓLOGA</div>

      <div style="text-align: center; width: 100%; font-weight: bold;left: 4mm; position:relative">
        MPPS: 98438 - CMT: 5320
      </div>

      <div style="text-align: center; width: 100%; font-weight: bold;left: 4mm; position:relative">
        TLFs: <?php echo $_SESSION['informacion_pie_pagina_reportes_2']?>
      </div>

      <div style="position: absolute;  top: -2mm; left: 4mm; height: 0px;">
       <img src="../imagenes/cara1.jpg" style="width: 32mm; height: 25mm;">
      </div>

      <div style="position: absolute;  top: -2mm; right: -1mm; height: 0px;">
       <img src="../imagenes/logo_reportes.jpg" style="width: 25mm; height: 25mm;">
      </div>

    </div>

    <div style="
      position: absolute; 
      width: 45%; 
      text-align: justify; 
      font-size: 12px;
      left: 140mm;
      top: 7mm;
    ">
      
      <div style="text-align: center; width: 100%; font-weight: bold;left: 3mm; position:relative">DRA. ROSANA SÁNCHEZ PERNÍA</div>
      <div style="text-align: center; width: 100%; font-weight: bold;left: 3mm; position:relative">DERMATÓLOGA</div>

      <div style="text-align: center; width: 100%; font-weight: bold;left: 3mm; position:relative">
        MPPS: 98438 - CMT: 5320
      </div>

      <div style="text-align: center; width: 100%; font-weight: bold;left: 3mm; position:relative">
        TLFs: <?php echo $_SESSION['informacion_pie_pagina_reportes_2']?>
      </div>

      <div style="position: absolute;  top: -2mm; left: 0mm; height: 0px;">
       <img src="../imagenes/cara1.jpg" style="width: 32mm; height: 25mm;">
      </div>

      <div style="position: absolute;  top: -2mm; right: 0mm; height: 0px;">
       <img src="../imagenes/logo_reportes.jpg" style="width: 25mm; height: 25mm;">
      </div>

    </div> 

    <div></div>
    <div></div>

    <div style="
      left: 3.5mm; 
      position: relative; 
      width: 47%; 
      text-align: justify; 
      font-size: 12px;
      height: 135mm;
      border: 1px dashed #ff5500;
      border-radius: 10px;
      padding: 10px;
      top: 5.5mm;
    ">
      <b style="padding:5px">RÉCIPE:&nbsp;&nbsp;&nbsp;</b>
      <br>
      <br>
      <?php 
        echo trim($recipe['texto_html']);
      ?>
    </div>

    <br>

    <div style="
      left: 5mm; 
      position: absolute; 
      width: 45%; 
      text-align: justify; 
      font-size: 12px;
      height: 135mm;
      border: 1px dashed #ff5500;
      border-radius: 10px;
      padding: 10px;
      top: 36.5mm;
      left: 140mm;
    ">
      <b style="padding:5px">INDICACIÓN:&nbsp;&nbsp;&nbsp;</b>
      <br>
      <br>
      <?php 
        echo trim($indicacion['texto_html']);
      ?>
    </div>

    <div style="
      position: relative; 
      width: 47%; 
      text-align: justify; 
      font-size: 12px;
      top: 0mm;
      left: 3.5mm;
    ">
      <div style=" left: 5mm;  position: relative;  width: 94%;  text-align: left;  font-size: 12px; padding-top: 3px;">
        <b>NOMBRES Y APELLIDOS:&nbsp;&nbsp;</b><?php echo strtoupper($datos['nombres'].' '.$datos['apellidos']);?>
      </div>

      <div style="left: 5mm; position: relative; width: 94%; text-align: left; font-size: 12px;">
        <b>FECHA:&nbsp;&nbsp;</b><?php echo date("d", $timestamp).' / '.date("m", $timestamp).' / '.date("Y", $timestamp);?>
      </div>
    </div>

    <div style="
      position: absolute; 
      width: 45%; 
      text-align: justify; 
      font-size: 12px;
      left: 140mm;
      top: 182mm;
    ">
      <div style=" left: 5mm;  position: relative;  width: 94%;  text-align: left;  font-size: 12px; padding-top: 3px;">
        <b>NOMBRES Y APELLIDOS:&nbsp;&nbsp;</b><?php echo strtoupper($datos['nombres'].' '.$datos['apellidos']);?>
      </div>

      <div style="left: 5mm; position: relative; width: 94%; text-align: left; font-size: 12px;">
        <b>FECHA:&nbsp;&nbsp;</b><?php echo date("d", $timestamp).' / '.date("m", $timestamp).' / '.date("Y", $timestamp);?>
      </div>
    </div>

    <br>

    <div
    style="
      position: relative; 
      width: 47%; 
      text-align: justify; 
      font-size: 12px;
      top: -2.5mm;
      left: 3.5mm;
    ">
      
      <div style="width: 97%; height: 0px; border-bottom: 1px solid #723200; padding-bottom: 5px"></div>

      <div style="font-size: 10px;" class="centro">
        ENFERMEDAD DE LA PIEL, MUCOSAS, PELO Y UÑAS, EN NIÑOS, ADOLESCENTES Y ADULTOS
      </div>

      <div style="font-size: 10px;" class="centro">
        <?php echo $_SESSION['informacion_pie_pagina_reportes_1']?>
      </div>

      <div style="font-size: 11px;" class="centro">
        <?php echo $_SESSION['informacion_pie_pagina_reportes_3']?>
      </div>
      
      <div style="position: absolute; top: 10.4mm; left: 36%; height: 0px;">
       <img src="../imagenes/facebook.jpg" style="width: 4mm; height: 4mm;">
      </div>

      <div style="position: absolute; top: 10.4mm; left: 32%; height: 0px;">
       <img src="../imagenes/instagram.jpg" style="width: 4mm; height: 4mm;">
      </div>

    </div>

    <div style="
      position: absolute; 
      width: 45%; 
      text-align: justify; 
      font-size: 12px;
      left: 140mm;
      top: 193.5mm;
    ">
      
      <div style="width: 97%; height: 0px; border-bottom: 1px solid #723200; padding-bottom: 5px"></div>

      <div style="font-size: 10px;" class="centro">
        ENFERMEDAD DE LA PIEL, MUCOSAS, PELO Y UÑAS, EN NIÑOS, ADOLESCENTES Y ADULTOS
      </div>

      <div style="font-size: 10px;" class="centro">
        <?php echo $_SESSION['informacion_pie_pagina_reportes_1']?>
      </div>

      <div style="font-size: 10px;" class="centro">
        <?php echo $_SESSION['informacion_pie_pagina_reportes_3']?>
      </div>
      
      <div style="position: absolute; top: 10.4mm; left: 36%; height: 0px;">
       <img src="../imagenes/facebook.jpg" style="width: 4mm; height: 4mm;">
      </div>

      <div style="position: absolute; top: 10.4mm; left: 32%; height: 0px;">
       <img src="../imagenes/instagram.jpg" style="width: 4mm; height: 4mm;">
      </div>

    </div>

  </div>  
</page>
<?php

  require_once(dirname(__FILE__).'/../vendor/autoload.php');
  require_once('../vendor/autoload.php');
  use Spipu\Html2Pdf\Html2Pdf;

  if($pdf !== 0) {
    $content = ob_get_clean();

    try
    {    
        $width_in_mm = 216;
        $height_in_mm = 280;
        $html2pdf = new HTML2PDF('P', array($width_in_mm,$height_in_mm), 'en', true, 'UTF-8', array(0, 0, 0, 0));
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));

        
        $obj->fechaHora('America/Caracas','d-m-Y');
        
        $nombre = /*$datos->id_historia.*/'-'.$dia.'-'.$hora;

        if ($pdf == 1) {
          $html2pdf->output("../reportes/antecedentes/antecedente$nombre.pdf", "f");
        } else if ($pdf == 2) {
          $html2pdf->Output("../reportes/antecedentes/antecedente$nombre.pdf");
        } else {  
          $html2pdf->Output("../reportes/antecedentes/antecedente$nombre.pdf");
          $html2pdf->output("../reportes/antecedentes/antecedente$nombre.pdf", "f");
        }
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
  }
?>