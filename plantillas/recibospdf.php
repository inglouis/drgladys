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

  if (isset($_REQUEST['solo'])) {
    $solo = $_REQUEST['solo'];
  } else {
    $solo = '';
  }

  if(isset($_REQUEST['modo'])) {

    $modo = $_REQUEST['modo'];

    if ($modo == 'previa') {
      $id_recibo = (int)$_REQUEST['id'];
      $datos = json_decode($obj->seleccionar("
        select 
            a.*, b.nomb_medi, b.id_hijo, c.nomb_hijo, TO_CHAR(a.fecha :: DATE, 'dd-mm-yyyy') as fecha_arreglada, a.exonerado, d.apel_nomb as apel_nomb_hist, d.nume_cedu as nume_cedu_hist
          from historias.recibos_temporales as a 
          inner join historias.medicos as b using (id_medico)
          left join historias.hijos as c using (id_hijo)
          inner join historias.entradas as d using(id_historia)
          where a.id_recibo = ?", [$id_recibo]), true)[0];
      //eliminar

      $conceptos = $obj->e_pdo("
          select 
              dp.id_concepto, dp.nombre, kit.cantidad, kit.monto_dolar, kit.monto_pesos, kit.porcentaje
          from historias.conceptos dp
          inner join (
            SELECT 
              x.*
            from historias.recibos_temporales, 
            jsonb_array_elements(conceptos::jsonb) AS t(doc),
            jsonb_to_record(t.doc) as x (id_concepto bigint, cantidad bigint, monto_dolar numeric(14,2), monto_pesos numeric(14,2), porcentaje numeric(14,2))
          where id_recibo = $id_recibo
          ) as kit on dp.id_concepto = kit.id_concepto"
        )->fetchAll(PDO::FETCH_ASSOC);

      $obj->e_pdo("delete from historias.recibos_temporales where id_recibo = $id_recibo");

    } else if ($modo = 'reporte') {

      if (isset($_REQUEST['id'])) {
        $id_recibo = (int)$_REQUEST['id'];
        $datos = json_decode($obj->seleccionar("
          select 
            a.*, b.nomb_medi, b.id_hijo, c.nomb_hijo, TO_CHAR(a.fecha :: DATE, 'dd-mm-yyyy') as fecha_arreglada, a.exonerado, d.apel_nomb as apel_nomb_hist, d.nume_cedu as nume_cedu_hist
          from historias.recibos as a 
          inner join historias.medicos as b using (id_medico)
          left join historias.hijos as c using (id_hijo)
          inner join historias.entradas as d using(id_historia)
          where a.id_recibo = ?
        ", [$id_recibo]), true)[0];

        $conceptos = $obj->e_pdo("
          select 
              dp.id_concepto, dp.nombre, kit.cantidad, kit.monto_dolar, kit.monto_pesos, kit.porcentaje
          from historias.conceptos dp
          inner join (
            SELECT 
              x.*
            from historias.recibos, 
            jsonb_array_elements(conceptos::jsonb) AS t(doc),
            jsonb_to_record(t.doc) as x (id_concepto bigint, cantidad bigint, monto_dolar numeric(14,2), monto_pesos numeric(14,2), porcentaje numeric(14,2))
          where id_recibo = $id_recibo
          ) as kit on dp.id_concepto = kit.id_concepto"
        )->fetchAll(PDO::FETCH_ASSOC);
      } else {
        throw new Exception('operación inválida: ID necesario para imprimir recibo'); 
      }

    }

  } else {
    throw new Exception('operación inválida: MODO necesario para imprimir recibo');
  }

  // echo "<pre>";
  // print_r($datos);
  // echo "</pre>";

  $datos['conversiones'] = json_decode($datos['conversiones'], true);
  $telefonos = json_decode($datos['telefonos'], true);
  $pago      = $obj->i_pdo("select desc_fopa from primarias.form_pago where codi_fopa = $datos[pago]", [], true)->fetchColumn();

  $posicion  = 360;
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
        width: 200mm;
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

<!-- Array CON HIJO
(
Array
(
 [id_recibo] => 3
 [id_historia] => 3
 [nume_cedu] => 34465867
 [apel_nomb] => CARVAJAL LUIS ALFONSO
 [telefonos] => ["04265745867"]
 [pago] => 1
 [total_absoluto] => 100.00
 [total_medico] => 50.00
 [total_hijo] => 50.00
 [subtotales] => [{"id_moneda":1,"subtotal":"30"},{"id_moneda":3,"subtotal":"238000"}]
 [id_moneda] => 1
 [id_medico] => 5
 [nume_reci] => 24469
 [no_reci] => 0
 [conceptos] => [
  {"id_concepto":23,"cantidad":1,"monto_dolar":"30.00","monto_pesos":"150000.00","porcentaje":"25.00"}, = 15
  {"id_concepto":21,"cantidad":1,"monto_dolar":"30.00","monto_pesos":"70000.00","porcentaje":"25.00"}, = 15
  {"id_concepto":19,"cantidad":1,"monto_dolar":"40.00","monto_pesos":"150000.00","porcentaje":"25.00"}] = 20
 [porcentaje] => 50.00
 [fecha] => 2021-11-15
 [informe] => test
 [hora] => 00:59:46
 [conversiones] => {"1":1,"2":4.56,"3":3700,"4":0.85}
 [status] => A
 [nomb_medi] => DR. RUGGERO A. BAMBINI A.
 [id_hijo] => 7
 [nomb_hijo] => OSCAR DAVID CASTILLO B
)
) -->

<!-- Array SIN HIJO
(
 [id_recibo] => 18
 [id_historia] => 1
 [nume_cedu] => 28285070
 [apel_nomb] => LUIS DANIEL CARVAJAL CHACÓN
 [telefonos] => ["04265745867","14141414"]
 [pago] => 1
 [total_absoluto] => 50.00
 [total_medico] => 50.00
 [total_hijo] => 0.00
 [subtotales] => [{"id_moneda":1,"subtotal":"40"},{"id_moneda":3,"subtotal":"37000"}]
 [id_moneda] => 1
 [id_medico] => 1
 [nume_reci] => 138975
 [no_reci] => 1
 [conceptos] => [{"id_concepto":23,"cantidad":1,"monto_dolar":"30.00","monto_pesos":"150000.00","porcentaje":"25.00"},{"id_concepto":22,"cantidad":1,"monto_dolar":"20.00","monto_pesos":"70000.00","porcentaje":"25.00"}]
 [porcentaje] => 0.00
 [fecha] => 2021-11-18
 [informe] => sin hijo
 [hora] => 17:08:43
 [status] => A
 [conversiones] => '{"1":1,"2":4.56,"3":3700,"4":0.85}'
 [nomb_medi] => DR. OSCAR CASTILLO INCIARTE
 [id_hijo] =>
 [nomb_hijo] =>
) -->

<?php 

if(!empty($datos['id_hijo'])) { 
  $porcentajeMedico = 100 - $datos['porcentaje'];
?>

<!--CON HIJO-->

<?php 
  if ($solo == '' || $solo == 'medico') {
    for ($i=0; $i < 3; $i++) : 
      $posicion = 360;
?>

<page style="width:216mm" backtop="45mm" backbottom="5mm" backleft="5mm" backright="5mm">
  <div class="contenedor">
    <!--<div id="cabecera" style="height: 70px">
      <h4 id="titulo1">CLÍNICA OFTALMOLÓGICA</h4>
      <h4 id="titulo2" style="font-size: 18px">DR. CASTILLO INCIARTE</h4>
      <h5 id="fecha" style="text-align: right;">Fecha: <?php echo $dia?></h5>
      <h5 id="hora" style="text-align: right;">Hora: <?php echo $hora?></h5>
    </div>  -->

    <table>
      <tbody>
        <tr>
          <td style="font-size: 16px; width:100%">FECHA: <?php echo $datos['fecha_arreglada']?></td>
          <td style="font-size: 16px; width:100%; position:relative">FACTURA N°: <div style="left:30px"><?php echo $datos['nume_reci']?></div></td>
        </tr>
      </tbody>
    </table>  

    <table>
      <tbody>
        <tr>
          <td style="font-size: 12px">Nombre y apellidos o razón social: <?php echo $datos['apel_nomb']?></td>
          <td style="font-size: 12px">Rif/Cédula o pasaporte: <?php echo strtoupper($datos['nume_cedu'])?></td>
        </tr>
      </tbody>
    </table>  

    <table>
      <tbody>
        <tr>
          <td style="font-size: 12px">Nombre: <?php echo $datos['apel_nomb_hist']?></td>
          <td style="font-size: 12px">N° Historia: <?php echo $datos['id_historia']?></td>
        </tr> 
      </tbody>    
    </table>

    <table>
      <tbody>
        <tr>
          <td style="font-size: 12px">Rif/Cédula o pasaporte del paciente: <?php echo strtoupper($datos['nume_cedu_hist'])?></td>
          <td style="font-size: 12px">Hora: <?php echo $datos['hora']?></td>
        </tr> 
      </tbody>    
    </table>

    <table>
      <tbody>
        <tr>
          <td style="font-size: 12px">Teléfonos: 
            <?php 
              $concat = "";
              foreach ($telefonos as $r) {
                $concat .= $r.', ';
              }
              $concat = substr($concat, 0,-2);
              echo $concat;
            ?>
          </td>
          <td style="font-size: 12px">Forma de pago: <?php echo $pago ?></td>
        </tr> 
      </tbody>    
    </table>

    <div class="separador" style="margin-top: 0px; position: absolute; top: 79mm"></div>

    <table style="width: 195mm; margin-top: 15px;border-left: none; border-collapse: collapse;">
      <thead>
        <tr>
          <th style="width: 30mm;" class="conceptos-cabecera">CANTIDAD</th>
          <th style="width: 75mm;" class="conceptos-cabecera">DESCRIPCIÓN DEL SERVICIO PRESTADO</th>
          <th style="width: 45mm;" class="conceptos-cabecera">PRECIO UNIDAD BsS</th>
          <th style="width: 45mm;" class="conceptos-cabecera">MONTO BsS</th>
        </tr>
      </thead>
      <tbody>
        <?php 

        $monto_total = 0;

        foreach ($conceptos as $r) : ?>
          <tr style="padding: 5px;">
            <td style="height: 15px; text-align: center; vertical-align: middle; border-bottom: 1px dashed #ccc"><?php echo $r['cantidad']?></td>
            <td style="height: 15px; text-align: center; vertical-align: middle; border-bottom: 1px dashed #ccc"><?php echo $r['nombre']?></td>
            <td style="height: 15px; text-align: center; vertical-align: middle; border-bottom: 1px dashed #ccc">
              <?php 
                if ($datos['id_moneda'] == 1) {

                  echo number_format((($r['monto_dolar'] * $porcentajeMedico) / 100) * $datos['conversiones']['2'], 2, ',', '.');

                } else if ($datos['id_moneda'] == 3) {

                  $preTotal = (($r['monto_pesos'] * $porcentajeMedico) / 100) / $datos['conversiones']['3'];
                  echo number_format($preTotal * $datos['conversiones'][2], 2, ',', '.');

                } 
              ?>    
            </td>
            <td style="height: 15px; text-align: center; vertical-align: middle; border-bottom: 1px dashed #ccc">
              <?php

                //esta parte deberia ir entre las condiciones dependiento de la moneda pero al final todo ese comportamiento es basura
                $monto_total = $monto_total + ((($r['monto_dolar'] * $r['cantidad']) * $porcentajeMedico) / 100);

                if ($datos['id_moneda'] == 1) {

                  echo number_format(((($r['monto_dolar'] * $r['cantidad']) * $porcentajeMedico) / 100) * $datos['conversiones']['2'], 2, ',', '.');

                } else if ($datos['id_moneda'] == 3) {

                  $preTotal = ((($r['monto_pesos'] * $r['cantidad']) * $porcentajeMedico) / 100) / $datos['conversiones']['3'];
                  echo number_format($preTotal * $datos['conversiones'][$datos['id_moneda']], 2, ',', '.');

                }
              ?>      
            </td>
          </tr>
          <?php $posicion = $posicion + 30?>
        <?php endforeach;?>
      </tbody>
    </table>

    <div style="position:absolute; top:<?php echo $posicion."px"?>;">

      <div class="separador" style="position: absolute; top: -2mm"></div>

      <?php 
        if ($datos['id_moneda'] == 1) {

          $total_final = $datos['total_medico'] * $datos['conversiones']['2'];

          if((float)$datos['exonerado'] > 0) {
            $exonerado = (float)$datos['exonerado'] * $datos['conversiones']['2'];

            $pre_subtotal = round($total_final + $exonerado, 2);

            // echo "
            //   <div style='font-size:12px; width:200mm; text-align:right'>Subtotal: $pre_subtotal</div>
            //   <div style='font-size:12px; width:200mm; text-align:right'>Exonerado o diferido: -$exonerado</div>
            // ";
          }

        } else if ($datos['id_moneda'] == 3) {

          $total_final = $datos['total_medico'] / $datos['conversiones']['3'];
          $total_final = number_format($total_final * $datos['conversiones']['2'], 2);

          if((float)$datos['exonerado'] > 0) {
            $exonerado = (float)$datos['exonerado'] * $datos['conversiones']['2'];

            $pre_subtotal = round($total_final + $exonerado, 2);

            // echo "
            //   <div style='font-size:12px; width:200mm; text-align:right'>Subtotal: $pre_subtotal</div>
            //   <div style='font-size:12px; width:200mm; text-align:right'>Exonerado o diferido: -$exonerado</div>
            // ";
          }

        }
      ?>

      <div style='font-size:14px; width:200mm; text-align:right; font-weight: bold'>Monto total a pagar Bs: 
        <?php

          if ($datos['id_moneda'] == 1) {

            echo number_format($monto_total * $datos['conversiones']['2'], 2, ',', '.');
            //echo number_format($datos['total_medico'] * $datos['conversiones']['2'], 2, ',', '.');

          } else if ($datos['id_moneda'] == 3) {

            $preTotal = $monto_total / $datos['conversiones']['3'];
            echo number_format($preTotal * $datos['conversiones']['2'], 2, ',', '.');

          }
        ?> 
      </div>
      
      <div class="separador" style="margin: 0px"></div>
    </div>
  </div>  
</page>

<?php 
    endfor;
  }
?>

<?php 
  if($solo == '' || $solo == 'hijo') {
    for ($i=0; $i < 3; $i++) : 
      $posicion = 360;
?>

<page style="width:216mm" backtop="45mm" backbottom="5mm" backleft="5mm" backright="5mm">
  <div class="contenedor">
    <!--<div id="cabecera" style="height: 70px">
      <h4 id="titulo1">CLÍNICA OFTALMOLÓGICA</h4>
      <h4 id="titulo2" style="font-size: 18px">DR. CASTILLO INCIARTE</h4>
      <h5 id="fecha" style="text-align: right;">Fecha: <?php echo $dia?></h5>
      <h5 id="hora" style="text-align: right;">Hora: <?php echo $hora?></h5>
    </div>  -->

    <table>
      <tbody>
        <tr>
          <td style="font-size: 16px; width:100%">FECHA: <?php echo $datos['fecha_arreglada']?></td>
          <td style="font-size: 16px; width:100%; position:relative">FACTURA N°: <div style="left:30px"><?php echo $datos['h_nume_reci']?></div></td>
        </tr>
      </tbody>
    </table>  

    <table>
      <tbody>
        <tr>
          <td style="font-size: 12px">Nombre y apellidos o razón social: <?php echo $datos['apel_nomb']?></td>
          <td style="font-size: 12px">Rif/Cédula o pasaporte: <?php echo strtoupper($datos['nume_cedu'])?></td>
        </tr>
      </tbody>
    </table>  

    <table>
      <tbody>
        <tr>
          <td style="font-size: 12px">Nombre: <?php echo $datos['apel_nomb_hist']?></td>
          <td style="font-size: 12px">N° Historia: <?php echo $datos['id_historia']?></td>
        </tr> 
      </tbody>    
    </table>

    <table>
      <tbody>
        <tr>
          <td style="font-size: 12px">Rif/Cédula o pasaporte N°: <?php echo strtoupper($datos['nume_cedu_hist'])?></td>
          <td style="font-size: 12px">Hora: <?php echo $datos['hora']?></td>
        </tr> 
      </tbody>    
    </table>

    <table>
      <tbody>
        <tr>
          <td style="font-size: 12px">Teléfonos: 
            <?php 
              $concat = "";
              foreach ($telefonos as $r) {
                $concat .= $r.', ';
              }
              $concat = substr($concat, 0,-2);
              echo $concat;
            ?>
          </td>
          <td style="font-size: 12px">Forma de pago: <?php echo $pago ?></td>
        </tr> 
      </tbody>    
    </table>

    <div class="separador" style="margin-top: 0px;  position: absolute; top: 79.5mm"></div>

    <table style="width: 195mm; margin-top: 15px; border-left: none; border-collapse: collapse;">
      <thead>
        <tr>
           <th style="width: 30mm;" class="conceptos-cabecera">CANTIDAD</th>
          <th style="width: 75mm;" class="conceptos-cabecera">DESCRIPCIÓN DEL SERVICIO PRESTADO</th>
          <th style="width: 45mm;" class="conceptos-cabecera">PRECIO UNIDAD BsS</th>
          <th style="width: 45mm;" class="conceptos-cabecera">MONTO BsS</th>
        </tr>
      </thead>
      <tbody>
        <?php 

        $monto_total = 0;

        foreach ($conceptos as $r) : ?>
          <tr style="padding: 5px;">
            <td style="height: 15px; text-align: center; vertical-align: middle; border-bottom: 1px dashed #ccc"><?php echo $r['cantidad']?></td>
            <td style="height: 15px; text-align: center; vertical-align: middle; border-bottom: 1px dashed #ccc"><?php echo "PRE-EXAMEN (E)"//$r['nombre']?></td>
            <td style="height: 15px; text-align: center; vertical-align: middle; border-bottom: 1px dashed #ccc">
              <?php 
                if ($datos['id_moneda'] == 1) {

                  echo number_format((($r['monto_dolar'] * $datos['porcentaje']) / 100) * $datos['conversiones']['2'], 2, ',', '.');

                } else if ($datos['id_moneda'] == 3) {

                  $preTotal = (($r['monto_pesos'] * $datos['porcentaje']) / 100) / $datos['conversiones']['3'];
                  echo number_format($preTotal * $datos['conversiones'][2], 2, ',', '.');

                } 
              ?>    
            </td>
            <td style="height: 15px; text-align: center; vertical-align: middle; border-bottom: 1px dashed #ccc">
              <?php 
                if ($datos['id_moneda'] == 1) {

                  $monto_total = $monto_total + ((($r['monto_dolar'] * $r['cantidad']) * $porcentajeMedico) / 100);

                  echo number_format(((($r['monto_dolar'] * $r['cantidad']) * $datos['porcentaje']) / 100) * $datos['conversiones']['2'], 2, ',', '.');

                } else if ($datos['id_moneda'] == 3) {

                  $preTotal = ((($r['monto_pesos'] * $r['cantidad']) * $datos['porcentaje']) / 100) / $datos['conversiones']['3'];
                  echo number_format($preTotal * $datos['conversiones'][$datos['id_moneda']], 2, ',', '.');

                }
              ?>      
            </td>
          </tr>
          <?php $posicion = $posicion + 30?>
        <?php endforeach;?>
      </tbody>
    </table>

    <div style="position:absolute; top:<?php echo $posicion."px"?>;">

      <div class="separador" style="position: absolute; top: -2mm"></div>

      <?php 
        if ($datos['id_moneda'] == 1) {

          $total_final = $datos['total_hijo'] * $datos['conversiones']['2'];

          if((float)$datos['exonerado'] > 0) {
            $exonerado = (float)$datos['exonerado'] * $datos['conversiones']['2'];

            $pre_subtotal = round($total_final + $exonerado, 2);

            // echo "
            //   <div style='font-size:12px; width:200mm; text-align:right'>Subtotal: $pre_subtotal</div>
            //   <div style='font-size:12px; width:200mm; text-align:right'>Exonerado o diferido: -$exonerado</div>
            // ";
          }

        } else if ($datos['id_moneda'] == 3) {

          $total_final = $datos['total_hijo'] / $datos['conversiones']['3'];
          $total_final = number_format($total_final * $datos['conversiones']['2'], 2);

          if((float)$datos['exonerado'] > 0) {
            $exonerado = (float)$datos['exonerado'] * $datos['conversiones']['2'];

            $pre_subtotal = round($total_final + $exonerado, 2);

            // echo "
            //   <div style='font-size:12px; width:200mm; text-align:right'>Subtotal: $pre_subtotal</div>
            //   <div style='font-size:12px; width:200mm; text-align:right'>Exonerado o diferido: -$exonerado</div>
            // ";
          }

        }
      ?>

      <div style='font-size:14px; width:200mm; text-align:right; font-weight: bold'>Monto total a pagar Bs: 
        <?php
          if ($datos['id_moneda'] == 1) {

            echo number_format($monto_total * $datos['conversiones']['2'], 2, ',', '.');

          } else if ($datos['id_moneda'] == 3) {

            $preTotal = $monto_total * $datos['conversiones']['3'];
            echo number_format($preTotal * $datos['conversiones']['2'], 2, ',', '.');

          }
        ?> 
      </div>

      <div class="separador" style="margin: 0px"></div>
    </div>
  </div>  
</page>

<?php 
   endfor;
  }
?>

<?php } else { ?>

<!--SIN HIJO-->
<?php for ($i=0; $i < 3; $i++) : 
 $posicion  = 360;
  ?>

<page style="width:216mm" backtop="45mm" backbottom="5mm" backleft="8mm" backright="8mm">
  <div class="contenedor">
    <!--<div id="cabecera" style="height: 70px">
      <h4 id="titulo1">CLÍNICA OFTALMOLÓGICA</h4>
      <h4 id="titulo2" style="font-size: 18px">DR. CASTILLO INCIARTE</h4>
      <h5 id="fecha" style="text-align: right;">Fecha: <?php echo $dia?></h5>
      <h5 id="hora" style="text-align: right;">Hora: <?php echo $hora?></h5>
    </div>  -->

    <table>
      <tbody>
        <tr>
          <td style="font-size: 16px; width:100%">FECHA: <?php echo $datos['fecha_arreglada']?></td>
          <td style="font-size: 16px; width:100%; position:relative">FACTURA N°: <div style="left:30px"><?php echo $datos['nume_reci']?></div></td>
        </tr>
      </tbody>
    </table>  

    <table>
      <tbody>
        <tr>
          <td style="font-size: 12px">Nombre y apellidos o razón social: <?php echo $datos['apel_nomb']?></td>
          <td style="font-size: 12px">Rif/Cédula o pasaporte: <?php echo strtoupper($datos['nume_cedu'])?></td>
        </tr>
      </tbody>
    </table>  

    <table>
      <tbody>
        <tr>
          <td style="font-size: 12px">Nombre: <?php echo $datos['apel_nomb_hist']?></td>
          <td style="font-size: 12px">N° Historia: <?php echo $datos['id_historia']?></td>
        </tr> 
      </tbody>    
    </table>

    <table>
      <tbody>
        <tr>
          <td style="font-size: 12px">Rif/Cédula o pasaporte N°: <?php echo strtoupper($datos['nume_cedu_hist'])?></td>
          <td style="font-size: 12px">Hora: <?php echo $datos['hora']?></td>
        </tr> 
      </tbody>    
    </table>

    <table>
      <tbody>
        <tr>
          <td style="font-size: 12px">Teléfonos: 
            <?php 
              $concat = "";
              foreach ($telefonos as $r) {
                $concat .= $r.', ';
              }
              $concat = substr($concat, 0,-2);
              echo $concat;
            ?>
          </td>
          <td style="font-size: 12px">Forma de pago: <?php echo $pago ?></td>
        </tr> 
      </tbody>    
    </table>

    <div class="separador" style="margin-top: 0px;position: absolute; top: 79.5mm"></div>

    <table style="width: 195mm; margin-top: 15px; border-left: none; border-collapse: collapse;">
      <thead>
        <tr>
          <th style="width: 30mm;" class="conceptos-cabecera">CANTIDAD</th>
          <th style="width: 75mm;" class="conceptos-cabecera">DESCRIPCIÓN DEL SERVICIO PRESTADO</th>
          <th style="width: 45mm;" class="conceptos-cabecera">PRECIO UNIDAD BsS</th>
          <th style="width: 45mm;" class="conceptos-cabecera">MONTO BsS</th>
        </tr>
      </thead>
      <tbody>
        <?php 

        $monto_total = 0;

        foreach ($conceptos as $r) : ?>
          <tr style="padding: 5px;">
            <td style="height: 15px; text-align: center; vertical-align: middle; border-bottom: 1px dashed #ccc"><?php echo $r['cantidad']?></td>
            <td style="height: 15px; text-align: center; vertical-align: middle; border-bottom: 1px dashed #ccc"><?php echo $r['nombre']?></td>
            <td style="height: 15px; text-align: center; vertical-align: middle; border-bottom: 1px dashed #ccc">
              <?php 
                if ($datos['id_moneda'] == 1) {

                  echo number_format(($r['monto_dolar'] * $datos['conversiones']['2']), 2, ',', '.');

                } else if ($datos['id_moneda'] == 3) {

                  $preTotal = $r['monto_pesos'] / $datos['conversiones']['3'];
                  echo number_format($preTotal * $datos['conversiones']['2'], 2, ',', '.');

                } 
              ?>
            </td>
            <td style="height: 15px; text-align: center; vertical-align: middle; border-bottom: 1px dashed #ccc">
              <?php

                $monto_total = $monto_total + ($r['monto_dolar'] * $r['cantidad']);

                if ($datos['id_moneda'] == 1) {

                  echo number_format(($r['monto_dolar'] * $r['cantidad']) * $datos['conversiones']['2'], 2, ',', '.');

                } else if ($datos['id_moneda'] == 3) {

                  $preTotal = $r['monto_pesos'] / $datos['conversiones']['3'];
                  echo number_format($preTotal * $datos['conversiones']['2'], 2, ',', '.');

                }
              ?> 
            </td>
          </tr>
          <?php $posicion = $posicion + 30?>
        <?php endforeach;?>
      </tbody>
    </table>

    <div style="position:absolute; top:<?php echo $posicion."px"?>;">

      <div class="separador" style="position: absolute; top: -2mm"></div>

      <?php 
        if ($datos['id_moneda'] == 1) {

          $total_final = $datos['total_absoluto'] * $datos['conversiones']['2'];

          if((float)$datos['exonerado'] > 0) {
            $exonerado = (float)$datos['exonerado'] * $datos['conversiones']['2'];

            $pre_subtotal = round($total_final + $exonerado, 2);

            // echo "
            //   <div style='font-size:12px; width:200mm; text-align:right'>Subtotal: $pre_subtotal</div>
            //   <div style='font-size:12px; width:200mm; text-align:right'>Exonerado o diferido: -$exonerado</div>
            // ";
          }

        } else if ($datos['id_moneda'] == 3) {

          $total_final = $datos['total_absoluto'] / $datos['conversiones']['3'];
          $total_final = number_format($total_final * $datos['conversiones']['2'], 2);

          if((float)$datos['exonerado'] > 0) {
            $exonerado = (float)$datos['exonerado'] * $datos['conversiones']['2'];

            $pre_subtotal = round($total_final + $exonerado, 2);

            // echo "
            //   <div style='font-size:12px; width:200mm; text-align:right'>Subtotal: $pre_subtotal</div>
            //   <div style='font-size:12px; width:200mm; text-align:right'>Exonerado o diferido: -$exonerado</div>
            // ";
          }

        }
      ?>

      <div style='font-size:14px; width:200mm; text-align:right; font-weight: bold'>Monto total a pagar Bs: 
        <?php 

          if ($datos['id_moneda'] == 1) {

            echo number_format($monto_total * $datos['conversiones']['2'], 2, ',', '.');
            //number_format($datos['total_absoluto'] * $datos['conversiones']['2'], 2, ',', '.');

          } else if ($datos['id_moneda'] == 3) {

            $preTotal = $monto_total / $datos['conversiones']['3'];
            echo number_format($preTotal * $datos['conversiones']['2'], 2, ',', '.');

          }
        ?>
      </div>

      <div class="separador" style="margin: 0px"></div>
    </div>
  </div>  
</page>
<?php endfor;?>
<?php } ?>

<?php
  require_once(dirname(__FILE__).'/../vendor/autoload.php');
  require_once('../vendor/autoload.php');
  use Spipu\Html2Pdf\Html2Pdf;

  if($pdf !== 0) {
    $content = ob_get_clean();

    try
    {    
        $width = 216;
        $height = 140;
        $html2pdf = new HTML2PDF('L', array($width,$height, 0, 0), 'en', true, 'UTF-8', array(0, 0, 0, 0));
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));

        $hora   = $obj->fechaHora('America/Caracas','H-i-s');
        $obj->fechaHora('America/Caracas','d-m-Y');
        $nombre = $datos['id_historia'].'-'.$datos['nume_reci'].'-'.$dia;

        if ($pdf == 1) {
          $html2pdf->output("../reportes/recibos/recibo$nombre.pdf", "f");
        } else if ($pdf == 2) {
          $html2pdf->Output("../reportes/recibos/recibo$nombre.pdf");
        } else {  
          $html2pdf->Output("../reportes/recibos/recibo$nombre.pdf");
          $html2pdf->output("../reportes/recibos/recibo$nombre.pdf", "f");
        }
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
  }
?>