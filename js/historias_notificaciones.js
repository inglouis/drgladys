import { historias, tools, notificaciones, usuario, cambiarSeccionBotones, reporteSeleccionado, reportesDisponibles } from '../js/historias.js';
import { notificaciones_reportes, notificados_reportes, notificacionesPop , notificacionesBoton, notificadosDesplegable, notificadosBoton } from '../js/historias.js';
import { Paginacion } from '../js/main.js';

var paginacionPosiciones = {
	"constancia": 0,
	"informe": 1,
	"referencia": 2,
	"presupuesto": 3,
	"reposo": 4,
	"general": 5
}

var historiaPopups = {
	"crud-editar-popup": ediPop,
	"crud-insertar-popup": insPop,
	"crud-informacion-popup": infPop,
	"crud-notificaciones-popup": notPop,
	"crud-insertar-ocupaciones-popup": ocuPop,
	"crud-insertar-proveniencias-popup": proPop,
	"crud-insertar-parentescos-popup": parPop,
	"crud-insertar-estado_civil-popup": civPop,
	"crud-insertar-religiones-popup": relPop,
	"crud-insertar-medicos-popup": medPop,
	"crud-previas-popup": prePop,
	"crud-reportes-popup": repPop,
	"crud-coneditar-popup": conPop,
	"crud-geneditar-popup": genPop,
	"crud-infeditar-popup": forPop,
	"crud-preeditar-popup": presPop,
	"crud-repeditar-popup": repoPop
}

window.reportesPaginacion = {
	"constancia": () => {
		cambiarSeccionBotones(qs('#constancia'))
		window.paginacion.animacion(0, true)
	},
	"informe": () => {
		cambiarSeccionBotones(qs('#informe'))
		qs('#informes-contenedor-notificaciones').scrollTo(0,0)
		window.paginacion.animacion(1, true)
	},
	"referencia": () => {
		cambiarSeccionBotones(qs('#referencia'))
		window.paginacion.animacion(2, true)
	},
	"presupuesto": () => {
		cambiarSeccionBotones(qs('#presupuesto'))
		window.paginacion.animacion(3, true)
	},
	"reposo": () => {
		cambiarSeccionBotones(qs('#reposo'))
		window.paginacion.animacion(4, true)
	},
	"general": () => {
		cambiarSeccionBotones(qs('#general'))
		window.paginacion.animacion(5, true)
	}
}

