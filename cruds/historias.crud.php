<!--//////////////////////////////////////////////////////////////////////////////////-->
<!--///////////////////////////////  TEMPLATE FECHA //////////////////////////////////-->
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

<!--//////////////////////////////////////////////////////////////////////////////////-->
<!--////////////////////////////  TEMPLATE ELIMINAR //////////////////////////////////-->
<!--//////////////////////////////////////////////////////////////////////////////////-->
<template id="eliminar-template">
  <div class="eliminar-contenedor">

    <div class="eliminar-texto" style="color: #fff;">
      ¿DESEA ELIMINAR ESTE REPORTE?: 
    </div>

    <div>
      <button class="btn eliminar-boton btn-eliminar" title="ELIMINAR">X</button>
    </div>
  </div>
</template>

<!-------------------------------------------------------- -->
<!--------------------- INFORMARCIÓN  -------------------- -->
<!-------------------------------------------------------- -->
<div id="crud-informacion-popup" class="popup-oculto" data-crud='popup'>
  <div id="crud-informacion-pop" class="popup-oculto" data-scroll style="
    justify-content: flex-start;
    position: relative;
    min-width: 600px;
  ">

    <button id="crud-informacion-cerrar" data-crud='cerrar'>X</button>

    <section id="crud-informacion-titulo" data-crud='titulo'>
      INFORMACIÓN DEL PACIENTE
    </section>

    <input type="text" autocomplete="off"  id="informacion-enfocar" style="position: absolute; top: -100%;">

    <div class="valor-cabecera" style="padding-top: 2px;">
      <div style="
        justify-content: flex-start;
        padding: 0px 0px 3px 0px;
        margin-bottom: 7px;
        border-bottom: 1px solid #97b2d1;
      ">
        <label>Última consulta (MM-DD-AAAA)</label>
        <input type="text" autocomplete="off"  id="informacion-fecha-valor" data-valor="fecha_cons" class="informacion-valores upper visual" disabled style="width: 65px;">
      </div>
    </div>

    <div class="filas" style="height: fit-content;">

      <div class="columnas">
        
        <div style="width:20rem">
          <label>N° historia</label>
          <input type="text" autocomplete="off"  data-valor="id_historia" class="informacion-valores upper visual" disabled>
        </div>

        <div style="width:20rem">
          <label>Cédula/rif</label>
          <input type="text" autocomplete="off"  data-valor="cedula" class="informacion-valores upper visual" disabled>
        </div>

        <div>
          <label>Nombre completo</label>
          <input type="text" autocomplete="off"  data-valor="nombre_completo" class="informacion-valores upper visual" disabled>
        </div>

      </div>

      <div class="columnas">
        
        <div>
          <label>Dirección</label>
          <input type="text" autocomplete="off"  data-valor="direccion" class="informacion-valores upper visual" disabled>
        </div>

      </div>

      <div class="columnas">
        
        <div>

          <label>Sexo</label>
          <select data-valor="sexo" class="informacion-valores upper visual" disabled style="color:#262626">
            <option value="">SIN DEFINIR</option>
            <option value="F">FEMENINO</option>
            <option value="M">MASCULINO</option>
          </select>

        </div>

        <div style="width: 40rem;">
          <label>Fecha de nacimiento</label>
          <input type="date" id="informacion-fecha" data-valor="fecha_naci" class="informacion-valores upper visual" disabled>
        </div>

        <div style="width: 10rem">
          <label>Edad</label>
          <input type="text" autocomplete="off"  id="informacion-edad" class="upper visual" disabled>
        </div>

        <div>
          <label>Lugar de nacimiento</label>
          <input type="text" autocomplete="off"  data-valor="lugar_naci" class="informacion-valores upper visual" disabled>
        </div>

      </div>

      <div class="columnas">
        
        <div>
          
          <label>Ocupación</label>
          <section data-grupo="cc-ocupaciones-consultar" class="combo-consulta">
            <input type="text" autocomplete="off"  data-limit="" data-hide>
            <select class="informacion-valores upper visual" data-valor="id_ocupacion" disabled style="color:#262626"></select>
          </section>

        </div>

        <div>
          
          <label>Proveniencia</label>
          <section data-grupo="cc-proveniencias-consultar" class="combo-consulta">
            <input type="text" autocomplete="off"  data-limit="" data-hide>
            <select class="informacion-valores upper visual" data-valor="id_proveniencia" disabled style="color:#262626"></select>
          </section>

        </div>

        <div>
          
          <label>Médico referido</label>
          <section data-grupo="cc-medicos-consultar" class="combo-consulta">
            <input type="text" autocomplete="off"  data-limit="" data-hide>
            <select class="informacion-valores upper visual" data-valor="id_medico_referido" disabled style="color:#262626"></select>
          </section>

        </div>

      </div>

      <div class="columnas">

        <div>
          
          <label>Parentesco</label>
          <section data-grupo="cc-parentescos-consultar" class="combo-consulta">
            <input type="text" autocomplete="off"  data-limit="" data-hide>
            <select class="informacion-valores upper visual" data-valor="id_parentesco" disabled style="color:#262626"></select>
          </section>

        </div>

        <div>
          
          <label>Estado civil</label>
          <section data-grupo="cc-estado_civil-consultar" class="combo-consulta">
            <input type="text" autocomplete="off"  data-limit="" data-hide>
            <select class="informacion-valores upper visual" data-valor="id_estado_civil" disabled style="color:#262626"></select>
          </section>

        </div>

        <div>
          
          <label>Religión</label>
          <section data-grupo="cc-religiones-consultar" class="combo-consulta">
            <input type="text" autocomplete="off"  data-limit="" data-hide>
            <select class="informacion-valores upper visual" data-valor="id_religion" disabled style="color:#262626"></select>
          </section>

        </div>

      </div>

      <div class="columnas">
        <div>
          <label>Representante de emergencia</label>
          <input type="text" autocomplete="off"  data-valor="emergencia_persona" class="informacion-valores upper visual" disabled>
        </div>

        <div>
          <label>Representante información</label>
          <input type="text" autocomplete="off"  data-valor="emergencia_informacion" class="informacion-valores upper visual" disabled>
        </div>

        <div>
          <label>Representante contacto</label>
          <input type="text" autocomplete="off"  data-valor="emergencia_contacto" class="informacion-valores upper visual" disabled>
        </div>
      </div>

      <div class="columnas" style="flex-direction: row;align-items: baseline; padding-bottom: 5px;">
        
        <div style="margin: 0px">
          <label>Teléfonos</label>
          <section data-valor="telefonos" class="informacion-valores contenedor-lista"></section>
        </div>

        <div>
          <label>Otros</label>
          <section data-valor="otros" class="informacion-valores contenedor-lista"></section>
        </div>

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
  <div id="crud-editar-pop" class="popup-oculto" data-scroll style="
      height: fit-content; 
      justify-content: flex-start; 
      min-width: 800px; 
      max-height: 90%; 
      width: 50%;"
    >
    <button id="crud-editar-cerrar" data-crud='cerrar'>X</button>
    <section id="crud-editar-titulo" data-crud='titulo'>
      EDITAR HISTORIA

      <div class="valor-cabecera cabecera-formularios">
        <div>
          <label>N° de historia</label>
          <input type="text" autocomplete="off"  data-valor="id_historia" class="editar-cargar upper visual" disabled style="width: 65px;">
        </div>
      </div>

    </section>

    <div class="filas" style="justify-content: flex-start;">

      <div class="columnas">

        <div style="width: 20rem" title="[TAB] para enforcar">
          <label class="requerido">Cédula/rif</label>
          <input id="editar-enfocar" type="text" autocomplete="off"  maxlength="14" data-valor="cedula" placeholder="-" class="editar-valores lleno upper" maxlength="14">
        </div>

        <div style="width: 20rem;">
          <label>N° HIJO</label>
          <select data-valor="nro_hijo" class="editar-valores upper">
            <option value="0">---</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
            <option value="13">13</option>
            <option value="14">14</option>
            <option value="15">15</option>
          </select>
        </div>

        <div>
          <label class="requerido">Nombres</label>
          <input type="text" autocomplete="off"  data-valor="nombres" maxlength="100" placeholder="-" class="editar-valores lleno upper">
        </div>

        <div>
          <label class="requerido">Apellidos</label>
          <input type="text" autocomplete="off"  data-valor="apellidos" maxlength="100" placeholder="-" class="editar-valores lleno upper">
        </div>

      </div> 

      <div class="columnas">
        
        <div style="width: 40rem;">
          <label class="requerido">Fecha de nacimiento</label>
          <input type="date" id="editar-fecha" data-valor="fecha_naci" class="editar-valores lleno upper">
        </div>

        <div style="width: 20rem">
          <label>Edad</label>
          <input type="text" autocomplete="off"  id="editar-edad" class="lleno upper" disabled style="background: #fff">
        </div>

        <div>
          <label>Lugar de nacimiento</label>
          <input type="text" autocomplete="off"  data-valor="lugar_naci" class="editar-valores upper">
        </div>

      </div>

      <div class="columnas">
        
        <div>
          <label>Dirección</label>
          <input type="text" autocomplete="off"  data-valor="direccion" placeholder="-" class="editar-valores upper">
        </div>

      </div>

      <div class="columnas" style="align-items: baseline;">

        <div>

          <label class="requerido">
            <button id="editar-nueva-ocupaciones" class="boton-ver contenedor-resaltar" title="Cargar nueva ocupación" style="left: 75px; top: 4px">
              +  
            </button>
            Ocupación
          </label>

          <section data-grupo="cc-ocupaciones-editar" class="combo-consulta">

            <input type="text" autocomplete="off" placeholder="Buscar ocupación" data-limit="" class="upper">
            <select class="editar-valores lleno scroll" data-valor="id_ocupacion" id="editar-ocupacion"></select>

          </section>

        </div>

        <div>

          <label>
            <button id="editar-nueva-proveniencias" class="boton-ver contenedor-resaltar" title="Cargar nueva proveniencia" style="left: 80px; top: 4px">
              +  
            </button>
            Proveniencia
          </label>

          <section data-grupo="cc-proveniencias-editar" class="combo-consulta">

            <input type="text" autocomplete="off"  placeholder="Buscar proveniencia" data-limit="" class="upper">
            <select class="editar-valores scroll" data-valor="id_proveniencia" id="editar-proveniencia"></select>

          </section>

        </div>

        <div>

          <label>
            <button id="editar-nueva-medicos" class="boton-ver contenedor-resaltar" title="Cargar nuevo médico" style="left: 95px; top: 4px">
              +  
            </button>
            Médico referido
          </label>

          <section data-grupo="cc-medicos-editar" class="combo-consulta">

            <input type="text" autocomplete="off"  placeholder="Buscar médico referido" data-limit="" class="upper">
            <select class="editar-valores scroll" data-valor="id_proveniencia" id="editar-medico"></select>

          </section>

        </div>

      </div>

      <div class="columnas" style="align-items: baseline;">

        <div>

          <label>
            <button id="editar-nueva-parentescos" class="boton-ver contenedor-resaltar" title="Cargar nuevo parentesco" style="left: 70px; top: 4px">
              +  
            </button>
            Parentesco
          </label>

          <section data-grupo="cc-parentescos-editar" class="combo-consulta">

            <input type="text" autocomplete="off"  placeholder="Buscar parentesco" data-limit="" class="upper">
            <select class="editar-valores scroll" data-valor="id_parentesco" id="editar-parentesco"></select>

          </section>

        </div>

        <div>
          
          <label>
            <button id="editar-nueva-estado_civil" class="boton-ver contenedor-resaltar" title="Cargar nuevo estado civil" style="left: 70px; top: 4px">
              +  
            </button>
            Estado civil
          </label>

          <section data-grupo="cc-estado_civil-editar" class="combo-consulta">

            <input type="text" autocomplete="off"  placeholder="Buscar estado civil" data-limit="" class="upper">
            <select class="editar-valores scroll" data-valor="id_estado_civil" id="editar-civil"></select>

          </section>

        </div>

        <div>
          
          <label>
            <button id="editar-nueva-religiones" class="boton-ver contenedor-resaltar" title="Cargar nueva religión" style="left: 50px; top: 4px">
              +  
            </button>
            Religión
          </label>

          <section data-grupo="cc-religiones-editar" class="combo-consulta">

            <input type="text" autocomplete="off"  placeholder="Buscar religión" data-limit="" class="upper">
            <select class="editar-valores scroll" data-valor="id_religion" id="editar-religion"></select>

          </section>

        </div>

      </div>

      <div class="columnas">

        <div>
          <label>Sexo</label>
          <select data-valor="sexo" class="editar-valores upper">
            <option value="">SIN DEFINIR</option>
            <option value="F">FEMENINO</option>
            <option value="M">MASCULINO</option>
          </select>
        </div>
        
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

        <div>
          <label>Otros</label>
          
          <section id="cc-otros-editar" class="contenedor-consulta editar-valores borde-estilizado" data-valor="otros">

            <span class="tooltip-general">Presionar [ENTER] para agregar</span>
            <section>
              <input type="text" autocomplete="off"  data-estilo="cc-input" placeholder="Cargar..." class="upper">
              <select data-limit="" data-estilo="cc-select" data-hide></select>
            </section>
            <div data-estilo="cc-div" style="max-height: 70px; min-height: 70px; border: none"></div>

          </section>

        </div>

      </div>

      <section id="crud-editar-botones" data-crud='botones' style="column-gap: 10px; padding: 10px 10px 0px 10px;">
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
  <div id="crud-insertar-pop" class="popup-oculto" data-scroll style="
    height: fit-content; 
    justify-content: flex-start; 
    min-width: 800px; 
    max-height: 90%; 
    width: 50%;
  ">
    <button id="crud-insertar-cerrar" data-crud='cerrar'>X</button>
    <section id="crud-insertar-titulo" data-crud='titulo' style="justify-content: flex-start;">
      INSERTAR HISTORIA

      <button id="crud-insertar-limpiar" title="Limpiar Contenido" data-crud="limpiar">
        <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="trash-alt" class="svg-inline--fa fa-trash-alt fa-w-14 iconos-b" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M32 464a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128H32zm272-256a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zm-96 0a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zm-96 0a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zM432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16z"></path></svg>
      </button>
    </section> 

    <div class="filas" style="justify-content: flex-start; height: fit-content;">

      <div class="columnas">

        <div style="width: 100px">
          <label class="requerido">Cédula/rif</label>
          <input id="insertar-enfocar" type="text" autocomplete="off"  placeholder="-" class="insertar-valores lleno upper" maxlength="14">
        </div>

        <div style="width: 20rem;">
          <label>N° HIJO</label>
          <select class="insertar-valores upper">
            <option value="0">---</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
            <option value="13">13</option>
            <option value="14">14</option>
            <option value="15">15</option>
          </select>
        </div>

        <div>
          <label class="requerido">Nombres</label>
          <input id="insertar-nombre" type="text" autocomplete="off"  placeholder="-" class="insertar-valores lleno upper">
        </div>

        <div>
          <label class="requerido">Apellidos</label>
          <input type="text" autocomplete="off"  placeholder="-" class="insertar-valores lleno upper">
        </div>

      </div>

      <div class="columnas">
        
        <div style="width: 40rem;">
          <label class="requerido">Fecha de nacimiento</label>
          <input type="date" id="insertar-fecha" class="insertar-valores lleno upper">
        </div>

        <div style="width: 100px">
          <label>Edad</label>
          <input type="text" autocomplete="off"  id="insertar-edad" class="lleno upper visual" disabled>
        </div>

        <div>
          <label>Lugar de nacimiento</label>
          <input type="text" autocomplete="off"  class="insertar-valores upper" maxlength="200">
        </div>

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
          <label>Dirección</label>
          <input type="text" autocomplete="off"  placeholder="-" class="insertar-valores upper">
        </div>

      </div>

      <div class="columnas" style="align-items: baseline;">

        <div>

          <label class="requerido">
            <button id="insertar-nueva-ocupaciones" class="boton-ver contenedor-resaltar" title="Cargar nueva ocupación" style="left: 75px; top: 4px">
              +  
            </button>
            Ocupación
          </label>

          <section data-grupo="cc-ocupaciones-insertar" class="combo-consulta">

            <input type="text" autocomplete="off" placeholder="Buscar ocupación" data-limit="" class="upper insertar-cajones">
            <select class="insertar-valores lleno scroll" id="insertar-ocupacion"></select>

          </section>

        </div>

        <div>

          <label>
            <button id="insertar-nueva-proveniencias" class="boton-ver contenedor-resaltar" title="Cargar nueva proveniencia" style="left: 80px; top: 4px">
              +  
            </button>
            Proveniencia
          </label>

          <section data-grupo="cc-proveniencias-insertar" class="combo-consulta">

            <input type="text" autocomplete="off"  placeholder="Buscar ocupación" data-limit="" class="upper insertar-cajones">
            <select class="insertar-valores scroll" id="insertar-proveniencia"></select>

          </section>

        </div>

        <div>

          <label>
            <button id="insertar-nueva-medicos" class="boton-ver contenedor-resaltar" title="Cargar nuevo médico" style="left: 95px; top: 4px">
              +  
            </button>
            Médico referido
          </label>

          <section data-grupo="cc-medicos-insertar" class="combo-consulta">

            <input type="text" autocomplete="off"  placeholder="Buscar ocupación" data-limit="" class="upper insertar-cajones">
            <select class="insertar-valores scroll" id="insertar-medico"></select>

          </section>

        </div>

      </div>

      <div class="columnas" style="align-items: baseline;">
        
        <div>

          <label>
            <button id="insertar-nueva-parentescos" class="boton-ver contenedor-resaltar" title="Cargar nuevo parentesco" style="left: 70px; top: 4px">
              +  
            </button>
            Parentesco
          </label>

          <section data-grupo="cc-parentescos-insertar" class="combo-consulta">

            <input type="text" autocomplete="off"  placeholder="Buscar ocupación" data-limit="" class="upper insertar-cajones">
            <select class="insertar-valores scroll" id="insertar-parentesco"></select>

          </section>

        </div>

        <div>


          <label>
            <button id="insertar-nueva-estado_civil" class="boton-ver contenedor-resaltar" title="Cargar nuevo estado civil" style="left: 70px; top: 4px">
              +  
            </button>
            Estado civil
          </label>
          
          <section data-grupo="cc-estado_civil-insertar" class="combo-consulta">

            <input type="text" autocomplete="off"  placeholder="Buscar ocupación" data-limit="" class="upper insertar-cajones">
            <select class="insertar-valores scroll" id="insertar-civil"></select>

          </section>

        </div>

        <div>


          <label>
            <button id="insertar-nueva-religiones" class="boton-ver contenedor-resaltar" title="Cargar nuevo religion" style="left: 50px; top: 4px">
              +  
            </button>
            Religión
          </label>
          
          <section data-grupo="cc-religiones-insertar" class="combo-consulta">

            <input type="text" autocomplete="off"  placeholder="Buscar ocupación" data-limit="" class="upper insertar-cajones">
            <select class="insertar-valores scroll" id="insertar-religion"></select>

          </section>

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

        <div>
          <label>Otros</label>
          
          <section id="cc-otros-insertar" class="contenedor-consulta insertar-valores borde-estilizado">

            <span class="tooltip-general">Presionar [ENTER] para agregar</span>
            <section>
              <input type="text" autocomplete="off"  data-estilo="cc-input" placeholder="Cargar..." class="upper">
              <select data-limit="" data-estilo="cc-select" data-hide></select>
            </section>
            <div data-estilo="cc-div" style="max-height: 70px; min-height: 70px; border: none"></div>

          </section>

        </div>

      </div>

    </div>

    <section id="crud-insertar-botones" data-crud='botones-nc' style="column-gap: 10px; padding: 10px 10px 0px 10px;;">
      <button class="botones-formularios insertar boton-confirmar">CONFIRMAR Y CERRAR</button>
      <button class="botones-formularios permanecer boton-confirmar">CONFIRMAR Y PERMANECER</button>
      <button class="botones-formularios cancelar boton-cancelar">CANCELAR</button> 
    </section>

  </div>
