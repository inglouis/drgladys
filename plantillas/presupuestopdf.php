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

  //--------------------------------------------------
  //VARIABLES GENERALES
  //--------------------------------------------------
  if (isset($_REQUEST['pdf'])) {
    $pdf = (int)$_REQUEST['pdf'];
  } else {
    $pdf = 2;
  }

  if (isset($_REQUEST['id'])) {
    $id = (int)$_REQUEST['id'];
  } else {
     throw new Exception('operación inválida: ID necesario para presupuesto'); 
  }

  if (isset($_REQUEST['modo'])) {
    $modo = $_REQUEST['modo'];
  } else {
     throw new Exception('operación inválida: MODO necesario para presupuesto'); 
  }

  if($modo == 'temporal') {
      $datos = json_decode($obj->seleccionar("
        select a.*, b.*, TO_CHAR(a.fecha :: DATE, 'dd/mm/yyyy') as fecha_arreglada, b.apel_nomb, c.desc_bare, d.nombre as cirugia, e.desc_segu
        from presupuestos.presupuesto_temp as a
        inner join historias.entradas as b using(id_historia)
        left join facturacion.baremos as c on a.id_baremo = c.id_principal
        left join historias.cirugias as d using(id_cirugia)
        left join facturacion.seguros as e using(id_seguro)
      where a.id_presupuesto = ?", [$id]), true)[0];
      

      if (isset($_REQUEST['id_presupuesto'])) {
        
        $datos['id_presupuesto'] = $_REQUEST['id_presupuesto'];

      } else {

        $datos['id_presupuesto'] = $obj->i_pdo("select coalesce(NULLIF(max(id_presupuesto) + 1, null), 1) as id_presupuesto from presupuestos.presupuesto", [], true)->fetchColumn();

      }

      //eliminar
      //$obj->e_pdo("delete from presupuestos.presupuesto_temp where id_presupuesto = $id");
  
  } else {
      $datos = json_decode($obj->seleccionar("
        select a.*, b.*, TO_CHAR(a.fecha :: DATE, 'dd/mm/yyyy') as fecha_arreglada, b.apel_nomb, c.desc_bare, d.nombre as cirugia, e.desc_segu
        from presupuestos.presupuesto as a
        inner join historias.entradas as b using(id_historia)
        left join facturacion.baremos as c on a.id_baremo = c.id_principal
        left join historias.cirugias as d using(id_cirugia)
        left join facturacion.seguros as e using(id_seguro)
      where a.id_presupuesto = ?", [$id]), true)[0];
  }
  setlocale(LC_ALL,"es_ES@euro","es_ES","esp");

  $dia  = $obj->fechaHora('America/Caracas','d-m-Y');
  $hora = $obj->fechaHora('America/Caracas','H:i:s');
  $edad = $obj->calcularEdad($datos['fech_naci']);

  $timestamp = strtotime($dia);
  //print_r($datos);


  //--------------------------------------------------
  //VARIABLES ESPECIFICAS
  //--------------------------------------------------

  if (isset($_REQUEST['normas_cirugia'])) {
    $normas_cirugia = (int)$_REQUEST['normas_cirugia'];
  } else {
     throw new Exception('operación inválida: NORMAS CIRUGIA necesario para reporte rápido'); 
  }

  if (isset($_REQUEST['igtf'])) {
    $check_igtf = (int)$_REQUEST['igtf'];
  } else {
    $check_igtf = 0;
  }

  if (isset($_REQUEST['normas_retina'])) {
    $normas_retina = (int)$_REQUEST['normas_retina'];
  } else {
     throw new Exception('operación inválida: NORMAS RETINA necesario para reporte rápido'); 
  }

  if (isset($_REQUEST['normas_laser'])) {
    $normas_laser = (int)$_REQUEST['normas_laser'];
  } else {
     throw new Exception('operación inválida: NORMAS LASER necesario para reporte rápido'); 
  }

  /*----*/
  if (isset($_REQUEST['informe_medico'])) {
    $informe_medico = (int)$_REQUEST['informe_medico'];
  } else {
     throw new Exception('operación inválida: INFORME MEDICO necesario para reporte rápido'); 
  }

  if (isset($_REQUEST['examen_lab'])) {
    $exalab = (int)$_REQUEST['examen_lab'];
  } else {
     throw new Exception('operación inválida: EXALAB necesario para reporte rápido'); 
  }

  if (isset($_REQUEST['cardiovascular'])) {
    $cardiovascular = (int)$_REQUEST['cardiovascular'];
  } else {
     throw new Exception('operación inválida: CARDIOVASCULAR necesario para reporte rápido'); 
  }

  if (isset($_REQUEST['torax'])) {
    $torax = (int)$_REQUEST['torax'];
  } else {
     throw new Exception('operación inválida: TORAX necesario para reporte rápido'); 
  }


  if($normas_cirugia == 1) {

  }

  if($normas_retina == 1) {

  }

  if($normas_laser == 1) {

  }

  if ($exalab == 1) {
    if($datos['exalab'] == 'A') {
      $examen_lab = [
        'X','X','X','X','X','X','X','X','X','X','X','X','X','X','X','X','X','X','X','X','X','X'
      ];
    } else if ($datos['exalab'] == 'N') {
      $examen_lab = [
        'X','X','','','','','X','X','X','','X','','X','X','X','','','','X','','',''
      ];
    } else {
      $examen_lab = [
        'X','X','X','X','X','X','X','X','X','X','X','X','X','X','X','X','X','X','X','X','X','X'
      ];
    }
  }

  if($cardiovascular == 1) {
    $preoperatorio = $obj->e_pdo("select nombre from historias.cirugias where id_cirugia = $datos[cardio]")->fetchColumn();
  }

  // echo "<pre>";
  // print_r(json_decode($datos['totales'], true));
  // echo "</pre>";

  // echo "<pre>";
  // print_r(json_decode($datos['detalle_servicios'], true));
  // echo "</pre>";

  // echo "<pre>";
  // print_r($datos['conversiones']);
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

      table tbody tr td, table thead tr th {
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

	$totales = json_decode($datos['totales'], true);
  $mqi = 0;

	$detalle_honorarios = json_decode($datos['detalle_honorarios'], true);
	$detalle_servicios = json_decode($datos['detalle_servicios'], true);
	$conversiones = json_decode($datos['conversiones'], true);
	
?>

<page style="width:100%" backtop="0mm" backbottom="5mm" backleft="6mm" backright="5mm">
	<div class="contenedor">
		<div id="cabecera" style="height: 70px">
			<div style="position:relative;">
				<h4 id="titulo1" style="">CLÍNICA OFTALMOLÓGICA</h4>
				<h4 id="titulo2">DR. CASTILLO INCIARTE Y ASOCIADOS C.A</h4>
			</div> 
		</div> 
		  <div id="subcabecera" class="centrar" style="font-size: 9px; top: 3px; position: relative;">
        <?php echo $_SESSION['informacion_subcabecera_reportes'];?>
      </div>
	    <div id="subcabecera" class="centrar">
	    	RIF J-30403471-1
	    </div>

	    <div class="separador"></div>

		<div style="position: absolute;  top: 5mm; left: 0mm">
			<img src="../imagenes/logo_reportes.jpg" style="width: 30mm; height: 23mm;">
		</div>

		<table style="width: 200mm; border:none; position: relative; top: -10px">
			<tbody>
				<tr>
					<td style="width: 25mm; border:none;">Presupuesto N°:</td>
					<td style="width: 100mm; border:none;"><?php echo $datos['id_presupuesto']?></td>
				</tr>
			</tbody>
		</table>

		<table style="width: 200mm; border:none; position: relative; top: -5px">
			<tbody>
				<tr>
					<td style="width: 25mm; border:none;">Médico:</td>
					<td style="width: 100mm; border:none;"><?php echo $datos['desc_bare']?></td>
				</tr>
			</tbody>
		</table>

		<table style="width: 200mm; border:none; position: relative;top: -5px">
			<tbody>
				<tr>
					<td style="width: 25mm; border:none;">Paciente:</td>
					<td style="width: 100mm; border:none;"><?php echo $datos['apel_nomb'].' - N° HISTORIA:'.$datos['id_historia']?></td>
				</tr>
			</tbody>
		</table>

		<table style="width: 200mm; border:none; position: relative;top: -5px">
			<tbody>
				<tr>
					<td style="width: 25mm; border:none;">Código N°:</td>
					<td style="width: 100mm; border:none;"><?php echo $datos['id_cirugia']?></td>
				</tr>
			</tbody>
		</table>

		<table style="width: 200mm; border:none; position: relative;top: -5px">
			<tbody>
				<tr>
					<td style="width: 25mm; border:none;">Diagnóstico:</td>
					<td style="width: 100mm; border:none;"><?php echo $datos['cirugia']?></td>
				</tr>
			</tbody>
		</table>

		<div class="separador"></div>

		<table style="width: 200mm; border:none; position: relative;top: -15px">
			<tbody>
				<tr>
					<td style="width: 25mm; border:none;">Responsable:</td>
					<td style="width: 100mm; border:none;"><?php echo $datos['desc_segu']?></td>
				</tr>
			</tbody>
		</table>

		<table style="width: 200mm; border:none; position: relative;top: -5px">
			<tbody>
				<tr>
					<td style="width: 25mm; border:none;">Fecha:</td>
					<td style="width: 100mm; border:none;"><?php echo $datos['fecha_arreglada']?></td>
				</tr>
			</tbody>
		</table>

		<div class="separador"></div>

		<table style="width: 200mm; position: relative; top: -10px">
			<thead>
				<tr style="border: 1px solid #262626">
					<th style="border-bottom: 1px dotted #262626">DESCRIPCIONES</th>
          <th style="border-bottom: 1px dotted #262626">CANTIDAD</th>
					<th style="border-bottom: 1px dotted #262626; text-align: right;">Bs</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($detalle_servicios as $r) :

          if ($r['id_servicio'] != $_SESSION['material_quirurgico_interno']) {
        ?>
				<tr>
					<td style="width: 155mm"><?php echo $r['descripcion']?>:</td>
          <td style="width: 15mm; text-align: center"><?php echo $r['cantidad']?></td>
					<td style="width: 14mm; text-align: right;">
            <?php 
              echo number_format(($r['costo_dolares'] * $r['cantidad']) * $conversiones[2], 2, ',', '.');
            ?> 
          </td>
				</tr>
				<?php 
          } else {

            $mqi = (float)number_format(($r['costo_dolares'] * $r['cantidad']) * $conversiones[2], 2, ',', '.');

          }
        endforeach;?>
			</tbody>
		</table>

		<div class="separador"></div>

		<table style="width: 200mm; position: relative; top: -10px">
			<tbody>
				<tr>
					<td style="width: 95mm">TOTAL SERVICIOS:</td>
					<td style="width: 95mm; text-align: right;"><?php echo number_format(($totales['total_servicio'] * $conversiones[2]), 2, ',', '.')?></td>
				</tr>
			</tbody>
		</table>

		<div class="separador"></div>

		<table style="width: 200mm; position: relative; top: -10px">
			<tbody>
				<?php foreach ($detalle_honorarios as $r) :?>
				<tr>
					<td style="width: 95mm"><?php echo $r['descripcion']?>:</td>
					<td style="width: 95mm; text-align: right;"><?php echo number_format($r['costo_dolares'] * $conversiones[2], 2, ',', '.'); ?></td>
				</tr>
				<?php endforeach;?>
			</tbody>
		</table>

		<div class="separador"></div>

		<table style="width: 200mm; position: relative; top: -10px">
			<tbody>
				<tr>
					<td style="width: 95mm">TOTAL HONORARIOS:</td>
					<td style="width: 95mm; text-align: right;"><?php echo number_format($totales['total_honorario'] * $conversiones[2], 2, ',', '.');?></td>
				</tr>
			</tbody>
		</table>

		<div class="separador"></div>

		<table style="width: 200mm; position: relative; top: -10px">
			<tbody>
				<tr>
					<td style="width: 95mm">TOTAL GENERAL:</td>
					<td style="width: 95mm; text-align: right;">
            <?php 
              echo number_format(($totales['total_servicio'] * $conversiones[2]) + ($totales['total_honorario'] * $conversiones[2]), 2, ',', '.');
            ?>
          </td>
				</tr>
			</tbody>
		</table>

    <?php if ($check_igtf == 1) {?>

    <div class="separador"></div>

    <table style="width: 200mm; position: relative; top: -10px">
      <tbody>
        <tr>
          <td style="width: 175mm">NOTA:  De acuerdo a la Providencia Administrativa publicada en 6.0 N°. 42339 de fecha 17-03-2022. Se hará la percepción del <b>3%</b> del <b>IGTF</b> por el pago en divisas por Bolívares:</td>
          <td style="width: 15mm; text-align: right;">
            <?php 
              echo number_format((($totales['total_servicio'] * $conversiones[2]) * 3) / 100, 2, ',', '.');
            ?>
          </td>
        </tr>
      </tbody>
    </table>

  <?php } ?>

		<div class="separador"></div>

		<div style="font-size: 12px; margin-top: 5px; margin-left: 35px">ESTE PRESUPUESTO TENDRÁ UNA VALIDEZ DE 48 HORAS</div>

		<table style="width: 200mm; margin-top: 10px">
			<tbody>
				<tr>
					<td style="width: 95mm; border:none">ORIGINAL</td>
					<td style="width: 95mm; border:none; text-align: right;"><div style="width: 65mm; border-top: 0.5px solid black; text-align: center">LA ADMINISTRACIÓN</div></td>
				</tr>
			</tbody>
		</table>
	</div>
</page>

<!------------------------------------------------------------------------------>
<!---------------------------PRESUPUESTO CHIKITO-------------------------------->
<!------------------------------------------------------------------------------>
<page style="width:100mm; height: 680mm !important" backtop="15mm" backbottom="0mm" backleft="0mm" backright="0mm">
  <div class="contenedor" style="rotate:90; top: -15px; left: -10px; width: 120mm; position: relative;">
    <div id="cabecera" style="height: 0px; top: -40px">
      <div style="position:relative; width: 120mm; top: -5px">
        <h4 id="titulo1" style="font-size: 13px;">CLÍNICA OFTALMOLÓGICA</h4>
        <h4 id="titulo2" style="font-size: 10px; top: 47px">DR. CASTILLO INCIARTE Y ASOCIADOS C.A</h4>
      </div> 
    </div> 

    <div id="subcabecera" class="centrar" style="font-size: 9px;width: 90mm; top: -35px;position: relative; left: 60px">
       <?php echo $_SESSION['informacion_subcabecera_reportes'];?>
    </div>

    <div id="subcabecera" class="centrar" style="font-size: 10px;width: 120mm; top: 0px; position: relative;">
      RIF J-30403471-1
    </div>

    <div class="separador" style="width: 120mm; position: relative; top: -5px"></div>

    <div style="position: absolute;  top: 8mm; left: 0mm; width: 120mm; position: absolute;">
      <img src="../imagenes/logo_reportes.jpg" style="width: 15mm; height: 10mm;">
    </div>

    <div style="font-size: 10px; top: -5px; position: relative;">
      <b>Presupuesto N°:</b> <?php echo $datos['id_presupuesto']?> &nbsp;&nbsp;<b>Cédula/Rif:</b><?php echo strtoupper($datos['nume_cedu'])?>
    </div>

    <div style="font-size: 10px; top: -5px; position: relative;">
      <b>Médico:</b><span  style="margin-left: 43px;"><?php echo $datos['desc_bare']?></span>
    </div>

    <div style="font-size: 10px; top: -5px; position: relative;">
      <b>Paciente:</b><span  style="margin-left: 36px;"><?php echo $datos['apel_nomb'].' - N° HISTORIA:'.$datos['id_historia']?></span>
    </div>

    <div style="font-size: 10px; top: -5px; position: relative;">
      <b>Diagnóstico:</b><span  style="margin-left: 20px;"><?php echo $datos['cirugia']?></span>
    </div>

    <div class="separador" style="width: 120mm"></div>

    <div style="font-size: 10px; top: -5px; position: relative;">
      <b>Código N°:</b><span  style="margin-left: 30px;"><?php echo $datos['id_cirugia']?></span>
    </div>

    <div style="font-size: 10px; top: -5px; position: relative;">
      <b>Responsable:</b><span  style="margin-left: 15px;"><?php echo $datos['desc_segu']?></span>
    </div>

    <div style="font-size: 10px; top: -5px; position: relative;">
      <b>Fecha:</b><span  style="margin-left: 50px;"><?php echo $datos['fecha_arreglada']?></span>
    </div>

    <div class="separador" style="width: 120mm;"></div>

    <table style="width: 120mm; position: relative; top: -10px">
      <thead>
        <tr style="border: 1px solid #262626">
          <th style="font-size:10px; border-bottom: 1px dotted #262626">DESCRIPCIONES</th>
          <th style="font-size:10px; border-bottom: 1px dotted #262626">CANTIDAD</th>
          <th style="font-size:10px; border-bottom: 1px dotted #262626; text-align: right;">Bs</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($detalle_servicios as $r) :

          if ($r['id_servicio'] != $_SESSION['material_quirurgico_interno']) {
        ?>
        <tr>
          <td style="padding:0px; height: 4px; border:none; font-size:9px; width: 87mm; "><?php echo $r['descripcion']?>:</td>
          <td style="padding:0px; height: 4px; border:none; font-size:9px; width: 12mm; text-align: center"><?php echo $r['cantidad']?></td>
          <td style="padding:0px; height: 4px; border:none; font-size:9px; width: 14mm; text-align: right;">
            <?php 
              echo number_format(($r['costo_dolares'] * $r['cantidad']) * $conversiones[2], 2, ',', '.');
            ?> 
          </td>
        </tr>
        <?php 
          } else {

            $mqi = (float)number_format(($r['costo_dolares'] * $r['cantidad']) * $conversiones[2], 2);

          }
        endforeach;?>
      </tbody>
    </table>

    <div class="separador" style="width: 120mm;"></div>

    <table style="width: 120mm; position: relative; top: -10px">
      <tbody>
        <tr>
          <td style="font-size:12px; width: 65mm">TOTAL SERVICIOS:</td>
          <td style="font-size:12px; width: 44mm; text-align: right;"><?php echo number_format(($totales['total_servicio'] * $conversiones[2]), 2, ',', '.')?></td>
        </tr>
      </tbody>
    </table>

    <div class="separador" style="width: 120mm;"></div>

    <table style="width: 120mm; position: relative; top: -10px">
      <tbody>
        <?php foreach ($detalle_honorarios as $r) :?>
        <tr>
          <td style="padding:0px; height: 4px; border:none; font-size:9px; width: 74mm;"><?php echo $r['descripcion']?>:</td>
          <td style="padding:0px; height: 4px; border:none; font-size:9px;; width: 44mm; text-align: right;"><?php echo number_format($r['costo_dolares'] * $conversiones[2], 2, ',', '.'); ?></td>
        </tr>
        <?php endforeach;?>
      </tbody>
    </table>

    <div class="separador" style="width: 120mm;"></div>

    <table style="width: 120mm; position: relative; top: -10px">
      <tbody>
        <tr>
          <td style="width: 65mm">TOTAL HONORARIOS:</td>
          <td style="width: 44mm; text-align: right;"><?php echo number_format($totales['total_honorario'] * $conversiones[2], 2, ',', '.');?></td>
        </tr>
      </tbody>
    </table>

    <div class="separador" style="width: 120mm;"></div>

    <table style="width: 120mm; position: relative; top: -10px">
      <tbody>
        <tr>
          <td style="width: 65mm">TOTAL GENERAL:</td>
          <td style="width: 44mm; text-align: right;">
            <?php 
              echo number_format(($totales['total_servicio'] * $conversiones[2]) + ($totales['total_honorario'] * $conversiones[2]), 2, ',', '.');
            ?>
          </td>
        </tr>
      </tbody>
    </table>

    <div class="separador" style="width: 120mm;"></div>

    <table style="width: 120mm; position: relative; top: -10px">
      <tbody>
        <tr>
          <td style="width: 94mm">IGTF:</td>
          <td style="width: 15mm; text-align: right;">
            <?php 
              echo number_format((($totales['total_servicio'] * $conversiones[2]) * 3) / 100, 2, ',', '.');
            ?>
          </td>
        </tr>
      </tbody>
    </table>

    <div class="separador" style="width: 120mm;"></div>

    <table style="width: 120mm; position: relative; margin-top: 0px;">
      <tbody>
        <tr>
          <td style="width: 10mm; border:none">COPIA</td>
          <td style="width: 40mm; border:none; text-align: right;"><div style="width: 35mm; border-top: 0.5px solid black; text-align: center">HECHO POR</div></td>
          <td style="width: 50mm; border:none; text-align: right;"><div style="width: 35mm; border-top: 0.5px solid black; text-align: center">LA ADMINISTRACIÓN</div></td>
        </tr>
      </tbody>
    </table>
  </div>

  <!--/////////////////////////////////////////////////////-->
  <div class="contenedor" style="rotate:90; top: 80mm; left: -10px; width: 120mm; position: absolute; padding-right: 26.5mm">

    <div style="position:relative; width: 120mm; top: 7mm">
      <h4 id="titulo1" style="font-size: 13px;">CLÍNICA OFTALMOLÓGICA</h4>
      <h4 id="titulo2" style="font-size: 10px; top: 47px">DR. CASTILLO INCIARTE Y ASOCIADOS C.A</h4>
    </div> 

    <div id="subcabecera" class="centrar" style="font-size: 9px;width: 90mm; top: 7px;position: relative; left: 60px">
       <?php echo $_SESSION['informacion_subcabecera_reportes'];?>
    </div>

    <div id="subcabecera" class="centrar" style="font-size: 10px;width: 120mm; top: 3px; position: relative;">
      RIF J-30403471-1
    </div>

    <div class="separador" style="width: 120mm; position: relative; top: -5px"></div>

    <div style="position: absolute;  top: 8mm; left: 0mm; width: 120mm; position: absolute;">
      <img src="../imagenes/logo_reportes.jpg" style="width: 15mm; height: 10mm;">
    </div>

    <div style="font-size: 10px; top: -5px; position: relative;">
      <b>Presupuesto N°:</b> <?php echo $datos['id_presupuesto']?> &nbsp;&nbsp;<b>Cédula/Rif:</b><?php echo strtoupper($datos['nume_cedu'])?>
    </div>

    <div style="font-size: 10px; top: -5px; position: relative;">
      <b>Médico:</b><span  style="margin-left: 43px;"><?php echo $datos['desc_bare']?></span>
    </div>

    <div style="font-size: 10px; top: -5px; position: relative;">
      <b>Paciente:</b><span  style="margin-left: 36px;"><?php echo $datos['apel_nomb'].' - N° HISTORIA:'.$datos['id_historia']?></span>
    </div>

    <div style="font-size: 10px; top: -5px; position: relative;">
      <b>Diagnóstico:</b><span  style="margin-left: 20px;"><?php echo $datos['cirugia']?></span>
    </div>

    <div class="separador" style="width: 120mm"></div>

    <div style="font-size: 10px; top: -5px; position: relative;">
      <b>Código N°:</b><span  style="margin-left: 30px;"><?php echo $datos['id_cirugia']?></span>
    </div>

    <div style="font-size: 10px; top: -5px; position: relative;">
      <b>Responsable:</b><span  style="margin-left: 15px;"><?php echo $datos['desc_segu']?></span>
    </div>

    <div style="font-size: 10px; top: -5px; position: relative;">
      <b>Fecha:</b><span  style="margin-left: 50px;"><?php echo $datos['fecha_arreglada']?></span>
    </div>

    <div class="separador" style="width: 120mm;"></div>

    <table style="width: 120mm; position: relative; top: -10px">
      <thead>
        <tr style="border: 1px solid #262626">
          <th style="font-size:10px; border-bottom: 1px dotted #262626">DESCRIPCIONES</th>
          <th style="font-size:10px; border-bottom: 1px dotted #262626">CANTIDAD</th>
          <th style="font-size:10px; border-bottom: 1px dotted #262626; text-align: right;">Bs</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($detalle_servicios as $r) :

          if ($r['id_servicio'] != $_SESSION['material_quirurgico_interno']) {
        ?>
        <tr>
          <td style="padding:0px; height: 4px; border:none; font-size:9px; width: 87mm; "><?php echo $r['descripcion']?>:</td>
          <td style="padding:0px; height: 4px; border:none; font-size:9px; width: 12mm; text-align: center"><?php echo $r['cantidad']?></td>
          <td style="padding:0px; height: 4px; border:none; font-size:9px; width: 14mm; text-align: right;">
            <?php 
              echo number_format(($r['costo_dolares'] * $r['cantidad']) * $conversiones[2], 2, ',', '.');
            ?> 
          </td>
        </tr>
        <?php 
          } else {

            $mqi = (float)number_format(($r['costo_dolares'] * $r['cantidad']) * $conversiones[2], 2);

          }
        endforeach;?>
      </tbody>
    </table>

    <div class="separador" style="width: 120mm;"></div>

    <table style="width: 120mm; position: relative; top: -10px">
      <tbody>
        <tr>
          <td style="font-size:12px; width: 65mm">TOTAL SERVICIOS:</td>
          <td style="font-size:12px; width: 44mm; text-align: right;"><?php echo number_format(($totales['total_servicio'] * $conversiones[2]), 2, ',', '.')?></td>
        </tr>
      </tbody>
    </table>

    <div class="separador" style="width: 120mm;"></div>

    <table style="width: 120mm; position: relative; top: -10px">
      <tbody>
        <?php foreach ($detalle_honorarios as $r) :?>
        <tr>
          <td style="padding:0px; height: 4px; border:none; font-size:9px; width: 74mm;"><?php echo $r['descripcion']?>:</td>
          <td style="padding:0px; height: 4px; border:none; font-size:9px;; width: 44mm; text-align: right;"><?php echo number_format($r['costo_dolares'] * $conversiones[2], 2, ',', '.'); ?></td>
        </tr>
        <?php endforeach;?>
      </tbody>
    </table>

    <div class="separador" style="width: 120mm;"></div>

    <table style="width: 120mm; position: relative; top: -10px">
      <tbody>
        <tr>
          <td style="width: 65mm">TOTAL HONORARIOS:</td>
          <td style="width: 44mm; text-align: right;"><?php echo number_format($totales['total_honorario'] * $conversiones[2], 2, ',', '.');?></td>
        </tr>
      </tbody>
    </table>

    <div class="separador" style="width: 120mm;"></div>

    <table style="width: 120mm; position: relative; top: -10px">
      <tbody>
        <tr>
          <td style="width: 65mm">TOTAL GENERAL:</td>
          <td style="width: 44mm; text-align: right;">
            <?php 
              echo number_format(($totales['total_servicio'] * $conversiones[2]) + ($totales['total_honorario'] * $conversiones[2]), 2, ',', '.');
            ?>
          </td>
        </tr>
      </tbody>
    </table>

    <div class="separador" style="width: 120mm;"></div>

    <table style="width: 120mm; position: relative; top: -10px">
      <tbody>
        <tr>
          <td style="width: 94mm">IGTF:</td>
          <td style="width: 15mm; text-align: right;">
            <?php 
              echo number_format((($totales['total_servicio'] * $conversiones[2]) * 3) / 100, 2, ',', '.');
            ?>
          </td>
        </tr>
      </tbody>
    </table>

    <div class="separador" style="width: 120mm;"></div>

    <table style="width: 120mm; position: relative; margin-top: 0px; top: -5px">
      <tbody>
        <tr>
          <td style="width: 10mm; border:none">COPIA</td>
          <td style="width: 40mm; border:none; text-align: right;"><div style="width: 35mm; border-top: 0.5px solid black; text-align: center">HECHO POR</div></td>
          <td style="width: 50mm; border:none; text-align: right;"><div style="width: 35mm; border-top: 0.5px solid black; text-align: center">LA ADMINISTRACIÓN</div></td>
        </tr>
      </tbody>
    </table>
  </div>
  <!--//////////////////////////////////////////////-->
</page>


<?php if($normas_cirugia == 1) {?>
<page style="width:92%" backtop="0mm" backbottom="5mm" backleft="6mm" backright="5mm">
  <div class="contenedor">
     <div id="cabecera" style="height: 70px">
      <div style="position:relative;">
        <h4 id="titulo1" style="">CLÍNICA OFTALMOLÓGICA</h4>
        <h4 id="titulo2">DR. CASTILLO INCIARTE Y ASOCIADOS C.A</h4>
      </div> 
      <h3 id="titulo3" style="margin-top: 5px">RIF: J-30403474-1</h3>
    </div> 
    <div style="height: 10px; margin-top: 20px">
      <div style="position:relative;">
        <h4 id="titulo1" style="">NORMAS PARA PACIENTES DE CIRUGÍA</h4>
      </div> 
    </div> 

    <div style="position: absolute;  top: 5mm; left: 0mm">
       <img src="../imagenes/logo_reportes.jpg" style="width: 30mm; height: 23mm;">
      </div>
    <div class="separador"></div>

    <div style="text-align: justify; font-size: 12px;">
      <div>
      * SI TOMA ASPIRINA O ANTICOAGULANTE, PREVIA AUTORIZACIÓN DE SU MÉDICO TRATANTE, SUSPENDER DÍAS 15 ANTES DE LA CIRUGÍA.
      </div>
      <div></div>
      <div>
      * TRAER RESULTADOS DE EXAMENES PRE OPERATORIOS INDICADOS COMPLETOS, PARA PODER PROGRAMAR SU CIRUGÍA.
      </div>
      <div></div>
     <div>
      * AL SABER LA FECHA DE LA CIRUGÍA EL PACIENTE DEBE ACUDIR A LA ADMINISTRACIÓN DE LA CLÍNICA EL DÍA ANTERIOR PARA LA TRAMITACIÓN DEL PAGO RESPECTIVO, DE LO CONTRARIO SERÁ OMITIDO EL CASO.
      </div> 
    </div>
    <div></div>
    <div class="separador"></div>
    <div style="font-size: 14px">
    * CUENTAS CORRIENTES A NOMBRE DE: CLÍNICA OFTALMOLÓGICA CASTILLO INCIARTE Y ASOSIADOS C.A.
    </div>

    <div></div>      
    <div style="text-align: justify; font-size: 14px; text-align: center;"><b>PROVINCIAL: 01080361640100014630  MERCANTIL.: 01050093191093041889</b></div>
    <div style="text-align: justify; font-size: 14px; text-align: center; padding-left: 0px"><b>SOFITASA....: 01370020670000130321  TESORO.......: 01630304603043005474</b></div>
    <div></div>

    <div class="separador"></div>

    <div style="text-align: justify; font-size: 12px; margin-bottom: 0px">
      <div>
        <b>ZELLE oeci50@gmail.com A NOMBRE DE OSCAR CASTILLO INCIARTE</b>
      </div>

      <div></div>
      <div class="separador"></div>

      <div style="font-size: 17px;">* Si cancela en moneda extranjera debe realizar el pago del IGTF en Bolívares (Bs.) por TRANSFERENCIA o PAGO MÓVIL</div>

      <div class="separador"></div>
      <div></div>

      <div>
        <b>BANCOLOMBIA: AHORROS 726-28297062 A NOMBRE DE: OSCAR E. CASTILLO INCIARTE C.C: 1.126.243.925.</b>
      </div>
      <div></div>
      <div class="separador"></div>
    </div>

    <div></div>

    <div style="text-align: justify; font-size: 12px;">
      <div>
      * DEBE LLAMAR EL DÍA ANTERIOR (MARTES)  A LAS 2.30 PM PARA INDICARLE LA HORA DE SU CIRUGÍA.
      </div>
      <div></div>
      <div>
      * SI TOMA MEDICAMENTOS PARA LA HIPERTENSIÓN ARTERIAL O GLICEMÍA NO DEBE SUSPENDERLOS TOMARLOS A SU HORA CON POCA AGUA.
      </div>
      <div></div>
      <div>
      * NO  COMER NI TOMAR NINGÚN LÍQUIDO SEIS HORAS ANTES DE LA CIRUGÍA.
      </div>
      <div></div>
      <div>
      * A LAS DAMAS SE RECOMIENDA NO UTILIZAR MAQUILLAJE, NI ESMALTE DE UÑAS Y NO TRAER NINGÚN TIPO DE JOYAS.
      </div>
      <div></div>
      <div>
      * BAÑARSE BIEN EL DÍA DE LA CIRUGÍA ESPECIALMENTE EL CABELLO Y LA CARA.
      </div>
      <div></div>
      <div>
      * ES INDISPENSABLE TRAER LOS EXÁMENES PRE OPERATORIOS EL DÍA DE LA CIRUGÍA.
      </div>
      <div></div>
      <div>
      * SE RECOMIENDA VENIR CON UN SOLO ACOMPAÑANTE CUMPLIENDO LAS NORMAS DE BIOSEGURIDAD. NO QUITARSE LA MASCARILLA EN NINGÚN MOMENTO.
      </div>
      <div></div>
      <div>
      * LA CIRUGÍA INCLUYE 1 CONTROL POST OPERATORIO SIN COSTO. LOS CONTROLES SUCESIVOS SERÁN PAGOS.
      </div>
    </div style="margin-bottom: 5px">
    <div class="separador"></div>
    
    <div id="subcabecera" class="centrar">
      A.19 de Abril Edf. Clínica de Ojos P.B. La Bermeja - San Cristóbal Edo.Táchira
    </div>
    <div id="subcabecera" class="centrar" style="font-weight: bold">
      TF: 3560133 - 3560139 - 3560141 - 3560137  FAX: 3558633
    </div>

    <div id="subcabecera" class="centrar" style="font-weight: bold">
      e-mail: clicastillo96@gmail.com
    </div>
  </div>  
</page>
<?php }?>

<?php if($normas_retina == 1) { ?>
<page style="width:92%" backtop="0mm" backbottom="5mm" backleft="6mm" backright="5mm">
  <div class="contenedor">
    <div id="cabecera" style="height: 70px">
      <div style="position:relative;">
        <h4 id="titulo1" style="">CLÍNICA OFTALMOLÓGICA</h4>
        <h4 id="titulo2">DR. CASTILLO INCIARTE Y ASOCIADOS C.A</h4>
      </div> 
      <h3 id="titulo3" style="margin-top: 5px">RIF: J-30403474-1</h3>
    </div> 
    <div style="height: 10px; margin-top: 20px">
      <div style="position:relative;">
        <h4 id="titulo1" style="">NORMAS PARA PACIENTES DE CIRUGÍA DE RETINA</h4>
      </div> 
    </div> 
    <div style="position: absolute;  top: 5mm; left: 0mm">
     <img src="../imagenes/logo_reportes.jpg" style="width: 30mm; height: 23mm;">
    </div>
    <div class="separador"  style="margin-bottom: 5px"></div>

      <div style="text-align: justify; font-size: 12px;">
        <div>
        * SI TOMA ASPIRINA O ANTICOAGULANTE, PREVIA AUTORIZACIÓN DE SU MÉDICO TRATANTE, SUSPENDER 15 DÍAS ANTES DE LA CIRUGÍA.
        </div>
        <div></div>
        <div>
        * TRAER RESULTADOS DE EXÁMENES PRE OPERATORIOS INDICADOS COMPLETOS, PARA PODER PROGRAMAR SU CIRUGÍA.
        </div>
        <div></div>
        <div>
        * AL SABER LA FECHA DE LA CIRUGÍA EL PACIENTE DEBE ACUDIR A LA ADMINISTRACIÓN DE LA CLINÍCA EL DÍA ANTERIOR PARA LA TRAMITACIÓN DEL PAGO  RESPECTIVO, DE  LO CONTRARIO SERÁ OMITIDO EL CASO.
        </div>
        <div></div>

        <div class="separador"  style="margin-bottom: 15px"></div>
        <div  style="margin-bottom: 5px; font-size: 14px">
         * CUENTAS CORRIENTES A NOMBRE DE CLÍNICA OFTALMOLÓGICA CASTILLO INCIARTE Y ASOCIADOS, C.A.
        </div>

        <div></div>      
        <div style="text-align: justify; font-size: 14px; text-align: center;"><b>PROVINCIAL: 01080361640100014630  MERCANTIL.: 01050093191093041889</b></div>
        <div style="text-align: justify; font-size: 14px; text-align: center; padding-left: 0px"><b>SOFITASA....: 01370020670000130321  TESORO.......: 01630304603043005474</b></div>
        <div></div>
      </div>
      <div></div>

      <div class="separador"></div>

      <div style="text-align: justify; font-size: 12px; margin-bottom: 0px">
        <div>
          <b>ZELLE oeci50@gmail.com A NOMBRE DE OSCAR CASTILLO INCIARTE</b>
        </div>

        <div></div>
        <div class="separador"></div>

        <div style="font-size: 17px;">* Si cancela en moneda extranjera debe realizar el pago del IGTF en Bolívares (Bs.) por TRANSFERENCIA o PAGO MÓVIL</div>

        <div class="separador"></div>
        <div></div>

        <div>
          <b>BANCOLOMBIA: AHORROS 726-28297062 A NOMBRE DE: OSCAR E. CASTILLO INCIARTE C.C: 1.126.243.925.</b>
        </div>
        <div></div>
        <div class="separador"></div>
      </div>

      <div></div>

      <div style="text-align: justify; font-size: 12px; margin-top:5px">
        <div>
        * DEBE LLAMAR EL DÍA MARTES A LAS 2:30 PM PARA INDICARLE LA HORA DE LA CIRUGÍA.
        </div>
        <div></div>
        <div>
        * SI TOMA MEDICAMENTOS PARA LA HIPERTENSIÓN ARTERIAL O GLICEMIA NO DEBE SUSPENDERLOS DEBE TOMARLOS A SU HORA CON POCA AGUA.
        </div>
        <div></div>
        <div style="margin-bottom: 5px">
        * NO COMER NI TOMAR NINGÍN LÍQUIDO SEIS HORAS ANTES DE LA CIRUGÍA..
        </div>
      </div>
    <div class="separador"></div>
    
    <div id="subcabecera" class="centrar"  style="margin-top: 20px;">
      A.19 de Abril Edf. Clínica de Ojos P.B. La Bermeja - San Cristóbal Edo.Táchira. VENEZUELA.
    </div>
    <div id="subcabecera" class="centrar" style="font-weight: bold">
      TF: 3560133 - 3560139 - 3560141 - 3560137  FAX: 0276-3558633
    </div>
    <div id="subcabecera" class="centrar" style="font-weight: bold">
      e-mail: clicastillo96@gmail.com
    </div>
  </div>  
</page>

<?php }?>

<?php if ($normas_laser == 1) {?>
<page style="width:92%" backtop="0mm" backbottom="5mm" backleft="6mm" backright="5mm">
  <div class="contenedor">
     <div id="cabecera" style="height: 70px">
      <div style="position:relative;">
        <h4 id="titulo1" style="">CLÍNICA OFTALMOLÓGICA</h4>
        <h4 id="titulo2">DR. CASTILLO INCIARTE Y ASOCIADOS C.A</h4>
      </div> 
      <h3 id="titulo3" style="margin-top: 5px">RIF: J-30403474-1</h3>
    </div> 
    <div style="height: 10px; margin-top: 20px">
      <div style="position:relative;">
        <h4 id="titulo1" style="">NORMAS PARA LA APLICACIÓN DE RAYOS LASER</h4>
      </div> 
    </div>

    <div style="position: absolute;  top: 5mm; left: 0mm; height: 0px;">
     <img src="../imagenes/logo_reportes.jpg" style="width: 30mm; height: 23mm;">
    </div>
    <div class="separador"></div>

    <div style="text-align: justify; font-size: 12px;">
      <div>
      * * DEBE SOLICITAR SU CITA PARA RAYOS LASER  A LOS NÚMEROS TELEFÓNICOS:
      </div>
      <div></div>
      <div>
      0276-3560139 - 3560141 - 3560237 - 04247498952
      </div>
      <div></div>
     <div>
      *  EL DÍA DE LA APLICACIÓN PUEDE COMER NORMAL.
      </div> 
      <div></div>
      <div style="margin-bottom:5px">
      * SE RECOMIENDA VENIR ACOMPAÑADOS Y TRAER LENTES OSCUROS.
      </div> 
    </div>

    <div class="separador"></div>
    <div style="font-size: 14px">
    * PAGOS VIA TRANSFERENCIA BANCARIA A LOS SIGUIENTES BANCOS.
    </div>

    <div></div>      
    <div style="text-align: justify; font-size: 14px; text-align: center;"><b>PROVINCIAL: 01080361640100014630  MERCANTIL.: 01050093191093041889</b></div>
    <div style="text-align: justify; font-size: 14px; text-align: center; padding-left: 0px"><b>SOFITASA....: 01370020670000130321  TESORO.......: 01630304603043005474</b></div>
    <div></div>
    
    <div class="separador"></div>

    <div style="text-align: justify; font-size: 12px; margin-bottom: 0px">
      <div>
        <b>ZELLE oeci50@gmail.com A NOMBRE DE OSCAR CASTILLO INCIARTE</b>
      </div>

      <div></div>
      <div class="separador"></div>

      <div style="font-size: 17px;">* Si cancela en moneda extranjera debe realizar el pago del IGTF en Bolívares (Bs.) por TRANSFERENCIA o PAGO MÓVIL</div>

      <div class="separador"></div>
      <div></div>

      <div>
        <b>BANCOLOMBIA: AHORROS 726-28297062 A NOMBRE DE: OSCAR E. CASTILLO INCIARTE C.C: 1.126.243.925.</b>
      </div>
      <div></div>
      <div class="separador"></div>
    </div>
  
    <div></div>
    
    <div id="subcabecera" class="centrar">
      A.19 de Abril Edf. Clínica de Ojos P.B. La Bermeja - San Cristóbal Edo.Táchira
    </div>
    <div id="subcabecera" class="centrar" style="font-weight: bold">
      TF: 3560133 - 3560139 - 3560141 - 3560137  FAX: 3558633
    </div>

    <div id="subcabecera" class="centrar" style="font-weight: bold">
          e-mail: clicastillo96@gmail.com
    </div>
  </div>  
</page>
<?php }?>

<?php if($informe_medico == 1) {?>
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
      El suscrito Médico Oftalmológo Dr. <b><?php echo strtoupper($datos['desc_bare'])?></b>, hace constar por medio del presente que el paciente <b><?php echo strtoupper($datos['apel_nomb'])?></b>, con cédula de identidad No: <b><?php echo strtoupper($datos['nume_cedu'])?></b> de <?php echo $edad?> años presenta: <b><?php echo strtoupper($datos['informe'])?></b> por lo que amerita CIRUGÍA DE:<b style="width: fit-content; float:left"><?php echo strtoupper($datos['cirugia'])?></b> en la CLÍNICA OFTALMOLÓGICA CASTILLO INCIARTE Y ASOCIADOS.
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
<?php }?>


<?php 
  if ($exalab == 1) {
    include_once('examenes_laboratorio_general.php');
  }
?>


<?php if ($cardiovascular == 1) {?>

  <page style="width: 216mm" backtop="1mm" backbottom="5mm" backleft="5mm" backright="5mm">
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

      <div style="position:relative;">
        <h4 id="titulo1" style="">EXAMEN CARDIOVASCULAR</h4>
        <h4 id="titulo1" style="">========================</h4>
      </div> 

      <div></div>
      <div></div>


      <table style="border:none !important;margin-left:20px;">
        <tbody>
          <tr>
            <td style="width: 170mm; text-align: left">PREOPERATORIO DE: <div class="unbold" style="bottom: 5px; width: 120mm"><?php echo strtoupper($preoperatorio)?></div></td>
          </tr> 
        </tbody>    
      </table>

      <div></div>

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

<?php if ($torax == 1) {?>
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
  //----------------------------------------------------------
  //GENERADOR GENERAL
  //----------------------------------------------------------
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
          $html2pdf->Output("../reportes/presupuestos/presupuesto$nombre.pdf", "f");
        } else if ($pdf == 2) {
          $html2pdf->Output("../reportes/presupuestos/presupuesto$nombre.pdf");
        } else if ($pdf == 3){      
          $html2pdf->Output("../reportes/presupuestos/presupuesto$nombre.pdf");
          $html2pdf->output("../reportes/presupuestos/presupuesto$nombre.pdf", "f");
        }
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
  }
?>