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

  if (isset($_REQUEST['id'])) {

    $id_cierre = $_REQUEST['id'];
    $sql = "select *, TO_CHAR(fecha :: DATE, 'dd-mm-yyyy') as fecha_arreglada from historias.cierres_caja where id_cierre = $id_cierre";
    $datosCierre = $obj->e_pdo($sql, [])->fetch(PDO::FETCH_ASSOC);

  } else {
    throw new Exception('operación inválida: ID necesario para imprimir cierre de caja'); 
  }

  if (isset($_REQUEST['pdf'])) {
    $pdf = (int)$_REQUEST['pdf'];
  } else {
    throw new Exception('operación inválida: ID necesario para imprimir cierre de caja'); 
  }

  if (isset($_REQUEST['general'])) {
    $general = (int)$_REQUEST['general'];
  } else {
    throw new Exception('operación inválida: GENERAL necesario para imprimir cierre de caja'); 
  }

  if (isset($_REQUEST['individuos'])) {
    $individuos = (int)$_REQUEST['individuos'];
  } else {
    throw new Exception('operación inválida: INDIVIDUOS necesario para imprimir cierre de caja'); 
  }

  if (isset($_REQUEST['cierre'])) {
    $cierre = (int)$_REQUEST['cierre'];
  } else {
    throw new Exception('operación inválida: CIERRE necesario para imprimir cierre de caja'); 
  }

  if (isset($_REQUEST['fecha'])) {
    $fecha = $_REQUEST['fecha'];
  } else {
    throw new Exception('operación inválida: FECHA necesario para imprimir cierre de caja'); 
  }

  if (isset($_REQUEST['montos'])) {
    $montos = json_decode($_REQUEST['montos'], true);
  } else {
    $montos = false;
  }

  //print_r($montos);

  // echo "<pre>";
  // print_r($datosCierre);
  // echo "</pre>";

  $datosRecibos = json_decode($datosCierre['recibos'], true);

  foreach ($datosRecibos as &$r) {
    $r['conversiones'] = json_decode($r['conversiones'], true);
    $r['conceptos'] = json_decode($r['conceptos'], true);
  }

  //print_r(json_encode($datosRecibos));

  $datosRecibos = json_encode($datosRecibos);
  
  $sql = "
      select
        t.id_recibo,
        t.id_historia,
        t.id_medico,
        b.id_hijo,
        t.id_moneda,
        b.nomb_medi,
        d.nomb_hijo,
        coalesce(NULLIF(e.apel_nomb, null), c.apel_nomb) as apel_nomb,
        case when t.id_moneda = 3 then (total_absoluto / (conversiones->>'3')::numeric(14,2))::numeric(14,2) else total_absoluto::numeric(14,2) end as total_absoluto_dolar,
        case when t.id_moneda = 3 then (total_medico / (conversiones->>'3')::numeric(14,2))::numeric(14,2) else total_medico::numeric(14,2) end as total_medico_dolar,
        case when t.id_moneda = 3 then (total_hijo / (conversiones->>'3')::numeric(14,2))::numeric(14,2) else total_hijo::numeric(14,2) end as total_hijo_dolar,
        t.conversiones,
        t.subtotales,
        (conversiones->>'2')::numeric(14,2) as conversion_bolivar,
        t.conceptos_abrevituras,
        t.nume_reci,
        t.no_reci,
        h_nume_reci,
        h_no_reci,
        t.hora,
        t.tipo_reci,
        t.exonerado,
        t.porcentaje,
        TO_CHAR(t.fecha :: DATE, 'dd-mm-yyyy') as fecha_arreglada
      FROM (
        SELECT 
      x.*,
      (
          select json_agg( row_to_json(t)) from 
        (
            select a.abreviatura, b.monto_dolar, b.monto_pesos, a.grupos, b.cantidad
            from historias.conceptos as a
            inner join (
            SELECT x.*
            from  
               jsonb_array_elements(x.conceptos::jsonb) AS t(doc),
               jsonb_to_record(t.doc) as x (id_concepto bigint, monto_dolar numeric(14,2), monto_pesos numeric(14,2), cantidad bigint)
        ) as b on a.id_concepto = b.id_concepto) as t
      ) as conceptos_abrevituras
        from 
         jsonb_array_elements(
      '$datosRecibos'::jsonb
      ) AS t(doc),
         jsonb_to_record(t.doc) as x (
          id_recibo bigint, 
          id_historia bigint, 
          id_medico bigint, 
          id_hijo bigint,
          total_absoluto numeric(14,2),
          total_medico numeric(14,2),
          total_hijo numeric(14,2),
          id_moneda bigint,
          conversiones json,
          conceptos json,
          subtotales json,
          porcentaje numeric(6,2),
          nume_reci bigint,
          no_reci bigint,
          h_nume_reci bigint,
          h_no_reci bigint,
          hora time without time zone,
          tipo_reci smallint,
          fecha date,
          exonerado numeric(14,2)
       )
    ) as t 
    inner join historias.medicos as b on t.id_medico = b.id_medico
    inner join historias.entradas as c on t.id_historia = c.id_historia
    left join historias.hijos as d on d.id_hijo = b.id_hijo
    left join (select id_recibo, apel_nomb from historias.recibos) as e on e.id_recibo = t.id_recibo
    order by t.id_medico asc, t.id_historia asc
  ";

  //echo $sql;

$datosRecibos = json_decode($obj->seleccionar($sql, []), true);
$fecha = date("d-m-Y", strtotime($fecha));

//$datosRecibosAnulados = json_decode($obj->seleccionar("select * from historias.recibos where fecha = ?::date and status = 'B' and tipo_reci = 1", [$datosCierre['fecha']], true), true);

// echo "<pre>";
// print_r($datosRecibosAnulados);
// echo "</pre>";

/*Array
(
 [id_cierre] => 5
 [total_absoluto] => 141.00
 [totales_dividos] => [{"id_medico":5,"total_medico_sumado":"10.00","total_hijo_sumado":"10.00"},{"id_medico":1,"total_medico_sumado":"121.00","total_hijo_sumado":"0.00"}]
 [recibos] => [
        {
          "id_recibo":1,
          "id_historia":1,
          "total_absoluto":"150000.00",
          "total_medico":"150000.00",
          "total_hijo":"0.00",
          "subtotales":"[{\"id_moneda\":1,\"subtotal\":\"41\"}]",
          "id_moneda":3,
          "id_pago":1,
          "conversiones":"{\"1\":1,\"2\":4.56,\"3\":3700,\"4\":0.85}",
          "id_medico":1,
          "nume_reci":"138976",
          "no_reci":"0",
          "conceptos":"[{\"id_concepto\":23,\"nombre\":\"SUERO DE GLAUCOMA (E)\",\"monto_dolar\":30.00,\"monto_pesos\":150000.00}]",
          "porcentaje":"0.00",
          "fecha":"2021-11-20",
          "hora":"03:02:42",
          "tipo_reci":1,
          "informe":"",
          "status":"A"
        }
      ]
 [laser] => 10.00
 [estudios_especializados] => 0.00
 [honorarios_oftalmologia] => 0.00
 [honorarios_centro_clinico] => 12.00
 [deposito] => 0.00
 [fecha] => 2021-11-20
 [status] => D
 [conversion_bolivar] => 4.56
)*/

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

      #tabla-cierre tbody tr td{
        border: 1px solid black !important;
      }

      #tabla-cierre-cabecera {
        width:300px !important;
        color: #202020 !important;
        border-bottom: 1px solid #ccc !important;
        border-left: 1px dashed #ccc !important;
        font-size: 11px !important;
      }
