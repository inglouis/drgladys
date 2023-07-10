import {historias, recipes, tools, notificaciones, recipePrevia} from '../js/historias.js';


/* -------------------------------------------------------------------------------------------------*/
/*           						GENERAR REPORTE DEL ANTECENDENTE		  					    */
/* -------------------------------------------------------------------------------------------------*/
qs("#recipes-procesar .reporte-cargar").addEventListener('click', async e => {

	if(window.procesar) {

		window.procesar = false

		var datos = tools.procesar('', '', 'recipes-valores', tools);

		if (datos !== '') {
			
			var resultado = JSON.parse(await tools.fullAsyncQuery('historias_recipes', 'recipes_insertar', datos, [["+", "%2B"]]))

			if (typeof resultado === 'object' && resultado !== null) {

				tools.limpiar('.recipes-valores', '', {"contenedor-personalizable": window.camposTextosPersonalizables})

				var sesion = [
					{"sesion": 'datos_pdf', "parametros": JSON.stringify(resultado)}
				]

				await tools.fullAsyncQuery('historias_recipes', 'modificar_sesion', sesion)

				recipes.cargarTabla(JSON.parse(await tools.fullAsyncQuery('historias_recipes', 'recipes_consultar', [historias.sublista.id_historia])), undefined, undefined)

				setTimeout(() => {

					if (qs('#recipes-previa-desplegable').style.display !== 'none') {

						recipePrevia.prevenir = false
						recipePrevia.accionar()
						recipePrevia.prevenir = true

					}

					window.reportes.imprimirPDF(`../plantillas/recipepdf.php?&pdf=2`, {})

				}, 1000)

			} else {

				notificaciones.mensajeSimple('Error al procesar la petición', resultado, 'F')

			}

		}

	} else {

		notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'PROCESANDO')
		
	}

})

/* -------------------------------------------------------------------------------------------------*/
/*           						VISTA PREVIA DE recipe				  					    */
/* -------------------------------------------------------------------------------------------------*/
qs("#recipes-procesar .reporte-previa").addEventListener('click', async e => {

	if(window.procesar) {

		window.procesar = false

		var datos = tools.procesar('', '', 'recipes-valores', tools);

		if (datos !== '') {

			notificaciones.mensajePersonalizado('Cargando reporte...', false, 'CLARO-1', 'PROCESANDO')

			var resultado = {
				"id": historias.sublista.id_historia,
				"nombres": historias.sublista.nombres,
				"apellidos": historias.sublista.apellidos,
				"direccion": historias.sublista.direccion,
				"cedula": historias.sublista.cedula,
				"fecha_nacimiento": historias.sublista.fecha_nacimiento,
				"peso": historias.sublista.peso,
				"talla": historias.sublista.talla,
				"recipe": {
					"texto": qs('#recipes-enfocar').texto,
					"textoPrevia": qs('#recipes-enfocar').textoPrevia
				},
				"indicacion": {
					"texto": qs('#recipes-indicaciones').texto,
					"textoPrevia": qs('#recipes-indicaciones').textoPrevia
				}
			}

			if (typeof resultado === 'object' && resultado !== null) {

				var sesion = [
					{"sesion": 'datos_pdf', "parametros": JSON.stringify(resultado)}
				]

				await tools.fullAsyncQuery('historias_recipes', 'modificar_sesion', sesion)

				recipes.cargarTabla(JSON.parse(await tools.fullAsyncQuery('historias_recipes', 'recipes_consultar', [historias.sublista.id_historia])), undefined, undefined)

				setTimeout(() => {

					if (qs('#recipes-previa-desplegable').style.display === 'none') {

						recipePrevia.prevenir = false
						recipePrevia.accionar()
						recipePrevia.prevenir = true

					}

					window.reportes.previa(qs('#recipes-iframe'), `../plantillas/recipepdf.php?&pdf=2`)

				}, 1000)

			} else {

				notificaciones.mensajeSimple('Error al procesar la petición', resultado, 'F')

			}

		}

	} else {

		notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'PROCESANDO')
		
	}

})

