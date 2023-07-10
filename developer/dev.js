/////////////////////////////////////////////////////
import  {Tabla} from '../js/crud.js';
import {Herramientas, PopUp, Acciones, Rellenar, Filtros} from '../js/main.js'
const tools  = new Herramientas()
const ediPop = new PopUp('crud-editar-popup','popup', 'subefecto', true)

function toolsMensaje(imprimir, instruccion, consola) {

	tools['mensaje'] = imprimir
	tools.mensajes(instruccion);
	
	(consola !== false) ? console.log(consola) : '';

	window.procesar = true

}
/////////////////////////////////////////////////////
//Binds
window.qs    = document.querySelector.bind(document)
window.qsa   = document.querySelectorAll.bind(document)
/////////////////////////////////////////////////////
window.procesar = true;
window.codigoEmpresa = 0;
window.parcheSeleccionado = []
window.idSeleccionada = 0
/////////////////////////////////////////////////////
window.rellenar = new Rellenar()
/////////////////////////////////////////////////////
window.contenedoresMapaComplejos = [
	['editar', ediPop, 'popup', '']
]
/////////////////////////////////////////////////////
window.filtrosUsuario = new Filtros('dev-usuarios')
window.filtrosBanderas = new Filtros('dev-banderas')
/////////////////////////////////////////////////////
//---------------------------------------------------------------------------------//
//								CONTROLADOR DEV GENERAL
//---------------------------------------------------------------------------------//

class Dev {

	constructor() {

	}

	async parche(valores) {
		window.procesar = false

		var resultado = await tools.fullAsyncQuery('dev', 'insertarParche', valores) //agregar expcecion de aspersand

	    if (resultado.trim() === 'exito') {
	    	window.procesar = true
        	tools['mensaje'] = 'Parche anunciado'
        	tools.mensajes(true) 

        	qsa(".parche").forEach((e, i) => {
				e.value = ''
			})

			var resultado = JSON.parse(await tools.fullAsyncQuery('parches', 'cargarParches', []))
			parches.cargarTabla(resultado)

	    } else {
			tools['mensaje'] = 'Error al procesar el usuario'
			tools.mensajes(false)
			window.procesar = true
          	console.log(resultado)
		}
	}

	usuarios () {

	}

}

const dev = new Dev()

//---------------------------------------------------------------------------------//
//								PARCHES
//---------------------------------------------------------------------------------//

class Parches extends Acciones {
	constructor (crud) {
		super(crud)
		this.fila
		this.clase = 'parches'
		this.funcion = 'buscarParches'
		//-------------------------------
		this.alternar = ''
		this.especificos =  ['id_parches', 'titulo']
		this.limitante = 0
		this.boton = ''
		//-------------------------------
		this.div = document.createElement('div')
		//this.contenido = qs('#sobre-contenedor').content.querySelector('.contenido-sobre').cloneNode(true)
	}
}

window.parches = new Parches(new Tabla(
	[
		['Parche', true, 1],
  		['Fecha', true, 3],
  		['Acciones', false, 0]
	],
	'tabla-parches','busqueda', 6,'izquierda','derecha','numeracion',true
))

parches['crud'].cuerpo.push([parches['crud'].columna = parches['crud'].cuerpo.length, [parches['crud'].gDiv(null,null)], [false], ['HTML'], '', 1])
parches['crud'].cuerpo.push([parches['crud'].columna = parches['crud'].cuerpo.length, [parches['crud'].gSpan(null,null)], [false], ['HTML'], '', 3])
parches['crud'].cuerpo.push([parches['crud'].columna = parches['crud'].cuerpo.length, [
	parches['crud'].gBt('editar btn btn-success', `<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="pencil-alt" class="svg-inline--fa fa-pencil-alt fa-w-16 iconos" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M497.9 142.1l-46.1 46.1c-4.7 4.7-12.3 4.7-17 0l-111-111c-4.7-4.7-4.7-12.3 0-17l46.1-46.1c18.7-18.7 49.1-18.7 67.9 0l60.1 60.1c18.8 18.7 18.8 49.1 0 67.9zM284.2 99.8L21.6 362.4.4 483.9c-2.9 16.4 11.4 30.6 27.8 27.8l121.5-21.3 262.6-262.6c4.7-4.7 4.7-12.3 0-17l-111-111c-4.8-4.7-12.4-4.7-17.1 0zM124.1 339.9c-5.5-5.5-5.5-14.3 0-19.8l154-154c5.5-5.5 14.3-5.5 19.8 0s5.5 14.3 0 19.8l-154 154c-5.5 5.5-14.3 5.5-19.8 0zM88 424h48v36.3l-64.5 11.3-31.1-31.1L51.7 376H88v48z"></path></svg>`)
], [false], ['VALUE'], '', 0])

