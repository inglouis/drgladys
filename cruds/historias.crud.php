<!--//////////////////////////////////////////////////////////////////////////////////-->
<!--////////////////////////  TEMPLATE FECHA //////////////////////////////////-->
<!--//////////////////////////////////////////////////////////////////////////////////-->

<template id="template-fecha">

    <section class="template-fecha-contenedor">
        
    <div class="elementos">
      <label>Fecha</label>
      <input type="date" class="fecha-template input" disabled style="background:#fff">
    </div>

     <div class="elementos">
      <label>Hora</label>
      <input type="time" class="hora-template input" step="1" disabled style="background:#fff">
    </div>

</section>

</template>

<!-------------------------------------------------------- -->
<!--------------------- INFORMARCIÓN  -------------------- -->
<!-------------------------------------------------------- -->
<div id="crud-informacion-popup" class="popup-oculto" data-crud='popup'>
  <div id="crud-informacion-pop" class="popup-oculto" data-scroll style="
    justify-content: flex-start;
    position: relative;
    min-width: 450px;
  ">

    <button id="crud-informacion-cerrar" data-crud='cerrar'>X</button>

    <section id="crud-informacion-titulo" data-crud='titulo'>
      INFORMACIÓN DEL PACIENTE
    </section>

    <input type="text" id="informacion-enfocar" style="position: absolute; top: -100%;">

    <div class="valor-cabecera" style="padding-top: 2px;">
      <div style="
        justify-content: flex-start;
        padding: 0px 0px 3px 0px;
        margin-bottom: 7px;
        border-bottom: 1px solid #97b2d1;
      ">
        <label>Última consulta (MM-DD-AAAA)</label>
        <input type="text" id="informacion-fecha-valor" data-valor="fecha_cons" class="informacion-valores upper visual" disabled style="width: 65px;">
      </div>
    </div>

    <div class="filas" style="height: fit-content;">

      <div class="columnas">
        
        <div style="width:40%">
          <label>Cédula/rif</label>
          <input type="text" data-valor="cedula" class="informacion-valores upper visual" disabled>
        </div>

        <div>
          <label>Nombre completo</label>
          <input type="text" data-valor="nombre_completo" class="informacion-valores upper visual" disabled>
        </div>

      </div>

      <div class="columnas">
        
        <div>
          <label>Dirección</label>
          <input type="text" data-valor="direccion" class="informacion-valores upper visual" disabled>
        </div>

      </div>

      <div class="columnas">
        
        <div>
          
          <label>Ocupación</label>
          <section data-grupo="cc-ocupacion-consultar" class="combo-consulta">
            <input type="text" data-limit="" data-hide>
            <select class="informacion-valores upper visual" data-valor="id_ocupacion" disabled style="color:#262626"></select>
          </section>

        </div>

        <div>

          <label>Sexo</label>
          <select data-valor="sexo" class="informacion-valores upper visual" disabled style="color:#262626">
            <option value="">Sin definir</option>
            <option value="F">FEMENINO</option>
            <option value="M">MASCULINO</option>
          </select>

        </div>

      </div>

      <div class="columnas">
        
        <div>
          <label>Fecha de nacimiento</label>
          <input type="date" id="informacion-fecha" data-valor="fecha_naci" class="informacion-valores upper visual" disabled>
        </div>

        <div>
          <label>Edad</label>
          <input type="text" id="informacion-edad" class="upper visual" disabled>
        </div>

      </div>

      <div class="columnas" style="flex-direction: row;align-items: baseline; padding-bottom: 5px;">
        
        <div style="margin: 0px">
          <label>Teléfonos</label>
          <section data-valor="telefonos" class="informacion-valores contenedor-lista"></section>
        </div>

      </div>

      <div class="columnas" style="flex-direction: column;align-items: baseline; padding-bottom: 5px;">
        
        <label>Otros</label>
        <section data-valor="otros" class="informacion-valores contenedor-lista"></section>

      </div>

    </div>

    <section id="crud-informacion-botones" data-crud='botones-derecha'>
      <button class="botones-formularios cerrar">CERRAR</button>
    </section>

  </div>
</div>

