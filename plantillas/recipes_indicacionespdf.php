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
    throw new Exception('EL REPORTE NO SE PUEDE PROCESAR SIN ID');
  }

  if (isset($_REQUEST['pdf'])) {
    $pdf = (int)$_REQUEST['pdf'];
  } else {
    $pdf = 1;
  }

  $datos = json_decode($obj->seleccionar("select *, TO_CHAR(fecha :: DATE, 'dd-mm-yyyy') as fecha_arreglada from historias.recipes where id_recipe = ?", [$id]), true)[0];
  $datos['medicamentos'] = json_decode($datos['medicamentos'], true);
  $maximo = 3;

  if($datos['id_historia'] == 0 || $datos['id_historia'] == '0') {
    $datos['id_historia'] = '--';
  }

  // echo "<pre>";
  // print_r($datos);
  // echo "</pre>";

  $dia  = $obj->fechaHora('America/Caracas','d-m-Y');
  $hora = $obj->fechaHora('America/Caracas','H:i:s');

  $tratamientosRellenos = false;
?>

<style>
      #separador, #separadorb {
        margin-top: 0px
      }

      #titulo1, #titulo1b {
        top:45px
      }

      #titulo2,#titulo2b {
        top: 70px;
      }

      #titulo3, #titulo3b {
        top:130px;
        font-size: 15px;
      }

      #titulo4, #titulo4b {
        top: 155px;
        font-size: 15px;
      }

      #fecha, #fechab {
        top: 55px;
        font-weight: 100; 
        color: #5f5f5f;
      }

      #hora, #horab {
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
        width: 81%;
        display: flex;
        flex-direction: column;
        font-size: 18px;
      }

      #subcabecera, #subcabecerab {
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

      #cabecera h5, #cabecera h4, #cabecerab h5, #cabecerab h4 {
        width: 100%; 
        text-align: center;
        position:absolute;
      }

      #cabecera h5, #cabecerab h5 {
        font-size: 16px;
      }

      #cabecera h4, #cabecera h4 {
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

<?php 
// echo "<pre>";
// print_r($datos['medicamentos']);
// echo "</pre>";
?>

<page style="width: 216mm;"  backtop="0mm" backbottom="5mm" backleft="5mm" backright="5mm">
  <div class="contenedor">
    <div id="cabecera" style="height: 30px;">
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

    <div style="position: absolute;  top: 5mm; left: 0mm">
       <img src="../imagenes/logo_reportes.jpg" style="width: 30mm; height: 23mm;">
    </div>
    <div class="separador"></div>

    <div class="subtitulo">
      RP:
    </div>  

    <table style="width: 216mm; border: none; border-collapse: collapse; margin-left: 50px; ">
      <tbody>
        <?php 

          foreach($datos['medicamentos'] as $r) :?>

          <?php 
            $genericos = $obj->e_pdo("select * from ppal.traer_medicamentos_genericos where id_medicamento = $r[id_medicamento]")->fetch(PDO::FETCH_ASSOC);
            $genericos['genericos_nombres'] = json_decode($genericos['genericos_nombres'], true);
          ;?>

          <tr style="padding: 0px; height: 10px;">
            <td style="height: 10px; width:180mm;text-align: left; vertical-align: middle; border-bottom: 1px dashed #ccc; font-size: 10px; font-weight: 100">
              <?php 

                if(isset($r['medicamentos_genericos'])) {
                  $concat = strtoupper($r['medicamentos_genericos']);

                  $concat .= ': '.$r['presentacion'];
                  echo $concat;

                } else {

                  if (count($genericos['genericos_nombres']) > 0) {

                    $concat = $genericos['nombre'].' O ';

                    foreach ($genericos['genericos_nombres'] as $c) {
                      $concat .= $c.' O ';
                    }
                    $concat = substr($concat, 0, -3);
                  } else {

                    $concat = $genericos['nombre'];

                  }

                  $concat .= ': '.$r['presentacion'];
                  echo $concat;
                }          
              ?>
            </td>
          </tr>
        <?php endforeach;?>
      </tbody>
    </table>

    <table style="position:absolute; top: 110mm; width: 200mm; border: none;">
      <tbody>
        <tr>
          <td style="width: 75mm; text-align: center">NOMBRE: <?php echo $datos['nombres']?></td>
          <td style="width: 35mm; text-align: center">CI: <?php echo $datos['cedula']?></td>
          <td style="width: 35mm; text-align: center">N° HISTORIA: <?php echo $datos['id_historia']?></td>
          <td style="width: 35mm; text-align: center">FECHA: <?php echo $datos['fecha_arreglada']?></td>
        </tr>
      </tbody>
    </table>

    <table style="position:absolute; top: 115mm; width: 180mm; border: none;">
      <tbody>
        <tr>
          <td style="width: 200mm; text-align: center">PACIENTE CON RESIDENCIA LEJANA COMUNICARSE ANTES DE VENIR A CONSULTA</td>
        </tr>
      </tbody>
    </table>

    <table style="position:absolute; top: 120mm; width: 180mm; border: none;">
      <tbody>
        <tr>
          <td style="width: 200mm; font-weight: bold; text-align: center">*  *  *  *  *  ORDEN DE LLEGADA  *  *  *  *  *</td>
        </tr>
      </tbody>
    </table>
  </div> 

