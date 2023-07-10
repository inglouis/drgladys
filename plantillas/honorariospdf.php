<?php
  /*MODOS PDF:
    0: traer solo estructura HTML
    1: solo guardar REPORTE,
    2: traer reporte SIN GUARDAR,
    3: traer reporte Y GUARDAR, 
  */

  ob_start();
  include_once('../clases/facturas.class.php');
  $obj = new Model();

  //--------------------------------------------------
  //VARIABLES GENERALES
  //--------------------------------------------------
  if (isset($_REQUEST['pdf'])) {
    $pdf = (int)$_REQUEST['pdf'];
  } else {
    $pdf = 2;
  }

  if (isset($_REQUEST['modo'])) {

    $modo = $_REQUEST['modo'];

  } else {
    
  	throw new Exception('operación inválida: MODO necesario para honorarios');

  }

  if ($modo == 'previa') {

  	//traer datos para previa
  	if (!empty($_SESSION['datos_pdf'])) {

		  $datos = json_decode($_SESSION['datos_pdf'], true);

  	} else {
  		throw new Exception('operación inválida: DATOS expirados, refrescar reporte');
  	}

    //print_r($datos);

    //a veces se esta colando la id de la factura, ver por que

  	//organizar datos
  	$id_principal = $datos[0];
  	$id_auxiliar  = $datos[1];

  	$desde     = $datos[2];
  	$hasta	   = $datos[3];
  	$descuento = $datos[4];

    $con_deducible = $datos[5];

  	$monto_total_dolares   = $datos[6];
  	$monto_total_bolivares = $datos[7];

  	$facturas = $datos[8];

  } else if ($modo == 'confirmado') {

    if (isset($_REQUEST['id'])) {

      $id_honorario = (int)$_REQUEST['id'];

      $datos = $obj->i_pdo('select * from facturacion.honorarios where id_honorario = ?', [$id_honorario], true)->fetch(PDO::FETCH_ASSOC);

      $id_principal = $datos['id_principal'];
      $id_auxiliar  = $datos['id_auxiliar'];

      $desde     = $datos['desde'];
      $hasta     = $datos['hasta'];
      $descuento = $datos['descuento'];

      $con_deducible = $datos['deducible'];

      $monto_total_dolares   = $datos['total_dolar'];
      $monto_total_bolivares = $datos['total_bolivar'];

      $facturas = $obj->i_pdo("
          sELECT 
              sq.*, 
              b.apel_nomb,
              CASE WHEN sq.id_factura_anulada is null THEN '{}'::json ELSE 

              (
                  SELECT 
                  json_build_object(
                      'costo_dolares', x.costo_dolares,
                      'costo_bolivares', (x.costo_dolares * (a.conversiones->'2'->>'conver')::numeric(14,2))::numeric(14,2),
                      'id_baremo', x.id_baremo, 
                      'status', x.status
                  ) as detalle_honorario_anulado

                  FROM facturacion.facturas AS a,

                  jsonb_array_elements(a.detalle_honorarios::jsonb) AS t(doc),
                  jsonb_to_record(t.doc)AS x (id_baremo bigint, costo_dolares numeric(14,2), status character varying (1))

                  WHERE x.id_baremo = sq.id_principal and a.id_factura = sq.id_factura_anulada or x.id_baremo = sq.id_auxiliar and a.id_factura = sq.id_factura_anulada AND id_factura IN (
                      (select unnest(ARRAY(select trim(json_array_elements_text(id_facturas::json))::bigint from facturacion.honorarios where id_honorario = ?)) as id_honorario)
                    )
              )
              
              END AS detalle_honorario_anulado
              
          FROM (
              SELECT 
                          
                  a.id_factura,
                  a.id_factura_anulada,
                  b.id_principal::bigint as id_principal,
                  b.id_auxiliar::bigint,
                  a.id_historia,
                  x.costo_dolares,
                  (x.costo_dolares * (a.conversiones->'2'->>'conver')::numeric(14,2))::numeric(14,2) as costo_bolivares,
                  a.conversiones,
                  TO_CHAR(a.fecha :: DATE, 'dd-mm-yyyy') as fecha_arreglada,
                  a.fecha_credito_pagado as fecha,
                  (null)::numeric(14,2) as diferencia,
                  a.detalle_honorarios,
                  a.status

              FROM facturacion.facturas AS a,

                  jsonb_array_elements(a.detalle_honorarios::jsonb) AS t(doc),
                  jsonb_to_record(t.doc)AS x (id_baremo bigint, costo_dolares numeric(14,2))

              LEFT JOIN facturacion.baremos AS b ON x.id_baremo = b.id_principal
              WHERE a.status in ('A', 'C') and a.status_credito_pago = 'CON' AND a.fecha_credito_pagado BETWEEN ? AND ? AND id_factura IN (
                  (select unnest(ARRAY(select trim(json_array_elements_text(id_facturas::json))::bigint from facturacion.honorarios where id_honorario = ?)) as id_honorario)
              )
          ) as sq

          LEFT JOIN historias.entradas AS b ON b.id_historia = sq.id_historia
          WHERE sq.id_principal = ? or sq.id_principal = ?
          ORDER BY sq.id_factura ASC
        ",
        [$id_honorario, $desde, $hasta, $id_honorario, $id_principal, $id_auxiliar],
        true
      )->fetchAll(PDO::FETCH_ASSOC);


      //print_r($facturas);

    } else {
      throw new Exception('operación inválida: ID necesario para generar reporte');
    }

  } else {
    throw new Exception('operación inválida: MODO necesario para generar reporte');
  }

  //traer baremos
  $sql = "select id_principal, id_auxiliar, desc_bare, stat_bare, haber, cta3, ctades, cedu, rif from facturacion.baremos where id_principal = ?";
  $baremoPrincipal = $obj->i_pdo($sql, [$id_principal], true)->fetch(PDO::FETCH_ASSOC);

  $sql = "select id_principal, id_auxiliar, desc_bare, stat_bare, haber, cta3, ctades, cedu, rif from facturacion.baremos where id_principal = ?";
  $baremoAuxiliar = $obj->i_pdo($sql, [$id_auxiliar], true)->fetch(PDO::FETCH_ASSOC);

  //traer impuestos
  $sql = "select * from miscelaneos.impuestos where id_impuesto = 1";
  $impuestos = $obj->i_pdo($sql, [], true)->fetch(PDO::FETCH_ASSOC);

  //otros datos
	$dia  = $obj->fechaHora('America/Caracas','d-m-Y');
	$hora = $obj->fechaHora('America/Caracas','H:i:s');
	setlocale(LC_ALL,"es_ES@euro","es_ES","esp");

  $stampDesde = strtotime($desde);
  $stampHasta = strtotime($hasta);

  $timestamp = new DateTime($dia);
  $fecha = strtotime($dia);

  // (
  //  [0] => Array
  //  (
  //    [id_factura] => 97014704
  //    [id_principal] => 44
  //    [id_auxiliar] => 47
  //    [id_historia] => 1602
  //    [costo_dolares] => 600.00
  //    [costo_bolivares] => 3276.00
  //    [conversiones] => {"1": {"conver": 1, "nombre": "DOLARES", "unidad": "$"}, "2": {" ...
  //    [fecha_arreglada] => 22-06-2022
  //    [apel_nomb] => ALI OSORIO FATIMA
  //  )
  // )

  // echo "<pre>";
  // print_r($baremos);
  // echo "</pre>";

