//1)--------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------
//										GENERAL                                         
//----------------------------------------------------------------------------------------------------
////--------------------------------------------------------------------------------------------------

/////////////////////////////////////////////////////
//IMPORTA EL CÓDIGO DEL CRUD
/////////////////////////////////////////////////////
import {Tabla} from '../js/crud.js';

/////////////////////////////////////////////////////
//IMPORTA usoS DE MAIN.JS PARA REUTILIZAR FUNCIONES
/////////////////////////////////////////////////////
import {PopUp, Acciones, Herramientas, ContenedoresEspeciales, paginaCargada, Rellenar, Atajos, ARPropiedades, Reportes, Notificaciones, Animaciones, customDesplegable, textoPersonalizable} from '../js/main.js';

/////////////////////////////////////////////////////
//GENERA LOS COMPORTAMIENTOS BÁSICOS DE LOS POPUPS
/////////////////////////////////////////////////////
window.ediPop = new PopUp('crud-editar-popup', 'popup', 'subefecto', true, 'editar', ['insertar-ocupaciones'], 27)
window.insPop = new PopUp('crud-insertar-popup', 'popup', 'subefecto', true, 'insertar', '', 27)
window.infPop = new PopUp('crud-informacion-popup', 'popup', 'subefecto', true, 'informacion', '', 27)

window.ocuPop = new PopUp('crud-insertar-ocupaciones-popup','popup', 'subefecto', true, 'insertar-ocupaciones', '', 27)
// window.diaPop = new PopUp('crud-insertar-diagnosticos-popup','popup', 'subefecto', true, 'insertar-diagnosticos', '', 27)

ediPop.evtBotones()
insPop.evtBotones()
infPop.evtBotones()

ocuPop.evtBotones()
// diaPop.evtBotones()

window.addEventListener('keyup', (e) => {

	ediPop.evtEscape(e)
	insPop.evtEscape(e)
	infPop.evtEscape(e)

	ocuPop.evtEscape(e)
	// diaPop.evtEscape(e)

})

/////////////////////////////////////////////////////
//HERRAMIENTAS GENERALES
/////////////////////////////////////////////////////
export const tools = new Herramientas()

/////////////////////////////////////////////////////
//NOTIFICACIONES GENERALES
/////////////////////////////////////////////////////
export var notificaciones = new Notificaciones()

//notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'ALERTA')
//notificaciones.mensajeSimple('Procesando...', false, 'V')

///////////////////////////////////////////////////////
//PROPIEDADES BOTONES PAGINACION CONTENEDORES
/////////////////////////////////////////////////////
const propiedadesBotonesContenedores = new ARPropiedades({"data-estilo": "focus-2"})
///////////////////////////////////////////////////////
//ANIMACIONES
////////////////////////////////////////////////////
window.animaciones = new Animaciones({on: 'abrir', off: 'cerrar'}, ['click', 'mouseleave'])
window.animaciones.hider = 'data-hidden'

/////////////////////////////////////////////////////
//GENERA LOS COMPORTAMIENTOS BÁSICOS DE LOS POPUPS
/////////////////////////////////////////////////////
window.contenedores = new ContenedoresEspeciales('historias-status')

window.contenedoresConsultar = new ContenedoresEspeciales('crud-informacion-popup') 
window.contenedoresEditar    = new ContenedoresEspeciales('crud-editar-popup') 
window.contenedoresInsertar  = new ContenedoresEspeciales('crud-insertar-popup') 
/////////////////////////////////////////////////////
//TEXTAREAS PERSONALIZABLES
/////////////////////////////////////////////////////
// window.camposTextosPersonalizables = new textoPersonalizable()

// window.camposTextosPersonalizables.declarar('#antecedentes-enfocar', undefined, '#antecedentes-previa-texto')
// window.camposTextosPersonalizables.declarar('#anteditar-textarea', undefined, '#anteditar-previa-texto')

// window.camposTextosPersonalizables.init()
/////////////////////////////////////////////////////
window.qs = document.querySelector.bind(document)
window.qsa = document.querySelectorAll.bind(document)
/////////////////////////////////////////////////////
window.procesar = true
window.idSeleccionada = 0

var prevenirCierrePop = false,
	permitirLimpieza = true,
	ultimoBotonInsersionBasica = ''
/////////////////////////////////////////////////////
//ATAJOS DE TECLADO
/////////////////////////////////////////////////////
window.atajos = new Atajos('Shift', [
	{"elemento": '#contenido-contenedor',"ejecuta": 'n', "tarea": () => {tools.limpiar('.insertar-valores', '', {}); insPop.pop()}},
	{"elemento": '#busqueda',"ejecuta": 'Shift', "clean": true, "tarea": "focus"},
	{"elemento": '#busqueda',"ejecuta": 'Shift', "clean": true, "tarea": () => {
		setTimeout(() => {historias.crud.botonForzar()}, 100)
	}}
])

