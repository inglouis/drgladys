<style type="text/css">
	#exalab-contenedor table tbody tr td, table thead tr th {
		text-align: left;
		padding: 0px 5px;
		font-weight: bold;
	}

	#exalab-contenedor .centro {
		text-align: left;
		font-size: 14px;
		width: 100%;
	}

	#exalab-contenedor .tabla {
		margin-left: 50px;
	}

	#exalab-contenedor table {
		width:100%;
		color: #202020;
		border-bottom: 1px solid #ccc;
		border-left: 1px dashed #ccc;
		font-size: 11px;
	}

	#exalab-contenedor table thead, table tbody, table tbody tr, table thead tr {
		width: 300px;
	}

	#exalab-contenedor table tbody tr td, table thead tr th {
		text-align: left;
		padding: 3px 5px;
		font-weight: bold;
	}

	#exalab-contenedor .derecha {
		text-align: right !important;
	}

	#exalab-contenedor .small {
		font-size: 9.5px;
		padding-top: 1px;
		width: fit-content;
	}

	#exalab-contenedor .subtitulo {
		font-size: 12px;
		font-weight: bold;
		margin-left: 50px;
		padding-top:10px;
	}

	#exalab-contenedor .fecha {
		position: absolute; 
		bottom: 5px; 
		right: 30px; 
		font-size: 15px;
	}
</style>

