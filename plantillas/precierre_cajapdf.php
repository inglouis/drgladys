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

  if (isset($_REQUEST['pdf'])) {
    $pdf = (int)$_REQUEST['pdf'];
  } else {
    throw new Exception('operación inválida: PDF necesario para imprimir cierre de caja'); 
  }

  if (isset($_REQUEST['fecha'])) {
    $fecha = $_REQUEST['fecha'];
  } else {
    throw new Exception('operación inválida: FECHA necesario para imprimir cierre de caja'); 
  }

  $sql = "
      select 
      a.id_recibo, a.id_historia, a.total_absoluto, a.apel_nomb, a.total_medico, a.total_hijo, a.subtotales, a.id_moneda, a.pago, a.conversiones, a.id_medico, a.nume_reci, a.no_reci, a.h_nume_reci, a.h_no_reci, c.nomb_medi, a.exonerado,
     
      (SELECT array_to_json(array_agg(row_to_json(t))) 
          FROM (
          select 
              kit.id_concepto,
              dp.nombre,
              kit.monto_dolar,
              kit.monto_pesos
          from historias.conceptos as dp
          inner join (
          SELECT x.*
          from historias.recibos, 
               jsonb_array_elements(conceptos::jsonb) AS t(doc),
               jsonb_to_record(t.doc) as x (id_concepto bigint , monto_dolar numeric(14,2), monto_pesos numeric(14,2))
          where id_recibo = a.id_recibo
          ) as kit on dp.id_concepto = kit.id_concepto
      ) as t) as conceptos,

      a.porcentaje, a.fecha::date, a.hora, a.tipo_reci, a.informe,a.status

  from historias.recibos as a
      inner join historias.entradas as b using(id_historia)
      inner join historias.medicos as c ON a.id_medico = c.id_medico
      inner join primarias.form_pago as d ON a.pago = d.codi_fopa
      inner join miscelaneos.monedas as e using(id_moneda)
  where a.status = 'A' and a.fecha = '$fecha'::date or a.status = 'D' and a.fecha = '$fecha'::date
  order by a.id_medico asc, a.id_historia asc
  ";

$datos = json_decode($obj->seleccionar($sql, []), true);

$sql = "select * from historias.recibos where status = 'B' and fecha = '$fecha'";
$bloqueados = json_decode($obj->seleccionar($sql, []), true);

// echo "<pre>";
// print_r($bloqueados);
// echo "</pre>";

$dia       = $obj->fechaHora('America/Caracas','d-m-Y');
$hora      = $obj->fechaHora('America/Caracas','H:i:s');

$drpm = array();

foreach ($datos as $r) {

  $conver = json_decode($r['conversiones'], true);

  if (!array_key_exists($r['id_medico'], $drpm)) {
    $drpm[$r['id_medico']] = array();
    $drpm[$r['id_medico']]['total_absoluto'] = 0;
    $drpm[$r['id_medico']]['medico'] = '';
    $drpm[$r['id_medico']]['porcentaje'] = 0;
    $drpm[$r['id_medico']]['conver'] = $conver[3];
    $drpm[$r['id_medico']]['total_absoluto_todos'] = 0;
  }

  // echo "<pre>";
  // print_r($r);
  // echo "</pre>";

  if($r['pago'] !== 3) {
    $drpm[$r['id_medico']]['conver'] = ($conver[3] + $drpm[$r['id_medico']]['conver']) / 2;
    $drpm[$r['id_medico']]['total_absoluto'] = $drpm[$r['id_medico']]['total_absoluto'] + (int)$r['total_absoluto'];
  }

  $drpm[$r['id_medico']]['total_absoluto_todos'] = $drpm[$r['id_medico']]['total_absoluto_todos'] + (int)$r['total_absoluto'];

  $drpm[$r['id_medico']]['medico'] = $r['nomb_medi'];
  $drpm[$r['id_medico']]['porcentaje'] = $r['porcentaje'];
  $drpm[$r['id_medico']]['id_medico'] = $r['id_medico'];

  // echo $drpm[$r['id_medico']]['total_absoluto'].'----';
  // echo  $drpm[$r['id_medico']]['conver'];
}


