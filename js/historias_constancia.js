import { customDesplegable } from '../js/main.js';
import { historias, tools, notificaciones, reporteSeleccionado } from '../js/historias.js';
import { constancias } from '../js/historias.js';

/* 1)------------------------------------------------------------------------------------------------*/
/* ---------------------------------------- CONSTANCIAS ---------------------------------------------*/
/*---------------------------------------------------------------------------------------------------*/

export const constanciaPrevia = new customDesplegable('#constancias-contenedor .desplegable-contenedor', '#constancias-contenedor .reporte-previa', '#constancias-contenedor .desplegable-cerrar', undefined, 'fit-content')

constanciaPrevia.eventos()
constanciaPrevia.prevenir = true

/* -------------------------------------------------------------------------------------------------*/
/*           						CONSTANCIA - PROPIEDADES				 					    */
/* -------------------------------------------------------------------------------------------------*/
constancias['crud'].generarColumnas(['gSpan', null, null], [false],['HTML'], 'constancias-contenedor', 0)
constancias['crud'].generarColumnas(['gSpan', null, null], [false],['HTML'], 'fecha-contenedor', 0)
/////////////////////////////////////////////////////
///
constancias['crud']['propiedadesTr'] = {
	"contenedor": (e) => {

		var fr = new DocumentFragment(),
			th = constancias, 
			contenedor = e.querySelector('.constancias-contenedor'), 
			contenido = th.contenido.cloneNode(true)

		contenedor.innerHTML = ''
		contenedor.appendChild(contenido)
		contenedor.setAttribute('id', `id-${e.sublista.id}-${reporteSeleccionado}`)
		
		contenedor.querySelector('.crud-datos-contenedor').setAttribute('id', `a-id-${e.sublista.id}-${reporteSeleccionado}`)

		var motivo = JSON.parse(e.sublista.motivo).texto_html,
			recomendaciones = JSON.parse(e.sublista.recomendaciones).texto_html

		contenedor.querySelector('.constancia-motivo').innerHTML = motivo.toUpperCase()
		contenedor.querySelector('.constancia-recomendaciones').innerHTML = recomendaciones.toUpperCase()

		contenedor.querySelector('.constancia-menor').checked = (e.sublista.menor === 'X') ? true : false;
		contenedor.querySelector('.constancia-aula').checked = (e.sublista.aula === 'X') ? true : false;

		contenedor.querySelector('.nombre').insertAdjacentHTML('afterbegin', `<b>- Nombre:</b> ${e.sublista.nombres}`)
		contenedor.querySelector('.apellido').insertAdjacentHTML('afterbegin', `<b>- Apellido:</b> ${e.sublista.apellidos}`)
		contenedor.querySelector('.cedula').insertAdjacentHTML('afterbegin', `<b>- Cédula/pasaporte:</b> ${e.sublista.cedula}`)
		contenedor.querySelector('.edad').insertAdjacentHTML('afterbegin', `<b>- Edad:</b> ${tools.calcularFecha(new Date(e.sublista.fecha_nacimiento))}`)
		
		setTimeout(() => {

			window.animaciones.generar(`#id-${e.sublista.id}-${reporteSeleccionado} .crud-datos`, [`#a-id-${e.sublista.id}-${reporteSeleccionado}`])

		}, 0)

	},
	"fecha": (e) => {

		var th = constancias, 
			contenedor = e.querySelector('.fecha-contenedor'), 
			contenido = th.contenidoFecha.cloneNode(true)

		contenedor.innerHTML = ''
		contenedor.appendChild(contenido)

		contenedor.querySelector('.fecha-template').value = e.sublista.fecha
		contenedor.querySelector('.hora-template').value  = e.sublista.hora

	},
	"eliminar": (e) => {
		var th = constancias,
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
constancias['crud']['customBodyEvents'] = {
	/* -------------------------------------------------------------------------------------------------*/
	/*           								REUTILIZAR 											    */
	/* -------------------------------------------------------------------------------------------------*/
	"reusar": async (e) => {

		if (e.target.classList.contains('reusar')) {

			constancias.sublista = tools.pariente(e.target, 'TR').sublista

			tools.limpiar('.constancia-valores', '', {})
			rellenar.contenedores(constancias.sublista, '.constancia-valores', {elemento: e.target, id: 'value'}, {})

			notificaciones.mensajeSimple('Datos cargados', false, 'V')

			constancias.validarRepresentante()

		}

	},
	/* -------------------------------------------------------------------------------------------------*/
	/*           					ENVIAR LOS DATOS PARA EDITAR LA CONSTANCIA   					    */
	/* -------------------------------------------------------------------------------------------------*/
	"editar": async (e) => {

		if (e.target.classList.contains('editar')) {

			constancias.sublista = tools.pariente(e.target, 'TR').sublista

			tools.limpiar('.coneditar-valores', '', {})	

			rellenar.contenedores(constancias.sublista, '.coneditar-valores', {elemento: e.target, id: 'value'}, {})

			constancias.validarRepresentante()

			conPop.pop()

		}

	},
	/* -------------------------------------------------------------------------------------------------*/
	/*           				ENVIAR LOS DATOS PARA REIMPRIMIR EL ANTECENDENTE   					    */
	/* -------------------------------------------------------------------------------------------------*/
	"reimprimir": async (e) => {

		if (e.target.classList.contains('reimprimir')) {

			constancias.sublista = tools.pariente(e.target, 'TR').sublista

			var lista = tools.copiaLista(constancias.sublista)

			lista['id_historia'] = historias.sublista.id_historia

			var sesion = [
					{"sesion": 'datos_pdf', "parametros": JSON.stringify(lista)}
				]

			await tools.fullAsyncQuery('historias', 'modificar_sesion', sesion)

			qs('#crud-previas-popup iframe').src = ''

			prePop.pop()

			window.reportes.previa(qs('#crud-previas-popup iframe'), `../plantillas/${reporteSeleccionado}pdf.php?&pdf=2`)

		}

	}
};


(async () => {

	constancias.cargarTabla([], undefined, undefined)

})()

/* -------------------------------------------------------------------------------------------------*/
/*           							CONSTANCIAS - NOTIFICAR	  								    */
/* -------------------------------------------------------------------------------------------------*/
qs('#constancias-contenedor').identificador = 'constancia'

qs("#constancias-contenedor .reporte-notificar").addEventListener('click', async e => {

	if (window.procesar) {

		var elemento = qs('#constancias-contenedor')

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
				"menor": datos[2],
				"aula": datos[3],
				"motivo": {
					"texto_base": qs(`#${elemento.identificador}-informacion`).texto_base,
					"texto_html": qs(`#${elemento.identificador}-informacion`).texto_html
				},
				"recomendaciones": {
					"texto_base": qs(`#${elemento.identificador}-recomendaciones`).texto_base,
					"texto_html": qs(`#${elemento.identificador}-recomendaciones`).texto_html
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
/*           							CONSTANCIAS - CARGAR	  								    */
/* -------------------------------------------------------------------------------------------------*/
qs("#constancias-contenedor .reporte-cargar").addEventListener('click', async e => {

	if(window.procesar) {

		var elemento = qs('#constancias-contenedor')

		window.procesar = false

		var datos = tools.procesar('', '', `${elemento.identificador}-valores`, tools);

		if (datos !== '') {
		
			notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'PROCESANDO')
			
			var lista = { 
				"nombres": historias.sublista.nombres, 
				"apellidos": historias.sublista.apellidos, 
				"cedula": historias.sublista.cedula, 
				"fecha_nacimiento": historias.sublista.fecha_naci,
				"menor": datos[2],
				"aula": datos[3],
				"motivo": {
					"texto_base": qs(`#${elemento.identificador}-informacion`).texto_base,
					"texto_html": qs(`#${elemento.identificador}-informacion`).texto_html
				},
				"recomendaciones": {
					"texto_base": qs(`#${elemento.identificador}-recomendaciones`).texto_base,
					"texto_html": qs(`#${elemento.identificador}-recomendaciones`).texto_html
				}
			}

			var resultado = JSON.parse(await tools.fullAsyncQuery(`historias_${elemento.identificador}`, `${elemento.identificador}_insertar`, [lista, historias.sublista.id_historia], [["+", "%2B"]]))

			if (typeof resultado === 'object' && resultado !== null) {

				tools.limpiar(`.${elemento.identificador}-valores`, '', {})

				var sesion = [{"sesion": 'datos_pdf', "parametros": JSON.stringify(resultado)}]

				await tools.fullAsyncQuery('historias', 'modificar_sesion', sesion)

				constancias.cargarTabla(JSON.parse(await tools.fullAsyncQuery(`historias_${elemento.identificador}`, `${elemento.identificador}_consultar`, [historias.sublista.id_historia])), undefined, undefined)

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
				"menor": datos[2],
				"aula": datos[3],
				"motivo": {
					"texto_base": qs(`#${elemento.identificador}-informacion`).texto_base,
					"texto_html": qs(`#${elemento.identificador}-informacion`).texto_html
				},
				"recomendaciones": {
					"texto_base": qs(`#${elemento.identificador}-recomendaciones`).texto_base,
					"texto_html": qs(`#${elemento.identificador}-recomendaciones`).texto_html
				}
			}

			if (typeof resultado === 'object' && resultado !== null) {

				var sesion = [ {"sesion": 'datos_pdf', "parametros": JSON.stringify(resultado)} ]

				await tools.fullAsyncQuery('historias', 'modificar_sesion', sesion)

				constancias.cargarTabla(JSON.parse(await tools.fullAsyncQuery(`historias_${elemento.identificador}`, `${elemento.identificador}_consultar`, [historias.sublista.id_historia])), undefined, undefined)

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

			var motivo = (typeof datos[0] === 'string') ? JSON.parse(datos[0]) : datos[0];
			var recomendaciones = (typeof datos[1] === 'string') ? JSON.parse(datos[1]) : datos[1];

			constancias.sublista.motivo = JSON.stringify(motivo)
			constancias.sublista.recomendaciones = JSON.stringify(recomendaciones)
			constancias.sublista.menor  = datos[2]
			constancias.sublista.aula   = datos[3] 

			var resultado = await tools.fullAsyncQuery(`historias_${elemento.identificador}`, `${elemento.identificador}_editar`, [JSON.stringify(constancias.crud.lista), historias.sublista.id_historia], [["+", "%2B"]])

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

			var resultado = await tools.fullAsyncQuery(`historias_${elemento.identificador}`, `${elemento.identificador}_eliminar`, [JSON.stringify(constancias.crud.lista), historias.sublista.id_historia])

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
/*           						CONSTANCIA - MODELO					 					    	*/
/* -------------------------------------------------------------------------------------------------*/
var modelos = {
	"correctivo": "AMERITA USO CONTÍNUO DE LENTES CORRECTIVOS"
}

qs('#constancia-modelos').addEventListener('click', e => {

    if (e.target.tagName === 'BUTTON') {

    	var conector = (qs('#constancia-recomendaciones').value === '') ? '' : ' - '

    	var modelo_final = {
    		"recomendaciones": JSON.stringify({
    			"texto_base": `${qs('#referencia-agradecimiento').value}${conector}${modelos[e.target.dataset.identificador]}`,
    			"texto_html": `${qs('#referencia-agradecimiento').value}${conector}${modelos[e.target.dataset.identificador]}`
    		})
    	}

        rellenar.contenedores(modelo_final, '.constancia-recomendaciones', {}, {})
        
        notificaciones.mensajeSimple('Datos cargados', false, 'V')

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

/* -------------------------------------------------------------------------------------------------*/
/*           						CONSTNCIA - SCROLL TOP						 				    */
/* -------------------------------------------------------------------------------------------------*/
qs('#constancia-busqueda').addEventListener('keydown', e => {
	qs('#tabla-constancia').parentElement.scrollTo(0,0)
})

/* -------------------------------------------------------------------------------------------------*/
/*           						CONSTNCIA - SCROLL TOP						 				    */
/* -------------------------------------------------------------------------------------------------*/
qs('#constancia-menor').addEventListener('click', e => {

	constancias.validarRepresentante()

})