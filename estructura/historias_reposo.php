<!--1)---------------------------------------------------- -->
<!-------------------- REPOSOS EDITAR -------------------- -->
<!-------------------------------------------------------- -->
<div id="crud-repeditar-popup" class="popup-oculto" data-crud='popup'>
  <div id="crud-repeditar-pop" class="popup-oculto" style="width:30%; min-width: 300px">

    <button id="crud-repeditar-cerrar" data-crud='cerrar'>X</button>

    <section id="crud-repeditar-titulo" data-crud='titulo'>
      EDITAR REPOSO
    </section>

    <div class="filas" style="height: fit-content; position:relative;">

      <div class="personalizacion-b" id="crud-repeditar-personalizacion" data-hidden style="background: #000000ba !important;">
        <section>Personalización</section>
        <section style="width: 100%; border: 1px dashed #fff"></section>
        <span>ENTER: SEPARAR LÍNEA</span>
        <span>°CENTRAR°</span>
        <span>*<b>NEGRITA</b>*</span>
        <span>_ <u>SUBRAYADO</u> _</span>
        <span>~<i>ITÁLICA</i>~</span>

        <div class="previa-b" id="repeditar-previa" data-scroll></div>
      </div>

      <div class="columnas">
        
        <div>
          <label class="requerido">Cabecera del reporte</label>
          <select data-valor="cabecera" class="repeditar-valores upper lleno">
            <option value="0">Por intervención quirúrgica</option>
            <option value="1">Por presentar un motivo</option>
          </select>
        </div>

      </div>

      <div class="columnas" style="height: 100%">
        
        <div style="height: 100%">
          <label class="requerido">Motivo de la cabecera</label>
          <textarea rows="4" id="repeditar-informacion" data-previa="repeditar-previa" data-valor="reposo" class="repeditar-valores upper lleno textarea-espaciado contenedor-personalizable" style="resize:none; min-height: 30vh;" data-scroll></textarea>
        </div>

      </div>

      <div class="columnas">

        <div class="check-alineado" style="margin:0px">
          <label>Requiere cuidado de representantes</label>        
          <input type="checkbox" data-valor="representante" class="repeditar-valores check checksmall" style="width: 30px; height: 30px">
        </div>

      </div>

      <div class="columnas">

        <div class="check-alineado" style="margin:0px">
          <label>Recomendaciones</label>        
          <input type="checkbox" data-valor="recomendaciones" class="repeditar-valores check checksmall" style="width: 30px; height: 30px">
        </div>

      </div>

      <div class="columnas">
        <div>
          <label>Recomendaciones tiempo</label>
          <input type="text" data-valor="recomendaciones_tiempo" class="repeditar-valores upper">
        </div>
      </div>

      <div class="columnas">

        <div style="margin: 0px" title="FECHA SOBRE LA CUÁL SE APLICAN LOS DÍAS AL CALCULAR EL REPOSO">
          <label class="requerido">FECHA INICIAL DEL REPOSO:</label>
          <input type="date" id="reposos-inicio-editar" data-valor="fecha_inicio" class="repeditar-valores lleno textarea-espaciado">
        </div>
        
      </div>

      <div class="columnas">

        <div style="margin: 0px">
          <label class="requerido">DÍAS DE REPOSO:</label>
          <input type="text" id="reposos-dias-editar" data-valor="dias" placeholder="0" class="repeditar-valores lleno">
        </div>
        
      </div>

      <div class="columnas">

        <div style="margin: 0px">
          <label class="requerido">FECHA FINAL DEL REPOSO:</label>
          <input type="date" id="reposos-fin-editar" data-valor="fecha_final" class="repeditar-valores lleno" disabled>
        </div>
        
      </div>

      <div class="columnas">
        <div>
          <input type="text" id="reposos-fecha-editar" data-valor="fecha_simple" class="repeditar-valores lleno visual" disabled style="height: 20px; padding: 5px; border: 1px dashed #262626">
        </div>
      </div>

    </div>

    <section id="crud-repeditar-botones" data-crud='botones' style="column-gap:5px">
      <button class="botones-formularios confirmar btn-editar">CONFIRMAR</button>
      <button class="botones-formularios cerrar">CANCELAR</button>
    </section>

  </div>
</div>

