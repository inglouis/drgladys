import  {Tabla} from '../js/crud.js';
import  {PopUp, Acciones, Herramientas, Filtros, paginaCargada, Rellenar, Atajos} from '../js/main.js';
const ediPop = new PopUp('crud-editar-popup','popup', 'subefecto', true)
const insPop = new PopUp('crud-insertar-popup','popup', 'subefecto', true)

const tools = new Herramientas()
window.tool = new Herramientas()

window.filtros = new Filtros('tratamientos-filtros')
window.filtrosInsertar  = new Filtros('crud-insertar-popup')
window.filtrosEditar  = new Filtros('crud-editar-popup')
/////////////////////////////////////////////////////
window.qs    = document.querySelector.bind(document)
window.qsa   = document.querySelectorAll.bind(document)
/////////////////////////////////////////////////////
window.procesar = true;
window.idSeleccionada = 0
window.idTratamiento = 0

window.cargar = new paginaCargada('#tabla-tratamientos thead .ASC', 'existencia')
window.cargar.revision()

window.rellenar = new Rellenar()

window.contenedoresMapa = [
	['editar', ediPop, 'popup', ''],
	['insertar', insPop, 'popup', 'tratamientos']
]

window.atajos = new Atajos('Shift', [
	{"elemento": '#contenido-contenedor',"ejecuta": 'n', "tarea": () => {insPop.pop()}},
	{"elemento": '#salto',"ejecuta": 'tab', "clean": true, "tarea": "focus"}
])
window.atajos.eventos()

/////////////////////////////////////////////////////
window.URLquery = new URLSearchParams(window. location. search)
var regresarEnConfirmacion = false
/////////////////////////////////////////////////////
if(URLquery.has('id_medicamento')) {

    regresarEnConfirmacion = true
	
	var existencia1 = setInterval(async () => {

		if(window.tratamientos) {
            clearInterval(existencia1);
            //window.medicamentos.crud.reposicionar(Number(URLquery.get('posicion')), true)
            var sublista = window.tool.filtrar(window.tratamientos.crud.lista,Number(URLquery.get('id_medicamento')), ['id_medicamento'], true, 'preciso')[0]

            var boton = document.createElement('button')
            	boton.setAttribute('class', 'editar')
            	boton.value = sublista.id_tratamiento
            	boton.sublista = sublista

            window.tratamientos.crud.customBodyEvents['editar'](boton, true)

			qs('#regresar-medicamentos').href = `../paginas/medicamentos.php?posicion=${URLquery.get('posicion')}&busqueda=${URLquery.get('busqueda')}`

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
//								tratamientos
//---------------------------------------------------------------------------------//

class Tratamientos extends Acciones {
	constructor (crud) {
		super(crud)
		this.fila
		this.clase = 'tratamientos'
		this.funcion = 'buscarTratamientos'
		//-------------------------------
		this.alternar =  [true, '#fff' , '#fff']
		this.especificos =  ['id_tratamiento', 'nombre', 'id_medicamento', 'tratamientos']
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
		        					qs('#tabla-tratamientos tbody').innerHTML = ''
		        					window.lista = JSON.parse(this.responseText)
				        			th.cargarTabla(window.lista, true)
				        		}
				    		}
					}, 1000)
				} else if (this.responseText.trim() === 'repetido') {
					tools['mensaje'] = 'Registro ya existe'
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
//										tratamientos                                            
//----------------------------------------------------------------------------------------------------
window.tratamientos = new Tratamientos(new Tabla(
	[
		['Código', true, 0],
		['Médicamento', true, 4],
		['Status', true, 3],
		['Acciones', false, 0]
	],
	'tabla-tratamientos','busqueda', Number(configuracion.filas),'izquierda','derecha','numeracion',true
))

tratamientos['crud'].cuerpo.push([tratamientos['crud'].columna = tratamientos['crud'].cuerpo.length, [tratamientos['crud'].gSpan(null,null)], [false], ['HTML'], '', 0])
tratamientos['crud'].cuerpo.push([tratamientos['crud'].columna = tratamientos['crud'].cuerpo.length, [tratamientos['crud'].gSpan(null,null)], [false], ['HTML'], '', 4])
tratamientos['crud'].cuerpo.push([tratamientos['crud'].columna = tratamientos['crud'].cuerpo.length, [tratamientos['crud'].gSpan(null,null)], [false], ['HTML'], '', 3])
tratamientos['crud'].cuerpo.push([tratamientos['crud'].columna = tratamientos['crud'].cuerpo.length, [
		tratamientos['crud'].gBt('editar btn btn-success', `<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="pencil-alt" class="svg-inline--fa fa-pencil-alt fa-w-16 iconos" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M497.9 142.1l-46.1 46.1c-4.7 4.7-12.3 4.7-17 0l-111-111c-4.7-4.7-4.7-12.3 0-17l46.1-46.1c18.7-18.7 49.1-18.7 67.9 0l60.1 60.1c18.8 18.7 18.8 49.1 0 67.9zM284.2 99.8L21.6 362.4.4 483.9c-2.9 16.4 11.4 30.6 27.8 27.8l121.5-21.3 262.6-262.6c4.7-4.7 4.7-12.3 0-17l-111-111c-4.8-4.7-12.4-4.7-17.1 0zM124.1 339.9c-5.5-5.5-5.5-14.3 0-19.8l154-154c5.5-5.5 14.3-5.5 19.8 0s5.5 14.3 0 19.8l-154 154c-5.5 5.5-14.3 5.5-19.8 0zM88 424h48v36.3l-64.5 11.3-31.1-31.1L51.7 376H88v48z"></path></svg>`)
	], [false], ['VALUE'], '', 1])

tratamientos['crud']['clase'] = 'tratamientos'
tratamientos['crud']['funcion'] = 'buscarTratamientos'

tratamientos['crud']['customBodyEvents'] = {
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

			tratamientos.limpiar('.crud-valores', '', {})
			rellenar.contenedores(sublista, '.crud-valores', {elemento: button, id: 'value'})

			var trata = []
			JSON.parse(sublista.tratamientos).forEach((el, i) => {
				trata.push({"id_tratamiento": i, "tratamiento": el})
				window.idTratamiento = i
			}) 

			tratamientosEditar.cargarTabla(trata)
			ediPop.pop()
		}
	}
};

