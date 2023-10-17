import { Herramientas } from '../js/main.js';
export const tools = new Herramientas()
/////////////////////////////////////////////////////////////
window.qs    = document.querySelector.bind(document)
window.qsa   = document.querySelectorAll.bind(document)
window.gid = document.getElementById.bind(document)
/////////////////////////////////////////////////////////////
class Galeria {

	constructor(selector, contenedor) {

		(qs(selector)) ? this._selector = qs(selector) : console.log('SELECTOR  OBLIGATORIO');
		(qs(contenedor)) ? this._contenedor = qs(contenedor) : console.log('CONTENEDOR  OBLIGATORIO');

		this._estructuraPropiedades = {
			"class": "galeria-img"
		}

		this._select = undefined
		this._ruta = '../imagenes/anexos/'
		this._retardo = 3000

		/////////////////////////////////////////////////////////////
		this.div = document.createElement('div')
		this.img = document.createElement('img')
		this.select = document.createElement('select')
		this.option = document.createElement('option')
		/////////////////////////////////////////////////////////////
		this._opciones = {}
		this._imagenes = []
		this._rutaImagenes = '#galeria-contenedor .galeria-img img'
		this._pswp = '.pswp'
		
	}

	//----------------------------------------------------------------
	copiaLista (aObject) {
		if (!aObject) {
			return aObject;
		}

		let v;
		let bObject = Array.isArray(aObject) ? [] : {};

		for (const k in aObject) {
			v = aObject[k];
			bObject[k] = (typeof v === "object") ? this.copiaLista(v) : v;
		}

		return bObject;
	}

	estructura(longitud, imagen, posicion) {

		var contenedor = this.div.cloneNode(true);
			contenedor.setAttribute('class', this._estructuraPropiedades['class'])			

			var img = this.img.cloneNode(true)
				img.setAttribute('src', URL.createObjectURL(imagen))
				img.setAttribute('data-posicion', posicion)

			var select = this._select.cloneNode(true)
				select.selectedIndex = posicion
				select['indexPrevio'] = select.selectedIndex+""


		contenedor.appendChild(img)
		contenedor.appendChild(select)

		return contenedor

	}

	cargar() {

		var th = this,
			fr = new DocumentFragment(),
			longitud = Object.keys(this._selector.files),
			select = this.select.cloneNode(true)


		//------------------------------------------------------
		this._select = undefined

		longitud.forEach(index => {

			var option = th.option.cloneNode(true)
				option.setAttribute('value', index)
				option.insertAdjacentHTML('afterbegin', (Number(index) + 1))

			select.appendChild(option)

		})

		this._select = select

		//------------------------------------------------------
		longitud.forEach(index => {
		    
		    fr.appendChild(th.estructura(longitud.length, th._selector.files[index], index))
		    
		})
		//------------------------------------------------------
		this._contenedor.innerHTML = ''
		this._contenedor.appendChild(fr)
		//------------------------------------------------------
		this.imagenesExpandirCargar()

	}

	async limpiar() {

		this._selector.value = ''

		var cola = []

		cola.push(this.retardar().then(x => {}));
		cola.push(this.retardar().then(x => {}));

		await Promise.all(cola);

		this.cargar()

	}

	///////////////////////////////////////////////////////////////////////////////////////
	async retardar() {

		var th = this

		return new Promise((resolve, reject) => {
			setTimeout(resolve, th._retardo);
		});
	}

	async buscarImagenRuta(src, fileName, mimeType){
        return (fetch(src)
            .then(function(res){return res.arrayBuffer();})
            .then(function(buf){return new File([buf], fileName, {type:mimeType});})
        );
    }

	async reposicionar(select) {

		var th = this,
			longitud = this._selector.files.length,
			nueva_lista = {},
			transferencia_archivos = new DataTransfer();

		const cola = [];

		var imagenes_viejas = this.copiaLista(this._selector.files),
			imagenes_nuevas = {}

		//-------------------------------------------------------------------------------------------------
		var imagen_nueva = this.copiaLista(imagenes_viejas[select.value])
		var imagen_vieja = this.copiaLista(imagenes_viejas[select['indexPrevio']])

		nueva_lista[select['indexPrevio']] = {"imagen": imagen_nueva['name'], "type": imagen_nueva['type']}
		nueva_lista[select.value] = {"imagen": imagen_vieja['name'], "type": imagen_vieja['type']}

		//-------------------------------------------------------------------------------------------------
		Object.keys(imagenes_viejas).forEach(index => {

			if (nueva_lista[index] === undefined) {

				if (imagenes_viejas[index]['name'] !== undefined) {

					if (imagenes_viejas[index]['name'].includes('.png') || imagenes_viejas[index]['name'].includes('.jpg') || imagenes_viejas[index]['name'].includes('.jpeg')) {

						nueva_lista[index] = {"imagen": imagenes_viejas[index]['name'], "type": imagenes_viejas[index]['type']}

					}

				}

			}

		})

		//-------------------------------------------------------------------------------------------------
		Object.keys(nueva_lista).forEach(async index => {

			cola.push(th.retardar().then(x => {}));

			let archivo = await th.buscarImagenRuta(`${th._ruta}${nueva_lista[index].imagen}`, nueva_lista[index].imagen, nueva_lista[index].type)

			imagenes_nuevas[index] = archivo

		})

		await Promise.all(cola);		

		//-------------------------------------------------------------------------------------------------
		Object.keys(imagenes_nuevas).forEach( index => {
			
			transferencia_archivos.items.add(imagenes_nuevas[index]);

		});

		//-------------------------------------------------------------------------------------------------
		this._selector.files = transferencia_archivos.files;
		select['indexPrevio'] = select.selectedIndex
		this.cargar()

	}