<!--2)---------------------------------------------------- -->
<!----------------- reposoS TEMPLATE ----------------- -->
<!-------------------------------------------------------- -->
<template id="reposo-template">

  <section class="reposo-crud cruds">

  	<div class="crud-contenido">
  		
	    <div style="display: flex; flex-direction: column">

  			<div class="crud-botones">

          <button class="modelo btn btn-reusar" title="Reutilizar información del reporte para cualquier historia">
            <?php echo $_SESSION['botones']['reportes_modelo']?>
          </button>

          <button class="reusar btn btn-reusar" title="Reutilizar información del reporte">
            <?php echo $_SESSION['botones']['reportes_reusar']?>
          </button>

  				<button class="editar btn btn-editar" title="Editar reporte">
  					<?php echo $_SESSION['botones']['reportes_editar']?>
  				</button>

  				<button class="reimprimir btn btn-imprimir" title="Reimprimir reporte">
  					<?php echo $_SESSION['botones']['reportes_reimprimir']?>
  				</button>
  				
  				<div class="crud-eliminar-contenedor">
  					
  					<button class="eliminar btn btn-eliminar">
  						<?php echo $_SESSION['botones']['reportes_eliminar']?>
  					</button>
  					
  				</div>

  			</div>

  			<div class="crud-informacion">

  				<label class="crud-titulo">REPOSO</label>

  				<div class="reposo crud-reporte">
  				  
            <select class="reposos-cabecera input visual" disabled style="margin-top: 5px">
              <option value="0">Por intervención quirúrgica</option>
              <option value="1">Por presentar un motivo</option>
            </select>

            <div class="reposos-motivo"></div>

            <div class="reposos-representante">
              <label>Requiere cuidados del representante</label>
              <input type="checkbox" disabled class="input check checksmall">
            </div>

            <div class="reposos-recomendaciones">
              <label>Recomendaciones</label>
              <input type="checkbox" disabled class="input check checksmall">
            </div>

            <div class="reposos-recomendaciones-tiempo">
              <label>Tiempo recomendado para práctica física</label>
              <div></div>
            </div>

            <div class="reposos-fecha-inicio" style="margin-bottom: 5px;">
              <label>DESDE:</label>
              <input type="date" class="visual" disabled style="border: 1px dashed #03a9f4; border-radius: 5px;"> 
            </div>

            <div class="reposos-fecha-final">
              <label>HASTA:</label>
              <input type="date" class="visual" disabled style="border: 1px dashed #03a9f4; border-radius: 5px;"> 
            </div>

            <div class="reposos-fecha-dias" style="
              display: flex;
              align-items: flex-end;
              column-gap: 6px;
            ">
              <label>DÍAS:</label>
              <div style="font-weight: bold"></div>
            </div>

            <div class="reposos-fecha-simple">
              <label>REPOSO ACABA EL:</label>
              <div></div>
            </div>

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