</div>

<!------------------------------------------------------------------- -->
<!---------------------------- RECIPES ------------------------------ -->
<!------------------------------------------------------------------- -->
<div id="crud-recipe-popup" class="popup-oculto" data-crud='popup'>
  <div id="crud-recipe-pop" class="popup-oculto" data-scroll style="padding: 2.5% !important">
    <button id="crud-recipe-cerrar" data-crud='cerrar'>X</button>

    <section style="height: 100%; width: 100%; display: flex; align-items: center;">
      <div style="display: grid; height: 100%; grid-template-rows: 30px 100px 1fr 1fr; width: 100%;">
        <div style="font-weight: 100 !important; width: 100%; font-size: 1.5em !important; text-align: right; border-bottom: 2px dashed #ccc; height: fit-content;">
          RÉCIPES E INDICACIONES
        </div>
        <div class="filas">
          <div class="columnas">
            <div>
              <label>N° Historia:</label>
              <input type="number" data-recipe="id_historia" readonly="true" class="crud-recipe">
            </div>
            <div>
              <label for="recipe-nombres" class="requerido">Nombres y Apellidos o Razón Social</label>
              <input type="text" id="recipe-nombres"  maxlength="40" minlength="1" maxlength="40" data-recipe="apel_nomb" class="crud-recipe lleno upper recipe-limpiar">
            </div>
            <div>
              <label for="imprimir-cedula" class="requerido">N° Cédula/Rif o pasaporte</label>
              <input type="text" id="recipe-cedula" maxlength="20" minlength="1" data-recipe="nume_cedu" class="crud-recipe lleno upper recipe-limpiar">
            </div>
          </div>
        </div>

        <div style="display: flex; flex-direction: column; height: 100%;">
          <section style="font-size: 20px; text-align: left;" class="titulo">
            MEDICAMENTOS
          </section> 

          <div style="display: grid; height: 100%; width: 100%; grid-template-rows: 35px 1fr auto;">
            <div style="display: flex; position:relative; width: 40%;">
              <input type="text"  id="salto" placeholder="test" style="display: block; position: absolute; top:-4200px" tabindex="1">
              <input type="text" name="medicamentos-busqueda" id="medicamentos-busqueda" data-estilo="busqueda" placeholder="Busqueda" tabindex="2" style="height: 100%">
              <button id="modo-buscar-medicamentos" data-estilo="modo-buscar" style="right: 32px; left: unset; top: 1px; width: 25px; height: 33px;">
                <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="sort" class="svg-inline--fa fa-sort fa-w-10 iconos-b" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path fill="currentColor" d="M41 288h238c21.4 0 32.1 25.9 17 41L177 448c-9.4 9.4-24.6 9.4-33.9 0L24 329c-15.1-15.1-4.4-41 17-41zm255-105L177 64c-9.4-9.4-24.6-9.4-33.9 0L24 183c-15.1 15.1-4.4 41 17 41h238c21.4 0 32.1-25.9 17-41z"></path></svg>
              </button>
              <button id="modo-buscar-medicamentos-preciso" data-estilo="modo-buscar" style="right: 58px; left: unset; top: 1px; width: 25px; height: 33px;">
                <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="sort" class="svg-inline--fa fa-sort fa-w-10 iconos-b" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path fill="currentColor" d="M41 288h238c21.4 0 32.1 25.9 17 41L177 448c-9.4 9.4-24.6 9.4-33.9 0L24 329c-15.1-15.1-4.4-41 17-41zm255-105L177 64c-9.4-9.4-24.6-9.4-33.9 0L24 183c-15.1 15.1-4.4 41 17 41h238c21.4 0 32.1-25.9 17-41z"></path></svg>
              </button>
              <button id="modo-insertar-medicamentos" title="Insertar medicamento">
                +
              </button>
            </div>

            <div class="tabla-ppal scroll" data-estilo="tabla-recipes">
              <table id="tabla-medicamentos" class="table table-bordered table-striped">
                  <thead>
                  </thead>
                  <tbody>
                  </tbody>
              </table>
            </div>

            <div style="display: flex; height: 100%; padding-top: 5px;">
              <button id="izquierda-medicamentos" class="botones"><?php echo "<"?></button>
              <div id="numeracion-medicamentos" data-estilo="numeracion-contenedor">
                  <input class="numeracion-medicamentos" type="number" maxlength="3" minlength="0">
                  <span class="numeracion-medicamentos" data-estilo="numeracion"></span> 
              </div>
              <button id="derecha-medicamentos" class="botones"><?php echo ">"?></button>          
            </div>
            <div id="crud-recipe-botones" data-crud='botones' style="padding: 0px; top: 20px; column-gap: 10px; display: flex; height: fit-content; min-height: fit-content; position: relative;">
              <button class="botones-formularios imprimir" id="imprimir-recipe" style="height: fit-content; font-weight: bold; padding: 10px;">GUARDAR E IMPRIMIR</button>
              <button class="botones-formularios cerrar" style="height: fit-content; min-width: 160px; font-weight: bold; padding: 10px;">CANCELAR</button> 
            </div>
        </div>
      </div>
    </section>
  </div>
