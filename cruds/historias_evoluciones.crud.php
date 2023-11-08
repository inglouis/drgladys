<!--//////////////////////////////////////////////////////////////////////////////////-->
<!--/////////////////////////  EVOLUCIONES TEMPLATE //////////////////////////////////-->
<!--//////////////////////////////////////////////////////////////////////////////////-->

<template id="evoluciones-template">

  <section class="evoluciones-contenido filas">

    <div class="evoluciones-botones">

      <button class="reusar btn btn-reusar" title="Reutilizar información de la evolución">
        <?php echo $_SESSION['botones']['reportes_reusar']?>
      </button>

      <button class="editar btn btn-editar" title="Editar evolución">
        <?php echo $_SESSION['botones']['reportes_editar']?>
      </button>

      <button class="notificar btn btn-notificar" title="Notificar evolución">
        <?php echo $_SESSION['botones']['evoluciones_notificar']?>
      </button>
      
      <div class="crud-eliminar-contenedor" style="position: relative;">
        
        <button class="eliminar btn btn-eliminar">
          <?php echo $_SESSION['botones']['reportes_eliminar']?>
        </button>
        
      </div>

    </div>

    <div class="columnas">

      <div data-template="problematico" class="check-alineado" style="column-gap: 5px; height: 8px">
        <input type="checkbox" class="check checkexpresion" style="width: 30px; height: 30px; justify-content: center; align-items: center; display:flex;    position: absolute; right: 21px; top: 40px;" disabled>
      </div>

    </div>

    <div class="columnas">
      
      <div data-template="nota">
        <label class="title">Nota inicial:</label>
        <div class="notas"></div>
      </div>

    </div>

    <div class="separador">Examen oftalmológico</div>

    <div class="columnas" style="flex-direction: column; align-items: baseline; margin-top: 10px;">
      
      <div data-template="agudeza_4" style="margin: 0px;" class="dato-simple">
        <label class="title">Agudeza visual - 4m:</label>
        <div></div>
      </div>

      <div data-template="agudeza_4_pruebas">
        <label class="subtitle">Pruebas:</label>
        <ul></ul>
      </div>

    </div>

    <div class="columnas" style="flex-direction: column; align-items: baseline;">
      
      <div data-template="agudeza_1" style="margin: 0px;" class="dato-simple">
        <label class="title">Agudeza visual - 1m:</label>
        <div></div>
      </div>

      <div data-template="agudeza_1_pruebas">
        <label class="subtitle">Pruebas:</label>
        <ul></ul>
      </div>

    </div>

    <div class="columnas" style="flex-direction: column; align-items: baseline;">
      
      <div data-template="agudeza_lectura" style="margin: 0px;" class="dato-simple">
        <label class="title">Agudeza visual - lectura:</label>
        <div></div>
      </div>

      <div data-template="agudeza_lectura_pruebas">
        <label class="subtitle">Pruebas:</label>
        <ul></ul>
      </div>

    </div>

    <div class="columnas" style="margin-top: 10px;">
      
      <div data-template="estereopsis" class="dato-simple">
        <label class="title">Estereopsis:</label>
      </div>

      <div data-template="test" class="dato-simple">
        <label class="title">Ishihara:</label>
      </div>

      <div data-template="reflejo" class="dato-simple">
        <label class="title">Stereo Fly:</label>
      </div>

    </div>

    <div class="separador">Pruebas</div>

    <div class="columnas" style="margin-top: 10px;">
      
      <div data-template="pruebas" class="dato-simple">
        <label class="title">Prueba realizada:</label>
      </div>

      <div data-template="pruebas_correccion" class="dato-simple">
        <label class="title">Aplicó corrección:</label>
      </div>

    </div>

    <div class="columnas"><label style="font-weight: bold; margin-top: 15px; text-decoration: underline; font-size: 18px;">Prueba</label></div>

    <div class="columnas">

      <div class="pruebas borde-estilizado">

        <section style="grid-template-columns: auto; align-self: baseline; justify-content: center;">
          <input type="text" data-template="pruebas_od_1" class="upper visual" disabled placeholder="---" style="width: 70px;">
        </section>

        <section style="grid-template-columns: auto auto auto; align-self: center; top: 3px; position: relative;">
          <input type="text" data-template="pruebas_od_2" class="upper visual" disabled placeholder="---">
          <input type="text" data-template="pruebas_od_3" class="upper visual" disabled placeholder="---">
          <input type="text" data-template="pruebas_od_4" class="upper visual" disabled placeholder="---">
        </section>

        <section style="grid-template-columns: auto auto auto; align-self: end;">
          <input type="text" data-template="pruebas_od_5" class="upper visual" disabled placeholder="---" style="height: inherit; align-self: start; display: grid; top: -10px; left: 10px;">
          <div style="width: 100%">
              <input type="text" data-template="pruebas_od_6" class="upper visual" disabled placeholder="---" style="height: 20px">
              <input type="text" data-template="pruebas_od_7" class="upper visual" disabled placeholder="---" style="height: 20px">
          </div>
          <input type="text" data-template="pruebas_od_8" class="upper visual" disabled placeholder="---" style="height: inherit; align-self: start; display: grid; top: -10px; right: 10px;">
        </section>
        
      </div>

      <div class="pruebas borde-estilizado">

        <section style="grid-template-columns: auto; align-self: baseline; justify-content: center;">
          <input type="text" data-template="pruebas_oi_1" class="upper visual" disabled placeholder="---" style="width: 70px;">
        </section>

        <section style="grid-template-columns: auto auto auto; align-self: center; top: 3px; position: relative;">
          <input type="text" data-template="pruebas_oi_2" class="upper visual" disabled placeholder="---">
          <input type="text" data-template="pruebas_oi_3" class="upper visual" disabled placeholder="---">
          <input type="text" data-template="pruebas_oi_4" class="upper visual" disabled placeholder="---">
        </section>

        <section style="grid-template-columns: auto auto auto; align-self: end;">
          <input type="text" data-template="pruebas_oi_5" class="upper visual" disabled placeholder="---" style="height: inherit; align-self: start; display: grid; top: -10px; left: 10px;">
          <div style="width: 100%">
              <input type="text" data-template="pruebas_oi_6" class="upper visual" disabled placeholder="---" style="height: 20px">
              <input type="text" data-template="pruebas_oi_7" class="upper visual" disabled placeholder="---" style="height: 20px">
          </div>
          <input type="text" data-template="pruebas_oi_8" class="upper visual" disabled placeholder="---" style="height: inherit; align-self: start; display: grid; top: -10px; right: 10px;">
        </section>
        
      </div>

    </div>

    <div class="columnas">
      
      <div data-template="pruebas-nota">
        <label class="title">Nota de las pruebas:</label>
        <div class="notas"></div>
      </div>

    </div>

    <div class="columnas"><label style="font-weight: bold; margin-top: 15px; text-decoration: underline; font-size: 18px;">Motilidad</label></div>

    <div class="columnas">

      <div class="motilidad borde-estilizado">

        <section style="grid-template-columns: auto auto; align-self: end;">
          <input type="text" data-template="motilidad_od_1" placeholder="---" disabled class="upper visual" style="width: 80px">
          <input type="text" data-template="motilidad_od_2" placeholder="---" disabled class="upper visual" style="width: 80px; justify-self: flex-end;">
        </section>

        <section style="grid-template-columns: auto auto; align-self: center;">
          <input type="text" data-template="motilidad_od_3" placeholder="---" disabled class="upper visual" style="width: 80px">
          <input type="text" data-template="motilidad_od_4" placeholder="---" disabled class="upper visual" style="width: 80px; justify-self: flex-end;">
        </section>

        <section style="grid-template-columns: auto auto; align-self: start;">
          <input type="text" data-template="motilidad_od_5" placeholder="---" disabled class="upper visual" style="width: 80px">
          <input type="text" data-template="motilidad_od_6" placeholder="---" disabled class="upper visual" style="width: 80px; justify-self: flex-end;">
        </section>

      </div>

      <div class="motilidad borde-estilizado">

       <section style="grid-template-columns: auto auto; align-self: end;">
          <input type="text" data-template="motilidad_oi_1" placeholder="---" disabled class="upper visual" style="width: 80px">
          <input type="text" data-template="motilidad_oi_2" placeholder="---" disabled class="upper visual" style="width: 80px; justify-self: flex-end;">
        </section>

        <section style="grid-template-columns: auto auto; align-self: center;">
          <input type="text" data-template="motilidad_oi_3" placeholder="---" disabled class="upper visual" style="width: 80px">
          <input type="text" data-template="motilidad_oi_4" placeholder="---" disabled class="upper visual" style="width: 80px; justify-self: flex-end;">
        </section>

        <section style="grid-template-columns: auto auto; align-self: start;">
          <input type="text" data-template="motilidad_oi_5" placeholder="---" disabled class="upper visual" style="width: 80px">
          <input type="text" data-template="motilidad_oi_6" placeholder="---" disabled class="upper visual" style="width: 80px; justify-self: flex-end;">
        </section>

      </div>

    </div>

    <div class="columnas">
      
      <div data-template="motilidad-nota">
        <label class="title">Nota de la motilidad:</label>
        <div class="notas"></div>
      </div>

    </div>

    <div class="separador">Refracción</div>

    <div class="columnas">

      <div data-template="rx" style="margin: 0px;">
        <label class="title">RX:</label>
        <div></div>
      </div>

    </div>

    <div class="columnas">

      <div data-template="rx_ciclo" style="margin: 0px;">
        <label class="title">RX - CICLOPLEGIA:</label>
        <div></div>
      </div>

    </div>

    <div class="separador">Biomicroscopía</div>

    <div class="columnas">

      <div data-template="biomicroscopia_img" style="margin: 0px;justify-content: center; display: flex; align-items: center;">
        <img src="" width="513" height="309">
      </div>

    </div>

    <div class="columnas">
      
      <div data-template="nota_bio_od">
        <label class="title">OD:</label>
        <div class="notas"></div>
      </div>

      <div data-template="nota_bio_oi">
        <label class="title">OI:</label>
        <div class="notas"></div>
      </div>

    </div>

    <div class="separador">Fondo de ojo</div>

    <div class="columnas">

      <div data-template="fondo_img" style="margin: 0px;justify-content: center; display: flex; align-items: center;">
        <img src="" width="513" height="309">
      </div>

    </div>

    <div class="columnas">
      
      <div data-template="nota_f_od">
        <label class="title">OD:</label>
        <div class="notas"></div>
      </div>

      <div data-template="nota_f_oi">
        <label class="title">OI:</label>
        <div class="notas"></div>
      </div>

    </div>

    <div class="separador">Pio, Estudios, IDX</div>

    <div class="columnas" style="flex-direction: column; align-items: baseline; margin-top: 10px;">
      
      <div data-template="pio" style="margin: 0px;" class="dato-simple">
        <label class="title">Pio:</label>
        <div></div>
      </div>

    </div>

    <div class="columnas">
      
      <div data-template="referencias">
        <label class="subtitle">Estudios:</label>
        <ul></ul>
      </div>

    </div>

    <div class="columnas">

      <div data-template="idx">
        <label class="subtitle">Idx:</label>
        <ul></ul>
      </div>

    </div>

    <div class="separador">Fórmula</div>

    <div class="columnas">

      <div data-template="formula" style="margin: 0px;">
        <div></div>
      </div>

    </div>

    <div class="columnas">
      
      <div data-template="curva" style="margin: 0px;" class="dato-simple">
        <label class="title">Curva base:</label>
        <div></div>
      </div>

    </div>

    <div class="columnas">
      
      <div data-template="altura_pupilar" style="margin: 0px;" class="dato-simple">
        <label class="title">Altura pupilar:</label>
        <div></div>
      </div>

    </div>

    <div class="columnas">
      
      <div data-template="interpupilar" style="margin: 0px;" class="dato-simple">
        <label class="title">Distancia interpupilar:</label>
        <div></div>
      </div>

    </div>

    <div class="columnas">

      <div data-template="formula_estudios">
        <label class="subtitle">Estudios:</label>
        <ul></ul>
      </div>

    </div>

    <div class="columnas">
      
      <div data-template="plan">
        <label class="title">Plan</label>
        <div class="notas"></div>
      </div>

    </div>

    <div class="separador">Anexos</div>


    <div class="columnas"><label style="font-weight: bold; margin-top: 15px; text-decoration: underline; font-size: 18px;">Antes de la cirugía:</label></div>
    
    <div class="columnas">
      
      <div data-template="anexos_lentes_antes" class="dato-simple">
        <label class="title">Aplicó uso de lentes:</label>
      </div>

    </div>

    <div id="galeria-contenedor-antes"data-template="img-antes" class="columnas galeria-contenedor">
      
    </div>

    <div class="columnas"><label style="font-weight: bold; margin-top: 15px; text-decoration: underline; font-size: 18px;">Después de la cirugía:</label></div>
    
    <div class="columnas">
      
      <div data-template="anexos_lentes_despues" class="dato-simple">
        <label class="title">Aplicó uso de lentes:</label>
      </div>

    </div>

    <div id="galeria-contenedor-despues"data-template="img-despues" class="columnas galeria-contenedor">

  </section>

