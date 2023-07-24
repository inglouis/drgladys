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

  if (gettype($datos['antecedente']) == 'string') {
    $antecedente = json_decode($datos['antecedente'], true);
  } else {
    $antecedente = $datos['antecedente'];
  }

  $edad = $obj->calcularEdad($datos['fecha_nacimiento']);

  $fecha_arreglada = date("d-m-Y", strtotime($datos['fecha']));

?>

<style>

  page {
  	font-size: 12px;
  }

  page, div, table, h5, h3, h4 {
    color: #723200;
    margin:0px !important;
  }

  table {
    font-size: 13px;
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

    <div id="cabecera">

  		<div style="top:-21mm; left: 0mm; height: 0px; position: relative;">
  			<img src="../imagenes/reportes_historia_cabecera.jpg" style="width: 80mm; height: 20mm;">
  		</div>

  		<div style="font-family: 'Qwigley'; font-size: 30px; ">
  			Al servicio de tu piel
  		</div>

		</div> 

		<div style="position: absolute;  top: 15mm; left: 5mm; height: 0px;">
			<img src="../imagenes/logo_reportes.jpg" style="width: 28mm; height: 28mm;">
		</div>

		<div style="position: absolute;  top: 2mm; right: 0mm; height: 0px;">
			<img src="../imagenes/decoracion_historia.jpg" style="width: 170mm; height: 13mm;">
		</div>

	    <div class="centro" style="font-size: 16px; font-weight: bold; position:relative; top: 7mm">HISTORIA MÉDICA</div>

	    <div></div>
	    <div></div>

	    <table>
	      <tbody>
	        <tr>
	          <td>NOMBRES Y APELLIDOS:</td>
	          <td style="font-weight: bold; width: 100%"><?php echo strtoupper($datos['nombres'].''.$datos['apellidos'])?></td>
	        </tr>
	      </tbody>
	    </table>

	    <table>
	      <tbody>
	        <tr>
	          <td>EDAD:</td>
	          <td style="font-weight: bold"><?php echo $edad?></td>
	          <td>CÉDULA O PASAPORTE:</td>
	          <td style="font-weight: bold"><?php echo strtoupper($datos['cedula'])?></td>
	        </tr>
	      </tbody>
	    </table>

	    <table>
	      <tbody>
	        <tr>
	          <td>DIRECCIÓN:</td>
	          <td style="font-weight: bold"><?php echo strtoupper($datos['direccion'])?></td>
	        </tr>
	      </tbody>
	    </table>

	    <table>
	      <tbody>
	        <tr>
	          <td>FECHA:</td>
	          <td style="font-weight: bold"><?php echo $fecha_arreglada?></td>
	          <td>HORA:</td>
	          <td style="font-weight: bold"><?php echo $datos['hora']?></td>
	        </tr>
	      </tbody>
	    </table>
	    
	    <!--<p style="text-align: justify; margin: 0px; padding: 0px; height: auto">-->
	    <!--</p>-->

  	</div>

  	<div></div>
  	<div></div>

	<?php 
    echo trim(strtoupper($antecedente['texto_html']));
  ?>

  <div style="width: 100%"></div>

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