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
const infPop = new PopUp('crud-informacion-popup', 'popup', 'subefecto', true, 'informacion', '', 27)

ediPop.evtBotones()
insPop.evtBotones()
infPop.evtBotones()

window.addEventListener('keyup', (e) => {

	ediPop.evtEscape(e)
	insPop.evtEscape(e)
	infPop.evtEscape(e)

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
window.contenedores = new ContenedoresEspeciales('medicos-filtros')

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
window.cargar = new paginaCargada('#tabla-medicos thead .ASC', 'existencia')
window.cargar.revision()
/////////////////////////////////////////////////////
window.rellenar = new Rellenar()
/////////////////////////////////////////////////////
var sesiones = await window.sesiones(false)
/////////////////////////////////////////////////////
//----------------------------------------------------------------------------------------------------
//										medicos                                           
//----------------------------------------------------------------------------------------------------
class Medicos extends Acciones {

	constructor(crud) {
		super(crud)
		this.fila
		this.uso   = 'medicos'
		this.funcion = 'buscar_medicos'
		this.cargar  = 'cargar_medicos' 
		//-------------------------------
		this.alternar = [true, 'white', 'whitesmoke']
		this.especificos = ['id_medico', 'nombres_apellidos','direccion']
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
window.medicos = new Medicos(new Tabla(
	[
		['N°. medico', true, 0],
		['Nombres y Apellidos del Médico', true, 1],
		['Dirección del Médico', true, 2],
		['Status', true, 3],
		['Acciones', false, 0]
	],
	'tabla-medicos', 'busqueda', Number(sesiones.modo_filas), 'izquierda', 'derecha', 'numeracion', true
))
/////////////////////////////////////////////////////
///
medicos['crud'].generarColumnas(['gSpan', null, null], [false],['HTML'], '', 0)
medicos['crud'].generarColumnas(['gSpan', null, null], [false],['HTML'], '', 1)
medicos['crud'].generarColumnas(['gSpan', null, null], [false],['HTML'], '', 2)
medicos['crud'].generarColumnas(['gSpan', null, null], [false],['HTML'], '', 3)


medicos['crud'].cuerpo.push([medicos['crud'].columna = medicos['crud'].cuerpo.length, [
		medicos['crud'].gBt('informacion btn btn-informacion', `<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="info" class="svg-inline--fa fa-info fa-w-6 iconos-b" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 192 512"><path fill="currentColor" d="M20 424.229h20V279.771H20c-11.046 0-20-8.954-20-20V212c0-11.046 8.954-20 20-20h112c11.046 0 20 8.954 20 20v212.229h20c11.046 0 20 8.954 20 20V492c0 11.046-8.954 20-20 20H20c-11.046 0-20-8.954-20-20v-47.771c0-11.046 8.954-20 20-20zM96 0C56.235 0 24 32.235 24 72s32.235 72 72 72 72-32.235 72-72S135.764 0 96 0z"></path></svg>`),
		medicos['crud'].gBt('editar btn btn-editar', `<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="pencil-alt" class="svg-inline--fa fa-pencil-alt fa-w-16 iconos-b" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M497.9 142.1l-46.1 46.1c-4.7 4.7-12.3 4.7-17 0l-111-111c-4.7-4.7-4.7-12.3 0-17l46.1-46.1c18.7-18.7 49.1-18.7 67.9 0l60.1 60.1c18.8 18.7 18.8 49.1 0 67.9zM284.2 99.8L21.6 362.4.4 483.9c-2.9 16.4 11.4 30.6 27.8 27.8l121.5-21.3 262.6-262.6c4.7-4.7 4.7-12.3 0-17l-111-111c-4.8-4.7-12.4-4.7-17.1 0zM124.1 339.9c-5.5-5.5-5.5-14.3 0-19.8l154-154c5.5-5.5 14.3-5.5 19.8 0s5.5 14.3 0 19.8l-154 154c-5.5 5.5-14.3 5.5-19.8 0zM88 424h48v36.3l-64.5 11.3-31.1-31.1L51.7 376H88v48z"></path></svg>`)
	], [0,0,0,0], ['VALUE', 'VALUE','VALUE','VALUE'], 'crud-botones', false
])
/////////////////////////////////////////////////////
medicos['crud']['limitante'] = 1

/////////////////////////////////////////////////////
///
medicos['crud'].botonModoBusqueda("#modo-buscar", 1, [
	['id_medico'],
	['id_medico', 'nombres_apellidos','direccion']
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
medicos['crud']['customBodyEvents'] = {
	"informacion": async (e) => {
		if(e.target.classList.contains('informacion')) {

			var sublista = tools.pariente(e.target, 'TR').sublista

			tools.limpiar('.informacion-valores', '', {})
			rellenar.contenedores(sublista, '.informacion-valores', {elemento: e.target, id: 'value'})
			infPop.pop()

		}
	},
	/* -------------------------------------------------------------------------------------------------*/
	/*           evento que envia los datos del boton de editar del crud al contenedor de edicion       */
	/* -------------------------------------------------------------------------------------------------*/
	"editar": async (e) => {
		if(e.target.classList.contains('editar')) {

			var sublista = tools.pariente(e.target, 'TR').sublista

			tools.limpiar('.editar-valores', '', {})
			rellenar.contenedores(sublista, '.editar-valores', {elemento: e.target, id: 'value'}, {
				"contenedorConsulta": e => {

				}
			})
			ediPop.pop()

		}
	}
};

(async () => {
	var resultado = await tools.fullAsyncQuery('medicos', 'cargar_medicos', [])
	medicos.cargarTabla(JSON.parse(resultado), undefined, undefined)
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

	medicos.spinner('#tabla-medicos tbody')
	
	var peticion = contenedores.procesar(tools.fullQuery, 'medicos','filtrar')

	peticion.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
        	qs('#tabla-medicos tbody').innerHTML = ''
        	medicos.cargarTabla(JSON.parse(this.responseText))
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

			var datos = tools.procesar(e.target, 'editar', 'editar-valores', tools);

			if(datos !== '') {

				var resultado = await tools.fullAsyncQuery('medicos', 'actualizar_medicos', datos)

				if (resultado.trim() === 'exito') {

					medicos.confirmarActualizacion(ediPop)
				
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

		var datos = tools.procesar(e.target, 'insertar', 'nuevos', tools)

		if (datos !== false) {

			var resultado = await tools.fullAsyncQuery('medicos', 'crear_medicos', datos)

			if (resultado.trim() === 'exito') {

				medicos.confirmarActualizacion(insPop)
			
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
qs('#tabla-medicos').addEventListener('click', e => {
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

qs('#medicos-insertar').addEventListener('click', e => {
	tools.limpiar('.nuevos', '', {})
	window.idSeleccionada = 0
	insPop.pop()
})
