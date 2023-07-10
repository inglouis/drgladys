import  {Tabla} from '../js/crud.js';
import  {Acciones, Herramientas, paginaCargada, Rellenar, Reportes, customDesplegable, Animaciones} from '../js/main.js';

// const indice = new customDesplegable('desplegable-indice', 'desplegable-abrir-indice', 'desplegable-cerrar-indice')
// indice.eventos()

const tools = new Herramientas()
/////////////////////////////////////////////////////
window.qs    = document.querySelector.bind(document)
window.qsa   = document.querySelectorAll.bind(document)
/////////////////////////////////////////////////////
window.procesar = true;
window.idEliminar = 0
window.idSeleccionada = 0
/////////////////////////////////////////////////////
window.rellenar = new Rellenar()
window.reportes = new Reportes()
/////////////////////////////////////////////////////
window.animaciones = new Animaciones({on: 'aparecer', off: 'desaparecer'})
window.animaciones.hider = 'data-hidden'
window.animaciones.delay = 1500
/////////////////////////////////////////////////////
window.animaciones.forzarDisparoSalida('#spinner', '.paginas-contenedor')
/////////////////////////////////////////////////////
setTimeout(() => {
	qs('#spinner').remove()
}, 3000)
/////////////////////////////////////////////////////
//window.mouse = {}
//onmousemove = function(e){mouse = {"x": e.clientX, "y": e.clientY}}

//---------------------------------------------------------------------------------//
//								CALCULO DE LA FECHA DE DÍA
//---------------------------------------------------------------------------------//
var fecha = new Date()
qs('#inicio-bienvenida-fecha').innerHTML = fecha.toLocaleDateString('es-CA',{timeZone: "America/Caracas", weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })

//---------------------------------------------------------------------------------//
//								CONVERSIONES DEL DIA
//---------------------------------------------------------------------------------//
window.monedas = JSON.parse(await tools.fullAsyncQuery('index', 'monedas', []))

var fr = new DocumentFragment()

monedas.forEach(e => {
	
		var div = document.createElement('div')
			var span = document.createElement('span')
				span.insertAdjacentText('afterbegin', `${e.nombre}: `)

			div.appendChild(span)

			var span = document.createElement('span')
				span.insertAdjacentText('afterbegin', e.conver)
				span.setAttribute('style', 'color: #198754; text-shadow: 0px 0px 2px #03a9f4;')

			div.appendChild(span)

		fr.appendChild(div)

})

qs('#index-conversiones').appendChild(fr)

//----------------------------------------------------------------------------------------------------
//										E V E N T O S                                                
//----------------------------------------------------------------------------------------------------

/* -------------------------------------------------------------------------------------------------*/	
//                      eventos exclusivos de el archivo js
/* -------------------------------------------------------------------------------------------------*/
var procesarWebb = true

qs('#webb').addEventListener('click', e => {

	if (procesarWebb) {

		qs('.panel-body').setAttribute('style', 'padding: 50px;padding-top: 20px;background: url(../imagenes/webb.jpg);background-repeat: repeat-y;background-position: center;display: flex;box-sizing: border-box;background-blend-mode: exclusion;')
		qs('#inicio-titulo').setAttribute('style', 'position: relative; color: #fff')
		qs('#webb svg').setAttribute('style', 'width: 18px;color: #fff !important;')

		var div = `<div id="webb-celebracion"><a target="_blank" href="https://www.nasa.gov/webbfirstimages">¡Celebrando la primera imagen del satélite James Webb publicada el 11 de junio de 2022!</a></div>`

		qs('#inicio-bienvenida').insertAdjacentHTML('afterbegin', div)

		procesarWebb = false

	} else {

		qs('.panel-body').setAttribute('style', 'background: #f1f1f1; padding: 50px; padding-top: 20px;')
		qs('#inicio-titulo').setAttribute('style', 'position: relative;')
		qs('#webb svg').setAttribute('style', 'width: 18px;')
		qs('#webb-celebracion').remove()
    	
		procesarWebb = true

	}

})
