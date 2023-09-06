/////////////////////////////////////////////////////
//IMPORTA EL CÓDIGO DEL CRUD
/////////////////////////////////////////////////////
import {Tabla} from '../js/crud.js';

/////////////////////////////////////////////////////
//IMPORTA usoS DE MAIN.JS PARA REUTILIZAR FUNCIONES
/////////////////////////////////////////////////////
import {PopUp, Acciones, Herramientas, ContenedoresEspeciales, paginaCargada, Rellenar, Notificaciones} from '../js/main.js';

/////////////////////////////////////////////////////
//GENERA LOS COMPORTAMIENTOS BÁSICOS DE LOS POPUPS
/////////////////////////////////////////////////////
const eliPop = new PopUp('crud-eliminar-popup', 'popup', 'subefecto', true, 'eliminar', '', 27)
const ediPop = new PopUp('crud-editar-popup', 'popup', 'subefecto', true, 'editar', '', 27)
const insPop = new PopUp('crud-insertar-popup', 'popup', 'subefecto', true, 'insertar', '', 27)

ediPop.evtBotones()
insPop.evtBotones()
eliPop.evtBotones()

window.addEventListener('keyup', (e) => {

	ediPop.evtEscape(e)
	insPop.evtEscape(e)
	eliPop.evtEscape(e)

})

/////////////////////////////////////////////////////
//HERRAMIENTAS GENERALES
/////////////////////////////////////////////////////
const tools = new Herramientas()

/////////////////////////////////////////////////////
//NOTIFICACIONES GENERALES
/////////////////////////////////////////////////////
var notificaciones = new Notificaciones()

//notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'ALERTA')
//notificaciones.mensajeSimple('Procesando...', false, 'V')

/////////////////////////////////////////////////////
//GENERA LOS COMPORTAMIENTOS BÁSICOS DE LOS POPUPS
/////////////////////////////////////////////////////
window.contenedores = new ContenedoresEspeciales('genericos-status')

window.contenedoresConsultar = new ContenedoresEspeciales('crud-informacion-popup') 
window.contenedoresEditar = new ContenedoresEspeciales('crud-editar-popup') 

/////////////////////////////////////////////////////
window.qs = document.querySelector.bind(document)
window.qsa = document.querySelectorAll.bind(document)
/////////////////////////////////////////////////////
window.procesar = true;
window.idSeleccionada = 0
/////////////////////////////////////////////////////
//REVISA QUE LA PÁGINA YA CARGO POR COMPLETO PARA QUITAR LA ANIMACIÓN DE CARGA
/////////////////////////////////////////////////////
window.cargar = new paginaCargada('#tabla-genericos thead .ASC', 'existencia')
window.cargar.revision()
/////////////////////////////////////////////////////
window.rellenar = new Rellenar()
/////////////////////////////////////////////////////
var sesiones = await window.sesiones()
/////////////////////////////////////////////////////
//----------------------------------------------------------------------------------------------------
//										genericos                                           
//----------------------------------------------------------------------------------------------------
class Genericos extends Acciones {

