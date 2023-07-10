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
    throw new Exception('operación inválida: ID necesario para informe especial'); 
  }

  if (isset($_REQUEST['informe'])) {
    $id_informe = (int)$_REQUEST['informe'];
  } else {
    throw new Exception('operación inválida: INFORME necesario para informe especial'); 
  }

  if (isset($_REQUEST['cantidad'])) {
    $cantidadPaginas = (int)$_REQUEST['cantidad'];
  } else {
    throw new Exception('operación inválida: CANTIDAD necesario para informe especial'); 
  }

  if (isset($_REQUEST['pdf'])) {
    $pdf = (int)$_REQUEST['pdf'];
  } else {
    $pdf = 2;
  }

  if (isset($_REQUEST['modo'])) {
    $modo = $_REQUEST['modo'];
  } else {
    throw new Exception('operación inválida: MODO necesario para informe especial'); 
  }

  $datosInforme = '';

  if ($modo == 'temporal') {
    $datosInforme = json_decode($obj->seleccionar("select * from historias.informes_especiales_temp where id_informe = ? limit 1", [$id_informe]), true)[0];
    $obj->e_pdo("delete from historias.informes_especiales_temp where id_informe = $id_informe");
  } else {
    $datosInforme = json_decode($obj->seleccionar("select * from historias.informes_especiales where id_informe = ?", [$id_informe]), true)[0];
  }

  $datos = json_decode($obj->seleccionar("select * from historias.entradas where id_historia = ?", [$id]), true)[0];

  $dia  = $obj->fechaHora('America/Caracas','d-m-Y');
  $hora = $obj->fechaHora('America/Caracas','H:i:s');
  $edad = $obj->calcularEdad($datos['fech_naci']);

  $reemplazos = [$datos['id_historia'], $datos['nume_cedu'], $datos['apel_nomb'], "<b>", "</b>", "<u>", "</u>", "<i>", "</i>", "<br>", "<br><div style='position:relative; top: -5px'></div>", "<div style='width:140mm; text-align:center;'>", "</div>", $edad, $dia, "&nbsp;"];
  $reemplazar = ["[H]", "[C]", "[N]", "[-B]", "[B-]", "[-U]", "[U-]", "[-I]", "[I-]", "[BR]", "[BR2]", "[-CE]", "[CE-]", "[E]", "[F]", "[-]"];

  $titulo = str_replace($reemplazar, $reemplazos, $datosInforme['titulo']);
  $contenido = str_replace($reemplazar, $reemplazos, $datosInforme['contenido']);

  function espaciosBlancos($contenido) {

    $espacios_start = strpos($contenido ,"[ ");
    $espacios_end = strpos($contenido ," ]");

    if ($espacios_start && $espacios_end) {

      $blancos = '';
      $espacios = substr($contenido, $espacios_start, ($espacios_end - $espacios_start) + 2);

      for ($i=0; $i < strlen($espacios); $i++) { 
        $blancos .= '&nbsp;';
      };

      $contenidoLoop = str_replace($espacios, $blancos, $contenido);

      return espaciosBlancos($contenidoLoop);

    } else {
      //echo $contenido;
      return $contenido;

    }
  
  };


//echo $contenido;

$contenido = espaciosBlancos($contenido);
$titulo = espaciosBlancos($titulo);
//echo 'paso:'.$contenido;



  setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
?>

<style>
      #romper {
        white-space:pre-wrap;
      }

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
        width: 200mm;
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
      <?php if ($datosInforme['informacion'] == 'A') {?>
        .fecha {
          position: absolute; 
          bottom: 5px; 
          right: 30px; 
          font-size: 15px;
        }
      <?php } else {?>
        .fecha {
          position: absolute; 
          bottom: -20px; 
          right: 30px; 
          font-size: 15px;
        }
      <?php }?>  
</style>

<page style="width:100%" backtop="0mm" backbottom="5mm" backleft="6mm" backright="5mm">
<?php for ($z=0; $z < $cantidadPaginas; $z++) :?>


  <?php 
    if($z != 0) {
      $separacion = '85px';
    } else {
      $separacion = '0px';
    }
  ?>

  <div class="contenedor" style="padding-top:35px">
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

    <div style="position: absolute;  top: 15mm; left: 0mm;">
       <img src="../imagenes/logo_reportes.jpg" style="width: 30mm; height: 23mm;">
    </div>

    <div class="separador"></div>
  
    <div></div>

    <div style="position:relative;">
      <h4 id="titulo1" style="text-decoration: underline;"><?php echo $titulo?></h4>
    </div> 
  

    <div></div>

    <div id="romper"style="margin-left: 25mm;width: 140mm; text-align: justify; min-height: 60mm; font-size: 13px">
      <?php echo $contenido?>
    </div> 

    <div></div>

    <div style="position: relative;">
      <?php if ($datosInforme['fecha'] == 'A') {?>
        <div class="fecha">
          Fecha: <?php echo $dia?>
        </div>
      <?php }?>

      <?php if ($datosInforme['informacion'] == 'A') {?>
        <table style="margin-top: 5px; margin-left:20px; font-size: 12px; position: absolute;">
          <tbody>
            <tr>
              <td>N° Historia: <div style="width:fit-content"><?php echo $datos['id_historia']?></div></td>
              <td>NOMBRE: <div style="width:fit-content"><?php echo $datos['apel_nomb']?></div></td>
              <td>N°.Cédula: <div style="width:fit-content"><?php echo $datos['nume_cedu']?></div></td>
            </tr>
          </tbody>
        </table>
      <?php }?>
    </div>


  </div>  
<?php endfor;?>
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
          $html2pdf->Output("../reportes/informes_especiales/informes_especiales$nombre.pdf", "f");
        } else if ($pdf == 2) {
          $html2pdf->Output("../reportes/informes_especiales/informes_especiales$nombre.pdf");
        } else if ($pdf == 3){      
          $html2pdf->Output("../reportes/informes_especiales/informes_especiales$nombre.pdf");
          $html2pdf->output("../reportes/informes_especiales/informes_especiales$nombre.pdf", "f");
        }
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
  }
?>