<!--3)---------------------------------------------------- -->
<!--------------------- REPOSOS CONTENEDOR --------------- -->
<!-------------------------------------------------------- -->
<section class="reportes-seccion" data-hide>
                
    <div data-familia class="contenedor contenedor-reportes" id="reposos-contenedor">

      <div class="izquierda">

        <div class="subtitulo">
          Cargar nuevo reposo

          <button class="limpiar" title="Limpiar Contenido" data-crud="limpiar">
            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="trash-alt" class="svg-inline--fa fa-trash-alt fa-w-14 iconos-b" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M32 464a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128H32zm272-256a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zm-96 0a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zm-96 0a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zM432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16z"></path></svg>
          </button>

          <button class="reutilizar" title="Reutilizar modelo" data-crud="reutilizar">
            <svg class="iconos-b" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><path fill="currentColor" d="M32 96l320 0V32c0-12.9 7.8-24.6 19.8-29.6s25.7-2.2 34.9 6.9l96 96c6 6 9.4 14.1 9.4 22.6s-3.4 16.6-9.4 22.6l-96 96c-9.2 9.2-22.9 11.9-34.9 6.9s-19.8-16.6-19.8-29.6V160L32 160c-17.7 0-32-14.3-32-32s14.3-32 32-32zM480 352c17.7 0 32 14.3 32 32s-14.3 32-32 32H160v64c0 12.9-7.8 24.6-19.8 29.6s-25.7 2.2-34.9-6.9l-96-96c-6-6-9.4-14.1-9.4-22.6s3.4-16.6 9.4-22.6l96-96c9.2-9.2 22.9-11.9 34.9-6.9s19.8 16.6 19.8 29.6l0 64H480z"/></svg>
          </button>
        </div>

        <div class="cargar" title="[TAB] para enforcar">

          <div class="personalizacion" data-hidden style="background: #000000ba !important;">

            <section>Personalización</section>
            <section style="width: 100%; border: 1px dashed #fff"></section>
            <span>ENTER: SEPARAR LÍNEA</span>
            <span>°CENTRAR°</span>
            <span>*<b>NEGRITA</b>*</span>
            <span>_ <u>SUBRAYADO</u> _</span>
            <span>~<i>ITÁLICA</i>~</span>

            <div id="reposo-previa" data-scroll></div>

          </div>
            
          <div id="reposo-contenedor-izquierda" class="filas" style="height: 75vh; position: relative; justify-content: flex-start;" data-scroll-invisible>
          
            <div class="columnas">
              
              <div>
                
                <label class="requerido">Cabecera del reporte</label>
                <select data-valor="cabecera" class="reposo-valores upper lleno">
                  <option value="0">Por intervención quirúrgica</option>
                  <option value="1">Por presentar un motivo</option>
                </select>
                
              </div>

            </div>

            <div class="columnas" style="height: 100%">
              
              <div style="height: 100%">
                
                <label class="requerido">Motivo de la cabecera</label>
                <textarea id="reposo-informacion" data-previa="reposo-previa" data-valor="reposo" rows="6" class="reposo-valores upper lleno textarea-espaciado contenedor-personalizable" placeholder="Cargar información..." style="resize: none" data-scroll title="
                  Por intervención quirúrgica cargar -> LA CAUSA QUE MOTIVO AL PROCEDIMIENTO, EL PROCEDIMIENTO QUIRÚRGICO&#013Por presentación de motivo cargar -> LA CAUSA QUE MOTIVO LA CONSULTA
                "></textarea>

              </div>

            </div>

            <div class="columnas">

              <div class="check-alineado">
                <label>Requiere cuidado de representantes</label>        
                <input id="reposo-menor" type="checkbox" data-valor="representante" class="reposo-valores check checksmall" style="width: 30px; height: 30px">
              </div>
              
            </div>

            <div class="columnas">

              <div class="check-alineado" style="margin:0px">
                <label>Recomendaciones</label>        
                <input type="checkbox" data-valor="recomendaciones" class="reposo-valores check checksmall" style="width: 30px; height: 30px">
              </div>

            </div>

            <div class="columnas">
              <div>
                <label>Recomendaciones tiempo</label>
                <input type="text" data-valor="recomendaciones_tiempo" class="reposo-valores upper">
              </div>
            </div>

            <div class="columnas" style="margin: 5px 0px;">

              <div style="margin: 0px" title="FECHA SOBRE LA CUÁL SE APLICAN LOS DÍAS AL CALCULAR EL REPOSO">
                <label class="requerido">FECHA INICIAL DEL REPOSO:</label>
                <input type="date" data-valor="fecha_inicio" id="reposos-inicio-insertar" class="reposo-valores lleno textarea-espaciado">
              </div>
              
            </div>

            <div class="columnas" style="margin: 5px 0px;">

              <div style="margin: 0px">
                <label class="requerido">DÍAS DE REPOSO:</label>
                <input type="text" data-valor="dias" id="reposos-dias-insertar" placeholder="0" class="reposo-valores lleno">
              </div>
              
            </div>

            <div class="columnas" style="margin: 5px 0px;">

              <div style="margin: 0px">
                <label class="requerido">FECHA FINAL DEL REPOSO:</label>
                <input type="date" data-valor="fecha_final" id="reposos-fin-insertar" class="reposo-valores lleno" disabled>
              </div>
              
            </div>

            <div class="columnas" style="margin: 5px 0px;">
              <div style="margin-bottom: 5px;">
                <input type="text" data-valor="fecha_simple" id="reposos-fecha-insertar" class="reposo-valores lleno visual" disabled style="height: 20px; padding: 5px; border: 1px dashed #262626">
              </div>
            </div>

          </div>

          <div class="botones-reportes">

            <?php 
              if ($_SESSION['usuario']['rol'] == 'DOCTOR') {
            ?>
              <button class="reporte-notificar" title="Envía una notificación de revisión y modificación del reporte al doctor/a" data-hidden>
                <svg style="width: 15px; height: 15px;" class="iconos" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><path fill="currentColor" d="M64 32C64 14.3 49.7 0 32 0S0 14.3 0 32V64 368 480c0 17.7 14.3 32 32 32s32-14.3 32-32V352l64.3-16.1c41.1-10.3 84.6-5.5 122.5 13.4c44.2 22.1 95.5 24.8 141.7 7.4l34.7-13c12.5-4.7 20.8-16.6 20.8-30V66.1c0-23-24.2-38-44.8-27.7l-9.6 4.8c-46.3 23.2-100.8 23.2-147.1 0c-35.1-17.6-75.4-22-113.5-12.5L64 48V32z"/></svg>
              </button>
            <?php 
              } else if ($_SESSION['usuario']['rol'] == 'ADMINISTRACION') {
            ?>
              <button class="reporte-notificar" title="Envía una notificación de revisión y modificación del reporte al doctor/a">
                <svg style="width: 15px; height: 15px;" class="iconos" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><path fill="currentColor" d="M64 32C64 14.3 49.7 0 32 0S0 14.3 0 32V64 368 480c0 17.7 14.3 32 32 32s32-14.3 32-32V352l64.3-16.1c41.1-10.3 84.6-5.5 122.5 13.4c44.2 22.1 95.5 24.8 141.7 7.4l34.7-13c12.5-4.7 20.8-16.6 20.8-30V66.1c0-23-24.2-38-44.8-27.7l-9.6 4.8c-46.3 23.2-100.8 23.2-147.1 0c-35.1-17.6-75.4-22-113.5-12.5L64 48V32z"/></svg>
              </button>

              <div style="
                width: 1px;
                height: 100%;
                border-left: 2px dashed #ff8101;
              "></div>
            <?php 
              }
            ?>
            
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

          <input type="text" autocomplete="off" id="reposo-busqueda" class="upper borde-estilizado boton-busqueda">

        </div>

        <div class="tabla-ppal borde-estilizado" data-scroll>

          <table id="tabla-reposo" class="table table-bordered table-striped">
            <thead>
            </thead>
            <tbody>
            </tbody>
          </table>
          
        </div>

      </div>

    </div>

</section>