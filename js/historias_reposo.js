import { customDesplegable } from '../js/main.js';
import { historias, tools, notificaciones, reporteSeleccionado } from '../js/historias.js';
import { reposos } from '../js/historias.js';

/* 1)------------------------------------------------------------------------------------------------*/
/* ---------------------------------------- reposoS ---------------------------------------------*/
/*---------------------------------------------------------------------------------------------------*/

export const reposoPrevia = new customDesplegable('#reposos-contenedor .desplegable-contenedor', '#reposos-contenedor .reporte-previa', '#reposos-contenedor .desplegable-cerrar', undefined, 'fit-content')

reposoPrevia.eventos()
reposoPrevia.prevenir = true

/* -------------------------------------------------------------------------------------------------*/
/*           						reposo - PROPIEDADES				 					    */
/* -------------------------------------------------------------------------------------------------*/
reposos['crud'].generarColumnas(['gSpan', null, null], [false],['HTML'], 'reposos-contenedor', 0)
reposos['crud'].generarColumnas(['gSpan', null, null], [false],['HTML'], 'fecha-contenedor', 0)
/////////////////////////////////////////////////////
///
reposos['crud']['propiedadesTr'] = {
	"contenedor": (e) => {

		var fr = new DocumentFragment(),
			th = reposos, 
			contenedor = e.querySelector('.reposos-contenedor'), 
			contenido = th.contenido.cloneNode(true)

		contenedor.innerHTML = ''
		contenedor.appendChild(contenido)
		contenedor.setAttribute('id', `id-${e.sublista.id}-${reporteSeleccionado}`)
		
		contenedor.querySelector('.crud-datos-contenedor').setAttribute('id', `a-id-${e.sublista.id}-${reporteSeleccionado}`)

		var texto = JSON.parse(e.sublista.reposo).texto_html

		contenedor.querySelectorAll('.reposos-cabecera option').forEach((el, i) => {
			if (el.value === e.sublista.cabecera) {
				el.parentElement.selectedIndex = i
			}
		})

		contenedor.querySelector('.reposos-motivo').innerHTML = `<b style="text-decoration:underline">Motivo de la cabecera:</b> ${texto.toUpperCase()}`
		contenedor.querySelector('.reposos-representante input').checked = (e.sublista.representante === 'X') ? true : false;
		contenedor.querySelector('.reposos-recomendaciones input').checked = (e.sublista.recomendaciones === 'X') ? true : false;
		contenedor.querySelector('.reposos-recomendaciones-tiempo div').innerHTML = e.sublista.recomendaciones_tiempo

		contenedor.querySelector('.reposos-fecha-inicio input').value = e.sublista.fecha_inicio
		contenedor.querySelector('.reposos-fecha-final input').value = e.sublista.fecha_final
		
		contenedor.querySelector('.reposos-fecha-dias div').innerHTML = e.sublista.dias
		contenedor.querySelector('.reposos-fecha-simple div').innerHTML = e.sublista.fecha_simple

		contenedor.querySelector('.nombre').insertAdjacentHTML('afterbegin', `<b>- Nombre:</b> ${e.sublista.nombres}`)
		contenedor.querySelector('.apellido').insertAdjacentHTML('afterbegin', `<b>- Apellido:</b> ${e.sublista.apellidos}`)
		contenedor.querySelector('.cedula').insertAdjacentHTML('afterbegin', `<b>- Cédula/pasaporte:</b> ${e.sublista.cedula}`)
		contenedor.querySelector('.edad').insertAdjacentHTML('afterbegin', `<b>- Edad:</b> ${tools.calcularFecha(new Date(e.sublista.fecha_naci))}`)
		
		setTimeout(() => {

			window.animaciones.generar(`#id-${e.sublista.id}-${reporteSeleccionado} .crud-datos`, [`#a-id-${e.sublista.id}-${reporteSeleccionado}`])

		}, 0)

	},
	"fecha": (e) => {

		var th = reposos, 
			contenedor = e.querySelector('.fecha-contenedor'), 
			contenido = th.contenidoFecha.cloneNode(true)

		contenedor.innerHTML = ''
		contenedor.appendChild(contenido)

		contenedor.querySelector('.fecha-template').value = e.sublista.fecha
		contenedor.querySelector('.hora-template').value  = e.sublista.hora

	},
	"eliminar": (e) => {
		var th = reposos,
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
reposos['crud']['customBodyEvents'] = {
	/* -------------------------------------------------------------------------------------------------*/
	/*           								  MODELO 											    */
	/* -------------------------------------------------------------------------------------------------*/
	"modelo": async (e) => {

		if (e.target.classList.contains('modelo')) {

			reposos.sublista = tools.pariente(e.target, 'TR').sublista

			reporteModeloSeleccionado = {datos: tools.copiaLista(reposos.sublista), reporte: 'reposo'}

			notificaciones.mensajeSimple('Modelo copiado', false, 'V')

		}

	},
	/* -------------------------------------------------------------------------------------------------*/
	/*           								REUTILIZAR 											    */
	/* -------------------------------------------------------------------------------------------------*/
	"reusar": async (e) => {

		if (e.target.classList.contains('reusar')) {

			reposos.sublista = tools.pariente(e.target, 'TR').sublista

			tools.limpiar('.reposo-valores', '', {})
			rellenar.contenedores(reposos.sublista, '.reposo-valores', {elemento: e.target, id: 'value'}, {})

			notificaciones.mensajeSimple('Datos cargados', false, 'V')

		}

	},
	/* -------------------------------------------------------------------------------------------------*/
	/*           					ENVIAR LOS DATOS PARA EDITAR LA reposo   					    */
	/* -------------------------------------------------------------------------------------------------*/
	"editar": async (e) => {

		if (e.target.classList.contains('editar')) {

			reposos.sublista = tools.pariente(e.target, 'TR').sublista

			tools.limpiar('.repeditar-valores', '', {})	

			rellenar.contenedores(reposos.sublista, '.repeditar-valores', {elemento: e.target, id: 'value'}, {})

			repoPop.pop()

		}

	},
	/* -------------------------------------------------------------------------------------------------*/
	/*           				ENVIAR LOS DATOS PARA REIMPRIMIR EL ANTECENDENTE   					    */
	/* -------------------------------------------------------------------------------------------------*/
	"reimprimir": async (e) => {

		if (e.target.classList.contains('reimprimir')) {

			reposos.sublista = tools.pariente(e.target, 'TR').sublista

			var sesion = [
					{"sesion": 'datos_pdf', "parametros": JSON.stringify(reposos.sublista)}
				]

			await tools.fullAsyncQuery('historias', 'modificar_sesion', sesion)

			qs('#crud-previas-popup iframe').src = ''

			prePop.pop()

			window.reportes.previa(qs('#crud-previas-popup iframe'), `../plantillas/${reporteSeleccionado}pdf.php?&pdf=2`)

		}

	}
};


(async () => {

	reposos.cargarTabla([], undefined, undefined)

})()

/* -------------------------------------------------------------------------------------------------*/
/*           							REPOSOS - NOTIFICAR	  								    */
/* -------------------------------------------------------------------------------------------------*/
qs('#reposos-contenedor').identificador = 'reposo'

qs("#reposos-contenedor .reporte-notificar").addEventListener('click', async e => {

	if (window.procesar) {

		var elemento = qs('#reposos-contenedor')

		window.procesar = false

		var datos = tools.procesar('', '', `${elemento.identificador}-valores`, tools);

		if (datos !== '') {
		
			notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'PROCESANDO')

			var lista = { 
				"id_historia": historias.sublista.id_historia,
				"nombres": historias.sublista.nombres, 
				"apellidos": historias.sublista.apellidos, 
				"cedula": historias.sublista.cedula, 
				"fecha_naci": historias.sublista.fecha_naci,
				"cabecera": datos[0],
				"representante": datos[2],
				"recomendaciones": datos[3],
				"recomendaciones_tiempo": datos[4],
				"fecha_inicio": datos[5],
				"dias": datos[6].trim(),
				"fecha_final": datos[7],
				"fecha_simple": datos[8].toUpperCase(),
				"reposo": {
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
/*           							REPOSOS - CARGAR	  									    */
/* -------------------------------------------------------------------------------------------------*/
qs('#reposos-contenedor').identificador = 'reposo'

qs("#reposos-contenedor .reporte-cargar").addEventListener('click', async e => {

	if(window.procesar) {

		var elemento = qs('#reposos-contenedor')

		window.procesar = false

		notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'PROCESANDO')

		var datos = tools.procesar('', '', `${elemento.identificador}-valores`, tools);

		if (datos !== '') {
			
			var lista = { 
				"id_historia": historias.sublista.id_historia, 
				"nombres": historias.sublista.nombres, 
				"apellidos": historias.sublista.apellidos, 
				"cedula": historias.sublista.cedula, 
				"fecha_naci": historias.sublista.fecha_naci,
				"cabecera": datos[0],
				"representante": datos[2],
				"recomendaciones": datos[3],
				"recomendaciones_tiempo": datos[4],
				"fecha_inicio": datos[5],
				"dias": datos[6].trim(),
				"fecha_final": datos[7],
				"fecha_simple": datos[8].toUpperCase(),
				"reposo": {
					"texto_base": qs(`#${elemento.identificador}-informacion`).texto_base,
					"texto_html": qs(`#${elemento.identificador}-informacion`).texto_html
				}
			}

			var resultado = JSON.parse(await tools.fullAsyncQuery(`historias_${elemento.identificador}`, `${elemento.identificador}_insertar`, [lista, historias.sublista.id_historia], [["+", "%2B"]]))

			if (typeof resultado === 'object' && resultado !== null) {

				tools.limpiar(`.${elemento.identificador}-valores`, '', {})

				var sesion = [{"sesion": 'datos_pdf', "parametros": JSON.stringify(resultado)}]

				await tools.fullAsyncQuery('historias', 'modificar_sesion', sesion)

				reposos.cargarTabla(JSON.parse(await tools.fullAsyncQuery(`historias_${elemento.identificador}`, `${elemento.identificador}_consultar`, [historias.sublista.id_historia])), undefined, undefined)

				setTimeout(() => {

					if (elemento.querySelector('.desplegable-contenedor').style.display !== 'none') {

						reposoPrevia.prevenir = false
						reposoPrevia.accionar()
						reposoPrevia.prevenir = true

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
/*           							REPOSO - PREVIA					  					    */
/* -------------------------------------------------------------------------------------------------*/
qs("#reposos-contenedor .reporte-previa").addEventListener('click', async e => {

	if(window.procesar) {

		var elemento = qs('#reposos-contenedor')

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
				"fecha_naci": historias.sublista.fecha_naci,
				"cabecera": datos[0],
				"representante": datos[2],
				"recomendaciones": datos[3],
				"recomendaciones_tiempo": datos[4],
				"fecha_inicio": datos[5],
				"dias": datos[6].trim(),
				"fecha_final": datos[7],
				"fecha_simple": datos[8].toUpperCase(),
				"reposo": {
					"texto_base": qs(`#${elemento.identificador}-informacion`).texto_base,
					"texto_html": qs(`#${elemento.identificador}-informacion`).texto_html
				}
			}

			if (typeof resultado === 'object' && resultado !== null) {

				var sesion = [ {"sesion": 'datos_pdf', "parametros": JSON.stringify(resultado)} ]

				await tools.fullAsyncQuery('historias', 'modificar_sesion', sesion)

				reposos.cargarTabla(JSON.parse(await tools.fullAsyncQuery(`historias_${elemento.identificador}`, `${elemento.identificador}_consultar`, [historias.sublista.id_historia])), undefined, undefined)

				setTimeout(() => {

					if (elemento.querySelector('.desplegable-contenedor').style.display === 'none') {

						reposoPrevia.prevenir = false
						reposoPrevia.accionar()
						reposoPrevia.prevenir = true

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
/*           							reposo - EDITAR			 							    */
/* -------------------------------------------------------------------------------------------------*/
qs('#crud-repeditar-botones .confirmar').addEventListener('click', async e => {

	if(window.procesar) {

		notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'PROCESANDO')	

		var elemento = qs('#reposos-contenedor')

		window.procesar = false

		var datos = tools.procesar('', '', `repeditar-valores`, tools);

		if (datos !== '') {

			var lista = (typeof datos[1] === 'string') ? JSON.parse(datos[1]) : datos[1];

			reposos.sublista.cabecera = datos[0]
			reposos.sublista.reposo   = JSON.stringify(lista)
			reposos.sublista.representante   = datos[2]
			reposos.sublista.recomendaciones = datos[3]
			reposos.sublista.recomendaciones_tiempo = datos[4]
			reposos.sublista.fecha_inicio    = datos[5]
			reposos.sublista.dias            = datos[6]
			reposos.sublista.fecha_final     = datos[7]
			reposos.sublista.fecha_simple    = datos[8]

			var resultado = await tools.fullAsyncQuery(`historias_${elemento.identificador}`, `${elemento.identificador}_editar`, [JSON.stringify(reposos.crud.lista), historias.sublista.id_historia], [["+", "%2B"]])

			if (resultado.trim() === 'exito') {

				reposos.cargarTabla(reposos.crud.lista)

				notificaciones.mensajeSimple('Petición realiza con éxito', false, 'V')

				window.idSeleccionada = historias.sublista.id_historia

				repoPop.pop()

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
/*           						reposo - ELIMINAR					 					    */
/* -------------------------------------------------------------------------------------------------*/
qs('#reposos-contenedor table').addEventListener('click', async e => {

	if (e.target.classList.contains('eliminar-boton')) {

		if (window.procesar) {

			var elemento = qs('#reposos-contenedor')

			window.procesar = false
			
			notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'PROCESANDO')	

			reposos.crud.lista.forEach((lista, i) => {

				if (lista.id === Number(e.target.value)) {

					reposos.crud.lista.splice(i, 1)

				}

			})

			var resultado = await tools.fullAsyncQuery(`historias_${elemento.identificador}`, `${elemento.identificador}_eliminar`, [JSON.stringify(reposos.crud.lista), historias.sublista.id_historia])

			if (resultado.trim() === 'exito') {

				reposos.cargarTabla(reposos.crud.lista)

				notificaciones.mensajeSimple('Petición realiza con éxito', false, 'V')

			} else {

				notificaciones.mensajeSimple('Error al procesar la petición', resultado, 'F')

			}

			window.procesar = true

		}

	}

})

/* -------------------------------------------------------------------------------------------------*/
/*           						  reposo - TEXTO PREVIA	 								    */
/* -------------------------------------------------------------------------------------------------*/
qs('#reposos-contenedor .cargar').addEventListener('mouseenter', e => {

	qs('#reposos-contenedor .personalizacion').removeAttribute('data-hidden')	

})

qs('#reposos-contenedor .cargar').addEventListener('mouseleave', e => {

	qs('#reposos-contenedor .personalizacion').setAttribute('data-hidden', '')

})

qs('#crud-repeditar-pop .filas').addEventListener('mouseenter', e => {

	qs('#crud-repeditar-personalizacion').removeAttribute('data-hidden')	

})

qs('#crud-repeditar-pop .filas').addEventListener('mouseleave', e => {

	qs('#crud-repeditar-personalizacion').setAttribute('data-hidden', '')

})

/* -------------------------------------------------------------------------------------------------*/
/*           						REPOSO - LIMPIAR					 					    */
/* -------------------------------------------------------------------------------------------------*/
qs('#reposos-contenedor .limpiar').addEventListener('click', e => {

	tools.limpiar('.reposo-valores', '', {
		"procesado": e => {
			gid('reposos-inicio-insertar').value = window.dia
		}
	})

	notificaciones.mensajeSimple('Datos limpiados', false, 'V')

})

/* -------------------------------------------------------------------------------------------------*/
/*           							REPOSO - REUSAR MODELO				 					    */
/* -------------------------------------------------------------------------------------------------*/
qs('#reposos-contenedor .reutilizar').addEventListener('click', e => {

	if (typeof reporteModeloSeleccionado['reporte'] !== 'undefined') {

		if (reporteModeloSeleccionado['reporte'] === 'reposo') {

			tools.limpiar('.reposo-valores', '', {})
			rellenar.contenedores(reporteModeloSeleccionado['datos'], '.reposo-valores', {elemento: e.target, id: 'value'}, {})
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
/*           						REPOSO - SCROLL TOP						 					    */
/* -------------------------------------------------------------------------------------------------*/
qs('#reposo-busqueda').addEventListener('keydown', e => {
	qs('#tabla-reposo').parentElement.scrollTo(0,0)
})

/* -------------------------------------------------------------------------------------------------*/
//operaciones relacionadas al calculo de la fecha de reposo insersion
/*--------------------------------------------------------------------------------------------------*/
qs('#reposos-dias-insertar').addEventListener('input', e => {

	qs('#reposos-fin-insertar').value = tools.calcularFecha(Number(e.target.value), 'dia', qs('#reposos-inicio-insertar').value)
	
	var now = new Date(qs('#reposos-inicio-insertar').value)
		now.setDate(now.getDate() + Number(e.target.value) - 1)

	qs('#reposos-fecha-insertar').value = now.toLocaleDateString('es-CA',{timeZone: "America/Caracas", weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }).toUpperCase()

})

qs('#reposos-inicio-insertar').addEventListener('change', e => {

	var reposo

	if(qs('#reposos-dias-insertar').value.trim() !== '') {
		reposo = Number(qs('#reposos-dias-insertar').value) - 1
	} else {
		reposo = 0
	}

	qs('#reposos-fin-insertar').value = tools.calcularFecha(reposo, 'dia', qs('#reposos-inicio-insertar').value)
	
	var now = new Date(qs('#reposos-inicio-insertar').value)
		now.setDate(now.getDate() + reposo)

	qs('#reposos-fecha-insertar').value = now.toLocaleDateString('es-CA',{timeZone: "America/Caracas", weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }).toUpperCase()
})

/* -------------------------------------------------------------------------------------------------*/
//operaciones relacionadas al calculo de la fecha de reposo edicion
/*--------------------------------------------------------------------------------------------------*/
qs('#reposos-dias-editar').addEventListener('input', e => {

	qs('#reposos-fin-editar').value = tools.calcularFecha(Number(e.target.value), 'dia', qs('#reposos-inicio-editar').value)
	
	var now = new Date(qs('#reposos-inicio-editar').value)
		now.setDate(now.getDate() + Number(e.target.value) - 1)

	qs('#reposos-fecha-editar').value = now.toLocaleDateString('es-CA',{timeZone: "America/Caracas", weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }).toUpperCase()

})

qs('#reposos-inicio-editar').addEventListener('change', e => {

	var reposo

	if(qs('#reposos-dias-editar').value.trim() !== '') {
		reposo = Number(qs('#reposos-dias-editar').value) - 1
	} else {
		reposo = 0
	}

	qs('#reposos-fin-editar').value = tools.calcularFecha(reposo, 'dia', qs('#reposos-inicio-editar').value)
	
	var now = new Date(qs('#reposos-inicio-editar').value)
		now.setDate(now.getDate() + reposo)

	qs('#reposos-fecha-editar').value = now.toLocaleDateString('es-CA',{timeZone: "America/Caracas", weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }).toUpperCase()
})

/* -------------------------------------------------------------------------------------------------*/
//operaciones relacionadas al calculo de la fecha de reposo notificaciones
/*--------------------------------------------------------------------------------------------------*/
qs('#reposos-dias-notificaciones').addEventListener('input', e => {

	qs('#reposos-fin-notificaciones').value = tools.calcularFecha(Number(e.target.value), 'dia', qs('#reposos-inicio-notificaciones').value)
	
	var now = new Date(qs('#reposos-inicio-notificaciones').value)
		now.setDate(now.getDate() + Number(e.target.value) - 1)

	qs('#reposos-fecha-notificaciones').value = now.toLocaleDateString('es-CA',{timeZone: "America/Caracas", weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }).toUpperCase()

})

qs('#reposos-inicio-notificaciones').addEventListener('change', e => {

	var reposo

	if(qs('#reposos-dias-notificaciones').value.trim() !== '') {
		reposo = Number(qs('#reposos-dias-notificaciones').value) - 1
	} else {
		reposo = 0
	}

	qs('#reposos-fin-notificaciones').value = tools.calcularFecha(reposo, 'dia', qs('#reposos-inicio-notificaciones').value)
	
	var now = new Date(qs('#reposos-inicio-notificaciones').value)
		now.setDate(now.getDate() + reposo)

	qs('#reposos-fecha-notificaciones').value = now.toLocaleDateString('es-CA',{timeZone: "America/Caracas", weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }).toUpperCase()
})

/* -------------------------------------------------------------------------------------------------*/
/*           						REPOSO - ES MENOR DE EDAD					 				    */
/* -------------------------------------------------------------------------------------------------*/
qs('#reposo-menor').addEventListener('click', e => {

	reposos.validarRepresentante()

})