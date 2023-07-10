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

  if(isset($_REQUEST['rango'])) {

    $rango = json_decode($_REQUEST['rango'], true);

    $ordenes = json_decode(
      $obj->seleccionar("
         select a.*, b.*
        from ordenes.ordenes as a
          left join ordenes.entradas_optica as b using (id_historia)
        where a.id_orden between ? and ?", 
      $rango), 
    true);

  } else {

    if (isset($_REQUEST['id'])) {
      $id = (int)$_REQUEST['id'];
    } else {
      throw new Exception('operación inválida: ID necesario para imprimir orden'); 
    }

    if (isset($_REQUEST['datos'])) {
      $datos = json_decode($_REQUEST['datos'], true);
      $datos['id_historia'] = $id;
      $datos['id_orden'] = $obj->e_pdo("select (max(id_orden) + 1) from ordenes.ordenes")->fetchColumn();

      if(empty($datos['id_orden'])) {

        $datos['id_orden'] = 1;

      }

    } else {

      $datos = json_decode(
        $obj->seleccionar("
           select a.*, b.*
          from ordenes.ordenes as a
            left join ordenes.entradas_optica as b using (id_historia)
          where a.id_orden = ?", 
        [$id]), 
      true)[0];

      if(empty($datos['id_historia'])) {

        $datos = json_decode(
          $obj->seleccionar("
             select *
              from ordenes.ordenes
            where id_orden = ?", 
          [$id]), 
        true)[0];

        $datos['id_historia'] = '---';

      }

    }



  }

  if (isset($_REQUEST['pdf'])) {
    $pdf = (int)$_REQUEST['pdf'];
  } else {
    $pdf = 1;
  }

  // echo "<pre>";
  // print_r($datos);
  // echo "</pre>";

  $dia  = $obj->fechaHora('America/Caracas','d-m-Y');
  $hora = $obj->fechaHora('America/Caracas','H:i:s');
?>

<style>
  #separador {
    margin-top: 0px
  }

  #titulo1 {
    /*top:47px*/
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
    /*position:absolute;*/
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
    font-weight: bold;
  }

  table thead, table tbody, table tbody tr, table thead tr {
    width: 300px;
  }

  table tbody tr td, table thead tr th {
    text-align: left;
    padding: 0.6px 5px;
    font-weight: bold;
    font-size:10px;
  }

  table tbody tr td {
    font-weight: bold;
    font-size:15.4px;
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
    bottom: 0px; 
    right: 30px; 
    font-size: 15px;
  }
</style>

