/////////////////////////////////////////////////////
//IMPORTA EL CÓDIGO DEL CRUD
/////////////////////////////////////////////////////
import {Tabla} from '../js/crud.js';

/////////////////////////////////////////////////////
//IMPORTA usoS DE MAIN.JS PARA REUTILIZAR FUNCIONES
/////////////////////////////////////////////////////
import {PopUp, Acciones, Herramientas, ContenedoresEspeciales, paginaCargada, Rellenar, Notificaciones, Atajos} from '../js/main.js';

/////////////////////////////////////////////////////
//GENERA LOS COMPORTAMIENTOS BÁSICOS DE LOS POPUPS
/////////////////////////////////////////////////////
const ediPop = new PopUp('crud-editar-popup', 'popup', 'subefecto', true, 'editar', '', 27)
const insPop = new PopUp('crud-insertar-popup', 'popup', 'subefecto', true, 'insertar', '', 27)

ediPop.evtBotones()
insPop.evtBotones()

window.addEventListener('keyup', (e) => {

	ediPop.evtEscape(e)
	insPop.evtEscape(e)

})

/////////////////////////////////////////////////////
//HERRAMIENTAS GENERALES
/////////////////////////////////////////////////////
const tools = new Herramientas()
var idTratamiento = undefined
/////////////////////////////////////////////////////
//NOTIFICACIONES GENERALES
/////////////////////////////////////////////////////
var notificaciones = new Notificaciones()

//notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'ALERTA')
//notificaciones.mensajeSimple('Procesando...', false, 'V')

/////////////////////////////////////////////////////
//GENERA LOS COMPORTAMIENTOS BÁSICOS DE LOS POPUPS
/////////////////////////////////////////////////////
window.contenedores = new ContenedoresEspeciales('tratamientos-status')

window.contenedoresInsertar  = new ContenedoresEspeciales('crud-insertar-popup')
/////////////////////////////////////////////////////
window.qs = document.querySelector.bind(document)
window.qsa = document.querySelectorAll.bind(document)
/////////////////////////////////////////////////////
window.procesar = true;
window.idSeleccionada = 0
/////////////////////////////////////////////////////
//REVISA QUE LA PÁGINA YA CARGO POR COMPLETO PARA QUITAR LA ANIMACIÓN DE CARGA
/////////////////////////////////////////////////////
window.cargar = new paginaCargada('#tabla-tratamientos thead .ASC', 'existencia')
window.cargar.revision()
/////////////////////////////////////////////////////
window.rellenar = new Rellenar()
/////////////////////////////////////////////////////
window.atajos = new Atajos('Shift', [
	{"elemento": '#contenido-contenedor',"ejecuta": 'n', "tarea": () => {insPop.pop()}},
	{"elemento": '#salto',"ejecuta": 'tab', "clean": true, "tarea": "focus"}
])
window.atajos.eventos()
/////////////////////////////////////////////////////
var sesiones = await window.sesiones()
/////////////////////////////////////////////////////

window.URLquery = new URLSearchParams(window. location. search)
var regresarEnConfirmacion = false
/////////////////////////////////////////////////////
if(URLquery.has('id_medicamento')) {

    regresarEnConfirmacion = true
	
	var existencia1 = setInterval(async () => {

		if(tratamientos) {
            clearInterval(existencia1);
            //window.medicamentos.crud.reposicionar(Number(URLquery.get('posicion')), true)
            var sublista = tools.filtrar(tratamientos.crud.lista,Number(URLquery.get('id_medicamento')), ['id_medicamento'], true, 'preciso')[0]

            var boton = document.createElement('button')
            	boton.setAttribute('class', 'editar')
            	boton.value = sublista.id_tratamiento
            	boton.sublista = sublista

            tratamientos.crud.customBodyEvents['editar'](boton, true)

			qs('#regresar-medicamentos').href = `../paginas/medicamentos.php?posicion=${URLquery.get('posicion')}&busqueda=${URLquery.get('busqueda')}`

		}
       
    }, 1000);
}