parches['crud']['customBodyEvents'] = {
	/* -------------------------------------------------------------------------------------------------*/
	/*           evento que envia los datos del boton de editar del crud al contenedor de edicion       */
	/* -------------------------------------------------------------------------------------------------*/
	"editar": async (e) => {
		if(e.target.classList.contains('editar')) {
			var sublista = tools.pariente(e.target, 'TR').sublista

			window.parcheSeleccionado = sublista

			parches.limpiar('.parches-editar', '', {})
			rellenar.contenedores(sublista, '.parches-editar', {elemento: e.target, id: 'value'})

			qs('#crud-dev-parche-vivo').innerHTML = ''
			qs('#crud-dev-parche-vivo').insertAdjacentHTML('afterbegin', sublista.descripcion)

			ediPop.pop()
		}
	}
};

parches['crud']['propiedadesTr'] = {
	"cargarContenido": (e) => {
		// var fr = new DocumentFragment()
				
		// var div = document.createElement('div')
		// 	div.setAttribute('class', 'parches-notas')
		// 	div.insertAdjacentHTML('afterbegin', `${e.sublista['titulo']} ${e.sublista['descripcion']}`)
		// fr.appendChild(div)

		// e.querySelector('.parche-contenedor').appendChild(fr)

	}
};

(async () => {
	var resultado = await tools.fullAsyncQuery('parches', 'cargarParches', [])
	parches.cargarTabla(JSON.parse(resultado))
	parches['crud'].botonBuscar('buscar', false) 	
})()



/* -------------------------------------------------------------------------------------------------*/	
//                 generador de eventos complejos de los botones de cada contenedor
/* -------------------------------------------------------------------------------------------------*/

var comboRoles = JSON.parse(await tools.fullAsyncQuery('dev', 'comboRoles', []))

filtrosUsuario.eventos().combo('cc-rol-dev', ['dev', 'comboRoles', ['', '']], false, [], undefined, undefined, {"lista": comboRoles, "navegacionVertical": true, "motorBusqueda": true})
filtrosBanderas.eventos().combo('cc-formularios-dev', ['dev', 'comboFormularios', ['', '']], false, [])
/* -------------------------------------------------------------------------------------------------*/	
//                 generador de eventos complejos de los botones de cada contenedor
/* -------------------------------------------------------------------------------------------------*/
contenedoresMapaComplejos.forEach((e,i) => {
	if(qs(`#crud-${e[0]}-cerrar`)) {
		qs(`#crud-${e[0]}-cerrar`).addEventListener('click', () => {	
			e[1].pop()
			window.procesar = true
		})
	}

	if(qs(`#crud-${e[0]}-botones`)) {
		qs(`#crud-${e[0]}-botones`).addEventListener('click', (el) => {
			if(el.target.classList.contains('cerrar')) {
				e[1].pop()
				window.procesar = true
			}	
		})
	}
});

var contenedoresMapaComplejosOpciones = {
	"string": (e) => {
		if(qs(`#crud-${e[3]}-popup`)) {
			if(qs(`#crud-${e[3]}-popup`).classList.contains('popup-oculto')) {
				e[1].pop()
				window.procesar = true
			}
		} else {
			e[1].pop()
			window.procesar = true
		} 
	},
	"object": (e) => {
		var cerrar = true
		e[3].forEach((el,i) => {
			if(qs(`#crud-${el}-popup`).classList.contains('popup-activo')) {
				cerrar = false
			}
		})
		if (cerrar) {
			e[1].pop()
			window.procesar = true
		}
	}
}

window.addEventListener('keyup', (el) => {
	contenedoresMapaComplejos.forEach((e,i) => {
		if (el.keyCode === 27 && qs(`#crud-${e[0]}-popup`).classList.contains(`${e[2]}-activo`) && e[0] !== 'bloqueo') {/*hardcoded as fack booooi*/	
			contenedoresMapaComplejosOpciones[typeof e[3]](e) 	
			if(medicamentos.inputSeleccionado !== '') {
				medicamentos.inputSeleccionado.focus()
			}
		}
	})
})

