<!--1)---------------------------------------------------- -->
<!---------------- informeS EDITAR -------------------- -->
<!-------------------------------------------------------- -->
<div id="crud-infeditar-popup" class="popup-oculto" data-crud='popup'>
  <div id="crud-infeditar-pop" class="popup-oculto" style="    
      width: 40%;
      min-width: 450px;
      height: 80%;
      justify-content: flex-start;
      overflow-x: hidden;
    " data-scroll>

    <button id="crud-infeditar-cerrar" data-crud='cerrar'>X</button>

    <section id="crud-infeditar-titulo" data-crud='titulo'>
      EDITAR INFORME
    </section>

    <div class="filas" style="height: fit-content; position:relative;">

      <div class="personalizacion-c" id="crud-infeditar-personalizacion" data-hidden>
        <section>Personalización</section>
        <section style="width: 100%; border: 1px dashed #fff"></section>
        <span>ENTER: SEPARAR LÍNEA</span>
        <span>°CENTRAR°</span>
        <span>*<b>NEGRITA</b>*</span>
        <span>_ <u>SUBRAYADO</u> _</span>
        <span>~<i>ITÁLICA</i>~</span>

        <div class="previa-b" id="infeditar-previa" data-scroll></div>
      </div>

      <div class="columnas">
              
        <div>
          
          <label class="requerido">Tipo de informe médico</label>
          <select data-valor="tipo" class="infeditar-valores  upper lleno">
            <option value="0">Resumido</option>
            <option value="1">Completo</option>
            <option value="2">Simple</option>
          </select>
          
        </div>

      </div>

      <div class="columnas">
        
        <div>
          <label class="requerido">Motivos / antecedentes / simple</label>
          <textarea rows="4" id="infeditar-informacion" data-previa="infeditar-previa" data-valor="contenido" class="infeditar-valores upper lleno textarea-espaciado contenedor-personalizable" style="resize:none;" data-scroll title="
            Resumido -> EL CONTENIDO SERÁ UTILIZADO PARA LOS MOTIVOS DEL INFORME&#013Completo -> EL CONTENIDO SERÁ UTILIZADO PARA LOS ANTECEDENTES DEL INFORME&#013Simple -> EL CONTENIDO SERÁ UTILIZADO COMO MODELO DE TODO EL REPORTE
          "></textarea>
        </div>

      </div>

      <div class="columnas">
                
        <div>     
          <label>Control</label>
          <textarea rows="4" id="infeditar-control" data-previa="infeditar-previa" data-valor="control" class="infeditar-valores upper textarea-espaciado contenedor-personalizable" style="resize:none;" data-scroll ></textarea>
        </div>

      </div>

      <div class="columnas">
        
        <div>     
          <label>Plan o indicaciones</label>
          <textarea rows="4" id="infeditar-plan" data-previa="infeditar-previa" data-valor="plan" class="infeditar-valores upper textarea-espaciado contenedor-personalizable" style="resize:none;" data-scroll title="Resumido -> EL CONTENIDO SERÁ UTILIZADO PARA LAS INDICACIONES DEL INFORME&#013Completo -> EL CONTENIDO SERÁ UTILIZADO PARA EL PLAN DEL INFORME
        "></textarea>
        </div>

      </div>

      <section style="border-bottom: 1px dashed #b9a3cb; width: 100%; height: 1px;"></section>

      <div class="columnas" style="flex-direction: column; align-items: baseline;">

        <label>Agudeza visual - 4m</label>

        <div style="margin: 0px; flex-direction: row; column-gap: 10px;">
          <div>    
            <input type="text" data-valor="agudeza_od_4" class="infeditar-valores upper fracciones" placeholder="OD">
          </div>

          <div>
            <input type="text" data-valor="agudeza_oi_4" class="infeditar-valores upper fracciones" placeholder="OI">
          </div>  
        </div>

      </div>

      <div class="columnas">
        
        <div class="check-alineado">
          <label>Con corrección - 4m</label>        
          <input type="checkbox" data-valor="correccion_4" class="infeditar-valores check checksmall" style="width: 30px; height: 30px">
        </div>

      </div>

      <section style="border-bottom: 1px dashed #b9a3cb; width: 100%; height: 1px;"></section>

      <div class="columnas" style="flex-direction: column; align-items: baseline;">

        <label>Agudeza visual - 1.5m</label>

        <div style="margin: 0px; flex-direction: row; column-gap: 10px;">
          <div>    
            <input type="text" data-valor="agudeza_od_1" class="infeditar-valores upper fracciones" placeholder="OD">
          </div>

          <div>
            <input type="text" data-valor="agudeza_oi_1" class="infeditar-valores upper fracciones" placeholder="OI">
          </div>  
        </div>

      </div>

      <div class="columnas">
        
        <div class="check-alineado">
          <label>Con corrección - 1.5m</label>        
          <input type="checkbox" data-valor="correccion_1" class="infeditar-valores check checksmall" style="width: 30px; height: 30px">
        </div>

      </div>

      <section style="border-bottom: 1px dashed #b9a3cb; width: 100%; height: 1px;"></section>

      <div class="columnas" style="flex-direction: column; align-items: baseline;">

        <label>Agudeza visual - Lectura</label>

        <div style="margin: 0px; flex-direction: row; column-gap: 10px;">
          <div>    
            <input type="text" data-valor="agudeza_od_lectura" class="infeditar-valores upper" placeholder="OD">
          </div>

          <div>
            <input type="text" data-valor="agudeza_oi_lectura" class="infeditar-valores upper" placeholder="OI">
          </div>  
        </div>

      </div>

      <div class="columnas">
        
        <div class="check-alineado">
          <label>Con corrección - Lectura</label>        
          <input type="checkbox" data-valor="correccion_lectura" class="infeditar-valores check checksmall" style="width: 30px; height: 30px">
        </div>

      </div>

      <section style="border-bottom: 1px dashed #b9a3cb; width: 100%; height: 1px;"></section>

      <div class="columnas">

        <div>  
          <label>Estereopsis</label>  
          <input type="text" data-valor="estereopsis" class="infeditar-valores upper" placeholder="00s">
        </div>

        <div>
          <label>Ishihara</label>
          <input type="text" data-valor="test" class="infeditar-valores upper fracciones" placeholder="00/00">
        </div>

        <div>
          <label>Stereo Fly</label>
          <input type="text" data-valor="reflejo" class="infeditar-valores upper" placeholder="00s">
        </div>  

      </div>

      <div class="columnas">
        
        <div>     
          <label>Motilidad</label>
          <textarea rows="4" id="infeditar-motilidad" data-previa="infeditar-previa" data-valor="motilidad" class="infeditar-valores upper textarea-espaciado contenedor-personalizable" style="resize:none;" data-scroll ></textarea>
        </div>

      </div>

      <div class="columnas" style="flex-direction: column; align-items: baseline;">

        <label>
          RX
          <input type="checkbox" data-valor="rx_cicloplegia" class="infeditar-valores check" title="CICLOPLEGIA">
        </label>

        <div style="margin: 0px; flex-direction: column; row-gap: 10px;">
          <div style="flex-direction: row; justify-content: center; align-items: center;">
            <label style="padding-right: 3px">OD:</label>
            <input type="checkbox" data-valor="rx_od_signo_1" class="infeditar-valores check checksigno">
            <input type="text" data-valor="rx_od_valor_1" class="infeditar-valores upper decimales" placeholder="0.00">
            <input type="checkbox" data-valor="rx_od_signo_2" class="infeditar-valores check checksigno">
            <input type="text" data-valor="rx_od_valor_2" class="infeditar-valores upper decimales" placeholder="0.00">
            <span   class="informe-separador">X</span>
            <input type="text" data-valor="rx_od_grados" class="infeditar-valores upper" placeholder="0">
            <span   class="informe-grado">°</span>
            <span   class="informe-igual">=</span>
            <input type="text" data-valor="rx_od_resultado" class="infeditar-valores upper fracciones" placeholder="00/00">
          </div>

          <div style="flex-direction: row; justify-content: center; align-items: center;">
            <label style="padding-right: 9px">OI:</label>
            <input type="checkbox" data-valor="rx_oi_signo_1" class="infeditar-valores check checksigno">
            <input type="text" data-valor="rx_oi_valor_1" class="infeditar-valores upper decimales" placeholder="0.00">
            <input type="checkbox" data-valor="rx_oi_signo_2" class="infeditar-valores check checksigno">
            <input type="text" data-valor="rx_oi_valor_2" class="infeditar-valores upper decimales" placeholder="0.00">
            <span   class="informe-separador">X</span>
            <input type="text" data-valor="rx_oi_grados" class="infeditar-valores upper" placeholder="0">
            <span   class="informe-grado">°</span>
            <span   class="informe-igual">=</span>
            <input type="text" data-valor="rx_oi_resultado" class="infeditar-valores upper fracciones" placeholder="00/00">
          </div>
        </div>

      </div>

      <div class="columnas">
        
        <div>     
          <label>Biomicroscopia</label>
          <textarea rows="2" id="infeditar-biomicroscopia" data-previa="infeditar-previa" data-valor="biomicroscopia" class="infeditar-valores upper textarea-espaciado contenedor-personalizable" style="resize:none;" data-scroll ></textarea>
        </div>

      </div>

      <div class="columnas" style="flex-direction: column; align-items: baseline;">

        <label>PIO</label>

        <div style="margin: 0px; flex-direction: row; column-gap: 10px;">
          <div>    
            <input type="text" data-valor="pio_od" class="infeditar-valores upper decimales" placeholder="OD - 0.00mmHg">
          </div>

          <div>
            <input type="text" data-valor="pio_oi" class="infeditar-valores upper decimales" placeholder="OI - 0.00mmHg">
          </div>  
        </div>

      </div>

      <div class="columnas">
      
        <div>     
          <label>Fondo de ojo</label>
          <textarea rows="2" id="infeditar-fondo" data-previa="infeditar-previa" data-valor="fondo_ojo" class="infeditar-valores upper textarea-espaciado contenedor-personalizable" style="resize:none;" data-scroll ></textarea>
        </div>

      </div>

      <div class="columnas">
        
        <div style="position:relative;">

          <label>
            IDX:
          </label>
          
          <style>
            #cc-diagnosticos-infeditar .ccContenedor {
               width: 95%;
            }
          </style>  

          <section id="cc-diagnosticos-infeditar" class="contenedor-consulta infeditar-valores borde-estilizado" data-valor="diagnosticos">

            <input type="text" data-estilo="cc-input" class="upper" data-minimo="0" data-ocultar="0" placeholder="Buscar diagnósticos" title="[ENTER] para forzar actualización">
            <select id="infeditar-combo" data-limit="" data-estilo="cc-select" placeholder="Buscar diagnóstico" data-size="5" data-ocultar="1" data-hide data-absoluto="1" data-scroll style="
              height: auto;
              border: 1px dashed #5eb6fb;
              border-top: none;
              background: #ddf4ffc2;
              padding: 0px 5px;
              margin: 0px;
              color: black;
            "></select>
            <div data-estilo="cc-div" style="background: #fff; min-height: 80px; max-height: 85px; border: none;" data-scroll></div>

          </section>

        </div>

      </div>

    </div>

    <section id="crud-infeditar-botones" data-crud='botones' style="column-gap:5px">
      <button class="botones-formularios confirmar btn-editar">CONFIRMAR</button>
      <button class="botones-formularios cerrar">CANCELAR</button>
    </section>

  </div>
