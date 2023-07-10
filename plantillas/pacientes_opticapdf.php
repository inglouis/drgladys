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



  //print_r($datos);

  if (isset($_REQUEST['pdf'])) {
    $pdf = (int)$_REQUEST['pdf'];
  } else {
    $pdf = 1;
  }

  if (isset($_REQUEST['fecha'])) {
    
    $dia_desde = json_decode($_REQUEST['fecha'], true)[0];
    $dia_hasta = json_decode($_REQUEST['fecha'], true)[1];

    $sql = "
    	select 
    		*,
    		case when id_historia is not null then id_historia::character varying(100) else '' end as id_historia_procesada,
            case when id_historia is not null then 'REGISTRADO' else 'ANONIMO' end as modo_cliente
    	from ordenes.ordenes where fecha_dia between '$dia_desde'::date and '$dia_hasta'::date and status = 'A' order by id_orden asc";

    $datos = $obj->e_pdo($sql)->fetchAll(PDO::FETCH_ASSOC);

    $fecha = new DateTime($dia_desde);
    $dia_desde = $fecha->format('d-m-Y');

    $fecha = new DateTime($dia_hasta);
    $dia_hasta = $fecha->format('d-m-Y');

    $clientes = array(
    	"REGISTRADO" => 0,
    	"ANONIMO" => 0
    );

    foreach ($datos as $r) {
    	
    	$clientes[$r['modo_cliente']] = $clientes[$r['modo_cliente']] + 1;

    }

  } else {
    throw new Exception('operación inválida: FECHA necesario para resumen del día óptica'); 
  }

?>

<style>
      #separador {
        margin-top: 0px
      }

      #titulo1 {
        
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

      table thead tr th {
        border-bottom: 2px dashed #262626;
        border-top: 2px dashed #262626;
        text-align: center;
        font-size: 13px;
      }

      table tbody tr td {
        font-size: 11px;
      }
</style>

