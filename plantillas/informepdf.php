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

 // [nombres] => PEPE
 // [apellidos] => PEPE
 // [cedula] => 414324234
 // [fecha] => 2023-09-28
 // [hora] => 10:47:06
 // [fecha_nacimiento] => 2000-12-20
 // [agudeza_od_1] => 0.00
 // [agudeza_od_4] => 1.50
 // [agudeza_od_lectura] => 0.00
 // [agudeza_oi_1] => 0.00
 // [agudeza_oi_4] => 1.50
 // [agudeza_oi_lectura] => 0.00
 // [biomicroscopia] => {"texto_base": "bio DEL INFORME", "texto_html": "bio DEL INFORME"}
 // [contenido] => {"texto_base": "motivo del informe", "texto_html": "motivo del informe"}
 // [control] => {"texto_base": "control DEL INFORME", "texto_html": "control DEL INFORME"}
 // [correccion_1] =>
 // [correccion_4] => X
 // [correccion_lectura] =>
 // [diagnosticos] => [{"id": 4, "value": "4 || CARCINOMA ESPINOCELUAR", "autoincremento": "0"}]
 // [estereopsis] => 10
 // [fondo_ojo] => {"texto_base": "fondo DEL INFORME", "texto_html": "fondo DEL INFORME"}
 // [motilidad] => {"texto_base": "motilidad DEL INFORME", "texto_html": "motilidad DEL INFORME"}
 // [pio_od] => 3.00
 // [pio_oi] => 3.00
 // [plan] => {"texto_base": "plan DEL INFORME", "texto_html": "plan DEL INFORME"}
 // [reflejo] => 10/10
 // [rx_od_grados] => 80
 // [rx_od_resultado] => 15/15
 // [rx_od_signo_1] => X
 // [rx_od_signo_2] =>
 // [rx_od_valor_1] => 1.20
 // [rx_od_valor_2] => 1.20
 // [rx_oi_grados] => 90
 // [rx_oi_resultado] => 30
 // [rx_oi_signo_1] =>
 // [rx_oi_signo_2] => X
 // [rx_oi_valor_1] => 1.70
 // [rx_oi_valor_2] => 1.70
 // [rx_cicloplegia] => X
 // [test] => 20/20
 // [tipo] => 1
 // [diagnosticos_procesados] => [{"nombre": "CARCINOMA ESPINOCELUAR", "id_diagnostico": 4}]
 // [fecha_arreglada] => 28-09-2023,
 // [id_historia] => 11371

  ////////////////////////////////////////////////////////////////
  //EDAD
  ////////////////////////////////////////////////////////////////
  $edad = $obj->calcularEdad($datos['fecha_nacimiento']).' AÑOS DE EDAD';

  $edad_anos = (int)$obj->calcularEdad($datos['fecha_nacimiento']);

  if ($edad == 0) {

    $edad = $obj->calcularMeses($datos['fecha_nacimiento']).' MESES DE EDAD';

  }

  if ($edad == 0) {

    $edad = $obj->calcularDias($datos['fecha_nacimiento']).' DÍAS DE EDAD';

  }

  /////////////////////////////////////////////////////////////////
  //CABECERA
  /////////////////////////////////////////////////////////////////

  if ($edad_anos < 9) {
    $cedula = "CON N° CÉDULA DE REPRESENTANTE $datos[cedula]";
  } else {
    $cedula = "CON N° CÉDULA $datos[cedula]";
  }

  if ($datos['tipo'] == "0") {
    $cabecera = "el paciente $datos[nombres] $datos[apellidos] $cedula de $edad, quien presenta:";
  } else if ($datos['tipo'] == "1") {
    $cabecera = "paciente $datos[nombres] $datos[apellidos] $cedula de $edad, quien presenta:";
  } else if ($datos['tipo'] == "2") {
    $cabecera = "paciente $datos[nombres] $datos[apellidos] $cedula de $edad";
  } else {
    $cabecera = "[CABECERA INVÁLIDA]";
  }

  /////////////////////////////////////////////////////////////////
  //TEXTOS DE HTML
  /////////////////////////////////////////////////////////////////
  if (gettype($datos['contenido']) == 'string') { $contenido = json_decode($datos['contenido'], true); } else { $contenido = $datos['contenido'];}
  if (gettype($datos['biomicroscopia']) == 'string') { $biomicroscopia = json_decode($datos['biomicroscopia'], true); } else { $biomicroscopia = $datos['biomicroscopia'];}
  if (gettype($datos['control']) == 'string') { $control = json_decode($datos['control'], true); } else { $control = $datos['control'];}
  if (gettype($datos['fondo_ojo']) == 'string') { $fondo_ojo = json_decode($datos['fondo_ojo'], true); } else { $fondo_ojo = $datos['fondo_ojo'];}
  if (gettype($datos['motilidad']) == 'string') { $motilidad = json_decode($datos['motilidad'], true); } else { $motilidad = $datos['motilidad'];}
  if (gettype($datos['plan']) == 'string') { $plan = json_decode($datos['plan'], true); } else { $plan = $datos['plan'];}
  
  /////////////////////////////////////////////////////////////////
  //DIAGNOSTICOS
  /////////////////////////////////////////////////////////////////

  if (isset($datos['diagnosticos_procesados'])) {

    $diagnosticos = json_decode($datos['diagnosticos_procesados'], true);

    if (empty($diagnosticos)) {
      $diagnosticos = array();
    }

  } else {

    $sql = "select ppal.basicas_diagnosticos_armar_lista(?) as diagnosticos_procesados";

    $diagnosticos = json_decode($obj->i_pdo($sql, [json_encode($datos['diagnosticos'])], true)->fetchColumn(), true);

    if (empty($diagnosticos)) {
      $diagnosticos = array();
    }

  }

  ////////////////////////////////////////////////////////////////
  setlocale(LC_TIME,"es_ES");

  $fmt = new IntlDateFormatter('es_ES',
    IntlDateFormatter::LONG,
    IntlDateFormatter::NONE,
    'Europe/Berlin',
    IntlDateFormatter::GREGORIAN
  );

  ////////////////////////////////////////////////////////////////
  $timestamp = strtotime($datos['fecha']);

  $fecha =  $fmt->format($timestamp);

  $fecha_arreglada = date("d-m-Y", strtotime($datos['fecha']));

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

