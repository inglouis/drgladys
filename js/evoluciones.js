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

const infPop = new PopUp('crud-informacion-popup', 'popup', 'subefecto', true, 'informacion', '', 27)

infPop.evtBotones()

window.addEventListener('keyup', (e) => {

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
window.contenedores = new ContenedoresEspeciales('evoluciones-filtros')

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
window.cargar = new paginaCargada('#tabla-evoluciones thead .ASC', 'existencia')
window.cargar.revision()
/////////////////////////////////////////////////////
window.rellenar = new Rellenar()
/////////////////////////////////////////////////////
var sesiones = await window.sesiones(true)
/////////////////////////////////////////////////////
//----------------------------------------------------------------------------------------------------
//										evoluciones                                           
//----------------------------------------------------------------------------------------------------
class Evoluciones extends Acciones {

	constructor(crud) {
		super(crud)
		this.fila
		this.uso   = 'evoluciones'
		this.funcion = 'buscar_evoluciones'
		this.cargar  = 'cargar_evoluciones' 
		//-------------------------------
		this.alternar = [true, 'white', 'whitesmoke']
		this.especificos = ['id_evolucion', 'cedula','id_historia','nombres','apellidos']
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
window.evoluciones = new Evoluciones(new Tabla(
	[
		['N°. Evolución', true, 0],
		['Cédula', true, 1],
		['N° historia', true, 2],
		['Nombres', true, 3],
		['Apellidos', true, 4],
		['Status', true, 14],

		['Acciones', false, 0]
	],
	'tabla-evoluciones', 'busqueda', Number(sesiones.modo_filas), 'izquierda', 'derecha', 'numeracion', true
))
/////////////////////////////////////////////////////
///
evoluciones['crud'].generarColumnas(['gSpan', null, null], [false],['HTML'], '', 0)
evoluciones['crud'].generarColumnas(['gSpan', null, null], [false],['HTML'], '', 1)
evoluciones['crud'].generarColumnas(['gSpan', null, null], [false],['HTML'], '', 2)
evoluciones['crud'].generarColumnas(['gSpan', null, null], [false],['HTML'], '', 3)
evoluciones['crud'].generarColumnas(['gSpan', null, null], [false],['HTML'], '', 4)
evoluciones['crud'].generarColumnas(['gSpan', null, null], [false],['HTML'], '', 14)

evoluciones['crud'].cuerpo.push([evoluciones['crud'].columna = evoluciones['crud'].cuerpo.length, [
		evoluciones['crud'].gBt('informacion btn btn-informacion', `<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="info" class="svg-inline--fa fa-info fa-w-6 iconos-b" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 192 512"><path fill="currentColor" d="M20 424.229h20V279.771H20c-11.046 0-20-8.954-20-20V212c0-11.046 8.954-20 20-20h112c11.046 0 20 8.954 20 20v212.229h20c11.046 0 20 8.954 20 20V492c0 11.046-8.954 20-20 20H20c-11.046 0-20-8.954-20-20v-47.771c0-11.046 8.954-20 20-20zM96 0C56.235 0 24 32.235 24 72s32.235 72 72 72 72-32.235 72-72S135.764 0 96 0z"></path></svg>`)
	], [0], ['VALUE'], 'crud-botones', false
])
/////////////////////////////////////////////////////
evoluciones['crud']['limitante'] = 1

/////////////////////////////////////////////////////
///
evoluciones['crud'].botonModoBusqueda("#modo-buscar", 1, [
	['id_evolucion'],
	['id_evolucion', 'cedula','id_historia','nombres','apellidos']
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
evoluciones['crud']['customBodyEvents'] = {
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
	var resultado = await tools.fullAsyncQuery('evoluciones', 'cargar_evoluciones', [])
	evoluciones.cargarTabla(JSON.parse(resultado), undefined, undefined)
})()

//----------------------------------------------------------------------------------------------------
//										E V E N T O S                                                
//----------------------------------------------------------------------------------------------------
contenedores.eventos().checkboxes('status')

//contenedoresConsultar.eventos().combo('cc-ocupacion-consultar', ['combos', 'combo_evoluciones', ['', '']], false, {})
//contenedoresEditar.eventos().combo('cc-ocupacion-editar', ['combos', 'combo_evoluciones', ['', '']], false, {})

//----------------------------------------------------------------------------------------------------
//						Evento del botón de aplicar filtros en la tabla principal
//----------------------------------------------------------------------------------------------------
qs('#procesar').addEventListener('click', async e => {

	evoluciones.spinner('#tabla-evoluciones tbody')
	
	var peticion = contenedores.procesar(tools.fullQuery, 'evoluciones','filtrar')

	peticion.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
        	qs('#tabla-evoluciones tbody').innerHTML = ''
        	evoluciones.cargarTabla(JSON.parse(this.responseText))
        }
    };
})

/* -------------------------------------------------------------------------------------------------*/	
//          evento que envía la ID del crud al boton de eliminar del contenedor
/* -------------------------------------------------------------------------------------------------*/
qs('#tabla-evoluciones').addEventListener('click', e => {
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

qs('#evoluciones-insertar').addEventListener('click', e => {
	tools.limpiar('.nuevos', '', {})
	window.idSeleccionada = 0
	insPop.pop()
})