tratamientos['crud'].botonModoBusqueda("#modo-buscar", 1, [
	['id_medicamento'],
	['id_tratamiento', 'nombre', 'id_medicamento', 'tratamientos']
], {"mensaje": (e) => {
	if(e.target.opcion === 0) {
		tools['mensaje'] = 'Modo filtro PRECISO seleccionado'
		tools.mensajes(true)
	} else if (e.target.opcion === 1) {
		tools['mensaje'] = 'Modo filtro PARECIDO seleccionado'
		tools.mensajes(true)
	}
}});

(async () => {
	var resultado = await tools.fullAsyncQuery('tratamientos', 'cargarTratamientos', [])
	tratamientos.cargarTabla(JSON.parse(resultado), undefined, true)
	tratamientos['crud'].botonBuscar('buscar', false) 	
})()

//----------------------------------------------------------------------------------------------------
//										*TRATAMIENTOS-EDITAR                                     
//----------------------------------------------------------------------------------------------------
class TratamientosEditar extends Acciones {
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
	}

	window.tratamientosEditar = new TratamientosEditar(new Tabla(
		[
			['Descripción', true, 1],
			['Eliminar', false, 0]
		],
		'tabla-tratamientos-editar','tratamientos-busqueda-editar', -1,'null','null','null',true
	))

	tratamientosEditar['crud'].cuerpo.push([tratamientosEditar['crud'].columna = tratamientosEditar['crud'].cuerpo.length, [tratamientosEditar['crud'].gInp('input upper', 'text', 'Descripción del tratamiento', 
	[{"atributo": "titulo", "valor":""}, {"atributo": "placeholder", "valor":"Contenido..."}]
	, 'width: 100%')], [false], ['VALUE'], '', 1])

	tratamientosEditar['crud'].cuerpo.push([tratamientosEditar['crud'].columna = tratamientosEditar['crud'].cuerpo.length, [
		tratamientosEditar['crud'].gBt(['eliminar btn btn-danger', 'Eliminar fila', 'width: 25px; height: 25px;'], `X`)
	], [false], ['VALUE'], '', 0])

	tratamientosEditar['crud']['inputHandler'] = [{"input":0}, true]
	tratamientosEditar['crud']['desplazamientoActivo'] = [true, false, true, false]
	tratamientosEditar['crud']['ofv'] = true
	tratamientosEditar['crud']['ofvh'] = '300px';

	tratamientosEditar['crud'].inputEliminar('eliminar', '', [
		function fn(params) {
			tools['mensaje'] = 'Procesando...'
	        tools.mensajes(['#ffc107', '#fff'])
	    },
	    function fn(params) {
			tools['mensaje'] = 'Fila eliminada'
	        tools.mensajes(true)
	    }
	]) 

	qs('#nuevo-tratamiento-editar').addEventListener('click', e => {
		window.idTratamiento = window.idTratamiento + 1
		tratamientosEditar.crud.lista.push({"id_tratamiento": window.idTratamiento, "tratamiento": ''})
		tratamientosEditar.cargarTabla(tratamientosEditar.crud.lista)
	})

