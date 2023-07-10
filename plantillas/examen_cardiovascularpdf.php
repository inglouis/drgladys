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

    $datosQuery = json_decode($_REQUEST['datos'], true);

    // echo "<pre>";
    // print_r($datosQuery);
    // echo "</pre>";

    if($datosQuery[0] !== '') {
      $preoperatorio = $obj->e_pdo("select nombre from historias.cirugias where id_cirugia = $datosQuery[0]")->fetchColumn();
    } else {
      $preoperatorio = false;
    }

    if ($datosQuery[1] !== '') {
      $examen_lab = [
        'X','X','X','X','X','X','X','X','X','X','X','X',$datosQuery[5][0],'X',$datosQuery[5][1],'X','X','X','X',$datosQuery[5][2],'X',$datosQuery[5][3]
      ];
    } else if ($datosQuery[2] !== '') {
      $examen_lab = [
        'X','X','','','','','X','X','X','','X','',$datosQuery[5][0],'X',$datosQuery[5][1],'','','','X',$datosQuery[5][2],'',$datosQuery[5][3]
      ];
    } else {
      $examen_lab = false;
    }

    if ($datosQuery[3] !== '') {
      $torax = true;
    } else {
      $torax = false;
    }

  } else {
    throw new Exception('operación inválida: DATOS necesario para imprimir Examen Cardiovascular'); 
  }

   if (isset($_REQUEST['id'])) {
    $id = (int)$_REQUEST['id'];
  } else {
    throw new Exception('operación inválida: ID necesario para imprimir Examen Cardiovascular'); 
  }

  $datos = json_decode($obj->seleccionar("select *, TO_CHAR(fech_naci :: DATE, 'dd-mm-yyyy') as fecha_arreglada
  from historias.entradas a
  inner join historias.medicos b using (id_medico)
  where id_historia = ?", [$id]), true)[0];

  if (isset($_REQUEST['pdf'])) {
    $pdf = (int)$_REQUEST['pdf'];
  } else {
    $pdf = 1;
  }

  $dia = $obj->fechaHora('America/Caracas','d-m-Y');
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
<?php if ($preoperatorio !== false) {?>

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
            <td style="width: 134mm; text-align: center;"><div style="width:fit-content; border-bottom: 2px dashed #ccc; font-size: 16px">EXAMEN CARDIOVASCULAR</div></td>
          </tr>
        </tbody>
      </table>  
      <table style="border:none">
        <tbody>
          <tr>
            <td></td>
          </tr> 
        </tbody>    
      </table>

      <table style="border:none">
        <tbody>
          <tr>
            <td></td>
          </tr> 
        </tbody>    
      </table>


      <table style="border:none;margin-left:20px;">
        <tbody>
          <tr>
            <td style="width: 170mm; text-align: left">PREOPERATORIO DE: <div class="unbold" style="bottom: 5px"><?php echo strtoupper($preoperatorio)?></div></td>
          </tr> 
        </tbody>    
      </table>

      <table style="border:none">
        <tbody>
          <tr>
            <td></td>
          </tr> 
        </tbody>    
      </table>

     <table style="margin-top: 85px; margin-left:20px; font-size=12px";>
        <tbody>
          <tr>
            <td>N° Historia: <div class="small"><?php echo $datos['id_historia']?></div></td>
            <td>NOMBRE: <div class="small"><?php echo $datos['apel_nomb']?></div></td>
            <td>N°.Cédula: <div class="small"><?php echo $datos['nume_cedu']?></div></td>
          </tr>
        </tbody>
      </table>

    </div>  
  </page>
<?php }?>

<?php if ($examen_lab !== false) {?>

<?php 
  include_once('examenes_laboratorio_general.php');
?>

<?php }?>

<?php if ($torax !== false) {?>
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
  
    <div></div>
    <div></div>
    <div></div>

    <div style="width: 200mm; text-align: center">
        <h4 id="titulo1" style="">TELE TORAX PERFIL</h4>
    </div>

    <div></div>

    <div style="width: 200mm; text-align: center; margin-top: 10mm">
      <h4 id="titulo1" style="">APP Y LATERAL</h4>
    </div> 

    <div></div>
    <div></div>

    <table style="margin-top: 20px; margin-left:20px; font-size: 12px;">
      <tbody>
        <tr>
          <td>N° Historia: <div style="width:fit-content"><?php echo $datos['id_historia']?></div></td>
          <td>NOMBRE: <div style="width:fit-content"><?php echo $datos['apel_nomb']?></div></td>
          <td>N°.Cédula: <div style="width:fit-content"><?php echo $datos['nume_cedu']?></div></td>
        </tr>
      </tbody>
    </table>

  </div>  
</page>
<?php }?>

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
        $nombre = $id.'-'.$dia.'-'.$hora;

        if ($pdf == 1) {
          $html2pdf->output("../reportes/examen_cardiovascular/examen_cardiovascular$nombre.pdf", "f");
        } else if ($pdf == 2) {
          $html2pdf->Output("../reportes/examen_cardiovascular/examen_cardiovascular$nombre.pdf");
        } else {  
          $html2pdf->Output("../reportes/examen_cardiovascular/examen_cardiovascular$nombre.pdf");
          $html2pdf->output("../reportes/examen_cardiovascular/examen_cardiovascular$nombre.pdf", "f");
        }
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
  }
?>