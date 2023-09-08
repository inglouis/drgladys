<!-------------------------------------------------------- -->
<!---------------- MEDICAMENTOS TEMPLATE ----------------- -->
<!-------------------------------------------------------- -->
<template id="medicamentos-template">

  <section class="medicamentos-crud cruds">

  	<div class="crud-contenido">
  		
	    contenido

	    <button class="seleccionar-medicamento"></button>
	    <button class="seleccionar-presentacion"></button>
	    <button class="seleccionar-tratamiento"></button>

	    <div class="genericos"></div>
	    <div class="presentacion"></div>
	    <div class="tratamiento"></div>

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

        <div class="busqueda-estilizada">
          <input type="text" id="medicamentos-busqueda" autocomplete="off" class="upper borde-estilizado" title="Enfocar cajón de texto [Shift > Shift]&#013Abrir insersión de historia &#013Información primer resultado [Shift > ENTER]&#013Limpiar cajón de busqueda [Supr > Supr]">
        </div>
        
        <div id="tabla-medicamentos-contenedor" class="tabla-ppal" data-scroll>

          <table id="tabla-medicamentos" class="table table-bordered table-striped">
            <thead></thead>
            <tbody></tbody>
          </table>

        </div>

        <div style="display: flex; height: 100%;">

          <button id="medicamentos-izquierda" class="botones"><?php echo "<"?></button>

          <div id="medicamentos-numeracion" data-estilo="numeracion-contenedor" style="width: 100px">
            <input class="medicamentos-numeracion" type="number" maxlength="3" minlength="0" title="[ENTER] para cargar página">
            <span class="medicamentos-numeracion"></span> 
          </div>

          <button id="medicamentos-derecha" class="botones"><?php echo ">"?></button>

        </div>

      </section>


      <section class="izquierda">

        <div class="busqueda-estilizada">
          <input type="text" id="recipes-busqueda" autocomplete="off" class="upper borde-estilizado" title="Enfocar cajón de texto [Shift > Shift]&#013Abrir insersión de historia &#013Información primer resultado [Shift > ENTER]&#013Limpiar cajón de busqueda [Supr > Supr]">
        </div>
        
        <div id="tabla-recipes-contenedor" class="tabla-ppal">

          <table id="tabla-recipes" class="table table-bordered table-striped">
            <thead></thead>
            <tbody></tbody>
          </table>

        </div>

        <div style="display: flex; height: 100%;">

          <button id="medicamentos-izquierda" class="botones"><?php echo "<"?></button>

          <div id="medicamentos-consulta-numeracion" data-estilo="numeracion-contenedor" style="width: 100px">
            <input class="medicamentos-consulta-numeracion" type="number" maxlength="3" minlength="0" title="[ENTER] para cargar página">
            <span class="medicamentos-consulta-numeracion"></span> 
          </div>

          <button id="medicamentos-consulta-derecha" class="botones"><?php echo ">"?></button>

        </div>

      </section>

    </div>

  </div>
</div>

<!------------------------------------------------------------------- -->
<!------------------------- TRATAMIENTOS ------------------------- -->
<!------------------------------------------------------------------- -->
<div id="crud-tratamientos-popup" class="popup-oculto" data-crud='popup' style="background: transparent;">
  <div id="crud-tratamientos-pop" class="popup-oculto">

    <button id="crud-tratamientos-cerrar" data-crud='cerrar'>X</button>

    <section id="crud-tratamientos-titulo" class="subtitulo">
      Seleccionar tratamiento
    </section> 

    <div style="display: grid; height: 100%; width: 100%; grid-template-rows: 35px 1fr auto;">
      <div style="display: flex;">
        <input type="text" name="tratamientos-busqueda" id="tratamientos-busqueda" data-estilo="busqueda" placeholder="Busqueda">
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
<div id="crud-presentaciones-popup" class="popup-oculto" data-crud='popup' style="background: transparent;">
  <div id="crud-presentaciones-pop" class="popup-oculto">

    <button id="crud-presentaciones-cerrar" data-crud='cerrar'>X</button>

    <section id="crud-presentaciones-titulo" class="subtitulo">
      Seleccionar presentación
    </section> 

    <div style="display: grid; height: 100%; width: 100%; grid-template-rows: 35px 1fr auto;">
      <div style="display: flex;">
        <input type="text" name="presentaciones-busqueda" id="presentaciones-busqueda" data-estilo="busqueda" placeholder="Busqueda">
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
