import  {Tabla} from '../js/crud.js';
import  {PopUp, Acciones, Herramientas, Filtros, paginaCargada} from '../js/main.js';
const eliPop = new PopUp('crud-eliminar-popup','popup', 'subefecto', false)
const ediPop = new PopUp('crud-editar-popup','popup', 'subefecto', true)
const insPop = new PopUp('crud-insertar-popup','popup', 'subefecto', true)

const tools = new Herramientas()
window.filtros = new Filtros('iva-filtros')
window.filtrosInsertar  = new Filtros('crud-insertar-popup')
window.filtrosEditar  = new Filtros('crud-editar-popup')
/////////////////////////////////////////////////////
window.qs    = document.querySelector.bind(document)
window.qsa   = document.querySelectorAll.bind(document)
/////////////////////////////////////////////////////
window.procesar = true;
window.idEliminar = 0
window.idSeleccionada = 0

window.cargar = new paginaCargada('#tabla-iva thead .ASC', 'existencia')
window.cargar.revision()


window.contenedoresMapa = [
	['editar', ediPop, 'popup', ''],
	['eliminar', eliPop, 'popup', ''],
	['insertar', insPop, 'popup', 'iva'],
]

//---------------------------------------------------------------------------------//
//								iva
//---------------------------------------------------------------------------------//

class Iva extends Acciones {
	constructor (crud) {
		super(crud)
		this.fila
		this.clase = 'iva'
		this.funcion = 'buscariva'
		//-------------------------------
		this.alternar =  [true, '#fff' , '#fff']
		this.especificos =  ['id_iva', 'porcentaje']
		this.limitante = 0
		this.boton = ''
		//-------------------------------
	}