<?php
  $longitud = count($datos['medicamentos']);
  
  for ($i = 0; $i < $longitud; $i++) {

    $r = $datos['medicamentos'][$i];
    
    if (trim($datos['medicamentos'][$i]['tratamiento']) !== '') {
      $tratamientosRellenos = true;
    };

  }


  if ($tratamientosRellenos == true) {
?>

  <!--segunda hoja-->
  <div class="contenedor" style="margin-top: 20px">

    <div id="cabecera" style="height: 70px;">
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

    <div class="subtitulo">
      IND:
    </div>

    <?php 

      $longitud_final = 0;

      for ($pag = 0; $pag < 3; $pag++) : 

      if(count($datos['medicamentos']) > $pag) {

          $longitud_final = $longitud_final + 1;

    ?>

    <table style="width: 216mm; border: none; border-collapse: collapse; margin-left: 50px;">
      <tbody>
        <?php
          $r = $datos['medicamentos'][$pag];
          $genericos = $obj->e_pdo("select * from ppal.traer_medicamentos_genericos where id_medicamento = $r[id_medicamento]")->fetch(PDO::FETCH_ASSOC);
          $genericos['genericos_nombres'] = json_decode($genericos['genericos_nombres'], true);
        ;?>

        <tr style="padding: 0px; height: 10px;">
          <td style="height: 10px; text-align: left; vertical-align: middle; border-bottom: 1px dashed #ccc; font-size: 10px; font-weight: 100">
            <?php 


              if(isset($r['medicamentos_genericos'])) {

                $concat = strtoupper($r['medicamentos_genericos']);
                echo $concat;

              } else {

                if (count($genericos['genericos_nombres']) > 0) {

                  $concat = $genericos['nombre'].' O ';

                          $concat = substr($concat, 0, -3);
                } else {

                  $concat = $genericos['nombre'];

                }

                echo $concat;
              } 
            ?>
          </td>
        </tr>
        <tr style="padding: 0px; height: 10px; margin-left: 5px;">
          <td style="padding-left: 50px;width: 140mm; height: 10px; text-align: left; vertical-align: middle; border-bottom: 1px dashed #ccc; font-size: 10px; font-weight: 100">
            <?php 
              $concat = $r['tratamiento'];
              echo $concat;
            ?>
          </td>
        </tr>
      </tbody>
    </table>  

    <?php
    }
      endfor;
    ?>
    <table style="margin-top: 20px; width: 200mm; border: none;">
      <tbody>
        <tr>
          <td style="width: 70mm; text-align: center">NOMBRE: <?php echo $datos['nombres']?></td>
          <td style="width: 35mm; text-align: center">CI: <?php echo $datos['cedula']?></td>
          <td style="width: 35mm; text-align: center">N° HISTORIA: <?php echo $datos['id_historia']?></td>
          <td style="width: 35mm; text-align: center">FECHA: <?php echo $datos['fecha_arreglada']?></td>
        </tr>
      </tbody>
    </table>

    <table style=" width: 180mm; border: none;">
      <tbody>
        <tr>
          <td style="width: 200mm; text-align: center">PACIENTE CON RESIDENCIA LEJANA COMUNICARSE ANTES DE VENIR A CONSULTA</td>
        </tr>
      </tbody>
    </table>

    <table style=" width: 180mm; border: none;">
      <tbody>
        <tr>
          <td style="width: 200mm; font-weight: bold; text-align: center">*  *  *  *  *  ORDEN DE LLEGADA  *  *  *  *  *</td>
        </tr>
      </tbody>
    </table>

  </div>

<?php 
}
?>