window.atajos.eventos()
/////////////////////////////////////////////////////
/////////////////////////////////////////////////////
window.atajoSuprimir = new Atajos('Delete', [
	{"elemento": '#busqueda',"ejecuta": 'Delete', "clean": true, "tarea": "focus"},
	{"elemento": '#busqueda',"ejecuta": 'Delete', "clean": true, "tarea": () => {
		qs('#busqueda').value = ''
	}}
])

window.atajoSuprimir.eventos()
/////////////////////////////////////////////////////
//REVISA QUE LA PÁGINA YA CARGO POR COMPLETO PARA QUITAR LA ANIMACIÓN DE CARGA
/////////////////////////////////////////////////////
window.cargar = new paginaCargada('#tabla-historias thead .ASC', 'existencia')
window.cargar.revision()

// window.cargarInforme = new paginaCargada('#informe-combo', 'longitud', 'cargar-informes')
// window.cargarInforme.revision()
/////////////////////////////////////////////////////
window.rellenar = new Rellenar()
window.reportes = new Reportes()
/////////////////////////////////////////////////////
var sesiones = await window.sesiones(true)
/////////////////////////////////////////////////////
//2)--------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------
//									FORMULARIO                                   
//----------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------
class Historias extends Acciones {

	constructor(crud) {
		super(crud)
		this.fila
		this.uso   = 'historias'
		this.cargar  = 'cargar_historias' 
		//-------------------------------
		this.alternar = [true, 'white', 'whitesmoke']
		this.especificos = ['id_historia', 'nombre_completo', 'cedula']
		this.limitante = 0
		this.boton = ''
		this.sublista = {}
		this.tr = ''
		//-------------------------------
		this.div = document.createElement('div')
	}

	async confirmarActualizacion(popUp) {

		notificaciones.mensajeSimple('Petición realiza con éxito', false, 'V')
		
		if (!prevenirCierrePop) {

			if (typeof popUp !== 'undefined') {
				popUp.pop()
			}

		}

		var resultado = JSON.parse(await tools.fullAsyncQuery(this.uso, this.cargar, []))

		this.cargarTabla(resultado, true)

	}

}
/////////////////////////////////////////////////////
///
export var historias = new Historias(new Tabla(
	[
		['N°. Hist', true, 0],
		['Paciente', true, 22],
		['N° de cédula', true, 9],
		['Status', true, 21],
		['Acciones', false, 0]
	],
	'tabla-historias', 'busqueda', Number(sesiones.modo_filas), 'izquierda', 'derecha', 'numeracion', true
))

window.historias = historias
/////////////////////////////////////////////////////
///
historias['crud'].generarColumnas(['gSpan', null, null], [false],['HTML'], '', 0)
historias['crud'].generarColumnas(['gSpan', null, null], [false],['HTML'], '', 22)
historias['crud'].generarColumnas(['gSpan', null, null], [false],['HTML'], '', 9)
historias['crud'].generarColumnas(['gSpan', null, null], [false],['HTML'], '', 21)