?>

<style>
	#separador {margin-top: 0px}

	#titulo1 {top:30px}

	#titulo2 {top: 55px;}

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

	#cabecera h5 {font-size: 16px;}

	#cabecera h4 {font-size: 18px;}

	.centro {
		text-align: left;
		font-size: 14px;
		width: 100%;
	}

	.tabla {margin-left: 50px;}

	table {
		width:100%;
		color: #202020;
		font-size: 12px;
		margin-left: 0px;
		margin-top: 0px;
	}

	table thead, table tbody, table tbody tr, table thead tr {width: 300px;}

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

	.derecha {text-align: right !important;}

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

<page style="width:200mm" backtop="5mm" backbottom="5mm" backleft="6mm" backright="4mm">

	<div style="font-size: 17px">
		CLÍNICA OFTALMOLÓGICA CASTILLO INCIARTE Y ASOCIADOS C.A.
	</div>

	<div style="text-align: right;">
		<?php echo $dia?>
	</div>

	<div style="position: relative;">
		<div style="font-size: 21px;position: absolute; text-align: left; width: 100%">DESDE:&nbsp;&nbsp;<b><?php echo date("d-m-Y", $stampDesde)?></b></div>
		<div style="font-size: 21px;position: absolute; text-align: right; width: 100%">HASTA:&nbsp;&nbsp;<b><?php echo date("d-m-Y", $stampHasta)?></b></div>
	</div>

	<div></div>

	<div class="separador"></div>

  	<table style="width: 210mm; position: relative;">
      <thead>
        <tr style="border: 1px solid #262626">
          <th style="text-align:center; border-bottom: 1px dotted #262626;">N° FACT</th>
          <th style="text-align:center; border-bottom: 1px dotted #262626;">FECHA</th>
          <th style="text-align:center; border-bottom: 1px dotted #262626;">PACIENTE</th>
          <th style="text-align:center; border-bottom: 1px dotted #262626;">COD. BARE</th>
          <th style="text-align:center; border-bottom: 1px dotted #262626; text-align: right;">TOT. HON</th>
        </tr>
      </thead>
      <tbody>
        <?php

        $espaciado = 50; //no se aplica más

        $contienePrincipal = false;
        $contieneAuxiliar  = false;

        $subtotales = array(
          $id_principal => 0,
          $id_auxiliar =>  0
        );

        // echo "<pre>";
        // print_r($subtotales);
        // echo "</pre>";

        $facturasProcesadas = array(
          $id_principal => array(),
          $id_auxiliar =>  array()
        );

        foreach ($facturas as $r) {

          $subtotales[$r['id_principal']] = $subtotales[$r['id_principal']] + $r['costo_bolivares'];

          $facturasProcesadas[$r['id_principal']][] = $r;

          if ($id_principal == $r['id_principal']) {

            $contienePrincipal = true;

          }

          if ($id_auxiliar == $r['id_principal']) {

            $contieneAuxiliar = true;

          }

        }

        if ($contienePrincipal) {

          foreach ($facturasProcesadas[$id_principal] as $r) :

          	$espaciado = $espaciado + 1;

            //echo $r['id_factura_anulada'];

            if ($r['id_factura_anulada'] != 0) {

              $detalle_honorario_anulado = json_decode($r['detalle_honorario_anulado'], true);

              if ($detalle_honorario_anulado['status'] == 'D') {

                $monto_anulado = $detalle_honorario_anulado['costo_bolivares'];

                //resta del monto anulado por honorario por codigo principal
                $subtotales[$id_principal] = $subtotales[$id_principal] - $monto_anulado;
                $monto_total_bolivares = $monto_total_bolivares;

              } else {

                $monto_anulado = 0.00;

              }

              //print_r($detalles_honorario_anulado);

            }
 
          ?>
            <tr>
              <td style="width: 15mm; font-size: 13px; text-align: center"><?php echo $r['id_factura']?></td>
              <td style="width: 15mm; font-size: 13px; text-align: center"><?php echo $r['fecha_arreglada']?></td>
              <td style="width: 93mm; font-size: 13px; text-align: left"><?php echo $r['apel_nomb']?></td>
              <td style="width: 13mm; font-size: 13px; text-align: center"><?php echo $r['id_principal']?></td>

              <?php 
                if ($r['id_factura_anulada'] != 0) {

                  echo "
                    <td style='width: 33mm; font-size: 13px; text-align: right; background: lightgray'>".number_format($r['costo_bolivares'], 2, ',', '.')." <b style='color:#9b1b1b'>- ".number_format($monto_anulado, 2, ',', '.')."</b></td>
                  ";

                } else {

                  echo "
                    <td style='width: 33mm; font-size: 13px; text-align: right'>".number_format($r['costo_bolivares'], 2, ',', '.')."</td>
                  ";

                }
              ?>

            </tr>
            <?php 
              if ($r['id_factura_anulada'] != 0) {


                $nota = $obj->i_pdo('select id_credito from facturacion.facturas_credito where id_factura_anulada = ?', [$r['id_factura_anulada']], true)->fetchColumn();
            ?>

              <tr style="background: lightgray; padding-bottom: 5px;">
                <td style="width: 15mm; font-size: 13px; text-align: center"></td>
                <td style="width: 15mm; font-size: 13px; text-align: center"></td>
                <td style="width: 93mm; font-size: 11px; text-align: left">Monto procesado en la factura N° <b><?php echo $r['id_factura_anulada']?></b> y nota N°<b><?php echo $nota;?></b></td>
                <td style="width: 13mm; font-size: 13px; text-align: center"></td>
                <td style="width: 33mm; font-size: 13px; text-align: right; background: #daebda;"><?php echo number_format($r['costo_bolivares'] - $monto_anulado, 2, ',', '.')?></td>
              </tr>

            <?php 
              }
            ?>

          <?php 
          
          endforeach;

        }

        ?>
      </tbody>
    </table>



    <?php 

    if ($contienePrincipal) {

    ?>
    <div class="separador" style="position: relative; top: 5px"></div>

    <table style="width: 210mm; position: relative; top: -2px">
      <thead>
        <tr>
          <th style="border: none;"></th>
          <th style="border: none;"></th>
          <th style="border: none;"></th>
          <th style="border: none;"></th>
          <th style="border: none;"></th>
          <th style="border: none;"></th>
        </tr>
      </thead>
      <tbody style="border: none">

      	<?php

    			echo "
    				<tr style='border: none'>
		          <td style='width: 60mm;border: none; font-size: 13px; text-align: center;'>CANCELACIÓN DE HONORARIOS A:</td>
		          <td style='width: 5mm;border: none; font-size: 13px; text-align: center;'>$id_principal</td>
		          <td style='width: 45mm;border: none; font-size: 13px; text-align: center;'>$baremoPrincipal[desc_bare]</td>
		          <td style='width: 25mm;border: none; font-size: 13px; text-align: center;'>$baremoPrincipal[stat_bare]</td>
		          <td style='width: 15mm;border: none; font-size: 13px; text-align: center;'>$baremoPrincipal[haber]</td>
              <td style='width: 15mm;border: none; font-size: 13px; text-align: right; font-weight:bold'>". number_format($subtotales[$id_principal], 2, ',', '.')."</td>
		        </tr>
    			";

	      ?>

      </tbody>
    </table>

    <?php 
      }
    ?>

    <div class="separador"></div>

    <table style="width: 210mm; position: relative;">
      <thead>
        <tr style="border: none">
          <th style="text-align:center; border-bottom: 1px dotted #262626;">N° FACT</th>
          <th style="text-align:center; border-bottom: 1px dotted #262626;">FECHA</th>
          <th style="text-align:center; border-bottom: 1px dotted #262626;">PACIENTE</th>
          <th style="text-align:center; border-bottom: 1px dotted #262626;">COD. BARE</th>
          <th style="text-align:center; border-bottom: 1px dotted #262626; text-align: right;">TOT. HON</th>
        </tr>
      </thead>
      <tbody>
        <?php

        if ($contieneAuxiliar && $id_principal != $id_auxiliar) {

          foreach ($facturasProcesadas[$id_auxiliar] as $r) :

            $espaciado = $espaciado + 1;

            if ($r['id_factura_anulada'] != 0) {

              $detalle_honorario_anulado = json_decode($r['detalle_honorario_anulado'], true);

              if ($detalle_honorario_anulado['status'] == 'D') {

                $monto_anulado = $detalle_honorario_anulado['costo_bolivares'];

                //resta del monto anulado por honorario por codigo principal
                $subtotales[$id_auxiliar] = $subtotales[$id_auxiliar] - $monto_anulado;
                $monto_total_bolivares = $monto_total_bolivares;

              } else {

                $monto_anulado = 0.00;

              }

              //print_r($detalles_honorario_anulado);

            }

          ?>
            <tr>
              <td style="width: 15mm; font-size: 13px; text-align: center"><?php echo $r['id_factura']?></td>
              <td style="width: 15mm; font-size: 13px; text-align: center"><?php echo $r['fecha_arreglada']?></td>
              <td style="width: 93mm; font-size: 13px; text-align: left"><?php echo $r['apel_nomb']?></td>
              <td style="width: 15mm; font-size: 13px; text-align: center"><?php echo $r['id_principal']?></td>
                <?php 
                if ($r['id_factura_anulada'] != 0) {

                    echo "
                      <td style='width: 33mm; font-size: 13px; text-align: right; background: lightgray'>".number_format($r['costo_bolivares'], 2, ',', '.')." <b style='color:#9b1b1b'>- ".number_format($monto_anulado, 2, ',', '.')."</b></td>
                    ";

                  } else {

                    echo "
                      <td style='width: 33mm; font-size: 13px; text-align: right'>".number_format($r['costo_bolivares'], 2, ',', '.')."</td>
                    ";

                  }
                ?>

            </tr>
            <?php 
              if ($r['id_factura_anulada'] != 0) {

                $nota = $obj->i_pdo('select id_credito from facturacion.facturas_credito where id_factura_anulada = ?', [$r['id_factura_anulada']], true)->fetchColumn();
            ?>

              <tr style="background: lightgray; padding-bottom: 5px;">
                <td style="width: 15mm; font-size: 13px; text-align: center"></td>
                <td style="width: 15mm; font-size: 13px; text-align: center"></td>
                <td style="width: 93mm; font-size: 11px; text-align: left">Monto procesado en la factura N° <b><?php echo $r['id_factura_anulada']?></b> y nota N°<b><?php echo $nota;?></b></td>
                <td style="width: 15mm; font-size: 13px; text-align: center"></td>
                <td style="width: 33mm; font-size: 13px; text-align: right; background: #daebda;"><?php echo number_format($r['costo_bolivares'] - $monto_anulado, 2, ',', '.')?></td>
              </tr>

            <?php 
              }
            ?>
          <?php 
          endforeach;

        }

        ?>
      </tbody>
    </table>


    <?php

    if ($contieneAuxiliar && $id_principal != $id_auxiliar) {

    ?>
    <div class="separador" style="position: relative; top: 3px"></div>

    <table style="width: 210mm; position: relative; top: -2px">
      <thead>
        <tr>
          <th style="border: none;"></th>
          <th style="border: none;"></th>
          <th style="border: none;"></th>
          <th style="border: none;"></th>
          <th style="border: none;"></th>
          <th style="border: none;"></th>
        </tr>
      </thead>
      <tbody style="border: none">

        <?php

          echo "
            <tr style='border: none'>
              <td style='width: 60mm;border: none; font-size: 13px; text-align: center;'>CANCELACIÓN DE HONORARIOS A:</td>
              <td style='width: 5mm;border: none; font-size: 13px; text-align: center;'>$id_auxiliar</td>
              <td style='width: 45mm;border: none; font-size: 13px; text-align: center;'>$baremoAuxiliar[desc_bare]</td>
              <td style='width: 25mm;border: none; font-size: 13px; text-align: center;'>$baremoAuxiliar[stat_bare]</td>
              <td style='width: 15mm;border: none; font-size: 13px; text-align: center;'>$baremoAuxiliar[haber]</td>
              <td style='width: 15mm;border: none; font-size: 13px; text-align: right; font-weight:bold'>". number_format($subtotales[$id_auxiliar], 2, ',', '.')."</td>
            </tr>
          ";

        ?>

      </tbody>
    </table>

    <?php 
      }
    ?>

    <div class="separador" style="position: relative; top: 3px"></div>

    <table style="width: 210mm; position: relative; top: -3px">
      <thead>
        <tr>
          <th style="border: none;"></th>
          <th style="border: none;"></th>
          <th style="border: none;"></th>
          <th style="border: none;"></th>
          <th style="border: none;"></th>
          <th style="border: none;"></th>
        </tr>
      </thead>
      <tbody style="border: none">
        <tr style="border: none">
          <td style="border: none; width: 15mm; font-size: 14px; text-align: center"></td>
          <td style="border: none; width: 15mm; font-size: 14px; text-align: center"></td>
          <td style="border: none; width: 15mm; font-size: 14px; text-align: center"></td>
          <td style="border: none; width: 15mm; font-size: 14px; text-align: center"></td>
          <td style="border: none; width: 91mm; font-size: 14px; text-align: right;">Monto total (BsS):</td>
          <td style="border: none; width: 12mm; font-size: 14px; text-align: right; font-weight: bold"><?php echo number_format($monto_total_bolivares, 2, ',', '.')?>
          </td>
        </tr>
      </tbody>
    </table>

    <div class="separador" style="position: relative; top: 3px"></div>

    <!--segunda parte del repote-->

    <div style="position: absolute; top: 70%">
        <!--<div style="position: relative; top: <?php echo $espaciado.'mm'?>"></div>-->

        <!--[IMPORTANTE] todo este set de datos parece estar raro-->
        <?php 

          $islr = ($monto_total_bolivares * $impuestos['valor1']) / 100;

          if ($con_deducible == 'X') {
            $islr = $islr - $impuestos['deducible'];
          }
        
        ?>

        <div class="separador" style="position: relative; top: -33px"></div>

        <?php 

          if ($contienePrincipal) {

            $cta3 = $baremoPrincipal['cta3'];
            $ctades = $baremoPrincipal['ctades'];
            $desc_bare = $baremoPrincipal['desc_bare'];
            $cedula_bare = $baremoPrincipal['cedu'];

          } else if ($contieneAuxiliar) {

            $cta3 = $baremoAuxiliar['cta3'];
            $ctades = $baremoAuxiliar['ctades'];
            $desc_bare = $baremoAuxiliar['desc_bare'];
            $cedula_bare = $baremoAuxiliar['cedu'];

          }

        ?>

        <table style="width: 210mm; position: relative; top: 3px">
          <thead>
            <tr>
              <th style="border: none;"></th>
              <th style="border: none;"></th>
              <th style="border: none;"></th>
              <th style="border: none;"></th>
              <th style="border: none;"></th>
              <th style="border: none;"></th>
              <th style="border: none;"></th>
            </tr>
          </thead>
          <tbody style="border: none">
            <tr style="border: none">
              <td style="border: none; width: 105mm; font-size: 14px; text-align: left">Total base imponible ISLR:</td>
              <td style="border: none; width: 1mm; font-size: 14px; text-align: center"></td>
              <td style="border: none; width: 1mm; font-size: 14px; text-align: left"></td>
              <td style="border: none; width: 9mm; font-size: 14px; text-align: center; font-weight: bold"></td>
              <td style="border: none; width: 9mm; font-size: 14px; text-align: center; font-weight: bold"></td>
              <td style="border: none; width: 12mm; font-size: 14px; text-align: center; font-weight: bold"><?php echo number_format($monto_total_bolivares, 2, ',', '.')?></td>
              <td style="border: none; width: 25mm; font-size: 14px; text-align: center"></td>
            </tr>

            <tr style="border: none">
              <td style="border: none; width: 105mm; font-size: 14px; text-align: left">Menos retención del <?php echo number_format($impuestos['valor1'], 0)?>% de IMPUESTOS SOBRE LA RENTA:</td>
              <td style="border: none; width: 1mm; font-size: 14px; text-align: center"></td>
              <td style="border: none; width: 1mm; font-size: 14px; text-align: left"></td>
              <td style="border: none; width: 9mm; font-size: 14px; text-align: center; font-weight: bold"></td>
              <td style="border: none; width: 9mm; font-size: 14px; text-align: center; font-weight: bold"></td>
              <td style="border: none; width: 12mm; font-size: 14px; text-align: center; font-weight: bold"><?php echo number_format($islr, 2, ',', '.')?></td>
              <td style="border: none; width: 25mm; font-size: 14px; text-align: center"><?php echo $cta3?></td>
            </tr>

            <tr style="border: none">
              <td style="border: none; width: 105mm; font-size: 14px; text-align: left">Total a restar por descuento o anticipo:</td>
              <td style="border: none; width: 1mm; font-size: 14px; text-align: center"></td>
              <td style="border: none; width: 1mm; font-size: 14px; text-align: left"></td>
              <td style="border: none; width: 9mm; font-size: 14px; text-align: center; font-weight: bold"></td>
              <td style="border: none; width: 9mm; font-size: 14px; text-align: center; font-weight: bold"></td>
              <td style="border: none; width: 12mm; font-size: 14px; text-align: center; font-weight: bold"><?php echo number_format($descuento, 2, ',', '.')?></td>
              <td style="border: none; width: 25mm; font-size: 14px; text-align: center"><?php echo $ctades?></td>
            </tr>
          </tbody>
        </table>

        <div></div>

        <table style="width: 210mm; position: relative; top: -5px">
          <thead>
            <tr>
              <th style="border: none;"></th>
              <th style="border: none;"></th>
              <th style="border: none;"></th>
              <th style="border: none;"></th>
              <th style="border: none;"></th>
              <th style="border: none;"></th>
              <th style="border: none;"></th>
            </tr>
          </thead>
          <tbody style="border: none">
            <tr style="border: none">
              <td style="border: none; width: 105mm; font-size: 14px; text-align: left">----------------------------------------->>> TOTAL A PAGAR ------>:</td>
              <td style="border: none; width: 1mm; font-size: 14px; text-align: center"></td>
              <td style="border: none; width: 1mm; font-size: 14px; text-align: left"></td>
              <td style="border: none; width: 9mm; font-size: 14px; text-align: center"></td>
              <td style="border: none; width: 9mm; font-size: 14px; text-align: center; font-weight: bold"></td>
              <td style="border: none; width: 12mm; font-size: 14px; text-align: center; font-weight: bold"><?php echo number_format(($monto_total_bolivares - $descuento - $islr), 2, ',', '.')?></td>
              <td style="border: none; width: 25mm; font-size: 14px; text-align: center; font-weight: bold">1.1.1.2.84</td>
            </tr>
          </tbody>
        </table>

        <div></div>
        <div></div>

        <!--<div style="font-size: 14px; font-weight: bold">ANTICIPOS</div>-->
        <div></div>

        <div></div>
        <div></div>

        <div style="font-size: 14px">Autorizo a Clínica Oftalmológica Castillo Inciarte C.A. para que actua como Agente de Cobro</div>

        <div></div>
        <div></div>

        <div style="position: relative;">
          
          <div style="width: 90mm; position: absolute; right: 0px">
            <div style="text-align:center; font-size: 14px">
                RECIBE CONFORME:
            </div>
            <div></div>
            <div style="text-align:center; font-size: 14px">
              __________________________________
            </div>
            <div style="text-align:center; font-size: 14px; font-weight: bold">
              <?php echo $desc_bare?>
            </div>
            <div style="text-align:center; font-size: 14px; font-weight: bold">
              C.I: <?php echo $cedula_bare?>
            </div>
          </div>

        </div>

    </div>