//----------------------------------------------------------------------------------------------------
//										TRATAMIENTOS                                           
//----------------------------------------------------------------------------------------------------
class Tratamientos extends Acciones {

	constructor(crud) {
		super(crud)
		this.fila
		this.uso   = 'tratamientos'
		this.funcion = 'buscar_tratamientos'
		this.cargar  = 'cargar_tratamientos' 
		//-------------------------------
		this.alternar = [true, 'white', 'whitesmoke']
		this.especificos = ['id_tratamiento', 'nombre', 'id_medicamento', 'tratamientos']
		this.limitante = 0
		this.boton = ''
		//-------------------------------
		this.div = document.createElement('div')
	}

	async confirmarActualizacion(popUp) {

		notificaciones.mensajeSimple('Petición realiza con éxito', false, 'V')
		popUp.pop()
		var resultado = JSON.parse(await tools.fullAsyncQuery(this.uso, this.cargar, []))
		this.cargarTabla(resultado, true)

	}

}
/////////////////////////////////////////////////////
/////////////////////////////////////////////////////
var tratamientos = new Tratamientos(new Tabla(
	[
		['N° de medicamento', true, 0],
		['Descripción del medicamento', true, 4],
		['Status', true, 3],
		['Acciones', false, 0]
	],
	'tabla-tratamientos', 'busqueda', Number(sesiones.modo_filas), 'izquierda', 'derecha', 'numeracion', true
))

window.tratamientos = tratamientos
/////////////////////////////////////////////////////
///
tratamientos['crud'].generarColumnas(['gSpan', null, null], [false],['HTML'], '', 0)
tratamientos['crud'].generarColumnas(['gSpan', null, null], [false],['HTML'], '', 4)
tratamientos['crud'].generarColumnas(['gSpan', null, null], [false],['HTML'], '', 3)

tratamientos['crud'].cuerpo.push([tratamientos['crud'].columna = tratamientos['crud'].cuerpo.length, [
		tratamientos['crud'].gBt('editar btn btn-editar', `<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="pencil-alt" class="iconos-b" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M497.9 142.1l-46.1 46.1c-4.7 4.7-12.3 4.7-17 0l-111-111c-4.7-4.7-4.7-12.3 0-17l46.1-46.1c18.7-18.7 49.1-18.7 67.9 0l60.1 60.1c18.8 18.7 18.8 49.1 0 67.9zM284.2 99.8L21.6 362.4.4 483.9c-2.9 16.4 11.4 30.6 27.8 27.8l121.5-21.3 262.6-262.6c4.7-4.7 4.7-12.3 0-17l-111-111c-4.8-4.7-12.4-4.7-17.1 0zM124.1 339.9c-5.5-5.5-5.5-14.3 0-19.8l154-154c5.5-5.5 14.3-5.5 19.8 0s5.5 14.3 0 19.8l-154 154c-5.5 5.5-14.3 5.5-19.8 0zM88 424h48v36.3l-64.5 11.3-31.1-31.1L51.7 376H88v48z"></path></svg>`)
	], [false], ['VALUE'], 'crud-botones', 1
])
/////////////////////////////////////////////////////
tratamientos['crud']['limitante'] = 1

/////////////////////////////////////////////////////
///
tratamientos['crud'].botonModoBusqueda("#modo-buscar", 1, [
	['id_tratamiento'],
	['id_tratamiento', 'nombre', 'id_medicamento', 'tratamientos']
], {"mensaje": (e) => {
	if(e.target.opcion === 0) {
		tools['mensaje'] = 'Modo filtro PRECISO seleccionado'
		tools.mensajes(true)
	} else if (e.target.opcion === 1) {
		tools['mensaje'] = 'Modo filtro PARECIDO seleccionado'
		tools.mensajes(true)
	}
}})