</div>

<!--2)---------------------------------------------------- -->
<!------------------- INFORMES TEMPLATE ------------------ -->
<!-------------------------------------------------------- -->
<template id="informe-template">

  <section class="informe-crud cruds">

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

				<label class="crud-titulo">INFORME MÉDICO</label>

				<div class="informe crud-reporte">
				  
          <select class="informe-tipo input visual" disabled style="margin-top: 5px">
            <option value="0">Resumido</option>
            <option value="1">Completo</option>
            <option value="2">Simple</option>
          </select>

          <div class="informe-contenido">
            <label>Contenido principal del informe</label>
            <div></div>
          </div>

          <div class="informe-aplica-completo">

            <section style="border-bottom: 1px dashed #b9a3cb; width: 100%; height: 1px; padding-top: 5px"></section>
            
            <div class="informe-agudeza-4">
              <label>Agudeza visual - 4M</label>
              <div style="display: flex; justify-content: left; align-items: center;">
                <span></span>
                <input type="checkbox" disabled class="input check checksmall" title="CORRECCIÓN - 4M">
              </div>
            </div>

            <section style="border-bottom: 1px dashed #b9a3cb; width: 100%; height: 1px; padding-top: 5px"></section>

            <div class="informe-agudeza-1">
              <label>Agudeza visual - 1M</label>
              <div style="display: flex; justify-content: left; align-items: center;">
                <span></span>
                <input type="checkbox" disabled class="input check checksmall" title="CORRECCIÓN - 1M">
              </div>
            </div>

            <section style="border-bottom: 1px dashed #b9a3cb; width: 100%; height: 1px; padding-top: 5px"></section>

            <div class="informe-agudeza-lectura">
              <label>Agudeza visual - Lectura</label>
              <div style="display: flex; justify-content: left; align-items: center;">
                <span></span>
                <input type="checkbox" disabled class="input check checksmall" title="CORRECCIÓN - LECTURA">
              </div>
            </div>

            <section style="border-bottom: 1px dashed #b9a3cb; width: 100%; height: 1px; padding-top: 5px"></section>

            <div class="informe-test">
              <label>Pruebas</label>
              <div></div>
            </div>

            <div class="informe-motilidad">
              <label>Motilidad</label>
              <div></div>
            </div>

            <div class="informe-rx">
              <label>
                Rx
                <input type="checkbox" class="input check checksmall rx-cicloplegia" title="CICLOPLEGIA" disabled>
              </label>
              <div></div>
              <div></div>
            </div>

            <div class="informe-bio">
              <label>Biomiscroscopia</label>
              <div></div>
            </div>

            <div class="informe-pio">
              <label>PIO</label>
              <div></div>
            </div>

            <div class="informe-fondo">
              <label>Fondo de ojo</label>
              <div></div>
            </div>

            <div class="informe-diagnosticos">
              <label>Diagnósticos</label>
              <div style="display: flex; font-weight: bold; color: green; flex-direction: column;"></div>
            </div>

            <div class="informe-plan">
              <label>Plan</label>
              <div></div>
            </div>

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
<!----------------- INFORMES CONTENEDOR --------------- -->
<!-------------------------------------------------------- -->
<section class="reportes-seccion" data-hide>
                
    <div data-familia class="contenedor contenedor-reportes" id="informes-contenedor">

      <div class="izquierda" style="width: 35%">

        <div class="subtitulo">
          Cargar nuevo informe médico

          <button class="limpiar" title="Limpiar Contenido" data-crud="limpiar">
            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="trash-alt" class="svg-inline--fa fa-trash-alt fa-w-14 iconos-b" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M32 464a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128H32zm272-256a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zm-96 0a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zm-96 0a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zM432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16z"></path></svg>
          </button>

          <button class="reutilizar" title="Reutilizar modelo" data-crud="reutilizar">
            <svg class="iconos-b" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><path fill="currentColor" d="M32 96l320 0V32c0-12.9 7.8-24.6 19.8-29.6s25.7-2.2 34.9 6.9l96 96c6 6 9.4 14.1 9.4 22.6s-3.4 16.6-9.4 22.6l-96 96c-9.2 9.2-22.9 11.9-34.9 6.9s-19.8-16.6-19.8-29.6V160L32 160c-17.7 0-32-14.3-32-32s14.3-32 32-32zM480 352c17.7 0 32 14.3 32 32s-14.3 32-32 32H160v64c0 12.9-7.8 24.6-19.8 29.6s-25.7 2.2-34.9-6.9l-96-96c-6-6-9.4-14.1-9.4-22.6s3.4-16.6 9.4-22.6l96-96c9.2-9.2 22.9-11.9 34.9-6.9s19.8 16.6 19.8 29.6l0 64H480z"/></svg>
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

            <div id="informe-previa" data-scroll></div>

          </div>
            
          <div id="informe-contenedor-izquierda" class="filas" style="height: 75vh; position: relative; justify-content: flex-start;" data-scroll-invisible>
          
            <div class="columnas">
              
              <div>
                
                <label class="requerido">Tipo de informe médico</label>
                <select data-valor="tipo" class="informe-valores  upper lleno">
                  <option value="0">Resumido</option>
                  <option value="1">Completo</option>
                  <option value="2">Simple</option>
                </select>
                
              </div>

            </div>

            <div class="columnas">
              
              <div>
                <label class="requerido">Motivos / antecedentes / simple</label>
                <textarea rows="4" id="informe-informacion" data-previa="informe-previa" data-valor="contenido" class="informe-valores upper lleno textarea-espaciado contenedor-personalizable" style="resize:none;" data-scroll title="
                  Resumido -> EL CONTENIDO SERÁ UTILIZADO PARA LOS MOTIVOS DEL INFORME&#013Completo -> EL CONTENIDO SERÁ UTILIZADO PARA LOS ANTECEDENTES DEL INFORME&#013Simple -> EL CONTENIDO SERÁ UTILIZADO COMO MODELO DE TODO EL REPORTE
                "></textarea>
              </div>

            </div>

            <section id="informes-completo-contenedor">
              
              <div class="columnas">
                
                <div>     
                  <label>Control</label>
                  <textarea rows="4" id="informe-control" data-previa="informe-previa" data-valor="control" class="informe-valores upper textarea-espaciado contenedor-personalizable" style="resize:none;" data-scroll ></textarea>
                </div>

              </div>

              <div class="columnas">
                
                <div>     
                  <label>Plan o indicaciones</label>
                  <textarea rows="4" id="informe-plan" data-previa="informe-previa" data-valor="plan" class="informe-valores upper textarea-espaciado contenedor-personalizable" style="resize:none;" data-scroll title="Resumido -> EL CONTENIDO SERÁ UTILIZADO PARA LAS INDICACIONES DEL INFORME&#013Completo -> EL CONTENIDO SERÁ UTILIZADO PARA EL PLAN DEL INFORME
                "></textarea>
                </div>

              </div>

              <section style="border-bottom: 1px dashed #b9a3cb; width: 100%; height: 1px;"></section>

              <div class="columnas" style="flex-direction: column; align-items: baseline;">

                <label>Agudeza visual - 4m</label>

                <div style="margin: 0px; flex-direction: row; column-gap: 10px;">
                  <div>    
                    <input type="text" data-valor="agudeza_od_4" class="informe-valores upper fracciones" placeholder="OD">
                  </div>

                  <div>
                    <input type="text" data-valor="agudeza_oi_4" class="informe-valores upper fracciones" placeholder="OI">
                  </div>  
                </div>

              </div>

              <div class="columnas">
                
                <div class="check-alineado">
                  <label>Con corrección - 4m</label>        
                  <input type="checkbox" data-valor="correccion_4" class="informe-valores check checksmall" style="width: 30px; height: 30px">
                </div>

              </div>

              <section style="border-bottom: 1px dashed #b9a3cb; width: 100%; height: 1px;"></section>

              <div class="columnas" style="flex-direction: column; align-items: baseline;">

                <label>Agudeza visual - 1.5m</label>

                <div style="margin: 0px; flex-direction: row; column-gap: 10px;">
                  <div>    
                    <input type="text" data-valor="agudeza_od_1" class="informe-valores upper fracciones" placeholder="OD">
                  </div>

                  <div>
                    <input type="text" data-valor="agudeza_oi_1" class="informe-valores upper fracciones" placeholder="OI">
                  </div>  
                </div>

              </div>

              <div class="columnas">
                
                <div class="check-alineado">
                  <label>Con corrección - 1.5m</label>        
                  <input type="checkbox" data-valor="correccion_1" class="informe-valores check checksmall" style="width: 30px; height: 30px">
                </div>

              </div>

              <section style="border-bottom: 1px dashed #b9a3cb; width: 100%; height: 1px;"></section>

              <div class="columnas" style="flex-direction: column; align-items: baseline;">

                <label>Agudeza visual - Lectura</label>

                <div style="margin: 0px; flex-direction: row; column-gap: 10px;">
                  <div>    
                    <input type="text" data-valor="agudeza_od_lectura" class="informe-valores upper" placeholder="OD">
                  </div>

                  <div>
                    <input type="text" data-valor="agudeza_oi_lectura" class="informe-valores upper" placeholder="OI">
                  </div>  
                </div>

              </div>

              <div class="columnas">
                
                <div class="check-alineado">
                  <label>Con corrección - Lectura</label>        
                  <input type="checkbox" data-valor="correccion_lectura" class="informe-valores check checksmall" style="width: 30px; height: 30px">
                </div>

              </div>

              <section style="border-bottom: 1px dashed #b9a3cb; width: 100%; height: 1px;"></section>

              <div class="columnas">

                <div>  
                  <label>Estereopsis</label>  
                  <input type="text" data-valor="estereopsis" class="informe-valores upper" placeholder="00s">
                </div>

                <div>
                  <label>Ishihara</label>
                  <input type="text" data-valor="test" class="informe-valores upper fracciones" placeholder="00/00">
                </div>

                <div>
                  <label>Stereo Fly</label>
                  <input type="text" data-valor="reflejo" class="informe-valores upper" placeholder="00s">
                </div>  

              </div>

              <div class="columnas">
                
                <div>     
                  <label>Motilidad</label>
                  <textarea rows="4" id="informe-motilidad" data-previa="informe-previa" data-valor="motilidad" class="informe-valores upper textarea-espaciado contenedor-personalizable" style="resize:none;" data-scroll ></textarea>
                </div>

              </div>

              <div class="columnas" style="flex-direction: column; align-items: baseline;">

                <label>
                  RX
                  <input type="checkbox" data-valor="rx_cicloplegia" class="informe-valores check" title="CICLOPLEGIA">
                </label>

                <div style="margin: 0px; flex-direction: column; row-gap: 10px;">
                  <div style="flex-direction: row; justify-content: center; align-items: center;">
                    <label style="padding-right: 3px">OD:</label>
                    <input type="checkbox" data-valor="rx_od_signo_1" class="informe-valores check checksigno">
                    <input type="text" data-valor="rx_od_valor_1" class="informe-valores upper decimales" placeholder="0.00">
                    <input type="checkbox" data-valor="rx_od_signo_2" class="informe-valores check checksigno">
                    <input type="text" data-valor="rx_od_valor_2" class="informe-valores upper decimales" placeholder="0.00">
                    <span   class="informe-separador">X</span>
                    <input type="text" data-valor="rx_od_grados" class="informe-valores upper" placeholder="0">
                    <span   class="informe-grado">°</span>
                    <span   class="informe-igual">=</span>
                    <input type="text" data-valor="rx_od_resultado" class="informe-valores upper fracciones" placeholder="00/00">
                  </div>

                  <div style="flex-direction: row; justify-content: center; align-items: center;">
                    <label style="padding-right: 9px">OI:</label>
                    <input type="checkbox" data-valor="rx_oi_signo_1" class="informe-valores check checksigno">
                    <input type="text" data-valor="rx_oi_valor_1" class="informe-valores upper decimales" placeholder="0.00">
                    <input type="checkbox" data-valor="rx_oi_signo_2" class="informe-valores check checksigno">
                    <input type="text" data-valor="rx_oi_valor_2" class="informe-valores upper decimales" placeholder="0.00">
                    <span   class="informe-separador">X</span>
                    <input type="text" data-valor="rx_oi_grados" class="informe-valores upper" placeholder="0">
                    <span   class="informe-grado">°</span>
                    <span   class="informe-igual">=</span>
                    <input type="text" data-valor="rx_oi_resultado" class="informe-valores upper fracciones" placeholder="00/00">
                  </div>
                </div>

              </div>

              <div class="columnas">
                
                <div>     
                  <label>Biomicroscopia</label>
                  <textarea rows="2" id="informe-biomicroscopia" data-previa="informe-previa" data-valor="biomicroscopia" class="informe-valores upper textarea-espaciado contenedor-personalizable" style="resize:none;" data-scroll ></textarea>
                </div>

              </div>

              <div class="columnas" style="flex-direction: column; align-items: baseline;">

                <label>PIO</label>

                <div style="margin: 0px; flex-direction: row; column-gap: 10px;">
                  <div>    
                    <input type="text" data-valor="pio_od" class="informe-valores upper decimales" placeholder="OD - 0.00mmHg">
                  </div>

                  <div>
                    <input type="text" data-valor="pio_oi" class="informe-valores upper decimales" placeholder="OI - 0.00mmHg">
                  </div>  
                </div>

              </div>

              <div class="columnas">
                
                <div>     
                  <label>Fondo de ojo</label>
                  <textarea rows="2" id="informe-fondo" data-previa="informe-previa" data-valor="fondo_ojo" class="informe-valores upper textarea-espaciado contenedor-personalizable" style="resize:none;" data-scroll ></textarea>
                </div>

              </div>

              <div class="columnas">
                
                <div style="position:relative;">

                  <label>
                    <button id="insertar-nueva-diagnostico" class="boton-ver contenedor-resaltar" title="Cargar nuevo diagnóstico" style="left: 105px;">+</button>
                    IDX:
                  </label>
                  
                  <style>
                    #cc-diagnosticos-informes .ccContenedor {
                       width: 95%;
                    }
                  </style>  

                  <section id="cc-diagnosticos-informes" class="contenedor-consulta informe-valores borde-estilizado" data-valor="diagnosticos">

                    <input type="text" data-estilo="cc-input" class="upper" data-minimo="0" data-ocultar="0" placeholder="Buscar diagnósticos" title="[ENTER] para forzar actualización">
                    <select id="informe-combo" data-limit="" data-estilo="cc-select" placeholder="Buscar diagnóstico" data-size="5" data-ocultar="1" data-hide data-absoluto="1" data-scroll style="
                      height: auto;
                      border: 1px dashed #5eb6fb;
                      border-top: none;
                      background: #ddf4ffc2;
                      padding: 0px 5px;
                      margin: 0px;
                      color: black;
                    "></select>
                    <div data-estilo="cc-div" style="background: #fff; min-height: 80px; max-height: 85px; border: none;" data-scroll></div>

                  </section>

                </div>

              </div>

            </section>

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

          <input type="text" autocomplete="off" id="informe-busqueda" class="upper borde-estilizado boton-busqueda">

        </div>

        <div class="tabla-ppal borde-estilizado" data-scroll>

          <table id="tabla-informe" class="table table-bordered table-striped">
            <thead>
            </thead>
            <tbody>
            </tbody>
          </table>
          
        </div>

      </div>

    </div>

</section>

<!-------------------------------------------------------- -->
<!------------------- INSERTAR DIAGNOSTICO --------------- -->
<!-------------------------------------------------------- -->
<div id="crud-insertar-diagnostico-popup" class="popup-oculto" data-crud='popup'>
  <div id="crud-insertar-diagnostico-pop" class="popup-oculto" style="width: 50%">
    <button id="crud-insertar-diagnostico-cerrar" data-crud='cerrar'>X</button>
    <section id="crud-insertar-diagnostico-titulo" data-crud='titulo'>
      AGREGAR DIAGNÓSTICO
    </section> 

    <div class="filas">

      <div class="columnas" style="align-items: baseline;">

        <div>
          <label class="requerido">Nombre</label>  
          <input type="text" placeholder="Nombre del diagnóstico" class="insertar-diagnostico lleno upper">
        </div>
      </div>
    </div>

    <section id="crud-insertar-diagnostico-botones" data-crud='botones' style="column-gap: 10px">
      <button class="botones-formularios insertar">CONFIRMAR</button>
      <button class="botones-formularios cerrar">CANCELAR</button> 
    </section>

  </div>
</div>