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
  if (gettype($datos['motivo']) == 'string') {
    $motivo = json_decode($datos['motivo'], true);
  } else {
    $motivo = $datos['motivo'];
  }

  $timestamp = strtotime($datos['fecha']);

  $fecha_inicio = date("d-m-Y", strtotime($datos['fecha_inicio']));
  $fecha_final = date("d-m-Y", strtotime($datos['fecha_final']));
  $fecha_simple = date("d-m-Y", strtotime($datos['fecha_simple']));

?>

<style>

  page {
  page {
  	font-size: 13px;
  }

  page, div, table, h5, h3, h4 {
    color: #723200;
    margin:0px !important;
  }

  table {
    font-size: 14px;
    left: 7mm;
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
    width: 100%;
    display: flex;
    flex-direction: column;
    font-size: 16px;
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
</style>

<!------------------------------------------------------------------------------------------------->

<page style="text-align:justify;" backtop="10mm" backbottom="25mm" backleft="10mm" backright="10mm">

	<page_footer>
		<div style="position:absolute; bottom: 5mm">
		  
		  <div style="width: 90%; height: 1px; background: #723200; position: relative; left: 10mm"></div>

		  <div style="font-size: 15px;" class="centro">
		    <?php echo $_SESSION['informacion_pie_pagina_reportes_1']?>
		  </div>
		  <div style="font-size: 15px;" class="centro">
		    <?php echo $_SESSION['informacion_pie_pagina_reportes_2']?>
		  </div>

		  <div style="font-size: 15px;" class="centro">
		    <?php echo $_SESSION['informacion_pie_pagina_reportes_3']?>
		  </div>

		  <div style="position: absolute; bottom: -0.5mm; left: 36%; height: 0px;">
		   <img src="../imagenes/facebook.jpg" style="width: 4.5mm; height: 4.5mm;">
		  </div>

		  <div style="position: absolute; bottom: -0.5mm; left: 39%; height: 0px;">
		   <img src="../imagenes/instagram.jpg" style="width: 4.5mm; height: 4.5mm;">
		  </div>

		</div>
	</page_footer> 

    <div class="contenedor">

    	<div id="cabecera" style="width: 100%; top: 5mm">

        <div style="text-align: center; width: 100%; font-weight: bold;">DRA. ROSANA SÁNCHEZ PERNÍA</div>
        <div style="text-align: center; width: 100%; font-weight: bold;">DERMATOLÓGICA CLÍNICA Y VENEROLOGÍA</div>
        <div style="text-align: center; width: 100%; font-weight: bold;">NIÑOS, ADOLESCENTES Y ADULTOS</div>

      </div> 

      <div style="position: absolute;  top: 5mm; left: 5mm; height: 0px;">
       <img src="../imagenes/logo_reportes.jpg" style="width: 25mm; height: 25mm;">
      </div>

      <!-- <div style="font-size: 11px; font-weight: bold; position: absolute; right: 4.5mm; top: 15mm">
        FECHA DE EMISIÓN
      </div>

      <table id="tabla-fecha" style="position: absolute; right: 30mm; top: 18mm">
        <thead style="border: 1px solid #723200;">
          <tr style="border: 1px solid #723200;">
            <th style="border: 1px solid #723200; border-top-left-radius: 10px; background: #723200; color: #fff">DD</th>
            <th style="border: 1px solid #723200; background: #723200; color: #fff">MM</th>
            <th style="border: 1px solid #723200; border-top-right-radius: 10px; background: #723200; color: #fff">AAAA</th>
          </tr>
        </thead>
        <tbody style="border: 1px solid #723200;">
          <tr style="border: 1px solid #723200;">
            <td style="border: 1px solid #723200; text-align: center"><?php echo date("d", $timestamp);?></td>
            <td style="border: 1px solid #723200; text-align: center"><?php echo date("m", $timestamp);?></td>
            <td style="border: 1px solid #723200; text-align: center"><?php echo date("Y", $timestamp);?></td>
          </tr>
        </tbody>
      </table> -->

      <div></div>
      <div></div>

	    <div class="centro" style="font-size: 20px; font-weight: bold; position:relative; top: 10mm">REPOSO MÉDICO</div>

	    <div></div>
	    <div></div>

	    <table style="border:none">
      <tbody>
        <tr>
          <td style="width: 80mm; text-align: left">SE INDICA REPOSO DESDE EL:&nbsp;&nbsp;<b><?php echo $fecha_inicio?></b></td>
          <td style="width: 40mm; text-align: left">HASTA EL:&nbsp;&nbsp;<b><?php echo $fecha_final?></b></td>
        </tr> 
      </tbody>    
    </table>

    <table style="border:none">
      <tbody>
        <tr>
          <td>(  *  *  <?php echo $datos['dias']?> DÍAS *  *  )</td>
        </tr> 
      </tbody>    
    </table>

    <table style="border:none">
      <tbody>
        <tr>
          <td>POR CAUSA DE: <b>
            <?php 
              echo trim(strtoupper($motivo['texto_html']));
            ?>
          </b></td>
        </tr> 
      </tbody>    
    </table>

    <table style="border:none">
      <tbody>
        <tr>
          <td style="width: fit-content; text-align: left">NOMBRE DEL PACIENTE:&nbsp;&nbsp;<?php echo $datos['nombres'].' '.$datos['apellidos']?></td>
          <td style="width: 70mm; text-align: left">&nbsp;&nbsp;&nbsp;&nbsp;C.I:&nbsp;&nbsp;<?php echo $datos['cedula']?></td>
        </tr> 
      </tbody>    
    </table>

  	</div>

  	<div></div>
  	<div></div>

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