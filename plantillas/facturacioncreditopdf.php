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

  if (isset($_REQUEST['credito'])) {
    $credito = (int)$_REQUEST['credito'];

    $creditoDatos = $obj->i_pdo("select * from facturacion.facturas_credito where id_credito = ?", [$credito], true)->fetch(PDO::FETCH_ASSOC);

  } else {
    throw new Exception('operación inválida: CREDITO necesario para imprimir resumen'); 
  }

  $datos = json_decode($obj->seleccionar("
      select a.*, b.*, TO_CHAR(a.fecha :: DATE, 'dd/mm/yyyy') as fecha_arreglada, b.apel_nomb, c.desc_bare, d.nombre as cirugia, e.desc_segu, g.kit_orden, c.genero
      from facturacion.facturas as a
      inner join historias.entradas as b using(id_historia)
      left join facturacion.baremos as c on a.id_baremo = c.id_principal
      left join historias.cirugias as d using(id_cirugia)
      left join facturacion.seguros as e using(id_seguro)
      left join inventario.ordenes_facturadas as g on a.id_factura = g.id_factura
    where a.id_factura = ?", [$creditoDatos['id_factura_anulada']]), true)[0];

  $baremos = (function ($e){
    $concat = '';
    foreach ($e as &$r) { $concat .= $r['id_baremo'].','; }
    return substr($concat, 0, strlen($concat) - 1);
  })(json_decode($datos['detalle_honorarios'], true));

  $sql = "select id_principal, desc_bare, rif, stat_bare from facturacion.baremos where id_principal in ($baremos)";
  $baremos = $obj->e_pdo($sql)->fetchAll(PDO::FETCH_ASSOC);

  $baremosProcesados = array();

  foreach ($baremos as $b) {
    $baremosProcesados[$b['id_principal']] = $b;
  }

  // echo "<pre>";
  // print_r($creditoDatos);
  // echo "</pre>";

?>

<style>
  #separador {
    margin-top: 0px
  }

  #titulo1 {
    top:30px
  }

  #titulo2 {
    top: 55px;
  }

  #titulo3 {
    top:115px;
    font-size: 15px;
  }

  #titulo4 {
    top: 140px;
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
    width: 200mm;
    height: 2px;
    margin: 0px;
    padding-top: 0px;
    border-top: 1px dashed #727070;
    border-bottom: 1px dashed #727070;
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
    font-size: 12px;
    margin-left: 0px;
    margin-top: 0px;
  }

  table thead, table tbody, table tbody tr, table thead tr {
    width: 300px;
  }

  table tbody tr td {
    text-align: left;
    padding: 0px 5px;
    border-bottom: 0.5px dashed #909090;
  }

  table thead tr th {
    text-align: left;
    padding: 0px 5px;
    border-bottom: 0.5px dashed #909090;
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

<?php 

  $telefonos = json_decode($datos['telefonos'], true);
  $totales = json_decode($datos['totales'], true);
  $subtotales = json_decode($datos['subtotales'], true);
  $mqi = 0;

  $detalle_honorarios = json_decode($datos['detalle_honorarios'], true);
  $detalle_servicios = json_decode($datos['detalle_servicios'], true);
  $conversiones = json_decode($datos['conversiones'], true);
  $subtotal_paciente = json_decode($datos['subtotal_paciente'], true);
  $kit_orden = json_decode($datos['kit_orden'], true);

  $subtotal_descuento = $datos['subtotal_descuento'];

  // echo "<pre>";
  // print_r($subtotal_paciente);
  // echo "</pre>";

  $conversiones = json_decode($datos['conversiones'], true);
  $timestampFactura = strtotime($datos['fecha']);

  $timestampCredito = strtotime($creditoDatos['fecha']);

  $creditoFinal = '';
  $creditoLongitud = strlen(strval($credito));

  for ($i=0; $i < (8 - $creditoLongitud); $i++) { 
    
    $creditoFinal = $creditoFinal.'0';

  }

  $creditoFinal .= $credito;


?>

<page style="width:205mm" backtop="0mm" backbottom="5mm" backleft="6mm" backright="4mm">
  <div class="contenedor">

    <div style="height: 53mm"></div>

    <div style="font-size: 13px; position: relative;">
  
    </div>

    <div style="font-size: 20px; position: absolute; right: 55px; top: 48mm">
      NOTA DE CRÉDITO N°:&nbsp;<?php echo $creditoFinal?>
    </div>

    <div class="separador" style="width: 190mm"></div>

    <div style="font-size: 14px; position: absolute; right: 57px; top: 53mm">
      FECHA:<b>&nbsp;&nbsp;<?php echo date("d", $timestampCredito);?>/<?php echo date("m", $timestampCredito);?>/<?php echo date("Y", $timestampCredito);?></b>
    </div>

    <table style="width: 190mm; border:none; position: relative; top: 0px">
      <tbody>
        <tr>
          <td style="width: 190mm; border:none; font-weight: 100px;"><b>RESPONSABLE:</b> &nbsp;&nbsp; <?php echo $datos['nomb_resp']?></td>
        </tr>
      </tbody>
    </table>

    <table style="width: 190mm; border:none; position: relative; top: 0px">
      <tbody>
        <tr>
          <td style="width: 190mm; border:none; font-weight: 100px;">N° RIF/CÉDULA: &nbsp;&nbsp;&nbsp; <?php echo $datos['cedu_resp']?></td>
        </tr>
      </tbody>
    </table>

    <table style="width: 190mm; border:none; position: relative; top: 0px">
      <tbody>
        <tr>
          <td style="width: 190mm; border:none; font-weight: 100px;">DIRECCIÓN: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $datos['dire_resp']?></td>
        </tr>
      </tbody>
    </table>

    <table style="width: 190mm; border:none; position: relative; top: 0px">
      <tbody>
        <tr>
          <td style="width: 20mm; border:none; font-weight: 100"><b>PACIENTE:</b></td>
          <td style="width: 170mm; border:none;">&nbsp;&nbsp;
            <b><?php echo $datos['apel_nomb'].'</b> - N° HISTORIA:<b>'.$datos['id_historia']?></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <div style="font-weight: 100; width: fit-content">RIF/CÉDULA: &nbsp; <b><?php echo $datos['nume_cedu']?></b></div>
          </td>
        </tr>
      </tbody>
    </table>

    <table style="width: 190mm; border:none;">
      <tbody>
        <tr>
          <td style="width: 57mm; border:none; font-weight: 100">N° Y FECHA DE FACTURA AFECTADA:</td>
          <td style="width: 170mm; border:none; font-weight: bold; text-align: left">
            
            <?php echo $datos['id_factura'];?>

            &nbsp;&nbsp;&nbsp;&nbsp;

            <b>&nbsp;&nbsp;<?php echo date("d", $timestampFactura);?>/<?php echo date("m", $timestampFactura);?>/<?php echo date("Y", $timestampFactura);?></b>
          </td>
        </tr>
      </tbody>
    </table>

    <div class="separador" style="width: 190mm; margin-bottom: 3px"></div>

    <div style="border-bottom: 1px dotted #262626; font-size: 12px; margin-left: 4px; width: 190mm;">CONCEPTO DEL CRÉDITO</div>

    <div style="font-size: 14px; margin-left: 3px; margin-bottom: 4px; font-weight: bold">
      <?php echo $creditoDatos['concepto']; ?>
    </div>

    <div class="separador" style="width: 190mm"></div>

    <table style="width: 190mm; position: relative; top: -10px">
      <thead>
        <tr style="border: 1px solid #262626">
          <th style="border-bottom: 1px dotted #262626; padding-bottom: 2px;">&nbsp;&nbsp;DESCRIPCIÓN DEL SERVICIO</th>
          <th style="border-bottom: 1px dotted #262626; padding-bottom: 2px"></th>
          <th style="border-bottom: 1px dotted #262626; padding-bottom: 2px; text-align: right;">Bs</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($detalle_servicios as $r) :

          if ($r['id_servicio'] == $_SESSION['material_quirurgico_anexo']) {
            $diferenciaMaterial = (($r['costo_dolares'] * $r['cantidad']) * $conversiones[2]['conver']);
          }

          if ($r['id_servicio'] != $_SESSION['material_quirurgico_interno']) {
        ?>
        <tr>
          <td style="font-size: 12px; width: 133mm"><?php echo $r['descripcion']?>:</td>
          <td style="font-size: 12px; width: 15mm; text-align: center"><?php //echo $r['cantidad']?></td>
          <td style="font-size: 12px; width: 26mm; text-align: right;">
            <?php 
              echo number_format(($r['costo_dolares'] * $r['cantidad']) * $conversiones[2]['conver'], 2, ',', '.');
            ?> 
          </td>
        </tr>
        <?php 
          } else {

            $mqi = (float)number_format(($r['costo_dolares'] * $r['cantidad']) * $conversiones[2]['conver'], 2, ',', '.');

          }
        endforeach;?>
      </tbody>
    </table>


    <div class="separador" style="width: 190mm"></div>

    <table style="width: 190mm; position: relative; top: -10px; font-weight: bold">
      <tbody>
        <tr>
          <td style="width: 85mm">TOTAL SERVICIOS:</td>
          <td style="width: 95mm; text-align: right;">
            <?php echo number_format(($subtotales['servicios'] * $conversiones[2]['conver']), 2, ',', '.')?>    
          </td>
        </tr>
      </tbody>
    </table>

    <div class="separador" style="width: 190mm"></div>

    <div style="width: 190mm; text-align: center; position: relative; top: -5px; margin-bottom: 0px; font-size: 13px; font-weight: bold;"></div>

    <table style="width: 190mm">
      <tbody>
        <thead>
        <tr style="border: 1px solid #262626">
          <th style="border-bottom: 1px dotted #262626">&nbsp;&nbsp;NOMBRE</th>
          <th style="border-bottom: 1px dotted #262626">STATUS</th>
          <th style="border-bottom: 1px dotted #262626">N° RIF</th>
          <th style="border-bottom: 1px dotted #262626; text-align: right;">Bs</th>
        </tr>
      </thead>
        <?php foreach ($detalle_honorarios as $r) :?>
        <tr>
          <td style="font-size: 12px;width: 60mm"><?php echo $baremosProcesados[$r['id_baremo']]['desc_bare']?></td>
          <td style="font-size: 12px;width: 43.5mm"><?php echo $r['descripcion']?></td>
          <td style="font-size: 12px;width: 35mm"><?php echo $baremosProcesados[$r['id_baremo']]['rif']?></td>
          <td style="font-size: 12px;width: 30mm; text-align: right;">
            <?php echo number_format($r['costo_dolares'] * $conversiones[2]['conver'], 2, ',', '.'); ?>
          </td>
        </tr>
        <?php endforeach;?>
      </tbody>
    </table>

    <div class="separador" style="width: 190mm"></div>

    <table style="width: 190mm; position: relative; top: -10px; font-weight: bold">
      <tbody>
        <tr>
          <td style="width: 85mm">TOTAL HONORARIOS:</td>
          <td style="width: 95mm; text-align: right;">
            <?php echo number_format(($subtotales['honorarios'] * $conversiones[2]['conver']), 2, ',', '.')?>
          </td>
        </tr>
      </tbody>
    </table>

    <div class="separador" style="width: 190mm"></div>

    <table style="width: 190mm; position: relative; top: -10px; font-weight: bold">
      <tbody>
        <tr>
          <td style="width: 85mm">TOTAL GENERAL:</td>
          <td style="width: 95mm; text-align: right;">
            <?php 
              echo number_format(($subtotales['honorarios'] * $conversiones[2]['conver']) + ($subtotales['servicios'] * $conversiones[2]['conver']), 2, ',', '.');
            ?>
          </td>
        </tr>
      </tbody>
    </table>

    <div class="separador" style="width: 190mm"></div>

    <div></div>

    <div style="text-align: center; font-weight: bold; font-size: 12px;">AUTORIZADO POR</div>

    <div></div>
    <div></div>

    <div style="text-align: center; font-weight: 100; color: #262626">________________________________________</div>

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

        //agregar codigo de credito

        if ($pdf == 1) {
          $html2pdf->output("../reportes/recibos/facturascredito$nombre.pdf", "f");
        } else if ($pdf == 2) {
          $html2pdf->Output("../reportes/recibos/facturascredito$nombre.pdf");
        } else {  
          $html2pdf->Output("../reportes/recibos/facturascredito$nombre.pdf");
          $html2pdf->output("../reportes/recibos/facturascredito$nombre.pdf", "f");
        }
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
  }
?>