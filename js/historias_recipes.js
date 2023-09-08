import { customDesplegable } from '../js/main.js';
import { historias, tools, notificaciones, reporteSeleccionado } from '../js/historias.js';
import { recipes, medicamentos, tratamientos, presentaciones } from '../js/historias.js';

/* 1)------------------------------------------------------------------------------------------------*/
/* ------------------------------------------ RECIPES -----------------------------------------------*/
/*---------------------------------------------------------------------------------------------------*/

//----------------------------------------------------------------------------------------------------
//										MEDICAMENTOS - PROPIEDADES                                          
//----------------------------------------------------------------------------------------------------
medicamentos['crud'].cuerpo.push([medicamentos['crud'].columna = medicamentos['crud'].cuerpo.length, [
		medicamentos['crud'].gCheck('check checksmall check-seleccionar', 'Seleccionar medicamento para el récipe', [], 'width:25px; height:25px; margin:0px', {'positivo': 'X', 'negativo': '', 'id': 0}),
		medicamentos['crud'].gCheck('check checksmall check-presentacion', 'Guardar modelo de presentación', [], 'width:20px; height:20px', {'positivo': 'X', 'negativo': '', 'id': 0}),
		medicamentos['crud'].gCheck('check checksmall check-tratamiento', 'Guardar modelo de tratamiento', [], 'width:20px; height:20px', {'positivo': 'X', 'negativo': '', 'id': 0})
	], [6, 7, 8], ['VALUE', 'VALUE', 'VALUE'], 'crud-botones', false
])
medicamentos['crud'].generarColumnas(['gSpan', null, null], [false],['HTML'], 'medicamentos-contenedor', 0)

////////////////////////////////////////////////////////////
medicamentos.crud['inputHandler'] = [{"input":0, "checkbox":0}, true]
////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////
medicamentos['crud']['propiedadesTr'] = {

	"contenedor": (e) => {

		var fr = new DocumentFragment(),
			th = medicamentos, 
			contenedor = e.querySelector('.medicamentos-contenedor'), 
			contenido = th.contenido.cloneNode(true)

		contenedor.innerHTML = ''
		contenedor.appendChild(contenido)
		contenedor.setAttribute('id', `id-${e.sublista.id}-medicamentos`)

		var genericos = JSON.parse(e.sublista.genericos),
			medicamentosGenericos = ''
		
		genericos.forEach(e => {medicamentosGenericos = `${e}, ${medicamentosGenericos}`})

		contenedor.querySelector('.genericos').insertAdjacentHTML('afterbegin', `<b>${e.sublista.nombre}</b>:${medicamentosGenericos}`)
		contenedor.querySelector('.presentacion').insertAdjacentHTML('afterbegin', `${e.sublista.presentacion}`)
		contenedor.querySelector('.tratamiento').insertAdjacentHTML('afterbegin', ` ${e.sublista.tratamiento}`)

	}
};
////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////
medicamentos['crud']['customKeyEvents'] = {

	"tratamientos": async (e) => {

		var boton = e.target

		if (boton.tagName === 'BUTTON') {

			if (boton.classList.contains('seleccionar-tratamiento')) {

				var th = medicamentos, 
					resultado

				medicamentos.btnSeleccionado = boton

				th.sublista = tools.pariente(boton, 'TR').sublista

				resultado = JSON.parse(await tools.fullAsyncQuery('historias_recipes', 'traer_tratamientos', [th.sublista.id_medicamento]))
				tratamientos.cargarTabla(resultado)

				traPop.pop()

				qs('#tratamientos-seleccionado').value = ''

				if(tratamientos.crud.lista.length > 0) {
					window.setTimeout(() => qs('#tratamientos-busqueda').focus(), 5);
				} else {
					window.setTimeout(() => qs('#tratamientos-seleccionado').focus(), 10);
				}
			}

		}

	},
	"presentaciones": async (e) => {
		
		var boton = e.target

		if (boton.tagName === 'BUTTON') {

			if (boton.classList.contains('seleccionar-presentaciones')) {

				var th = medicamentos, 
					resultado

				medicamentos.btnSeleccionado = boton

				th.sublista = tools.pariente(boton, 'TR').sublista

				resultado = JSON.parse(await tools.fullAsyncQuery('historias_recipes', 'traer_presentaciones', [th.sublista.id_medicamento]))
				presentaciones.cargarTabla(resultado)

				presenPop.pop()

				qs('#presentaciones-seleccionado').value = ''

				if(presentaciones.crud.lista.length > 0) {
					window.setTimeout(() => qs('#presentaciones-busqueda').focus(), 5);
				} else {
					window.setTimeout(() => qs('#presentaciones-seleccionado').focus(), 10);
				}
			}

		}

	}
};
////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////
(async () => {
	var resultado = await tools.fullAsyncQuery('historias_recipes', 'cargar_medicamentos', [])

	medicamentos.cargarTabla(JSON.parse(resultado))
	medicamentos['crud']['resetLista'] = JSON.parse(resultado)
	medicamentos['crud'].botonBuscar('medicamentos-busqueda', false) 	
})()

