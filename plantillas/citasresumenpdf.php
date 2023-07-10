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

  if (isset($_REQUEST['fecha'])) {
    $fecha = $_REQUEST['fecha'];
  } else {
    throw new Exception('operación inválida: FECHA necesario para imprimir resumen'); 
  }

  if (isset($_REQUEST['dia'])) {
    $diaCita = $_REQUEST['dia'];
  } else {
    throw new Exception('operación inválida: DIA necesario para imprimir resumen'); 
  }

  $citas = $obj->i_pdo("
    select a.id_cita, a.id_historia, a.cedula, a.nombres, a.telefonos, a.id_medico, b.nomb_medi, a.direccion, a.cedula, a.tipo, a.fecha, a.status, a.motivo, case when a.id_historia = 0 then '-' else a.id_historia::character varying(100) end as id_historia_crud, a.estudio
        FROM (
            SELECT 
                a.id_cita,
                a.id_historia,
                coalesce(NULLIF(a.cedula::character varying(20), ''), b.nume_cedu) AS cedula,
                coalesce(NULLIF(a.nombres::character varying(40), ''), b.apel_nomb) AS nombres,
                coalesce(NULLIF(a.id_medico, 0), b.id_medico) AS id_medico,
                coalesce(NULLIF(a.direccion::character varying(20), ''), b.dire_paci) AS direccion,
                coalesce(NULLIF(a.telefonos::jsonb, '[]'::jsonb), b.telefonos::jsonb) AS telefonos,
                a.tipo,
                a.fecha,
                a.status,
                ''::character varying(1) as marcador,
                a.motivo,
                a.estudio
            from historias.citas As a
            left join historias.entradas as b using(id_historia)
           ) as a
        inner join historias.medicos as b USING (id_medico)
      where a.fecha = ? and a.status = 'C' order by a.fecha, a.id_cita
  ", [$fecha], true)->fetchAll(PDO::FETCH_ASSOC);

  // echo "<pre>";
  // print_r($kit_orden);
  // echo "</pre>";

  //$telefonos = json_decode($datos['telefonos'], true);

  $timestamp = strtotime($fecha);
  $fecha_arreglada = new DateTime($fecha);
  $fecha = date("d-m-Y", strtotime($fecha));

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
    width: 205mm;
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

  table tbody tr td, table thead tr th {
    width: fit-content;
    text-align: left;
    display: flex;
    padding: 5px 3px;
    border: 1px solid #ccc
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

<page style="width:100%" backtop="10mm" backbottom="5mm" backleft="6mm" backright="5mm">
  <div class="contenedor">
  
    <div style="position: absolute;  top: 5mm; left: 0mm">
       <img src="../imagenes/logo_reportes.jpg" style="width: 30mm; height: 23mm;">
    </div>

    <div style="font-size: 16px; margin-bottom: 5px; text-align: center; top: 5px; position: relative;">LISTADO DE CITAS DE PACIENTES</div>

    <div id="subcabecera" class="centrar" style="font-size: 10px; text-align: center; width: 150mm; left: 33.5mm; position: relative;">
       <?php echo $_SESSION['informacion_subcabecera_reportes'];?>
    </div>

    <div style="text-align: right; width: 205mm; position: relative; top: 20px">
       <b>DÍA: <?php echo $fecha?> &nbsp;&nbsp;&nbsp; FECHA: <?php echo strtoupper($diaCita);?></b>
    </div>

    <div class="separador" style="margin-bottom: 10px"></div>

    <table style="width: 200mm; position: relative; top: -10px">
      <thead>
        <tr style="border: 1px solid #262626">
          <th style="text-align:center; border-bottom: 1px dotted #262626;">N°</th>
          <th style="text-align:center; border-bottom: 1px dotted #262626;"></th>
          <th style="text-align:center; border-bottom: 1px dotted #262626;">N° HIST</th>
          <th style="text-align:center; border-bottom: 1px dotted #262626;">APELLIDOS Y NOMBRE</th>
          <th style="text-align:center; border-bottom: 1px dotted #262626;">C.I</th>
          <th style="text-align:center; border-bottom: 1px dotted #262626;">MÉDICO</th>
          <th style="text-align:center; border-bottom: 1px dotted #262626;">TELÉFONOS</th>
        </tr>
      </thead>
      <tbody>
        <?php 


        foreach ($citas as $k => $r) :
          
        ?>
        <tr>
          <td style="width: 10mm; text-align: center"><?php echo ($k + 1)?></td>
          <td style="width: 5mm; text-align: center"><?php 
            if ($r['estudio'] == 'X') {
              echo 'E';
            } else {
              echo '';
            }
          ?></td>
          <td style="width: 20mm; text-align: center"><?php echo $r['id_historia_crud']?></td>
          <td style="width: 51mm; text-align: center"><?php echo $r['nombres']?></td>
          <td style="width: 20mm; text-align: center"><?php echo $r['cedula']?></td>
          <td style="width: 45mm; text-align: center"><?php echo $r['nomb_medi']?></td>
          <td style="width: 20mm; text-align: center">
            <?php 
              $telefonos = json_decode($r['telefonos'], true);
              $concat = "";

              if (gettype($telefonos) == 'array') {

                if(count($telefonos) > 0) {

                  foreach ($telefonos as $t) {
                    $concat .= $t.' - ';
                  }
                  //$concat = substr($concat, 0,-2);
                  echo $concat;

                } 

              }


            ?>
          </td>
        </tr>
        <?php 
        endforeach;
        ?>
      </tbody>
    </table>

    <div class="separador" style="margin-top: 10px"></div>

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
        $width = 216;
        $height = 280;
        $html2pdf = new HTML2PDF('P', array($width,$height, 0, 0), 'en', true, 'UTF-8', array(0, 0, 0, 0));
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));

        $hora   = $obj->fechaHora('America/Caracas','H-i-s');
        $obj->fechaHora('America/Caracas','d-m-Y');
        $nombre = $dia.'-'.$hora;

        if ($pdf == 1) {
          $html2pdf->output("../reportes/citasresumen/citasresumen$nombre.pdf", "f");
        } else if ($pdf == 2) {
          $html2pdf->Output("../reportes/citasresumen/citasresumen$nombre.pdf");
        } else {  
          $html2pdf->Output("../reportes/citasresumen/citasresumen$nombre.pdf");
          $html2pdf->output("../reportes/citasresumen/citasresumen$nombre.pdf", "f");
        }
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
  }
?>