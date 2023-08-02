
<!--1)---------------------------------------------------- -->
<!---------------- CONSTANCIAS EDITAR -------------------- -->
<!-------------------------------------------------------- -->
<div id="crud-coneditar-popup" class="popup-oculto" data-crud='popup'>
  <div id="crud-coneditar-pop" class="popup-oculto" style="width:30%; min-width: 300px">

    <button id="crud-coneditar-cerrar" data-crud='cerrar'>X</button>

    <section id="crud-coneditar-titulo" data-crud='titulo'>
      EDITAR CONSTANCIA
    </section>

    <div class="filas" style="height: fit-content; position:relative;">

      <div class="personalizacion-b" id="crud-coneditar-personalizacion" data-hidden>
        <section>Personalización</section>
        <section style="width: 100%; border: 1px dashed #fff"></section>
        <span>ENTER: SEPARAR LÍNEA</span>
        <span>°CENTRAR°</span>
        <span>*<b>NEGRITA</b>*</span>
        <span>_ <u>SUBRAYADO</u> _</span>
        <span>~<i>ITÁLICA</i>~</span>

        <div class="previa-b" id="coneditar-previa" data-scroll></div>
      </div>

      <div class="columnas">
        
        <div>
          <label class="requerido">Constancia</label>
          <textarea rows="4" id="coneditar-textarea" data-previa="coneditar-previa" data-valor="constancia" class="coneditar-valores upper lleno textarea-espaciado contenedor-personalizable" style="resize:none; min-height: 30vh;" data-scroll></textarea>
        </div>

      </div>

    </div>

    <section id="crud-coneditar-botones" data-crud='botones' style="column-gap:5px">
      <button class="botones-formularios confirmar btn-editar">CONFIRMAR</button>
      <button class="botones-formularios cerrar">CANCELAR</button>
    </section>

  </div>
</div>

<!--2)---------------------------------------------------- -->
<!-------------------- GENERAL EDITAR -------------------- -->
<!-------------------------------------------------------- -->
<div id="crud-geneditar-popup" class="popup-oculto" data-crud='popup'>
  <div id="crud-geneditar-pop" class="popup-oculto" style="width:30%; min-width: 300px">

    <button id="crud-geneditar-cerrar" data-crud='cerrar'>X</button>

    <section id="crud-geneditar-titulo" data-crud='titulo'>
      EDITAR INFORMACIÓN GENERAL
    </section>

    <div class="filas" style="height: fit-content; position:relative;">

      <div class="personalizacion-b" id="crud-geneditar-personalizacion" data-hidden>
        <section>Personalización</section>
        <section style="width: 100%; border: 1px dashed #fff"></section>
        <span>ENTER: SEPARAR LÍNEA</span>
        <span>°CENTRAR°</span>
        <span>*<b>NEGRITA</b>*</span>
        <span>_ <u>SUBRAYADO</u> _</span>
        <span>~<i>ITÁLICA</i>~</span>

        <div class="previa-b" id="geneditar-previa" data-scroll></div>

      </div>

      <div class="columnas">
        
        <div>
          <label class="requerido">Título</label>
          <input type="text" id="geneditar-titulo" data-valor="titulo" class="geneditar-valores upper lleno">
        </div>

      </div>

      <div class="columnas" style="height: 100%">

        <div>
          <label class="requerido">Información</label>
          <textarea rows="4" id="geneditar-informacion" data-previa="geneditar-previa" data-valor="general" class="geneditar-valores upper lleno textarea-espaciado contenedor-personalizable" style="resize:none; min-height: 30vh;" data-scroll></textarea>
        </div>

      </div>

    </div>

    <section id="crud-geneditar-botones" data-crud='botones' style="column-gap:5px">
      <button class="botones-formularios confirmar btn-editar">CONFIRMAR</button>
      <button class="botones-formularios cerrar">CANCELAR</button>
    </section>

  </div>
</div>

<!--3)---------------------------------------------------- -->
<!----------------------------  -------------------------- -->
<!-------------------------------------------------------- -->