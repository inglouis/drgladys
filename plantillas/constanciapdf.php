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

  if (gettype($datos['recomendaciones']) == 'string') {
    $recomendaciones = json_decode($datos['recomendaciones'], true);
  } else {
    $recomendaciones = $datos['recomendaciones'];
  }

  if (!empty($datos['menor'])) {

    $representante = $obj->i_pdo("select emergencia_informacion, emergencia_persona from principales.historias where id_historia = ?", [(int)$datos['id_historia']], true)->fetch(PDO::FETCH_ASSOC);

    if (empty($representante['emergencia_persona'])) {
      $representante['emergencia_persona'] = '[SIN REPRESENTANTE ASIGNADO]';
    }

    if (empty($representante['emergencia_informacion'])) {
      $representante['emergencia_informacion'] = '[SIN REPRESENTANTE ASIGNADO]';
    }

    $menor = "ESTO EN COMPAÑIA DE SU REPRESENTANTE $representante[emergencia_persona] con C.I $representante[emergencia_informacion]";

  } else {
    $menor = '';
  }

  if (!empty($datos['menor'])) {

    $datos['nombres'] = strtoupper($datos['nombres']);
    $datos['apellidos'] = strtoupper($datos['apellidos']);

    $aula = "SE AGRADECE COLABORACIÓN A LOS DOCENTES DE SENTAR AL PACIENTE $datos[nombres] $datos[apellidos] EN LOS PRIMEROS PUESTOS DEL SALÓN POR SU CONDICIÓN VISUAL.";
  } else {
    $aula = "";
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

  $edad = $obj->calcularEdad($datos['fecha_nacimiento']);

  $fecha_arreglada = date("d-m-Y", strtotime($datos['fecha']));

  $edad = $obj->calcularEdad($datos['fecha_nacimiento']);

?>

<style>

  page {
  	font-size: 15px;
    font-family: arial;
  }

  page, div, table, h5, h3, h4 {
    color: #262626; /*#723200;*/
    margin:0px !important;
  }

  table {
    font-size: 15px;
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
		  
		  <div style="font-size: 14px;" class="centro">
		    Dra. Gladys A. Chaparro H.
		  </div>
		  <div style="font-size: 14px;" class="centro">
		    Oftalmólogo
		  </div>

		  <div style="font-size: 14px;" class="centro">
		    M.S.D.S.: 34.989 C.M.: 1.915
		  </div>

      <div style="text-align: right; font-size: 13px; position: relative; right: 26px; font-weight: bold">
        San Cristóbal, <?php echo $fecha?>
      </div>

      <div></div>

      <div style="width: 92%; height: 1px; background: #723200; position: relative; left: 10mm"></div>

      <div class="centro" style="font-size: 12px; position: relative; top: -8px">Av. Guayana, C.C. Villa Etapa "C", Edificio CEMOC - Consultorio 103, San Cristóbal - Edo. Táchira., (0276) 4121329, (0276) 5108011</div>

		</div>
	</page_footer> 

  <div class="contenedor">

      <div id="cabecera">

    		<div style="font-family: 'Qwigley'; font-size: 40px; ">
    			Dra. Gladys A. Chaparro H.
    		</div>

        <div style="font-size: 14px">RIF: v-09143081-5</div>
        <div style="font-size: 14px">Oftalmólogo</div>
        <div style="font-size: 14px">Infantil y Estrabismo</div>
        <div style="font-size: 14px">M.S.D.S.: 34.989 C.M.: 1.915</div>

  		</div>

      <div></div>
      <div class="separador"></div>

  		<div style="position: absolute;  top: 15mm; left: 5mm; height: 0px;">
  			<img src="../imagenes/logo_cemoc.jpg" style="width: 45mm; height: 25mm;">
  		</div>

	    <div class="centro" style="font-size: 16px; font-weight: bold; position:relative; top: 7mm; text-decoration: underline;">CONSTANCIA</div>

	    <div></div>
	    <div></div>

      <?php 
        if (!empty($motivo['texto_html'])) {
      ?>
        <div style="font-size: 15px; text-transform: uppercase;">
          Se hace constar que el paciente <b><?php echo $datos['nombres'].' '.$datos['apellidos']?></b> de <b><?php echo $edad?></b> años de edad, acudio el día de hoy a consulta oftalmológica, donde presenta: <?php echo trim(strtoupper($motivo['texto_html']));?>. <?php echo $menor ?>
        </div>
      <?php 
        } else {
      ?>
        <div style="font-size: 15px; text-transform: uppercase; position: relative;">
          Se hace constar que el paciente <b><?php echo $datos['nombres'].' '.$datos['apellidos']?></b> de <b><?php echo $edad?></b> años de edad, acudio el día de hoy a consulta oftalmológica. <?php echo $menor?>
        </div>
      <?php 
        }
      ?>

      <?php 
        if (!empty($recomendaciones['texto_html'])) {
      ?>
        <div style="text-decoration: underline; font-size: 15px; text-transform: uppercase; position: relative; margin-top: 10px">Recomendaciones:</div>
        <div></div>
        <div style="font-size: 15px; text-transform: uppercase; position: relative;">
          <?php echo strtoupper($recomendaciones['texto_html'])?>
        </div>
      <?php 
        }
      ?>
	    
      <div></div>

      <div style="font-size: 15px; text-transform: uppercase; position: relative;">
        <b><?php echo $aula?></b>
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
          $html2pdf->output("../reportes/constancias/constancia$nombre.pdf", "f");
        } else if ($pdf == 2) {
          $html2pdf->Output("../reportes/constancias/constancia$nombre.pdf");
        } else {  
          $html2pdf->Output("../reportes/constancias/constancia$nombre.pdf");
          $html2pdf->output("../reportes/constancias/constancia$nombre.pdf", "f");
        }
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
  }
?>