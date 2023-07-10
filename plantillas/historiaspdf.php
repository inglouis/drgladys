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

  if (isset($_REQUEST['id'])) {
    $id_historia = (int)$_REQUEST['id'];
  } else {
     throw new Exception('operación inválida: ID necesario para imprimir historia'); 
  }

  $datos = $obj->i_pdo(
      "select *, TO_CHAR(fech_naci :: DATE, 'dd-mm-yyyy') as fecha_arreglada
      from historias.entradas a
      inner join historias.medicos b using (id_medico)
      where id_historia = ?", 
      [$id_historia], 
      true
    )->fetch(PDO::FETCH_ASSOC); 

 // $datos = json_decode($obj->seleccionar("select *, TO_CHAR(fech_naci :: DATE, 'dd-mm-yyyy') as fecha_arreglada
 // from historias.entradas a
 // inner join historias.medicos b using (id_medico)
 // where id_historia = ?", [$id_historia]), true)[0];

  if (isset($_REQUEST['pdf'])) {
    $pdf = (int)$_REQUEST['pdf'];
  } else {
    $pdf = 1;
  }

  $ocupacion = $obj->i_pdo("select nombre from historias.ocupaciones where id_ocupacion = $datos[id_ocupacion]", [], true)->fetchColumn();
  $motivo    = $obj->i_pdo("select nombre from historias.motivos where id_motivo = $datos[id_motivo]", [], true)->fetchColumn();
  $referido  = $obj->i_pdo("select nombre from historias.referidos where id_referido = $datos[id_referido]", [], true)->fetchColumn();
  $edad      = $obj->calcularEdad($datos['fech_naci']);
  $dia       = $obj->fechaHora('America/Caracas','d-m-Y');
  $hora      = $obj->fechaHora('America/Caracas','H:i:s');

  $cirugias = json_decode($datos['cirugias'], true);
  foreach ($cirugias as &$r1) {
      $dato = ($obj->i_pdo("select nombre from historias.cirugias where id_cirugia = '$r1[id_cirugia]'",[],true))->fetchColumn();
      $r1['nombre'] = $dato;
      $r1 = ["nombre" => $r1['nombre']];
  }

  $telefonos = json_decode($datos['telefonos'], true);
  $correos = json_decode($datos['correos'], true);
  $otros = json_decode($datos['otros'], true);
  $random = bin2hex(random_bytes(4)).date('Y-m-d');
?>

<?php if ($pdf == 0) : ?>
  <style type="text/css">
      .contenedor {
        position: absolute;
        top: 0px;
        /*page-break-after: always;*/
        align-items: left;
        left: -4px;
        font-family: monospace;
        opacity: 0.7;
      }

      #cabecera {
        top: -30px !important;
        position: relative !important;
      }

      @media print{
        @page {
          size: 201mm 310mm;
          margin: 0mm 0mm 0mm 0mm;
        }

        html, body {
            height: 1%;
            width: 96%;   
        }
      }

      #cabecera h5 {
        font-weight: bold;
      }

      table {
        width: fit-content !important;
      }

      #separador {
        margin-top: 20px
      }

      #titulo1 {
        top: 35px !important;
      }

      #titulo2 {
        top: 60px !important;
      }

      #fecha {
        top: 65px !important;
      }

      #hora {
        top:80px !important; 
      }

      table tbody tr td {
        float: left;
      }
  </style>
<?php endif;?>

<style>
      #separador {
        margin-top: 0px
      }

      #titulo1 {
        top:30px
      }

      #titulo2 {
        top: 50px;
        font-size: 16px !important;
      }

      #fecha {
        top: 115px;
        font-weight: 100; 
        color: #5f5f5f;
      }

      #hora {
        top:115px;
        font-size: 14px;
        position: absolute;
        left: 140px;
        font-weight: 100; 
        color:#5f5f5f;
      }

      #edad {
        top: 113px;
        left: 255px;
        font-weight: bold;
        font-size: 16px;
        position: absolute;
        color: #5f5f5f;
      }

      #sexo {
        top:115px;
        font-size: 14px;
        left: 330px;
        position: absolute;
        font-weight: 100; 
        color:#5f5f5f;
      }

      h5, h3 {
        padding:0px; 
        margin: 0px;
        text-align: center;
      }

     .contenedor {
        width: 93%;
        display: flex;
        flex-direction: column;
        font-size: 18px;
      }
    
      .separador {
        width: 100%;
        height: 2px;
        border-top: 1px dashed #383838;
        border-bottom: 1px dashed #383838;
        margin: 2px 2px;
      }

      #cabecera h5, #cabecera h4 {
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
</style>

