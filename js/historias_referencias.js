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

		var motivo = JSON.parse(e.sublista.motivo).texto_html,
			agradecimiento = JSON.parse(e.sublista.agradecimiento).texto_html

		contenedor.querySelector('.referencia-referencia').innerHTML = window.lista_referencias[e.sublista.id_referencia].descripcion
		contenedor.querySelector('.referencia-referido').innerHTML = window.lista_referidos[e.sublista.id_medico_referido].nombre

		contenedor.querySelector('.referencia-motivo').innerHTML = motivo.toUpperCase()

		contenedor.querySelector('.referencia-agradecimiento').innerHTML = agradecimiento.toUpperCase()

		contenedor.querySelector('.nombre').insertAdjacentHTML('afterbegin', `<b>- Nombre:</b> ${e.sublista.nombres}`)
		contenedor.querySelector('.apellido').insertAdjacentHTML('afterbegin', `<b>- Apellido:</b> ${e.sublista.apellidos}`)
		contenedor.querySelector('.cedula').insertAdjacentHTML('afterbegin', `<b>- Cédula/pasaporte:</b> ${e.sublista.cedula}`)
		contenedor.querySelector('.edad').insertAdjacentHTML('afterbegin', `<b>- Edad:</b> ${tools.calcularFecha(new Date(e.sublista.fecha_nacimiento))}`)
		
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
	/*           								  MODELO 											    */
	/* -------------------------------------------------------------------------------------------------*/
	"modelo": async (e) => {

		if (e.target.classList.contains('modelo')) {

			referencias.sublista = tools.pariente(e.target, 'TR').sublista

			reporteModeloSeleccionado = {datos: tools.copiaLista(referencias.sublista), reporte: 'referencia'}

			notificaciones.mensajeSimple('Modelo copiado', false, 'V')

		}

	},
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

			refPop.pop()

		}

	},
	/* -------------------------------------------------------------------------------------------------*/
	/*           				ENVIAR LOS DATOS PARA REIMPRIMIR EL ANTECENDENTE   					    */
	/* -------------------------------------------------------------------------------------------------*/
	"reimprimir": async (e) => {

		if (e.target.classList.contains('reimprimir')) {

			referencias.sublista = tools.pariente(e.target, 'TR').sublista

			var lista = tools.copiaLista(referencias.sublista)

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

	referencias.cargarTabla([], undefined, undefined)

})()

/* -------------------------------------------------------------------------------------------------*/
/*           							REFERENCIAS - NOTIFICAR									    */
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
				"nombres": historias.sublista.nombres, 
				"apellidos": historias.sublista.apellidos, 
				"cedula": historias.sublista.cedula, 
				"fecha_nacimiento": historias.sublista.fecha_naci,
				"id_referencia": datos[0],
				"id_medico_referido": datos[2],
				"agradecimiento": datos[3], 
				"motivo": {
					"texto_base": qs(`#${elemento.identificador}-informacion`).texto_base,
					"texto_html": qs(`#${elemento.identificador}-informacion`).texto_html
				} 
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
/*           							REFERENCIAS - CARGAR	  								    */
/* -------------------------------------------------------------------------------------------------*/

qs("#referencias-contenedor .reporte-cargar").addEventListener('click', async e => {

	if(window.procesar) {

		var elemento = qs('#referencias-contenedor')

		window.procesar = false

		notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'PROCESANDO')

		var datos = tools.procesar('', '', `${elemento.identificador}-valores`, tools);

		if (datos !== '') {
			
			var lista = { 
				"id_historia": historias.sublista.id_historia,
				"nombres": historias.sublista.nombres, 
				"apellidos": historias.sublista.apellidos, 
				"cedula": historias.sublista.cedula, 
				"fecha_nacimiento": historias.sublista.fecha_naci,
				"id_referencia": datos[0],
				"id_medico_referido": datos[2],
				"agradecimiento": datos[3], 
				"motivo": {
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
/*           							REFERENCIAS - PREVIA				  					    */
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
				"nombres": historias.sublista.nombres, 
				"apellidos": historias.sublista.apellidos, 
				"cedula": historias.sublista.cedula, 
				"fecha_nacimiento": historias.sublista.fecha_naci,
				"id_referencia": datos[0],
				"id_medico_referido": datos[2],
				"agradecimiento": datos[3], 
				"motivo": {
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

				notificaciones.mensajeSimple('Error al procesar la petición', null, 'F')

			}

		}

	} else {

		notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'PROCESANDO')
		
	}

})

