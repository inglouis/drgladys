import  {Tabla} from '../js/crud.js';
import  {PopUp, Acciones, Herramientas, Filtros, paginaCargada, Paginacion, Rellenar} from '../js/main.js';
const eliPop = new PopUp('crud-eliminar-popup','popup', 'subefecto', false)
const ediPop = new PopUp('crud-editar-popup','popup', 'subefecto', true)
const insPop = new PopUp('crud-insertar-popup','popup', 'subefecto', true)

const tools = new Herramientas()
window.filtros = new Filtros('medicamentos-filtros')
window.filtrosInsertar  = new Filtros('crud-insertar-popup')
window.filtrosEditar  = new Filtros('crud-editar-popup')

/////////////////////////////////////////////////////
window.qs    = document.querySelector.bind(document)
window.qsa   = document.querySelectorAll.bind(document)
/////////////////////////////////////////////////////
window.procesar = true;
window.idEliminar = 0
window.idSeleccionada = 0

window.rellenar = new Rellenar()

window.cargar = new paginaCargada('#tabla-medicamentos thead .ASC', 'existencia')
window.cargar.revision()

window.contenedoresMapa = [
	['editar', ediPop, 'popup', ''],
	['eliminar', eliPop, 'popup', ''],
	['insertar', insPop, 'popup', 'medicamentos'],
]

//window.medicamentos.crud.pagPosi
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

/////////////////////////////////////////////////////
var sesiones = await window.sesiones()
/////////////////////////////////////////////////////
//var banderas = JSON.parse(sesiones.usuario.banderas)['recibos']
var configuracion = JSON.parse(sesiones.usuario.configuracion)
/////////////////////////////////////////////////////

//---------------------------------------------------------------------------------//
//								medicamentos
//---------------------------------------------------------------------------------//

class Medicamentos extends Acciones {
	constructor (crud) {
		super(crud)
		this.fila
		this.clase = 'medicamentos'
		this.funcion = 'buscarMedicamentos'
		//-------------------------------
		this.alternar =  [true, 'transparent' , '#fff']
		this.especificos =  ['id_medicamento','nombre']
		this.limitante = 0
		this.boton = ''
		//-------------------------------
	}