/* -------------------------------------------------------------------------------------------------*/
/*           						NOTIFICACIONES - PROPIEDADES				 				    */
/* -------------------------------------------------------------------------------------------------*/
notificaciones_reportes['crud'].generarColumnas(['gSpan', null, null], [false], ['HTML'], 'notificaciones-crud', 0)
/////////////////////////////////////////////////////
///
notificaciones_reportes['crud']['propiedadesTr'] = {
	"contenedor": (e) => {

		var fr = new DocumentFragment(),
			th = notificaciones_reportes, 
			contenedor = e.querySelector('.notificaciones-crud'), 
			contenido = th.contenido.cloneNode(true)


		contenedor.innerHTML = ''
		contenedor.appendChild(contenido)
		contenedor.setAttribute('id', `id-${e.sublista.id}-notificaciones`)

		var lista = JSON.parse(e.sublista.datos)

		contenedor.querySelector('.reporte').innerHTML = e.sublista.reporte.toUpperCase()

		if (typeof lista.nombres === 'undefined') {
			contenedor.querySelector('.nombre').innerHTML  = lista.nombre_completo.toUpperCase()
		} else {
			contenedor.querySelector('.nombre').innerHTML  = `${lista.nombres.toUpperCase()} ${lista.apellidos.toUpperCase()}`
		}

		if (e.sublista.id === th.posicion) {

			contenedor.classList.add('seleccionado')
			
		} else {

			contenedor.classList.remove('seleccionado')

		}

	},
	"informacion": (e) => {
		var fr = new DocumentFragment(), th = historias
		var div = th.div.cloneNode(true);

		var datos = JSON.parse(e.sublista.datos)

		var d1 = th.div.cloneNode(true)
			d1.insertAdjacentHTML('afterbegin', 'N° DE HISTORIA:')
			d1.setAttribute('style', `min-width:200px; color:#fff`)

		var d2 = th.div.cloneNode(true)
			d2.insertAdjacentHTML('afterbegin', datos.id_historia)
			d2.setAttribute('style', `color:#fff`)

		div.appendChild(d1)
		div.appendChild(d2)

		div.setAttribute('style', `padding: 6px; width:fit-content; text-align: left;font-size: 1.1em; position:fixed; background:#262626`)
		div.setAttribute('class', 'tooltip-crud')
		div.setAttribute('data-hidden', '')

		e.addEventListener('mousemove', div.fn = function fn(e) {
			this.querySelector('.tooltip-crud').style.top = (e.clientY - 50)+'px'
			this.querySelector('.tooltip-crud').style.left = (e.clientX + 15)+'px'
		})

		e.addEventListener('mouseenter', div.fn = function fn(e) {
			this.querySelector('.tooltip-crud').removeAttribute('data-hidden')	
		})

		e.addEventListener('mouseleave', div.fn = function fn(e) {
			this.querySelector('.tooltip-crud').setAttribute('data-hidden', '')
		})

		e.appendChild(div)
	}
}
/////////////////////////////////////////////////////
///
notificaciones_reportes['crud']['customBodyEvents'] = {
	/* -------------------------------------------------------------------------------------------------*/
	/*           								REUTILIZAR 											    */
	/* -------------------------------------------------------------------------------------------------*/
	"cargar": async (e) => {

		qsa('#tabla-notificaciones tr td').forEach( ren => {
			
			ren.classList.remove('seleccionado')

		});

		notificaciones_reportes.sublista = tools.pariente(e.target, 'TR').sublista

		tools.pariente(e.target, 'TR').children[0].classList.add('seleccionado')

		notificaciones_reportes.posicion = notificaciones_reportes.sublista.id
		
		paginacionNotificaciones.animacion(paginacionPosiciones[notificaciones_reportes.sublista.reporte], true)

		tools.limpiar(`.${notificaciones_reportes.sublista.reporte}-valores-notificaciones`, '', {})

		rellenar.contenedores(JSON.parse(notificaciones_reportes.sublista.datos), `.${notificaciones_reportes.sublista.reporte}-valores-notificaciones`, {}, {
			"contenedorConsulta": function fn(lista, grupo) {

				if (notificaciones_reportes.sublista.reporte === 'informe') {

					var peticion = tools.fullQuery('historias_informe', 'estandar_diagnosticos', lista)
					peticion.onreadystatechange = function() {
				        if (this.readyState == 4 && this.status == 200) {
				        	contenedoresNotificaciones.estandarizarContenedor(grupo, JSON.parse(this.responseText), ['id_diagnostico', 'nombre'])
				        }
				    };	

				}
			}
		})

		notificaciones.mensajeSimple('Datos cargados', false, 'V')

	}
};


(async () => {

	notificaciones_reportes.cargarTabla([], undefined, undefined)

})()