	///////////////////////////////////////////////////////////////////////////////////////////////////
	imagenesExpandirConstruir() {

		if (PhotoSwipe !== undefined) {

			this.photo = new PhotoSwipe(document.querySelectorAll(this._pswp)[0], PhotoSwipeUI_Default, this._imagenes, this._opciones)
			this.photo.init()

		} else {

			console.log('PhotoSwipe es necesario para el funcionamiento de esta clase')

		}

	}

	imagenesExpandirConfiguracion(index, imagenes) {
		this._opciones = {
		    index: index,
		    showHideOpacity:true,
		    bgOpacity:0.9,
		    closeOnScroll: false,
		    getThumbBoundsFn: (index) => {
			    var thumbnail = document.querySelectorAll(imagenes)[index];
			    var pageYScroll = window.pageYOffset || document.documentElement.scrollTop; 
			    var rect = thumbnail.getBoundingClientRect(); 
			    return {x:rect.left, y:rect.top + pageYScroll, w:rect.width};
			}
		};
	}
	
	async imagenesExpandirCargar() {
		
		var th = this,
			imagenes = qsa(this._rutaImagenes) //.galeria-img img

		var cola = []

		cola.push(this.retardar().then(x => {}));

		await Promise.all(cola);

		this._imagenes = []

		for (var i = 0; i < imagenes.length; i++) {

			var height = imagenes[i].naturalHeight,
				width  = imagenes[i].naturalWidth

			if (height < 400) {height = 800}
			if (width  < 400) {width  = 800}

			th._imagenes.push({
				src: imagenes[i].src,
				w:width,
				h:height
			})
		
		}

	}

}

window.galeria = new Galeria('#galeria-cargar', '#galeria-contenedor')

galeria._pswp = '.pswp'
galeria._rutaImagenes = '#galeria-contenedor .galeria-img img'
galeria._retardo = 3000

qs('#galeria-cargar').addEventListener('change', () => {

	galeria.cargar()

})

qs('#galeria-contenedor').addEventListener('change', e => {

	if (e.target.tagName === 'SELECT') {

		galeria.reposicionar(e.target)

	}

})

qs('#galeria-contenedor').addEventListener('click', e => {

	if (e.target.tagName === 'IMG') {		
		galeria.imagenesExpandirConfiguracion(Number(e.target.dataset.posicion), '.galeria-img');
		galeria.imagenesExpandirConstruir();
	}

})

qs('#galeria-enviar').addEventListener('click', async e => {

	var datos = tools.procesar('', '', 'valores', tools)

	console.log(await tools.fullAsyncQuery('experimentos', 'imagenes', datos, [["+", "%2B"]], undefined, true))

})

/////////////////////////////////////////////////////////////
window.galeria2 = new Galeria('#galeria-cargar2', '#galeria-contenedor2')

galeria2._pswp = '.pswp2'
galeria2._rutaImagenes = '#galeria-contenedor2 .galeria-img img'
galeria2._retardo = 3000

qs('#galeria-cargar2').addEventListener('change', () => {

	galeria2.cargar()

})

qs('#galeria-contenedor2').addEventListener('change', e => {

	if (e.target.tagName === 'SELECT') {

		galeria2.reposicionar(e.target)

	}

})

qs('#galeria-contenedor2').addEventListener('click', e => {

	if (e.target.tagName === 'IMG') {		
		galeria2.imagenesExpandirConfiguracion(Number(e.target.dataset.posicion), '.galeria-img');
		galeria2.imagenesExpandirConstruir();
	}

})

qs('#galeria-enviar2').addEventListener('click', async e => {

	var datos = tools.procesar('', '', 'valores', tools)

	console.log(await tools.fullAsyncQuery('experimentos', 'imagenes', datos, [["+", "%2B"]], undefined, true))

})


/////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////
class textoPersonalizable {

	constructor () {
		var th = this
		
		this.alerta = 'no se ha declarardo ningún elemento para procesar el texto'
		this.elementos = {}
		this.elementoActual = ''

		this.simbolos = {
			"*": (condicion) => {
				return (condicion) ? '<b>': '</b>';
			},
			"_": (condicion) => {
				return (condicion) ? '<u>': '</u>';
			}, 	 
			"/": (condicion) => {
				return (condicion) ? '<i>': '</i>';
			}, 
			"|": (condicion) => {
				return (condicion) ? "<div style='text-align:center'>" : "</div>";
			}, 
			"Enter": () => {
				return '<br>'
			}
		}

		this.equivalentes = {
			"*": "<b>",
			"_": "<u>", 	 
			"/": "<i>", 	
			"|": "<div style='text-align:center'>"
		}

		this.equivalentesNegativos = {
			"*": "</b>",
			"_": "</u>", 	 
			"/": "</i>", 	
			"|": "</div>"
		}

	}