//print_r($drpm);
// (
//  [id_recibo] => 4
//  [id_historia] => 7
//  [total_absoluto] => 40.00
//  [total_medico] => 40.00
//  [total_hijo] => 0.00
//  [subtotales] => [{"id_moneda":1,"subtotal":"30"},{"id_moneda":3,"subtotal":"36000"}]
//  [id_moneda] => 1
//  [id_pago] => 1
//  [conversiones] => {"1":1,"2":4.54,"3":3600,"4":0.85}
//  [id_medico] => 1
//  [nume_reci] => 139366
//  [no_reci] => 3
//  [h_nume_reci] => 0
//  [h_no_reci] => 0
//  [conceptos] => [{"id_concepto":14,"nombre":"FDT BIULATERAL (E)","monto_dolar":40.00,"monto_pesos":150000.00}]
//  [porcentaje] => 0.00
//  [fecha] => 2021-11-26
//  [hora] => 00:27:44
//  [tipo_reci] => 0
//  [informe] =>
//  [status] => A
//  )

  $posicion  = 360; 
  $fecha = date("d-m-Y", strtotime($fecha));
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
        width: 81%;
        display: flex;
        flex-direction: column;
        font-size: 18px;
      }
    
      .separador {
        width: 190mm;
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

      table tbody tr td {
        width: fit-content;
        text-align: left;
        display: flex;
        padding: 3px 5px;
        border: 1px solid black;
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

<!--  => Array
 (
 [id_recibo] => 4
 [id_historia] => 7
 [total_absoluto] => 40.00
 [total_medico] => 40.00
 [total_hijo] => 0.00
 [subtotales] => [{"id_moneda":1,"subtotal":"30"},{"id_moneda":3,"subtotal":"36000"}]
 [id_moneda] => 1
 [id_pago] => 1
 [conversiones] => {"1":1,"2":4.54,"3":3600,"4":0.85}
 [id_medico] => 1
 [nume_reci] => 139366
 [no_reci] => 3
 [h_nume_reci] => 0
 [h_no_reci] => 0
 [conceptos] => [{"id_concepto":14,"nombre":"FDT BIULATERAL (E)","monto_dolar":40.00,"monto_pesos":150000.00}]
 [porcentaje] => 0.00
 [fecha] => 2021-11-26
 [hora] => 00:27:44
 [tipo_reci] => 0
 [informe] =>
 [status] => A
 ) -->


<?php 
  $totalDolar = 0;
  $totalPesos = 0;
  $totalBoliv = 0;

  $total = 0;

  $totales = array(
    1 => $total,
    2 => $total,
    3 => $total,
    4 => $total
  );

  $SDM = array(); //subtotalesDivisasMedicos

  foreach ($datos as $r) {

    $conversiones = json_decode($r['conversiones'], true);
    $subtotales = json_decode($r['subtotales'], true);

    if(!isset($SDM[$r['id_medico']])) {

      $SDM[$r['id_medico']] = array(
        1 => 0,
        2 => 0,
        3 => 0,
        4 => 0
      );

    }

    foreach ($subtotales as $sub) {
    
      $totales[$sub['id_moneda']] = $totales[$sub['id_moneda']] + $sub['subtotal'];

      $SDM[$r['id_medico']][$sub['id_moneda']] = $SDM[$r['id_medico']][$sub['id_moneda']] + $sub['subtotal'];

    }
  }

?>

<page style="width:216mm" backtop="5mm" backbottom="5mm" backleft="5mm" backright="5mm">
  <div class="contenedor">

    <table style="width: 200mm; border:none">
      <tbody>
        <tr>
          <td style="width: 48%; font-size: 16px; font-weight: bold; text-align: center">DIARIO M.E.</td>
          <td style="width: 49.5%; font-size: 16px; font-weight: bold; text-align: center">FECHA: <?php echo $fecha;?></td>
        </tr>
      </tbody>
    </table>

    <table style="border: 1px solid black; width: 200mm">
      <thead>
        <tr>
          <th style="width: 10mm; text-align: center; height: 7mm; vertical-align: middle; border: 1px dashed #262626">N°.HIST</th>
          <th style="max-width:65mm; width: 65mm; text-align: center; height: 7mm; vertical-align: middle; border: 1px dashed #262626">NOMBRE DEL PACIENTE</th>
          <th style="width: 10mm; text-align: center; height: 7mm; vertical-align: middle; border: 1px dashed #262626">MÉD</th>
          <th style="max-width:13mm; width: 13mm; text-align: center; height: 7mm; vertical-align: middle; border: 1px dashed #262626">RECI</th>
          <th style="width: 13mm; text-align: center; height: 7mm; vertical-align: middle; border: 1px dashed #262626">US $</th>
          <th style="width: 15mm; text-align: center; height: 7mm; vertical-align: middle; border: 1px dashed #262626">BOL BSS</th>
          <th style="width: 18mm; text-align: center; height: 7mm; vertical-align: middle; border: 1px dashed #262626">PESOS COL</th>
          <th style="width: 10mm; text-align: center; height: 7mm; vertical-align: middle; border: 1px dashed #262626">EU €</th>
          <th style="width: 15mm; text-align: center; height: 7mm; vertical-align: middle; border: 1px dashed #262626">EXO</th>
        </tr>
      </thead>
      <tbody>

        <?php 
          $tr = "";

          $exoneradoTotal = 0;
          foreach ($datos as $r) {

            $estructura = "
            <tr>
              <td style='text-align: center; font-size: 13px'>$r[id_historia]</td>
              <td style='max-width:65mm; width: 65mm; text-align: center; font-size: 13px'>$r[apel_nomb]</td>
              <td style='text-align: center; font-size: 13px'>$r[id_medico]</td>
            ";

            if ($r['tipo_reci'] == 1) {
              $estructura .= "<td style='text-align: center; font-size: 13px'>$r[nume_reci]</td>";
            } else {
              $estructura .= "<td style='text-align: center; font-size: 13px'></td>";
            }

            $subtotales = json_decode($r['subtotales'], true);
            $exoneradoTotal = $exoneradoTotal + $r['exonerado'];

            if($r['pago'] == 3) {
              $totalTr = array(
                1 => 'CORTESÍA',
                2 => '',
                3 => '',
                4 => ''
              );
            } else {
              $totalTr = array(
                1 => '',
                2 => '',
                3 => '',
                4 => ''
              );

              foreach ($subtotales as $e) {
                $totalTr[$e['id_moneda']] = $e['subtotal']; 
              }
            }

            foreach ($totalTr as $e) {
              $estructura .= "<td style='text-align: center; font-size: 13px'>$e</td>";
            }

             $estructura .= "<td style='text-align: center; font-size: 13px'>$r[exonerado]</td>";

            $estructura .= "</tr>";
            $tr .= $estructura;

          }    
          echo $tr;  
        ?>
        <tr>
          <td style="font-size: 13px; font-weight: bold; text-align: center">TOTAL:</td>
          <td></td>
          <td></td>
          <td></td>
          <td style="font-size: 13px; font-weight: bold; text-align: center"><?php echo $totales[1];?></td>
          <td style="font-size: 13px; font-weight: bold; text-align: center"><?php echo $totales[2]?></td>
          <td style="font-size: 13px; font-weight: bold; text-align: center"><?php echo $totales[3]?></td>
          <td style="font-size: 13px; font-weight: bold; text-align: center"><?php echo $totales[4]?></td>
          <td style="font-size: 13px; font-weight: bold; text-align: center"><?php echo $exoneradoTotal?></td>
        </tr>
      </tbody>
    </table>

    <table style="border: 1px solid black; width: 200mm; margin-top:20px">
      <thead>
        <tr>
          <th style="width: 89mm; text-align: center; height: 7mm; vertical-align: middle; border: 1px dashed #262626">MÉDICO</th>
          <th style="width: 30mm; text-align: center; height: 7mm; vertical-align: middle; border: 1px dashed #262626">TOTAL $</th>
          <th style="width: 30mm; text-align: center; height: 7mm; vertical-align: middle; border: 1px dashed #262626">TOTAL COL</th>
          <th style="width: 38mm; text-align: center; height: 7mm; vertical-align: middle; border: 1px dashed #262626">PORCENTAJE</th>
        </tr>
      </thead>
      <tbody>

<!--         <td style='text-align: center; font-size: 13px'><?php echo round($r['total_absoluto'] * $conversiones[2] , 2)?></td>
        <td style='text-align: center; font-size: 13px'><?php echo round($r['total_absoluto_todos'] * $conversiones[2] , 2)?></td> -->

        <?php 
          foreach ($drpm as $r) :

        ?>
            <tr>
              <td style='text-align: center; font-size: 13px'><?php echo $r['medico']?></td>
              <td style='text-align: center; font-size: 13px'><?php echo $SDM[$r['id_medico']]['1'];?></td>
              <td style='text-align: center; font-size: 13px'><?php echo $SDM[$r['id_medico']]['3'];?></td>
              <td style='text-align: center; font-size: 13px'><?php echo $r['porcentaje']?></td>
            </tr>
        <?php endforeach;?>
      </tbody>
    </table>

    <div style="width: 190mm; font-size: 16px; text-align: left; border: 1px dashed #ccc; margin-top:20px">
      Reportes de pagos o recibos anulados - con valor 0.00 en el cierre de caja:
    </div>

    <table style="border: 1px solid black; width: 200mm; top: -20px">
      <thead>
        <tr>
          <th style="width: 20mm; text-align: center; height: 7mm; vertical-align: middle; border: 1px dashed #262626">HISTORIA</th>
          <th style="width: 75mm; text-align: center; height: 7mm; vertical-align: middle; border: 1px dashed #262626">PACIENTE</th>
          <th style="width: 30mm; text-align: center; height: 7mm; vertical-align: middle; border: 1px dashed #262626">CORRELATIVO</th>
          <th style="width: 30mm; text-align: center; height: 7mm; vertical-align: middle; border: 1px dashed #262626">FORMA</th>
          <th style="width: 32mm; text-align: center; height: 7mm; vertical-align: middle; border: 1px dashed #262626">MONTO BASE $</th>
        </tr>
      </thead>
      <tbody>

        <?php 
          foreach ($bloqueados as $r) :
        ?>
            <tr>
              <td style='text-align: center; font-size: 13px'><?php echo $r['id_historia']?></td>
              <td style='text-align: center; font-size: 13px'><?php echo $r['apel_nomb']?></td>
              <td style='text-align: center; font-size: 13px'>
                <?php 
                  if ($r['tipo_reci'] == 1) {
                    echo $r['nume_reci'];
                  } else {
                    echo $r['no_reci'];
                  }        
                ?>
              </td>
              <td style='text-align: center; font-size: 13px'>
                <?php 
                  if ($r['tipo_reci'] == 1) {
                    echo 'RECIBO';
                  } else {
                    echo 'PAGO';
                  }        
                ?>
              </td>
              <td style='text-align: center; font-size: 13px'><?php echo $r['total_absoluto']?></td>
            </tr>
        <?php endforeach;?>
      </tbody>
    </table>
  </div>  
</page>

<?php 
  $totalDolar = 0;
  $totalPesos = 0;

  foreach ($datos as $r) {
    if($r['id_moneda'] == 1) {
      $totalDolar = $totalDolar + (float)$r['total_absoluto'];
    } else {
      $totalPesos = $totalPesos + (float)$r['total_absoluto'];
    }
  }
?>

<?php
  require_once(dirname(__FILE__).'/../vendor/autoload.php');
  require_once('../vendor/autoload.php');
  use Spipu\Html2Pdf\Html2Pdf;

  if($pdf !== 0) {
    $content = ob_get_clean();

    try
    {    
        $width_in_mm = 205;
        $height_in_mm = 280;
        $html2pdf = new HTML2PDF('P', array($width_in_mm,$height_in_mm), 'en', true, 'UTF-8', array(0, 0, 0, 0));
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));

        $hora   = $obj->fechaHora('America/Caracas','H-i-s');
        $obj->fechaHora('America/Caracas','d-m-Y');
        $nombre = $dia.'-'.$hora;

        if ($pdf == 1) {
          $html2pdf->output("../reportes/precierre/precierre$nombre.pdf", "f");
        } else if ($pdf == 2) {
          $html2pdf->Output("../reportes/precierre/precierre$nombre.pdf");
        } else {  
          $html2pdf->Output("../reportes/precierre/precierre$nombre.pdf");
          $html2pdf->output("../reportes/precierre/precierre$nombre.pdf", "f");
        }
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
  }
?>