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
    $pdf = 2;
  }

  $dia  = $obj->fechaHora('America/Caracas','d-m-Y');
  $hora = $obj->fechaHora('America/Caracas','H:i:s');

  setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
?>

<style>
      #separador {
        margin-top: 0px
      }

      #titulo1 {
        top:50px
      }

      #titulo2 {
        top: 75px;
      }

      #titulo3 {
        top:135px;
        font-size: 15px;
      }

      #titulo4 {
        top: 160px;
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
        position:absolute;
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

      .fecha {
        position: absolute; 
        bottom: 5px; 
        right: 30px; 
        font-size: 15px;
      }
</style>

<page style="width:100%" backtop="0mm" backbottom="5mm" backleft="6mm" backright="5mm">
  <div class="contenedor">
     <div id="cabecera" style="height: 70px">
      <div style="position:relative;">
        <h4 id="titulo1" style="">CLÍNICA OFTALMOLÓGICA</h4>
        <h4 id="titulo2">DR. CASTILLO INCIARTE Y ASOCIADOS C.A</h4>
      </div> 
      <h3 id="titulo3" style="margin-top: 5px">RIF: J-30403474-1</h3>
    </div> 
    <div style="height: 10px; margin-top: 20px">
      <div style="position:relative;">
        <h4 id="titulo1" style="">NORMAS PARA LA APLICACIÓN DE RAYOS LASER</h4>
      </div> 
    </div>

    <div style="position: absolute;  top: 5mm; left: 0mm; height: 0px;">
     <img src="../imagenes/logo_reportes.jpg" style="width: 30mm; height: 23mm;">
    </div>
    <div class="separador"></div>

    <div style="text-align: justify; font-size: 12px;">
      <div>
      * * DEBE SOLICITAR SU CITA PARA RAYOS LASER  A LOS NÚMEROS TELEFÓNICOS:
      </div>
      <div></div>
      <div>
      0276-3560139 - 3560141 - 3560237 - 04247498952
      </div>
      <div></div>
     <div>
      *  EL DÍA DE LA APLICACIÓN PUEDE COMER NORMAL.
      </div> 
      <div></div>
      <div style="margin-bottom:5px">
      * SE RECOMIENDA VENIR ACOMPAÑADOS Y TRAER LENTES OSCUROS.
      </div> 
    </div>

    <div class="separador"></div>
    <div style="font-size: 14px">
    * PAGOS VIA TRANSFERENCIA BANCARIA A LOS SIGUIENTES BANCOS.
    </div>

    <div></div>      
    <div style="text-align: justify; font-size: 14px; text-align: center;"><b>PROVINCIAL: 01080361640100014630  MERCANTIL.: 01050093191093041889</b></div>
    <div style="text-align: justify; font-size: 14px; text-align: center; padding-left: 0px"><b>SOFITASA....: 01370020670000130321  TESORO.......: 01630304603043005474</b></div>
    <div></div>
    <div class="separador"></div>

    <div style="text-align: justify; font-size: 12px;">
      <div>
        <b>ZELLE oeci50@gmail.com A NOMBRE DE OSCAR CASTILLO INCIARTE</b>
      </div>
      <div></div>
      <div class="separador"></div>
      <div style="margin-bottom: 5px">
        <b>BANCOLOMBIA: AHORROS 726-28297062 A NOMBRE DE: ORCAR E. CASTILLO INCIARTE C.C. 1.126.243.925.</b>
      </div>
    </div>
    <div class="separador"></div>
  
    <div></div>
    
    <div id="subcabecera" class="centrar">
      A.19 de Abril Edf. Clínica de Ojos P.B. La Bermeja - San Cristóbal Edo.Táchira
    </div>
    <div id="subcabecera" class="centrar">
      TF: 3560133 - 3560139 - 3560141 - 3560137  FAX: 3558633
    </div>

    <div id="subcabecera" class="centrar">
          e-mail: clicastillo@yahoo.com
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

        $html2pdf = new HTML2PDF('P', array($width_in_mm, $height_in_mm), 'en', true, 'UTF-8', array(0, 0, 0, 0));
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));

        $hora   = $obj->fechaHora('America/Caracas','H-i-s');
        $obj->fechaHora('America/Caracas','d-m-Y');
        $nombre = $dia.'-'.$hora;

        if($pdf == 1) {
          $html2pdf->Output("../reportes/normas_laser/normas_laser$nombre.pdf", "f");
        } else if ($pdf == 2) {
          $html2pdf->Output("../reportes/normas_laser/normas_laser$nombre.pdf");
        } else if ($pdf == 3){      
          $html2pdf->Output("../reportes/normas_laser/normas_laser$nombre.pdf");
          $html2pdf->output("../reportes/normas_laser/normas_laser$nombre.pdf", "f");
        }
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
  }
?>