<page style="text-align:justify;" backtop="10mm" backbottom="35mm" backleft="10mm" backright="10mm">

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

      <div class="centro" style="font-size: 16px; font-weight: bold; position:relative; top: 7mm; text-decoration: underline;">INFORME MÉDICO</div>

      <div></div>
      <div></div>

      <!-------------------------------------------------------------->
      <!----------------------- RESUMIDO ----------------------------->
      <!-------------------------------------------------------------->
	    <?php if ($datos['tipo'] == "0") { ?>
        <!--echo trim(strtoupper($informe['texto_html']));-->

        <div>
          <?php echo trim(strtoupper($cabecera));?>
        </div>

        <div></div>

        <div>
          <?php echo trim(strtoupper($contenido['texto_html']));?>.
        </div>

        <div></div>
        <div></div>

        <div>
          <b>SE INDICA:</b><?php echo trim(strtoupper($plan['texto_html']));?>.
        </div>

        <div></div>

        <div>
          <b>DEBE VOLVER A CONTROL:</b> <?php echo trim(strtoupper($control['texto_html']));?>.
        </div>

      <!-------------------------------------------------------------->
      <!----------------------- COMPLETO ----------------------------->
      <!-------------------------------------------------------------->
      <?php } else if ($datos['tipo'] == "1") { ?>

        <div>
          <?php echo trim(strtoupper($cabecera));?>
        </div>

        <div></div>

        <div>
          <?php echo trim(strtoupper($contenido['texto_html']));?>.
        </div>

        <div></div>
        <div></div>

        <div style="text-transform: uppercase;">Al examen oftalmológico actual:</div>

        <div></div>
        <?php 

          if ($datos['agudeza_od_4'] !== '0.00' && $datos['agudeza_oi_4'] !== '0.00') {

            if (!empty($datos['correccion_4'])) {
              $correccion_4 = "APLICA CORRECCIÓN";
            } else {
              $correccion_4 = "NO APLICA CORRECCIÓN";
            }

            echo "<b>AGUDEZA VISUAL - 4 METROS</b>";
            echo "<br>";
            echo "<div style='padding-left: 10px'>OI:&nbsp; $datos[agudeza_oi_4] &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $correccion_4</div>";
            echo "<div style='padding-left: 10px'>OD: $datos[agudeza_od_4]</div>";
            echo "<div></div>";

          }

        ?>

        <?php 

          if ($datos['agudeza_od_1'] !== '0.00' && $datos['agudeza_oi_1'] !== '0.00') {

            if (!empty($datos['correccion_1'])) {
              $correccion_1 = "APLICA CORRECCIÓN";
            } else {
              $correccion_1 = "NO APLICA CORRECCIÓN";
            }

            echo "<b>AGUDEZA VISUAL - 1,5 METROS</b>";
            echo "<br>";
            echo "<div style='padding-left: 10px'>OI:&nbsp; $datos[agudeza_oi_1] &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $correccion_1</div>";
            echo "<div style='padding-left: 10px'>OD: $datos[agudeza_od_1]</div>";
            echo "<div></div>";

          }

        ?>

        <?php 

          if ($datos['agudeza_od_lectura'] !== '0.00' && $datos['agudeza_oi_lectura'] !== '0.00') {

            if (!empty($datos['correccion_lectura'])) {
              $correccion_lectura = "APLICA CORRECCIÓN";
            } else {
              $correccion_lectura = "NO APLICA CORRECCIÓN";
            }

            echo "<b>AGUDEZA VISUAL - LECTURA</b>";
            echo "<br>";
            echo "<div style='padding-left: 10px'>OI:&nbsp; $datos[agudeza_oi_lectura] &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; $correccion_lectura</div>";
            echo "<div style='padding-left: 10px'>OD: $datos[agudeza_od_lectura]</div>";
            echo "<div></div>";

          }

        ?>

        <?php 
          if (!empty($motilidad['texto_html'])) {
        ?>

          <b>MOTILIDAD</b><br>
          <div>
            <?php echo trim(strtoupper($motilidad['texto_html']));?>.
          </div>

        <?php 
          }
        ?>

        <?php 
          if (!empty($datos['rx_od_resultado']) && !empty($datos['rx_oi_resultado'])) {
        ?>

          <div></div>

          <?php 
            if (!empty($datos['rx_cicloplegia'])) {
              echo "<b>RX: CICLOPLEGIA</b>";
            } else {
              echo "<b>RX</b>";
            }

            if (!empty($datos['rx_od_signo_1'])) {$rx_od_signo_1 = ' + ';} else {$rx_od_signo_1 = ' - ';}
            if (!empty($datos['rx_od_signo_2'])) {$rx_od_signo_2 = ' + ';} else {$rx_od_signo_2 = ' - ';}
            if (!empty($datos['rx_oi_signo_1'])) {$rx_oi_signo_1 = ' + ';} else {$rx_oi_signo_1 = ' - ';}
            if (!empty($datos['rx_oi_signo_2'])) {$rx_oi_signo_2 = ' + ';} else {$rx_oi_signo_2 = ' - ';}
          ?>          

          <br>
          <table>
            <thead>
              <tr>
                <th></th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td style="width: 30px">OI:</td>
                <td><?php echo $rx_oi_signo_1.$datos['rx_oi_valor_1'].$rx_oi_signo_2.$datos['rx_oi_valor_2']." X ".$datos['rx_oi_grados']."° = ".$datos['rx_oi_resultado']?></td>
              </tr>
              <tr>
                <td style="width: 30px">OD:</td>
                <td><?php echo $rx_od_signo_1.$datos['rx_od_valor_1'].$rx_od_signo_2.$datos['rx_od_valor_2']." X ".$datos['rx_od_grados']."° = ".$datos['rx_od_resultado']?></td>
              </tr>
            </tbody>
          </table>

        <?php 
          }
        ?>

        <?php 
          if (!empty($biomicroscopia['texto_html'])) {
        ?>
          <div></div>
          <b>BIOMICROSCOPIA</b><br>
          <div>
            <?php echo trim(strtoupper($biomicroscopia['texto_html']));?>.
          </div>

        <?php 
          }
        ?>

        <?php 

          if ($datos['pio_od'] !== '0.00' && $datos['pio_oi'] !== '0.00') {

            echo "<div></div>";
            echo "<b>PIO:</b>";
            echo "<br>";
            echo "<div style='padding-left: 10px'>OI:&nbsp; $datos[pio_od] mmHg</div>";
            echo "<div style='padding-left: 10px'>OD: $datos[pio_oi] mmHg</div>";

          }

        ?>

        <?php 
          if (!empty($fondo_ojo['texto_html'])) {
        ?>
          <div></div>
          <b>FONDO DE OJO</b><br>
          <div>
            <?php echo trim(strtoupper($fondo_ojo['texto_html']));?>.
          </div>

        <?php 
          }
        ?>

        <?php  if (count($diagnosticos) > 0) {?>
          <div></div>
          <b>IDX</b>
          <br>
          <?php
            foreach ($diagnosticos as $key => $r) {
              
              echo "- ".$r['nombre'].'<br>';

            };
          ?>

        <?php } ?>

        <?php 
          if (!empty($plan['texto_html'])) {
        ?>
          <div></div>
          <b>PLAN</b><br>
          <div>
            <?php echo trim(strtoupper($plan['texto_html']));?>.
          </div>

        <?php 
          }
        ?>

      <!-------------------------------------------------------------->
      <!------------------------- SIMPLE ----------------------------->
      <!-------------------------------------------------------------->
      <?php } else if ($datos['tipo'] == "2") { ?>

        <div>
          <?php echo trim(strtoupper($cabecera));?>.
        </div>

        <div></div>

        <div>
          <?php echo trim(strtoupper($contenido['texto_html']));?>.
        </div>

      <?php } ?>

    <div></div>
    <div></div>

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
          $html2pdf->output("../reportes/informees/informe$nombre.pdf", "f");
        } else if ($pdf == 2) {
          $html2pdf->Output("../reportes/informees/informe$nombre.pdf");
        } else {  
          $html2pdf->Output("../reportes/informees/informe$nombre.pdf");
          $html2pdf->output("../reportes/informees/informe$nombre.pdf", "f");
        }
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
  }
?>