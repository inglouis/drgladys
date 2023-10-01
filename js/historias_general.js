import { customDesplegable } from '../js/main.js';
import { historias, tools, notificaciones, reporteSeleccionado } from '../js/historias.js';
import { generales } from '../js/historias.js';

/* 1)------------------------------------------------------------------------------------------------*/
/* ---------------------------------------- generales ---------------------------------------------*/
/*---------------------------------------------------------------------------------------------------*/

export const generalPrevia = new customDesplegable('#generales-contenedor .desplegable-contenedor', '#generales-contenedor .reporte-previa', '#generales-contenedor .desplegable-cerrar', undefined, 'fit-content')

generalPrevia.eventos()
generalPrevia.prevenir = true

/* -------------------------------------------------------------------------------------------------*/
/*           						general - PROPIEDADES				 					    */
/* -------------------------------------------------------------------------------------------------*/
generales['crud'].generarColumnas(['gSpan', null, null], [false],['HTML'], 'generales-contenedor', 0)
generales['crud'].generarColumnas(['gSpan', null, null], [false],['HTML'], 'fecha-contenedor', 0)
/////////////////////////////////////////////////////
///
generales['crud']['propiedadesTr'] = {
	"contenedor": (e) => {

		var fr = new DocumentFragment(),
			th = generales, 
			contenedor = e.querySelector('.generales-contenedor'), 
			contenido = th.contenido.cloneNode(true)

		contenedor.innerHTML = ''
		contenedor.appendChild(contenido)
		contenedor.setAttribute('id', `id-${e.sublista.id}-${reporteSeleccionado}`)
		
		contenedor.querySelector('.crud-datos-contenedor').setAttribute('id', `a-id-${e.sublista.id}-${reporteSeleccionado}`)

		var texto = JSON.parse(e.sublista.general).texto_html

		contenedor.querySelector('.general').innerHTML = texto.toUpperCase()

		contenedor.querySelector('.titulo').innerHTML = e.sublista.titulo
		contenedor.querySelector('.nombre').insertAdjacentHTML('afterbegin', `<b>- Nombre:</b> ${e.sublista.nombres}`)
		contenedor.querySelector('.apellido').insertAdjacentHTML('afterbegin', `<b>- Apellido:</b> ${e.sublista.apellidos}`)
		contenedor.querySelector('.cedula').insertAdjacentHTML('afterbegin', `<b>- Cédula/pasaporte:</b> ${e.sublista.cedula}`)
		contenedor.querySelector('.edad').insertAdjacentHTML('afterbegin', `<b>- Edad:</b> ${tools.calcularFecha(new Date(e.sublista.fecha_nacimiento))}`)
		
		setTimeout(() => {

			window.animaciones.generar(`#id-${e.sublista.id}-${reporteSeleccionado} .crud-datos`, [`#a-id-${e.sublista.id}-${reporteSeleccionado}`])

		}, 0)

	},
	"fecha": (e) => {

		var th = generales, 
			contenedor = e.querySelector('.fecha-contenedor'), 
			contenido = th.contenidoFecha.cloneNode(true)

		contenedor.innerHTML = ''
		contenedor.appendChild(contenido)

		contenedor.querySelector('.fecha-template').value = e.sublista.fecha
		contenedor.querySelector('.hora-template').value  = e.sublista.hora

	},
	"eliminar": (e) => {
		var th = generales,
			contenedor = historias.contenedorEliminarBoton.cloneNode(true)

		contenedor.setAttribute('data-hidden', '')
		contenedor.querySelector('.eliminar-boton').value = e.sublista.id

		e.querySelector('.crud-eliminar-contenedor').appendChild(contenedor)

		contenedor = e.querySelector('.eliminar-contenedor')
		
		e.addEventListener('mouseover', el => {

			if (el.target.classList.contains('eliminar')) {
				var coordenadas = e.querySelector('.eliminar').getBoundingClientRect()
				//contenedor.setAttribute('style', `left: ${coordenadas.left - 310}px`)
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
/////////////////////////////////////////////////////
///
generales['crud']['customBodyEvents'] = {
	/* -------------------------------------------------------------------------------------------------*/
	/*           								  MODELO 											    */
	/* -------------------------------------------------------------------------------------------------*/
	"modelo": async (e) => {

		if (e.target.classList.contains('modelo')) {

			generales.sublista = tools.pariente(e.target, 'TR').sublista

			reporteModeloSeleccionado = {datos: tools.copiaLista(generales.sublista), reporte: 'general'}

			notificaciones.mensajeSimple('Modelo copiado', false, 'V')

		}

	},
	/* -------------------------------------------------------------------------------------------------*/
	/*           								REUTILIZAR 											    */
	/* -------------------------------------------------------------------------------------------------*/
	"reusar": async (e) => {

		if (e.target.classList.contains('reusar')) {

			generales.sublista = tools.pariente(e.target, 'TR').sublista

			tools.limpiar('.general-valores', '', {})
			rellenar.contenedores(generales.sublista, '.general-valores', {elemento: e.target, id: 'value'}, {})

			notificaciones.mensajeSimple('Datos cargados', false, 'V')

		}

	},
	/* -------------------------------------------------------------------------------------------------*/
	/*           					ENVIAR LOS DATOS PARA EDITAR GENERALES 		  					    */
	/* -------------------------------------------------------------------------------------------------*/
	"editar": async (e) => {

		if (e.target.classList.contains('editar')) {

			generales.sublista = tools.pariente(e.target, 'TR').sublista

			tools.limpiar('.geneditar-valores', '', {})
			rellenar.contenedores(generales.sublista, '.geneditar-valores', {elemento: e.target, id: 'value'}, {})

			genPop.pop()

		}

	},
	/* -------------------------------------------------------------------------------------------------*/
	/*           				ENVIAR LOS DATOS PARA REIMPRIMIR EL ANTECENDENTE   					    */
	/* -------------------------------------------------------------------------------------------------*/
	"reimprimir": async (e) => {

		if (e.target.classList.contains('reimprimir')) {

			generales.sublista = tools.pariente(e.target, 'TR').sublista

			var sesion = [
					{"sesion": 'datos_pdf', "parametros": JSON.stringify(generales.sublista)}
				]

			await tools.fullAsyncQuery('historias', 'modificar_sesion', sesion)

			qs('#crud-previas-popup iframe').src = ''

			prePop.pop()

			window.reportes.previa(qs('#crud-previas-popup iframe'), `../plantillas/${reporteSeleccionado}pdf.php?&pdf=2`)

		}

	}
};


(async () => {

	generales.cargarTabla([], undefined, undefined)

})()

/* -------------------------------------------------------------------------------------------------*/
/*           							GENERALES - NOTIFICAR	  								    */
/* -------------------------------------------------------------------------------------------------*/
qs('#generales-contenedor').identificador = 'general'

qs("#generales-contenedor .reporte-notificar").addEventListener('click', async e => {

	if (window.procesar) {

		var elemento = qs('#generales-contenedor')

		window.procesar = false

		var datos = tools.procesar('', '', `${elemento.identificador}-valores`, tools);

		if (datos !== '') {
		
			notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'PROCESANDO')

			var lista = { 
				"id_historia": historias.sublista.id_historia,
				"nombres": historias.sublista.nombres, 
				"apellidos": historias.sublista.apellidos, 
				"cedula": historias.sublista.cedula, 
				"fecha_nacimiento": historias.sublista.fecha_naci,
				"titulo": datos[0].toUpperCase(),
				"general": {
					"texto_base": qs(`#${elemento.identificador}-informacion`).texto_base,
					"texto_html": qs(`#${elemento.identificador}-informacion`).texto_html
				}
			}

			var resultado = JSON.parse(await tools.fullAsyncQuery(`historias_notificaciones`, `notificar`, [lista, elemento.identificador], [["+", "%2B"]]))

			if (typeof resultado === 'object' && resultado !== null) {

				tools.limpiar(`.${elemento.identificador}-valores`, '', {})

				notificaciones.mensajeSimple('Notificación enviada', '', 'V')

			} else {

				notificaciones.mensajeSimple('Error al procesar la petición', resultado, 'F')

			}

		}

	} else {

		notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'PROCESANDO')
		
	}

})

/* -------------------------------------------------------------------------------------------------*/
/*           							GENERALES - CARGAR	  									    */
/* -------------------------------------------------------------------------------------------------*/
qs("#generales-contenedor .reporte-cargar").addEventListener('click', async e => {

	if(window.procesar) {

		var elemento = qs('#generales-contenedor')

		window.procesar = false

		notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'PROCESANDO')

		var datos = tools.procesar('', '', `${elemento.identificador}-valores`, tools);

		if (datos !== '') {
			
			var lista = { 
				"nombres": historias.sublista.nombres, 
				"apellidos": historias.sublista.apellidos, 
				"cedula": historias.sublista.cedula, 
				"fecha_nacimiento": historias.sublista.fecha_naci,
				"titulo": datos[0].toUpperCase(),
				"general": {
					"texto_base": qs(`#${elemento.identificador}-informacion`).texto_base,
					"texto_html": qs(`#${elemento.identificador}-informacion`).texto_html
				}
			}

			var resultado = JSON.parse(await tools.fullAsyncQuery(`historias_${elemento.identificador}`, `${elemento.identificador}_insertar`, [lista, historias.sublista.id_historia], [["+", "%2B"]]))

			if (typeof resultado === 'object' && resultado !== null) {

				tools.limpiar(`.${elemento.identificador}-valores`, '', {})

				var sesion = [{"sesion": 'datos_pdf', "parametros": JSON.stringify(resultado)}]

				await tools.fullAsyncQuery('historias', 'modificar_sesion', sesion)

				generales.cargarTabla(JSON.parse(await tools.fullAsyncQuery(`historias_${elemento.identificador}`, `${elemento.identificador}_consultar`, [historias.sublista.id_historia])), undefined, undefined)

				setTimeout(() => {

					if (elemento.querySelector('.desplegable-contenedor').style.display !== 'none') {

						generalPrevia.prevenir = false
						generalPrevia.accionar()
						generalPrevia.prevenir = true

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
/*           							GENERAL - PREVIA					  					    */
/* -------------------------------------------------------------------------------------------------*/
qs("#generales-contenedor .reporte-previa").addEventListener('click', async e => {

	if(window.procesar) {

		var elemento = qs('#generales-contenedor')

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
				"titulo": datos[0].toUpperCase(),
				"general": {
					"texto_base": qs(`#${elemento.identificador}-informacion`).texto_base,
					"texto_html": qs(`#${elemento.identificador}-informacion`).texto_html
				}
			}

			if (typeof resultado === 'object' && resultado !== null) {

				var sesion = [ {"sesion": 'datos_pdf', "parametros": JSON.stringify(resultado)} ]

				await tools.fullAsyncQuery('historias', 'modificar_sesion', sesion)

				generales.cargarTabla(JSON.parse(await tools.fullAsyncQuery(`historias_${elemento.identificador}`, `${elemento.identificador}_consultar`, [historias.sublista.id_historia])), undefined, undefined)

				setTimeout(() => {

					if (elemento.querySelector('.desplegable-contenedor').style.display === 'none') {

						generalPrevia.prevenir = false
						generalPrevia.accionar()
						generalPrevia.prevenir = true

					}

					window.reportes.previa(elemento.querySelector('.desplegable-iframe'), `../plantillas/${elemento.identificador}pdf.php?&pdf=2`)

				}, 1000)

			} else {

				notificaciones.mensajeSimple('Error al procesar la petición', null, 'F')

			}

		}

	} else {

		notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'PROCESANDO')
		
	}

})

/* -------------------------------------------------------------------------------------------------*/
/*           							GENERAL - EDITAR			 							    */
/* -------------------------------------------------------------------------------------------------*/
qs('#crud-geneditar-botones .confirmar').addEventListener('click', async e => {

	if(window.procesar) {

		notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'PROCESANDO')	

		var elemento = qs('#generales-contenedor')

		window.procesar = false

		var datos = tools.procesar('', '', `geneditar-valores`, tools);

		if (datos !== '') {

			var listaGeneral = (typeof datos[1] === 'string') ? JSON.parse(datos[1]) : datos[1];

			generales.sublista.titulo  = datos[0]
			generales.sublista.general = JSON.stringify(listaGeneral)

			var resultado = await tools.fullAsyncQuery(`historias_${elemento.identificador}`, `${elemento.identificador}_editar`, [JSON.stringify(generales.crud.lista), historias.sublista.id_historia], [["+", "%2B"]])

			if (resultado.trim() === 'exito') {

				generales.cargarTabla(generales.crud.lista)

				notificaciones.mensajeSimple('Petición realiza con éxito', false, 'V')

				window.idSeleccionada = historias.sublista.id_historia

				genPop.pop()

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
/*           						general - ELIMINAR					 					    */
/* -------------------------------------------------------------------------------------------------*/
qs('#generales-contenedor table').addEventListener('click', async e => {

	if (e.target.classList.contains('eliminar-boton')) {

		if (window.procesar) {

			var elemento = qs('#generales-contenedor')

			window.procesar = false
			
			notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'PROCESANDO')	

			generales.crud.lista.forEach((lista, i) => {

				if (lista.id === Number(e.target.value)) {

					generales.crud.lista.splice(i, 1)

				}

			})

			var resultado = await tools.fullAsyncQuery(`historias_${elemento.identificador}`, `${elemento.identificador}_eliminar`, [JSON.stringify(generales.crud.lista), historias.sublista.id_historia])

			if (resultado.trim() === 'exito') {

				generales.cargarTabla(generales.crud.lista)

				notificaciones.mensajeSimple('Petición realiza con éxito', false, 'V')

			} else {

				notificaciones.mensajeSimple('Error al procesar la petición', resultado, 'F')

			}

			window.procesar = true

		}

	}

})

/* -------------------------------------------------------------------------------------------------*/
/*           						  general - TEXTO PREVIA	 								    */
/* -------------------------------------------------------------------------------------------------*/
qs('#generales-contenedor .cargar').addEventListener('mouseenter', e => {

	qs('#generales-contenedor .personalizacion').removeAttribute('data-hidden')	

})

qs('#generales-contenedor .cargar').addEventListener('mouseleave', e => {

	qs('#generales-contenedor .personalizacion').setAttribute('data-hidden', '')

})

qs('#crud-geneditar-pop .filas').addEventListener('mouseenter', e => {

	qs('#crud-geneditar-personalizacion').removeAttribute('data-hidden')	

})

qs('#crud-geneditar-pop .filas').addEventListener('mouseleave', e => {

	qs('#crud-geneditar-personalizacion').setAttribute('data-hidden', '')

})

/* -------------------------------------------------------------------------------------------------*/
/*           						GENERAL - LIMPIAR					 					    */
/* -------------------------------------------------------------------------------------------------*/
qs('#generales-contenedor .limpiar').addEventListener('click', e => {

	tools.limpiar('.general-valores', '', {})

	notificaciones.mensajeSimple('Datos limpiados', false, 'V')

})

/* -------------------------------------------------------------------------------------------------*/
/*           						GENERAL - REUSAR MODELO				 					    */
/* -------------------------------------------------------------------------------------------------*/
qs('#generales-contenedor .reutilizar').addEventListener('click', e => {

	if (typeof reporteModeloSeleccionado['reporte'] !== 'undefined') {

		if (reporteModeloSeleccionado['reporte'] === 'general') {

			tools.limpiar('.general-valores', '', {})
			rellenar.contenedores(reporteModeloSeleccionado['datos'], '.general-valores', {elemento: e.target, id: 'value'}, {})
			notificaciones.mensajeSimple('Modelo cargado', false, 'V')

		} else {

			notificaciones.mensajeSimple('El modelo seleccionado no es válido para este reporte', false, 'F')

			setTimeout(() => {notificaciones.mensajeSimple(`El modelo requerido es: ${reporteModeloSeleccionado['reporte'].toUpperCase()}`, false, 'V')}, 2000)

		}


	} else {

		notificaciones.mensajeSimple('Ningún modelo ha sido seleccionado', false, 'F')

	}

})

/* -------------------------------------------------------------------------------------------------*/
/*           						GENERAL - SCROLL TOP						 					    */
/* -------------------------------------------------------------------------------------------------*/
qs('#general-busqueda').addEventListener('keydown', e => {
	qs('#tabla-general').parentElement.scrollTo(0,0)
})