//----------------------------------------------------------------------------------------------------
//										*TRATAMIENTOS-EDITAR                                     
//----------------------------------------------------------------------------------------------------
class TratamientosInsertar extends Acciones {
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
	}

	window.tratamientosInsertar = new TratamientosInsertar(new Tabla(
		[
			['Descripción', true, 1],
			['Eliminar', false, 0]
		],
		'tabla-tratamientos-insertar','tratamientos-busqueda-insertar', -1,'null','null','null',true
	))

	tratamientosInsertar['crud'].cuerpo.push([tratamientosInsertar['crud'].columna = tratamientosInsertar['crud'].cuerpo.length, [tratamientosInsertar['crud'].gInp('input upper', 'text', 'Descripción del tratamiento', 
	[{"atributo": "titulo", "valor":""}, {"atributo": "placeholder", "valor":"Contenido..."}]
	, 'width: 100%')], [false], ['VALUE'], '', 1])

	tratamientosInsertar['crud'].cuerpo.push([tratamientosInsertar['crud'].columna = tratamientosInsertar['crud'].cuerpo.length, [
		tratamientosInsertar['crud'].gBt(['eliminar btn btn-danger', 'Eliminar fila', 'width: 25px; height: 25px;'], `X`)
	], [false], ['VALUE'], '', 0])

	tratamientosInsertar['crud']['inputHandler'] = [{"input":0}, true]
	tratamientosInsertar['crud']['desplazamientoActivo'] = [true, false, true, false]
	tratamientosInsertar['crud']['ofv'] = true
	tratamientosInsertar['crud']['ofvh'] = '300px';

	tratamientosInsertar['crud'].inputEliminar('eliminar', '', [
		function fn(params) {
			tools['mensaje'] = 'Procesando...'
	        tools.mensajes(['#ffc107', '#fff'])
	    },
	    function fn(params) {
			tools['mensaje'] = 'Fila eliminada'
	        tools.mensajes(true)
	    }
	]) 

	qs('#nuevo-tratamiento-insertar').addEventListener('click', e => {
		window.idTratamiento = window.idTratamiento + 1
		tratamientosInsertar.crud.lista.push({"id_tratamiento": window.idTratamiento, "tratamiento": ''})
		tratamientosInsertar.cargarTabla(tratamientosInsertar.crud.lista)
	})

//----------------------------------------------------------------------------------------------------
//										E V E N T O S                                                
//----------------------------------------------------------------------------------------------------
///////////////////////////////////////////////////////////////////////////////////////////////////////////
//									FILTROS
filtros.eventos().checkboxes('status')