/* -------------------------------------------------------------------------------------------------*/
/*           							REFERENCIAS - EDITAR									    */
/* -------------------------------------------------------------------------------------------------*/
qs('#crud-refeditar-botones .confirmar').addEventListener('click', async e => {

	if(window.procesar) {

		notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'PROCESANDO')	

		var elemento = qs('#referencias-contenedor')

		window.procesar = false

		var datos = tools.procesar('', '', `refeditar-valores`, tools);

		if (datos !== '') {

			var motivo = (typeof datos[1] === 'string') ? JSON.parse(datos[1]) : datos[1];
			var agradecimiento = (typeof datos[3] === 'string') ? JSON.parse(datos[3]) : datos[3];

			referencias.sublista.id_referencia 		= datos[0]
			referencias.sublista.motivo 			= JSON.stringify(motivo)
			referencias.sublista.id_medico_referido = datos[2]
			referencias.sublista.agradecimiento 	= JSON.stringify(agradecimiento)

			var resultado = await tools.fullAsyncQuery(`historias_${elemento.identificador}`, `${elemento.identificador}_editar`, [JSON.stringify(referencias.crud.lista), historias.sublista.id_historia], [["+", "%2B"]])

			if (resultado.trim() === 'exito') {

				referencias.cargarTabla(referencias.crud.lista)

				notificaciones.mensajeSimple('Petición realiza con éxito', false, 'V')

				window.idSeleccionada = historias.sublista.id_historia

				refPop.pop()

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
/*           						REFERENCIAS - ELIMINAR					 					    */
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
/*           						  REFERENCIAS - TEXTO PREVIA	 							    */
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
/*           						REFERENCIAS - LIMPIAR					 					    */
/* -------------------------------------------------------------------------------------------------*/
qs('#referencias-contenedor .limpiar').addEventListener('click', e => {

	tools.limpiar('.referencia-valores', '', {})

	notificaciones.mensajeSimple('Datos limpiados', false, 'V')

})


/* -------------------------------------------------------------------------------------------------*/
/*           						REFERENCIAS - REUSAR MODELO				 					    */
/* -------------------------------------------------------------------------------------------------*/
qs('#referencias-contenedor .reutilizar').addEventListener('click', e => {

	if (typeof reporteModeloSeleccionado['reporte'] !== 'undefined') {

		if (reporteModeloSeleccionado['reporte'] === 'referencia') {

			tools.limpiar('.referencia-valores', '', {})
			rellenar.contenedores(reporteModeloSeleccionado['datos'], '.referencia-valores', {elemento: e.target, id: 'value'}, {})
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
/*           						REFERENCIAS - SCROLL TOP				 					    */
/* -------------------------------------------------------------------------------------------------*/
qs('#referencia-busqueda').addEventListener('keydown', e => {
	qs('#tabla-referencia').parentElement.scrollTo(0,0)
})

/* -------------------------------------------------------------------------------------------------*/
/*           						REFERENCIAS - MODELO					 				    	*/
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

        rellenar.contenedores(modelo_final, '.referencia-agradecimiento', {}, {})
        
        notificaciones.mensajeSimple('Datos cargados', false, 'V')

    }
    
})

//-------------------------------------------------------------------------------
//botones que insertan datos básicos desde la edición o insersión de una historia
//-------------------------------------------------------------------------------

var insersiones_lista  = ['referencia', 'referido'],
	insersiones_lista_combos = [refInsPop, refeInsPop],
	ultimoBotonInsersionBasica = '';

insersiones_lista.forEach((grupo, i) => {

	qs(`#insertar-nueva-${grupo}`).addEventListener('click', e => {
		ultimoBotonInsersionBasica = e.target
		tools.limpiar(`.insertar-${grupo}-valores`, '', {})
		insersiones_lista_combos[i].pop()
	})

	qs(`#crud-insertar-${grupo}-botones`).addEventListener('click', async e => {

		if (e.target.classList.contains('insertar')) {

			var datos = tools.procesar(e.target, 'insertar', `insertar-${grupo}-valores`,  tools)

			if (datos !== '') {

				if (grupo === 'referencia') {
					datos.splice(2,1)
				} else {
					datos.splice(1,1)
				}

				var resultado = await tools.fullAsyncQuery(`${grupo}s`, `crear_${grupo}s`, datos)

				if(resultado.trim() === 'exito') {

					notificaciones.mensajeSimple(`Información insertada con éxito`, resultado, 'V')

					setTimeout(async () => {

						var lista = JSON.parse(await tools.fullAsyncQuery('combos', `combo_${grupo}s`, []))

						ultimoBotonInsersionBasica.parentElement.parentElement.querySelector('input').value = qs(`#nombre-${grupo}`).value.toUpperCase()
						ultimoBotonInsersionBasica.parentElement.parentElement.querySelector('input').focus()

						qs(`#nombre-${grupo}`).value = ''

						insersiones_lista_combos[i].pop()

						contenedoresReportes.reconstruirCombo(qs(`[data-grupo="cc-referencias-${insersiones_lista[i]}-insertar"] select`), qs(`[data-grupo="cc-referencias-${insersiones_lista[i]}-insertar"] input`), lista)
						contenedoresReportes.filtrarComboForzado(qs(`[data-grupo="cc-referencias-${insersiones_lista[i]}-insertar"] select`), qs(`[data-grupo="cc-referencias-${insersiones_lista[i]}-insertar"] input`))

					}, 500)

				} else if (resultado.trim() === 'repetido') {

					notificaciones.mensajeSimple(`Este [${grupo.toUpperCase()}] ya existe`, resultado, 'F')

				} else {

					notificaciones.mensajeSimple('Error al procesar la petición', resultado, 'F')

				}
			}
		}
	})

})

/* -------------------------------------------------------------------------------------------------*/
/* -------------------------------------------------------------------------------------------------*/
qs('#referencia-informacion').addEventListener('click', e => {
	e.target.focus()
})

qs('#referencia-agradecimiento').addEventListener('click', e => {
	e.target.focus()
})

qs('#referencia-informacion-notificaciones').addEventListener('click', e => {
	e.target.focus()
})

qs('#referencia-agradecimiento-notificaciones').addEventListener('click', e => {
	e.target.focus()
})