<page style="width: 270mm" backtop="4mm" backbottom="5mm" backleft="5mm" backright="5mm">
  <div class="contenedor">
    <div id="cabecera" style="height: 70px">
      <div style="position:relative; top: 40px; height: 60px">
        <h4 id="titulo1" style="font-size: 30; position: absolute;">SERVIOPTICA</h4>
      </div> 
    </div> 
    <div class="separador imprimir-separar"></div>
    <div id="subcabecera" class="centrar">
      A.19 de Abril Edf. Clínica de Ojos P.B. La Bermeja - San Cristóbal Edo.Táchira - TF: 3560133
    </div>

    <div style="position: absolute;  top: 5mm; left: 0mm">
       <img src="../imagenes/logo_reportes.jpg" style="width: 30mm; height: 23mm;">
    </div>

    <div class="separador" id="separador"></div>

    <?php 
      if ($dia_desde == $dia_hasta) {
        echo "
          <div style=\"width: 270mm; text-align: center;\">
            <b style=\"width:fit-content; border-bottom: 2px dashed #ccc; font-size: 16px\">RESUMEN DEL DÍA $dia_desde</b>
          </div>
        ";
      } else {
        echo "
          <div style=\"width: 270mm; text-align: center;\">
            <u><b style=\"width:fit-content; border-bottom: 2px dashed #ccc; font-size: 16px\">RESUMEN DEL DÍA DESDE $dia_desde HASTA $dia_hasta</b></u>
          </div>
        ";
      }
    ?>

    <div></div>

    <div style="font-size: 14px; position: relative;">
      Clientes capturados en el margen de fechas: <b><?php echo $clientes['REGISTRADO']?></b> &nbsp;&nbsp;-&nbsp;&nbsp; Clientes anónimos en el margen de fechas: <b><?php echo $clientes['ANONIMO']?></b>
    </div>

    <table style="width: 260mm; margin-top: 0px;border-left: none; border-collapse: collapse; margin-left: 5px">
      <thead>
        <tr>
          <th style="" class="planes_cabecera">Fecha</th>
          <th style="" class="planes_cabecera">Nombre de paciente:</th>
          <th style="" class="planes_cabecera">Orden:</th>
          <th style="" class="planes_cabecera">Cliente:</th>
          <th style="" class="planes_cabecera">Cédula:</th>
          <th style="" class="planes_cabecera">Montura:</th>
          <th style="" class="planes_cabecera">Cristales:</th>
          <th style="" class="planes_cabecera">Altura:</th>
          <th style="" class="planes_cabecera">Fórmula:</th>      
      	</tr>
      </thead>
      <tbody style="width: 190mm;">
        <?php foreach ($datos as $r) : ?>

          <?php 
            // echo "<pre>";
            // print_r($r);
            // echo "</pre>";
          ?>

          <tr style="padding: 5px;">
            <td style="width: 10mm; height: 15px; text-align: center; vertical-align: middle;">
              <?php echo $r['fecha_dia']?>
            </td>
            <td style="width: 40mm; height: 15px; text-align: center; vertical-align: middle;">
              <?php echo $r['apel_nomb']?>
            </td>
            <td style="width: 10mm; height: 15px; text-align: center; vertical-align: middle;">
              <?php echo $r['id_orden']?>
            </td>
            <td style="width: 20mm; height: 15px; text-align: center; vertical-align: middle;">
              <?php echo $r['modo_cliente']?>
            </td>
            <td style="width: 15mm; height: 15px; text-align: center; vertical-align: middle;">
              <?php echo $r['nume_cedu']?>
            </td>
            <td style="width: 25mm; height: 15px; text-align: center; vertical-align: middle;">
              <?php echo $r['montura']?>
            </td>
            <td style="width: 15mm; height: 15px; text-align: center; vertical-align: middle;">
              <?php echo $r['cristales']?>
            </td>

            <td style="width: 25mm; height: 15px; text-align: center; vertical-align: middle;">
              <?php echo $r['altura']?>
            </td>

              <?php 

              // if ($r['sig_lejos_od'] !== '' || 
              //     $r['lejos_esfera_od'] !== '0.00' ||
              //     $r['signo_cilindro_od'] !==  '' ||
              //     $r['cilindro_od'] !== '0.00' ||
              //     $r['grado_od'] !== '0'
              //   ) {

              ?>

              <td style="width: 60mm; height: 5px; text-align: center; vertical-align: top;">
                <?php 
                  echo "OD:"."&nbsp;";

                  if (trim($r['sig_lejos_od']) != '' ) {
                   echo $r['sig_lejos_od']."&nbsp;";
                  } else {
                    echo "!&nbsp;";
                  }

                  echo $r['lejos_esfera_od']."&nbsp;";

                  if (trim($r['signo_cilindro_od']) != '') {
                   echo $r['signo_cilindro_od']."&nbsp;";
                  } else {
                    echo "!&nbsp;";
                  }

                  echo $r['cilindro_od']."&nbsp;";
                  echo "&nbsp;x&nbsp;";
                  echo $r['grado_od']."&nbsp;";


                  if($r['cerc_od'] !== '0.00') {
                    echo "&nbsp;&nbsp;ADD OD:&nbsp;".$r['cerc_od'];
                  }

                  // if($r['sig_lejos_od'] !== '') {
                  //   echo $r['sig_lejos_od'];
                  // }

                  // if($r['lejos_esfera_od'] !== '0.00') {
                  //   echo $r['lejos_esfera_od'];
                  // }

                  // if($r['signo_cilindro_od'] !== '') {
                  //   echo $r['signo_cilindro_od'];
                  // }

                  // if($r['cilindro_od'] !== '0.00') {
                  //   echo $r['cilindro_od'];
                  // }

                  // if($r['grado_od'] !== '0') {
                  //   echo $r['grado_od'];
                  // }
                ?>
              </td>

              <?php

              // } else {

              //   echo "<td style=\"width: 50mm; height: 5px; text-align: center; vertical-align: middle; border-bottom: 1px dashed #ccc\">OD:</td>";

              // }

              ?>

            <td>
              
            </td>
          </tr>
          <tr style="border:none !important;">
            <td style="width: 10mm; height: 15px; text-align: center; vertical-align: middle;"></td>
            <td style="width: 40mm; height: 15px; text-align: center; vertical-align: middle;"></td>
            <td style="width: 10mm; height: 15px; text-align: center; vertical-align: middle;"></td>
            <td style="width: 20mm; height: 15px; text-align: center; vertical-align: middle;"></td>
            <td style="width: 15mm; height: 15px; text-align: center; vertical-align: middle;"></td>
            <td style="width: 20mm; height: 15px; text-align: center; vertical-align: middle;"></td>
            <td style="width: 15mm; height: 15px; text-align: center; vertical-align: middle;"></td>
            <td style="width: 25mm; height: 15px; text-align: center; vertical-align: middle;"></td>
            <?php 

              // if ($r['sig_lejos_oi'] !== '' || 
              //     $r['lejos_esfera_oi'] !== '0.00' ||
              //     $r['signo_cilindro_oi'] !==  '' ||
              //     $r['cilindro_oi'] !== '0.00' ||
              //     $r['grado_oi'] !== '0'
              //   ) {

              ?>

              <td style="width: 60mm; height: 15px; text-align: center; vertical-align: bottom;">
                <?php 
                  echo "OI:"."&nbsp;";

                  if (trim($r['sig_lejos_oi']) != '') {
                   echo $r['sig_lejos_oi']."&nbsp;";
                  } else {
                    echo "!&nbsp;";
                  }

                  echo $r['lejos_esfera_oi']."&nbsp;";

                  if (trim($r['signo_cilindro_oi']) != '') {
                   echo $r['signo_cilindro_oi']."&nbsp;";
                  } else {
                    echo "!&nbsp;";
                  }

                  echo $r['cilindro_oi']."&nbsp;";
                  echo "&nbsp;x&nbsp;";
                  echo $r['grado_oi']."&nbsp;";

                  if($r['cerc_oi'] !== '0.00') {
                    echo "&nbsp;&nbsp;ADD OI:&nbsp;".$r['cerc_oi'];
                  }

                  // if($r['sig_lejos_oi']) {
                  //   echo $r['sig_lejos_oi'];
                  // }

                  // if($r['lejos_esfera_oi']) {
                  //   echo $r['lejos_esfera_oi'];
                  // }

                  // if($r['signo_cilindro_oi']) {
                  //   echo $r['signo_cilindro_oi'];
                  // }

                  // if($r['cilindro_oi']) {
                  //   echo $r['cilindro_oi'];
                  // }

                  // if($r['grado_oi']) {
                  //   echo $r['grado_oi'];
                  // }
                ?>
              </td>

              <?php

              // } else {

              //   echo "<td style=\"width: 50mm; height: 15px; text-align: center; vertical-align: middle;\"></td>";

              // }

              ?>
          </tr>
          <tr style="border:none !important;">
            <td style="width: 10mm; height: 15px; text-align: center; vertical-align: middle;"></td>
            <td style="width: 40mm; height: 0px; text-align: center; vertical-align: top;border-bottom: 1px dashed #ccc"></td>
            <td style="width: 10mm; height: 0px; text-align: center; vertical-align: top;border-bottom: 1px dashed #ccc"></td>
            <td style="width: 20mm; height: 0px; text-align: center; vertical-align: top;border-bottom: 1px dashed #ccc"></td>
            <td style="width: 15mm; height: 0px; text-align: center; vertical-align: top;border-bottom: 1px dashed #ccc"></td>
            <td style="width: 20mm; height: 0px; text-align: center; vertical-align: top;border-bottom: 1px dashed #ccc"></td>
            <td style="width: 15mm; height: 0px; text-align: center; vertical-align: top;border-bottom: 1px dashed #ccc"></td>
            <td style="width: 25mm; height: 0px; text-align: center; vertical-align: top;border-bottom: 1px dashed #ccc"></td>
            <td style="width: 60mm; height: 0px; text-align: center; vertical-align: top;border-bottom: 1px dashed #ccc">
              <?php 

                if (trim($r['bifocal_kriptok']) != '') {
                 echo "BK&nbsp;";
                }

                if (trim($r['bifocal_flat_top']) != '') {
                 echo "BFT&nbsp;";
                }

                if (trim($r['bifocal_ultex']) != '') {
                 echo "BU&nbsp;";
                } 

                if (trim($r['bifocal_ejecutivo']) != '') {
                 echo "BE&nbsp;";
                }

                if (trim($r['multifocal']) != '') {
                 echo "M&nbsp;";
                } 
              ?>
            </td>
          </tr>
        <?php endforeach;?>
      </tbody>
    </table>
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
        $html2pdf = new HTML2PDF('L', array($width_in_mm,$height_in_mm), 'en', true, 'UTF-8', array(0, 0, 0, 0));
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));

        $hora   = $obj->fechaHora('America/Caracas','H-i-s');
        $obj->fechaHora('America/Caracas','d-m-Y');
        $nombre = $dia_desde.'-'.$dia_hasta;

        if ($pdf == 1) {
          $html2pdf->output("../reportes/pacientes_optica/pacientes_optica$nombre.pdf", "f");
        } else if ($pdf == 2) {
          $html2pdf->Output("../reportes/pacientes_optica/pacientes_optica$nombre.pdf");
        } else if ($pdf == 4) {
           $html2pdf->Output("pacientes_optica$nombre.pdf", "D");
        } else {  
          $html2pdf->Output("../reportes/pacientes_optica/pacientes_optica$nombre.pdf");
          $html2pdf->output("../reportes/pacientes_optica/pacientes_optica$nombre.pdf", "f");
        }
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
  }
?>