import { historias, tools, notificaciones, usuario, cambiarSeccionBotones, reporteSeleccionado, reportesDisponibles } from '../js/historias.js';
import { notificaciones_reportes, notificados_reportes } from '../js/historias.js';
import { Paginacion } from '../js/main.js';

var paginacionPosiciones = {
	"constancia": 0
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
		window.paginacion.animacion(1, true)
	},
	"presupuesto": () => {
		cambiarSeccionBotones(qs('#presupuesto'))
		window.paginacion.animacion(2, true)
	},
	"reposo": () => {
		cambiarSeccionBotones(qs('#reposo'))
		window.paginacion.animacion(3, true)
	},
	"general": () => {
		cambiarSeccionBotones(qs('#general'))
		window.paginacion.animacion(4, true)
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
		contenedor.querySelector('.nombre').innerHTML  = `${lista.nombres.toUpperCase()} ${lista.apellidos.toUpperCase()}`
		
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

		rellenar.contenedores(JSON.parse(notificaciones_reportes.sublista.datos), `.${notificaciones_reportes.sublista.reporte}-valores-notificaciones`, {}, {})

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
		contenedor.querySelector('.nombre').innerHTML  = `${lista.nombres.toUpperCase()} ${lista.apellidos.toUpperCase()}`
		
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

		}

		//RELLENA LOS DATOS Y ABRE EL POPUP
		historias.crud.customBodyEvents['reportes'](botonHistoria)

		//CAMBIA A LA POSICION DEL REPORTE CORRESPONDIENTE
		reportesPaginacion[notificados_reportes.sublista.reporte]()

		//LIMPIAR LOS DATOS
		tools.limpiar(`.${notificados_reportes.sublista.reporte}-valores`, '', {})

		//LLENA LOS DATOS DEL REPORTE
		rellenar.contenedores(datos, `.${notificados_reportes.sublista.reporte}-valores`, {}, {})

		//ENVIA NOTIFICACION
		notificaciones.mensajeSimple('Datos cargados', false, 'V')

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
qs("#edicion-notificaciones .reporte-actualizar").addEventListener('click', async e => {

	if (window.procesar) {

		window.procesar = false

		var datos = tools.procesar('', '', `${notificaciones_reportes.sublista.reporte}-valores-notificaciones`, tools, {'asociativa': true, 'id': 'id'});

		if (datos !== '') {
		
			if (notificaciones_reportes.posicion !== undefined) {

				notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'PROCESANDO')
				
				var x = JSON.parse(notificaciones_reportes.sublista.datos)

				datos['id_historia']      = x.id_historia
				datos['nombres']          = x.nombres
				datos['apellidos']        = x.apellidos
				datos['cedula'] 	      = x.cedula
				datos['fecha_nacimiento'] = x.fecha_nacimiento

				var datos_modificados = [] 

				notificaciones_reportes.crud.lista.forEach(e => {

				    if (e.id !== notificaciones_reportes.posicion) {
				        datos_modificados.push(e)
				    }
				   
				})

				var resultado = await tools.fullAsyncQuery(`historias_notificaciones`, `notificar_revisado`, [datos, datos_modificados, notificaciones_reportes.sublista.reporte], [["+", "%2B"]])

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

})

/* -------------------------------------------------------------------------------------------------*/
/*           					  NOTIFICACIONES - TEXTAREAS PREVIAS	 						    */
/* -------------------------------------------------------------------------------------------------*/
qs('#constancias-contenedor-notificaciones .cargar').addEventListener('mouseenter', e => {

	qs('#constancias-contenedor-notificaciones .personalizacion-notificaciones').removeAttribute('data-hidden')	

})

qs('#constancias-contenedor-notificaciones .cargar').addEventListener('mouseleave', e => {

	qs('#constancias-contenedor-notificaciones .personalizacion-notificaciones').setAttribute('data-hidden', '')

})

/* -------------------------------------------------------------------------------------------------*/
/* ------------------------------ ABRIR SECCIÓN DE NOTIFICACIONES ----------------------------------*/
/* -------------------------------------------------------------------------------------------------*/
qs('#notificacion-doctor').addEventListener('click', async e => {

	//PETICION PARA ACTUALIZAR LISTA DE DATOS DE NOTIFIACION

	notificaciones_reportes.cargarTabla(JSON.parse(await tools.fullAsyncQuery('historias_notificaciones', 'notificaciones_consultar', [])))

	//QUITAR ALERTA
	e.target.classList.remove('notificacion-alerta')

	//LIMPIAR DATOS
	notificaciones_reportes.posicion = undefined
	paginacionNotificaciones.animacion(0, true)
	tools.limpiar(`.${notificaciones_reportes.sublista.reporte}-valores-notificaciones`, '', {})

	notPop.pop()
})

/* -------------------------------------------------------------------------------------------------*/
/* ------------------------------ ABRIR SECCIÓN DE NOTIFICADOS -------------------------------------*/
/* -------------------------------------------------------------------------------------------------*/
qs('#desplegable-abrir-notificados').addEventListener('click', async e => {

	//PETICION PARA ACTUALIZAR LISTA DE DATOS DE NOTIFIACION

	notificados_reportes.cargarTabla(JSON.parse(await tools.fullAsyncQuery('historias_notificaciones', 'notificaciones_consultar', [])))

	//QUITAR ALERTA
	e.target.classList.remove('notificacion-alerta')

	//LIMPIAR DATOS
	notificados_reportes.posicion = undefined

})

//----------------------------------------------------------------------------------------------------
//              				NOTIFICACIONES
//----------------------------------------------------------------------------------------------------
var notificacionesPop = qs('#crud-notificaciones-popup'),
	notificacionesBoton = qs('#notificacion-doctor'),
	notificadosDesplegable = qs('#desplegable-notificados'),
	notificadosBoton = qs('#desplegable-abrir-notificados')

setInterval(async () => {

    if (Number(await tools.fullAsyncQuery('historias', 'controlador_cambios', []))) {

        //ACTUALIZACION SI CONTENEDOR ESTA ABIERTO
        //
        if (notificacionesPop.classList.contains('popup-activo') && usuario.rol.trim() === 'DOCTOR') { //AGREAR ROL A COMPARARCIONES

       		notificaciones_reportes.cargarTabla(JSON.parse(await tools.fullAsyncQuery('historias_notificaciones', 'notificaciones_consultar', [])))

        }

        if (notificadosDesplegable.style.display === '' && usuario.rol.trim() === 'ADMINISTRACION') {

        	notificados_reportes.cargarTabla(JSON.parse(await tools.fullAsyncQuery('historias_notificaciones', 'notificaciones_consultar', [])))

        }

        //ALERTA VISUAL DE NOTIFICACION DE REPORTES 
        //-----------------------------------------
        //lnr = longitud_notificaciones_reportes

        var lnr = await tools.fullAsyncQuery('historias_notificaciones', 'notificacion_reportes_cantidad', [])

        if (lnr > 0) {

        	if (!notificacionesPop.classList.contains('popup-activo') && usuario.rol.trim() === 'DOCTOR') {

        		notificacionesBoton.classList.add('notificacion-alerta')

        	}

	        if (notificadosDesplegable.style.display === 'none' && usuario.rol.trim() === 'ADMINISTRACION') {
	        	
	        	notificadosBoton.classList.add('notificacion-alerta')

	        }

        }


    	await tools.fullAsyncQuery('historias', 'controlador_cambios_desactivar', [])

    }

}, 5000);

//----------------------------------------------------------------------------------------------------
//              				PASOS PARA LAS NOTIFICACIONES DE ANDREA
//----------------------------------------------------------------------------------------------------

//0- ABRIR EL DESPLEGABLE DE NOTIFICACIONES Y CLICKAR UN RENGLON
//1- APLICAR FILTRO POR NUMERO DE HISTORIA EN EL CRUD DE HISTORIAS
//2- BUSCAR EL BOTON EN LA TABLA DONDE LA COMPARATIVA DE ID_HISTORIA SEA IGUAL
//3- LLAMAR A CUSTOMBBODYEVENTS "REPORTES" PASANDOLE LA REFERENCIA DEL BOTON PARA ABRIR EL CONTENEDOR FUNCIONALMENTE
//4- RELLENAR LOS DATOS DEL DESPLEGABLE A LA SECCION CORRECTA [CAMBIAR A LA SECCION CORRESPONDIENTE DE FORMA AUTOMATICA CON LA REFERENCIA DEL REPORTE]

//NOTAS: CUANDO SE CLICKEE UN BOTON DEBE: CERRARSE CUALQUIER POPUP ABIERTO, ABRIRSE EL DE REPORTES, LIMPIAR INFORMACION Y CARGAR CORRESPONDIENTE [BLOQUAR CLICKEO MIENTRAS SE ESTE CARGANDO ESTE PROCESO]