<!-------------------------------------------------------- -->
<!---------------------------- EDITAR -------------------- -->
<!-------------------------------------------------------- -->
<div id="crud-editar-popup" class="popup-oculto" data-crud='popup'>
  <div id="crud-editar-pop" class="popup-oculto" data-scroll style="height: 90%; justify-content: flex-start; min-width: 600px; width: 40%">
    <button id="crud-editar-cerrar" data-crud='cerrar'>X</button>
    <section id="crud-editar-titulo" data-crud='titulo'>
      EDITAR HISTORIA
    </section> 

    <div class="filas" style="justify-content: flex-start;">

      <div class="columnas">

        <div style="width: 100px" title="[TAB] para enforcar">
          <label class="requerido">Cédula/rif</label>
          <input id="editar-enfocar" type="text" data-valor="cedula" placeholder="-" class="editar-valores lleno upper" maxlength="14">
        </div>

        <div>
          <label class="requerido">Nombres</label>
          <input type="text" data-valor="nombres" placeholder="-" class="editar-valores lleno upper">
        </div>

        <div>
          <label class="requerido">Apellidos</label>
          <input type="text" data-valor="apellidos" placeholder="-" class="editar-valores lleno upper">
        </div>

      </div> 

      <div class="columnas">
        
        <div>
          <label class="requerido">Fecha de nacimiento</label>
          <input type="date" id="editar-fecha" data-valor="fecha_nacimiento" class="editar-valores lleno upper">
        </div>

        <div>
          <label>Edad</label>
          <input type="text" id="editar-edad" class="lleno upper" disabled style="background: #fff">
        </div>

      </div>

      <div class="columnas">
        
        <div>
          <label>Dirección</label>
          <input type="text" data-valor="direccion" placeholder="-" class="editar-valores upper">
        </div>

      </div>

      <div class="columnas" style="align-items: baseline;">

        <div style="position: relative;">

          <button id="editar-nueva-ocupacion" class="boton-ver contenedor-resaltar" title="Cargar nueva ocupación" style="left: 95px;">
            +  
          </button>

          <label>Ocupación</label>
          <section data-grupo="cc-ocupacion-editar" class="combo-consulta">

            <input type="text" placeholder="Buscar ocupación" data-limit="" class="upper">
            <select class="editar-valores scroll" data-valor="id_ocupacion" id="editar-ocupacion"></select>

          </section>

        </div>

      </div>

      <div class="columnas">

        <div>

          <label>Sexo</label>
          <select data-valor="sexo" class="editar-valores upper">
            <option value="">Seleccionar...</option>
            <option value="F">FEMENINO</option>
            <option value="M">MASCULINO</option>
          </select>

        </div>
        

      </div>

      <div class="columnas">
        <div>
          <label class="requerido">Estado de la historia</label>
          <select class="editar-valores lleno" data-valor="status">
            <option value="A">ACTIVADA</option>
            <option value="D">DESACTIVADA</option>
          </select>            
        </div>
      </div>

      <div class="columnas">
        
        <div>

          <label>Teléfonos</label>

          <section id="cc-telefonos-editar" class="contenedor-consulta editar-valores borde-estilizado" data-valor="telefonos">

            <span class="tooltip-general">Presionar [ENTER] para agregar</span>
            <section>
              <input type="number" data-estilo="cc-input" placeholder="Cargar...">
              <select data-limit="" data-estilo="cc-select" data-hide></select>
            </section>
            <div data-estilo="cc-div" style="max-height: 70px; min-height: 70px; border: none"></div>

          </section>

        </div>

      </div>

      <div class="columnas">

        <div>
          <label>Otros</label>
          
          <section id="cc-otros-editar" class="contenedor-consulta editar-valores borde-estilizado" data-valor="otros">

            <span class="tooltip-general">Presionar [ENTER] para agregar</span>
            <section>
              <input type="text" data-estilo="cc-input" placeholder="Cargar..." class="upper">
              <select data-limit="" data-estilo="cc-select" data-hide></select>
            </section>
            <div data-estilo="cc-div" style="max-height: 70px; min-height: 70px; border: none"></div>

          </section>

        </div>

      </div>

      <section id="crud-editar-botones" data-crud='botones' style="column-gap: 10px; padding: 10px;">
        <button class="botones-formularios editar">CONFIRMAR</button>
        <button class="botones-formularios cerrar">CANCELAR</button> 
      </section>
    </div>
  </div>
</div>

