import {historias, informes, tools, notificaciones, informePrevia} from '../js/historias.js';


/* -------------------------------------------------------------------------------------------------*/
/*           						GENERAR REPORTE DEL INFORMES		  					    */
/* -------------------------------------------------------------------------------------------------*/
qs("#informes-procesar .reporte-cargar").addEventListener('click', async e => {

	if(window.procesar) {

		window.procesar = false

		notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'PROCESANDO')

		var datos = tools.procesar('', '', 'informes-valores', tools);

		if (datos !== '') {
			
			var resultado = JSON.parse(await tools.fullAsyncQuery('historias_informes', 'informes_insertar', datos, [["+", "%2B"]]))

			if (typeof resultado === 'object' && resultado !== null) {

				tools.limpiar('.informes-valores', '', {"contenedor-personalizable": window.camposTextosPersonalizables})

				var sesion = [
					{"sesion": 'datos_pdf', "parametros": JSON.stringify(resultado)}
				]

				await tools.fullAsyncQuery('historias_informes', 'modificar_sesion', sesion)

				informes.cargarTabla(JSON.parse(await tools.fullAsyncQuery('historias_informes', 'informes_consultar', [historias.sublista.id_historia])), undefined, undefined)

				setTimeout(async () => {

					if (qs('#informes-previa-desplegable').style.display !== 'none') {

						informePrevia.prevenir = false
						informePrevia.accionar()
						informePrevia.prevenir = true

					}

					window.reportes.imprimirPDF(`../plantillas/informepdf.php?&pdf=2`, {})

					var resultado = await tools.fullAsyncQuery('historias', 'cargar_historias', [])
					historias.cargarTabla(JSON.parse(resultado), undefined, undefined)
					historias.crud.botonForzar()

				}, 1000)

			} else {

				setTimeout(() => {
					notificaciones.mensajeSimple('Error al procesar la petición', resultado, 'F')
				}, 500)

			}

		}

	} else {

		notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'PROCESANDO')
		
	}

})

