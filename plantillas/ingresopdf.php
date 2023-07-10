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

  if (isset($_REQUEST['datos'])) {

    $lista = json_decode($_REQUEST['datos'], true);

    if (count($lista) > 8) {

      // echo "<pre>";
      // print_r($lista);
      // echo "</pre>";

        $lista = array(
          0 => $lista[0],
          1 => $lista[1],
          2 => '',
          3 => $lista[5],
          4 => '',
          5 => '',
          6 => $lista[6],
          7 => $lista[7],
          8 => $lista[8],
          9 => $lista[9],
          10=> $lista[10]
        );
  
    }

  } else {
    throw new Exception('operación inválida: DATOS necesaria para imprimir ingreso'); 
  }

  if (isset($_REQUEST['id_presupuesto'])) {

    $id_presupuesto = $_REQUEST['id_presupuesto'];

    if (count($lista) < 8) {

      // echo "<pre>";
      // print_r($lista);
      // echo "</pre>";

        $lista = array(
          0 => $lista[0],
          1 => $lista[1],
          2 => '',
          3 => $lista[2],
          4 => '',
          5 => '',
          6 => $lista[3],
          7 => $lista[4],
          8 => $lista[5],
          9 => $lista[6],
          10=> $id_presupuesto
        );
  
    }

    $datos = $obj->i_pdo(
      "select 
          b.id_historia,
          a.id_presupuesto,
          b.apel_nomb, 
          b.nume_cedu,
          b.telefonos,
          a.totales,
          a.conversiones,
          TO_CHAR(current_date :: DATE, 'dd-mm-yyyy') as fecha_arreglada,
          c.nombre as nombre_cirugia
       from ppal.v_presupuesto as a
       inner join historias.entradas as b using(id_historia)
       inner join historias.cirugias as c using(id_cirugia)
       where a.id_presupuesto = ?", [$id_presupuesto], true
    )->fetch(PDO::FETCH_ASSOC);
 

  } else {
    throw new Exception('operación inválida: ID_PRESUPUESTO necesaria para imprimir ingreso'); 
  }

  $pago = $obj->i_pdo("select desc_fopa from primarias.form_pago where codi_fopa = $lista[6]", [], true)->fetchColumn();
  $datos['totales']      = json_decode($datos['totales'], true);
  $datos['telefonos']    = json_decode($datos['telefonos'], true);
  $datos['conversiones'] = json_decode($datos['conversiones'], true);

  $total = $lista[0]; //$datos['totales']['total'] * $datos['conversiones'][2];

;
$timestamp = strtotime($lista[1]);

// echo "<pre>";
// print_r($lista);
// echo "</pre>";

//echo $total;

if (empty(trim($lista[7]))) { $lista[7] = $datos['apel_nomb']; }
if (empty(trim($lista[8]))) { $lista[8] = $datos['nume_cedu']; }

if (count($lista[9]) < 1) { 

  $lista[9] = $datos['telefonos'];

} else {

  foreach ($lista[9] as &$t) {
    if(isset($t['value'])) {
      $t = strval($t['value']);
    } else {
      $t = strval($t);
    }
  }
}

$descripcion = $lista[3];
$paciente  = $lista[7];
$cedula    = $lista[8];
$telefonos = $lista[9];


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

<?php 
  for ($i=0; $i < 3; $i++) { 

?>

<page style="width:215mm" backtop="47mm" backbottom="0mm" backleft="4mm" backright="5mm">

  <!--<img src="../imagenes/comp.jpg" style="position: absolute; height: 152mm; width: 209.5mm;top: -170px; left: -15px">-->

  <div class="contenedor" style="position: absolute;">

    <div style="font-size: 14px; position: absolute; right: 96px; top: -116px;">
      <b>&nbsp;&nbsp;&nbsp;<?php echo date("d", $timestamp);?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo date("m", $timestamp);?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo date("Y", $timestamp);?></b>
    </div>

    <div style="position: absolute; top: -40px; left: 250px; font-size: 20px; font-weight: bold">
      <?php echo number_format($total, 2, ',', '.');?>
    </div>


    <div style="position: absolute; left: 30px; top: 4px; font-size: 16px; text-transform: uppercase;">
      <?php echo $paciente;?>
    </div>
    
    <div style="position: absolute; left: 600px; top: -2px; font-size: 16px; text-transform: uppercase;">
      <?php echo strtoupper($cedula);?>
    </div>

    <div style="position: absolute; left: 110px; top: 35px; font-size: 12px; text-transform: uppercase;">
      <?php
        $concat = "";
        foreach ($telefonos as $r) {
          $concat .= $r.' - ';
        }
        $concat = substr($concat, 0,-2);
        echo $concat;
      ?>
    </div>

    <div style="position: absolute; left: 525px; top: 30px; font-size: 12px; text-transform: uppercase;">
     <?php echo strtoupper($pago)?>
    </div>

    <div class="separador" style="position: relative; top: 70px; width: 185mm; left: 30px; text-transform: uppercase;"></div>

    <div></div>

    <div style="font-size: 12px; padding-left: 40px;font-weight: bold; text-transform: uppercase;"><?php echo $descripcion;?></div>
    <div style="font-size: 12px; padding-left: 40px;font-weight: bold"><?php echo $datos['nombre_cirugia']?></div>
    <div style="font-size: 12px; padding-left: 40px">SEGÚN PRESUPUESTO N°: &nbsp;<b><?php echo $datos['id_presupuesto']?></b></div>

    <div></div>

    <div style="font-size: 12px; padding-left: 40px; font-weight: bold">POR SERVICIO PRESTADO AL PACIENTE:</div>
    <div style="font-size: 12px; padding-left: 40px"><?php echo $datos['apel_nomb']?></div>

    <div class="separador" style="position: relative; top: 20px; width: 185mm; left: 30px;"></div>
    
    <div style='font-size:18px; width:193mm; text-align:right; font-weight: bold; position: relative; top: 55px'> 
      <?php
        echo number_format($total, 2, ',', '.');
      ?> 
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
        $height = 280;
        $html2pdf = new HTML2PDF('P', array($width,$height, 0, 0), 'en', true, 'UTF-8', array(0, 0, 0, 0));
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));

        $hora   = $obj->fechaHora('America/Caracas','H-i-s');
        $obj->fechaHora('America/Caracas','d-m-Y');
        $nombre = $datos['id_historia'].'-'.$datos['id_presupuesto'].'-'.$dia;

        if ($pdf == 1) {
          $html2pdf->output("../reportes/ingresos/ingreso$nombre.pdf", "f");
        } else if ($pdf == 2) {
          $html2pdf->Output("../reportes/ingresos/ingreso$nombre.pdf");
        } else {  
          $html2pdf->Output("../reportes/ingresos/ingreso$nombre.pdf");
          $html2pdf->output("../reportes/ingresos/ingreso$nombre.pdf", "f");
        }
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
  }
?>