/////////////////////////////////////////////////////
/////////////////////////////////////////////////////
tratamientos['crud']['customBodyEvents'] = {
	/* -------------------------------------------------------------------------------------------------*/
	/*           evento que envia los datos del boton de editar del crud al contenedor de edicion       */
	/* -------------------------------------------------------------------------------------------------*/
	"editar": async (e, generado) => {

		var button = (tools.esDOM(e)) ? e : e.target;

		if(button.classList.contains('editar')) {

			var trata = []

			if(generado) {

				var sublista = button.sublista

			} else {

				var sublista = tools.pariente(button, 'TR').sublista

			}

			qs('#tratamientos-busqueda-editar').value = ''

			tools.limpiar('.editar-valores', '', {})
			rellenar.contenedores(sublista, '.editar-valores', {elemento: button, id: 'value'})

			JSON.parse(sublista.tratamientos).forEach((el, i) => {
				trata.push({"id_tratamiento": i, "tratamiento": el})
				idTratamiento = i
			}) 

			tratamientosEditar.cargarTabla(trata)
			ediPop.pop()

		}
	}
};

(async () => {
	var resultado = await tools.fullAsyncQuery('tratamientos', 'cargar_tratamientos', [])
	tratamientos.cargarTabla(JSON.parse(resultado), undefined, undefined)
})()

//----------------------------------------------------------------------------------------------------
//										*TRATAMIENTOS-EDITAR                                     
//----------------------------------------------------------------------------------------------------
class TratamientosEditar extends Acciones {
		constructor (crud) {
			super(crud)
			this.fila
			this.clase = ''
			this.funcion = ''
			//-------------------------------
			this.alternar =  ''
			this.especificos = []
			this.limitante = 0
			this.boton = ''
			//-------------------------------
		}

		async confirmarActualizacion(popUp) {

			notificaciones.mensajeSimple('Petición realiza con éxito', false, 'V')
			popUp.pop()
			var resultado = JSON.parse(await tools.fullAsyncQuery(this.uso, this.cargar, []))
			this.cargarTabla(resultado, true)

		}
	}

/////////////////////////////////////////////////////
/////////////////////////////////////////////////////
window.tratamientosEditar = new TratamientosEditar(new Tabla(
	[
		['Descripción', true, 1],
		['Eliminar', false, 0]
	],
	'tabla-tratamientos-editar','tratamientos-busqueda-editar', -1,'null','null','null',true
))
/////////////////////////////////////////////////////
/////////////////////////////////////////////////////

tratamientosEditar['crud'].cuerpo.push([
	tratamientosEditar['crud'].columna = tratamientosEditar['crud'].cuerpo.length, [tratamientosEditar['crud'].gInp('input upper', 'text', 'Descripción del tratamiento', 
	[
		{"atributo": "titulo", "valor":""}, 
		{"atributo": "placeholder", "valor":"Contenido..."}
	], 
	'width: 100%')
], [false], ['VALUE'], '', 1])
/////////////////////////////////////////////////////
tratamientosEditar['crud'].cuerpo.push([tratamientosEditar['crud'].columna = tratamientosEditar['crud'].cuerpo.length, [
	tratamientosEditar['crud'].gBt(['eliminar btn btn-eliminar', 'Eliminar fila', 'width: 25px; height: 25px;'], `X`)
], [false], ['VALUE'], '', 0])

/////////////////////////////////////////////////////
/////////////////////////////////////////////////////
tratamientosEditar['crud']['inputHandler'] = [{"input":0}, true]
tratamientosEditar['crud']['desplazamientoActivo'] = [true, false, true, false]
tratamientosEditar['crud']['ofv'] = true
tratamientosEditar['crud']['ofvh'] = '300px';

tratamientosEditar['crud'].inputEliminar('eliminar', '', [
	function fn(params) {
		tools['mensaje'] = 'Procesando...'
        tools.mensajes(['#ffc107', '#fff'])
    },
    function fn(params) {
		tools['mensaje'] = 'Fila eliminada'
        tools.mensajes(true)
    }
]) 

