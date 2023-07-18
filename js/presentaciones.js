import  {Tabla} from '../js/crud.js';
import  {PopUp, Acciones, Herramientas, Filtros, paginaCargada, Rellenar, Atajos} from '../js/main.js';
const ediPop = new PopUp('crud-editar-popup','popup', 'subefecto', true)
const insPop = new PopUp('crud-insertar-popup','popup', 'subefecto', true)

const tools = new Herramientas()
window.tool = new Herramientas()

window.filtros = new Filtros('presentaciones-filtros')
window.filtrosInsertar  = new Filtros('crud-insertar-popup')
window.filtrosEditar  = new Filtros('crud-editar-popup')
/////////////////////////////////////////////////////
window.qs    = document.querySelector.bind(document)
window.qsa   = document.querySelectorAll.bind(document)
/////////////////////////////////////////////////////
window.procesar = true;
window.idSeleccionada = 0
window.idPresentacion = 0

window.cargar = new paginaCargada('#tabla-presentaciones thead .ASC', 'existencia')
window.cargar.revision()

window.rellenar = new Rellenar()

window.contenedoresMapa = [
	['editar', ediPop, 'popup', ''],
	['insertar', insPop, 'popup', 'presentaciones']
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

		if(window.presentaciones) {
            clearInterval(existencia1);
           

            //window.medicamentos.crud.reposicionar(Number(URLquery.get('posicion')), true)
            var sublista = window.tool.filtrar(window.presentaciones.crud.lista,Number(URLquery.get('id_medicamento')), ['id_medicamento'], true, 'preciso')[0]

            var boton = document.createElement('button')
            	boton.setAttribute('class', 'editar')
            	boton.value = sublista.id_presentacion
            	boton.sublista = sublista

            window.presentaciones.crud.customBodyEvents['editar'](boton, true)

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
//								presentaciones
//---------------------------------------------------------------------------------//

class Presentaciones extends Acciones {
	constructor (crud) {
		super(crud)
		this.fila
		this.clase = 'presentaciones'
		this.funcion = 'buscarpresentaciones'
		//-------------------------------
		this.alternar =  [true, '#fff' , '#fff']
		this.especificos =  ['id_presentacion', 'nombre', 'id_medicamento', 'presentaciones']
		this.limitante = 0
		this.boton = ''
		//-------------------------------
	}

}

//----------------------------------------------------------------------------------------------------
//										presentaciones                                            
//----------------------------------------------------------------------------------------------------
window.presentaciones = new Presentaciones(new Tabla(
	[
		['Código', true, 0],
		['Médicamento', true, 4],
		['Status', true, 3],
		['Acciones', false, 0]
	],
	'tabla-presentaciones','busqueda', Number(configuracion.filas),'izquierda','derecha','numeracion',true
))

presentaciones['crud'].cuerpo.push([presentaciones['crud'].columna = presentaciones['crud'].cuerpo.length, [presentaciones['crud'].gSpan(null,null)], [false], ['HTML'], '', 0])
presentaciones['crud'].cuerpo.push([presentaciones['crud'].columna = presentaciones['crud'].cuerpo.length, [presentaciones['crud'].gSpan(null,null)], [false], ['HTML'], '', 4])
presentaciones['crud'].cuerpo.push([presentaciones['crud'].columna = presentaciones['crud'].cuerpo.length, [presentaciones['crud'].gSpan(null,null)], [false], ['HTML'], '', 3])
presentaciones['crud'].cuerpo.push([presentaciones['crud'].columna = presentaciones['crud'].cuerpo.length, [
		presentaciones['crud'].gBt('editar btn btn-success', `<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="pencil-alt" class="svg-inline--fa fa-pencil-alt fa-w-16 iconos" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M497.9 142.1l-46.1 46.1c-4.7 4.7-12.3 4.7-17 0l-111-111c-4.7-4.7-4.7-12.3 0-17l46.1-46.1c18.7-18.7 49.1-18.7 67.9 0l60.1 60.1c18.8 18.7 18.8 49.1 0 67.9zM284.2 99.8L21.6 362.4.4 483.9c-2.9 16.4 11.4 30.6 27.8 27.8l121.5-21.3 262.6-262.6c4.7-4.7 4.7-12.3 0-17l-111-111c-4.8-4.7-12.4-4.7-17.1 0zM124.1 339.9c-5.5-5.5-5.5-14.3 0-19.8l154-154c5.5-5.5 14.3-5.5 19.8 0s5.5 14.3 0 19.8l-154 154c-5.5 5.5-14.3 5.5-19.8 0zM88 424h48v36.3l-64.5 11.3-31.1-31.1L51.7 376H88v48z"></path></svg>`)
	], [false], ['VALUE'], '', 1])

presentaciones['crud']['clase'] = 'presentaciones'
presentaciones['crud']['funcion'] = 'buscarpresentaciones'

presentaciones['crud']['customBodyEvents'] = {
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

			presentaciones.limpiar('.crud-valores', '', {})
			rellenar.contenedores(sublista, '.crud-valores', {elemento: button, id: 'value'})

			var trata = []
			JSON.parse(sublista.presentaciones).forEach((el, i) => {
				trata.push({"id_presentacion": i, "presentacion": el})
				window.idPresentacion = i
			}) 

			presentacionesEditar.cargarTabla(trata)
			ediPop.pop()
		}
	}
};

