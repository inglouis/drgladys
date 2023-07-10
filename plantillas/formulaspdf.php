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

  if (isset($_REQUEST['id'])) {
    $id = (int)$_REQUEST['id'];
  } else {
    throw new Exception('operación inválida: ID necesario para imprimir formula'); 
  }

  if (isset($_REQUEST['datos'])) {

    $query = json_decode($_REQUEST['datos'], true);

    $formula = $query[0];
    $fecha = $query[1];

    $cantidad = count($formula);

    if (count($formula) <= 21) {

      for ($i=0; $i < 30 - $cantidad ; $i++) { 
        
        array_push($formula, "");

      }

    }

    //echo count($formula);

    $dia = $fecha;

    $datos = json_decode($obj->seleccionar("
        select 
          a.id_historia,
          a.nume_cedu,
          a.nume_hijo,
          a.nume_hist,
          a.apel_nomb,
          a.id_medico,
          a.sexo,
          a.id_ocupacion,
          a.fech_naci,
          a.dire_paci,
          a.telefonos,
          a.correos,
          a.id_motivo,
          a.id_referido,
          a.diabetico,
          a.hipertenso,
          a.glaucoma,
          a.estrabismo,
          a.lent_cont,
          a.lent_mont,
          a.lent_intr,
          a.alergico,
          a.cirugias,
          '$formula[0]' as sig_lejos_od,
          $formula[1]::numeric(14,2) as lejos_esfera_od,
          '$formula[2]' as signo_cilindro_od,
          $formula[3]::numeric(14,2) as cilindro_od,
          '$formula[4]' as grado_od,
          '$formula[5]' as sig_lejos_oi,
          $formula[6]::numeric(14,2) as lejos_esfera_oi,
          '$formula[7]' as signo_cilindro_oi,
          $formula[8]::numeric(14,2) as cilindro_oi,
          '$formula[9]' as grado_oi,
          '$formula[10]' as cerc_od,
          '$formula[11]' as cerc_oi,
          '$formula[12]' as cb_od,
          '$formula[13]' as cb_oi,
          '$formula[14]' as bifocal_kriptok,
          '$formula[15]' as bifocal_flat_top,
          '$formula[16]' as bifocal_ultex,
          '$formula[17]' as bifocal_ejecutivo,
          '$formula[18]' as multifocal,
          '$formula[19]' as di_od_oi,
          '$formula[20]' as avod2,
          '$formula[21]' as avoi2,
          '$formula[22]' as avod3,
          '$formula[23]' as avoi3,
          '$formula[24]' as po_od,
          '$formula[25]' as po_oi,
          '$formula[26]' as fondo_ojo_1,
          '$formula[27]' as fondo_ojo_2,
          '$formula[28]' as fondo_ojo_3,
          trim(b.descripcion)::character varying(300) as tabfor 
        from historias.entradas as a
      left join historias.tabfor as b using (id_tabfor)
      where a.id_historia = ?
    ", [$id]), true)[0];

  } else {
     
    $datos = json_decode($obj->seleccionar("select a.*, trim(b.descripcion)::character varying(300) as tabfor from historias.entradas as a
    left join historias.tabfor as b using (id_tabfor)
    where a.id_historia = ?", [$id]), true)[0];

    $dia  = $obj->fechaHora('America/Caracas','d-m-Y');

  }

  // echo "<pre>";
  // print_r($formula);
  // echo "</pre>";

  if (isset($_REQUEST['pdf'])) {
    $pdf = (int)$_REQUEST['pdf'];
  } else {
    $pdf = 1;
  }

  $hora = $obj->fechaHora('America/Caracas','H:i:s');

?>

<style>
  #separador {
    margin-top: 0px
  }

  #titulo1 {
    top:47px
  }

  #titulo2 {
    top: 65px;
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
    width: 92%;
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
    font-size: 13px;
  }

  .derecha {
    text-align: right !important;
  }

  .small {
    font-size: 12px;
    padding-top: 1px;
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
    <div class="separador"></div>

     <div style="position: absolute;  top: 5mm; left: 0mm">
       <img src="../imagenes/logo_reportes.jpg" style="width: 30mm; height: 23mm;">
    </div>

    <div class="subtitulo">
      LEJOS:
    </div>  
    <table class="tabla tabla-formulas">
      <tbody>
        <tr>
          <td style="width:40px">O.D</td>
          <td style="width:20px">ESF:</td>
          <td style="width:10px"><?php echo $datos['sig_lejos_od']?></td>
          <td style="width:10px; padding-right:30px"><?php echo $datos['lejos_esfera_od']?></td>
          <td style="width:20px">CIL:</td>
          <td style="width:10px; font-weight: bold;"><?php echo $datos['signo_cilindro_od']?></td>
          <td style="width:10px; padding-right:30px; font-weight: bold;"><?php echo $datos['cilindro_od']?></td>
          <td><?php echo $datos['grado_od']?>°</td>
        </tr>
      </tbody>
    </table>

    <table class="tabla tabla-formulas">
      <tbody>
        <tr>
          <td style="width:40px">O.I</td>
          <td style="width:20px">ESF:</td>
          <td style="width:10px"><?php echo $datos['sig_lejos_oi']?></td>
          <td style="width:10px; padding-right:30px"><?php echo $datos['lejos_esfera_oi']?></td>
          <td style="width:20px">CIL:</td>
          <td style="width:10px; font-weight: bold;"><?php echo $datos['signo_cilindro_oi']?></td>
          <td style="width:10px; padding-right:30px"><?php echo $datos['cilindro_oi']?></td>
          <td><?php echo $datos['grado_oi']?>°</td>
        </tr>
      </tbody>
    </table>

    <div class="subtitulo" style="margin-top: 20px">
      CERCA:
    </div>
   
      <?php 
        if ($datos['cerc_od'] !== '0.00' || $datos['cerc_oi'] !== '0.00') {
      ?>
    <table class="tabla tabla-formulas2">
      <thead>
        <tr>
          <th>ADD</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <tr style="margin-bottom: 10mm">
          <td style="width:40px">O.D:</td>
          <td style="width:20px; padding-rigth: 30px"><?php echo $datos['cerc_od']?></td>

            <?php if(!empty($datos['multifocal'])) {?>
              <td style="padding-left: 8px; font-size: 11px; padding-right: 0px;">MULTIFOCAL:</td>
              <td style="width: 5px; font-size: 12px; text-align:left"><?php echo $datos['multifocal']?></td>
            <?php }?>
            <?php if(!empty($datos['bifocal_kriptok'])) {?>
              <td style="padding-left: 8px; font-size: 11px; padding-right: 0px">BIFOCAL KRIPTOK:</td>
              <td style="width:5px; font-size: 12px; text-align:left"><?php echo $datos['bifocal_kriptok']?></td>
            <?php }?>

          <td style="width:60mm; text-align: center"><?php echo $datos['tabfor']?></td>
        </tr>
      </tbody>
    </table>

    <table class="tabla tabla-formulas2">
      <tbody>
        <tr style="margin-top: 10px; vertical-align: middle">
          <td style="width:40px;">O.I:</td>
          <td style="width:20px; padding-rigth: 30px;"><?php echo $datos['cerc_oi']?></td>

            <?php if(!empty($datos['bifocal_flat_top'])) {?>
              <td style="padding-left: 8px; font-size: 11px; padding-right: 0px">BIFOCAL FLAT TOP:</td>
              <td style="width:5px; font-size: 12px; text-align:left"><?php echo $datos['bifocal_flat_top']?></td>
            <?php }?>

            <?php if(!empty($datos['bifocal_ultex'])) {?>
              <td style="padding-left: 8px; font-size: 11px; padding-right: 0px">BIFOCAL ULTEX:</td>
              <td style="width:5px; font-size: 12px; text-align:left"><?php echo $datos['bifocal_ultex']?></td>
            <?php }?>

            <?php if(!empty($datos['bifocal_ejecutivo'])) {?>
              <td style="padding-left: 8px; font-size: 11px; padding-right: 0px">BIFOCAL EJECUTIVO:</td>
              <td style="width:5px; font-size: 12px; text-align:left"><?php echo $datos['bifocal_ejecutivo']?></td>
            <?php }?>
        </tr>
      </tbody>
    </table>
    <?php 
      } else {
    ?>
    <table class="tabla tabla-formulas2">
      <thead>
        <tr>
          <th>ADD</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <tr style="margin-bottom: 10mm">
          <td style="width:40px">O.D:</td>
          <td style="width:20px; padding-rigth: 30px"><?php echo $datos['cerc_od']?></td>
          <td style="width:60mm; text-align: center"><?php echo $datos['tabfor']?></td>
        </tr>
      </tbody>
    </table>
    <table class="tabla tabla-formulas2">
      <tbody>
        <tr style="margin-top: 10px; vertical-align: middle">
          <td style="width:40px;">O.I:</td>
          <td style="width:20px; padding-rigth: 30px;"><?php echo $datos['cerc_oi']?></td>
        </tr>
      </tbody>
    </table>
    <?php 
      }
    ?>

    <table class="tabla tabla-formulas2" style="margin-top: 20px">
      <tbody>
        <tr>
          <td style="width:40px">D.I:</td>
          <td style="width:20px; padding-rigth: 30px"><?php echo $datos['di_od_oi']?></td>
          <td style="padding-left: 30px;">CB O.D:</td>
          <td style="width:10px"><?php echo $datos['cb_od']?></td>
        </tr>
        <tr>
          <td style="width:40px"></td>
          <td style="width:20px; padding-rigth: 30px"></td>
          <td style="padding-left: 30px;">CB O.I:</td>
          <td style="width:10px"><?php echo $datos['cb_oi']?></td>
        </tr>
      </tbody>
    </table>

    <table style="margin-top: 15px; margin-left:20px; font-size: 14px">
      <tbody>
        <tr>
          <td style=" font-size: 14px">N° Historia: <div class="small" style=" font-size: 14px"><?php echo $datos['id_historia']?></div></td>
          <td style=" font-size: 14px">NOMBRE: <div class="small" style=" font-size: 14px"><?php echo $datos['apel_nomb']?></div></td>
          <td style=" font-size: 14px">N°.Cédula: <div class="small" style=" font-size: 14px"><?php echo $datos['nume_cedu']?></div></td>
        </tr>
      </tbody>
    </table>
    
    <div class="fecha" style="position: absolute; bottom: 35px; right: 10px;">
      Fecha: <?php echo $dia?>
    </div>

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
        $width_in_mm = 216;
        $height_in_mm = 280;

        $html2pdf = new HTML2PDF('P', array($width_in_mm, $height_in_mm), 'en', true, 'UTF-8', array(0, 0, 0, 0));
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));

        $hora   = $obj->fechaHora('America/Caracas','H-i-s');
        $obj->fechaHora('America/Caracas','d-m-Y');
        $nombre = $id.'-'.$dia.'-'.$hora;

        if($pdf == 1) {
          $html2pdf->Output("../reportes/formulas/formula$nombre.pdf", "f");
        } else if ($pdf == 2) {
          $html2pdf->Output("../reportes/formulas/formula$nombre.pdf");
        } else if ($pdf == 3){      
          $html2pdf->Output("../reportes/formulas/formula$nombre.pdf");
          $html2pdf->output("../reportes/formulas/formula$nombre.pdf", "f");
        }
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
  }
?>