//----------------------------------------------------------------------------------------------------
//										RECIPES - PROPIEDADES                                          
//----------------------------------------------------------------------------------------------------
recipes['crud'].cuerpo.push([recipes['crud'].columna = recipes['crud'].cuerpo.length, [recipes['crud'].gSpan(null,null)], [false], ['HTML'], '', 0])
recipes['crud'].cuerpo.push([recipes['crud'].columna = recipes['crud'].cuerpo.length, [recipes['crud'].gSpan(null,null)], [false], ['HTML'], '', 1])
recipes['crud'].cuerpo.push([historias['crud'].columna = historias['crud'].cuerpo.length, [
		recipes['crud'].gBt(['imprimir btn btn-imprimir', 'Reimprimir récipe & indicación'], `<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="info" class="iconos-b" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 192 512"><path fill="currentColor" d="M20 424.229h20V279.771H20c-11.046 0-20-8.954-20-20V212c0-11.046 8.954-20 20-20h112c11.046 0 20 8.954 20 20v212.229h20c11.046 0 20 8.954 20 20V492c0 11.046-8.954 20-20 20H20c-11.046 0-20-8.954-20-20v-47.771c0-11.046 8.954-20 20-20zM96 0C56.235 0 24 32.235 24 72s32.235 72 72 72 72-32.235 72-72S135.764 0 96 0z"></path></svg>`),
		recipes['crud'].gBt(['reusar btn btn-reusar', 'Reutilizar contenido de récipe & indicación'], `<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="pencil-alt" class="svg-inline--fa fa-pencil-alt fa-w-16 iconos-b" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M497.9 142.1l-46.1 46.1c-4.7 4.7-12.3 4.7-17 0l-111-111c-4.7-4.7-4.7-12.3 0-17l46.1-46.1c18.7-18.7 49.1-18.7 67.9 0l60.1 60.1c18.8 18.7 18.8 49.1 0 67.9zM284.2 99.8L21.6 362.4.4 483.9c-2.9 16.4 11.4 30.6 27.8 27.8l121.5-21.3 262.6-262.6c4.7-4.7 4.7-12.3 0-17l-111-111c-4.8-4.7-12.4-4.7-17.1 0zM124.1 339.9c-5.5-5.5-5.5-14.3 0-19.8l154-154c5.5-5.5 14.3-5.5 19.8 0s5.5 14.3 0 19.8l-154 154c-5.5 5.5-14.3 5.5-19.8 0zM88 424h48v36.3l-64.5 11.3-31.1-31.1L51.7 376H88v48z"></path></svg>`),
		recipes['crud'].gBt(['eliminar btn btn-eliminar', 'Eliminar récipe & indicación'], `<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512" class="iconos-b"><path fill="currentColor" d="M128 0C92.7 0 64 28.7 64 64v96h64V64H354.7L384 93.3V160h64V93.3c0-17-6.7-33.3-18.7-45.3L400 18.7C388 6.7 371.7 0 354.7 0H128zM384 352v32 64H128V384 368 352H384zm64 32h32c17.7 0 32-14.3 32-32V256c0-35.3-28.7-64-64-64H64c-35.3 0-64 28.7-64 64v96c0 17.7 14.3 32 32 32H64v64c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V384zM432 248a24 24 0 1 1 0 48 24 24 0 1 1 0-48z"/></svg>`)
	], [0, 0, 0], ['VALUE', 'VALUE', 'VALUE'], 'crud-botones', false
])