<page style="width:100%" backtop="0mm" backbottom="5mm" backleft="6mm" backright="4mm">

  <div class="contenedor">
    <div id="cabecera" style="height: 70px; position: relative">
      <h4 id="titulo1">CLÍNICA OFTALMOLÓGICA</h4>
      <h4 id="titulo2" style="font-size: 18px">DR. CASTILLO INCIARTE Y ASOCIADOS</h4>
      <h5 id="fecha" style="text-align: left; color:#262626">Fecha: <?php echo $dia?></h5>
      <div id="hora" style="text-align: left; color:#262626">Hora: <?php echo $hora?></div>
      <div id="edad" style="color:#262626">Edad: <?php echo $edad?></div>
      <!--<div id="sexo" style="color:#262626">Sexo: <?php echo $datos['sexo']?></div>    -->  
    </div>

    <div style="position: absolute;  top: 5mm; left: 0mm">
       <img src="../imagenes/logo_reportes.jpg" style="width: 30mm; height: 23mm;">
    </div>

    <div class="separador" id="separador" style="margin: 0px; padding: 0px;"></div>

    <div style="display: block; width: 150mm; height: fit-content; font-size: 12px; top: -2px">
      <?php 

        if ($datos['diabetico'] == 'X') {

          echo '<img src="../imagenes/triangulo.jpg"style="width: 15px; height: 15px;"> - ';

        }

        foreach ($otros as $r) {
          echo $r." - ";
        }  
      ?>
    </div>

    <div class="separador" id="separador"></div>

    <table>
      <tbody>
        <tr>
          <td style="position:relative">N° Historia: 
              <div style="font-size: 14px; top: 1px; width: fit-content; position: fixed">
                <?php echo $datos['id_historia']?>
              </div>
          </td>
          <td>Médico: <?php echo $datos['nomb_medi']?></td> 
        </tr>
      </tbody>
    </table>  

    <table>
      <tbody>
        <tr>
          <td>Nombre: <div style="width: fit-content; font-weight: bold"><?php echo $datos['apel_nomb']?></div></td>
        </tr> 
      </tbody>    
    </table>

    <table>
      <tbody>
        <tr>
          <td>Cédula: <?php echo $datos['nume_cedu']?></td>
          <td>Sexo: <?php echo $datos['sexo']?></td>
          <td>Ocupación: <div class="small"> <?php echo $ocupacion?></div></td>
          <td>Fech.Nac: <?php echo $datos['fecha_arreglada']?></td>
        </tr>
      </tbody>
    </table>  

   <table>
      <tbody>
        <tr>
          <td>
            <img src="../imagenes/address.jpg" style="width: 16px; height: 10px">
            : <div class="small"><?php echo $datos['dire_paci']?></div></td>
        </tr> 
      </tbody>    
    </table>

    <table>
      <tbody>
        <tr>
          <td>
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
          <td>
            <img src="../imagenes/envelope.jpg" style="width: 11px; height: 10px">
            : <div class="small">
            <?php 
              $concat = "";
              foreach ($correos as $r) {
                $concat .= $r.', ';
              }
              $concat = substr($concat, 0,-2);
              echo $concat;
            ?></div>
          </td>
        </tr> 
      </tbody>    
    </table>


    <table>
      <tbody>
        <tr>
          <td>Motivo Consulta: <?php echo $motivo?></td>
          <td>Referido por: <?php echo $referido?></td>
        </tr> 
      </tbody>    
    </table>

    <table>
      <tbody>
        <tr>
          <td>
            Antecedentes ==>
            <?php
              if($datos['diabetico'] == 'X') {echo "Diabetis: [ ".$datos['diabetico']." ] -";}; 
              if($datos['hipertenso'] == 'X') {echo "Hiper.Arterial: [ ".$datos['hipertenso']." ] -";};
              if($datos['glaucoma'] == 'X') {echo "Glaucoma: [ ".$datos['glaucoma']." ] -";};
              if($datos['estrabismo'] == 'X') {echo "Estrabísmo: [ ".$datos['estrabismo']." ] -";}; 
              if($datos['alergico'] == 'X') {echo "Alergía: [ ".$datos['alergico']." ]";};
            ?>    
          </td>
          <td>Lentes ==>
            <?php 
              if($datos['lent_cont'] == 'X') {echo "Contacto: [ ".$datos['lent_cont']." ] -";}; 
              if($datos['lent_mont'] == 'X') {echo "Montura: [ ".$datos['lent_mont']." ] -";}; 
              if($datos['lent_intr'] == 'X') {echo "Intraocular: [ ".$datos['lent_intr']." ]";}; 
            ?>
          </td>
        </tr> 
        <tr>
          <td>Cirugías: <?php 
            $concat = ' ';
            foreach ($cirugias as $r) {
              $concat .= $r['nombre'].' - ';
            }
            $concat = substr($concat, 0,-3);
            echo $concat;
          ?></td>
        </tr>   
      </tbody>
    </table>

    <table style="width: 216mm; border:none">
      <tbody>
        <tr>
          <td style="width: 47%; text-align: center">
            <div style="width: fit-content; border-bottom: 1px dashed #ccc; font-size:16px">OD:</div>
          </td>
          <td style="width: 47%; text-align: center">
            <div style="width: fit-content; border-bottom: 1px dashed #ccc; font-size:16px">OI:</div>
          </td>
        </tr>
      </tbody>
    </table>

    <div style="position: absolute; left: 99.8mm ;top: 115mm; height: 152mm; width: 1px; border: 1px dashed #383838"></div>

    <div style="width: 108mm; position: relative;">
      <img src="../imagenes/lagrimal derecho.jpg" style="width: 33mm; height: 22.5mm;">
      <img src="../imagenes/cristalino frente.jpg" style="width: 10mm; height: 10mm; position: absolute; top: 8mm; left: 41mm">
      <img src="../imagenes/cristalino derecho.jpg" style="width: 5mm; height: 13mm; position: absolute; top: 6mm; left: 60mm">
      <img src="../imagenes/ilustracion ojo lado derecho.jpg" style="width: 25mm; height: 25mm; position: absolute; top: 0mm; left: 72mm">
      <img src="../imagenes/fondo de ojo derecho.jpg" style="width: 14mm; height: 14mm; position: absolute; top: 29mm; left: 75mm">
    </div>

    <img src="../imagenes/lagrimal izquierdo.jpg" style="width: 42mm; height: 25mm; position: absolute; top: 107mm; left: 158mm">
    <img src="../imagenes/cristalino frente.jpg" style="width: 10mm; height: 10mm; position: absolute; top: 117mm; left: 145mm">
    <img src="../imagenes/cristalino izquierdo.jpg" style="width: 5mm; height: 13mm; position: absolute; top: 115mm; left: 135mm">    

    <img src="../imagenes/ilustracion ojo lado izquierdo.jpg" style="width: 25mm; height: 25mm; position: absolute; top: 106.8mm; left: 104mm">
    <img src="../imagenes/fondo de ojo izquierdo.jpg" style="width: 14mm; height: 14mm; position: absolute; top: 136mm; left: 110mm">

    <table style="width: 216mm; border: none">
      <tbody>
        <tr>
          <td style="width: 44%; height: 20px; padding: 0px 8px;"><div style="border-bottom: 1px solid #6a6a6a;"></div></td>
          <td style="width: 48.5%; height: 20px; padding: 0px 12px;"><div style="border-bottom: 1px solid #6a6a6a;"></div></td>
        </tr>
        <tr>
          <td style="width: 46%; height: 20px; padding: 0px 8px;"><div style="border-bottom: 1px solid #6a6a6a;"></div></td>
          <td style="width: 48.5%; height: 20px; padding: 0px 12px;"><div style="border-bottom: 1px solid #6a6a6a;"></div></td>
        </tr>
        <tr>
          <td style="width: 46%; height: 20px; padding: 0px 8px;"><div style="border-bottom: 1px solid #6a6a6a;"></div></td>
          <td style="width: 48.5%; height: 20px; padding: 0px 12px;"><div style="border-bottom: 1px solid #6a6a6a;"></div></td>
        </tr>
        <tr>
          <td style="width: 46%; height: 20px; padding: 0px 8px;"><div style="border-bottom: 1px solid #6a6a6a;"></div></td>
          <td style="width: 48.5%; height: 20px; padding: 0px 12px;"><div style="border-bottom: 1px solid #6a6a6a;"></div></td>
        </tr>
        <tr>
          <td style="width: 46%; height: 20px; padding: 0px 8px;"><div style="border-bottom: 1px solid #6a6a6a;"></div></td>
          <td style="width: 48.5%; height: 20px; padding: 0px 12px;"><div style="border-bottom: 1px solid #6a6a6a;"></div></td>
        </tr>
        <tr>
          <td style="width: 46%; height: 20px; padding: 0px 8px;"><div style="border-bottom: 1px solid #6a6a6a;"></div></td>
          <td style="width: 48.5%; height: 20px; padding: 0px 12px;"><div style="border-bottom: 1px solid #6a6a6a;"></div></td>
        </tr>
        <tr>
          <td style="width: 46%; height: 20px; padding: 0px 8px;"><div style="border-bottom: 1px solid #6a6a6a;"></div></td>
          <td style="width: 48.5%; height: 20px; padding: 0px 12px;"><div style="border-bottom: 1px solid #6a6a6a;"></div></td>
        </tr>
        <tr>
          <td style="width: 46%; height: 20px; padding: 0px 8px;"><div style="border-bottom: 1px solid #6a6a6a;"></div></td>
          <td style="width: 48.5%; height: 20px; padding: 0px 12px;"><div style="border-bottom: 1px solid #6a6a6a;"></div></td>
        </tr>
        <tr>
          <td style="width: 46%; height: 20px; padding: 0px 8px;"><div style="border-bottom: 1px solid #6a6a6a;"></div></td>
          <td style="width: 48.5%; height: 20px; padding: 0px 12px;"><div style="border-bottom: 1px solid #6a6a6a;"></div></td>
        </tr>
        <tr>
          <td style="width: 46%; height: 20px; padding: 0px 8px;"><div style="border-bottom: 1px solid #6a6a6a;"></div></td>
          <td style="width: 48.5%; height: 20px; padding: 0px 12px;"><div style="border-bottom: 1px solid #6a6a6a;"></div></td>
        </tr>
        <tr>
          <td style="width: 46%; height: 20px; padding: 0px 8px;"><div style="border-bottom: 1px solid #6a6a6a;"></div></td>
          <td style="width: 48.5%; height: 20px; padding: 0px 12px;"><div style="border-bottom: 1px solid #6a6a6a;"></div></td>
        </tr>
        <tr>
          <td style="width: 46%; height: 20px; padding: 0px 8px;"><div style="border-bottom: 1px solid #6a6a6a;"></div></td>
          <td style="width: 48.5%; height: 20px; padding: 0px 12px;"><div style="border-bottom: 1px solid #6a6a6a;"></div></td>
        </tr>
        <tr>
          <td style="width: 46%; height: 20px; padding: 0px 8px;"><div style="border-bottom: 1px solid #6a6a6a;"></div></td>
          <td style="width: 48.5%; height: 20px; padding: 0px 12px;"><div style="border-bottom: 1px solid #6a6a6a;"></div></td>
        </tr>
        <tr>
          <td style="width: 46%; height: 20px; padding: 0px 8px;"><div style="border-bottom: 1px solid #6a6a6a;"></div></td>
          <td style="width: 48.5%; height: 20px; padding: 0px 12px;"><div style="border-bottom: 1px solid #6a6a6a;"></div></td>
        </tr>
        <tr>
          <td style="width: 46%; height: 20px; padding: 0px 8px;"><div style="border-bottom: 1px solid #6a6a6a;"></div></td>
          <td style="width: 48.5%; height: 20px; padding: 0px 12px;"><div style="border-bottom: 1px solid #6a6a6a;"></div></td>
        </tr>
        <tr>
          <td style="width: 46%; height: 20px; padding: 0px 8px;"><div style="border-bottom: 1px solid #6a6a6a;"></div></td>
          <td style="width: 48.5%; height: 20px; padding: 0px 12px;"><div style="border-bottom: 1px solid #6a6a6a;"></div></td>
        </tr>
        <tr>
          <td style="width: 46%; height: 20px; padding: 0px 8px;"><div style="border-bottom: 1px solid #6a6a6a;"></div></td>
          <td style="width: 48.5%; height: 20px; padding: 0px 12px;"><div style="border-bottom: 1px solid #6a6a6a;"></div></td>
        </tr>
        <tr>
          <td style="width: 46%; height: 20px; padding: 0px 8px;"><div style="border-bottom: 1px solid #6a6a6a;"></div></td>
          <td style="width: 48.5%; height: 20px; padding: 0px 12px;"><div style="border-bottom: 1px solid #6a6a6a;"></div></td>
        </tr>
        <tr>
          <td style="width: 46%; height: 20px; padding: 0px 8px;"><div style="border-bottom: 1px solid #6a6a6a;"></div></td>
          <td style="width: 48.5%; height: 20px; padding: 0px 12px;"><div style="border-bottom: 1px solid #6a6a6a;"></div></td>
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

        $hora   = $obj->fechaHora('America/Caracas','H-i-s');
        $obj->fechaHora('America/Caracas','d-m-Y');
        $nombre = $id_historia.'-'.$dia.'-'.$hora;

        if ($pdf == 1) {
          $html2pdf->output("../reportes/historias/historia$nombre.pdf", "f");
        } else if ($pdf == 2) {
          $html2pdf->Output("../reportes/historias/historia$nombre.pdf");
        } else {  
          $html2pdf->Output("../reportes/historias/historia$nombre.pdf");
          $html2pdf->output("../reportes/historias/historia$nombre.pdf", "f");
        }
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
  }
?>