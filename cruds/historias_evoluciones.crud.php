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