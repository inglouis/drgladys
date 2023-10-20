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

var evoluciones_signos = {
	"X": '+',
	"": '-'
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
		var texto = JSON.parse(e.sublista.nota).texto_html
			contenedor.querySelector('[data-template="nota"] div').innerHTML = texto.toUpperCase()

		//examen oftalmológico
		//------------------------------------------------
		contenedor.querySelector('[data-template="agudeza_4"] div').innerHTML = `OD: ${e.sublista.agudeza_od_4} - OI: ${e.sublista.agudeza_oi_4}`
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

		contenedor.querySelector('[data-template="estereopsis"]').insertAdjacentHTML('beforeend', ((e.sublista.estereopsis !== '') ? `${e.sublista.estereopsis} SEG` : '---'))
		contenedor.querySelector('[data-template="test"]').insertAdjacentHTML('beforeend', ((e.sublista.test !== '') ? e.sublista.test : '---'))
		contenedor.querySelector('[data-template="reflejo"]').insertAdjacentHTML('beforeend', ((e.sublista.reflejo !== '') ? `${e.sublista.reflejo} SEG` : '---'))

		contenedor.querySelector('[data-template="pruebas"]').insertAdjacentHTML('beforeend', evoluciones_pruebas[e.sublista.pruebas])
		contenedor.querySelector('[data-template="pruebas_correccion"]').insertAdjacentHTML('beforeend', ((e.sublista.correccion_pruebas === 'X') ? 'SÍ' : 'NO')) 

		//pruebas
		//------------------------------------------------
		contenedor.querySelector('[data-template="pruebas_od_1"]').value = decodeURIComponent(e.sublista.pruebas_od_1)
		contenedor.querySelector('[data-template="pruebas_od_2"]').value = decodeURIComponent(e.sublista.pruebas_od_2)
		contenedor.querySelector('[data-template="pruebas_od_3"]').value = decodeURIComponent(e.sublista.pruebas_od_3)
		contenedor.querySelector('[data-template="pruebas_od_4"]').value = decodeURIComponent(e.sublista.pruebas_od_4)
		contenedor.querySelector('[data-template="pruebas_od_5"]').value = decodeURIComponent(e.sublista.pruebas_od_5)
		contenedor.querySelector('[data-template="pruebas_od_6"]').value = decodeURIComponent(e.sublista.pruebas_od_6)
		contenedor.querySelector('[data-template="pruebas_od_7"]').value = decodeURIComponent(e.sublista.pruebas_od_7)
		contenedor.querySelector('[data-template="pruebas_od_8"]').value = decodeURIComponent(e.sublista.pruebas_od_8)

		contenedor.querySelector('[data-template="pruebas_oi_1"]').value = decodeURIComponent(e.sublista.pruebas_oi_1)
		contenedor.querySelector('[data-template="pruebas_oi_2"]').value = decodeURIComponent(e.sublista.pruebas_oi_2)
		contenedor.querySelector('[data-template="pruebas_oi_3"]').value = decodeURIComponent(e.sublista.pruebas_oi_3)
		contenedor.querySelector('[data-template="pruebas_oi_4"]').value = decodeURIComponent(e.sublista.pruebas_oi_4)
		contenedor.querySelector('[data-template="pruebas_oi_5"]').value = decodeURIComponent(e.sublista.pruebas_oi_5)
		contenedor.querySelector('[data-template="pruebas_oi_6"]').value = decodeURIComponent(e.sublista.pruebas_oi_6)
		contenedor.querySelector('[data-template="pruebas_oi_7"]').value = decodeURIComponent(e.sublista.pruebas_oi_7)
		contenedor.querySelector('[data-template="pruebas_oi_8"]').value = decodeURIComponent(e.sublista.pruebas_oi_8)

		texto = JSON.parse(e.sublista.pruebas_nota).texto_html
		contenedor.querySelector('[data-template="pruebas-nota"] div').innerHTML = texto.toUpperCase()

		contenedor.querySelector('[data-template="motilidad_od_1"]').value = decodeURIComponent(e.sublista.motilidad_od_1)
		contenedor.querySelector('[data-template="motilidad_od_2"]').value = decodeURIComponent(e.sublista.motilidad_od_2)
		contenedor.querySelector('[data-template="motilidad_od_3"]').value = decodeURIComponent(e.sublista.motilidad_od_3)
		contenedor.querySelector('[data-template="motilidad_od_4"]').value = decodeURIComponent(e.sublista.motilidad_od_4)
		contenedor.querySelector('[data-template="motilidad_od_5"]').value = decodeURIComponent(e.sublista.motilidad_od_5)
		contenedor.querySelector('[data-template="motilidad_od_6"]').value = decodeURIComponent(e.sublista.motilidad_od_6)

		contenedor.querySelector('[data-template="motilidad_oi_1"]').value = decodeURIComponent(e.sublista.motilidad_oi_1)
		contenedor.querySelector('[data-template="motilidad_oi_2"]').value = decodeURIComponent(e.sublista.motilidad_oi_2)
		contenedor.querySelector('[data-template="motilidad_oi_3"]').value = decodeURIComponent(e.sublista.motilidad_oi_3)
		contenedor.querySelector('[data-template="motilidad_oi_4"]').value = decodeURIComponent(e.sublista.motilidad_oi_4)
		contenedor.querySelector('[data-template="motilidad_oi_5"]').value = decodeURIComponent(e.sublista.motilidad_oi_5)
		contenedor.querySelector('[data-template="motilidad_oi_6"]').value = decodeURIComponent(e.sublista.motilidad_oi_6)

		texto = JSON.parse(e.sublista.motilidad_nota).texto_html
		contenedor.querySelector('[data-template="motilidad-nota"] div').innerHTML = texto.toUpperCase()


		//rx
		//------------------------------------------------
		contenedor.querySelector('[data-template="rx"] div').insertAdjacentHTML('afterbegin', `
			OD: ${evoluciones_signos[e.sublista.rx_od_signo_1_ciclo]}${e.sublista.rx_od_valor_1_ciclo} ${evoluciones_signos[e.sublista.rx_od_signo_2_ciclo]}${e.sublista.rx_od_valor_2_ciclo} X ${e.sublista.rx_od_grados_ciclo}° = ${e.sublista.rx_od_resultado_ciclo}
			<br>
			OI: ${evoluciones_signos[e.sublista.rx_oi_signo_1_ciclo]}${e.sublista.rx_oi_valor_1_ciclo} ${evoluciones_signos[e.sublista.rx_oi_signo_2_ciclo]}${e.sublista.rx_oi_valor_2_ciclo} X ${e.sublista.rx_oi_grados_ciclo}° = ${e.sublista.rx_oi_resultado_ciclo}
		`) 

		contenedor.querySelector('[data-template="rx_ciclo"] div').insertAdjacentHTML('afterbegin', `
			OD: ${evoluciones_signos[e.sublista.rx_od_signo_1_ciclo]}${e.sublista.rx_od_valor_1_ciclo} ${evoluciones_signos[e.sublista.rx_od_signo_2_ciclo]}${e.sublista.rx_od_valor_2_ciclo} X ${e.sublista.rx_od_grados_ciclo}° = ${e.sublista.rx_od_resultado_ciclo}
			<br>
			OI: ${evoluciones_signos[e.sublista.rx_oi_signo_1_ciclo]}${e.sublista.rx_oi_valor_1_ciclo} ${evoluciones_signos[e.sublista.rx_oi_signo_2_ciclo]}${e.sublista.rx_oi_valor_2_ciclo} X ${e.sublista.rx_oi_grados_ciclo}° = ${e.sublista.rx_oi_resultado_ciclo}
		`) 

		//biomicroscopia
		//------------------------------------------------
		contenedor.querySelector('[data-template="biomicroscopia_img"] img').src = e.sublista.imagen_biomicroscopia

		texto = JSON.parse(e.sublista.nota_b_od).texto_html
		contenedor.querySelector('[data-template="nota_bio_od"] div').innerHTML = texto.toUpperCase()

		texto = JSON.parse(e.sublista.nota_b_oi).texto_html
		contenedor.querySelector('[data-template="nota_bio_oi"] div').innerHTML = texto.toUpperCase()

		//fondo de ojo
		//------------------------------------------------
		contenedor.querySelector('[data-template="fondo_img"] img').src = e.sublista.imagen_fondo_ojo

		texto = JSON.parse(e.sublista.nota_f_od).texto_html
		contenedor.querySelector('[data-template="nota_f_od"] div').innerHTML = texto.toUpperCase()

		texto = JSON.parse(e.sublista.nota_f_oi).texto_html
		contenedor.querySelector('[data-template="nota_f_oi"] div').innerHTML = texto.toUpperCase()

		//pio, estudio, idx
		//------------------------------------------------
		contenedor.querySelector('[data-template="pio"] div').innerHTML = `OD: ${e.sublista.pio_od} mmHg - OI: ${e.sublista.pio_oi} mmHg`

		var referencias = JSON.parse(e.sublista.referencias_procesados),
			idx = JSON.parse(e.sublista.diagnosticos_procesados)

		referencias.forEach(valor => {
			contenedor.querySelector('[data-template="referencias"] ul').insertAdjacentHTML('afterbegin', `[${valor.nombre}]: ${valor.descripcion}`)
		})

		idx.forEach(valor => {
			contenedor.querySelector('[data-template="idx"] ul').insertAdjacentHTML('afterbegin', valor.nombre)
		})

		//formula
		//------------------------------------------------
		contenedor.querySelector('[data-template="formula"] div').insertAdjacentHTML('afterbegin', `
			OD: ${evoluciones_signos[e.sublista.formula_od_signo_1_ciclo]}${e.sublista.formula_od_valor_1_ciclo} ${evoluciones_signos[e.sublista.formula_od_signo_2_ciclo]}${e.sublista.formula_od_valor_2_ciclo} X ${e.sublista.formula_od_grados_ciclo}°
			<br>
			OI: ${evoluciones_signos[e.sublista.formula_oi_signo_1_ciclo]}${e.sublista.formula_oi_valor_1_ciclo} ${evoluciones_signos[e.sublista.formula_oi_signo_2_ciclo]}${e.sublista.formula_oi_valor_2_ciclo} X ${e.sublista.formula_oi_grados_ciclo}°
		`) 

		contenedor.querySelector('[data-template="curva"] div').innerHTML = `OD: ${e.sublista.curva_od} - OI: ${e.sublista.curva_oi}`
		contenedor.querySelector('[data-template="intraocular"] div').innerHTML = `OD:${e.sublista.distancia_intraocular_od} - OI: ${e.sublista.distancia_intraocular_oi}`
		contenedor.querySelector('[data-template="interpupilar"] div').innerHTML = `OD:${e.sublista.distancia_interpupilar_od} - OI: ${e.sublista.distancia_interpupilar_oi} - ADD: ${e.sublista.distancia_interpupilar_add} - DIP: ${e.sublista.dip}`

		contenedor.querySelector('[data-template="formula_estudios"] ul').insertAdjacentHTML('beforeend', ((e.sublista.bifocal_kriptok !== '') ? `<li>BIFOCAL KRIPTOK</li>` : ''))
		contenedor.querySelector('[data-template="formula_estudios"] ul').insertAdjacentHTML('beforeend', ((e.sublista.multifocal !== '') ? `<li>MULTIFOCAL</li>` : ''))
		contenedor.querySelector('[data-template="formula_estudios"] ul').insertAdjacentHTML('beforeend', ((e.sublista.bifocal_flat_top !== '') ? `<li>BIFOCAL FLAP TOP</li>` : ''))
		contenedor.querySelector('[data-template="formula_estudios"] ul').insertAdjacentHTML('beforeend', ((e.sublista.bifocal_ejecutivo !== '') ? `<li>BIFOCAL EJECUTIVO</li>` : ''))
		contenedor.querySelector('[data-template="formula_estudios"] ul').insertAdjacentHTML('beforeend', ((e.sublista.bifocal_ultex !== '') ? `<li>BIFOCAL ULTEX</li>` : ''))

		texto = JSON.parse(e.sublista.plan).texto_html
		contenedor.querySelector('[data-template="plan"] div').innerHTML = texto.toUpperCase()

		//anexos
		//------------------------------------------------
		var index = 0

		e.sublista.imagenes_antes_cirugia.forEach((imagen) => {

			var div = th.div.cloneNode(true)
				div.classList.add('galeria-img')

			var img = th.img.cloneNode(true)
				img.src = imagen
				img.setAttribute('data-posicion', index)

			index++

			div.appendChild(img)

			contenedor.querySelector('[data-template="img-antes"]').appendChild(div)

		})

		e.sublista.imagenes_despues_cirugia.forEach((imagen) => {

			var div = th.div.cloneNode(true)
				div.classList.add('galeria-img')

			var img = th.img.cloneNode(true)
				img.src = imagen
				img.setAttribute('data-posicion', index)

			index++

			div.appendChild(img)

			contenedor.querySelector('[data-template="img-despues"]').appendChild(div)

		})

		contenedor.querySelector('[data-template="anexos_lentes_antes"]').insertAdjacentHTML('beforeend', ((e.sublista.anexos_antes_lentes === 'X') ? 'SÍ' : 'NO')) 
		contenedor.querySelector('[data-template="anexos_lentes_despues"]').insertAdjacentHTML('beforeend', ((e.sublista.anexos_despues_lentes === 'X') ? 'SÍ' : 'NO')) 


		//------------------------------------------------
		//------------------------------------------------
		e.querySelector('.evoluciones-contenedor').innerHTML = ''
		e.querySelector('.evoluciones-contenedor').appendChild(contenedor)

		
		th.imagenesExpandirCargar()

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

qs('#evoluciones-consultar-contenedor').addEventListener('click', e => {

	if (e.target.tagName === 'IMG') {

		if (e.target.parentElement.classList.contains('galeria-img')) {

			evoluciones.imagenesExpandirConfiguracion(Number(e.target.dataset.posicion));
			evoluciones.imagenesExpandirConstruir();

		}

	}

})
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

imgBio._fn['remover'] = () => {
	notificaciones.mensajeSimple('Objetos eliminados', false, 'V')
}

imgBio._fn['color'] = () => {
	notificaciones.mensajeSimple('Colores cambiados', false, 'V')
}

imgBio.asignarDibujadoInicial('black', 2)
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

fondBio._fn['remover'] = () => {
	notificaciones.mensajeSimple('Objetos eliminados', false, 'V')
}

fondBio._fn['color'] = () => {
	notificaciones.mensajeSimple('Color cambiado', false, 'V')
}

fondBio.asignarDibujadoInicial('black', 2)
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

				var resultado = await tools.fullAsyncQuery('historias_evoluciones', 'cargar_evolucion', datos, [["+", "%2B"], ["'", "%27"]], undefined, true)

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

	notificaciones.mensajePersonalizado('Cargando evolución...', false, 'CLARO-1', 'PROCESANDO')

	qs('#evoluciones-busqueda').value = e.target.value
    evoluciones.crud.botonForzar(true)

    setTimeout(() => {
		qs('#tabla-evoluciones-consultar-contenedor').scrollTo(0,0)
	}, 1000)

})