</page>

<?php

$negar = false;

if ($monto_total_bolivares > $impuestos['limite'] && $negar == true) {?>

<page style="width:200mm" backtop="15mm" backbottom="5mm" backleft="6mm" backright="4mm">

  <div class="separador" style="font-weight:bold; position: relative;"></div>

  <div style="text-align: center; font-weight: bold">
    CLÍNICA OFTALMOLÓGICA CASTILLO INCIARTE Y ASOCIADOS C.A.
  </div>

  <div id="subcabecera" class="centrar" style="font-weight:bold; font-size: 12px; position: relative; width: 120mm; left: 40mm">
    <?php echo $_SESSION['informacion_subcabecera_reportes'];?>
  </div>

  <div style="text-align: center; font-weight: bold">
    RIF: J-30403474-1
  </div>

  <div class="separador" style="font-weight:bold; position: relative; top: 8px"></div>

  <div></div>
  <div></div>

  <div style="text-align: center; font-size: 20px; font-weight: bold">COMPROBANTE DE RETENCIÓN I.S.L.R:</div>
  <div style="text-align: center; font-size: 20px; font-weight: bold">MES DE <?php echo strtoupper(strftime("%B", $timestamp->getTimestamp()));?> <?php echo date("Y", $fecha);?></div>

  <div></div>
  <div></div>
  <div></div>

  <table>
    <thead>
      <tr>
        <th style="font-size: 16px; width: 110mm"></th>
        <th style="font-size: 16px; width: 40mm">MONTO PAGADO</th>
        <th style="font-size: 16px; width: 40mm">MONTO RETENIDO</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td style="font-size: 16px; border:none; width: 110mm"><?php echo $desc_bare?></td>
        <td style="font-size: 16px; border:none; width: 40mm; text-align: center"> <?php echo number_format($monto_total_bolivares, 2, ',', '.')?></td>
        <td style="font-size: 16px; border:none; width: 40mm; text-align: center"><?php echo number_format($islr, 2, ',', '.')?></td>
      </tr>
      <tr>
        <td style="font-size: 16px; border:none; width: 110mm"><?php echo strtoupper($baremoPrincipal['rif'])?></td>
        <td style="font-size: 16px; border:none; width: 40mm"></td>
        <td style="font-size: 16px; border:none; width: 40mm"></td>
      </tr>
      <!-- <tr>
        <td style="font-size: 16px; border:none; width: 110mm">Fecha: <?php echo $dia?></td>
        <td style="font-size: 16px; border:none; width: 40mm"></td>
        <td style="font-size: 16px; border:none; width: 40mm"></td>
      </tr> -->
    </tbody>
  </table>

  <div style="position: relative; top: 60px; font-size: 16px; font-weight: bold">
    San Cristóbal,  <?php echo date("d", $fecha);?> de <?php echo strtoupper(strftime("%B", $timestamp->getTimestamp()));?> <?php echo date("Y", $fecha);?>
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
        $width = 216;
        $height = 280;
        $html2pdf = new HTML2PDF('P', array($width,$height, 0, 0), 'en', true, 'UTF-8', array(0, 0, 0, 0));
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));

        $hora   = $obj->fechaHora('America/Caracas','H-i-s');
        $obj->fechaHora('America/Caracas','d-m-Y');
        $nombre = /*$dia.'-'.*/$hora;

        if ($pdf == 1) {
          $html2pdf->output("../reportes/honorarios/honorarios$nombre.pdf", "f");
        } else if ($pdf == 2) {
          $html2pdf->Output("../reportes/honorarios/honorarios$nombre.pdf");
        } else {  
          $html2pdf->Output("../reportes/honorarios/honorarios$nombre.pdf");
          $html2pdf->output("../reportes/honorarios/honorarios$nombre.pdf", "f");
        }
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
  }
?>