presentaciones['crud'].botonModoBusqueda("#modo-buscar", 1, [
	['id_medicamento'],
	['id_presentacion', 'nombre', 'id_medicamento', 'presentaciones']
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
	var resultado = await tools.fullAsyncQuery('presentaciones', 'cargarPresentaciones', [])
	presentaciones.cargarTabla(JSON.parse(resultado), true)
	presentaciones['crud'].botonBuscar('buscar', false) 	
})()

//----------------------------------------------------------------------------------------------------
//										*presentaciones-EDITAR                                     
//----------------------------------------------------------------------------------------------------
class PresentacionesEditar extends Acciones {
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

	window.presentacionesEditar = new PresentacionesEditar(new Tabla(
		[
			['Descripción', true, 1],
			['Eliminar', false, 0]
		],
		'tabla-presentaciones-editar','presentaciones-busqueda-editar', -1,'null','null','null',true
	))

	presentacionesEditar['crud'].cuerpo.push([presentacionesEditar['crud'].columna = presentacionesEditar['crud'].cuerpo.length, [presentacionesEditar['crud'].gInp('input upper', 'text', 'Descripción del presentacion', 
	[{"atributo": "titulo", "valor":""}, {"atributo": "placeholder", "valor":"Contenido..."}]
	, 'width: 100%')], [false], ['VALUE'], '', 1])

	presentacionesEditar['crud'].cuerpo.push([presentacionesEditar['crud'].columna = presentacionesEditar['crud'].cuerpo.length, [
		presentacionesEditar['crud'].gBt(['eliminar btn btn-danger', 'Eliminar fila', 'width: 25px; height: 25px;'], `X`)
	], [false], ['VALUE'], '', 0])

	presentacionesEditar['crud']['inputHandler'] = [{"input":0}, true]
	presentacionesEditar['crud']['desplazamientoActivo'] = [true, false, true, false]
	presentacionesEditar['crud']['ofv'] = true
	presentacionesEditar['crud']['ofvh'] = '300px';

	presentacionesEditar['crud'].inputEliminar('eliminar', '', [
		function fn(params) {
			tools['mensaje'] = 'Procesando...'
	        tools.mensajes(['#ffc107', '#fff'])
	    },
	    function fn(params) {
			tools['mensaje'] = 'Fila eliminada'
	        tools.mensajes(true)
	    }
	]) 

	qs('#nuevo-presentacion-editar').addEventListener('click', e => {
		window.idPresentacion = window.idPresentacion + 1
		presentacionesEditar.crud.lista.push({"id_presentacion": window.idPresentacion, "presentacion": ''})
		presentacionesEditar.cargarTabla(presentacionesEditar.crud.lista)
	})

//----------------------------------------------------------------------------------------------------
//										*presentaciones-EDITAR                                     
//----------------------------------------------------------------------------------------------------
class PresentacionesInsertar extends Acciones {
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

	window.presentacionesInsertar = new PresentacionesInsertar(new Tabla(
		[
			['Descripción', true, 1],
			['Eliminar', false, 0]
		],
		'tabla-presentaciones-insertar','presentaciones-busqueda-insertar', -1,'null','null','null',true
	))

	presentacionesInsertar['crud'].cuerpo.push([presentacionesInsertar['crud'].columna = presentacionesInsertar['crud'].cuerpo.length, [presentacionesInsertar['crud'].gInp('input upper', 'text', 'Descripción del presentacion', 
	[{"atributo": "titulo", "valor":""}, {"atributo": "placeholder", "valor":"Contenido..."}]
	, 'width: 100%')], [false], ['VALUE'], '', 1])

