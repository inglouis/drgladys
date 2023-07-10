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

  if (isset($_REQUEST['datos'])) {
    $datos = json_decode($_REQUEST['datos'], true);
  }

  if (isset($_REQUEST['pdf'])) {
    $pdf = (int)$_REQUEST['pdf'];
  } else {
    $pdf = 1;
  }

  if (isset($_REQUEST['id'])) {
    $id = (int)$_REQUEST['id'];

	$datos = json_decode(

		$obj->seleccionar("
			select a.id_cita, a.id_historia, a.cedula, a.nombres, a.direccion, a.motivo, a.telefonos, a.id_medico, a.fecha, a.tipo
      FROM (
          SELECT 
          	a.id_cita,
              coalesce(NULLIF(a.id_historia, null), 0) AS id_historia,
              coalesce(NULLIF(a.cedula::character varying(20), ''), b.nume_cedu) AS cedula,
              coalesce(NULLIF(a.nombres::character varying(40), ''), b.apel_nomb) AS nombres,
              coalesce(NULLIF(a.direccion::character varying(20), ''), b.dire_paci) AS direccion,
              a.motivo,
              coalesce(NULLIF(a.telefonos::jsonb, '[]'::jsonb), b.telefonos::jsonb) AS telefonos,
              coalesce(NULLIF(a.id_medico, 0), b.id_medico) AS id_medico,
              a.fecha,
              a.tipo
          from historias.citas As a
          left join historias.entradas as b using(id_historia)
         ) as a
      inner join historias.medicos as b USING (id_medico)
      where id_cita = ?
		", [$id])
		, true

	)[0];

	$datos = array(
		0 => $datos['id_historia'],
		1 => $datos['cedula'],
		2 => $datos['nombres'],
		3 => $datos['direccion'],
		4 => $datos['motivo'],
		5 => $datos['telefonos'],
		6 => $datos['id_medico'],
		7 => $datos['fecha'],
		8 => $datos['tipo']
	);
    
	// echo "<br><br><br><br><pre>";
	// print_r($datos);
	// echo "</pre>";

  } else {
    $id = 0;
  }

  //$datos[3] = date("d-m-Y", strtotime($datos[3]));
  //print_r($datos);

  if ($datos[0] == 0) {
  	$datos[0] = '-';
  }

  $datos[7] = date("d-m-Y", strtotime($datos[7]));

  $dia = $obj->fechaHora('America/Caracas','d-m-Y');

?>

<style>
      #separador {
        margin-top: 0px
      }

      #titulo1 {
        top:50px
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
</style>

<page style="width: 200mm" backtop="1mm" backbottom="5mm" backleft="5mm" backright="5mm">
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
    <div id="subcabecera" class="centrar" style="font-size: 10px;">
       <?php echo $_SESSION['informacion_subcabecera_reportes'];?>
    </div>

    <div style="position: absolute;  top: 5mm; left: 0mm">
       <img src="../imagenes/logo_reportes.jpg" style="width: 30mm; height: 23mm;">
    </div>

    <div class="separador" id="separador"></div>
    <table style="margin-bottom: 5mm; border:none">
      <tbody>
        <tr>
          <td style="width: 170mm; text-align: center;"><div style="width:fit-content; border-bottom: 2px dashed #ccc; font-size: 16px">CITA MÉDICA</div></td>
        </tr>
      </tbody>
    </table>  

    <table style="border:none;padding-left:30px">
      <tbody>
        <tr>
          <td style="width: 170mm; text-align: left">PACIENTE: <div class="unbold" style="bottom: 5px"><?php echo strtoupper($datos[2])." [N° Historia: ".$datos[0]."]"?></div></td>
        </tr> 
      </tbody>    
    </table>

    <table style="border:none;padding-left:30px">
      <tbody>
        <tr>
          <td style="width: 170mm; text-align: left">PARA: <div class="unbold"><?php echo strtoupper($datos[4])?></div></td>
        </tr> 
      </tbody>    
    </table>

    <table style="border:none;padding-left:30px">
      <tbody>
        <tr>
          <td style="width: 170mm; text-align: left">PARA EL DÍA (DD/MM/AAAA): <div class="unbold"><?php echo $datos[7]?></div></td>
        </tr> 
      </tbody>    
    </table>

   <table style="border:none;position: absolute; top: 90mm; left: 0mm;padding-left:30px">
      <tbody>
        <tr>
          <td>San Cristóbal. <?php echo $dia?></td>
        </tr> 
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
        $html2pdf = new HTML2PDF('P', array($width_in_mm,$height_in_mm), 'en', true, 'UTF-8', array(0, 0, 0, 0));
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));

        $id = 0;
        $hora   = $obj->fechaHora('America/Caracas','H-i-s');
        $obj->fechaHora('America/Caracas','d-m-Y');
        $nombre = $datos[0].'-'.$dia.'-'.$hora;

        if ($pdf == 1) {
          $html2pdf->output("../reportes/citas/citas$nombre.pdf", "f");
        } else if ($pdf == 2) {
          $html2pdf->Output("../reportes/citas/citas$nombre.pdf");
        } else {  
          $html2pdf->Output("../reportes/citas/citas$nombre.pdf");
          $html2pdf->output("../reportes/citas/citas$nombre.pdf", "f");
        }
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
  }
?>