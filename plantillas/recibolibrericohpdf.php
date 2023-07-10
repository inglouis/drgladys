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
  $hora = $obj->fechaHoraAjustar('America/Caracas','H:i:s', 30);
  $monedas = $obj->e_pdo("select * from miscelaneos.monedas where id_moneda = 2")->fetch(PDO::FETCH_ASSOC);

  if (isset($_REQUEST['pdf'])) {
    $pdf = (int)$_REQUEST['pdf'];
  } else {
    $pdf = 1;
  }

  if (isset($_REQUEST['modo'])) {
    $modo = $_REQUEST['modo'];
  } else {
    throw new Exception('operación inválida: MODO necesaria para imprimir ingreso'); 
  }

  if (isset($_REQUEST['para'])) {
    $para = $_REQUEST['para'];

    if ($para != 'M' && $para != 'H') {
      throw new Exception('operación inválida: VALOR INVALIDO EN [PARA]'); 
    }

  } else {
    throw new Exception('operación inválida: PARA necesaria para imprimir ingreso'); 
  }

  if (isset($_REQUEST['datos'])) {

  if ($modo == 'insertado') {

    $lista = (int)$_REQUEST['datos'];

  } else {
    
    $lista = json_decode($_REQUEST['datos'], true);

  }

  } else {
    throw new Exception('operación inválida: DATOS necesaria para imprimir ingreso'); 
  }


  // [0] => 100           -monto
  // [1] => 2021-07-06    -fecha
  // [2] => 1             -id_pago
  // [3] =>               -id_persona
  // [4] => 1             -id_mh
  // [5] => persona x     -nombre servicio
  // [6] => 213123        -telefono servicio
  // [7] => 282828282     -cedula servicio
  // [8] => 139584        -siguiente correlativo
  // [9] => desc          -descripcion
  // [10] => ob1          -observacion1
  // [11] => ob2          -observacion2

  if ($modo == 'previa') {

    // echo "<pre>";
    // print_r($lista);
    // echo "</pre>";

    $monto       = $lista[0];
    $fecha       = $lista[1];
    $id_pago     = $lista[2];
    $id_persona  = $lista[3];
    $id_mh       = $lista[4];
    $nombre      = $lista[5];
    $telefono    = $lista[6];
    $rif         = $lista[7];
    $correlativo = $lista[8];
    $descripcion = $lista[9];
    $ob1         = $lista[10];
    $ob2         = $lista[11];

    if ($para == 'M') {
      $correlativo = $obj->i_pdo("select nume_reci + 1 from historias.medicos where id_medico = $id_mh", [], true)->fetchColumn();
    } else {
      $correlativo = $obj->i_pdo("select nume_reci + 1 from historias.hijos where id_hijo = $id_mh", [], true)->fetchColumn();
    }

    if (empty($id_persona)) {

      $persona = $nombre;

    } else {

      $persona = $obj->i_pdo("select nombre from facturacion.personas where id_persona = $id_persona", [], true)->fetchColumn();

    }


  } else if ($modo == 'insertado') {

    if ($para == 'M') {
      $sql = "
        select 
          a.*,
          b.telefono,
          b.rif,
          c.nomb_medi as nombre,
          a.id_medico as codigo
      from historias.recibos_libres as a
      left join facturacion.personas as b using(id_persona)
      left join historias.medicos as c using(id_medico)
      where a.id_recibo = ?";
    } else {
      $sql = "
      select 
          a.*,
          b.telefono,
          b.rif,
          c.nomb_hijo as nombre,
          a.id_hijo as codigo
      from historias.recibos_libres as a
      left join facturacion.personas as b using(id_persona)
      left join historias.hijos as c using(id_hijo)
      where a.id_recibo = ?";
    }

    $datos = $obj->i_pdo($sql, [$lista], true)->fetch(PDO::FETCH_ASSOC);

    $monto       = $datos['total'];
    $fecha       = $datos['fecha'];
    $hora        = $datos['hora'];
    $id_pago     = $datos['id_pago'];
    $id_persona  = $datos['id_persona'];
    $id_mh       = $datos['codigo'];
    $telefono    = $datos['telefono'];
    $rif         = $datos['rif'];
    $correlativo = $datos['nume_reci'];
    $descripcion = $datos['descripcion'];
    $ob1         = $datos['observacion1'];
    $ob2         = $datos['observacion2'];
    
    $persona = $obj->i_pdo("select nombre from facturacion.personas where id_persona = $id_persona", [], true)->fetchColumn();
  
  } else if ($modo == 'reimprimir') {

    $monto       = $lista['total'];
    $fecha       = $lista['fecha'];
    $hora        = $lista['hora'];
    $id_pago     = $lista['id_pago'];
    $id_persona  = $lista['id_persona'];
    $id_mh       = $lista['codigo'];
    $telefono    = $lista['telefono'];
    $rif         = $lista['rif'];
    $correlativo = $lista['nume_reci'];
    $descripcion = $lista['descripcion'];
    $ob1         = $lista['observacion1'];
    $ob2         = $lista['observacion2'];
    
    $persona = $obj->i_pdo("select nombre from facturacion.personas where id_persona = $id_persona", [], true)->fetchColumn();

  }
  $pago = $obj->i_pdo("select desc_fopa from primarias.form_pago where codi_fopa = $id_pago", [], true)->fetchColumn();

  $timestamp = strtotime($fecha);

  $fecha_arreglada = date("d-m-Y", strtotime($fecha));
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
        width: 189mm;
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
        padding: 1px 5px;
      }

      table thead tr th {
        font-size: 10px !important;
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

<?php 

?>
<?php 
  for ($i=0; $i < 3; $i++) { 
?>
<!--40mm(historias) 50mm(recibos)-->
<page style="width:200mm" backtop="35mm" backbottom="5mm" backleft="15mm" backright="2mm">
  <div class="contenedor">

    <table>
      <tbody>
        <tr>
          <td style="font-size: 16px; width: 100mm; padding:0px">FECHA: <?php echo $fecha_arreglada?></td>
          <td style="font-size: 16px; width: 87mm; padding:0px; position:relative; text-align: right;">FACTURA N°: <?php echo $correlativo?></td>
        </tr>
      </tbody>
    </table>  

    <table>
      <tbody>
        <tr>
          <td style="font-size: 12px">Razón social: <?php echo $persona?></td>
          
        </tr>
      </tbody>
    </table>  

    <table>
      <tbody>
        <tr>
          <td style="font-size: 12px">Rif/Cédula o pasaporte N°: <?php echo strtoupper($rif)?></td>
          <td style="font-size: 12px">Hora: <?php echo $hora?></td>
        </tr> 
      </tbody>    
    </table>

    <table>
      <tbody>
        <tr>
          <td style="font-size: 12px">Teléfono N°: <?php echo strtoupper($telefono)?></td>
          <td style="font-size: 12px">Forma de pago: <?php echo $pago?></td>
        </tr> 
      </tbody>    
    </table>


    <div class="separador" style="position: relative; top: 8px;"></div>

    <table style="width: 200mm; margin-top: 0px; border-left: none; border-collapse: collapse; position: relative; top: -6px">
      <thead>
        <tr>
          <th style="width: 30mm; font-size: 10px" class="conceptos-cabecera">CANTIDAD</th>
          <th style="width: 65mm; font-size: 10px" class="conceptos-cabecera">DESCRIPCIÓN DEL SERVICIO PRESTADO</th>
          <th style="width: 45mm; font-size: 10px" class="conceptos-cabecera">PRECIO UNIDAD BsS</th>
          <th style="width: 45mm; font-size: 10px" class="conceptos-cabecera">MONTO BsS</th>
        </tr>
      </thead>
      <tbody>
	      <tr style="padding: 5px;">
	        <td style="height: 15px; text-align: center; vertical-align: middle; border-bottom: 1px dashed #ccc">1</td>
	        <td style="height: 15px; text-align: center; vertical-align: middle; border-bottom: 1px dashed #ccc">
	        	<?php echo strtoupper($descripcion)?>
	        </td>
	        <td style="height: 15px; text-align: center; vertical-align: middle; border-bottom: 1px dashed #ccc">
	          <?php echo number_format($monto, 2, '.', ','); ?>
	        </td>
	        <td style="height: 15px; text-align: center; vertical-align: middle; border-bottom: 1px dashed #ccc">
	          <?php echo number_format($monto, 2, '.', ','); ?> 
	        </td>
	      </tr>
	      <?php if (trim($ob1) != '') { ?>
	      <tr>
	      	<td style="height: 15px; text-align: center; vertical-align: middle; border-bottom: 1px dashed #ccc"></td>
	      	<td style="height: 15px; text-align: center; vertical-align: middle; border-bottom: 1px dashed #ccc"><?php echo strtoupper($ob1)?></td>
	      	<td style="height: 15px; text-align: center; vertical-align: middle; border-bottom: 1px dashed #ccc"></td>
	      	<td style="height: 15px; text-align: center; vertical-align: middle; border-bottom: 1px dashed #ccc"></td>
	      </tr>
	  	  <?php }?>
	  	  <?php if (trim($ob2) != '') { ?>
	      <tr>
	      	<td style="height: 15px; text-align: center; vertical-align: middle; border-bottom: 1px dashed #ccc"></td>
	      	<td style="height: 15px; text-align: center; vertical-align: middle; border-bottom: 1px dashed #ccc"><?php echo strtoupper($ob2)?></td>
	      	<td style="height: 15px; text-align: center; vertical-align: middle; border-bottom: 1px dashed #ccc"></td>
	      	<td style="height: 15px; text-align: center; vertical-align: middle; border-bottom: 1px dashed #ccc"></td>
	      </tr>
	      <?php }?>
      </tbody>
    </table>

    <div></div>

    <div>

      <div class="separador"></div>

      <div style='font-size:14px; width:187mm; text-align:right; font-weight: bold; position: relative; top: -10px'>Monto total a pagar BsS: 
        <?php 
          echo number_format($monto, 2, '.', ',');
        ?>
      </div>

      <div class="separador" style="margin: 0px"></div>
    </div>
  </div>  
</page>
<?php 
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
        $width = 216;
        $height = 140;
        $html2pdf = new HTML2PDF('L', array($width,$height, 0, 0), 'en', true, 'UTF-8', array(0, 0, 0, 0));
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));

        $nombre = $id_mh.'-'.$correlativo.'-'.$dia;

        if ($pdf == 1) {
          $html2pdf->output("../reportes/recibosmedicos/recibo$nombre.pdf", "f");
        } else if ($pdf == 2) {
          $html2pdf->Output("../reportes/recibosmedicos/recibo$nombre.pdf");
        } else {  
          $html2pdf->Output("../reportes/recibosmedicos/recibo$nombre.pdf");
          $html2pdf->output("../reportes/recibosmedicos/recibo$nombre.pdf", "f");
        }
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
  }
?>