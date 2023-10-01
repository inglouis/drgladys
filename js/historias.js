//1)--------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------
//										GENERAL                                         
//----------------------------------------------------------------------------------------------------
////--------------------------------------------------------------------------------------------------

//IMPORTA EL CÓDIGO DEL CRUD
/////////////////////////////////////////////////////
import {Tabla} from '../js/crud.js';

/////////////////////////////////////////////////////
window.qs  = document.querySelector.bind(document)
window.qsa = document.querySelectorAll.bind(document)
/////////////////////////////////////////////////////
//IMPORTA usoS DE MAIN.JS PARA REUTILIZAR FUNCIONES
/////////////////////////////////////////////////////
import {PopUp, Acciones, Herramientas, ContenedoresEspeciales, paginaCargada, Rellenar, Atajos, ARPropiedades, Reportes, Notificaciones, Animaciones, customDesplegable, textoPersonalizable, Paginacion, PaginacionContenedores, InputsDecimales} from '../js/main.js';

/////////////////////////////////////////////////////
//DESPLEGABLES DE LA PAGINA
/////////////////////////////////////////////////////
const paginacionReportesDesplegable = new customDesplegable('#reportes-paginacion', '#reportes-abrir-paginacion', '#reportes-cerrar-paginacion', ['mouseenter', 'mouseleave'], 'fit-content')
	  paginacionReportesDesplegable.horientacion = 'V'

paginacionReportesDesplegable.eventos()

/////////////////////////////////////////////////////
window.notificados = new customDesplegable('#desplegable-notificados', '#desplegable-abrir-notificados', '#desplegable-cerrar-notificados', undefined, '400px')
	   notificados.eventos()

window.recipes_desplegable = new customDesplegable('#desplegable-recipes', '#desplegable-abrir-recipes', '#desplegable-cerrar-recipes', undefined, '400px')
	   recipes_desplegable.eventos()

/////////////////////////////////////////////////////
//BOTONES PAGINACION
/////////////////////////////////////////////////////
qsa('#reportes-paginacion-botones button').forEach((boton) => {

	boton['identificador'] = boton.id

})

export async function cambiarSeccionBotones (boton) {

	reporteSeleccionado = boton.identificador

	if (reportesDisponibles[reporteSeleccionado].crud.lista.length < 1) {

		notificaciones.mensajeSimple('Cargando datos', false, 'V')

		await historias.traer_lista()

	}

}

qs('#reportes-paginacion-botones').addEventListener('click', async (e) => {

	if (e.target.tagName === 'BUTTON') {

		cambiarSeccionBotones(e.target)

	}

})
/////////////////////////////////////////////////////
//TEXTAREAS PERSONALIZABLES
/////////////////////////////////////////////////////
window.camposTextosPersonalizables = new textoPersonalizable();

([
	
	['#constancia-informacion', '#constancia-previa'],
	['#coneditar-informacion', '#coneditar-previa'],
	['#constancia-recomendaciones', '#constancia-previa'],
	['#coneditar-recomendaciones', '#coneditar-previa'],
	['#general-informacion', '#general-previa'],
	['#geneditar-informacion', '#geneditar-previa'],
	['#informe-informacion', '#informe-previa'],
	['#informe-control', '#informe-previa'],
	['#informe-motilidad', '#informe-previa'],
	['#informe-biomicroscopia', '#informe-previa'],
	['#informe-fondo', '#informe-previa'],
	['#informe-plan', '#informe-previa'],
	['#infeditar-informacion', '#infeditar-previa'],
	['#infeditar-control', '#infeditar-previa'],
	['#infeditar-motilidad', '#infeditar-previa'],
	['#infeditar-biomicroscopia', '#infeditar-previa'],
	['#infeditar-fondo', '#infeditar-previa'],
	['#infeditar-plan', '#infeditar-previa'],
	['#presupuesto-informacion', '#presupuesto-previa'],
	['#preeditar-informacion', '#preeditar-previa'],
	['#reposo-informacion', '#reposo-previa'],
	['#repeditar-informacion', '#repeditar-previa'],
	['#referencia-informacion', '#referencia-previa'],
	['#referencia-agradecimiento', '#referencia-previa'],
	['#refeditar-informacion', '#refeditar-previa'],
	['#refeditar-agradecimiento', '#refeditar-previa'],

	['#constancia-informacion-notificaciones', '#constancia-previa-notificaciones'],
	['#constancia-recomendaciones-notificaciones', '#constancia-previa-notificaciones'],
	['#informe-informacion-notificaciones', '#informe-previa-notificaciones'],
	['#informe-control-notificaciones', '#informe-previa-notificaciones'],
	['#informe-motilidad-notificaciones', '#informe-previa-notificaciones'],
	['#informe-biomicroscopia-notificaciones', '#informe-previa-notificaciones'],
	['#informe-fondo-notificaciones', '#informe-previa-notificaciones'],
	['#informe-plan-notificaciones', '#informe-previa-notificaciones'],
	['#presupuesto-informacion-notificaciones', '#presupuesto-previa-notificaciones'],
	['#reposo-informacion-notificaciones', '#reposo-previa-notificaciones'],
	['#general-informacion-notificaciones', '#general-previa-notificaciones'],
	['#referencia-informacion-notificaciones', '#referencia-previa-notificaciones'],
	['#referencia-agradecimiento-notificaciones', '#referencia-previa-notificaciones']

]).forEach(e => { window.camposTextosPersonalizables.declarar(e[0], e[1]) })

window.camposTextosPersonalizables.init()

/////////////////////////////////////////////////////
//INPUTS QUE MANEJAN DECIMALES
/////////////////////////////////////////////////////
var inputsDecimales = new InputsDecimales('.decimales')
	inputsDecimales.init()

var inputsFracciones = new InputsDecimales('.fracciones', '/')
	inputsFracciones.init()
/////////////////////////////////////////////////////
//GENERA LOS COMPORTAMIENTOS BÁSICOS DE LOS POPUPS
/////////////////////////////////////////////////////
window.ediPop = new PopUp('crud-editar-popup', 'popup', 'subefecto', true, 'editar', ['insertar-ocupaciones', 'insertar-proveniencias', 'insertar-parentescos', 'insertar-estado_civil', 'insertar-religiones', 'insertar-medicos'], 27)
window.insPop = new PopUp('crud-insertar-popup', 'popup', 'subefecto', true, 'insertar', ['insertar-ocupaciones', 'insertar-proveniencias', 'insertar-parentescos', 'insertar-estado_civil', 'insertar-religiones', 'insertar-medicos'], 27)
window.infPop = new PopUp('crud-informacion-popup', 'popup', 'subefecto', true, 'informacion', '', 27)
window.notPop = new PopUp('crud-notificaciones-popup', 'popup', 'subefecto', true, 'notificaciones', '', 27)
window.recPop = new PopUp('crud-recipes-popup', 'popup', 'subefecto', true, 'recipes', ['presentaciones', 'tratamientos', 'medicamentos'], 27)

window.ocuPop = new PopUp('crud-insertar-ocupaciones-popup','popup', 'subefecto', true, 'insertar-ocupaciones', '', 27)
window.proPop = new PopUp('crud-insertar-proveniencias-popup','popup', 'subefecto', true, 'insertar-proveniencias', '', 27)
window.parPop = new PopUp('crud-insertar-parentescos-popup','popup', 'subefecto', true, 'insertar-parentescos', '', 27)
window.civPop = new PopUp('crud-insertar-estado_civil-popup','popup', 'subefecto', true, 'insertar-estado_civil', '', 27)
window.relPop = new PopUp('crud-insertar-religiones-popup','popup', 'subefecto', true, 'insertar-religiones', '', 27)
window.medPop = new PopUp('crud-insertar-medicos-popup','popup', 'subefecto', true, 'insertar-medicos', '', 27)

window.prePop = new PopUp('crud-previas-popup', 'popup', 'subefecto', true, 'previas', '', 27)
window.repPop = new PopUp('crud-reportes-popup', 'popup', 'subefecto', true, 'reportes', ['previas', 'coneditar', 'geneditar', 'infeditar', 'preeditar', 'repeditar', 'refeditar', 'insertar-referencia', 'insertar-referido', 'insertar-diagnostico'], 27)

window.conPop = new PopUp('crud-coneditar-popup', 'popup', 'subefecto', true, 'coneditar', '', 27)
window.genPop = new PopUp('crud-geneditar-popup', 'popup', 'subefecto', true, 'geneditar', '', 27);
window.forPop = new PopUp('crud-infeditar-popup', 'popup', 'subefecto', true, 'infeditar', '', 27);
window.presPop = new PopUp('crud-preeditar-popup', 'popup', 'subefecto', true, 'preeditar', '', 27);
window.repoPop = new PopUp('crud-repeditar-popup', 'popup', 'subefecto', true, 'repeditar', '', 27);
window.refPop = new PopUp('crud-refeditar-popup', 'popup', 'subefecto', true, 'refeditar', '', 27);