</div>

<!------------------------------------------------------------------- -->
<!------------------------- TRATAMIENTOS ------------------------- -->
<!------------------------------------------------------------------- -->
<div id="crud-tratamientos-popup" class="popup-oculto" data-crud='popup' style="background: transparent;">
  <div id="crud-tratamientos-pop" class="popup-oculto">
    <button id="crud-tratamientos-cerrar" data-crud='cerrar'>X</button>

    <section id="crud-tratamientos-titulo" class="subtitulo">
      Seleccionar y editar un tratamiento existente o llenar manualmente el campo [PROCESAR TRATAMIENTO]
    </section> 

    <div style="display: grid; height: 100%; width: 100%; grid-template-rows: 35px 1fr auto;">
      <div style="display: flex;">
        <input type="text" name="tratamientos-busqueda" id="tratamientos-busqueda" data-estilo="busqueda" placeholder="Busqueda">
      </div>

      <div class="tabla-ppal scroll" data-estilo="tabla-tratamientos">
        <table id="tabla-tratamientos" class="table table-bordered table-striped">
            <thead>
            </thead>
            <tbody>
            </tbody>
        </table>
      </div>

      <!-- <div style="display: flex; height: 100%;">
        <button id="tratamientos-izquierda" class="botones"><?php echo "<"?></button>
        <div id="tratamientos-numeracion" data-estilo="numeracion-contenedor">
            <span class="tratamientos-numeracion" data-estilo="numeracion"></span>
            <span class="tratamientos-numeracion" data-estilo="numeracion"></span> 
        </div>
        <button id="tratamientos-derecha" class="botones"><?php echo ">"?></button>          
      </div> -->
    </div>
    <div class="filas columnas">
      <label style="width: 100%; text-align: left; padding-top: 5px;">PROCESAR TRATAMIENTO</label>
      <textarea spellcheck=true lang="es" cols="30" rows="3" id="tratamientos-seleccionado" class="scroll upper"></textarea>
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
      Seleccionar y editar una presentación existente o llenar manualmente el campo [PROCESAR PRESENTACIÓN]
    </section> 

    <div style="display: grid; height: 100%; width: 100%; grid-template-rows: 35px 1fr auto;">
      <div style="display: flex;">
        <input type="text" name="presentaciones-busqueda" id="presentaciones-busqueda" data-estilo="busqueda" placeholder="Busqueda">
      </div>

      <div class="tabla-ppal scroll" data-estilo="tabla-presentaciones">
        <table id="tabla-presentaciones" class="table table-bordered table-striped">
            <thead>
            </thead>
            <tbody>
            </tbody>
        </table>
      </div>

      <!-- <div style="display: flex; height: 100%;">
        <button id="presentaciones-izquierda" class="botones"><?php echo "<"?></button>
        <div id="presentaciones-numeracion" data-estilo="numeracion-contenedor">
            <span class="presentaciones-numeracion" data-estilo="numeracion"></span>
            <span class="presentaciones-numeracion" data-estilo="numeracion"></span> 
        </div>
        <button id="presentaciones-derecha" class="botones"><?php echo ">"?></button>          
      </div> -->
      <div class="filas columnas">
        <label style="width: 100%; text-align: left; padding-top: 5px;">PROCESAR PRESENTACIÓN</label>
        <textarea spellcheck=true cols="30" lang="es" rows="3" id="presentacion-seleccionada" class="scroll upper"></textarea>
      </div>
    </div>
  </div>
