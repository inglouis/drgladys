<?php
  /*MODOS PDF:
    0: traer solo estructura HTML
    1: solo guardar REPORTE,
    2: traer reporte SIN GUARDAR,
    3: traer reporte Y GUARDAR, 
  */

  ob_start();
  include_once('../clases/pruebas.class.php');
  $obj = new Model();

  if (isset($_REQUEST['datos'])) {
    
    $datosSobre = json_decode($_REQUEST['datos'], true);
    $formato = (int)$datosSobre[4];

  } else {
    throw new Exception('operación inválida: ID_SOBRE necesario para informe especial'); 
  }

  if (isset($_REQUEST['pdf'])) {
    $pdf = (int)$_REQUEST['pdf'];
  } else {
    $pdf = 2;
  }

  $dia  = $obj->fechaHora('America/Caracas','d-m-Y');
  $hora = $obj->fechaHora('America/Caracas','H:i:s');

  $reemplazos = ['', '', '', "<b>", "</b>", "<u>", "</u>", "<i>", "</i>", "<br>", "<br><br>", "<div style='width:140mm; text-align:center;'>", "</div>", '', '', "&nbsp;"];
  $reemplazar = ["[H]", "[C]", "[N]", "[-B]", "[B-]", "[-U]", "[U-]", "[-I]", "[I-]", "[BR]", "[BR2]", "[-CE]", "[CE-]", "[E]", "[F]", "[-]"];

  $titulo = str_replace($reemplazar, $reemplazos, $datosSobre[0]);
  $contenido = str_replace($reemplazar, $reemplazos, strtoupper($datosSobre[1]));

  function espaciosBlancos($contenido) {

    $espacios_start = strpos($contenido ,"[ ");
    $espacios_end = strpos($contenido ," ]");

    if ($espacios_start && $espacios_end) {

      $blancos = '';
      $espacios = substr($contenido, $espacios_start, ($espacios_end - $espacios_start) + 2);

      for ($i=0; $i < strlen($espacios); $i++) { 
        $blancos .= '&nbsp;';
      };

      $contenidoLoop = str_replace($espacios, $blancos, $contenido);

      return espaciosBlancos($contenidoLoop);

    } else {
      //echo $contenido;
      return $contenido;

    }
  
  };

//echo $contenido;

$contenido = espaciosBlancos($contenido);
$titulo = espaciosBlancos($titulo);
//echo 'paso:'.$contenido;

  setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
?>

<style>
      #romper {
        white-space:pre-wrap;
      }

      #separador {
        margin-top: 0px
      }

      #titulo1 {
     
        top: -10px;
      }

      #titulo2 {

        top: 0px;
      }

      #titulo3 {

        font-size: 11px;
        top: 0px;
      }

      #titulo4 {
        font-size: 11px;
        top: 0px;
      }

      #fecha {
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
      }

      #subcabecera {
        font-size: 10px;
        width: 100%;
        text-align: center;
      }
    
      .separador {
        width: 98%;
        height: 2px;
        border-top: 1px dashed #909090;
        border-bottom: 1px dashed #909090;
        margin: 1px 1px;
      }

      #cabecera h5, #cabecera h4 {
        width: 100%; 
        text-align: center;
      }

      #cabecera h5 {
        font-size: 13px;
      }

      #cabecera h4 {
        font-size: 13px;
      }

      .centro {
        text-align: left;
        font-size: 12px;
        width: 100%;
      }

      .tabla {
        margin-left: 50px;
      }

      table {
        width:100%;
        color: #202020;
        border-bottom: 1px solid #ccc;
        border-left: 1px dashed #ccc;
        font-size: 11px;
      }

      table thead, table tbody, table tbody tr, table thead tr {
        width: 300px;
      }

      table tbody tr td, table thead tr th {
        text-align: left;
        padding: 3px 5px;
        font-weight: bold;
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
  
</style>

<?php if ($formato == 1) {?>  

  <page style="width:240mm" backtop="5mm" backbottom="0mm" backleft="0mm" backright="10mm">


    <div class="contenedor" style="position: relative; rotate:90; ">
      <div id="cabecera" style="height: 20px; position: relative; top:355px; "><!--245px-->
        <h4 id="titulo1">CLÍNICA OFTALMOLÓGICA</h4>
        <h4 id="titulo2" style="position: relative; top: 0px;">DR. CASTILLO INCIARTE Y ASOCIADOS C.A</h4> 
        <h3 id="titulo3" style="position: relative; top: 0px;">Enfermedades Oculares, Retina, Glaucoma, Lentes Intraoculares</h3>
        <h3 id="titulo4">Rayos Laser, Ecografía</h3>
      </div> 

      <div class="separador imprimir-separar" style="position: relative; top: 2px;"></div>
      <div id="subcabecera" class="centrar" style="position: relative; top: -10px">
        <?php echo $_SESSION['informacion_subcabecera_reportes'];?>
      </div>

      <div style="position: absolute;  top:89mm; left: 0mm;"> <!--60mm-->
         <img src="../imagenes/logo_reportes.jpg" style="width: 25mm; height: 18mm;">
      </div>

      <div class="separador"></div>
    
      <div></div>

      <!--<div style="position:relative;">
        <h4 id="titulo1" style="text-decoration: underline;"><?php echo $titulo?></h4>
      </div> 
     -->

      <div id="romper"style="width: 180mm; text-align: justify; min-height: 60mm; font-size: 12px; position: relative; top: -20px; text-align: center; line-height: 0.8;">
        <div style="text-align: justify;">
          <?php echo $contenido?>
          
        </div>
      </div> 

      <div></div>

      <?php if ($datosSobre[3] == 'A') {?>
      <div style="position: relative; margin-top:0px; font-size: 10px; top: -5px; right: 0px">
        <div class="fecha">
          Fecha: <?php echo $dia?>
        </div>
      </div>
      <?php }?>


    </div>  

  </page>

<?php } else if ($formato == 2) {?>

  <page style="width:240mm" backtop="5mm" backbottom="0mm" backleft="0mm" backright="10mm">


    <div class="contenedor" style="position: relative; rotate:90; ">


      <div id="romper"style="width: 180mm; text-align: justify; min-height: 60mm; font-size: 12px; position: relative; top: 350px; text-align: center; line-height: 0.8;">
        <div style="text-align: justify;">
          <?php echo $contenido?>
          
        </div>
      </div> 

      <div></div>

      <?php if ($datosSobre[3] == 'A') {?>
      <div style="position: relative; margin-left:40px; margin-top:0px; font-size: 10px; top: -5px; right: 0px">
        <div class="fecha">
          Fecha: <?php echo $dia?>
        </div>
      </div>
      <?php }?>


    </div>  

  </page>

<?php } ?>


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

        $html2pdf = new HTML2PDF('P', array($width_in_mm, $height_in_mm), 'en', true, 'UTF-8', array(0, 0, 0, 0));
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));

        $hora   = $obj->fechaHora('America/Caracas','H-i-s');
        $obj->fechaHora('America/Caracas','d-m-Y');
        $nombre = $titulo.'.'.$dia.'-'.$hora;

        if($pdf == 1) {
          $html2pdf->Output("../reportes/sobres/sobres$nombre.pdf", "f");
        } else if ($pdf == 2) {
          $html2pdf->Output("../reportes/sobres/sobres$nombre.pdf");
        } else if ($pdf == 3){      
          $html2pdf->Output("../reportes/sobres/sobres$nombre.pdf");
          $html2pdf->output("../reportes/sobres/sobres$nombre.pdf", "f");
        }
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
  }
?>