/* -------------------------------------------------------------------------------------------------*/
/*           						NOTIFICADOS - PROPIEDADES					 				    */
/* -------------------------------------------------------------------------------------------------*/
notificados_reportes['crud'].generarColumnas(['gSpan', null, null], [false], ['HTML'], 'notificados-crud', 0)
/////////////////////////////////////////////////////
///
notificados_reportes['crud']['propiedadesTr'] = {
	"contenedor": (e) => {

		var fr = new DocumentFragment(),
			th = notificados_reportes, 
			contenedor = e.querySelector('.notificados-crud'), 
			contenido = th.contenido.cloneNode(true)


		contenedor.innerHTML = ''
		contenedor.appendChild(contenido)
		contenedor.setAttribute('id', `id-${e.sublista.id}-notificados`)

		var lista = JSON.parse(e.sublista.datos)

		contenedor.querySelector('.reporte').innerHTML = e.sublista.reporte.toUpperCase()
		
		if (typeof lista.nombres === 'undefined') {
			contenedor.querySelector('.nombre').innerHTML  = lista.nombre_completo.toUpperCase()
		} else {
			contenedor.querySelector('.nombre').innerHTML  = `${lista.nombres.toUpperCase()} ${lista.apellidos.toUpperCase()}`
		}
		
		if (e.sublista.id === th.posicion) {

			contenedor.classList.add('seleccionado')
			
		} else {

			contenedor.classList.remove('seleccionado')

		}

	},
	"informacion": (e) => {
		var fr = new DocumentFragment(), th = historias
		var div = th.div.cloneNode(true);

		var datos = JSON.parse(e.sublista.datos)

		var d1 = th.div.cloneNode(true)
			d1.insertAdjacentHTML('afterbegin', 'N° DE HISTORIA:')
			d1.setAttribute('style', `min-width:200px; color:#fff`)

		var d2 = th.div.cloneNode(true)
			d2.insertAdjacentHTML('afterbegin', datos.id_historia)
			d2.setAttribute('style', `color:#fff`)

		div.appendChild(d1)
		div.appendChild(d2)

		div.setAttribute('style', `padding: 6px; width:fit-content; text-align: left;font-size: 1.1em; position:fixed; background:#262626`)
		div.setAttribute('class', 'tooltip-crud')
		div.setAttribute('data-hidden', '')

		e.addEventListener('mousemove', div.fn = function fn(e) {
			this.querySelector('.tooltip-crud').style.top = (e.clientY - 50)+'px'
			this.querySelector('.tooltip-crud').style.left = (e.clientX + 15)+'px'
		})

		e.addEventListener('mouseenter', div.fn = function fn(e) {
			this.querySelector('.tooltip-crud').removeAttribute('data-hidden')	
		})

		e.addEventListener('mouseleave', div.fn = function fn(e) {
			this.querySelector('.tooltip-crud').setAttribute('data-hidden', '')
		})

		e.appendChild(div)
	}
}
/////////////////////////////////////////////////////
///
notificados_reportes['crud']['customBodyEvents'] = {
	/* -------------------------------------------------------------------------------------------------*/
	/*           								REUTILIZAR 											    */
	/* -------------------------------------------------------------------------------------------------*/
	"cargar": async (e) => {

		if (e.target.tagName !== 'BUTTON') {

			var tr = undefined, botonHistoria = undefined

			qsa('#tabla-notificados tr td').forEach( ren => {
				
				ren.classList.remove('seleccionado')

			});

			notificados_reportes.sublista = tools.pariente(e.target, 'TR').sublista

			tools.pariente(e.target, 'TR').children[0].classList.add('seleccionado')

			//CAMBIAR POPUP
			window.paginacionHistorias.cambiarUltimoSeleccionado('reportes')
			window.paginacionHistorias.actualizarFamiliaDeBotones(tools.pariente(qs('#tabla-historias tbody tr .reportes'), 'TR'))

			//LISTA DE DATOS
			var datos = JSON.parse(notificados_reportes.sublista.datos)

			//CAMBIA LA POSICION ACTUAL DE LA LISTA SELECCIONADA
			notificados_reportes.posicion = notificados_reportes.sublista.id

			//ASIGNA EL VALOR AL CAJON DE BUSQUEDA DE LA HISTORIA
			qs('#busqueda').value = datos.id_historia

			//FUERZA LA BUSQUEDA EN EL CRUD
			historias.crud.botonForzar()

			//CIERRA LOS POPUPS ACTIVOS
			qsa('.popup-activo').forEach(el => {

				if (el.id === 'crud-reportes-popup') {

					if (historias.sublista.id_historia !== datos.id_historia) {

						historiaPopups[el.id].pop()

					}

				} else {

					historiaPopups[el.id].pop()

				}

			})

			//CAPTURA EL TR DE LA TABLA
			qsa('#tabla-historias tbody tr').forEach(el => {
			    
			    if (el.sublista.id_historia === datos.id_historia) {
			        tr = el
			    }
			    
			})
			
			//CAPTURA EL BOTON DEL RENGLON
			botonHistoria = tr.querySelector('.reportes')

			//PREVIENE EL CIERRE DEL POPUP EN CASO DE SER EL MISMO NUMERO DE HISTORIA
			if (historias.sublista.id_historia === datos.id_historia && qs('#crud-reportes-popup').classList.contains('popup-activo')) {

				prevenirCierreReporte = true

			} else {

				//LIMPIAR LOS DATOS
				tools.limpiar(`.${notificados_reportes.sublista.reporte}-valores`, '', {})

			}

			//RELLENA LOS DATOS Y ABRE EL POPUP
			historias.crud.customBodyEvents['reportes'](botonHistoria)

			//CAMBIA A LA POSICION DEL REPORTE CORRESPONDIENTE
			reportesPaginacion[notificados_reportes.sublista.reporte]()

			//LLENA LOS DATOS DEL REPORTE
			rellenar.contenedores(datos, `.${notificados_reportes.sublista.reporte}-valores`, {}, {
				"contenedorConsulta": function fn(lista, grupo) {

					if (notificados_reportes.sublista.reporte === 'informe') {

						var peticion = tools.fullQuery('historias_informe', 'estandar_diagnosticos', lista)
						peticion.onreadystatechange = function() {
					        if (this.readyState == 4 && this.status == 200) {
					        	contenedoresNotificaciones.estandarizarContenedor(grupo, JSON.parse(this.responseText), ['id_diagnostico', 'nombre'])
					        }
					    };	

					}
				}
			})

			//ENVIA NOTIFICACION
			notificaciones.mensajeSimple('Datos cargados', false, 'V')

		}

	},
	"eliminar": async (e) => {
		if (e.target.classList.contains('eliminar')) {

			if (window.procesar) {

				window.procesar = false

				notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'PROCESANDO')

				notificados_reportes.sublista = tools.pariente(e.target, 'TR').sublista

				//CAMBIA LA POSICION ACTUAL DE LA LISTA SELECCIONADA
				notificados_reportes.posicion = notificados_reportes.sublista.id

				var resultado = await tools.fullAsyncQuery(`historias_notificaciones`, `notificado_revisado`, [notificados_reportes.posicion], [["+", "%2B"]])

				if (resultado.trim() === 'exito') {

					notificados_reportes.posicion = undefined

					notificados_reportes.cargarTabla(JSON.parse(await tools.fullAsyncQuery('historias_notificaciones', 'notificaciones_consultar', [])))

					notificaciones.mensajeSimple('Revisión del reporte completada', '', 'V')

				} else if (resultado.trim() === 'espera') {

					notificaciones.mensajePersonalizado('Se está actualizando el listado de reportes, espere un momento...', false, 'CLARO-1', 'PROCESANDO')

				} else {

					notificaciones.mensajeSimple('Error al procesar la petición', resultado, 'F')

				}

				window.procesar = true
				
			}

		}
	}
};