/* -------------------------------------------------------------------------------------------------*/
/*           						VISTA PREVIA DE ANTECEDENTE				  					    */
/* -------------------------------------------------------------------------------------------------*/
qs("#informes-procesar .reporte-previa").addEventListener('click', async e => {

	if(window.procesar) {

		window.procesar = false

		var datos = tools.procesar('', '', 'informes-valores', tools);

		if (datos !== '') {

			notificaciones.mensajePersonalizado('Cargando reporte...', false, 'CLARO-1', 'PROCESANDO')
			
			var diagnosticos = []

			datos[3].forEach(d => {
				diagnosticos.push({"id_diagnostico": d.id})
			})

			var resultado = {
				"id": historias.sublista.id_historia,
				"nombres": historias.sublista.nombres,
				"apellidos": historias.sublista.apellidos,
				"direccion": historias.sublista.direccion,
				"cedula": historias.sublista.cedula,
				"fecha_nacimiento": historias.sublista.fecha_nacimiento,
				"peso": historias.sublista.peso,
				"talla": historias.sublista.talla,
				"motivo": {
					"texto": qs('#informes-enfocar').texto,
					"textoPrevia": qs('#informes-enfocar').textoPrevia
				},
				"enfermedad": {
					"texto": qs('#informes-enfermedad').texto,
					"textoPrevia": qs('#informes-enfermedad').textoPrevia
				},
				"plan": {
					"texto": qs('#informes-plan').texto,
					"textoPrevia": qs('#informes-plan').textoPrevia
				},
				"diagnosticos": diagnosticos
			}

			if (typeof resultado === 'object' && resultado !== null) {

				var sesion = [
					{"sesion": 'datos_pdf', "parametros": JSON.stringify(resultado)}
				]

				await tools.fullAsyncQuery('historias_informes', 'modificar_sesion', sesion)

				informes.cargarTabla(JSON.parse(await tools.fullAsyncQuery('historias_informes', 'informes_consultar', [historias.sublista.id_historia])), undefined, undefined)

				setTimeout(() => {

					if (qs('#informes-previa-desplegable').style.display === 'none') {

						informePrevia.prevenir = false
						informePrevia.accionar()
						informePrevia.prevenir = true

					}

					window.reportes.previa(qs('#informes-iframe'), `../plantillas/informepdf.php?&pdf=2`)

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
qs('#crud-infeditar-botones .confirmar').addEventListener('click', async e => {

	if(window.procesar) {

		notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'PROCESANDO')	

		var datos = tools.procesar('', '', 'infeditar-valores', tools);

		if (datos !== '') {

			window.procesar = false

			var diagnosticos = []

			datos[3].forEach(d => {
				diagnosticos.push({"id_diagnostico": d.id})
			})

			informes.sublista.motivo = JSON.stringify(datos[0])
			informes.sublista.enfermedad = JSON.stringify(datos[1])
			informes.sublista.plan = JSON.stringify(datos[2])
			informes.sublista.diagnosticos = diagnosticos

			var resultado = await tools.fullAsyncQuery('historias_informes', 'informes_editar', [JSON.stringify(informes.crud.lista), historias.sublista.id_historia], [["+", "%2B"]])

			if (resultado.trim() === 'exito') {

				var lista = JSON.parse(await tools.fullAsyncQuery('historias_informes', 'informes_consultar', [historias.sublista.id_historia]))
				informes.cargarTabla(lista, undefined, undefined)

				notificaciones.mensajeSimple('Petición realiza con éxito', false, 'V')

				infEdiPop.pop()

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

qs('#crud-infeliminar-botones .eliminar').addEventListener('click', async e => {

	if(window.procesar) {

		window.procesar = false
		
		notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'PROCESANDO')	

		informes.crud.lista.forEach((lista, i) => {

			if (lista.id === informes.sublista.id) {

				informes.crud.lista.splice(i, 1)

			}

		})

		var resultado = await tools.fullAsyncQuery('historias_informes', 'informes_eliminar', [JSON.stringify(informes.crud.lista), historias.sublista.id_historia])

		if (resultado.trim() === 'exito') {

			informes.cargarTabla(informes.crud.lista)

			notificaciones.mensajeSimple('Petición realiza con éxito', false, 'V')

			infEliPop.pop()

		} else {

			notificaciones.mensajeSimple('Error al procesar la petición', resultado, 'F')

		}

		window.procesar = true

	}

})

/* -------------------------------------------------------------------------------------------------*/
/*           					EDITAR FORMATO DEL REPORTES, SUGERENCIAS	 					    */
/* -------------------------------------------------------------------------------------------------*/
qs('#crud-informes-contenedor .cargar').addEventListener('mouseenter', e => {

	qs('#crud-informes-personalizacion').removeAttribute('data-hidden')	

})

qs('#crud-informes-contenedor .cargar').addEventListener('mouseleave', e => {

	qs('#crud-informes-personalizacion').setAttribute('data-hidden', '')

})

qs('#crud-infeditar-pop .filas').addEventListener('mouseenter', e => {

	qs('#crud-infeditar-personalizacion').removeAttribute('data-hidden')	

})

qs('#crud-infeditar-pop .filas').addEventListener('mouseleave', e => {

	qs('#crud-infeditar-personalizacion').setAttribute('data-hidden', '')

})


/* -------------------------------------------------------------------------------------------------*/
/*           					LIMPIAR CARGA DE INFORMES					 					    */
/* -------------------------------------------------------------------------------------------------*/
qs('#informes-limpiar').addEventListener('click', e => {

	tools.limpiar('.informes-valores', '', {"contenedor-personalizable": window.camposTextosPersonalizables})

	notificaciones.mensajeSimple('Datos limpiados', false, 'V')

})

/* -------------------------------------------------------------------------------------------------*/
/*           					OCULTAR MOSTRAR PREVIAS DEL INFORMES		 					    */
/* -------------------------------------------------------------------------------------------------*/
var previas = [
	[qs('#informes-enfocar'), qs('#informes-previa-motivo')],
	[qs('#informes-enfermedad'), qs('#informes-previa-enfermedad')],
	[qs('#informes-plan'), qs('#informes-previa-plan')],
	[qs('#infeditar-motivo'), qs('#infeditar-previa-motivo')],
	[qs('#infeditar-enfermedad'), qs('#infeditar-previa-enfermedad')],
	[qs('#infeditar-plan'), qs('#infeditar-previa-plan')]
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
qs('#crud-infprevia-botones .imprimir').addEventListener('click', e => {
	window.reportes.imprimirPDF(`../plantillas/informepdf.php?&pdf=2`, {})

	setTimeout(() => {
		infPrePop.pop()
	}, 1000)
})
