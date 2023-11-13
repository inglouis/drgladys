import {historias, tools, notificaciones, evoluciones, evoluciones_notificadas, desplazar_evolucion } from '../js/historias.js';
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
		e.sublista.pruebas_od_1 = decodeURIComponent(e.sublista.pruebas_od_1)
		e.sublista.pruebas_od_2 = decodeURIComponent(e.sublista.pruebas_od_2)
		e.sublista.pruebas_od_3 = decodeURIComponent(e.sublista.pruebas_od_3)
		e.sublista.pruebas_od_4 = decodeURIComponent(e.sublista.pruebas_od_4)
		e.sublista.pruebas_od_5 = decodeURIComponent(e.sublista.pruebas_od_5)
		e.sublista.pruebas_od_6 = decodeURIComponent(e.sublista.pruebas_od_6)
		e.sublista.pruebas_od_7 = decodeURIComponent(e.sublista.pruebas_od_7)
		e.sublista.pruebas_od_8 = decodeURIComponent(e.sublista.pruebas_od_8)

		contenedor.querySelector('[data-template="pruebas_od_1"]').value = e.sublista.pruebas_od_1
		contenedor.querySelector('[data-template="pruebas_od_2"]').value = e.sublista.pruebas_od_2
		contenedor.querySelector('[data-template="pruebas_od_3"]').value = e.sublista.pruebas_od_3
		contenedor.querySelector('[data-template="pruebas_od_4"]').value = e.sublista.pruebas_od_4
		contenedor.querySelector('[data-template="pruebas_od_5"]').value = e.sublista.pruebas_od_5
		contenedor.querySelector('[data-template="pruebas_od_6"]').value = e.sublista.pruebas_od_6
		contenedor.querySelector('[data-template="pruebas_od_7"]').value = e.sublista.pruebas_od_7
		contenedor.querySelector('[data-template="pruebas_od_8"]').value = e.sublista.pruebas_od_8

		e.sublista.pruebas_oi_1 = decodeURIComponent(e.sublista.pruebas_oi_1)
		e.sublista.pruebas_oi_2 = decodeURIComponent(e.sublista.pruebas_oi_2)
		e.sublista.pruebas_oi_3 = decodeURIComponent(e.sublista.pruebas_oi_3)
		e.sublista.pruebas_oi_4 = decodeURIComponent(e.sublista.pruebas_oi_4)
		e.sublista.pruebas_oi_5 = decodeURIComponent(e.sublista.pruebas_oi_5)
		e.sublista.pruebas_oi_6 = decodeURIComponent(e.sublista.pruebas_oi_6)
		e.sublista.pruebas_oi_7 = decodeURIComponent(e.sublista.pruebas_oi_7)
		e.sublista.pruebas_oi_8 = decodeURIComponent(e.sublista.pruebas_oi_8)

		contenedor.querySelector('[data-template="pruebas_oi_1"]').value = e.sublista.pruebas_oi_1 
		contenedor.querySelector('[data-template="pruebas_oi_2"]').value = e.sublista.pruebas_oi_2 
		contenedor.querySelector('[data-template="pruebas_oi_3"]').value = e.sublista.pruebas_oi_3 
		contenedor.querySelector('[data-template="pruebas_oi_4"]').value = e.sublista.pruebas_oi_4 
		contenedor.querySelector('[data-template="pruebas_oi_5"]').value = e.sublista.pruebas_oi_5 
		contenedor.querySelector('[data-template="pruebas_oi_6"]').value = e.sublista.pruebas_oi_6 
		contenedor.querySelector('[data-template="pruebas_oi_7"]').value = e.sublista.pruebas_oi_7 
		contenedor.querySelector('[data-template="pruebas_oi_8"]').value = e.sublista.pruebas_oi_8 

		texto = JSON.parse(e.sublista.pruebas_nota).texto_html
		contenedor.querySelector('[data-template="pruebas-nota"] div').innerHTML = texto.toUpperCase()

		e.sublista.motilidad_od_1 = decodeURIComponent(e.sublista.motilidad_od_1)
		e.sublista.motilidad_od_2 = decodeURIComponent(e.sublista.motilidad_od_2)
		e.sublista.motilidad_od_3 = decodeURIComponent(e.sublista.motilidad_od_3)
		e.sublista.motilidad_od_4 = decodeURIComponent(e.sublista.motilidad_od_4)
		e.sublista.motilidad_od_5 = decodeURIComponent(e.sublista.motilidad_od_5)
		e.sublista.motilidad_od_6 = decodeURIComponent(e.sublista.motilidad_od_6)

		contenedor.querySelector('[data-template="motilidad_od_1"]').value = e.sublista.motilidad_od_1 
		contenedor.querySelector('[data-template="motilidad_od_2"]').value = e.sublista.motilidad_od_2 
		contenedor.querySelector('[data-template="motilidad_od_3"]').value = e.sublista.motilidad_od_3 
		contenedor.querySelector('[data-template="motilidad_od_4"]').value = e.sublista.motilidad_od_4 
		contenedor.querySelector('[data-template="motilidad_od_5"]').value = e.sublista.motilidad_od_5 
		contenedor.querySelector('[data-template="motilidad_od_6"]').value = e.sublista.motilidad_od_6 

		e.sublista.motilidad_oi_1 = decodeURIComponent(e.sublista.motilidad_oi_1)
		e.sublista.motilidad_oi_2 = decodeURIComponent(e.sublista.motilidad_oi_2)
		e.sublista.motilidad_oi_3 = decodeURIComponent(e.sublista.motilidad_oi_3)
		e.sublista.motilidad_oi_4 = decodeURIComponent(e.sublista.motilidad_oi_4)
		e.sublista.motilidad_oi_5 = decodeURIComponent(e.sublista.motilidad_oi_5)
		e.sublista.motilidad_oi_6 = decodeURIComponent(e.sublista.motilidad_oi_6)

		contenedor.querySelector('[data-template="motilidad_oi_1"]').value = e.sublista.motilidad_oi_1 
		contenedor.querySelector('[data-template="motilidad_oi_2"]').value = e.sublista.motilidad_oi_2 
		contenedor.querySelector('[data-template="motilidad_oi_3"]').value = e.sublista.motilidad_oi_3 
		contenedor.querySelector('[data-template="motilidad_oi_4"]').value = e.sublista.motilidad_oi_4 
		contenedor.querySelector('[data-template="motilidad_oi_5"]').value = e.sublista.motilidad_oi_5 
		contenedor.querySelector('[data-template="motilidad_oi_6"]').value = e.sublista.motilidad_oi_6 

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
		contenedor.querySelector('[data-template="altura_pupilar"] div').innerHTML = `OD:${e.sublista.altura_pupilar_od} - OI: ${e.sublista.altura_pupilar_oi}`
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

			if (!imagen.includes('init.txt')) {

				var div = th.div.cloneNode(true)
					div.classList.add('galeria-img')

				var img = th.img.cloneNode(true)
					img.src = imagen
					img.setAttribute('data-posicion', index)

				index++

				div.appendChild(img)

				contenedor.querySelector('[data-template="img-antes"]').appendChild(div)

			}

		})

		e.sublista.imagenes_despues_cirugia.forEach((imagen) => {

			if (!imagen.includes('init.txt')) {

				var div = th.div.cloneNode(true)
					div.classList.add('galeria-img')

				var img = th.img.cloneNode(true)
					img.src = imagen
					img.setAttribute('data-posicion', index)

				index++

				div.appendChild(img)

				contenedor.querySelector('[data-template="img-despues"]').appendChild(div)

			}

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

		var th = evoluciones,
			contenedor = historias.contenedorEliminarBoton.cloneNode(true)

		contenedor.setAttribute('data-hidden', '')
		contenedor.querySelector('.eliminar-boton').value = e.sublista.id

		e.querySelector('.crud-eliminar-contenedor').appendChild(contenedor)

		contenedor = e.querySelector('.eliminar-contenedor')
		
		e.addEventListener('mouseover', el => {

			if (el.target.classList.contains('eliminar')) {

				var coordenadas = e.querySelector('.eliminar').getBoundingClientRect()
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

			rellenar.contenedores(evoluciones.sublista, '.evoluciones-valores', {elemento: e.target, id: 'value'}, {
				"contenedorConsulta": function fn(lista, grupo) {

					if (grupo === 'cc-diagnosticos-evoluciones') {

						var peticion = tools.fullQuery('historias_informe', 'estandar_diagnosticos', lista)

						peticion.onreadystatechange = function() {
					        if (this.readyState == 4 && this.status == 200) {
					        	contenedoresEvoluciones.estandarizarContenedor(grupo, JSON.parse(this.responseText), ['id_diagnostico', 'nombre'])
					        }
					    };

					}

					if (grupo === 'cc-estudios-evoluciones') {

						var peticion = tools.fullQuery('historias_evoluciones', 'estandar_referencias', lista)

						peticion.onreadystatechange = function() {
					        if (this.readyState == 4 && this.status == 200) {
					        	contenedoresEvoluciones.estandarizarContenedor(grupo, JSON.parse(this.responseText), ['id_referencia', 'nombre'])
					        }
					    };

					}

					gid('evoluciones-fecha').value = window.dia
					imgBio.asignarImagenJSON('../imagenes/biomicroscopia.jpg', evoluciones.sublista.txt_bio)
					fondBio.asignarImagenJSON('../imagenes/biomicroscopia.jpg', evoluciones.sublista.txt_fondo)
					paginacionEvoluciones.animacion(0, true)

				}
			})

			notificaciones.mensajeSimple('Datos cargados', false, 'V')

		}

	},
	/* -------------------------------------------------------------------------------------------------*/
	/*           							NOTIFICAR EVOLUCIÓN										    */
	/* -------------------------------------------------------------------------------------------------*/
	"notificar": async (e) => {

		if (e.target.classList.contains('notificar')) {

			evoluciones.sublista = tools.pariente(e.target, 'TR').sublista

			var resultado = await tools.fullAsyncQuery('historias_evoluciones', 'notificar_evolucion', [evoluciones.sublista.id_evolucion])

			if (resultado.trim() === 'exito') {

				notificaciones.mensajeSimple('Evolución notificada con éxito', false, 'V')

			} else if (resultado.trim() === 'repetido') {

				notificaciones.mensajeSimple('Esta evolución ya fué notificada', false, 'F')

			} else {

				notificaciones.mensajeSimple('Error al procesar la petición', resultado, 'F')

			}

		}
	},
	/* -------------------------------------------------------------------------------------------------*/
	/*           								ELIMINAR 											    */
	/* -------------------------------------------------------------------------------------------------*/
	"eliminar": async(e) => {

		if (e.target.classList.contains('eliminar-boton')) {

			evoluciones.sublista = tools.pariente(e.target, 'TR').sublista

			var resultado = await tools.fullAsyncQuery('historias_evoluciones', 'eliminar_evolucion', [evoluciones.sublista.id_evolucion, evoluciones.sublista.id_historia])

			if (resultado.trim() === 'exito') {

				await evoluciones.traer_lista()

				notificaciones.mensajeSimple('Petición realiza con éxito', false, 'V')

			} else {

				notificaciones.mensajeSimple('Error al procesar la petición', resultado, 'F') 

			}

		}
		
	},
	/* -------------------------------------------------------------------------------------------------*/
	/*           								EDITAR 												    */
	/* -------------------------------------------------------------------------------------------------*/
	"editar": async (e) => {
		if (e.target.classList.contains('editar')) {

			evoluciones.sublista = tools.pariente(e.target, 'TR').sublista
			evoluciones.modalidad = 'editar'

			tools.limpiar('.evoluciones-valores', '', {})

			rellenar.contenedores(evoluciones.sublista, '.evoluciones-valores', {elemento: e.target, id: 'value'}, {
				"contenedorConsulta": function fn(lista, grupo) {

					if (grupo === 'cc-diagnosticos-evoluciones') {

						var peticion = tools.fullQuery('historias_informe', 'estandar_diagnosticos', lista)

						peticion.onreadystatechange = function() {
					        if (this.readyState == 4 && this.status == 200) {
					        	contenedoresEvoluciones.estandarizarContenedor(grupo, JSON.parse(this.responseText), ['id_diagnostico', 'nombre'])
					        }
					    };

					}

					if (grupo === 'cc-estudios-evoluciones') {

						var peticion = tools.fullQuery('historias_evoluciones', 'estandar_referencias', lista)

						peticion.onreadystatechange = function() {
					        if (this.readyState == 4 && this.status == 200) {
					        	contenedoresEvoluciones.estandarizarContenedor(grupo, JSON.parse(this.responseText), ['id_referencia', 'nombre'])
					        }
					    };

					}

					gid('evoluciones-fecha').value = window.dia
					imgBio.asignarImagenJSON('../imagenes/biomicroscopia.jpg', evoluciones.sublista.txt_bio)
					fondBio.asignarImagenJSON('../imagenes/biomicroscopia.jpg', evoluciones.sublista.txt_fondo)
					paginacionEvoluciones.animacion(0, true)

				}
			})

			notificaciones.mensajeSimple('Datos cargados', false, 'V')

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

imgBio.formaPersonalizada('dendritis', {fill: 'transparent', stroke: '#529b62', width: 0.3, height: 0.3, strokeWidth: 6.5, left: 185, top: 236 }, `M120.8602,63.449056q-35.096527,12.657935,1.231457,16.110097c-33.733296,1.493948-24.361628,9.178024-19.13719,12.65793c5.954242,4.009143,8.235845,6.572201,19.137189,5.41465c15.917545,2.858628,10.301356,7.253808-10.467384,14.147614s9.150424,6.306059,24.002112,9.876084-6.940727,9.16262-24.002112,15.137051s6.463382,11.089412,54.223099,12.978716c29.557498-2.378651,26.944529-10.507104,0-18.735085-6.85772-4.456182,8.674524-10.753465,21.258366-19.832125c9.604973-14.443615-3.017407-16.348224-30.841146-13.572255-6.26459-5.41465,9.58278-3.113205,9.58278-18.07258-20.111397,7.916884-34.124788,8.305147-25.873841-2.301445c4.656984-5.986552,17.376705-3.438281,16.291061-16.110098q-.307863-10.356493-35.40439,2.301445Z`)
imgBio.formaPersonalizada('ulceras_redondas', {fill: 'transparent', stroke: '#529b62', width: 1.5, height: 1.5, left: 156, top: 68}, `M-12.3293 0a12.3293 12.3293 0 1 0 24.6587 0a12.3293 12.3293 0 1 0 -24.6587 0`)
imgBio.formaPersonalizada('lente_intraocular', {fill: 'transparent', stroke: '#8d8d8d', width: 1, height: 1, left: 152, top: 56}, `
	M17.3293 30a12.3293 12.3293 0 1 0 24.6587 0a12.3293 12.3293 0 1 0 -24.6587 0 \
	M17.670667,30c-10.905211-6.154473-15.627304-20.125299,0-30 \
	M42.329333,30c10.640452,7.179181,13.221354,21.949768,0,30 \
	M24 30a6 6 0 1 0 12 0a6 6 0 1 0 -12 0
`)
imgBio.formaPersonalizada('congestion_ocular', {fill: 'transparent', stroke: '#ca3f3f', width: 0.8, height: 1.5, strokeWidth: 1.5, left: 95, top: 191}, `
	M0,1.933023h20.992004 /
	M0,4.933023h20.992004 /
	M0,23.933023h20.992004 /
	M0,26.933023h20.992004 /
	M0,29.933023h20.992004 /
	M-110,1.933023h20.992004 /
	M-110,4.933023h20.992004 /
	M-110,23.933023h20.992004 /
	M-110,26.933023h20.992004 /
	M-110,29.933023h20.992004 
`)
imgBio.formaPersonalizada('papilas_arriba', {top: 135, left: 30, fill: 'transparent', stroke: '#ca3f3f', width: 1.8, height: 1.7}, `
	M10,4c.423796,2.176743.686605,2.929212,1.806605,4.462512c1.5,1.836257,4.379268,1.774804,5.54,0c1.070963-1.53327.982978-1.974812,1.669311-4.462513 /
	M-5,6c.423796,2.176743.686605,2.929212,1.806605,4.462512c1.5,1.836257,4.379268,1.774804,5.54,0c1.070963-1.53327.982978-1.974812,1.669311-4.462513 /
    M-20,10c.423796,2.176743.686605,2.929212,1.806605,4.462512c1.5,1.836257,4.379268,1.774804,5.54,0c1.070963-1.53327.982978-1.974812,1.669311-4.462513 / 
    M-35,15c.423796,2.176743.686605,2.929212,1.806605,4.462512c1.5,1.836257,4.379268,1.774804,5.54,0c1.070963-1.53327.982978-1.974812,1.669311-4.462513 /
    M-50,23c.423796,2.176743.686605,2.929212,1.806605,4.462512c1.5,1.836257,4.379268,1.774804,5.54,0c1.070963-1.53327.982978-1.974812,1.669311-4.462513 /  
    M-65,30c.423796,2.176743.686605,2.929212,1.806605,4.462512c1.5,1.836257,4.379268,1.774804,5.54,0c1.070963-1.53327.982978-1.974812,1.669311-4.462513 /
    M-78,40c.423796,2.176743.686605,2.929212,1.806605,4.462512c1.5,1.836257,4.379268,1.774804,5.54,0c1.070963-1.53327.982978-1.974812,1.669311-4.462513 
`)
imgBio.formaPersonalizada('papilas_abajo', {top: 231, left: 48, fill: 'transparent', stroke: '#ca3f3f', width: 2.3, height: 1.7}, `
  	M60,25c.000383-2.099525.687491-4.315556,2.297012-4.892647.594924-.270683,1.803133-.294431,2.421697,0c1.868574.667539,1.978392,2.796979,2.199992,4.892647 /
    M50,24c.000383-2.099525.687491-4.315556,2.297012-4.892647.594924-.270683,1.803133-.294431,2.421697,0c1.868574.667539,1.978392,2.796979,2.199992,4.892647 /
    M40,22c.000383-2.099525.687491-4.315556,2.297012-4.892647.594924-.270683,1.803133-.294431,2.421697,0c1.868574.667539,1.978392,2.796979,2.199992,4.892647 /
    M30,18c.000383-2.099525.687491-4.315556,2.297012-4.892647.594924-.270683,1.803133-.294431,2.421697,0c1.868574.667539,1.978392,2.796979,2.199992,4.892647 /
    M20,13c.000383-2.099525.687491-4.315556,2.297012-4.892647.594924-.270683,1.803133-.294431,2.421697,0c1.868574.667539,1.978392,2.796979,2.199992,4.892647 /
    M10,8c.000383-2.099525.687491-4.315556,2.297012-4.892647.594924-.270683,1.803133-.294431,2.421697,0c1.868574.667539,1.978392,2.796979,2.199992,4.892647 /
    M0,0c.000383-2.099525.687491-4.315556,2.297012-4.892647.594924-.270683,1.803133-.294431,2.421697,0c1.868574.667539,1.978392,2.796979,2.199992,4.892647 
`)

imgBio.formaPersonalizada('cicatriz_linea_izquierda', {top: 175, left: 110, fill: 'transparent', stroke: 'black', width: 0.5, height: 0.5, strokeWidth: 3.5 }, `
  	M15,15l-30-30
`)

imgBio.formaPersonalizada('cicatriz_linea_derecha', {top: 175, left: 170, fill: 'transparent', stroke: 'black', width: 0.5, height: 0.5, strokeWidth: 3.5 }, `
  	M15,15l+30-30
`)

imgBio.formaPersonalizada('cicatriz_curva_izquierda', {top: 194, left: 97, fill: 'transparent', stroke: 'black', width: 0.5, height: 0.5, strokeWidth: 3.5 }, `
  	M55.331512,76.859199c0,0-13.299621,3.80734-20.331512,3.741496s-15.115352,1.834351-21.003112-3.741496-7.456833-22.105993-7.482992-31.859199s1.237851-26.072729,7.215743-31.478986s14.330499-2.876883,21.270361-2.672497s20.331512,2.672497,20.331512,2.672497
`)

imgBio.formaPersonalizada('cicatriz_curva_derecha', {top: 194, left: 174, fill: 'transparent', stroke: 'black', width: 0.5, height: 0.5, strokeWidth: 3.5 }, `
  	M39.486195,9.86556c9.080945-1.988472,21.755256-5.975467,30.457406,0s10.221826,23.159429,10.235686,35.13444-1.555871,29.357441-10.235686,35.267104-20.705831,2.007771-29.708454,0
`)

imgBio.formaPersonalizada('cataratas_1', {top: 88, left: 94, fill: 'transparent', stroke: 'black', width: 0.5, height: 0.5, strokeWidth: 2.5 }, `
  	M0,29.985638L9.873448,0L20,40L29.46694,0L40,29.985638
`)

imgBio.formaPersonalizada('cataratas_2', {top: 68, left: 94, fill: 'transparent', stroke: 'black', width: 0.5, height: 0.5, strokeWidth: 2.5 }, `
  	M-0.000002,9.910635L9.941195,40L19.999999,0L30.129545,40L39.999998,9.910635
`)

imgBio.formaPersonalizada('cataratas_3', {top: 75, left: 138, fill: 'transparent', stroke: 'black', width: 0.5, height: 0.5, strokeWidth: 2.5 }, `
  	M10.108489,0L40,10.15791L0,20l40,9.947408L10.108489,40
`)

imgBio.formaPersonalizada('cataratas_4', {top: 75, left: 192, fill: 'transparent', stroke: 'black', width: 0.5, height: 0.5, strokeWidth: 2.5 }, `
  	M29.897987,-0.000002L0,10.023287l40,9.976712L0,30.216652l29.897987,9.783346
`)

imgBio.formaPersonalizada('pliegues_epicantales_pronunciados', {top: 145, left: 161, fill: 'transparent', stroke: '#af3613', width: 1.3, height: 1.3, strokeWidth: 2.5 }, `
  	M10.264146,100c0,0,10.140372-34.701505,10.18871-50s-9.860042-50-9.860042-50 /
	M150.276741,0c0,0-10.18871,34.691738-10.18871,50s10.18871,50,10.18871,50 / 
	M+11.5,8.933023h135.992004 /
	M+16,26.933023h125.992004 /
	M+21,46.933023h118.992004 /
	M+17.5,64.933023h125.992004 /
	M+13,84.933023h132.992004 
`)

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
galeriaAntes._retardo = 1000

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
galeriaDespues._retardo = 1000

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

	if (e.target.classList.contains('evoluciones-confirmar') || e.target.classList.contains('evoluciones-notificar')) {

		if (window.procesar) {

			window.procesar = false

			window.idSeleccionada = 0

			var datos = tools.procesar(e.target, e.target.classList[0], 'evoluciones-valores', tools)

			if (datos !== '') {

				//datos['img_bio']  = imgBio.capturarImagenJSON()
				//datos['fond_bio'] = fondBio.capturarImagenJSON()

				datos.splice(datos.length, 0, imgBio.capturarImagenJSON())
				datos.splice(datos.length, 0, fondBio.capturarImagenJSON())
				
				datos.splice(datos.length, 0, imgBio.capturarImagen())
				datos.splice(datos.length, 0, fondBio.capturarImagen())
				datos[datos.length] = historias.sublista.id_historia

				window.idSeleccionada = historias.sublista.id_historia

				notificaciones.mensajePersonalizado('Procesando...', false, 'CLARO-1', 'PROCESANDO')

				if (evoluciones.modalidad === 'insertar') {

					var resultado = await tools.fullAsyncQuery('historias_evoluciones', 'cargar_evolucion', datos, [["+", "%2B"], ["'", "%27"]], undefined, true)

				} else if (evoluciones.modalidad === 'editar') {

					datos[datos.length] = evoluciones.sublista.id_evolucion

					var resultado = await tools.fullAsyncQuery('historias_evoluciones', 'editar_evolucion', datos, [["+", "%2B"], ["'", "%27"]], undefined, true)

				}

				if (!isNaN(resultado)) {

					notificaciones.mensajeSimple('Petición realiza con éxito', false, 'V')

					if (evoluciones.modalidad === 'insertar') {

						evoPop.pop()

					} else if (evoluciones.modalidad === 'editar') {

						evoluciones.modalidad = 'insertar'

						await evoluciones.traer_lista()

						tools.limpiar('.evoluciones-valores', '', {})
						tools.limpiar('.evoluciones-cargar', '', {})
						rellenar.contenedores(historias.sublista, '.evoluciones-cargar', {}, {})

						gid('evoluciones-fecha').value = window.dia
						window.galeriaAntes.limpiar()
						window.galeriaDespues.limpiar()

						imgBio.reiniciar()
						imgBio.asignarImagen('../imagenes/biomicroscopia.jpg')

						fondBio.reiniciar()
						fondBio.asignarImagen('../imagenes/fondo_ojo.jpg')

						paginacionEvoluciones.animacion(1, true)

					}

					if (e.target.classList.contains('evoluciones-notificar')) {

						await tools.fullAsyncQuery('historias_evoluciones', 'notificar_evolucion', [resultado])

					}
				
				} else if (String(resultado).trim() === 'repetido') {

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

// /* -------------------------------------------------------------------------------------------------*/
// /*           						EVOLUCIONES - INSERTAR					 				  	   */
// /* -------------------------------------------------------------------------------------------------*/

//-------------------------------------------------------------------------------
//botones que insertan datos básicos desde la edición o insersión de una historia
//-------------------------------------------------------------------------------
var insersiones_lista = ['estudios'],
	insersiones_lista_combos = [estPop]

var insersiones_procesado = {
	"estudios": (datos, lista, posicion) => {

		ultimoBotonInsersionBasica.parentElement.parentElement.querySelector('input').value = datos.toUpperCase()
		ultimoBotonInsersionBasica.parentElement.parentElement.querySelector('input').focus()

		tools.limpiar('.insertar-estudio', '', {})

		insersiones_lista_combos[posicion].pop()

		contenedoresReportes.reconstruirCombo(qs(`#cc-estudios-evoluciones select`), qs(`#cc-estudios-evoluciones input`), lista)
		contenedoresReportes.filtrarComboForzado(qs(`#cc-estudios-evoluciones select`), qs(`#cc-estudios-evoluciones input`), true)

		ultimoBotonInsersionBasica = ''

	}
}

insersiones_lista.forEach((grupo, i) => {

	qs(`#crud-insertar-${grupo}-botones`).addEventListener('click', async e => {

		if (e.target.classList.contains('insertar')) {

			var datos = tools.procesar('', '', `insertar-${grupo}`, tools)

			if (datos !== '') {

				datos.splice(1,1)

				if (grupo === 'estudios') {

					var resultado = await tools.fullAsyncQuery('referencias', `crear_referencias`, datos)

				} else {

					var resultado = await tools.fullAsyncQuery(`${grupo}`, `crear_${grupo}`, datos)

				}

				if(resultado.trim() === 'exito') {

					notificaciones.mensajeSimple(`${grupo.toUpperCase()} insertada con éxito`, resultado, 'V')

					setTimeout(async () => {

						if (grupo === 'estudios') {

							var lista = JSON.parse(await tools.fullAsyncQuery('combos', `combo_referencias`, []))

						} else {

							var lista = JSON.parse(await tools.fullAsyncQuery('combos', `combo_${grupo}`, []))

						}	

						insersiones_procesado[grupo](datos[0], lista, i)

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

qs('#evoluciones-nueva-estudio').addEventListener('click', e => {

	tools.limpiar('.insertar-estudios', '', {})

	estPop.pop()

	ultimoBotonInsersionBasica = e.target

})

qs('#evoluciones-nueva-diagnostico').addEventListener('click', e => {

	tools.limpiar('.insertar-diagnosticos', '', {})

	diaPop.pop()

	ultimoBotonInsersionBasica = e.target

})

//----------------------------------------------------------------------------------------------------
//									EVOLUCIONES NOTIFICADAS - PROPIEDADES                                          
//----------------------------------------------------------------------------------------------------
//voluciones_notificadas['crud'].cuerpo.push([evoluciones_notificadas['crud'].columna = evoluciones_notificadas['crud'].cuerpo.length, [evoluciones_notificadas['crud'].gSpan(null,null)], [false], ['HTML'], '', 2])

evoluciones_notificadas['crud'].cuerpo.push([evoluciones_notificadas['crud'].columna = evoluciones_notificadas['crud'].cuerpo.length, [
		evoluciones_notificadas['crud'].gSpan(null, null),
		evoluciones_notificadas['crud'].gSpan(null, null),
	], [135, 134], ['HTML', 'HTML'], '', false
])
evoluciones_notificadas['crud'].cuerpo.push([evoluciones_notificadas['crud'].columna = evoluciones_notificadas['crud'].cuerpo.length, [
		evoluciones_notificadas['crud'].gBt(['eliminar btn btn-eliminar', 'Confirmar revisión de la evolución'], `<svg style="width:10px; height: 10px" class="iconos" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><path fill="currentColor" d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"></path></svg>`)
	], [false], ['VALUE'], 'crud-botones', 0
])

evoluciones_notificadas.crud['ofv'] = true
evoluciones_notificadas['crud']['ofvh'] = 'auto';

evoluciones_notificadas['crud']['customBodyEvents'] = {
	/* -------------------------------------------------------------------------------------------------*/
	/*           								ELIMINAR 											    */
	/* -------------------------------------------------------------------------------------------------*/
	"eliminar": async (e) => {

		if (e.target.tagName === 'BUTTON') {

			if(e.target.classList.contains('eliminar')) {

				evoluciones_notificadas.sublista = tools.pariente(e.target, 'TR').sublista

				await tools.fullAsyncQuery('historias_evoluciones', 'notificaciones_evoluciones_revisado', [])

				await evoluciones_notificadas.cargarTabla(JSON.parse(await tools.fullAsyncQuery('historias_evoluciones', 'notificaciones_evoluciones_consultar', [])))
				
				notificaciones.mensajeSimple(`Revisión y uso de la evolución finalizado con éxito`, undefined, 'V')
			}

		}
	},
	/* -------------------------------------------------------------------------------------------------*/
	/*           								CONSULTAR 											    */
	/* -------------------------------------------------------------------------------------------------*/
	"consultar": async (e) => {

		if (e.target.tagName !== 'BUTTON') {

			if (!e.target.classList.contains('eliminar')) {

				evoluciones_notificadas.sublista = tools.pariente(e.target, 'TR').sublista

				tools.limpiar('.evolucion-desplazable-limpiar', '', {})

				desplazar_evolucion.abrir()

				//cabecera
				//------------------------------------------------
				evoluciones_notificadas.contenido.querySelector('.cabecera div').insertAdjacentHTML('afterbegin', evoluciones_notificadas.sublista.nombre_completo);

				//nota
				//------------------------------------------------
				(JSON.parse(evoluciones_notificadas.sublista.nota).texto_html === '') ? evoluciones_notificadas.contenido.querySelector('[data-consulta="nota"]').parentElement.setAttribute('data-hidden', '') : evoluciones_notificadas.contenido.querySelector('[data-consulta="nota_b_oi"]').parentElement.removeAttribute('data-hidden');

				evoluciones_notificadas.contenido.querySelector('[data-consulta="nota"]').insertAdjacentHTML('afterbegin', JSON.parse(evoluciones_notificadas.sublista.nota).texto_html);

				//examen oftalmológico
				//------------------------------------------------
				(evoluciones_notificadas.sublista.agudeza_od_4 === '' && evoluciones_notificadas.sublista.agudeza_oi_4 === '') ? (evoluciones_notificadas.contenido.querySelector('[data-consulta="agudeza_4"]').parentElement.setAttribute('data-hidden', ''), evoluciones_notificadas.contenido.querySelector('[data-consulta="agudeza_4_pruebas"]').parentElement.setAttribute('data-hidden', '')) : (evoluciones_notificadas.contenido.querySelector('[data-consulta="agudeza_4"]').parentElement.removeAttribute('data-hidden'), evoluciones_notificadas.contenido.querySelector('[data-consulta="agudeza_4_pruebas"]').parentElement.removeAttribute('data-hidden'));

				evoluciones_notificadas.contenido.querySelector('[data-consulta="agudeza_4"]').innerHTML = `OD: ${evoluciones_notificadas.sublista.agudeza_od_4} - OI: ${evoluciones_notificadas.sublista.agudeza_oi_4}`
				evoluciones_notificadas.contenido.querySelector('[data-consulta="agudeza_4_pruebas"]').insertAdjacentHTML('afterbegin', ((evoluciones_notificadas.sublista.correccion_4 === 'X') ? '<li>CORRECCIÓN</li>' : '')) 
				evoluciones_notificadas.contenido.querySelector('[data-consulta="agudeza_4_pruebas"]').insertAdjacentHTML('afterbegin', ((evoluciones_notificadas.sublista.allen_4 === 'X') ? '<li>ALLEN</li>' : '')) 
				evoluciones_notificadas.contenido.querySelector('[data-consulta="agudeza_4_pruebas"]').insertAdjacentHTML('afterbegin', ((evoluciones_notificadas.sublista.jagger_4 === 'X') ? '<li>JAGGER</li>' : '')) 
				evoluciones_notificadas.contenido.querySelector('[data-consulta="agudeza_4_pruebas"]').insertAdjacentHTML('afterbegin', ((evoluciones_notificadas.sublista.e_direccional_4 === 'X') ? '<li>E - DIRECCIONAL</li>' : '')) 
				evoluciones_notificadas.contenido.querySelector('[data-consulta="agudeza_4_pruebas"]').insertAdjacentHTML('afterbegin', ((evoluciones_notificadas.sublista.numeros_4 === 'X') ? '<li>NÚMEROS</li>' : '')) 
				evoluciones_notificadas.contenido.querySelector('[data-consulta="agudeza_4_pruebas"]').insertAdjacentHTML('afterbegin', ((evoluciones_notificadas.sublista.decimales_4 === 'X') ? '<li>DECIMALES</li>' : '')) 
				evoluciones_notificadas.contenido.querySelector('[data-consulta="agudeza_4_pruebas"]').insertAdjacentHTML('afterbegin', ((evoluciones_notificadas.sublista.fracciones_4 === 'X') ? '<li>FRACCIONES</li>' : '')) 
				evoluciones_notificadas.contenido.querySelector('[data-consulta="agudeza_4_pruebas"]').insertAdjacentHTML('afterbegin', ((evoluciones_notificadas.sublista.letras_4 === 'X') ? '<li>LETRAS</li>' : ''));

				(evoluciones_notificadas.sublista.agudeza_od_1 === '' && evoluciones_notificadas.sublista.agudeza_oi_1 === '') ? (evoluciones_notificadas.contenido.querySelector('[data-consulta="agudeza_1"]').parentElement.setAttribute('data-hidden', ''), evoluciones_notificadas.contenido.querySelector('[data-consulta="agudeza_1_pruebas"]').parentElement.setAttribute('data-hidden', '')) : (evoluciones_notificadas.contenido.querySelector('[data-consulta="agudeza_1"]').parentElement.removeAttribute('data-hidden'), evoluciones_notificadas.contenido.querySelector('[data-consulta="agudeza_1_pruebas"]').parentElement.removeAttribute('data-hidden'));
				
				evoluciones_notificadas.contenido.querySelector('[data-consulta="agudeza_1"]').innerHTML = `OD: ${evoluciones_notificadas.sublista.agudeza_od_1} - OI: ${evoluciones_notificadas.sublista.agudeza_oi_1}`
				evoluciones_notificadas.contenido.querySelector('[data-consulta="agudeza_1_pruebas"]').insertAdjacentHTML('afterbegin', ((evoluciones_notificadas.sublista.correccion_1 === 'X') ? '<li>CORRECCIÓN</li>' : '')) 
				evoluciones_notificadas.contenido.querySelector('[data-consulta="agudeza_1_pruebas"]').insertAdjacentHTML('afterbegin', ((evoluciones_notificadas.sublista.allen_1 === 'X') ? '<li>ALLEN</li>' : '')) 
				evoluciones_notificadas.contenido.querySelector('[data-consulta="agudeza_1_pruebas"]').insertAdjacentHTML('afterbegin', ((evoluciones_notificadas.sublista.jagger_1 === 'X') ? '<li>JAGGER</li>' : '')) 
				evoluciones_notificadas.contenido.querySelector('[data-consulta="agudeza_1_pruebas"]').insertAdjacentHTML('afterbegin', ((evoluciones_notificadas.sublista.e_direccional_1 === 'X') ? '<li>E - DIRECCIONAL</li>' : '')) 
				evoluciones_notificadas.contenido.querySelector('[data-consulta="agudeza_1_pruebas"]').insertAdjacentHTML('afterbegin', ((evoluciones_notificadas.sublista.numeros_1 === 'X') ? '<li>NÚMEROS</li>' : '')) 
				evoluciones_notificadas.contenido.querySelector('[data-consulta="agudeza_1_pruebas"]').insertAdjacentHTML('afterbegin', ((evoluciones_notificadas.sublista.decimales_1 === 'X') ? '<li>DECIMALES</li>' : '')) 
				evoluciones_notificadas.contenido.querySelector('[data-consulta="agudeza_1_pruebas"]').insertAdjacentHTML('afterbegin', ((evoluciones_notificadas.sublista.fracciones_1 === 'X') ? '<li>FRACCIONES</li>' : '')) 
				evoluciones_notificadas.contenido.querySelector('[data-consulta="agudeza_1_pruebas"]').insertAdjacentHTML('afterbegin', ((evoluciones_notificadas.sublista.letras_1 === 'X') ? '<li>LETRAS</li>' : ''));

				(evoluciones_notificadas.sublista.agudeza_od_lectura === '' && evoluciones_notificadas.sublista.agudeza_oi_lectura === '') ? (evoluciones_notificadas.contenido.querySelector('[data-consulta="agudeza_lectura"]').parentElement.setAttribute('data-hidden', ''), evoluciones_notificadas.contenido.querySelector('[data-consulta="agudeza_lectura_pruebas"]').parentElement.setAttribute('data-hidden', '')) : (evoluciones_notificadas.contenido.querySelector('[data-consulta="agudeza_lectura"]').parentElement.removeAttribute('data-hidden'), evoluciones_notificadas.contenido.querySelector('[data-consulta="agudeza_lectura_pruebas"]').parentElement.removeAttribute('data-hidden'));

				evoluciones_notificadas.contenido.querySelector('[data-consulta="agudeza_lectura"]').innerHTML = `OD: ${evoluciones_notificadas.sublista.agudeza_od_lectura} - OI: ${evoluciones_notificadas.sublista.agudeza_oi_lectura}`
				evoluciones_notificadas.contenido.querySelector('[data-consulta="agudeza_lectura_pruebas"]').insertAdjacentHTML('afterbegin', ((evoluciones_notificadas.sublista.correccion_lectura === 'X') ? '<li>CORRECCIÓN</li>' : '')) 
				evoluciones_notificadas.contenido.querySelector('[data-consulta="agudeza_lectura_pruebas"]').insertAdjacentHTML('afterbegin', ((evoluciones_notificadas.sublista.allen_lectura === 'X') ? '<li>ALLEN</li>' : '')) 
				evoluciones_notificadas.contenido.querySelector('[data-consulta="agudeza_lectura_pruebas"]').insertAdjacentHTML('afterbegin', ((evoluciones_notificadas.sublista.jagger_lectura === 'X') ? '<li>JAGGER</li>' : '')) 
				evoluciones_notificadas.contenido.querySelector('[data-consulta="agudeza_lectura_pruebas"]').insertAdjacentHTML('afterbegin', ((evoluciones_notificadas.sublista.e_direccional_lectura === 'X') ? '<li>E - DIRECCIONAL</li>' : '')) 
				evoluciones_notificadas.contenido.querySelector('[data-consulta="agudeza_lectura_pruebas"]').insertAdjacentHTML('afterbegin', ((evoluciones_notificadas.sublista.numeros_lectura === 'X') ? '<li>NÚMEROS</li>' : '')) 
				evoluciones_notificadas.contenido.querySelector('[data-consulta="agudeza_lectura_pruebas"]').insertAdjacentHTML('afterbegin', ((evoluciones_notificadas.sublista.decimales_lectura === 'X') ? '<li>DECIMALES</li>' : '')) 
				evoluciones_notificadas.contenido.querySelector('[data-consulta="agudeza_lectura_pruebas"]').insertAdjacentHTML('afterbegin', ((evoluciones_notificadas.sublista.fracciones_lectura === 'X') ? '<li>FRACCIONES</li>' : '')) 
				evoluciones_notificadas.contenido.querySelector('[data-consulta="agudeza_lectura_pruebas"]').insertAdjacentHTML('afterbegin', ((evoluciones_notificadas.sublista.letras_lectura === 'X') ? '<li>LETRAS</li>' : ''))

				evoluciones_notificadas.contenido.querySelector('[data-consulta="estereopsis"]').insertAdjacentHTML('afterbegin', ((evoluciones_notificadas.sublista.estereopsis !== '') ? `${evoluciones_notificadas.sublista.estereopsis} SEG` : '---'))
				evoluciones_notificadas.contenido.querySelector('[data-consulta="test"]').insertAdjacentHTML('afterbegin', ((evoluciones_notificadas.sublista.test !== '') ? evoluciones_notificadas.sublista.test : '---'))
				evoluciones_notificadas.contenido.querySelector('[data-consulta="reflejo"]').insertAdjacentHTML('afterbegin', ((evoluciones_notificadas.sublista.reflejo !== '') ? `${evoluciones_notificadas.sublista.reflejo} SEG` : '---'))

				evoluciones_notificadas.contenido.querySelector('[data-consulta="pruebas"]').insertAdjacentHTML('beforeend', evoluciones_pruebas[evoluciones_notificadas.sublista.pruebas]);

				//pruebas
				//------------------------------------------------
				(JSON.parse(evoluciones_notificadas.sublista.pruebas_nota).texto_html === '') ? evoluciones_notificadas.contenido.querySelector('[data-consulta="pruebas_nota"]').parentElement.setAttribute('data-hidden', '') : evoluciones_notificadas.contenido.querySelector('[data-consulta="pruebas_nota"]').parentElement.removeAttribute('data-hidden');
				(JSON.parse(evoluciones_notificadas.sublista.motilidad_nota).texto_html === '') ? evoluciones_notificadas.contenido.querySelector('[data-consulta="motilidad_nota"]').parentElement.setAttribute('data-hidden', '') : evoluciones_notificadas.contenido.querySelector('[data-consulta="motilidad_nota"]').parentElement.removeAttribute('data-hidden');

				evoluciones_notificadas.contenido.querySelector('[data-consulta="pruebas_nota"]').insertAdjacentHTML('afterbegin', JSON.parse(evoluciones_notificadas.sublista.pruebas_nota).texto_html) 
				evoluciones_notificadas.contenido.querySelector('[data-consulta="motilidad_nota"]').insertAdjacentHTML('afterbegin', JSON.parse(evoluciones_notificadas.sublista.motilidad_nota).texto_html);

				//rx
				//------------------------------------------------
				(evoluciones_notificadas.sublista.rx_od_valor_1 === '0.00' && evoluciones_notificadas.sublista.rx_oi_valor_1 === '0.00')  ? evoluciones_notificadas.contenido.querySelector('[data-consulta="rx"]').parentElement.setAttribute('data-hidden', '') : evoluciones_notificadas.contenido.querySelector('[data-consulta="rx"]').parentElement.removeAttribute('data-hidden');
				(evoluciones_notificadas.sublista.rx_od_valor_1_ciclo === '0.00' && evoluciones_notificadas.sublista.rx_oi_valor_1_ciclo === '0.00')  ? evoluciones_notificadas.contenido.querySelector('[data-consulta="rx_ciclo"]').parentElement.setAttribute('data-hidden', '') : evoluciones_notificadas.contenido.querySelector('[data-consulta="rx_ciclo"]').parentElement.removeAttribute('data-hidden');

				evoluciones_notificadas.contenido.querySelector('[data-consulta="rx"]').insertAdjacentHTML('afterbegin', `
					OD: ${evoluciones_signos[evoluciones_notificadas.sublista.rx_od_signo_1]}${evoluciones_notificadas.sublista.rx_od_valor_1} ${evoluciones_signos[evoluciones_notificadas.sublista.rx_od_signo_2]}${evoluciones_notificadas.sublista.rx_od_valor_2} X ${evoluciones_notificadas.sublista.rx_od_grados}° = ${evoluciones_notificadas.sublista.rx_od_resultado}
					<br>
					OI: ${evoluciones_signos[evoluciones_notificadas.sublista.rx_oi_signo_1]}${evoluciones_notificadas.sublista.rx_oi_valor_1} ${evoluciones_signos[evoluciones_notificadas.sublista.rx_oi_signo_2]}${evoluciones_notificadas.sublista.rx_oi_valor_2} X ${evoluciones_notificadas.sublista.rx_oi_grados}° = ${evoluciones_notificadas.sublista.rx_oi_resultado}
				`) 

				evoluciones_notificadas.contenido.querySelector('[data-consulta="rx_ciclo"]').insertAdjacentHTML('afterbegin', `
					OD: ${evoluciones_signos[evoluciones_notificadas.sublista.rx_od_signo_1_ciclo]}${evoluciones_notificadas.sublista.rx_od_valor_1_ciclo} ${evoluciones_signos[evoluciones_notificadas.sublista.rx_od_signo_2_ciclo]}${evoluciones_notificadas.sublista.rx_od_valor_2_ciclo} X ${evoluciones_notificadas.sublista.rx_od_grados_ciclo}° = ${evoluciones_notificadas.sublista.rx_od_resultado_ciclo}
					<br>
					OI: ${evoluciones_signos[evoluciones_notificadas.sublista.rx_oi_signo_1_ciclo]}${evoluciones_notificadas.sublista.rx_oi_valor_1_ciclo} ${evoluciones_signos[evoluciones_notificadas.sublista.rx_oi_signo_2_ciclo]}${evoluciones_notificadas.sublista.rx_oi_valor_2_ciclo} X ${evoluciones_notificadas.sublista.rx_oi_grados_ciclo}° = ${evoluciones_notificadas.sublista.rx_oi_resultado_ciclo}
				`);

				//biomicroscopia
				//------------------------------------------------
				(JSON.parse(evoluciones_notificadas.sublista.nota_b_od).texto_html === '') ? evoluciones_notificadas.contenido.querySelector('[data-consulta="nota_b_od"]').parentElement.setAttribute('data-hidden', '') : evoluciones_notificadas.contenido.querySelector('[data-consulta="nota_b_od"]').parentElement.removeAttribute('data-hidden');
				(JSON.parse(evoluciones_notificadas.sublista.nota_b_oi).texto_html === '') ? evoluciones_notificadas.contenido.querySelector('[data-consulta="nota_b_oi"]').parentElement.setAttribute('data-hidden', '') : evoluciones_notificadas.contenido.querySelector('[data-consulta="nota_b_oi"]').parentElement.removeAttribute('data-hidden');

				evoluciones_notificadas.contenido.querySelector('[data-consulta="nota_b_od"]').insertAdjacentHTML('afterbegin', JSON.parse(evoluciones_notificadas.sublista.nota_b_od).texto_html) 
				evoluciones_notificadas.contenido.querySelector('[data-consulta="nota_b_oi"]').insertAdjacentHTML('afterbegin', JSON.parse(evoluciones_notificadas.sublista.nota_b_oi).texto_html);

				//fondo de ojo
				//------------------------------------------------
				(JSON.parse(evoluciones_notificadas.sublista.nota_f_od).texto_html === '') ? evoluciones_notificadas.contenido.querySelector('[data-consulta="nota_f_od"]').parentElement.setAttribute('data-hidden', '') : evoluciones_notificadas.contenido.querySelector('[data-consulta="nota_f_od"]').parentElement.removeAttribute('data-hidden');
				(JSON.parse(evoluciones_notificadas.sublista.nota_f_oi).texto_html === '') ? evoluciones_notificadas.contenido.querySelector('[data-consulta="nota_f_oi"]').parentElement.setAttribute('data-hidden', '') : evoluciones_notificadas.contenido.querySelector('[data-consulta="nota_f_oi"]').parentElement.removeAttribute('data-hidden');

				evoluciones_notificadas.contenido.querySelector('[data-consulta="nota_f_od"]').insertAdjacentHTML('afterbegin', JSON.parse(evoluciones_notificadas.sublista.nota_f_od).texto_html) 
				evoluciones_notificadas.contenido.querySelector('[data-consulta="nota_f_oi"]').insertAdjacentHTML('afterbegin', JSON.parse(evoluciones_notificadas.sublista.nota_f_oi).texto_html);

				//pio, estudio, idx
				//------------------------------------------------
				(evoluciones_notificadas.sublista.pio_od === '0.00' && evoluciones_notificadas.sublista.pio_oi === '0.00')  ? evoluciones_notificadas.contenido.querySelector('[data-consulta="pio"]').parentElement.setAttribute('data-hidden', '') : evoluciones_notificadas.contenido.querySelector('[data-consulta="pio"]').parentElement.removeAttribute('data-hidden');

				evoluciones_notificadas.contenido.querySelector('[data-consulta="pio"]').innerHTML = `OD: ${evoluciones_notificadas.sublista.pio_od} mmHg - OI: ${evoluciones_notificadas.sublista.pio_oi} mmHg`

				var referencias = JSON.parse(evoluciones_notificadas.sublista.referencias_procesados),
					idx = JSON.parse(evoluciones_notificadas.sublista.diagnosticos_procesados);

				(referencias.length < 1) ? evoluciones_notificadas.contenido.querySelector('[data-consulta="referencias"]').parentElement.setAttribute('data-hidden', '') : evoluciones_notificadas.contenido.querySelector('[data-consulta="referencias"]').parentElement.removeAttribute('data-hidden');
				(idx.length < 1) ? evoluciones_notificadas.contenido.querySelector('[data-consulta="idx"]').parentElement.setAttribute('data-hidden', '') : evoluciones_notificadas.contenido.querySelector('[data-consulta="idx"]').parentElement.removeAttribute('data-hidden');

				referencias.forEach(valor => {
					evoluciones_notificadas.contenido.querySelector('[data-consulta="referencias"]').insertAdjacentHTML('afterbegin', `<li class="copiable">[${valor.nombre}]: ${valor.descripcion}</li>`)
				})

				idx.forEach(valor => {
					evoluciones_notificadas.contenido.querySelector('[data-consulta="idx"]').insertAdjacentHTML('afterbegin', `<li class="copiable">${valor.nombre}</li>`)
				});

				//formula
				//------------------------------------------------
				(evoluciones_notificadas.sublista.formula_od_signo_1_ciclo === '0.00' && evoluciones_notificadas.sublista.formula_oi_signo_1_ciclo === '0.00')  ? evoluciones_notificadas.contenido.querySelector('[data-consulta="formula"]').parentElement.setAttribute('data-hidden', '') : evoluciones_notificadas.contenido.querySelector('[data-consulta="formula"]').parentElement.removeAttribute('data-hidden');
				(evoluciones_notificadas.sublista.curva_od === '0.00' && evoluciones_notificadas.sublista.curva_oi === '0.00')  ? evoluciones_notificadas.contenido.querySelector('[data-consulta="curva"]').parentElement.setAttribute('data-hidden', '') : evoluciones_notificadas.contenido.querySelector('[data-consulta="curva"]').parentElement.removeAttribute('data-hidden');
				(evoluciones_notificadas.sublista.altura_pupilar_od === '0' && evoluciones_notificadas.sublista.altura_pupilar_oi === '0')  ? evoluciones_notificadas.contenido.querySelector('[data-consulta="altura_pupilar"]').parentElement.setAttribute('data-hidden', '') : evoluciones_notificadas.contenido.querySelector('[data-consulta="altura_pupilar"]').parentElement.removeAttribute('data-hidden');
				(evoluciones_notificadas.sublista.distancia_interpupilar_od === '0' && evoluciones_notificadas.sublista.distancia_interpupilar_oi === '0' && evoluciones_notificadas.sublista.distancia_interpupilar_add === '0' && evoluciones_notificadas.sublista.dip === '0')  ? evoluciones_notificadas.contenido.querySelector('[data-consulta="interpupilar"]').parentElement.setAttribute('data-hidden', '') : evoluciones_notificadas.contenido.querySelector('[data-consulta="interpupilar"]').parentElement.removeAttribute('data-hidden');

				evoluciones_notificadas.contenido.querySelector('[data-consulta="formula"]').insertAdjacentHTML('afterbegin', `
					OD: ${evoluciones_signos[evoluciones_notificadas.sublista.formula_od_signo_1_ciclo]}${evoluciones_notificadas.sublista.formula_od_valor_1_ciclo} ${evoluciones_signos[evoluciones_notificadas.sublista.formula_od_signo_2_ciclo]}${evoluciones_notificadas.sublista.formula_od_valor_2_ciclo} X ${evoluciones_notificadas.sublista.formula_od_grados_ciclo}°
					<br>
					OI: ${evoluciones_signos[evoluciones_notificadas.sublista.formula_oi_signo_1_ciclo]}${evoluciones_notificadas.sublista.formula_oi_valor_1_ciclo} ${evoluciones_signos[evoluciones_notificadas.sublista.formula_oi_signo_2_ciclo]}${evoluciones_notificadas.sublista.formula_oi_valor_2_ciclo} X ${evoluciones_notificadas.sublista.formula_oi_grados_ciclo}°
				`) 

				evoluciones_notificadas.contenido.querySelector('[data-consulta="curva"]').innerHTML = `OD: ${evoluciones_notificadas.sublista.curva_od} - OI: ${evoluciones_notificadas.sublista.curva_oi}`
				evoluciones_notificadas.contenido.querySelector('[data-consulta="altura_pupilar"]').innerHTML = `OD:${evoluciones_notificadas.sublista.altura_pupilar_od} - OI: ${evoluciones_notificadas.sublista.altura_pupilar_oi}`
				evoluciones_notificadas.contenido.querySelector('[data-consulta="interpupilar"]').innerHTML = `OD:${evoluciones_notificadas.sublista.distancia_interpupilar_od} - OI: ${evoluciones_notificadas.sublista.distancia_interpupilar_oi} - ADD: ${evoluciones_notificadas.sublista.distancia_interpupilar_add} - DIP: ${evoluciones_notificadas.sublista.dip}`

				evoluciones_notificadas.contenido.querySelector('[data-consulta="formula_estudios"]').insertAdjacentHTML('beforeend', ((evoluciones_notificadas.sublista.bifocal_kriptok !== '') ? `<li class="copiable">BIFOCAL KRIPTOK</li>` : ''))
				evoluciones_notificadas.contenido.querySelector('[data-consulta="formula_estudios"]').insertAdjacentHTML('beforeend', ((evoluciones_notificadas.sublista.multifocal !== '') ? `<li class="copiable">MULTIFOCAL</li>` : ''))
				evoluciones_notificadas.contenido.querySelector('[data-consulta="formula_estudios"]').insertAdjacentHTML('beforeend', ((evoluciones_notificadas.sublista.bifocal_flat_top !== '') ? `<li class="copiable">BIFOCAL FLAP TOP</li>` : ''))
				evoluciones_notificadas.contenido.querySelector('[data-consulta="formula_estudios"]').insertAdjacentHTML('beforeend', ((evoluciones_notificadas.sublista.bifocal_ejecutivo !== '') ? `<li class="copiable">BIFOCAL EJECUTIVO</li>` : ''))
				evoluciones_notificadas.contenido.querySelector('[data-consulta="formula_estudios"]').insertAdjacentHTML('beforeend', ((evoluciones_notificadas.sublista.bifocal_ultex !== '') ? `<li class="copiable">BIFOCAL ULTEX</li>` : ''));

				//plan
				//------------------------------------------------
				(JSON.parse(evoluciones_notificadas.sublista.plan).texto_html === '') ? evoluciones_notificadas.contenido.querySelector('[data-consulta="plan"]').parentElement.setAttribute('data-hidden', '') : evoluciones_notificadas.contenido.querySelector('[data-consulta="nota_b_oi"]').parentElement.removeAttribute('data-hidden');

				evoluciones_notificadas.contenido.querySelector('[data-consulta="plan"]').insertAdjacentHTML('afterbegin', JSON.parse(evoluciones_notificadas.sublista.plan).texto_html) 

				setTimeout(() => {
					qs('#desplegable-evoluciones-contenido').scrollTo(0,0)
				}, 10)

			}

		}

	}
}

evoluciones_notificadas['crud']['propiedadesTr'] = {
	"informacion": (e) => {
		var fr = new DocumentFragment(), th = evoluciones_notificadas
		var div = th.div.cloneNode(true);

		var d1 = th.div.cloneNode(true)
			d1.insertAdjacentHTML('afterbegin', `<b>N° DE EVOLUCION: </b>${e.sublista.id_evolucion}`)
			d1.setAttribute('style', `min-width:250px; color:#fff;  border-bottom: 1px solid #fff; margin-bottom: 5px`)

		div.appendChild(d1)

		var d1 = th.div.cloneNode(true)
			d1.insertAdjacentHTML('afterbegin', `<b>N° DE HISTORIA: </b> ${e.sublista.id_historia}`)
			d1.setAttribute('style', `min-width:250px; color:#fff`)


		div.appendChild(d1)

		div.setAttribute('style', `padding: 6px; width:fit-content; text-align: left;font-size: 1.1em; position:fixed; background:#262626`)
		div.setAttribute('title', 'Desplegar contenedor desplazable')
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

qs('#desplegable-evoluciones-desplazador-cerrar').addEventListener('click', e => {

	desplazar_evolucion.cerrar()

})

qs('#desplegable-evoluciones-contenido').addEventListener('click', e => {

	if (e.target.classList.contains('copiable')) {

		tools.copiarPortapapeles(e.target.innerHTML)
		notificaciones.mensajeSimple(`Contenido copiado al portapapeles`, undefined, 'V')

	}

})

/* -------------------------------------------------------------------------------------------------*/
/*           							ABRIR DESPLEGALBE 										    */
/* -------------------------------------------------------------------------------------------------*/
qs('#desplegable-abrir-evoluciones').addEventListener('click', async e => {

	//PETICION PARA ACTUALIZAR LISTA DE DATOS DE NOTIFIACION
	await evoluciones_notificadas.cargarTabla(JSON.parse(await tools.fullAsyncQuery('historias_evoluciones', 'notificaciones_evoluciones_consultar', [])))

	//QUITAR ALERTA
	e.target.classList.remove('notificacion-alerta')

})