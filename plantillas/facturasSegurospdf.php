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


  setlocale(LC_ALL,"es_ES@euro","es_ES","esp");

  $dia  = $obj->fechaHora('America/Caracas','d-m-Y');
  $hora = $obj->fechaHora('America/Caracas','H:i:s');
  $monedas = $obj->e_pdo("select * from miscelaneos.monedas where id_moneda = 2")->fetch(PDO::FETCH_ASSOC);

  if (isset($_REQUEST['pdf'])) {
    $pdf = (int)$_REQUEST['pdf'];
  } else {
    $pdf = 1;
  }

  if (isset($_REQUEST['desde'])) {
    $desde = $_REQUEST['desde'];
  } else {
    throw new Exception('operación inválida: DESDE necesario para imprimir resumen'); 
  }

  if (isset($_REQUEST['hasta'])) {
    $hasta = $_REQUEST['hasta'];
  } else {
    throw new Exception('operación inválida: HASTA necesario para imprimir resumen'); 
  }

  if (isset($_REQUEST['id_seguro'])) {
    $seguro = $_REQUEST['id_seguro'];
  } else {
    throw new Exception('operación inválida: HASTA necesario para imprimir resumen'); 
  }


  $sql = "select * from facturacion.seguros where id_seguro = ?";

  $datos_seguro = $obj->i_pdo($sql, [$seguro], true)->fetch(PDO::FETCH_ASSOC);

  $facturas = json_decode($_SESSION['datos_pdf'], true);

  // echo "<pre>";
  // print_r($facturas);
  // echo "</pre>";

  // $stampDesde = strtotime($desde);
  // $stampHasta = strtotime($hasta);

  $fecha = new DateTime($dia);
  $timestamp = strtotime($dia);
  // $fecha_arreglada = new DateTime($fecha);
  // $fecha = date("d-m-Y", strtotime($fecha));

?>

<style>
  #titulo1 {
    top:55px
  }

  #titulo2 {
    top: 75px;
    font-size: 16px !important;
  }

  #fecha {
    top: 105px;
    font-weight: 100; 
    color: #5f5f5f;
  }

  #hora {
    top:120px; 
    font-weight: 100; 
    color:#5f5f5f;
  }

  h5, h3 {
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

  .separador {
    width: 205mm;
    height: 2px;
    border-top: 1px dashed #383838;
    border-bottom: 1px dashed #383838;
  }

  #cabecera h5, #cabecera h4 {
    width: 100%; 
    text-align: center;
    position:absolute;
  }

  #cabecera h5 {
    font-size: 14px;
  }

  #cabecera h4 {
    font-size: 20px;
  }

  .centro {
    text-align: left;
    font-size: 14px;
    width: 100%;
  }

  table {
    width:300px;
    color: #202020;
    border-bottom: 1px solid #ccc;
    border-left: 1px dashed #ccc;
    font-size: 11px;
  }

  table tbody tr td, table thead tr th {
    width: fit-content;
    text-align: left;
    display: flex;
    padding: 5px 3px;
    border: 1px solid #ccc
  }

  .derecha {
    text-align: right !important;
  }

  .small {
    font-size: 9.5px;
    padding-top: 1px;
    width: fit-content;
  }

  .conceptos-cabecera {
    text-align: center; 
    border: 1px solid #ccc; 
    font-size: 12px;
    height: 20px; 
    vertical-align: middle
  }
</style>

<page style="width:100%" backtop="10mm" backbottom="5mm" backleft="6mm" backright="5mm">
  <div class="contenedor">

    <div class="separador" style="margin-bottom: 10px"></div>

    <div id="subcabecera" class="centrar" style="font-size: 14px; text-align: center; width: 150mm; margin-left: 5px;position: relative; width: 200mm; margin-bottom: 15px">
       <?php echo $_SESSION['informacion_subcabecera_reportes'];?>
    </div>

    <div id="subcabecera" class="centrar" style="font-size: 10px;width: 200mm;text-align: center ;top: 0px; position: relative;">
      RIF J-30403471-1
    </div>

    <div class="separador" style="margin-bottom: 10px"></div>

    <div style="font-style: 16px">
      San Cristóbal,  <?php echo date("d", $timestamp);?> <?php echo strtoupper(strftime("%B", $fecha->getTimestamp()));?> de <?php echo date("Y", $timestamp);?>.
    </div>

    <div></div>
    <div></div>

    <div style="font-style: 16px">
      SEÑORES: 
    </div>
    <div style="font-style: 16px; font-weight: bold">
      <?php echo $datos_seguro['desc_segu']?>
    </div>


    <div></div>
    <div></div>

    <div style="font-style: 16px; font-weight: bold">
      Atención:
    </div>

    <div></div>
    <div></div>

    <div class="separador" style="margin-bottom: 10px"></div>

    <table style="width: 200mm; position: relative; top: -10px">
      <thead>
        <tr style="border: 1px solid #262626">
          <th style="text-align:center; border-bottom: 1px dotted #262626;">N° FACTURA</th>
          <th style="text-align:center; border-bottom: 1px dotted #262626;">FECHA</th>
          <th style="text-align:center; border-bottom: 1px dotted #262626;">PACIENTE</th>
          <th style="text-align:center; border-bottom: 1px dotted #262626;">C.I</th>
          <th style="text-align:center; border-bottom: 1px dotted #262626;">COBERTURA</th>
          <th style="text-align:center; border-bottom: 1px dotted #262626;">ABONO</th>
          <th style="text-align:center; border-bottom: 1px dotted #262626;">CLAVE</th>
        </tr>
      </thead>
      <tbody>
        <?php 

        $total = 0;

        foreach ($facturas as $k => $r) :
          
        ?>
        <tr>
          <td style="width: 20mm; text-align: center"><?php echo $r['id_factura']?></td>
          <td style="width: 18mm; text-align: center"><?php echo $r['fecha']?></td>
          <td style="width: 40mm; text-align: center"><?php echo $r['apel_nomb']?></td>
          <td style="width: 17mm; text-align: center"><?php echo $r['nume_cedu']?></td>
          <td style="width: 17mm; text-align: center"><?php echo $r['total_credito']?></td>
          <td style="width: 20mm; text-align: center"><?php echo $r['total_credito_pagado']?></td>
          <td style="width: 40mm; text-align: center"><?php echo $r['clave_credito_pago']?></td>
        </tr>
        <?php 
        endforeach;
        ?>
      </tbody>
    </table>

    <div class="separador" style="margin-top: 10px"></div>

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
        $width = 216;
        $height = 280;
        $html2pdf = new HTML2PDF('P', array($width,$height, 0, 0), 'en', true, 'UTF-8', array(0, 0, 0, 0));
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));

        $hora   = $obj->fechaHora('America/Caracas','H-i-s');
        $obj->fechaHora('America/Caracas','d-m-Y');
        $nombre = $dia.'-'.$hora;

        if ($pdf == 1) {
          $html2pdf->output("../reportes/citasresumen/citasresumen$nombre.pdf", "f");
        } else if ($pdf == 2) {
          $html2pdf->Output("../reportes/citasresumen/citasresumen$nombre.pdf");
        } else {  
          $html2pdf->Output("../reportes/citasresumen/citasresumen$nombre.pdf");
          $html2pdf->output("../reportes/citasresumen/citasresumen$nombre.pdf", "f");
        }
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
  }
?>