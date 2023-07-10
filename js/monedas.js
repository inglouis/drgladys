import  {Tabla} from '../js/crud.js';
import  {PopUp, Acciones, Herramientas, Filtros, paginaCargada, Rellenar, Animaciones} from '../js/main.js';
const ediPop = new PopUp('crud-editar-popup','popup', 'subefecto', true)
const insPop = new PopUp('crud-insertar-popup','popup', 'subefecto', true)

const tools = new Herramientas()
window.filtros = new Filtros('monedas-filtros')
window.filtrosInsertar  = new Filtros('crud-insertar-popup')
window.filtrosEditar  = new Filtros('crud-editar-popup')
/////////////////////////////////////////////////////
window.qs    = document.querySelector.bind(document)
window.qsa   = document.querySelectorAll.bind(document)
/////////////////////////////////////////////////////
window.procesar = true;
window.idSeleccionada = 0


window.cargar = new paginaCargada('#tabla-monedas thead .ASC', 'existencia')
window.cargar.revision()

window.rellenar = new Rellenar()

window.contenedoresMapa = [
	['editar', ediPop, 'popup', ''],
	['insertar', insPop, 'popup', 'monedas'],
]

window.animaciones = new Animaciones({on: 'aparecer', off: 'desaparecer'})
window.animaciones.hider = 'data-hidden'
window.animaciones.generar('#notas-importantes', ['#notas-importantes-contenedor'])

/////////////////////////////////////////////////////
var sesiones = await window.sesiones()
/////////////////////////////////////////////////////
//var banderas = JSON.parse(sesiones.usuario.banderas)['recibos']
var configuracion = JSON.parse(sesiones.usuario.configuracion)
/////////////////////////////////////////////////////

//---------------------------------------------------------------------------------//
//								monedas
//---------------------------------------------------------------------------------//

class Monedas extends Acciones {
	constructor (crud) {
		super(crud)
		this.fila
		this.clase = 'monedas'
		this.funcion = 'buscarMonedas'
		//-------------------------------
		this.alternar =  [true, '#fff' , '#fff']
		this.especificos =  ['id_moneda', 'unidad']
		this.limitante = 0
		this.boton = ''
		//-------------------------------
	}

	actualizar(datos, params) {
		tools['mensaje'] = 'Procesando...'
		tools.mensajes(['#ffc107', '#fff'])
		var th = this
		var peticion = this.query(params[0], datos)
		peticion.onreadystatechange = function() {
	        if (this.readyState == 4 && this.status == 200) {
	        	window.procesar = true

				if (this.responseText.trim() === 'exito') {
					tools['mensaje'] = 'Petición realizada con éxito'
					tools.mensajes(true)

					setTimeout(() => {
						params[2].pop()
						var peticion = th.query(params[1], [])
							peticion.onreadystatechange = function() {
		        				if (this.readyState == 4 && this.status == 200) {
		        					qs('#tabla-monedas tbody').innerHTML = ''
		        					window.lista = JSON.parse(this.responseText)
				        			th.cargarTabla(window.lista)
				        		}
				    		}
					}, 1000)
				} else if (this.responseText.trim() === 'repetido') {
					tools['mensaje'] = 'El Registro ya existe'
					tools.mensajes(false)
				} else {
					tools['mensaje'] = 'Error al procesar la petición'
					tools.mensajes(false)
					console.log(this.responseText)
				}
	        } else {
	        	window.procesar = true
	        }
	    };
	}
}

//----------------------------------------------------------------------------------------------------
//										monedas ANTIGUAS                                           
//----------------------------------------------------------------------------------------------------
window.monedas = new Monedas(new Tabla(
	[
		['Nombre de la Moneda', true, 1],
		['Conversión DOLAR($)', true, 2],
		['Conversión PESOS(COL)', true, 5],
		['Unidad', true, 3],
		['Status', true, 4],
		['Acciones', false, 0]
	],
	'tabla-monedas','busqueda', Number(configuracion.filas),'izquierda','derecha','numeracion',true
))

monedas['crud'].cuerpo.push([monedas['crud'].columna = monedas['crud'].cuerpo.length, [monedas['crud'].gSpan(null,null)], [false], ['HTML'], '', 1])
monedas['crud'].cuerpo.push([monedas['crud'].columna = monedas['crud'].cuerpo.length, [monedas['crud'].gSpan(null,null)], [false], ['HTML'], '', 2])
monedas['crud'].cuerpo.push([monedas['crud'].columna = monedas['crud'].cuerpo.length, [monedas['crud'].gSpan(null,null)], [false], ['HTML'], '', 5])
monedas['crud'].cuerpo.push([monedas['crud'].columna = monedas['crud'].cuerpo.length, [monedas['crud'].gSpan(null,null)], [false], ['HTML'], '', 3])
monedas['crud'].cuerpo.push([monedas['crud'].columna = monedas['crud'].cuerpo.length, [monedas['crud'].gSpan(null,null)], [false], ['HTML'], '', 4])
monedas['crud'].cuerpo.push([monedas['crud'].columna = monedas['crud'].cuerpo.length, [
		monedas['crud'].gBt('editar btn btn-success', `<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="pencil-alt" class="svg-inline--fa fa-pencil-alt fa-w-16 iconos" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M497.9 142.1l-46.1 46.1c-4.7 4.7-12.3 4.7-17 0l-111-111c-4.7-4.7-4.7-12.3 0-17l46.1-46.1c18.7-18.7 49.1-18.7 67.9 0l60.1 60.1c18.8 18.7 18.8 49.1 0 67.9zM284.2 99.8L21.6 362.4.4 483.9c-2.9 16.4 11.4 30.6 27.8 27.8l121.5-21.3 262.6-262.6c4.7-4.7 4.7-12.3 0-17l-111-111c-4.8-4.7-12.4-4.7-17.1 0zM124.1 339.9c-5.5-5.5-5.5-14.3 0-19.8l154-154c5.5-5.5 14.3-5.5 19.8 0s5.5 14.3 0 19.8l-154 154c-5.5 5.5-14.3 5.5-19.8 0zM88 424h48v36.3l-64.5 11.3-31.1-31.1L51.7 376H88v48z"></path></svg>`)
	], [false], ['VALUE'], '', 0])