	actualizar(datos, params, excepciones) {
		tools['mensaje'] = 'Procesando...'
		tools.mensajes(['#ffc107', '#fff'])
		var th = this
		var peticion = this.query(params[0], datos, excepciones)
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
		        					qs('#tabla-iva tbody').innerHTML = ''
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
//										iva                                           
//----------------------------------------------------------------------------------------------------
window.iva = new Iva(new Tabla(
	[
		['Código', true, 0],
		['Porcentaje', true, 1],
		['Fecha', true, 2],
		[['Por defecto', 'Valor por defecto en operaciones de carga o compra de inventario'], true, 5],
		['Status', true, 4],
		['Acciones', false, 0]
	],
	'tabla-iva','busqueda', 14,'izquierda','derecha','numeracion',true
))

iva['crud'].cuerpo.push([iva['crud'].columna = iva['crud'].cuerpo.length, [iva['crud'].gSpan(null,null)], [false], ['HTML'], '', 0])
iva['crud'].cuerpo.push([iva['crud'].columna = iva['crud'].cuerpo.length, [iva['crud'].gSpan(null,null)], [false], ['HTML'], '', 1])
iva['crud'].cuerpo.push([iva['crud'].columna = iva['crud'].cuerpo.length, [iva['crud'].gSpan(null,null)], [false], ['HTML'], '', 2])
iva['crud'].cuerpo.push([iva['crud'].columna = iva['crud'].cuerpo.length, [iva['crud'].gSpan(null,null)], [false], ['HTML'], '', 5])
iva['crud'].cuerpo.push([iva['crud'].columna = iva['crud'].cuerpo.length, [iva['crud'].gSpan(null,null)], [false], ['HTML'], '', 4])
iva['crud'].cuerpo.push([iva['crud'].columna = iva['crud'].cuerpo.length, [
		iva['crud'].gBt('editar btn btn-success', `<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="pencil-alt" class="svg-inline--fa fa-pencil-alt fa-w-16 iconos" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M497.9 142.1l-46.1 46.1c-4.7 4.7-12.3 4.7-17 0l-111-111c-4.7-4.7-4.7-12.3 0-17l46.1-46.1c18.7-18.7 49.1-18.7 67.9 0l60.1 60.1c18.8 18.7 18.8 49.1 0 67.9zM284.2 99.8L21.6 362.4.4 483.9c-2.9 16.4 11.4 30.6 27.8 27.8l121.5-21.3 262.6-262.6c4.7-4.7 4.7-12.3 0-17l-111-111c-4.8-4.7-12.4-4.7-17.1 0zM124.1 339.9c-5.5-5.5-5.5-14.3 0-19.8l154-154c5.5-5.5 14.3-5.5 19.8 0s5.5 14.3 0 19.8l-154 154c-5.5 5.5-14.3 5.5-19.8 0zM88 424h48v36.3l-64.5 11.3-31.1-31.1L51.7 376H88v48z"></path></svg>`),
	], [
	[	
		[
			['porcentaje', 1, true],
			['fecha', 2, true],
			['defecto', 3, true],
			['eStatus', 4, true],
			['id_iva', 0]
		], 
		['CLASE', 0, true]
	]
], ['MUL'], '', false])

iva['crud'].botonModoBusqueda("#modo-buscar", 1, [
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

iva['crud']['clase'] = 'iva'
iva['crud']['funcion'] = 'buscarIva';

(async () => {
	var resultado = await tools.fullAsyncQuery('iva', 'cargarIva', [])
	iva.cargarTabla(JSON.parse(resultado))
	iva['crud'].botonBuscar('buscar', false) 	
})()

/* -------------------------------------------------------------------------------------------------*/
/*   		Evento que refresca la el crud con datos sql*							                */
/* -------------------------------------------------------------------------------------------------*/
qs('#procesar').addEventListener('click', e => {
	iva.spinner('#tabla-iva tbody')
	var peticion = filtros.procesar(tools.fullQuery, 'iva','filtrar')
	peticion.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
        	qs('#tabla-iva tbody').innerHTML = ''
        	iva.cargarTabla(JSON.parse(this.responseText))
        }
    };
})

//----------------------------------------------------------------------------------------------------
//										E V E N T O S                                                
//----------------------------------------------------------------------------------------------------
filtros.eventos().checkboxes('status')

/* -------------------------------------------------------------------------------------------------*/
/*   		Evento que limpia los datos del contenedor de insertar*                */
/* -------------------------------------------------------------------------------------------------*/
qs('#crud-insertar-limpiar').addEventListener('click', e => {
	iva.limpiar('.nuevos', '', {
		"procesado": e => {
			tools['mensaje'] = 'Datos limpiados'
			tools.mensajes(true)
		},
		"asegurar": () => {return '#crud-insertar-pop'}
	})
})

/* -------------------------------------------------------------------------------------------------*/
/*           evento que envia los datos del boton de editar del crud al contenedor de edicion       */
/* -------------------------------------------------------------------------------------------------*/
iva.contenedor(qs('#tabla-iva'), 'editar', ediPop, 'crud-valores', {}, {"id":3})
/* -------------------------------------------------------------------------------------------------*/
/*   		Evento que envia los datos al metodo de javascript que hace la peticion*                */
/* -------------------------------------------------------------------------------------------------*/
qs('#crud-editar-botones').addEventListener('click', e => {
	var datos = iva.confirmar(e.target, 'editar', 'crud-valores', tools);
	(datos !== '') ? iva.actualizar(datos, ['actualizarIva', 'cargarIva', ediPop], [["+", "%2B"]]) : '' 
})

/* -------------------------------------------------------------------------------------------------*/
/*                    evento que envia los datos a php para la insersión                            */
/* -------------------------------------------------------------------------------------------------*/
qs('#crud-insertar-botones').addEventListener('click', e => {
	if (e.target.classList.contains('insertar')) {
		var datos = iva.confirmar(e.target, 'insertar', 'nuevos', tools)
		if (datos !== '') {
			iva.actualizar(datos, ['crearIva', 'cargarIva', insPop], [["+", "%2B"]])
		}
	}
})

/* -------------------------------------------------------------------------------------------------*/	
//          evento que envía la ID del crud al boton de eliminar del contenedor
/* -------------------------------------------------------------------------------------------------*/
qs('#tabla-iva').addEventListener('click', e => {
	if (e.target.tagName === 'BUTTON') {
		if (e.target.classList.contains('eliminar')) {
			window.idEliminar = Number(e.target.classList[3])
			eliPop.pop()
		}
	}
})

/* -------------------------------------------------------------------------------------------------*/	
//                      generador de eventos de los botones de cada contenedor
/* -------------------------------------------------------------------------------------------------*/
contenedoresMapa.forEach((e,i) => {
	if(qs(`#crud-${e[0]}-cerrar`)) {
		qs(`#crud-${e[0]}-cerrar`).addEventListener('click', () => {	
			e[1].pop()
		})
	}

	if(qs(`#crud-${e[0]}-botones`)) {
		qs(`#crud-${e[0]}-botones`).addEventListener('click', (el) => {
			if(el.target.classList.contains('cerrar')) {
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
					e[1].pop()
				}	
			} else {
				e[1].pop()
			}  	
		}
	})
})

/* -------------------------------------------------------------------------------------------------*/	
//                      eventos exclusivos de el archivo js
/* -------------------------------------------------------------------------------------------------*/

qs('#insertar-iva').addEventListener('click', e => {
	window.idSeleccionada = 0
	iva.limpiar('.nuevos', '', {"asegurar": () => {return '#crud-insertar-pop'}})
	insPop.pop()
})