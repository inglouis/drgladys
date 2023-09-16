<!-------------------------------------------------------- -->
<!---------------- MEDICAMENTOS TEMPLATE ----------------- -->
<!-------------------------------------------------------- -->
<template id="medicamentos-template">

  <section class="medicamentos-crud cruds">

  	<div class="crud-contenido">

  		<div class="izquierda">
  			
		    <button class="btn btn-general seleccionar-medicamento" title="Medicamento">M</button>
		    <button class="btn btn-general seleccionar-presentacion" title="Seleccionar presentación">P</button>
		    <button class="btn btn-general seleccionar-tratamiento" title="Seleccionar tratamiento">T</button>

  		</div>

  		<div class="derecha">
  			
		    <div class="genericos">
		    	<input class="genericos-input upper" type="text" title="Medicamentos genéricos [editable]">
		    </div>
		    <div class="presentacion"><ul><li></li></ul></div>
		    <div class="tratamiento"><ul><li></li></ul></div>

  		</div>

  	</div>


  </section>

</template>

<!------------------------------------------------------------------- -->
<!---------------------------- RECIPES ------------------------------ -->
<!------------------------------------------------------------------- -->
<div id="crud-recipes-popup" class="popup-oculto" data-crud='popup'>
  <div id="crud-recipes-pop" class="popup-oculto" data-scroll style="padding: 2% !important">
    
    <button id="crud-recipes-cerrar" data-crud='cerrar'>X</button>

    <section id="crud-insertar-titulo" data-crud='titulo' style="justify-content: flex-start;">
      Recipes & indicaciones del paciente
    </section> 

    <div class="valor-cabecera cabecera-formularios" style="right: 30px;">
    	
      <div>
        <label>Paciente:</label>
        <input type="text" autocomplete="off"  data-valor="nombre_completo" class="recipes-cargar upper visual" disabled style="width: 10vw; min-width: 150px">
      </div>

      <div>
        <label style="width: 85px;">N° de cédula:</label>
        <input type="text" autocomplete="off"  data-valor="cedula" class="recipes-cargar upper visual" disabled style="width: 10vw; min-width: 150px">
      </div>

    </div>

    <div id="crud-recipes-contenedor">
      
      <section class="derecha" style="position: relative;">

		<?php  
		if ($_SESSION['usuario']['rol'] == 'ADMINISTRACION') { 
		?>
			<!--<div class="bloquear">ACCESO DENEGADO</div>-->
		<?php  
		} 
		?>

      	<div class="cabecera">
      		
      		<div style="display: flex; column-gap: 5px;">
      			
		        <div class="busqueda-estilizada">
		          <input type="text" id="medicamentos-busqueda" autocomplete="off" class="upper borde-estilizado" title="Enfocar cajón de texto [Shift > Shift]&#013Abrir insersión de historia &#013Información primer resultado [Shift > ENTER]&#013Limpiar cajón de busqueda [Supr > Supr]">
		        </div>

		        <div style="display: flex;justify-content: center;align-items: center;">
                
                	<button id="medicamentos-insertar" class="btn btn-nuevo tooltip-filtro">+</button>

              	</div>

      		</div>

	        <div style="display: flex;">

				<button id="medicamentos-izquierda" class="botones"><?php echo "<"?></button>

				<div id="medicamentos-numeracion" data-estilo="numeracion-contenedor" style="width: 100px">
					<input class="medicamentos-numeracion" type="number" maxlength="3" minlength="0" title="[ENTER] para cargar página" style="font-weight: bold">
					<span class="medicamentos-numeracion"></span> 
				</div>

				<button id="medicamentos-derecha" class="botones"><?php echo ">"?></button>

	        </div>

      	</div>

        <div id="tabla-medicamentos-contenedor" class="tabla-ppal borde-estilizado" data-scroll>

          <table id="tabla-medicamentos" class="table table-bordered table-striped">
            <thead></thead>
            <tbody></tbody>
          </table>

        </div>

        <div id="crud-recipes-botones" class="botones-reportes" style="justify-content: center">
        	<?php  
			if ($_SESSION['usuario']['rol'] == 'DOCTOR') { 
			?>
				<button class="recipe-notificar">GUARDAR & NOTIFICAR</button>
			<?php  
			} 
			?>
       	 	<button class="recipe-cargar">GUARDAR & IMPRIMIR</button>
        	<button class="recipe-previa">VISTA PREVIA</button>
      	</div>

      </section>


      <section class="izquierda">

        <div class="busqueda-estilizada">
          <input type="text" id="recipes-busqueda" autocomplete="off" class="upper borde-estilizado" title="Enfocar cajón de texto [Shift > Shift]&#013Abrir insersión de historia &#013Información primer resultado [Shift > ENTER]&#013Limpiar cajón de busqueda [Supr > Supr]">
        </div>
        
        <div id="tabla-recipes-contenedor" class="tabla-ppal borde-estilizado" data-scroll>

          <table id="tabla-recipes" class="table table-bordered table-striped">
            <thead></thead>
            <tbody></tbody>
          </table>

        </div>

      </section>

    </div>

  </div>
