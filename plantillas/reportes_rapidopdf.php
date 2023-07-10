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

  //--------------------------------------------------
  //VARIABLES GENERALES
  //--------------------------------------------------
  if (isset($_REQUEST['pdf'])) {
    $pdf = (int)$_REQUEST['pdf'];
  } else {
    $pdf = 2;
  }

  if (isset($_REQUEST['id'])) {
    $id = (int)$_REQUEST['id'];
  } else {
     throw new Exception('operación inválida: ID necesario para reporte rápido'); 
  }

  $dia  = $obj->fechaHora('America/Caracas','d-m-Y');
  $hora = $obj->fechaHora('America/Caracas','H:i:s');
  $datos = json_decode($obj->seleccionar("select a.*, b.nomb_medi from historias.entradas as a 
    left join historias.medicos as b using(id_medico)
    where a.id_historia = ?", [$id]), true)[0];
  $telefonos = json_decode($datos['telefonos'], true);
  $edad      = $obj->calcularEdad($datos['fech_naci']);
  setlocale(LC_ALL,"es_ES@euro","es_ES","esp");

  //--------------------------------------------------
  //VARIABLES ESPECIFICAS
  //--------------------------------------------------
  if (isset($_REQUEST['admision'])) {
    $admision = (int)$_REQUEST['admision'];
  } else {
     throw new Exception('operación inválida: ADMISION necesario para reporte rápido'); 
  }

  if (isset($_REQUEST['limpieza_lentes'])) {
    $limpieza_lentes = (int)$_REQUEST['limpieza_lentes'];
  } else {
     throw new Exception('operación inválida: LIMPIEZA LENTES necesario para reporte rápido'); 
  }

  if (isset($_REQUEST['horarios_lentes'])) {
    $horarios_lentes = (int)$_REQUEST['horarios_lentes'];
  } else {
     throw new Exception('operación inválida: HORARIOS LENTES necesario para reporte rápido'); 
  }

  if (isset($_REQUEST['limpieza_gas'])) {
    $limpieza_gas = (int)$_REQUEST['limpieza_gas'];
  } else {
     throw new Exception('operación inválida: HORARIOS LENTES necesario para reporte rápido'); 
  }

  if (isset($_REQUEST['tele_torax'])) {
    $tele_torax = (int)$_REQUEST['tele_torax'];
  } else {
     throw new Exception('operación inválida: TELE TORAX necesario para reporte rápido'); 
  }

  if (isset($_REQUEST['normas_cirugia'])) {
    $normas_cirugia = (int)$_REQUEST['normas_cirugia'];
  } else {
     throw new Exception('operación inválida: NORMAS CIRUGIA necesario para reporte rápido'); 
  }

  if (isset($_REQUEST['normas_retina'])) {
    $normas_retina = (int)$_REQUEST['normas_retina'];
  } else {
     throw new Exception('operación inválida: NORMAS RETINA necesario para reporte rápido'); 
  }

  if (isset($_REQUEST['normas_laser'])) {
    $normas_laser = (int)$_REQUEST['normas_laser'];
  } else {
     throw new Exception('operación inválida: NORMAS LASER necesario para reporte rápido'); 
  }

  if (isset($_REQUEST['acompanante'])) {
    $acompanante = (int)$_REQUEST['acompanante'];
  } else {
     throw new Exception('operación inválida: CONSTANCIA DE ACOMPANANTE necesario para reporte rápido'); 
  };

  if (isset($_REQUEST['constancia'])) {
    $constancia = (int)$_REQUEST['constancia'];
  } else {
     throw new Exception('operación inválida: CONSTANCIA necesario para reporte rápido'); 
  };

  if (isset($_REQUEST['vial'])) {
    $vial = (int)$_REQUEST['vial'];
  } else {
     throw new Exception('operación inválida: VIAL necesario para reporte rápido'); 
  };

  if (isset($_REQUEST['operatorio'])) {

    $operatorio = $_REQUEST['operatorio'];

  } else {
     throw new Exception('operación inválida: OPERATORIO necesario para reporte rápido'); 
  };

  if (isset($_REQUEST['amsler'])) {

    $amsler = $_REQUEST['amsler'];

  } else {
     throw new Exception('operación inválida: AMSLER necesario para reporte rápido'); 
  };

  if (isset($_REQUEST['prepresupuesto'])) {

    $prepresupuesto = $_REQUEST['prepresupuesto'];

  } else {
     throw new Exception('operación inválida: PREPRESUPUESTO necesario para reporte rápido'); 
  };

  if (isset($_REQUEST['curva_presion'])) {

    $curva_presion = $_REQUEST['curva_presion'];

  } else {
     throw new Exception('operación inválida: CURVA_PRESION necesario para reporte rápido'); 
  };

  if (isset($_REQUEST['paquimetria'])) {

    $paquimetria = $_REQUEST['paquimetria'];

  } else {
     throw new Exception('operación inválida: CURVA_PRESION necesario para reporte rápido'); 
  };

  //--------------------------------------------------
  //PETICIONES
  //--------------------------------------------------
  if ($admision == 1) {
    $datosAdmision = json_decode($obj->seleccionar("select 
      a.apel_nomb,
      a.nume_cedu,
      TO_CHAR(a.fech_naci :: DATE, 'dd-mm-yyyy') as fech_naci,
      a.dire_paci,
      b.nomb_medi
    from historias.entradas as a
    inner join historias.medicos as b using(id_medico)
    where a.id_historia = ?", [$id]), true)[0];
  };

  if ($limpieza_lentes == 1) {

  }

  if ($horarios_lentes == 1) {

  }

  if ($limpieza_gas == 1) {

  }

  if ($limpieza_gas == 1) {

  }

  if ($tele_torax == 1) {

  }

  if ($normas_cirugia == 1) {

  }

  if ($normas_retina == 1) {

  }

  if ($normas_laser == 1) {

  }

  if ($curva_presion == 1) {

  }

  if ($paquimetria == 1) {

  }

  //--------------------------------------------------
  // CAPTURA DE DATOS
  //--------------------------------------------------

  //datos globales:
  $datos_pdf = json_decode($_SESSION['datos_pdf'], true);
  //--------------------------------------------------

  // echo "<pre>";
  // print_r($datos_pdf);
  // echo "</pre>";

  //--------------------------------------------------
  if ($constancia == 1) {
    $datos_constancia = $datos_pdf['datos_constancia'];
    $datos_constancia[3] = date("d-m-Y", strtotime($datos_constancia[3]));
  }
  //--------------------------------------------------
  if ($acompanante == 1) {

    $datos_acompanante = $datos_pdf['datos_acompanante'];
    $datos_acompanante[2] = date("d-m-Y", strtotime($datos_acompanante[2]));

    $nombre_aco = strtoupper($datos_acompanante[0]);
    $cedu_aco = $datos_acompanante[1];
    $fecha_aco = $datos_acompanante[2];

  };
  //--------------------------------------------------
  if ($vial == 1) {
    $datos_vial = $datos_pdf['datos_vial'];
  }
  //--------------------------------------------------
  if ($operatorio == 1) {

    $datos_operatorio = $datos_pdf['datos_operatorio'];

    // echo "<pre>";
    // print_r($datos_operatorio);
    // echo "</pre>";

    $datos_operatorio[5] = $obj->i_pdo(
      "select nombre from historias.cirugias where id_cirugia = ?",  
      [$datos_operatorio[5]], 
    true)->fetchColumn();

    $datos_operatorio[2] = date("d-m-Y", strtotime($datos_operatorio[2]));
  }
  //--------------------------------------------------
  if($amsler == 1) {

  }
  //--------------------------------------------------
  if ($prepresupuesto == 1) {

    $datos_prepresupuesto = $datos_pdf['datos_prepresupuesto'];

    $datos_prepresupuesto[1] = $obj->i_pdo(
      "select nomb_medi from historias.medicos where id_medico = ?",  
      [$datos_prepresupuesto[1]], 
    true)->fetchColumn();

    $datos_prepresupuesto[2] = $obj->i_pdo(
      "select nombre from historias.cirugias where id_cirugia = ?",  
      [$datos_prepresupuesto[2]], 
    true)->fetchColumn();

    $datos_prepresupuesto_historia = $obj->i_pdo(
      "select 
        a.id_historia, a.apel_nomb, b.nomb_medi, a.nume_cedu
      from historias.entradas a 
      left join historias.medicos b using (id_medico)
      where a.id_historia = ?",  
      [$datos_prepresupuesto[3]], 
    true)->fetch(PDO::FETCH_ASSOC);

  }
  //--------------------------------------------------
  if ($curva_presion == 1) {

    $datos_curva_presion = $datos_pdf['datos_curva_presion'];

  }
  //--------------------------------------------------
  //--------------------------------------------------
  if ($paquimetria == 1) {


    $datos_paquimetria = $datos_pdf['paquimetria'];

    $datos_paquimetria_historia = $obj->i_pdo("
      select a.apel_nomb, a.fech_naci, b.nomb_medi 
      from historias.entradas as a left join historias.medicos as b using (id_medico)
      where a.id_historia = ?", [$datos_paquimetria[8]], true)->fetch(PDO::FETCH_ASSOC);

    $edad_paquimetria = $obj->calcularEdad($datos_paquimetria_historia['fech_naci']);
    //print_r($datos_paquimetria);

  }
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


<!--
//--------------------------------------------------
//REPORTE DE ADMISION
//-------------------------------------------------- -->
<?php  if($admision == 1) {?>
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
      
      <div style="position: absolute;  top: 5mm; left: 0mm">
       <img src="../imagenes/logo_reportes.jpg" style="width: 30mm; height: 23mm;">
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
<?php } ?>


<?php if ($limpieza_lentes == 1) {?>
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
    <div id="subcabecera" class="centrar" style="font-size: 10px">
      <?php echo $_SESSION['informacion_subcabecera_reportes'];?>
    </div>

    <div style="position: absolute;  top: 5mm; left: 0mm">
       <img src="../imagenes/logo_reportes.jpg" style="width: 30mm; height: 23mm;">
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

<?php }?>

<?php if($horarios_lentes == 1) {?>
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
      <div id="subcabecera" class="centrar" style="font-size: 10px">
         <?php echo $_SESSION['informacion_subcabecera_reportes'];?>
      </div>

      <div style="position: absolute;  top: 5mm; left: 0mm">
       <img src="../imagenes/logo_reportes.jpg" style="width: 30mm; height: 23mm;">
      </div>

      <div class="separador"></div>

      <div></div>

      <div id="subcabecera" class="centrar" style="font-size: 16px;"><b>
        HORARIO PARA LENTES DE CONTACTO</b>
      </div>
      <div class="separador"></div>
   
      <div></div>
      
      <table style="border:none">
          <tbody>
            <tr>
              <td></td>
            </tr>
          </tbody>
      </table>

       <table>
        <tbody>
          <tr>
            <td  style="font-size: 14px; text-align: center; position: absolute;">1er DÍA  1 HORA  A.M. ---------: 1    HORA  P.M.</td>
          </tr>
        </tbody>
      </table>

      <table style="border:none">
          <tbody>
            <tr>
              <td></td>
            </tr>
          </tbody>
      </table>

      <table>
        <tbody>
          <tr>
            <td class="centrar" style="font-size: 14px; text-align: center">2do DÍA  2 HORAS  A.M. ------: 2    HORAS P.M.</td>
          </tr>
        </tbody>
      </table>

      <table style="border:none">
          <tbody>
            <tr>
              <td></td>
            </tr>
          </tbody>
      </table>

      <table>
        <tbody>
          <tr>
            <td class="centrar" style="font-size: 14px; text-align: center">3er DÍA  3 HORAS  A.M. ------: 3    HORAS P.M.</td>
          </tr>
        </tbody>
      </table>

      <table style="border:none">
          <tbody>
            <tr>
              <td></td>
            </tr>
          </tbody>
      </table>

      <table>
        <tbody>
          <tr>
            <td class="centrar" style="font-size: 14px; text-align: center">4to DÍA  4 HORAS  A.M. ------: 4    HORAS P.M.</td>
          </tr>
        </tbody>
      </table>

      <table style="border:none">
          <tbody>
            <tr>
              <td></td>
            </tr>
          </tbody>
      </table>

      <table>
        <tbody>
          <tr>
            <td class="centrar" style="font-size: 14px; text-align: center">5to DÍA  5 HORAS  A.M. ------: 5    HORAS P.M.</td>
          </tr>
        </tbody>
      </table>

      <table style="border:none">
          <tbody>
            <tr>
              <td></td>
            </tr>
          </tbody>
      </table>

      <table>
        <tbody>
          <tr>
            <td class="centrar" style="font-size: 14px; text-align: center">6to DÍA  6 HORAS  A.M. ------: 6    HORAS P.M.</td>
          </tr>
        </tbody>
      </table>

      <table style="border:none">
          <tbody>
            <tr>
              <td></td>
            </tr>
          </tbody>
      </table>

      <table>
        <tbody>
          <tr>
            <td class="centrar" style="font-size: 14px; text-align: center">7mo DÍA  7 HORAS  A.M. -----: 7    HORAS P.M.</td>
          </tr>
        </tbody>
      </table>

      <table style="border:none">
          <tbody>
            <tr>
              <td></td>
            </tr>
          </tbody>
      </table>

      <table>
        <tbody>
          <tr>
            <td class="centrar" style="font-size: 14px; text-align: center">8vo DÍA  8 HORAS  A.M. ------: 8    HORAS P.M.</td>
          </tr>
        </tbody>
      </table>

      <table style="border:none">
          <tbody>
            <tr>
              <td></td>
            </tr>
          </tbody>
      </table>

      <table style="margin-top: 10px; margin-left:20px; border:none;">
          <tbody>
            <tr>
              <td style=" font-size: 16px;">ASISTIR AL CONSULTORIO A LOS 8 DÍAS CON LOS LENTES PUESTOS</td>
            </tr>
          </tbody>
      </table>

      <table style="border:none">
          <tbody>
            <tr>
              <td></td>
            </tr>
          </tbody>
      </table>

      <table style="margin-top: 15px; margin-left:20px; border:none">
        <tbody>
          <tr>
            <td>N° Historia: <div style="width: fit-content"><?php echo $datos['id_historia']?></div></td>
            <td>NOMBRE: <div style="width: fit-content"><?php echo $datos['apel_nomb']?></div></td>
            <td>N°.Cédula: <div style="width: fit-content"><?php echo $datos['nume_cedu']?></div></td>
          </tr>
        </tbody>
      </table>

    </div>  
  </page>
<?php }?>

<?php if($limpieza_gas == 1) {?>

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
    <div id="subcabecera" class="centrar" style="font-size: 10px">
      <?php echo $_SESSION['informacion_subcabecera_reportes'];?>
    </div>

    <div style="position: absolute;  top: 5mm; left: 0mm">
       <img src="../imagenes/logo_reportes.jpg" style="width: 30mm; height: 23mm;">
    </div>

    <div class="separador"></div>

    <div></div>

    <div id="subcabecera" class="centrar" style="font-size: 16px;"><b>
      LIMPIEZA Y CUIDADO PARA LENTES GAS PERMEABLE Ó PMMA</b>
    </div>
    <div class="separador"></div>
 
    <div></div>
    
    <table style="margin-top: 10px; margin-left:20px; border:none">
        <tbody>
          <tr>
            <td></td>
          </tr>
        </tbody>
    </table>

    <div style="text-align: justify; font-size: 12px;">
      <div>
       * FROTAR LEVEMENTE CON SOLUCIÓN LIMPIADORA 20/20, BOSTON, O LC 65.
      </div>
      
      <div></div>
      
      <table style="margin-top: 10px; margin-left:20px; border:none">
        <tbody>
          <tr>
            <td></td>
          </tr>
        </tbody>
      </table>

      <div>
        * ENJUAGAR CON ABUNDANTE AGUA.
      </div>
    
      <div></div>  

      <table style="margin-top: 10px; margin-left:20px; border:none">
        <tbody>
          <tr>
            <td></td>
          </tr>
        </tbody>
      </table>
      
    
      <div>
        * GUARDAR EN EL ESTUCHE CON SOLUCIÓN CONSERVADORA 20/20, BOSTON O SOAC-LENS.
      </div>
    
      <div></div>
  
      <table style="margin-top: 10px; margin-left:20px; border:none">
        <tbody>
          <tr>
            <td></td>
          </tr>
        </tbody>
     </table>
    
      <div style="width: 200mm">
        * PUEDE USAR CON LOS LENTES PUESTOS UNA GOTA 3 VECES AL DÍA DE LÁGRIMAS ARTIFICIALES, CONFORMT DROPS, OPTIFRESH O ADAPETTES.
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
          <td>N° Historia: <div style="width:fit-content"><?php echo $datos['id_historia']?></div></td>
          <td>NOMBRE: <div style="width:fit-content"><?php echo $datos['apel_nomb']?></div></td>
          <td>N°.Cédula: <div style="width:fit-content"><?php echo $datos['nume_cedu']?></div></td>
        </tr>
      </tbody>
    </table>

  </div>  
</page>

<?php }?>

<?php if ($tele_torax == 1) {?>
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
    <div id="subcabecera" class="centrar" style="font-size: 10px">
      <?php echo $_SESSION['informacion_subcabecera_reportes'];?>
    </div>

    <div style="position: absolute;  top: 5mm; left: 0mm">
       <img src="../imagenes/logo_reportes.jpg" style="width: 30mm; height: 23mm;">
    </div>

    <div class="separador"></div>
  
    <div></div>
    <div></div>
    <div></div>

    <div style="width: 200mm; text-align: center">
        <h4 id="titulo1" style="">TELE TORAX PERFIL</h4>
    </div>

    <div></div>

    <div style="width: 200mm; text-align: center; margin-top: 10mm">
      <h4 id="titulo1" style="">APP Y LATERAL</h4>
    </div> 

    <div></div>
    <div></div>

    <table style="margin-top: 20px; margin-left:20px; font-size: 12px;">
      <tbody>
        <tr>
          <td>N° Historia: <div style="width:fit-content"><?php echo $datos['id_historia']?></div></td>
          <td>NOMBRE: <div style="width:fit-content"><?php echo $datos['apel_nomb']?></div></td>
          <td>N°.Cédula: <div style="width:fit-content"><?php echo $datos['nume_cedu']?></div></td>
        </tr>
      </tbody>
    </table>

  </div>  
</page>

<?php }?>

<?php if($normas_cirugia == 1) {?>
<page style="width:100%" backtop="0mm" backbottom="5mm" backleft="6mm" backright="5mm">
  <div class="contenedor">
     <div id="cabecera" style="height: 70px">
      <div style="position:relative;">
        <h4 id="titulo1" style="">CLÍNICA OFTALMOLÓGICA</h4>
        <h4 id="titulo2">DR. CASTILLO INCIARTE Y ASOCIADOS C.A</h4>
      </div> 
      <h3 id="titulo3" style="margin-top: 5px">RIF: J-30403474-1</h3>
    </div> 
    <div style="height: 10px; margin-top: 20px">
      <div style="position:relative;">
        <h4 id="titulo1" style="">NORMAS PARA PACIENTES DE CIRUGÍA</h4>
      </div> 
    </div> 

    <div style="position: absolute;  top: 5mm; left: 0mm">
       <img src="../imagenes/logo_reportes.jpg" style="width: 30mm; height: 23mm;">
      </div>
    <div class="separador"></div>

    <div style="text-align: justify; font-size: 12px;">
      <div>
      * SI TOMA ASPIRINA O ANTICOAGULANTE, PREVIA AUTORIZACIÓN DE SU MÉDICO TRATANTE, SUSPENDER DÍAS 15 ANTES DE LA CIRUGÍA.
      </div>
      <div></div>
      <div>
      * TRAER RESULTADOS DE EXAMENES PRE OPERATORIOS INDICADOS COMPLETOS, PARA PODER PROGRAMAR SU CIRUGÍA.
      </div>
      <div></div>
     <div>
      * AL SABER LA FECHA DE LA CIRUGÍA EL PACIENTE DEBE ACUDIR A LA ADMINISTRACIÓN DE LA CLÍNICA EL DÍA ANTERIOR PARA LA TRAMITACIÓN DEL PAGO RESPECTIVO, DE LO CONTRARIO SERÁ OMITIDO EL CASO.
      </div> 
    </div>
    <div></div>
    <div class="separador"></div>
    <div style="font-size: 14px">
    * CUENTAS CORRIENTES A NOMBRE DE: CLÍNICA OFTALMOLÓGICA CASTILLO INCIARTE Y ASOSIADOS C.A.
    </div>

    <div></div>      
    <div style="text-align: justify; font-size: 14px; text-align: center;"><b>PROVINCIAL: 01080361640100014630  MERCANTIL.: 01050093191093041889</b></div>
    <div style="text-align: justify; font-size: 14px; text-align: center; padding-left: 0px"><b>SOFITASA....: 01370020670000130321  TESORO.......: 01630304603043005474</b></div>
    <div></div>

    <div class="separador"></div>

    <div style="text-align: justify; font-size: 12px; margin-bottom: 0px">

      <div>
        <b>ZELLE oeci50@gmail.com A NOMBRE DE OSCAR CASTILLO INCIARTE</b>
      </div>

      <div></div>
      <div class="separador"></div>

      <div style="font-size: 17px;">* Si cancela en moneda extranjera debe realizar el pago del IGTF en Bolívares (Bs.) por TRANSFERENCIA o PAGO MÓVIL</div>

      <div class="separador"></div>
      <div></div>

      <div>
        <b>BANCOLOMBIA: AHORROS 726-28297062 A NOMBRE DE: OSCAR E. CASTILLO INCIARTE C.C: 1.126.243.925.</b>
      </div>
      <div></div>
      <div></div>

    </div>
    <div class="separador"></div>
    <div style="text-align: justify; font-size: 12px;">
      <div>
      * DEBE LLAMAR EL DÍA ANTERIOR (MARTES)  A LAS 2.30 PM PARA INDICARLE LA HORA DE SU CIRUGÍA.
      </div>
      <div></div>
      <div>
      * SI TOMA MEDICAMENTOS PARA LA HIPERTENSIÓN ARTERIAL O GLICEMÍA NO DEBE SUSPENDERLOS TOMARLOS A SU HORA CON POCA AGUA.
      </div>
      <div></div>
      <div>
      * NO  COMER NI TOMAR NINGÚN LÍQUIDO SEIS HORAS ANTES DE LA CIRUGÍA.
      </div>
      <div></div>
      <div>
      * A LAS DAMAS SE RECOMIENDA NO UTILIZAR MAQUILLAJE, NI ESMALTE DE UÑAS Y NO TRAER NINGÚN TIPO DE JOYAS.
      </div>
      <div></div>
      <div>
      * BAÑARSE BIEN EL DÍA DE LA CIRUGÍA ESPECIALMENTE EL CABELLO Y LA CARA.
      </div>
      <div></div>
      <div>
      * ES INDISPENSABLE TRAER LOS EXÁMENES PRE OPERATORIOS EL DÍA DE LA CIRUGÍA.
      </div>
      <div></div>
      <div>
      * SE RECOMIENDA VENIR CON UN SOLO ACOMPAÑANTE CUMPLIENDO LAS NORMAS DE BIOSEGURIDAD. NO QUITARSE LA MASCARILLA EN NINGÚN MOMENTO.
      </div>
      <div></div>
      <div>
      * LA CIRUGÍA INCLUYE 1 CONTROL POST OPERATORIO SIN COSTO. LOS CONTROLES SUCESIVOS SERÁN PAGOS.
      </div>
    </div style="margin-bottom: 5px">
    <div></div>
  
    <div class="separador"></div>
    
    <div id="subcabecera" class="centrar">
      A.19 de Abril Edf. Clínica de Ojos P.B. La Bermeja - San Cristóbal Edo.Táchira
    </div>
    <div id="subcabecera" class="centrar" style="font-weight: bold">
      TF: 3560133 - 3560139 - 3560141 - 3560137  FAX: 3558633
    </div>

    <div id="subcabecera" class="centrar" style="font-weight: bold">
      e-mail: clicastillo96@gmail.com
    </div>
  </div>  
</page>
<?php }?>

<?php if($normas_retina == 1) { ?>
<page style="width:100%" backtop="0mm" backbottom="5mm" backleft="6mm" backright="5mm">
  <div class="contenedor">
    <div id="cabecera" style="height: 70px">
      <div style="position:relative;">
        <h4 id="titulo1" style="">CLÍNICA OFTALMOLÓGICA</h4>
        <h4 id="titulo2">DR. CASTILLO INCIARTE Y ASOCIADOS C.A</h4>
      </div> 
      <h3 id="titulo3" style="margin-top: 5px">RIF: J-30403474-1</h3>
    </div> 
    <div style="height: 10px; margin-top: 20px">
      <div style="position:relative;">
        <h4 id="titulo1" style="">NORMAS PARA PACIENTES DE CIRUGÍA DE RETINA</h4>
      </div> 
    </div> 
    <div style="position: absolute;  top: 5mm; left: 0mm">
     <img src="../imagenes/logo_reportes.jpg" style="width: 30mm; height: 23mm;">
    </div>
    <div class="separador"  style="margin-bottom: 5px"></div>

      <div style="text-align: justify; font-size: 12px;">
        <div>
        * SI TOMA ASPIRINA O ANTICOAGULANTE, PREVIA AUTORIZACIÓN DE SU MÉDICO TRATANTE, SUSPENDER 15 DÍAS ANTES DE LA CIRUGÍA.
        </div>
        <div></div>
        <div>
        * TRAER RESULTADOS DE EXÁMENES PRE OPERATORIOS INDICADOS COMPLETOS, PARA PODER PROGRAMAR SU CIRUGÍA.
        </div>
        <div></div>
        <div>
        * AL SABER LA FECHA DE LA CIRUGÍA EL PACIENTE DEBE ACUDIR A LA ADMINISTRACIÓN DE LA CLINÍCA EL DÍA ANTERIOR PARA LA TRAMITACIÓN DEL PAGO  RESPECTIVO, DE  LO CONTRARIO SERÁ OMITIDO EL CASO.
        </div>
        <div></div>

        <div class="separador"  style="margin-bottom: 15px"></div>
        <div  style="margin-bottom: 5px; font-size: 14px">
         * CUENTAS CORRIENTES A NOMBRE DE CLÍNICA OFTALMOLÓGICA CASTILLO INCIARTE Y ASOCIADOS, C.A.
        </div>

        <div></div>      
        <div style="text-align: justify; font-size: 14px; text-align: center;"><b>PROVINCIAL: 01080361640100014630  MERCANTIL.: 01050093191093041889</b></div>
        <div style="text-align: justify; font-size: 14px; text-align: center; padding-left: 0px"><b>SOFITASA....: 01370020670000130321  TESORO.......: 01630304603043005474</b></div>
        <div></div>
      </div>
      <div></div>

      <div class="separador"></div>

      <div style="text-align: justify; font-size: 12px; margin-bottom: 0px">
        <div>
          <b>ZELLE oeci50@gmail.com A NOMBRE DE OSCAR CASTILLO INCIARTE</b>
        </div>

        <div></div>
        <div class="separador"></div>

        <div style="font-size: 17px;">* Si cancela en moneda extranjera debe realizar el pago del IGTF en Bolívares (Bs.) por TRANSFERENCIA o PAGO MÓVIL</div>

        <div class="separador"></div>
        <div></div>

        <div>
          <b>BANCOLOMBIA: AHORROS 726-28297062 A NOMBRE DE: OSCAR E. CASTILLO INCIARTE C.C: 1.126.243.925.</b>
        </div>
        <div></div>
        <div class="separador"></div>
      </div>

      <div style="text-align: justify; font-size: 12px; margin-top:5px">
        <div>
        * DEBE LLAMAR EL DÍA MARTES A LAS 2:30 PM PARA INDICARLE LA HORA DE LA CIRUGÍA.
        </div>
        <div></div>
        <div>
        * SI TOMA MEDICAMENTOS PARA LA HIPERTENSIÓN ARTERIAL O GLICEMIA NO DEBE SUSPENDERLOS DEBE TOMARLOS A SU HORA CON POCA AGUA.
        </div>
        <div></div>
        <div style="margin-bottom: 5px">
        * NO COMER NI TOMAR NINGÍN LÍQUIDO SEIS HORAS ANTES DE LA CIRUGÍA..
        </div>
      </div>
    <div class="separador"></div>
    
    <div id="subcabecera" class="centrar"  style="margin-top: 20px;">
      A.19 de Abril Edf. Clínica de Ojos P.B. La Bermeja - San Cristóbal Edo.Táchira. VENEZUELA.
    </div>
    <div id="subcabecera" class="centrar" style="font-weight: bold">
      TF: 3560133 - 3560139 - 3560141 - 3560137  FAX: 0276-3558633
    </div>
    <div id="subcabecera" class="centrar" style="font-weight: bold">
      e-mail: clicastillo96@gmail.com
    </div>
  </div>  
</page>

<?php }?>

<?php if ($normas_laser == 1) {?>
<page style="width:100%" backtop="0mm" backbottom="5mm" backleft="6mm" backright="5mm">
  <div class="contenedor">
     <div id="cabecera" style="height: 70px">
      <div style="position:relative;">
        <h4 id="titulo1" style="">CLÍNICA OFTALMOLÓGICA</h4>
        <h4 id="titulo2">DR. CASTILLO INCIARTE Y ASOCIADOS C.A</h4>
      </div> 
      <h3 id="titulo3" style="margin-top: 5px">RIF: J-30403474-1</h3>
    </div> 
    <div style="height: 10px; margin-top: 20px">
      <div style="position:relative;">
        <h4 id="titulo1" style="">NORMAS PARA LA APLICACIÓN DE RAYOS LASER</h4>
      </div> 
    </div>

    <div style="position: absolute;  top: 5mm; left: 0mm; height: 0px;">
     <img src="../imagenes/logo_reportes.jpg" style="width: 30mm; height: 23mm;">
    </div>
    <div class="separador"></div>

    <div style="text-align: justify; font-size: 12px;">
      <div>
      * * DEBE SOLICITAR SU CITA PARA RAYOS LASER  A LOS NÚMEROS TELEFÓNICOS:
      </div>
      <div></div>
      <div>
      0276-3560139 - 3560141 - 3560237 - 04247498952
      </div>
      <div></div>
     <div>
      *  EL DÍA DE LA APLICACIÓN PUEDE COMER NORMAL.
      </div> 
      <div></div>
      <div style="margin-bottom:5px">
      * SE RECOMIENDA VENIR ACOMPAÑADOS Y TRAER LENTES OSCUROS.
      </div> 
    </div>

    <div class="separador"></div>
    <div style="font-size: 14px">
    * PAGOS VIA TRANSFERENCIA BANCARIA A LOS SIGUIENTES BANCOS.
    </div>

    <div></div>      
    <div style="text-align: justify; font-size: 14px; text-align: center;"><b>PROVINCIAL: 01080361640100014630  MERCANTIL.: 01050093191093041889</b></div>
    <div style="text-align: justify; font-size: 14px; text-align: center; padding-left: 0px"><b>SOFITASA....: 01370020670000130321  TESORO.......: 01630304603043005474</b></div>
    <div></div>
    <div class="separador"></div>

    <div class="separador"></div>

      <div style="text-align: justify; font-size: 12px; margin-bottom: 0px">
        <div>
          <b>ZELLE oeci50@gmail.com A NOMBRE DE OSCAR CASTILLO INCIARTE</b>
        </div>

        <div></div>
        <div class="separador"></div>

        <div style="font-size: 17px;">* Si cancela en moneda extranjera debe realizar el pago del IGTF en Bolívares (Bs.) por TRANSFERENCIA o PAGO MÓVIL</div>

        <div class="separador"></div>
        <div></div>

        <div>
          <b>BANCOLOMBIA: AHORROS 726-28297062 A NOMBRE DE: OSCAR E. CASTILLO INCIARTE C.C: 1.126.243.925.</b>
        </div>
        <div></div>
        <div class="separador"></div>
      </div>
  
    <div></div>
    
    <div id="subcabecera" class="centrar">
      A.19 de Abril Edf. Clínica de Ojos P.B. La Bermeja - San Cristóbal Edo.Táchira
    </div>
    <div id="subcabecera" class="centrar" style="font-weight: bold">
      TF: 3560133 - 3560139 - 3560141 - 3560137  FAX: 3558633
    </div>

    <div id="subcabecera" class="centrar" style="font-weight: bold;">
       e-mail: clicastillo96@gmail.com
    </div>
  </div>  
</page>
<?php }?>

<!--//--------------------------------------------------
//REPORTE DE CONSTANCIA
//-------------------------------------------------- -->
<?php  if($constancia == 1) {?>
<page style="width: 100%" backtop="1mm" backbottom="5mm" backleft="5mm" backright="5mm">
  <div class="contenedor">
    <div id="cabecera" style="height: 70px; width: 200mm">
      <div style="position:relative;">
        <h4 id="titulo1" style="">CLÍNICA OFTALMOLÓGICA</h4>
        <h4 id="titulo2">DR. CASTILLO INCIARTE Y ASOCIADOS C.A</h4>
      </div> 
      <h3 id="titulo3">Enfermedades Oculares, Retina, Glaucoma, Lentes Intraoculares</h3>
      <h3 id="titulo4">Rayos Laser, Ecografía</h3>
    </div> 
    <div class="separador imprimir-separar"></div>
    <div id="subcabecera" class="centrar" style="font-size: 10px; width: 200mm">
      <?php echo $_SESSION['informacion_subcabecera_reportes'];?>
    </div>

    <div style="position: absolute;  top: 5mm; left: 0mm">
       <img src="../imagenes/logo_reportes.jpg" style="width: 30mm; height: 23mm;">
    </div>

    <div class="separador" id="separador"></div>
    <table style="margin-bottom: 5mm; border:none">
      <tbody>
        <tr>
          <td style="width: 165mm; text-align: center;"><div style="width:fit-content; border-bottom: 2px dashed #ccc; font-size: 16px">CONSTANCIA</div></td>
        </tr>
      </tbody>
    </table>  

    <table style="border:none">
      <tbody>
        <tr>
          <td style="width: 170mm; text-align: left">SE HACE CONSTANCIA QUE EL PACIENTE: <div class="unbold" style="bottom: 5px"><?php echo $datos_constancia[1]." [N° Historia: ".$datos_constancia[0]."]"?></div></td>
        </tr> 
      </tbody>    
    </table>

    <table style="border:none">
      <tbody>
        <tr>
          <td style="width: 170mm; text-align: left">CON CÉDULA DE IDENTIDAD NÚMERO: <div class="unbold"><?php echo $datos_constancia[2]?></div></td>
        </tr> 
      </tbody>    
    </table>

    <table style="border:none">
      <tbody>
        <tr>
          <td style="width: 170mm; text-align: left">ASISTIÓ A CONSULTA EN (DD/MM/AAAA): <div class="unbold"><?php echo $datos_constancia[3]?></div></td>
        </tr> 
      </tbody>    
    </table>

   <table style="position: absolute; top: 90mm; left: 0mm">
      <tbody>
        <tr>
          <td>FECHA:<?php echo $dia?></td>
        </tr> 
      </tbody>    
    </table>
  </div>  
</page>
<?php }?>

<?php if ($acompanante == 1) {?>

<page style="width:100%" backtop="0mm" backbottom="5mm" backleft="6mm" backright="5mm">
  <div class="contenedor">
    <div id="cabecera" style="height: 70px; width: 200mm">
      <div style="position:relative;">
        <h4 id="titulo1" style="">CLÍNICA OFTALMOLÓGICA</h4>
        <h4 id="titulo2">DR. CASTILLO INCIARTE Y ASOCIADOS C.A</h4>
      </div> 
      <h3 id="titulo3">Enfermedades Oculares, Retina, Glaucoma, Lentes Intraoculares</h3>
      <h3 id="titulo4">Rayos Laser, Ecografía</h3>
    </div> 
    <div class="separador imprimir-separar"></div>
    <div id="subcabecera" class="centrar" style="font-size: 10px; width: 200mm">
      <?php echo $_SESSION['informacion_subcabecera_reportes'];?>
    </div>

    <div style="position: absolute;  top: 5mm; left: 0mm">
       <img src="../imagenes/logo_reportes.jpg" style="width: 30mm; height: 23mm;">
    </div>

    <div class="separador" id="separador"></div>

    <div style="position:relative;width: 170mm; text-align: center; left:-70px; margin-bottom: 30px; margin-top: 10px">
      <div style="width:fit-content; border-bottom: 2px dashed #ccc; font-size: 16px; font-weight: bold">CONSTANCIA DE ACOMPAÑANTE</div>
    </div>

    <table style="border:none">
      <tbody>
        <tr>
          <td style="width: 170mm; text-align: left">SE HACE CONSTANCIA QUE EL PACIENTE: <div class="unbold" style="bottom: 5px"><?php echo $datos['apel_nomb']." [N° Historia: ".$datos['id_historia']."]"?></div></td>
        </tr> 
      </tbody>    
    </table>

    <table style="border:none">
      <tbody>
        <tr>
          <td style="width: 170mm; text-align: left">CON CÉDULA DE IDENTIDAD NÚMERO: <div class="unbold"><?php echo $datos['nume_cedu']?></div></td>
        </tr> 
      </tbody>    
    </table>

    <table style="border:none">
      <tbody>
        <tr>
          <td style="width: 170mm; text-align: left">ASISTIÓ A CONSULTA EN (DD/MM/AAAA): <div class="unbold"><?php echo $fecha_aco?> acompañado de: <?php echo $nombre_aco?></div></td>
        </tr> 
      </tbody>    
    </table>

    <table style="border:none">
      <tbody>
        <tr>
          <td style="width: 170mm; text-align: left">CÉDULA ACOMPAÑANTE: <?php echo $cedu_aco?></td>
        </tr> 
      </tbody>    
    </table>

   <table style="position: absolute; top: 90mm; left: 0mm">
      <tbody>
        <tr>
          <td>FECHA:<?php echo $dia?></td>
        </tr> 
      </tbody>    
    </table>
  </div>  
</page>

<?php }?>

<!--
//--------------------------------------------------
//REPORTE VIAL
//-------------------------------------------------- -->
<?php  if($vial == 1) {?>

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
    <div id="subcabecera" class="centrar" style="font-size: 10px">
      <?php echo $_SESSION['informacion_subcabecera_reportes'];?>
    </div>
    <div class="separador"></div>

    <div style="position: absolute;  top: 5mm; left: 0mm">
      <img src="../imagenes/logo_reportes.jpg" style="width: 30mm; height: 23mm;">
    </div>

    <table style="margin-bottom: 5mm; border:none; position:relative; left: -50px;">
      <tbody>
        <tr>
          <td style="width: 155mm; text-align: center;"><div style="width:fit-content; border-bottom: 2px dashed #ccc; font-size: 16px">INFORME PARA MEDICINA VIAL</div></td>
        </tr>
      </tbody>
    </table>

    <table class="tabla tabla-formulas2" style="margin-top: -10px">
      <tbody>
        <tr>
          <td style="width:fit-content">Agudeza Visual&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;S/C&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;OD:</td>
          <td style="width:20px; padding-rigth: 30px"><?php echo $datos_vial[0]?></td>
          <td style="padding-left: 30px;">C/C  OD:</td>
          <td style="width:10px"><?php echo $datos_vial[2]?></td>
        </tr>
        <tr>
          <td style="width:100px; text-align: right;">OI:</td>
          <td style="width:20px; padding-rigth: 30px"><?php echo $datos_vial[1]?></td>
          <td style="padding-left: 30px; text-align: right;">OI:</td>
          <td style="width:10px"><?php echo $datos_vial[3]?></td>
        </tr>
      </tbody>
    </table>

    <table class="tabla" style="margin-top: 10px">
      <tbody>
        <tr style="height: 10px;">
          <td>Presión Ocular OD:</td>
          <td style="width:80px;"><?php echo $datos_vial[4]?> &nbsp;&nbsp; &nbsp; <b>mmHg</b></td>
          <td>Presión Ocular OI:</td>
          <td style="width:100px"><?php echo $datos_vial[5]?> &nbsp;&nbsp; <b>mmHg</b></td>
        </tr>
      </tbody>
    </table>


    <table class="tabla tabla-formulas2" style="margin-top: 10px">
      <tbody>
        <tr>
          <td >Colores:</td>
          <td style="text-align: left"><?php echo strtoupper($datos_vial[9])?></td>
          <td style="padding-left: 30px;">Fondo de ojo:</td>
          <td style="text-align: left"><?php echo strtoupper($datos_vial[6])."&nbsp;".strtoupper($datos_vial[7])."&nbsp;".strtoupper($datos_vial[8])?></td>
        </tr>
      </tbody>
    </table>

    <table class="tabla tabla-formulas2" style="margin-top: 10px">
      <tbody>
        <tr>
          <td>Campo Visual Confrontación:</td>
          <td><?php echo strtoupper($datos_vial[10])?></td>
        </tr>
      </tbody>
    </table>

    <table class="tabla tabla-formulas2" style="margin-top: 10px">
      <tbody>
        <tr>
          <td>Observaciones:</td>
          <td><?php echo strtoupper($datos_vial[11])?></td>
        </tr>
      </tbody>
    </table>

    <table style="margin-top: 30px; margin-left:30px">
      <tbody>
        <tr>
          <td>N° Historia: <div class="small"><?php echo $datos['id_historia']?></div></td>
          <td>NOMBRE: <div class="small"><?php echo $datos['apel_nomb']?></div></td>
          <td>N°.Cédula: <div class="small"><?php echo $datos['nume_cedu']?></div></td>
        </tr>
      </tbody>
    </table>
    
    <div class="fecha">
      Fecha: <?php echo $dia?>
    </div>

  </div>  
</page>

<?php }?>

<!-- //--------------------------------------------------
//REPORTE DE CONSTANCIA POST OPERATORIA
//----------------------------------------------------> 
<?php  if($operatorio == 1) {?>
<page style="width: 100%" backtop="1mm" backbottom="5mm" backleft="5mm" backright="5mm">
  <div class="contenedor">
    <div id="cabecera" style="height: 70px; width: 200mm">
      <div style="position:relative;">
        <h4 id="titulo1" style="">CLÍNICA OFTALMOLÓGICA</h4>
        <h4 id="titulo2">DR. CASTILLO INCIARTE Y ASOCIADOS C.A</h4>
      </div> 
      <h3 id="titulo3">Enfermedades Oculares, Retina, Glaucoma, Lentes Intraoculares</h3>
      <h3 id="titulo4">Rayos Laser, Ecografía</h3>
    </div> 
    <div class="separador imprimir-separar"></div>
    <div id="subcabecera" class="centrar" style="font-size: 10px">
      <?php echo $_SESSION['informacion_subcabecera_reportes'];?>
    </div>

    <div style="position: absolute;  top: 5mm; left: 0mm">
       <img src="../imagenes/logo_reportes.jpg" style="width: 30mm; height: 23mm;">
    </div>

    <div class="separador" id="separador"></div>
    <table style="margin-bottom: 5mm; border:none">
      <tbody>
        <tr>
          <td style="width: 165mm; text-align: center;"><div style="width:fit-content; border-bottom: 2px dashed #ccc; font-size: 16px">CONSTANCIA</div></td>
        </tr>
      </tbody>
    </table>  

    <table style="border:none">
      <tbody>
        <tr>
          <td style="text-align: left; font-weight: 100px; font-size: 15px; width: 200mm">SE HACE CONSTANCIA QUE EL PACIENTE:&nbsp;
            <b><?php echo $datos_operatorio[0]." [N° Historia: ".$datos_operatorio[10]."]"?></b>
            &nbsp;&nbsp;CON CÉDULA DE IDENTIDAD NÚMERO:&nbsp;
            <b><?php echo $datos_operatorio[1]?>.</b>
          </td>
        </tr> 
      </tbody>    
    </table>

    <table style="border:none">
      <tbody>
        <tr>
          <td style="text-align: left; font-weight: 100px;font-size: 15px; width: 200mm">FUE INTERVENIDO DE:&nbsp;
            <b><?php echo strtoupper($datos_operatorio[5])?></b>, EL DÍA <b><?php echo $datos_operatorio[2]?> (DD/MM/AAAA).</b>
          </td>
        </tr> 
      </tbody>    
    </table>

    <table style="border:none; width: 200mm">
      <tbody>
        <tr>
          <td style="text-align: left; font-weight: 100 !important;font-size: 15px; width: 200mm">POR LO QUE AMERITA LOS CUIDADOS POST OPERATORIOS DE: <b><?php echo strtoupper($datos_operatorio[3])?></b> CON N° DE CÉDULA: <b><?php echo strtoupper($datos_operatorio[4])?>&nbsp;&nbsp;</b>DURANTE: <b><?php echo strtoupper($datos_operatorio[7])?></b> DÍAS, HASTA EL <b><?php echo strtoupper($datos_operatorio[9])?>.</b></td>
        </tr> 
      </tbody>    
    </table>

   <table style="position: relative; margin-top: 20px; left: 0mm;font-size: 15px;">
      <tbody>
        <tr>
          <td>FECHA:<?php echo $dia?></td>
        </tr> 
      </tbody>    
    </table>
  </div>  
</page>
<?php }?>

<!----------------------------------------------------
//REPORTE AMSLER
//--------------------------------------------------->
<?php  if($amsler == 1) {?>
<style>

</style>

<page style="width:100%" backtop="0mm" backbottom="5mm" backleft="6mm" backright="5mm">
  <div class="contenedor">

    <div style="position: absolute;  top: 5mm; left: 0mm">
       <img src="../imagenes/logo_reportes_nuevo.jpg" style="width: 30mm; height: 23mm;">
    </div>

    <div id="cabecera" style="height: 70px; position: relative; top: 10mm; left: -15mm">
      <h4 id="titulo1" style="top: unset; position: relative;">CLÍNICA OFTALMOLÓGICA</h4>
      <h4 id="titulo2" style="top: unset; position: relative;">DR. CASTILLO INCIARTE Y ASOCIADOS C.A</h4> 
      <h3 id="titulo3" style="position: relative;top: unset;">Enfermedades Oculares, Retina, Glaucoma, Lentes Intraoculares</h3>
      <h3 id="titulo4" style="position: relative;top: unset;">Rayos Laser, Ecografía</h3>
    </div> 

    <div class="separador imprimir-separar"></div>
    <div id="subcabecera" class="centrar" style="font-size: 10px; position: relative; left: -15mm">
     <?php echo $_SESSION['informacion_subcabecera_reportes'];?>
    </div>

    <div class="separador" id="separador"></div>

    <div style="font-size: 12px">
      Tápese un ojo y enfoque el punto en el centro de la retícula.
    </div>

    <div style="font-size: 12px">
      Hágase las siguientes pruebas:
    </div>
    
    <div></div>
    
    <div style="font-size: 12px ;position: relative; top: -20px; left: -10px">
      <ul>
        <li>
          ¿Me es posible ver las esquinas y lados del cuadro?
        </li>
        <li>
          ¿Veo alguna línea curveada?
        </li>
        <li>
          ¿Hay hoyos o áreas faltante en la retícula?
        </li>
      </ul> 
    </div>

    <div></div>

    <div style="font-size: 12px; position: relative; top: -10px">
      En caso de que no vea rectas las lineas de la retícula o que haya áreas faltantes o distorsionadas, infórmeselo a su oftalmólogo.
    </div>

    <div style="position: relative; top: 15px; left: 35mm">
       <img src="../imagenes/amsler1.jpg" style="width: 128mm; height: 128mm">
    </div>

    <div></div>

    <table style="border: 1px solid #262626; border-radius: 10px; padding: 0px; position:relative; left: 30px; top: 13px;">
      <thead>
        <tr>
          <th style="width: 170mm">Anotaciones</th>
        </tr>
      </thead>

      <tbody>
        <tr><td style="padding: 9px 10px;border-bottom: 0.5px solid #262626; padding:3px;"></td></tr>
        <tr><td style="padding: 9px 10px;border-bottom: 0.5px solid #262626"></td></tr>
        <tr><td style="padding: 9px 10px;border-bottom: 0.5px solid #262626"></td></tr>
        <tr><td style="padding: 9px 10px;border-bottom: 0.5px solid #262626"></td></tr>
        <tr><td style="padding: 9px 10px;border-bottom: 0.5px solid #262626"></td></tr>
        <tr><td style="padding: 9px 10px;border-bottom: 0.5px solid #262626"></td></tr>
        <tr><td style="padding: 9px 10px;border-bottom: 0.5px solid #262626"></td></tr>
        <tr><td style="padding: 9px 10px;"></td></tr>
      </tbody>
    </table>

  </div>  
</page>
<?php }?>

<!----------------------------------------------------
//PRE PRESUPUESTO
//--------------------------------------------------->
<?php 
  if ($prepresupuesto == 1) {
?>

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
    <div id="subcabecera" class="centrar" style="font-size: 10px">
      <?php echo $_SESSION['informacion_subcabecera_reportes'];?>
    </div>

    <div style="position: absolute;  top: 5mm; left: 0mm">
       <img src="../imagenes/logo_reportes.jpg" style="width: 30mm; height: 23mm;">
    </div>

    <div class="separador"></div>
  
    <div></div>

    <div style="width: 200mm; text-align: center">
        <h4 id="titulo1" style="text-decoration: underline;">PRESUPUESTO</h4>
    </div>

    <div></div>

    <div style="margin-left: 25mm;width: 140mm; text-align: justify; min-height: 60mm; font-size: 13px; white-space:pre-wrap;">
      
      <div><b>HISTORIA:</b> <?php echo $datos_prepresupuesto_historia['id_historia'];?> &nbsp;&nbsp;&nbsp;&nbsp;<b>N° DE CÉDULA:&nbsp;</b><?php echo $datos_prepresupuesto_historia['nume_cedu'];?></div>
      <div><b>MÉDICO:</b> <?php echo $datos_prepresupuesto[1];?></div>
      <div><b>PACIENTE:</b> <?php echo $datos_prepresupuesto_historia['apel_nomb'];?></div>
      <div><b>DIAGNÓSTICO:</b> <?php echo $datos_prepresupuesto[2];?></div>
      <div><b>RESPONSABLE:</b> PARTICULAR</div>
      <div>*****************************************************************************</div>
      <div><b>TOTAL PRESUPUESTO:</b> <?php echo $datos_prepresupuesto[0];?>$ O EL EQUIVALENTE EN BS AL TIPO DE CAMBIO DEL BANCO CENTRAL DE VENEZUELA</div>
      <div><b>NOTA:</b> ESTE PRESUPUESTO TIENE UNA VALIDEZ DE 48 HORAS</div>

      <div></div>

      <div>LA ADMINISTRACIÓN</div>

      <div style="position: relative; text-align: right; width: 100%; top: 20px; font-size: 14px; right: -65px">
        Fecha: <?php echo $dia?>
      </div>

    </div>



  </div>  
</page>
<?php 
  }
?>

<!----------------------------------------------------
//CURVA BASE
//--------------------------------------------------->
<?php if ($curva_presion == 1) {?>

  <style type="text/css">
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
  </style>

  <page style="width:100%" backtop="10mm" backbottom="5mm" backleft="6mm" backright="5mm">
  <div class="contenedor">
  
    <div style="position: absolute;  top: 5mm; left: 0mm">
       <img src="../imagenes/logo_reportes_nuevo.jpg" style="width: 30mm; height: 23mm;">
    </div>

    <div id="cabecera" style="height: 70px; position: relative; top: 0mm; left: 0mm">
      <h4 id="titulo1" style="top: unset; position: relative;">CLÍNICA OFTALMOLÓGICA</h4>
      <h4 id="titulo2" style="top: unset; position: relative;">DR. CASTILLO INCIARTE Y ASOCIADOS C.A</h4> 
      <h3 id="titulo3" style="position: relative;top: unset;">Enfermedades Oculares, Retina, Glaucoma, Lentes Intraoculares</h3>
      <h3 id="titulo4" style="position: relative;top: unset;">Rayos Laser, Ecografía</h3>
    </div> 

    <div class="separador"></div>

    <div id="subcabecera" class="centrar" style="font-size: 10px; position: relative; left: 0mm">
     <?php echo $_SESSION['informacion_subcabecera_reportes'];?>
    </div>

    <div class="separador"></div>
  
    <div></div>

    <div style="width: 200mm; text-align: center">
        <h4 id="titulo1">RESULTADO CURVA DE PRESIÓN</h4>
    </div>

    <div style="margin-bottom: 5px"></div>

    <div class="separador" style="margin-bottom: 10px"></div>

    <div></div>

    <table style="width: 200mm; position: relative; top: -10px; font-size: 16px; left: 46mm">
      <thead>
        <tr style="border: 1px solid #262626">
          <th style="text-align:center; border-bottom: 1px dotted #262626;">HORA</th>
          <th style="text-align:center; border-bottom: 1px dotted #262626;">OD</th>
          <th style="text-align:center; border-bottom: 1px dotted #262626;">OI</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td style="width: 20mm; text-align: center">
            <?php 
              $hora = date('h:i a', strtotime($datos_curva_presion['0']));
              echo $hora;
            ?>
          </td>
          <td style="width: 35mm; text-align: center"><?php echo $datos_curva_presion['4']?> mmHg</td>
          <td style="width: 35mm; text-align: center"><?php echo $datos_curva_presion['8']?> mmHg</td>
        </tr>
        <tr>
          <td style="width: 20mm; text-align: center">
            <?php 
              $hora = date('h:i a', strtotime($datos_curva_presion['1']));
              echo $hora;
            ?>
          </td>
          <td style="width: 35mm; text-align: center"><?php echo $datos_curva_presion['5']?> mmHg</td>
          <td style="width: 35mm; text-align: center"><?php echo $datos_curva_presion['9']?> mmHg</td>
        </tr>
        <tr>
          <td style="width: 20mm; text-align: center">
            <?php 
              $hora = date('h:i a', strtotime($datos_curva_presion['2']));
              echo $hora;
            ?>
          </td>
          <td style="width: 35mm; text-align: center"><?php echo $datos_curva_presion['6']?> mmHg</td>
          <td style="width: 35mm; text-align: center"><?php echo $datos_curva_presion['10']?> mmHg</td>
        </tr>
        <tr>
          <td style="width: 20mm; text-align: center">
            <?php 
              $hora = date('h:i a', strtotime($datos_curva_presion['3']));
              echo $hora;
            ?>
          </td>
          <td style="width: 35mm; text-align: center"><?php echo $datos_curva_presion['7']?> mmHg</td>
          <td style="width: 35mm; text-align: center"><?php echo $datos_curva_presion['11']?> mmHg</td>
        </tr>
      </tbody>
    </table>

    <div></div>
    <div></div>

    <div style="color: #808080; text-align: center">_____________________________________________________</div>

    <div></div>

    <div class="separador" style="margin-top: 10px"></div>

  </div>  
</page>

<?php 
  }
?>

<!----------------------------------------------------
//PAQUIMETRIA
//--------------------------------------------------->
<?php if ($paquimetria == 1) {?>

  <style type="text/css">
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
  </style>

  <page style="width:100%" backtop="10mm" backbottom="5mm" backleft="6mm" backright="5mm">
  <div class="contenedor">
  
    <div style="position: absolute;  top: 5mm; left: 0mm">
       <img src="../imagenes/logo_reportes_nuevo.jpg" style="width: 30mm; height: 23mm;">
    </div>

    <div id="cabecera" style="height: 70px; position: relative; top: 0mm; left: 0mm">
      <h4 id="titulo1" style="top: unset; position: relative;">CLÍNICA OFTALMOLÓGICA</h4>
      <h4 id="titulo2" style="top: unset; position: relative;">DR. CASTILLO INCIARTE Y ASOCIADOS C.A</h4> 
      <h3 id="titulo3" style="position: relative;top: unset;">Enfermedades Oculares, Retina, Glaucoma, Lentes Intraoculares</h3>
      <h3 id="titulo4" style="position: relative;top: unset;">Rayos Laser, Ecografía</h3>
    </div> 

    <div class="separador"></div>

    <div id="subcabecera" class="centrar" style="font-size: 10px; position: relative; left: 0mm">
     <?php echo $_SESSION['informacion_subcabecera_reportes'];?>
    </div>

    <div class="separador"></div>
  
    <div></div>

    <div style="width: 200mm; text-align: center">
        <h4 id="titulo1" style="text-decoration: underline;">RESULTADO DE PAQUIMETRÍA</h4>
    </div>

    <?php 

      // echo "<pre>";
      // print_r($datos_paquimetria);
      // echo "</pre>";

      $p_od_medida = $datos_paquimetria[0];
      $p_oi_medida = $datos_paquimetria[4];

      $p_od_operac = $datos_paquimetria[3];
      $p_oi_operac = $datos_paquimetria[7];

      if ($datos_paquimetria[1] == 'X') {

        $p_od_signo = '+';
        $p_od_desc  = 'SE LE SUMA';

      } else if ($datos_paquimetria[2] == 'X') {

        $p_od_signo = '-';
        $p_od_desc  = 'SE LE RESTA';

      } else {

        $p_od_signo = '';
        $p_od_desc  = '';

      };

      if ($datos_paquimetria[5] == 'X') {

        $p_oi_signo = '+';
        $p_oi_desc  = 'SE LE SUMA';

      } else if ($datos_paquimetria[6] == 'X') {

        $p_oi_signo = '-';
        $p_oi_desc = 'SE LE RESTA';

      } else {

        $p_oi_signo = '';
        $p_oi_desc = '';

      };

      $datos_paquimetria_historia

    ?>

    <div style="margin-bottom: 5px"></div>

    <div></div>

    <div style="left: 28mm; position: relative;">
      <b>PACIENTE:</b> <?php echo strtoupper($datos_paquimetria_historia['apel_nomb'])?> DE <?php echo $edad_paquimetria?> AÑOS DE EDAD
    </div>

    <div></div>

    <table style="width: 200mm; position: relative; top: -10px; font-size: 16px; left: 28mm">
      <thead>
        <tr style="border: 1px solid #262626">
          <th style="text-align:center; border-bottom: 1px dotted #262626;"></th>
          <th style="text-align:center; border-bottom: 1px dotted #262626;"></th>
          <th style="text-align:center; border-bottom: 1px dotted #262626;"></th>
          <th style="text-align:center; border-bottom: 1px dotted #262626;"></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td style="width: 20mm; text-align: center">
            OD
          </td>
          <td style="width: 35mm; text-align: center"><?php echo $p_od_medida?></td>
          <td style="width: 35mm; text-align: center"><?php echo $p_od_desc?></td>
          <td style="width: 35mm; text-align: center"><?php echo $p_od_signo.$p_od_operac?></td>
          
        </tr>

        <tr>
          <td style="width: 20mm; text-align: center">
            OI
          </td>
          <td style="width: 35mm; text-align: center"><?php echo $p_oi_medida?></td>
          <td style="width: 35mm; text-align: center"><?php echo $p_oi_desc?></td>
          <td style="width: 35mm; text-align: center"><?php echo $p_oi_signo.$p_oi_operac?></td>
          
        </tr>
        
      </tbody>
    </table>

    <div></div>


    <div style="left: 28mm; position: relative;">ATENTAMENTE</div>
    <div style="left: 28mm; position: relative;"><b><?php echo strtoupper($datos_paquimetria_historia['nomb_medi'])?></b></div>

  </div>  
</page>

<?php 
  }
?>

<?php
  //----------------------------------------------------------
  //GENERADOR GENERAL
  //----------------------------------------------------------
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