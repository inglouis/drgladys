import { historias, tools, notificaciones, usuario } from '../js/historias.js';
import { notificaciones_reportes } from '../js/historias.js';
import { Paginacion } from '../js/main.js';


var paginacionPosiciones = {
	"constancia": 0
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
/*           					  NOTIFICACIONES - TEXTAREAS PREVIAS	 						    */
/* -------------------------------------------------------------------------------------------------*/
qs('#constancias-contenedor-notificaciones .cargar').addEventListener('mouseenter', e => {

	qs('#constancias-contenedor-notificaciones .personalizacion-notificaciones').removeAttribute('data-hidden')	

})

qs('#constancias-contenedor-notificaciones .cargar').addEventListener('mouseleave', e => {

	qs('#constancias-contenedor-notificaciones .personalizacion-notificaciones').setAttribute('data-hidden', '')

})

//----------------------------------------------------------------------------------------------------
//              				NOTIFICACIONES
//----------------------------------------------------------------------------------------------------
setInterval(async () => {

    if (Number(await tools.fullAsyncQuery('historias', 'controlador_cambios', []))) {

        //ACTUALIZACION SI CONTENEDOR ESTA ABIERTO
        //
        if (qs('#crud-notificaciones-popup').classList.contains('popup-activo')) {

       		notificaciones_reportes.cargarTabla(JSON.parse(await tools.fullAsyncQuery('historias_notificaciones', 'notificaciones_consultar', [])))

        }

        //ALERTA VISUAL DE NOTIFICACION DE REPORTES 
        //-----------------------------------------
        //lnr = longitud_notificaciones_reportes

        var lnr = await tools.fullAsyncQuery('historias_notificaciones', 'notificacion_reportes_cantidad', [])

        if (lnr > 0) {

        	if (!qs('#crud-notificaciones-popup').classList.contains('popup-activo')) {

        		qs('#notificacion-doctor').classList.add('notificacion-alerta')

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