/* -------------------------------------------------------------------------------------------------*/
/*   		Evento que envia los datos al metodo de javascript que hace la peticion*                */
/* -------------------------------------------------------------------------------------------------*/
var excepciones = [["&", "%26"]]

qs('#crud-editar-botones').addEventListener('click', async e => {
	if(e.target.classList.contains('editar')) {
		if(window.procesar) {
			window.procesar = false

			tools['mensaje'] = 'Procesando...'
			tools.mensajes(['#ffc107', '#fff'])

			var datos = parches.confirmar(e.target, 'editar', 'parches-editar', tools);
			
			// excepciones.forEach((e,i) => {
		 //    	datos[1] = datos[1].replaceAll(e[0], e[1]);
		 //    });

			if(datos !== '') {

				var resultado = await tools.fullAsyncQuery('dev', 'actualizarParches', datos, [["&", "%26"]])

				if(resultado.trim() === 'exito') {

						tools['mensaje'] = 'Petición realizada con éxito'
						tools.mensajes(true)
						window.procesar = true

						var resultado = JSON.parse(await tools.fullAsyncQuery('parches', 'cargarParches', []))
						parches.cargarTabla(resultado)
				
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
//                       eventos exclusivos de el archivo js
/* -------------------------------------------------------------------------------------------------*/
qs('#dev-parches-cargar').addEventListener('click', e=> {
	var parche = qsa(".parche")
	var datos  = []
	var procesar = true

	parche.forEach((e, i) => {
		if(e.value === '') {
			procesar = false
			tools.alertaInput(e)
		} else {
			datos.push(e.value)
		}
	});

	if(procesar === true) {
		dev.parche(datos)
	}
})

//---------------------------------------------------------------------
function typeInTextarea(newText, el = document.activeElement) {
  const [start, end] = [el.selectionStart, el.selectionEnd];
  el.setRangeText(newText, start, end, 'select');
}

qs('#crud-parche-contenido').addEventListener('keyup', e => {

	var scrollTop = e.target.scrollTop, 
		scrollLeft = e.target.scrollLeft

	var scrollTopVivo = qs('#crud-dev-parche-vivo').scrollTop, 
    	scrollLeftVivo = qs('#crud-dev-parche-vivo').scrollLeft

	if (e.key === 'Tab') {
         typeInTextarea('&nbsp;&nbsp;&nbsp;')   
    }

	qs('#crud-dev-parche-vivo').innerHTML = ''
	qs('#crud-dev-parche-vivo').insertAdjacentHTML('afterbegin', e.target.value)

	e.target.scrollTo(scrollLeft, scrollTop)
	qs('#crud-dev-parche-vivo').scrollTo(scrollLeftVivo, scrollTopVivo)

})



//---------------------------------------------------------------------
qs('#usuario-generar-clave').addEventListener('click', e => {

	var clave = tools.generadorAleatorio(15, 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!*#$/=?¡')
	qs(`#usuario-clave`).value = ''
	qs(`#usuario-clave`).value = clave

})

qs('#usuario-copiar-clave').addEventListener('click', e => {

	var input = document.createElement('input')
    	input.setAttribute('type', 'text')
    	input.setAttribute('value', qs('#usuario-clave').value) 
    	input.select();
	document.body.appendChild(input);
	input.select();
	input.setSelectionRange(0, 99999);
	document.execCommand("copy");
	document.body.removeChild(input);

	tools['mensaje'] = 'Copiado al portapapeles'
	tools.mensajes(['#0d6efd', '#fff'])

})

/* -------------------------------------------------------------------------------------------------*/	
//                       cargar usuario
/* -------------------------------------------------------------------------------------------------*/

var usuarioProcesar = true

qs('#dev-usuario-cargar').addEventListener('click', async e => {
	
	if (!window.procesar) { editarProcesar = false }
	if (!e.target.tagName === 'BUTTON') { editarProcesar = false }
	if (!e.target.classList.contains('confirmar')) { editarProcesar = false}

	if (usuarioProcesar) {

		toolsMensaje('Procesando...', ['#ffc107', '#fff'], false)

        var datos = tools.confirmar(e.target, 'confirmar', 'usuario-valores', tools)

        if (datos !== '') {

        	var resultado = await tools.fullAsyncQuery('dev', 'registrarUsuario', datos)

            if (resultado.trim() === 'exito') {

            	toolsMensaje('Petición realizada con éxito', true, false)
				parches.limpiar('.usuario-limpiar', '', {})

            } else if (resultado.trim() === 'iusuario') {

            	toolsMensaje('USUARIO INVÁLIDO', false, resultado)

            } else if (resultado.trim() === 'icorreo') {

            	toolsMensaje('CORREO INVÁLIDO', false, resultado)

            } else {

            	toolsMensaje('Error al procesar la petición', false, resultado)

            }

            usuarioProcesar = true

        }

	} else {

		usuarioProcesar = true

	}

})

/* -------------------------------------------------------------------------------------------------*/	
//                       cargar formulario
/* -------------------------------------------------------------------------------------------------*/

var formularioProcesar = true

qs('#dev-formulario-cargar').addEventListener('click', async e => {
	
	if (!window.procesar) { formularioProcesar = false }
	if (!e.target.tagName === 'BUTTON') { formularioProcesar = false }
	if (!e.target.classList.contains('confirmar')) { formularioProcesar = false}

	if (formularioProcesar) {

		toolsMensaje('Procesando...', ['#ffc107', '#fff'], false)

        var datos = tools.confirmar(e.target, 'confirmar', 'formulario-valores', tools)

        if (datos !== '') {

        	var resultado = await tools.fullAsyncQuery('dev', 'insertarFormulario', datos)

            if (resultado.trim() === 'exito') {

            	toolsMensaje('Petición realizada con éxito', true, false)
				parches.limpiar('.formulario-limpiar', '', {})

				var formulario = JSON.parse(await tools.fullAsyncQuery('dev', 'comboFormularios', []))

	        	filtrosBanderas.reconstruirCombo(
	        		qs('[data-grupo="cc-formularios-dev"]').querySelector('select'), 
	        		qs('[data-grupo="cc-formularios-dev"]').querySelector('input'), 
	        		formulario
	        	)

            } else {

            	toolsMensaje('Error al procesar la petición', false, resultado)

            }

            formularioProcesar = true

        }

	} else {

		formularioProcesar = true

	}

})

/* -------------------------------------------------------------------------------------------------*/	
//                       cargar banderas
/* -------------------------------------------------------------------------------------------------*/

var banderasProcesar = true

qs('#dev-banderas-cargar').addEventListener('click', async e => {
	
	if (!window.procesar) { banderasProcesar = false }
	if (!e.target.tagName === 'BUTTON') { banderasProcesar = false }
	if (!e.target.classList.contains('confirmar')) { banderasProcesar = false}

	if (banderasProcesar) {

		toolsMensaje('Procesando...', ['#ffc107', '#fff'], false)

        var datos = tools.confirmar(e.target, 'confirmar', 'banderas-valores', tools)

        if (datos !== '') {

        	var resultado = await tools.fullAsyncQuery('dev', 'insertarBanderas', datos)

            if (resultado.trim() === 'exito') {

            	toolsMensaje('Petición realizada con éxito', true, false)
				parches.limpiar('.banderas-limpiar', '', {})

            } else {

            	toolsMensaje('Error al procesar la petición', false, resultado)

            }

            banderasProcesar = true

        }

	} else {

		banderasProcesar = true

	}

})

/* -------------------------------------------------------------------------------------------------*/	
//                       cargar opcion menu
/* -------------------------------------------------------------------------------------------------*/

var menuProcesar = true

qs('#dev-menu-cargar').addEventListener('click', async e => {
	
	if (!window.procesar) { menuProcesar = false }
	if (!e.target.tagName === 'BUTTON') { menuProcesar = false }
	if (!e.target.classList.contains('confirmar')) { menuProcesar = false}

	if (menuProcesar) {

		toolsMensaje('Procesando...', ['#ffc107', '#fff'], false)

        var datos = tools.confirmar(e.target, 'confirmar', 'menu-valores', tools)

        if (datos !== '') {

        	var resultado = await tools.fullAsyncQuery('dev', 'insertarMenuOpciones', datos)

            if (resultado.trim() === 'exito') {

            	toolsMensaje('Petición realizada con éxito', true, false)
				parches.limpiar('.menu-limpiar', '', {})

            } else {

            	toolsMensaje('Error al procesar la petición', false, resultado)

            }

            menuProcesar = true

        }

	} else {

		menuProcesar = true

	}

})