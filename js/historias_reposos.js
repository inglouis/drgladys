import {historias, reposos, tools, notificaciones, reposoPrevia} from '../js/historias.js';


/* -------------------------------------------------------------------------------------------------*/
/*           						GENERAR REPORTE DEL ANTECENDENTE		  					    */
/* -------------------------------------------------------------------------------------------------*/
qs("#reposos-procesar .reporte-cargar").addEventListener('click', async e => {

	if(window.procesar) {

		window.procesar = false

		notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'PROCESANDO')

		var datos = tools.procesar('', '', 'reposos-valores', tools);

		if (datos !== '') {
			
			var resultado = JSON.parse(await tools.fullAsyncQuery('historias_reposos', 'reposos_insertar', datos, [["+", "%2B"]]))

			if (typeof resultado === 'object' && resultado !== null) {

				tools.limpiar('.reposos-valores', '', {"contenedor-personalizable": window.camposTextosPersonalizables})

				var sesion = [
					{"sesion": 'datos_pdf', "parametros": JSON.stringify(resultado)}
				]

				await tools.fullAsyncQuery('historias_reposos', 'modificar_sesion', sesion)

				reposos.cargarTabla(JSON.parse(await tools.fullAsyncQuery('historias_reposos', 'reposos_consultar', [historias.sublista.id_historia])), undefined, undefined)

				setTimeout(() => {

					if (qs('#reposos-previa-desplegable').style.display !== 'none') {

						reposoPrevia.prevenir = false
						reposoPrevia.accionar()
						reposoPrevia.prevenir = true

					}

					window.reportes.imprimirPDF(`../plantillas/reposopdf.php?&pdf=2`, {})

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
/*           						VISTA PREVIA DE REPOSO				  					    */
/* -------------------------------------------------------------------------------------------------*/
qs("#reposos-procesar .reporte-previa").addEventListener('click', async e => {

	if(window.procesar) {

		window.procesar = false

		var datos = tools.procesar('', '', 'reposos-valores', tools);

		if (datos !== '') {

			notificaciones.mensajePersonalizado('Cargando reporte...', false, 'CLARO-1', 'PROCESANDO')
			
			//qs('#reposos-iframe').src = ''

			var resultado = {
				"id": historias.sublista.id_historia,
				"nombres": historias.sublista.nombres,
				"apellidos": historias.sublista.apellidos,
				"cedula": historias.sublista.cedula,
				"motivo": {
					"texto": qs('#reposos-enfocar').texto,
					"textoPrevia": qs('#reposos-enfocar').textoPrevia
				},
				"fecha_inicio": datos[1],
				"dias": datos[2].trim(),
				"fecha_final": datos[3],
				"fecha_simple": datos[4].toUpperCase()
			}

			if (typeof resultado === 'object' && resultado !== null) {

				var sesion = [
					{"sesion": 'datos_pdf', "parametros": JSON.stringify(resultado)}
				]

				await tools.fullAsyncQuery('historias_reposos', 'modificar_sesion', sesion)

				//reposos.cargarTabla(JSON.parse(await tools.fullAsyncQuery('historias_reposos', 'reposos_consultar', [historias.sublista.id_historia])), undefined, undefined)

				setTimeout(() => {

					if (qs('#reposos-previa-desplegable').style.display === 'none') {

						reposoPrevia.prevenir = false
						reposoPrevia.accionar()
						reposoPrevia.prevenir = true

					}

					window.reportes.previa(qs('#reposos-iframe'), `../plantillas/reposopdf.php?&pdf=2`)

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
qs('#crud-repeditar-botones .confirmar').addEventListener('click', async e => {

	if(window.procesar) {

		notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'PROCESANDO')	

		var datos = tools.procesar('', '', 'repeditar-valores', tools);

		if (datos !== '') {

			window.procesar = false

			reposos.sublista.motivo = JSON.stringify(datos[0])
			reposos.sublista.fecha_inicio = datos[1].toUpperCase()
			reposos.sublista.dias = datos[2].trim()
			reposos.sublista.fecha_final = datos[3].toUpperCase()
			reposos.sublista.fecha_simple = datos[4].toUpperCase()

			var resultado = await tools.fullAsyncQuery('historias_reposos', 'reposos_editar', [JSON.stringify(reposos.crud.lista), historias.sublista.id_historia], [["+", "%2B"]])

			if (resultado.trim() === 'exito') {

				reposos.cargarTabla(reposos.crud.lista)

				notificaciones.mensajeSimple('Petición realiza con éxito', false, 'V')

				repEdiPop.pop()

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

qs('#crud-repeliminar-botones .eliminar').addEventListener('click', async e => {

	if(window.procesar) {

		window.procesar = false
		
		notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'PROCESANDO')	

		reposos.crud.lista.forEach((lista, i) => {

			if (lista.id === reposos.sublista.id) {

				reposos.crud.lista.splice(i, 1)

			}

		})

		var resultado = await tools.fullAsyncQuery('historias_reposos', 'reposos_eliminar', [JSON.stringify(reposos.crud.lista), historias.sublista.id_historia])

		if (resultado.trim() === 'exito') {

			reposos.cargarTabla(reposos.crud.lista)

			notificaciones.mensajeSimple('Petición realiza con éxito', false, 'V')

			repEliPop.pop()

		} else {

			notificaciones.mensajeSimple('Error al procesar la petición', resultado, 'F')

		}

		window.procesar = true

	}

})


/* -------------------------------------------------------------------------------------------------*/
/*           					EDITAR FORMATO DEL REPORTES, SUGERENCIAS	 					    */
/* -------------------------------------------------------------------------------------------------*/
qs('#crud-reposos-contenedor .cargar').addEventListener('mouseenter', e => {

	qs('#crud-reposos-personalizacion').removeAttribute('data-hidden')	

})

qs('#crud-reposos-contenedor .cargar').addEventListener('mouseleave', e => {

	qs('#crud-reposos-personalizacion').setAttribute('data-hidden', '')

})

qs('#crud-anteditar-pop .filas').addEventListener('mouseenter', e => {

	qs('#crud-repeditar-personalizacion').removeAttribute('data-hidden')	

})

qs('#crud-anteditar-pop .filas').addEventListener('mouseleave', e => {

	qs('#crud-repeditar-personalizacion').setAttribute('data-hidden', '')

})


/* -------------------------------------------------------------------------------------------------*/
/*           					LIMPIAR CARGA DE REPOSOS				 					    */
/* -------------------------------------------------------------------------------------------------*/
qs('#reposos-limpiar').addEventListener('click', e => {

	tools.limpiar('.reposos-valores', '', {
		"contenedor-personalizable": window.camposTextosPersonalizables,
		"procesado": e => {
			gid('reposos-inicio-insertar').value = window.dia
		}
	})

	notificaciones.mensajeSimple('Datos limpiados', false, 'V')

})

/* -------------------------------------------------------------------------------------------------*/
//operaciones relacionadas al calculo de la fecha de reposo insersion
/*-------------------------------------------------------------------------------------------------*/
qs('#reposos-dias-insertar').addEventListener('input', e => {

	qs('#reposos-fin-insertar').value = tools.calcularFecha(Number(e.target.value), 'dia', qs('#reposos-inicio-insertar').value)
	
	var now = new Date(qs('#reposos-inicio-insertar').value)
		now.setDate(now.getDate() + Number(e.target.value) - 1)

	qs('#reposos-fecha-insertar').value = now.toLocaleDateString('es-CA',{timeZone: "America/Caracas", weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })

})

qs('#reposos-inicio-insertar').addEventListener('change', e => {

	var reposo

	if(qs('#reposos-dias-insertar').value.trim() !== '') {
		reposo = Number(qs('#reposos-dias-insertar').value)
	} else {
		reposo = 0
	}

	qs('#reposos-fin-insertar').value = tools.calcularFecha(reposo, 'dia', qs('#reposos-inicio-insertar').value)
	
	var now = new Date(qs('#reposos-inicio-insertar').value)
		now.setDate(now.getDate() + reposo)

	qs('#reposos-fecha-insertar').value = now.toLocaleDateString('es-CA',{timeZone: "America/Caracas", weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })
})

/* -------------------------------------------------------------------------------------------------*/
//operaciones relacionadas al calculo de la fecha de reposo edicion
/*-------------------------------------------------------------------------------------------------*/
qs('#reposos-dias-editar').addEventListener('input', e => {

	qs('#reposos-fin-editar').value = tools.calcularFecha(Number(e.target.value), 'dia', qs('#reposos-inicio-editar').value)
	
	var now = new Date(qs('#reposos-inicio-editar').value)
		now.setDate(now.getDate() + Number(e.target.value) - 1)

	qs('#reposos-fecha-editar').value = now.toLocaleDateString('es-CA',{timeZone: "America/Caracas", weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })

})

qs('#reposos-inicio-editar').addEventListener('change', e => {

	var reposo

	if(qs('#reposos-dias-editar').value.trim() !== '') {
		reposo = Number(qs('#reposos-dias-editar').value)
	} else {
		reposo = 0
	}

	qs('#reposos-fin-editar').value = tools.calcularFecha(reposo, 'dia', qs('#reposos-inicio-editar').value)
	
	var now = new Date(qs('#reposos-inicio-editar').value)
		now.setDate(now.getDate() + reposo)

	qs('#reposos-fecha-editar').value = now.toLocaleDateString('es-CA',{timeZone: "America/Caracas", weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })
})

/* -------------------------------------------------------------------------------------------------*/
/*           					IMPRIMIR REPORTE							 					    */
/* -------------------------------------------------------------------------------------------------*/
qs('#crud-repprevia-botones .imprimir').addEventListener('click', e => {
	window.reportes.imprimirPDF(`../plantillas/reposopdf.php?&pdf=2`, {})

	setTimeout(() => {
		repPrePop.pop()
	}, 1000)
})
			