window.traPop = new PopUp('crud-tratamientos-popup', 'popup', 'subefecto', true, 'tratamientos', '', 27)
window.presenPop = new PopUp('crud-presentaciones-popup', 'popup', 'subefecto', true, 'presentaciones', '', 27);
window.mediPop = new PopUp('crud-medicamentos-popup', 'popup', 'subefecto', true, 'medicamentos', '', 27)

window.refInsPop = new PopUp('crud-insertar-referencia-popup', 'popup', 'subefecto', true, 'insertar-referencia', '', 27);
window.refeInsPop = new PopUp('crud-insertar-referido-popup', 'popup', 'subefecto', true, 'insertar-referido', '', 27)

window.diaPop = new PopUp('crud-insertar-diagnostico-popup', 'popup', 'subefecto', true, 'insertar-diagnostico', '', 27)

ediPop.evtBotones()
insPop.evtBotones()
infPop.evtBotones()
notPop.evtBotones()
recPop.evtBotones()

ocuPop.evtBotones()
proPop.evtBotones()
parPop.evtBotones()
civPop.evtBotones()
relPop.evtBotones()
medPop.evtBotones()

prePop.evtBotones()
repPop.evtBotones()

conPop.evtBotones()
genPop.evtBotones()
forPop.evtBotones()
presPop.evtBotones()
repoPop.evtBotones()
refPop.evtBotones()

traPop.evtBotones()
presenPop.evtBotones()
mediPop.evtBotones()

refInsPop.evtBotones()
refeInsPop.evtBotones()

diaPop.evtBotones()

window.addEventListener('keyup', (e) => {

	ediPop.evtEscape(e)
	insPop.evtEscape(e)
	infPop.evtEscape(e)
	notPop.evtEscape(e)
	recPop.evtEscape(e)

	ocuPop.evtEscape(e)
	proPop.evtEscape(e)
	parPop.evtEscape(e)
	civPop.evtEscape(e)
	relPop.evtEscape(e)
	medPop.evtEscape(e)
	
	prePop.evtEscape(e)
	repPop.evtEscape(e)

	conPop.evtEscape(e)
	genPop.evtEscape(e)
	forPop.evtEscape(e)
	presPop.evtEscape(e)
	repoPop.evtEscape(e)
	refPop.evtEscape(e)

	traPop.evtEscape(e)
	presenPop.evtEscape(e)
	mediPop.evtEscape(e)

	refInsPop.evtEscape(e)
	refeInsPop.evtEscape(e)

	diaPop.evtEscape(e)

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
const botonesReportesPaginacion = new ARPropiedades({"data-estilo": "focus-2"})
///////////////////////////////////////////////////////
//ANIMACIONES
////////////////////////////////////////////////////
window.animaciones = new Animaciones({on: 'abrir', off: 'cerrar'}, ['click', 'mouseleave'])
window.animaciones.hider = 'data-hidden'

/////////////////////////////////////////////////////
//GENERA LOS COMPORTAMIENTOS BÁSICOS DE LOS POPUPS
/////////////////////////////////////////////////////
window.contenedores = new ContenedoresEspeciales('historias-status')

window.contenedoresConsultar      = new ContenedoresEspeciales('crud-informacion-popup') 
window.contenedoresEditar         = new ContenedoresEspeciales('crud-editar-popup') 
window.contenedoresInsertar       = new ContenedoresEspeciales('crud-insertar-popup')
window.contenedoresReportes       = new ContenedoresEspeciales('crud-reportes-popup')
window.contenedoresInformeEditar  = new ContenedoresEspeciales('crud-infeditar-popup')
window.contenedoresMedicamentos   = new ContenedoresEspeciales('crud-medicamentos-popup')
window.contenedoresNotificaciones = new ContenedoresEspeciales('crud-notificaciones-popup')

/////////////////////////////////////////////////////
//VARIABLES GLOBALES
/////////////////////////////////////////////////////
window.procesar = true
window.idSeleccionada = 0

export var 
	prevenirCierrePop = false,
	permitirLimpiezaReportes = true,
	ultimoBotonInsersionBasica = '',
	reporteSeleccionado = 'constancia'

window.reporteModeloSeleccionado = {}
window.prevenirCierreReporte = false
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
/////////////////////////////////////////////////////
window.atajoReportes = new Atajos('Shift', [
	{"elemento": '#crud-reportes-popup',"ejecuta": '1', "clean": true, "tarea": () => {
		cambiarSeccionBotones(qs('#constancia'))
		window.paginacion.animacion(0, true)
	}},
	{"elemento": '#crud-reportes-popup',"ejecuta": '2', "clean": true, "tarea": () => {
		cambiarSeccionBotones(qs('#informe'))
		window.paginacion.animacion(1, true)
	}},
	{"elemento": '#crud-reportes-popup',"ejecuta": '3', "clean": true, "tarea": () => {
		cambiarSeccionBotones(qs('#presupuesto'))
		window.paginacion.animacion(2, true)
	}},
	{"elemento": '#crud-reportes-popup',"ejecuta": '4', "clean": true, "tarea": () => {
		cambiarSeccionBotones(qs('#reposo'))
		window.paginacion.animacion(3, true)
	}},
	{"elemento": '#crud-reportes-popup',"ejecuta": '5', "clean": true, "tarea": () => {
		cambiarSeccionBotones(qs('#general'))
		window.paginacion.animacion(4, true)
	}}
])

window.atajoReportes.eventos()
/////////////////////////////////////////////////////
//REVISA QUE LA PÁGINA YA CARGO POR COMPLETO PARA QUITAR LA ANIMACIÓN DE CARGA
/////////////////////////////////////////////////////
window.cargar = new paginaCargada('#tabla-historias thead .ASC', 'existencia')
window.cargar.revision()

// window.cargarInforme = new paginaCargada('#informe-combo', 'longitud', 'cargar-informes')
// window.cargarInforme.revision()
/////////////////////////////////////////////////////
//DATOS DE REFERENCIAS Y REFERIDOS
/////////////////////////////////////////////////////
window.lista_referencias = JSON.parse(await tools.fullAsyncQuery(`referencias`, `traer_referencias`, []))
window.lista_referidos = JSON.parse(await tools.fullAsyncQuery(`referidos`, `traer_referidos`, []))
/////////////////////////////////////////////////////
window.rellenar = new Rellenar()
window.reportes = new Reportes()
/////////////////////////////////////////////////////
var sesiones = await window.sesiones(true)
export var usuario = sesiones.usuario
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
		this.contenedorEliminarBoton = qs('#eliminar-template').content.querySelector('.eliminar-contenedor').cloneNode(true)
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

		this.crud.botonForzar(true)

	}

	limpieza() {

		tools.limpiar('.constancia-valores', '', {})
		tools.limpiar('.general-valores', '', {})
		tools.limpiar('.informe-valores', '', {})
		tools.limpiar('.presupuesto-valores', '', {})
		tools.limpiar('.referencia-valores', '', {})
		tools.limpiar('.reposo-valores', '', {
			"procesado": e => {
				gid('reposos-inicio-insertar').value = window.dia
			}
		})

		constancias.cargarTabla([], undefined, undefined)
		generales.cargarTabla([], undefined, undefined)
		informes.cargarTabla([], undefined, undefined)
		presupuestos.cargarTabla([], undefined, undefined)
		reposos.cargarTabla([], undefined, undefined)
		referencias.cargarTabla([], undefined, undefined)

		rellenar.contenedores(this.sublista, '.presupuesto-representante-valores', {}, {})

		
		gid('reposos-fecha-insertar').innerHTML = ''
		setTimeout(() => {
			qs('#reposo-contenedor-izquierda').scrollTo(0,0)
			qs('#informe-contenedor-izquierda').scrollTo(0,0)
		}, 1000)

		gid('constancia-busqueda').value = ''
		gid('general-busqueda').value = ''
		gid('informe-busqueda').value = ''
		gid('presupuesto-busqueda').value = ''
		gid('reposo-busqueda').value = ''
		gid('referencia-busqueda').value = ''

	}

	async traer_lista() {
		
		var lista = JSON.parse(await tools.fullAsyncQuery(`historias_${reporteSeleccionado}`, `${reporteSeleccionado}_consultar`, [historias.sublista.id_historia]))
		reportesDisponibles[reporteSeleccionado].cargarTabla(lista, undefined, undefined)

	}

}
/////////////////////////////////////////////////////
/////////////////////////////////////////////////////
export var historias = new Historias(new Tabla(
	[
		['Acciones', false, 0],
		['N°. Historia', true, 0],
		['Paciente', true, 22],
		['N° de cédula', true, 9],
		['N° de hijo', true, 25],
		['Status', true, 21]
	],
	'tabla-historias', 'busqueda', Number(sesiones.modo_filas), 'izquierda', 'derecha', 'numeracion', true
))

