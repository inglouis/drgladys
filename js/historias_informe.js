import { customDesplegable, Rellenar } from '../js/main.js';
import { historias, tools, notificaciones, reporteSeleccionado } from '../js/historias.js';
import { informes } from '../js/historias.js';

/* 1)------------------------------------------------------------------------------------------------*/
/* ---------------------------------------- informeS ---------------------------------------------*/
/*---------------------------------------------------------------------------------------------------*/

export const informePrevia = new customDesplegable('#informes-contenedor .desplegable-contenedor', '#informes-contenedor .reporte-previa', '#informes-contenedor .desplegable-cerrar', undefined, 'fit-content')

informePrevia.eventos()
informePrevia.prevenir = true

/* -------------------------------------------------------------------------------------------------*/
/*           						informe - PROPIEDADES				 					    */
/* -------------------------------------------------------------------------------------------------*/
informes['crud'].generarColumnas(['gSpan', null, null], [false],['HTML'], 'informes-contenedor', 0)
informes['crud'].generarColumnas(['gSpan', null, null], [false],['HTML'], 'fecha-contenedor', 0)
/////////////////////////////////////////////////////
///
informes['crud']['propiedadesTr'] = {
	"contenedor": (e) => {

		var fr = new DocumentFragment(),
			th = informes, 
			contenedor = e.querySelector('.informes-contenedor'), 
			contenido = th.contenido.cloneNode(true)

		contenedor.innerHTML = ''
		contenedor.appendChild(contenido)
		contenedor.setAttribute('id', `id-${e.sublista.id}-${reporteSeleccionado}`)
		
		contenedor.querySelector('.crud-datos-contenedor').setAttribute('id', `a-id-${e.sublista.id}-${reporteSeleccionado}`)

		var texto = JSON.parse(e.sublista.informe).texto_html

		contenedor.querySelector('.informe').innerHTML = texto.toUpperCase()

		contenedor.querySelector('.nombre').insertAdjacentHTML('afterbegin', `<b>- Nombre:</b> ${e.sublista.nombres}`)
		contenedor.querySelector('.apellido').insertAdjacentHTML('afterbegin', `<b>- Apellido:</b> ${e.sublista.apellidos}`)
		contenedor.querySelector('.cedula').insertAdjacentHTML('afterbegin', `<b>- Cédula/pasaporte:</b> ${e.sublista.cedula}`)
		contenedor.querySelector('.edad').insertAdjacentHTML('afterbegin', `<b>- Edad:</b> ${tools.calcularFecha(new Date(e.sublista.fecha_nacimiento))}`)
		
		setTimeout(() => {

			window.animaciones.generar(`#id-${e.sublista.id}-${reporteSeleccionado} .crud-datos`, [`#a-id-${e.sublista.id}-${reporteSeleccionado}`])

		}, 0)

	},
	"fecha": (e) => {

		var th = informes, 
			contenedor = e.querySelector('.fecha-contenedor'), 
			contenido = th.contenidoFecha.cloneNode(true)

		contenedor.innerHTML = ''
		contenedor.appendChild(contenido)

		contenedor.querySelector('.fecha-template').value = e.sublista.fecha
		contenedor.querySelector('.hora-template').value  = e.sublista.hora

	},
	"eliminar": (e) => {
		var th = informes,
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
informes['crud']['customBodyEvents'] = {
	/* -------------------------------------------------------------------------------------------------*/
	/*           								REUTILIZAR 											    */
	/* -------------------------------------------------------------------------------------------------*/
	"reusar": async (e) => {

		if (e.target.classList.contains('reusar')) {

			informes.sublista = tools.pariente(e.target, 'TR').sublista

			tools.limpiar('.informe-valores', '', {})
			rellenar.contenedores(informes.sublista, '.informe-valores', {elemento: e.target, id: 'value'}, {})

			notificaciones.mensajeSimple('Datos cargados', false, 'V')

		}

	},
	/* -------------------------------------------------------------------------------------------------*/
	/*           					ENVIAR LOS DATOS PARA EDITAR LA informe   					    */
	/* -------------------------------------------------------------------------------------------------*/
	"editar": async (e) => {

		if (e.target.classList.contains('editar')) {

			informes.sublista = tools.pariente(e.target, 'TR').sublista

			tools.limpiar('.infeditar-valores', '', {})	

			rellenar.contenedores(informes.sublista, '.infeditar-valores', {elemento: e.target, id: 'value'}, {})

			forPop.pop()

		}

	},
	/* -------------------------------------------------------------------------------------------------*/
	/*           				ENVIAR LOS DATOS PARA REIMPRIMIR EL ANTECENDENTE   					    */
	/* -------------------------------------------------------------------------------------------------*/
	"reimprimir": async (e) => {

		if (e.target.classList.contains('reimprimir')) {

			informes.sublista = tools.pariente(e.target, 'TR').sublista

			var sesion = [
					{"sesion": 'datos_pdf', "parametros": JSON.stringify(informes.sublista)}
				]

			await tools.fullAsyncQuery('historias', 'modificar_sesion', sesion)

			qs('#crud-previas-popup iframe').src = ''

			prePop.pop()

			window.reportes.previa(qs('#crud-previas-popup iframe'), `../plantillas/${reporteSeleccionado}pdf.php?&pdf=2`)

		}

	}
};


(async () => {

	informes.cargarTabla([], undefined, undefined)

})()

/* -------------------------------------------------------------------------------------------------*/
/*           							informeS - CARGAR	  								    */
/* -------------------------------------------------------------------------------------------------*/
qs('#informes-contenedor').identificador = 'informe'

qs("#informes-contenedor .reporte-cargar").addEventListener('click', async e => {

	if(window.procesar) {

		var elemento = qs('#informes-contenedor')

		window.procesar = false

		notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'PROCESANDO')

		var datos = tools.procesar('', '', `${elemento.identificador}-valores`, tools);

		if (datos !== '') {
			
			var lista = { 
				"nombres": historias.sublista.nombres, 
				"apellidos": historias.sublista.apellidos, 
				"cedula": historias.sublista.cedula, 
				"fecha_nacimiento": historias.sublista.fecha_naci,
				"informe": {
					"texto_base": qs(`#${elemento.identificador}-informacion`).texto_base,
					"texto_html": qs(`#${elemento.identificador}-informacion`).texto_html
				}
			}

			var resultado = JSON.parse(await tools.fullAsyncQuery(`historias_${elemento.identificador}`, `${elemento.identificador}_insertar`, [lista, historias.sublista.id_historia], [["+", "%2B"]]))

			if (typeof resultado === 'object' && resultado !== null) {

				tools.limpiar(`.${elemento.identificador}-valores`, '', {})

				var sesion = [{"sesion": 'datos_pdf', "parametros": JSON.stringify(resultado)}]

				await tools.fullAsyncQuery('historias', 'modificar_sesion', sesion)

				informes.cargarTabla(JSON.parse(await tools.fullAsyncQuery(`historias_${elemento.identificador}`, `${elemento.identificador}_consultar`, [historias.sublista.id_historia])), undefined, undefined)

				setTimeout(() => {

					if (elemento.querySelector('.desplegable-contenedor').style.display !== 'none') {

						informePrevia.prevenir = false
						informePrevia.accionar()
						informePrevia.prevenir = true

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
/*           							informe - PREVIA					  					    */
/* -------------------------------------------------------------------------------------------------*/
qs("#informes-contenedor .reporte-previa").addEventListener('click', async e => {

	if(window.procesar) {

		var elemento = qs('#informes-contenedor')

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
				"informe": {
					"texto_base": qs(`#${elemento.identificador}-informacion`).texto_base,
					"texto_html": qs(`#${elemento.identificador}-informacion`).texto_html
				}
			}

			if (typeof resultado === 'object' && resultado !== null) {

				var sesion = [ {"sesion": 'datos_pdf', "parametros": JSON.stringify(resultado)} ]

				await tools.fullAsyncQuery('historias', 'modificar_sesion', sesion)

				informes.cargarTabla(JSON.parse(await tools.fullAsyncQuery(`historias_${elemento.identificador}`, `${elemento.identificador}_consultar`, [historias.sublista.id_historia])), undefined, undefined)

				setTimeout(() => {

					if (elemento.querySelector('.desplegable-contenedor').style.display === 'none') {

						informePrevia.prevenir = false
						informePrevia.accionar()
						informePrevia.prevenir = true

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
/*           							informe - EDITAR			 							    */
/* -------------------------------------------------------------------------------------------------*/
qs('#crud-infeditar-botones .confirmar').addEventListener('click', async e => {

	if(window.procesar) {

		notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'PROCESANDO')	

		var elemento = qs('#informes-contenedor')

		window.procesar = false

		var datos = tools.procesar('', '', `infeditar-valores`, tools);

		if (datos !== '') {

			var lista = (typeof datos[0] === 'string') ? JSON.parse(datos[0]) : datos[0];

			informes.sublista.informe = JSON.stringify(lista)

			var resultado = await tools.fullAsyncQuery(`historias_${elemento.identificador}`, `${elemento.identificador}_editar`, [JSON.stringify(informes.crud.lista), historias.sublista.id_historia], [["+", "%2B"]])

			if (resultado.trim() === 'exito') {

				informes.cargarTabla(informes.crud.lista)

				notificaciones.mensajeSimple('Petición realiza con éxito', false, 'V')

				window.idSeleccionada = historias.sublista.id_historia

				forPop.pop()

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
/*           						informe - ELIMINAR					 					    */
/* -------------------------------------------------------------------------------------------------*/
qs('#informes-contenedor table').addEventListener('click', async e => {

	if (e.target.classList.contains('eliminar-boton')) {

		if (window.procesar) {

			var elemento = qs('#informes-contenedor')

			window.procesar = false
			
			notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'PROCESANDO')	

			informes.crud.lista.forEach((lista, i) => {

				if (lista.id === Number(e.target.value)) {

					informes.crud.lista.splice(i, 1)

				}

			})

			var resultado = await tools.fullAsyncQuery(`historias_${elemento.identificador}`, `${elemento.identificador}_eliminar`, [JSON.stringify(informes.crud.lista), historias.sublista.id_historia])

			if (resultado.trim() === 'exito') {

				informes.cargarTabla(informes.crud.lista)

				notificaciones.mensajeSimple('Petición realiza con éxito', false, 'V')

			} else {

				notificaciones.mensajeSimple('Error al procesar la petición', resultado, 'F')

			}

			window.procesar = true

		}

	}

})

/* -------------------------------------------------------------------------------------------------*/
/*           						  INFORME - TEXTO PREVIA	 								    */
/* -------------------------------------------------------------------------------------------------*/
qs('#informes-contenedor .cargar').addEventListener('mouseenter', e => {

	qs('#informes-contenedor .personalizacion').removeAttribute('data-hidden')	

})

qs('#informes-contenedor .cargar').addEventListener('mouseleave', e => {

	qs('#informes-contenedor .personalizacion').setAttribute('data-hidden', '')

})

qs('#crud-infeditar-pop .filas').addEventListener('mouseenter', e => {

	qs('#crud-infeditar-personalizacion').removeAttribute('data-hidden')	

})

qs('#crud-infeditar-pop .filas').addEventListener('mouseleave', e => {

	qs('#crud-infeditar-personalizacion').setAttribute('data-hidden', '')

})

/* -------------------------------------------------------------------------------------------------*/
/*           						INFORME - LIMPIAR					 						    */
/* -------------------------------------------------------------------------------------------------*/
qs('#informes-contenedor .limpiar').addEventListener('click', e => {

	tools.limpiar('.informe-valores', '', {})

	notificaciones.mensajeSimple('Datos limpiados', false, 'V')

})

/* -------------------------------------------------------------------------------------------------*/
/*           						INFORME - SCROLL TOP					 					    */
/* -------------------------------------------------------------------------------------------------*/
qs('#informe-busqueda').addEventListener('keydown', e => {
	qs('#tabla-informe').parentElement.scrollTo(0,0)
})

/* -------------------------------------------------------------------------------------------------*/
/*           						INFORME - MODELO					 					    	*/
/* -------------------------------------------------------------------------------------------------*/
var modelos = {
	"preoperatorio": {"informe": JSON.stringify({
		"texto_base": "FAVOR REALIZAR VALORACIÓN PEDIÁTRICA PREOPERATORIA, CURA QUIRÚRGICA DE ESTRABISMO CON ANESTESIA GENERAL.", 
		"texto_html": "FAVOR REALIZAR VALORACIÓN PEDIÁTRICA PREOPERATORIA, CURA QUIRÚRGICA DE ESTRABISMO CON ANESTESIA GENERAL."
	})},
	"rx": {"informe": JSON.stringify({
		"texto_base": "FAVOR REALIZAR R(X) DE TORAX, PREOPERATORIO, CURA QUIRÚRGICA DE ESTRABISMO CON ANESTESIA.", 
		"texto_html": "FAVOR REALIZAR R(X) DE TORAX, PREOPERATORIO, CURA QUIRÚRGICA DE ESTRABISMO CON ANESTESIA."
	})},
	"cardiovascular": {"informe": JSON.stringify({
		"texto_base": "FAVOR REALIZAR VALORACIÓN CARDIOVASCULAR PREOPERATORIA, CURA QUIRÚRGICA DE ESTRABISMO CON ANESTESIA GENERAL.", 
		"texto_html": "FAVOR REALIZAR VALORACIÓN CARDIOVASCULAR PREOPERATORIA, CURA QUIRÚRGICA DE ESTRABISMO CON ANESTESIA GENERAL."
	})}
}

qs('#informe-modelos').addEventListener('click', e=> {

    if (e.target.tagName === 'BUTTON') {

        rellenar.contenedores(modelos[e.target.dataset.identificador], '.informe-valores', {}, {})
        
        notificaciones.mensajeSimple('Datos cargados', false, 'V')

    }
    
})