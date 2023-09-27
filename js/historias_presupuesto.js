import { customDesplegable } from '../js/main.js';
import { historias, tools, notificaciones, reporteSeleccionado } from '../js/historias.js';
import { presupuestos } from '../js/historias.js';

/* 1)------------------------------------------------------------------------------------------------*/
/* ---------------------------------------- presupuestoS ---------------------------------------------*/
/*---------------------------------------------------------------------------------------------------*/

export const presupuestoPrevia = new customDesplegable('#presupuestos-contenedor .desplegable-contenedor', '#presupuestos-contenedor .reporte-previa', '#presupuestos-contenedor .desplegable-cerrar', undefined, 'fit-content')

presupuestoPrevia.eventos()
presupuestoPrevia.prevenir = true

/* -------------------------------------------------------------------------------------------------*/
/*           						presupuesto - PROPIEDADES				 					    */
/* -------------------------------------------------------------------------------------------------*/
presupuestos['crud'].generarColumnas(['gSpan', null, null], [false],['HTML'], 'presupuestos-contenedor', 0)
presupuestos['crud'].generarColumnas(['gSpan', null, null], [false],['HTML'], 'fecha-contenedor', 0)
/////////////////////////////////////////////////////
///
presupuestos['crud']['propiedadesTr'] = {
	"contenedor": (e) => {

		var fr = new DocumentFragment(),
			th = presupuestos, 
			contenedor = e.querySelector('.presupuestos-contenedor'), 
			contenido = th.contenido.cloneNode(true)

		contenedor.innerHTML = ''
		contenedor.appendChild(contenido)
		contenedor.setAttribute('id', `id-${e.sublista.id}-${reporteSeleccionado}`)
		
		contenedor.querySelector('.crud-datos-contenedor').setAttribute('id', `a-id-${e.sublista.id}-${reporteSeleccionado}`)

		var texto = JSON.parse(e.sublista.presupuesto).texto_html

		contenedor.querySelector('.presupuesto').innerHTML = texto.toUpperCase()

		contenedor.querySelector('.nombre').insertAdjacentHTML('afterbegin', `<b>- Nombre:</b> ${e.sublista.nombre_completo}`)
		contenedor.querySelector('.cedula').insertAdjacentHTML('afterbegin', `<b>- Cédula/pasaporte:</b> ${e.sublista.cedula}`)
		
		setTimeout(() => {

			window.animaciones.generar(`#id-${e.sublista.id}-${reporteSeleccionado} .crud-datos`, [`#a-id-${e.sublista.id}-${reporteSeleccionado}`])

		}, 0)

	},
	"fecha": (e) => {

		var th = presupuestos, 
			contenedor = e.querySelector('.fecha-contenedor'), 
			contenido = th.contenidoFecha.cloneNode(true)

		contenedor.innerHTML = ''
		contenedor.appendChild(contenido)

		contenedor.querySelector('.fecha-template').value = e.sublista.fecha
		contenedor.querySelector('.hora-template').value  = e.sublista.hora

	},
	"eliminar": (e) => {
		var th = presupuestos,
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
presupuestos['crud']['customBodyEvents'] = {
	/* -------------------------------------------------------------------------------------------------*/
	/*           								REUTILIZAR 											    */
	/* -------------------------------------------------------------------------------------------------*/
	"reusar": async (e) => {

		if (e.target.classList.contains('reusar')) {

			presupuestos.sublista = tools.pariente(e.target, 'TR').sublista

			tools.limpiar('.presupuesto-valores', '', {})
			rellenar.contenedores(presupuestos.sublista, '.presupuesto-valores', {elemento: e.target, id: 'value'}, {})

			notificaciones.mensajeSimple('Datos cargados', false, 'V')

		}

	},
	/* -------------------------------------------------------------------------------------------------*/
	/*           					ENVIAR LOS DATOS PARA EDITAR LA presupuesto   					    */
	/* -------------------------------------------------------------------------------------------------*/
	"editar": async (e) => {

		if (e.target.classList.contains('editar')) {

			presupuestos.sublista = tools.pariente(e.target, 'TR').sublista

			tools.limpiar('.preeditar-valores', '', {})	

			rellenar.contenedores(presupuestos.sublista, '.preeditar-valores', {elemento: e.target, id: 'value'}, {})

			presPop.pop()

		}

	},
	/* -------------------------------------------------------------------------------------------------*/
	/*           				ENVIAR LOS DATOS PARA REIMPRIMIR EL ANTECENDENTE   					    */
	/* -------------------------------------------------------------------------------------------------*/
	"reimprimir": async (e) => {

		if (e.target.classList.contains('reimprimir')) {

			presupuestos.sublista = tools.pariente(e.target, 'TR').sublista

			var sesion = [
					{"sesion": 'datos_pdf', "parametros": JSON.stringify(presupuestos.sublista)}
				]

			await tools.fullAsyncQuery('historias', 'modificar_sesion', sesion)

			qs('#crud-previas-popup iframe').src = ''

			prePop.pop()

			window.reportes.previa(qs('#crud-previas-popup iframe'), `../plantillas/${reporteSeleccionado}pdf.php?&pdf=2`)

		}

	}
};


(async () => {

	presupuestos.cargarTabla([], undefined, undefined)

})()

/* -------------------------------------------------------------------------------------------------*/
/*           							PRESUPUESTOS - NOTIFICAR								    */
/* -------------------------------------------------------------------------------------------------*/
qs('#presupuestos-contenedor').identificador = 'presupuesto'

qs("#presupuestos-contenedor .reporte-notificar").addEventListener('click', async e => {

	if (window.procesar) {

		var elemento = qs('#presupuestos-contenedor')

		window.procesar = false

		var datos = tools.procesar('', '', `${elemento.identificador}-valores`, tools);

		if (datos !== '') {
		
			notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'PROCESANDO')
			
			var lista = {
				"id_historia": historias.sublista.id_historia,
				"presupuesto": {
					"texto_base": qs(`#${elemento.identificador}-informacion`).texto_base,
					"texto_html": qs(`#${elemento.identificador}-informacion`).texto_html
				},
				"nombre_completo": datos[0], 
				"cedula": datos[1], 
			}

			var resultado = JSON.parse(await tools.fullAsyncQuery(`historias_notificaciones`, `notificar`, [lista, elemento.identificador], [["+", "%2B"]]))

			if (typeof resultado === 'object' && resultado !== null) {

				tools.limpiar(`.${elemento.identificador}-valores`, '', {})
				
				rellenar.contenedores(historias.sublista, '.presupuesto-representante-valores', {}, {})

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
/*           							PRESUPUESTO - CARGAR	  								    */
/* -------------------------------------------------------------------------------------------------*/

qs("#presupuestos-contenedor .reporte-cargar").addEventListener('click', async e => {

	if(window.procesar) {

		var elemento = qs('#presupuestos-contenedor')

		window.procesar = false

		notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'PROCESANDO')

		var datos = tools.procesar('', '', `${elemento.identificador}-valores`, tools);

		if (datos !== '') {
			
			var lista = { 
				"nombre_completo": datos[0], 
				"cedula": datos[1], 
				"presupuesto": {
					"texto_base": qs(`#${elemento.identificador}-informacion`).texto_base,
					"texto_html": qs(`#${elemento.identificador}-informacion`).texto_html
				}
			}

			var resultado = JSON.parse(await tools.fullAsyncQuery(`historias_${elemento.identificador}`, `${elemento.identificador}_insertar`, [lista, historias.sublista.id_historia], [["+", "%2B"]]))

			if (typeof resultado === 'object' && resultado !== null) {

				tools.limpiar(`.${elemento.identificador}-valores`, '', {})

				rellenar.contenedores(historias.sublista, '.presupuesto-representante-valores', {}, {})

				var sesion = [{"sesion": 'datos_pdf', "parametros": JSON.stringify(resultado)}]

				await tools.fullAsyncQuery('historias', 'modificar_sesion', sesion)

				presupuestos.cargarTabla(JSON.parse(await tools.fullAsyncQuery(`historias_${elemento.identificador}`, `${elemento.identificador}_consultar`, [historias.sublista.id_historia])), undefined, undefined)

				setTimeout(() => {

					if (elemento.querySelector('.desplegable-contenedor').style.display !== 'none') {

						presupuestoPrevia.prevenir = false
						presupuestoPrevia.accionar()
						presupuestoPrevia.prevenir = true

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
/*           							PRESUPUESTO - PREVIA				  					    */
/* -------------------------------------------------------------------------------------------------*/
qs("#presupuestos-contenedor .reporte-previa").addEventListener('click', async e => {

	if(window.procesar) {

		var elemento = qs('#presupuestos-contenedor')

		window.procesar = false

		var datos = tools.procesar('', '', `${elemento.identificador}-valores`, tools);

		elemento.querySelector('.desplegable-iframe').src = ''

		if (datos !== '') {

			notificaciones.mensajePersonalizado('Cargando reporte...', false, 'CLARO-1', 'PROCESANDO')

			var resultado = {
				"id_historia": historias.sublista.id_historia, 
				"nombre_completo": datos[0], 
				"cedula": datos[1], 
				"presupuesto": {
					"texto_base": qs(`#${elemento.identificador}-informacion`).texto_base,
					"texto_html": qs(`#${elemento.identificador}-informacion`).texto_html
				}
			}

			if (typeof resultado === 'object' && resultado !== null) {

				var sesion = [ {"sesion": 'datos_pdf', "parametros": JSON.stringify(resultado)} ]

				await tools.fullAsyncQuery('historias', 'modificar_sesion', sesion)

				presupuestos.cargarTabla(JSON.parse(await tools.fullAsyncQuery(`historias_${elemento.identificador}`, `${elemento.identificador}_consultar`, [historias.sublista.id_historia])), undefined, undefined)

				setTimeout(() => {

					if (elemento.querySelector('.desplegable-contenedor').style.display === 'none') {

						presupuestoPrevia.prevenir = false
						presupuestoPrevia.accionar()
						presupuestoPrevia.prevenir = true

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
/*           							presupuesto - EDITAR			 							    */
/* -------------------------------------------------------------------------------------------------*/
qs('#crud-preeditar-botones .confirmar').addEventListener('click', async e => {

	if(window.procesar) {

		notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'PROCESANDO')	

		var elemento = qs('#presupuestos-contenedor')

		window.procesar = false

		var datos = tools.procesar('', '', `preeditar-valores`, tools);

		if (datos !== '') {

			var lista = (typeof datos[2] === 'string') ? JSON.parse(datos[2]) : datos[2];

			presupuestos.sublista.presupuesto = JSON.stringify(lista)

			var resultado = await tools.fullAsyncQuery(`historias_${elemento.identificador}`, `${elemento.identificador}_editar`, [JSON.stringify(presupuestos.crud.lista), historias.sublista.id_historia], [["+", "%2B"]])

			if (resultado.trim() === 'exito') {

				presupuestos.cargarTabla(presupuestos.crud.lista)

				notificaciones.mensajeSimple('Petición realiza con éxito', false, 'V')

				window.idSeleccionada = historias.sublista.id_historia

				presPop.pop()

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
/*           						presupuesto - ELIMINAR					 					    */
/* -------------------------------------------------------------------------------------------------*/
qs('#presupuestos-contenedor table').addEventListener('click', async e => {

	if (e.target.classList.contains('eliminar-boton')) {

		if (window.procesar) {

			var elemento = qs('#presupuestos-contenedor')

			window.procesar = false
			
			notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'PROCESANDO')	

			presupuestos.crud.lista.forEach((lista, i) => {

				if (lista.id === Number(e.target.value)) {

					presupuestos.crud.lista.splice(i, 1)

				}

			})

			var resultado = await tools.fullAsyncQuery(`historias_${elemento.identificador}`, `${elemento.identificador}_eliminar`, [JSON.stringify(presupuestos.crud.lista), historias.sublista.id_historia])

			if (resultado.trim() === 'exito') {

				presupuestos.cargarTabla(presupuestos.crud.lista)

				notificaciones.mensajeSimple('Petición realiza con éxito', false, 'V')

			} else {

				notificaciones.mensajeSimple('Error al procesar la petición', resultado, 'F')

			}

			window.procesar = true

		}

	}

})

/* -------------------------------------------------------------------------------------------------*/
/*           						  presupuesto - TEXTO PREVIA	 								    */
/* -------------------------------------------------------------------------------------------------*/
qs('#presupuestos-contenedor .cargar').addEventListener('mouseenter', e => {

	qs('#presupuestos-contenedor .personalizacion').removeAttribute('data-hidden')	

})

qs('#presupuestos-contenedor .cargar').addEventListener('mouseleave', e => {

	qs('#presupuestos-contenedor .personalizacion').setAttribute('data-hidden', '')

})

qs('#crud-preeditar-pop .filas').addEventListener('mouseenter', e => {

	qs('#crud-preeditar-personalizacion').removeAttribute('data-hidden')	

})

qs('#crud-preeditar-pop .filas').addEventListener('mouseleave', e => {

	qs('#crud-preeditar-personalizacion').setAttribute('data-hidden', '')

})

/* -------------------------------------------------------------------------------------------------*/
/*           						PRESUPUESTO - LIMPIAR					 					    */
/* -------------------------------------------------------------------------------------------------*/
qs('#presupuestos-contenedor .limpiar').addEventListener('click', e => {

	tools.limpiar('.presupuesto-valores', '', {})

	notificaciones.mensajeSimple('Datos limpiados', false, 'V')

})

/* -------------------------------------------------------------------------------------------------*/
/*           						PRESUPUESTO - SCROLL TOP				 					    */
/* -------------------------------------------------------------------------------------------------*/
qs('#presupuesto-busqueda').addEventListener('keydown', e => {
	qs('#tabla-presupuesto').parentElement.scrollTo(0,0)
})

/* -------------------------------------------------------------------------------------------------*/
/*           						PRESUPUESTO - REPRESENTANTE			 					    	*/
/* -------------------------------------------------------------------------------------------------*/
qs('#presupuesto-representante').addEventListener('click', e=> {

    if (e.target.tagName === 'BUTTON') {

    	var lista = {
    		"paciente": {
    			"nombre_completo": historias.sublista.nombre_completo,
    			"cedula": historias.sublista.cedula
    		},
    		"representante": {
    			"nombre_completo": historias.sublista.emergencia_persona,
    			"cedula": historias.sublista.emergencia_informacion
    		}
    	}

        rellenar.contenedores(lista[e.target.dataset.identificador], '.presupuesto-representante-valores', {}, {})
        
        notificaciones.mensajeSimple('Datos cargados', false, 'V')

    }
    
})