/////////////////////////////////////////////////////
/////////////////////////////////////////////////////
historias['crud'].cuerpo.push([historias['crud'].columna = historias['crud'].cuerpo.length, [
		historias['crud'].gBt(['informacion btn btn-informacion', 'Información del paciente'], `<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="info" class="iconos-b" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 192 512"><path fill="currentColor" d="M20 424.229h20V279.771H20c-11.046 0-20-8.954-20-20V212c0-11.046 8.954-20 20-20h112c11.046 0 20 8.954 20 20v212.229h20c11.046 0 20 8.954 20 20V492c0 11.046-8.954 20-20 20H20c-11.046 0-20-8.954-20-20v-47.771c0-11.046 8.954-20 20-20zM96 0C56.235 0 24 32.235 24 72s32.235 72 72 72 72-32.235 72-72S135.764 0 96 0z"></path></svg>`),
		historias['crud'].gBt(['editar btn btn-editar', 'Editar historia'], `<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="pencil-alt" class="svg-inline--fa fa-pencil-alt fa-w-16 iconos-b" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M497.9 142.1l-46.1 46.1c-4.7 4.7-12.3 4.7-17 0l-111-111c-4.7-4.7-4.7-12.3 0-17l46.1-46.1c18.7-18.7 49.1-18.7 67.9 0l60.1 60.1c18.8 18.7 18.8 49.1 0 67.9zM284.2 99.8L21.6 362.4.4 483.9c-2.9 16.4 11.4 30.6 27.8 27.8l121.5-21.3 262.6-262.6c4.7-4.7 4.7-12.3 0-17l-111-111c-4.8-4.7-12.4-4.7-17.1 0zM124.1 339.9c-5.5-5.5-5.5-14.3 0-19.8l154-154c5.5-5.5 14.3-5.5 19.8 0s5.5 14.3 0 19.8l-154 154c-5.5 5.5-14.3 5.5-19.8 0zM88 424h48v36.3l-64.5 11.3-31.1-31.1L51.7 376H88v48z"></path></svg>`),
		historias['crud'].gBt(['reportes btn btn-imprimir', 'Generar reportes del paciente'], `<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512" class="iconos-b"><path fill="currentColor" d="M128 0C92.7 0 64 28.7 64 64v96h64V64H354.7L384 93.3V160h64V93.3c0-17-6.7-33.3-18.7-45.3L400 18.7C388 6.7 371.7 0 354.7 0H128zM384 352v32 64H128V384 368 352H384zm64 32h32c17.7 0 32-14.3 32-32V256c0-35.3-28.7-64-64-64H64c-35.3 0-64 28.7-64 64v96c0 17.7 14.3 32 32 32H64v64c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V384zM432 248a24 24 0 1 1 0 48 24 24 0 1 1 0-48z"/></svg>`),
		historias['crud'].gBt(['recipes btn btn-imprimir', 'Generar y consultar recipes del paciente'], `<svg class="iconos-b" preserveAspectRatio="none" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path class="gradiante-bg-general" fill="currentColor" d="M288 130.54V112h16c8.84 0 16-7.16 16-16V80c0-8.84-7.16-16-16-16h-96c-8.84 0-16 7.16-16 16v16c0 8.84 7.16 16 16 16h16v18.54C115.49 146.11 32 239.18 32 352h448c0-112.82-83.49-205.89-192-221.46zM496 384H16c-8.84 0-16 7.16-16 16v32c0 8.84 7.16 16 16 16h480c8.84 0 16-7.16 16-16v-32c0-8.84-7.16-16-16-16z"></path></svg>`)
	], [0, 0, 0, 0], ['VALUE', 'VALUE', 'VALUE', 'VALUE'], 'crud-botones', false
])