recipes.crud['ofv'] = true
recipes.crud['ofvh'] = '35vh';

recipes['crud']['customBodyEvents'] = {
	/* -------------------------------------------------------------------------------------------------*/
	/*           								REIMRRIMIR 											    */
	/* -------------------------------------------------------------------------------------------------*/
	"imprimir": (e) => {

		if(e.target.tagName === 'BUTTON') {

			if(e.target.classList.contains('imprimir')) {

				window.reportes.imprimirPDF(`../plantillas/.php?id=${Number(e.target.value)}&pdf=2`, {})
			
			}

		}
	},
	/* -------------------------------------------------------------------------------------------------*/
	/*           								REUTILIZAR 											    */
	/* -------------------------------------------------------------------------------------------------*/
	"reusar": async (e) => {

		if (e.target.classList.contains('reusar')) {

			constancias.sublista = tools.pariente(e.target, 'TR').sublista

			tools.limpiar('.constancia-valores', '', {})
			rellenar.contenedores(constancias.sublista, '.constancia-valores', {elemento: e.target, id: 'value'}, {})

			notificaciones.mensajeSimple('Datos cargados', false, 'V')

		}

	},
	/* -------------------------------------------------------------------------------------------------*/
	/*           					ENVIAR LOS DATOS PARA EDITAR LA CONSTANCIA   					    */
	/* -------------------------------------------------------------------------------------------------*/
	"elimiar": async (e) => {

		if (e.target.classList.contains('elimiar')) {

			// constancias.sublista = tools.pariente(e.target, 'TR').sublista

			// tools.limpiar('.coneditar-valores', '', {})	

			// rellenar.contenedores(constancias.sublista, '.coneditar-valores', {elemento: e.target, id: 'value'}, {})

			// conPop.pop()

		}

	}

}