(async () => {

	notificados_reportes.cargarTabla([], undefined, undefined)

})()

/* -------------------------------------------------------------------------------------------------*/
/* -----------------------------------PAGINACIÓN DE REPORTES----------------------------------------*/
/* -------------------------------------------------------------------------------------------------*/
window.paginacionNotificaciones = new Paginacion(
	{"contenedores": ".notificaciones-seccion" ,"familia": '[data-familia]', "efecto": ['aparecer', 'aparecer'], "delay": 100},
	[
		{},
		{}
	]
)

window.paginacionNotificaciones.subefectos = true //por defecto true es solo para acordarme de la opcion

//window.paginacion.animacion(i, true)

/* -------------------------------------------------------------------------------------------------*/
/*           					CONSTANCIAS - NOTIFICAR	REVISADO								    */
/* -------------------------------------------------------------------------------------------------*/
qs("#edicion-notificaciones").addEventListener('click', async e => {

	if (e.target.classList.contains('reporte-actualizar') && e.target.tagName === 'BUTTON') {

		if (window.procesar) {

			window.procesar = false

			var datos_notificados = tools.procesar('', '', `${notificaciones_reportes.sublista.reporte}-valores-notificaciones`, tools, {'asociativa': true, 'id': 'id'});

			if (datos_notificados !== '') {
			
				if (notificaciones_reportes.posicion !== undefined) {

					notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'PROCESANDO')
					
					var x = JSON.parse(notificaciones_reportes.sublista.datos)

					datos_notificados['id_historia']      = x.id_historia
					datos_notificados['nombres']          = x.nombres
					datos_notificados['apellidos']        = x.apellidos
					datos_notificados['cedula'] 	      = x.cedula
					datos_notificados['fecha_nacimiento'] = x.fecha_nacimiento

					if (notificaciones_reportes.sublista.reporte === 'informe') {
						datos_notificados['diagnosticos'] = JSON.stringify(datos_notificados['diagnosticos'])
					}

					// notificaciones_reportes.crud.lista.forEach(e => {

					//     if (e.id !== notificaciones_reportes.posicion) {
					//         datos_modificados.push(e)
					//     }
					   
					// })

					var resultado = await tools.fullAsyncQuery(`historias_notificaciones`, `notificar_revisado`, [datos_notificados, notificaciones_reportes.sublista.reporte, notificaciones_reportes.posicion], [["+", "%2B"]])

					if (resultado.trim() === 'exito') {

						notificaciones_reportes.posicion = undefined

						notificaciones_reportes.cargarTabla(JSON.parse(await tools.fullAsyncQuery('historias_notificaciones', 'notificaciones_consultar', [])))

						tools.limpiar(`.${notificaciones_reportes.sublista.reporte}-valores-notificaciones`, '', {})

						notificaciones.mensajeSimple('Reporte modificado', '', 'V')

						setTimeout(() => {
							notificaciones.mensajeSimple('Se notificó a recepción la impresión del reporte', '', 'V')
						}, 2000)

					} else if (resultado.trim() === 'espera') {

						notificaciones.mensajePersonalizado('Se está actualizando el listado de reportes, espere un momento...', false, 'CLARO-1', 'PROCESANDO')

					} else {

						notificaciones.mensajeSimple('Error al procesar la petición', resultado, 'F')

					}

				} else {
					notificaciones.mensajeSimple('No ha seleccionado ningún reporte', resultado, 'F')
				}

			}

		} else {

			notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'PROCESANDO')
			
		}

	}

})