historias['crud'].generarColumnas(['gSpan', null, null], [false],['HTML'], '', 0)
historias['crud'].generarColumnas(['gSpan', null, null], [false],['HTML'], '', 22)
historias['crud'].generarColumnas(['gSpan', null, null], [false],['HTML'], '', 9)
historias['crud'].generarColumnas(['gSpan', null, null], [false],['HTML'], '', 25)
historias['crud'].generarColumnas(['gSpan', null, null], [false],['HTML'], '', 21)
/////////////////////////////////////////////////////
/////////////////////////////////////////////////////
historias['crud']['retornarSiempre'] = true
historias['crud']['limitante'] = 1
historias['crud']['clase'] = 'historias'
historias['crud']['funcion'] = 'buscar_historias'
historias['crud']['autoBusqueda'] = true
historias['crud']['inputNavegarGenerar'] = false
/////////////////////////////////////////////////////
/////////////////////////////////////////////////////
historias['crud'].botonModoBusqueda("#modo-buscar", 1, [
	['id_historia', 'id_correlativo'],
	['id_historia', 'id_correlativo','nombre_completo', 'cedula']
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
historias['crud']['propiedadesTr'] = {
	"informacion": (e) => {
		var fr = new DocumentFragment(), th = historias
		var div = th.div.cloneNode(true);

		var fecha = (e.sublista.fecha_consulta === '1900-01-01') ? '---' :  e.sublista.fecha_consulta_arreglada;

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
			window.paginacionHistorias.actualizarFamiliaDeBotones(tools.pariente(e.target, 'TR'))
			window.paginacionHistorias.cambiarUltimoSeleccionado(e.target.classList[0])
		}
	},
	/* -------------------------------------------------------------------------------------------------*/
	/*           					ENVIAR LOS DATOS PARA CONSULTAR LA HISTORIA   					    */
	/* -------------------------------------------------------------------------------------------------*/
	"informacion": async (e) => {

		var button

		if (tools.esDOM(e)) {

			button = e

		} else {

			button = e.target
			permitirLimpiezaReportes = true

		}

		if (button.classList.contains('informacion')) {

			botonesReportesPaginacion.ejecutar('#paginacion-contenedores .informacion')

			historias.tr = tools.pariente(button, 'TR')
			historias.sublista = historias.tr.sublista

			if (permitirLimpiezaReportes) {
				historias.limpieza()
				permitirLimpiezaReportes = true
			}

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
			permitirLimpiezaReportes = true

		}

		if (button.classList.contains('editar')) {

			botonesReportesPaginacion.ejecutar('#paginacion-contenedores .editar')

			historias.tr = tools.pariente(button, 'TR')
			historias.sublista = historias.tr.sublista

			if (permitirLimpiezaReportes) {
				historias.limpieza()
				permitirLimpiezaReportes = true
			}

			tools.limpiar('.editar-valores', '', {})
			tools.limpiar('.editar-cargar', '', {})

			rellenar.contenedores(historias.sublista, '.editar-cargar', {elemento: button, id: 'value'}, {})
			rellenar.contenedores(historias.sublista, '.editar-valores', {elemento: button, id: 'value'}, {
				"contenedorConsulta": function fn(lista, elemento) {
					
					contenedoresEditar.estandarizarContenedor(elemento, lista, [0])
					
				},
				"procesado": function fn() {

					qs('#editar-edad').value = tools.calcularFecha(new Date(qs('#editar-fecha').value))
					qs('[data-grupo=cc-ocupaciones-editar] input').value = ''
				
				}
			})

			setTimeout(() => {
				
				document.querySelector('#editar-enfocar').focus()

			}, 100)

			ediPop.pop()

		}

	},
	"reportes": async (e) => {

		var button = (tools.esDOM(e)) ? e : e.target; 

		if (button.classList.contains('reportes')) {

			historias.tr = tools.pariente(button, 'TR')
			historias.sublista = historias.tr.sublista

			if (permitirLimpiezaReportes) {

				if (!prevenirCierreReporte) {
					historias.limpieza()
				}
				permitirLimpiezaReportes = true
			}
	
			botonesReportesPaginacion.ejecutar('#paginacion-contenedores .reportes')

			rellenar.contenedores(historias.sublista, '.constancia-cargar', {elemento: button, id: 'value'})
			
			setTimeout(() => {document.querySelector('#constancia-informacion').focus()}, 100)

			rellenar.contenedores(historias.sublista, '.reportes-cargar', {elemento: button, id: 'value'})

			await historias.traer_lista()

			if (!prevenirCierreReporte) {
				
				repPop.pop()

			} 

			prevenirCierreReporte = false

		}

	},
	/* -------------------------------------------------------------------------------------------------*/
	/*           							RECIPES & INDICACIONES									    */
	/* -------------------------------------------------------------------------------------------------*/
	"recipes": async (e) => {

		var button

		if (tools.esDOM(e)) {

			button = e

		} else {

			button = e.target
			permitirLimpiezaReportes = true

		}

		if (button.classList.contains('recipes')) {

			botonesReportesPaginacion.ejecutar('#paginacion-contenedores .recipes')

			historias.tr = tools.pariente(button, 'TR')
			historias.sublista = historias.tr.sublista

			if (permitirLimpiezaReportes) {
				historias.limpieza()
				permitirLimpiezaReportes = true
			}

			// medicamentos['crud'].lista = tools.copiaLista(window.medicamentos['crud'].resetLista)
			// medicamentos['crud'].checkLista = []
			// medicamentos['crud'].generarCabecera();
			// medicamentos.cargarTabla(window.medicamentos['crud'].lista)

			await medicamentos.traerMedicamentos()

			rellenar.contenedores(historias.sublista, '.recipes-cargar', {elemento: button, id: 'value'}, {})

			await recipes.traerRecipes(historias.sublista.id_historia)

			//var resultado = await tools.fullAsyncQuery('historias_recipes', 'cargar_recipes', [historias.sublista.id_historia])
			//recipes.cargarTabla(JSON.parse(resultado))

			recPop.pop()

		}

	},
};

(async () => {
	var resultado = await tools.fullAsyncQuery('historias', 'cargar_historias', [])
	historias.cargarTabla(JSON.parse(resultado), undefined, undefined)
	window.historias = historias
})()

historias['crud'].botonBuscar('buscar', false)

//3)---------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------
//								EVENTOS RELACIONADOS A LA HISTORIA                                              
//----------------------------------------------------------------------------------------------------
var comboDiagnosticos = JSON.parse(await tools.fullAsyncQuery('combos', 'combo_diagnosticos', [])),
	comboOcupacion    = JSON.parse(await tools.fullAsyncQuery('combos', 'combo_ocupaciones', [])),
	comboProveniencia = JSON.parse(await tools.fullAsyncQuery('combos', 'combo_proveniencias', [])),
	comboParentesco   = JSON.parse(await tools.fullAsyncQuery('combos', 'combo_parentescos', [])),
	comboCivil        = JSON.parse(await tools.fullAsyncQuery('combos', 'combo_estado_civil', [])),
	comboReligion     = JSON.parse(await tools.fullAsyncQuery('combos', 'combo_religiones', [])),
	comboMedico       = JSON.parse(await tools.fullAsyncQuery('combos', 'combo_medicos', [])),
	comboReferencia         = JSON.parse(await tools.fullAsyncQuery('combos', 'combo_referencias', [])),
	comboMedicoReferido = JSON.parse(await tools.fullAsyncQuery('combos', 'combo_medicos_referidos', []))

contenedores.eventos().checkboxes('status')

contenedoresConsultar.eventos().combo('cc-ocupaciones-consultar', ['combos', 'combo_ocupaciones', ['', '']], false, {}, undefined, undefined, {"lista": comboOcupacion, "seleccionarGenerado": true})
contenedoresInsertar.eventos().combo('cc-ocupaciones-insertar', ['combos', 'combo_ocupaciones', ['', '']], false, {}, undefined, undefined, {"lista": comboOcupacion, "seleccionarGenerado": true, "navegacionVertical": true})
contenedoresEditar.eventos().combo('cc-ocupaciones-editar', ['combos', 'combo_ocupaciones', ['', '']], false, {}, undefined, undefined, {"lista": comboOcupacion, "seleccionarGenerado": true, "navegacionVertical": true})

contenedoresConsultar.eventos().combo('cc-parentescos-consultar', ['combos', 'combo_parentescos', ['', '']], false, {}, undefined, undefined, {"lista": comboParentesco, "seleccionarGenerado": true})
contenedoresInsertar.eventos().combo('cc-parentescos-insertar', ['combos', 'combo_parentescos', ['', '']], false, {}, undefined, undefined, {"lista": comboParentesco, "seleccionarGenerado": true, "navegacionVertical": true})
contenedoresEditar.eventos().combo('cc-parentescos-editar', ['combos', 'combo_parentescos', ['', '']], false, {}, undefined, undefined, {"lista": comboParentesco, "seleccionarGenerado": true, "navegacionVertical": true})

contenedoresConsultar.eventos().combo('cc-proveniencias-consultar', ['combos', 'combo_proveniencias', ['', '']], false, {}, undefined, undefined, {"lista": comboProveniencia, "seleccionarGenerado": true})
contenedoresInsertar.eventos().combo('cc-proveniencias-insertar', ['combos', 'combo_proveniencias', ['', '']], false, {}, undefined, undefined, {"lista": comboProveniencia, "seleccionarGenerado": true, "navegacionVertical": true})
contenedoresEditar.eventos().combo('cc-proveniencias-editar', ['combos', 'combo_proveniencias', ['', '']], false, {}, undefined, undefined, {"lista": comboProveniencia, "seleccionarGenerado": true, "navegacionVertical": true})

contenedoresConsultar.eventos().combo('cc-estado_civil-consultar', ['combos', 'combo_estado_civil', ['', '']], false, {}, undefined, undefined, {"lista": comboCivil, "seleccionarGenerado": true})
contenedoresInsertar.eventos().combo('cc-estado_civil-insertar', ['combos', 'combo_estado_civil', ['', '']], false, {}, undefined, undefined, {"lista": comboCivil, "seleccionarGenerado": true, "navegacionVertical": true})
contenedoresEditar.eventos().combo('cc-estado_civil-editar', ['combos', 'combo_estado_civil', ['', '']], false, {}, undefined, undefined, {"lista": comboCivil, "seleccionarGenerado": true, "navegacionVertical": true})

contenedoresReportes.eventos().combo('cc-referencias-referencia-insertar', ['combos', 'combo_referencias', ['', '']], false, {}, undefined, undefined, {"lista": comboReferencia, "seleccionarGenerado": true, "navegacionVertical": true})
contenedoresReportes.eventos().combo('cc-referencias-referencia-editar', ['combos', 'combo_referencias', ['', '']], false, {}, undefined, undefined, {"lista": comboReferencia, "seleccionarGenerado": true, "navegacionVertical": true})

contenedoresReportes.eventos().combo('cc-referencias-referido-insertar', ['combos', 'combo_referencias', ['', '']], false, {}, undefined, undefined, {"lista": comboMedicoReferido, "seleccionarGenerado": true, "navegacionVertical": true})
contenedoresReportes.eventos().combo('cc-referencias-referido-editar', ['combos', 'combo_referencias', ['', '']], false, {}, undefined, undefined, {"lista": comboMedicoReferido, "seleccionarGenerado": true, "navegacionVertical": true})

contenedoresNotificaciones.eventos().combo('cc-referencias-referencia-notificaciones', ['combos', 'combo_referencias', ['', '']], false, {}, undefined, undefined, {"lista": comboReferencia, "seleccionarGenerado": true, "navegacionVertical": true})
contenedoresNotificaciones.eventos().combo('cc-referencias-referido-notificaciones', ['combos', 'combo_referencias', ['', '']], false, {}, undefined, undefined, {"lista": comboMedicoReferido, "seleccionarGenerado": true, "navegacionVertical": true})

contenedoresConsultar.eventos().combo('cc-religiones-consultar', ['combos', 'combo_religiones', ['', '']], false, {}, undefined, undefined, {"lista": comboReligion, "seleccionarGenerado": true})
contenedoresInsertar.eventos().combo('cc-religiones-insertar', ['combos', 'combo_religiones', ['', '']], false, {}, undefined, undefined, {"lista": comboReligion, "seleccionarGenerado": true, "navegacionVertical": true})
contenedoresEditar.eventos().combo('cc-religiones-editar', ['combos', 'combo_religiones', ['', '']], false, {}, undefined, undefined, {"lista": comboReligion, "seleccionarGenerado": true, "navegacionVertical": true})

contenedoresConsultar.eventos().combo('cc-medicos-consultar', ['combos', 'combo_medicos', ['', '']], false, {}, undefined, undefined, {"lista": comboMedico, "seleccionarGenerado": true})
contenedoresInsertar.eventos().combo('cc-medicos-insertar', ['combos', 'combo_medicos', ['', '']], false, {}, undefined, undefined, {"lista": comboMedico, "seleccionarGenerado": true, "navegacionVertical": true})
contenedoresEditar.eventos().combo('cc-medicos-editar', ['combos', 'combo_medicos', ['', '']], false, {}, undefined, undefined, {"lista": comboMedico, "seleccionarGenerado": true, "navegacionVertical": true})

contenedoresEditar.eventos().contenedor(
	'cc-telefonos-editar', //elemento
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
	'cc-otros-insertar', //elemento
	['', '', ['', '']],    //informacion de la petición
	[0, 1], 			   //limitador de busqueda
	[false, true, [false, false], false, true, false, false, false, [false, true], false, false], //comportamientos extras
	{} //funciones
)

contenedoresMedicamentos.eventos().contenedor(
	'cc-medicamentos-genericos', //elemento
	['combos', 'combo_genericos', ['', 80]],    //informacion de la petición
	[0, 2], 			   //limitador de busqueda
	[true, true, [false, false], true, false, true, true, true, [true, false], false, false], //comportamientos extras
	{} //funciones
)

contenedoresReportes.eventos().contenedor(
	'cc-diagnosticos-informes', //elemento
	['combos', 'combo_diagnosticos', ['', '']],    //informacion de la petición
	[0, 0], 			   //limitador de busqueda
	[false, true, [false, false], true, true, false, true, true, [true, true], false, true], //comportamientos extras
	{"lista": comboDiagnosticos} //funciones
)

contenedoresInformeEditar.eventos().contenedor(
	'cc-diagnosticos-infeditar', //elemento
	['combos', 'combo_diagnosticos', ['', '']],    //informacion de la petición
	[0, 0], 			   //limitador de busqueda
	[false, true, [false, false], true, true, false, true, true, [true, true], false, true], //comportamientos extras
	{"lista": comboDiagnosticos} //funciones
)

contenedoresNotificaciones.eventos().contenedor(
	'cc-diagnosticos-informe-notificaciones', //elemento
	['combos', 'combo_diagnosticos', ['', '']],    //informacion de la petición
	[0, 0], 			   //limitador de busqueda
	[false, true, [false, false], true, true, false, true, true, [true, true], false, true], //comportamientos extras
	{"lista": comboDiagnosticos} //funciones
)

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

			if (datos !== '') {
				
				notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'PROCESANDO')

				var resultado = await tools.fullAsyncQuery('historias', 'editar_historia', datos)

				if (resultado.trim() === 'exito') {

					historias.tr.sublista = JSON.parse(await tools.fullAsyncQuery('historias', 'traer_historia', [historias.sublista.id_historia]))

					historias.confirmarActualizacion()

					if (datos[14] === 'D') {

						ediPop.pop()

					}
				
				} else if (resultado.trim() === 'repetido') {

					notificaciones.mensajeSimple('Un paciente con esta cédula y N° de hijo ya existe', resultado, 'F') 

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

	if (e.target.classList.contains('insertar') || e.target.classList.contains('permanecer')) {

		var datos = tools.procesar('', '', 'insertar-valores', tools)

		if (datos !== '') {

			notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'PROCESANDO')

			var resultado = await tools.fullAsyncQuery('historias', 'insertar_historia', datos)

			if (resultado.trim() === 'exito') {

				if (e.target.classList.contains('insertar')) {

					historias.confirmarActualizacion(insPop)

				} else {

					historias.confirmarActualizacion()
					tools.limpiar('.insertar-valores', '', {})
					tools.limpiar('.insertar-cajones', '', {})
					
					qs('#insertar-edad').value = ''

				}

			
			} else if (resultado.trim() === 'repetido') {

				notificaciones.mensajeSimple('Un paciente con esta cédula y N° de hijo ya existe', resultado, 'F')

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
	
	tools.limpiar('.insertar-cajones', '', {})
	tools.limpiar('.insertar-valores', '', {})
	
	window.idSeleccionada = 0
	insPop.pop()
})

/* -------------------------------------------------------------------------------------------------*/
/*   		Evento que limpia los datos del contenedor de insertar*            		    
/* -------------------------------------------------------------------------------------------------*/
qs('#crud-insertar-limpiar').addEventListener('click', e => {
	tools.limpiar('.insertar-valores', '', {
		"procesado": e => {
			notificaciones.mensajeSimple('Datos limpiados', false, 'V')
		},
		"asegurar": () => {return '#crud-insertar-pop'}
	})
})

//-------------------------------------------------------------------------------
//botones que insertan datos básicos desde la edición o insersión de una historia
//-------------------------------------------------------------------------------

var insersiones_lista  = ['ocupaciones', 'proveniencias', 'parentescos', 'estado_civil', 'religiones', 'medicos'],
	insersiones_lista_combos = [ocuPop, proPop, parPop, civPop, relPop, medPop];

insersiones_lista.forEach((grupo, i) => {

	qs(`#editar-nueva-${grupo}`).addEventListener('click', e => {
		ultimoBotonInsersionBasica = e.target
		tools.limpiar(`.nuevas-${grupo}`, '', {})
		insersiones_lista_combos[i].pop()
	})

	qs(`#insertar-nueva-${grupo}`).addEventListener('click', e => {
		ultimoBotonInsersionBasica = e.target
		tools.limpiar(`.nuevas-${grupo}`, '', {})
		insersiones_lista_combos[i].pop()
	})

	qs(`#crud-insertar-${grupo}-botones`).addEventListener('click', async e => {

		if (e.target.classList.contains('insertar')) {

			var datos = tools.procesar(e.target, 'insertar', `nuevas-${grupo}`,  tools)

			if (datos !== '') {

				if (grupo === 'medicos') {
					datos.splice(2,1)
				} else {
					datos.splice(1,1)
				}

				var resultado = await tools.fullAsyncQuery(grupo, `crear_${grupo}`, datos)

				if(resultado.trim() === 'exito') {

					notificaciones.mensajeSimple(`Información insertada con éxito`, resultado, 'V')

					setTimeout(async () => {

						var lista = JSON.parse(await tools.fullAsyncQuery('combos', `combo_${grupo}`, []))

						ultimoBotonInsersionBasica.parentElement.parentElement.querySelector('input').value = qs(`#nombre-${grupo}`).value.toUpperCase()
						ultimoBotonInsersionBasica.parentElement.parentElement.querySelector('input').focus()

						qs(`#nombre-${grupo}`).value = ''

						insersiones_lista_combos[i].pop()

						contenedoresEditar.reconstruirCombo(qs(`[data-grupo="cc-${insersiones_lista[i]}-editar"] select`), qs(`[data-grupo="cc-${insersiones_lista[i]}-editar"] input`), lista)
						contenedoresEditar.filtrarComboForzado(qs(`[data-grupo="cc-${insersiones_lista[i]}-editar"] select`), qs(`[data-grupo="cc-${insersiones_lista[i]}-editar"] input`))

						contenedoresInsertar.reconstruirCombo(qs(`[data-grupo="cc-${insersiones_lista[i]}-insertar"] select`), qs(`[data-grupo="cc-${insersiones_lista[i]}-insertar"] input`), lista)
						contenedoresInsertar.filtrarComboForzado(qs(`[data-grupo="cc-${insersiones_lista[i]}-insertar"] select`), qs(`[data-grupo="cc-${insersiones_lista[i]}-insertar"] input`))

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

/* -------------------------------------------------------------------------------------------------*/
/* ------------------------------PAGINACIÓN ENTRE CONTENEDORES--------------------------------------*/
/* -------------------------------------------------------------------------------------------------*/
qs('#paginacion-contenedores').addEventListener('click', e => {

	if (e.target.tagName === 'BUTTON') {

		permitirLimpiezaReportes = false

		botonesReportesPaginacion.ejecutar(e.target)
		window.paginacionHistorias.cambiarContenedor(e.target.classList[0])

	}

})

//6)---------------------------------------------------------------------------------------------------
/* --------------------------------------ATAJOS DE BUSQUEDA----------------------------------------*/
/* -------------------------------------------------------------------------------------------------*/
qs('#busqueda').addEventListener('keydown', e => {

	if (e.target.value !== '' && e.keyCode === 13) {

		if (historias.crud.busqueda.length > 0) {

			botonesReportesPaginacion.ejecutar('#paginacion-contenedores .informacion')
			window.paginacionHistorias.cambiarUltimoSeleccionado('informacion')
			window.paginacionHistorias.actualizarFamiliaDeBotones(tools.pariente(qs('#tabla-historias tbody tr .informacion'), 'TR'))
			window.paginacionHistorias.cambiarContenedor('informacion')
		
		} else {

			tools.limpiar('.insertar-valores', '', {}); 

			if (!isNaN(e.target.value)) {
				qs('#insertar-enfocar').value = e.target.value
			}

			setTimeout(() => {qs('#insertar-enfocar').focus()}, 100)
			
			insPop.pop()

		}

	}

})

/* -------------------------------------------------------------------------------------------------*/
/* --------------------------------- IMPRESION FINAL GENERAL ---------------------------------------*/
/* -------------------------------------------------------------------------------------------------*/
qs('#crud-previas-botones .imprimir').addEventListener('click', e => {
	
	window.reportes.imprimirPDF(`../plantillas/${reporteSeleccionado}pdf.php?&pdf=2`, {})

	setTimeout(() => {
		prePop.pop()
	}, 1000)

})

/* -------------------------------------------------------------------------------------------------*/
/* -----------------------------------PAGINACIÓN DE REPORTES----------------------------------------*/
/* -------------------------------------------------------------------------------------------------*/
window.paginacion = new Paginacion(
	{"contenedores": ".reportes-seccion" ,"familia": '[data-familia]', "efecto": ['aparecer', 'aparecer'], "delay": 100},
	[
		{},
		{}
	]
)

window.paginacion.subefectos = true //por defecto true es solo para acordarme de la opcion

qsa('#reportes-paginacion-botones button').forEach((e, i) => {
	e.addEventListener('click', (boton) => {

		window.paginacion.animacion(i, true)
		qs('#crud-reportes-cabecera .cabecera').innerHTML = boton.target.innerHTML.toUpperCase()

	})
})

//7)---------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------
//										OBJETOS DE LOS REPORTES                                        
//----------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------
//----------------------------------------------------------------------------------------------------
class Constancias extends Acciones {

	constructor(crud) {
		super(crud)
		this.fila
		this.clase   = 'principales'
		this.funcion = 'constancia_consultar'
		//-------------------------------
		this.alternar = [true, 'white', 'whitesmoke']
		this.especificos = ['fecha_arreglada']
		this.limitante = 0
		this.boton = ''
		this.sublista = {}
		//-------------------------------
		this.div = document.createElement('div')
		this.contenido = qs('#constancia-template').content.querySelector('.constancia-crud').cloneNode(true)
		this.contenidoFecha = qs('#template-fecha').content.querySelector('.template-fecha-contenedor').cloneNode(true)
	}

	async confirmarActualizacion(popUp) {

		notificaciones.mensajeSimple('Petición realiza con éxito', false, 'V')

		var resultado = JSON.parse(await tools.fullAsyncQuery(this.clase, this.funcion, []))

		this.cargarTabla(resultado, true)

	}

	validarRepresentante() {
		var validar = true

		if (historias.sublista.emergencia_persona.trim() === '') {

			validar = false

		}

		if (historias.sublista.emergencia_informacion.trim() === '') {

			validar = false

		}

		if (validar == false) {

			qs('#constancia-menor').checked = false
			notificaciones.mensajeSimple('Falta información en la historia: [NOMBRE DE REPRESENTANTE, CÉDULA DE REPRESENTANTE]', null, 'F')

		}
	}

}

export var constancias = new Constancias(new Tabla(
	[	
		['', false, 0],
		['', false, 0]
	],
	'tabla-constancia', 'constancia-busqueda', -1, 'null', 'null', 'null', true
))

/////////////////////////////////////////////////////
/////////////////////////////////////////////////////

class Generales extends Acciones {

	constructor(crud) {
		super(crud)
		this.fila
		this.clase   = 'principales'
		this.funcion = 'general_consultar'
		//-------------------------------
		this.alternar = [true, 'white', 'whitesmoke']
		this.especificos = ['fecha_arreglada']
		this.limitante = 0
		this.boton = ''
		this.sublista = {}
		//-------------------------------
		this.div = document.createElement('div')
		this.contenido = qs('#general-template').content.querySelector('.general-crud').cloneNode(true)
		this.contenidoFecha = qs('#template-fecha').content.querySelector('.template-fecha-contenedor').cloneNode(true)
	}

	async confirmarActualizacion(popUp) {

		notificaciones.mensajeSimple('Petición realiza con éxito', false, 'V')

		var resultado = JSON.parse(await tools.fullAsyncQuery(this.clase, this.funcion, []))

		this.cargarTabla(resultado, true)

	}

}

export var generales = new Generales(new Tabla(
	[	
		['', false, 0],
		['', false, 0]
	],
	'tabla-general', 'general-busqueda', -1, 'null', 'null', 'null', true
))

/////////////////////////////////////////////////////
/////////////////////////////////////////////////////

class Informes extends Acciones {

	constructor(crud) {
		super(crud)
		this.fila
		this.clase   = 'principales'
		this.funcion = 'informe_consultar'
		//-------------------------------
		this.alternar = [true, 'white', 'whitesmoke']
		this.especificos = ['fecha_arreglada']
		this.limitante = 0
		this.boton = ''
		this.sublista = {}
		//-------------------------------
		this.div = document.createElement('div')
		this.contenido = qs('#informe-template').content.querySelector('.informe-crud').cloneNode(true)
		this.contenidoFecha = qs('#template-fecha').content.querySelector('.template-fecha-contenedor').cloneNode(true)
	}

	async confirmarActualizacion(popUp) {

		notificaciones.mensajeSimple('Petición realiza con éxito', false, 'V')

		var resultado = JSON.parse(await tools.fullAsyncQuery(this.clase, this.funcion, []))

		this.cargarTabla(resultado, true)

	}

}

export var informes = new Informes(new Tabla(
	[	
		['', false, 0],
		['', false, 0]
	],
	'tabla-informe', 'informe-busqueda', -1, 'null', 'null', 'null', true
))

/////////////////////////////////////////////////////
/////////////////////////////////////////////////////
class Presupuestos extends Acciones {

	constructor(crud) {
		super(crud)
		this.fila
		this.clase   = 'principales'
		this.funcion = 'presupuesto_consultar'
		//-------------------------------
		this.alternar = [true, 'white', 'whitesmoke']
		this.especificos = ['fecha_arreglada']
		this.limitante = 0
		this.boton = ''
		this.sublista = {}
		//-------------------------------
		this.div = document.createElement('div')
		this.contenido = qs('#presupuesto-template').content.querySelector('.presupuesto-crud').cloneNode(true)
		this.contenidoFecha = qs('#template-fecha').content.querySelector('.template-fecha-contenedor').cloneNode(true)
	}

	async confirmarActualizacion(popUp) {

		notificaciones.mensajeSimple('Petición realiza con éxito', false, 'V')

		var resultado = JSON.parse(await tools.fullAsyncQuery(this.clase, this.funcion, []))

		this.cargarTabla(resultado, true)

	}

}

export var presupuestos = new Presupuestos(new Tabla(
	[	
		['', false, 0],
		['', false, 0]
	],
	'tabla-presupuesto', 'presupuesto-busqueda', -1, 'null', 'null', 'null', true
))

/////////////////////////////////////////////////////
/////////////////////////////////////////////////////
class Reposos extends Acciones {

	constructor(crud) {
		super(crud)
		this.fila
		this.clase   = 'principales'
		this.funcion = 'reposo_consultar'
		//-------------------------------
		this.alternar = [true, 'white', 'whitesmoke']
		this.especificos = ['fecha_arreglada']
		this.limitante = 0
		this.boton = ''
		this.sublista = {}
		this.posicion = undefined
		//-------------------------------
		this.div = document.createElement('div')
		this.contenido = qs('#reposo-template').content.querySelector('.reposo-crud').cloneNode(true)
		this.contenidoFecha = qs('#template-fecha').content.querySelector('.template-fecha-contenedor').cloneNode(true)
	}

	async confirmarActualizacion(popUp) {

		notificaciones.mensajeSimple('Petición realiza con éxito', false, 'V')

		var resultado = JSON.parse(await tools.fullAsyncQuery(this.clase, this.funcion, []))

		this.cargarTabla(resultado, true)

	}

	validarRepresentante() {
		var validar = true

		if (historias.sublista.emergencia_persona.trim() === '') {

			validar = false

		}

		if (historias.sublista.emergencia_informacion.trim() === '') {

			validar = false

		}

		if (validar == false) {

			qs('#reposo-menor').checked = false
			notificaciones.mensajeSimple('Falta información en la historia: [NOMBRE DE REPRESENTANTE, CÉDULA DE REPRESENTANTE]', null, 'F')

		}
	}

}

export var reposos = new Reposos(new Tabla(
	[	
		['', false, 0],
		['', false, 0]
	],
	'tabla-reposo', 'reposo-busqueda', -1, 'null', 'null', 'null', true
))

/////////////////////////////////////////////////////
/////////////////////////////////////////////////////
class Referencias extends Acciones {

	constructor(crud) {
		super(crud)
		this.fila
		this.clase   = 'principales'
		this.funcion = 'referencia_consultar'
		//-------------------------------
		this.alternar = [true, 'white', 'whitesmoke']
		this.especificos = ['fecha_arreglada']
		this.limitante = 0
		this.boton = ''
		this.sublista = {}
		//-------------------------------
		this.div = document.createElement('div')
		this.contenido = qs('#referencia-template').content.querySelector('.referencia-crud').cloneNode(true)
		this.contenidoFecha = qs('#template-fecha').content.querySelector('.template-fecha-contenedor').cloneNode(true)
	}

	async confirmarActualizacion(popUp) {

		notificaciones.mensajeSimple('Petición realiza con éxito', false, 'V')

		var resultado = JSON.parse(await tools.fullAsyncQuery(this.clase, this.funcion, []))

		this.cargarTabla(resultado, true)

	}

}

export var referencias = new Referencias(new Tabla(
	[	
		['', false, 0],
		['', false, 0]
	],
	'tabla-referencias', 'referencias-busqueda', -1, 'null', 'null', 'null', true
))

/////////////////////////////////////////////////////
/////////////////////////////////////////////////////
class Notificaciones_reportes extends Acciones {

	constructor(crud) {
		super(crud)
		this.fila
		this.clase   = ''
		this.funcion = ''
		//-------------------------------
		this.alternar = [true, 'white', 'whitesmoke']
		this.especificos = ['']
		this.limitante = 0
		this.boton = ''
		this.sublista = {}
		this.posicion = undefined
		//-------------------------------
		this.div = document.createElement('div')
		this.contenido = qs('#notificaciones-template').content.querySelector('.notificaciones-contenedor').cloneNode(true)
	}

}

export var notificaciones_reportes = new Notificaciones_reportes(new Tabla(
	[	
		['', false, 0],
		['', false, 0]
	],
	'tabla-notificaciones', 'null', -1, 'null', 'null', 'null', false
))

window.notificaciones_reportes = notificaciones_reportes

/////////////////////////////////////////////////////
/////////////////////////////////////////////////////
class Notificados_reportes extends Acciones {

	constructor(crud) {
		super(crud)
		this.fila
		this.clase   = ''
		this.funcion = ''
		//-------------------------------
		this.alternar = [true, 'white', 'whitesmoke']
		this.especificos = ['']
		this.limitante = 0
		this.boton = ''
		this.sublista = {}
		this.posicion = undefined
		//-------------------------------
		this.div = document.createElement('div')
		this.contenido = qs('#notificados-template').content.querySelector('.notificados-contenedor').cloneNode(true)
	}

}

export var notificados_reportes = new Notificados_reportes(new Tabla(
	[	
		['', false, 0],
		['', false, 0]
	],
	'tabla-notificados', 'null', -1, 'null', 'null', 'null', false
))

window.notificados_reportes = notificados_reportes

/////////////////////////////////////////////////////
/////////////////////////////////////////////////////
class Notificados_recipes extends Acciones {

	constructor(crud) {
		super(crud)
		this.fila
		this.clase   = ''
		this.funcion = ''
		//-------------------------------
		this.alternar = [true, 'white', 'whitesmoke']
		this.especificos = ['']
		this.limitante = 0
		this.boton = ''
		this.sublista = {}
		this.posicion = undefined
		//-------------------------------
		this.div = document.createElement('div')
	}

}

export var notificados_recipes = new Notificados_recipes(new Tabla(
	[	
		['', false, 0],
		['', false, 0]
	],
	'tabla-notificados', 'null', -1, 'null', 'null', 'null', false
))

window.notificados_recipes = notificados_recipes

/////////////////////////////////////////////////////
/*					MEDICAMENTOS 				   */
/////////////////////////////////////////////////////
class Medicamentos extends Acciones {
	constructor (crud) {
		super(crud)
		this.fila
		this.clase = 'historias_recipes'
		this.funcion = 'cargar_medicamentos'
		//-------------------------------
		this.alternar =  [true, '#ebebeb' , '#fff']
		this.especificos =  ['id_medicamento', 'nombre', 'genericos_nombres', 'marcador']
		this.limitante = 0
		this.boton = ''
		this.sublista = {}
		//-------------------------------
		this.div = document.createElement('div')
		this.contenido = qs('#medicamentos-template').content.querySelector('.medicamentos-crud').cloneNode(true)
		//-------------------------------
		this.btnSeleccionado = undefined
	}

	async traerMedicamentos() {

		this['crud'].lista = tools.copiaLista(window.medicamentos['crud'].resetLista)
		this['crud'].checkLista = []
		this['crud'].generarCabecera();
		this.cargarTabla(this['crud'].lista)
	}
}

export var medicamentos = new Medicamentos(new Tabla(
	[
		[['✓', 'Medicamentos seleccionados para el récipe & indicación del paciente'], true, 7],
		['Contenido del récipe & indicación', false, 0]
	],
	'tabla-medicamentos', 'medicamentos-busqueda', 5,'medicamentos-izquierda','medicamentos-derecha','medicamentos-numeracion', false
))

window.medicamentos = medicamentos

/////////////////////////////////////////////////////
/*					RECIPES 					   */
/////////////////////////////////////////////////////
class Recipes extends Acciones {

	constructor(crud) {
		super(crud)
		this.fila
		this.clase   = ''
		this.funcion = ''
		//-------------------------------
		this.alternar = [true, 'white', 'whitesmoke']
		this.especificos = ['id_recipe', 'fecha']
		this.limitante = 0
		this.boton = ''
		this.sublista = {}
		this.posicion = undefined
		//-------------------------------
		this.div = document.createElement('div')
	}

	async traerRecipes(id_historia) {

		this.cargarTabla(JSON.parse(await tools.fullAsyncQuery('historias_recipes', 'cargar_recipes', [id_historia])))

	}

}

export var recipes = new Recipes(new Tabla(
	[	
		['Fecha', true, 5],
		['Acciones', false, 0]
	],
	'tabla-recipes', 'recipes-busqueda', -1, 'null', 'null', 'null', false
))

window.recipes = recipes

/////////////////////////////////////////////////////
/*					RECIPES NOTIFICADOS			   */
/////////////////////////////////////////////////////
class Recipes_notificados extends Acciones {

	constructor(crud) {
		super(crud)
		this.fila
		this.clase   = ''
		this.funcion = ''
		//-------------------------------
		this.alternar = [true, 'white', 'whitesmoke']
		this.especificos = ['id_recipe', 'fecha']
		this.limitante = 0
		this.boton = ''
		this.sublista = {}
		this.posicion = undefined
		//-------------------------------
		this.div = document.createElement('div')
		this.contenedorEliminarBoton = qs('#eliminar-template').content.querySelector('.eliminar-contenedor').cloneNode(true)
	}

}

export var recipes_notificados = new Recipes_notificados(new Tabla(
	[	
		['Paciente', true, 2],
		['Acciones', false, 0]
	],
	'tabla-recipes-notificados', 'null', -1, 'null', 'null', 'null', false
))

window.recipes_notificados = recipes_notificados
recipes_notificados.cargarTabla([])

/////////////////////////////////////////////////////
/*					TRATAMIENTOS 				   */
/////////////////////////////////////////////////////
window.idTratamiento = 0

class Tratamientos extends Acciones {
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
		this.sublista = {}
		//-------------------------------
	}
}

export var tratamientos = new Tratamientos(new Tabla(
	[
		['', true, 0],
		['', false, 0]
	],
	'tabla-tratamientos','tratamientos-busqueda', -1,'null','null','null', false
))

window.tratamientos = tratamientos

/////////////////////////////////////////////////////
/////////////////////////////////////////////////////
qs('#nuevo-tratamiento').addEventListener('click', e => {
	tratamientos.crud.lista.push({"tratamiento": ''})
	tratamientos.cargarTabla(tratamientos.crud.lista)
})

/////////////////////////////////////////////////////
/*					PRESENTACIONES 				   */
/////////////////////////////////////////////////////
window.idPresentacion = 0

class Presentaciones extends Acciones {
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
			this.sublista = {}
			//-------------------------------
		}
	}

export var presentaciones = new Presentaciones(new Tabla(
	[
		['', true, 0],
		['', false, 0]
	],
	'tabla-presentaciones','presentaciones-busqueda', -1,'null','null','null', false
))

window.presentaciones = presentaciones

/////////////////////////////////////////////////////
/////////////////////////////////////////////////////
qs('#nueva-presentacion').addEventListener('click', e => {
	presentaciones.crud.lista.push({"presentacion": ''})
	presentaciones.cargarTabla(presentaciones.crud.lista)
})

//---------------------------------------------------------------------------------------------------
/* -------------------------------------------------------------------------------------------------*/
/*           							PAGINACION HISTORIAS			 	  					    */
/* -------------------------------------------------------------------------------------------------*/
window.paginacionHistorias = new PaginacionContenedores(
	'#paginacion-contenedores',
	{
		"informacion": {
			"pop": () => {infPop.pop(); permitirLimpiezaReportes = false},
			"boton": ''
		},
		"editar": {
			"pop": () => {ediPop.pop(); permitirLimpiezaReportes = false},
			"boton": ''
		},
		"reportes": {
			"pop": () => {repPop.pop(); permitirLimpiezaReportes = false},
			"boton": ''
		},
		"recipes": {
			"pop": () => {recPop.pop(); permitirLimpiezaReportes = false},
			"boton": ''
		}
	},
	historias,
	botonesReportesPaginacion
)

//SOLUCIONAR ESTE PROBLEMA
window.paginacionHistorias.cambiarUltimoSeleccionado('informacion')
window.paginacionHistorias.actualizarFamiliaDeBotones(tools.pariente(qs('#tabla-historias tbody tr .informacion'), 'TR'))
/////////////////////////////////////////////////////
/////////////////////////////////////////////////////
ediPop.funciones['apertura'] = {"apertura": () => {window.paginacionHistorias.contenedor.style = "z-index: 10"; window.paginacionHistorias.mostrar()}}
ediPop.funciones['cierre']   = {"cierre": ()   => { window.paginacionHistorias.ocultar()}}

insPop.funciones['apertura'] = {"apertura": () => {window.paginacionHistorias.mostrar()}}
insPop.funciones['cierre']   = {"cierre": ()   => {window.paginacionHistorias.ocultar()}}

infPop.funciones['apertura'] = {"apertura": () => {window.paginacionHistorias.contenedor.style = "z-index: 10"; window.paginacionHistorias.mostrar()}}
infPop.funciones['cierre']   = {"cierre": ()   => { window.paginacionHistorias.ocultar()}}

repPop.funciones['apertura'] = {"apertura": () => {
	window.paginacionHistorias.mostrar(); 
	if (reporteSeleccionado === 'constancia') {constancias.validarRepresentante()};
	if (reporteSeleccionado === 'reposo') {reposos.validarRepresentante()};
	if (reporteSeleccionado === 'informe') {qs('#tabla-informe').parentElement.scrollTo(0,0)}
}}

repPop.funciones['cierre']   = {"cierre": ()   => {window.paginacionHistorias.ocultar()}}

recPop.funciones['apertura'] = {"apertura": () => {window.paginacionHistorias.mostrar(); window.paginacionHistorias.contenedor.style = "z-index: 10"}}
recPop.funciones['cierre']   = {"cierre": ()   => {window.paginacionHistorias.ocultar()}}

prePop.funciones['apertura'] = {"apertura": () => {window.paginacionHistorias.contenedor.style = "z-index: 0"}}
prePop.funciones['cierre']   = {"cierre": ()   => {window.paginacionHistorias.contenedor.style = "z-index: 10"}}

insPop.funciones['apertura'] = {"apertura": () => {window.paginacionHistorias.contenedor.style = "z-index: 0"}}
insPop.funciones['cierre']   = {"cierre": ()   => {window.paginacionHistorias.contenedor.style = "z-index: 10"}}

conPop.funciones['apertura'] = {"apertura": () => {window.paginacionHistorias.contenedor.style = "z-index: 0"}}
conPop.funciones['cierre']   = {"cierre": ()   => {window.paginacionHistorias.contenedor.style = "z-index: 10"}}

ocuPop.funciones['apertura'] = {"apertura": () => {window.paginacionHistorias.contenedor.style = "z-index: 0"}}
ocuPop.funciones['cierre']   = {"cierre": ()   => {window.paginacionHistorias.contenedor.style = "z-index: 10"}}

proPop.funciones['apertura'] = {"apertura": () => {window.paginacionHistorias.contenedor.style = "z-index: 0"}}
proPop.funciones['cierre']   = {"cierre": ()   => {window.paginacionHistorias.contenedor.style = "z-index: 10"}}

parPop.funciones['apertura'] = {"apertura": () => {window.paginacionHistorias.contenedor.style = "z-index: 0"}}
parPop.funciones['cierre']   = {"cierre": ()   => {window.paginacionHistorias.contenedor.style = "z-index: 10"}}

civPop.funciones['apertura'] = {"apertura": () => {window.paginacionHistorias.contenedor.style = "z-index: 0"}}
civPop.funciones['cierre']   = {"cierre": ()   => {window.paginacionHistorias.contenedor.style = "z-index: 10"}}

relPop.funciones['apertura'] = {"apertura": () => {window.paginacionHistorias.contenedor.style = "z-index: 0"}}
relPop.funciones['cierre']   = {"cierre": ()   => {window.paginacionHistorias.contenedor.style = "z-index: 10"}}

medPop.funciones['apertura'] = {"apertura": () => {window.paginacionHistorias.contenedor.style = "z-index: 0"}}
medPop.funciones['cierre']   = {"cierre": ()   => {window.paginacionHistorias.contenedor.style = "z-index: 10"}}

genPop.funciones['apertura'] = {"apertura": () => {window.paginacionHistorias.contenedor.style = "z-index: 0"}}
genPop.funciones['cierre']   = {"cierre": ()   => {window.paginacionHistorias.contenedor.style = "z-index: 10"}}

diaPop.funciones['apertura'] = {"apertura": () => {window.paginacionHistorias.contenedor.style = "z-index: 0"}}
diaPop.funciones['cierre']   = {"cierre": ()   => {window.paginacionHistorias.contenedor.style = "z-index: 10"}}

forPop.funciones['apertura'] = {"apertura": () => {window.paginacionHistorias.contenedor.style = "z-index: 0"; qs('#crud-infeditar-pop').scrollTo(0, 0)}}
forPop.funciones['cierre']   = {"cierre": ()   => {window.paginacionHistorias.contenedor.style = "z-index: 10"}}

presPop.funciones['apertura'] = {"apertura": () => {window.paginacionHistorias.contenedor.style = "z-index: 0"}}
presPop.funciones['cierre']   = {"cierre": ()   => {window.paginacionHistorias.contenedor.style = "z-index: 10"}}

repoPop.funciones['apertura'] = {"apertura": () => {window.paginacionHistorias.contenedor.style = "z-index: 0"}}
repoPop.funciones['cierre']   = {"cierre": ()   => {window.paginacionHistorias.contenedor.style = "z-index: 10"}}

refPop.funciones['apertura'] = {"apertura": () => {window.paginacionHistorias.contenedor.style = "z-index: 0"}}
refPop.funciones['cierre']   = {"cierre": ()   => {window.paginacionHistorias.contenedor.style = "z-index: 10"}}

traPop.funciones['apertura'] = {"apertura": () => {window.paginacionHistorias.contenedor.style = "z-index: 0"}}
traPop.funciones['cierre']   = {"cierre": ()   => {window.paginacionHistorias.contenedor.style = "z-index: 10"}}

presenPop.funciones['apertura'] = {"apertura": () => {window.paginacionHistorias.contenedor.style = "z-index: 0"}}
presenPop.funciones['cierre']   = {"cierre": ()   => {window.paginacionHistorias.contenedor.style = "z-index: 10"}}

mediPop.funciones['apertura'] = {"apertura": () => {window.paginacionHistorias.contenedor.style = "z-index: 0"}}
mediPop.funciones['cierre']   = {"cierre": ()   => {window.paginacionHistorias.contenedor.style = "z-index: 10"}}
/* -------------------------------------------------------------------------------------------------*/
/*           					LISTADO DE TABLAS DE REPORTES 									    */
/* -------------------------------------------------------------------------------------------------*/

export var reportesDisponibles = {
	"constancia": constancias,
	"general": generales,
	"informe": informes,
	"presupuesto": presupuestos,
	"reposo": reposos,
	"referencia": referencias
}

//----------------------------------------------------------------------------------------------------
//              				NOTIFICACIONES
//----------------------------------------------------------------------------------------------------
export var 
	notificacionesPop = qs('#crud-notificaciones-popup'),
	notificacionesBoton = qs('#notificacion-doctor'),
	notificadosDesplegable = qs('#desplegable-notificados'),
	notificadosBoton = qs('#desplegable-abrir-notificados')

var recipesDesplegable = qs('#desplegable-recipes'),
	recipesBoton = qs('#desplegable-abrir-recipes')

setInterval(async () => {

    if (Number(await tools.fullAsyncQuery('historias', 'controlador_cambios', []))) {

    	//------------------------------------------------------------------
    	//					NOTIFICACIONES REPORTES
        //------------------------------------------------------------------

        //ACTUALIZACION SI CONTENEDOR ESTA ABIERTO
        //
        if (notificacionesPop.classList.contains('popup-activo') && usuario.rol.trim() === 'DOCTOR') { //AGREAR ROL A COMPARARCIONES

       		notificaciones_reportes.cargarTabla(JSON.parse(await tools.fullAsyncQuery('historias_notificaciones', 'notificaciones_consultar', [])))

        }

        if (notificadosDesplegable.style.display === '' && usuario.rol.trim() === 'ADMINISTRACION') {

        	notificados_reportes.cargarTabla(JSON.parse(await tools.fullAsyncQuery('historias_notificaciones', 'notificaciones_consultar', [])))

        }

        //ALERTA VISUAL DE NOTIFICACION DE REPORTES 
        //-----------------------------------------
        //lnr = longitud_notificaciones_reportes

        var lnr = await tools.fullAsyncQuery('historias_notificaciones', 'notificacion_reportes_cantidad', [])

        if (lnr > 0) {

        	if (!notificacionesPop.classList.contains('popup-activo') && usuario.rol.trim() === 'DOCTOR') {

        		notificacionesBoton.classList.add('notificacion-alerta')

        	}

	        if (notificadosDesplegable.style.display === 'none' && usuario.rol.trim() === 'ADMINISTRACION') {
	        	
	        	notificadosBoton.classList.add('notificacion-alerta')

	        }

        }

        //------------------------------------------------------------------
    	//					NOTIFICACIONES RECIPES
        //------------------------------------------------------------------

        //ACTUALIZACION SI CONTENEDOR ESTA ABIERTO
        //
        if (recipesDesplegable.style.display === '' && usuario.rol.trim() === 'ADMINISTRACION') {

        	notificados_reportes.cargarTabla(JSON.parse(await tools.fullAsyncQuery('historias_recipes', 'notificaciones_recipes_consultar', [])))

        }

        //ALERTA VISUAL DE NOTIFICACION DE REPORTES 
        //-----------------------------------------
        //lnr = longitud_notificaciones_reportes

        var lnr = await tools.fullAsyncQuery('historias_recipes', 'notificacion_recipes_cantidad', [])

        if (lnr > 0) {

	        if (recipesDesplegable.style.display === 'none' && usuario.rol.trim() === 'ADMINISTRACION') {
	        	
	        	recipesBoton.classList.add('notificacion-alerta')

	        }

        }

    	await tools.fullAsyncQuery('historias', 'controlador_cambios_desactivar', [])

    }

}, 5000);