/* -------------------------------------------------------------------------------------------------*/
/*           					CONFIRMAR EDICION DEL ANTENCEDENTE			 					    */
/* -------------------------------------------------------------------------------------------------*/
qs('#crud-receditar-botones .confirmar').addEventListener('click', async e => {

	if(window.procesar) {

		notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'PROCESANDO')	

		var datos = tools.procesar('', '', 'receditar-valores', tools);

		if (datos !== '') {

			window.procesar = false

			recipes.sublista.recipe = JSON.stringify(datos[0])
			recipes.sublista.indicacion = JSON.stringify(datos[1])

			var resultado = await tools.fullAsyncQuery('historias_recipes', 'recipes_editar', [JSON.stringify(recipes.crud.lista), historias.sublista.id_historia], [["+", "%2B"]])

			if (resultado.trim() === 'exito') {

				recipes.cargarTabla(recipes.crud.lista)

				notificaciones.mensajeSimple('Petición realiza con éxito', false, 'V')

				recEdiPop.pop()

			} else {

				notificaciones.mensajeSimple('Error al procesar la petición', resultado, 'F')

			}

			window.procesar = true

		}

	}

})

/* -------------------------------------------------------------------------------------------------*/
/*           					CONFIRMAR EDICION DEL ANTENCEDENTE			 					    */
/* -------------------------------------------------------------------------------------------------*/
qs('#crud-receliminar-botones .eliminar').addEventListener('click', async e => {

	if(window.procesar) {

		window.procesar = false
		
		notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'PROCESANDO')	

		recipes.crud.lista.forEach((lista, i) => {

			if (lista.id === recipes.sublista.id) {

				recipes.crud.lista.splice(i, 1)

			}

		})

		var resultado = await tools.fullAsyncQuery('historias_recipes', 'recipes_eliminar', [JSON.stringify(recipes.crud.lista), historias.sublista.id_historia])

		if (resultado.trim() === 'exito') {

			recipes.cargarTabla(recipes.crud.lista)

			notificaciones.mensajeSimple('Petición realiza con éxito', false, 'V')

			recEliPop.pop()

		} else {

			notificaciones.mensajeSimple('Error al procesar la petición', resultado, 'F')

		}

		window.procesar = true

	}

})

/* -------------------------------------------------------------------------------------------------*/
/*           					EDITAR FORMATO DEL REPORTES, SUGERENCIAS	 					    */
/* -------------------------------------------------------------------------------------------------*/
qs('#crud-recipes-contenedor .cargar').addEventListener('mouseenter', e => {

	qs('#crud-recipes-personalizacion').removeAttribute('data-hidden')	

})

qs('#crud-recipes-contenedor .cargar').addEventListener('mouseleave', e => {

	qs('#crud-recipes-personalizacion').setAttribute('data-hidden', '')

})

qs('#crud-receditar-pop .filas').addEventListener('mouseenter', e => {

	qs('#crud-receditar-personalizacion').removeAttribute('data-hidden')	

})

qs('#crud-receditar-pop .filas').addEventListener('mouseleave', e => {

	qs('#crud-receditar-personalizacion').setAttribute('data-hidden', '')

})


/* -------------------------------------------------------------------------------------------------*/
/*           					LIMPIAR CARGA DE recipes				 					    */
/* -------------------------------------------------------------------------------------------------*/
qs('#recipes-limpiar').addEventListener('click', e => {

	tools.limpiar('.recipes-valores', '', {"contenedor-personalizable": window.camposTextosPersonalizables})

	notificaciones.mensajeSimple('Datos limpiados', false, 'V')

})

/* -------------------------------------------------------------------------------------------------*/
/*           					OCULTAR MOSTRAR PREVIAS DEL INFORMES		 					    */
/* -------------------------------------------------------------------------------------------------*/
var previas = [
	[qs('#recipes-enfocar'), qs('#recipes-previa-recipes')],
	[qs('#recipes-indicaciones'), qs('#recipes-previa-indicaciones')],
	[qs('#receditar-recipes'), qs('#receditar-previa-recipes')],
	[qs('#receditar-indicaciones'), qs('#receditar-previa-indicaciones')],
]

previas.forEach(el => {
	
	el[0].addEventListener('focusin', e => {

		el[1].removeAttribute('data-hidden')

	})

	el[0].addEventListener('focusout', e => {

		el[1].setAttribute('data-hidden', '')

	})

});

/* -------------------------------------------------------------------------------------------------*/
/*           					IMPRIMIR REPORTE							 					    */
/* -------------------------------------------------------------------------------------------------*/
qs('#crud-recprevia-botones .imprimir').addEventListener('click', e => {
	window.reportes.imprimirPDF(`../plantillas/recipepdf.php?&pdf=2`, {})

	setTimeout(() => {
		recPrePop.pop()
	}, 1000)
})