</div>

<!------------------------------------------------------------------- -->
<!------------------------- PREVIA REPORTES ------------------------- -->
<!------------------------------------------------------------------- -->
<div id="crud-previas-popup" class="popup-oculto" data-crud='popup'>
  <div id="crud-previas-pop" class="popup-oculto">

    <button id="crud-previas-cerrar" data-crud='cerrar'>X</button>

    <section id="crud-previas-titulo" data-crud='titulo' style="margin-bottom: 5px;">
      VISTA PREVIA
    </section>

    <section id="crud-previas-reporte" class="reportes-previa-iframe">
      <iframe src=""></iframe>
    </section>

    <section id="crud-previas-botones" data-crud='botones' style="padding-top: 10px; column-gap: 5px;">
      <button class="botones-formularios imprimir">IMPRIMIR</button>
      <button class="botones-formularios cerrar">CANCELAR</button>
    </section>

  </div>
</div>

<!------------------------------------------------------------------- -->
<!--------------------------- INSERSIONES --------------------------- -->
<!------------------------------------------------------------------- -->

<?php 
  $insersiones = array(
    0 => ["ocupaciones", "ocupación"],
    1 => ["proveniencias", "proveniencia"],
    2 => ["parentescos", "parentesco"],
    3 => ["estado_civil", "estado civil"],
    4 => ["religiones", "religión"]
  );

  foreach ($insersiones as $r) {

?>

<div id="crud-insertar-<?php echo $r[0]?>-popup" class="popup-oculto" data-crud='popup'>
  <div id="crud-insertar-<?php echo $r[0]?>-pop" class="popup-oculto" style="width:50%;">

    <button id="crud-insertar-<?php echo $r[0]?>-cerrar" data-crud='cerrar'>X</button>

    <section id="crud-insertar-<?php echo $r[0]?>-titulo" data-crud='titulo'>
      Insertar <?php echo $r[1]?>
    </section> 

    <section class="filas">
      <div class="columnas">
        <div>
          <label class="requerido">Nombre de la <?php echo $r[1]?></label>  
          <input type="text" autocomplete="off"  minlength="1" id="nombre-<?php echo $r[0]?>" maxlength="100" class="nuevas-<?php echo $r[0]?> lleno upper" placeholder="...">
        </div>
      </div> 

    </section>

    <section id="crud-insertar-<?php echo $r[0]?>-botones" data-crud='botones' style="column-gap: 10px; padding: 10px 10px 0px 10px;;">
      <button class="botones-formularios insertar">CONFIRMAR</button>
      <button class="botones-formularios cerrar">CANCELAR</button> 
    </section>

  </div> 
</div>

<?php 
  }
?>

<div id="crud-insertar-medicos-popup" class="popup-oculto" data-crud='popup'>
  <div id="crud-insertar-medicos-pop" class="popup-oculto" style="width:50%;">

    <button id="crud-insertar-medicos-cerrar" data-crud='cerrar'>X</button>

    <section id="crud-insertar-medicos-titulo" data-crud='titulo'>
      Insertar médico referido
    </section> 

    <section class="filas">

      <div class="columnas">
        <div>
          <label class="requerido">Nombre del médico</label>  
          <input type="text" autocomplete="off"  minlength="1" id="nombre-medicos" maxlength="100" class="nuevas-medicos lleno upper" placeholder="...">
        </div>
      </div>

      <div class="columnas">
        <div>
          <label>Dirección del médico</label>  
          <input type="text" autocomplete="off"  minlength="1" id="direccion-medicos" maxlength="100" class="nuevas-medicos upper" placeholder="...">
        </div>
      </div> 

    </section>

    <section id="crud-insertar-medicos-botones" data-crud='botones' style="column-gap: 10px; padding: 10px 10px 0px 10px;;">
      <button class="botones-formularios insertar">CONFIRMAR</button>
      <button class="botones-formularios cerrar">CANCELAR</button> 
    </section>

  </div> 
</div>