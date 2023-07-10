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
    $id = 1;
  }

  $datos = json_decode($obj->seleccionar("select 
      a.id_historia,
      a.apel_nomb,
      a.nume_cedu,
      TO_CHAR(a.fech_naci :: DATE, 'dd-mm-yyyy') as fech_naci,
      a.dire_paci,
      b.nomb_medi,
      a.telefonos,
      a.fech_naci
    from historias.entradas as a
    inner join historias.medicos as b using(id_medico)
    where a.id_historia = ?", [$id]), true)[0];

  if (isset($_REQUEST['pdf'])) {
    $pdf = (int)$_REQUEST['pdf'];
  } else {
    $pdf = 2;
  }

  $dia  = $obj->fechaHora('America/Caracas','d-m-Y');
  $hora = $obj->fechaHora('America/Caracas','H:i:s');
  $telefonos = json_decode($datos['telefonos'], true);
  $edad      = $obj->calcularEdad($datos['fech_naci']);
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
        margin-left: 0px;
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
        <h4 id="titulo1" style="">CLÍNICA OFTALMOLÓGICA CASTILLO INCIARTE</h4>
        <h4 id="titulo2">Y ASOCIADOS C.A</h4>
      </div> 
      <h3 id="titulo1" style="margin-top: 35px">DEPARTAMENTO DE ADMISIÓN</h3>
    </div> 

    <div id="cabecera" style="height: 70px">
      <div style="position:relative;">
        <h4 id="titulo1" style="">DATOS DEL PACIENTE</h4>
      </div> 
    </div> 
    
    <div class="separador"></div>

    <table style="margin-top: 10px; margin-left:10px; border: none">
      <tbody>
        <tr>
          <td style="width: fit-content">NOMBRE DEL PACIENTE: <div style="padding-left: 2px; width: fit-content"><?php echo $datos['apel_nomb']?></div></td>
          <td style="padding-left: 10px; text-align: left">N° DE HISTORIA: <b><?php echo $datos['id_historia']?></b></td>
        </tr>
      </tbody>
    </table>

    <table style="margin-top: 10px; margin-left:10px; border: none">
      <tbody>
        <tr>
          <td style="width: fit-content">CÉDULA DE IDENTIDAD O RIF: <div style="padding-left: 2px; width: fit-content"><?php echo $datos['nume_cedu']?></div></td>
          <td style="padding-left: 10px">
            <img src="../imagenes/phone.jpg" style="width: 11px; height: 10px">
            : <div class="small">
            <?php 
              $concat = "";
              foreach ($telefonos as $r) {
                $concat .= $r.', ';
              }
              $concat = substr($concat, 0,-2);
              echo $concat;
            ?></div>
          </td>
        </tr>
      </tbody>
    </table>

    <table style="margin-top: 10px; margin-left:10px; border: none">
      <tbody>
        <tr>
          <td style="width: fit-content">FECHA DE NACIMIENTO: <div style="padding-left: 2px; width: fit-content"><?php echo $datos['fech_naci']?></div></td>
          <td style="padding-left: 10px; text-align: left">EDAD: <b><?php echo $edad?></b></td>
          
        </tr>
      </tbody>
    </table>

    <table style="margin-top: 10px; margin-left:10px; border: none">
      <tbody>
        <tr>
          <td>DIRECCIÓN: <div style="padding-left: 2px"><?php echo $datos['dire_paci']?></div></td>
        </tr>
      </tbody>
    </table>

    <table style="margin-top: 10px; margin-left:10px; border: none">
      <tbody>
        <tr>
          <td>MÉDICO TRATANTE: <div style="padding-left: 2px"><?php echo $datos['nomb_medi']?></div></td>
        </tr>
      </tbody>
    </table>

    <table style="margin-top: 10px; margin-left:10px">
      <tbody>
        <tr>
          <td></td>
        </tr>
      </tbody>
    </table>


    <div class="separador"></div>

    <div style="margin-top:10mm">
      <div style="position:relative;">
        <h4>DATOS PERSONA RESPONSABLE DEL PAGO</h4>
      </div> 
    </div> 

    <table style="margin-top: 10px; margin-left:10px; border: none">
      <tbody>
        <tr>
          <td>APELLIDOS Y NOMBRES:________________________________________________________________________________________________</td>
        </tr>
      </tbody>
    </table>

    <table style="margin-top: 10px; margin-left:10px; border: none">
      <tbody>
        <tr>
          <td>CÉDULA DE IDENTIDAD O RIF:____________________________________________________________________________________________</td>
        </tr>
      </tbody>
    </table>

    <table style="margin-top: 10px; margin-left:10px; border: none">
      <tbody>
        <tr>
          <td>DIRECCIÓN:____________________________________________________________________________________________________________</td>
        </tr>
      </tbody>
    </table>

    <table style="margin-top: 10px; margin-left:10px; border: none">
      <tbody>
        <tr>
          <td>NÚMEROS DE TELÉFONOS:_______________________________________________________________________________________________</td>
        </tr>
      </tbody>
    </table>

    <table style="margin-top: 10px; margin-left:10px; border: none">
      <tbody>
        <tr>
          <td></td>
        </tr>
      </tbody>
    </table>

    <div class="separador"></div>

    <div style="margin-top: 10mm">
      <div style="position:relative;">
        <h4 >OTROS DATOS</h4>
      </div> 
    </div> 


    <table style="margin-top: 10px; margin-left:10px; border:none">
      <tbody>
        <tr>
          <td>REEMBOLSO POR SEGURO: SI______      NO______</td>
        </tr>
      </tbody>
    </table>

    <table style="margin-top: 10px; margin-left:10px; border:none">
      <tbody>
        <tr>
          <td></td>
        </tr>
      </tbody>
    </table>

    <table style="margin-top: 10px; margin-left:10px; border:none">
      <tbody>
        <tr>
          <td>NOMBRE DE LA ASEGURADORA:_________________________________________________________________________________________</td>
        </tr>
      </tbody>
    </table>

    <table style="margin-top: 10px; margin-left:10px; border:none">
      <tbody>
        <tr>
          <td></td>
        </tr>
      </tbody>
    </table>

    <table  style="width:200mm; margin-top: 10px; margin-left:10px; border:none">
      <thead>
        <tr>
          <th style="width: 85mm">FIRMA DEL PACIENTE</th>
          <th style="width: 70mm">FIRMA PERSONA RESPONSABLE</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td style="width: 100%; text-align: left;">
            <div>_______________________________________________________</div>
          </td>
          <td style="width: 100%; text-align: left;">
             <div>_______________________________________________________________</div>
          </td>
        </tr>
      </tbody>
    </table>


    <table style="margin-top: 10px; margin-left:10px; border:none">
      <tbody>
        <tr>
          <td style="font-size: 16px;">FECHA: <div style="padding-left: 2px"><?php echo $dia?></div></td>
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
          $html2pdf->Output("../reportes/admisiones/admision$nombre.pdf", "f");
        } else if ($pdf == 2) {
          $html2pdf->Output("../reportes/admisiones/admision$nombre.pdf");
        } else if ($pdf == 3){      
          $html2pdf->Output("../reportes/admisiones/admision$nombre.pdf");
          $html2pdf->output("../reportes/admisiones/admision$nombre.pdf", "f");
        }
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
  }
?>