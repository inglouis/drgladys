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
const eliPop = new PopUp('crud-eliminar-popup', 'popup', 'subefecto', true, 'eliminar', '', 27)

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
window.contenedores = new ContenedoresEspeciales('medicamentos-status')

window.contenedoresInsertar  = new ContenedoresEspeciales('crud-insertar-popup')
window.contenedoresEditar    = new ContenedoresEspeciales('crud-editar-popup')
/////////////////////////////////////////////////////
window.qs = document.querySelector.bind(document)
window.qsa = document.querySelectorAll.bind(document)
/////////////////////////////////////////////////////
window.procesar = true;
window.idSeleccionada = 0
/////////////////////////////////////////////////////
//REVISA QUE LA PÁGINA YA CARGO POR COMPLETO PARA QUITAR LA ANIMACIÓN DE CARGA
/////////////////////////////////////////////////////
window.cargar = new paginaCargada('#tabla-medicamentos thead .ASC', 'existencia')
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
var sesiones = await window.sesiones(false)
/////////////////////////////////////////////////////

/////////////////////////////////////////////////////
const URLquery = new URLSearchParams(window. location. search)
/////////////////////////////////////////////////////
if(URLquery.has('posicion')) {

	// window.historia = JSON.parse(await tools.fullAsyncQuery('historias', 'buscarHistorias', [Number(window.id_historia)]))[0]
	// rellenar.contenedores(window.historia, '.presupuestos-cargar')

	// qs('#presupuesto-historia').value = window.id_historia
	// qs('#presupuesto-historia').classList.remove('input-resaltar')

	var existencia1 = setInterval(async () => {

		if(window.medicamentos) {
            clearInterval(existencia1);
           
            if (URLquery.get('busqueda').trim() === '') {

            	window.medicamentos.crud.reposicionar(Number(URLquery.get('posicion')), true)

            } else {

            	qs('#busqueda').value = URLquery.get('busqueda').trim()
            	window.medicamentos.crud.botonForzar(true)

            }


		}
       
    }, 1000);
}

//----------------------------------------------------------------------------------------------------
//										MEDICAMENTOS                                           
//----------------------------------------------------------------------------------------------------
class Medicamentos extends Acciones {

