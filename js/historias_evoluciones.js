import {historias, tools, notificaciones} from '../js/historias.js';
import { Paginacion, Animaciones } from '../js/main.js';
import { Canvas } from '../js/dibujar.js';
import { Galeria } from '../js/galeria.js';

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

qsa('#crud-evoluciones-secciones button')[1].addEventListener('click', e => {
	paginacionEvoluciones.animacion(1, true)
})

/* -------------------------------------------------------------------------------------------------*/
/* ----------------------------------- CANVAS - BIOMICROSCOPIA --------------------------------------*/
/* -------------------------------------------------------------------------------------------------*/
window.imgBio = new Canvas('bio-imagen', 'bio-seleccionar', 'bio-remover', true)

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