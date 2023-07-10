
import  {Tabla} from '../js/crud.js';
import  {PopUp, Acciones, Herramientas, Filtros, paginaCargada, Atajos, Rellenar, Reportes} from '../js/main.js';
const decPop = new PopUp('crud-consultar-popup','popup', 'subefecto', true)

const tools = new Herramientas()
window.filtros = new Filtros('medicamentos_dados_pacientes-filtros')
window.filtrosconsultar  = new Filtros('crud-consultar-popup')
/////////////////////////////////////////////////////
window.qs    = document.querySelector.bind(document)
window.qsa   = document.querySelectorAll.bind(document)
/////////////////////////////////////////////////////
window.procesar = true;
window.idEliminar = 0
window.idSeleccionada = 0

window.atajos = new Atajos('Shift', [
		{"elemento": '#busqueda',"ejecuta": 'b', "clean": true, "tarea": "focus"},
		{"elemento": '#insertar-medicamentos_dados_pacientes',"ejecuta": 'n', "clean": true, "tarea": () => {insPop.pop()}}
	])
window.atajos.eventos()

window.cargar = new paginaCargada('#tabla-presupuestos thead .ASC', 'existencia')
window.cargar.revision()

window.cargar = new paginaCargada('#tabla-medicamentos_dados_pacientes thead .ASC', 'existencia')
window.cargar.revision()

window.rellenar = new Rellenar()
window.reportes = new Reportes()

window.contenedoresMapa = [
	['consultar', decPop, 'popup', '']
]

var actuMasiva = qs('#actualizacion-masiva')

/////////////////////////////////////////////////////
var sesiones = await window.sesiones()
/////////////////////////////////////////////////////
//var banderas = JSON.parse(sesiones.usuario.banderas)['recibos']
var configuracion = JSON.parse(sesiones.usuario.configuracion)
/////////////////////////////////////////////////////

//---------------------------------------------------------------------------------//
//								medicamentos_dados_pacientes
//---------------------------------------------------------------------------------//

