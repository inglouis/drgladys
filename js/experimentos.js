window.qs    = document.querySelector.bind(document)
window.qsa   = document.querySelectorAll.bind(document)
window.gid = document.getElementById.bind(document)
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