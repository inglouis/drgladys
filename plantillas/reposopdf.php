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

  $sexo = $obj->i_pdo("select sexo from principales.historias where id_historia = ?", [(int)$datos['id_historia']], true)->fetchColumn();

  $cedula = $datos['cedula'];

  if ($sexo == 'M') {

    $genero = 'Masculino';

  } else {

    $genero = "Femenina";

  }

  // echo "<pre>";
  // print_r($datos);
  // echo "</pre>";

  if (gettype($datos['reposo']) == 'string') {
    $reposo = json_decode($datos['reposo'], true);
  } else {
    $reposo = $datos['reposo'];
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

  $fecha_inicio = date("d-m-Y", strtotime($datos['fecha_inicio']));
  $fecha_final = date("d-m-Y", strtotime($datos['fecha_final']));
  $fecha_simple = date("d-m-Y", strtotime($datos['fecha_simple']));

  $edad = $obj->calcularEdad($datos['fecha_naci']).' AÑOS DE EDAD';

  if ($edad == 0) {

    $edad = $obj->calcularMeses($datos['fecha_naci']).' MESES DE EDAD';

  }

  if ($edad == 0) {

    $edad = $obj->calcularDias($datos['fecha_naci']).' DÍAS DE EDAD';

  }

  if ($datos['representante'] == 'X') {

    $cedula_cabecera = " ";

  } else {

    $cedula_cabecera = "CON CÉDULA DE IDENTIDAD $datos[cedula] ";

  }

  if ($datos['cabecera'] == '0') {

    $cabecera = "SE HACE CONSTAR QUE EL PACIENTE <b>$genero</b> DE $edad ".$cedula_cabecera."FUE INTERVENIDO QUIRÚRGICAMENTE DE: ". trim(strtoupper($reposo['texto_html']));
    
  } else if ($datos['cabecera'] == '1') {

    $cabecera = "SE HACE CONSTAR QUE EL PACIENTE <b>$genero</b> DE $edad ".$cedula_cabecera."PRESENTA: ".trim(strtoupper($reposo['texto_html']));

  } else {

    $cabecera = '[CABECERA SIN ASIGNAR]';

  }

  if ($datos['representante'] == 'X') {

    $representante = $obj->i_pdo("select emergencia_informacion, emergencia_persona from principales.historias where id_historia = ?", [(int)$datos['id_historia']], true)->fetch(PDO::FETCH_ASSOC);

    if (empty($representante['emergencia_persona'])) {
      $representante['emergencia_persona'] = '[SIN REPRESENTANTE ASIGNADO]';
    }

    if (empty($representante['emergencia_informacion'])) {
      $representante['emergencia_informacion'] = '[SIN REPRESENTANTE ASIGNADO]';
    }

    $representante = "AMERITA REPOSO MÉDICO Y CUIDADOS DE SU REPRESENTANTE <b>$representante[emergencia_persona]</b> con C.I <b>$representante[emergencia_informacion].</b> DESDE EL: <b>$fecha_inicio</b> HASTA EL: <b>$fecha_final</b>.";

  } else {

    $representante = "AMERITA REPOSO MÉDICO DESDE EL: <b>$fecha_inicio</b> HASTA EL: <b>$fecha_final</b>.";

  }

  if (empty(trim($datos['recomendaciones_tiempo']))) {

    $recomendaciones_tiempo = '3 MESES';

  } else {

    $recomendaciones_tiempo = strtoupper($datos['recomendaciones_tiempo']);

  }

  if ($datos['recomendaciones'] == 'X') {

    $recomendaciones = "NO DEBE PRACTICAR DEPORTES DE IMPACTO, ACUDIR A RÍOS Y PISCINAS, PLAYAS NI LUGARES CONTAMINADOS DURANTE $recomendaciones_tiempo A PARTIR DE LA FECHA PRESENTE.";

  } else {

    $recomendaciones = "";

  }

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
    <div></div>

    <div style="position: absolute;  top: 15mm; left: 5mm; height: 0px;">
      <img src="../imagenes/logo_cemoc.jpg" style="width: 45mm; height: 25mm;">
    </div>

    <div></div>

    <div style="text-align: right;">
      NOMBRE: <?php echo trim(strtoupper($datos['nombres'].' '.$datos['apellidos']));?>
    </div>

    <div style="text-align: right;">
      C.I: <?php echo trim(strtoupper($datos['cedula']));?>
    </div>


    <div class="centro" style="font-size: 16px; font-weight: bold; position:relative; top: 7mm; text-decoration: underline;">REPOSO MÉDICO</div>

    <div></div>
    <div></div>

    <div style="left: 7mm; width: 90%; position: relative;">
      <?php echo strtoupper($cabecera);?>
    </div>

    <div></div>

    <div style="left: 7mm; width: 90%; position: relative;">
      <?php echo strtoupper($representante);?>
    </div>

    <table style="border:none">
      <tbody>
        <tr>
          <td>(  *  *  <?php echo 'DURANTE: <b>'.$datos['dias']."</b>"?> DÍAS *  *  )</td>
        </tr> 
      </tbody>    
    </table>

    <div></div>

    <div style="left: 7mm; width: 90%; position: relative;">
      <?php echo strtoupper($recomendaciones);?>
    </div>


  </div>

  <div></div>
  <div></div>

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
          $html2pdf->output("../reportes/reposos/reposo$nombre.pdf", "f");
        } else if ($pdf == 2) {
          $html2pdf->Output("../reportes/reposos/reposo$nombre.pdf");
        } else {  
          $html2pdf->Output("../reportes/reposos/reposo$nombre.pdf");
          $html2pdf->output("../reportes/reposos/reposo$nombre.pdf", "f");
        }
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
  }
?>