</page>

<?php 

  if ($tratamientosRellenos == true && $longitud_final != count($datos['medicamentos'])) {
  
  //$test = 7;
  //if($test > $maximo) {
    //$paginas = ceil($test / $maximo);
    $paginas = floor(count($datos['medicamentos']) / $maximo);
    $maxPag  = 6;
    $currentPag = 3;

    for ($i = 0; $i < $paginas; $i++) : ?>

      <page style="width: 216mm" backtop="0mm" backbottom="5mm" backleft="5mm" backright="5mm">
        <div class="contenedor">

          <div id="cabecera" style="height: 70px;">
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

          <div style="position: absolute;  top: 5mm; left: 0mm">
           <img src="../imagenes/logo_reportes.jpg" style="width: 30mm; height: 23mm;">
        </div>

          <div class="separador"></div>

          <div class="subtitulo">
            IND:
          </div>

          <?php for ($pag = $currentPag; $pag < $maxPag; $pag++) : 
            if(count($datos['medicamentos']) > $pag) {
          ?>

          <table style="width: 216mm; border: none; border-collapse: collapse; margin-left: 50px;">
            <tbody>
              <?php
                $r = $datos['medicamentos'][$pag];
                $genericos = $obj->e_pdo("select * from ppal.traer_medicamentos_genericos where id_medicamento = $r[id_medicamento]")->fetch(PDO::FETCH_ASSOC);
                $genericos['genericos_nombres'] = json_decode($genericos['genericos_nombres'], true);
              ;?>

              <tr style="padding: 0px; height: 10px;">
                <td style="height: 10px; text-align: left; vertical-align: middle; border-bottom: 1px dashed #ccc; font-size: 10px; font-weight: 100">
                  <?php 
                    $concat = $genericos['nombre'];
                    echo $concat;
                  ?>
                </td>
              </tr>
              <tr style="padding: 0px; height: 10px; margin-left: 5px;">
                <td style="padding-left: 50px;width: 140mm; height: 10px; text-align: left; vertical-align: middle; border-bottom: 1px dashed #ccc; font-size: 10px; font-weight: 100">
                  <?php 
                    $concat = $r['tratamiento'];
                    echo $concat;
                  ?>
                </td>
              </tr>
            </tbody>
          </table>  

          <?php
          }
          endfor;

          if($pag == $maxPag) {
            $currentPag = $pag;
            $maxPag = $maxPag + 3;
          }

        ?>
        <table style="position:absolute; top: 120mm; width: 200mm; border: none;">
          <tbody>
            <tr>
              <td style="width: 70mm; text-align: center">NOMBRE: <?php echo $datos['nombres']?></td>
              <td style="width: 35mm; text-align: center">CI: <?php echo $datos['cedula']?></td>
              <td style="width: 35mm; text-align: center">N° HISTORIA: <?php echo $datos['id_historia']?></td>
              <td style="width: 35mm; text-align: center">FECHA: <?php echo $datos['fecha_arreglada']?></td>
            </tr>
          </tbody>
        </table>

        <table style="position:absolute; top: 125mm; width: 180mm; border: none;">
          <tbody>
            <tr>
              <td style="width: 200mm; text-align: center">PACIENTE CON RESIDENCIA LEJANA COMUNICARSE ANTES DE VENIR A CONSULTA</td>
            </tr>
          </tbody>
        </table>

        <table style="position:absolute; top: 130mm; width: 180mm; border: none;">
          <tbody>
            <tr>
              <td style="width: 200mm; font-weight: bold; text-align: center">*  *  *  *  *  ORDEN DE LLEGADA  *  *  *  *  *</td>
            </tr>
          </tbody>
        </table>

      </div>
    </page>

    <?php endfor;

  }?>
    
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
          $html2pdf->Output("../reportes/recipes/recipe$nombre.pdf", "f");
        } else if ($pdf == 2) {
          $html2pdf->Output("../reportes/recipes/recipe$nombre.pdf");
        } else if ($pdf == 3){      
          $html2pdf->Output("../reportes/recipes/recipe$nombre.pdf");
          $html2pdf->output("../reportes/recipes/recipe$nombre.pdf", "f");
        }
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
  }
?>