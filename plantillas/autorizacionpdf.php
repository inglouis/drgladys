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
    throw new Exception('operación inválida: ID necesario para informe autorización'); 
  }

  if (isset($_REQUEST['historia'])) {
    $id_historia = (int)$_REQUEST['historia'];
  } else {
    throw new Exception('operación inválida: HISTORIA necesario para informe autorización'); 
  }

  if (isset($_REQUEST['departamento'])) {
    $departamento = (int)$_REQUEST['departamento'];
  } else {
    throw new Exception('operación inválida: DEPARTAMENTO necesario para informe autorización'); 
  }

  if (isset($_REQUEST['fecha'])) {
    $fecha = $_REQUEST['fecha'];
  } else {
    throw new Exception('operación inválida: FECHA necesario para informe autorización'); 
  }

  if (isset($_REQUEST['paciente'])) {
    $paciente = $_REQUEST['paciente'];
  } else {
    throw new Exception('operación inválida: PACIENTE necesario para informe autorización'); 
  }

  if (isset($_REQUEST['cedula'])) {
    $cedula = $_REQUEST['cedula'];
  } else {
    throw new Exception('operación inválida: CEDULA necesario para informe autorización'); 
  }

  if (isset($_REQUEST['fecha_completa'])) {
    $fecha_completa = $_REQUEST['fecha_completa'];
  } else {
    throw new Exception('operación inválida: FECHA COMPLETA necesario para informe autorización'); 
  }

  $datos = json_decode($obj->seleccionar("select 
      a.*,
      b.nomb_medi,
      b.rif,
      b.msas,
      TO_CHAR(a.fech_naci :: DATE, 'dd-mm-yyyy') as fecha_arreglada
    from historias.entradas as a
    inner join historias.medicos as b using(id_medico)
    where a.id_historia = ?", [$id_historia]), true)[0];

  if (isset($_REQUEST['pdf'])) {
    $pdf = (int)$_REQUEST['pdf'];
  } else {
    $pdf = 2;
  }

  setlocale(LC_ALL,"es_ES@euro","es_ES", "esp");

  $timestamp = strtotime($fecha);
  $fecha_arreglada = new DateTime($fecha);
  $fecha = date("d-m-Y", strtotime($fecha));

  $hora = $obj->fechaHora('America/Caracas','H:i:s');

  if($departamento == 1) {
    $telefonos = json_decode($datos['telefonos'], true);
    $edad      = $obj->calcularEdad($datos['fech_naci']);
  }

  $cirugia = json_decode($obj->seleccionar("select nombre from historias.cirugias where id_cirugia = ?", [$id]), true)[0]['nombre'];

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
        <h4 id="titulo1" style="">AUTORIZACIÓN DE INTERVENCIÓN QUIRÚRGICA</h4>
      </div> 
    </div> 

    <div class="separador"></div>

    <table style="margin-top: 10px; margin-left:20px; border:none">
      <tbody>
        <tr>
          <td></td>
        </tr>
      </tbody>
    </table>

    <div style="text-align: justify;">
      Quien suscribe <b><?php echo strtoupper($paciente)?></b>, de nacionalidad VENEZOLANA, mayor de edad, con cédula de identidad <b><?php echo strtoupper($cedula)?></b>, en mi condición de paciente o representante legal del paciente <b><?php echo strtoupper($datos['apel_nomb'])?></b> por medio del presente documento declaro: que libre y voluntariamente he elegido como médico tratante al profesional:
    </div>

    <table style="margin-top: 10px; margin-left:20px; border:none">
      <tbody>
        <tr>
          <td></td>
        </tr>
      </tbody>
    </table>

    <div style="width: 200mm; text-align:center"><b><?php echo $datos['nomb_medi']?></b></div>

    <table style="margin-top: 10px; border:none; margin-left:20px">
      <tbody>
        <tr>
          <td></td>
        </tr>
      </tbody>
    </table>


    <div style="text-align: justify;">
      Quien es de nacionalidad VENEZOLANA, mayor de edad, titular de la C.I.: <b><?php echo strtoupper($datos['rif'])?></b>, inscrito en el Ministerio de Salud y Desarrollo Social bajo el N°.<b><?php echo strtoupper($datos['msas'])?></b>, para que dicho profesional me practique la siguiente intervección quirúrgica:
    </div>

    <table style="margin-top: 10px; margin-left:20px; border:none">
      <tbody>
        <tr>
          <td></td>
        </tr>
      </tbody>
    </table>


    <div>
      <div>
        <h4><?php echo $cirugia?></h4>
      </div> 
    </div> 

    <table style="margin-top: 10px; margin-left:20px; border:none">
      <tbody>
        <tr>
          <td></td>
        </tr>
      </tbody>
    </table>

    <div style="text-align: justify; font-size: 17px">
      De igual forma hago constar, que estoy plenamente consciente de los riesgos a los cuales me encuentro expuesto(a) al ser sometido(a) a dicha intervención los cuales entre otros son: reacciones a la anestesia, rechazo interno a materiales de cirugía, reacciones alérgicas, inflamaciones, infecciones por virus, bacterias y hongos los cuales me han sido explicados por el médico tratante aceptando y autorizando al mismo para que efectúe la intervención, estando consciente que el médico tratante adquiere una obligación de medios no de resultados, es decir, que cumplir su labor con profesionalismo y ética, poniendo todos sus conocimientos y empleando los equipos y materiales idóneos a tal fin cumpliendo las normativas legales que regulan  el  caso.
          Entendemos que el médico es un profesional altamente calificado, pero a pesar de tomar todas las precauciones del caso, se pueden presentar complicaciones durante y con posterioridad a la  intervención quirúrgica, las cuales no se deben a impericia, imprudencia o negligencia del médico y son riesgos normales de toda cirugía. Me comprometo a cumplir con las normas y medidas que me indique el médico tratante durante el post operatorio en mi residencia. Así mismo declaro que estoy plenamente consciente que el médico es un profesional que esta capacitado para realizar su trabajo en  las  mejores  condiciones de seguridad posible  para  el  paciente  y  en tal virtud, asumo totalmente las consecuencias y los resultados  de la cirugía. Autorizo  al  médico  tratante arriba  identificado  a  practicar  la  cirugía  en  la <b>CLINICA OFTALMOLOGICA
          CASTILLO INCIARTE Y ASOCIADOS C.A.</b> En caso de incumplimiento  de  las  normas durante  el  período  post  operatorio  expresamente  libero  tanto al médico tratante como <b>CLINICA OFTALMOLOGICA CASTILLO INCIARTE Y ASOCIADOS C.A.</b> de toda clase de responsabilidad que pudiera tener en relación a la aparición de patologías como consecuencia de  las omisiones al tratamiento pre y post operatorios o actos imprudentes por mi cometido. Así lo digo y firmo.
    </div>

    <div style="font-size:16px; text-align:left; width: 200mm; margin-top:5mm">
      En la ciudad de San Cristóbal: <div style="width: fit-content; padding-left:2mm"><b><?php echo $fecha_completa?></b></div>
    </div>

    <table style="border: none; margin-top:10mm; width:200mm;">
      <thead>
        <tr>
          <th>EL PACIENTE</th>
          <th>HUELLA DIGITAL</th>
        </tr>
      </thead>
      <tbody style="height: 100px">
        <tr style="">
          <td style="width: 90mm;">
            <div></div>
            <div></div>
            <div style="">____________________________________________________    </div>
          </td>
          <td >
            <div></div>
            <div></div>
             <div>_______________________________________________________________</div>
          </td>
        </tr>
      </tbody>
    </table> 
    <table style="margin-top: 10px; margin-left:20px; border:none">
      <tbody>
        <tr>
          <td></td>
        </tr>
      </tbody>
    </table>

    <table style="margin-top: 5mm; border:none; width:200mm;">
      <thead>
        <tr>
          <th>EL RESPONSABLE</th>
          <th>HUELLA DIGITAL</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td style="width: 90mm">
            <div></div>
            <div></div>
            <div>____________________________________________________   </div>
          </td>
          <td>
            <div></div>
            <div></div>
             <div>_______________________________________________________________</div>
          </td>
        </tr>
      </tbody>
    </table> 

  </div>  
</page>

<?php if($departamento == 1) {?>
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
          <td style="width: fit-content">FECHA DE NACIMIENTO: <div style="padding-left: 2px; width: fit-content"><?php echo $datos['fecha_arreglada']?></div></td>
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
          <td style="font-size: 16px;">FECHA: <div style="padding-left: 2px"><?php echo $fecha?></div></td>
        </tr>
      </tbody>
    </table>
  </div>  
</page>
<?php }?> 

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
        $nombre = $id.'-'.$fecha.'-'.$hora;

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