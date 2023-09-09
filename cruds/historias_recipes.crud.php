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
		    	<input class="genericos-input upper" type="text">
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
  <div id="crud-recipes-pop" class="popup-oculto" data-scroll style="padding: 2.5% !important">
    
    <button id="crud-recipes-cerrar" data-crud='cerrar'>X</button>

    <section id="crud-insertar-titulo" data-crud='titulo' style="justify-content: flex-start;">
      Recipes & indicaciones del paciente
    </section> 

    <div class="valor-cabecera cabecera-formularios" style="right: 30px;">

      <div>
        <label>N° de historia</label>
        <input type="text" autocomplete="off"  data-valor="id_historia" class="recipes-cargar upper visual" disabled style="width: 65px;">
      </div>

      <div>
        <label>Paciente</label>
        <input type="text" autocomplete="off"  data-valor="nombre_completo" class="recipes-cargar upper visual" disabled style="width: 10vw; min-width: 150px">
      </div>

    </div>

    <div id="crud-recipes-contenedor">
      
      <section class="derecha">

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

        <div class="botones-reportes" style="justify-content: center">            
       	 	<button class="recipe-cargar">CARGAR</button>
      	</div>

      </section>


      <section class="izquierda">

        <div class="busqueda-estilizada">
          <input type="text" id="recipes-busqueda" autocomplete="off" class="upper borde-estilizado" title="Enfocar cajón de texto [Shift > Shift]&#013Abrir insersión de historia &#013Información primer resultado [Shift > ENTER]&#013Limpiar cajón de busqueda [Supr > Supr]">
        </div>
        
        <div id="tabla-recipes-contenedor" class="tabla-ppal borde-estilizado">

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

      <div class="busqueda-estilizada">
        <input type="text" name="tratamientos-busqueda" class="borde-estilizado upper" id="tratamientos-busqueda" data-estilo="busqueda" placeholder="Busqueda">
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

      <div class="busqueda-estilizada">
        <input type="text" name="presentaciones-busqueda" class="borde-estilizado upper" id="presentaciones-busqueda" data-estilo="busqueda" placeholder="Busqueda">
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
