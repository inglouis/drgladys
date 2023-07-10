<?php
  /*MODOS PDF:
    0: traer solo estructura HTML //ESTE SE DESCARTARÁ PARA OTROS REPORTES
    1: solo guardar REPORTE,
    2: traer reporte SIN GUARDAR,
    3: traer reporte Y GUARDAR, 
  */

  ob_start();

  include_once('../../clases/pruebas.class.php');
  $obj = new Model();

  $dia  = $obj->fechaHora('America/Caracas','d-m-Y');
  $hora = $obj->fechaHora('America/Caracas','H:i:s');
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

  if (isset($_REQUEST['datos'])) {

    if ($modo == 'insertado') {

      $lista = (int)$_REQUEST['datos'];

    } else {
      
      $lista = json_decode($_REQUEST['datos'], true);

    }

  } else {
    throw new Exception('operación inválida: DATOS necesaria para imprimir ingreso'); 
  }


  // echo "<pre>";
  // print_r($lista);
  // echo "</pre>";

   // [0] => 3                -formato
   // [1] => 320              -subtotal
   // [2] => 371.2            -total
   // [3] => 2022-07-06       -fecha
   // [4] => 16               -iva
   // [5] => X                -suma
   // [6] =>                  -resta
   // [7] => 1                -id_pago
   // [8] => 2                -id_persona
   // [9] => C O C I A, C.A.  -nombre persona
   // [10] => 3560139         -telefono persona
   // [11] => J-30403474-1    -rif persona
   // [12] => 2               -nuevo control
   // [13] => descripcion     -descripcion

  if ($modo == 'previa') {

    // echo "<pre>";
    // print_r($lista);
    // echo "</pre>";

    $formato     = $lista[0];
    $subtotal    = $lista[1];
    $total       = $lista[2];
    $fecha       = $lista[3];
    $iva         = $lista[4];
    $suma        = $lista[5];
    $resta       = $lista[6];
    $forma       = $lista[7];
    $persona     = $lista[8];
    $nombre      = $lista[9];
    $telefono    = $lista[10];
    $rif         = $lista[11];
    $control     = $lista[12];
    $descripcion = $lista[13];

    if (empty($control)) {
      $control = 1;
    }

    $nombrePersona = $nombre;

  } else if ($modo == 'insertado') {

      $datos = $obj->i_pdo(
        "select 
            a.*,
            b.telefono,
            b.rif
         from historias.recibos_personas as a
         left join facturacion.personas as b using(id_persona)
         where a.id_recibo = ?", [$lista], true
      )->fetch(PDO::FETCH_ASSOC);

      $formato     = $datos['id_formato'];
      $subtotal    = $datos['subtotal'];
      $total       = $datos['total'];
      $fecha       = $datos['fecha'];
      $iva         = $datos['islr'];
      $suma        = $datos['suma'];
      $resta       = $datos['resta'];
      $forma       = $datos['id_pago'];
      $persona     = $datos['id_persona'];
      $descripcion = $datos['descripcion'];
      $telefono    = $datos['telefono'];
      $rif         = $datos['rif'];
      $control     = $datos['control'];

      $nombrePersona = $obj->i_pdo("select nombre from facturacion.personas where id_persona = $persona", [], true)->fetchColumn();
  
  } else if ($modo = 'reimprimir') {

    $formato     = $lista['id_formato'];
    $subtotal    = $lista['subtotal'];
    $total       = $lista['total'];
    $fecha       = $lista['fecha'];
    $iva         = $lista['islr'];
    $suma        = $lista['suma'];
    $resta       = $lista['resta'];
    $forma       = $lista['id_pago'];
    $persona     = $lista['id_persona'];
    $descripcion = $lista['descripcion'];
    $telefono    = $lista['telefono'];
    $rif         = $lista['rif'];
    $control     = $lista['control'];

    $nombrePersona = $obj->i_pdo("select nombre from facturacion.personas where id_persona = $persona", [], true)->fetchColumn();

  } else {
     throw new Exception('operación inválida: MODO INVÁLIDO'); 
  }

  $pago = $obj->i_pdo("select desc_fopa from primarias.form_pago where codi_fopa = $forma", [], true)->fetchColumn();

  $timestamp = strtotime($fecha);

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
    padding: 0px;
    font-size: 15px;
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
  for ($i=0; $i < 3; $i++) { 
  
  require('formatopdf.php');

?>


<?php
  }
?>

<?php
  require_once(dirname(__FILE__).'/../../vendor/autoload.php');
  require_once('../../vendor/autoload.php');
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
        $nombre = $persona.'-'.$dia;

        if ($pdf == 1) {
          $html2pdf->output("../../reportes/recibos_personas/recibo$nombre.pdf", "f");
        } else if ($pdf == 2) {
          $html2pdf->Output("../../reportes/recibos_personas/recibo$nombre.pdf");
        } else {  
          $html2pdf->Output("../../reportes/recibos_personas/recibo$nombre.pdf");
          $html2pdf->output("../../reportes/recibos_personas/recibo$nombre.pdf", "f");
        }
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
  }
?>