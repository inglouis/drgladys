import { customDesplegable } from '../js/main.js';
import { historias, tools, notificaciones, reporteSeleccionado } from '../js/historias.js';
import { recipes, medicamentos, tratamientos, presentaciones, recipes_notificados, notificados_reportes } from '../js/historias.js';

/* 1)------------------------------------------------------------------------------------------------*/
/* ------------------------------------------ RECIPES -----------------------------------------------*/
/*---------------------------------------------------------------------------------------------------*/

//----------------------------------------------------------------------------------------------------
//										MEDICAMENTOS - PROPIEDADES                                          
//----------------------------------------------------------------------------------------------------
medicamentos['crud']['cuerpo'].push([medicamentos['crud'].columna = medicamentos['crud'].cuerpo.length, [
		medicamentos['crud'].gCheck('check checklarge check-seleccionar', 'Seleccionar medicamento para el récipe', [], 'width:24px; height:24px; margin:0px; margin-bottom: 5px;', {'positivo': 'X', 'negativo': '', 'id': 7}),
		medicamentos['crud'].gCheck('check checksmall check-presentacion', 'Guardar modelo de presentación', [], 'width:20px; height:20px; margin: 0px;', {'positivo': 'X', 'negativo': '', 'id': 8}),
		medicamentos['crud'].gCheck('check checksmall check-tratamiento', 'Guardar modelo de tratamiento', [], 'width:20px; height:20px; margin: 0px;', {'positivo': 'X', 'negativo': '', 'id': 9})
	], [7, 8, 9], ['VALUE', 'VALUE', 'VALUE'], 'crud-botones', false
])

medicamentos['crud'].generarColumnas(['gDiv', null, null], [false],['HTML'], 'medicamentos-contenedor-crud', 0)

////////////////////////////////////////////////////////////
medicamentos['crud']['inputHandler'] = [{"input":0, "checkbox":0}, true]
medicamentos['crud']['desplazamientoActivo'] = [false, false, false, false]
////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////
medicamentos['crud']['propiedadesTr'] = {

	"contenedor": (e) => {

		var fr = new DocumentFragment(),
			th = medicamentos, 
			contenedor = e.querySelector('.medicamentos-contenedor-crud'), 
			contenido = th.contenido.cloneNode(true)

		contenedor.innerHTML = ''
		contenedor.appendChild(contenido)
		contenedor.setAttribute('id', `id-${e.sublista.id_medicamento}-medicamentos`)

		if (e.sublista.medicamentos_genericos === ' - ') {var medicamentos_genericos = ''} else {var medicamentos_genericos = e.sublista.medicamentos_genericos}
		if (e.sublista.presentacion 		  === '') {var presentacion 		  = '---'} else {var presentacion 		    = e.sublista.presentacion}
		if (e.sublista.tratamiento 			  === '') {var tratamiento 		      = '---'} else {var tratamiento 			= e.sublista.tratamiento}

		medicamentos_genericos = medicamentos_genericos.substring(medicamentos_genericos.length - 3, 3)

		contenedor.querySelector('.genericos').insertAdjacentHTML('afterbegin', `<b>${e.sublista.nombre}:</b> `)
		contenedor.querySelector('.genericos input').value = medicamentos_genericos
		contenedor.querySelector('.presentacion ul li').insertAdjacentHTML('afterbegin', `${presentacion}`)
		contenedor.querySelector('.tratamiento ul li').insertAdjacentHTML('afterbegin', ` ${tratamiento}`)

	}
	
};
////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////
medicamentos['crud']['customBodyEvents'] = {

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

			if (boton.classList.contains('seleccionar-presentacion')) {

				var th = medicamentos, 
					resultado

				medicamentos.btnSeleccionado = boton

				th.sublista = tools.pariente(boton, 'TR').sublista

				resultado = JSON.parse(await tools.fullAsyncQuery('historias_recipes', 'traer_presentaciones', [th.sublista.id_medicamento]))
				presentaciones.cargarTabla(resultado)

				presenPop.pop()

				if(presentaciones.crud.lista.length > 0) {
					window.setTimeout(() => qs('#presentaciones-busqueda').focus(), 5);
				} else {
					window.setTimeout(() => qs('#presentaciones-seleccionado').focus(), 10);
				}
			}

		}

	}
}