<?php if (!isset($_REQUEST['rango'])) {?>

<page style="width:100%" backtop="0mm" backbottom="0mm" backleft="6mm" backright="5mm">
  <div class="contenedor" style="top: -5mm; position: relative;">
    <div id="cabecera" style="height: 30px">
      <div style="position:relative; top: 10mm;">
        <h4 id="titulo1" style="font-size: 30">SERVIOPTICA</h4>
      </div> 
    </div> 
    <div class="separador imprimir-separar"></div>
    <div id="subcabecera" class="centrar" style="position: relative; top: -5px">
      A.19 de Abril Edf. Clínica de Ojos P.B. La Bermeja - San Cristóbal Edo.Táchira - TF: 3560133
    </div>

    <div class="separador"></div>

     <div style="position: absolute;  top: 5mm; left: 0mm">
       <img src="../imagenes/logo_reportes.jpg" style="width: 30mm; height: 23mm;">
    </div>

    <div style="position: absolute; top: 117px; width: 200mm; text-align: right; font-size: 28px; font-weight: bold">
      N° Orden: <?php echo $datos['id_orden']?>
    </div>

    <div style="margin-left: 25px; position: relative; top: -8px; font-size: 16px">
      Fórmula de lentes
    </div>

    <div class="subtitulo" style="position: relative; top: -8px">
      LEJOS:
    </div>

    <table class="tabla tabla-formulas" style="position: relative; top: -3px; font-size: 10px !important;">
      <tbody>
        <tr>
          <td style="width:40px;">O.D</td>
          <td style="width:20px">ESF:</td>
          <td style="width:10px"><?php echo $datos['sig_lejos_od']?></td>
          <td style="width:10px; padding-right:30px"><?php echo number_format($datos['lejos_esfera_od'], 2)?></td>
          <td style="width:20px">CIL:</td>
          <td style="width:10px; font-weight: bold;"><?php echo $datos['signo_cilindro_od']?></td>
          <td style="width:10px; padding-right:30px; font-weight: bold;"><?php echo number_format($datos['cilindro_od'], 2)?></td>
          <td><?php echo $datos['grado_od']?>°</td>
        </tr>
      </tbody>
    </table>

    <table class="tabla tabla-formulas" style="position: relative; top: -2px">
      <tbody>
        <tr>
          <td style="width:40px">O.I</td>
          <td style="width:20px">ESF:</td>
          <td style="width:10px"><?php echo $datos['sig_lejos_oi']?></td>
          <td style="width:10px; padding-right:30px"><?php echo number_format($datos['lejos_esfera_oi'], 2)?></td>
          <td style="width:20px">CIL:</td>
          <td style="width:10px; font-weight: bold;"><?php echo $datos['signo_cilindro_oi']?></td>
          <td style="width:10px; padding-right:30px"><?php echo number_format($datos['cilindro_oi'], 2)?></td>
          <td><?php echo $datos['grado_oi']?>°</td>
        </tr>
      </tbody>
    </table>

    <div class="subtitulo" style="margin-top: -2px">
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
          <td style="width:20px; padding-rigth: 30px"><?php echo number_format($datos['cerc_od'], 2)?></td>
          
            <?php if(!empty($datos['multifocal'])) {?>
              <td style="padding-left: 8px; font-size: 11px; padding-right: 0px;">MULTIFOCAL:</td>
              <td style="width: 5px; font-size: 12px; text-align:left"><?php echo $datos['multifocal']?></td>
            <?php }?>
            <?php if(!empty($datos['bifocal_kriptok'])) {?>
              <td style="padding-left: 8px; font-size: 11px; padding-right: 0px">BIFOCAL KRIPTOK:</td>
              <td style="width:5px; font-size: 12px; text-align:left"><?php echo $datos['bifocal_kriptok']?></td>
            <?php }?>

        </tr>
      </tbody>
    </table>

    <table class="tabla tabla-formulas2">
      <tbody>
        <tr style="margin-top: 10px; vertical-align: middle">
          <td style="width:40px;">O.I:</td>
          <td style="width:20px; padding-rigth: 30px;"><?php echo number_format($datos['cerc_oi'], 2)?></td>

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

    <table class="tabla tabla-formulas2" style="margin-top: 0px">
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

    <table class="tabla tabla-formulas">
      <tbody>
        <tr>
          <td style="width:fit-content">Montura:</td>
          <td style="width:fit-content; "><?php echo strtoupper($datos['montura'])?></td>
          <td style="width:fit-content;padding-left:30px">Cristales:</td>
          <td style="width:fit-content;"><?php echo strtoupper($datos['cristales'])?></td>
          <td style="width:fit-content;padding-left:30px">Altura:</td>
          <td style="width:fit-content;"><?php echo $datos['altura']?></td>
<!--           <td style="width:fit-content; padding-left:30px">Detalles:<?php echo $datos['detalle']?></td> -->
        </tr>
      </tbody>
    </table>
    <?php $w = "400px"?>
    <div style="position: absolute; bottom: 68px; font-size: 13px; right: 0px; width: <?php echo $w?>;max-width: <?php echo $w?>;min-width: <?php echo $w?>; right: 0px;">
      Detalles:&nbsp;<b><?php echo strtoupper(substr($datos['detalle'],0,40))?></b>
    </div>
    <?php  if (strlen($datos['detalle']) > 39) {?>
    <div style="position: absolute; bottom: 48px; font-size: 13px; right: 0px; width: <?php echo $w?>;max-width: <?php echo $w?>;min-width: <?php echo $w?>; right: 0px;">
      <b><?php echo strtoupper(substr($datos['detalle'], 40, 40))?></b>
    </div>
    <?php }?>
    <?php if (strlen($datos['detalle']) > 79) {?>
    <div style="position: absolute; bottom: 28px; font-size: 13px; right: 0px; width: <?php echo $w?>;max-width: <?php echo $w?>;min-width: <?php echo $w?>; right: 0px;">
      <b><?php echo strtoupper(substr($datos['detalle'],80, 20))?></b>
    </div>
    <?php }?>
    <table style="margin-top: 0px; margin-left:0px;">
      <tbody>
        <tr>
          <?php 
            if ($datos['id_historia'] == 0) {
              $datos['id_historia'] = '---';
            }
          ?>

          <td style="font-size: 14px !important;">NOMBRE:&nbsp; <?php echo $datos['apel_nomb']?></td>
          <td style="font-size: 14px !important;">N°.Cédula: &nbsp;<?php echo $datos['nume_cedu']?></td>
        </tr>
      </tbody>
    </table>
    
    <div class="fecha" style="font-size: 12px;">
      Fecha: <?php echo $dia?>
    </div>

  </div>  
</page>

<?php 
  } else { 

    $romper = 0;

    foreach ($ordenes as $i => &$datos) :     

      if ($romper == 0) {
        echo '<page style="width:100%" backtop="0mm" backbottom="0mm" backleft="6mm" backright="5mm">';
      }

?>

    <div class="contenedor" style="top: -3mm; position: relative;">
      <div id="cabecera" style="height: 30px">
        <div style="position:relative;top:10mm">
          <h4 id="titulo1" style="font-size: 30">SERVIOPTICA</h4>
        </div> 
      </div> 
      <div class="separador imprimir-separar"></div>
      <div id="subcabecera" class="centrar" style="position: relative; top: -5px">
        A.19 de Abril Edf. Clínica de Ojos P.B. La Bermeja - San Cristóbal Edo.Táchira - TF: 3560133
      </div>

      <div class="separador"></div>

       <div style="position: absolute;  top: 5mm; left: 0mm">
         <img src="../imagenes/logo_reportes.jpg" style="width: 30mm; height: 23mm;">
      </div>

      <div style="position: absolute; top: 120px; width: 200mm; text-align: right; font-size: 28px; font-weight: bold">
        N° Orden: <?php echo $datos['id_orden']?>
      </div>

      <div style="margin-left: 25px; position: relative; top: -8px; font-size: 16px">
        Fórmula de lentes
      </div>

      <div class="subtitulo" style="position: relative; top: -8px">
        LEJOS:
      </div>

      <table class="tabla tabla-formulas" style="position: relative; top: -3px; font-size: 10px !important;">
        <tbody>
          <tr>
            <td style="width:40px;">O.D</td>
            <td style="width:20px">ESF:</td>
            <td style="width:10px"><?php echo $datos['sig_lejos_od']?></td>
            <td style="width:10px; padding-right:30px"><?php echo number_format($datos['lejos_esfera_od'], 2)?></td>
            <td style="width:20px">CIL:</td>
            <td style="width:10px; font-weight: bold;"><?php echo $datos['signo_cilindro_od']?></td>
            <td style="width:10px; padding-right:30px; font-weight: bold;"><?php echo number_format($datos['cilindro_od'], 2)?></td>
            <td><?php echo $datos['grado_od']?>°</td>
          </tr>
        </tbody>
      </table>

      <table class="tabla tabla-formulas" style="position: relative; top: -2px">
        <tbody>
          <tr>
            <td style="width:40px">O.I</td>
            <td style="width:20px">ESF:</td>
            <td style="width:10px"><?php echo $datos['sig_lejos_oi']?></td>
            <td style="width:10px; padding-right:30px"><?php echo number_format($datos['lejos_esfera_oi'], 2)?></td>
            <td style="width:20px">CIL:</td>
            <td style="width:10px; font-weight: bold;"><?php echo $datos['signo_cilindro_oi']?></td>
            <td style="width:10px; padding-right:30px"><?php echo number_format($datos['cilindro_oi'], 2)?></td>
            <td><?php echo $datos['grado_oi']?>°</td>
          </tr>
        </tbody>
      </table>

      <div class="subtitulo" style="margin-top: -2px">
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
            <td style="width:20px; padding-rigth: 30px"><?php echo number_format($datos['cerc_od'], 2)?></td>
            
              <?php if(!empty($datos['multifocal'])) {?>
                <td style="padding-left: 8px; font-size: 11px; padding-right: 0px;">MULTIFOCAL:</td>
                <td style="width: 5px; font-size: 12px; text-align:left"><?php echo $datos['multifocal']?></td>
              <?php }?>
              <?php if(!empty($datos['bifocal_kriptok'])) {?>
                <td style="padding-left: 8px; font-size: 11px; padding-right: 0px">BIFOCAL KRIPTOK:</td>
                <td style="width:5px; font-size: 12px; text-align:left"><?php echo $datos['bifocal_kriptok']?></td>
              <?php }?>

          </tr>
        </tbody>
      </table>

      <table class="tabla tabla-formulas2">
        <tbody>
          <tr style="margin-top: 10px; vertical-align: middle">
            <td style="width:40px;">O.I:</td>
            <td style="width:20px; padding-rigth: 30px;"><?php echo number_format($datos['cerc_oi'], 2)?></td>

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

      <table class="tabla tabla-formulas2" style="margin-top: 0px">
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

      <table class="tabla tabla-formulas">
        <tbody>
          <tr>
            <td style="width:fit-content">Montura:</td>
            <td style="width:fit-content; "><?php echo strtoupper($datos['montura'])?></td>
            <td style="width:fit-content;padding-left:30px">Cristales:</td>
            <td style="width:fit-content;"><?php echo strtoupper($datos['cristales'])?></td>
            <td style="width:fit-content;padding-left:30px">Altura:</td>
            <td style="width:fit-content;"><?php echo $datos['altura']?></td>
  <!--           <td style="width:fit-content; padding-left:30px">Detalles:<?php echo $datos['detalle']?></td> -->
          </tr>
        </tbody>
      </table>
      <?php $w = "400px"?>
      <div style="position: absolute; bottom: 68px; font-size: 13px; right: 0px; width: <?php echo $w?>;max-width: <?php echo $w?>;min-width: <?php echo $w?>; right: 0px;">
        Detalles:&nbsp;<b><?php echo strtoupper(substr($datos['detalle'],0,40))?></b>
      </div>
      <?php  if (strlen($datos['detalle']) > 39) {?>
      <div style="position: absolute; bottom: 48px; font-size: 13px; right: 0px; width: <?php echo $w?>;max-width: <?php echo $w?>;min-width: <?php echo $w?>; right: 0px;">
        <b><?php echo strtoupper(substr($datos['detalle'], 40, 40))?></b>
      </div>
      <?php }?>
      <?php if (strlen($datos['detalle']) > 79) {?>
      <div style="position: absolute; bottom: 28px; font-size: 13px; right: 0px; width: <?php echo $w?>;max-width: <?php echo $w?>;min-width: <?php echo $w?>; right: 0px;">
        <b><?php echo strtoupper(substr($datos['detalle'],80, 20))?></b>
      </div>
      <?php }?>
      <table style="margin-top: 0px; margin-left:0px;">
        <tbody>
          <tr>
            <?php 
              if ($datos['id_historia'] == 0) {
                $datos['id_historia'] = '---';
              }
            ?>

            <td style="font-size: 14px !important;">NOMBRE:&nbsp; <?php echo $datos['apel_nomb']?></td>
            <td style="font-size: 14px !important;">N°.Cédula: &nbsp;<?php echo $datos['nume_cedu']?></td>
          </tr>
        </tbody>
      </table>
      
      <div class="fecha" style="font-size: 12px;">
        Fecha: <?php echo $dia?>
      </div>

    </div>  
  

<?php

    $romper = $romper + 1;

    if($romper == 3) {
      echo "</page>";
      $romper = 0;
    }

    endforeach; 

    if($romper < 3) {
      if ($romper != 0) {
        echo "</page>";  
      }
      
    }
?>

<?php } ?>