/////////////////////////////////////////////////////
/////////////////////////////////////////////////////
qs('#nuevo-tratamiento-editar').addEventListener('click', e => {
	idTratamiento = idTratamiento + 1
	tratamientosEditar.crud.lista.push({"id_tratamiento": idTratamiento, "tratamiento": ''})
	tratamientosEditar.cargarTabla(tratamientosEditar.crud.lista)
})

//----------------------------------------------------------------------------------------------------
//										*TRATAMIENTOS-EDITAR                                     
//----------------------------------------------------------------------------------------------------
class TratamientosInsertar extends Acciones {
		constructor (crud) {
			super(crud)
			this.fila
			this.clase = ''
			this.funcion = ''
			//-------------------------------
			this.alternar =  ''
			this.especificos = []
			this.limitante = 0
			this.boton = ''
			//-------------------------------
		}

		async confirmarActualizacion(popUp) {

			notificaciones.mensajeSimple('Petición realiza con éxito', false, 'V')
			popUp.pop()
			var resultado = JSON.parse(await tools.fullAsyncQuery(this.uso, this.cargar, []))
			this.cargarTabla(resultado, true)

		}
	}

/////////////////////////////////////////////////////
/////////////////////////////////////////////////////
window.tratamientosInsertar = new TratamientosInsertar(new Tabla(
	[
		['Descripción', true, 1],
		['Eliminar', false, 0]
	],
	'tabla-tratamientos-insertar','tratamientos-busqueda-insertar', -1,'null','null','null',true
))
/////////////////////////////////////////////////////
/////////////////////////////////////////////////////

tratamientosInsertar['crud'].cuerpo.push([
	tratamientosInsertar['crud'].columna = tratamientosInsertar['crud'].cuerpo.length, [tratamientosInsertar['crud'].gInp('input upper', 'text', 'Descripción del tratamiento', 
	[
		{"atributo": "titulo", "valor":""}, 
		{"atributo": "placeholder", "valor":"Contenido..."}
	], 
	'width: 100%')
], [false], ['VALUE'], '', 1])
/////////////////////////////////////////////////////
tratamientosInsertar['crud'].cuerpo.push([tratamientosInsertar['crud'].columna = tratamientosInsertar['crud'].cuerpo.length, [
	tratamientosInsertar['crud'].gBt(['eliminar btn btn-eliminar', 'Eliminar fila', 'width: 25px; height: 25px;'], `X`)
], [false], ['VALUE'], '', 0])

/////////////////////////////////////////////////////
/////////////////////////////////////////////////////
tratamientosInsertar['crud']['inputHandler'] = [{"input":0}, true]
tratamientosInsertar['crud']['desplazamientoActivo'] = [true, false, true, false]
tratamientosInsertar['crud']['ofv'] = true
tratamientosInsertar['crud']['ofvh'] = '300px';

tratamientosInsertar['crud'].inputEliminar('eliminar', '', [
	function fn(params) {
		tools['mensaje'] = 'Procesando...'
        tools.mensajes(['#ffc107', '#fff'])
    },
    function fn(params) {
		tools['mensaje'] = 'Fila eliminada'
        tools.mensajes(true)
    }
]) 

/////////////////////////////////////////////////////
/////////////////////////////////////////////////////
qs('#nuevo-tratamiento-insertar').addEventListener('click', e => {
	idTratamiento = idTratamiento + 1
	tratamientosInsertar.crud.lista.push({"id_tratamiento": idTratamiento, "tratamiento": ''})
	tratamientosInsertar.cargarTabla(tratamientosInsertar.crud.lista)
})

//----------------------------------------------------------------------------------------------------
//										E V E N T O S                                                
//----------------------------------------------------------------------------------------------------
contenedores.eventos().checkboxes('status')

contenedoresInsertar.eventos().combo('cc-medicamentos-insertar', ['combos', 'combo_medicamentos', ['', '']], false, [])
//----------------------------------------------------------------------------------------------------
//						Evento del botón de aplicar filtros en la tabla principal
//----------------------------------------------------------------------------------------------------
qs('#procesar').addEventListener('click', async e => {

	tratamientos.spinner('#tabla-tratamientos tbody')
	
	var peticion = contenedores.procesar(tools.fullQuery, 'tratamientos','filtrar')

	peticion.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
        	qs('#tabla-tratamientos tbody').innerHTML = ''
        	tratamientos.cargarTabla(JSON.parse(this.responseText))
        }
    };
})