<page style="width: 200mm" backtop="0mm" backbottom="5mm" backleft="6mm" backright="5mm">
  <div class="contenedor" id="exalab-contenedor" style="position: relative; top: -10px">
    <div id="cabecera" style="height: 50px">
      <div style="position:relative;">
        <h4 id="titulo1"  style="position: relative; top: 40px">CLÍNICA OFTALMOLÓGICA</h4>
        <h4 id="titulo2"  style="position: relative; top: 0px">DR. CASTILLO INCIARTE Y ASOCIADOS C.A</h4>
      </div> 
      <h3 id="titulo3" style="">Enfermedades Oculares, Retina, Glaucoma, Lentes Intraoculares</h3>
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

    <div class="subtitulo" style="margin-bottom: 10px; width:170mm">
      <h4 id="titulo1" style="">EXAMENES DE LABORATORIO</h4>
    </div>

    <table style="border-bottom: 1px solid #ccc; border: none; margin-left: 60px; position: relative; top: -10px">
      <tbody>
        <tr>
          <td style="width:fit-content;">Hb</td>
          <td style="width: 69mm; text-align:right; border-bottom: 1px solid #ccc; border-bottom: 1px solid #ccc"><?php echo $examen_lab[0]?></td>
          <td style="width:fit-conten;">Hc</td>
          <td style="width: 75mm; text-align:right; border-bottom: 1px solid #ccc; border-bottom: 1px solid #ccc"><?php echo $examen_lab[1]?></td>
        </tr>
      </tbody>
    </table>

    <table style="border-bottom: 1px solid #ccc; border: none; margin-left: 60px">
      <tbody>
        <tr>
          <td style="width:fit-content">ÚREA</td>
          <td style="width: 65mm; text-align:right; border-bottom: 1px solid #ccc;"><?php echo $examen_lab[2]?></td>
          <td style="width:fit-content">COLESTEROL</td>
          <td style="width: 58.5mm; text-align:right; border-bottom: 1px solid #ccc;"><?php echo $examen_lab[3]?></td>
        </tr>
      </tbody>
    </table>

    <table style="border-bottom: 1px solid #ccc; border: none; margin-left: 60px">
      <tbody>
        <tr>
          <td style="width:fit-content">CREATININA</td>
          <td style="width: 55mm; text-align:right; border-bottom: 1px solid #ccc;"><?php echo $examen_lab[4]?></td>
          <td style="width:fit-content">TRIGLÍCERIDOS</td>
          <td style="width: 56mm; text-align:right; border-bottom: 1px solid #ccc;"><?php echo $examen_lab[5]?></td>
        </tr>
      </tbody>
    </table>

    <table style="border-bottom: 1px solid #ccc; border: none; margin-left: 60px">
      <tbody>
        <tr>
          <td style="width:fit-content">GLÍCEMIA</td>
          <td style="width: 59mm; text-align:right; border-bottom: 1px solid #ccc;"><?php echo $examen_lab[6]?></td>
          <td style="width:fit-content">P.T.T / P.T</td>
          <td style="width: 64.5mm; text-align:right; border-bottom: 1px solid #ccc;"><?php echo $examen_lab[7]?></td>
        </tr>
      </tbody>
    </table>

    <table style="border-bottom: 1px solid #ccc; border: none; margin-left: 60px">
      <tbody>
        <tr>
          <td style="width:fit-content">CUENTA BLANCA Y FORMULA</td>
          <td style="width: 30mm; text-align:right; border-bottom: 1px solid #ccc;"><?php echo $examen_lab[8]?></td>
          <td style="width:fit-content">ÁCIDO ÚRICO</td>
          <td style="width: 59mm; text-align:right; border-bottom: 1px solid #ccc;"><?php echo $examen_lab[9]?></td>
        </tr>
      </tbody>
    </table>

    <table style="border-bottom: 1px solid #ccc; border: none; margin-left: 60px">
      <tbody>
        <tr>
          <td style="width:fit-content">ORINA</td>
          <td style="width: 64mm; text-align:right; border-bottom: 1px solid #ccc;"><?php echo $examen_lab[10]?></td>
          <td style="width:fit-content">HECES</td>
          <td style="width: 68.5mm; text-align:right; border-bottom: 1px solid #ccc;"><?php echo $examen_lab[11]?></td>
        </tr>
      </tbody>
    </table>

    <table style="border-bottom: 1px solid #ccc; border: none; margin-left: 60px">
      <tbody>
        <tr>
          <td style="width:fit-content">TOXOPLASMOSIS Igg Igm</td>
          <td style="width: 37mm; text-align:right; border-bottom: 1px solid #ccc;"><?php echo $examen_lab[12]?></td>
          <td style="width:fit-content">V.D.R.L</td>
          <td style="width: 68mm; text-align:right; border-bottom: 1px solid #ccc;"><?php echo $examen_lab[13]?></td>
        </tr>
      </tbody>
    </table>

    <table style="border-bottom: 1px solid #ccc; border: none; margin-left: 60px">
      <tbody>
        <tr>
          <td style="width:fit-content">HG GLICOSILADA</td>
          <td style="width: 48.5mm; text-align:right; border-bottom: 1px solid #ccc;"><?php echo $examen_lab[14]?></td>
          <td style="width:fit-content">IgE</td>
          <td style="width: 73.5mm; text-align:right; border-bottom: 1px solid #ccc;"><?php echo $examen_lab[15]?></td>
        </tr>
      </tbody>
    </table>

    <table style="border-bottom: 1px solid #ccc; border: none; margin-left: 60px">
      <tbody>
        <tr>
          <td style="width:fit-content">HEPATITIS A</td>
          <td style="width: 55.5mm; text-align:right; border-bottom: 1px solid #ccc;"><?php echo $examen_lab[16]?></td>
          <td style="width:fit-content">HEPATITIS B</td>
          <td style="width: 60mm; text-align:right; border-bottom: 1px solid #ccc;"><?php echo $examen_lab[17]?></td>
        </tr>
      </tbody>
    </table>

    <table style="border-bottom: 1px solid #ccc; border: none; margin-left: 60px">
      <tbody>
        <tr>
          <td style="width:fit-content">HIV</td>
          <td style="width: 69mm; text-align:right; border-bottom: 1px solid #ccc;"><?php echo $examen_lab[18]?></td>
          <td style="width:fit-content">INSULINA PRE Y POST PANDRIAL</td>
          <td style="width: 30mm; text-align:right; border-bottom: 1px solid #ccc;"><?php echo $examen_lab[19]?></td>
        </tr>
      </tbody>
    </table>

    <table style="border-bottom: 1px solid #ccc; border: none; margin-left: 60px">
      <tbody>
        <tr>
          <td style="width:fit-content">Proteina C Reactiva</td>
          <td style="width: 46.5mm; text-align:right; border-bottom: 1px solid #ccc;"><?php echo $examen_lab[20]?></td>
          <td style="width:fit-content">GLICEMIA PRE Y POST PANDRIAL</td>
          <td style="width: 30mm; text-align:right; border-bottom: 1px solid #ccc;"><?php echo $examen_lab[21]?></td>
        </tr>
      </tbody>
    </table>

    <?php 
    if (isset($examen_lab[22])) {
    ?>

    <div style="margin-top: 8px; font-size: 12px; width: 180mm; margin-left: 60px">
      OTROS:<?php echo strtoupper($examen_lab[22])?>
    </div>

	<?php } ?>

    <table style="margin-top: 15px; margin-left:20px; font-size:12px; border: none">
      <tbody>
        <tr>
          <td>N° Historia: <div style="width: fit-content"><?php echo $datos['id_historia']?></div></td>
          <td>NOMBRE: <div style="width: fit-content"><?php echo $datos['apel_nomb']?></div></td>
          <td>N°.Cédula: <div style="width: fit-content"><?php echo $datos['nume_cedu']?></div></td>
        </tr>
      </tbody>
    </table>

    <div class="fecha">
      Fecha: <?php echo $dia?>
    </div>

  </div>  
</page>
