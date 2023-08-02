<!--1)---------------------------------------------------- -->
<!----------------- CONSTANCIAS TEMPLATE ----------------- -->
<!-------------------------------------------------------- -->
<template id="constancia-template">

  <section class="constancia-crud cruds">

  	<div class="crud-contenido">
  		
	    <div style="display: flex; flex-direction: column">

			<div class="crud-botones">

				<button class="editar btn btn-editar">
					<?php echo $_SESSION['botones']['reportes_editar']?>
				</button>

				<button class="reimprimir btn btn-imprimir">
					<?php echo $_SESSION['botones']['reportes_reimprimir']?>
				</button>
				
				<div class="crud-eliminar-contenedor">
					
					<button class="eliminar btn btn-eliminar">
						<?php echo $_SESSION['botones']['reportes_eliminar']?>
					</button>
					
				</div>

			</div>

			<div class="crud-informacion">

				<label class="crud-titulo">CONSTANCIA</label>

				<div class="constancia crud-reporte">
				  
				</div>

			</div>

	    </div>

	    <div class="crud-datos" title="Click para expandir">
	      Ver más información <b>...</b>

	      <section class="crud-datos-contenedor" data-hidden data-efecto="cerrar">
	      
	      	<div style="border-bottom: 1px solid;">Información</div>

	      	<div class="crud-dato nombre"></div>
	      	<div class="crud-dato apellido"></div>
	      	<div class="crud-dato cedula"></div>
	      	<div class="crud-dato edad"></div>

	      </section>

	    </div>

  	</div>


  </section>

</template>

<!-------------------------------------------------------- -->
<!----------------- CONSTANCIAS CONTENEDOR --------------- -->
<!-------------------------------------------------------- -->
<section class="reportes-seccion">
                
    <div data-familia class="contenedor contenedor-reportes" id="constancias-contenedor">

      <div class="izquierda">

        <div class="subtitulo">
          Cargar nueva constancia

          <button class="limpiar" title="Limpiar Contenido" data-crud="limpiar">
            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="trash-alt" class="svg-inline--fa fa-trash-alt fa-w-14 iconos-b" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M32 464a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128H32zm272-256a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zm-96 0a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zm-96 0a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zM432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16z"></path></svg>
          </button>
        </div>

        <div class="cargar" title="[TAB] para enforcar">

          <div class="personalizacion" data-hidden>

            <section>Personalización</section>
            <section style="width: 100%; border: 1px dashed #fff"></section>
            <span>ENTER: SEPARAR LÍNEA</span>
            <span>°CENTRAR°</span>
            <span>*<b>NEGRITA</b>*</span>
            <span>_ <u>SUBRAYADO</u> _</span>
            <span>~<i>ITÁLICA</i>~</span>

            <div id="constancia-previa" data-scroll></div>

          </div>
            
          <div class="filas" style="height: 100%; position: relative">
          
            <div class="columnas" style="height: 100%">
              
              <div style="height: 100%; margin: 0px">
                
                <label class="requerido">Constancia</label>
                <textarea id="constancia-textarea" data-previa="constancia-previa" rows="6" class="constancia-valores upper lleno textarea-espaciado contenedor-personalizable" placeholder="Cargar información..." style="resize: none" data-scroll></textarea>

              </div>

            </div>

          </div>

          <div class="botones-reportes">
            <button class="reporte-cargar">CARGAR</button>
            <button class="reporte-previa">PREVIA</button>
          </div>

        </div>

        <!------------------------ PREVIA -------------------------- -->
        <!---------------------------------------------------------- -->
        <div class="desplegable-oculto desplegable-contenedor">
          
          <section>

            <div>
              <iframe src="" class="desplegable-iframe"></iframe>
            </div>

            <div>
              <button class='desplegable-cerrar'>
                <?php echo $_SESSION['botones']['desplegable_cerrar']?>
              </button>
            </div>
            
          </section>

        </div>

      </div>

      <div class="derecha">

        <div class="busqueda-estilizada">

          <input type="text" autocomplete="off" id="constancia-busqueda" class="upper borde-estilizado boton-busqueda">

        </div>

        <div class="tabla-ppal borde-estilizado" data-scroll>

          <table id="tabla-constancia" class="table table-bordered table-striped">
            <thead>
            </thead>
            <tbody>
            </tbody>
          </table>
          
        </div>

      </div>

    </div>

</section>