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
var idPresentacion = undefined
/////////////////////////////////////////////////////
//NOTIFICACIONES GENERALES
/////////////////////////////////////////////////////
var notificaciones = new Notificaciones()

//notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'ALERTA')
//notificaciones.mensajeSimple('Procesando...', false, 'V')

/////////////////////////////////////////////////////
//GENERA LOS COMPORTAMIENTOS BÁSICOS DE LOS POPUPS
/////////////////////////////////////////////////////
window.contenedores = new ContenedoresEspeciales('presentaciones-status')

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
window.cargar = new paginaCargada('#tabla-presentaciones thead .ASC', 'existencia')
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

		if(presentaciones) {
            clearInterval(existencia1);
            //window.medicamentos.crud.reposicionar(Number(URLquery.get('posicion')), true)
            var sublista = tools.filtrar(presentaciones.crud.lista, Number(URLquery.get('id_medicamento')), ['id_medicamento'], true, 'preciso')[0]

            var boton = document.createElement('button')
            	boton.setAttribute('class', 'editar')
            	boton.value = sublista.id_presentacion
            	boton.sublista = sublista

            presentaciones.crud.customBodyEvents['editar'](boton, true)

			qs('#regresar-medicamentos').href = `../paginas/medicamentos.php?posicion=${URLquery.get('posicion')}&busqueda=${URLquery.get('busqueda')}`

		}
       
    }, 1000);
}

//----------------------------------------------------------------------------------------------------
//										PRESENTACIONES                                           
//----------------------------------------------------------------------------------------------------
class Presentaciones extends Acciones {

