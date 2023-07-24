import {historias, antecedentes, tools, notificaciones, antecedentePrevia} from '../js/historias.js';


/* -------------------------------------------------------------------------------------------------*/
/*           						GENERAR REPORTE DEL ANTECENDENTE		  					    */
/* -------------------------------------------------------------------------------------------------*/
qs("#antecedentes-procesar .reporte-cargar").addEventListener('click', async e => {

	if(window.procesar) {

		window.procesar = false

		notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'PROCESANDO')

		var datos = tools.procesar('', '', 'antecedentes-valores', tools);

		if (datos !== '') {
			
			var resultado = JSON.parse(await tools.fullAsyncQuery('historias_antecedentes', 'antecedentes_insertar', datos, [["+", "%2B"]]))

			if (typeof resultado === 'object' && resultado !== null) {

				tools.limpiar('.antecedentes-valores', '', {})

				var sesion = [
					{"sesion": 'datos_pdf', "parametros": JSON.stringify(resultado)}
				]

				await tools.fullAsyncQuery('historias_antecedentes', 'modificar_sesion', sesion)

				antecedentes.cargarTabla(JSON.parse(await tools.fullAsyncQuery('historias_antecedentes', 'antecedentes_consultar', [historias.sublista.id_historia])), undefined, undefined)

				setTimeout(() => {

					if (qs('#antecedentes-previa-desplegable').style.display !== 'none') {

						antecedentePrevia.prevenir = false
						antecedentePrevia.accionar()
						antecedentePrevia.prevenir = true

					}

					window.reportes.imprimirPDF(`../plantillas/antecedentepdf.php?&pdf=2`, {})

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
/*           						VISTA PREVIA DE ANTECEDENTE				  					    */
/* -------------------------------------------------------------------------------------------------*/
qs("#antecedentes-procesar .reporte-previa").addEventListener('click', async e => {

	if(window.procesar) {

		window.procesar = false

		var datos = tools.procesar('', '', 'antecedentes-valores', tools);

		if (datos !== '') {

			notificaciones.mensajePersonalizado('Cargando reporte...', false, 'CLARO-1', 'PROCESANDO')
			
			//qs('#antecedentes-iframe').src = ''

			var resultado = {
				"id": historias.sublista.id_historia,
				"nombres": historias.sublista.nombres,
				"apellidos": historias.sublista.apellidos,
				"direccion": historias.sublista.direccion,
				"cedula": historias.sublista.cedula,
				"fecha_nacimiento": historias.sublista.fecha_nacimiento,
				"peso": historias.sublista.peso,
				"talla": historias.sublista.talla,
				"antecedente": {
					"texto_base": qs('#antecedentes-enfocar').texto_base,
					"texto_html": qs('#antecedentes-enfocar').texto_html
				}
			}

			if (typeof resultado === 'object' && resultado !== null) {

				var sesion = [
					{"sesion": 'datos_pdf', "parametros": JSON.stringify(resultado)}
				]

				await tools.fullAsyncQuery('historias_antecedentes', 'modificar_sesion', sesion)

				antecedentes.cargarTabla(JSON.parse(await tools.fullAsyncQuery('historias_antecedentes', 'antecedentes_consultar', [historias.sublista.id_historia])), undefined, undefined)

				setTimeout(() => {

					if (qs('#antecedentes-previa-desplegable').style.display === 'none') {

						antecedentePrevia.prevenir = false
						antecedentePrevia.accionar()
						antecedentePrevia.prevenir = true

					}

					window.reportes.previa(qs('#antecedentes-iframe'), `../plantillas/antecedentepdf.php?&pdf=2`)

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
qs('#crud-anteditar-botones .confirmar').addEventListener('click', async e => {

	if(window.procesar) {

		notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'PROCESANDO')	

		var datos = tools.procesar('', '', 'anteditar-valores', tools);

		if (datos !== '') {

			window.procesar = false

			antecedentes.sublista.antecedente = JSON.stringify(datos[0])

			var resultado = await tools.fullAsyncQuery('historias_antecedentes', 'antecedentes_editar', [JSON.stringify(antecedentes.crud.lista), historias.sublista.id_historia], [["+", "%2B"]])

			if (resultado.trim() === 'exito') {

				antecedentes.cargarTabla(antecedentes.crud.lista)

				notificaciones.mensajeSimple('Petición realiza con éxito', false, 'V')

				window.idSeleccionada = historias.sublista.id_historia

				antEdiPop.pop()

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

qs('#crud-anteliminar-botones .eliminar').addEventListener('click', async e => {

	if(window.procesar) {

		window.procesar = false
		
		notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'PROCESANDO')	

		antecedentes.crud.lista.forEach((lista, i) => {

			if (lista.id === antecedentes.sublista.id) {

				antecedentes.crud.lista.splice(i, 1)

			}

		})

		var resultado = await tools.fullAsyncQuery('historias_antecedentes', 'antecedentes_eliminar', [JSON.stringify(antecedentes.crud.lista), historias.sublista.id_historia])

		if (resultado.trim() === 'exito') {

			antecedentes.cargarTabla(antecedentes.crud.lista)

			notificaciones.mensajeSimple('Petición realiza con éxito', false, 'V')

			antEliPop.pop()

		} else {

			notificaciones.mensajeSimple('Error al procesar la petición', resultado, 'F')

		}

		window.procesar = true

	}

})


/* -------------------------------------------------------------------------------------------------*/
/*           					EDITAR FORMATO DEL REPORTES, SUGERENCIAS	 					    */
/* -------------------------------------------------------------------------------------------------*/
qs('#crud-antecedentes-contenedor .cargar').addEventListener('mouseenter', e => {

	qs('#crud-antecedentes-personalizacion').removeAttribute('data-hidden')	

})

qs('#crud-antecedentes-contenedor .cargar').addEventListener('mouseleave', e => {

	qs('#crud-antecedentes-personalizacion').setAttribute('data-hidden', '')

})

qs('#crud-anteditar-pop .filas').addEventListener('mouseenter', e => {

	qs('#crud-anteditar-personalizacion').removeAttribute('data-hidden')	

})

qs('#crud-anteditar-pop .filas').addEventListener('mouseleave', e => {

	qs('#crud-anteditar-personalizacion').setAttribute('data-hidden', '')

})


/* -------------------------------------------------------------------------------------------------*/
/*           					LIMPIAR CARGA DE ANTECEDENTES				 					    */
/* -------------------------------------------------------------------------------------------------*/
qs('#antecedentes-limpiar').addEventListener('click', e => {

	tools.limpiar('.antecedentes-valores', '', {})

	notificaciones.mensajeSimple('Datos limpiados', false, 'V')

})

/* -------------------------------------------------------------------------------------------------*/
/*           					IMPRIMIR REPORTE							 					    */
/* -------------------------------------------------------------------------------------------------*/
qs('#crud-antprevia-botones .imprimir').addEventListener('click', e => {
	window.reportes.imprimirPDF(`../plantillas/antecedentepdf.php?&pdf=2`, {})

	setTimeout(() => {
		antPrePop.pop()
	}, 1000)
})