</div>

<!------------------------------------------------------------------- -->
<!------------------------- TRATAMIENTOS ------------------------- -->
<!------------------------------------------------------------------- -->
<div id="crud-tratamientos-popup" class="popup-oculto" data-crud='popup'>
  <div id="crud-tratamientos-pop" class="popup-oculto">

    <button id="crud-tratamientos-cerrar" data-crud='cerrar'>X</button>

    <section id="crud-tratamientos-titulo" class="subtitulo">
      SELECCIONAR TRATAMIENTO
    </section> 

    <div class="contenido">

      <div class="busqueda-estilizada" style="justify-content: center; align-items: center; column-gap: 5px;">

        <input type="text" name="tratamientos-busqueda" class="borde-estilizado upper" id="tratamientos-busqueda" data-estilo="busqueda" placeholder="Busqueda" style="background: #fff">

        <button style="position: relative; top: 0px; height: 100%;" id="nuevo-tratamiento" class="btn-nuevo btn btn-primary" title="Agregar fila">+</button>

      </div>

      <div class="tabla-ppal scroll" data-estilo="tabla-tratamientos">
        <table id="tabla-tratamientos" class="table table-bordered table-striped">
            <thead></thead>
            <tbody></tbody>
        </table>
      </div>

    </div>

  </div>
</div>

<!------------------------------------------------------------------- -->
<!------------------------- PRESENTACIONES ------------------------- -->
<!------------------------------------------------------------------- -->
<div id="crud-presentaciones-popup" class="popup-oculto" data-crud='popup'>
  <div id="crud-presentaciones-pop" class="popup-oculto">

    <button id="crud-presentaciones-cerrar" data-crud='cerrar'>X</button>

    <section id="crud-presentaciones-titulo" class="subtitulo">
      SELECCIONAR PRESENTACIÓN
    </section> 

    <div class="contenido">

      <div class="busqueda-estilizada" style="justify-content: center; align-items: center; column-gap: 5px;">
        
        <input type="text" name="presentaciones-busqueda" class="borde-estilizado upper" id="presentaciones-busqueda" data-estilo="busqueda" placeholder="Busqueda" style="background: #fff">

        <button style="position: relative; top: 0px; height: 100%;" id="nueva-presentacion" class="btn-nuevo btn btn-primary" title="Agregar fila">+</button>

      </div>

      <div class="tabla-ppal scroll" data-estilo="tabla-presentaciones">
        <table id="tabla-presentaciones" class="table table-bordered table-striped">
            <thead></thead>
            <tbody></tbody>
        </table>
      </div>

    </div>
  </div>
</div>

<!-------------------------------------------------------- -->
<!--------------------- MEDICAMENTOS  -------------------- -->
<!-------------------------------------------------------- -->
    <div id="crud-medicamentos-popup" class="popup-oculto" data-crud='popup'>

      <div id="crud-medicamentos-pop" class="popup-oculto" style="width:50%; min-width:600px ;height: fit-content;">

        <button id="crud-medicamentos-cerrar" data-crud='cerrar'>X</button>

        <section id="crud-medicamentos-titulo" data-crud='titulo' style="
          justify-content: flex-end;
          flex-direction: row-reverse;
          align-items: baseline;
          column-gap: 5px;
        ">
          
          <button id="crud-medicamentos-limpiar" title="Limpiar Contenido" data-crud='limpiar'>
              <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="trash-alt" class="svg-inline--fa fa-trash-alt fa-w-14 iconos-b" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M32 464a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128H32zm272-256a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zm-96 0a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zm-96 0a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zM432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16z"></path></svg>
          </button>

            Insertar medicamento

        </section> 

        <section class="filas">

          <div class="columnas" style="width:100%;">

            <div>
              <label class="requerido">Descripción del Medicamento</label>  
              <input type="text" size="100" minlength="1" maxlength="100" class="medicamentos-valores upper lleno">
            </div>

          </div>

          <div class="columnas">

            <div style="height: fit-content">

              <section style="width: 100%; display: flex; flex-direction: row; margin: 0px;">
                <label style="width:50%">Génericos</label>
                <label style="width:50%">Kit de Génericos</label>
              </section>

              <section id="cc-medicamentos-genericos" class="contenedor-consulta medicamentos-valores borde-estilizado" data-valor="genericos">

                <span class="tooltip-general">Presionar [ENTER] para agregar</span>

                <section style="width: 50%">
                  <input type="text" data-estilo="cc-input" placeholder="Cargar...">
                  <select data-limit="" data-estilo="cc-select" data-size="16" data-limit="80" data-scroll></select>
                </section>

                <div style="width: 50%" data-estilo="cc-div"></div>

              </section>

            </div>

          </div> 

        </section>

        <section id="crud-medicamentos-botones" data-crud='botones' style="column-gap: 10px; padding: 10px;">
          <button class="botones-formularios insertar">CONFIRMAR</button>
          <button class="botones-formularios cerrar">CANCELAR</button> 
        </section>
      </div> 
    </div>