///////////////////////////////////////////////////////////////////////////////////////////////////////////
//									INSERTAR FILTROS
filtrosInsertar.eventos().combo('cc-medicamentos-insertar', ['tratamientos', 'comboMedicamentos', ['', '']], false, [])
/* -------------------------------------------------------------------------------------------------*/
/*   		Evento que refresca la el crud con datos sql*							                */
/* -------------------------------------------------------------------------------------------------*/
qs('#procesar').addEventListener('click', e => {
	tratamientos.spinner('#tabla-tratamientos tbody')
	var peticion = filtros.procesar(tools.fullQuery, 'tratamientos','filtrar')
	peticion.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
        	qs('#tabla-tratamientos tbody').innerHTML = ''
        	tratamientos.cargarTabla(JSON.parse(this.responseText))
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

			tools['mensaje'] = 'Procesando...'
			tools.mensajes(['#ffc107', '#fff'])

			var datos = tratamientos.confirmar(e.target, 'editar', 'crud-valores', tools);
			
			if(datos !== '') {

				var lista = tools.copiaLista(tratamientosEditar.crud.lista)
					lista = lista.filter((e) => { if(e['tratamiento'].trim() !== '') { return e }})
				
				if(lista.length < 1) {lista = []}

				datos.splice(datos.length - 1, 0, lista)

				var resultado = await tools.fullAsyncQuery('tratamientos', 'actualizarTratamientos', datos)

				if(resultado.trim() === 'exito') {

						tools['mensaje'] = 'Petición realizada con éxito'
						tools.mensajes(true)
						ediPop.pop()
						window.procesar = true

						var resultado = JSON.parse(await tools.fullAsyncQuery('tratamientos', 'cargarTratamientos', []))
						tratamientos.cargarTabla(resultado, true)

						if (regresarEnConfirmacion) {
	        				window.location.href = `../paginas/medicamentos.php?posicion=${URLquery.get('posicion')}&busqueda=${URLquery.get('busqueda')}`
	        			}
				
				} else {
					tools['mensaje'] = 'Error al procesar la petición'
					console.log(resultado)
					tools.mensajes(false)
					window.procesar = true
				}

			}

		} else {
			tools['mensaje'] = 'Procesando...'
			tools.mensajes(['#ffc107', '#fff'])
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

			tools['mensaje'] = 'Procesando...'
			tools.mensajes(['#ffc107', '#fff'])

			var datos = tratamientos.confirmar(e.target, 'insertar', 'nuevos', tools);
			
			if(datos !== '') {

				var lista = tools.copiaLista(tratamientosInsertar.crud.lista)
					lista = lista.filter((e) => { if(e['tratamiento'].trim() !== '') { return e }})
				
				if(lista.length < 1) {lista = []}

				datos.splice(datos.length, 0, lista)

				var resultado = await tools.fullAsyncQuery('tratamientos', 'crearTratamientos', datos)

				if(resultado.trim() === 'exito') {

						tools['mensaje'] = 'Petición realizada con éxito'
						tools.mensajes(true)
						insPop.pop()
						window.procesar = true

						var resultado = JSON.parse(await tools.fullAsyncQuery('tratamientos', 'cargarTratamientos', []))
						tratamientos.cargarTabla(resultado)
				
				} else if (resultado.trim() === 'repetido') {

					tools['mensaje'] = 'Medicamento repetido'
					tools.mensajes(false)
					window.procesar = true

				} else {

					tools['mensaje'] = 'Error al procesar la petición'
					console.log(resultado)
					tools.mensajes(false)
					window.procesar = true

				}

			}

		} else {
			tools['mensaje'] = 'Procesando...'
			tools.mensajes(['#ffc107', '#fff'])
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

qs('#insertar-tratamientos').addEventListener('click', e => {
	window.idSeleccionada = 0
	window.idTratamiento = 0
	tratamientos.limpiar('.nuevos', '', {"asegurar": () => {return '#crud-insertar-pop'}})
	insPop.pop()
})