	presentacionesInsertar['crud'].cuerpo.push([presentacionesInsertar['crud'].columna = presentacionesInsertar['crud'].cuerpo.length, [
		presentacionesInsertar['crud'].gBt(['eliminar btn btn-danger', 'Eliminar fila', 'width: 25px; height: 25px;'], `X`)
	], [false], ['VALUE'], '', 0])

	presentacionesInsertar['crud']['inputHandler'] = [{"input":0}, true]
	presentacionesInsertar['crud']['desplazamientoActivo'] = [true, false, true, false]
	presentacionesInsertar['crud']['ofv'] = true
	presentacionesInsertar['crud']['ofvh'] = '300px';

	presentacionesInsertar['crud'].inputEliminar('eliminar', '', [
		function fn(params) {
			tools['mensaje'] = 'Procesando...'
	        tools.mensajes(['#ffc107', '#fff'])
	    },
	    function fn(params) {
			tools['mensaje'] = 'Fila eliminada'
	        tools.mensajes(true)
	    }
	]) 

	qs('#nuevo-presentacion-insertar').addEventListener('click', e => {
		window.idPresentacion = window.idPresentacion + 1
		presentacionesInsertar.crud.lista.push({"id_presentacion": window.idPresentacion, "presentacion": ''})
		presentacionesInsertar.cargarTabla(presentacionesInsertar.crud.lista)
	})

//----------------------------------------------------------------------------------------------------
//										E V E N T O S                                                
//----------------------------------------------------------------------------------------------------
///////////////////////////////////////////////////////////////////////////////////////////////////////////
//									FILTROS
filtros.eventos().checkboxes('status')

///////////////////////////////////////////////////////////////////////////////////////////////////////////
//									INSERTAR FILTROS
filtrosInsertar.eventos().combo('cc-medicamentos-insertar', ['presentaciones', 'comboMedicamentos', ['', '']], false, [])
/* -------------------------------------------------------------------------------------------------*/
/*   		Evento que refresca la el crud con datos sql*							                */
/* -------------------------------------------------------------------------------------------------*/
qs('#procesar').addEventListener('click', e => {
	presentaciones.spinner('#tabla-presentaciones tbody')
	var peticion = filtros.procesar(tools.fullQuery, 'presentaciones','filtrar')
	peticion.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
        	qs('#tabla-presentaciones tbody').innerHTML = ''
        	presentaciones.cargarTabla(JSON.parse(this.responseText))
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

			var datos = presentaciones.confirmar(e.target, 'editar', 'crud-valores', tools);

			if(datos !== '') {

				var lista = tools.copiaLista(presentacionesEditar.crud.lista)
					lista = lista.filter((e) => { if(e['presentacion'].trim() !== '') { return e }})
				
				if(lista.length < 1) {lista = []}

				datos.splice(datos.length - 1, 0, lista)

				var resultado = await tools.fullAsyncQuery('presentaciones', 'actualizarPresentaciones', datos)

				if(resultado.trim() === 'exito') {

						tools['mensaje'] = 'Petición realizada con éxito'
						tools.mensajes(true)
						ediPop.pop()
						window.procesar = true

						var resultado = JSON.parse(await tools.fullAsyncQuery('presentaciones', 'cargarPresentaciones', []))
						presentaciones.cargarTabla(resultado, true)

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

			var datos = presentaciones.confirmar(e.target, 'insertar', 'nuevos', tools);
			
			if(datos !== '') {

				var lista = tools.copiaLista(presentacionesInsertar.crud.lista)
					lista = lista.filter((e) => { if(e['presentacion'].trim() !== '') { return e }})
				
				if(lista.length < 1) {lista = []}

				datos.splice(datos.length, 0, lista)

				var resultado = await tools.fullAsyncQuery('presentaciones', 'crearPresentaciones', datos)

				if(resultado.trim() === 'exito') {

						tools['mensaje'] = 'Petición realizada con éxito'
						tools.mensajes(true)
						insPop.pop()
						window.procesar = true

						var resultado = JSON.parse(await tools.fullAsyncQuery('presentaciones', 'cargarPresentaciones', []))
						presentaciones.cargarTabla(resultado)
				
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

qs('#insertar-presentaciones').addEventListener('click', e => {
	window.idSeleccionada = 0
	window.idPresentacion = 0
	presentaciones.limpiar('.nuevos', '', {"asegurar": () => {return '#crud-insertar-pop'}})
	insPop.pop()
})