	constructor(crud) {
		super(crud)
		this.fila
		this.uso   = 'presentaciones'
		this.funcion = 'buscar_presentaciones'
		this.cargar  = 'cargar_presentaciones' 
		//-------------------------------
		this.alternar = [true, 'white', 'whitesmoke']
		this.especificos = ['id_presentacion', 'nombre', 'id_medicamento', 'presentaciones']
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
var presentaciones = new Presentaciones(new Tabla(
	[
		['N° de medicamento', true, 0],
		['Descripción del medicamento', true, 4],
		['Status', true, 3],
		['Acciones', false, 0]
	],
	'tabla-presentaciones', 'busqueda', Number(sesiones.modo_filas), 'izquierda', 'derecha', 'numeracion', true
))

window.presentaciones = presentaciones
/////////////////////////////////////////////////////
///
presentaciones['crud'].generarColumnas(['gSpan', null, null], [false],['HTML'], '', 0)
presentaciones['crud'].generarColumnas(['gSpan', null, null], [false],['HTML'], '', 4)
presentaciones['crud'].generarColumnas(['gSpan', null, null], [false],['HTML'], '', 3)

presentaciones['crud'].cuerpo.push([presentaciones['crud'].columna = presentaciones['crud'].cuerpo.length, [
		presentaciones['crud'].gBt('editar btn btn-editar', `<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="pencil-alt" class="iconos-b" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M497.9 142.1l-46.1 46.1c-4.7 4.7-12.3 4.7-17 0l-111-111c-4.7-4.7-4.7-12.3 0-17l46.1-46.1c18.7-18.7 49.1-18.7 67.9 0l60.1 60.1c18.8 18.7 18.8 49.1 0 67.9zM284.2 99.8L21.6 362.4.4 483.9c-2.9 16.4 11.4 30.6 27.8 27.8l121.5-21.3 262.6-262.6c4.7-4.7 4.7-12.3 0-17l-111-111c-4.8-4.7-12.4-4.7-17.1 0zM124.1 339.9c-5.5-5.5-5.5-14.3 0-19.8l154-154c5.5-5.5 14.3-5.5 19.8 0s5.5 14.3 0 19.8l-154 154c-5.5 5.5-14.3 5.5-19.8 0zM88 424h48v36.3l-64.5 11.3-31.1-31.1L51.7 376H88v48z"></path></svg>`)
	], [false], ['VALUE'], 'crud-botones', 1
])
/////////////////////////////////////////////////////
presentaciones['crud']['limitante'] = 1

/////////////////////////////////////////////////////
///
presentaciones['crud'].botonModoBusqueda("#modo-buscar", 1, [
	['id_presentacion'],
	['id_presentacion', 'nombre', 'id_medicamento', 'presentaciones']
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
presentaciones['crud']['customBodyEvents'] = {
	/* -------------------------------------------------------------------------------------------------*/
	/*           evento que envia los datos del boton de editar del crud al contenedor de edicion       */
	/* -------------------------------------------------------------------------------------------------*/
	"editar": async (e, generado) => {

		var button = (tools.esDOM(e)) ? e : e.target;

		if(button.classList.contains('editar')) {

			var presen = []

			if(generado) {

				var sublista = button.sublista

			} else {

				var sublista = tools.pariente(button, 'TR').sublista

			}

			qs('#presentaciones-busqueda-editar').value = ''

			tools.limpiar('.editar-valores', '', {})
			rellenar.contenedores(sublista, '.editar-valores', {elemento: button, id: 'value'})

			JSON.parse(sublista.presentaciones).forEach((el, i) => {
				presen.push({"id_presentacion": i, "presentacion": el})
				idPresentacion = i
			}) 

			presentacionesEditar.cargarTabla(presen)
			ediPop.pop()

		}
	}
};

(async () => {
	var resultado = await tools.fullAsyncQuery('presentaciones', 'cargar_presentaciones', [])
	presentaciones.cargarTabla(JSON.parse(resultado), undefined, undefined)
})()

//----------------------------------------------------------------------------------------------------
//									PRESENTACIONES EDITAR                                     
//----------------------------------------------------------------------------------------------------
class PresentacionesEditar extends Acciones {
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
window.presentacionesEditar = new PresentacionesEditar(new Tabla(
	[
		['Descripción', true, 1],
		['Eliminar', false, 0]
	],
	'tabla-presentaciones-editar','presentaciones-busqueda-editar', -1,'null','null','null',true
))
/////////////////////////////////////////////////////
/////////////////////////////////////////////////////

presentacionesEditar['crud'].cuerpo.push([
	presentacionesEditar['crud'].columna = presentacionesEditar['crud'].cuerpo.length, [presentacionesEditar['crud'].gInp('input upper', 'text', 'Descripción del presentacion', 
	[
		{"atributo": "titulo", "valor":""}, 
		{"atributo": "placeholder", "valor":"Contenido..."}
	], 
	'width: 100%')
], [false], ['VALUE'], '', 1])
/////////////////////////////////////////////////////
presentacionesEditar['crud'].cuerpo.push([presentacionesEditar['crud'].columna = presentacionesEditar['crud'].cuerpo.length, [
	presentacionesEditar['crud'].gBt(['eliminar btn btn-eliminar', 'Eliminar fila', 'width: 25px; height: 25px;'], `X`)
], [false], ['VALUE'], '', 0])

/////////////////////////////////////////////////////
/////////////////////////////////////////////////////
presentacionesEditar['crud']['inputHandler'] = [{"input":0}, true]
presentacionesEditar['crud']['desplazamientoActivo'] = [true, false, true, false]
presentacionesEditar['crud']['ofv'] = true
presentacionesEditar['crud']['ofvh'] = '300px';

presentacionesEditar['crud'].inputEliminar('eliminar', '', [
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
qs('#nuevo-presentacion-editar').addEventListener('click', e => {
	idPresentacion = idPresentacion + 1
	presentacionesEditar.crud.lista.push({"id_presentacion": idPresentacion, "presentacion": ''})
	presentacionesEditar.cargarTabla(presentacionesEditar.crud.lista)
})

//----------------------------------------------------------------------------------------------------
//										PRESENTACIONES INSERTAR                                     
//----------------------------------------------------------------------------------------------------
class PresentacionesInsertar extends Acciones {
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
window.presentacionesInsertar = new PresentacionesInsertar(new Tabla(
	[
		['Descripción', true, 1],
		['Eliminar', false, 0]
	],
	'tabla-presentaciones-insertar','presentaciones-busqueda-insertar', -1,'null','null','null',true
))
/////////////////////////////////////////////////////
/////////////////////////////////////////////////////

presentacionesInsertar['crud'].cuerpo.push([
	presentacionesInsertar['crud'].columna = presentacionesInsertar['crud'].cuerpo.length, [presentacionesInsertar['crud'].gInp('input upper', 'text', 'Descripción del presentacion', 
	[
		{"atributo": "titulo", "valor":""}, 
		{"atributo": "placeholder", "valor":"Contenido..."}
	], 
	'width: 100%')
], [false], ['VALUE'], '', 1])
/////////////////////////////////////////////////////
presentacionesInsertar['crud'].cuerpo.push([presentacionesInsertar['crud'].columna = presentacionesInsertar['crud'].cuerpo.length, [
	presentacionesInsertar['crud'].gBt(['eliminar btn btn-eliminar', 'Eliminar fila', 'width: 25px; height: 25px;'], `X`)
], [false], ['VALUE'], '', 0])

/////////////////////////////////////////////////////
/////////////////////////////////////////////////////
presentacionesInsertar['crud']['inputHandler'] = [{"input":0}, true]
presentacionesInsertar['crud']['desplazamientoActivo'] = [true, false, true, false]
presentacionesInsertar['crud']['ofv'] = true
presentacionesInsertar['crud']['ofvh'] = '300px';

presentacionesInsertar['crud'].inputEliminar('eliminar', '', [
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
qs('#nuevo-presentacion-insertar').addEventListener('click', e => {
	idPresentacion = idPresentacion + 1
	presentacionesInsertar.crud.lista.push({"id_presentacion": idPresentacion, "presentacion": ''})
	presentacionesInsertar.cargarTabla(presentacionesInsertar.crud.lista)
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

	presentaciones.spinner('#tabla-presentaciones tbody')
	
	var peticion = contenedores.procesar(tools.fullQuery, 'presentaciones','filtrar')

	peticion.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
        	qs('#tabla-presentaciones tbody').innerHTML = ''
        	presentaciones.cargarTabla(JSON.parse(this.responseText))
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

				var lista = tools.copiaLista(presentacionesEditar.crud.lista)
					lista = lista.filter((e) => { if(e['presentacion'].trim() !== '') { return e }})
				
				if(lista.length < 1) {lista = []}

				datos.splice(datos.length - 1, 0, lista)

				var resultado = await tools.fullAsyncQuery('presentaciones', 'actualizar_presentaciones', datos)

				if(resultado.trim() === 'exito') {

					presentaciones.confirmarActualizacion(ediPop)

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

				var lista = tools.copiaLista(presentacionesInsertar.crud.lista)
					lista = lista.filter((e) => { if(e['presentacion'].trim() !== '') { return e }})
				
				if(lista.length < 1) {lista = []}

				datos.splice(datos.length, 0, lista)

				var resultado = await tools.fullAsyncQuery('presentaciones', 'crear_presentaciones', datos)

				if(resultado.trim() === 'exito') {

					presentaciones.confirmarActualizacion(insPop)
				
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
qs('#tabla-presentaciones').addEventListener('click', e => {
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

qs('#presentaciones-insertar').addEventListener('click', e => {
	window.idSeleccionada = 0
	idPresentacion = 0
	tools.limpiar('.nuevos', '', {"asegurar": () => {return '#crud-insertar-pop'}})
	insPop.pop()
})
