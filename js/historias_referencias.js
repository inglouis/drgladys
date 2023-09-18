import { customDesplegable } from '../js/main.js';
import { historias, tools, notificaciones, reporteSeleccionado } from '../js/historias.js';
import { referencias } from '../js/historias.js';

/* 1)------------------------------------------------------------------------------------------------*/
/* ---------------------------------------- referenciaS ---------------------------------------------*/
/*---------------------------------------------------------------------------------------------------*/

export const referenciaPrevia = new customDesplegable('#referencias-contenedor .desplegable-contenedor', '#referencias-contenedor .reporte-previa', '#referencias-contenedor .desplegable-cerrar', undefined, 'fit-content')

referenciaPrevia.eventos()
referenciaPrevia.prevenir = true

/* -------------------------------------------------------------------------------------------------*/
/*           						referencia - PROPIEDADES				 					    */
/* -------------------------------------------------------------------------------------------------*/
referencias['crud'].generarColumnas(['gSpan', null, null], [false],['HTML'], 'referencias-contenedor', 0)
referencias['crud'].generarColumnas(['gSpan', null, null], [false],['HTML'], 'fecha-contenedor', 0)
/////////////////////////////////////////////////////
///
referencias['crud']['propiedadesTr'] = {
	"contenedor": (e) => {

		var fr = new DocumentFragment(),
			th = referencias, 
			contenedor = e.querySelector('.referencias-contenedor'), 
			contenido = th.contenido.cloneNode(true)

		contenedor.innerHTML = ''
		contenedor.appendChild(contenido)
		contenedor.setAttribute('id', `id-${e.sublista.id}-${reporteSeleccionado}`)
		
		contenedor.querySelector('.crud-datos-contenedor').setAttribute('id', `a-id-${e.sublista.id}-${reporteSeleccionado}`)

		var texto = JSON.parse(e.sublista.referencia).texto_html

		contenedor.querySelector('.referencia').innerHTML = texto.toUpperCase()

		contenedor.querySelector('.nombre').insertAdjacentHTML('afterbegin', `<b>- Nombre:</b> ${e.sublista.nombre_completo}`)
		contenedor.querySelector('.cedula').insertAdjacentHTML('afterbegin', `<b>- Cédula/pasaporte:</b> ${e.sublista.cedula}`)
		
		setTimeout(() => {

			window.animaciones.generar(`#id-${e.sublista.id}-${reporteSeleccionado} .crud-datos`, [`#a-id-${e.sublista.id}-${reporteSeleccionado}`])

		}, 0)

	},
	"fecha": (e) => {

		var th = referencias, 
			contenedor = e.querySelector('.fecha-contenedor'), 
			contenido = th.contenidoFecha.cloneNode(true)

		contenedor.innerHTML = ''
		contenedor.appendChild(contenido)

		contenedor.querySelector('.fecha-template').value = e.sublista.fecha
		contenedor.querySelector('.hora-template').value  = e.sublista.hora

	},
	"eliminar": (e) => {
		var th = referencias,
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
referencias['crud']['customBodyEvents'] = {
	/* -------------------------------------------------------------------------------------------------*/
	/*           								REUTILIZAR 											    */
	/* -------------------------------------------------------------------------------------------------*/
	"reusar": async (e) => {

		if (e.target.classList.contains('reusar')) {

			referencias.sublista = tools.pariente(e.target, 'TR').sublista

			tools.limpiar('.referencia-valores', '', {})
			rellenar.contenedores(referencias.sublista, '.referencia-valores', {elemento: e.target, id: 'value'}, {})

			notificaciones.mensajeSimple('Datos cargados', false, 'V')

		}

	},
	/* -------------------------------------------------------------------------------------------------*/
	/*           					ENVIAR LOS DATOS PARA EDITAR LA referencia   					    */
	/* -------------------------------------------------------------------------------------------------*/
	"editar": async (e) => {

		if (e.target.classList.contains('editar')) {

			referencias.sublista = tools.pariente(e.target, 'TR').sublista

			tools.limpiar('.refeditar-valores', '', {})	

			rellenar.contenedores(referencias.sublista, '.refeditar-valores', {elemento: e.target, id: 'value'}, {})

			presPop.pop()

		}

	},
	/* -------------------------------------------------------------------------------------------------*/
	/*           				ENVIAR LOS DATOS PARA REIMPRIMIR EL ANTECENDENTE   					    */
	/* -------------------------------------------------------------------------------------------------*/
	"reimprimir": async (e) => {

		if (e.target.classList.contains('reimprimir')) {

			referencias.sublista = tools.pariente(e.target, 'TR').sublista

			var sesion = [
					{"sesion": 'datos_pdf', "parametros": JSON.stringify(referencias.sublista)}
				]

			await tools.fullAsyncQuery('historias', 'modificar_sesion', sesion)

			qs('#crud-previas-popup iframe').src = ''

			prePop.pop()

			window.reportes.previa(qs('#crud-previas-popup iframe'), `../plantillas/${reporteSeleccionado}pdf.php?&pdf=2`)

		}

	}
};


(async () => {

	referencias.cargarTabla([], undefined, undefined)

})()

/* -------------------------------------------------------------------------------------------------*/
/*           							referenciaS - NOTIFICAR								    */
/* -------------------------------------------------------------------------------------------------*/
qs('#referencias-contenedor').identificador = 'referencia'

qs("#referencias-contenedor .reporte-notificar").addEventListener('click', async e => {

	if (window.procesar) {

		var elemento = qs('#referencias-contenedor')

		window.procesar = false

		var datos = tools.procesar('', '', `${elemento.identificador}-valores`, tools);

		if (datos !== '') {
		
			notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'PROCESANDO')
			
			var lista = {
				"id_historia": historias.sublista.id_historia,
				"referencia": {
					"texto_base": qs(`#${elemento.identificador}-informacion`).texto_base,
					"texto_html": qs(`#${elemento.identificador}-informacion`).texto_html
				},
				"nombre_completo": datos[0], 
				"cedula": datos[1], 
			}

			var resultado = JSON.parse(await tools.fullAsyncQuery(`historias_notificaciones`, `notificar`, [lista, elemento.identificador], [["+", "%2B"]]))

			if (typeof resultado === 'object' && resultado !== null) {

				tools.limpiar(`.${elemento.identificador}-valores`, '', {})
				
				rellenar.contenedores(historias.sublista, '.referencia-representante-valores', {}, {})

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
/*           							referencia - CARGAR	  								    */
/* -------------------------------------------------------------------------------------------------*/

qs("#referencias-contenedor .reporte-cargar").addEventListener('click', async e => {

	if(window.procesar) {

		var elemento = qs('#referencias-contenedor')

		window.procesar = false

		notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'PROCESANDO')

		var datos = tools.procesar('', '', `${elemento.identificador}-valores`, tools);

		if (datos !== '') {
			
			var lista = { 
				"nombre_completo": datos[0], 
				"cedula": datos[1], 
				"referencia": {
					"texto_base": qs(`#${elemento.identificador}-informacion`).texto_base,
					"texto_html": qs(`#${elemento.identificador}-informacion`).texto_html
				}
			}

			var resultado = JSON.parse(await tools.fullAsyncQuery(`historias_${elemento.identificador}`, `${elemento.identificador}_insertar`, [lista, historias.sublista.id_historia], [["+", "%2B"]]))

			if (typeof resultado === 'object' && resultado !== null) {

				tools.limpiar(`.${elemento.identificador}-valores`, '', {})

				rellenar.contenedores(historias.sublista, '.referencia-representante-valores', {}, {})

				var sesion = [{"sesion": 'datos_pdf', "parametros": JSON.stringify(resultado)}]

				await tools.fullAsyncQuery('historias', 'modificar_sesion', sesion)

				referencias.cargarTabla(JSON.parse(await tools.fullAsyncQuery(`historias_${elemento.identificador}`, `${elemento.identificador}_consultar`, [historias.sublista.id_historia])), undefined, undefined)

				setTimeout(() => {

					if (elemento.querySelector('.desplegable-contenedor').style.display !== 'none') {

						referenciaPrevia.prevenir = false
						referenciaPrevia.accionar()
						referenciaPrevia.prevenir = true

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
/*           							referencia - PREVIA				  					    */
/* -------------------------------------------------------------------------------------------------*/
qs("#referencias-contenedor .reporte-previa").addEventListener('click', async e => {

	if(window.procesar) {

		var elemento = qs('#referencias-contenedor')

		window.procesar = false

		var datos = tools.procesar('', '', `${elemento.identificador}-valores`, tools);

		elemento.querySelector('.desplegable-iframe').src = ''

		if (datos !== '') {

			notificaciones.mensajePersonalizado('Cargando reporte...', false, 'CLARO-1', 'PROCESANDO')

			var resultado = {
				"id_historia": historias.sublista.id_historia, 
				"nombre_completo": datos[0], 
				"cedula": datos[1], 
				"referencia": {
					"texto_base": qs(`#${elemento.identificador}-informacion`).texto_base,
					"texto_html": qs(`#${elemento.identificador}-informacion`).texto_html
				}
			}

			if (typeof resultado === 'object' && resultado !== null) {

				var sesion = [ {"sesion": 'datos_pdf', "parametros": JSON.stringify(resultado)} ]

				await tools.fullAsyncQuery('historias', 'modificar_sesion', sesion)

				referencias.cargarTabla(JSON.parse(await tools.fullAsyncQuery(`historias_${elemento.identificador}`, `${elemento.identificador}_consultar`, [historias.sublista.id_historia])), undefined, undefined)

				setTimeout(() => {

					if (elemento.querySelector('.desplegable-contenedor').style.display === 'none') {

						referenciaPrevia.prevenir = false
						referenciaPrevia.accionar()
						referenciaPrevia.prevenir = true

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
/*           							referencia - EDITAR			 							    */
/* -------------------------------------------------------------------------------------------------*/
qs('#crud-refeditar-botones .confirmar').addEventListener('click', async e => {

	if(window.procesar) {

		notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'PROCESANDO')	

		var elemento = qs('#referencias-contenedor')

		window.procesar = false

		var datos = tools.procesar('', '', `refeditar-valores`, tools);

		if (datos !== '') {

			var lista = (typeof datos[2] === 'string') ? JSON.parse(datos[2]) : datos[2];

			referencias.sublista.referencia = JSON.stringify(lista)

			var resultado = await tools.fullAsyncQuery(`historias_${elemento.identificador}`, `${elemento.identificador}_editar`, [JSON.stringify(referencias.crud.lista), historias.sublista.id_historia], [["+", "%2B"]])

			if (resultado.trim() === 'exito') {

				referencias.cargarTabla(referencias.crud.lista)

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
/*           						referencia - ELIMINAR					 					    */
/* -------------------------------------------------------------------------------------------------*/
qs('#referencias-contenedor table').addEventListener('click', async e => {

	if (e.target.classList.contains('eliminar-boton')) {

		if (window.procesar) {

			var elemento = qs('#referencias-contenedor')

			window.procesar = false
			
			notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'PROCESANDO')	

			referencias.crud.lista.forEach((lista, i) => {

				if (lista.id === Number(e.target.value)) {

					referencias.crud.lista.splice(i, 1)

				}

			})

			var resultado = await tools.fullAsyncQuery(`historias_${elemento.identificador}`, `${elemento.identificador}_eliminar`, [JSON.stringify(referencias.crud.lista), historias.sublista.id_historia])

			if (resultado.trim() === 'exito') {

				referencias.cargarTabla(referencias.crud.lista)

				notificaciones.mensajeSimple('Petición realiza con éxito', false, 'V')

			} else {

				notificaciones.mensajeSimple('Error al procesar la petición', resultado, 'F')

			}

			window.procesar = true

		}

	}

})

/* -------------------------------------------------------------------------------------------------*/
/*           						  referencia - TEXTO PREVIA	 								    */
/* -------------------------------------------------------------------------------------------------*/
qs('#referencias-contenedor .cargar').addEventListener('mouseenter', e => {

	qs('#referencias-contenedor .personalizacion').removeAttribute('data-hidden')	

})

qs('#referencias-contenedor .cargar').addEventListener('mouseleave', e => {

	qs('#referencias-contenedor .personalizacion').setAttribute('data-hidden', '')

})

qs('#crud-refeditar-pop .filas').addEventListener('mouseenter', e => {

	qs('#crud-refeditar-personalizacion').removeAttribute('data-hidden')	

})

qs('#crud-refeditar-pop .filas').addEventListener('mouseleave', e => {

	qs('#crud-refeditar-personalizacion').setAttribute('data-hidden', '')

})

/* -------------------------------------------------------------------------------------------------*/
/*           						referencia - LIMPIAR					 					    */
/* -------------------------------------------------------------------------------------------------*/
qs('#referencias-contenedor .limpiar').addEventListener('click', e => {

	tools.limpiar('.referencia-valores', '', {})

	notificaciones.mensajeSimple('Datos limpiados', false, 'V')

})

/* -------------------------------------------------------------------------------------------------*/
/*           						referencia - SCROLL TOP				 					    */
/* -------------------------------------------------------------------------------------------------*/
qs('#referencia-busqueda').addEventListener('keydown', e => {
	qs('#tabla-referencia').parentElement.scrollTo(0,0)
})

/* -------------------------------------------------------------------------------------------------*/
/*           						INFORME - MODELO					 					    	*/
/* -------------------------------------------------------------------------------------------------*/
var modelos = {
	"preoperatorio": "REALIZAR VALORACIÓN PEDIÁTRICA PREOPERATORIA",
	"rx": "REALIZAR RX DE TORAX, PREOPERATORIO",
	"cardiovascular": "REALIZAR VALORACIÓN CARDIOVASCULAR PREOPERATORIA", 
	"pediatrica": "REALIZAR VALORACIÓN PEDIÁTRICA PREOPERATORIA", 
	"estrabismo": "CURA QUIRÚRGICA DE ESTRABISMO CON ANESTESIA"
}

qs('#referencias-modelos').addEventListener('click', e => {

    if (e.target.tagName === 'BUTTON') {

    	var conector = (qs('#referencia-agradecimiento').value === '') ? '' : ' - '

    	var modelo_final = {
    		"agradecimiento": JSON.stringify({
    			"texto_base": `${qs('#referencia-agradecimiento').value}${conector}${modelos[e.target.dataset.identificador]}`,
    			"texto_html": `${qs('#referencia-agradecimiento').value}${conector}${modelos[e.target.dataset.identificador]}`
    		})
    	}

    	console.log(modelo_final)

        rellenar.contenedores(modelo_final, '.referencia-agradecimiento', {}, {})
        
        notificaciones.mensajeSimple('Datos cargados', false, 'V')

    }
    
})