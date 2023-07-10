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

  $sql = "select a.*, b.apel_nomb, b.nume_cedu, date_part('year',age(b.fech_naci)) as edad, (b.telefonos->0)::character varying(15) as telefono from historias.plan_cirugia as a
    inner join historias.entradas as b using (id_historia) order by a.hora::time";


  $datos = $obj->e_pdo($sql)->fetchAll(PDO::FETCH_ASSOC);

  //print_r($datos);

  if (isset($_REQUEST['pdf'])) {
    $pdf = (int)$_REQUEST['pdf'];
  } else {
    $pdf = 1;
  }

  if (isset($_REQUEST['fecha'])) {
    $dia = $_REQUEST['fecha'];
    $fecha = new DateTime($dia);
    $dia = $fecha->format('d-m-Y');

  } else {
    throw new Exception('operación inválida: FECHA necesario para plan de cirugia'); 
  }

?>

<style>
      #separador {
        margin-top: 0px
      }

      #titulo1 {
        
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

      table thead tr th {
        border-bottom: 2px dashed #262626;
        border-top: 2px dashed #262626;
        text-align: center;
        font-size: 13px;
      }

      table tbody tr td {
        font-size: 11px;
      }
</style>

<page style="width: 200mm" backtop="1mm" backbottom="5mm" backleft="5mm" backright="5mm">
  <div class="contenedor">
    <div id="cabecera" style="height: 70px">
      <div style="position:relative;">
        <h4 id="titulo1" style="position: relative; top:35px;">CLÍNICA OFTALMOLÓGICA</h4>
        <h4 id="titulo1" style="position: relative;">DR. CASTILLO INCIARTE Y ASOCIADOS C.A</h4>
        <h4 id="titulo2">Rif J-30403474-1</h4>
      </div> 
      <h3 id="titulo3" style="font-size: 12px">Enfermedades Oculares, Retina, Glaucoma, Lentes Intraoculares Rayos Laser, Ecografía</h3>
    </div> 
    <div class="separador imprimir-separar"></div>

    <div id="subcabecera" class="centrar" style="font-size: 10px;">
       <?php echo $_SESSION['informacion_subcabecera_reportes'];?>
    </div>

    <div style="position: absolute;  top: 5mm; left: 0mm">
       <img src="../imagenes/logo_reportes.jpg" style="width: 30mm; height: 23mm;">
    </div>

    <div class="separador" id="separador"></div>
    <table style="margin-bottom: 5mm; border:none">
      <tbody>
        <tr>
          <td style="width: 130mm; text-align: center;"><div style="width:fit-content; border-bottom: 2px dashed #ccc; font-size: 16px">PLAN DE CIRUGÍA <?php echo $dia?></div></td>
        </tr>
      </tbody>
    </table>

    <table style="width: 190mm; margin-top: 0px;border-left: none; border-collapse: collapse;">
      <thead>
        <tr>
          <th style="" class="planes_cabecera">Nombre de paciente:</th>
          <th style="" class="planes_cabecera">Historia:</th>
          <th style="" class="planes_cabecera">Cédula:</th>
          <th style="" class="planes_cabecera">Edad:</th>
          <th style="" class="planes_cabecera">Diagnóstico:</th>
          <th style="" class="planes_cabecera">Teléfono:</th>
          <th style="" class="planes_cabecera">Médico:</th>
          <th style="" class="planes_cabecera">Hora:</th>
        </tr>
      </thead>
      <tbody style="width: 190mm;">
        <?php foreach ($datos as $r) : ?>
          <tr style="padding: 5px;">
            <td style="width: 50mm; height: 15px; text-align: center; vertical-align: middle; border-bottom: 1px dashed #ccc">
              <?php echo $r['apel_nomb']?>
            </td>
            <td style="width: 10mm; height: 15px; text-align: center; vertical-align: middle; border-bottom: 1px dashed #ccc">
              <?php echo $r['id_historia']?>
            </td>
            <td style="width: 15mm; height: 15px; text-align: center; vertical-align: middle; border-bottom: 1px dashed #ccc">
              <?php echo $r['nume_cedu']?>
            </td>
            <td style="width: 5mm; height: 15px; text-align: center; vertical-align: middle; border-bottom: 1px dashed #ccc">
              <?php echo $r['edad']?>
            </td>
            <td style="width: 40mm; height: 15px; text-align: center; vertical-align: middle; border-bottom: 1px dashed #ccc">
              <?php echo $r['diagnostico']?>
            </td>
            <td style="width: 20mm; height: 15px; text-align: center; vertical-align: middle; border-bottom: 1px dashed #ccc">
              <?php echo $r['telefono']?>
            </td>
            <td style="width: 10mm; height: 15px; text-align: center; vertical-align: middle; border-bottom: 1px dashed #ccc">
              <?php echo $r['abrev_medico']?>
            </td>
            <td style="width: 10mm;height: 15px; text-align: center; vertical-align: middle; border-bottom: 1px dashed #ccc">
              <?php 
                $hora = date('h:i:s a', strtotime($r['hora']));

                echo $hora;

                ?>
            </td>

          </tr>
        <?php endforeach;?>
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

        $hora   = $obj->fechaHora('America/Caracas','H-i-s');
        $obj->fechaHora('America/Caracas','d-m-Y');
        $nombre = $dia.'-'.$hora;

        if ($pdf == 1) {
          $html2pdf->output("../reportes/plan_cirugia/plan_cirugia$nombre.pdf", "f");
        } else if ($pdf == 2) {
          $html2pdf->Output("../reportes/plan_cirugia/plan_cirugia$nombre.pdf");
        } else {  
          $html2pdf->Output("../reportes/plan_cirugia/plan_cirugia$nombre.pdf");
          $html2pdf->output("../reportes/plan_cirugia/plan_cirugia$nombre.pdf", "f");
        }
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
  }
?>