	actualizar(datos, params, reposicionar, excepciones) {
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
		        					qs('#tabla-medicamentos tbody').innerHTML = ''
		        					window.lista = JSON.parse(this.responseText)
				        			th.cargarTabla(window.lista, reposicionar)
				        		}
				    		}
					}, 1000)
				} else if (this.responseText.trim() === 'repetido') {
					tools['mensaje'] = 'El registro ya existe'
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

window.medicamentos = new Medicamentos(new Tabla(
	[
		['Código', true, 0],
		['Descripción del Médicamento', true, 1],
		['Status', true, 3],
		['Acciones', false, 0]
	],
	'tabla-medicamentos','busqueda', Number(configuracion.filas),'izquierda','derecha','numeracion',true
))

var estiloBotones = 'margin-right: 2px;height: 29px;display: inline-flex;justify-content: center;align-items: center;color: #fff;';

medicamentos['crud'].cuerpo.push([medicamentos['crud'].columna = medicamentos['crud'].cuerpo.length, [medicamentos['crud'].gSpan(null,null)], [false], ['HTML'], '', 0])
medicamentos['crud'].cuerpo.push([medicamentos['crud'].columna = medicamentos['crud'].cuerpo.length, [medicamentos['crud'].gSpan(null,null)], [false], ['HTML'], '', 1])
medicamentos['crud'].cuerpo.push([medicamentos['crud'].columna = medicamentos['crud'].cuerpo.length, [medicamentos['crud'].gSpan(null,null)], [false], ['HTML'], '', 3])
medicamentos['crud'].cuerpo.push([medicamentos['crud'].columna = medicamentos['crud'].cuerpo.length, [
	medicamentos['crud'].gBt(['editar btn btn-success', 'Editar medicamento'], `<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="pencil-alt" class="svg-inline--fa fa-pencil-alt fa-w-16 iconos" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M497.9 142.1l-46.1 46.1c-4.7 4.7-12.3 4.7-17 0l-111-111c-4.7-4.7-4.7-12.3 0-17l46.1-46.1c18.7-18.7 49.1-18.7 67.9 0l60.1 60.1c18.8 18.7 18.8 49.1 0 67.9zM284.2 99.8L21.6 362.4.4 483.9c-2.9 16.4 11.4 30.6 27.8 27.8l121.5-21.3 262.6-262.6c4.7-4.7 4.7-12.3 0-17l-111-111c-4.8-4.7-12.4-4.7-17.1 0zM124.1 339.9c-5.5-5.5-5.5-14.3 0-19.8l154-154c5.5-5.5 14.3-5.5 19.8 0s5.5 14.3 0 19.8l-154 154c-5.5 5.5-14.3 5.5-19.8 0zM88 424h48v36.3l-64.5 11.3-31.1-31.1L51.7 376H88v48z"></path></svg>`),
	medicamentos['crud'].gBt(['presentacion btn btn-estilizado2', 'Editar presentaciones', estiloBotones], `<svg class="iconos" style="width: 15px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path fill="currentColor" d="M112 32C50.12 32 0 82.12 0 143.1v223.1c0 61.88 50.12 111.1 112 111.1s112-50.12 112-111.1V143.1C224 82.12 173.9 32 112 32zM160 256H64V144c0-26.5 21.5-48 48-48s48 21.5 48 48V256zM299.8 226.2c-3.5-3.5-9.5-3-12.38 .875c-45.25 62.5-40.38 150.1 15.88 206.4c56.38 56.25 144 61.25 206.5 15.88c4-2.875 4.249-8.75 .75-12.25L299.8 226.2zM529.5 207.2c-56.25-56.25-143.9-61.13-206.4-15.87c-4 2.875-4.375 8.875-.875 12.38l210.9 210.7c3.5 3.5 9.375 3.125 12.25-.75C590.8 351.1 585.9 263.6 529.5 207.2z"/></svg>`),
	medicamentos['crud'].gBt(['tratamiento btn btn-estilizado2', 'Editar tratamientos', estiloBotones], `<svg class="iconos" style="width: 15px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path fill="currentColor" d="M256 0v128h128L256 0zM224 128L224 0H48C21.49 0 0 21.49 0 48v416C0 490.5 21.49 512 48 512h288c26.51 0 48-21.49 48-48V160h-127.1C238.3 160 224 145.7 224 128zM288 301.7v36.57C288 345.9 281.9 352 274.3 352L224 351.1v50.29C224 409.9 217.9 416 210.3 416H173.7C166.1 416 160 409.9 160 402.3V351.1L109.7 352C102.1 352 96 345.9 96 338.3V301.7C96 294.1 102.1 288 109.7 288H160V237.7C160 230.1 166.1 224 173.7 224h36.57C217.9 224 224 230.1 224 237.7V288h50.29C281.9 288 288 294.1 288 301.7z"/></svg>`)
], [0,0,0], ['VALUE','VALUE','VALUE'], '', false])

medicamentos['crud']['clase'] = 'medicamentos'
medicamentos['crud']['funcion'] = 'buscarMedicamentos'
medicamentos['crud']['inputHandler'] = [{"input":0}, true]

medicamentos['crud'].botonModoBusqueda("#modo-buscar", 1, [
	['id_medicamento'],
	['id_medicamento','nombre']
], {"mensaje": (e) => {
	if(e.target.opcion === 0) {
		tools['mensaje'] = 'Modo filtro PRECISO seleccionado'
		tools.mensajes(true)
	} else if (e.target.opcion === 1) {
		tools['mensaje'] = 'Modo filtro PARECIDO seleccionado'
		tools.mensajes(true)
	}
}})

medicamentos['crud']['customBodyEvents'] = {
	/* -------------------------------------------------------------------------------------------------*/
	/*           evento que envia los datos del boton de editar del crud al contenedor de edicion       */
	/* -------------------------------------------------------------------------------------------------*/
	"editar": async (e) => {
		if(e.target.classList.contains('editar')) {
			medicamentos.limpiar('.crud-valores', '', {})
			rellenar.contenedores(tools.pariente(e.target, 'TR').sublista, '.crud-valores', {elemento: e.target, id: 'value'}, {
				"contenedorConsulta": async function fn(lista, grupo) {
					var resultado = await tools.fullAsyncQuery('medicamentos', 'estandarGenericos', lista)
					filtrosEditar.estandarizarContenedor(grupo, JSON.parse(resultado), ['id_generico', 'nombre'])
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
	var resultado = await tools.fullAsyncQuery('medicamentos', 'cargarMedicamentos', [])
	medicamentos.cargarTabla(JSON.parse(resultado))
	medicamentos['crud'].botonBuscar('buscar', false) 	
})()

//----------------------------------------------------------------------------------------------------
//										E V E N T O S                                                
//----------------------------------------------------------------------------------------------------
filtros.eventos().checkboxes('status')

/* -------------------------------------------------------------------------------------------------*/
/*   		Evento que refresca la el crud con datos sql*							                */
/* -------------------------------------------------------------------------------------------------*/
qs('#procesar').addEventListener('click', e => {
	medicamentos.spinner('#tabla-medicamentos tbody')
	var peticion = filtros.procesar(tools.fullQuery, 'medicamentos','filtrar')
	peticion.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
        	qs('#tabla-medicamentos tbody').innerHTML = ''
        	medicamentos.cargarTabla(JSON.parse(this.responseText))
        }
    };
})

/* -------------------------------------------------------------------------------------------------*/
/*   		Evento que limpia los datos del contenedor de insertar*                */
/* -------------------------------------------------------------------------------------------------*/
qs('#crud-insertar-limpiar').addEventListener('click', e => {
	medicamentos.limpiar('.nuevos', '', {
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
	var datos = medicamentos.confirmar(e.target, 'editar', 'crud-valores', tools);
	(datos !== '') ? medicamentos.actualizar(datos, ['actualizarMedicamentos', 'cargarMedicamentos', ediPop], true, [["+", "%2B"]]) : '' 
})

///////////////////////////////////////////////////////////////////////////////////////////////////////////
//									INSERTAR FILTROS
filtrosInsertar.eventos().contenedor('cc-insertar-genericos', ['medicamentos', 'comboGenericos', ['', 80]],
	['', [{"atributo": "maxlength", "valor":"100"},{"atributo": "placeholder", "valor":"  Agregar artículo"}], 'height: 50px;', {"minimo": 1, "ocultar": false}], 
	['', '', 'overflow-x: scroll; width: 100%; border: 1px dashed #989898; position: relative; top: 0px;', {"size": 5, "ocultar": true, "absoluto": false}], 
	['insertar-genericos', '', 'position: relative; border: 1px solid #0d6efd; width: 50%; display: flex; max-height: 100%;', {"separador": ' '}], 
'', [0, 2], [true, true, [false, false], true, false, true, true, true, [true, false], false])

///////////////////////////////////////////////////////////////////////////////////////////////////////////
//									EDITAR FILTROS
filtrosEditar.eventos().contenedor('cc-editar-genericos', ['medicamentos', 'comboGenericos', ['', 80]],
	['', [{"atributo": "maxlength", "valor":"100"},{"atributo": "placeholder", "valor":"  Agregar artículo"}], 'height: 50px;', {"minimo": 1, "ocultar": false}], 
	['', '', 'overflow-x: scroll; width: 100%; border: 1px dashed #989898; position: relative; top: 0px;', {"size": 5, "ocultar": true, "absoluto": false}], 
	['insertar-genericos', '', 'position: relative; border: 1px solid #0d6efd; width: 50%; display: flex; max-height: 100%;', {"separador": ' '}], 
'', [0, 2], [true, true, [false, false], true, false, true, true, true, [true, false], false])
											
/* -------------------------------------------------------------------------------------------------*/
/*                    evento que envia los datos a php para la insersión                            */
/* -------------------------------------------------------------------------------------------------*/
qs('#crud-insertar-botones').addEventListener('click', e => {
	if (e.target.classList.contains('insertar')) {
		var datos = medicamentos.confirmar(e.target, 'insertar', 'nuevos', tools)
		if (datos !== '') {
			medicamentos.actualizar(datos, ['crearMedicamentos', 'cargarMedicamentos', insPop], false, [["+", "%2B"]])
		} else {
			tools['mensaje'] = 'Campos vacíos'
			tools.mensajes(false)
		}
	}
})

/* -------------------------------------------------------------------------------------------------*/	
//          evento que envía la ID del crud al boton de eliminar del contenedor
/* -------------------------------------------------------------------------------------------------*/
qs('#tabla-medicamentos').addEventListener('click', e => {
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

qs('#insertar-medicamentos').addEventListener('click', e => {
	window.idSeleccionada = 0
	medicamentos.limpiar('.nuevos', '', {})
	insPop.pop()
})