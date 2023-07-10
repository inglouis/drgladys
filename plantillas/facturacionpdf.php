<?php
  /*MODOS PDF:
    0: traer solo estructura HTML
    1: solo guardar REPORTE,
    2: traer reporte SIN GUARDAR,
    3: traer reporte Y GUARDAR, 
  */

  ob_start();
  include_once('../clases/facturacion_acciones.class.php');
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

  if (isset($_REQUEST['paciente'])) {
    $paciente = (int)$_REQUEST['paciente'];
  } else {
    $paciente = 0;
  }

  if (isset($_REQUEST['empresa'])) {
    $empresa = (int)$_REQUEST['empresa'];
  } else {
    $empresa = 0;
  }

  if (isset($_REQUEST['exonerado'])) {
    $exonerado = (int)$_REQUEST['exonerado'];
  } else {
    $exonerado = 0;
  }

  if (isset($_REQUEST['modo'])) {
    $modo = $_REQUEST['modo'];
  } else {
     throw new Exception('operación inválida: MODO necesario para presupuesto'); 
  }

  if (isset($_REQUEST['credito'])) {
    $credito = $_REQUEST['credito'];
  } else {
    $credito = 'false';
  }

  if($modo == 'temporal') {

      $iteraciones_factura = 1;

      $datos = json_decode($obj->seleccionar("
        select a.*, b.*, TO_CHAR(a.fecha :: DATE, 'dd/mm/yyyy') as fecha_arreglada, b.apel_nomb, c.desc_bare, d.nombre as cirugia, e.desc_segu, c.genero
        from facturacion.facturas_temp as a
        inner join historias.entradas as b using(id_historia)
        left join facturacion.baremos as c on a.id_baremo = c.id_principal
        left join historias.cirugias as d using(id_cirugia)
        left join facturacion.seguros as e using(id_seguro)
      where a.id_factura = ?", [$id]), true)[0];
      
      if (isset($_REQUEST['id_factura'])) {
        
        $datos['id_factura'] = $_REQUEST['id_factura'];

      } else {

        $datos['id_factura'] = $obj->i_pdo("select coalesce(NULLIF(max(id_factura) + 1, null), 
           (SELECT last_value + 1 FROM facturacion.facturas_id_factura_seq)::bigint
        ) as id_factura from facturacion.facturas", [], true)->fetchColumn();

      }

      $sql = "
        select
            t.*,
            desc_fopa,
            TO_CHAR(t.fecha :: DATE, 'dd-mm-yyyy') as fecha_arreglada
        FROM (
            SELECT x.*
            FROM facturacion.facturas_temp as a,
           jsonb_array_elements(abonos::jsonb) AS t(doc),
           jsonb_to_record(t.doc) as x (id_pago bigint, comprobante character varying(100), monto numeric(14,2), fecha date, descripcion text, igtf character varying(1))
            WHERE id_factura = ?
        ) as t 
        left join primarias.form_pago as b on t.id_pago = b.codi_fopa
      ";

      $comprobantes = $obj->i_pdo($sql, [$id], true)->fetchAll(PDO::FETCH_ASSOC);

      // echo "<pre>";
      // print_r($comprobantes);
      // echo "</pre>";
      //eliminar
      $obj->e_pdo("delete from facturacion.facturas_temp where id_factura = $id");
  
  } else if ($modo == 'insertado') {

    $iteraciones_factura = 4; 

    $datos = json_decode($obj->seleccionar("
      select a.*, b.*, TO_CHAR(a.fecha :: DATE, 'dd/mm/yyyy') as fecha_arreglada, b.apel_nomb, c.desc_bare, d.nombre as cirugia, e.desc_segu, g.kit_orden, c.genero
      from facturacion.facturas as a
      inner join historias.entradas as b using(id_historia)
      left join facturacion.baremos as c on a.id_baremo = c.id_principal
      left join historias.cirugias as d using(id_cirugia)
      left join facturacion.seguros as e using(id_seguro)
      left join inventario.ordenes_facturadas as g on a.id_factura = g.id_factura
    where a.id_factura = ?", [$id]), true)[0];

    $comprobantes = json_decode($obj->traerAbonosDetallados([$datos['id_presupuesto']]), true);

  } else if ($modo == 'previa') {

    $iteraciones_factura = 4; 

    $listaPrevia = json_decode($_REQUEST['datos'], true);

    $datos = json_decode($obj->seleccionar("
      select a.*, b.*, TO_CHAR(a.fecha :: DATE, 'dd/mm/yyyy') as fecha_arreglada, b.apel_nomb, c.desc_bare, d.nombre as cirugia, e.desc_segu, g.kit_orden, c.genero
      from facturacion.facturas as a
      inner join historias.entradas as b using(id_historia)
      left join facturacion.baremos as c on a.id_baremo = c.id_principal
      left join historias.cirugias as d using(id_cirugia)
      left join facturacion.seguros as e using(id_seguro)
      left join inventario.ordenes_facturadas as g on a.id_factura = g.id_factura
    where a.id_factura = ?", [$id]), true)[0];

    $comprobantes = json_decode($obj->traerAbonosDetallados([$datos['id_presupuesto']]), true);
    
    $datos['presupuesto_copia']     = $listaPrevia[0];
    $datos['egreso']                = $listaPrevia[1];
    $datos['materiales']            = $listaPrevia[2];
    $datos['normas_cirugia']        = $listaPrevia[3];
    $datos['normas_retina']         = $listaPrevia[4];
    $datos['normas_laser']          = $listaPrevia[5];
    $datos['exalab']                = $listaPrevia[6];
    $datos['exalab_adulto']         = $listaPrevia[7];
    $datos['exalab_nino']           = $listaPrevia[8];
    $datos['informe']               = $listaPrevia[9];
    $datos['informe_descripcion']   = $listaPrevia[10];
    $datos['preoperatorio']         = $listaPrevia[11];
    $datos['preoperatorio_cirugia'] = $listaPrevia[12];
    $datos['torax']                 = $listaPrevia[13];

  }

  $dia  = $obj->fechaHora('America/Caracas','d-m-Y');
  $hora = $obj->fechaHora('America/Caracas','H:i:s');
  $edad = $obj->calcularEdad($datos['fech_naci']);

  $sexo = $obj->i_pdo("select sexo from historias.entradas where id_historia = ?", [$datos['id_historia']], true)->fetchColumn();

  // echo "<pre>";
  //print_r($datos['fecha_arreglada']);
  // echo "</pre>";

  setlocale(LC_ALL,"es_ES@euro","es_ES","esp");

  //--------------------------------------------------
  //VARIABLES ESPECIFICAS
  //--------------------------------------------------

  if (isset($datos['egreso'])) {
    $egreso = $datos['egreso'];
  } else {
     throw new Exception('operación inválida: EGRESO necesario para factura'); 
  }

  if (isset($datos['materiales'])) {
    $materiales = $datos['materiales'];
  } else {
     throw new Exception('operación inválida: EGRESO necesario para factura'); 
  }

  if (isset($datos['normas_cirugia'])) {
    $normas_cirugia = $datos['normas_cirugia'];
  } else {
     throw new Exception('operación inválida: NORMAS CIRUGIA necesario para factura'); 
  }

  if (isset($datos['normas_retina'])) {
    $normas_retina = $datos['normas_retina'];
  } else {
     throw new Exception('operación inválida: NORMAS RETINA necesario para factura'); 
  }

  if (isset($datos['normas_laser'])) {
    $normas_laser = $datos['normas_laser'];
  } else {
     throw new Exception('operación inválida: NORMAS LASER necesario para factura'); 
  }

  if (isset($datos['informe'])) {
    $informe_medico = $datos['informe'];
  } else {
     throw new Exception('operación inválida: INFORME MEDICO necesario para factura'); 
  }

  if (isset($datos['exalab'])) {
    $exalab = $datos['exalab'];
  } else {
     throw new Exception('operación inválida: EXALAB necesario para factura'); 
  }

  if (isset($datos['preoperatorio'])) {
    $cardiovascular = $datos['preoperatorio'];
  } else {
     throw new Exception('operación inválida: CARDIOVASCULAR necesario para factura'); 
  }

  if (isset($datos['torax'])) {
    $torax = $datos['torax'];
  } else {
     throw new Exception('operación inválida: TORAX necesario para factura'); 
  }

  if (isset($datos['presupuesto_copia'])) {
    $presupuesto_copia = $datos['presupuesto_copia'];
  } else {
     throw new Exception('operación inválida: PRESUPUESTO COPIA necesario para factura'); 
  }

  //------------------------------------

  if($egreso == 'X') {

  }

  if($materiales == 'X') {

  }

  if($normas_cirugia == 'X') {

  }

  if($normas_retina == 'X') {

  }

  if($normas_laser == 'X') {

  }

  if ($exalab == 'X') {

    if($datos['exalab_adulto'] == 'A' || $datos['exalab_adulto'] == 'X') {
      $examen_lab = [
        'X','X','X','X','X','X','X','X','X','X','X','X','X','X','X','X','X','X','X','X','X','X'
      ];
    } else if ($datos['exalab_nino'] == 'N' || $datos['exalab_nino'] == 'X') {
      $examen_lab = [
        'X','X','','','','','X','X','X','','X','','X','X','X','','','','X','','',''
      ];
    } else {
      $examen_lab = [
        'X','X','X','X','X','X','X','X','X','X','X','X','X','X','X','X','X','X','X','X','X','X'
      ];
    }

  }

  if($presupuesto_copia == 'X') {

    $datosPresupuesto = json_decode($obj->seleccionar("
        select a.*, b.*, TO_CHAR(a.fecha :: DATE, 'dd/mm/yyyy') as fecha_arreglada, b.apel_nomb, c.desc_bare, d.nombre as cirugia, e.desc_segu
        from presupuestos.presupuesto as a
        inner join historias.entradas as b using(id_historia)
        left join facturacion.baremos as c on a.id_baremo = c.id_principal
        left join historias.cirugias as d using(id_cirugia)
        left join facturacion.seguros as e using(id_seguro)
      where a.id_presupuesto = ?", [$datos['id_presupuesto']]), true)[0];

  }


  if($cardiovascular == 'X') {

    $id_cirugia = (int)$datos['preoperatorio_cirugia'];

    $preoperatorio = $obj->e_pdo("select nombre from historias.cirugias where id_cirugia = $id_cirugia")->fetchColumn();
  }

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

  //print_r($baremosProcesados);

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
	$timestamp = strtotime($datos['fecha']);

  $igtfAplicable = false;
  $exoneradoAplicable = false;

  foreach ($subtotal_paciente as $key => $r) {
    
    if ($key !== 2) {

      if ($r['monto'] != '') {

        $igtfAplicable = true;

      }

    } 

  }

  if ($subtotal_descuento != '' || $subtotal_descuento != 0) {
    $exoneradoAplicable = true;
  }

  $diferenciaMaterial = 0;

?>
<?php 
  for ($i=0; $i < $iteraciones_factura; $i++) :
?>
<page style="width:205mm" backtop="0mm" backbottom="5mm" backleft="6mm" backright="4mm">
	<div class="contenedor">

		<div style="height: 53mm"></div>

    <div style="font-size: 13px; position: relative;">
      SEGÚN EL PRESUPUESTO N°:&nbsp;&nbsp;<?php echo $datos['id_presupuesto']?>
    </div>

    <div style="font-size: 20px; position: absolute; right: 55px; top: 48mm">
      Factura N°:&nbsp;<?php echo $datos['id_factura']?>
    </div>

    <div class="separador" style="width: 190mm"></div>

    <div style="font-size: 14px; position: absolute; right: 57px; top: 53mm">
      FECHA:<b>&nbsp;&nbsp;<?php echo date("d", $timestamp);?>&nbsp;&nbsp;&nbsp;<?php echo date("m", $timestamp);?>&nbsp;&nbsp;&nbsp;<?php echo date("Y", $timestamp);?></b>
    </div>

		<table style="width: 190mm; border:none; position: relative; top: -10px">
			<tbody>
				<tr>
					<td style="width: 17mm; border:none; font-weight: 100px;">Responsable:</td>
					<td style="width: 170mm; border:none;">
            <b><?php echo $datos['nomb_resp']?></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <div style="font-weight: 100; width: fit-content">RIF/CÉDULA: &nbsp;&nbsp;&nbsp; <b><?php echo $datos['cedu_resp']?></b></div>
          </td>
				</tr>
			</tbody>
		</table>

		<table style="width: 190mm; border:none;">
			<tbody>
				<tr>
					<td style="width: 17mm; border:none; font-weight: 100">Dirección:</td>
					<td style="width: 100mm; border:none; font-weight: bold"><?php echo $datos['dire_resp']?></td>
				</tr>
			</tbody>
		</table>

    <table style="width: 190mm; border:none;">
      <tbody>
        <tr>
          <td style="width: 17mm; border:none; font-weight: 100">Teléfonos:</td>
          <td style="width: 170mm; border:none; font-weight: bold">
            <?php 
              $concat = "";
              foreach ($telefonos as $r) {

                $concat .= $r.' - ';

              }

              $concat = substr($concat, 0,-2);
              echo $concat;
            ?>

            &nbsp;&nbsp;&nbsp;&nbsp;

            <div style="font-weight: 100; width: fit-content">Formas de pago: &nbsp; 
              <b>
                <?php 
                  $concat = "";
                  $concatCompro = "";

                  // echo "<pre>";
                  // print_r($comprobantes);
                  // echo "</pre>";

                  foreach ($comprobantes as $r) {

                    if (!isset($r['desc_fopa'])) {
                      
                      $r['desc_fopa'] = $r['forma_pago']; 

                    }

                    if ($r['id_pago'] == $_SESSION['credito_forma_pago']) {

                      if ($credito != 'true') {
                        
                        $concat .= $r['desc_fopa'].', ';
                        $concatCompro .= $r['comprobante'].', ';

                      }


                    } else {

                      $concat .= $r['desc_fopa'].', ';
                      $concatCompro .= $r['comprobante'].', ';

                    }

                  }

                  $concat = substr($concat, 0,-2);
                  echo $concat;
                ?>
              </b>
            </div>

          </td>
        </tr>
      </tbody>
    </table>

    <table style="width: 190mm; border:none;">
      <tbody>
        <tr>
          <td style="width: 17mm; border:none; font-weight: 100">Cod. Seguro:</td>
          <td style="width: 170mm; border:none;">
            <b><?php echo $datos['id_seguro']?></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <div style="font-weight: 100; width: fit-content">Seguro: &nbsp; <b><?php echo $datos['desc_segu']?></b></div>
          </td>
        </tr>
      </tbody>
    </table>

    <div class="separador" style="position: relative; top: -5px; width: 190mm"></div>

		<table style="width: 190mm; border:none; position: relative; top: -10px">
			<tbody>
				<tr>
					<td style="width: 20mm; border:none; font-weight: 100">Paciente:</td>
					<td style="width: 170mm; border:none;">
            <b><?php echo $datos['apel_nomb'].'</b> - N° HISTORIA:<b>'.$datos['id_historia']?></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <div style="font-weight: 100; width: fit-content">RIF/CÉDULA: &nbsp; <b><?php echo $datos['nume_cedu']?></b></div>
          </td>
				</tr>
			</tbody>
		</table>

		<table style="width: 190mm; border:none;">
			<tbody>
				<tr>
					<td style="width: 20mm; border:none; font-weight: 100">Dirección:</td>
					<td style="width: 100mm; border:none;font-weight: bold"><?php echo $datos['dire_paci']?></td>
				</tr>
			</tbody>
		</table>

		<table style="width: 190mm; border:none;">
			<tbody>
				<tr>
					<td style="width: 20mm; border:none; font-weight: 100">Diagnóstico:</td>
					<td style="width: 100mm; border:none;font-weight: bold"><?php echo $datos['cirugia']?></td>
				</tr>
			</tbody>
		</table>

		<div class="separador" style="width: 190mm"></div>

		<table style="width: 190mm; position: relative; top: -10px">
      <thead>
        <tr style="border: 1px solid #262626">
          <th style="border-bottom: 1px dotted #262626">DESCRIPCIONES</th>
          <th style="border-bottom: 1px dotted #262626">CANTIDAD</th>
          <th style="border-bottom: 1px dotted #262626; text-align: right;">Bs</th>
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
          <td style="font-size: 12px; width: 15mm; text-align: center"><?php echo $r['cantidad']?></td>
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

    <div style="width: 190mm; text-align: center; position: relative; top: -5px; margin-bottom: 5px; font-size: 13px; font-weight: bold;">
      SE EMITE EN CONFORMIDAD AL ARTÍCULO N° 10 DE LA LEY DEL IVA
    </div>

		<table style="width: 190mm">
			<tbody>
        <thead>
        <tr style="border: 1px solid #262626">
          <th style="border-bottom: 1px dotted #262626">NOMBRE</th>
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

    <?php 
      if ($igtfAplicable == 1) {

        $conver = array(
          1 => $conversiones[2]['conver'],
          3 => $conversiones[3]['conver'],
          4 => $conversiones[4]['conver']
        );

        $subtotal_extranjeras = 0;
        $subtotal_bolivares   = 0;
        $total_servicios_bolivares = $subtotales['servicios'] * $conversiones[2]['conver'];

        foreach ($subtotal_paciente as $k => $r) {
          
          if ($k != 'total') {

            if ($k != 2) {

              $subtotal_extranjeras = $subtotal_extranjeras + ($r['monto'] * $conver[1]);

            } else if ($k == 2) {

              $subtotal_bolivares = $subtotal_bolivares + ($r['monto'] * $conver[1]);

            }

          }

        }

    ?>  

    <table style="width: 190mm;position: relative; top: -10px;">
      <tbody>
        <tr>
          <td style="width: 165mm">NOTA:  De acuerdo a la Providencia Administrativa publicada en 6.0 N°. 42339 de fecha 17-03-2022. Se hará la percepción del <b>3%</b> del <b>IGTF</b> por el pago en divisas por Bolívares:</td>
          <td style="width: 15mm; text-align: right;font-weight: bold">
            <?php 

              ///echo $subtotal_bolivares;

              //SI EL PAGO EN BOLIVARES ES MENOR A LOS SERVICIOS APLICA: RESTA DE SUBTOTAL_BOLIVARES - TOTAL_SERVICIOS_BOLIVAREES = VALOR AL CUAL APLICA IGTF
              if ($subtotal_bolivares < $total_servicios_bolivares) {

                $total_diferencia = $total_servicios_bolivares - $subtotal_bolivares;
                echo number_format(($total_diferencia * 3) / 100, 2, ',', '.');

              //SI EL PAGO EN BOLIVARES EN MAYOR EL IGTF APLICA SOBRE LAS MONEDAS EXTRAJENRAS CONVERTIDAS
              } else {

                echo number_format(($subtotal_extranjeras * 3) / 100, 2, ',', '.');

              }
              
            ?>
          </td>
        </tr>
      </tbody>
    </table>

		<div class="separador" style="width: 190mm"></div>

    <?php 
      // echo $diferencia;
      // print_r($comprobantes);

      }
    ?>

    <?php if ($exoneradoAplicable && $exonerado == 1) { ?>
  		<div style="font-size: 12px; margin-top: 0px; margin-left: 15px">
        Monto exonerado: <?php echo number_format(($subtotal_descuento * $conversiones[2]['conver']), 2, ',', '.');?>
      </div>
    <?php } ?>

    <?php if ($empresa == 1) { ?>
      <div style="font-size: 12px; margin-top: 0px; margin-left: 15px">
        Empresa reconoce: <?php echo number_format(($datos['subtotal_empresa'] * $conversiones[2]['conver']), 2, ',', '.');?>
      </div>
    <?php } ?>

    <?php if ($paciente == 1) { ?>
      <div style="font-size: 12px; margin-top: 0px; margin-left: 15px">
        Paciente reconoce: <?php echo number_format(($subtotal_paciente['total'] * $conversiones[2]['conver']), 2, ',', '.');?>
      </div>
    <?php } ?>


		<table style="width: 190mm; margin-top: 10px">
			<tbody>
				<tr>
					<td style="width: 95mm; border:none">COMPROBANTE DE INGRESO:&nbsp; 
            <?php 
              $concatCompro = substr($concatCompro, 0,-2);
              echo $concatCompro;
            ?>
          </td>
				</tr>
			</tbody>
		</table>
	</div>
</page>
<?php 
  endfor;
?>

<?php if ($presupuesto_copia == 'X') {

  $totales_presupuesto = json_decode($datosPresupuesto['totales'], true);
  $detalle_honorarios_presupuesto = json_decode($datosPresupuesto['detalle_honorarios'], true);
  $detalle_servicios_presupuesto = json_decode($datosPresupuesto['detalle_servicios'], true);
  $conversiones_presupuesto = json_decode($datosPresupuesto['conversiones'], true);

  $mqi_presupuesto = 0;
?>

<!------------------------------------------------------------------------------>
<!---------------------------PRESUPUESTO CHIKITO-------------------------------->
<!------------------------------------------------------------------------------>
<page style="width:100mm; height: 100mm" backtop="15mm" backbottom="0mm" backleft="0mm" backright="0mm">
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
      <b>Presupuesto N°:</b> <?php echo $datosPresupuesto['id_presupuesto']?> &nbsp;&nbsp;<b>Cédula/Rif:</b><?php echo strtoupper($datosPresupuesto['nume_cedu'])?>
    </div>

    <div style="font-size: 10px; top: -5px; position: relative;">
      <b>Médico:</b><span  style="margin-left: 43px;"><?php echo $datosPresupuesto['desc_bare']?></span>
    </div>

    <div style="font-size: 10px; top: -5px; position: relative;">
      <b>Paciente:</b><span  style="margin-left: 36px;"><?php echo $datosPresupuesto['apel_nomb'].' - N° HISTORIA:'.$datosPresupuesto['id_historia']?></span>
    </div>

    <div style="font-size: 10px; top: -5px; position: relative;">
      <b>Diagnóstico:</b><span  style="margin-left: 20px;"><?php echo $datosPresupuesto['cirugia']?></span>
    </div>

    <div class="separador" style="width: 120mm"></div>

    <div style="font-size: 10px; top: -5px; position: relative;">
      <b>Código N°:</b><span  style="margin-left: 30px;"><?php echo $datosPresupuesto['id_cirugia']?></span>
    </div>

    <div style="font-size: 10px; top: -5px; position: relative;">
      <b>Responsable:</b><span  style="margin-left: 15px;"><?php echo $datosPresupuesto['desc_segu']?></span>
    </div>

    <div style="font-size: 10px; top: -5px; position: relative;">
      <b>Fecha:</b><span  style="margin-left: 50px;"><?php echo $datosPresupuesto['fecha_arreglada']?></span>
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
        <?php foreach ($detalle_servicios_presupuesto as $r) :

          if ($r['id_servicio'] != $_SESSION['material_quirurgico_interno']) {
        ?>
        <tr>
          <td style="padding:0px; height: 4px; border:none; font-size:9px; width: 87mm; "><?php echo $r['descripcion']?>:</td>
          <td style="padding:0px; height: 4px; border:none; font-size:9px; width: 12mm; text-align: center"><?php echo $r['cantidad']?></td>
          <td style="padding:0px; height: 4px; border:none; font-size:9px; width: 14mm; text-align: right;">
            <?php 
              echo number_format(($r['costo_dolares'] * $r['cantidad']) * $conversiones_presupuesto[2], 2, ',', '.');
            ?> 
          </td>
        </tr>
        <?php 
          } else {

            $mqi_presupuesto = (float)number_format(($r['costo_dolares'] * $r['cantidad']) * $conversiones_presupuesto[2], 2, ',', '.');

          }
        endforeach;?>
      </tbody>
    </table>

    <div class="separador" style="width: 120mm;"></div>

    <table style="width: 120mm; position: relative; top: -10px">
      <tbody>
        <tr>
          <td style="font-size:12px; width: 65mm">TOTAL SERVICIOS:</td>
          <td style="font-size:12px; width: 44mm; text-align: right;"><?php echo number_format(($totales_presupuesto['total_servicio'] * $conversiones_presupuesto[2]), 2, ',', '.')?></td>
        </tr>
      </tbody>
    </table>

    <div class="separador" style="width: 120mm;"></div>

    <table style="width: 120mm; position: relative; top: -10px">
      <tbody>
        <?php foreach ($detalle_honorarios_presupuesto as $r) :?>
        <tr>
          <td style="padding:0px; height: 4px; border:none; font-size:9px; width: 74mm;"><?php echo $r['descripcion']?>:</td>
          <td style="padding:0px; height: 4px; border:none; font-size:9px;; width: 44mm; text-align: right;"><?php echo number_format($r['costo_dolares'] * $conversiones_presupuesto[2], 2, ',', '.'); ?></td>
        </tr>
        <?php endforeach;?>
      </tbody>
    </table>

    <div class="separador" style="width: 120mm;"></div>

    <table style="width: 120mm; position: relative; top: -10px">
      <tbody>
        <tr>
          <td style="width: 65mm">TOTAL HONORARIOS:</td>
          <td style="width: 44mm; text-align: right;"><?php echo number_format($totales_presupuesto['total_honorario'] * $conversiones_presupuesto[2], 2, ',', '.');?></td>
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
              echo number_format(($totales_presupuesto['total_servicio'] * $conversiones_presupuesto[2]) + ($totales_presupuesto['total_honorario'] * $conversiones_presupuesto[2]), 2, ',', '.');
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
              echo number_format((($totales_presupuesto['total_servicio'] * $conversiones_presupuesto[2]) * 3) / 100, 2, ',', '.');
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
</page>

<?php } ?> 

<?php if ($egreso == 'X') {?>
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

      <div style="height: 10px; margin-top: 20px">
        <div style="position:relative;">
          <h4 id="titulo1" style="border-bottom: 2px dashed #262626 !important">INFORME DE EGRESO</h4>
          <h4>========= == ========</h4>
        </div> 
      </div>

      <?php 
        if ($sexo == 'M') {
          $palabra1 = 'intervenido';
        } else {
          $palabra1 = 'intervenida';
        }

        $fecha_arreglada = new DateTime($datos['fecha']);
      ?>

      <div style="position: relative; left: 180px; width: 120mm; margin-top: 10mm; text-align: justify; font-size: 16px; letter-spacing: 2px; line-height: 2;">
        El suscrito Médico Oftalmológico <?php echo $datos['desc_bare']?> hace constar por medio del presente que el paciente: <?php echo $datos['apel_nomb']?> fue <?php echo $palabra1?>  en esta clínica el día:<?php echo $datos['fecha_arreglada']?> de: <?php echo $datos['cirugia']?> siendo su evolución Satisfactoria.
      </div>

      <div style="position: relative; left: 180px; width: 120mm; margin-top: 7mm; text-align: justify; font-size: 16px; letter-spacing: 2px; line-height: 2;">
        Constancia expedida a solicitud de la parte interesada en San Cristóbal a los <?php echo date("d", $timestamp);?> días del mes de <?php echo strtoupper(strftime("%B", $fecha_arreglada->getTimestamp()));?> del año <?php echo date("Y", $timestamp);?>.
      </div> 

      <div></div>
      <div></div>
      <div></div>
      <div></div>
      <div></div>

      <?php
        $prefijo = '';

        if ($datos['genero'] == 'M') {
          $prefijo = 'DR. ';
        } else if ($datos['genero'] == 'F') {
          $prefijo = 'DRA. ';
        } else if ($datos['genero'] == 'NB') {
          $prefijo = '';
        } else {
          $prefijo = 'DR. ';
        }
      ?>

      <div style="width: 110mm; text-align: center;">
        <div style="width: 110mm; text-align: center; border-bottom: 1px solid #636363"></div>
        <div style="position: relative; top: -10px; font-size: 16px">
          <?php echo $prefijo.$datos['desc_bare']?>
        </div>
      </div>

    </div>  
  </page>
<?php }?>


<?php if ($materiales == 'X') {
  $total_materiales = 0;

  $kit_orden = json_decode($obj->i_pdo("
    select 
    json_agg(json_build_object(
       'id_articulo', x.id_articulo,
       'cantidad', x.cantidad::bigint,
       'descripcion', b.descripcion,
       'precio_ajustado', x.precio_ajustado
    )) as kit_orden_procesado
    from (select 
      ?::jsonb as kit_orden
    ) as a,
         jsonb_array_elements(a.kit_orden::jsonb) AS t(doc),
         jsonb_to_record(t.doc) as x (id_articulo bigint , cantidad numeric(14,2),  precio_ajustado numeric(14,6))
    inner join inventario.articulos as b using (id_articulo)
    inner join inventario.familias as c on b.id_familia = c.id_familia
  ", [json_encode($kit_orden)], true)->fetchColumn() , true);


    // echo "<pre>";
    // print_r($kit_orden);
    // echo "</pre>";

?>
<page style="width:100%" backtop="10mm" backbottom="5mm" backleft="6mm" backright="5mm">
  <div class="contenedor">
  
    <div>
      <b><?php echo $datos['cirugia']?></b>
    </div>
    <div>
      Anexo Factura N°: <b><?php echo $datos['id_factura']?></b>
    </div>

    <div class="separador"></div>

    <table style="width: 200mm; position: relative; top: -10px">
      <thead>
        <tr style="border: 1px solid #262626">
          <th style="border-bottom: 1px dotted #262626;">DESCRIPCIONES</th>
          <th style="border-bottom: 1px dotted #262626;">CANTIDAD</th>
          <th style="border-bottom: 1px dotted #262626; ;text-align: right;">Bs</th>
        </tr>
      </thead>
      <tbody>
        <?php 
        $aplicables = true;

        foreach ($kit_orden as $r) {
          $total_materiales = $total_materiales + ($r['precio_ajustado'] * $r['cantidad']);
        }

        $total_base = ($total_materiales * $conversiones[2]['conver']);
        $diferencia = ($total_base - $diferenciaMaterial);
        
        //echo $diferenciaMaterial;
        //$total_materiales;

        foreach ($kit_orden as $r) :
        ?>
        <tr>
          <td style="width: 155mm"><?php echo $r['descripcion']?>:</td>
          <td style="width: 15mm; text-align: center"><?php echo $r['cantidad']?></td>
          <td style="width: 14mm; text-align: right; font-weight: bold">
            <?php

              $precio = ($r['precio_ajustado'] * $r['cantidad']) * $conversiones[2]['conver'];

              if ($precio + $diferencia > $diferencia && $aplicables) {
                $precio = $precio - $diferencia;

                $aplicables = false;
              
              }

              echo number_format($precio, 2, ',', '.');

              //$total_materiales = $total_materiales + ($r['precio_ajustado'] * $r['cantidad']);
            ?> 
          </td>
        </tr>
        <?php 
        endforeach;
        ?>
      </tbody>
    </table>

    <div class="separador"></div>

    <table style="width: 200mm; position: relative; top: -10px; font-weight: bold">
      <tbody>
        <tr>
          <td style="width: 95mm">TOTAL DE MATERIALES:</td>
          <td style="width: 95mm; text-align: right;">
            <?php echo number_format(($total_materiales * $conversiones[2]['conver']) - ($total_base - $diferenciaMaterial), 2, ',', '.');
            //number_format(($total_materiales * $conversiones[2]['conver']), 2, ',', '.')
            ?>    
          </td>
        </tr>
      </tbody>
    </table>

    <div class="separador" style="position: relative;"></div>

  </div>  
</page>
<?php }?>

<?php if($normas_cirugia == 'X') {?>
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

<?php if($normas_retina == 'X') { ?>
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

<?php if ($normas_laser == 'X') {?>
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

<?php if($informe_medico == 'X') {?>
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
      El suscrito Médico Oftalmológo Dr. <b><?php echo strtoupper($datos['desc_bare'])?></b>, hace constar por medio del presente que el paciente <b><?php echo strtoupper($datos['apel_nomb'])?></b>, con cédula de identidad No: <b><?php echo strtoupper($datos['nume_cedu'])?></b> de <?php echo $edad?> años presenta: <b><?php echo strtoupper($datos['informe_descripcion'])?></b> por lo que amerita CIRUGÍA DE:<b style="width: fit-content; float:left"><?php echo strtoupper($datos['cirugia'])?></b> en la CLÍNICA OFTALMOLÓGICA CASTILLO INCIARTE Y ASOCIADOS.
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
  if ($exalab == 'X') {
    include_once('examenes_laboratorio_general.php');
  }
?>

<?php if ($cardiovascular == 'X') {?>

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

<?php if ($torax == 'X') {?>
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
        $nombre = $datos['id_factura'].'-'.$datos['id_historia'].'-'.$dia;

        if($pdf == 1) {
          $html2pdf->Output("../reportes/facturas/facturacion$nombre.pdf", "f");
        } else if ($pdf == 2) {
          $html2pdf->Output("../reportes/facturas/facturacion$nombre.pdf");
        } else if ($pdf == 3){      
          $html2pdf->Output("../reportes/facturas/facturacion$nombre.pdf");
          $html2pdf->output("../reportes/facturas/facturacion$nombre.pdf", "f");
        }
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
  }
?>