	constructor(crud) {
		super(crud)
		this.fila
		this.uso   = 'medicamentos'
		this.funcion = 'buscar_medicamentos'
		this.cargar  = 'cargar_medicamentos' 
		//-------------------------------
		this.alternar = [true, 'white', 'whitesmoke']
		this.especificos = ['id_medicamento', 'nombre']
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
var medicamentos = new Medicamentos(new Tabla(
	[
		['N° del medicamento', true, 0],
		['Descripción del medicamento', true, 1],
		['Status', true, 3],
		['Acciones', false, 0]
	],
	'tabla-medicamentos', 'busqueda', Number(sesiones.modo_filas), 'izquierda', 'derecha', 'numeracion', true
))

window.medicamentos = medicamentos
/////////////////////////////////////////////////////
///
medicamentos['crud'].generarColumnas(['gSpan', null, null], [false],['HTML'], '', 0)
medicamentos['crud'].generarColumnas(['gSpan', null, null], [false],['HTML'], '', 1)
medicamentos['crud'].generarColumnas(['gSpan', null, null], [false],['HTML'], '', 3)

var estiloBotones = 'margin-right: 2px;height: 29px;display: inline-flex;justify-content: center;align-items: center;color: #fff;';

medicamentos['crud'].cuerpo.push([medicamentos['crud'].columna = medicamentos['crud'].cuerpo.length, [
		medicamentos['crud'].gBt(['editar btn btn-editar', 'Editar medicamento'], `<svg aria-hidden="true" class="iconos-b" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M497.9 142.1l-46.1 46.1c-4.7 4.7-12.3 4.7-17 0l-111-111c-4.7-4.7-4.7-12.3 0-17l46.1-46.1c18.7-18.7 49.1-18.7 67.9 0l60.1 60.1c18.8 18.7 18.8 49.1 0 67.9zM284.2 99.8L21.6 362.4.4 483.9c-2.9 16.4 11.4 30.6 27.8 27.8l121.5-21.3 262.6-262.6c4.7-4.7 4.7-12.3 0-17l-111-111c-4.8-4.7-12.4-4.7-17.1 0zM124.1 339.9c-5.5-5.5-5.5-14.3 0-19.8l154-154c5.5-5.5 14.3-5.5 19.8 0s5.5 14.3 0 19.8l-154 154c-5.5 5.5-14.3 5.5-19.8 0zM88 424h48v36.3l-64.5 11.3-31.1-31.1L51.7 376H88v48z"></path></svg>`),
		medicamentos['crud'].gBt(['presentacion btn btn-general', 'Editar presentaciones', estiloBotones], `<svg class="iconos-b" style="width: 15px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="currentColor" d="M112 32C50.12 32 0 82.12 0 143.1v223.1c0 61.88 50.12 111.1 112 111.1s112-50.12 112-111.1V143.1C224 82.12 173.9 32 112 32zM160 256H64V144c0-26.5 21.5-48 48-48s48 21.5 48 48V256zM299.8 226.2c-3.5-3.5-9.5-3-12.38 .875c-45.25 62.5-40.38 150.1 15.88 206.4c56.38 56.25 144 61.25 206.5 15.88c4-2.875 4.249-8.75 .75-12.25L299.8 226.2zM529.5 207.2c-56.25-56.25-143.9-61.13-206.4-15.87c-4 2.875-4.375 8.875-.875 12.38l210.9 210.7c3.5 3.5 9.375 3.125 12.25-.75C590.8 351.1 585.9 263.6 529.5 207.2z"/></svg>`),
		medicamentos['crud'].gBt(['tratamiento btn btn-general', 'Editar tratamientos', estiloBotones], `<svg class="iconos-b" style="width: 15px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path fill="currentColor" d="M256 0v128h128L256 0zM224 128L224 0H48C21.49 0 0 21.49 0 48v416C0 490.5 21.49 512 48 512h288c26.51 0 48-21.49 48-48V160h-127.1C238.3 160 224 145.7 224 128zM288 301.7v36.57C288 345.9 281.9 352 274.3 352L224 351.1v50.29C224 409.9 217.9 416 210.3 416H173.7C166.1 416 160 409.9 160 402.3V351.1L109.7 352C102.1 352 96 345.9 96 338.3V301.7C96 294.1 102.1 288 109.7 288H160V237.7C160 230.1 166.1 224 173.7 224h36.57C217.9 224 224 230.1 224 237.7V288h50.29C281.9 288 288 294.1 288 301.7z"/></svg>`)
	], [0,0,0], ['VALUE', 'VALUE', 'VALUE'], 'crud-botones', false
])
/////////////////////////////////////////////////////
medicamentos['crud']['limitante'] = 1

/////////////////////////////////////////////////////
///
medicamentos['crud'].botonModoBusqueda("#modo-buscar", 1, [
	['id_medicamento'],
	['id_medicamento', 'nombre']
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
medicamentos['crud']['customBodyEvents'] = {
	/* -------------------------------------------------------------------------------------------------*/
	/*           evento que envia los datos del boton de editar del crud al contenedor de edicion       */
	/* -------------------------------------------------------------------------------------------------*/
	"editar": async (e) => {

		var button = (tools.esDOM(e)) ? e : e.target;

		if(button.classList.contains('editar')) {

			var sublista = tools.pariente(button, 'TR').sublista

			tools.limpiar('.editar-valores', '', {})

			rellenar.contenedores(sublista, '.editar-valores', {elemento: button, id: 'value'}, {
				"contenedorConsulta": async function fn(lista, grupo) {

					var resultado = await tools.fullAsyncQuery('medicamentos', 'estandar_genericos', lista)
					contenedoresEditar.estandarizarContenedor(grupo, JSON.parse(resultado), ['id_generico', 'nombre'])

				}
			})

			ediPop.pop()

		}
	},
	"presentacion": async (e) => {
		if(e.target.classList.contains('presentacion')) {
			
			var sublista = tools.pariente(e.target, 'TR').sublista

			window.location.href = `../paginas/presentaciones.php?id_medicamento=${sublista.id_medicamento}&posicion=${window.medicamentos.crud.pagPosi}&busqueda=${qs('#busqueda').value}`

		}
	},
	"tratamiento": async (e) => {
		if(e.target.classList.contains('tratamiento')) {
			
			var sublista = tools.pariente(e.target, 'TR').sublista

			window.location.href = `../paginas/tratamientos.php?id_medicamento=${sublista.id_medicamento}&posicion=${window.medicamentos.crud.pagPosi}&busqueda=${qs('#busqueda').value}`

		}
	}
};

(async () => {
	var resultado = await tools.fullAsyncQuery('medicamentos', 'cargar_medicamentos', [])
	medicamentos.cargarTabla(JSON.parse(resultado), undefined, undefined)
	medicamentos['crud'].botonBuscar('buscar', false) 
})()

//----------------------------------------------------------------------------------------------------
//										E V E N T O S                                                
//----------------------------------------------------------------------------------------------------
contenedores.eventos().checkboxes('status')

contenedoresInsertar.eventos().contenedor(
	'cc-insertar-genericos', //elemento
	['combos', 'combo_genericos', ['', 80]],    //informacion de la petición
	[0, 2], 			   //limitador de busqueda
	[true, true, [false, false], true, false, true, true, true, [true, false], false, true], //comportamientos extras
	{} //funciones
)

contenedoresEditar.eventos().contenedor(
	'cc-editar-genericos', //elemento
	['combos', 'combo_genericos', ['', 80]],    //informacion de la petición
	[0, 2], 			   //limitador de busqueda
	[true, true, [false, false], true, false, true, true, true, [true, false], false, true], //comportamientos extras
	{} //funciones
)
//----------------------------------------------------------------------------------------------------
//						Evento del botón de aplicar filtros en la tabla principal
//----------------------------------------------------------------------------------------------------
qs('#procesar').addEventListener('click', async e => {

	medicamentos.spinner('#tabla-medicamentos tbody')
	
	var peticion = contenedores.procesar(tools.fullQuery, 'medicamentos','filtrar')

	peticion.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
        	qs('#tabla-medicamentos tbody').innerHTML = ''
        	medicamentos.cargarTabla(JSON.parse(this.responseText))
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

				var resultado = await tools.fullAsyncQuery('medicamentos', 'actualizar_medicamentos', datos)

				if (resultado.trim() === 'exito') {

					await medicamentos.confirmarActualizacion(ediPop)

					medicamentos.crud.botonForzar(true)
				
				} else if (resultado.trim() === 'repetido') {

					notificaciones.mensajeSimple('Este medicamento ya éxiste', resultado, 'F')

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

			var resultado = await tools.fullAsyncQuery('medicamentos', 'crear_medicamentos', datos)

			if (resultado.trim() === 'exito') {

				medicamentos.confirmarActualizacion(insPop)
			
			} else if (resultado.trim() === 'repetido') {

				notificaciones.mensajeSimple('Este medicamento ya éxiste', resultado, 'F')

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
qs('#tabla-medicamentos').addEventListener('click', e => {
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

qs('#medicamentos-insertar').addEventListener('click', e => {
	window.idSeleccionada = 0
	tools.limpiar('.insertar-valores', '', {"asegurar": () => {return '#crud-insertar-pop'}})
	insPop.pop()
})