class Medicamentos_dados_pacientes extends Acciones {
	constructor (crud) {
		super(crud)
		this.fila
		this.clase = 'medicamentos_dados_pacientes'
		this.funcion = 'buscarMedicamentos_dados_pacientes'
		//-------------------------------
		this.alternar =  [true, 'transparent' , '#fff']
		this.especificos =  ['id_historia', 'nume_cedu', 'apel_nomb']
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
		        					qs('#tabla-medicamentos_dados_pacientes tbody').innerHTML = ''
		        					window.lista = JSON.parse(this.responseText)
				        			th.cargarTabla(window.lista, undefined, true)
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

//----------------------------------------------------------------------------------------------------
//										medicamentos_dados_pacientes                                            
//----------------------------------------------------------------------------------------------------
window.medicamentos_dados_pacientes = new Medicamentos_dados_pacientes(new Tabla(
	[
		['No Cédula', true, 1],
		['No Hijo', true, 2],
		['No Historia', true, 0],
		['Apellidos y Nombres del Paciente', true, 4],
		['Acciones', false, 0]
	],
	'tabla-medicamentos_dados_pacientes','busqueda', Number(configuracion.filas),'izquierda','derecha','numeracion',true
))

medicamentos_dados_pacientes['crud'].cuerpo.push([medicamentos_dados_pacientes['crud'].columna = medicamentos_dados_pacientes['crud'].cuerpo.length, [medicamentos_dados_pacientes['crud'].gSpan(null,null)], [false], ['HTML'], '', 1])
medicamentos_dados_pacientes['crud'].cuerpo.push([medicamentos_dados_pacientes['crud'].columna = medicamentos_dados_pacientes['crud'].cuerpo.length, [medicamentos_dados_pacientes['crud'].gSpan(null,null)], [false], ['HTML'], '', 2])
medicamentos_dados_pacientes['crud'].cuerpo.push([medicamentos_dados_pacientes['crud'].columna = medicamentos_dados_pacientes['crud'].cuerpo.length, [medicamentos_dados_pacientes['crud'].gSpan(null,null)], [false], ['HTML'], '', 0])
medicamentos_dados_pacientes['crud'].cuerpo.push([medicamentos_dados_pacientes['crud'].columna = medicamentos_dados_pacientes['crud'].cuerpo.length, [medicamentos_dados_pacientes['crud'].gSpan(null,null)], [false], ['HTML'], '', 4])
medicamentos_dados_pacientes['crud'].cuerpo.push([medicamentos_dados_pacientes['crud'].columna = medicamentos_dados_pacientes['crud'].cuerpo.length, [
		medicamentos_dados_pacientes['crud'].gBt(['consultar btn btn-detalles', 'Consulta historial de medicamentos'], `<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="info" class="svg-inline--fa fa-info fa-w-6 iconos" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 192 512"><path fill="currentColor" d="M20 424.229h20V279.771H20c-11.046 0-20-8.954-20-20V212c0-11.046 8.954-20 20-20h112c11.046 0 20 8.954 20 20v212.229h20c11.046 0 20 8.954 20 20V492c0 11.046-8.954 20-20 20H20c-11.046 0-20-8.954-20-20v-47.771c0-11.046 8.954-20 20-20zM96 0C56.235 0 24 32.235 24 72s32.235 72 72 72 72-32.235 72-72S135.764 0 96 0z"></path></svg>`)
	], [false], ['VALUE'], '', 0])

medicamentos_dados_pacientes['crud']['clase'] = 'medicamentos_dados_pacientes'
medicamentos_dados_pacientes['crud']['funcion'] = 'buscarMedicamentos_dados_pacientes'
medicamentos_dados_pacientes['crud']['inputHandler'] = [{"input":0, 
	"inputProcesado": () => {
		if(!actuMasiva.getAttribute('data-hide')) {
			actuMasiva.removeAttribute('data-hide')
			setTimeout(() => {actuMasiva.removeAttribute('data-invisible')}, 100)
		}
	}
}, true]

medicamentos_dados_pacientes['crud'].botonModoBusqueda("#modo-buscar", 1, [
	['id_historia'],
	['id_historia', 'nume_cedu','apel_nomb']
], {"mensaje": (e) => {
	if(e.target.opcion === 0) {
		tools['mensaje'] = 'Modo filtro PRECISO seleccionado'
		tools.mensajes(true)
	} else if (e.target.opcion === 1) {
		tools['mensaje'] = 'Modo filtro PARECIDO seleccionado'
		tools.mensajes(true)
	}
}})

medicamentos_dados_pacientes['crud']['customBodyEvents'] = {
	/* -------------------------------------------------------------------------------------------------*/
	/*           evento que envia los datos del boton de consultar del crud al contenedor de edicion       */
	/* -------------------------------------------------------------------------------------------------*/
	"consultar": async (e) => {
		if(e.target.classList.contains('consultar')) {
			var sublista = tools.pariente(e.target, 'TR').sublista

			medicamentos_dados_pacientes.limpiar('.crud-valores', '', {})
			medicamentos_dados_pacientes.limpiar('.crud-ordenes', '', {})
			rellenar.contenedores(sublista, '.crud-valores', {elemento: e.target, id: 'value'})

			var resultado = await tools.fullAsyncQuery('medicinas', 'mostrarMedicamentos_dados_pacientes', [sublista.id_historia])
			medicamentos.cargarTabla(JSON.parse(resultado))

			decPop.pop()
		}
	}
};

(async () => {
	var resultado = await tools.fullAsyncQuery('medicinas', 'cargarMedicamentos_dados_pacientes', [])
	medicamentos_dados_pacientes.cargarTabla(JSON.parse(resultado), undefined, true)
	medicamentos_dados_pacientes['crud'].botonBuscar('buscar', false) 	
})()

//----------------------------------------------------------------------------------------------------
//										*MEDICAMENTOS                                            
//----------------------------------------------------------------------------------------------------
class Medicamentos extends Acciones {
	constructor (crud) {
		super(crud)
		this.fila
		this.clase = 'historias'
		this.funcion = 'buscarMedicamentos'
		//-------------------------------
		this.alternar =  [true, 'transparent' , '#fff']
		this.especificos =  ['id_medicamento', 'nombre', 'genericos_nombres', 'fecha']
		this.limitante = 0
		this.boton = ''
		//-------------------------------
		this.div = document.createElement('div')
		this.inputSeleccionado = ''
	}
}

window.medicamentos = new Medicamentos(new Tabla(
	[
		['Medicamento', true, 5],
		['Presentacion', true, 3],
		['Tratamientos', true, 2],
		['Fecha', true, 6]
	],
	'tabla-medicamentos', 'medicamentos-busqueda', -1,'null','null','null',true
))

medicamentos['crud'].cuerpo.push([medicamentos['crud'].columna = medicamentos['crud'].cuerpo.length, [medicamentos['crud'].gSpan(null,null)], [false], ['HTML'], '', 5])
medicamentos['crud'].cuerpo.push([medicamentos['crud'].columna = medicamentos['crud'].cuerpo.length, [medicamentos['crud'].gSpan(null,null)], [false], ['HTML'], '', 3])
medicamentos['crud'].cuerpo.push([medicamentos['crud'].columna = medicamentos['crud'].cuerpo.length, [medicamentos['crud'].gSpan(null,null)], [false], ['HTML'], '', 2])
medicamentos['crud'].cuerpo.push([medicamentos['crud'].columna = medicamentos['crud'].cuerpo.length, [medicamentos['crud'].gSpan(null,null)], [false], ['HTML'], '', 6])

medicamentos.crud['ofv'] = true
medicamentos.crud['ofvh'] = '35vh';

medicamentos.crud.propiedadesTr = {
	"informacion": (e) => {
		var fr = new DocumentFragment(), genericos, th = medicamentos
		var div = th.div.cloneNode(true)

		var d1 = th.div.cloneNode(true)
			d1.insertAdjacentHTML('afterbegin', 'Medicamentos genéricos:')
			d1.setAttribute('style', `min-width:200px; color: #fff; margin-bottom: 3px`)

		var d2 = th.div.cloneNode(true)
			d2.setAttribute('style', `display: flex; flex-direction:column`)

			genericos = JSON.parse(e.sublista.genericos_nombres)

			genericos.forEach((el) => {
				var d = th.div.cloneNode(true)
				d.insertAdjacentHTML('afterbegin', el)
				d.setAttribute('style', `color: #fff; border-top: 1px dashed #fff`)
				d2.appendChild(d)
			});

		div.appendChild(d1)
		div.appendChild(d2)

		div.setAttribute('style', `width:fit-content; text-align: left;font-size: 1.1em; position:fixed; background:#262626; padding: 5px`)
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
};

//----------------------------------------------------------------------------------------------------
//										E V E N T O S                                                
//----------------------------------------------------------------------------------------------------
filtros.eventos().checkboxes('status')

/* -------------------------------------------------------------------------------------------------*/
/*   		Evento que refresca la el crud con datos sql*							                */
/* -------------------------------------------------------------------------------------------------*/
qs('#procesar').addEventListener('click', e => {
	medicamentos_dados_pacientes.spinner('#tabla-medicamentos_dados_pacientes tbody')
	var peticion = filtros.procesar(tools.fullQuery, 'medicamentos_dados_pacientes', 'filtrar')
	peticion.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
        	qs('#tabla-medicamentos_dados_pacientes tbody').innerHTML = ''
        	medicamentos_dados_pacientes.cargarTabla(JSON.parse(this.responseText))
        }
    };
})

/* -------------------------------------------------------------------------------------------------*/
/*   		Evento que envia los datos al metodo de javascript que hace la peticion*                */
/* -------------------------------------------------------------------------------------------------*/
qs('#crud-consultar-botones').addEventListener('click', async e => {

	if (e.target.classList.contains('consultar')) {
		if(window.procesar) {
			window.procesar = false

			tools['mensaje'] = 'Procesando...'
			tools.mensajes(['#ffc107', '#fff'])

			var datos = medicamentos_dados_pacientes.confirmar(e.target, 'consultar', 'crud-ordenes', tools);
			
			if(datos !== '') {

				var resultado = await tools.fullAsyncQuery('medicamentos_dados_pacientes', 'mostrarMedicamentos_dados_pacientes', datos)

				if(!isNaN(resultado)) {

					window.procesar = true
					/*window.reportes.imprimirPDF(`../plantillas/formulas_opticapdf.php?id=${resultado}&pdf=2`)
					*/
					setTimeout(() => {
						tools['mensaje'] = 'exito'
						tools.mensajes(true)
						decPop.pop()
						window.procesar = true
					}, 1000)
				
				} else {
					tools['mensaje'] = 'Error al procesar la petición'
					console.log(resultado)
					tools.mensajes(false)
					window.procesar = true
				}

			} else {
				tools['mensaje'] = 'Campos vacíos'
				tools.mensajes(false)
				window.procesar = true
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

