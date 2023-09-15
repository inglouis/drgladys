<?php
  /*MODOS PDF:
    0: traer solo estructura HTML
    1: solo guardar REPORTE,
    2: traer reporte SIN GUARDAR,
    3: traer reporte Y GUARDAR, 
  */

  ob_start();
  include_once('../clases/historias.class.php');
  $obj = new Model();

  if (isset($_REQUEST['pdf'])) {
    $pdf = (int)$_REQUEST['pdf'];
  } else {
    $pdf = 1;
  }

  if (isset($_REQUEST['id'])) {
    $id = (int)$_REQUEST['id'];
  } else {
    $id = 0;
  }

  $datos = null; 

  if (isset($_REQUEST['modo'])) {

    if ($_REQUEST['modo'] == 'imprimir') {

      $datos = json_decode($obj->seleccionar("select *, TO_CHAR(fecha :: DATE, 'dd-mm-yyyy') as fecha_arreglada from principales.recipes where id_recipe = ?", [$id]), true)[0];
      $datos['medicamentos'] = json_decode($datos['medicamentos'], true);
      
    } else if ($_REQUEST['modo'] == 'previa') {

      $datos = json_decode($_SESSION['datos_pdf'], true);
      $datos['nombres'] = $datos[0];
      $datos['cedula'] = $datos[1];
      $datos['id_historia'] = $datos[2];
      $datos['medicamentos'] = $datos[3];

      $datos['fecha_arreglada']  = $obj->fechaHora('America/Caracas','Y-m-d');

    } else {

      throw new Exception('MODO INVALIDO');

    }


  } else {

     throw new Exception('ES NECESARIO DECLARAR EL MODO DEL REPORTE');

  }

  $maximo = 3;

  if ($datos['id_historia'] == 0 || $datos['id_historia'] == '0') {

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

  page {
    font-size: 15px;
    font-family: arial;
  }

  page, div, table, h5, h3, h4 {
    color: #262626; /*#723200;*/
    margin:0px !important;
  }

  table {
    font-size: 15px;
    left: 7mm;
    position: relative;
  }

  table tbody {

  }

  #separador {
    width: 90%;
    margin-top: 0px
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
  }

  #subcabecera {
    font-size: 12px;
    width: 100%;
    text-align: center;
  }

  .separador {
    width: 197mm;
    height: 2px;
    border-top: 2px dashed #909090;
    border-bottom: 2px dashed #909090;
    margin: 2px 2px;
  }

  #cabecera {
    top: 5mm;
    position: relative;
    width: 100%; 
    color: #723200;
  }

  #cabecera h5, #cabecera h4, #cabecera div {
    text-align: center;
    font-size: 16px;
  }

  .centro {
    text-align: center;
    font-size: 14px;
    width: 100%;
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
    padding-top:11px;
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

<page style="text-align:justify;" backtop="5mm" backbottom="5mm" backleft="10mm" backright="10mm">

    <div class="contenedor" style="height: 120mm">
      
      <div id="cabecera">

        <div style="font-family: 'Qwigley'; font-size: 40px; ">
          Dra. Gladys A. Chaparro H.
        </div>

        <div style="font-size: 14px">RIF: v-09143081-5</div>
        <div style="font-size: 14px">Oftalmólogo</div>
        <div style="font-size: 14px">Infantil y Estrabismo</div>
        <div style="font-size: 14px">M.S.D.S.: 34.989 C.M.: 1.915</div>

      </div>

      <div></div>
      <div class="separador"></div>

      <div style="position: absolute;  top: 15mm; left: 5mm; height: 0px;">
        <img src="../imagenes/logo_cemoc.jpg" style="width: 45mm; height: 25mm;">
      </div>

      <div></div>

      <div class="subtitulo">
        RP:
      </div>  

      <div style="height: 180px">
        
        <table style="width: 216mm; border: none; border-collapse: collapse; margin-left: 50px; ">
          <tbody>
            <?php 

              foreach($datos['medicamentos'] as $r) :?>

              <tr style="padding: 0px; height: 10px;">
                <td style="height: 10px; width:180mm;text-align: left; vertical-align: middle; border-bottom: 1px dashed #ccc; font-size: 10px; font-weight: 100">
                  <?php 

                    if (isset($r['medicamentos_genericos'])) {

                      $concat = $r['nombre'].' '.strtoupper(substr($r['medicamentos_genericos'], strlen($r['medicamentos_genericos'])));

                      $concat .= ': '.$r['presentacion'];
                      echo $concat;

                    }  

                  ?>
                </td>
              </tr>
            <?php endforeach;?>
          </tbody>
        </table>

      </div>

      <div></div>

      <table style="position:absolute; top: 110mm; width: 200mm; border: none;">
        <tbody>
          <tr>
            <td style="width: 75mm; text-align: center; font-size: 12px">NOMBRE: <?php echo $datos['nombres']?></td>
            <td style="width: 35mm; text-align: center; font-size: 12px">CI: <?php echo $datos['cedula']?></td>
            <td style="width: 35mm; text-align: center; font-size: 12px">N° HISTORIA: <?php echo $datos['id_historia']?></td>
            <td style="width: 35mm; text-align: center; font-size: 12px">FECHA: <?php echo $datos['fecha_arreglada']?></td>
          </tr>
        </tbody>
      </table>

      <div>
        <div style="width: 95%; height: 1px; background: #723200; position: relative; left: 5mm"></div>
        <div class="centro" style="font-size: 12px; position: relative; top: -8px">Av. Guayana, C.C. Villa Etapa "C", Edificio CEMOC - Consultorio 103, San Cristóbal - Edo. Táchira., (0276) 4121329, (0276) 5108011</div>
      </div>

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
  <div class="contenedor" style="margin-top: 40px; position: relative;">

    <div id="cabecera">

      <div style="font-family: 'Qwigley'; font-size: 40px;">
        Dra. Gladys A. Chaparro H.
      </div>

      <div style="font-size: 14px">RIF: v-09143081-5</div>
      <div style="font-size: 14px">Oftalmólogo</div>
      <div style="font-size: 14px">Infantil y Estrabismo</div>
      <div style="font-size: 14px">M.S.D.S.: 34.989 C.M.: 1.915</div>

    </div>

    <div></div>
    <div class="separador"></div>

    <div style="position: absolute;  top: 10mm; left: 5mm; height: 0px;">
      <img src="../imagenes/logo_cemoc.jpg" style="width: 45mm; height: 25mm;">
    </div>

    <div></div>

    <div class="subtitulo">
      IND:
    </div>

    <div style="height: 180px">
      
      <table style="width: 216mm; border: none; border-collapse: collapse; margin-left: 50px;">
        <tbody>

          <?php 

            $longitud_final = 0;

            for ($pag = 0; $pag < 4; $pag++) : 

              if(count($datos['medicamentos']) > $pag) {

                $longitud_final = $longitud_final + 1;

          ?>

          <tr style="padding: 0px; height: 10px;">
            <td style="height: 10px; text-align: left; vertical-align: middle; border-bottom: 1px dashed #ccc; font-size: 10px; font-weight: 100">
              <?php 

                if (isset($datos['medicamentos'][$pag]['medicamentos_genericos'])) {

                  $concat = $datos['medicamentos'][$pag]['nombre'].' '.strtoupper(substr($datos['medicamentos'][$pag]['medicamentos_genericos'], strlen($datos['medicamentos'][$pag]['medicamentos_genericos'])));
                  echo $concat;

                }

              ?>
            </td>
          </tr>
          <tr style="padding: 0px; height: 10px; margin-left: 5px;">
            <td style="padding-left: 50px;width: 140mm; height: 10px; text-align: left; vertical-align: middle; border-bottom: 1px dashed #ccc; font-size: 10px; font-weight: 100">
              <?php 
                $concat = $datos['medicamentos'][$pag]['tratamiento'];
                echo $concat;
              ?>
            </td>
          </tr>

          <?php
              }
            endfor;
          ?>
    
        </tbody>
      </table>  

    </div>

    <div></div>

    <table style="position:absolute; top: 110mm; width: 200mm; border: none;">
        <tbody>
          <tr>
            <td style="width: 75mm; text-align: center; font-size: 12px">NOMBRE: <?php echo $datos['nombres']?></td>
            <td style="width: 35mm; text-align: center; font-size: 12px">CI: <?php echo $datos['cedula']?></td>
            <td style="width: 35mm; text-align: center; font-size: 12px">N° HISTORIA: <?php echo $datos['id_historia']?></td>
            <td style="width: 35mm; text-align: center; font-size: 12px">FECHA: <?php echo $datos['fecha_arreglada']?></td>
          </tr>
        </tbody>
      </table>

      <div>
        <div style="width: 95%; height: 1px; background: #723200; position: relative; left: 5mm"></div>
        <div class="centro" style="font-size: 12px; position: relative; top: -8px">Av. Guayana, C.C. Villa Etapa "C", Edificio CEMOC - Consultorio 103, San Cristóbal - Edo. Táchira., (0276) 4121329, (0276) 5108011</div>
      </div>

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
    $maxPag  = 7;
    $currentPag = 4;

    for ($i = 0; $i < $paginas; $i++) : ?>

      <page style="width: 216mm" backtop="0mm" backbottom="5mm" backleft="5mm" backright="5mm">
        
        <div class="contenedor" style="position: relative;">

          <div id="cabecera">

            <div style="font-family: 'Qwigley'; font-size: 40px;">
              Dra. Gladys A. Chaparro H.
            </div>

            <div style="font-size: 14px">RIF: v-09143081-5</div>
            <div style="font-size: 14px">Oftalmólogo</div>
            <div style="font-size: 14px">Infantil y Estrabismo</div>
            <div style="font-size: 14px">M.S.D.S.: 34.989 C.M.: 1.915</div>

          </div>

          <div></div>
          <div class="separador"></div>

          <div style="position: absolute;  top: 10mm; left: 5mm; height: 0px;">
            <img src="../imagenes/logo_cemoc.jpg" style="width: 45mm; height: 25mm;">
          </div>

          <div></div>

          <div class="subtitulo">
            IND:
          </div>

          <div style="height: 180px">
            
            <table style="width: 216mm; border: none; border-collapse: collapse; margin-left: 50px;">
              <tbody>

                <?php for ($pag = $currentPag; $pag < $maxPag; $pag++) : 
                  if(count($datos['medicamentos']) > $pag) {
                ?>

                <tr style="padding: 0px; height: 10px;">
                  <td style="height: 10px; text-align: left; vertical-align: middle; border-bottom: 1px dashed #ccc; font-size: 10px; font-weight: 100">
                    <?php 

                      $concat = $datos['medicamentos'][$pag]['nombre'].' '.strtoupper(substr($datos['medicamentos'][$pag]['medicamentos_genericos'], strlen($datos['medicamentos'][$pag]['medicamentos_genericos'])));
                      echo $concat;

                    ?>
                  </td>
                </tr>
                <tr style="padding: 0px; height: 10px; margin-left: 5px;">
                  <td style="padding-left: 50px;width: 140mm; height: 10px; text-align: left; vertical-align: middle; border-bottom: 1px dashed #ccc; font-size: 10px; font-weight: 100">
                    <?php 
                      $concat = $datos['medicamentos'][$pag]['tratamiento'];
                      echo $concat;
                    ?>
                  </td>
                </tr>
                
                <?php
                  }
                  endfor;

                  if($pag == $maxPag) {
                    $currentPag = $pag;
                    $maxPag = $maxPag + 3;
                  }

                ?>
              </tbody>
            </table>  
            
          </div>

        <div></div>

        <table style="position:absolute; top: 110mm; width: 200mm; border: none;">
          <tbody>
            <tr>
              <td style="width: 75mm; text-align: center; font-size: 12px">NOMBRE: <?php echo $datos['nombres']?></td>
              <td style="width: 35mm; text-align: center; font-size: 12px">CI: <?php echo $datos['cedula']?></td>
              <td style="width: 35mm; text-align: center; font-size: 12px">N° HISTORIA: <?php echo $datos['id_historia']?></td>
              <td style="width: 35mm; text-align: center; font-size: 12px">FECHA: <?php echo $datos['fecha_arreglada']?></td>
            </tr>
          </tbody>
        </table>

        <div>
          <div style="width: 95%; height: 1px; background: #723200; position: relative; left: 5mm"></div>
          <div class="centro" style="font-size: 12px; position: relative; top: -8px">Av. Guayana, C.C. Villa Etapa "C", Edificio CEMOC - Consultorio 103, San Cristóbal - Edo. Táchira., (0276) 4121329, (0276) 5108011</div>
        </div>


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
        $html2pdf = new HTML2PDF('P', array($width_in_mm,$height_in_mm), 'en', true, 'UTF-8', array(0, 0, 0, 0));
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));

        
        $obj->fechaHora('America/Caracas','d-m-Y');
        
        $nombre = /*$datos->id_historia.*/'-'.$dia.'-'.$hora;

        if ($pdf == 1) {
          $html2pdf->output("../reportes/recipes/recipe$nombre.pdf", "f");
        } else if ($pdf == 2) {
          $html2pdf->Output("../reportes/recipes/recipe$nombre.pdf");
        } else {  
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