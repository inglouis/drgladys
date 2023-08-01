import { customDesplegable } from '../js/main.js';
import {historias, tools, notificaciones, reporteSeleccionado} from '../js/historias.js';
import {constancias} from '../js/historias.js';

/* -------------------------------------------------------------------------------------------------*/
/*           						IMPRESION FINAL GENERAL					 					    */
/* -------------------------------------------------------------------------------------------------*/
qs('#crud-previas-botones .imprimir').addEventListener('click', e => {
	
	window.reportes.imprimirPDF(`../plantillas/${reporteSeleccionado}pdf.php?&pdf=2`, {})

	setTimeout(() => {
		prePop.pop()
	}, 1000)

})

/* 1)------------------------------------------------------------------------------------------------*/
/* ---------------------------------------- CONSTANCIAS ---------------------------------------------*/
/*---------------------------------------------------------------------------------------------------*/

export const constanciaPrevia = new customDesplegable('#constancias-contenedor .desplegable-contenedor', '#constancias-contenedor .reporte-previa', '#constancias-contenedor .desplegable-cerrar', undefined, 'fit-content')

constanciaPrevia.eventos()
constanciaPrevia.prevenir = true

/* -------------------------------------------------------------------------------------------------*/
/*           							CONSTANCIAS - CARGAR	  								    */
/* -------------------------------------------------------------------------------------------------*/
qs('#constancias-contenedor').identificador = 'constancia'

