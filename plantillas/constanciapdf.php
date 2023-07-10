<?php
  /*MODOS PDF:
    0: traer solo estructura HTML //ESTE SE DESCARTARÁ PARA OTROS REPORTES
    1: solo guardar REPORTE,
    2: traer reporte SIN GUARDAR,
    3: traer reporte Y GUARDAR, 
  */

  ob_start();
  include_once('../clases/pruebas.class.php');
  $obj = new Model();

  if (isset($_REQUEST['datos'])) {
    $datos = json_decode($_REQUEST['datos'], true);
  } else {
    throw new Exception('operación inválida: DATOS necesario para imprimir reposo'); 
  }

  if (isset($_REQUEST['pdf'])) {
    $pdf = (int)$_REQUEST['pdf'];
  } else {
    $pdf = 1;
  }

  $datos[3] = date("d-m-Y", strtotime($datos[3]));

  $dia   = $obj->fechaHora('America/Caracas','d-m-Y');
// Array ( 
//   [0] => 3 
//   [1] => 2021-11-25 
//   [2] => 5 
//   [3] => 2021-11-29 
//   [4] => 1 
//   [5] => lunes, 29 de noviembre de 2021 
//   [6] => 1 )
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
        width: 100%;
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
        width: 100%;
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
        font-size: 11px;
        padding-left: 2px;
        width: fit-content;
        font-weight: 100;
      }

      .unbold {
        font-size: 12px;
        padding-left: 2px;
        top: -1px;
        width: fit-content;
        font-weight: 100;
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

<!-- // Array ( 
//   [0] => 3 
//   [1] => 2021-11-25 
//   [2] => 5 
//   [3] => 2021-11-29 
//   [4] => 1 
//   [5] => lunes, 29 de noviembre de 2021 
//   [6] => 1 ) -->

<page style="width: 200mm" backtop="1mm" backbottom="5mm" backleft="5mm" backright="5mm">
  <div class="contenedor">
    <div id="cabecera" style="height: 70px">
      <div style="position:relative;">
        <h4 id="titulo1" style="">CLÍNICA OFTALMOLÓGICA</h4>
        <h4 id="titulo2">DR. CASTILLO INCIARTE Y ASOCIADOS C.A</h4>
      </div> 
      <h3 id="titulo3">Enfermedades Oculares, Retina, Glaucoma, Lentes Intraoculares</h3>
      <h3 id="titulo4">Rayos Laser, Ecografía</h3>
    </div> 
    <div class="separador imprimir-separar"></div>
    <div id="subcabecera" class="centrar" style="font-size: 10px">
      <?php echo $_SESSION['informacion_subcabecera_reportes'];?>
    </div>

    <div style="position: absolute;  top: 5mm; left: 0mm">
       <img src="../imagenes/logo_reportes.jpg" style="width: 30mm; height: 23mm;">
    </div>

    <div class="separador" id="separador"></div>
    <table style="margin-bottom: 5mm; border:none">
      <tbody>
        <tr>
          <td style="width: 170mm; text-align: center;"><div style="width:fit-content; border-bottom: 2px dashed #ccc; font-size: 16px">CONSTANCIA</div></td>
        </tr>
      </tbody>
    </table>  

    <table style="border:none">
      <tbody>
        <tr>
          <td style="width: 170mm; text-align: left">SE HACE CONSTANCIA QUE EL PACIENTE: <div class="unbold" style="bottom: 5px"><?php echo $datos[1]." [N° Historia: ".$datos[0]."]"?></div></td>
        </tr> 
      </tbody>    
    </table>

    <table style="border:none">
      <tbody>
        <tr>
          <td style="width: 170mm; text-align: left">CON CÉDULA DE IDENTIDAD NÚMERO: <div class="unbold"><?php echo $datos[2]?></div></td>
        </tr> 
      </tbody>    
    </table>

    <table style="border:none">
      <tbody>
        <tr>
          <td style="width: 170mm; text-align: left">ASISTIÓ A CONSULTA EN (DD/MM/AAAA): <div class="unbold"><?php echo $datos[3]?></div></td>
        </tr> 
      </tbody>    
    </table>

   <table style="position: absolute; top: 90mm; left: 0mm">
      <tbody>
        <tr>
          <td>FECHA:<?php echo $dia?></td>
        </tr> 
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
        $html2pdf = new HTML2PDF('P', array($width_in_mm,$height_in_mm), 'en', true, 'UTF-8', array(0, 0, 0, 0));
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));

        $id = 0;
        $hora   = $obj->fechaHora('America/Caracas','H-i-s');
        $obj->fechaHora('America/Caracas','d-m-Y');
        $nombre = $datos[0].'-'.$dia.'-'.$hora;

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