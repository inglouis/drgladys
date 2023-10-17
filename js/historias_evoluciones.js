import {historias, tools, notificaciones, evoluciones } from '../js/historias.js';
import { Paginacion, Animaciones } from '../js/main.js';
import { Canvas } from '../js/dibujar.js';
import { Galeria } from '../js/galeria.js';

/* -------------------------------------------------------------------------------------------------*/
/*           						EVOLUCIONES - PROPIEDADES				 					    */
/* -------------------------------------------------------------------------------------------------*/
evoluciones['crud'].generarColumnas(['gSpan', null, null], [false], ['HTML'], 'evoluciones-contenedor', 0)

evoluciones['crud']['ofv']  = true
evoluciones['crud']['ofvh'] = '68vh'

var evoluciones_pruebas = {
	"0": "COVER TEST (CT)",
	"1": "KRIMSKY TEST (KY)",
	"2": "HIRSCHBERG TEST (HT)"
}

/////////////////////////////////////////////////////
///
evoluciones['crud']['propiedadesTr'] = {
	"contenedor": (e) => {

		var contenedor = new DocumentFragment(),
			th = evoluciones, 
			contenido = th.contenido.cloneNode(true)

		
		contenedor.appendChild(contenido)

		//problematico
		contenedor.querySelector('[data-template="problematico"] input').title = (e.sublista.problematico === 'X') ? 'Aplica como paciente problemático' : 'NO aplica como paciente problemático';
		contenedor.querySelector('[data-template="problematico"] input').checked = (e.sublista.problematico === 'X') ? true : false;

		//nota
		var nota = JSON.parse(e.sublista.nota).texto_html
			contenedor.querySelector('[data-template="nota"] div').innerHTML = nota.toUpperCase()

		//examen oftalmológico
		contenedor.querySelector('[data-template="agudeza_4"] div').innerHTML = `OD:${e.sublista.agudeza_od_4} - OI: ${e.sublista.agudeza_oi_4}`
		contenedor.querySelector('[data-template="agudeza_4_pruebas"] ul').insertAdjacentHTML('afterbegin', ((e.sublista.correccion_4 === 'X') ? '<li>CORRECCIÓN</li>' : '')) 
		contenedor.querySelector('[data-template="agudeza_4_pruebas"] ul').insertAdjacentHTML('afterbegin', ((e.sublista.allen_4 === 'X') ? '<li>ALLEN</li>' : '')) 
		contenedor.querySelector('[data-template="agudeza_4_pruebas"] ul').insertAdjacentHTML('afterbegin', ((e.sublista.jagger_4 === 'X') ? '<li>JAGGER</li>' : '')) 
		contenedor.querySelector('[data-template="agudeza_4_pruebas"] ul').insertAdjacentHTML('afterbegin', ((e.sublista.e_direccional_4 === 'X') ? '<li>E - DIRECCIONAL</li>' : '')) 
		contenedor.querySelector('[data-template="agudeza_4_pruebas"] ul').insertAdjacentHTML('afterbegin', ((e.sublista.numeros_4 === 'X') ? '<li>NÚMEROS</li>' : '')) 
		contenedor.querySelector('[data-template="agudeza_4_pruebas"] ul').insertAdjacentHTML('afterbegin', ((e.sublista.decimales_4 === 'X') ? '<li>DECIMALES</li>' : '')) 
		contenedor.querySelector('[data-template="agudeza_4_pruebas"] ul').insertAdjacentHTML('afterbegin', ((e.sublista.fracciones_4 === 'X') ? '<li>FRACCIONES</li>' : '')) 
		contenedor.querySelector('[data-template="agudeza_4_pruebas"] ul').insertAdjacentHTML('afterbegin', ((e.sublista.letras_4 === 'X') ? '<li>LETRAS</li>' : ''))

		contenedor.querySelector('[data-template="agudeza_1"] div').innerHTML = `OD:${e.sublista.agudeza_od_4} - OI: ${e.sublista.agudeza_oi_1}`
		contenedor.querySelector('[data-template="agudeza_1_pruebas"] ul').insertAdjacentHTML('afterbegin', ((e.sublista.correccion_1 === 'X') ? '<li>CORRECCIÓN</li>' : '')) 
		contenedor.querySelector('[data-template="agudeza_1_pruebas"] ul').insertAdjacentHTML('afterbegin', ((e.sublista.allen_1 === 'X') ? '<li>ALLEN</li>' : '')) 
		contenedor.querySelector('[data-template="agudeza_1_pruebas"] ul').insertAdjacentHTML('afterbegin', ((e.sublista.jagger_1 === 'X') ? '<li>JAGGER</li>' : '')) 
		contenedor.querySelector('[data-template="agudeza_1_pruebas"] ul').insertAdjacentHTML('afterbegin', ((e.sublista.e_direccional_1 === 'X') ? '<li>E - DIRECCIONAL</li>' : '')) 
		contenedor.querySelector('[data-template="agudeza_1_pruebas"] ul').insertAdjacentHTML('afterbegin', ((e.sublista.numeros_1 === 'X') ? '<li>NÚMEROS</li>' : '')) 
		contenedor.querySelector('[data-template="agudeza_1_pruebas"] ul').insertAdjacentHTML('afterbegin', ((e.sublista.decimales_1 === 'X') ? '<li>DECIMALES</li>' : '')) 
		contenedor.querySelector('[data-template="agudeza_1_pruebas"] ul').insertAdjacentHTML('afterbegin', ((e.sublista.fracciones_1 === 'X') ? '<li>FRACCIONES</li>' : '')) 
		contenedor.querySelector('[data-template="agudeza_1_pruebas"] ul').insertAdjacentHTML('afterbegin', ((e.sublista.letras_1 === 'X') ? '<li>LETRAS</li>' : '')) 

		contenedor.querySelector('[data-template="agudeza_lectura"] div').innerHTML = `OD:${e.sublista.agudeza_od_4} - OI: ${e.sublista.agudeza_oi_lectura}`
		contenedor.querySelector('[data-template="agudeza_lectura_pruebas"] ul').insertAdjacentHTML('afterbegin', ((e.sublista.correccion_lectura === 'X') ? '<li>CORRECCIÓN</li>' : '')) 
		contenedor.querySelector('[data-template="agudeza_lectura_pruebas"] ul').insertAdjacentHTML('afterbegin', ((e.sublista.allen_lectura === 'X') ? '<li>ALLEN</li>' : '')) 
		contenedor.querySelector('[data-template="agudeza_lectura_pruebas"] ul').insertAdjacentHTML('afterbegin', ((e.sublista.jagger_lectura === 'X') ? '<li>JAGGER</li>' : '')) 
		contenedor.querySelector('[data-template="agudeza_lectura_pruebas"] ul').insertAdjacentHTML('afterbegin', ((e.sublista.e_direccional_lectura === 'X') ? '<li>E - DIRECCIONAL</li>' : '')) 
		contenedor.querySelector('[data-template="agudeza_lectura_pruebas"] ul').insertAdjacentHTML('afterbegin', ((e.sublista.numeros_lectura === 'X') ? '<li>NÚMEROS</li>' : '')) 
		contenedor.querySelector('[data-template="agudeza_lectura_pruebas"] ul').insertAdjacentHTML('afterbegin', ((e.sublista.decimales_lectura === 'X') ? '<li>DECIMALES</li>' : '')) 
		contenedor.querySelector('[data-template="agudeza_lectura_pruebas"] ul').insertAdjacentHTML('afterbegin', ((e.sublista.fracciones_lectura === 'X') ? '<li>FRACCIONES</li>' : '')) 
		contenedor.querySelector('[data-template="agudeza_lectura_pruebas"] ul').insertAdjacentHTML('afterbegin', ((e.sublista.letras_lectura === 'X') ? '<li>LETRAS</li>' : '')) 

		contenedor.querySelector('[data-template="estereopsis"]').insertAdjacentHTML('beforeend', ((e.sublista.estereopsis !== '') ? e.sublista.estereopsis : '---'))
		contenedor.querySelector('[data-template="test"]').insertAdjacentHTML('beforeend', ((e.sublista.test !== '') ? e.sublista.test : '---'))
		contenedor.querySelector('[data-template="reflejo"]').insertAdjacentHTML('beforeend', ((e.sublista.reflejo !== '') ? e.sublista.reflejo : '---'))

		contenedor.querySelector('[data-template="pruebas"]').insertAdjacentHTML('beforeend', evoluciones_pruebas[e.sublista.pruebas])
		contenedor.querySelector('[data-template="pruebas_correccion"]').insertAdjacentHTML('beforeend', ((e.sublista.correccion_pruebas === 'X') ? 'SÍ' : 'NO')) 

		e.querySelector('.evoluciones-contenedor').innerHTML = ''
		e.querySelector('.evoluciones-contenedor').appendChild(contenedor)

		// //tipo
		// contenedor.querySelectorAll('.informe-tipo option').forEach((el, i) => {
		// 	if (el.value === e.sublista.tipo) {
		// 		el.parentElement.selectedIndex = i
		// 	}
		// })

		// if (e.sublista.tipo !== '1') {
		// 	contenedor.querySelector('.informe-aplica-completo').setAttribute('data-hidden', '')
		// }

		// //contenido
		// var contenido = JSON.parse(e.sublista.contenido).texto_html
		// 	contenedor.querySelector('.informe-contenido div').innerHTML = contenido.toUpperCase()

		// //agudeza 4
		// contenedor.querySelector('.informe-agudeza-4 span').innerHTML = `OD: ${e.sublista.agudeza_od_4.toUpperCase()} - OI: ${e.sublista.agudeza_oi_4.toUpperCase()}`
		// contenedor.querySelector('.informe-agudeza-4 input').checked = (e.sublista.correccion_4 === 'X') ? true : false;

		// //agudeza 1
		// contenedor.querySelector('.informe-agudeza-1 span').innerHTML = `OD: ${e.sublista.agudeza_od_1.toUpperCase()} - OI: ${e.sublista.agudeza_oi_1.toUpperCase()}`
		// contenedor.querySelector('.informe-agudeza-1 input').checked = (e.sublista.correccion_1 === 'X') ? true : false;

		// //agudeza lectura
		// contenedor.querySelector('.informe-agudeza-lectura span').innerHTML = `OD: ${e.sublista.agudeza_od_lectura.toUpperCase()} - OI: ${e.sublista.agudeza_oi_lectura.toUpperCase()}`
		// contenedor.querySelector('.informe-agudeza-lectura input').checked = (e.sublista.correccion_lectura === 'X') ? true : false;

		// //pruebas
		// contenedor.querySelector('.informe-test div').innerHTML = `Estereopsis: ${e.sublista.estereopsis}S - Ishihara: ${e.sublista.test} - Stereo Fly: ${e.sublista.reflejo}`

		// //motilidad
		

		// //rx
		// contenedor.querySelector('.rx-cicloplegia').checked = (e.sublista.rx_cicloplegia === 'X') ? true : false;

		// contenedor.querySelectorAll('.informe-rx div')[0].innerHTML = 
		// 	`
		// 		OD: ${(e.sublista.rx_od_signo_1 === 'X') ? '+' : '-'}
		// 			${e.sublista.rx_od_valor_1} 
		// 			${(e.sublista.rx_od_signo_2 === 'X') ? '+' : '-'}
		// 			${e.sublista.rx_od_valor_2} X
		// 			${e.sublista.rx_od_grados}° = 
		// 			${e.sublista.rx_od_resultado}
		// 	`

		// contenedor.querySelectorAll('.informe-rx div')[1].innerHTML = 
		// 	`
		// 		OI: &nbsp;&nbsp;${(e.sublista.rx_oi_signo_1 === 'X') ? '+' : '-'}
		// 			${e.sublista.rx_oi_valor_1} 
		// 			${(e.sublista.rx_oi_signo_2 === 'X') ? '+' : '-'}
		// 			${e.sublista.rx_oi_valor_2} X
		// 			${e.sublista.rx_oi_grados}° = 
		// 			${e.sublista.rx_oi_resultado}
		// 	`

		// //biomicroscopia
		// var bio = JSON.parse(e.sublista.biomicroscopia).texto_html
		// 	contenedor.querySelector('.informe-bio div').innerHTML = bio.toUpperCase()

		// //PIO
		// contenedor.querySelector('.informe-pio div').innerHTML = `
		// 		OD: ${e.sublista.pio_od} - OI: ${e.sublista.pio_oi}
		// 	`

		// //fondo de ojo
		// var fondo = JSON.parse(e.sublista.fondo_ojo).texto_html
		// 	contenedor.querySelector('.informe-fondo div').innerHTML = fondo.toUpperCase()

		// //diagnosticos
		// var diagnostico = JSON.parse(e.sublista.diagnosticos_procesados)
		// 	diagnostico.forEach(d => {

		// 		contenedor.querySelector('.informe-diagnosticos div').insertAdjacentHTML('beforeend',  `<span>${d.nombre}</span>`)

		// 	})

		// //plan
		// var plan = JSON.parse(e.sublista.plan).texto_html
		// 	contenedor.querySelector('.informe-plan div').innerHTML = plan.toUpperCase()


		// contenedor.querySelector('.nombre').insertAdjacentHTML('afterbegin', `<b>- Nombre:</b> ${e.sublista.nombres}`)
		// contenedor.querySelector('.apellido').insertAdjacentHTML('afterbegin', `<b>- Apellido:</b> ${e.sublista.apellidos}`)
		// contenedor.querySelector('.cedula').insertAdjacentHTML('afterbegin', `<b>- Cédula/pasaporte:</b> ${e.sublista.cedula}`)
		// contenedor.querySelector('.edad').insertAdjacentHTML('afterbegin', `<b>- Edad:</b> ${tools.calcularFecha(new Date(e.sublista.fecha_nacimiento))}`)

	},
	"eliminar": (e) => {
		// var th = informes,
		// 	contenedor = historias.contenedorEliminarBoton.cloneNode(true)

		// contenedor.setAttribute('data-hidden', '')
		// contenedor.querySelector('.eliminar-boton').value = e.sublista.id

		// e.querySelector('.crud-eliminar-contenedor').appendChild(contenedor)

		// contenedor = e.querySelector('.eliminar-contenedor')
		
		// e.addEventListener('mouseover', el => {

		// 	if (el.target.classList.contains('eliminar')) {
		// 		var coordenadas = e.querySelector('.eliminar').getBoundingClientRect()
		// 		//contenedor.setAttribute('style', `left: ${coordenadas.left - 310}px`)
		// 		contenedor.removeAttribute('data-hidden')	
		// 	}	

		// })

		// e.querySelector('.eliminar').addEventListener('mouseleave', el => {
		// 	if (!contenedor.matches(':hover')) {
		// 		contenedor.setAttribute('data-hidden', '')
		// 	}
		// })

		// contenedor.addEventListener('mouseleave', el => {
		// 	contenedor.setAttribute('data-hidden', '')
		// })

	}
}
/////////////////////////////////////////////////////
///
evoluciones['crud']['customBodyEvents'] = {
	/* -------------------------------------------------------------------------------------------------*/
	/*           								  MODELO 											    */
	/* -------------------------------------------------------------------------------------------------*/
	"modelo": async (e) => {

		if (e.target.classList.contains('modelo')) {

			evoluciones.sublista = tools.pariente(e.target, 'TR').sublista

			evolucionModeloSeleccionado = tools.copiaLista(evoluciones.sublista)

			notificaciones.mensajeSimple('Modelo copiado', false, 'V')

		}

	},
	/* -------------------------------------------------------------------------------------------------*/
	/*           								REUTILIZAR 											    */
	/* -------------------------------------------------------------------------------------------------*/
	"reusar": async (e) => {

		if (e.target.classList.contains('reusar')) {

			evoluciones.sublista = tools.pariente(e.target, 'TR').sublista

			tools.limpiar('.evoluciones-valores', '', {})
			rellenar.contenedores(informes.sublista, '.evoluciones-valores', {elemento: e.target, id: 'value'}, {
				"contenedorConsulta": function fn(lista, grupo) {

					if (grupo === 'diagnosticos') {

						var peticion = tools.fullQuery('evoluciones', 'estandar_diagnosticos', lista)

						peticion.onreadystatechange = function() {
					        if (this.readyState == 4 && this.status == 200) {
					        	contenedoresReportes.estandarizarContenedor(grupo, JSON.parse(this.responseText), ['id_diagnostico', 'nombre'])
					        }
					    };

					}

					if (grupo === 'referencias') {

						var peticion = tools.fullQuery('evoluciones', 'estandar_referencias', lista)

						peticion.onreadystatechange = function() {
					        if (this.readyState == 4 && this.status == 200) {
					        	contenedoresReportes.estandarizarContenedor(grupo, JSON.parse(this.responseText), ['id_referencia', 'nombre'])
					        }
					    };

					}

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

			// evoluciones.sublista = tools.pariente(e.target, 'TR').sublista

			// tools.limpiar('.evoluciones-valores', '', {})	

			// rellenar.contenedores(informes.sublista, '.evoluciones-valores', {elemento: e.target, id: 'value'}, {
			// 	"contenedorConsulta": function fn(lista, grupo) {

			// 		var peticion = tools.fullQuery('historias_informe', 'estandar_diagnosticos', lista)
			// 		peticion.onreadystatechange = function() {
			// 	        if (this.readyState == 4 && this.status == 200) {
			// 	        	contenedoresReportes.estandarizarContenedor(grupo, JSON.parse(this.responseText), ['id_diagnostico', 'nombre'])
			// 	        }
			// 	    };		

			// 	}
			// })

			// forPop.pop()

		}

	}
};


(async () => {

	evoluciones.cargarTabla([], undefined, undefined)
	evoluciones['crud'].botonBuscar('evoluciones-buscar', false)

})()


/* -------------------------------------------------------------------------------------------------*/
/* -----------------------------------PAGINACIÓN DE REPORTES----------------------------------------*/
/* -------------------------------------------------------------------------------------------------*/
window.paginacionEvoluciones = new Paginacion(
	{"contenedores": ".evoluciones-seccion" ,"familia": '[data-familia]', "efecto": ['izquierda-1', 'derecha-1'], "delay": 100},
	[
		{},
		{}
	]
)

qsa('#crud-evoluciones-secciones button')[0].addEventListener('click', e => {
	paginacionEvoluciones.animacion(0, true)
})

qsa('#crud-evoluciones-secciones button')[1].addEventListener('click', async e => {
	paginacionEvoluciones.animacion(1, true)
})

/* -------------------------------------------------------------------------------------------------*/
/* ----------------------------------- CANVAS - BIOMICROSCOPIA --------------------------------------*/
/* -------------------------------------------------------------------------------------------------*/
window.imgBio = new Canvas('bio-imagen', 'bio-seleccionar', 'bio-remover', true)

imgBio._formato['width']  = 513
imgBio._formato['height'] = 309

imgBio.asignarImagen('../imagenes/biomicroscopia.jpg')

imgBio.asignarDibujadoInicial('black', 5)
imgBio.asignarDibujados('.bio-dibujar')
imgBio.asignarGrosores('.bio-slider')
imgBio.asignarTexto('bio-texto')

imgBio.formaPersonalizada('bio-forma-1', {fill: 'transparent', stroke: 'black'}, `M120.8602,63.449056q-35.096527,12.657935,1.231457,16.110097c-33.733296,1.493948-24.361628,9.178024-19.13719,12.65793c5.954242,4.009143,8.235845,6.572201,19.137189,5.41465c15.917545,2.858628,10.301356,7.253808-10.467384,14.147614s9.150424,6.306059,24.002112,9.876084-6.940727,9.16262-24.002112,15.137051s6.463382,11.089412,54.223099,12.978716c29.557498-2.378651,26.944529-10.507104,0-18.735085-6.85772-4.456182,8.674524-10.753465,21.258366-19.832125c9.604973-14.443615-3.017407-16.348224-30.841146-13.572255-6.26459-5.41465,9.58278-3.113205,9.58278-18.07258-20.111397,7.916884-34.124788,8.305147-25.873841-2.301445c4.656984-5.986552,17.376705-3.438281,16.291061-16.110098q-.307863-10.356493-35.40439,2.301445Z`)

////////////////////////////////////////////////////////////////////////////////////////////////
qs('#bio-valor').innerHTML = qs('#bio-rango').value
////////////////////////////////////////////////////////////////////////////////////////////////
qs('#bio-rango').addEventListener('input', e => {

    qs('#bio-valor').innerHTML = e.target.value

})
////////////////////////////////////////////////////////////////////////////////////////////////
qs('#bio-reiniciar').addEventListener('click', e => {
	imgBio.reiniciar()
	imgBio.asignarImagen('../imagenes/biomicroscopia.jpg')
})

/* -------------------------------------------------------------------------------------------------*/
/* ----------------------------------- CANVAS - FONDO DE OJO ---------------------------------------*/
/* -------------------------------------------------------------------------------------------------*/
window.fondBio = new Canvas('fondo-imagen', 'fondo-seleccionar', 'fondo-remover', true)

fondBio._formato['width']  = 513
fondBio._formato['height'] = 309

fondBio.asignarImagen('../imagenes/fondo_ojo.jpg')

fondBio.asignarDibujadoInicial('black', 5)
fondBio.asignarDibujados('.fondo-dibujar')
fondBio.asignarGrosores('.fondo-slider')
fondBio.asignarTexto('fondo-texto')

fondBio.formaPersonalizada('fondo-forma-1', {fill: 'transparent', stroke: 'black'}, `M120.8602,63.449056q-35.096527,12.657935,1.231457,16.110097c-33.733296,1.493948-24.361628,9.178024-19.13719,12.65793c5.954242,4.009143,8.235845,6.572201,19.137189,5.41465c15.917545,2.858628,10.301356,7.253808-10.467384,14.147614s9.150424,6.306059,24.002112,9.876084-6.940727,9.16262-24.002112,15.137051s6.463382,11.089412,54.223099,12.978716c29.557498-2.378651,26.944529-10.507104,0-18.735085-6.85772-4.456182,8.674524-10.753465,21.258366-19.832125c9.604973-14.443615-3.017407-16.348224-30.841146-13.572255-6.26459-5.41465,9.58278-3.113205,9.58278-18.07258-20.111397,7.916884-34.124788,8.305147-25.873841-2.301445c4.656984-5.986552,17.376705-3.438281,16.291061-16.110098q-.307863-10.356493-35.40439,2.301445Z`)

////////////////////////////////////////////////////////////////////////////////////////////////
qs('#fondo-valor').innerHTML = qs('#bio-rango').value
////////////////////////////////////////////////////////////////////////////////////////////////
qs('#fondo-rango').addEventListener('input', e => {

    qs('#fondo-valor').innerHTML = e.target.value

})
////////////////////////////////////////////////////////////////////////////////////////////////
qs('#fondo-reiniciar').addEventListener('click', e => {
	fondBio.reiniciar()
	fondBio.asignarImagen('../imagenes/fondo_ojo.jpg')
})
////////////////////////////////////////////////////////////////////////////////////////////////
//COMO CAPTURAR LAS IMAGENES
// qs('#bio-capturar').addEventListener('click', function () {
 
//     console.log(imgBio.capturarImagen())
//     console.log(imgBio.capturarImagenJSON())

// });

/* -------------------------------------------------------------------------------------------------*/
/* --------------------------------------- SALTAR PAGINA -------------------------------------------*/
/* -------------------------------------------------------------------------------------------------*/
var secciones = qsa('#crud-evoluciones-contenedor .radios input'),
	saltos = qsa('#crud-evoluciones-contenedor .evoluciones-saltar'),
	contenedor = qs('#crud-evoluciones-contenedor .filas')

saltos[0]['altura'] = 122.546875
saltos[1]['altura'] = 431.546875
saltos[2]['altura'] = 1345.546875
saltos[3]['altura'] = 1672.546875
saltos[4]['altura'] = 2137.546875
saltos[5]['altura'] = 2653.546875
saltos[6]['altura'] = 2916.546875
saltos[7]['altura'] = 3216.546875

////////////////////////////////////////////////////////////////////////////////////////////////
qsa('#crud-evoluciones-contenedor .radios input').forEach((radios, i) => {

	radios.addEventListener('click', e => {

		saltos[i]['altura'] = saltos[i].getBoundingClientRect().top + contenedor.scrollTop - 170

		contenedor.scrollTo(0, 0)
		contenedor.scrollTo(0, saltos[i]['altura'])

	})

})
////////////////////////////////////////////////////////////////////////////////////////////////
contenedor.addEventListener("scroll", e => {

    const scrollContenedor = contenedor.scrollTop + 80

    secciones.forEach((seccion, i) => {

    	var maximo = undefined

    	if (saltos[i + 1]) {

    		maximo = saltos[i + 1]

    	} else {

    		maximo = saltos[i]

    	}

    	if (scrollContenedor > saltos[i]['altura'] && scrollContenedor < maximo['altura']) {

    		seccion.checked = true

    	} else {

    		if (scrollContenedor > saltos[i]['altura']) {

				seccion.checked = true

    		} else {

    			seccion.checked = false

    		}

    	}

    })
});

/* -------------------------------------------------------------------------------------------------*/
/*           					  NOTIFICACIONES - TEXTAREAS PREVIAS	 						    */
/* -------------------------------------------------------------------------------------------------*/

qs(`#crud-evoluciones-contenedor .cargar`).addEventListener('mouseenter', e => {

	qs(`#crud-evoluciones-contenedor .personalizacion-c`).removeAttribute('data-hidden')	

})

qs(`#crud-evoluciones-contenedor .cargar`).addEventListener('mouseleave', e => {

	qs(`#crud-evoluciones-contenedor .personalizacion-c`).setAttribute('data-hidden', '')

})


/* -------------------------------------------------------------------------------------------------*/
/* ------------------------------------------- CONSEJOS --------------------------------------------*/
/* -------------------------------------------------------------------------------------------------*/
var animaciones = new Animaciones({on: 'aparecer', off: 'desaparecer'})
	animaciones.hider = 'data-hidden'
	animaciones.generar('#crud-evoluciones-aconsejar', ['#crud-evoluciones-consejos'])

/* -------------------------------------------------------------------------------------------------*/
/* ------------------------------------------- ANEXOS ----------------------------------------------*/
/* -------------------------------------------------------------------------------------------------*/

//ANTES
/////////////////////////////////////////////////////////////////////////////////////////////////////
window.galeriaAntes = new Galeria('#anexos-antes-cargar', '#anexos-antes-contenedor')

galeriaAntes._pswp = '.pswp1'
galeriaAntes._rutaImagenes = '#anexos-antes-contenedor .galeria-img img'
galeriaAntes._retardo = 3000

qs('#anexos-antes-cargar').addEventListener('change', () => {

	galeriaAntes.cargar()

})

qs('#anexos-antes-contenedor').addEventListener('change', e => {

	if (e.target.tagName === 'SELECT') {

		galeriaAntes.reposicionar(e.target)

	}

})

qs('#anexos-antes-contenedor').addEventListener('click', e => {

	if (e.target.tagName === 'IMG') {

		galeriaAntes.imagenesExpandirConfiguracion(Number(e.target.dataset.posicion), '.galeria-img');
		galeriaAntes.imagenesExpandirConstruir();

	}

})

//DESPUES
/////////////////////////////////////////////////////////////////////////////////////////////////////
window.galeriaDespues = new Galeria('#anexos-despues-cargar', '#anexos-despues-contenedor')

galeriaDespues._pswp = '.pswp2'
galeriaDespues._rutaImagenes = '#anexos-despues-contenedor .galeria-img img'
galeriaDespues._retardo = 3000

qs('#anexos-despues-cargar').addEventListener('change', () => {

	galeriaDespues.cargar()

})

qs('#anexos-despues-contenedor').addEventListener('change', e => {

	if (e.target.tagName === 'SELECT') {

		galeriaDespues.reposicionar(e.target)

	}

})

qs('#anexos-despues-contenedor').addEventListener('click', e => {

	if (e.target.tagName === 'IMG') {

		galeriaDespues.imagenesExpandirConfiguracion(Number(e.target.dataset.posicion), '.galeria-img');
		galeriaDespues.imagenesExpandirConstruir();

	}

})

//"img".src = URL.createObjectURL("input".files[0])
//https://stackoverflow.com/questions/29477906/send-photo-from-javascript-to-php
//https://stackoverflow.com/questions/54888848/multiple-images-upload-using-javascript-php-mysql ----> ESTA TIENE MEJOR PINTA EN AYUDAR

/* -------------------------------------------------------------------------------------------------*/
/*   		Evento que envia los datos al metodo de javascript que hace la peticion*                */
/* -------------------------------------------------------------------------------------------------*/
qs('#crud-evoluciones-botones').addEventListener('click', async e => {

	if(e.target.classList.contains('evoluciones-confirmar')) {

		if(window.procesar) {

			window.procesar = false

			var datos = tools.procesar(e.target, 'evoluciones-confirmar', 'evoluciones-valores', tools)

			if (datos !== '') {

				//datos['img_bio']  = imgBio.capturarImagenJSON()
				//datos['fond_bio'] = fondBio.capturarImagenJSON()

				datos.splice(datos.length - 1, 0, imgBio.capturarImagenJSON())
				datos.splice(datos.length - 1, 0, fondBio.capturarImagenJSON())
				
				datos.splice(datos.length - 1, 0, imgBio.capturarImagen())
				datos.splice(datos.length - 1, 0, fondBio.capturarImagen())

				notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'PROCESANDO')

				var resultado = await tools.fullAsyncQuery('historias_evoluciones', 'cargar_evolucion', datos, [["+", "%2B"]], undefined, true)

				//console.log(resultado)

				if (resultado.trim() === 'exito') {

					notificaciones.mensajeSimple('Petición realiza con éxito', false, 'V')

					evoPop.pop()

					//historias.tr.sublista = JSON.parse(await tools.fullAsyncQuery('historias', 'traer_historia', [historias.sublista.id_historia]))

					//historias.confirmarActualizacion()
				
				} else if (resultado.trim() === 'repetido') {

					notificaciones.mensajeSimple('Una evolución ya fué cargada hoy para este paciente', resultado, 'F') 

				} else {

					notificaciones.mensajeSimple('Error al procesar la petición', resultado, 'F')

				}

			}

		} else {

			notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'PROCESANDO')
			
		}
	}
})

/* -------------------------------------------------------------------------------------------------*/
/*   							EVENTOS GENERALES DE LAS EVOLUCIONES     					        */
/* -------------------------------------------------------------------------------------------------*/
qs('#evoluciones-consulta-fechas select').addEventListener('change', e => {

	qs('#evoluciones-busqueda').value = e.target.value
    evoluciones.crud.botonForzar(true)

})