</style>

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

  foreach ($datosRecibos as $r) {

    $subtotales = json_decode($r['subtotales'], true);

    foreach ($subtotales as $sub) {
    
      $totales[$sub['id_moneda']] = $totales[$sub['id_moneda']] + $sub['subtotal'];

    }
  }

  if(!$montos) {
    $vales = json_decode($datosCierre['vales'], true);
  }

  $datosCierre['fecha'] = date("d-m-Y", strtotime($datosCierre['fecha']));
?>

<?php if ($cierre == 1) { ?>
<page style="width:216mm" backtop="5mm" backbottom="5mm" backleft="5mm" backright="5mm">
  <div class="contenedor">

    <table style="width: 200mm; border: 1px solid #262626" id="tabla-cierre-cabecera">
      <tbody>
        <tr>
          <td style="width: 80mm; font-size: 16px; font-weight: bold; text-align: left">DIARIO M.E.</td>
          <td style="width: 114mm; font-size: 16px; font-weight: bold; text-align: center">FECHA: <?php echo $datosCierre['fecha'];?></td>
        </tr>
      </tbody>
    </table>

    <table style="border: 1px solid black; width: 200mm" id="tabla-cierre">
      <thead>
        <tr>
          <th style="width: 10mm; text-align: center; height: 7mm; vertical-align: middle; border: 1px dashed #262626">N°.HIST</th>
          <th style="max-width:70mm; width: 70mm; text-align: center; height: 7mm; vertical-align: middle; border: 1px dashed #262626">NOMBRE DEL PACIENTE</th>
          <th style="width: 13mm; text-align: center; height: 7mm; vertical-align: middle; border: 1px dashed #262626">MÉDICO</th>
          <th style="width: 10mm; text-align: center; height: 7mm; vertical-align: middle; border: 1px dashed #262626">US</th>
          <th style="width: 10mm; text-align: center; height: 7mm; vertical-align: middle; border: 1px dashed #262626">BOL</th>
          <th style="width: 15mm; text-align: center; height: 7mm; vertical-align: middle; border: 1px dashed #262626">PESOS</th>
          <th style="width: 10mm; text-align: center; height: 7mm; vertical-align: middle; border: 1px dashed #262626">EU</th>
          <th style="width: 10mm; text-align: center; height: 7mm; vertical-align: middle; border: 1px dashed #262626">EXO</th>
        </tr>
      </thead>
      <tbody>

        <?php 
          $tr = "";

          $exoneradoTotal = 0;
          foreach ($datosRecibos as $r) {

            // echo "<pre>";
            // print_r($r);
            // echo "</pre>";

            $exoneradoTotal = $exoneradoTotal + $r['exonerado'];

            $estructura = "
            <tr>
              <td style='text-align: center; font-size: 13px'>$r[id_historia]</td>
              <td style='max-width:70mm; width: 70mm; text-align: center; font-size: 13px'>$r[apel_nomb]</td>
              <td style='text-align: center; font-size: 13px'>$r[id_medico]</td>
            ";

            $subtotales = json_decode($r['subtotales'], true);
            $totalTr = array(
              1 => '',
              2 => '',
              3 => '',
              4 => '',
            );

            foreach ($subtotales as $e) {
              $totalTr[$e['id_moneda']] = $e['subtotal']; 
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
          <td style="font-size: 10px; font-weight: bold; text-align: center">SUBTOTAL:</td>
          <td></td>
          <td></td>
          <td style="font-size: 13px; font-weight: bold; text-align: center;"><?php echo $totales[1]?></td>
          <td style="font-size: 13px; font-weight: bold; text-align: center;"><?php echo $totales[2]?></td>
          <td style="font-size: 13px; font-weight: bold; text-align: center;"><?php echo $totales[3]?></td>
          <td style="font-size: 13px; font-weight: bold; text-align: center;"><?php echo $totales[4]?></td>
        </tr>

        <tr>
          <td style="font-size: 13px; font-weight: bold; text-align: center">ZELLE</td>
          <td></td>
          <td></td>
          <td style="font-size: 13px; font-weight: bold; text-align: center"> 
            <?php
              if (!!$montos) {
                echo $montos['zelle'];
                $totales[1] = $totales[1] - (float)$montos['zelle'];
              } else {
                echo $datosCierre['zelle'];
                $totales[1] = $totales[1] - (float)$datosCierre['zelle'];
              } 
            ?>
          </td>
          <td></td>
          <td style="font-size: 13px; font-weight: bold; text-align: center">
            
          </td>
          <td></td>
        </tr>

        <tr>
          <td style="font-size: 11px; font-weight: bold; text-align: center">BANCOL</td>
          <td></td>
          <td></td>
          <td style="font-size: 13px; font-weight: bold; text-align: center"> 
            
          </td>
          <td></td>
          <td style="font-size: 13px; font-weight: bold; text-align: center">
            <?php
              if (!!$montos) {
                echo $montos['bancolombia'];
                $totales[3] = $totales[3] - (float)$montos['bancolombia'];
              } else {
                echo $datosCierre['bancolombia'];
                $totales[3] = $totales[3] - (float)$datosCierre['bancolombia'];
              } 
            ?>
          </td>
          <td></td>
        </tr>

        <tr>
          <td style="font-size: 13px; font-weight: bold; text-align: center">VALES:</td>
          <td></td>
          <td></td>
          <td style="font-size: 13px; font-weight: bold; text-align: center">
            <?php
              if (!!$montos) {
                echo $montos['dolar'];
              } else {
                echo $vales['dolar'];
              } 
            ?>
          </td>
          <td style="font-size: 13px; font-weight: bold; text-align: center">
            <?php
              if (!!$montos) {
                echo $montos['bolivar'];
              } else {
                echo $vales['bolivar'];
              } 
            ?>
          </td>
          <td style="font-size: 13px; font-weight: bold; text-align: center">
            <?php
              if (!!$montos) {
                echo $montos['pesos'];
              } else {
                echo $vales['pesos'];
              } 
            ?>
          </td>
          <td style="font-size: 13px; font-weight: bold; text-align: center;">
            <?php
              if (!!$montos) {
                echo $montos['euro'];
              } else {
                echo $vales['euro'];
              } 
            ?>
          </td>
        </tr>

        <tr>
          <td style="font-size: 13px; font-weight: bold; text-align: center">TOTAL:</td>
          <td></td>
          <td></td>
          <td style="font-size: 13px; font-weight: bold; text-align: center; <?php if ($totales[1] < 0) {echo "color:red";}?>">
            <?php 
              if (!!$montos) {
                echo Number_format(($totales[1] - (float)$montos['dolar']), 2, ',', '.');
              } else {
                echo Number_format(($totales[1] - (float)$vales['dolar']), 2, ',', '.');
              } 
            ?>
          </td>
          <td style="font-size: 13px; font-weight: bold; text-align: center; <?php if ($totales[2] < 0) {echo "color:red";}?>">
            <?php 
              if (!!$montos) {
                echo Number_format(($totales[2] - (float)$montos['bolivar']), 2, ',', '.');
              } else {
                echo Number_format(($totales[2] - (float)$vales['bolivar']), 2, ',', '.');
              } 
            ?>
          </td>
          <td style="font-size: 13px; font-weight: bold; text-align: center; <?php if ($totales[3] < 0) {echo "color:red";}?>">
            <?php 
              if (!!$montos) {
                echo Number_format(($totales[3] - (float)$montos['pesos']), 2, ',', '.');
              } else {
                echo Number_format(($totales[3] - (float)$vales['pesos']), 2, ',', '.');
              } 
            ?>
          </td>
          <td style="font-size: 13px; font-weight: bold; text-align: center; <?php if ($totales[4] < 0) {echo "color:red";}?>">
            <?php 
              if (!!$montos) {
                echo Number_format(($totales[4] - (float)$montos['euro']), 2, ',', '.');
              } else {
                echo Number_format(($totales[4] - (float)$vales['euro']), 2, ',', '.');
              } 
            ?>
          </td>
          <td style="font-size: 13px; font-weight: bold; text-align: center; <?php if ($totales[4] < 0) {echo "color:red";}?>"><?php echo $exoneradoTotal?></td>
        </tr>

      </tbody>
    </table> 
  </div> 
</page>

<?php }; ?>

<?php 

  if ($general == 1) {

    $drpm = array(); //datos recibos por medico
    foreach ($datosRecibos as $r) {

      if ($r['tipo_reci'] == 1) {
        if (!array_key_exists($r['id_medico'], $drpm)) {
          $drpm[$r['id_medico']] = array();
        }

        array_push($drpm[$r['id_medico']], $r);
      }
      
    }

    if (array_key_exists('1', $drpm)) {
      if($montos !== false) {  
        //INSERTAR LOS VALORES DE ZELLE Y OTROS AQUI DESDE LA BASE DE DATOS

        $honorarios_oftalmologia = round((float)$montos['honorarios_oftalmologia'] * (float)$datosCierre['conversion_bolivar'], 2);

        $honorarios_centro_clinico = round((float)$montos['honorarios_centro_clinico'] * (float)$datosCierre['conversion_bolivar'], 2);

        $zelle = round((float)$montos['zelle'] * (float)$datosCierre['conversion_bolivar'], 2);

      } else {

        $honorarios_oftalmologia = round($datosCierre['honorarios_oftalmologia'] * (float)$datosCierre['conversion_bolivar'], 2);

        $honorarios_centro_clinico = round($datosCierre['honorarios_centro_clinico'] * (float)$datosCierre['conversion_bolivar'], 2);

        $zelle = round($datosCierre['zelle'] * (float)$datosCierre['conversion_bolivar'], 2);

      }

    } else {
      $honorarios_oftalmologia = 0;
      $honorarios_centro_clinico = 0;
      $zelle = 0;
    }

    $datosHijos = array();

    foreach ($drpm as $datosMedico) :

      $hijo = 0;
      $exonerado = 0;
      // echo "<pre>";
      // print_r($datosMedico);
      // echo "</pre>";

      $totalesInformeMedico = array(
        "C" => 0, "E" => 0, "O" => 0
      );

      $totalesInformeHijo = array(
        "C" => 0, "E" => 0, "O" => 0
      );

      foreach ($datosMedico as $recibos) {

        $nomb_medi = $recibos['nomb_medi'];
        $nomb_hijo = $recibos['nomb_hijo'];

        $id_hijo = $recibos['id_hijo'];


        $conversiones = json_decode($recibos['conversiones'], true);
        $conceptos = json_decode($recibos['conceptos_abrevituras'], true);

        //print_r($conversiones);

        $porcentajeMedico = 100 - $recibos['porcentaje'];
        $porcentajeHijo = $recibos['porcentaje'];

        $exonerado = (float)$recibos['exonerado'] + $exonerado;
        
        //CARGA LA INFORMACION DE LOS HIJOS EN UN UNICO GRUPO QUE DESPUES SE GENERARA POR SEPARADO
        if (!isset($datosHijos[$id_hijo])) {

          $datosHijos[$id_hijo] = array(

              "nombre" => $nomb_hijo,
              "C" => 0,
              "E" => 0,
              "O" => 0,
              "exonerado" => array(0 => 0, 1 => 0)

          );

        };  

        if ($id_hijo == 0) {

          foreach ($conceptos as $c) {

            if(isset($c['cantidad'])) {$cantidadMultiplicar = $c['cantidad'];} else {$cantidadMultiplicar = 1;}

            //echo round(($totalesInformeMedico[$c['grupos']] + ((float)$c['monto_dolar'] * $cantidadMultiplicar) / $conversiones[2]), 2).'---';

            $totalesInformeMedico[$c['grupos']] = $totalesInformeMedico[$c['grupos']] + ((float)$c['monto_dolar'] * $cantidadMultiplicar * $conversiones[2]); 
          }

        } else {

          foreach ($conceptos as $c) {

            if(isset($c['cantidad'])) {$cantidadMultiplicar = $c['cantidad'];} else {$cantidadMultiplicar = 1;}

            $totalesInformeMedico[$c['grupos']] = $totalesInformeMedico[$c['grupos']] + ((float)$c['monto_dolar'] * $cantidadMultiplicar) * $conversiones[2]; 
          }

          $totalesInformeHijo = $totalesInformeMedico;

        }
      }

      $totalesInformeMedico['C'] = round(($totalesInformeMedico['C'] * $porcentajeMedico / 100), 2);
      $totalesInformeMedico['E'] = round(($totalesInformeMedico['E'] * $porcentajeMedico / 100), 2);
      $totalesInformeMedico['O'] = round(($totalesInformeMedico['O'] * $porcentajeMedico / 100), 2);

      $totalTempHijo1 = ($totalesInformeHijo['C'] * $porcentajeHijo / 100);
      $totalTempHijo2 = ($totalesInformeHijo['E'] * $porcentajeHijo / 100);
      $totalTempHijo3 = ($totalesInformeHijo['O'] * $porcentajeHijo / 100);

      $totalesInformeHijo['C'] = round(($totalesInformeHijo['C'] * $porcentajeHijo / 100), 2);
      $totalesInformeHijo['E'] = round(($totalesInformeHijo['E'] * $porcentajeHijo / 100), 2);
      $totalesInformeHijo['O'] = round(($totalesInformeHijo['O'] * $porcentajeHijo / 100), 2);

      if($id_hijo == 0) {

        $exonerado = round($exonerado * (float)$conversiones[2], 2);
      } else {

        $exoneradoTemp = array(
          0 => ($exonerado * $porcentajeMedico / 100) * (float)$conversiones[2], 2,
          1 => ($exonerado * $porcentajeHijo / 100) * (float)$conversiones[2], 2
        );

        $exonerado = array(
            0 => round(($exonerado * $porcentajeMedico / 100) * (float)$conversiones[2], 2),
            1 => round(($exonerado * $porcentajeHijo / 100) * (float)$conversiones[2], 2)
        );

        $datosHijos[$id_hijo]['C'] = $datosHijos[$id_hijo]['C'] + $totalTempHijo1;
        $datosHijos[$id_hijo]['E'] = $datosHijos[$id_hijo]['E'] + $totalTempHijo2;
        $datosHijos[$id_hijo]['O'] = $datosHijos[$id_hijo]['O'] + $totalTempHijo3;

        $datosHijos[$id_hijo]['exonerado'][0] = $datosHijos[$id_hijo]['exonerado'][0] + $exoneradoTemp[0];
        $datosHijos[$id_hijo]['exonerado'][1] = $datosHijos[$id_hijo]['exonerado'][1] + $exoneradoTemp[1];
      }

      //-------------------------------------------------------------------------
      //SI NO TIENE HIJO
      //-------------------------------------------------------------------------

      if ($id_hijo == 0) {
      ?>
        <page style="width: 200mm" backtop="5mm" backbottom="5mm" backleft="5mm" backright="5mm">
          <div class="contenedor">
            <div id="cabecera" style="height: 90px; magin-bottom: 5px">
              <div style="position:relative;">
                <h3 style="margin-top: 35px; width: 200mm; text-align: center; font-weight: bold; font-size: 20px;"><?php echo $nomb_medi?></h3>
              </div>
            </div> 

            <div style="position: absolute;  top: 5mm; left: 0mm">
               <img src="../imagenes/logo_reportes.jpg" style="width: 30mm; height: 23mm;">
            </div>

            <div class="separador" id="separador"></div>

            <div id="subcabecera" class="centrar" style="font-size: 16px">
              <?php echo $datosCierre['fecha']?>
            </div>

            <div class="separador" id="separador"></div>
            <table style="margin-bottom: 5mm; border:none">
              <tbody>
                <tr>
                  <td style="width: 157mm; text-align: center;"><div style="font-size: 16px; width:fit-content; border-bottom: 2px dashed #ccc">INFORME DIARIO</div></td>
                </tr>
              </tbody>
            </table>  

            <table style="border:none; text-align: center; width: 170mm; top: -15px; position: relative; margin-left: 125px;">
              <thead >
                <tr>
                  <th style="width: 60mm; text-align: center; height: 3mm; border-bottom: 1px solid #ccc; vertical-align: middle;">OPERACIÓN</th>
                  <th style="width: 60mm; text-align: center; height: 3mm; border-bottom: 1px solid #ccc; vertical-align: middle;">MONTO (BS)</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="width: 60mm; text-align: center; height: 4mm; vertical-align: middle;">CONSULTAS........................................:</td>
                  <td style="width: 60mm; text-align: center; height: 4mm; vertical-align: middle;"><?php echo Number_format($totalesInformeMedico['C'], 2, ',', '.')?></td>
                </tr>

                <tr>
                  <td style="width: 60mm; text-align: center; height: 4mm; vertical-align: middle;">OTROS:.................................................:</td>
                  <td style="width: 60mm; text-align: center; height: 4mm; vertical-align: middle;"><?php echo Number_format($totalesInformeMedico['O'], 2, ',', '.')?></td>
                </tr>

                <tr>
                  <td style="width: 60mm; text-align: center; height: 4mm; vertical-align: middle;">ESTUDIOS ESPECIALIZADOS............:</td>
                  <td style="width: 60mm; text-align: center; height: 4mm; vertical-align: middle;"><?php echo Number_format($totalesInformeMedico['E'], 2, ',', '.')?></td>
                </tr>

                <tr>
                  <td style="width: 60mm; text-align: center; height: 4mm; vertical-align: middle;">HONORARIOS C. OFTALMOLÓGICA.:</td>
                  <td style="width: 60mm; text-align: center; height: 4mm; vertical-align: middle;"><?php echo Number_format($honorarios_oftalmologia, 2, ',', '.')?></td>
                </tr> 

                <tr>
                  <td style="width: 60mm; text-align: center; height: 4mm; vertical-align: middle;">HONORARIOS CENTRO CLÍNICO SC:</td>
                  <td style="width: 60mm; text-align: center; height: 4mm; vertical-align: middle;"><?php echo Number_format($honorarios_centro_clinico, 2, ',', '.')?></td>
                </tr>

                <tr>
                  <td style="width: 60mm; text-align: center; height: 4mm; vertical-align: middle;">EXONERADO........................................:</td>
                  <td style="width: 60mm; text-align: center; height: 4mm; vertical-align: middle;"><?php echo Number_format($exonerado, 2, ',', '.')?></td>
                </tr>

              </tbody>    
            </table>  

            <div class="separador" style="margin-top: 0px; margin-bottom: 0px;"></div>
            <div style="width: 142mm; height: fit-content; font-size: 15px; text-align: right; font-weight: bold">
              Bs:
              <?php echo 
                Number_format(($totalesInformeMedico['C'] +
                $totalesInformeMedico['O'] +
                $totalesInformeMedico['E'] +
                $honorarios_oftalmologia +
                $honorarios_centro_clinico -
                $exonerado), 2, ',', '.'); 
              ?>
            </div>
            <div class="separador" style="margin: 0px"></div>
            <!-- <div style="width: 157mm; text-align: left; font-weight: bold; font-size: 14px;"><?php echo $recibos['nomb_medi']?></div> -->

          </div>  
        </page>

      <!-----------------------------------------------------------------------------
      //SI TIENE HIJO
      //---------------------------------------------------------------------------->

      <?php } else { ?>

        <page style="width: 200mm" backtop="5mm" backbottom="5mm" backleft="5mm" backright="5mm">
          <div class="contenedor">
            <div id="cabecera" style="height: 90px; magin-bottom: 5px">
              <div style="position:relative;">
              <h3 style="margin-top: 35px; width: 200mm; text-align: center; font-weight: bold; font-size: 20px;"><?php echo $nomb_medi?></h3>
            </div> 
            </div> 

            <div style="position: absolute;  top: 5mm; left: 0mm">
               <img src="../imagenes/logo_reportes.jpg" style="width: 30mm; height: 23mm;">
            </div>

            <div class="separador" id="separador"></div>

            <div id="subcabecera" class="centrar" style="font-size: 16px">
              <?php echo $datosCierre['fecha']?>
            </div>

            <div class="separador" id="separador"></div>
            <table style="margin-bottom: 5mm; border:none">
              <tbody>
                <tr>
                  <td style="width: 157mm; text-align: center;"><div style="font-size: 16px; width:fit-content; border-bottom: 2px dashed #ccc">INFORME DIARIO</div></td>
                </tr>
              </tbody>
            </table>  

            <table style="border:none; text-align: center; width: 170mm; top: -15px; position: relative; margin-left: 125px;">
              <thead >
                <tr>
                  <th style="width: 60mm; text-align: center; height: 3mm; border-bottom: 1px solid #ccc; vertical-align: middle;">OPERACIÓN</th>
                  <th style="width: 60mm; text-align: center; height: 3mm; border-bottom: 1px solid #ccc; vertical-align: middle;">MONTO (BS)</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td style="width: 60mm; text-align: center; height: 4mm; vertical-align: middle;">CONSULTAS........................................:</td>
                  <td style="width: 60mm; text-align: center; height: 4mm; vertical-align: middle;"><?php echo Number_format($totalesInformeMedico['C'], 2, ',', '.')?></td>
                </tr>

                <tr>
                  <td style="width: 60mm; text-align: center; height: 4mm; vertical-align: middle;">OTROS:.................................................:</td>
                  <td style="width: 60mm; text-align: center; height: 4mm; vertical-align: middle;"><?php echo Number_format($totalesInformeMedico['O'], 2, ',', '.')?></td>
                </tr>

                <tr>
                  <td style="width: 60mm; text-align: center; height: 4mm; vertical-align: middle;">ESTUDIOS ESPECIALIZADOS............:</td>
                  <td style="width: 60mm; text-align: center; height: 4mm; vertical-align: middle;"><?php echo Number_format($totalesInformeMedico['E'], 2, ',', '.')?></td>
                </tr>

                <tr>
                  <td style="width: 60mm; text-align: center; height: 4mm; vertical-align: middle;">EXONERADO........................................:</td>
                  <td style="width: 60mm; text-align: center; height: 4mm; vertical-align: middle;"><?php echo Number_format($exonerado[0], 2, ',', '.')?></td>
                </tr> 
              </tbody>    
            </table>

            <div class="separador" style="margin-top: 0px; margin-bottom: 0px;"></div>
            <div style="width: 142mm; height: fit-content; font-size: 15px; text-align: right; font-weight: bold">
              Bs:
              <?php echo 
                Number_format(($totalesInformeMedico['C'] +
                $totalesInformeMedico['O'] +
                $totalesInformeMedico['E'] -
                $exonerado[0]), 2, ',', '.'); 
              ?>
            </div>
            <div class="separador" style="margin: 0px"></div>
            <!--<div style="width: 157mm; text-align: left; font-weight: bold; font-size: 14px;"><?php echo $recibos['nomb_medi']?></div> -->

          </div>

        </page>

<?php 
    } 
?>

<?php 
    
  endforeach;

  // echo "<pre>";
  // print_r($datosHijos);
  // echo "</pre>";

  foreach ($datosHijos as $llave => $hijo) {
    
    if ($llave != 0) {

  ?>

    <page style="width: 200mm" backtop="5mm" backbottom="5mm" backleft="5mm" backright="5mm">

      <div class="contenedor">
        <div id="cabecera" style="height: 90px; magin-bottom: 5px">
          <div style="position:relative;">
          <h3 style="margin-top: 35px; width: 200mm; text-align: center; font-weight: bold; font-size: 20px;"><?php echo $hijo['nombre']?></h3>
        </div> 
        </div> 

        <div style="position: absolute;  top: 5mm; left: 0mm">
           <img src="../imagenes/logo_reportes.jpg" style="width: 30mm; height: 23mm;">
        </div>

        <div class="separador" id="separador"></div>

        <div id="subcabecera" class="centrar" style="font-size: 16px">
          <?php echo $datosCierre['fecha']?>
        </div>

        <div class="separador" id="separador"></div>
        <table style="margin-bottom: 5mm; border:none">
          <tbody>
            <tr>
              <td style="width: 157mm; text-align: center;"><div style="font-size: 16px; width:fit-content; border-bottom: 2px dashed #ccc">INFORME DIARIO</div></td>
            </tr>
          </tbody>
        </table>  

        <table style="border:none; text-align: center; width: 170mm; top: -15px; position: relative; margin-left: 125px;">
          <thead >
            <tr>
              <th style="width: 60mm; text-align: center; height: 3mm; border-bottom: 1px solid #ccc; vertical-align: middle;">OPERACIÓN</th>
              <th style="width: 60mm; text-align: center; height: 3mm; border-bottom: 1px solid #ccc; vertical-align: middle;">MONTO (BS)</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td style="width: 60mm; text-align: center; height: 4mm; vertical-align: middle;">CONSULTAS........................................:</td>
              <td style="width: 60mm; text-align: center; height: 4mm; vertical-align: middle;"><?php echo Number_format($hijo['C'], 2, ',', '.')?></td>
            </tr>

            <tr>
              <td style="width: 60mm; text-align: center; height: 4mm; vertical-align: middle;">OTROS:.................................................:</td>
              <td style="width: 60mm; text-align: center; height: 4mm; vertical-align: middle;"><?php echo Number_format($hijo['O'], 2, ',', '.')?></td>
            </tr>

            <tr>
              <td style="width: 60mm; text-align: center; height: 4mm; vertical-align: middle;">ESTUDIOS ESPECIALIZADOS............:</td>
              <td style="width: 60mm; text-align: center; height: 4mm; vertical-align: middle;"><?php echo Number_format($hijo['E'], 2, ',', '.')?></td>
            </tr>

            <tr>
              <td style="width: 60mm; text-align: center; height: 4mm; vertical-align: middle;">EXONERADO........................................:</td>
              <td style="width: 60mm; text-align: center; height: 4mm; vertical-align: middle;"><?php echo Number_format($hijo['exonerado'][1], 2, ',', '.')?></td>
            </tr> 
          </tbody>    
        </table>

        <div class="separador" style="margin-top: 0px; margin-bottom: 0px;"></div>

        <div style="width: 142mm; height: fit-content; font-size: 15px; text-align: right; font-weight: bold">
          Bs:
          <?php echo 
            Number_format(($hijo['C'] +
            $hijo['O'] +
            $hijo['E'] -
            $hijo['exonerado'][0]), 2, ',', '.'); 
          ?>
        </div>

        <div class="separador" style="margin: 0px"></div>
        
      </div>

    </page>
<?php
    }

  }

 }

?>

<?php 
 if($individuos == 1) {
    $drpm = array(); //datos recibos por medico
    //echo "<pre>";
    //print_r($datosRecibos);
    //echo "</pre>";
    foreach ($datosRecibos as $r) {

      if($r['tipo_reci'] == 1) { 
        if (!array_key_exists($r['id_medico'], $drpm)) {
          $drpm[$r['id_medico']] = array();
        }

        array_push($drpm[$r['id_medico']], $r);
      }
    }

    //informe diario
    // echo "<pre>";
    // print_r($drpm);
    // echo "</pre>";

    foreach ($drpm as $datosMedico) :

      $hijo = 0;
      $exonerado = 0;
      // echo "<pre>";
      // print_r($datosMedico);
      // echo "</pre>";

      $totales = array(
        "medico" => 0,
        "hijo" => 0
      );

      foreach ($datosMedico as $recibos) {

        $hijo = $recibos['id_hijo'];
        $nomb_medi = $recibos['nomb_medi'];
        $nomb_hijo = $recibos['nomb_hijo'];

        $porcentajeMedico = 100 - $recibos['porcentaje'];
        $porcentajeHijo = $recibos['porcentaje'];

        //$exonerado = (float)$recibos['exonerado'] + $exonerado;

        //echo "<pre>";
        //print_r($conversiones);
        //echo "</pre>";

        $totales['medico'] = ($totales['medico'] + $recibos['total_medico_dolar']) - (float)$exonerado;
        $totales['hijo'] = ($totales['hijo'] + $recibos['total_hijo_dolar']) - (float)$exonerado;

      }

      // print_r($totales);

    if ($hijo == 0) { //medico   
?>
      <page style="width: 200mm" backtop="5mm" backbottom="5mm" backleft="5mm" backright="5mm">
        <div class="contenedor">
          <div id="cabecera" style="height: 90px; magin-bottom: 5px">
            <div style="position:relative;">
              <h3 style="margin-top: 35px; width: 200mm; text-align: center; font-weight: bold; font-size: 20px;"><?php echo $nomb_medi?></h3>
            </div> 
          </div> 

          <div style="position: absolute;  top: 5mm; left: 0mm">
             <img src="../imagenes/logo_reportes.jpg" style="width: 30mm; height: 23mm;">
          </div>

          <div class="separador" id="separador"></div>  

          <table style="border:none; text-align: center; width: 200mm; top: -15px; position: relative;">
            <thead>
              <tr>
                <th style="width: 15mm; text-align: center; height: 3mm; border-bottom: 1px solid #ccc; vertical-align: middle;">N° HIST</th>
                <th style="width: 50mm; text-align: center; height: 3mm; border-bottom: 1px solid #ccc; vertical-align: middle;">PACIENTES</th>
                <th style="width: 25mm; text-align: center; height: 3mm; border-bottom: 1px solid #ccc; vertical-align: middle;">MONTOS (BS)</th>
                <th style="width: 10mm; text-align: center; height: 3mm; border-bottom: 1px solid #ccc; vertical-align: middle;">CANTIDAD</th>
                <th style="width: 30mm; text-align: center; height: 3mm; border-bottom: 1px solid #ccc; vertical-align: middle;">CONCEPTOS</th>
                <th style="width: 10mm; text-align: center; height: 3mm; border-bottom: 1px solid #ccc; vertical-align: middle;">HORAS</th>
                <th style="width: 25mm; text-align: center; height: 3mm; border-bottom: 1px solid #ccc; vertical-align: middle;">N° RECIBO</th>
              </tr>
            </thead>
            <tbody>
<?php 

          $totalFinal = 0;

          foreach ($datosMedico as $recibos) {

            $conversiones = json_decode($recibos['conversiones'], true);
            $conceptos = json_decode($recibos['conceptos_abrevituras'], true); 

            //echo (float)$conversiones[2];

            $conceptosLength = count($conceptos); 

            $porcentajeMedico = 100 - $recibos['porcentaje'];
            $porcentajeHijo = $recibos['porcentaje'];
            $exonerado = Number_format(($recibos['exonerado'] * $porcentajeMedico / 100 * (float)$conversiones[2]), 2, ',', '.');
            $totalConcepto = 0;

            $tabla = "<tr style='border-top: 1px dashed #909090'>";
            $tabla .= "
              <th style='border-top: 1px dashed #909090'>$recibos[id_historia]</th>
              <th style='width: 50mm;border-top: 1px dashed #909090'>$recibos[apel_nomb]</th>
              <th style='border-top: 1px dashed #909090'></th>
              <th style='border-top: 1px dashed #909090'></th>
              <th style='border-top: 1px dashed #909090'></th>
              <th style='border-top: 1px dashed #909090'>$recibos[hora]</th>
              <th style='border-top: 1px dashed #909090'>$recibos[nume_reci]</th>
            ";
            $tabla .= "</tr>";

            for ($i = 0; $i < $conceptosLength; $i++) { 
              if(isset($conceptos[$i])) {
                $monto = number_format(round((($conceptos[$i]['monto_dolar'] * $porcentajeMedico / 100 * (float)$conversiones[2])), 2), 2, ',', '.');

                $totalConcepto = $totalConcepto + round((($conceptos[$i]['monto_dolar'] * $porcentajeMedico / 100 * (float)$conversiones[2]) * $conceptos[$i]['cantidad']), 2);
                
                $abrev = $conceptos[$i]['abreviatura'];
                $cantidad = $conceptos[$i]['cantidad'];

                if($i == 0) {
                  $primero = 'Subtotales';
                } else {
                  $primero = '';
                }

                $tabla .= "
                <tr>
                  <th></th>
                  <th>$primero</th>
                  <th>$monto</th>
                  <th>$cantidad</th>
                  <th>$abrev</th>
                  <th></th>
                </tr>
                ";
              }
            }

            $tabla .= "<tr>";
            $tabla .= "
              <th></th>
              <th>Exonerado</th>
              <th>$exonerado</th>
              <th></th>
              <th></th>
            ";
            $tabla .= "</tr>";

            $tabla .= "<tr>";
            $tabla .= "
              <th></th>
              <th>Total consulta</th>
              <th>".Number_format($totalConcepto, 2, ',', '.')."</th>
              <th></th>
              <th></th>
            ";
            $tabla .= "</tr>";

            $totalFinal = $totalFinal + $totalConcepto;

            echo $tabla;
          }
?>  
            </tbody>
          </table>

          <div class="separador" style="margin-top: 0px; margin-bottom: 0px;"></div>
          <div style="width: 200mm; height: fit-content; font-size: 15px; text-align: right; font-weight: bold">
            Total general Bs....:<?php
              echo Number_format($totalFinal, 2, ',', '.');
              //echo round(($totales['medico'] * $porcentajeMedico / 100) * (float)$datosCierre['conversion_bolivar'], 2);?>
          </div>
          <div style="width: 200mm; height: fit-content; font-size: 15px; text-align: right; font-weight: bold">
            Fecha: <?php echo $datosCierre['fecha']?>
          </div>
          <div class="separador" style="margin: 0px"></div>
          

          </div> 
        </page>
<?php 
    } else { //medico-hijo
?>

      <!--medico-->
      <page style="width: 200mm" backtop="5mm" backbottom="5mm" backleft="5mm" backright="5mm">
        <div class="contenedor">
          <div id="cabecera" style="height: 90px; magin-bottom: 5px">
            <div style="position:relative;">
              <h3 style="margin-top: 35px; width: 200mm; text-align: center; font-weight: bold; font-size: 20px;"><?php echo $nomb_medi?></h3>
            </div> 
          </div> 

          <div style="position: absolute;  top: 5mm; left: 0mm">
             <img src="../imagenes/logo_reportes.jpg" style="width: 30mm; height: 23mm;">
          </div>

          <div class="separador" id="separador"></div>  

          <table style="border:none; text-align: center; width: 200mm; top: -15px; position: relative;">
            <thead>
              <tr>
                <th style="width: 15mm; text-align: center; height: 3mm; border-bottom: 1px solid #ccc; vertical-align: middle;">N° HIST</th>
                <th style="width: 50mm; text-align: center; height: 3mm; border-bottom: 1px solid #ccc; vertical-align: middle;">PACIENTES</th>
                <th style="width: 25mm; text-align: center; height: 3mm; border-bottom: 1px solid #ccc; vertical-align: middle;">MONTOS (BS)</th>
                <th style="width: 10mm; text-align: center; height: 3mm; border-bottom: 1px solid #ccc; vertical-align: middle;">CANTIDAD</th>
                <th style="width: 30mm; text-align: center; height: 3mm; border-bottom: 1px solid #ccc; vertical-align: middle;">CONCEPTOS</th>
                <th style="width: 10mm; text-align: center; height: 3mm; border-bottom: 1px solid #ccc; vertical-align: middle;">HORAS</th>
                <th style="width: 25mm; text-align: center; height: 3mm; border-bottom: 1px solid #ccc; vertical-align: middle;">N° RECIBO</th>
              </tr>
            </thead>
            <tbody>
            <?php 

              $totalFinal = 0;
          
              foreach ($datosMedico as $recibos) {

                $conceptos = json_decode($recibos['conceptos_abrevituras'], true); 
                $conversiones = json_decode($recibos['conversiones'], true);
                //print_r($recibos);

                $conceptosLength = count($conceptos); 

                $porcentajeMedico = 100 - $recibos['porcentaje'];
                $porcentajeHijo = $recibos['porcentaje'];
                $exonerado = Number_format(($recibos['exonerado'] * $porcentajeMedico / 100 * (float)$conversiones[2]), 2, ',', '.');
                $totalConcepto = round($recibos['total_medico_dolar'] * (float)$conversiones[2], 2);

                $totalConcepto = 0;

                $tabla = "<tr style='border-top: 1px dashed #909090'>";
                $tabla .= "
                  <th style='border-top: 1px dashed #909090'>$recibos[id_historia]</th>
                  <th style='width: 50mm;border-top: 1px dashed #909090'>$recibos[apel_nomb]</th>
                  <th style='width: 25mm;border-top: 1px dashed #909090'></th>
                  <th style='border-top: 1px dashed #909090'></th>
                  <th style='border-top: 1px dashed #909090'></th>
                  <th style='border-top: 1px dashed #909090'>$recibos[hora]</th>
                  <th style='border-top: 1px dashed #909090'>$recibos[nume_reci]</th>
                ";
                $tabla .= "</tr>";

                for ($i = 0; $i < $conceptosLength; $i++) { 
                  if(isset($conceptos[$i])) {

                    $monto = number_format(round((($conceptos[$i]['monto_dolar'] * $porcentajeMedico / 100 * (float)$conversiones[2])), 2), 2, ',', '.');

                    $totalConcepto = $totalConcepto + round((($conceptos[$i]['monto_dolar'] * $porcentajeMedico / 100 * (float)$conversiones[2]) * $conceptos[$i]['cantidad']), 2);
                    
                    $abrev = $conceptos[$i]['abreviatura'];
                    $cantidad = $conceptos[$i]['cantidad'];

                    if($i == 0) {
                      $primero = 'Subtotales';
                    } else {
                      $primero = '';
                    }

                    $tabla .= "
                    <tr>
                      <th></th>
                      <th>$primero</th>
                      <th>$monto</th>
                      <th>$cantidad</th>
                      <th>$abrev</th>
                      <th></th>
                    </tr>
                    ";
                  }
                }

                $tabla .= "<tr>";
                $tabla .= "
                  <th></th>
                  <th>Exonerado</th>
                  <th>$exonerado</th>
                  <th></th>
                  <th></th>
                ";
                $tabla .= "</tr>";

                $tabla .= "<tr>";
                $tabla .= "
                  <th></th>
                  <th>Total consulta</th>
                  <th>".Number_format($totalConcepto, 2, ',', '.')."</th>
                  <th></th>
                  <th></th>
                ";

                $totalFinal = $totalFinal + $totalConcepto;

                $tabla .= "</tr>";

                echo $tabla;
              }
            ?>  
            </tbody>
          </table>

          <div class="separador" style="margin-top: 0px; margin-bottom: 0px;"></div>
          <div style="width: 200mm; height: fit-content; font-size: 15px; text-align: right; font-weight: bold">
            Total general Bs....:<?php
              echo Number_format($totalFinal, 2, ',', '.');
              //echo round($totales['medico'] * (float)$datosCierre['conversion_bolivar'], 2);?>
          </div>
          <div style="width: 200mm; height: fit-content; font-size: 15px; text-align: right; font-weight: bold">
            Fecha: <?php echo $datosCierre['fecha']?>
          </div>
          <div class="separador" style="margin: 0px"></div>

          </div> 
        </page>

      <!--hijo-->
      <page style="width: 200mm" backtop="5mm" backbottom="5mm" backleft="5mm" backright="5mm">
        <div class="contenedor">
          <div id="cabecera" style="height: 90px; magin-bottom: 5px">
            <div style="position:relative;">
              <h3 style="margin-top: 35px; width: 200mm; text-align: center; font-weight: bold; font-size: 20px;"><?php echo $nomb_hijo?></h3>
            </div> 
          </div> 

          <div style="position: absolute;  top: 5mm; left: 0mm">
             <img src="../imagenes/logo_reportes.jpg" style="width: 30mm; height: 23mm;">
          </div>

          <div class="separador" id="separador"></div>  

          <table style="border:none; text-align: center; width: 200mm; top: -15px; position: relative;">
            <thead>
              <tr>
                <th style="width: 15mm; text-align: center; height: 3mm; border-bottom: 1px solid #ccc; vertical-align: middle;">N° HIST</th>
                <th style="width: 50mm; text-align: center; height: 3mm; border-bottom: 1px solid #ccc; vertical-align: middle;">PACIENTES</th>
                <th style="width: 25mm; text-align: center; height: 3mm; border-bottom: 1px solid #ccc; vertical-align: middle;">MONTOS (BS)</th>
                <th style="width: 10mm; text-align: center; height: 3mm; border-bottom: 1px solid #ccc; vertical-align: middle;">CANTIDAD</th>
                <th style="width: 30mm; text-align: center; height: 3mm; border-bottom: 1px solid #ccc; vertical-align: middle;">CONCEPTOS</th>
                <th style="width: 10mm; text-align: center; height: 3mm; border-bottom: 1px solid #ccc; vertical-align: middle;">HORAS</th>
                <th style="width: 25mm; text-align: center; height: 3mm; border-bottom: 1px solid #ccc; vertical-align: middle;">N° RECIBO</th>
              </tr>
            </thead>
            <tbody>
            <?php 

            $totalFinal = 0;

              foreach ($datosMedico as $recibos) {

                $conceptos = json_decode($recibos['conceptos_abrevituras'], true); 
                $conversiones = json_decode($recibos['conversiones'], true);
                //print_r($recibos);

                $conceptosLength = count($conceptos); 

                $porcentajeMedico = 100 - $recibos['porcentaje'];
                $porcentajeHijo = $recibos['porcentaje'];
                $exonerado = Number_format(($recibos['exonerado'] * $porcentajeHijo / 100 * (float)$conversiones[2]), 2, ',', '.');
                $totalConcepto = round($recibos['total_hijo_dolar'] * (float)$conversiones[2], 2);

                $totalConcepto = 0;

                $tabla = "<tr style='border-top: 1px dashed #909090'>";
                $tabla .= "
                  <th style='border-top: 1px dashed #909090'>$recibos[id_historia]</th>
                  <th style='width: 50mm;border-top: 1px dashed #909090'>$recibos[apel_nomb]</th>
                  <th style='width: 25mm;border-top: 1px dashed #909090'></th>
                  <th style='border-top: 1px dashed #909090'></th>
                  <th style='border-top: 1px dashed #909090'></th>
                  <th style='border-top: 1px dashed #909090'>$recibos[hora]</th>
                  <th style='border-top: 1px dashed #909090'>$recibos[h_nume_reci]</th>
                ";
                $tabla .= "</tr>";

                for ($i = 0; $i < $conceptosLength; $i++) { 
                  if(isset($conceptos[$i])) {

                    $monto = number_format(round((($conceptos[$i]['monto_dolar'] * $porcentajeHijo / 100 * (float)$conversiones[2])), 2), 2, ',', '.');

                    $totalConcepto = $totalConcepto + round((($conceptos[$i]['monto_dolar'] * $porcentajeHijo / 100 * (float)$conversiones[2]) * $conceptos[$i]['cantidad']), 2);
                    
                    $abrev = $conceptos[$i]['abreviatura'];
                    $cantidad = $conceptos[$i]['cantidad'];

                    if($i == 0) {
                      $primero = 'Subtotales';
                    } else {
                      $primero = '';
                    }

                    $tabla .= "
                    <tr>
                      <th></th>
                      <th>$primero</th>
                      <th>$monto</th>
                      <th>$cantidad</th>
                      <th>$abrev</th>
                      <th></th>
                    </tr>
                    ";
                  }
                }

                $tabla .= "<tr>";
                $tabla .= "
                  <th></th>
                  <th>Exonerado</th>
                  <th>$exonerado</th>
                  <th></th>
                  <th></th>
                ";
                $tabla .= "</tr>";

                $tabla .= "<tr>";
                $tabla .= "
                  <th></th>
                  <th>Total consulta</th>
                  <th>".Number_format($totalConcepto, 2, ',', '.')."</th>
                  <th></th>
                  <th></th>
                ";

                $totalFinal = $totalFinal + $totalConcepto;

                $tabla .= "</tr>";

                echo $tabla;
              }
            ?>  
            </tbody>
          </table>

          <div class="separador" style="margin-top: 0px; margin-bottom: 0px;"></div>
          <div style="width: 200mm; height: fit-content; font-size: 15px; text-align: right; font-weight: bold">
            Total general Bs....:<?php
              echo Number_format($totalFinal, 2, ',', '.');
              //echo round($totales['hijo'] * (float)$datosCierre['conversion_bolivar'], 2);?>
          </div>
          <div style="width: 200mm; height: fit-content; font-size: 15px; text-align: right; font-weight: bold">
            Fecha: <?php echo $datosCierre['fecha']?>
          </div>
          <div class="separador" style="margin: 0px"></div>
          
          </div> 
        </page> 


<?php
      }
    endforeach;
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
        $width_in_mm = 216;
        $height_in_mm = 280;
        $html2pdf = new HTML2PDF('P', array($width_in_mm,$height_in_mm), 'en', true, 'UTF-8', array(0, 0, 0, 0));
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));

        $id = 0;
        $hora   = $obj->fechaHora('America/Caracas','H-i-s');
        $obj->fechaHora('America/Caracas','d-m-Y');
        //$nombre = $datos[6].'-'.$dia.'-'.$hora;
        $nombre = 'patata';

        if ($pdf == 1) {
          $html2pdf->output("../reportes/cierres_caja/cierre_caja$nombre.pdf", "f");
        } else if ($pdf == 2) {
          $html2pdf->Output("../reportes/cierres_caja/cierre_caja$nombre.pdf");
        } else {  
          $html2pdf->Output("../reportes/cierres_caja/cierre_caja$nombre.pdf");
          $html2pdf->output("../reportes/cierres_caja/cierre_caja$nombre.pdf", "f");
        }
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
  }
?>