<?php
  require_once(dirname(__FILE__).'/../vendor/autoload.php');
  require_once('../vendor/autoload.php');
  use Spipu\Html2Pdf\Html2Pdf;

  if($pdf !== 0) {
    $content = ob_get_clean();

    try
    {  

        if (!isset($id) && isset($rango)) {
          $id = json_encode($rango);
        }

        $width_in_mm = 216;
        $height_in_mm = 280;

        $html2pdf = new HTML2PDF('P', array($width_in_mm, $height_in_mm), 'en', true, 'UTF-8', array(0, 0, 0, 0));
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));

        $hora   = $obj->fechaHora('America/Caracas','H-i-s');
        $obj->fechaHora('America/Caracas','d-m-Y');
        $nombre = $id.'-'.$dia.'-'.$hora;

        if($pdf == 1) {
          $html2pdf->Output("../reportes/formulas/formulas_optica$nombre.pdf", "f");
        } else if ($pdf == 2) {
          $html2pdf->Output("../reportes/formulas/formulas_optica$nombre.pdf");
        } else if ($pdf == 3){      
          $html2pdf->Output("../reportes/formulas/formulas_optica$nombre.pdf");
          $html2pdf->output("../reportes/formulas/formulas_optica$nombre.pdf", "f");
        }
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
  }
?>