historias['crud'].cuerpo.push([historias['crud'].columna = historias['crud'].cuerpo.length, [
		historias['crud'].gBt(['informacion btn btn-informacion', 'Información del paciente'], `<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="info" class="iconos-b" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 192 512"><path fill="currentColor" d="M20 424.229h20V279.771H20c-11.046 0-20-8.954-20-20V212c0-11.046 8.954-20 20-20h112c11.046 0 20 8.954 20 20v212.229h20c11.046 0 20 8.954 20 20V492c0 11.046-8.954 20-20 20H20c-11.046 0-20-8.954-20-20v-47.771c0-11.046 8.954-20 20-20zM96 0C56.235 0 24 32.235 24 72s32.235 72 72 72 72-32.235 72-72S135.764 0 96 0z"></path></svg>`),
		historias['crud'].gBt(['editar btn btn-editar', 'Editar historia'], `<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="pencil-alt" class="svg-inline--fa fa-pencil-alt fa-w-16 iconos-b" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M497.9 142.1l-46.1 46.1c-4.7 4.7-12.3 4.7-17 0l-111-111c-4.7-4.7-4.7-12.3 0-17l46.1-46.1c18.7-18.7 49.1-18.7 67.9 0l60.1 60.1c18.8 18.7 18.8 49.1 0 67.9zM284.2 99.8L21.6 362.4.4 483.9c-2.9 16.4 11.4 30.6 27.8 27.8l121.5-21.3 262.6-262.6c4.7-4.7 4.7-12.3 0-17l-111-111c-4.8-4.7-12.4-4.7-17.1 0zM124.1 339.9c-5.5-5.5-5.5-14.3 0-19.8l154-154c5.5-5.5 14.3-5.5 19.8 0s5.5 14.3 0 19.8l-154 154c-5.5 5.5-14.3 5.5-19.8 0zM88 424h48v36.3l-64.5 11.3-31.1-31.1L51.7 376H88v48z"></path></svg>`),
		historias['crud'].gBt(['evolucion-cargar antecedentes-crud btn btn-general', 'Cargar evolución del paciente'], `<svg xmlns="http://www.w3.org/2000/svg" class="iconos-b" viewBox="0 0 448 512"><path fill="currentColor" d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z"/></svg>`),
		historias['crud'].gBt(['evolucion-consultar antecedentes-crud btn btn-general', 'Consultar evoluciones del paciente'], `<svg xmlns="http://www.w3.org/2000/svg" class="iconos-b" viewBox="0 0 448 512"><path fill="currentColor" d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z"/></svg>`)
	], [0,0,0,0], ['VALUE', 'VALUE', 'VALUE', 'VALUE'], 'crud-botones', false
])
/////////////////////////////////////////////////////
historias['crud']['retornarSiempre'] = true
historias['crud']['limitante'] = 1
historias['crud']['clase'] = 'historias'
historias['crud']['funcion'] = 'buscar_historias'
historias['crud']['autoBusqueda'] = true
historias['crud']['inputNavegarGenerar'] = false
/////////////////////////////////////////////////////
///
historias['crud'].botonModoBusqueda("#modo-buscar", 1, [
	['id_historia'],
	['id_historia', 'nombre_completo', 'cedula']
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
historias['crud']['propiedadesTr'] = {
	"informacion": (e) => {
		var fr = new DocumentFragment(), th = historias
		var div = th.div.cloneNode(true);

		//var fecha = (e.sublista.fecha_consulta === '1900-01-01') ? '---' :  e.sublista.fecha_consulta_arreglada;
		var  fecha = 'PLACEHOLDER'

		var d1 = th.div.cloneNode(true)
			d1.insertAdjacentHTML('afterbegin', 'Última fecha de consulta')
			d1.setAttribute('style', `min-width:200px; color:#fff`)

		var d2 = th.div.cloneNode(true)
			d2.insertAdjacentHTML('afterbegin', fecha)
			d2.setAttribute('style', `color:#fff`)

		div.appendChild(d1)
		div.appendChild(d2)

		div.setAttribute('style', `padding: 6px; width:fit-content; text-align: left;font-size: 1.1em; position:fixed; background:#262626`)
		div.setAttribute('class', 'tooltip-crud')
		div.setAttribute('data-hidden', '')

		e.addEventListener('mousemove', div.fn = function fn(e) {
			this.querySelector('.tooltip-crud').style.top = (e.clientY - 50)+'px'
			this.querySelector('.tooltip-crud').style.left = (e.clientX + 15)+'px'
		})

		e.addEventListener('mouseenter', div.fn = function fn(e) {
			this.querySelector('.tooltip-crud').removeAttribute('data-hidden')	
		})

		e.addEventListener('mouseleave', div.fn = function fn(e) {
			this.querySelector('.tooltip-crud').setAttribute('data-hidden', '')
		})

		e.appendChild(div)
	}
}
/////////////////////////////////////////////////////
///
historias['crud']['customBodyEvents'] = {
	/* -------------------------------------------------------------------------------------------------*/
	/*           					PAGINACION ENTRE CONTENEDORES				   					    */
	/* -------------------------------------------------------------------------------------------------*/
	"paginacion": (e) => {
		if(e.target.tagName === 'BUTTON') {
			window.pg.actualizarFamiliaDeBotones(tools.pariente(e.target, 'TR'))
			window.pg.cambiarUltimoSeleccionado(e.target.classList[0])
		}
	},
	/* -------------------------------------------------------------------------------------------------*/
	/*           					ENVIAR LOS DATOS PARA CONSULTAR LA HISTORIA   					    */
	/* -------------------------------------------------------------------------------------------------*/
	"informacion": async (e) => {

		var button = (tools.esDOM(e)) ? e : e.target;

		if (button.classList.contains('informacion')) {

			propiedadesBotonesContenedores.ejecutar('#paginacion-contenedores .informacion')

			historias.tr = tools.pariente(button, 'TR')
			historias.sublista = historias.tr.sublista

			// if (permitirLimpieza) {

			// } else {
			// 	permitirLimpieza = true
			// }

			tools.limpiar('.informacion-valores', '', {})

			var fecha = (historias.sublista.fecha_consulta === '1900-01-01') ? '---' :  historias.sublista.fecha_consulta_arreglada;

			rellenar.contenedores(historias.sublista, '.informacion-valores', {elemento: button, id: 'value'}, {
				"procesado": function fn() {

					qs('#informacion-edad').value = tools.calcularFecha(new Date(qs('#informacion-fecha').value))
					qs('#informacion-fecha-valor').value = fecha
				
				}
			})

			setTimeout(() => {
				
				document.querySelector('#informacion-enfocar').focus()

			}, 100)

			infPop.pop()

		}

	},
	/* -------------------------------------------------------------------------------------------------*/
	/*           					ENVIAR LOS DATOS PARA EDITAR LA HISTORIA   						    */
	/* -------------------------------------------------------------------------------------------------*/
	"editar": async (e) => {

		var button

		if (tools.esDOM(e)) {

			button = e
			prevenirCierrePop = true

		} else {

			button = e.target
			prevenirCierrePop = false

		}

		if (button.classList.contains('editar')) {

			propiedadesBotonesContenedores.ejecutar('#paginacion-contenedores .editar')

			historias.tr = tools.pariente(button, 'TR')
			historias.sublista = historias.tr.sublista

			if (permitirLimpieza) {
				tools.limpiar('.antecedentes-valores', '', {"contenedor-personalizable": window.camposTextosPersonalizables})
				tools.limpiar('.informes-valores', '', {"contenedor-personalizable": window.camposTextosPersonalizables})
				tools.limpiar('.recipes-valores', '', {"contenedor-personalizable": window.camposTextosPersonalizables})
				tools.limpiar('.reposos-valores', '', {
					"contenedor-personalizable": window.camposTextosPersonalizables,
					"procesado": e => {
						gid('reposos-inicio-insertar').value = window.dia
					}
				})
				gid('reposos-fecha-insertar').innerHTML = ''
			} else {
				permitirLimpieza = true
			}

			tools.limpiar('.editar-valores', '', {})

			rellenar.contenedores(historias.sublista, '.editar-valores', {elemento: button, id: 'value'}, {
				"contenedorConsulta": function fn(lista, elemento) {
					
					contenedoresEditar.estandarizarContenedor(elemento, lista, [0])
					
				},
				"procesado": function fn() {

					qs('#editar-edad').value = tools.calcularFecha(new Date(qs('#editar-fecha').value))
					qs('[data-grupo=cc-ocupacion-editar] input').value = ''
				
				}
			})

			setTimeout(() => {
				
				document.querySelector('#editar-enfocar').focus()

			}, 100)

			ediPop.pop()

		}

	},
	/* -------------------------------------------------------------------------------------------------*/
	/*           					ENVIAR LOS DATOS PARA LOS ANTECEDENTES   						    */
	/* -------------------------------------------------------------------------------------------------*/
	"antecedentes": async(e) => { 

		var button = (tools.esDOM(e)) ? e : e.target;

		if (button.classList.contains('antecedentes')) {

			tools.limpiar('.antecedentes-cargar', '', {})

			propiedadesBotonesContenedores.ejecutar('#paginacion-contenedores .antecedentes')

			notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'PROCESANDO')

			historias.tr = tools.pariente(button, 'TR')
			historias.sublista = historias.tr.sublista

			if (permitirLimpieza) {
				tools.limpiar('.antecedentes-valores', '', {"contenedor-personalizable": window.camposTextosPersonalizables})
				tools.limpiar('.informes-valores', '', {"contenedor-personalizable": window.camposTextosPersonalizables})
				tools.limpiar('.recipes-valores', '', {"contenedor-personalizable": window.camposTextosPersonalizables})
				tools.limpiar('.reposos-valores', '', {
					"contenedor-personalizable": window.camposTextosPersonalizables,
					"procesado": e => {
						gid('reposos-inicio-insertar').value = window.dia
					}
				})
				gid('reposos-fecha-insertar').innerHTML = ''
			} else {
				permitirLimpieza = true
			}

			rellenar.contenedores(historias.sublista, '.antecedentes-cargar', {elemento: button, id: 'value', "contenedor-personalizable": window.camposTextosPersonalizables})
			
			setTimeout(() => {
				
				document.querySelector('#antecedentes-enfocar').focus()

			}, 100)

			antPop.pop()
			
			var lista = JSON.parse(await tools.fullAsyncQuery('historias_antecedentes', 'antecedentes_consultar', [historias.sublista.id_historia]))

			antecedentes.cargarTabla(lista, undefined, undefined)

		}

	}
};

(async () => {
	var resultado = await tools.fullAsyncQuery('historias', 'cargar_historias', [])
	historias.cargarTabla(JSON.parse(resultado), undefined, undefined)

})()

historias['crud'].botonBuscar('buscar', false)

//3)---------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------
//										E V E N T O S                                                
//----------------------------------------------------------------------------------------------------
var comboDiagnosticos = JSON.parse(await tools.fullAsyncQuery('combos', 'combo_diagnosticos', []))

contenedores.eventos().checkboxes('status')

contenedoresConsultar.eventos().combo('cc-ocupacion-consultar', ['combos', 'combo_ocupacion', ['', '']], false, {})
contenedoresInsertar.eventos().combo('cc-ocupacion-insertar', ['combos', 'combo_ocupacion', ['', '']], false, {})
contenedoresEditar.eventos().combo('cc-ocupacion-editar', ['combos', 'combo_ocupacion', ['', '']], false, {})

contenedoresEditar.eventos().contenedor(
	'cc-telefonos-editar', //elemento
	['', '', ['', '']],    //informacion de la petición
	[0, 1], 			   //limitador de busqueda
	[false, true, [false, false], false, true, false, false, false, [false, true], false, false], //comportamientos extras
	{} //funciones
)

contenedoresEditar.eventos().contenedor(
	'cc-correos-editar', //elemento
	['', '', ['', '']],    //informacion de la petición
	[0, 1], 			   //limitador de busqueda
	[false, true, [false, false], false, true, false, false, false, [false, true], false, false], //comportamientos extras
	{} //funciones
)

contenedoresEditar.eventos().contenedor(
	'cc-otros-editar', //elemento
	['', '', ['', '']],    //informacion de la petición
	[0, 1], 			   //limitador de busqueda
	[false, true, [false, false], false, true, false, false, false, [false, true], false, false], //comportamientos extras
	{} //funciones
)

contenedoresInsertar.eventos().contenedor(
	'cc-telefonos-insertar', //elemento
	['', '', ['', '']],    //informacion de la petición
	[0, 1], 			   //limitador de busqueda
	[false, true, [false, false], false, true, false, false, false, [false, true], false, false], //comportamientos extras
	{} //funciones
)

contenedoresInsertar.eventos().contenedor(
	'cc-correos-insertar', //elemento
	['', '', ['', '']],    //informacion de la petición
	[0, 1], 			   //limitador de busqueda
	[false, true, [false, false], false, true, false, false, false, [false, true], false, false], //comportamientos extras
	{} //funciones
)

contenedoresInsertar.eventos().contenedor(
	'cc-otros-insertar', //elemento
	['', '', ['', '']],    //informacion de la petición
	[0, 1], 			   //limitador de busqueda
	[false, true, [false, false], false, true, false, false, false, [false, true], false, false], //comportamientos extras
	{} //funciones
)

// contenedoresInformes.eventos().contenedor(
// 	'cc-diagnosticos-informes', //elemento
// 	['combos', 'combo_diagnosticos', ['', '']],    //informacion de la petición
// 	[0, 0], 			   //limitador de busqueda
// 	[false, true, [false, false], true, true, false, true, true, [true, true], false, true], //comportamientos extras
// 	{"lista": comboDiagnosticos} //funciones
// )

// contenedoresInformesEditar.eventos().contenedor(
// 	'cc-diagnosticos-editar', //elemento
// 	['combos', 'combo_diagnosticos', ['', '']],    //informacion de la petición
// 	[0, 0], 			   //limitador de busqueda
// 	[false, true, [false, false], true, true, false, true, true, [true, true], false, true], //comportamientos extras
// 	{"lista": comboDiagnosticos} //funciones
// )

//4)---------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------
//						Evento del botón de aplicar filtros en la tabla principal
//----------------------------------------------------------------------------------------------------
qs('#procesar').addEventListener('click', async e => {

	historias.spinner('#tabla-historias tbody')
	
	var peticion = contenedores.procesar(tools.fullQuery, 'historias','filtrar')

	peticion.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
        	qs('#tabla-historias tbody').innerHTML = ''
        	historias.cargarTabla(JSON.parse(this.responseText))
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

			var datos = tools.procesar(e.target, 'editar', 'editar-valores', tools)

			if(datos !== '') {
				
				notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'PROCESANDO')

				var resultado = await tools.fullAsyncQuery('historias', 'editar_historia', datos)

				if (resultado.trim() === 'exito') {

					historias.tr.sublista = JSON.parse(await tools.fullAsyncQuery('historias', 'traer_historia', [historias.sublista.id_historia]))

					historias.confirmarActualizacion()

					if (datos[9] === 'D') {

						ediPop.pop()

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

		var datos = tools.procesar(e.target, 'insertar', 'insertar-valores', tools)

		if (datos !== false) {

			notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'PROCESANDO')

			var resultado = await tools.fullAsyncQuery('historias', 'insertar_historia', datos)

			if (resultado.trim() === 'exito') {

				historias.confirmarActualizacion(insPop)
			
			} else {

				notificaciones.mensajeSimple('Error al procesar la petición', resultado, 'F')

			}

		}
	}
})

/* -------------------------------------------------------------------------------------------------*/	
//                     edición de fecha
/* -------------------------------------------------------------------------------------------------*/
qs('#editar-fecha').addEventListener('change', e=> {

	qs('#editar-edad').value = tools.calcularFecha(new Date(e.target.value))

})

/* -------------------------------------------------------------------------------------------------*/	
//                     edición de fecha
/* -------------------------------------------------------------------------------------------------*/
qs('#insertar-fecha').addEventListener('change', e=> {

	qs('#insertar-edad').value = tools.calcularFecha(new Date(e.target.value))

})

/* -------------------------------------------------------------------------------------------------*/	
//                     abrir ínsersión de historia
/* -------------------------------------------------------------------------------------------------*/
qs('#historias-insertar').addEventListener('click', e => {
	prevenirCierrePop = false
	qs('[data-grupo=cc-ocupacion-insertar] input').value = ''
	tools.limpiar('.insertar-valores', '', {})
	window.idSeleccionada = 0
	insPop.pop()
})

/* -------------------------------------------------------------------------------------------------*/	
//                abrir ediciones de campos dentro de la historia (ocupacion, dermatologia)
/* -------------------------------------------------------------------------------------------------*/
qs('#editar-nueva-ocupacion').addEventListener('click', e=> {
	ultimoBotonInsersionBasica = e.target
	qs('#nombre-ocupaciones').value = ''
	ocuPop.pop()
})

qs('#insertar-nueva-ocupacion').addEventListener('click', e=> {
	ultimoBotonInsersionBasica = e.target
	qs('#nombre-ocupaciones').value = ''
	ocuPop.pop()
})

// qs('#insertar-nueva-diagnostico').addEventListener('click', e=> {
// 	ultimoBotonInsersionBasica = e.target
// 	qs('#nombre-diagnosticos').value = ''
// 	diaPop.pop()
// })

//-------------------------------------------------------------------------------
//botones que insertan datos básicos desde la edición o insersión de una historia
//-------------------------------------------------------------------------------

var insersiones_lista = ['ocupaciones' /*, 'diagnosticos'*/],
	insersiones_lista_combos = [ocuPop/*, diaPop*/];

insersiones_lista.forEach((grupo, i) => {

	qs(`#crud-insertar-${grupo}-botones`).addEventListener('click', async e => {

		if (e.target.classList.contains('insertar')) {

			var datos = tools.procesar(e.target, 'insertar', `nuevas-${grupo}`,  tools)

			if (datos !== '') {

				datos.splice(1,1)

				var resultado = await tools.fullAsyncQuery(grupo, `crear_${grupo}`, datos)

				if(resultado.trim() === 'exito') {

					notificaciones.mensajeSimple(`${grupo.toUpperCase()} insertada con éxito`, resultado, 'V')

					setTimeout(async () => {

						var lista = JSON.parse(await tools.fullAsyncQuery('combos', `combo_${grupo}`, []))

						ultimoBotonInsersionBasica.parentElement.querySelector('input').value = qs(`#nombre-${grupo}`).value.toUpperCase()
						ultimoBotonInsersionBasica.parentElement.querySelector('input').focus()

						qs(`#nombre-${grupo}`).value = ''

						insersiones_lista_combos[i].pop()

						if (grupo === 'ocupaciones') {

							contenedoresEditar.reconstruirCombo(qs('[data-grupo="cc-ocupacion-editar"] select'), qs('[data-grupo="cc-ocupacion-editar"] input'), lista)
							contenedoresEditar.filtrarComboForzado(qs('[data-grupo="cc-ocupacion-editar"] select'), qs('[data-grupo="cc-ocupacion-editar"] input'))

							contenedoresInsertar.reconstruirCombo(qs('[data-grupo="cc-ocupacion-insertar"] select'), qs('[data-grupo="cc-ocupacion-insertar"] input'), lista)
							contenedoresInsertar.filtrarComboForzado(qs('[data-grupo="cc-ocupacion-insertar"] select'), qs('[data-grupo="cc-ocupacion-insertar"] input'))

						} else if (grupo === 'diagnosticos') {

							contenedoresInformes.reconstruirCombo(qs(`#cc-diagnosticos-informes select`), qs(`#cc-diagnosticos-informes input`), lista)
							contenedoresInformes.filtrarComboForzado(qs(`#cc-diagnosticos-informes select`), qs(`#cc-diagnosticos-informes input`))

						}


					}, 500)

				} else if (resultado.trim() === 'repetido') {

					notificaciones.mensajeSimple(`Este [${grupo.toUpperCase()}] ya existe`, resultado, 'F')

				} else {

					notificaciones.mensajeSimple('Error al procesar la petición', resultado, 'F')

				}
			}
		}
	})

})

//5)---------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------
//										ANTECEDENTES                                        
//----------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------
class Antecedentes extends Acciones {

	constructor(crud) {
		super(crud)
		this.fila
		this.clase   = 'historias'
		this.funcion = 'traer_antecedentes_historia'
		//-------------------------------
		this.alternar = [true, 'white', 'whitesmoke']
		this.especificos = ['fecha_arreglada']
		this.limitante = 0
		this.boton = ''
		this.sublista = {}
		//-------------------------------
		this.div = document.createElement('div')
		this.contenido = qs('#antecedentes-template').content.querySelector('.antecedentes-contenido').cloneNode(true)
		this.contenidoFecha = qs('#template-fecha').content.querySelector('.template-fecha-contenedor').cloneNode(true)
	}

	async confirmarActualizacion(popUp) {

		notificaciones.mensajeSimple('Petición realiza con éxito', false, 'V')

		var resultado = JSON.parse(await tools.fullAsyncQuery(this.clase, this.funcion, []))

		this.cargarTabla(resultado, true)

	}

}
/////////////////////////////////////////////////////
///
export var antecedentes = new Antecedentes(new Tabla(
	[	
		['', false, 0],
		['', false, 0]
	],
	'tabla-antecedentes', 'antecedentes-busqueda', -1, 'null', 'null', 'null', true
))
/////////////////////////////////////////////////////
///
antecedentes['crud'].generarColumnas(['gSpan', null, null], [false],['HTML'], 'antecedentes-contenedor', 0)
antecedentes['crud'].generarColumnas(['gSpan', null, null], [false],['HTML'], 'fecha-contenedor', 0)
/////////////////////////////////////////////////////
///
antecedentes['crud']['propiedadesTr'] = {
	"contenedor": (e) => {

		var fr = new DocumentFragment(),
			th = antecedentes, 
			contenedor = e.querySelector('.antecedentes-contenedor'), 
			contenido = th.contenido.cloneNode(true)

		contenedor.innerHTML = ''
		contenedor.appendChild(contenido)
		contenedor.setAttribute('id', `id-${e.sublista.id}`)
		
		contenedor.querySelector('.antecedentes-datos-contenedor').setAttribute('id', `a-id-${e.sublista.id}`)

		var ant = JSON.parse(e.sublista.antecedente).textoPrevia,
			texto = ''

		ant.forEach(el => {
		    texto = `${texto}${el}` 
		})

		contenedor.querySelector('.antecedentes-antecedente').innerHTML = texto.toUpperCase()

		contenedor.querySelector('.antecedente-nombre').insertAdjacentHTML('afterbegin', `<b>- Nombre:</b> ${e.sublista.nombres}`)
		contenedor.querySelector('.antecedente-apellido').insertAdjacentHTML('afterbegin', `<b>- Apellido:</b> ${e.sublista.apellidos}`)
		contenedor.querySelector('.antecedente-cedula').insertAdjacentHTML('afterbegin', `<b>- Cédula/pasaporte:</b> ${e.sublista.cedula}`)
		contenedor.querySelector('.antecedente-direccion').insertAdjacentHTML('afterbegin', `<b>- Dirección:</b> ${e.sublista.direccion}`)
		contenedor.querySelector('.antecedente-edad').insertAdjacentHTML('afterbegin', `<b>- Edad:</b> ${tools.calcularFecha(new Date(e.sublista.fecha_nacimiento))}`)
		contenedor.querySelector('.antecedente-peso').insertAdjacentHTML('afterbegin', `<b>- Peso (M):</b> ${e.sublista.peso}`)
		contenedor.querySelector('.antecedente-talla').insertAdjacentHTML('afterbegin', `<b>- Talla (KG):</b> ${e.sublista.talla}`)
		
		setTimeout(() => {

			window.animaciones.generar(`#id-${e.sublista.id} .antecedentes-datos`, [`#a-id-${e.sublista.id}`])

		}, 0)

	},
	"fecha": (e) => {

		var th = antecedentes, 
			contenedor = e.querySelector('.fecha-contenedor'), 
			contenido = th.contenidoFecha.cloneNode(true)

		contenedor.innerHTML = ''
		contenedor.appendChild(contenido)

		contenedor.querySelector('.fecha-template').value = e.sublista.fecha
		contenedor.querySelector('.hora-template').value  = e.sublista.hora

	}
}
/////////////////////////////////////////////////////
///
antecedentes['crud']['customBodyEvents'] = {
	/* -------------------------------------------------------------------------------------------------*/
	/*           					ENVIAR LOS DATOS PARA EDITAR EL ANTECEDENTE   					    */
	/* -------------------------------------------------------------------------------------------------*/
	"editar": async (e) => {

		if (e.target.classList.contains('editar')) {

			antecedentes.sublista = tools.pariente(e.target, 'TR').sublista

			tools.limpiar('.anteditar-valores', '', {"contenedor-personalizable": window.camposTextosPersonalizables})
			rellenar.contenedores(antecedentes.sublista, '.anteditar-valores', {elemento: e.target, id: 'value', "contenedor-personalizable": window.camposTextosPersonalizables}, {})

			antEdiPop.pop()

		}

	},
	/* -------------------------------------------------------------------------------------------------*/
	/*           				ENVIAR LOS DATOS PARA REIMPRIMIR EL ANTECENDENTE   					    */
	/* -------------------------------------------------------------------------------------------------*/
	"reimprimir": async (e) => {

		if (e.target.classList.contains('reimprimir')) {

			antecedentes.sublista = tools.pariente(e.target, 'TR').sublista

			var sesion = [
					{"sesion": 'datos_pdf', "parametros": JSON.stringify(antecedentes.sublista)}
				]

			await tools.fullAsyncQuery('historias', 'modificar_sesion', sesion)

			antPrePop.pop()

			window.reportes.previa(qs('#crud-antprevia-reporte iframe'), `../plantillas/antecedentepdf.php?&pdf=2`)

		}

	},
	/* -------------------------------------------------------------------------------------------------*/
	/*           					ENVIAR LOS DATOS PARA ELIMINAR EL ANTECEDENTE   					    */
	/* -------------------------------------------------------------------------------------------------*/
	"eliminar": async (e) => {

		if (e.target.classList.contains('eliminar')) {

			antecedentes.sublista = tools.pariente(e.target, 'TR').sublista
			antEliPop.pop()

		}

	}
};


(async () => {

	antecedentes.cargarTabla([], undefined, undefined)

})()

//5)---------------------------------------------------------------------------------------------------
/* -------------------------------------------------------------------------------------------------*/
/*           							PAGINACION CONTENEDORES			 	  					    */
/* -------------------------------------------------------------------------------------------------*/
class PaginacionContenedores {

	constructor() {
		this.contenedorBotones = qs('#paginacion-contenedores')
		this.ultimoSeleccionado = ''

		this.controlador = {
			"informacion": {
				"pop": () => {infPop.pop()},
				"boton": ''
			},
			"editar": {
				"pop": () => {ediPop.pop()},
				"boton": ''
			}
		}
	}

	ocultar() {
		this.contenedorBotones.setAttribute('data-hidden', '')
	}

	mostrar() {
		this.contenedorBotones.removeAttribute('data-hidden')
	}

	cambiarContenedor(nuevoSeleccionado) {

		//var button = (tools.esDOM(nuevoSeleccionado)) ? e : e.target;
		//
		if (window.procesar) {

			window.procesaar = false

			this.controlador[this.ultimoSeleccionado]['pop']()

			historias.crud.customBodyEvents[nuevoSeleccionado](this.controlador[nuevoSeleccionado].boton)

			this.cambiarUltimoSeleccionado(nuevoSeleccionado)

			setTimeout(() => {
				qs('body').classList.add('no-scroll')
				window.procesaar = true
			}, 400)

		}

	}

	cambiarUltimoSeleccionado(seleccionado) {
		this.ultimoSeleccionado = seleccionado
	}

	actualizarFamiliaDeBotones(tr) {

		var th = this

		Object.keys(this.controlador).forEach(el => {

			th.controlador[el]['boton'] = tr.querySelector(`.${el}`)

		})

	}

	abrirContenedorRemoto(ref) {
		propiedadesBotonesContenedores.ejecutar(`#paginacion-contenedores .${ref}`)

		if (this.ultimoSeleccionado === '') {
			this.cambiarUltimoSeleccionado(ref)
		}

		if (historias.tr !== '') {
			this.actualizarFamiliaDeBotones(historias.tr)
		} else {
			this.actualizarFamiliaDeBotones(tools.pariente(qs(`#tabla-historias tbody tr .${ref}`), 'TR'))

		}

		this.cambiarContenedor(ref)
	}

}
/* -------------------------------------------------------------------------------------------------*/
window.pg = new PaginacionContenedores();
/* -------------------------------------------------------------------------------------------------*/
var pce = qs('#paginacion-contenedores') // paginacion contenedores elemento
/* -------------------------------------------------------------------------------------------------*/
ediPop.funciones['apertura'] = {"apertura": () => {window.pg.mostrar()}}
ediPop.funciones['cierre']   = {"cierre": ()   => {window.pg.ocultar()}}

insPop.funciones['apertura'] = {"apertura": () => {window.pg.mostrar()}}
insPop.funciones['cierre']   = {"cierre": ()   => {window.pg.ocultar(); permitirLimpieza = false}}

infPop.funciones['apertura'] = {"apertura": () => {window.pg.mostrar()}}
infPop.funciones['cierre']   = {"cierre": ()   => {window.pg.ocultar()}}

// antPop.funciones['apertura'] = {"apertura": () => {window.pg.mostrar()}}
// antPop.funciones['cierre']   = {"cierre": ()   => {window.pg.ocultar()}}

// antEdiPop.funciones['apertura'] = {"apertura": () => {pce.style = "z-index: 9;"}}
// antEdiPop.funciones['cierre']   = {"cierre": ()   => {pce.style = "z-index: 10;"}}

/* -------------------------------------------------------------------------------------------------*/
/* ------------------------------PAGINACIÓN ENTRE CONTENEDORES--------------------------------------*/
/* -------------------------------------------------------------------------------------------------*/
qs('#paginacion-contenedores').addEventListener('click', e => {

	if (e.target.tagName === 'BUTTON') {

		permitirLimpieza = false

		propiedadesBotonesContenedores.ejecutar(e.target)
		window.pg.cambiarContenedor(e.target.classList[0])

	}

})

//6)---------------------------------------------------------------------------------------------------
/* -------------------------------------------------------------------------------------------------*/
/* --------------------------------------ATAJOS DE BUSQUEDA----------------------------------------*/
/* -------------------------------------------------------------------------------------------------*/
qs('#busqueda').addEventListener('keydown', e => {

	if (e.target.value !== '' && e.keyCode === 13) {

		if (historias.crud.busqueda.length > 0) {

			propiedadesBotonesContenedores.ejecutar('#paginacion-contenedores .informacion')
			window.pg.cambiarUltimoSeleccionado('informacion')
			window.pg.actualizarFamiliaDeBotones(tools.pariente(qs('#tabla-historias tbody tr .informacion'), 'TR'))
			window.pg.cambiarContenedor('informacion')
		
		} else {

			tools.limpiar('.insertar-valores', '', {}); 

			if (!isNaN(e.target.value)) {
				qs('#insertar-enfocar').value = e.target.value
			}
			// else {
			// 	qs('#insertar-nombre').value = e.target.value
			// }

			setTimeout(() => {qs('#insertar-enfocar').focus()}, 100)
			
			insPop.pop()

		}

	}

})