	actual(elemento) {

		this.elementoActual = elemento

	}

	//declarar elemento [OBLIGATORIO]
	declarar(elemento, eventos, previa) { 

		elemento = (document.querySelector(elemento)) ? document.querySelector(elemento) : '';
		eventos  = (typeof eventos === 'undefined') ? ['keydown'] : eventos;
		previa   = (document.querySelector(previa)) ? document.querySelector(previa) : undefined;

		this.elementos[elemento.id] = {
			"elemento": elemento,
			"eventos": eventos,
			"previa": previa,
			"texto": '',
			"textoPrevia": []
		}

		this.elementos[elemento.id].elemento.texto = ''
		this.elementos[elemento.id].elemento.textoPrevia = []

	} 

	//procesa las acciones de cada elemento
	logica(evento) {

		var th = this

		//this.elementos[this.elementoActual].textoPrevia
		//this.elementos[this.elementoActual].texto

		th.elementos[th.elementoActual].textoPrevia
		th.elementos[th.elementoActual].texto

		if (Object.keys(this.elementos) !== 0) {

			//console.log(evento.key, typeof evento.key)

			var posicion = evento.target.selectionStart,
				valor    = (evento.key.length === 1) ? evento.key : '',
				llave    = evento.key;

			if (valor !== '') {
				
				this.elementos[this.elementoActual].textoPrevia.splice(posicion, 0, valor)

			}

			var longitud = this.elementos[this.elementoActual].textoPrevia.length - (this.elementos[this.elementoActual].textoPrevia.length - posicion)

			//ve si el simbolo debe procesarse de forma especial
			if (typeof this.simbolos[llave] !== 'undefined') {

				//hacer comparativas si a la izquierda tiene caracter o espcio vacio y viseversa
				for (var i = longitud; i >= 0; i--) {

					// console.log({"texto_previa": th.textoPrevia[i]})
					// console.log({"equivalentes negativos": th.equivalentesNegativos[valor]})
					// console.log({"equivalentes positicvos": th.equivalentes[valor]})

					if (this.elementos[this.elementoActual].textoPrevia[i] === this.equivalentesNegativos[valor]) {

						this.elementos[this.elementoActual].textoPrevia[posicion] = this.simbolos[llave](true)
						break;

					} else if (this.elementos[this.elementoActual].textoPrevia[i] === this.equivalentes[valor]) {

						this.elementos[this.elementoActual].textoPrevia[posicion] = this.simbolos[llave](false)
						break;

					} else if (this.elementos[this.elementoActual].textoPrevia[i] === valor) {

						this.elementos[this.elementoActual].textoPrevia[posicion] = this.simbolos[llave](true)

					}

				}

			}

			if (llave === 'Backspace') {

				if (evento.target.selectionStart !== evento.target.selectionEnd) {

					this.elementos[this.elementoActual].textoPrevia.splice(evento.target.selectionStart, (evento.target.selectionEnd - evento.target.selectionStart))

				} else {

					this.elementos[this.elementoActual].textoPrevia.splice(posicion - 1, 1)

				}

			}

			this.elementos[this.elementoActual].texto = evento.target.value

			this.elementos[this.elementoActual].elemento.texto = evento.target.value
			this.elementos[this.elementoActual].elemento.textoPrevia = this.elementos[this.elementoActual].textoPrevia

		} else {

			console.log(this.alerta)

		}

	}

	//genera los eventos de cada elemento
	eventos(objeto) {

		if (Object.keys(this.elementos) !== 0) {

			var th = this

			objeto.eventos.forEach((evt, i) => {

				objeto.elemento.addEventListener(evt, e => {

					th.elementoActual = objeto.elemento.id

				  	th.logica(e)

				  	if (objeto.previa !== undefined) {

				  		objeto.previa.innerHTML = '' 

				  		var texto = ''

						th.elementos[th.elementoActual].textoPrevia.forEach(e => {
						    texto = `${texto}${e}` 
						})

				  		objeto.previa.insertAdjacentHTML('afterbegin', texto) 

				  	}

				})

			})

		} else {

			console.log(this.alerta)

		}

	}
	
	//llama a todo a la vez en el orden adecuado
	init() { 

		if (Object.keys(this.elementos) !== 0) {

			var th = this

			Object.keys(this.elementos).forEach(obj => {

				th.eventos(th.elementos[obj])

			})

		} else {

			console.log(this.alerta)

		}

	}

}

/////////////////////////////////////////////////////////////
window.textareas = new textoPersonalizable()


window.textareas.declarar('#textarea', undefined, '#textarea-previa')
window.textareas.declarar('#textarea2', undefined, '#textarea-previa2')

window.textareas.init()