</template>

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

          <div class="personalizacion-c" data-hidden style="right: 5%; top: 20% !important; width: 20% !important;">

            <section>Personalización</section>
            <section style="width: 100%; border: 1px dashed #fff"></section>
            <span>ENTER: SEPARAR LÍNEA</span>
            <span>°CENTRAR°</span>
            <span>*<b>NEGRITA</b>*</span>
            <span>_ <u>SUBRAYADO</u> _</span>
            <span>~<i>ITÁLICA</i>~</span>

            <div id="evoluciones-previa" data-scroll></div>

          </div>
                      
          <div data-familia class="contenedor cargar" id="evoluciones-cargar-contenedor"> 

            <section class="radios">
              
              <label class="label-radio-estilizado-1"><input type="radio" name="evoluciones-seccion" class="radio-estilizado-1 tooltip-filtro-reverso"></label>
              <label class="label-radio-estilizado-1"><input type="radio" name="evoluciones-seccion" class="radio-estilizado-1 tooltip-filtro-reverso"></label>
              <label class="label-radio-estilizado-1"><input type="radio" name="evoluciones-seccion" class="radio-estilizado-1 tooltip-filtro-reverso"></label>
              <label class="label-radio-estilizado-1"><input type="radio" name="evoluciones-seccion" class="radio-estilizado-1 tooltip-filtro-reverso"></label>
              <label class="label-radio-estilizado-1"><input type="radio" name="evoluciones-seccion" class="radio-estilizado-1 tooltip-filtro-reverso"></label>
              <label class="label-radio-estilizado-1"><input type="radio" name="evoluciones-seccion" class="radio-estilizado-1 tooltip-filtro-reverso"></label>
              <label class="label-radio-estilizado-1"><input type="radio" name="evoluciones-seccion" class="radio-estilizado-1 tooltip-filtro-reverso"></label>
              <label class="label-radio-estilizado-1"><input type="radio" name="evoluciones-seccion" class="radio-estilizado-1 tooltip-filtro-reverso"></label>

              <div style="position: relative;">

                <button id="crud-evoluciones-aconsejar">i</button>

                <div id="crud-evoluciones-consejos" data-hidden class="consejos-contenedor" style="right: -277px; top: 25px; width: 700px;">

                  <div class="titulo">Consejos para la navegación del formulario</div>

                  <img src="../imagenes/teclado.png" style="width: 100%; height: 100%;">

                </div>
                
              </div>

            </section>

            <section class="filas borde-estilizado" data-scroll style="padding: 10px; justify-content: flex-start; height: 70vh; background-image: none;">
              
              <div class="columnas">

                <div class="check-alineado" style="column-gap: 5px;">
                  <input type="checkbox" data-valor="problematico" class="evoluciones-valores check checkexpresion" style="width: 30px; height: 30px; justify-content: center; align-items: center; display:flex;">
                </div>

              </div>

              <div class="columnas">

                <div>
                  <label class="requerido">FECHA DE LA EVOLUCION:</label>
                  <input type="date" id="evoluciones-fecha" data-valor="fecha" class="evoluciones-valores lleno textarea-espaciado">
                </div>
                
              </div>

              <div class="columnas">
                
                <div>     
                  <label>Nota inicial:</label>
                  <textarea rows="3" id="evoluciones-nota" data-previa="evoluciones-previa" data-valor="nota" class="evoluciones-valores upper textarea-espaciado contenedor-personalizable" style="resize:none;" data-scroll ></textarea>
                </div>

              </div>

              <div class="titulo evoluciones-saltar">
                <div>1</div>
                <div>Examen oftalmológico</div>
              </div>

              <div class="columnas" style="flex-direction: column; align-items: baseline;">

                <label>Agudeza visual - 4m</label>

                <div style="margin: 0px; flex-direction: row; column-gap: 10px;">
                  <div>    
                    <input type="text" data-valor="agudeza_od_4" class="evoluciones-valores upper fracciones" placeholder="OD - 00/00">
                  </div>

                  <div>
                    <input type="text" data-valor="agudeza_oi_4" class="evoluciones-valores upper fracciones" placeholder="OI - 00/00">
                  </div>

                  <div style="width: fit-content;" class="correccion">
                    <input type="checkbox" data-valor="correccion_4" class="evoluciones-valores check checksmall tooltip-filtro-reverso" style="width: 30px; height: 30px">
                  </div>

                  <div style="width: fit-content;" class="allen">
                    <input type="checkbox" data-valor="allen_4" class="evoluciones-valores check checksmall tooltip-filtro-reverso" style="width: 30px; height: 30px">
                  </div>

                  <div style="width: fit-content;" class="jagger">
                    <input type="checkbox" data-valor="jagger_4" class="evoluciones-valores check checksmall tooltip-filtro-reverso" style="width: 30px; height: 30px">
                  </div>

                  <div style="width: fit-content;" class="e-direcional">
                    <input type="checkbox" data-valor="e_direccional_4" class="evoluciones-valores check checksmall tooltip-filtro-reverso" style="width: 30px; height: 30px">
                  </div>

                  <div style="width: fit-content;" class="numeros">
                    <input type="checkbox" data-valor="numeros_4" class="evoluciones-valores check checksmall tooltip-filtro-reverso" style="width: 30px; height: 30px">
                  </div>

                  <div style="width: fit-content;" class="decimales">
                    <input type="checkbox" data-valor="decimales_4" class="evoluciones-valores check checksmall tooltip-filtro-reverso" style="width: 30px; height: 30px">
                  </div>

                  <div style="width: fit-content;" class="fracciones">
                    <input type="checkbox" data-valor="fracciones_4" class="evoluciones-valores check checksmall tooltip-filtro-reverso" style="width: 30px; height: 30px">
                  </div>

                  <div style="width: fit-content;" class="letras">
                    <input type="checkbox" data-valor="letras_4" class="evoluciones-valores check checksmall tooltip-filtro-reverso" style="width: 30px; height: 30px">
                  </div>
                </div>

              </div>

              <div class="columnas" style="flex-direction: column; align-items: baseline;">

                <label>Agudeza visual - 1.5m</label>

                <div style="margin: 0px; flex-direction: row; column-gap: 10px;">
                  <div>    
                    <input type="text" data-valor="agudeza_od_1" class="evoluciones-valores upper fracciones" placeholder="OD - 00/00">
                  </div>

                  <div>
                    <input type="text" data-valor="agudeza_oi_1" class="evoluciones-valores upper fracciones" placeholder="OI - 00/00">
                  </div>

                  <div style="width: fit-content;" class="correccion">
                    <input type="checkbox" data-valor="correccion_1" class="evoluciones-valores check checksmall tooltip-filtro-reverso" style="width: 30px; height: 30px">
                  </div>

                  <div style="width: fit-content;" class="allen">
                    <input type="checkbox" data-valor="allen_1" class="evoluciones-valores check checksmall tooltip-filtro-reverso" style="width: 30px; height: 30px">
                  </div>

                  <div style="width: fit-content;" class="jagger">
                    <input type="checkbox" data-valor="jagger_1" class="evoluciones-valores check checksmall tooltip-filtro-reverso" style="width: 30px; height: 30px">
                  </div>

                  <div style="width: fit-content;" class="e-direcional">
                    <input type="checkbox" data-valor="e_direccional_1" class="evoluciones-valores check checksmall tooltip-filtro-reverso" style="width: 30px; height: 30px">
                  </div>

                  <div style="width: fit-content;" class="numeros">
                    <input type="checkbox" data-valor="numeros_1" class="evoluciones-valores check checksmall tooltip-filtro-reverso" style="width: 30px; height: 30px">
                  </div>

                  <div style="width: fit-content;" class="decimales">
                    <input type="checkbox" data-valor="decimales_1" class="evoluciones-valores check checksmall tooltip-filtro-reverso" style="width: 30px; height: 30px">
                  </div>

                  <div style="width: fit-content;" class="fracciones">
                    <input type="checkbox" data-valor="fracciones_1" class="evoluciones-valores check checksmall tooltip-filtro-reverso" style="width: 30px; height: 30px">
                  </div>

                  <div style="width: fit-content;" class="letras">
                    <input type="checkbox" data-valor="letras_1" class="evoluciones-valores check checksmall tooltip-filtro-reverso" style="width: 30px; height: 30px">
                  </div>
                </div>

              </div>

              <div class="columnas" style="flex-direction: column; align-items: baseline;">

                <label>Agudeza visual - Lectura</label>

                <div style="margin: 0px; flex-direction: row; column-gap: 10px;">
                  <div>    
                    <input type="text" data-valor="agudeza_od_lectura" class="evoluciones-valores upper fracciones" placeholder="OD - 00/00">
                  </div>

                  <div>
                    <input type="text" data-valor="agudeza_oi_lectura" class="evoluciones-valores upper fracciones" placeholder="OI - 00/00">
                  </div>

                  <div style="width: fit-content;" class="correccion">
                    <input type="checkbox" data-valor="correccion_lectura" class="evoluciones-valores check checksmall tooltip-filtro-reverso" style="width: 30px; height: 30px">
                  </div>

                  <div style="width: fit-content;" class="allen">
                    <input type="checkbox" data-valor="allen_lectura" class="evoluciones-valores check checksmall tooltip-filtro-reverso" style="width: 30px; height: 30px">
                  </div>

                  <div style="width: fit-content;" class="jagger">
                    <input type="checkbox" data-valor="jagger_lectura" class="evoluciones-valores check checksmall tooltip-filtro-reverso" style="width: 30px; height: 30px">
                  </div>

                  <div style="width: fit-content;" class="e-direcional">
                    <input type="checkbox" data-valor="e_direccional_lectura" class="evoluciones-valores check checksmall tooltip-filtro-reverso" style="width: 30px; height: 30px">
                  </div>

                  <div style="width: fit-content;" class="numeros">
                    <input type="checkbox" data-valor="numeros_lectura" class="evoluciones-valores check checksmall tooltip-filtro-reverso" style="width: 30px; height: 30px">
                  </div>

                  <div style="width: fit-content;" class="decimales">
                    <input type="checkbox" data-valor="decimales_lectura" class="evoluciones-valores check checksmall tooltip-filtro-reverso" style="width: 30px; height: 30px">
                  </div>

                  <div style="width: fit-content;" class="fracciones">
                    <input type="checkbox" data-valor="fracciones_lectura" class="evoluciones-valores check checksmall tooltip-filtro-reverso" style="width: 30px; height: 30px">
                  </div>

                  <div style="width: fit-content;" class="letras">
                    <input type="checkbox" data-valor="letras_lectura" class="evoluciones-valores check checksmall tooltip-filtro-reverso" style="width: 30px; height: 30px">
                  </div>
                </div>

              </div>

              <div class="columnas">

                <div>  
                  <label>Estereopsis (SEG)</label>  
                  <input type="text" data-valor="estereopsis" class="evoluciones-valores upper" placeholder="00s">
                </div>

                <div>
                  <label>Ishihara</label>
                  <input type="text" data-valor="test" class="evoluciones-valores upper fracciones" placeholder="00/00">
                </div>

                <div>
                  <label>Stereo Fly (SEG)</label>
                  <input type="text" data-valor="reflejo" class="evoluciones-valores upper" placeholder="00s">
                </div>  

              </div>

              <div class="titulo evoluciones-saltar">
                <div>2</div>
                <div>Pruebas & Motilidad</div>
              </div>

              <div class="columnas" style="margin-top: 10px">
                <div>
                  <label style="font-size: 20px; border-bottom: 1px solid; width: 100%;">PRUEBAS</label>
                </div>
              </div>


              <div class="columnas" style="align-items: end;">
              
                <div>
                  
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
                  <label style="width: 50%; font-size: 16px">CON CORRECCIÓN:</label>
                  <label style="width: 50%; font-size: 16px">SIN CORRECCIÓN:</label>
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

              <div class="columnas">
                
                <div>     
                  <label>Notas de la prueba:</label>
                  <textarea rows="3" id="evoluciones-prueba" data-previa="evoluciones-previa" data-valor="pruebas_nota" class="evoluciones-valores upper textarea-espaciado contenedor-personalizable" style="resize:none;" data-scroll ></textarea>
                </div>

              </div>

              <div class="columnas" style="margin-top: 10px">
                <div>
                  <label style="font-size: 20px; border-bottom: 1px solid; width: 100%;">MOTILIDAD</label>
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

                    <section style="grid-template-columns: auto auto; align-self: end;">
                      <input type="text" data-valor="motilidad_od_1" placeholder="---" class="evoluciones-valores upper" style="width: 80px">
                      <input type="text" data-valor="motilidad_od_2" placeholder="---" class="evoluciones-valores upper" style="width: 80px; justify-self: flex-end;">
                    </section>

                    <section style="grid-template-columns: auto auto; align-self: center;">
                      <input type="text" data-valor="motilidad_od_3" placeholder="---" class="evoluciones-valores upper" style="width: 80px">
                      <input type="text" data-valor="motilidad_od_4" placeholder="---" class="evoluciones-valores upper" style="width: 80px; justify-self: flex-end;">
                    </section>

                    <section style="grid-template-columns: auto auto; align-self: start;">
                      <input type="text" data-valor="motilidad_od_5" placeholder="---" class="evoluciones-valores upper" style="width: 80px">
                      <input type="text" data-valor="motilidad_od_6" placeholder="---" class="evoluciones-valores upper" style="width: 80px; justify-self: flex-end;">
                    </section>

                  </div>

                  <div class="motilidad borde-estilizado">

                   <section style="grid-template-columns: auto auto; align-self: end;">
                      <input type="text" data-valor="motilidad_oi_1" placeholder="---" class="evoluciones-valores upper" style="width: 80px">
                      <input type="text" data-valor="motilidad_oi_2" placeholder="---" class="evoluciones-valores upper" style="width: 80px; justify-self: flex-end;">
                    </section>

                    <section style="grid-template-columns: auto auto; align-self: center;">
                      <input type="text" data-valor="motilidad_oi_3" placeholder="---" class="evoluciones-valores upper" style="width: 80px">
                      <input type="text" data-valor="motilidad_oi_4" placeholder="---" class="evoluciones-valores upper" style="width: 80px; justify-self: flex-end;">
                    </section>

                    <section style="grid-template-columns: auto auto; align-self: start;">
                      <input type="text" data-valor="motilidad_oi_5" placeholder="---" class="evoluciones-valores upper" style="width: 80px">
                      <input type="text" data-valor="motilidad_oi_6" placeholder="---" class="evoluciones-valores upper" style="width: 80px; justify-self: flex-end;">
                    </section>

                  </div>

              </div>

              <div class="columnas">
                
                <div>     
                  <label>Notas de la motilidad:</label>
                  <textarea rows="3" id="evoluciones-motilidad" data-previa="evoluciones-previa" data-valor="motilidad_nota" class="evoluciones-valores upper textarea-espaciado contenedor-personalizable" style="resize:none;" data-scroll ></textarea>
                </div>

              </div>

              <div class="titulo evoluciones-saltar">
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
                  RX: CICLOPLEGIA
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

              <div class="titulo evoluciones-saltar">
                <div>4</div>
                <div>Biomicroscopía</div>
              </div>

              <div class="columnas" style="align-items: baseline;">
                
                <section class="dibujar-herramientas-v">
                  
                  <div class="dibujar-colores-v">
          
                    <button class="bio-dibujar" data-color="black"></button>
                    <button class="bio-dibujar" data-color="#ca3f3f"></button>
                    <button class="bio-dibujar" data-color="blue"></button>
                    <button class="bio-dibujar" data-color="rgb(255 207 34)"></button>
                    <button class="bio-dibujar" data-color="orange"></button>
                    <button class="bio-dibujar" data-color="#529b62"></button>
                    <button class="bio-dibujar" data-color="purple"></button>
                    <button class="bio-dibujar" data-color="pink"></button>
                    <button class="bio-dibujar" data-color="#8d8d8d"></button>

                  </div>

                  <div class="dibujar-rango-v">
                      <input id="bio-rango" type="range" min="1" max="5" value="2" class="bio-slider">
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
                    <button id="bio-reiniciar" title="Reiniciar imagen">
                      <svg class="iconos-b" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><path fill="currentColor" d="M174.7 45.1C192.2 17 223 0 256 0s63.8 17 81.3 45.1l38.6 61.7 27-15.6c8.4-4.9 18.9-4.2 26.6 1.7s11.1 15.9 8.6 25.3l-23.4 87.4c-3.4 12.8-16.6 20.4-29.4 17l-87.4-23.4c-9.4-2.5-16.3-10.4-17.6-20s3.4-19.1 11.8-23.9l28.4-16.4L283 79c-5.8-9.3-16-15-27-15s-21.2 5.7-27 15l-17.5 28c-9.2 14.8-28.6 19.5-43.6 10.5c-15.3-9.2-20.2-29.2-10.7-44.4l17.5-28zM429.5 251.9c15-9 34.4-4.3 43.6 10.5l24.4 39.1c9.4 15.1 14.4 32.4 14.6 50.2c.3 53.1-42.7 96.4-95.8 96.4L320 448v32c0 9.7-5.8 18.5-14.8 22.2s-19.3 1.7-26.2-5.2l-64-64c-9.4-9.4-9.4-24.6 0-33.9l64-64c6.9-6.9 17.2-8.9 26.2-5.2s14.8 12.5 14.8 22.2v32l96.2 0c17.6 0 31.9-14.4 31.8-32c0-5.9-1.7-11.7-4.8-16.7l-24.4-39.1c-9.5-15.2-4.7-35.2 10.7-44.4zm-364.6-31L36 204.2c-8.4-4.9-13.1-14.3-11.8-23.9s8.2-17.5 17.6-20l87.4-23.4c12.8-3.4 26 4.2 29.4 17L182 241.2c2.5 9.4-.9 19.3-8.6 25.3s-18.2 6.6-26.6 1.7l-26.5-15.3L68.8 335.3c-3.1 5-4.8 10.8-4.8 16.7c-.1 17.6 14.2 32 31.8 32l32.2 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-32.2 0C42.7 448-.3 404.8 0 351.6c.1-17.8 5.1-35.1 14.6-50.2l50.3-80.5z"></path></svg>
                    </button>

                  </div>

                  <div class="dibujar-formas-v">
                    
                    <button id="dendritis" title="Dendritis">
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="116.551 73 42.58 44.54">
                        <path d="M 126 73 q -12 1 -4 5 C 125 80 130 82 122 84 c -7 2 -6 5 -3 6 c 2 1 5 2 8 3 c 13 5 -7 5 -10 8 s 10 4 10 7 s -9 1 -9 4 s 8 7 29 5 c 18 -4 13 -7 4 -11 c -12 -4 3 -4 4 -7.2649 c 1 -4.7351 -5 -3 -8 -4.7351 c -6.2646 -5.4146 11 -1 12 -8 c -1 -5 -16.2245 0.3909 -17 -3 c -1.1372 -5.4146 7 -2 10 -5 c 1 -2 -3 -4 -10 -4 C 138 74 135 73 131 73 Z" stroke="#529b62" stroke-width="1" fill="none"/>
                      </svg>
                    </button>

                    <button id="ulceras_redondas" title="Ulceras redondas">
                      <svg id="eCxcd3DV0lf1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 30 30" shape-rendering="geometricPrecision" text-rendering="geometricPrecision"><ellipse rx="12.329333" ry="12.329332" transform="translate(15 15)" fill="rgba(210,219,237,0)" stroke="#529b62"/></svg>
                    </button>

                    <button id="lente_intraocular" title="Lente intraocular">
                      <svg cache-id="c22f2e73c95946b6b41776ce31cf12cc" id="ewu43p8jZvo1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 60 60" shape-rendering="geometricPrecision" text-rendering="geometricPrecision"><ellipse rx="12.329333" ry="12.329332" transform="translate(30 30)" fill="rgba(210,219,237,0)" stroke="#8d8d8d"/><path d="M17.670667,30c-10.905211-6.154473-15.627304-20.125299,0-30" fill="none" stroke="#8d8d8d" stroke-width="0.5"/><path d="M42.329333,30c10.640452,7.179181,13.221354,21.949768,0,30" fill="none" stroke="#8d8d8d" stroke-width="0.5"/><ellipse rx="6" ry="6" transform="translate(30 30)" fill="none" stroke="#8d8d8d"/></svg>
                    </button>

                    <button id="congestion_ocular" title="Congestión ocular">  
                      <svg id="eZafsCov2LJ1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 60 60" shape-rendering="geometricPrecision" text-rendering="geometricPrecision"><path d="" fill="none" stroke="#3f5787" stroke-width="0.5"/><path d="" transform="translate(0 25.227145)" fill="none" stroke="#3f5787" stroke-width="0.5"/><path d="" transform="translate(50.007996 25.227145)" fill="none" stroke="#3f5787" stroke-width="0.5"/><path d="" transform="translate(50.007996-.01)" fill="none" stroke="#3f5787" stroke-width="0.5"/><path d="M0,19.933023h9.992004" transform="translate(0-2.659433)" fill="none" stroke="#ca3f3f" stroke-width="0.5"/><path d="M0,19.933023h9.992004" transform="translate(0 22.567712)" fill="none" stroke="#ca3f3f" stroke-width="0.5"/><path d="M0,19.933023h9.992004" transform="translate(50.007996 22.567712)" fill="none" stroke="#ca3f3f" stroke-width="0.5"/><path d="M0,19.933023h9.992004" transform="translate(0 24.647033)" fill="none" stroke="#ca3f3f" stroke-width="0.5"/><path d="M0,19.933023h9.992004" transform="translate(50.007996 24.647033)" fill="none" stroke="#ca3f3f" stroke-width="0.5"/><path d="M0,19.933023h9.992004" transform="translate(50.007996-2.669433)" fill="none" stroke="#ca3f3f" stroke-width="0.5"/><path d="M0,19.933023h9.992004" transform="translate(0-4.749433)" fill="none" stroke="#ca3f3f" stroke-width="0.5"/><path d="M0,19.933023h9.992004" transform="translate(0 20.477712)" fill="none" stroke="#ca3f3f" stroke-width="0.5"/><path d="M0,19.933023h9.992004" transform="translate(50.007996 20.477712)" fill="none" stroke="#ca3f3f" stroke-width="0.5"/><path d="M0,19.933023h9.992004" transform="translate(50.007996-4.759433)" fill="none" stroke="#ca3f3f" stroke-width="0.5"/></svg>
                    </button>

                    <button id="papilas_arriba" title="Papilas arriba">    
                      <svg id="eNjmdPTogGZ1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 90 50" shape-rendering="geometricPrecision" text-rendering="geometricPrecision"><path d="M10.784961,45.026368c.423796,2.176743.686605,2.929212,1.806605,4.462512c1.5,1.836257,4.379268,1.774804,5.54,0c1.070963-1.53327.982978-1.974812,1.669311-4.462513" transform="matrix(1 0 0 1.003243-6.258423-10.268734)" fill="none" stroke="#ca3f3f" stroke-width="0.5"/><path d="M10.784961,45.026368c.423796,2.176743.686605,2.929212,1.806605,4.462512c1.5,1.836257,4.379268,1.774804,5.54,0c1.070963-1.53327.982978-1.974812,1.669311-4.462513" transform="matrix(1 0 0 1.003243 3.757494-18.102782)" fill="none" stroke="#ca3f3f" stroke-width="0.5"/><path d="M10.784961,45.026368c.423796,2.176743.686605,2.929212,1.806605,4.462512c1.5,1.836257,4.379268,1.774804,5.54,0c1.070963-1.53327.982978-1.974812,1.669311-4.462513" transform="matrix(1 0 0 1.003243 14.773409-23.93683)" fill="none" stroke="#ca3f3f" stroke-width="0.5"/><path d="M10.784961,45.026368c.423796,2.176743.686605,2.929212,1.806605,4.462512c1.5,1.836257,4.379268,1.774804,5.54,0c1.070963-1.53327.982978-1.974812,1.669311-4.462513" transform="matrix(1 0 0 1.003243 26.457937-29.111274)" fill="none" stroke="#ca3f3f" stroke-width="0.5"/><path d="M10.784961,45.026368c.423796,2.176743.686605,2.929212,1.806605,4.462512c1.5,1.836257,4.379268,1.774804,5.54,0c1.070963-1.53327.982978-1.974812,1.669311-4.462513" transform="matrix(1 0 0 1.003243 38.457937-34.111274)" fill="none" stroke="#ca3f3f" stroke-width="0.5"/><path d="M10.784961,45.026368c.423796,2.176743.686605,2.929212,1.806605,4.462512c1.5,1.836257,4.379268,1.774804,5.54,0c1.070963-1.53327.982978-1.974812,1.669311-4.462513" transform="matrix(1 0 0 1.003243 52.457937-38.111274)" fill="none" stroke="#ca3f3f" stroke-width="0.5"/><path d="M10.784961,45.026368c.423796,2.176743.686605,2.929212,1.806605,4.462512c1.5,1.836257,4.379268,1.774804,5.54,0c1.070963-1.53327.982978-1.974812,1.669311-4.462513" transform="matrix(1 0 0 1.003243 65.457937-41.111274)" fill="none" stroke="#ca3f3f" stroke-width="0.5"/></svg>
                    </button>

                    <button id="papilas_abajo" title="Papilas abajo">
                      <svg id="eKDjukC59nm1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 90 50" shape-rendering="geometricPrecision" text-rendering="geometricPrecision"><path d="M10.784961,45.026368c.423796,2.176743.686605,2.929212,1.806605,4.462512c1.5,1.836257,4.379268,1.774804,5.54,0c1.070963-1.53327.982978-1.974812,1.669311-4.462513" transform="matrix(-1 0 0-1.003243 22.617808 56.769524)" fill="none" stroke="#ca3f3f" stroke-width="0.5"/><path d="M10.784961,45.026368c.423796,2.176743.686605,2.929212,1.806605,4.462512c1.5,1.836257,4.379268,1.774804,5.54,0c1.070963-1.53327.982978-1.974812,1.669311-4.462513" transform="matrix(-1 0 0-1.003243 33.633723 66.990132)" fill="none" stroke="#ca3f3f" stroke-width="0.5"/><path d="M10.784961,45.026368c.423796,2.176743.686605,2.929212,1.806605,4.462512c1.5,1.836257,4.379268,1.774804,5.54,0c1.070963-1.53327.982978-1.974812,1.669311-4.462513" transform="matrix(-1 0 0-1.003243 45.318251 75.741204)" fill="none" stroke="#ca3f3f" stroke-width="0.5"/><path d="M10.784961,45.026368c.423796,2.176743.686605,2.929212,1.806605,4.462512c1.5,1.836257,4.379268,1.774804,5.54,0c1.070963-1.53327.982978-1.974812,1.669311-4.462513" transform="matrix(-1 0 0-1.003243 57.318253 81.575252)" fill="none" stroke="#ca3f3f" stroke-width="0.5"/><path d="M10.784961,45.026368c.423796,2.176743.686605,2.929212,1.806605,4.462512c1.5,1.836257,4.379268,1.774804,5.54,0c1.070963-1.53327.982978-1.974812,1.669311-4.462513" transform="matrix(-1 0 0-1.003243 71.318253 84.492276)" fill="none" stroke="#ca3f3f" stroke-width="0.5"/><path d="M10.784961,45.026368c.423796,2.176743.686605,2.929212,1.806605,4.462512c1.5,1.836257,4.379268,1.774804,5.54,0c1.070963-1.53327.982978-1.974812,1.669311-4.462513" transform="matrix(-1 0 0-1.003243 84.318252 87.4093)" fill="none" stroke="#ca3f3f" stroke-width="0.5"/><path d="M10.784961,45.026368c.423796,2.176743.686605,2.929212,1.806605,4.462512c1.5,1.836257,4.379268,1.774804,5.54,0c1.070963-1.53327.982978-1.974812,1.669311-4.462513" transform="matrix(-1 0 0-1.003243 97.96803 89.4093)" fill="none" stroke="#ca3f3f" stroke-width="0.5"/></svg>
                    </button>

                    <button id="cicatriz_linea_izquierda" title="Cicatriz línea izquierda">
                      <svg id="eAjo27iYgT81" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 30 30" shape-rendering="geometricPrecision" text-rendering="geometricPrecision"><path d="M15,15l-30-30" transform="translate(15 15)" fill="none" stroke="#000" stroke-width="0.6" stroke-miterlimit="6"/></svg>
                    </button>
                    
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
                  <textarea rows="3" id="evoluciones-nota-b-od" data-previa="evoluciones-previa" data-valor="nota_b_od" class="evoluciones-valores upper textarea-espaciado contenedor-personalizable" style="resize:none;" data-scroll ></textarea>
                </div>

                <div>     
                  <label>Nota biomicroscopía OI:</label>
                  <textarea rows="3" id="evoluciones-nota-b-oi" data-previa="evoluciones-previa" data-valor="nota_b_oi" class="evoluciones-valores upper textarea-espaciado contenedor-personalizable" style="resize:none;" data-scroll ></textarea>
                </div>

              </div>

              <div class="titulo evoluciones-saltar">
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
                    <input id="fondo-rango" type="range" min="1" max="5" value="2" class="fondo-slider">
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
                    <button id="fondo-reiniciar" title="Reiniciar imagen">
                      <svg class="iconos-b" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><path fill="currentColor" d="M174.7 45.1C192.2 17 223 0 256 0s63.8 17 81.3 45.1l38.6 61.7 27-15.6c8.4-4.9 18.9-4.2 26.6 1.7s11.1 15.9 8.6 25.3l-23.4 87.4c-3.4 12.8-16.6 20.4-29.4 17l-87.4-23.4c-9.4-2.5-16.3-10.4-17.6-20s3.4-19.1 11.8-23.9l28.4-16.4L283 79c-5.8-9.3-16-15-27-15s-21.2 5.7-27 15l-17.5 28c-9.2 14.8-28.6 19.5-43.6 10.5c-15.3-9.2-20.2-29.2-10.7-44.4l17.5-28zM429.5 251.9c15-9 34.4-4.3 43.6 10.5l24.4 39.1c9.4 15.1 14.4 32.4 14.6 50.2c.3 53.1-42.7 96.4-95.8 96.4L320 448v32c0 9.7-5.8 18.5-14.8 22.2s-19.3 1.7-26.2-5.2l-64-64c-9.4-9.4-9.4-24.6 0-33.9l64-64c6.9-6.9 17.2-8.9 26.2-5.2s14.8 12.5 14.8 22.2v32l96.2 0c17.6 0 31.9-14.4 31.8-32c0-5.9-1.7-11.7-4.8-16.7l-24.4-39.1c-9.5-15.2-4.7-35.2 10.7-44.4zm-364.6-31L36 204.2c-8.4-4.9-13.1-14.3-11.8-23.9s8.2-17.5 17.6-20l87.4-23.4c12.8-3.4 26 4.2 29.4 17L182 241.2c2.5 9.4-.9 19.3-8.6 25.3s-18.2 6.6-26.6 1.7l-26.5-15.3L68.8 335.3c-3.1 5-4.8 10.8-4.8 16.7c-.1 17.6 14.2 32 31.8 32l32.2 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-32.2 0C42.7 448-.3 404.8 0 351.6c.1-17.8 5.1-35.1 14.6-50.2l50.3-80.5z"></path></svg>
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
                  <textarea rows="3" id="evoluciones-nota-f-od" data-previa="evoluciones-previa" data-valor="nota_f_od" class="evoluciones-valores upper textarea-espaciado contenedor-personalizable" style="resize:none;" data-scroll ></textarea>
                </div>

                <div>     
                  <label>Fondo de ojo OI:</label>
                  <textarea rows="3" id="evoluciones-nota-f-oi" data-previa="evoluciones-previa" data-valor="nota_f_oi" class="evoluciones-valores upper textarea-espaciado contenedor-personalizable" style="resize:none;" data-scroll ></textarea>
                </div>

              </div>

              <div class="titulo evoluciones-saltar">
                <div>6</div>
                <div>PIO, Estudios, IDX</div>
              </div>

              <div class="columnas" style="flex-direction: column; align-items: baseline;">

                <label>PIO (mmHg)</label>

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
                    <button id="evoluciones-nueva-estudio" class="boton-ver contenedor-resaltar" title="Cargar nuevo diagnóstico" style="left: 105px;">+</button>
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
                    <button id="evoluciones-nueva-diagnostico" class="boton-ver contenedor-resaltar" title="Cargar nuevo diagnóstico" style="left: 105px;">+</button>
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

              <div class="titulo evoluciones-saltar">
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

              <div class="columnas" style="flex-direction: column; align-items: baseline;">

                <label>Curva base</label>

                <div style="margin: 0px; flex-direction: row; column-gap: 10px;">
                  <div>    
                    <input type="text" data-valor="curva_od" class="evoluciones-valores upper decimales" placeholder="OD - 0.00">
                  </div>

                  <div>
                    <input type="text" data-valor="curva_oi" class="evoluciones-valores upper decimales" placeholder="OI - 0.00">
                  </div>  
                </div>

              </div>

              <div class="columnas" style="flex-direction: column; align-items: baseline;">

                <label>Altura pupilar</label>

                <div style="margin: 0px; flex-direction: row; column-gap: 10px;">
                  <div>    
                    <input type="text" data-valor="altura_pupilar_od" class="evoluciones-valores upper decimales" placeholder="OD - 0.00">
                  </div>

                  <div>
                    <input type="text" data-valor="altura_pupilar_oi" class="evoluciones-valores upper decimales" placeholder="OI - 0.00">
                  </div>  
                </div>

              </div>

              <div class="columnas" style="flex-direction: column; align-items: baseline;">

                <label>Distancia interpupilar</label>

                <div style="margin: 0px; flex-direction: row; column-gap: 10px;">
                  <div>    
                    <input type="text" data-valor="distancia_interpupilar_od" class="evoluciones-valores upper fracciones" placeholder="OD - 00/00">
                  </div>

                  <div>
                    <input type="text" data-valor="distancia_interpupilar_oi" class="evoluciones-valores upper fracciones" placeholder="OI - 00/00">
                  </div>

                  <div>
                    <input type="text" data-valor="distancia_interpupilar_add" class="evoluciones-valores upper" min="0" max="3" placeholder="ADD">
                  </div> 
                </div>

              </div>

              <div class="columnas" style="flex-direction: column; align-items: baseline;">

                <div>    
                  <label>DIP</label>
                  <input type="text" data-valor="dip" class="evoluciones-valores upper" placeholder="00mm">
                </div>

              </div>

              <div class="columnas" style="display: grid; grid-template-columns: auto auto auto; justify-content: stretch;">

                <div class="check-alineado">
                  <label>Bifocal - Kriptok</label>        
                  <input type="checkbox" data-valor="bifocal_kriptok" class="evoluciones-valores check checksmall" style="width: 30px; height: 30px">
                </div>

                <div class="check-alineado">
                  <label>Bifocal - Flap Top</label>        
                  <input type="checkbox" data-valor="bifocal_flat_top" class="evoluciones-valores check checksmall" style="width: 30px; height: 30px">
                </div> 

                <div class="check-alineado">
                  <label>Bifocal - Ultex</label>        
                  <input type="checkbox" data-valor="bifocal_ultex" class="evoluciones-valores check checksmall" style="width: 30px; height: 30px">
                </div>

                <div class="check-alineado">
                  <label>Multifocal</label>        
                  <input type="checkbox" data-valor="multifocal" class="evoluciones-valores check checksmall" style="width: 30px; height: 30px">
                </div>

                <div class="check-alineado">
                  <label>Bifocal - Ejecutivo</label>        
                  <input type="checkbox" data-valor="bifocal_ejecutivo" class="evoluciones-valores check checksmall" style="width: 30px; height: 30px">
                </div>

              </div>

              <div class="columnas">
                
                <div>     
                  <label>Plan:</label>
                  <textarea rows="6" id="evoluciones-plan" data-previa="evoluciones-previa" data-valor="plan" class="evoluciones-valores upper textarea-espaciado contenedor-personalizable" style="resize:none; margin-bottom: 10px;" data-scroll ></textarea>
                </div>
                
              </div>


              <div class="titulo evoluciones-saltar">
                <div>8</div>
                <div>Anexos</div>
              </div>

              <div class="columnas">
                  
                <div style="width: fit-content;">
                  <label style="font-size: 20px">ANTES DE LA CIRUGÍA</label>
                  <input type="file" id="anexos-antes-cargar" multiple class="galeria-cargar evoluciones-valores">
                </div>

                <div class="check-alineado" style="top: 13px; position: relative;">
                  <label>APLICA EL USO DE LENTES</label>        
                  <input type="checkbox" data-valor="anexos_antes_lentes" class="evoluciones-valores check checksmall" style="width: 30px; height: 30px">
                </div>

              </div>

              <div class="columnas">

                <div id="anexos-antes-contenedor" class="galeria-contenedor"></div>
                
              </div>

              <div class="columnas" style="margin-top: 30px;">
                  
                <div style="width: fit-content;">
                  <label style="font-size: 20px">DESPUÉS DE LA CIRUGÍA</label>
                  <input type="file" id="anexos-despues-cargar" multiple class="galeria-cargar evoluciones-valores">
                </div>

                <div class="check-alineado" style="top: 13px; position: relative;">
                  <label>APLICA EL USO DE LENTES</label>        
                  <input type="checkbox" data-valor="anexos_despues_lentes" class="evoluciones-valores check checksmall" style="width: 30px; height: 30px">
                </div>

              </div>

              <div class="columnas">

                <div id="anexos-despues-contenedor" class="galeria-contenedor"></div>

              </div>

            </section>

            <section id="crud-evoluciones-botones" data-crud='botones-evoluciones' style="column-gap: 10px; padding: 10px 10px 0px 10px; justify-content: center; display: flex;">

              <?php 
                if ($_SESSION['usuario']['rol'] == 'ADMINISTRACION') {
              ?>
                <button class="evoluciones-notificar" title="Envía una notificación informativa a recepción" data-hidden>
                  <svg style="width: 15px; height: 15px;" class="iconos" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><path fill="currentColor" d="M64 32C64 14.3 49.7 0 32 0S0 14.3 0 32V64 368 480c0 17.7 14.3 32 32 32s32-14.3 32-32V352l64.3-16.1c41.1-10.3 84.6-5.5 122.5 13.4c44.2 22.1 95.5 24.8 141.7 7.4l34.7-13c12.5-4.7 20.8-16.6 20.8-30V66.1c0-23-24.2-38-44.8-27.7l-9.6 4.8c-46.3 23.2-100.8 23.2-147.1 0c-35.1-17.6-75.4-22-113.5-12.5L64 48V32z"/></svg>
                </button>
              <?php 
                } else if ($_SESSION['usuario']['rol'] == 'DOCTOR') {
              ?>
                <button class="evoluciones-notificar" title="Envía una notificación informativa a recepción">
                  <svg style="width: 15px; height: 15px;" class="iconos" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><path fill="currentColor" d="M64 32C64 14.3 49.7 0 32 0S0 14.3 0 32V64 368 480c0 17.7 14.3 32 32 32s32-14.3 32-32V352l64.3-16.1c41.1-10.3 84.6-5.5 122.5 13.4c44.2 22.1 95.5 24.8 141.7 7.4l34.7-13c12.5-4.7 20.8-16.6 20.8-30V66.1c0-23-24.2-38-44.8-27.7l-9.6 4.8c-46.3 23.2-100.8 23.2-147.1 0c-35.1-17.6-75.4-22-113.5-12.5L64 48V32z"/></svg>
                </button>

                <div style="
                  width: 1px;
                  height: 100%;
                  border-left: 2px dashed #ff8101;
                  height: 35px;
                "></div>
              <?php 
                }
              ?>

              <button class="evoluciones-confirmar botones-formularios">CONFIRMAR</button>
              <button class="evoluciones-cancelar botones-formularios cancelar">CANCELAR</button> 
            </section>

          </div>

      </section>

      <!-------------------------------------------------------- -->
      <!------------------ EVOLUCIONES CONSULTAR --------------- -->
      <!-------------------------------------------------------- -->
      <section class="evoluciones-seccion" data-hide>
                      
          <div data-familia class="contenedor" id="evoluciones-consultar-contenedor" data-efecto="derecha-1">

            <div style="display: none">
              <input type="text" id="evoluciones-busqueda" autocomplete="off">
              <button id="evoluciones-buscar" class="btn">- </button>
            </div>

            <div id="evoluciones-consulta-fechas">
              <label>Seleccionar evolución por fecha:</label>
              <select></select>
            </div>

            <div id="tabla-evoluciones-consultar-contenedor" class="tabla-ppal" data-scroll>
              <table id="tabla-evoluciones-consultar" class="table table-bordered table-striped">
                <thead>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>

          </div>

      </section>

    </div>

  </div>

</div>