qs("#constancias-contenedor .reporte-cargar").addEventListener('click', async e => {

	if(window.procesar) {

		var elemento = qs('#constancias-contenedor')

		window.procesar = false

		notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'PROCESANDO')

		var datos = tools.procesar('', '', `${elemento.identificador}-valores`, tools);

		if (datos !== '') {
			
			var lista = { 
				"nombres": historias.sublista.nombres, 
				"apellidos": historias.sublista.apellidos, 
				"cedula": historias.sublista.cedula, 
				"fecha_nacimiento": historias.sublista.fecha_naci,
				"constancia": {
					"texto_base": qs(`#${elemento.identificador}-textarea`).texto_base,
					"texto_html": qs(`#${elemento.identificador}-textarea`).texto_html
				}
			}

			var resultado = JSON.parse(await tools.fullAsyncQuery('historias_reportes', `${elemento.identificador}_insertar`, [lista, historias.sublista.id_historia], [["+", "%2B"]]))

			if (typeof resultado === 'object' && resultado !== null) {

				tools.limpiar(`.${elemento.identificador}-valores`, '', {})

				var sesion = [{"sesion": 'datos_pdf', "parametros": JSON.stringify(resultado)}]

				await tools.fullAsyncQuery('historias', 'modificar_sesion', sesion)

				constancias.cargarTabla(JSON.parse(await tools.fullAsyncQuery('historias_reportes', `${elemento.identificador}_consultar`, [historias.sublista.id_historia])), undefined, undefined)

				setTimeout(() => {

					if (elemento.querySelector('.desplegable-contenedor').style.display !== 'none') {

						constanciaPrevia.prevenir = false
						constanciaPrevia.accionar()
						constanciaPrevia.prevenir = true

					}

					window.reportes.imprimirPDF(`../plantillas/${elemento.identificador}pdf.php?&pdf=2`, {})

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
/*           							CONSTANCIA - PREVIA					  					    */
/* -------------------------------------------------------------------------------------------------*/
qs("#constancias-contenedor .reporte-previa").addEventListener('click', async e => {

	if(window.procesar) {

		var elemento = qs('#constancias-contenedor')

		window.procesar = false

		var datos = tools.procesar('', '', `${elemento.identificador}-valores`, tools);

		elemento.querySelector('.desplegable-iframe').src = ''

		if (datos !== '') {

			notificaciones.mensajePersonalizado('Cargando reporte...', false, 'CLARO-1', 'PROCESANDO')

			var resultado = {
				"id_historia": historias.sublista.id_historia, 
				"nombres": historias.sublista.nombres, 
				"apellidos": historias.sublista.apellidos, 
				"cedula": historias.sublista.cedula, 
				"fecha_nacimiento": historias.sublista.fecha_naci,
				"constancia": {
					"texto_base": qs(`#${elemento.identificador}-textarea`).texto_base,
					"texto_html": qs(`#${elemento.identificador}-textarea`).texto_html
				}
			}

			if (typeof resultado === 'object' && resultado !== null) {

				var sesion = [ {"sesion": 'datos_pdf', "parametros": JSON.stringify(resultado)} ]

				await tools.fullAsyncQuery('historias', 'modificar_sesion', sesion)

				constancias.cargarTabla(JSON.parse(await tools.fullAsyncQuery('historias_reportes', `${elemento.identificador}_consultar`, [historias.sublista.id_historia])), undefined, undefined)

				setTimeout(() => {

					if (elemento.querySelector('.desplegable-contenedor').style.display === 'none') {

						constanciaPrevia.prevenir = false
						constanciaPrevia.accionar()
						constanciaPrevia.prevenir = true

					}

					window.reportes.previa(elemento.querySelector('.desplegable-iframe'), `../plantillas/${elemento.identificador}pdf.php?&pdf=2`)

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
/*           							CONSTANCIA - EDITAR			 							    */
/* -------------------------------------------------------------------------------------------------*/
qs('#crud-coneditar-botones .confirmar').addEventListener('click', async e => {

	if(window.procesar) {

		notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'PROCESANDO')	

		var elemento = qs('#constancias-contenedor')

		window.procesar = false

		var datos = tools.procesar('', '', `coneditar-valores`, tools);

		if (datos !== '') {

			var lista = (typeof datos[0] === 'string') ? JSON.parse(datos[0]) : datos[0];

			constancias.sublista.constancia = JSON.stringify(lista)

			var resultado = await tools.fullAsyncQuery('historias_reportes', `${elemento.identificador}_editar`, [JSON.stringify(constancias.crud.lista), historias.sublista.id_historia], [["+", "%2B"]])

			if (resultado.trim() === 'exito') {

				constancias.cargarTabla(constancias.crud.lista)

				notificaciones.mensajeSimple('Petición realiza con éxito', false, 'V')

				window.idSeleccionada = historias.sublista.id_historia

				conPop.pop()

			} else {

				notificaciones.mensajeSimple('Error al procesar la petición', resultado, 'F')

			}

			window.procesar = true

		} else {
			window.procesar = true
		}

	}

})

/* -------------------------------------------------------------------------------------------------*/
/*           						CONSTANCIA - ELIMINAR					 					    */
/* -------------------------------------------------------------------------------------------------*/
qs('#constancias-contenedor table').addEventListener('click', async e => {

	if (e.target.classList.contains('eliminar-boton')) {

		if (window.procesar) {

			var elemento = qs('#constancias-contenedor')

			window.procesar = false
			
			notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'PROCESANDO')	

			constancias.crud.lista.forEach((lista, i) => {

				if (lista.id === Number(e.target.value)) {

					constancias.crud.lista.splice(i, 1)

				}

			})

			var resultado = await tools.fullAsyncQuery('historias_reportes', `${elemento.identificador}_eliminar`, [JSON.stringify(constancias.crud.lista), historias.sublista.id_historia])

			if (resultado.trim() === 'exito') {

				constancias.cargarTabla(constancias.crud.lista)

				notificaciones.mensajeSimple('Petición realiza con éxito', false, 'V')

			} else {

				notificaciones.mensajeSimple('Error al procesar la petición', resultado, 'F')

			}

			window.procesar = true

		}

	}

})

/* -------------------------------------------------------------------------------------------------*/
/*           						  CONSTANCIA - TEXTO PREVIA	 								    */
/* -------------------------------------------------------------------------------------------------*/
qs('#constancias-contenedor .cargar').addEventListener('mouseenter', e => {

	qs('#constancias-contenedor .personalizacion').removeAttribute('data-hidden')	

})

qs('#constancias-contenedor .cargar').addEventListener('mouseleave', e => {

	qs('#constancias-contenedor .personalizacion').setAttribute('data-hidden', '')

})

qs('#crud-coneditar-pop .filas').addEventListener('mouseenter', e => {

	qs('#crud-coneditar-personalizacion').removeAttribute('data-hidden')	

})

qs('#crud-coneditar-pop .filas').addEventListener('mouseleave', e => {

	qs('#crud-coneditar-personalizacion').setAttribute('data-hidden', '')

})

/* -------------------------------------------------------------------------------------------------*/
/*           						CONSTANCIA - LIMPIAR					 					    */
/* -------------------------------------------------------------------------------------------------*/
qs('#constancias-contenedor .limpiar').addEventListener('click', e => {

	tools.limpiar('.constancia-valores', '', {})

	notificaciones.mensajeSimple('Datos limpiados', false, 'V')

})