/* -------------------------------------------------------------------------------------------------*/
/*           					  NOTIFICACIONES - TEXTAREAS PREVIAS	 						    */
/* -------------------------------------------------------------------------------------------------*/

var previas = ['constancias', 'informes']

previas.forEach((reporte) => {

	qs(`#${reporte}-contenedor-notificaciones .cargar`).addEventListener('mouseenter', e => {

		qs(`#${reporte}-contenedor-notificaciones .personalizacion-c`).removeAttribute('data-hidden')	

	})

	qs(`#${reporte}-contenedor-notificaciones .cargar`).addEventListener('mouseleave', e => {

		qs(`#${reporte}-contenedor-notificaciones .personalizacion-c`).setAttribute('data-hidden', '')

	})

})

/* -------------------------------------------------------------------------------------------------*/
/* ------------------------------ ABRIR SECCIÓN DE NOTIFICACIONES ----------------------------------*/
/* -------------------------------------------------------------------------------------------------*/
qs('#notificacion-doctor').addEventListener('click', async e => {

	notificaciones_reportes.posicion = undefined

	//PETICION PARA ACTUALIZAR LISTA DE DATOS DE NOTIFIACION

	notificaciones_reportes.cargarTabla(JSON.parse(await tools.fullAsyncQuery('historias_notificaciones', 'notificaciones_consultar', [])))

	//QUITAR ALERTA
	e.target.classList.remove('notificacion-alerta')

	//LIMPIAR DATOS
	paginacionNotificaciones.animacion(0, true)
	tools.limpiar(`.${notificaciones_reportes.sublista.reporte}-valores-notificaciones`, '', {})

	notPop.pop()
})

/* -------------------------------------------------------------------------------------------------*/
/* ------------------------------ ABRIR SECCIÓN DE NOTIFICADOS -------------------------------------*/
/* -------------------------------------------------------------------------------------------------*/
qs('#desplegable-abrir-notificados').addEventListener('click', async e => {

	//LIMPIAR
	notificados_reportes.posicion = undefined

	//PETICION PARA ACTUALIZAR LISTA DE DATOS DE NOTIFIACION

	notificados_reportes.cargarTabla(JSON.parse(await tools.fullAsyncQuery('historias_notificaciones', 'notificaciones_consultar', [])))

	//QUITAR ALERTA
	e.target.classList.remove('notificacion-alerta')

	//LIMPIAR DATOS
	notificados_reportes.posicion = undefined

})