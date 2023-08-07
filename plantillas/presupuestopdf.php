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

  if (gettype($datos['presupuesto']) == 'string') {
    $presupuesto = json_decode($datos['presupuesto'], true);
  } else {
    $presupuesto = $datos['presupuesto'];
  }

  setlocale(LC_TIME,"es_ES");

  $fmt = new IntlDateFormatter('es_ES',
    IntlDateFormatter::LONG,
    IntlDateFormatter::NONE,
    'Europe/Berlin',
    IntlDateFormatter::GREGORIAN
  );

  $timestamp = strtotime($datos['fecha']);

  $fecha =  $fmt->format($timestamp);

  $fecha_arreglada = date("d-m-Y", strtotime($datos['fecha']));

?>

<style>

  page {
  	font-size: 12px;
  }

  page, div, table, h5, h3, h4 {
    color: #262626; /*#723200;*/
    margin:0px !important;
  }

  table {
    font-size: 12px;
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
    top: 5mm;
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
    padding-top:11px;
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
		  
		  <div style="font-size: 11px;" class="centro">
		    Dra. Gladys A. Chaparro H.
		  </div>
		  <div style="font-size: 11px;" class="centro">
		    Oftalmólogo
		  </div>

		  <div style="font-size: 11px;" class="centro">
		    M.S.D.S.: 34.989 C.M.: 1.915
		  </div>

      <div style="text-align: right; font-size: 12px; position: relative; right: 26px">
        San Cristóbal, <?php echo $fecha?>
      </div>

      <div style="width: 92%; height: 1px; background: #723200; position: relative; left: 10mm"></div>

      <div class="centro" style="font-size: 11px; position: relative; top: -8px">Av. Guayana, C.C. Villa Etapa "C", Edificio CEMOC - Consultorio 103, San Cristóbal - Edo. Táchira., (0276) 4121329, (0276) 5108011</div>

		</div>
	</page_footer> 

  <div class="contenedor">

      <div id="cabecera">

    		<div style="font-family: 'Qwigley'; font-size: 40px; ">
    			Dra. Gladys A. Chaparro H.
    		</div>

        <div style="font-size: 11px">Rlf: V-09143081-5</div>
        <div style="font-size: 11px">Oftalmólogo</div>
        <div style="font-size: 11px">Infantil y Estrabismo</div>
        <div style="font-size: 11px">M.S.D.S.: 34.989 C.M.: 1.915</div>

  		</div>

      <div></div>
      <div class="separador"></div>

  		<div style="position: absolute;  top: 15mm; left: 5mm; height: 0px;">
  			<img src="../imagenes/logo_cemoc.jpg" style="width: 45mm; height: 25mm;">
  		</div>

	    <div class="centro" style="font-size: 16px; font-weight: bold; position:relative; top: 7mm; text-decoration: underline;">PRESUPUESTO</div>

	    <div></div>
	    <div></div>

	    <table>
	      <tbody>
	        <tr>
	          <td>NOMBRES Y APELLIDOS:</td>
	          <td style="font-weight: bold; width: 100%"><?php echo strtoupper($datos['nombre_completo'])?></td>
	        </tr>
	      </tbody>
	    </table>

	    <table>
	      <tbody>
	        <tr>
	          <td>CÉDULA O PASAPORTE:</td>
	          <td style="font-weight: bold"><?php echo strtoupper($datos['cedula'])?></td>
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

  	</div>

  	<div></div>
  	<div></div>

	<?php 
    echo trim(strtoupper($presupuesto['texto_html']));
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
          $html2pdf->output("../reportes/presupuestos/presupuesto$nombre.pdf", "f");
        } else if ($pdf == 2) {
          $html2pdf->Output("../reportes/presupuestos/presupuesto$nombre.pdf");
        } else {  
          $html2pdf->Output("../reportes/presupuestos/presupuesto$nombre.pdf");
          $html2pdf->output("../reportes/presupuestos/presupuesto$nombre.pdf", "f");
        }
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
  }
?>