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

  if (isset($_REQUEST['id'])) {
    $id = (int)$_REQUEST['id'];
  } else {
    throw new Exception('operación inválida: ID necesario para informe médico'); 
  }

  if (isset($_REQUEST['cirugia'])) {
    $cirugia = (int)$_REQUEST['cirugia'];
  } else {
    throw new Exception('operación inválida: CIRUGIA necesario para informe médico'); 
  }

  if (isset($_REQUEST['informe'])) {
    $informe = $_REQUEST['informe'];
  } else {
    throw new Exception('operación inválida: INFORME necesario para informe médico'); 
  }

  $datos = json_decode($obj->seleccionar("
      select
        a.id_historia,
        a.apel_nomb,
        a.nume_cedu,
        TO_CHAR(a.fech_naci :: DATE, 'dd-mm-yyyy') as fech_naci,
        a.dire_paci,
        b.nomb_medi,
        a.fech_naci as fech_naci_original
      from historias.entradas as a
      inner join historias.medicos as b using(id_medico)
      where a.id_historia = ?
  ", [$id]), true)[0];

  $cirugia = $obj->i_pdo("select nombre from historias.cirugias where id_cirugia = ?", [$cirugia], true)->fetchColumn();

  if (isset($_REQUEST['pdf'])) {
    $pdf = (int)$_REQUEST['pdf'];
  } else {
    $pdf = 2;
  }

  setlocale(LC_ALL,"es_ES@euro","es_ES","esp");

  $edad = $obj->calcularEdad($datos['fech_naci_original']);
  $dia  = $obj->fechaHora('America/Caracas','d-m-Y');
  $hora = $obj->fechaHora('America/Caracas','H:i:s');

  $timestamp = strtotime($dia);
?>

<style>
      #separador {
        margin-top: 0px
      }

      #titulo1 {
        top:47px
      }

      #titulo2 {
        top: 65px;
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
        font-size: 13px;
      }

      .derecha {
        text-align: right !important;
      }

      .small {
        font-size: 12px;
        padding-top: 1px;
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

<page style="width:100%" backtop="0mm" backbottom="5mm" backleft="6mm" backright="5mm">
  <div class="contenedor">
    <div id="cabecera" style="height: 70px">
      <div style="position:relative;">
        <h4 id="titulo1" style="">CLÍNICA OFTALMOLÓGICA</h4>
        <h4 id="titulo2">DR. CASTILLO INCIARTE Y ASOCIADOS C.A</h4>
      </div> 
      <h3 id="titulo3" style="margin-top: 5px">Enfermedades Oculares, Retina, Glaucoma, Lentes Intraoculares</h3>
      <h3 id="titulo4">Rayos Laser, Ecografía</h3>
    </div> 
    <div class="separador imprimir-separar"></div>
    <div id="subcabecera" class="centrar" style="font-size: 10px">
      <?php echo $_SESSION['informacion_subcabecera_reportes'];?>
    </div>

    <div style="position: absolute;  top: 5mm; left: 0mm">
     <img src="../imagenes/logo_reportes.jpg" style="width: 30mm; height: 23mm;">
    </div>

    <div class="separador"></div>


    <div style="position:relative;">
      <h4 id="titulo1" style="">INFORME MÉDICO</h4>
      <h4 id="titulo1" style="">======= ======</h4>
    </div> 
  
    <table style="margin-top: 10px; margin-left:20px; border:none">
      <tbody>
        <tr>
          <td></td>
        </tr>
      </tbody>
    </table>

    <?php 
      $fecha_arreglada = new DateTime($dia);
    ?>

    <div style="text-align: justify; width: 200mm">
      El suscrito Médico Oftalmólogo Dr. <b><?php echo strtoupper($datos['nomb_medi'])?></b>, hace constar por medio del presente que el paciente <b><?php echo strtoupper($datos['apel_nomb'])?></b>, con cédula de identidad N°: <b><?php echo strtoupper($datos['nume_cedu'])?></b> de &nbsp;<?php echo $edad?> &nbsp;años &nbsp;presenta: <b><?php echo strtoupper($informe)?></b> &nbsp;por&nbsp; lo&nbsp; que&nbsp;&nbsp; amerita&nbsp;&nbsp; CIRUGÍA &nbsp;DE: <br><b><?php echo strtoupper($cirugia)?></b> en la CLÍNICA OFTALMOLÓGICA CASTILLO INCIARTE Y ASOCIADOS.
      Informe que expide a solicitud de la parte interesada en San Cristóbal. Día <?php echo date("d", $timestamp);?> del mes de <?php echo strtoupper(strftime("%B", $fecha_arreglada->getTimestamp()));?> del año <?php echo date("Y", $timestamp);?>.
    </div>
    
    <table style="margin-top: 50px; margin-left:20px">
      <tbody>
        <tr>
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

        $html2pdf = new HTML2PDF('P', array($width_in_mm, $height_in_mm), 'en', true, 'UTF-8', array(0, 0, 0, 0));
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));

        $hora   = $obj->fechaHora('America/Caracas','H-i-s');
        $obj->fechaHora('America/Caracas','d-m-Y');
        $nombre = $id.'-'.$dia.'-'.$hora;

        if($pdf == 1) {
          $html2pdf->Output("../reportes/informe/informemedico$nombre.pdf", "f");
        } else if ($pdf == 2) {
          $html2pdf->Output("../reportes/informe/informemedico$nombre.pdf");
        } else if ($pdf == 3){      
          $html2pdf->Output("../reportes/informe/informemedico$nombre.pdf");
          $html2pdf->output("../reportes/informe/informemedico$nombre.pdf", "f");
        }
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
  }
?>