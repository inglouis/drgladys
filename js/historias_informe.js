import { customDesplegable, Rellenar } from '../js/main.js';
import { historias, tools, notificaciones, reporteSeleccionado } from '../js/historias.js';
import { informes } from '../js/historias.js';

/* 1)------------------------------------------------------------------------------------------------*/
/* ---------------------------------------- INFORMES 	---------------------------------------------*/
/*---------------------------------------------------------------------------------------------------*/

export const informePrevia = new customDesplegable('#informes-contenedor .desplegable-contenedor', '#informes-contenedor .reporte-previa', '#informes-contenedor .desplegable-cerrar', undefined, 'fit-content')

informePrevia.eventos()
informePrevia.prevenir = true

/* -------------------------------------------------------------------------------------------------*/
/*           						INFORME - PROPIEDADES				 					    */
/* -------------------------------------------------------------------------------------------------*/
informes['crud'].generarColumnas(['gSpan', null, null], [false],['HTML'], 'informes-contenedor', 0)
informes['crud'].generarColumnas(['gSpan', null, null], [false],['HTML'], 'fecha-contenedor', 0)

informes['crud']['ofv']  = true
informes['crud']['ofvh'] = '85vh'

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

		//tipo
		contenedor.querySelectorAll('.informe-tipo option').forEach((el, i) => {
			if (el.value === e.sublista.tipo) {
				el.parentElement.selectedIndex = i
			}
		})

		if (e.sublista.tipo !== '1') {
			contenedor.querySelector('.informe-aplica-completo').setAttribute('data-hidden', '')
		}

		//contenido
		var contenido = JSON.parse(e.sublista.contenido).texto_html
			contenedor.querySelector('.informe-contenido div').innerHTML = contenido.toUpperCase()

		//agudeza 4
		contenedor.querySelector('.informe-agudeza-4 span').innerHTML = `OD: ${e.sublista.agudeza_od_4.toUpperCase()} - OI: ${e.sublista.agudeza_oi_4.toUpperCase()}`
		contenedor.querySelector('.informe-agudeza-4 input').checked = (e.sublista.correccion_4 === 'X') ? true : false;

		//agudeza 1
		contenedor.querySelector('.informe-agudeza-1 span').innerHTML = `OD: ${e.sublista.agudeza_od_1.toUpperCase()} - OI: ${e.sublista.agudeza_oi_1.toUpperCase()}`
		contenedor.querySelector('.informe-agudeza-1 input').checked = (e.sublista.correccion_1 === 'X') ? true : false;

		//agudeza lectura
		contenedor.querySelector('.informe-agudeza-lectura span').innerHTML = `OD: ${e.sublista.agudeza_od_lectura.toUpperCase()} - OI: ${e.sublista.agudeza_oi_lectura.toUpperCase()}`
		contenedor.querySelector('.informe-agudeza-lectura input').checked = (e.sublista.correccion_lectura === 'X') ? true : false;

		//pruebas
		contenedor.querySelector('.informe-agudeza-test div').innerHTML = `Estereopsis: ${e.sublista.estereopsis}S - Ishihara: ${e.sublista.test} - Stereo Fly: ${e.sublista.reflejo}`

		//motilidad
		var motilidad = JSON.parse(e.sublista.motilidad).texto_html
			contenedor.querySelector('.informe-motilidad div').innerHTML = motilidad.toUpperCase()

		//rx
		contenedor.querySelectorAll('.informe-agudeza-rx div')[0].innerHTML = 
			`
				OD: ${(e.sublista.rx_od_signo_1 === 'X') ? '+' : '-'}
					${e.sublista.rx_od_valor_1} 
					${(e.sublista.rx_od_signo_2 === 'X') ? '+' : '-'}
					${e.sublista.rx_od_valor_2} X
					${e.sublista.rx_od_grados}° = 
					${e.sublista.rx_od_resultado}
			`

		contenedor.querySelectorAll('.informe-agudeza-rx div')[1].innerHTML = 
			`
				OI: &nbsp;&nbsp;${(e.sublista.rx_oi_signo_1 === 'X') ? '+' : '-'}
					${e.sublista.rx_oi_valor_1} 
					${(e.sublista.rx_oi_signo_2 === 'X') ? '+' : '-'}
					${e.sublista.rx_oi_valor_2} X
					${e.sublista.rx_oi_grados}° = 
					${e.sublista.rx_oi_resultado}
			`

		//PIO
		contenedor.querySelector('.informe-agudeza-pio div').innerHTML = `
				OD: ${e.sublista.pio_od} - OI: ${e.sublista.pio_oi}
			`

		//fondo de ojo
		contenedor.querySelector('.informe-agudeza-fondo div').innerHTML = e.sublista.fondo_ojo.toUpperCase()

		//diagnosticos
		var diagnostico = JSON.parse(e.sublista.diagnosticos_procesados)
			diagnostico.forEach(d => {

				contenedor.querySelector('.informe-diagnosticos div').insertAdjacentHTML('beforeend',  `<span>${d.nombre}</span>`)

			})

		//plan
		var plan = JSON.parse(e.sublista.plan).texto_html
			contenedor.querySelector('.informe-plan div').innerHTML = plan.toUpperCase()


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
			rellenar.contenedores(informes.sublista, '.informe-valores', {elemento: e.target, id: 'value'}, {
				"contenedorConsulta": function fn(lista, grupo) {

					var peticion = tools.fullQuery('historias_informe', 'estandar_diagnosticos', lista)
					peticion.onreadystatechange = function() {
				        if (this.readyState == 4 && this.status == 200) {
				        	contenedoresReportes.estandarizarContenedor(grupo, JSON.parse(this.responseText), ['id_diagnostico', 'nombre'])
				        }
				    };		

				}
			})

			notificaciones.mensajeSimple('Datos cargados', false, 'V')

		}

	},
	/* -------------------------------------------------------------------------------------------------*/
	/*           					ENVIAR LOS DATOS PARA EDITAR LA INFORME   					    */
	/* -------------------------------------------------------------------------------------------------*/
	"editar": async (e) => {

		if (e.target.classList.contains('editar')) {

			informes.sublista = tools.pariente(e.target, 'TR').sublista

			tools.limpiar('.infeditar-valores', '', {})	

			rellenar.contenedores(informes.sublista, '.infeditar-valores', {elemento: e.target, id: 'value'}, {
				"contenedorConsulta": function fn(lista, grupo) {

					var peticion = tools.fullQuery('historias_informe', 'estandar_diagnosticos', lista)
					peticion.onreadystatechange = function() {
				        if (this.readyState == 4 && this.status == 200) {
				        	contenedoresReportes.estandarizarContenedor(grupo, JSON.parse(this.responseText), ['id_diagnostico', 'nombre'])
				        }
				    };		

				}
			})

			forPop.pop()

		}

	},
	/* -------------------------------------------------------------------------------------------------*/
	/*           				ENVIAR LOS DATOS PARA REIMPRIMIR EL INFORME 	  					    */
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
/*           								INFORME - NOTIFICAR	  								    */
/* -------------------------------------------------------------------------------------------------*/
qs('#informes-contenedor').identificador = 'informe'