////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////
recipes['crud']['propiedadesTr'] = {
	"informacion": (e) => {

		var fr = new DocumentFragment(), genericos, th = recipes
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
}

//----------------------------------------------------------------------------------------------------
//										TRATAMIENTOS - PROPIEDADES                                          
//----------------------------------------------------------------------------------------------------
tratamientos['crud'].cuerpo.push([
	tratamientos['crud'].columna = tratamientos['crud'].cuerpo.length, [tratamientos['crud'].gInp('input upper', 'text', 'Descripción del tratamiento', 
	[
		{"atributo": "titulo", "valor":""}, 
		{"atributo": "placeholder", "valor":"Contenido..."}
	], 
	'width: 100%')
], [false], ['VALUE'], '', 0])

tratamientos['crud'].cuerpo.push([tratamientos['crud'].columna = tratamientos['crud'].cuerpo.length, [tratamientos['crud'].gBt(['seleccionar btn-seleccionar-flecha', 'Seleccionar tratamiento', 'height: 25px'], '<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="arrow-alt-circle-right" class="svg-inline--fa fa-arrow-alt-circle-right fa-w-16 iconos-b" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M256 8c137 0 248 111 248 248S393 504 256 504 8 393 8 256 119 8 256 8zM140 300h116v70.9c0 10.7 13 16.1 20.5 8.5l114.3-114.9c4.7-4.7 4.7-12.2 0-16.9l-114.3-115c-7.6-7.6-20.5-2.2-20.5 8.5V212H140c-6.6 0-12 5.4-12 12v64c0 6.6 5.4 12 12 12z"></path></svg>')], [false], ['VALUE'], '', 0])
////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////

tratamientos['crud']['inputHandler'] = [{"input":0}, true]
tratamientos['crud']['desplazamientoActivo'] = [true, true, true, true]
tratamientos['crud']['ofv'] = true
tratamientos['crud']['ofvh'] = '400px';

////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////
tratamientos['crud']['customBodyEvents'] = {
	"seleccionar": async (e) => {
		if(e.target.classList.contains('seleccionar')) {
			
			var pariente = tools.pariente(medicamentos.btnSeleccionado, 'TR')

			pariente.querySelector('.tratamiento').innerHTML = e.target.value.toUpperCase()
			medicamentos.sublista.tratamiento = e.target.value.toUpperCase()

			medicamentos.sublista.marcador = 'X'
			pariente.querySelector('[data-columna="marcador"]').checked = true
			qs('#tabla-medicamentos').inputActualizacionForzada(pariente.querySelector('[data-columna="marcador"]'))

			window.setTimeout(() => {
				setTimeout(() => {medicamentos.crud.inputNavegacionRefocus()}, 5) 
				medicamentos.btnSeleccionado = undefined
			}, 5);

			notificaciones.mensajeSimple(`Tratamiento seleccionado`, resultado, 'V')

			traPop.pop()

		}
	}
};

//----------------------------------------------------------------------------------------------------
//										PRESENTACIONES - PROPIEDADES                                          
//----------------------------------------------------------------------------------------------------
presentaciones['crud'].cuerpo.push([
	presentaciones['crud'].columna = presentaciones['crud'].cuerpo.length, [presentaciones['crud'].gInp('input upper', 'text', 'Descripción de la presentación', 
	[
		{"atributo": "titulo", "valor":""}, 
		{"atributo": "placeholder", "valor":"Contenido..."}
	], 
	'width: 100%')
], [false], ['VALUE'], '', 0])

presentaciones['crud'].cuerpo.push([presentaciones['crud'].columna = presentaciones['crud'].cuerpo.length, [presentaciones['crud'].gBt(['seleccionar btn-seleccionar-flecha', 'Seleccionar presentación', 'height: 25px'], '<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="arrow-alt-circle-right" class="svg-inline--fa fa-arrow-alt-circle-right fa-w-16 iconos-b" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M256 8c137 0 248 111 248 248S393 504 256 504 8 393 8 256 119 8 256 8zM140 300h116v70.9c0 10.7 13 16.1 20.5 8.5l114.3-114.9c4.7-4.7 4.7-12.2 0-16.9l-114.3-115c-7.6-7.6-20.5-2.2-20.5 8.5V212H140c-6.6 0-12 5.4-12 12v64c0 6.6 5.4 12 12 12z"></path></svg>')], [false], ['VALUE'], '', 0])
////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////

presentaciones['crud']['inputHandler'] = [{"input":0}, true]
presentaciones['crud']['desplazamientoActivo'] = [true, true, true, true]
presentaciones['crud']['ofv'] = true
presentaciones['crud']['ofvh'] = '400px';

////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////
presentaciones['crud']['customBodyEvents'] = {
	"seleccionar": async (e) => {
		if(e.target.classList.contains('seleccionar')) {
			
			var pariente = tools.pariente(medicamentos.btnSeleccionado, 'TR')

			pariente.querySelector('.presentacion').innerHTML = e.target.value.toUpperCase()
			medicamentos.sublista.presentacion = e.target.value.toUpperCase()

			medicamentos.sublista.marcador = 'X'
			pariente.querySelector('[data-columna="marcador"]').checked = true
			qs('#tabla-medicamentos').inputActualizacionForzada(pariente.querySelector('[data-columna="marcador"]'))

			window.setTimeout(() => {
				setTimeout(() => {medicamentos.crud.inputNavegacionRefocus()}, 5) 
				medicamentos.btnSeleccionado = undefined
			}, 5);

			notificaciones.mensajeSimple(`Presentación seleccionada`, resultado, 'V')

			presenPop.pop()

		}
	}
};

////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////

// qs("#constancias-contenedor .reporte-cargar").addEventListener('click', async e => {

// 	if(window.procesar) {

// 		var elemento = qs('#constancias-contenedor')

// 		window.procesar = false

// 		var datos = tools.procesar('', '', `${elemento.identificador}-valores`, tools);

// 		if (datos !== '') {
		
// 			notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'PROCESANDO')
			
// 			var lista = { 
// 				"nombres": historias.sublista.nombres, 
// 				"apellidos": historias.sublista.apellidos, 
// 				"cedula": historias.sublista.cedula, 
// 				"fecha_nacimiento": historias.sublista.fecha_naci,
// 				"constancia": {
// 					"texto_base": qs(`#${elemento.identificador}-textarea`).texto_base,
// 					"texto_html": qs(`#${elemento.identificador}-textarea`).texto_html
// 				}
// 			}

// 			var resultado = JSON.parse(await tools.fullAsyncQuery(`historias_${elemento.identificador}`, `${elemento.identificador}_insertar`, [lista, historias.sublista.id_historia], [["+", "%2B"]]))

// 			if (typeof resultado === 'object' && resultado !== null) {

// 				tools.limpiar(`.${elemento.identificador}-valores`, '', {})

// 				var sesion = [{"sesion": 'datos_pdf', "parametros": JSON.stringify(resultado)}]

// 				await tools.fullAsyncQuery('historias', 'modificar_sesion', sesion)

// 				constancias.cargarTabla(JSON.parse(await tools.fullAsyncQuery(`historias_${elemento.identificador}`, `${elemento.identificador}_consultar`, [historias.sublista.id_historia])), undefined, undefined)

// 				setTimeout(() => {

// 					if (elemento.querySelector('.desplegable-contenedor').style.display !== 'none') {

// 						constanciaPrevia.prevenir = false
// 						constanciaPrevia.accionar()
// 						constanciaPrevia.prevenir = true

// 					}

// 					window.reportes.imprimirPDF(`../plantillas/${elemento.identificador}pdf.php?&pdf=2`, {})

// 				}, 1000)

// 			} else {

// 				notificaciones.mensajeSimple('Error al procesar la petición', resultado, 'F')

// 			}

// 		}

// 	} else {

// 		notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'PROCESANDO')
		
// 	}

// })

// /* -------------------------------------------------------------------------------------------------*/
// /*           							CONSTANCIA - PREVIA					  					    */
// /* -------------------------------------------------------------------------------------------------*/
// qs("#constancias-contenedor .reporte-previa").addEventListener('click', async e => {

// 	if(window.procesar) {

// 		var elemento = qs('#constancias-contenedor')

// 		window.procesar = false

// 		var datos = tools.procesar('', '', `${elemento.identificador}-valores`, tools);

// 		elemento.querySelector('.desplegable-iframe').src = ''

// 		if (datos !== '') {

// 			notificaciones.mensajePersonalizado('Cargando reporte...', false, 'CLARO-1', 'PROCESANDO')

// 			var resultado = {
// 				"id_historia": historias.sublista.id_historia, 
// 				"nombres": historias.sublista.nombres, 
// 				"apellidos": historias.sublista.apellidos, 
// 				"cedula": historias.sublista.cedula, 
// 				"fecha_nacimiento": historias.sublista.fecha_naci,
// 				"constancia": {
// 					"texto_base": qs(`#${elemento.identificador}-textarea`).texto_base,
// 					"texto_html": qs(`#${elemento.identificador}-textarea`).texto_html
// 				}
// 			}

// 			if (typeof resultado === 'object' && resultado !== null) {

// 				var sesion = [ {"sesion": 'datos_pdf', "parametros": JSON.stringify(resultado)} ]

// 				await tools.fullAsyncQuery('historias', 'modificar_sesion', sesion)

// 				constancias.cargarTabla(JSON.parse(await tools.fullAsyncQuery(`historias_${elemento.identificador}`, `${elemento.identificador}_consultar`, [historias.sublista.id_historia])), undefined, undefined)

// 				setTimeout(() => {

// 					if (elemento.querySelector('.desplegable-contenedor').style.display === 'none') {

// 						constanciaPrevia.prevenir = false
// 						constanciaPrevia.accionar()
// 						constanciaPrevia.prevenir = true

// 					}

// 					window.reportes.previa(elemento.querySelector('.desplegable-iframe'), `../plantillas/${elemento.identificador}pdf.php?&pdf=2`)

// 				}, 1000)

// 			} else {

// 				notificaciones.mensajeSimple('Error al procesar la petición', resultado, 'F')

// 			}

// 		}

// 	} else {

// 		notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'PROCESANDO')
		
// 	}

// })

// /* -------------------------------------------------------------------------------------------------*/
// /*           						RECIPE CONSULTA - ELIMINAR									    */
// /* -------------------------------------------------------------------------------------------------*/
// qs('#constancias-contenedor table').addEventListener('click', async e => {

// 	if (e.target.classList.contains('eliminar-boton')) {

// 		if (window.procesar) {

// 			var elemento = qs('#constancias-contenedor')

// 			window.procesar = false
			
// 			notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'PROCESANDO')	

// 			constancias.crud.lista.forEach((lista, i) => {

// 				if (lista.id === Number(e.target.value)) {

// 					constancias.crud.lista.splice(i, 1)

// 				}

// 			})

// 			var resultado = await tools.fullAsyncQuery(`historias_${elemento.identificador}`, `${elemento.identificador}_eliminar`, [JSON.stringify(constancias.crud.lista), historias.sublista.id_historia])

// 			if (resultado.trim() === 'exito') {

// 				constancias.cargarTabla(constancias.crud.lista)

// 				notificaciones.mensajeSimple('Petición realiza con éxito', false, 'V')

// 			} else {

// 				notificaciones.mensajeSimple('Error al procesar la petición', resultado, 'F')

// 			}

// 			window.procesar = true

// 		}

// 	}

// })

/* -------------------------------------------------------------------------------------------------*/
/*           						CONSTANCIA - LIMPIAR					 					    */
/* -------------------------------------------------------------------------------------------------*/
// qs('#constancias-contenedor .limpiar').addEventListener('click', e => {

// 	tools.limpiar('.constancia-valores', '', {})

// 	notificaciones.mensajeSimple('Datos limpiados', false, 'V')

// })


//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
// var validarPresentacionTratamientos = {
// 	"00": "No es posible cargar más presentaciones ni tratamientos desde el recipe",
// 	"01": "No es posible cargar más presentaciones desde el recipe",
// 	"10": "No es posible cargar más tratamientos desde el recipe",
// 	"11": true
// }

// qs('#imprimir-recipe').addEventListener('click', async e => {
// 	if(window.procesar) {

// 		window.procesar = false

// 		if(window.medicamentos['crud'].checkLista.length > 0) {

// 			var procesoMarcador = false, procesoTratamiento = true, procesoPresentacion = true

// 			window.medicamentos['crud'].checkLista.forEach((e) => {
// 				if(e.marcador === 'X') {
// 					procesoMarcador = true
// 				}

// 				//habilitar para manejera las condiciones que evitan campos vacios de tratamientos y presentaciones
// 				// if(e.tratamiento.trim() === '' && e.marcador === 'X') {
// 				// 	procesoTratamiento = false
// 				// }

// 				if(e.presentacion.trim() === '' && e.marcador === 'X') {
// 					procesoPresentacion = false
// 				}
// 			});

// 			if(procesoMarcador && procesoTratamiento && procesoPresentacion) {

// 				toolsMensaje('Procesando...', ['#ffc107', '#fff'], false)

// 				var datos = window.conceptos.confirmar(e.target, 'imprimir', 'crud-recipe', tools);

// 				if (datos !== '') {
// 					datos.splice(datos.length - 1, 0, window.medicamentos['crud'].checkLista);

// 					var resultado = JSON.parse(await tools.fullAsyncQuery('historias', 'crearRecipe', datos))

// 					if(typeof resultado[0] === 'number') {
// 						window.procesar = true

// 						var mensaje = validarPresentacionTratamientos[String(`${resultado[1]}${resultado[2]}`)], delay = 0

// 						//console.log(resultado, `${resultado[0]}${resultado[1]}`, mensaje)

// 						if (typeof mensaje === 'string') {

// 							delay = 2500
// 							toolsMensaje(mensaje, ['#d05a04', '#fff'], false)

// 						} else {

// 							delay = 0

// 						}

// 						setTimeout(() => {

// 							window.reportes.imprimirPDF(`../plantillas/recipes_indicacionespdf.php?id=${resultado}&pdf=2`, {
// 								"procesado": function fn() {
// 									recPop.pop()
// 								}
// 							})

// 						}, delay)

// 					} else  {

// 						toolsMensaje('Error al procesar la petición', false, resultado)
	
// 					}
// 				} else {
// 					window.procesar = true
// 				}
				
// 			} else if (!procesoMarcador) {

// 				toolsMensaje('Ningún medicamento fue seleccionado', false, false)

// 			} else if (!procesoPresentacion) {

// 				toolsMensaje('Los medicamentos marcados no tienen presentación seleccionado', false, false)

// 			} else if (!procesoTratamiento) {

// 				toolsMensaje('Los medicamentos marcados no tienen tratamiento seleccionado', false, false)

// 			}
// 		} else {

// 			toolsMensaje('No se han marcado checkboxes', false, false)

// 		}		
// 	} else {
// 		toolsMensaje('Procesando...', ['#ffc107', '#fff'], false)
// 	}
// })