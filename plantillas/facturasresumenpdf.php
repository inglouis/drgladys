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

  $facturas = $obj->i_pdo("
    select * from ppal.v_facturas where fecha between ? and ? order by fecha, id_factura
  ", [$desde, $hasta], true)->fetchAll(PDO::FETCH_ASSOC);

  // echo "<pre>";
  // print_r($kit_orden);
  // echo "</pre>";

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
    padding: 3px 3px;
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
  
    <div style="font-size: 16px; margin-bottom: 10px">Resumen general de facturas desde el <b><?php echo $desde?></b> hasta el <b><?php echo $hasta?></b></div>

    <div class="separador" style="margin-bottom: 10px"></div>

    <table style="width: 200mm; position: relative; top: -10px">
      <thead>
        <tr style="border: 1px solid #262626">
          <th style="text-align:center; border-bottom: 1px dotted #262626;">FECHA</th>
          <th style="text-align:center; border-bottom: 1px dotted #262626;">N° FACT</th>
          <th style="text-align:center; border-bottom: 1px dotted #262626;">CIRUJANO</th>
          <th style="text-align:center; border-bottom: 1px dotted #262626;">PACIENTE</th>
          <th style="text-align:center; border-bottom: 1px dotted #262626;">SEGURO</th>
          <th style="text-align:center; border-bottom: 1px dotted #262626;">HON ($)</th>
          <th style="text-align:center; border-bottom: 1px dotted #262626;">SER ($)</th>
        </tr>
      </thead>
      <tbody>
        <?php 


        foreach ($facturas as $r) :

          $subtotales = json_decode($r['subtotales'], true);
          
        ?>
        <tr>
          <td style="width: 15mm; text-align: center"><?php echo $r['fecha']?></td>
          <td style="width: 15mm; text-align: center"><?php echo $r['id_factura']?></td>
          <td style="width: 40mm; text-align: center"><?php echo $r['desc_bare']?></td>
          <td style="width: 50mm; text-align: center"><?php echo $r['apel_nomb']?></td>
          <td style="width: 20mm; text-align: center"><?php echo $r['descripcion_seguro']?></td>
          <td style="width: 15mm; text-align: center"><?php echo $subtotales['honorarios']?></td>
          <td style="width: 15mm; text-align: center"><?php echo $subtotales['servicios']?></td>
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
          $html2pdf->output("../reportes/facturasresumen/facturasresumen$nombre.pdf", "f");
        } else if ($pdf == 2) {
          $html2pdf->Output("../reportes/facturasresumen/facturasresumen$nombre.pdf");
        } else {  
          $html2pdf->Output("../reportes/facturasresumen/facturasresumen$nombre.pdf");
          $html2pdf->output("../reportes/facturasresumen/facturasresumen$nombre.pdf", "f");
        }
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
  }
?>