<!-------------------------------------------------------- -->
<!------------------- INSERTAR --------------------------- -->
<!-------------------------------------------------------- -->
<div id="crud-insertar-popup" class="popup-oculto" data-crud='popup'>
  <div id="crud-insertar-pop" class="popup-oculto" data-scroll style="height: 90%; justify-content: flex-start; min-width: 600px; width: 40%">
    <button id="crud-insertar-cerrar" data-crud='cerrar'>X</button>
    <section id="crud-insertar-titulo" data-crud='titulo'>
      INSERTAR HISTORIA
    </section> 

    <div class="filas" style="justify-content: flex-start; height: fit-content;">

      <div class="columnas">

        <div style="width: 100px">
          <label class="requerido">Cédula/rif</label>
          <input id="insertar-enfocar" type="text" placeholder="-" class="insertar-valores lleno upper" maxlength="14">
        </div>

        <div>
          <label class="requerido">Nombres</label>
          <input id="insertar-nombre" type="text" placeholder="-" class="insertar-valores lleno upper">
        </div>

        <div>
          <label class="requerido">Apellidos</label>
          <input type="text" placeholder="-" class="insertar-valores lleno upper">
        </div>

      </div>

      <div class="columnas">
        
        <div>
          <label class="requerido">Fecha de nacimiento</label>
          <input type="date" id="insertar-fecha" class="insertar-valores lleno upper">
        </div>

        <div>
          <label>Edad</label>
          <input type="text" id="insertar-edad" class="lleno upper" disabled>
        </div>

      </div> 

      <div class="columnas">
        
        <div>
          <label>Dirección</label>
          <input type="text" placeholder="-" class="insertar-valores upper">
        </div>

      </div>

      <div class="columnas" style="align-items: baseline;">

        <div style="position: relative;">

          <button id="insertar-nueva-ocupacion" class="boton-ver contenedor-resaltar" title="Cargar nueva ocupación" style="left: 105px;">
            +  
          </button>

          <label>Ocupación</label>
          <section data-grupo="cc-ocupacion-insertar" class="combo-consulta">

            <input type="text" placeholder="Buscar ocupación" data-limit="" class="upper">
            <select class="insertar-valores scroll" id="insertar-ocupacion"></select>

          </section>

        </div>

      </div>

      <div class="columnas">

        <div>

          <label>Sexo</label>
          <select class="insertar-valores upper">
            <option value="">Seleccionar...</option>
            <option value="F">FEMENINO</option>
            <option value="M">MASCULINO</option>
          </select>

        </div>

      </div>

      <div class="columnas">
        
        <div>

          <label>Teléfonos</label>

          <section id="cc-telefonos-insertar" class="contenedor-consulta insertar-valores borde-estilizado">

            <span class="tooltip-general">Presionar [ENTER] para agregar</span>
            <section>
              <input type="number" data-estilo="cc-input" placeholder="Cargar...">
              <select data-limit="" data-estilo="cc-select" data-hide></select>
            </section>
            <div data-estilo="cc-div" style="max-height: 70px; min-height: 70px; border: none"></div>

          </section>
        </div>

      </div>

      <div class="columnas">

        <div>
          <label>Otros</label>
          
          <section id="cc-otros-insertar" class="contenedor-consulta insertar-valores borde-estilizado">

            <span class="tooltip-general">Presionar [ENTER] para agregar</span>
            <section>
              <input type="text" data-estilo="cc-input" placeholder="Cargar..." class="upper">
              <select data-limit="" data-estilo="cc-select" data-hide></select>
            </section>
            <div data-estilo="cc-div" style="max-height: 70px; min-height: 70px; border: none"></div>

          </section>

        </div>

      </div>

    </div>

    <section id="crud-insertar-botones" data-crud='botones' style="column-gap: 10px; padding: 10px;">
      <button class="botones-formularios insertar">CONFIRMAR</button>
      <button class="botones-formularios cerrar">CANCELAR</button> 
    </section>

  </div>
</div>

<!------------------------------------------------------------------- -->
<!---------------------- INSERTAR OCUPACIONES ----------------------- -->
<!------------------------------------------------------------------- -->
<div id="crud-insertar-ocupaciones-popup" class="popup-oculto" data-crud='popup'>
  <div id="crud-insertar-ocupaciones-pop" class="popup-oculto" style="width:50%;">

    <button id="crud-insertar-ocupaciones-cerrar" data-crud='cerrar'>X</button>

    <section id="crud-insertar-ocupaciones-titulo" data-crud='titulo'>
      Insertar ocupación
    </section> 

    <section class="filas">
      <div class="columnas">
        <div>
          <label class="requerido">Nombre de la ocupación</label>  
          <input type="text" minlength="1" id="nombre-ocupaciones" maxlength="100" class="nuevas-ocupaciones lleno upper" placeholder="...">
        </div>
      </div> 

    </section>
    <section id="crud-insertar-ocupaciones-botones" data-crud='botones' style="column-gap: 10px; padding: 10px;">
      <button class="botones-formularios insertar">CONFIRMAR</button>
      <button class="botones-formularios cerrar">CANCELAR</button> 
    </section>
  </div> 
</div>