/* -------------------------------------------------------------------------------------------------*/
/*   		Evento que envia los datos al metodo de javascript que hace la peticion*                */
/* -------------------------------------------------------------------------------------------------*/
qs('#crud-editar-botones').addEventListener('click', async e => {
	
	if(e.target.classList.contains('editar')) {
		
		if(window.procesar) {
			
			window.procesar = false

			notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'PROCESANDO')

			var datos = tools.procesar(e.target, 'editar', 'editar-valores', tools);
			
			if(datos !== '') {

				var lista = tools.copiaLista(tratamientosEditar.crud.lista)
					lista = lista.filter((e) => { if(e['tratamiento'].trim() !== '') { return e }})
				
				if(lista.length < 1) {lista = []}

				datos.splice(datos.length - 1, 0, lista)

				var resultado = await tools.fullAsyncQuery('tratamientos', 'actualizar_tratamientos', datos)

				if(resultado.trim() === 'exito') {

					tratamientos.confirmarActualizacion(ediPop)

					if (regresarEnConfirmacion) {
        				window.location.href = `../paginas/medicamentos.php?posicion=${URLquery.get('posicion')}&busqueda=${URLquery.get('busqueda')}`
        			}
				
				} else {

					notificaciones.mensajeSimple('Error al procesar la petición', resultado, 'F')

				}

			}

		} else {
			
			notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'PROCESANDO')

		}
	}
})

/* -------------------------------------------------------------------------------------------------*/
/*                    evento que envia los datos a php para la insersión                            */
/* -------------------------------------------------------------------------------------------------*/
qs('#crud-insertar-botones').addEventListener('click', async e => {

	if (e.target.classList.contains('insertar')) {

		if(window.procesar) {

			window.procesar = false

			notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'PROCESANDO')

			var datos = tools.procesar(e.target, 'insertar', 'insertar-valores', tools);
			
			if(datos !== '') {

				var lista = tools.copiaLista(tratamientosInsertar.crud.lista)
					lista = lista.filter((e) => { if(e['tratamiento'].trim() !== '') { return e }})
				
				if(lista.length < 1) {lista = []}

				datos.splice(datos.length, 0, lista)

				var resultado = await tools.fullAsyncQuery('tratamientos', 'crear_tratamientos', datos)

				if(resultado.trim() === 'exito') {

					tratamientos.confirmarActualizacion(insPop)
				
				} else if (resultado.trim() === 'repetido') {

					notificaciones.mensajeSimple('Medicamento repetido', resultado, 'F')

				} else {

					notificaciones.mensajeSimple('Error al procesar la petición', resultado, 'F')

				}

			}

		} else {
			notificaciones.mensajeSimple('Campos vacíos', resultado, 'F')
		}
	}
})

/* -------------------------------------------------------------------------------------------------*/	
//          evento que envía la ID del crud al boton de eliminar del contenedor
/* -------------------------------------------------------------------------------------------------*/
qs('#tabla-tratamientos').addEventListener('click', e => {
	if (e.target.tagName === 'BUTTON') {
		if (e.target.classList.contains('eliminar')) {
			idEliminar = Number(e.target.value)
			eliPop.pop()
		}
	}
})

/* -------------------------------------------------------------------------------------------------*/	
//                      eventos exclusivos de el archivo js
/* -------------------------------------------------------------------------------------------------*/
//////////////////////////////////////////////////////////////////////////////////////////////////////

qs('#tratamientos-insertar').addEventListener('click', e => {
	window.idSeleccionada = 0
	idTratamiento = 0
	tools.limpiar('.nuevos', '', {"asegurar": () => {return '#crud-insertar-pop'}})
	insPop.pop()
})
