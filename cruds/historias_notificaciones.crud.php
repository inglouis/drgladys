<!-------------------------------------------------------- -->
<!-------------- NOTIFICACIONES TEMPLATE ----------------- -->
<!-------------------------------------------------------- -->
<template id="notificaciones-template">

  <section class="notificaciones-contenedor">

  	<div class="notificaciones-contenido">
  		
	  	<div class="reporte"></div>
	  	<div class="nombre"></div>

  	</div>

  </section>

</template>


<!-------------------------------------------------------- -->
<!-------------- NOTIFICADOS TEMPLATE ----------------- -->
<!-------------------------------------------------------- -->
<template id="notificados-template">

  <section class="notificados-contenedor">
  	
  	<button class="btn eliminar" title="Confirmar finalización de la revisión del reporte">
  		<svg style="width:10px; height: 10px" class="iconos" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><path fill="currentColor" d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/></svg>
  	</button>

  	<div class="notificados-contenido">
  		
	  	<div class="reporte"></div>
	  	<div class="nombre"></div>

  	</div>

  </section>

</template>

<!------------------------------------------------------------------- -->
<!------------------- NOTIFICACIONES DOCTOR ------------------------- -->
<!------------------------------------------------------------------- -->
<div id="crud-notificaciones-popup" class="popup-oculto" data-crud='popup'>
	
	<div id="crud-notificaciones-pop" class="popup-oculto" style="
		min-height: 80%;
	    display: grid;
	    width: 60%;
	    grid-template-rows: auto 1fr auto;
	    justify-content: stretch;
	">

	    <button id="crud-notificaciones-cerrar" data-crud='cerrar'>X</button>

	    <section id="crud-notificaciones-titulo" data-crud='titulo' style="margin-bottom: 5px; border: none;">
	      REVISIÓN DE REPORTES
	    </section>

	    <section id="crud-notificaciones-contenedor">
	      	
	      	<div id="edicion-notificaciones" class="borde-estilizado">

	      		<!-------------------------------------------------------- -->
				<!----------------- CONSTANCIAS CONTENEDOR --------------- -->
				<!-------------------------------------------------------- -->
				<section class="notificaciones-seccion">
				                
				    <div data-familia class="contenedor contenedor-notificaciones" id="constancias-contenedor-notificaciones">

				        <div class="subtitulo">
				          Modificar reporte de constancia
				        </div>

				        <div class="cargar" title="[TAB] para enforcar">

				          <div class="personalizacion-notificaciones" data-hidden>

				            <section>Personalización</section>
				            <section style="width: 100%; border: 1px dashed #fff"></section>
				            <span>ENTER: SEPARAR LÍNEA</span>
				            <span>°CENTRAR°</span>
				            <span>*<b>NEGRITA</b>*</span>
				            <span>_ <u>SUBRAYADO</u> _</span>
				            <span>~<i>ITÁLICA</i>~</span>

				            <div id="constancia-previa-notificaciones" data-scroll></div>

				          </div>
				            
				          <div class="filas" style="height: 100%; position: relative">
				          
				            <div class="columnas" style="height: 100%">
				              
				              <div style="height: 100%; margin: 0px">
				                
				                <label>Motivo de la constancia:</label>
				                <textarea id="constancia-informacion-notificaciones" data-previa="constancia-previa-notificaciones" data-valor="motivo" rows="6" class="constancia-valores-notificaciones upper textarea-espaciado contenedor-personalizable" placeholder="Cargar información..." style="resize: none" data-scroll></textarea>

				              </div>

				            </div>

				            <div class="columnas">
				              
				              <div>
				                
				                <label class="requerido">Recomendaciones:</label>
				                <textarea id="constancia-recomendaciones-notificaciones" data-previa="constancia-previa-notificaciones" data-valor="recomendaciones" rows="6" class="constancia-valores-notificaciones upper lleno textarea-espaciado contenedor-personalizable" placeholder="Cargar información..." style="resize: none; height: 15vh" data-scroll></textarea>

				              </div>

				            </div>

				            <div class="columnas">

								<div class="check-alineado">
									<label>Es menor de edad</label>        
									<input type="checkbox" data-valor="menor" class="constancia-valores-notificaciones check checksmall" style="width: 30px; height: 30px">
								</div>

								</div>

								<div class="columnas">

								<div class="check-alineado">
									<label>Priorizar en aula</label>        
									<input type="checkbox" data-valor="aula" class="constancia-valores-notificaciones check checksmall" style="width: 30px; height: 30px">
								</div>

							</div>

				          </div>

				          <div class="botones-reportes" style="justify-content: center;">
				            <button class="reporte-actualizar">CONFIRMAR CAMBIOS</button>
				          </div>

				        </div>

				    </div>

				</section>

				<!-------------------------------------------------------- -->
				<!-------------------- INFORMES CONTENEDOR --------------- -->
				<!-------------------------------------------------------- -->
				<section class="notificaciones-seccion" data-hide data-efecto="aparecer">
				                
				    <div data-familia class="contenedor contenedor-notificaciones" id="informes-contenedor-notificaciones" data-scroll style="justify-content: flex-start; overflow-x: hidden; height: 72vh;">

				      <div class="subtitulo">
				        Modificar reporte de informe médico
				      </div>

				      <div class="cargar" title="[TAB] para enforcar" style="height: auto">

				        <div class="personalizacion-c" data-hidden style="right: 20%; top: 35% !important;">

				          <section>Personalización</section>
				          <section style="width: 100%; border: 1px dashed #fff"></section>
				          <span>ENTER: SEPARAR LÍNEA</span>
				          <span>°CENTRAR°</span>
				          <span>*<b>NEGRITA</b>*</span>
				          <span>_ <u>SUBRAYADO</u> _</span>
				          <span>~<i>ITÁLICA</i>~</span>

				          <div id="informe-previa-notificaciones" data-scroll></div>

				        </div>
				          
				        <div class="filas" style="height: 100%; position: relative">

				        <div class="columnas">
					              
					        <div>
					          
					          <label class="requerido">Tipo de informe médico</label>
					          <select data-valor="tipo" class="informe-valores-notificaciones  upper lleno">
					            <option value="0">Resumido</option>
					            <option value="1">Completo</option>
					            <option value="2">Simple</option>
					          </select>
					          
					        </div>

					      </div>

				          <div class="columnas">
        
					        <div>
					          <label class="requerido">Motivos o antecedentes</label>
					          <textarea rows="4" id="informe-informacion-notificaciones" data-previa="informe-previa-notificaciones" data-valor="contenido" class="informe-valores-notificaciones upper lleno textarea-espaciado contenedor-personalizable" style="resize:none;" data-scroll title="
					            Resumido -> EL CONTENIDO SERÁ UTILIZADO PARA LOS MOTIVOS DEL INFORME&#013Completo -> EL CONTENIDO SERÁ UTILIZADO PARA LOS ANTECEDENTES DEL INFORME&#013Simple -> EL CONTENIDO SERÁ UTILIZADO COMO MODELO DE TODO EL REPORTE
					          "></textarea>
					        </div>

					      </div>

					      <div class="columnas">
					                
					        <div>     
					          <label>Control</label>
					          <textarea rows="4" id="informe-control-notificaciones" data-previa="informe-previa-notificaciones" data-valor="control" class="informe-valores-notificaciones upper textarea-espaciado contenedor-personalizable" style="resize:none;" data-scroll ></textarea>
					        </div>

					      </div>

					      <div class="columnas">
                
			                <div>     
			                  <label>Plan o indicaciones</label>
			                  <textarea rows="4" id="informe-plan-notificaciones" data-previa="informe-previa-notificaciones" data-valor="plan" class="informe-valores-notificaciones upper textarea-espaciado contenedor-personalizable" style="resize:none;" data-scroll title="Resumido -> EL CONTENIDO SERÁ UTILIZADO PARA LAS INDICACIONES DEL INFORME&#013Completo -> EL CONTENIDO SERÁ UTILIZADO PARA EL PLAN DEL INFORME
			                "></textarea>
			                </div>

			              </div>

					      <section style="border-bottom: 1px dashed #b9a3cb; width: 100%; height: 1px;"></section>

					      <div class="columnas" style="flex-direction: column; align-items: baseline;">

					        <label>Agudeza visual - 4m</label>

					        <div style="margin: 0px; flex-direction: row; column-gap: 10px;">
					          <div>    
					            <input type="text" data-valor="agudeza_od_4" class="informe-valores-notificaciones upper decimales" placeholder="OD">
					          </div>

					          <div>
					            <input type="text" data-valor="agudeza_oi_4" class="informe-valores-notificaciones upper decimales" placeholder="OI">
					          </div>  
					        </div>

					      </div>

					      <div class="columnas">
					        
					        <div class="check-alineado">
					          <label>Con corrección - 4m</label>        
					          <input type="checkbox" data-valor="correccion_4" class="informe-valores-notificaciones check checksmall" style="width: 30px; height: 30px">
					        </div>

					      </div>

					      <section style="border-bottom: 1px dashed #b9a3cb; width: 100%; height: 1px;"></section>

					      <div class="columnas" style="flex-direction: column; align-items: baseline;">

					        <label>Agudeza visual - 1.5m</label>

					        <div style="margin: 0px; flex-direction: row; column-gap: 10px;">
					          <div>    
					            <input type="text" data-valor="agudeza_od_1" class="informe-valores-notificaciones upper decimales" placeholder="OD">
					          </div>

					          <div>
					            <input type="text" data-valor="agudeza_oi_1" class="informe-valores-notificaciones upper decimales" placeholder="OI">
					          </div>  
					        </div>

					      </div>

					      <div class="columnas">
					        
					        <div class="check-alineado">
					          <label>Con corrección - 1.5m</label>        
					          <input type="checkbox" data-valor="correccion_1" class="informe-valores-notificaciones check checksmall" style="width: 30px; height: 30px">
					        </div>

					      </div>

					      <section style="border-bottom: 1px dashed #b9a3cb; width: 100%; height: 1px;"></section>

					      <div class="columnas" style="flex-direction: column; align-items: baseline;">

					        <label>Agudeza visual - Lectura</label>

					        <div style="margin: 0px; flex-direction: row; column-gap: 10px;">
					          <div>    
					            <input type="text" data-valor="agudeza_od_lectura" class="informe-valores-notificaciones upper decimales" placeholder="OD">
					          </div>

					          <div>
					            <input type="text" data-valor="agudeza_oi_lectura" class="informe-valores-notificaciones upper decimales" placeholder="OI">
					          </div>  
					        </div>

					      </div>

					      <div class="columnas">
					        
					        <div class="check-alineado">
					          <label>Con corrección - Lectura</label>        
					          <input type="checkbox" data-valor="correccion_lectura" class="informe-valores-notificaciones check checksmall" style="width: 30px; height: 30px">
					        </div>

					      </div>

					      <section style="border-bottom: 1px dashed #b9a3cb; width: 100%; height: 1px;"></section>

					      <div class="columnas">

					        <div>  
					          <label>Estereopsis</label>  
					          <input type="text" data-valor="estereopsis" class="informe-valores-notificaciones upper" placeholder="00s">
					        </div>

					        <div>
					          <label>Ishihara</label>
					          <input type="text" data-valor="test" class="informe-valores-notificaciones upper" placeholder="00/00">
					        </div>

					        <div>
					          <label>Stereo Fly</label>
					          <input type="text" data-valor="reflejo" class="informe-valores-notificaciones upper" placeholder="00/00">
					        </div>  

					      </div>

					      <div class="columnas">
					        
					        <div>     
					          <label>Motilidad</label>
					          <textarea rows="4" id="informe-motilidad-notificaciones" data-previa="informe-previa-notificaciones" data-valor="motilidad" class="informe-valores-notificaciones upper textarea-espaciado contenedor-personalizable" style="resize:none;" data-scroll ></textarea>
					        </div>

					      </div>

					      <div class="columnas" style="flex-direction: column; align-items: baseline;">

					        <label>
					        	RX
					        	<input type="checkbox" data-valor="rx_cicloplegia" class="informe-valores-notificaciones check" title="CICLOPLEGIA">
					        </label>

					        <div style="margin: 0px; flex-direction: column; row-gap: 10px;">
					          <div style="flex-direction: row; justify-content: center; align-items: center;">
					            <label style="padding-right: 3px">OD:</label>
					            <input type="checkbox" data-valor="rx_od_signo_1" class="informe-valores-notificaciones check checksigno">
					            <input type="text" data-valor="rx_od_valor_1" class="informe-valores-notificaciones upper decimales" placeholder="0.00">
					            <input type="checkbox" data-valor="rx_od_signo_2" class="informe-valores-notificaciones check checksigno">
					            <input type="text" data-valor="rx_od_valor_2" class="informe-valores-notificaciones upper decimales" placeholder="0.00">
					            <span   class="informe-separador">X</span>
					            <input type="text" data-valor="rx_od_grados" class="informe-valores-notificaciones upper" placeholder="0">
					            <span   class="informe-grado">°</span>
					            <span   class="informe-igual">=</span>
					            <input type="text" data-valor="rx_od_resultado" class="informe-valores-notificaciones upper" placeholder="00/00">
					          </div>

					          <div style="flex-direction: row; justify-content: center; align-items: center;">
					            <label style="padding-right: 9px">OI:</label>
					            <input type="checkbox" data-valor="rx_oi_signo_1" class="informe-valores-notificaciones check checksigno">
					            <input type="text" data-valor="rx_oi_valor_1" class="informe-valores-notificaciones upper decimales" placeholder="0.00">
					            <input type="checkbox" data-valor="rx_oi_signo_2" class="informe-valores-notificaciones check checksigno">
					            <input type="text" data-valor="rx_oi_valor_2" class="informe-valores-notificaciones upper decimales" placeholder="0.00">
					            <span   class="informe-separador">X</span>
					            <input type="text" data-valor="rx_oi_grados" class="informe-valores-notificaciones upper" placeholder="0">
					            <span   class="informe-grado">°</span>
					            <span   class="informe-igual">=</span>
					            <input type="text" data-valor="rx_oi_resultado" class="informe-valores-notificaciones upper" placeholder="00/00">
					          </div>
					        </div>

					      </div>

					      <div class="columnas">
                
			                <div>     
			                  <label>Biomicroscopia</label>
			                  <textarea rows="2" id="informe-biomicroscopia-notificaciones" data-previa="informe-previa-notificaciones" data-valor="biomicroscopia" class="informe-valores-notificaciones upper textarea-espaciado contenedor-personalizable" style="resize:none;" data-scroll ></textarea>
			                </div>

			              </div>

					      <div class="columnas" style="flex-direction: column; align-items: baseline;">

					        <label>PIO</label>

					        <div style="margin: 0px; flex-direction: row; column-gap: 10px;">
					          <div>    
					            <input type="text" data-valor="pio_od" class="informe-valores-notificaciones upper decimales" placeholder="OD - 0.00mmHg">
					          </div>

					          <div>
					            <input type="text" data-valor="pio_oi" class="informe-valores-notificaciones upper decimales" placeholder="OI - 0.00mmHg">
					          </div>  
					        </div>

					      </div>

					      <div class="columnas">
                
			                <div>     
			                  <label>Fondo de ojo</label>
			                  <textarea rows="2" id="informe-fondo-notificaciones" data-previa="informe-previa-notificaciones" data-valor="fondo_ojo" class="informe-valores-notificaciones upper textarea-espaciado contenedor-personalizable" style="resize:none;" data-scroll ></textarea>
			                </div>

			              </div>

					      <div class="columnas">
					        
					        <div style="position:relative;">

					          <label>
					            IDX:
					          </label>
					          
					          <style>
					            #cc-diagnosticos-informe .ccContenedor {
					               width: 95%;
					            }
					          </style>  

					          <section id="cc-diagnosticos-informe-notificaciones" class="contenedor-consulta informe-valores-notificaciones borde-estilizado" data-valor="diagnosticos">

					            <input type="text" data-estilo="cc-input" class="upper" data-minimo="0" data-ocultar="0" placeholder="Buscar diagnósticos" title="[ENTER] para forzar actualización">
					            <select id="informe-combo-notificaciones" data-limit="" data-estilo="cc-select" placeholder="Buscar diagnóstico" data-size="5" data-ocultar="1" data-hide data-absoluto="1" data-scroll style="
					              height: auto;
					              border: 1px dashed #5eb6fb;
					              border-top: none;
					              background: #ddf4ffc2;
					              padding: 0px 5px;
					              margin: 0px;
					              color: black;
					            "></select>
					            <div data-estilo="cc-div" style="background: #fff; min-height: 80px; max-height: 85px; border: none; display: flex;" data-scroll></div>

					          </section>

					        </div>

					      </div>

				        </div>

				        <div class="botones-reportes" style="justify-content: center;">
				          <button class="reporte-actualizar">CONFIRMAR CAMBIOS</button>
				        </div>

				      </div>

				    </div>

				</section>

				<!-------------------------------------------------------- -->
				<!----------------- REFERENCIAS CONTENEDOR --------------- -->
				<!-------------------------------------------------------- -->
				<section class="notificaciones-seccion" data-hide data-efecto="aparecer">
				                
				    <div data-familia class="contenedor contenedor-notificaciones" id="informes-contenedor-notificaciones">

				      <div class="subtitulo">
				        Modificar reporte de referencia
				      </div>

				      <div class="cargar" title="[TAB] para enforcar">

				        <div class="personalizacion-notificaciones" data-hidden>

				          <section>Personalización</section>
				          <section style="width: 100%; border: 1px dashed #fff"></section>
				          <span>ENTER: SEPARAR LÍNEA</span>
				          <span>°CENTRAR°</span>
				          <span>*<b>NEGRITA</b>*</span>
				          <span>_ <u>SUBRAYADO</u> _</span>
				          <span>~<i>ITÁLICA</i>~</span>

				          <div id="referencia-previa-notificaciones" data-scroll></div>

				        </div>
				          
				        <div class="filas" style="height: 100%; position: relative">

				          <div class="columnas" style="height: 100%">

					        <div style="height: 100%">
					          
								<label class="requerido">Referencia para:</label>
								<section data-grupo="cc-referencias-referencia-notificaciones" class="combo-consulta">
									<input type="text" autocomplete="off"  data-limit="" placeholder="Buscar..." class="upper">
									<select class="referencia-valores-notificaciones upper visual" data-valor="id_referencia" data-scroll style="color:#262626"></select>
								</section>

					        </div>

					      </div>

					      <div class="columnas">
					        
					        <div>
						        <label class="requerido">Motivo de la referencia</label>
						        <textarea rows="4" id="referencia-informacion-notificaciones" data-previa="referencia-previa-notificaciones" data-valor="motivo" class="referencia-valores-notificaciones upper lleno textarea-espaciado contenedor-personalizable" style="resize:none; min-height: 15vh;" data-scroll></textarea>
					        </div>

					      </div>

					      <div class="columnas">
					        
					        <div>
					          
					            <label>Se recomienda a:</label>
					            <section data-grupo="cc-referencias-referido-notificaciones" class="combo-consulta">
					            	<input type="text" autocomplete="off"  data-limit="" placeholder="Buscar..." class="upper">
					            	<select class="referencia-valores-notificaciones upper visual" data-valor="id_medico_referido" data-scroll style="color:#262626"></select>
					            </section>

					        </div>

					      </div>

					      <div class="columnas" >
					              
					        <div>
					            <label class="requerido">Se agradece:</label>
					            <textarea rows="4" id="referencia-agradecimiento-notificaciones" data-previa="referencia-previa-notificaciones" data-valor="agradecimiento" class="referencia-valores-notificaciones upper lleno textarea-espaciado contenedor-personalizable" style="resize:none; min-height: 15vh;" data-scroll></textarea>
					        </div>

					      </div>

				        </div>

				        <div class="botones-reportes" style="justify-content: center;">
				          <button class="reporte-actualizar">CONFIRMAR CAMBIOS</button>
				        </div>

				      </div>

				    </div>

				</section>

				<!-------------------------------------------------------- -->
				<!---------------- PRESUPUESTOS CONTENEDOR --------------- -->
				<!-------------------------------------------------------- -->
				<section class="notificaciones-seccion" data-hide>
				                
				    <div data-familia class="contenedor contenedor-notificaciones" id="presupuestos-contenedor-notificaciones">

				      <div class="subtitulo">
				        Modificar reporte de presupuesto
				      </div>

				      <div class="cargar" title="[TAB] para enforcar">

				        <div class="personalizacion-notificaciones" data-hidden>

				          <section>Personalización</section>
				          <section style="width: 100%; border: 1px dashed #fff"></section>
				          <span>ENTER: SEPARAR LÍNEA</span>
				          <span>°CENTRAR°</span>
				          <span>*<b>NEGRITA</b>*</span>
				          <span>_ <u>SUBRAYADO</u> _</span>
				          <span>~<i>ITÁLICA</i>~</span>

				          <div id="presupuesto-previa-notificaciones" data-scroll></div>

				        </div>
				          
				        <div class="filas" style="height: 100%; position: relative">

				          <div class="columnas" >
				            
				            <div>
				              <label class="requerido">Nombre completo</label>
				              <input type="text" data-valor="nombre_completo" class="presupuesto-valores-notificaciones upper lleno presupuesto-representante-valores">
				            </div>

				          </div>

				          <div class="columnas" >
				            
				            <div>
				              <label class="requerido">Cédula</label>
				              <input type="text" data-valor="cedula" class="presupuesto-valores-notificaciones upper lleno presupuesto-representante-valores">
				            </div>        

				          </div>

				          <div class="columnas" style="height: 100%">
				            
				            <div style="height: 100%; margin: 0px">
				              
				              <label class="requerido">Presupuesto</label>
				              <textarea id="presupuesto-informacion-notificaciones" data-previa="presupuesto-previa-notificaciones" data-valor="presupuesto" rows="6" class="presupuesto-valores-notificaciones upper lleno textarea-espaciado contenedor-personalizable" placeholder="Cargar información..." style="resize: none" data-scroll></textarea>

				            </div>

				          </div>

				        </div>

				        <div class="botones-reportes" style="justify-content: center;">
				          <button class="reporte-actualizar">CONFIRMAR CAMBIOS</button>
				        </div>

				      </div>

				    </div>

				</section>

				<!-------------------------------------------------------- -->
				<!--------------------- REPOSOS CONTENEDOR --------------- -->
				<!-------------------------------------------------------- -->
				<section class="notificaciones-seccion" data-hide>
				                
				    <div data-familia class="contenedor contenedor-notificaciones" id="reposos-contenedor-notificaciones">

				        <div class="subtitulo">
				          Modificar reporte de reposo
				        </div>

				        <div class="cargar" title="[TAB] para enforcar">

				          <div class="personalizacion-notificaciones" data-hidden>

				            <section>Personalización</section>
				            <section style="width: 100%; border: 1px dashed #fff"></section>
				            <span>ENTER: SEPARAR LÍNEA</span>
				            <span>°CENTRAR°</span>
				            <span>*<b>NEGRITA</b>*</span>
				            <span>_ <u>SUBRAYADO</u> _</span>
				            <span>~<i>ITÁLICA</i>~</span>

				            <div id="reposo-previa-notificaciones" data-scroll></div>

				          </div>
				            
				          <div class="filas" style="position: relative">
				          
				          	<div class="columnas">
        
						        <div>
						          <label class="requerido">Cabecera del reporte</label>
						          <select data-valor="cabecera" class="reposo-valores-notificaciones upper lleno">
						            <option value="0">Por intervención quirúrgica</option>
						            <option value="1">Por presentar un motivo</option>
						          </select>
						        </div>

						    </div>

				            <div class="columnas">
				              
				              <div style="margin: 0px">
				                
				                <label class="requerido">Motivo de la cabecera</label>
				                <textarea id="reposo-informacion-notificaciones" data-previa="reposo-previa-notificaciones" data-valor="reposo" rows="6" class="reposo-valores-notificaciones upper lleno textarea-espaciado contenedor-personalizable" placeholder="Cargar información..." style="resize: none" data-scroll></textarea>

				              </div>

				            </div>

				            <div class="columnas">

						        <div style="margin:0px">
						          <label>Representante</label>        
						          <input type="checkbox" data-valor="representante" class="reposo-valores-notificaciones check checksmall" style="width: 30px; height: 30px">
						        </div>

					      	</div>

				            <div class="columnas">

						        <div style="margin:0px">
						          <label>Recomendaciones</label>        
						          <input type="checkbox" data-valor="recomendaciones" class="reposo-valores-notificaciones check checksmall" style="width: 30px; height: 30px">
						        </div>

					      	</div>

					      	<div class="columnas">
						        <div>
						          <label>Recomendaciones tiempo</label>
						          <input type="text" data-valor="recomendaciones_tiempo" class="reposo-valores-notificaciones upper">
						        </div>
						    </div>

						    <div class="columnas">

						        <div style="margin: 0px" title="FECHA SOBRE LA CUÁL SE APLICAN LOS DÍAS AL CALCULAR EL REPOSO">
						          <label class="requerido">FECHA INICIAL DEL REPOSO:</label>
						          <input type="date" id="reposos-inicio-notificaciones" data-valor="fecha_inicio" class="reposo-valores-notificaciones lleno textarea-espaciado">
						        </div>
					        
					    	</div>

				            <div class="columnas" style="margin: 5px 0px;">

				              <div style="margin: 0px">
				                <label class="requerido">DÍAS DE REPOSO:</label>
				                <input type="text" data-valor="dias" id="reposos-dias-notificaciones" placeholder="0" class="reposo-valores-notificaciones lleno">
				              </div>
				              
				            </div>

				            <div class="columnas" style="margin: 5px 0px;">

				              <div style="margin: 0px">
				                <label class="requerido">FECHA FINAL DEL REPOSO:</label>
				                <input type="date" data-valor="fecha_final" id="reposos-fin-notificaciones" class="reposo-valores-notificaciones lleno" disabled>
				              </div>
				              
				            </div>

				            <div class="columnas" style="margin: 5px 0px;">
				              <div style="margin-bottom: 5px;">
				                <input type="text" data-valor="fecha_simple" id="reposos-fecha-notificaciones" class="reposo-valores-notificaciones lleno visual" disabled style="height: 20px; padding: 5px; border: 1px dashed #262626">
				              </div>
				            </div>

				          </div>

				          <div class="botones-reportes" style="justify-content: center;">
				            <button class="reporte-actualizar">CONFIRMAR CAMBIOS</button>
				          </div>

				        </div>

				    </div>

				</section>

				<!-------------------------------------------------------- -->
				<!----------------- GENERALES CONTENEDOR ----------------- -->
				<!-------------------------------------------------------- -->
				<section class="notificaciones-seccion" data-hide>
				                
				    <div data-familia class="contenedor contenedor-notificaciones" id="generales-contenedor-notificaciones">

				      <div class="subtitulo">
				        Modificar reporte de información general
				      </div>

				      <div class="cargar" title="[TAB] para enforcar">

				        <div class="personalizacion-notificaciones" data-hidden>

				          <section>Personalización</section>
				          <section style="width: 100%; border: 1px dashed #fff"></section>
				          <span>ENTER: SEPARAR LÍNEA</span>
				          <span>°CENTRAR°</span>
				          <span>*<b>NEGRITA</b>*</span>
				          <span>_ <u>SUBRAYADO</u> _</span>
				          <span>~<i>ITÁLICA</i>~</span>

				          <div id="general-previa-notificaciones" data-scroll></div>

				        </div>
				          
				        <div class="filas" style="height: 100%; position: relative">
				        
				          <div class="columnas" >
				            
				            <div>
				              <label class="requerido">Título</label>
				              <input type="text" id="general-titulo-notificaciones" data-valor="titulo" class="general-valores-notificaciones upper lleno">
				            </div>        

				          </div>

				          <div class="columnas" style="height: 100%;">

				            <div style="height: 100%; margin: 0px">
				              <label class="requerido">Información</label>
				              <textarea id="general-informacion-notificaciones" data-previa="general-previa-notificaciones" data-valor="general" rows="6" class="general-valores-notificaciones upper lleno textarea-espaciado contenedor-personalizable" placeholder="Cargar información..." style="resize: none" data-scroll></textarea>
				            </div>

				          </div>

				        </div>

				        <div class="botones-reportes" style="justify-content: center;">
				          <button class="reporte-actualizar">CONFIRMAR CAMBIOS</button>
				        </div>

				      </div>

				    </div>

				</section>

	      	</div>

			<div id="contenedor-notificaciones" class="tabla-ppal borde-estilizado" data-scroll>

				<table id="tabla-notificaciones" class="table table-bordered table-striped">
					<thead>
					</thead>
					<tbody>
					</tbody>
				</table>

			</div>

	    </section>

  	</div>

</div>