qs("#informes-contenedor .reporte-notificar").addEventListener('click', async e => {

	if (window.procesar) {

		var elemento = qs('#informes-contenedor')

		window.procesar = false

		var datos = tools.procesar('', '', `${elemento.identificador}-valores`, tools, {"asociativa": true, "id": 'id_historia'});

		if (datos !== '') {
		
			notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'PROCESANDO')
			
			datos['id_historia'] =  historias.sublista.id_historia
			datos['nombres'] =  historias.sublista.nombres
			datos['apellidos'] = historias.sublista.apellidos
			datos['cedula'] = historias.sublista.cedula
			datos['fecha_nacimiento'] = historias.sublista.fecha_naci
			datos['diagnosticos'] = JSON.stringify(datos['diagnosticos'])

			var resultado = JSON.parse(await tools.fullAsyncQuery(`historias_notificaciones`, `notificar`, [datos, elemento.identificador], [["+", "%2B"]]))

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
/*           								INFORME - CARGAR	  								    */
/* -------------------------------------------------------------------------------------------------*/

qs("#informes-contenedor .reporte-cargar").addEventListener('click', async e => {

	if(window.procesar) {

		var elemento = qs('#informes-contenedor')

		window.procesar = false

		notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'PROCESANDO')

		var datos = tools.procesar('', '', `${elemento.identificador}-valores`, tools, {"asociativa": true, "id": 'id_historia'});

		if (datos !== '') {
			
			datos['id_historia'] =  historias.sublista.id_historia
			datos['nombres'] =  historias.sublista.nombres
			datos['apellidos'] = historias.sublista.apellidos
			datos['cedula'] = historias.sublista.cedula
			datos['fecha_nacimiento'] = historias.sublista.fecha_naci

			var resultado = JSON.parse(await tools.fullAsyncQuery(`historias_${elemento.identificador}`, `${elemento.identificador}_insertar`, [datos, historias.sublista.id_historia], [["+", "%2B"]]))

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
/*           							INFORME - PREVIA					  					    */
/* -------------------------------------------------------------------------------------------------*/
qs("#informes-contenedor .reporte-previa").addEventListener('click', async e => {

	if(window.procesar) {

		var elemento = qs('#informes-contenedor')

		window.procesar = false

		var datos = tools.procesar('', '', `${elemento.identificador}-valores`, tools, {"asociativa": true, "id": 'id_historia'});
		
		elemento.querySelector('.desplegable-iframe').src = ''

		if (datos !== '') {
		
			notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'PROCESANDO')
			
			datos['id_historia'] =  historias.sublista.id_historia
			datos['nombres'] =  historias.sublista.nombres
			datos['apellidos'] = historias.sublista.apellidos
			datos['cedula'] = historias.sublista.cedula
			datos['fecha_nacimiento'] = historias.sublista.fecha_naci

			if (typeof datos === 'object' && datos !== null) {

				var sesion = [ {"sesion": 'datos_pdf', "parametros": JSON.stringify(datos)} ]

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

				notificaciones.mensajeSimple('Error al procesar la petición', null, 'F')

			}

		}

	} else {

		notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'PROCESANDO')
		
	}

})

/* -------------------------------------------------------------------------------------------------*/
/*           							INFORME - EDITAR			 							    */
/* -------------------------------------------------------------------------------------------------*/
qs('#crud-infeditar-botones .confirmar').addEventListener('click', async e => {

	if(window.procesar) {

		notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'PROCESANDO')	

		var elemento = qs('#informes-contenedor')

		window.procesar = false

		var datos = tools.procesar('', '', `infeditar-valores`, tools, {});

		if (datos !== '') {

			var contenido = (typeof datos[1] === 'string') ? JSON.parse(datos[1]) : datos[1];
			var control   = (typeof datos[2] === 'string') ? JSON.parse(datos[2]) : datos[2];
			var motilidad = (typeof datos[15] === 'string') ? JSON.parse(datos[15]) : datos[15];
			var plan 	  = (typeof datos[33] === 'string') ? JSON.parse(datos[33]) : datos[33];

			informes.sublista.tipo          = datos[0]
			informes.sublista.contenido     = JSON.stringify(contenido)
			informes.sublista.control       = JSON.stringify(control)
			informes.sublista.agudeza_od_4  = datos[3]
			informes.sublista.agudeza_oi_4  = datos[4]
			informes.sublista.correccion_4  = datos[5]
			informes.sublista.agudeza_od_1  = datos[6]
			informes.sublista.agudeza_oi_1  = datos[7]
			informes.sublista.correccion_1  = datos[8]
			informes.sublista.agudeza_od_lectura  = datos[9]
			informes.sublista.agudeza_oi_lectura  = datos[10]
			informes.sublista.correccion_lectura  = datos[11]
			informes.sublista.estereopsis  = datos[12]
			informes.sublista.test  	   = datos[13]
			informes.sublista.reflejo  	   = datos[14]
			informes.sublista.motilidad    = JSON.stringify(motilidad)
			informes.sublista.rx_od_signo_1  = datos[16]
			informes.sublista.rx_od_valor_1  = datos[17]
			informes.sublista.rx_od_signo_2  = datos[18]
			informes.sublista.rx_od_valor_2  = datos[19]
			informes.sublista.rx_od_grados   = datos[20]
			informes.sublista.rx_od_resultado= datos[21]
			informes.sublista.rx_oi_signo_1  = datos[22]
			informes.sublista.rx_oi_valor_1  = datos[23]
			informes.sublista.rx_oi_signo_2  = datos[24]
			informes.sublista.rx_oi_valor_2  = datos[25]
			informes.sublista.rx_oi_grados   = datos[26]
			informes.sublista.rx_oi_resultado = datos[27]
			informes.sublista.biomicroscopia  = datos[28]
			informes.sublista.pio_od  	 	  = datos[29]
			informes.sublista.pio_oi  	 	  = datos[30]
			informes.sublista.fondo_ojo  	  = datos[31]
			informes.sublista.diagnosticos    = JSON.stringify(datos[32])
			informes.sublista.plan  		  = JSON.stringify(plan)

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
/*           							INFORME - ELIMINAR					 					    */
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

// /* -------------------------------------------------------------------------------------------------*/
// /*           						INFORME - MODELO					 					    	*/
// /* -------------------------------------------------------------------------------------------------*/
// var modelos = {
// 	"preoperatorio": {
// 		"informe": JSON.stringify({
// 			"texto_base": "FAVOR REALIZAR VALORACIÓN PEDIÁTRICA PREOPERATORIA, CURA QUIRÚRGICA DE ESTRABISMO CON ANESTESIA GENERAL.", 
// 			"texto_html": "FAVOR REALIZAR VALORACIÓN PEDIÁTRICA PREOPERATORIA, CURA QUIRÚRGICA DE ESTRABISMO CON ANESTESIA GENERAL."
// 		}),
// 		"titulo": "PREOPERATORIO"
// 	},
// 	"rx": {
// 		"informe": JSON.stringify({
// 			"texto_base": "FAVOR REALIZAR R(X) DE TORAX, PREOPERATORIO, CURA QUIRÚRGICA DE ESTRABISMO CON ANESTESIA.", 
// 			"texto_html": "FAVOR REALIZAR R(X) DE TORAX, PREOPERATORIO, CURA QUIRÚRGICA DE ESTRABISMO CON ANESTESIA."
// 		}),
// 		"titulo": "RX TORAX"
// 	},
// 	"cardiovascular": {
// 		"informe": JSON.stringify({
// 			"texto_base": "FAVOR REALIZAR VALORACIÓN CARDIOVASCULAR PREOPERATORIA, CURA QUIRÚRGICA DE ESTRABISMO CON ANESTESIA GENERAL.", 
// 			"texto_html": "FAVOR REALIZAR VALORACIÓN CARDIOVASCULAR PREOPERATORIA, CURA QUIRÚRGICA DE ESTRABISMO CON ANESTESIA GENERAL."
// 		}),
// 		"titulo": "VALORACIÓN CARDIOVASCULAR"
// 	},
// 	"pediatrica": {
// 		"informe": JSON.stringify({
// 			"texto_base": "FAVOR REALIZAR VALORACIÓN PEDIÁTRICA PREOPERATORIA, CURA QUIRÚRGICA DE ESTRABISMO CON ANESTESIA GENERAL.", 
// 			"texto_html": "FAVOR REALIZAR VALORACIÓN PEDIÁTRICA PREOPERATORIA, CURA QUIRÚRGICA DE ESTRABISMO CON ANESTESIA GENERAL."
// 		}),
// 		"titulo": "VALORACIÓN PEDIÁTRICA"
// 	}
// }

// qs('#informe-modelos').addEventListener('click', e=> {

//     if (e.target.tagName === 'BUTTON') {

//         rellenar.contenedores(modelos[e.target.dataset.identificador], '.informe-valores', {}, {})
        
//         notificaciones.mensajeSimple('Datos cargados', false, 'V')

//     }
    
// })