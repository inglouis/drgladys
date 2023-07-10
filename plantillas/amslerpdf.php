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

  if (isset($_REQUEST['pdf'])) {
    $pdf = (int)$_REQUEST['pdf'];
  } else {
    $pdf = 1;
  }

  setlocale(LC_ALL,"es_ES@euro","es_ES", "esp");

  $hora   = $obj->fechaHora('America/Caracas','H-i-s');
  $dia    = $obj->fechaHora('America/Caracas','d-m-Y');

?>
<style>
      #separador {
        margin-top: 0px
      }

      #titulo1 {

      }

      #titulo2 {
      }

      #titulo3 {
        font-size: 15px;
      }

      #titulo4 {
        font-size: 15px;
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

      #cabecera h5, #cabecera h4 {
        width: 100%; 
        text-align: center;
      
      }

      #cabecera h5 {
        font-size: 16px;
      }

      #cabecera h4 {
        font-size: 18px;
      }

      .centro {
        text-align: left;
        font-size: 14px;
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
        padding: 9px 10px;
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

      .fecha {
        position: absolute; 
        bottom: 5px; 
        right: 30px; 
        font-size: 15px;
      }
</style>

<page style="width:100%" backtop="0mm" backbottom="5mm" backleft="6mm" backright="5mm">
  <div class="contenedor">

    <div style="position: absolute;  top: 5mm; left: 0mm">
       <img src="../imagenes/logo_reportes_nuevo.jpg" style="width: 30mm; height: 23mm;">
    </div>

    <div id="cabecera" style="height: 70px; position: relative; top: 10mm; left: -15mm">
      <h4 id="titulo1" style="">CLÍNICA OFTALMOLÓGICA</h4>
      <h4 id="titulo2">DR. CASTILLO INCIARTE Y ASOCIADOS C.A</h4> 
      <h3 id="titulo3" style="position: relative;">Enfermedades Oculares, Retina, Glaucoma, Lentes Intraoculares</h3>
      <h3 id="titulo4" style="position: relative;">Rayos Laser, Ecografía</h3>
    </div> 

    <div class="separador imprimir-separar"></div>
    <div id="subcabecera" class="centrar" style="font-size: 10px; position: relative; left: -15mm">
     <?php echo $_SESSION['informacion_subcabecera_reportes'];?>
    </div>

    <div class="separador" id="separador"></div>

    <div style="font-size: 12px">
      Tápese un ojo y enfoque el punto en el centro de la retícula.
    </div>

    <div style="font-size: 12px">
      Hágase las siguientes pruebas:
    </div>
    
    <div></div>
    
    <div style="font-size: 12px ;position: relative; top: -20px; left: -10px">
      <ul>
        <li>
          ¿Me es posible ver las esquinas y lados del cuadro?
        </li>
        <li>
          ¿Veo alguna línea curveada?
        </li>
        <li>
          ¿Hay hoyos o áreas faltante en la retícula?
        </li>
      </ul> 
    </div>

    <div></div>

    <div style="font-size: 12px; position: relative; top: -10px">
      En caso de que no vea rectas las lineas de la retícula o que haya áreas faltantes o distorsionadas, infórmeselo a su oftalmólogo.
    </div>

    <div style="position: relative; top: 15px; left: 35mm">
       <img src="../imagenes/amsler1.jpg" style="width: 128mm; height: 128mm">
    </div>

    <div></div>

    <table style="border: 1px solid #262626; border-radius: 10px; padding: 0px; position:relative; left: 30px; top: 13px;">
      <thead>
        <tr>
          <th style="width: 170mm">Anotaciones</th>
        </tr>
      </thead>

      <tbody>
        <tr><td style="border-bottom: 0.5px solid #262626; padding:3px;"></td></tr>
        <tr><td style="border-bottom: 0.5px solid #262626"></td></tr>
        <tr><td style="border-bottom: 0.5px solid #262626"></td></tr>
        <tr><td style="border-bottom: 0.5px solid #262626"></td></tr>
        <tr><td style="border-bottom: 0.5px solid #262626"></td></tr>
        <tr><td style="border-bottom: 0.5px solid #262626"></td></tr>
        <tr><td style="border-bottom: 0.5px solid #262626"></td></tr>
        <tr><td style=""></td></tr>
      </tbody>
    </table>

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

        $html2pdf = new HTML2PDF('P', array($width_in_mm, $height_in_mm), 'en', true, 'UTF-8', array(0, 0, 0, 0));
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));

        
        $obj->fechaHora('America/Caracas','d-m-Y');
        $nombre = $dia.'-'.$hora;

        if($pdf == 1) {
          $html2pdf->Output("../reportes/amsler/amsler$nombre.pdf", "f");
        } else if ($pdf == 2) {
          $html2pdf->Output("../reportes/amsler/amsler$nombre.pdf");
        } else if ($pdf == 3){      
          $html2pdf->Output("../reportes/amsler/amsler$nombre.pdf");
          $html2pdf->output("../reportes/amsler/amsler$nombre.pdf", "f");
        }
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
  }
?>