medicamentos['crud']['customKeyEvents'] = {
	"genericos": async (e) => {

		var input = e.target

		if (input.tagName === 'INPUT') {

			if (input.classList.contains('genericos-input')) {

				var th = medicamentos

				th.sublista = tools.pariente(input, 'TR').sublista

				th.sublista.medicamentos_genericos = input.value.toUpperCase()

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
recipes['crud'].cuerpo.push([recipes['crud'].columna = recipes['crud'].cuerpo.length, [recipes['crud'].gSpan(null,null)], [false], ['HTML'], '', 5])
recipes['crud'].cuerpo.push([recipes['crud'].columna = recipes['crud'].cuerpo.length, [
		recipes['crud'].gBt(['imprimir btn btn-imprimir', 'Reimprimir récipe & indicación'], `<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512" class="iconos-b"><path fill="currentColor" d="M128 0C92.7 0 64 28.7 64 64v96h64V64H354.7L384 93.3V160h64V93.3c0-17-6.7-33.3-18.7-45.3L400 18.7C388 6.7 371.7 0 354.7 0H128zM384 352v32 64H128V384 368 352H384zm64 32h32c17.7 0 32-14.3 32-32V256c0-35.3-28.7-64-64-64H64c-35.3 0-64 28.7-64 64v96c0 17.7 14.3 32 32 32H64v64c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V384zM432 248a24 24 0 1 1 0 48 24 24 0 1 1 0-48z"/></svg>`),
		recipes['crud'].gBt(['reusar btn btn-reusar', 'Reutilizar contenido de récipe & indicación'], `<svg class="iconos-b" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><path fill="currentColor" d="M174.7 45.1C192.2 17 223 0 256 0s63.8 17 81.3 45.1l38.6 61.7 27-15.6c8.4-4.9 18.9-4.2 26.6 1.7s11.1 15.9 8.6 25.3l-23.4 87.4c-3.4 12.8-16.6 20.4-29.4 17l-87.4-23.4c-9.4-2.5-16.3-10.4-17.6-20s3.4-19.1 11.8-23.9l28.4-16.4L283 79c-5.8-9.3-16-15-27-15s-21.2 5.7-27 15l-17.5 28c-9.2 14.8-28.6 19.5-43.6 10.5c-15.3-9.2-20.2-29.2-10.7-44.4l17.5-28zM429.5 251.9c15-9 34.4-4.3 43.6 10.5l24.4 39.1c9.4 15.1 14.4 32.4 14.6 50.2c.3 53.1-42.7 96.4-95.8 96.4L320 448v32c0 9.7-5.8 18.5-14.8 22.2s-19.3 1.7-26.2-5.2l-64-64c-9.4-9.4-9.4-24.6 0-33.9l64-64c6.9-6.9 17.2-8.9 26.2-5.2s14.8 12.5 14.8 22.2v32l96.2 0c17.6 0 31.9-14.4 31.8-32c0-5.9-1.7-11.7-4.8-16.7l-24.4-39.1c-9.5-15.2-4.7-35.2 10.7-44.4zm-364.6-31L36 204.2c-8.4-4.9-13.1-14.3-11.8-23.9s8.2-17.5 17.6-20l87.4-23.4c12.8-3.4 26 4.2 29.4 17L182 241.2c2.5 9.4-.9 19.3-8.6 25.3s-18.2 6.6-26.6 1.7l-26.5-15.3L68.8 335.3c-3.1 5-4.8 10.8-4.8 16.7c-.1 17.6 14.2 32 31.8 32l32.2 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-32.2 0C42.7 448-.3 404.8 0 351.6c.1-17.8 5.1-35.1 14.6-50.2l50.3-80.5z"></path></svg>`),
		recipes['crud'].gBt(['eliminar btn btn-eliminar', 'Eliminar récipe & indicación'], `<svg class="iconos-b" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M32 464a48 48 0 0 0 48 48h288a48 48 0 0 0 48-48V128H32zm272-256a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zm-96 0a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zm-96 0a16 16 0 0 1 32 0v224a16 16 0 0 1-32 0zM432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16z"></path></svg>`)
	], [0, 0, 0], ['VALUE', 'VALUE', 'VALUE'], 'crud-botones crud-eliminar-contenedor', false
])

recipes.crud['ofv'] = true

recipes['crud']['propiedadesTr'] = {
	"eliminar": (e) => {
		var th = recipes,
			contenedor = historias.contenedorEliminarBoton.cloneNode(true)

		contenedor.setAttribute('data-hidden', '')
		contenedor.querySelector('.eliminar-boton').value = e.sublista.id_recipe

		e.querySelector('.crud-eliminar-contenedor').appendChild(contenedor)

		contenedor = e.querySelector('.eliminar-contenedor')

		e.addEventListener('mouseover', el => {

			if (el.target.classList.contains('eliminar')) {
				var coordenadas = e.querySelector('.eliminar').getBoundingClientRect()
				contenedor.removeAttribute('data-hidden')	
			}	

		})

		e.querySelector('.eliminar').addEventListener('mouseleave', el => {
			if (!contenedor.matches(':hover')) {
				contenedor.setAttribute('data-hidden', '')
			}
		})

		contenedor.addEventListener('mouseleave', el => {
			contenedor.setAttribute('data-hidden', '')
		})

	}
}

recipes['crud']['customBodyEvents'] = {
	/* -------------------------------------------------------------------------------------------------*/
	/*           								REIMRRIMIR 											    */
	/* -------------------------------------------------------------------------------------------------*/
	"imprimir": (e) => {

		if(e.target.tagName === 'BUTTON') {

			if(e.target.classList.contains('imprimir')) {

				window.reportes.imprimirPDF(`../plantillas/recipes_indicacionespdf.php?modo=imprimir&pdf=2php&id=${Number(e.target.value)}`, {})
			
			}

		}
	},
	/* -------------------------------------------------------------------------------------------------*/
	/*           								REUTILIZAR 											    */
	/* -------------------------------------------------------------------------------------------------*/
	"reusar": async (e) => {

		if (e.target.classList.contains('reusar')) {

			recipes.sublista = tools.pariente(e.target, 'TR').sublista

			var resultado = JSON.parse(await tools.fullAsyncQuery('historias_recipes', 'reusar_recipes', [recipes.sublista.medicamentos]))

			medicamentos.crud.checkLista = JSON.parse(recipes.sublista.medicamentos)
			medicamentos.cargarTabla(resultado)

			window.medicamentos.crud.ascDesc(qs('#tabla-medicamentos thead th').classList[0], qs('#tabla-medicamentos thead th')[1])

			notificaciones.mensajeSimple('Datos cargados', false, 'V')

		}

	}

}

//----------------------------------------------------------------------------------------------------
//										RECIPES NOTIFICADOS - PROPIEDADES                                          
//----------------------------------------------------------------------------------------------------
recipes_notificados['crud'].cuerpo.push([recipes_notificados['crud'].columna = recipes_notificados['crud'].cuerpo.length, [recipes_notificados['crud'].gSpan(null,null)], [false], ['HTML'], '', 2])
recipes_notificados['crud'].cuerpo.push([recipes_notificados['crud'].columna = recipes_notificados['crud'].cuerpo.length, [
		recipes_notificados['crud'].gBt(['imprimir btn btn-imprimir', 'Imprimir récipe & indicación'], `<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512" class="iconos-b"><path fill="currentColor" d="M128 0C92.7 0 64 28.7 64 64v96h64V64H354.7L384 93.3V160h64V93.3c0-17-6.7-33.3-18.7-45.3L400 18.7C388 6.7 371.7 0 354.7 0H128zM384 352v32 64H128V384 368 352H384zm64 32h32c17.7 0 32-14.3 32-32V256c0-35.3-28.7-64-64-64H64c-35.3 0-64 28.7-64 64v96c0 17.7 14.3 32 32 32H64v64c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V384zM432 248a24 24 0 1 1 0 48 24 24 0 1 1 0-48z"/></svg>`)
	], [false], ['VALUE'], 'crud-botones', 0
])

recipes_notificados.crud['ofv'] = true
recipes_notificados['crud']['ofvh'] = 'auto';

window.tools = tools

recipes_notificados['crud']['customBodyEvents'] = {
	/* -------------------------------------------------------------------------------------------------*/
	/*           								REIMRRIMIR 											    */
	/* -------------------------------------------------------------------------------------------------*/
	"imprimir": async (e) => {

		if(e.target.tagName === 'BUTTON') {

			if(e.target.classList.contains('imprimir')) {

				window.reportes.imprimirPDF(`../plantillas/recipes_indicacionespdf.php?modo=imprimir&pdf=2php&id=${Number(e.target.value)}`, {})

				var resultado = await tools.fullAsyncQuery('historias_recipes', 'notificaciones_recipes_revisado', [Number(e.target.value)])

				recipes_notificados.cargarTabla(JSON.parse(await tools.fullAsyncQuery('historias_recipes', 'notificaciones_recipes_consultar', [])))
			
			}

		}
	}
}

recipes_notificados['crud']['propiedadesTr'] = {
	"informacion": (e) => {
		var fr = new DocumentFragment(), th = recipes_notificados
		var div = th.div.cloneNode(true);

		var d1 = th.div.cloneNode(true)
			d1.insertAdjacentHTML('afterbegin', 'N° DE HISTORIA:')
			d1.setAttribute('style', `min-width:200px; color:#fff`)

		var d2 = th.div.cloneNode(true)
			d2.insertAdjacentHTML('afterbegin', e.sublista.id_historia)
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

//----------------------------------------------------------------------------------------------------
//										TRATAMIENTOS - PROPIEDADES                                          
//----------------------------------------------------------------------------------------------------
tratamientos['crud'].cuerpo.push([tratamientos['crud'].columna = tratamientos['crud'].cuerpo.length, [tratamientos['crud'].gBt(['seleccionar btn-seleccionar-flecha', 'Seleccionar tratamiento', 'height: 40px; background: transparent;'], '<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="arrow-alt-circle-right" class="svg-inline--fa fa-arrow-alt-circle-right fa-w-16 iconos-b" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M256 8c137 0 248 111 248 248S393 504 256 504 8 393 8 256 119 8 256 8zM140 300h116v70.9c0 10.7 13 16.1 20.5 8.5l114.3-114.9c4.7-4.7 4.7-12.2 0-16.9l-114.3-115c-7.6-7.6-20.5-2.2-20.5 8.5V212H140c-6.6 0-12 5.4-12 12v64c0 6.6 5.4 12 12 12z"></path></svg>')], [false], ['VALUE'], '', 0])
tratamientos['crud'].cuerpo.push([
	tratamientos['crud'].columna = tratamientos['crud'].cuerpo.length, [tratamientos['crud'].gInp('input upper', 'text', 'Descripción del tratamiento', 
	[
		{"atributo": "titulo", "valor":""}, 
		{"atributo": "placeholder", "valor":"Contenido..."}
	], 
	'width: 100%; padding: 5px;')
], [false], ['VALUE'], '', 0])

////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////

tratamientos['crud']['inputHandler'] = [{"input":0}, true]
//tratamientos['crud']['desplazamientoActivo'] = [true, true, true, true]
tratamientos['crud']['ofv'] = true
tratamientos['crud']['ofvh'] = '400px';

////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////
tratamientos['crud']['customBodyEvents'] = {
	"seleccionar": async (e) => {
		if (e.target.classList.contains('seleccionar')) {
			
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

			notificaciones.mensajeSimple(`Tratamiento seleccionado`, false, 'V')

			traPop.pop()

		}
	}
};

//----------------------------------------------------------------------------------------------------
//										PRESENTACIONES - PROPIEDADES                                          
//----------------------------------------------------------------------------------------------------
presentaciones['crud'].cuerpo.push([presentaciones['crud'].columna = presentaciones['crud'].cuerpo.length, [presentaciones['crud'].gBt(['seleccionar btn-seleccionar-flecha', 'Seleccionar presentación', 'height: 40px; background: transparent;'], '<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="arrow-alt-circle-right" class="svg-inline--fa fa-arrow-alt-circle-right fa-w-16 iconos-b" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M256 8c137 0 248 111 248 248S393 504 256 504 8 393 8 256 119 8 256 8zM140 300h116v70.9c0 10.7 13 16.1 20.5 8.5l114.3-114.9c4.7-4.7 4.7-12.2 0-16.9l-114.3-115c-7.6-7.6-20.5-2.2-20.5 8.5V212H140c-6.6 0-12 5.4-12 12v64c0 6.6 5.4 12 12 12z"></path></svg>')], [false], ['VALUE'], '', 0])
presentaciones['crud'].cuerpo.push([
	presentaciones['crud'].columna = presentaciones['crud'].cuerpo.length, [presentaciones['crud'].gInp('input upper', 'text', 'Descripción de la presentación', 
	[
		{"atributo": "titulo", "valor":""}, 
		{"atributo": "placeholder", "valor":"Contenido..."}
	], 
	'width: 100%; padding: 5px;')
], [false], ['VALUE'], '', 0])

////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////

presentaciones['crud']['inputHandler'] = [{"input":0}, true]
//presentaciones['crud']['desplazamientoActivo'] = [true, true, true, true]
presentaciones['crud']['ofv'] = true
presentaciones['crud']['ofvh'] = '400px';

////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////
presentaciones['crud']['customBodyEvents'] = {
	"seleccionar": async (e) => {
		if (e.target.classList.contains('seleccionar')) {
			
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

			notificaciones.mensajeSimple(`Presentación seleccionada`, false, 'V')

			presenPop.pop()

		}
	}
};

// /* -------------------------------------------------------------------------------------------------*/
// /*           							CONSTANCIA - CARGAR					  					    */
// /* -------------------------------------------------------------------------------------------------*/

var validarPresentacionTratamientos = {
	"00": "No es posible cargar más presentaciones ni tratamientos desde el recipe",
	"01": "No es posible cargar más presentaciones desde el recipe",
	"10": "No es posible cargar más tratamientos desde el recipe",
	"11": true
}


qs("#crud-recipes-botones").addEventListener('click', async e => {

	if (window.procesar) {

		window.procesar = false

		if (e.target.tagName === 'BUTTON') {

			if (medicamentos.crud.checkLista.length > 0) {

				var procesoMarcador = false, 
					procesoTratamiento = true, 
					procesoPresentacion = true

				medicamentos.crud.checkLista.forEach((e) => {

					if (e.marcador === 'X') { procesoMarcador = true }

					if (e.tratamiento.trim() === '' && e.marcador === 'X') { procesoTratamiento = false }

					if (e.presentacion.trim() === '' && e.marcador === 'X') { procesoPresentacion = false }

				});

				if (procesoMarcador && procesoTratamiento && procesoPresentacion) {

					var datos = tools.procesar('', '', `recipes-cargar`, tools);

					if (datos !== '') {
						
						notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'PROCESANDO')

						datos.splice(datos.length, 0, window.medicamentos['crud'].checkLista);
					
						if (e.target.classList.contains('recipe-previa')) {

							var sesion = [{"sesion": 'datos_pdf', "parametros": JSON.stringify(datos)}]
							await tools.fullAsyncQuery('historias', 'modificar_sesion', sesion)

							window.reportes.imprimirPDF(`../plantillas/recipes_indicacionespdf.php?modo=previa&pdf=2`, {})

						} else {

							var resultado = JSON.parse(await tools.fullAsyncQuery('historias_recipes', 'crear_recipe', datos))

							if (typeof resultado === 'object' && resultado !== null) {

								var mensaje = validarPresentacionTratamientos[String(`${resultado[1]}${resultado[2]}`)], 
									delay = 0

								if (typeof mensaje === 'string') {

									delay = 2500
									notificaciones.tiempo = 3000
									notificaciones.mensajePersonalizado(mensaje, false, '#d05a04', '#fff')

								} else {

									delay = 0

								}

								//REFRESCAR TABLA DE MEDICAMENTOS
								await medicamentos.traerMedicamentos()
								await recipes.traerRecipes(historias.sublista.id_historia)

								if (e.target.classList.contains('recipe-notificar')) {

									await tools.fullAsyncQuery('historias_recipes', 'notificar_recipe', [resultado[0]])

									notificaciones.mensajeSimple('Notificación enviada', null , 'V')

									//ENVIAR NOTIFICACION DE IMPRESION DE REPORTE

								} else if (e.target.classList.contains('recipe-cargar')) {

									setTimeout(() => {

										window.reportes.imprimirPDF(`../plantillas/recipes_indicacionespdf.php?modo=imprimir&id=${resultado[0]}&pdf=2`, {
											"procesado": function fn() {
												//recPop.pop()
											}
										})

									}, delay)
								}


							} else {

								notificaciones.mensajeSimple('Error al procesar la petición', resultado, 'F')

							}

						}


					}

				} else {

					if (!procesoMarcador) {

						notificaciones.mensajeSimple('Ningún medicamento fue seleccionado', null, 'F')

					}

					if (!procesoPresentacion) {

						notificaciones.mensajeSimple('Los medicamentos marcados no tienen presentación seleccionado', null, 'F')

					}

					if (!procesoTratamiento) {

						notificaciones.mensajeSimple('Los medicamentos marcados no tienen tratamiento seleccionado', null, 'F')

					}

				}

			} else {

				notificaciones.mensajeSimple('No se ha seleccionado ningún medicamento', null, 'F')

			}

		}


	} else {

		notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'PROCESANDO')
		
	}

})

/* -------------------------------------------------------------------------------------------------*/
/*           						RECIPE CONSULTA - ELIMINAR									    */
/* -------------------------------------------------------------------------------------------------*/
qs('#tabla-recipes').addEventListener('click', async e => {

	if (e.target.classList.contains('eliminar-boton')) {

		if (window.procesar) {

			var elemento = qs('#constancias-contenedor')

			window.procesar = false
			
			notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'PROCESANDO')	

			var resultado = await tools.fullAsyncQuery(`historias_recipes`, `eliminar_recipes`, [Number(e.target.value)])

			if (resultado.trim() === 'exito') {

				await recipes.traerRecipes(historias.sublista.id_historia)

				notificaciones.mensajeSimple('Petición realiza con éxito', false, 'V')

			} else {

				notificaciones.mensajeSimple('Error al procesar la petición', resultado, 'F')

			}

			window.procesar = true

		}

	}

})

/* -------------------------------------------------------------------------------------------------*/
/* ------------------------------ ABRIR SECCIÓN DE NOTIFICADOS -------------------------------------*/
/* -------------------------------------------------------------------------------------------------*/
qs('#desplegable-abrir-recipes').addEventListener('click', async e => {

	//PETICION PARA ACTUALIZAR LISTA DE DATOS DE NOTIFIACION
	recipes_notificados.cargarTabla(JSON.parse(await tools.fullAsyncQuery('historias_recipes', 'notificaciones_recipes_consultar', [])))

	//QUITAR ALERTA
	e.target.classList.remove('notificacion-alerta')

})

/* -------------------------------------------------------------------------------------------------*/
/* ------------------------- ABRIR SECCIÓN DE CARGA DE MEDICAMENTOS --------------------------------*/
/* -------------------------------------------------------------------------------------------------*/
qs('#medicamentos-insertar').addEventListener('click', async e => {

	mediPop.pop()

})