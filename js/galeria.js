export class Galeria {

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

////////////////////////////////////////////////////////////////////////////////////////////////
//EJEMPLO
//////////////////////////////////////////////////////////////////////////////////////////////////

// window.galeria = new Galeria('#galeria-cargar', '#galeria-contenedor')

// qs('#galeria-cargar').addEventListener('change', () => {

// 	galeria.cargar()

// })

// qs('#galeria-contenedor').addEventListener('change', e => {

// 	if (e.target.tagName === 'SELECT') {

// 		galeria.reposicionar(e.target)

// 	}

// })

// qs('#galeria-contenedor').addEventListener('click', e => {

// 	if (e.target.tagName === 'IMG') {		
// 		galeria.imagenesExpandirConfiguracion(Number(e.target.dataset.posicion), '.galeria-img');
// 		galeria.imagenesExpandirConstruir();
// 	}

// })

// qs('#galeria-enviar').addEventListener('click', async e => {

// 	var datos = tools.procesar('', '', 'valores', tools)

// 	console.log(await tools.fullAsyncQuery('experimentos', 'imagenes', datos, [["+", "%2B"]], undefined, true))

// })