	constructor(crud) {
		super(crud)
		this.fila
		this.uso   = 'genericos'
		this.funcion = 'buscar_genericos'
		this.cargar  = 'cargar_genericos' 
		//-------------------------------
		this.alternar = [true, 'white', 'whitesmoke']
		this.especificos = ['id_generico', 'nombre']
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
///
window.genericos = new Genericos(new Tabla(
	[
		['Código', true, 0],
		['Nombre del medicamento genérico', true, 1],
		['Status', true, 2],
		['Acciones', false, 0]
	],
	'tabla-genericos', 'busqueda', Number(sesiones.modo_filas), 'izquierda', 'derecha', 'numeracion', true
))
/////////////////////////////////////////////////////
///
genericos['crud'].generarColumnas(['gSpan', null, null], [false],['HTML'], '', 0)
genericos['crud'].generarColumnas(['gSpan', null, null], [false],['HTML'], '', 1)
genericos['crud'].generarColumnas(['gSpan', null, null], [false],['HTML'], '', 2)

genericos['crud'].cuerpo.push([genericos['crud'].columna = genericos['crud'].cuerpo.length, [
	genericos['crud'].gBt(['editar btn btn-editar', '', 'padding: 3px;'], `<svg class="iconos-b" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M497.9 142.1l-46.1 46.1c-4.7 4.7-12.3 4.7-17 0l-111-111c-4.7-4.7-4.7-12.3 0-17l46.1-46.1c18.7-18.7 49.1-18.7 67.9 0l60.1 60.1c18.8 18.7 18.8 49.1 0 67.9zM284.2 99.8L21.6 362.4.4 483.9c-2.9 16.4 11.4 30.6 27.8 27.8l121.5-21.3 262.6-262.6c4.7-4.7 4.7-12.3 0-17l-111-111c-4.8-4.7-12.4-4.7-17.1 0zM124.1 339.9c-5.5-5.5-5.5-14.3 0-19.8l154-154c5.5-5.5 14.3-5.5 19.8 0s5.5 14.3 0 19.8l-154 154c-5.5 5.5-14.3 5.5-19.8 0zM88 424h48v36.3l-64.5 11.3-31.1-31.1L51.7 376H88v48z"></path></svg>`),
], [false], ['VALUE'], '', 0])

/////////////////////////////////////////////////////
genericos['crud']['limitante'] = 1

/////////////////////////////////////////////////////
///
genericos['crud'].botonModoBusqueda("#modo-buscar", 1, [
	['id_generico'],
	['id_generico', 'nombre']
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
///
genericos['crud']['customBodyEvents'] = {
	/* -------------------------------------------------------------------------------------------------*/
	/*           evento que envia los datos del boton de editar del crud al contenedor de edicion       */
	/* -------------------------------------------------------------------------------------------------*/
	"editar": async (e, generado) => {

		var button = (tools.esDOM(e)) ? e : e.target;

		if(button.classList.contains('editar')) {

			if(generado) {

				var sublista = button.sublista, trata = []

			} else {

				var sublista = tools.pariente(button, 'TR').sublista, trata = []

			}

			tools.limpiar('.editar-valores', '', {})
			rellenar.contenedores(sublista, '.editar-valores', {elemento: button, id: 'value'})

			ediPop.pop()
		}
	}
};

(async () => {
	var resultado = await tools.fullAsyncQuery('genericos', 'cargar_genericos', [])
	genericos.cargarTabla(JSON.parse(resultado), undefined, undefined)
})()

//----------------------------------------------------------------------------------------------------
//										E V E N T O S                                                
//----------------------------------------------------------------------------------------------------
contenedores.eventos().checkboxes('status')

//contenedoresConsultar.eventos().combo('cc-ocupacion-consultar', ['combos', 'combo_ocupacion', ['', '']], false, {})
//contenedoresEditar.eventos().combo('cc-ocupacion-editar', ['combos', 'combo_ocupacion', ['', '']], false, {})

//----------------------------------------------------------------------------------------------------
//						Evento del botón de aplicar filtros en la tabla principal
//----------------------------------------------------------------------------------------------------
qs('#procesar').addEventListener('click', async e => {

	genericos.spinner('#tabla-genericos tbody')
	
	var peticion = contenedores.procesar(tools.fullQuery, 'genericos','filtrar')

	peticion.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
        	qs('#tabla-genericos tbody').innerHTML = ''
        	genericos.cargarTabla(JSON.parse(this.responseText))
        }
    };
})

/* -------------------------------------------------------------------------------------------------*/
/*   		Evento que envia los datos al metodo de javascript que hace la peticion*                */
/* -------------------------------------------------------------------------------------------------*/
qs('#crud-editar-botones').addEventListener('click', async e => {

	if(e.target.classList.contains('editar')) {

		if(window.procesar) {

			notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'PROCESANDO')

			window.procesar = false

			var datos = tools.procesar(e.target, 'editar', 'editar-valores', tools)

			if (datos !== '') {

				var resultado = await tools.fullAsyncQuery('genericos', 'actualizar_genericos', datos)

				if (resultado.trim() === 'exito') {

					genericos.confirmarActualizacion(ediPop)
				
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

		notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'PROCESANDO')

		var datos = tools.procesar(e.target, 'insertar', 'insertar-valores', tools)

		if (datos !== '') {

			var resultado = await tools.fullAsyncQuery('genericos', 'crear_genericos', datos)

			if (resultado.trim() === 'exito') {

				genericos.confirmarActualizacion(insPop)
			
			} else {

				notificaciones.mensajeSimple('Error al procesar la petición', resultado, 'F')

			}

		} else {

			notificaciones.mensajeSimple('Campos vacíos', resultado, 'F')

		}
	}
})

/* -------------------------------------------------------------------------------------------------*/	
//          evento que envía la ID del crud al boton de eliminar del contenedor
/* -------------------------------------------------------------------------------------------------*/
qs('#tabla-genericos').addEventListener('click', e => {
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

qs('#genericos-insertar').addEventListener('click', e => {
	tools.limpiar('.nuevos', '', {})
	window.idSeleccionada = 0
	insPop.pop()
})