monedas['crud']['clase'] = 'monedas'
monedas['crud']['funcion'] = 'buscarmonedas'

monedas['crud']['customBodyEvents'] = {
	/* -------------------------------------------------------------------------------------------------*/
	/*           evento que envia los datos del boton de editar del crud al contenedor de edicion       */
	/* -------------------------------------------------------------------------------------------------*/
	"editar": async (e) => {
		if(e.target.classList.contains('editar')) {
			monedas.limpiar('.crud-valores', '', {})
			rellenar.contenedores(tools.pariente(e.target, 'TR').sublista, '.crud-valores', {elemento: e.target, id: 'value'})
			ediPop.pop()
		}
	}
};

(async () => {
	var resultado = await tools.fullAsyncQuery('monedas', 'cargarMonedas', [])
	monedas.cargarTabla(JSON.parse(resultado))
	monedas['crud'].botonBuscar('buscar-monedas', false) 	
})()

/* -------------------------------------------------------------------------------------------------*/
/*   		Evento que refresca la el crud con datos sql*							                */
/* -------------------------------------------------------------------------------------------------*/
qs('#procesar').addEventListener('click', e => {
	monedas.spinner('#tabla-monedas tbody')
	var peticion = filtros.procesar(tools.fullQuery, 'monedas','filtrar')
	peticion.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
        	qs('#tabla-monedas tbody').innerHTML = ''
        	monedas.cargarTabla(JSON.parse(this.responseText))
        }
    };
})

/* -------------------------------------------------------------------------------------------------*/
/*   		Evento que limpia los datos del contenedor de insertar*                */
/* -------------------------------------------------------------------------------------------------*/
qs('#crud-insertar-limpiar').addEventListener('click', e => {
	monedas.limpiar('.nuevos', '', {
		"procesado": e => {
			tools['mensaje'] = 'Datos limpiados'
			tools.mensajes(true)
		},
		"asegurar": () => {return '#crud-insertar-pop'}
	})
})

/* -------------------------------------------------------------------------------------------------*/
/*   		Evento que envia los datos al metodo de javascript que hace la peticion*                */
/* -------------------------------------------------------------------------------------------------*/
qs('#crud-editar-botones').addEventListener('click', e => {
	var datos = monedas.confirmar(e.target, 'editar', 'crud-valores', tools);
	(datos !== '') ? monedas.actualizar(datos, ['actualizarMonedas', 'cargarMonedas', ediPop]) : '' 
})

/* -------------------------------------------------------------------------------------------------*/
/*                    evento que envia los datos a php para la insersión                            */
/* -------------------------------------------------------------------------------------------------*/
qs('#crud-insertar-botones').addEventListener('click', e => {
	if (e.target.classList.contains('insertar')) {
		var datos = monedas.confirmar(e.target, 'insertar', 'nuevos', tools)
		if (datos !== '') {
			monedas.actualizar(datos, ['crearmonedas', 'cargarMonedas', insPop])
		} else {
			tools['mensaje'] = 'Campos vacíos'
			tools.mensajes(false)
		}
	}
})

/* -------------------------------------------------------------------------------------------------*/	
//                      generador de eventos de los botones de cada contenedor
/* -------------------------------------------------------------------------------------------------*/
contenedoresMapa.forEach((e,i) => {
	if(qs(`#crud-${e[0]}-cerrar`)) {
		qs(`#crud-${e[0]}-cerrar`).addEventListener('click', () => {	
			window.idSeleccionada = 0
			e[1].pop()
		})
	}

	if(qs(`#crud-${e[0]}-botones`)) {
		qs(`#crud-${e[0]}-botones`).addEventListener('click', (el) => {
			if(el.target.classList.contains('cerrar')) {
				window.idSeleccionada = 0
				e[1].pop()
			}	
		})
	}
});

window.addEventListener('keyup', (el) => {
	contenedoresMapa.forEach((e,i) => {
		if (el.keyCode === 27 && qs(`#crud-${e[0]}-popup`).classList.contains(`${e[2]}-activo`)) {
			if(qs(`#crud-${e[3]}-popup`)) {
				if(qs(`#crud-${e[3]}-popup`).classList.contains('popup-oculto')) {
					window.idSeleccionada = 0
					e[1].pop()
				}	
			} else {
				window.idSeleccionada = 0
				e[1].pop()
			}  	
		}
	})
})

/* -------------------------------------------------------------------------------------------------*/	
//                      eventos exclusivos de el archivo js
/* -------------------------------------------------------------------------------------------------*/

qs('#insertar-monedas').addEventListener('click', e => {
	window.idSeleccionada = 0
	monedas.limpiar('.nuevos', '', {"asegurar": () => {return '#crud-insertar-pop'}})
	insPop.pop()
})