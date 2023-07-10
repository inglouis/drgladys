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
    $id = 2;
  }

  $datos = json_decode($obj->seleccionar("select * from historias.entradas where id_historia = ?", [$id]), true)[0];

  if (isset($_REQUEST['pdf'])) {
    $pdf = (int)$_REQUEST['pdf'];
  } else {
    $pdf = 2;
  }

  $dia  = $obj->fechaHora('America/Caracas','d-m-Y');
  $hora = $obj->fechaHora('America/Caracas','H:i:s');

  setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
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
    <div id="subcabecera" class="centrar">
      A.19 de Abril Edf. Clínica de Ojos P.B. La Bermeja - San Cristóbal Edo.Táchira - TF: 3560133
    </div>

    <div class="separador"></div>

    <div></div>

    <div id="subcabecera" class="centrar" style="font-size: 16px;"><b>
      LIMIPEZA Y CUIDADO PARA LENTES DE CONTACTO BLANDOS</b>
    </div>
    <div class="separador"></div>
 
    <div></div>

    <div style="text-align: justify; font-size: 12px;">
      <div>
       * LAVARSE BIEN LAS MANOS CON AGUA Y JABÓN ANTES DE MANIPULAR LOS LENTES DE CONTACTO.
      </div>
      
      <div></div>
   
      <div>
        * FROTAR SUAVEMENTE Y ENJUAGAR CON ABUNDANTE RENU, OPTI FREE, SOLO CARE, COMPLETE O RENUPLUS. GUARDAR EN EL ESTUCHE CON RENU, OPTI FREE, SOLO CARE, COMPLETE O RENUPLUS.
      </div>
    
      <div></div>  
    
      <div style="font-size: 16px;"><b>
        * CADA 8 DÍAS HACER LIMPIEZA PROFUNDA CON PASTILLA</b>
      </div>
    
      <div></div>
    
      <div>
        * REMOVEDORA DE PROTEINAS: FIZZI CLEAN, RENU O POLY ZYM. DISOLVER UNA PASTILLA EN 10cc DE RENU, OPTI FREE, SOLO CARE, COMPLETE O RENUPLUS Y DEJARLOS DURANTE LA NOCHE. LUEGO ENJUAGARLOS Y DEJARLOS EN ESTUCHE DURANTE 4 HORAS CON RENU, OPTI FREE, SOLO CARE, COMPLETE O RENUPLUS.
      </div>
    
      <div></div> 
    
      <div>
        * CUMPLIR EL HORARIO Y ASISTIR AL CONSULTORIO CON LOS LENTES PUESTOS
      </div>
    
      <div></div> 
    
      <div style="font-size: 16px;"><b>
        * JAMÁS DUERMA CON LOS LENTES PUESTOS</b>
      </div>

      <div></div>

      <div>
        * PUEDE  USAR  LÁGRIMAS  ARTIFICIALES, LAGRICEL, OPTIFRESH. SI USA RENUPLUS LA PASTILLA REMOVEDORA SE UTILIZARA UNA VEZ AL MES
      </div>

      <div></div>

      <table style="margin-top: 10px; margin-left:20px; border:none">
        <tbody>
          <tr>
            <td></td>
          </tr>
        </tbody>
      </table>
    </div>

    <table style="margin-top: 15px; margin-left:20px; font-size=12px";>
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
          $html2pdf->Output("../reportes/formulas/limpieza_lc_blandos$nombre.pdf", "f");
        } else if ($pdf == 2) {
          $html2pdf->Output("../reportes/formulas/limpieza_lc_blandos$nombre.pdf");
        } else if ($pdf == 3){      
          $html2pdf->Output("../reportes/formulas/limpieza_lc_blandos$nombre.pdf");
          $html2pdf->output("../reportes/formulas/limpieza_lc_blandos$nombre.pdf", "f");
        }
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
  }
?>