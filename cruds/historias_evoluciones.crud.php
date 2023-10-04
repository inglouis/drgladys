<!--//////////////////////////////////////////////////////////////////////////////////-->
<!--////////////////////////  evoluciones TEMPLATE //////////////////////////////////-->
<!--//////////////////////////////////////////////////////////////////////////////////-->

<!-- <template id="evoluciones-template">

  <section class="evoluciones-contenido">

  </section>

</template> -->

<!------------------------------------------------------------------- -->
<!---------------------- EVOLUCIONES CRUD --------------------------- -->
<!------------------------------------------------------------------- -->
<div id="crud-evoluciones-popup" class="popup-oculto" data-crud='popup'>
  
  <div id="crud-evoluciones-pop" class="popup-oculto" style="min-width: 750px; width: 30%">

    <button id="crud-evoluciones-cerrar" data-crud='cerrar'>X</button>

    <div class="valor-cabecera cabecera-formularios" style="right: 30px;">
      
      <div>
        <label>Paciente:</label>
        <input type="text" autocomplete="off"  data-valor="nombre_completo" class="evoluciones-cargar upper visual" disabled style="width: 10vw; min-width: 150px">
      </div>

      <div>
        <label style="width: 85px;">N° de cédula:</label>
        <input type="text" autocomplete="off"  data-valor="cedula" class="evoluciones-cargar upper visual" disabled style="width: 10vw; min-width: 150px">
      </div>

    </div>

    <div id="crud-evoluciones-contenedor">
        
      <div id="crud-evoluciones-secciones">
        <button>Cargar evolución</button>
        <button>Consultar evoluciones</button>
      </div>

      <!-------------------------------------------------------- -->
      <!------------------- EVOLUCIONES CARGAR ----------------- -->
      <!-------------------------------------------------------- -->
      <section class="evoluciones-seccion">
                      
          <div data-familia class="contenedor" id="evoluciones-cargar-contenedor">

            <section class="radios">
              
              <label class="label-radio-estilizado-1"><input type="radio" name="evoluciones-seccion" title="Examen oftalmológico" class="radio-estilizado-1" checked></label>
              <label class="label-radio-estilizado-1"><input type="radio" name="evoluciones-seccion" title="Pruebas & motilidad" class="radio-estilizado-1"></label>
              <label class="label-radio-estilizado-1"><input type="radio" name="evoluciones-seccion" title="" class="radio-estilizado-1"></label>
              <label class="label-radio-estilizado-1"><input type="radio" name="evoluciones-seccion" title="" class="radio-estilizado-1"></label>
              <label class="label-radio-estilizado-1"><input type="radio" name="evoluciones-seccion" title="" class="radio-estilizado-1"></label>
              <label class="label-radio-estilizado-1"><input type="radio" name="evoluciones-seccion" title="" class="radio-estilizado-1"></label>
              <label class="label-radio-estilizado-1"><input type="radio" name="evoluciones-seccion" title="" class="radio-estilizado-1"></label>

              <button id="crud-evoluciones-consejo">i</button>

            </section>

            <section class="filas borde-estilizado" data-scroll style="padding: 10px; justify-content: flex-start; height: 70vh;">
              
              <div class="columnas">

                <div class="check-alineado" style="column-gap: 5px;">
                  <label>Aplica como paciente problemático</label>
                  <input type="checkbox" data-valor="problematico" class="evoluciones-valores check checkexpresion" style="width: 30px; height: 30px">
                </div>

              </div>

              <div class="columnas">
                
                <div>     
                  <label>Nota inicial:</label>
                  <textarea rows="2" id="evoluciones-nota" data-previa="evoluciones-previa" data-valor="nota" class="evoluciones-valores upper textarea-espaciado contenedor-personalizable" style="resize:none;" data-scroll ></textarea>
                </div>

              </div>

              <div class="titulo">
                <div>1</div>
                <div>Examen oftalmológico</div>
              </div>

              <div class="columnas" style="flex-direction: column; align-items: baseline;">

                <label>Agudeza visual - 4m</label>

                <div style="margin: 0px; flex-direction: row; column-gap: 10px;">
                  <div>    
                    <input type="text" data-valor="agudeza_od_4" class="evoluciones-valores upper fracciones" placeholder="OD">
                  </div>

                  <div>
                    <input type="text" data-valor="agudeza_oi_4" class="evoluciones-valores upper fracciones" placeholder="OI">
                  </div>

                  <div style="width: fit-content;">
                    <input type="checkbox" data-valor="correccion_4" class="evoluciones-valores check checksmall" style="width: 30px; height: 30px">
                  </div>

                  <div style="width: fit-content;">
                    <input type="checkbox" data-valor="allen_4" class="evoluciones-valores check checksmall" style="width: 30px; height: 30px">
                  </div>

                  <div style="width: fit-content;">
                    <input type="checkbox" data-valor="jagger_4" class="evoluciones-valores check checksmall" style="width: 30px; height: 30px">
                  </div>

                  <div style="width: fit-content;">
                    <input type="checkbox" data-valor="e_direccional_4" class="evoluciones-valores check checksmall" style="width: 30px; height: 30px">
                  </div>

                  <div style="width: fit-content;">
                    <input type="checkbox" data-valor="numeros_4" class="evoluciones-valores check checksmall" style="width: 30px; height: 30px">
                  </div>

                  <div style="width: fit-content;">
                    <input type="checkbox" data-valor="decimales_4" class="evoluciones-valores check checksmall" style="width: 30px; height: 30px">
                  </div>

                  <div style="width: fit-content;">
                    <input type="checkbox" data-valor="fracciones_4" class="evoluciones-valores check checksmall" style="width: 30px; height: 30px">
                  </div>

                  <div style="width: fit-content;">
                    <input type="checkbox" data-valor="letras_4" class="evoluciones-valores check checksmall" style="width: 30px; height: 30px">
                  </div>
                </div>

              </div>

              <div class="columnas" style="flex-direction: column; align-items: baseline;">

                <label>Agudeza visual - 1.5m</label>

                <div style="margin: 0px; flex-direction: row; column-gap: 10px;">
                  <div>    
                    <input type="text" data-valor="agudeza_od_1" class="evoluciones-valores upper fracciones" placeholder="OD">
                  </div>

                  <div>
                    <input type="text" data-valor="agudeza_oi_1" class="evoluciones-valores upper fracciones" placeholder="OI">
                  </div>

                  <div style="width: fit-content;">
                    <input type="checkbox" data-valor="correccion_1" class="evoluciones-valores check checksmall" style="width: 30px; height: 30px">
                  </div>

                  <div style="width: fit-content;">
                    <input type="checkbox" data-valor="allen_1" class="evoluciones-valores check checksmall" style="width: 30px; height: 30px">
                  </div>

                  <div style="width: fit-content;">
                    <input type="checkbox" data-valor="jagger_1" class="evoluciones-valores check checksmall" style="width: 30px; height: 30px">
                  </div>

                  <div style="width: fit-content;">
                    <input type="checkbox" data-valor="e_direccional_1" class="evoluciones-valores check checksmall" style="width: 30px; height: 30px">
                  </div>

                  <div style="width: fit-content;">
                    <input type="checkbox" data-valor="numeros_1" class="evoluciones-valores check checksmall" style="width: 30px; height: 30px">
                  </div>

                  <div style="width: fit-content;">
                    <input type="checkbox" data-valor="decimales_1" class="evoluciones-valores check checksmall" style="width: 30px; height: 30px">
                  </div>

                  <div style="width: fit-content;">
                    <input type="checkbox" data-valor="fracciones_1" class="evoluciones-valores check checksmall" style="width: 30px; height: 30px">
                  </div>

                  <div style="width: fit-content;">
                    <input type="checkbox" data-valor="letras_1" class="evoluciones-valores check checksmall" style="width: 30px; height: 30px">
                  </div>
                </div>

              </div>

              <div class="columnas" style="flex-direction: column; align-items: baseline;">

                <label>Agudeza visual - Lectura</label>

                <div style="margin: 0px; flex-direction: row; column-gap: 10px;">
                  <div>    
                    <input type="text" data-valor="agudeza_od_lectura" class="evoluciones-valores upper fracciones" placeholder="OD">
                  </div>

                  <div>
                    <input type="text" data-valor="agudeza_oi_lectura" class="evoluciones-valores upper fracciones" placeholder="OI">
                  </div>

                  <div style="width: fit-content;">
                    <input type="checkbox" data-valor="correccion_lectura" class="evoluciones-valores check checksmall" style="width: 30px; height: 30px">
                  </div>

                  <div style="width: fit-content;">
                    <input type="checkbox" data-valor="allen_lectura" class="evoluciones-valores check checksmall" style="width: 30px; height: 30px">
                  </div>

                  <div style="width: fit-content;">
                    <input type="checkbox" data-valor="jagger_lectura" class="evoluciones-valores check checksmall" style="width: 30px; height: 30px">
                  </div>

                  <div style="width: fit-content;">
                    <input type="checkbox" data-valor="e_direccional_lectura" class="evoluciones-valores check checksmall" style="width: 30px; height: 30px">
                  </div>

                  <div style="width: fit-content;">
                    <input type="checkbox" data-valor="numeros_lectura" class="evoluciones-valores check checksmall" style="width: 30px; height: 30px">
                  </div>

                  <div style="width: fit-content;">
                    <input type="checkbox" data-valor="decimales_lectura" class="evoluciones-valores check checksmall" style="width: 30px; height: 30px">
                  </div>

                  <div style="width: fit-content;">
                    <input type="checkbox" data-valor="fracciones_lectura" class="evoluciones-valores check checksmall" style="width: 30px; height: 30px">
                  </div>

                  <div style="width: fit-content;">
                    <input type="checkbox" data-valor="letras_lectura" class="evoluciones-valores check checksmall" style="width: 30px; height: 30px">
                  </div>
                </div>

              </div>

              <div class="columnas">

                <div>  
                  <label>Estereopsis</label>  
                  <input type="text" data-valor="estereopsis" class="evoluciones-valores upper" placeholder="00s">
                </div>

                <div>
                  <label>Ishihara</label>
                  <input type="text" data-valor="test" class="evoluciones-valores upper fracciones" placeholder="00/00">
                </div>

                <div>
                  <label>Stereo Fly</label>
                  <input type="text" data-valor="reflejo" class="evoluciones-valores upper" placeholder="00s">
                </div>  

              </div>

              <div class="titulo">
                <div>2</div>
                <div>Pruebas & Motilidad</div>
              </div>

              <div class="columnas" style="align-items: end;">
              
                <div>
                  
                  <label>Pruebas</label>
                  <select data-valor="pruebas" class="evoluciones-valores upper">
                    <option value="0">COVER TEST (CT)</option>
                    <option value="1">KRIMSKY TEST (KY)</option>
                    <option value="2">HIRSCHBERG TEST (HT)</option>
                  </select>
                  
                </div>

                <div style="width: fit-content">
                  <input type="checkbox" data-valor="correccion_pruebas" class="evoluciones-valores check checksmall" style="width: 30px; height: 30px" title="APLICA CORRECCIÓN">
                </div>

              </div>

              <div class="columnas" style="margin-top: 10px">

                <div style="display: flex; flex-direction: row; column-gap: 10px;">
                  <label style="width: 50%; font-size: 16px">OD:</label>
                  <label style="width: 50%; font-size: 16px">OI:</label>
                </div>

              </div>

              <div class="columnas">

                <div class="pruebas borde-estilizado">

                  <section style="grid-template-columns: auto; align-self: baseline; justify-content: center;">
                    <input type="text" data-valor="pruebas_od_1" class="evoluciones-valores upper" placeholder="---" style="width: 70px;">
                  </section>

                  <section style="grid-template-columns: auto auto auto; align-self: center; top: 3px; position: relative;">
                    <input type="text" data-valor="pruebas_od_2" class="evoluciones-valores upper" placeholder="---">
                    <input type="text" data-valor="pruebas_od_3" class="evoluciones-valores upper" placeholder="---">
                    <input type="text" data-valor="pruebas_od_4" class="evoluciones-valores upper" placeholder="---">
                  </section>

                  <section style="grid-template-columns: auto auto auto; align-self: end;">
                    <input type="text" data-valor="pruebas_od_5" class="evoluciones-valores upper" placeholder="---" style="height: inherit; align-self: start; display: grid; top: -30px; left: 30px;">
                    <div style="width: 100%">
                        <input type="text" data-valor="pruebas_od_6" class="evoluciones-valores upper" placeholder="---" style="height: 20px">
                        <input type="text" data-valor="pruebas_od_7" class="evoluciones-valores upper" placeholder="---" style="height: 20px">
                    </div>
                    <input type="text" data-valor="pruebas_od_8" class="evoluciones-valores upper" placeholder="---" style="height: inherit; align-self: start; display: grid; top: -30px; right: 30px;">
                  </section>
                  
                </div>

                <div class="pruebas borde-estilizado">

                  <section style="grid-template-columns: auto; align-self: baseline; justify-content: center;">
                    <input type="text" data-valor="pruebas_oi_1" class="evoluciones-valores upper" placeholder="---" style="width: 70px;">
                  </section>

                  <section style="grid-template-columns: auto auto auto; align-self: center; top: 3px; position: relative;">
                    <input type="text" data-valor="pruebas_oi_2" class="evoluciones-valores upper" placeholder="---">
                    <input type="text" data-valor="pruebas_oi_3" class="evoluciones-valores upper" placeholder="---">
                    <input type="text" data-valor="pruebas_oi_4" class="evoluciones-valores upper" placeholder="---">
                  </section>

                  <section style="grid-template-columns: auto auto auto; align-self: end;">
                    <input type="text" data-valor="pruebas_oi_5" class="evoluciones-valores upper" placeholder="---" style="height: inherit; align-self: start; display: grid; top: -30px; left: 30px;">
                    <div style="width: 100%">
                        <input type="text" data-valor="pruebas_oi_6" class="evoluciones-valores upper" placeholder="---" style="height: 20px">
                        <input type="text" data-valor="pruebas_oi_7" class="evoluciones-valores upper" placeholder="---" style="height: 20px">
                    </div>
                    <input type="text" data-valor="pruebas_oi_8" class="evoluciones-valores upper" placeholder="---" style="height: inherit; align-self: start; display: grid; top: -30px; right: 30px;">
                  </section>
                  
                </div>

              </div>

              <div class="columnas" style="margin-top: 10px">
                <div>
                  <label>MOTILIDAD</label>
                </div>
              </div>

              <div class="columnas">

                <div style="display: flex; flex-direction: row; column-gap: 10px;">
                  <label style="width: 50%; font-size: 16px">OD:</label>
                  <label style="width: 50%; font-size: 16px">OI:</label>
                </div>

              </div>

              <div class="columnas">

                  <div class="motilidad borde-estilizado">

                    <section>
                      <input type="text" placeholder="---">
                      <input type="text" placeholder="---">
                    </section>

                    <section>
                      <input type="text" placeholder="---">
                      <input type="text" placeholder="---">
                    </section>

                    <section>
                      <input type="text" placeholder="---">
                      <input type="text" placeholder="---">
                    </section>

                  </div>

                  <div class="motilidad borde-estilizado">

                    <section>
                      <input type="text" placeholder="---">
                      <input type="text" placeholder="---">
                    </section>

                    <section>
                      <input type="text" placeholder="---">
                      <input type="text" placeholder="---">
                    </section>

                    <section>
                      <input type="text" placeholder="---">
                      <input type="text" placeholder="---">
                    </section>

                  </div>

              </div>

              <div class="titulo">
                <div>3</div>
                <div>Refracción</div>
              </div>

              <div class="columnas rx" style="flex-direction: column; align-items: baseline;">

                <label style="font-size: 20px; height: 25px; border-bottom: 1px solid; width: 100%; margin-bottom: 10px;">
                  RX
                </label>

                <div style="margin: 0px; flex-direction: column; row-gap: 10px;">
                  <div style="flex-direction: row; justify-content: center; align-items: center;">
                    <label style="padding-right: 3px">OD:</label>
                    <input type="checkbox" data-valor="rx_od_signo_1" class="evoluciones-valores check checksigno">
                    <input type="text" data-valor="rx_od_valor_1" class="evoluciones-valores upper decimales" placeholder="0.00">
                    <input type="checkbox" data-valor="rx_od_signo_2" class="evoluciones-valores check checksigno">
                    <input type="text" data-valor="rx_od_valor_2" class="evoluciones-valores upper decimales" placeholder="0.00">
                    <span   class="informe-separador">X</span>
                    <input type="text" data-valor="rx_od_grados" class="evoluciones-valores upper" placeholder="0">
                    <span   class="informe-grado">°</span>
                    <span   class="informe-igual">=</span>
                    <input type="text" data-valor="rx_od_resultado" class="evoluciones-valores upper fracciones" placeholder="00/00">
                  </div>

                  <div style="flex-direction: row; justify-content: center; align-items: center;">
                    <label style="padding-right: 9px">OI:</label>
                    <input type="checkbox" data-valor="rx_oi_signo_1" class="evoluciones-valores check checksigno">
                    <input type="text" data-valor="rx_oi_valor_1" class="evoluciones-valores upper decimales" placeholder="0.00">
                    <input type="checkbox" data-valor="rx_oi_signo_2" class="evoluciones-valores check checksigno">
                    <input type="text" data-valor="rx_oi_valor_2" class="evoluciones-valores upper decimales" placeholder="0.00">
                    <span   class="informe-separador">X</span>
                    <input type="text" data-valor="rx_oi_grados" class="evoluciones-valores upper" placeholder="0">
                    <span   class="informe-grado">°</span>
                    <span   class="informe-igual">=</span>
                    <input type="text" data-valor="rx_oi_resultado" class="evoluciones-valores upper fracciones" placeholder="00/00">
                  </div>
                </div>

              </div>

              <div class="columnas rx" style="flex-direction: column; align-items: baseline;">

                <label style="font-size: 20px; height: 25px; border-bottom: 1px solid; width: 100%; margin-bottom: 10px;">
                  RX: CICLOPLAGIA
                </label>

                <div style="margin: 0px; flex-direction: column; row-gap: 10px;">
                  <div style="flex-direction: row; justify-content: center; align-items: center;">
                    <label style="padding-right: 3px">OD:</label>
                    <input type="checkbox" data-valor="rx_od_signo_1_ciclo" class="evoluciones-valores check checksigno">
                    <input type="text" data-valor="rx_od_valor_1_ciclo" class="evoluciones-valores upper decimales" placeholder="0.00">
                    <input type="checkbox" data-valor="rx_od_signo_2_ciclo" class="evoluciones-valores check checksigno">
                    <input type="text" data-valor="rx_od_valor_2_ciclo" class="evoluciones-valores upper decimales" placeholder="0.00">
                    <span   class="evolucion-separador">X</span>
                    <input type="text" data-valor="rx_od_grados_ciclo" class="evoluciones-valores upper" placeholder="0">
                    <span   class="evolucion-grado">°</span>
                    <span   class="evolucion-igual">=</span>
                    <input type="text" data-valor="rx_od_resultado_ciclo" class="evoluciones-valores upper fracciones" placeholder="00/00">
                  </div>

                  <div style="flex-direction: row; justify-content: center; align-items: center;">
                    <label style="padding-right: 9px">OI:</label>
                    <input type="checkbox" data-valor="rx_oi_signo_1_ciclo" class="evoluciones-valores check checksigno">
                    <input type="text" data-valor="rx_oi_valor_1_ciclo" class="evoluciones-valores upper decimales" placeholder="0.00">
                    <input type="checkbox" data-valor="rx_oi_signo_2_ciclo" class="evoluciones-valores check checksigno">
                    <input type="text" data-valor="rx_oi_valor_2_ciclo" class="evoluciones-valores upper decimales" placeholder="0.00">
                    <span   class="evolucion-separador">X</span>
                    <input type="text" data-valor="rx_oi_grados_ciclo" class="evoluciones-valores upper" placeholder="0">
                    <span   class="evolucion-grado">°</span>
                    <span   class="evolucion-igual">=</span>
                    <input type="text" data-valor="rx_oi_resultado_ciclo" class="evoluciones-valores upper fracciones" placeholder="00/00">
                  </div>
                </div>

              </div>

              <div class="titulo">
                <div>4</div>
                <div>Biomicroscopía</div>
              </div>

              <div class="columnas" style="align-items: baseline;">
                
                <section class="dibujar-herramientas-v">
                  
                  <div class="dibujar-colores-v">
          
                    <button class="bio-dibujar" data-color="black"></button>
                    <button class="bio-dibujar" data-color="red"></button>
                    <button class="bio-dibujar" data-color="blue"></button>
                    <button class="bio-dibujar" data-color="yellow"></button>
                    <button class="bio-dibujar" data-color="orange"></button>
                    <button class="bio-dibujar" data-color="green"></button>
                    <button class="bio-dibujar" data-color="purple"></button>
                    <button class="bio-dibujar" data-color="pink"></button>
                    <button class="bio-dibujar" data-color="brown"></button>

                  </div>

                  <div class="dibujar-rango-v">
                      <input id="bio-rango" type="range" min="1" max="5" value="5" class="bio-slider">
                      <div id="bio-valor"></div>
                  </div>

                  <div class="dibujar-botones-v">
                    
                    <button id="bio-seleccionar" title="Seleccionar objeto">
                      <svg class="iconos-b" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 320 512"><path fill="currentColor" d="M0 55.2V426c0 12.2 9.9 22 22 22c6.3 0 12.4-2.7 16.6-7.5L121.2 346l58.1 116.3c7.9 15.8 27.1 22.2 42.9 14.3s22.2-27.1 14.3-42.9L179.8 320H297.9c12.2 0 22.1-9.9 22.1-22.1c0-6.3-2.7-12.3-7.4-16.5L38.6 37.9C34.3 34.1 28.9 32 23.2 32C10.4 32 0 42.4 0 55.2z"/></svg>
                    </button>
                    <button id="bio-texto" title="Escribir">
                      <svg class="iconos-b" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M497.9 142.1l-46.1 46.1c-4.7 4.7-12.3 4.7-17 0l-111-111c-4.7-4.7-4.7-12.3 0-17l46.1-46.1c18.7-18.7 49.1-18.7 67.9 0l60.1 60.1c18.8 18.7 18.8 49.1 0 67.9zM284.2 99.8L21.6 362.4.4 483.9c-2.9 16.4 11.4 30.6 27.8 27.8l121.5-21.3 262.6-262.6c4.7-4.7 4.7-12.3 0-17l-111-111c-4.8-4.7-12.4-4.7-17.1 0zM124.1 339.9c-5.5-5.5-5.5-14.3 0-19.8l154-154c5.5-5.5 14.3-5.5 19.8 0s5.5 14.3 0 19.8l-154 154c-5.5 5.5-14.3 5.5-19.8 0zM88 424h48v36.3l-64.5 11.3-31.1-31.1L51.7 376H88v48z"></path></svg>
                    </button>
                    <button id="bio-remover" disabled="disabled" title="Eliminar objeto seleccionado">
                      <svg class="iconos-b" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="trash-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M32 464a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128H32zm272-256a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zm-96 0a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zm-96 0a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zM432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16z"></path></svg>
                    </button>

                  </div>

                  <div class="dibujar-formas-v">
                    
                    <button id="bio-forma-1" title="Forma1">F</button>
                    <button title="---">-</button>
                    <button title="---">-</button>
                    <button title="---">-</button>
                    <button title="---">-</button>
                    <button title="---">-</button>
                    <button title="---">-</button>
                    <button title="---">-</button>
                    <button title="---">-</button>
                    <button title="---">-</button>
                    <button title="---">-</button>
                    <button title="---">-</button>

                  </div>

                </section>

                <section class="dibujar-contenedor-v">
                
                  <canvas id="bio-imagen" width="513" height="309"></canvas>

                </section>

              </div>

              <div class="columnas">
                
                <div>     
                  <label>Nota biomicroscopía OD:</label>
                  <textarea rows="3" id="evoluciones-nota-b-od" data-previa="evoluciones-previa" data-valor="nota-b-od" class="evoluciones-valores upper textarea-espaciado contenedor-personalizable" style="resize:none;" data-scroll ></textarea>
                </div>

                <div>     
                  <label>Nota biomicroscopía OI:</label>
                  <textarea rows="3" id="evoluciones-nota-b-oi" data-previa="evoluciones-previa" data-valor="nota-b-oi" class="evoluciones-valores upper textarea-espaciado contenedor-personalizable" style="resize:none;" data-scroll ></textarea>
                </div>

              </div>

              <div class="titulo">
                <div>5</div>
                <div>Fondo de ojo</div>
              </div>

              <div class="columnas" style="align-items: baseline;">
                
                <section class="dibujar-herramientas-v">
                  
                  <div class="dibujar-colores-v">
          
                    <button class="fondo-dibujar" data-color="black"></button>
                    <button class="fondo-dibujar" data-color="red"></button>
                    <button class="fondo-dibujar" data-color="blue"></button>
                    <button class="fondo-dibujar" data-color="yellow"></button>
                    <button class="fondo-dibujar" data-color="orange"></button>
                    <button class="fondo-dibujar" data-color="green"></button>
                    <button class="fondo-dibujar" data-color="purple"></button>
                    <button class="fondo-dibujar" data-color="pink"></button>
                    <button class="fondo-dibujar" data-color="brown"></button>

                  </div>

                  <div class="dibujar-rango-v">
                      <input id="fondo-rango" type="range" min="1" max="5" value="5" class="fondo-slider">
                      <div id="fondo-valor"></div>
                  </div>

                  <div class="dibujar-botones-v">
                    
                    <button id="fondo-seleccionar" title="Seleccionar objeto">
                      <svg class="iconos-b" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 320 512"><path fill="currentColor" d="M0 55.2V426c0 12.2 9.9 22 22 22c6.3 0 12.4-2.7 16.6-7.5L121.2 346l58.1 116.3c7.9 15.8 27.1 22.2 42.9 14.3s22.2-27.1 14.3-42.9L179.8 320H297.9c12.2 0 22.1-9.9 22.1-22.1c0-6.3-2.7-12.3-7.4-16.5L38.6 37.9C34.3 34.1 28.9 32 23.2 32C10.4 32 0 42.4 0 55.2z"/></svg>
                    </button>
                    <button id="fondo-texto" title="Escribir">
                      <svg class="iconos-b" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M497.9 142.1l-46.1 46.1c-4.7 4.7-12.3 4.7-17 0l-111-111c-4.7-4.7-4.7-12.3 0-17l46.1-46.1c18.7-18.7 49.1-18.7 67.9 0l60.1 60.1c18.8 18.7 18.8 49.1 0 67.9zM284.2 99.8L21.6 362.4.4 483.9c-2.9 16.4 11.4 30.6 27.8 27.8l121.5-21.3 262.6-262.6c4.7-4.7 4.7-12.3 0-17l-111-111c-4.8-4.7-12.4-4.7-17.1 0zM124.1 339.9c-5.5-5.5-5.5-14.3 0-19.8l154-154c5.5-5.5 14.3-5.5 19.8 0s5.5 14.3 0 19.8l-154 154c-5.5 5.5-14.3 5.5-19.8 0zM88 424h48v36.3l-64.5 11.3-31.1-31.1L51.7 376H88v48z"></path></svg>
                    </button>
                    <button id="fondo-remover" disabled="disabled" title="Eliminar objeto seleccionado">
                      <svg class="iconos-b" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="trash-alt" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M32 464a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128H32zm272-256a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zm-96 0a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zm-96 0a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zM432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16z"></path></svg>
                    </button>

                  </div>

                  <div class="dibujar-formas-v">
                    
                    <button id="fondo-forma-1" title="Forma1">F</button>
                    <button title="---">-</button>
                    <button title="---">-</button>
                    <button title="---">-</button>
                    <button title="---">-</button>
                    <button title="---">-</button>
                    <button title="---">-</button>
                    <button title="---">-</button>
                    <button title="---">-</button>
                    <button title="---">-</button>
                    <button title="---">-</button>
                    <button title="---">-</button>

                  </div>

                </section>

                <section class="dibujar-contenedor-v">
                
                  <canvas id="fondo-imagen" width="513" height="309"></canvas>

                </section>

              </div>

              <div class="columnas">
                
                <div>     
                  <label>Fondo de ojo OD:</label>
                  <textarea rows="3" id="evoluciones-nota-f-od" data-previa="evoluciones-previa" data-valor="nota-f-od" class="evoluciones-valores upper textarea-espaciado contenedor-personalizable" style="resize:none;" data-scroll ></textarea>
                </div>

                <div>     
                  <label>Fondo de ojo OI:</label>
                  <textarea rows="3" id="evoluciones-nota-f-oi" data-previa="evoluciones-previa" data-valor="nota-f-oi" class="evoluciones-valores upper textarea-espaciado contenedor-personalizable" style="resize:none;" data-scroll ></textarea>
                </div>

              </div>

              <div class="titulo">
                <div>6</div>
                <div>PIO, Estudios, IDX</div>
              </div>

              <div class="columnas" style="flex-direction: column; align-items: baseline;">

                <label>PIO</label>

                <div style="margin: 0px; flex-direction: row; column-gap: 10px;">
                  <div>    
                    <input type="text" data-valor="pio_od" class="evoluciones-valores upper decimales" placeholder="OD - 0.00mmHg">
                  </div>

                  <div>
                    <input type="text" data-valor="pio_oi" class="evoluciones-valores upper decimales" placeholder="OI - 0.00mmHg">
                  </div>  
                </div>

              </div>

              <div class="columnas">
                
                <div style="position:relative;">

                  <label>
                    Estudios:
                  </label>
                  
                  <style>
                    #cc-estudios-evoluciones .ccContenedor {
                       width: 95%;
                    }
                  </style>

                  <section id="cc-estudios-evoluciones" class="contenedor-consulta evoluciones-valores borde-estilizado" data-valor="referencias">

                    <input type="text" data-estilo="cc-input" class="upper" data-minimo="0" data-ocultar="0" placeholder="Buscar estudios" title="[ENTER] para forzar actualización">
                    <select data-limit="" data-estilo="cc-select" placeholder="Buscar estudios" data-size="5" data-ocultar="1" data-hide data-absoluto="1" data-scroll style="
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

                <div style="position:relative;">

                  <label>
                    IDX:
                  </label>
                  
                  <style>
                    #cc-diagnosticos-evoluciones .ccContenedor {
                       width: 95%;
                    }
                  </style>

                  <section id="cc-diagnosticos-evoluciones" class="contenedor-consulta evoluciones-valores borde-estilizado" data-valor="diagnosticos">

                    <input type="text" data-estilo="cc-input" class="upper" data-minimo="0" data-ocultar="0" placeholder="Buscar diagnósticos" title="[ENTER] para forzar actualización">
                    <select data-limit="" data-estilo="cc-select" placeholder="Buscar diagnóstico" data-size="5" data-ocultar="1" data-hide data-absoluto="1" data-scroll style="
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

              <div class="titulo">
                <div>7</div>
                <div>Plan & fórmula</div>
              </div>

              <div class="columnas rx" style="flex-direction: column; align-items: baseline;">

                <label style="font-size: 20px; height: 25px; border-bottom: 1px solid; width: 100%; margin-bottom: 10px;">
                  Fórmula
                </label>

                <div style="margin: 0px; flex-direction: column; row-gap: 10px;">
                  <div style="flex-direction: row; justify-content: center; align-items: center;">
                    <label style="padding-right: 3px">OD:</label>
                    <input type="checkbox" data-valor="formula_od_signo_1_ciclo" class="evoluciones-valores check checksigno">
                    <input type="text" data-valor="formula_od_valor_1_ciclo" class="evoluciones-valores upper decimales" placeholder="0.00">
                    <input type="checkbox" data-valor="formula_od_signo_2_ciclo" class="evoluciones-valores check checksigno">
                    <input type="text" data-valor="formula_od_valor_2_ciclo" class="evoluciones-valores upper decimales" placeholder="0.00">
                    <span   class="evolucion-separador">X</span>
                    <input type="text" data-valor="formula_od_grados_ciclo" class="evoluciones-valores upper" placeholder="0">
                    <span   class="evolucion-grado">°</span>
                  </div>

                  <div style="flex-direction: row; justify-content: center; align-items: center;">
                    <label style="padding-right: 9px">OI:</label>
                    <input type="checkbox" data-valor="formula_oi_signo_1_ciclo" class="evoluciones-valores check checksigno">
                    <input type="text" data-valor="formula_oi_valor_1_ciclo" class="evoluciones-valores upper decimales" placeholder="0.00">
                    <input type="checkbox" data-valor="formula_oi_signo_2_ciclo" class="evoluciones-valores check checksigno">
                    <input type="text" data-valor="formula_oi_valor_2_ciclo" class="evoluciones-valores upper decimales" placeholder="0.00">
                    <span   class="evolucion-separador">X</span>
                    <input type="text" data-valor="formula_oi_grados_ciclo" class="evoluciones-valores upper" placeholder="0">
                    <span   class="evolucion-grado">°</span>
                  </div>
                </div>

              </div>

              <div>     
                <label>Plan:</label>
                <textarea rows="6" id="evoluciones-plan" data-previa="evoluciones-previa" data-valor="plan" class="evoluciones-valores upper textarea-espaciado contenedor-personalizable" style="resize:none;" data-scroll ></textarea>
              </div>

            </section>

            <section id="crud-notificaciones-botones" data-crud='botones' style="column-gap: 10px; padding: 10px 10px 0px 10px;">
              <button class="botones-formularios confirmar">CONFIRMAR</button>
              <button class="botones-formularios cerrar">CANCELAR</button> 
            </section>

          </div>

      </section>

      <!-------------------------------------------------------- -->
      <!------------------ EVOLUCIONES CONSULTAR --------------- -->
      <!-------------------------------------------------------- -->
      <section class="evoluciones-seccion" data-hide>
                      
          <div data-familia class="contenedor" id="evoluciones-consultar-contenedor" data-efecto="derecha-1">

            CONSULTA

          </div>

      </section>

    </div>

  </div>

</div>