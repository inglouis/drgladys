window.qs    = document.querySelector.bind(document)
window.qsa   = document.querySelectorAll.bind(document)

////////////////////////////////////////////////////7
export class Notificaciones {

	constructor() {

		this.mensaje
		this.div  = document.createElement('div');
		this.span = document.createElement('span'); 
		this.tiempo = 2000
		this.tiempoFijo = 2000
		this.tiempoAnimacionTermina = 800
		this.cola = 0

		this.estado
		this.estilo

		this.fondo = ''
		this.fuente = ''

		this.posicion = 'D' //Izquierda - Derecha - Centro

		//LISTAS DE DATOS

		this.estados = {
			"V": 'form-exito',
			"F": 'form-fallo',
			"C": 'form-custom'
		}

		this.posiciones = {
			"I": 'left: 0px;',
			"D": 'right: 0px;',
			"C": 'left: 31%;'
		}

		this.fuentes = {
			"CLARO-1":  '#FFF',
			"CLARO-2":  '#e1e1e1',
			"CLARO-3":  '#d5d5d5',
			"OSCURO-1": '#000000',
			"OSCURO-2": '#262626',
			"OSCURO-3": '#303030',
		}

		this.fondos = {
			"PROCESANDO": '#3e68ff',
			"ALERTA": '#ffc107',
			"GENERAL": '#262626'
		}

	}

	mensajeSimple(contenido, consola, estado) {

		this.mensaje = contenido
		this.estado = estado.toUpperCase()
		this.posicion = 'D'

		this.generar();

		(consola !== false) ? console.log(consola) : '';
		window.procesar = true
	}

	mensajePersonalizado(contenido, consola, fuente, fondo, posicion, estilo) {

		this.mensaje  = contenido
		this.fuente    = (this.fuentes[fuente]) ? this.fuentes[fuente.toUpperCase()] : fuente;
		this.fondo    = (this.fondos[fondo]) ? this.fondos[fondo.toUpperCase()] : fondo;
		this.estilo   = estilo
		this.estado   = 'C'
		this.posicion = (this.posiciones[posicion]) ? this.posiciones[posicion.toUpperCase()] : this.posiciones['D'];

		this.generar();

		(consola !== false) ? console.log(consola) : '';
		window.procesar = true

	}

	generar () {

		var th = this

		var estiloBase = (this.estados[this.estado]) ? this.estados[this.estado] : 'form-fallo', 
			fragmento  = new DocumentFragment(), 
			div        = this.div.cloneNode(), 
			span       = this.span.cloneNode(),
			tiempo     = th.tiempo,
			tiempoAnimacionTermina = th.tiempoAnimacionTermina,
			elemento

	    div.setAttribute('class', estiloBase);
	    div.setAttribute('data-cola', 'a' + this.cola);
		div.setAttributeNS(null, 'style', `${this.posicion} background: ${this.fondo}; color: ${this.fuente}; ${this.estilo}`)

			span.insertAdjacentHTML('afterbegin', this.mensaje);

		div.appendChild(span)
		fragmento.appendChild(div)

		qs('body').appendChild(fragmento)

		elemento = qs(`[data-cola=a${this.cola}]`)
		elemento.setAttribute('data-efecto', 'tooltip-up')

		setTimeout(() => {

			elemento.setAttribute('data-efecto', 'tooltip-down')

			setTimeout(() => {

				elemento.remove();
	   			th.tiempo = th.tiempoFijo

			}, tiempoAnimacionTermina)

		}, tiempo)

		this.cola = this.cola + 1
	}

}

/////////////////////////////////////////////////////
export class Herramientas {
	constructor (){
		this.evento;
		this.mensaje;
		this.div  = document.createElement('div');
		this.span = document.createElement('span'); 
		this.tiempo = 2000
		this.tiempoFijo = 2000
		this.tiempoAnimacionTermina = 800
		this.cola = 0
		this.peticion = ''
		this.marcador = 'X'
		this.validarFuncion = { // this is uwu
	        "undefined": (e) => {''},
	        "function": (e, params) => {return e(params)}
	    }
	    //como invocar
	    //this.validarFuncion[typeof(funcion['x'])](funcion['x'], params)
	}

	esDOM (el) {
		return el instanceof Element	
	}

 	esJSON(str) {

	    if (typeof(str) === 'object') {

	    	return true

	    }

	    if(typeof(str) !== 'string' || !isNaN( str )) { 

	        return false;

	    } 

	    try {

	        JSON.parse(str);
	        return true;

	    } catch (e) {

	        return false;

	    }

	}

	replaceAll (find, replace) {
	    var str = this;
	    return str.replace(new RegExp(find.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&'), 'g'), replace);
	};

	mensajes(estado, estilo) {
		var th = this, 
			forma = 'form-fallo', 
			fragmento = new DocumentFragment(), 
			div  = this.div.cloneNode(), 
			span = this.span.cloneNode(),
			tiempo = th.tiempo,
			tiempoAnimacionTermina = th.tiempoAnimacionTermina

		if (estado === true) {
			forma = 'form-exito'
			div.setAttributeNS(null, 'style', `${estilo}`)
		} else if (estado === false) {
			forma = 'form-fallo'
			div.setAttributeNS(null, 'style', `${estilo}`)
		} else {
			forma = 'form-custom'
			div.setAttributeNS(null, 'style', `background:${estado[0]};color:${estado[1]};${estilo}`)
		}

	    div.setAttribute('class', forma);
	    div.setAttribute('data-cola', 'a' + this.cola);

		span.insertAdjacentHTML('afterbegin', this.mensaje);

		div.appendChild(span)
		fragmento.appendChild(div)

		qs('body').appendChild(fragmento)

		var elemento = qs(`[data-cola=a${this.cola}]`)
		this.cola = this.cola + 1

		elemento.setAttribute('data-efecto', 'tooltip-up')

		setTimeout(() => {

			elemento.setAttribute('data-efecto', 'tooltip-down')

			setTimeout(() => {

				elemento.remove();
	   			th.tiempo = th.tiempoFijo

			}, tiempoAnimacionTermina)

		}, tiempo)
	}

	vacios(e) {
		if (!e.value) {
	   	  window.setTimeout(function() {
	        e.classList.add('inputs-vacios-efecto')
	      }, 0)

	      window.setTimeout(function() {
	        e.classList.remove('inputs-vacios-efecto')
	      }, 1000)
	    }
	}

	alertaInput(e) {
		window.setTimeout(function() {
	    	e.classList.add('inputs-vacios-efecto')
	  	}, 0)

	  	window.setTimeout(function() {
	   		e.classList.remove('inputs-vacios-efecto')
	  	}, 1000)
	}

	efecto(e, clase) {
		window.setTimeout(function() {
	    	e.classList.add(clase)
	  	}, 0)

	  	window.setTimeout(function() {
	   		e.classList.remove(clase)
	  	}, 1000)
	}

	llamarEvento (elem, event) {
		var clickEvent = new Event( event ); // Create the event.
		elem.dispatchEvent( clickEvent );    // Dispatch the event.
	}

	click(node) {
	  var evt = document.createEvent('MouseEvents');
	  evt.initMouseEvent('mousedown', true, false, window, 0, 0, 0, 0, 0, false, false, false, false, 0, null);
	  node.dispatchEvent(evt);
	  
	  node.click();
	}

	fullQuery(clase, funcion, datos, excepciones) {
		var datos = JSON.stringify(datos)
	    var params = `funcion=${funcion}&clase=${clase}&datos=${datos}`;

	    if(typeof(excepciones) !== 'undefined') {
	    	excepciones.forEach((e,i) => {
		    	params = params.replaceAll(e[0], e[1]); //excepcion, reemplazo
		    });
	    }

	    var peticion = new XMLHttpRequest();
        	peticion.overrideMimeType("application/json");
	    	peticion.open('POST', '../controladores/controlador.php', true);  
	    	peticion.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	    	peticion.send(params);

	    return peticion
	}

	async fullAsyncQuery(clase, funcion, datos, excepciones, cola, procesarArchivos) {

		var th = this

		if (procesarArchivos) {

			var archivos = new FormData();

			//esto tiene que ser capaz de manejar datos asociativos
			datos.forEach((archivo, index) => {

				if (th.esDOM(archivo)) {			

					if (archivo.type === 'file') {

						var llaves = Object.keys(archivo.files)

						llaves.forEach(llave => {

							archivos.append(`${archivo.id}-${llave}`, archivo.files[llave]);

						})

						datos[index] = archivo.id

					}

				}

			})

			var datos = JSON.stringify(datos)

			if (typeof(excepciones) !== 'undefined') {
		    	excepciones.forEach((e,i) => {
			    	datos = datos.replaceAll(e[0], e[1]); //excepcion, reemplazo
			    });
		    }

			archivos.append('datos', datos)
			archivos.append('funcion',funcion)
			archivos.append('clase', clase)

		} else {
		    
		    var datos = JSON.stringify(datos)

			if (typeof(excepciones) !== 'undefined') {
	    		excepciones.forEach((e,i) => {
			    	datos = datos.replaceAll(e[0], e[1]); //excepcion, reemplazo
			    });
		    }

		    var params = `funcion=${funcion}&clase=${clase}&datos=${datos}`;

		}  

		if (cola === undefined) {

			var peticion = new XMLHttpRequest();
				peticion.overrideMimeType("application/json");
		    	peticion.open('POST', '../controladores/controlador.php', true); 

		    	if (procesarArchivos) {
		    		peticion.send(archivos);
		    	} else {	
		    		peticion.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		    		peticion.send(params);
		    	}

			const resultado = await new Promise(resolve => {
				peticion.onreadystatechange = function() {
				     if (this.readyState == 4 && this.status == 200) {
			    		resolve(this.responseText)
			    	}
				};
			}) 

			return resultado

		} else {

			if (this.peticion !== '') {
            	this.peticion.abort()
            	this.peticion = ''
          	}

		    this.peticion = new XMLHttpRequest();
	        this.peticion.overrideMimeType("application/json");
		    this.peticion.open('POST', '../controladores/controlador.php', true);  
		    this.peticion.send(params);

		    if (procesarArchivos) {
	    		this.peticion.send(archivos);
	    	} else {
	    		this.peticion.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		    	this.peticion.send(params);
	    	}

			const resultado = await new Promise(resolve => {
				th.peticion.onreadystatechange = function() {
				     if (this.readyState == 4 && this.status == 200) {
			    		resolve(this.responseText)
			    	}
				};
			}) 

			return resultado

		}
		
	}

	generarContenidoCombo (lista, seleccionar, titulo = undefined) {
		var fr = new DocumentFragment();
		var option = document.createElement('option')

		if (lista.length < 1) {
			var elemento = option.cloneNode(true)
				elemento.setAttribute('value', '')
				elemento.insertAdjacentText('afterbegin', 'Sin resultados')
				fr.appendChild(elemento)	
		} else {
			if (seleccionar === true) {
				var elemento = option.cloneNode(true)
					elemento.setAttribute('value', '')
					elemento.insertAdjacentText('afterbegin', 'Seleccionar')
					fr.appendChild(elemento)
			}
		}

		lista.forEach((e, i) => {
			var color = ''
			var elemento = option.cloneNode(true)	

				if(typeof(e['status']) !== 'undefined') {
					if(e['status'] === 'A') {
						color = ''
						elemento.setAttribute('title', e[[Object.keys(e)[1]]])
					} else {
						color = 'background:#ccc'
						elemento.setAttribute('title', 'Desactivado')
					}
					elemento.setAttribute('style', color)
				}

				if(typeof(e['sufijo']) !== 'undefined') {		
					elemento.setAttribute('data-sufijo', e['sufijo'])
				}

				if(typeof(e['prefijo']) !== 'undefined') {		
					elemento.setAttribute('data-prefijo', e['prefijo'])
				}
		
				elemento.setAttribute('value', e[[Object.keys(e)[0]]])
				elemento.insertAdjacentText('afterbegin', e[[Object.keys(e)[1]]])

				if (titulo !== undefined) {
					elemento.setAttribute('title', e[[Object.keys(e)[titulo]]])
				} else {
					elemento.setAttribute('title', e[[Object.keys(e)[1]]])
				}

				fr.appendChild(elemento)
		});

		return fr
	}

	generadorAleatorio(len, charSet) {

	    charSet = charSet || 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
	    var randomString = '';
	    for (var i = 0; i < len; i++) {
	        var randomPoz = Math.floor(Math.random() * charSet.length);
	        randomString += charSet.substring(randomPoz,randomPoz+1);
	    }
	    return randomString;
	    
	}

	filtrarPor(filtro, grupo, datos) {
	    var th = this
	    var lista = {
	      "preciso": {
	        "string": function fn() {
	          if(String(datos[0]) === String(datos[1])) { return [true, datos[2]] } else { return [false, null] }
	        },
	        "number": function fn() {
	          if(String(datos[0]) === String(datos[1])) { return [true, datos[2]] } else { return [false, null] }
	        },
	        "object": function fn() {
	          if(datos[0] === datos[1]) { return [true, datos[2]] } else { return [false, null] }
	        }
	      },
	      "parecido": {
	        "string": function fn() {
	          if(datos[0].toLowerCase().indexOf(datos[1].toLowerCase()) !== -1) {
	            return [true ,datos[2]]
	          } else {
	            return [false, null]
	          }
	        },
	        "number": function fn() {
	          if((datos[0]).indexOf(datos[1]) !== -1) {
	            return [true ,datos[2]]
	          } else {
	            return [false, null]
	          }
	        },
	        "object": function fn() {
	          if(JSON.stringify(datos[0]).toLowerCase().indexOf(datos[1].toLowerCase()) !== -1) {
	            return [true ,datos[2]]
	          } else {
	            return [false, null]
	          }
	        }
	      },
	      "asociativa": {
	      	"valor": () => {
	      		return datos[0]
	      	}
	      },
	      "numeral":{
	      	"valor": () => {
	      		return datos[1]
	      	}
	      }
	    }
	    return lista[filtro][grupo]()
	 }

	filtrar(arr, query, especificos, forzar, filtro) {
		var th = this
		if (typeof(forzar) !== 'undefined') {forzar = forzar} else {forzar = false}
		if (typeof filtro !== 'undefined') {filtro = filtro} else {filtro = 'parecido'}
		if (typeof especificos !== 'undefined') {
			if (especificos.length > 0) {
				especificos = especificos
			} else if (arr.length > 0) {
		      especificos = Object.keys(arr[0])
		    } else {
		    	especificos = []
		    }
	    } else {
	    	if(arr.length > 0) {
	    		especificos = Object.keys(arr[0])
	    	} else {
	    		especificos = []
	    	}
	    }

	    if (this.limitante < this.limitador && !forzar) {
	      this.limitante++
	      return ''
	    } else {
	        var detener = false 
	        var array = arr.filter(function(el) {     	

	        	var busqueda 
	        	if(typeof el.length === 'number') {busqueda = 'numeral'} else {busqueda = 'asociativa'}

	          	for (var r = 0; r < Object.keys(el).length; r++) {
		            var respuesta = []

		            for (var n = 0; n < especificos.length; n++) {

		            	var resultado, elemento = th.filtrarPor(busqueda, 'valor', [el[especificos[n]], el[r]])

		              	if (typeof elemento === 'string') {

		                	resultado = th.filtrarPor(filtro, 'string', [elemento, query, el])
			              	detener   = resultado[0]
			              	respuesta = resultado[1]   

		              	} else if (typeof elemento === 'number') { 

							var letras = '' + elemento
							resultado = th.filtrarPor(filtro, 'number', [letras, query, el])
							detener   = resultado[0]
							respuesta = resultado[1]

		              } else if (typeof elemento === 'object') {

							resultado = th.filtrarPor(filtro, 'object', [elemento, query, el])
							detener   = resultado[0]
							respuesta = resultado[1]

		              }
		              if(detener === true) {break} 
		            }

		            if(detener === true) {
		              detener = false        
		              return respuesta
		            } else if (detener === false) {
		              break 
		              return [] 
		            }
		        }  
	        })
	      this.limitante = 0
	      return array
	    }
	}
	  
  	calcularPrecio(costo, porcentaje, iva) {

  		if (typeof iva !== 'undefined') {

  			if(porcentaje < 0) {porcentaje = 1}
  			if(costo < 0) {costo = 1}
  			if(iva < 0) {iva = 1}

  			var calculo = (costo + ((costo * porcentaje) / 100)) + ((iva * costo) / 100)
				//calculo = (costo + ((iva * costo) / 100))

			//console.log(calculo, iva)

			return calculo

  		} else {
  			return (costo + ((costo * porcentaje) / 100))
  		}
		
	}

	// now.toLocaleDateString(
	// 	'es-ES',
 	//   { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }
	// )

	dateToYMD(end_date) {
        var ed = new Date(end_date);
        var d = ed.getDate();
        var m = ed.getMonth() + 1;
        var y = ed.getFullYear();
        return '' + y + '-' + (m<=9 ? '0' + m : m) + '-' + (d <= 9 ? '0' + d : d);
    }

	calcularFecha (date, forma, fecha) {

		//new Date("1983-March-25").toLocaleDateString('fr-CA', { year: 'numeric', month: '2-digit', day: '2-digit' })
	    var now , way;

	    (typeof forma === 'undefined') ? way = 'fecha': way = forma;
	    (typeof fecha === 'undefined') ? now = new Date(): now = new Date(fecha);

	    if (way === 'fecha') {

			var current_year = now.getFullYear();
		    var year_diff = current_year - date.getFullYear();
		    var birthday_this_year = new Date(current_year, date.getMonth(), date.getDate());
		    var has_had_birthday_this_year = (now >= birthday_this_year);

		    return has_had_birthday_this_year
		        ? year_diff
		        : year_diff - 1;

	    } else if (way === 'dia') {

	    	now.setDate(now.getDate() + date)
	    	return this.dateToYMD(now.toLocaleDateString('en-CA' ,{ year: 'numeric', month: '2-digit', day: '2-digit' }))

	    } else {

	    	console.log('valor inválido')
	    	return ''

	    }
	}

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

	pariente(elemento, parent, forzar) {
	  var detener = 1, romper = (forzar === undefined) ? 10 : forzar;

	  for (var i = 0; i < detener; i++) {      
	    if(elemento.tagName !== parent) {
	        elemento = elemento.parentElement
	        detener++
	    }     
	    if(detener > romper) {i = 100000}
	  }
	  return elemento
	}

	traerOffset(el) {
	    var _x = 0;
	    var _y = 0;
	    while( el && !isNaN( el.offsetLeft ) && !isNaN( el.offsetTop ) ) {
	        _x += el.offsetLeft - el.scrollLeft;
	        _y += el.offsetTop - el.scrollTop;
	        el = el.offsetParent;
	    }
	    return { top: _y, left: _x };
	}

	inputsTitulos (contenedor, tiempo) {

		document.querySelector(contenedor).addEventListener('input', e=> {
		    if(e.target.tagName === 'INPUT') {

		        if(e.target.type !== 'checkbox' && e.target.type === 'text') {

		        	e.target.title = e.target.value.toUpperCase()

		            //esto no esta respondiendo bien
		        }
		    } 
		})
	}

	variablesUrl() {
		const variables = new Proxy(new URLSearchParams(window.location.search), {
		  get: (searchParams, prop) => searchParams.get(prop),
		});

		return variables
	}

	fecha() {
		var date = new Date();

		var date = new Date();
		var dateString = new Date(date.getTime() - (date.getTimezoneOffset() * 60000 ))
                    .toISOString()
                    .split("T")[0];

        return dateString 
	}

	procesar(boton, comparacion, elementos, tools, params) {
		var th = this

		if(typeof boton === 'string') {
			var boton = document.createElement('button')
		}

		if (boton.classList.contains(comparacion) || comparacion === '') {

			window.procesar = false

			var procesar = true,
				datos = [],
				contenedores = (typeof(elementos) !== 'object' && elementos !== null) ? qsa(`.${elementos}`) : qsa(elementos[0]),
				e = 0,
				asociativa = false,
				incluirSeleccionado = true

			if (typeof(params) !== 'undefined') {

				if (typeof(params['incluirSeleccionado']) !== 'undefined') {

					incluirSeleccionado = params['incluirSeleccionado']

				}

				if (typeof(params['asociativa']) !== 'undefined' && params['asociativa'] === true) {

					if (typeof params['id'] === 'undefined') {

						if (incluirSeleccionado) {

							console.log('el modo ASOCIATIVO requiere la asignacion del nombre de la ID desde parametros [PARAMS]')
							window.procesar = true
							return ''

						}

					} else {
						
						asociativa = true

					}

				}
				
			}

			if (asociativa) {datos = {}}

			for (var i = 0; i < contenedores.length; i++) {

				if (contenedores[i].tagName === 'SECTION' || contenedores[i].tagName === 'DIV') { //contenedores especiales
					
					if(contenedores[i].classList.contains('contenedor-consulta')) {

						if (contenedores[i].querySelector('div')['lista'].length === 0 && contenedores[i].classList.contains('lleno')) {
							procesar = false
							th.alertaInput(contenedores[i])
						} else {
							(!asociativa) ? datos.push(contenedores[i].querySelector('div')['lista']) : datos[contenedores[i].dataset.valor] = contenedores[i].querySelector('div')['lista'];
						}
	
					} else if(contenedores[i].classList.contains('contenedor-lista')) {

						(!asociativa) ? datos.push(contenedores[i].dataset.informacion) : datos[contenedores[i].dataset.valor] = contenedores[i].dataset.informacion;

					}

				} else if (contenedores[i].classList.contains('contenedor-personalizable')) {

					if (contenedores[i].texto_base.trim().length === 0 && contenedores[i].classList.contains('lleno')) {

						procesar = false
						th.alertaInput(contenedores[i])
						
					} else {

						(!asociativa) ? datos.push({"texto_base": contenedores[i].texto_base, "texto_html": contenedores[i].texto_html}) : datos[contenedores[i].dataset.valor] = {"texto_base": contenedores[i].texto_base, "texto_html": contenedores[i].texto_html};

					}

				} else {

					if (contenedores[i].value.trim() === '' && contenedores[i].classList.contains('lleno')) {

						procesar = false
						th.alertaInput(contenedores[i])

					} else {

						if (contenedores[i].type === 'number') {

							
							(!asociativa) ? datos.push(Number(contenedores[i].value)) : datos[contenedores[i].dataset.valor] = Number(contenedores[i].value);

						} else if (contenedores[i].type === 'checkbox') {

							if(contenedores[i].checked) {
								(!asociativa) ? datos.push(th.marcador) : datos[contenedores[i].dataset.valor] = th.marcador;
							} else {
								(!asociativa) ? datos.push('') : datos[contenedores[i].dataset.valor] = '';
							}

						} else if (contenedores[i].type === 'file') {

							(!asociativa) ? datos.push(contenedores[i]) : datos[contenedores[i].dataset.valor] = contenedores[i];

						} else {

							(!asociativa) ? datos.push(contenedores[i].value) : datos[contenedores[i].dataset.valor] = contenedores[i].value;
							
						}

					}		
				}			
			}

			if(procesar) {

				if(window.idSeleccionada !== 0) {

					if (incluirSeleccionado) {
						
						(!asociativa) ? datos.push(window.idSeleccionada) : datos[params['id']] = window.idSeleccionada;	

					}

				}

				window.procesar = true
				return datos

			} else {

				tools['mensaje']  = 'Combos sin seleccionar ó campos vacíos'
				tools.mensajes(false)
				window.procesar = true
				return ''

			}

		} else {
			window.procesar = true
			return ''
		}

	}

	limpiar(grupo, funciones, params) {
		var contenedores = qsa(grupo)

		if(typeof(params['preprocesado']) !== 'undefined') {
			params['procesado']()
		}

		for (var i = 0; i < contenedores.length; i++) {
			if (contenedores[i].tagName === 'INPUT') {

				if (contenedores[i].type === 'checkbox') {

					contenedores[i].checked = false

				} else {

					contenedores[i].value = ''

				}

			} else if (contenedores[i].tagName === 'SELECT') {

				if(contenedores[i].parentElement.classList.contains('combo-consulta') && contenedores[i].children.length > 0) {
					var inicial = contenedores[i]['inicial'].cloneNode(true)
					contenedores[i].innerHTML = ''
					contenedores[i].appendChild(inicial)
				}
				
				contenedores[i].selectedIndex = 0
			} else if (contenedores[i].tagName === 'SECTION' || contenedores[i].tagName === 'DIV') {

				if(contenedores[i].classList.contains('contenedor-consulta')) {

					var div = contenedores[i].querySelector('div');
					div['lista'] = []
					div.innerHTML = ''

				} else if (contenedores[i].classList.contains('contenedor-lista')) {

					contenedores[i].innerHTML = ''

				}

			} else if (contenedores[i].classList.contains('contenedor-personalizable')) {

				contenedores[i].value = ''
				contenedores[i].texto_base = ''
				contenedores[i].texto_html = ''

				if (qs(`#${contenedores[i].dataset.previa}`)) {
					qs(`#${contenedores[i].dataset.previa}`).innerHTML = ''
				}

			} else {
				contenedores[i].value = ''
			}
		}

		if (typeof(funciones) !== 'string') {
			
		}

		if(typeof(params['asegurar']) !== 'undefined') {
			var contenedor = qs(params['asegurar']())
			var elementos = contenedor.querySelectorAll('input')
			elementos.forEach((e,i) => {

				if(e.type === 'checkbox') {
					e.checked = false
				} else {
					e.value = ''
				}
				
			})
		}	
		
		if(typeof(params['procesado']) !== 'undefined') {
			params['procesado']()
		}
	}

	insertarEnCursor(myField, myValue) {
	    //IE support
	    if (document.selection) {
	        myField.focus();
	        sel = document.selection.createRange();
	        sel.text = myValue;
	    }
	    //MOZILLA and others
	    else if (myField.selectionStart || myField.selectionStart == '0') {
	        var startPos = myField.selectionStart;
	        var endPos = myField.selectionEnd;
	        myField.value = myField.value.substring(0, startPos)
	            + myValue
	            + myField.value.substring(endPos, myField.value.length);
	        myField.selectionStart = startPos + myValue.length;
	        myField.selectionEnd = startPos + myValue.length;
	    } else {
	        myField.value += myValue;
	    }
	}
	
}

const tools = new Herramientas()

export class Acciones {
	constructor (crud) {
		this.crud = crud
		this.marcador = 'X'
	}

	cargarTabla(lista, reposicionar, echo) {
		this.crud.lista = lista

		if (this.alternar !== '') {
			this.crud['alternar'] = this.alternar
		}

		if (this.especificos !== '') {
			this.crud['especificos'] = this.especificos
		} 

		if (this.limitante !== '') {
			this.crud['limitante'] = this.limitante
		}

		if(typeof echo !== 'undefined') { this.crud.ordenLista() }

		this.crud.generarCabecera();


		this.crud.generar(false);
		this.crud.eventos();

		if(reposicionar) {
			this.crud.reposicionar(this.crud.pagPosi, true)
		} else {
			this.crud.pagPosi = 1
			this.crud.reposicionar(this.crud.pagPosi, true)
		}
		
		if (typeof(this.boton !== 'string')) {
			if(this.boton[1] === true) {
				this.crud.botonBuscar(this.boton[0], this.boton[1])
			}
		}
	}

	replaceAll (find, replace) {
	    var str = this;
	    return str.replace(new RegExp(find.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&'), 'g'), replace);
	};

	query(funcion, datos, excepciones) {
		var datos = JSON.stringify(datos)
	    var params = `funcion=${funcion}&clase=${this.clase}&datos=${datos}`;

	    if(typeof(excepciones) !== 'undefined') {
	    	excepciones.forEach((e,i) => {
	    		params = params.replaceAll(e[0], e[1])//excepcion, reemplazo
		    });
	    }

	    var peticion = new XMLHttpRequest();
        	peticion.overrideMimeType("application/json");
	    	peticion.open('POST', '../controladores/controlador.php', true);  
	    	peticion.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	    	peticion.send(params);

	    return peticion
	}

	limpiarEvento(boton, grupo, funciones, params) {
		var th = this
		qs(boton).addEventListener('click', e => {
			th.limpiar(grupo, funciones, params)
		})
	}

	spinner(contenedor) {
		var img = document.createElement('img')
			img.src = '../imagenes/spinner.gif';
			img.style = 'width: 5vh;height: 5vh;position: absolute;top: 48%;left: 46%;';
		qs(contenedor).innerHTML = ''
		qs(contenedor).appendChild(img)
	}

	validar (familia) {
		var procesar = true
		qsa(`.${familia}`).forEach((e,i) => {
		    if(e.value === '' && e.classList.contains('lleno')) {procesar = false}
		})
		return procesar
	}
}

export class PopUp {

	constructor(elemento, contenedor, subEfecto, scroll, evtElementos, evtElementosPadres, evtTecla) {
		this.estado     = false;
		this.body       = document.querySelector('body');
		this.el         = elemento;
		this.contenedor = contenedor;
		this.subEfecto  = subEfecto;
		this.scroll 	= scroll;
		this.mensaje    = '';
		this.nodoMensaje= document.querySelector('#mensaje-popup');
		this.argumentos = ''
		this.elemento   = document.querySelector('#'+this.el)
		this.cargaFija    = 50//300
		this.descargaFija = 50//400
		this.carga        = 50//300
		this.descarga     = 50//400
		this.funciones    = {"apertura": {}, "cierre": {}}
		this.forzarNoScrollUnaVez = false

		this.evtElementos       = evtElementos
		this.evtElementosPadres = evtElementosPadres
		this.evtTecla = (evtTecla) ? evtTecla : 27

		this.popEvtContenedor = qs(`#crud-${this.evtElementos}-popup`)

		this.ejecutarAntes = {"funcion": () => {}}

	}

	pop() {

		var th = this
		var elemento = document.querySelector('#'+this.el)
		var hijo = elemento.children[0]

		this.ejecutarAntes.funcion()

		if (!this.estado) {
			window.setTimeout(( ) => {
				elemento.classList.remove('popup-oculto')
				elemento.classList.remove(this.contenedor+'-inactivo', 'pop-off')
				elemento.classList.add(this.contenedor+'-activo', 'pop-on');

				if (this.subEfecto.length) {
					hijo.classList.remove('popup-oculto');
					hijo.classList.add(this.subEfecto);
				}
				if (this.scroll) {

					this.body.classList.add('no-scroll')

				} else if (typeof this.scroll === 'string') {

					qs(`#${this.scroll}`).classList.add('no-scroll')

				}

				this.estado = true

				Object.keys(th.funciones['apertura']).forEach((el,i) => {
		            th.funciones['apertura'][el]()
		        });

			}, 0)

		} else {

			window.setTimeout(( ) => {
				elemento.classList.remove(this.contenedor+'-activo', 'pop-on')
				elemento.classList.add(this.contenedor+'-inactivo', 'pop-off')

				//console.log(this.forzarNoScrollUnaVez)

				if (!this.forzarNoScrollUnaVez) {

					if (this.scroll) {

						setTimeout(() => {this.body.classList.remove('no-scroll')}, th.carga)

					} else if (typeof this.scroll === 'string') {

						setTimeout(() => {qs(`#${this.scroll}`).classList.remove('no-scroll')}, th.carga)

					}

				} else {

					this.forzarNoScrollUnaVez = false

				}

				window.setTimeout(() => {
					elemento.classList.add('popup-oculto')
					elemento.classList.remove(this.contenedor+'-inactivo')
					th.descarga = th.descargaFija
				}, th.descarga)

				if (this.subEfecto.length) {
					hijo.classList.add('popup-oculto');
					hijo.classList.remove(this.subEfecto);
				}
				this.estado = false

				Object.keys(th.funciones['cierre']).forEach((el,i) => {
		            th.funciones['cierre'][el]()
		        });

			}, 0)

		} 

		if (this.mensaje.length) {
			this.nodoMensaje.innerHTML = ''
			this.nodoMensaje.insertAdjacentHTML('afterbegin', this.mensaje)
			this.mensaje = ''
		} else {
			setTimeout(() => {
				if (this.nodoMensaje){
					this.nodoMensaje.innerHTML = ''
					this.mensaje = ''
					th.carga = th.cargaFija
				}
			}, th.carga)
		}

		if (this.argumentos.length) {
			if (this.argumentos[0]) {
			   	var y = this.argumentos[0]['ubicacion'][0]
			    var x = this.argumentos[0]['ubicacion'][1]
			    var unidadY = this.argumentos[0]['ubicacion'][2]
			    var unidadX = this.argumentos[0]['ubicacion'][3]

			    this.elemento.children[0].setAttributeNS(null, 'style', `
			    	position: absolute;
			    	top: ${y}${unidadY};
			    	left:${x}${unidadX};
			    ` )
			}
		}
	}

	evtBotones() {

		var th = this

		if (qs(`#crud-${this.evtElementos}-cerrar`)) {

			qs(`#crud-${this.evtElementos}-cerrar`).addEventListener('click', () => {

				window.idSeleccionada = 0
				th.pop()

			})

		}

		if (qs(`#crud-${this.evtElementos}-botones`)) {

			qs(`#crud-${this.evtElementos}-botones`).addEventListener('click', (el) => {

				if (el.target.classList.contains('cerrar') || el.target.classList.contains('cancelar')) {

					window.idSeleccionada = 0
					th.pop()

				}

			})
		}

	}

	evtEscape(evt) {

		var th = this

		if (evt.keyCode === this.evtTecla && this.popEvtContenedor.classList.contains(`popup-activo`)) {

			if (typeof this.evtElementosPadres !== 'object') {

				if (this.popEvtContenedor) {

					if (!this.popEvtContenedor.classList.contains('popup-oculto')) {

						window.idSeleccionada = 0
						this.pop()

					}

				} else {
					window.idSeleccionada = 0
					this.pop()
				}

			} else {

				var procesar = true

				for (let index = 0; index < this.evtElementosPadres.length + 1; index++) {
   	
					var contenedor = qs(`#crud-${this.evtElementosPadres[index]}-popup`)

					if (contenedor) {

						if (contenedor.classList.contains('popup-activo')) {

							window.idSeleccionada = 0
							procesar = false
							break;

						}

					}

				}

				if (procesar) {
					this.pop()
				}

			}

		}

	}

}

export class Menu {
	constructor() {
		this.evento
		this.ul = ''
	}
	
	cargarNav() {
		var th = this
			document.querySelectorAll(`#${this.evento} ul`).forEach(function(e, i, arr) {
		  	document.querySelectorAll(`#${th.evento} ul`)[i].style.display = 'none'
		});
	}

	mostrar() {
		qs(`#${this.evento}`).addEventListener('mouseover', e => {
			if(e.target.tagName === 'A') {
		    	if(e.target.parentElement.querySelector('ul') !== null) {
					e.target.parentElement.querySelector('ul').style.display = 'block'
				}
			}
		})
	}

	mostrarSmooth() {
		var th = this

		Array.from(document.querySelectorAll(`#${this.evento} li`)).forEach(el => {
			el.addEventListener('mouseover', e => {

				if (e.target.parentElement.tagName === 'LI') {

					th.ul = e.target.parentElement.querySelector('ul')

					if (th.ul) {

						var max = 0

						th.ul.setAttribute('data-efecto', 'mostrar-smooth')
						th.ul.querySelectorAll('li').forEach(e => {max = max + e.clientHeight})
						th.ul.setAttribute('style', `height: ${max}px`)
						th.ul = ''
					}

				}
			})
		})
	}

	ocultar() {
		var th = this

		Array.from(document.querySelectorAll(`#${this.evento} li`)).forEach(el => {
			el.addEventListener('mouseleave', e => {
				if (e.target.tagName === 'LI') {
					if (e.target.querySelector('ul')) {
						e.target.querySelectorAll('ul').forEach(ul => {
							ul.removeAttribute('data-efecto')
							ul.setAttribute('style', 'display:none')
						})
					}
				}
			})
		})
	}
}

export class MenuTree {
	constructor (evt, efectos, delay) {
  	this.evt = document.querySelector(evt)
	this.efectos = efectos
    this.delay = delay
  }
  
  	menuTree() {
	  	this.evt.addEventListener('click', (e) => {
		    var padre = e.target

		    Array.from(padre.children).forEach((elemento,i) => {
				if(elemento.tagName === 'UL' && elemento.parentElement.id !== this.evt.id) {
					if(typeof(elemento.dataset.hide) !== 'undefined') {
						elemento.removeAttribute('data-hide')
						elemento.setAttribute('data-efecto', this.efectos['abrir'])	
					} else {
						elemento.setAttribute('data-efecto', this.efectos['cerrar'])
	            		setTimeout(() => {elemento.setAttribute('data-hide', '')}, this.delay)
					}
				}
			})
		})
	}
}

export class paginaCargada {
	constructor(esperado, promesa, confirmado) {
		this.esperado   = esperado
		this.promesa    = promesa
		this.limpiar    = [false, 3000]
		this.confirmado = (typeof confirmado === 'undefined' || typeof confirmado === '' || confirmado === null) ? 'cargado' : confirmado;
	}

	generar() {
		let span = document.createElement('span')
			span.setAttribute('id', this.confirmado)
			span.setAttribute('style', 'display:none')
		qs('body').appendChild(span)
	}

	async checkFor(promesa) {
		var th = this
		var lista = {
			"existencia": () => {
				return new Promise(resolve => {
					var existencia = setInterval(async () => {   
			            if (qs(th.esperado)) { clearInterval(existencia); resolve(true) }
			        }, 1000);
				})	
			},
			"longitud": () => {
				return new Promise(resolve => {
					var existencia = setInterval(async () => {   
			            if (qs(th.esperado) && qs(th.esperado).children.length > 0) { 
			            	clearInterval(existencia); resolve(true)
			           	}
			        }, 1000);
				})
			}
		}
		var resultado = await lista[promesa]()
		return resultado
	}
	
	async revision() {
		var th = this
        var existencia = await th.checkFor(th.promesa)
        if(existencia) {th.generar()}
        if(this.limpiar[0]) {
        	setTimeout(() => {
        		qs(`#${th.confirmado}`).remove()
        	}, th.limpiar[1])
        }
	}
}

export class ContenedoresEspeciales {
	constructor (contenedor) {
		this.contenedor = contenedor
		this.elementos = qsa('[data-familia]')
		this.filtros = []
		this.procesando = false
		this.herramientas = new Herramientas()
		this.sizeSelectMotorBusqueda = 10
		this.minSelectMotorBusquedaY = '200px'
		this.minSelectMotorBusquedaX = '100%'
	}

	checkboxes (el) {
		var th = this

		if (el.dataset.agrupar === '1') {
			this.checkLong = this.checkLong + 1

			if(el.checked) {
				this.filtros.push([el.dataset.origen, el.value])
				this.checkboxes['insertar'] = false
			}

			if (this.checkLong === qsa(`[data-name=${el.dataset.name}]`).length && this.checkboxes['insertar'] === true) {
				this.filtros.push('')
				this.checkLong = 0
			}

			if (this.checkLong === qsa(`[data-name=${el.dataset.name}]`).length) {
				this.checkboxes['insertar'] = true
				this.checkLong = 0
			}
		} else {
			if(el.checked) {

				if(typeof(el.dataset['origen']) === 'undefined') {
					this.filtros.push(el.value)
				} else {
					this.filtros.push([el.dataset.origen, el.value])
				}
				
			} else {
				this.filtros.push('')
			}
		}
	}

	combo (el) {
		if(el.value !== '') {

			if(typeof(el.options[el.selectedIndex].dataset.origen) === 'undefined') {
			    this.filtros.push(el.value)
			} else {
				this.filtros.push([el.options[el.selectedIndex].dataset.origen, el.value])
			}
			
		} else {
			this.filtros.push('')
		}
	}

	reconstruirCombo(select, input, lista, titulo) { //archivo, metodo, datos
    	select.innerHTML = ''

		var lista = lista
		input['lista'] = lista

    	var inicial = this.herramientas.generarContenidoCombo(lista, true, titulo)
    	select['inicial'] = inicial.cloneNode(true)
    	select.appendChild(inicial)

	}

	filtrarComboForzado(select, input) {
		var filtrado = this.herramientas.filtrar(input['lista'], input.value, [], true, undefined)

	    if(filtrado !== '') {
	    	select.innerHTML = ''
	    	select.appendChild(this.herramientas.generarContenidoCombo(filtrado, false))	
	    }
	}

	procesar(query, clase, funcion) {
		var th = this
		if (!this.procesando) {

			this.filtros = []

			this.elementos.forEach((el,i) => {
				switch (el.tagName) {
					case 'INPUT':
						th.checkboxes(el)
					break;
					case 'SELECT':
						th.combo(el)
					break;
				}	
			})
			this.procesando = false
			return query(clase, funcion, this.filtros)
		} else {
			this.herramientas['mensaje'] = 'procesando'
			this.herramientas.mensajes(true)
		}
	}

	eventos() {
		var th = this 

		function checkboxes(nombre) { //revisar esta parte, no funciona :(

			qs(`#${th.contenedor} [data-grupo=${nombre}]`).addEventListener('click', e => {
				if (e.target.tagName === 'INPUT') {
					var preservar = e.target.checked

					qsa(`#${th.contenedor} input[data-name=${nombre}]`).forEach((e,i) => {
				    	e.checked = false	     
				    })
				    
				    e.target.checked = preservar
				} 
			})

		}

		function contenedor(elemento, peticion, limitantes, condiciones, funciones) {
			var elemento = qs(`#${elemento}`)
			var separador, size, ocultarSelect, ocultarInput, minimo, absoluto, selectEvt, especificos, filtro
			var input  = elemento.querySelector('input'), 
				select = elemento.querySelector('select'), 
				div    = elemento.querySelector('div'),
				jsSql = condiciones[0],      	  //controla si el combo se refresca con js o por peticiones
				estandar = condiciones[1],   	  //estandariza los datos a UPPERCASE
				seleccionar = condiciones[2],	  //habilita el valor de seleccionar cuando el combo se refresca
				obligatorio = condiciones[3],	  //define si el combo debe tener valor para habilitar la insersion en el contenedor
				addOcultar = condiciones[4], 	  //controla que el combo se oculte tras insertar un valor en el contenedor 
				transaccion = condiciones[5],	  //al clicar la opcion del combo el valor se transfiere al input
				filtrar = condiciones[6],    	  //controla si el combo debe cambiar si el valor del input se modifica
				limpiar = condiciones[7],     	  //controla si el combo es regenerado cuando un valor es insertado en el contenedor
				comparaciones = condiciones[8],	  //activa o desactiva la comparacion por la id o por el valor de cada nuevo elemento respecto a la lista
				autoTransaccion = condiciones[9], //toma de forma automatica el primer valor del combo
				cargarDeSelect = condiciones[10]  //carga el campo desde el select al contenedor

			//<!--limitadores de caracteres al momento de la busqueda-->
			if (limitantes.length !== 0) {

				th.herramientas['limitante'] = limitantes[0]
				th.herramientas['limitador'] = limitantes[1]
				input['limitante'] = limitantes[0]
				input['limitador'] = limitantes[1]

			} else {

				th.herramientas['limitante'] = 0
				th.herramientas['limitador'] = 0
				input['limitante'] = 0
				input['limitador'] = 0

			}

			//FUNCIONES
			//divPreprocesado
			//inputProcesado
			//sFr
			//bFr
			//dFr

			////////////////////////////////////////////////////////////////////////////////////
			//INPUT
			////////////////////////////////////////////////////////////////////////////////////
			
			//FUNCION DE LOS DATASETS
			/////////////////////////////////////////////////////////////////////////7//////////
			//ocultar = 1/0
			//minimo = 1/infinito
			//especificos = ['el1', 'el2']
			//filtro = ?
			
			//ES NECESARIO QUE ESTE ESTE AQUÍ
			if (select.dataset.ocultar !== undefined) { ocultarSelect = Number(select.dataset.ocultar) } else { ocultarSelect = 0 }

			if (input.dataset.ocultar  !== undefined) { ocultarInput  = Number(input.dataset.ocultar) }   else { ocultarInput = 0 }
			if (input.dataset.minimo   !== undefined) { minimo = Number(input.dataset.minimo) } else { minimo = 1 }
			if (input.dataset.especificos !== undefined) { especificos = JSON.parse(input.dataset.especificos) } else { especificos = undefined }
			if (input.dataset.filtro !== undefined) { filtro = JSON.parse(input.dataset.filtro) } else { filtro = undefined }

			input['peticion'] = peticion
			input.addEventListener('keyup', e => {

				var forzar = (e.target.value.length === 0 && e.key === 'Backspace') ? forzar = true : forzar = false; 

				if (jsSql === false) {

					if(typeof(input['lista']) !== 'undefined') {

						if(e.key !== 'Enter') {
							var filtrado = th.herramientas.filtrar(input['lista'], input.value, especificos, forzar, filtro)
							if(filtrado !== '') {

								if (filtrar) {
									select.innerHTML = ''
						    		select.appendChild(th.herramientas.generarContenidoCombo(filtrado, seleccionar[1]))
								}

							}

						}    
					}
				   
				} else {

					if (input['limitante'] < input['limitador'] && forzar === false) {

				      	input['limitante']++

				    } else {

				    	if(e.key !== 'Enter') {
				    		var peticion = th.herramientas.fullQuery(input.peticion[0], input.peticion[1], [input.value, select.dataset.limit])
							peticion.onreadystatechange = function() {
						        if (this.readyState == 4 && this.status == 200) {
						        	if (filtrar) {
						        		select.innerHTML = ''
						        		select.appendChild(th.herramientas.generarContenidoCombo(JSON.parse(this.responseText), seleccionar[1]))
						        	}    	
						        }
						    };
						    input['limitante'] = 0
				    	}

				    }
				}

				if(e.target.value.length > minimo) {
					if(ocultarSelect === 1) {
						select.removeAttribute('data-hide', '')
					}
				} else {
					if(ocultarSelect === 1) {
						select.setAttribute('data-hide', '')
					}
				}
			})

			if(peticion[0] !== '' && peticion[1] !== '') {
				var peticion = th.herramientas.fullQuery(peticion[0], peticion[1], peticion[2])
				peticion.onreadystatechange = function() {
			        if (this.readyState == 4 && this.status == 200) {
			        	select.innerHTML = ''
			        	if (jsSql === false) {
			        		var lista = JSON.parse(this.responseText)
			        		input['lista'] = JSON.parse(this.responseText)
			        	}

			        	var inicial = th.herramientas.generarContenidoCombo(JSON.parse(this.responseText), seleccionar[0])
			        	select['inicial'] = inicial.cloneNode(true)
			        	select.appendChild(inicial)
			        }
			    };
			} else {
				input['lista'] = []
			}

			if(ocultarInput === 1) {
				input.setAttribute('data-hide', '')
			}

			////////////////////////////////////////////////////////////////////////////////////
		    //SELECT
		    ////////////////////////////////////////////////////////////////////////////////////
			
			//FUNCION DE LOS DATASETS
			/////////////////////////////////////////////////////////////////////////7//////////
			//size = numerico
			//absoluto = true/false - 1/0
		    
		    if (select.dataset.size !== undefined) { size = Number(select.dataset.size) } else { size = 0 }
		    if (select.dataset.absoluto !== undefined) { absoluto = Number(select.dataset.absoluto) } else { absoluto = 0 }
		    
		    if(!absoluto) {
		    	var preStyle = select.getAttribute('style')+' ';
		    	if(preStyle === 'null ') {
		    		preStyle = ''
		    	}
		    	select.setAttribute('style', preStyle+' ;position: relative; top: 0px;')
		    }

		    select.setAttribute('size', size)
		    
		    if(size === 0) {selectEvt = 'change'} else {selectEvt = 'click'}

			select.addEventListener(selectEvt, e => {
				if(e.target.value !== "") {
					if(transaccion) {input.value = select.options[select.selectedIndex].innerHTML}
					input.focus()
				} else {
					input.value = ''
				}	
			})

			////////////////////////////////////////////////////////////////////////////////////
		    //div
			////////////////////////////////////////////////////////////////////////////////////
			
			//FUNCION DE LOS DATASETS
			/////////////////////////////////////////////////////////////////////////7//////////
			//separador = ''

			div['lista'] = []
			div['temporal'] = 0
			div['autoincremento'] = 0

  			div.addEventListener('click', e => {
  				if(e.target.classList.contains('ccEliminar')) {

  					if(typeof funciones['divPreprocesado'] !== 'undefined') {
						funciones['divPreprocesado'](e.target)
					}

  					div['lista'].forEach((el,i) => {
						if(String(el.autoincremento) === String(e.target.dataset.autoincremento)) {
							div['lista'].splice(i, 1)
						}
					});

  					e.target.parentElement.remove()
  				}
  			})

  			if(div.dataset.separador !== undefined) {separador = div.dataset.separador} else {separador = ''}

			//Keyevents
			//////////////////////////////////////////
			
			//EVENTO DE LA CARGA
			//////////////////////////////////////////7
			
			var eventoInput = (evento) => {

				if(evento.target.value !== "") {
					if(transaccion) {
						input.value = select.options[select.selectedIndex].innerHTML
					}

					input.focus()
					if (addOcultar) {
						select.setAttribute('data-hide', '')
					}			
				} else {
					input.value = ''
				}

			}

			var eventoSelect = (evento) => {

				var posicion = '', nuevo = true, datos = [], validar;

				if (evento.target.value.trim() !== '' && evento.target.value !== '0') {

					if (obligatorio) { (select.value === '') ? validar = false : validar = true; } else { validar = true }
					
					if(validar) {

						div['lista'].forEach((el,i) => {

							if (comparaciones[0]) {
							 	if(String(el.id) === String(select.value)) {
									posicion = i
									nuevo = false
								}
							}
							
							if(comparaciones[1]) {
								if(String(el.value) === String(evento.target.value).trim()) {
									posicion = i
									nuevo = false
								}		
							}
						})
						
						if(nuevo) {
							var id, value, color = '', prefijo = '', sufijo = ''
							var fr = new DocumentFragment()
							var d = document.createElement('div')
								d.setAttribute('class', 'ccContenedor');

								(select.value === '') ? (id = 'temp'+div['temporal'], div['temporal']++, color = 'ccId') : id = select.value;

								(estandar) ? value = String(evento.target.value.trim().toUpperCase()) : value = String(evento.target.value.trim());

								if(select.children.length !== 0) {
									(typeof(select.options[select.selectedIndex].dataset['prefijo']) !== 'undefined') ? prefijo = select.options[select.selectedIndex].dataset['prefijo']+separador : '';
									(typeof(select.options[select.selectedIndex].dataset['sufijo']) !== 'undefined') ? sufijo = separador+select.options[select.selectedIndex].dataset['sufijo'] : '';
								}

								if(select.value !== '' && autoTransaccion) {
									value = select.options[select.selectedIndex].innerHTML
								}

								if (evento.target.tagName === 'OPTION') {
									value = select.options[select.selectedIndex].innerHTML
								}

								var s = document.createElement('span')
									s.setAttribute('class', color)
									s.insertAdjacentText('afterbegin', prefijo+value+sufijo)

								if(typeof funciones['sFr'] !== 'undefined') {
									s = funciones['sFr'](s)
								}

								d.appendChild(s)

								var b = document.createElement('button')
									b.setAttribute('class','ccEliminar')
									b.setAttribute('data-id', id)
									b.setAttribute('data-value', value)
									b.setAttribute('data-autoincremento', div['autoincremento'])
									b.insertAdjacentText('afterbegin', 'X')

								if(typeof funciones['previo_carga'] !== 'undefined') { //añadir elemento html y otro al contenedor
									b = funciones['previo_carga'](b)
								}

								//console.log(d, b)

								d.appendChild(b)

								if(typeof funciones['post_carga'] !== 'undefined') {
									d = funciones['post_carga'](d)
								}

							fr.appendChild(d)
							div.appendChild(fr)

							input.value = ''
							input.setAttribute('value', '')
							input.focus()

							var contenedores = div.querySelectorAll('.ccContenedor')
							contenedores.forEach((el,i) => {
								var boton = el.children[1]
								var data = {};

								data['autoincremento'] = boton.dataset.autoincremento;
								(isNaN(boton.dataset.id)) ? data['id'] = boton.dataset.id : data['id'] = Number(boton.dataset.id);	
								(isNaN(boton.dataset.value)) ? data['value'] = String(boton.dataset.value) : data['value'] = String(boton.dataset.value);

								datos.push(data)		
							});

							div['lista'] = datos
							div['autoincremento'] = div['autoincremento'] + 1

							if(limpiar) {
								var inicial = select['inicial'].cloneNode(true)
								select.innerHTML = ''
				        		select.appendChild(inicial)
							}

							if (addOcultar) {
								select.setAttribute('data-hide', '')
							}
							
							if(typeof funciones['inputProcesado'] !== 'undefined') {
								funciones['inputProcesado'](evento.target)
							}

						} else {
							th.herramientas['mensaje'] = 'Este campo ya existe'
							th.herramientas.mensajes(false)
						}	
					} else {
						th.herramientas.alertaInput(select)
						th.herramientas['mensaje'] = 'Ningún valor fue seleccionado'
						th.herramientas.mensajes(false)
					}
					
				} else {
					th.herramientas.alertaInput(e.target)
					th.herramientas['mensaje'] = 'Campo vacío'
					th.herramientas.mensajes(false)
				}
				
			}; 

			//EVENTOS RELACIONADOS AL DIV
			//////////////////////////////////////////7
			elemento.addEventListener('keyup', (e) => {

				if (e.key === 'Enter' && e.target.tagName === 'SELECT') {
					eventoInput(e)
				}

				if (e.keyCode === 13 && e.target.tagName === 'INPUT') {
					eventoSelect(e)
				}

			})

			if (cargarDeSelect) {
				select.addEventListener('click', e => {
					eventoInput(e)
					eventoSelect(e)
				})
			}
		}

		function combo(nombre, peticion, jsSql, limitantes, filtro, especificos, params) {
			var padre = qs(`#${th.contenedor} [data-grupo=${nombre}]`)

			var input, select, filtroProcesado, titulo = undefined, especificosProcesado, seleccionar = false, listaExterna = undefined, seleccionarGenerado = true, navegacionVertical = false, motorBusqueda = false

			if(typeof params !== 'undefined') {
				if(typeof params['seleccionar'] !== 'undefined') {
					seleccionar = params['seleccionar']
				}

				if(typeof params['seleccionarGenerado'] !== 'undefined') {
					seleccionarGenerado = params['seleccionarGenerado']
				}

				if(typeof params['lista'] !== 'undefined') {
					listaExterna = params['lista']
				}

				if(typeof params['lista'] !== 'undefined') {
					listaExterna = params['lista']
				}

				if(typeof params['navegacionVertical'] !== 'undefined') {
					navegacionVertical = params['navegacionVertical']
				}

				if(typeof params['motorBusqueda'] !== 'undefined') {
					motorBusqueda = params['motorBusqueda']
				}

				if(typeof params['titulo'] !== 'undefined') {
					titulo = params['titulo']
				}
			}

			if(peticion.length > 0) {

				if (limitantes.length !== 0) {
					th.herramientas['limitante'] = limitantes[0]
					th.herramientas['limitador'] = limitantes[1]
					padre['limitante'] = limitantes[0]
					padre['limitador'] = limitantes[1]
				} else {
					th.herramientas['limitante'] = 0
					th.herramientas['limitador'] = 0
					padre['limitante'] = 0
					padre['limitador'] = 0
				}

				if (padre.children.length > 1) {

					input = padre.children[0]
					input['peticion'] = peticion
					select= padre.children[1]

					input.addEventListener('keyup', e => {

						var forzar = (e.target.value.length === 0 && e.key === 'Backspace') ? forzar = true : forzar = false; 

						if (e.target.value.trim() !== '') {

							if (jsSql === false) {

							    var filtrado = th.herramientas.filtrar(input['lista'], input.value, especificos, forzar, filtro)

							    if(filtrado !== '') {
							    	select.innerHTML = ''
							    	select.appendChild(th.herramientas.generarContenidoCombo(filtrado, seleccionar, titulo))	
							    }

							} else {

								if (padre['limitante'] < padre['limitador'] && forzar === false) {
							      	padre['limitante']++
							    } else {
							    	if(e.key !== 'Enter') {
							    		var peticion = th.herramientas.fullQuery(input.peticion[0], input.peticion[1], [input.value, input.dataset.limit])
										peticion.onreadystatechange = function() {
									        if (this.readyState == 4 && this.status == 200) {
									        	select.innerHTML = ''
									        	select.appendChild(th.herramientas.generarContenidoCombo(JSON.parse(this.responseText), seleccionar, titulo))
									        }
									    };
									    padre['limitante'] = ''
							    	} 	
							    }	
							}

						}

					})

					select.addEventListener('change', elemento => {
						elemento.target.title = elemento.target.options[elemento.target.selectedIndex].innerHTML
					})

				} else {
					input  = ''
					select = padre.children[0]
				}

				if(listaExterna === undefined) {

					var peticion = th.herramientas.fullQuery(peticion[0], peticion[1], peticion[2])
					peticion.onreadystatechange = function() {
				        if (this.readyState == 4 && this.status == 200) {
				        	select.innerHTML = ''
				        	if (jsSql === false) {
				        		var lista = JSON.parse(this.responseText)
				        		input['lista'] = JSON.parse(this.responseText)
				        	}
				        	var inicial = th.herramientas.generarContenidoCombo(JSON.parse(this.responseText), seleccionarGenerado, titulo)
				        	select['inicial'] = inicial.cloneNode(true)
				        	select.appendChild(inicial)
				        }
				    };

				} else {

					select.innerHTML = ''
		        	if (jsSql === false) {
		        		var lista = listaExterna
		        		input['lista'] = listaExterna
		        	}
		        	var inicial = th.herramientas.generarContenidoCombo(listaExterna, seleccionarGenerado, titulo)
		        	select['inicial'] = inicial.cloneNode(true)
		        	select.appendChild(inicial)

				}

				if (motorBusqueda) {

					if (padre.children.length > 1) {

						padre.setAttribute('data-relativo', '')
						padre.querySelector('input').addEventListener('input', elemento => {

							var select = elemento.target.nextElementSibling

							if (elemento.target.value.length > 0) {

								if(select.getAttribute('data-absoluto') === null) {

									var distancias = elemento.target.getBoundingClientRect()
									var altura = input.getBoundingClientRect().height + select.getBoundingClientRect().height

									select.setAttribute('data-absoluto', '')
									select.setAttribute('size', th.sizeSelectMotorBusqueda)
									select.setAttribute('style', `top:${distancias.height}px !important; min-height: ${th.minSelectMotorBusquedaY};z-index: 2;width: ${th.minSelectMotorBusquedaX};`)
									select.parentElement.style = `min-height:${altura}px`

								}

							} else {

								select.setAttribute('size', 1)
								select.removeAttribute('data-absoluto')
								select.setAttribute('style', ``)
								select.parentElement.style = ``

							}

						})

						padre.addEventListener('focusout', elemento => {

							select.setAttribute('size', 1)
							select.removeAttribute('data-absoluto')
							select.setAttribute('style', ``)
							select.parentElement.style = ``

						})


					} else {
						console.log('cantidad inválida de hijos para motorBusqueda, necesita un input y un select')
					}
					
				}

				if (navegacionVertical) {

					if (padre.children.length > 1) {

						padre.querySelector('input').addEventListener('keydown', elemento => {

							if(elemento.key === 'ArrowDown') {

								var distancias = elemento.target.getBoundingClientRect()

								select.focus()
								setTimeout(() => {
									select.scrollTo(0,0)
									select.scrollTop = 0
								}, 100)
								
								select.setAttribute('data-absoluto', '')
								select.setAttribute('size', th.sizeSelectMotorBusqueda)
								select.setAttribute('style', `top:${distancias.height}px !important; min-height: ${th.minSelectMotorBusquedaY};z-index: 2;width: ${th.minSelectMotorBusquedaX};`)

							}

						})

						padre.querySelector('select').addEventListener('keydown', elemento => {

							if(elemento.key === 'ArrowUp') {

								if(elemento.target.selectedIndex === 0) {

									padre.querySelector('input').focus()
									select.setAttribute('size', 1)
									select.removeAttribute('data-absoluto')
									select.setAttribute('style', ``)
									select.parentElement.style = ``

								}
								

							} else if (elemento.key === 'Enter') {
								padre.querySelector('input').value = elemento.target.options[elemento.target.selectedIndex].innerHTML
								padre.querySelector('input').focus()
								select.setAttribute('size', 1)
								select.setAttribute('style', ``)
								select.removeAttribute('data-absoluto')
								select.parentElement.style = ``
								padre.querySelector('input').value = ''
							}

						})

						padre.querySelector('select').addEventListener('focusout', elemento => {

							if(elemento.target.selectedIndex === 0) {

								padre.querySelector('input').focus()
								select.setAttribute('size', 1)
								select.removeAttribute('data-absoluto')
								select.setAttribute('style', ``)
								select.parentElement.style = ``

							} else {
								padre.querySelector('input').value = elemento.target.options[elemento.target.selectedIndex].innerHTML
								padre.querySelector('input').focus()
								select.setAttribute('size', 1)
								select.setAttribute('style', ``)
								select.removeAttribute('data-absoluto')
								select.parentElement.style = ``
								padre.querySelector('input').value = ''
							}

						})
					}

				}

			} else {
				console.log('faltan valores en el segundo parametro')
			}
		}

		function acordeon(nombre) {
			if (qs(`#${nombre}`)) {
				qs(`#${nombre}`).addEventListener('click', (e) => {
			    	var padre = e.target
			    	for(var i = 0; i < padre.children.length; i++) {
						if(padre.children[i].tagName === 'UL') {
							if (padre.children[i].style.display === 'none') {
				          		padre.children[i].style.display = "block"
				          	} else {
				          		padre.children[i].style.display = "none"
				          	}
						}
					}
			    })
			} else {
				console.log('El elemento no existe')
			}			
		}

		return {
			checkboxes : checkboxes,
			combo: combo,
			acordeon:acordeon,
			contenedor:contenedor
		}	
	}

	//--------------------------------------------------------
	//--------------------------------------------------------
	estandarizarContenedor(elemento, lista, posiciones, estandar) {
		var elemento = qs(`#${elemento}`)
		var datos = [], autoincremento = 0, posicion = 0
		var input  = elemento.querySelector('input'), 
			select = elemento.querySelector('select'), 
			div    = elemento.querySelector('div');	

		div['lista'] = []
		div.innerHTML = ''

		if (lista.length > 0) {

			lista.forEach((e,i) => { //iterar por toda la lista

				if (typeof(e) === 'object' && e !== null) {

					if (posiciones.length !== 0) {

						var longitud;
						(e.length !== undefined) ? longitud = e.length : longitud = Object.keys(e).length; //longitud

						if (longitud < 2) {
							var data = {}
							data['id'] = 'temp'+autoincremento
							data['value'] = e[posiciones[0]]
							data['autoincremento'] = autoincremento
							autoincremento = autoincremento + 1
						} else { 
							var data = {}
							data['id'] = e[posiciones[0]]
							data['value'] = e[posiciones[1]]
							data['autoincremento'] = autoincremento
							autoincremento = autoincremento + 1
						}

					} else {
						console.log('faltan posiciones')
					}

				} else {
					var data = {}
					data['id'] = 'temp'+autoincremento
					data['value'] = e
					data['autoincremento'] = autoincremento
					autoincremento = autoincremento + 1
				}
				posicion = autoincremento
				datos.push(data)
			})


			for (var i = 0; i < datos.length; i++) {
				if(typeof(datos[i].value) !== 'number') {
					if (datos[i].value.trim() === "") {
						datos.splice(i, 1)
						posicion--
						i--
					}

					if(estandar) {
						if(i > -1) {
							datos[i].value = String(datos[i].value.trim().toUpperCase())
						}
					} else {
						if(i > -1) {
							datos[i].value = String(datos[i].value.trim())
						}
					}
				}		
			}
			
			datos.forEach((e,i) => {
				var id, color = ''
				var fr = new DocumentFragment()
				var d = document.createElement('div')
					d.setAttribute('class', 'ccContenedor');

					(String(e.id).includes('temp')) ? color = 'ccId' : '';

					var s = document.createElement('span')
						s.insertAdjacentText('afterbegin', e.value)
						s.setAttribute('class', color)

					d.appendChild(s);

					var b = document.createElement('button')
						b.setAttribute('class','ccEliminar')
						b.setAttribute('data-id', e.id)
						b.setAttribute('data-value', e.value)
						b.setAttribute('data-autoincremento', i)
						b.insertAdjacentText('afterbegin', 'X')
					d.appendChild(b)
				fr.appendChild(d)
				div.appendChild(fr)
			});

			div['autoincremento'] = posicion
			div['temporal'] = posicion
			div['lista'] = datos
			
		} else {
			//console.log('lista vacía en contenedor especial')
		}
	}

	forzarCombo(combo, peticion, funcion) {
		var th = this, peticion = th.herramientas.fullQuery(peticion[0], peticion[1], peticion[2]), select = qs(combo), inicial, extra
		peticion.onreadystatechange = function() {
	        if (this.readyState == 4 && this.status == 200) {
	        	select.innerHTML = ''
	        	inicial = th.herramientas.generarContenidoCombo(JSON.parse(this.responseText), false)
	        	select.appendChild(inicial)
		        extra = select['inicial'].cloneNode(true)
		        extra.children[0].remove()
	        	select.appendChild(extra)

	        	if(typeof funcion === 'object' && funcion) {
		          Object.keys(funcion).forEach((el,i) => {
		            funcion[el](select)
		          });
		        }
	        }
	    };
	}
	//--------------------------------------------------------
	//--------------------------------------------------------
}

export class Paginacion {
	constructor(grupos, propiedades, paginar) {
		this.grupos 	  = (grupos) ? grupos : {}; //"familia": dato, "efecto": dato, "delay": dato; DATOS ESTANDAR
		this.contenedores = (qsa(this.grupos['contenedores']).length) ? qsa(this.grupos['contenedores']) : []; // Lista HTML de contenedores	
		this.propiedades  = (propiedades) ? propiedades : []; //"efecto": dato, "posicion": dato, "delay": datos; DATOS ESPECIFICOS [S: para estandar]
		this.posicionAntigua = 0
		this.posicionNueva = 0
		this.min = -1 //no cambia
		this.max = this.contenedores.length   //no cambia
		this.hider = 'data-hide'
		this.subefectos = true
		this.paginadores = (qsa(paginar).length) ? qsa(paginar) : [];
		this.btnAntiguo = ''
		this.rotar = false
	}

	show(familia, subposicion, subefecto ,subdelay) {
		setTimeout(() => {
			familia[subposicion].setAttribute('data-efecto', subefecto)	
			familia[subposicion].removeAttribute('data-invisible')	
		}, subdelay)
	}

	hide(familia) {
		familia.forEach((e,i) => {
			familia[i].setAttribute('data-invisible', '')
			familia[i].removeAttribute('data-efecto')
		})	
	}

	animacion(operacion, forzar, boton) { 
		var th = this 
		if (this.contenedores.length > 0) {
			var familia, oFamilia, efecto, delay, operador

			//console.log(1, this.max, this.posicionNueva, this.posicionAntigua); 1,3,0,0

			(forzar === undefined) ? operador = this.posicionNueva + operacion : operador = operacion;

			if(operador < this.max) {
				if(operador > this.min) {

					(forzar === undefined) ? this.posicionNueva = this.posicionNueva + operacion : this.posicionNueva = operacion;

					(typeof(this.grupos['familia']) !== 'undefined') ? (familia = this.contenedores[this.posicionNueva].querySelectorAll(`${this.grupos['contenedores']} ${this.grupos['familia']}`)) : console.log('parametro [familia] obligatorio');
					(typeof(this.grupos['familia']) !== 'undefined') ? (oFamilia = this.contenedores[this.posicionAntigua].querySelectorAll(`${this.grupos['contenedores']} ${this.grupos['familia']}`)) : console.log('parametro [familia] obligatorio');
					(typeof(this.grupos['efecto']) !== 'undefined') ? (efecto = this.grupos['efecto']) : console.log('parametro [efecto] estandar obligatorio');
					(typeof(this.grupos['delay']) !== 'undefined') ? (delay = this.grupos['delay']) : console.log('parametro [delay] estandar obligatorio');

					if(typeof(familia) !== 'undefined' || typeof(efecto) !== 'undefined' || typeof(delay) !== 'undefined') {

						this.contenedores[this.posicionAntigua].setAttribute(this.hider, '')
						this.contenedores[this.posicionNueva].removeAttribute(this.hider, '')

						for (var i = 0; i < familia.length; i++) {
							
							var subposicion, subefecto, subdelay

							if(this.subefectos) {
								(typeof(this.propiedades[i]['posicion']) !== 'undefined') ? subposicion = this.propiedades[i]['posicion'] : subposicion = i;
								(typeof(this.propiedades[i]['delay']) !== 'undefined') ? subdelay = this.propiedades[i]['delay'] : subdelay = delay;

								if(this.posicionNueva < this.posicionAntigua) {			
									(typeof(this.propiedades[i]['efecto']) !== 'undefined') ? subefecto = this.propiedades[i]['efecto'][0] : subefecto = efecto[0];
								} else {
									(typeof(this.propiedades[i]['efecto']) !== 'undefined') ? subefecto = this.propiedades[i]['efecto'][1] : subefecto = efecto[1];
								}
							} else {
								subposicion = i
								subdelay = delay;	
								(this.posicionNueva < this.posicionAntigua) ? subefecto = efecto[0] : subefecto = efecto[1];
							}
							
							this.hide(oFamilia)
							this.show(familia, subposicion, subefecto, subdelay)
						}

						(forzar === undefined) ? this.posicionAntigua = this.posicionAntigua + operacion : this.posicionAntigua = operacion;
						
					} else {
						console.log('variables de la propiedad [grupos] indefinidas')
					}
				}// else if () {

				// }
			} else if (operador >= this.max) {
				if(this.rotar) {
					this.posicionNueva = -1
					this.posicionAntigua = this.max - 1
					this.animacion(0, true, boton)
				}

			}

			if (this.paginadores.length > 0) {
				var fix = operador + 1
				if (fix > th.max) {fix = th.max}
				if (fix < 1) {fix = 1}
				this.paginadores[0].value = fix
			}
		}  else {
			console.log('parametro [contenedores] obligatorio')
		}	
	}

	flechas(comparacion, objetivo, funciones) {
		var th = this
		if(objetivo.tagName !== 'INPUT' && objetivo.tagName !== 'SELECT') {
			var dato, lista = {
				'ArrowRight': function fn () {th.animacion(1)},
				'ArrowLeft': function fn () {th.animacion(-1)}
			};

			(typeof(lista[comparacion]) !== 'undefined') ? (dato = lista[comparacion]) : dato = e => {};
			return dato
		} else {
			return function fn() {}
		}	
	}

	boton(btnNuevo, atributo, nombre) {
		(atributo === 'class') ?
			(this.btnAntiguo.classList.remove(nombre), btnNuevo.classList.add(nombre))
		:
			(this.btnAntiguo.removeAttribute(atributo, nombre), btnNuevo.setAttribute(atributo, nombre));
		
		this.btnAntiguo = btnNuevo
	}

	paginar() {
		var th = this
		if(this.paginadores.length > 0) {
			this.paginadores[0].value = 1
			this.paginadores[0].addEventListener('keyup', e => {
				if(e.key === 'Enter') {
					var paginar = Number(e.target.value)

					if(paginar <= th.max) {
						if(paginar > 0) {
							th.animacion(paginar - 1, true)
						} else {
							e.target.value = 1
						}
					} else {
						e.target.value = th.max
					}
				}
			})

			this.paginadores[1].value = th.max
		}	
	}
}

export class Atajos {
	constructor(acciona, elementos, contenedor, focusable) {
        this.acciona = acciona
        this.elementos = elementos
        this.contenedor = (contenedor) ? contenedor : '';
        this.focusable = (focusable) ? focusable : false;
        this.previsor = ''
        this.tareas = {
        	"focus": (elemento, clean) => {
        		elemento.focus()
        		if (clean) {
                    setTimeout(e => {
        			   elemento.value = elemento.value.substring(0,(elemento.value.length - 1))
                    }, 1) 
        		}
        	}
        }
	}

    opciones(opcion, elemento, clean) {
    	if(elemento !== null) {
    		this.tareas[opcion](elemento, clean)
    	}
    }

    ejecutar(ejecuta) {
    	var th = this, clean = ''
    	this.elementos.forEach((e,i) => {
    		if(ejecuta.toLowerCase() === e.ejecuta.toLowerCase()) {
    			if(typeof e.tarea === 'string') {
    				clean = (typeof e['clean'] !== 'undefined') ? e['clean'] : false;
    				th.opciones(e.tarea, qs(e.elemento), clean)
    			} else {
    				e.tarea()
    			}
    		}
    	});
    }

    eventos () {
    	var th = this, capturador

		capturador = (this.focusable) ? capturador = qs(this.contenedor) : capturador = window;

    	capturador.addEventListener('keydown', this.evento = function fn(e) {
    		if (!e.repeat) {
				if (th.previsor === th.acciona) {
	            	th.previsor = e.key
	            	th.ejecutar(e.key)
	            } else {
	            	th.previsor = e.key
	            }
    		}
    	})
    }
}

//agregar logica para proceso de animaciones individuales, esto esta muy limitado
export class Animaciones {
	constructor (efectos, eventos, logica) {
		this.efectos = efectos
		this.procesar = true
		this.eventos = (typeof eventos !== 'undefined') ? eventos : ['mouseenter', 'mouseleave'];
		this.logica  = (typeof logica !== 'undefined') ? logica : {"apertura": function fn () {}, "cierre": function fn () {}};
		this.delay = 500
		this.th = this
		this.hider = 'data-hide'
		this.atributos = {
			aplicar: function (e, efecto) {
				e.setAttribute('data-efecto', efecto)
    			e.removeAttribute('data-invisible')
        	}
        }
	}

	forzarDisparoEntrada(disparador, elementos) {
		this.logica['apertura']()
	} 

	forzarDisparoSalida(disparador, elementos) {

		var th = this

		this.logica['cierre'](qs(disparador));

		qsa(elementos).forEach(el => {

			el.setAttribute('data-hidden', '')

			setTimeout(() => {
				th.atributos.aplicar(qs(disparador), th.efectos.off)
			}, th.delay)
			

	    	setTimeout(() => {
	    		el.removeAttribute('data-hidden')
	    		el.setAttribute('data-efecto', th.efectos.on)
	    	}, th.delay + 500)

		})

	}

	generar(disparador, elementos) {
		var th = this, 
			padre = (disparador instanceof Element) ? disparador : qs(disparador);

		if (padre !== null) {

			padre.addEventListener(this.eventos[0], (e) => {
				th.logica['apertura'](e);
				qsa(elementos).forEach(el => {

					if (th.procesar) {

						el.removeAttribute(th.hider)
						th.atributos.aplicar(el, th.efectos.on)
						th.procesar = false
					} 
					
				})
			})

			padre.addEventListener(this.eventos[1], (e) => {

				if(!th.procesar) {

					th.logica['cierre'](e);
					qsa(elementos).forEach(el => {

						th.atributos.aplicar(el, th.efectos.off)	
			    		setTimeout(() => {
			    			el.setAttribute(th.hider, th.hider)
							th.procesar = true
			    		}, th.delay, 1)
				         
					})

				}

			})

		}
	
	}
}

export class Reportes {
	constructor() {
		this.funciones = ''
		this.herramientas = new Herramientas()
		this.sub = 20
		this.alertas = {
			"historial": {
				"procesando": true,
				"existencia": true,
				"exito": true
			}
		}
	}

	peticion (params) {
		var peticion = new XMLHttpRequest();
	    	peticion.open('POST', params['url'], true);  
	    	peticion.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	    	peticion.send();

	    return peticion
	}

	guardar (url) {
		var peticion = this.peticion({"url": url})
		peticion.onreadystatechange = function() {
	        if (this.readyState == 4 && this.status == 200) {
	        	console.log('generado')
	        }
	    };
	}

	historial(contenedor, funcion, clase, archivo) {
		var th = this

		if(th.alertas.historial.procensando) {
			this.herramientas['mensaje'] = 'Procesando...'
			this.herramientas.mensajes(['#ffc107', '#fff'])
		}

		window.procesar = false

		var peticion = this.herramientas.fullQuery(funcion, clase, [archivo])
		peticion.onreadystatechange = function() {
	        if (this.readyState == 4 && this.status == 200) {

	        	if(this.responseText.trim() !== '"noreport"') {
	        		var lista = JSON.parse(this.responseText)

		        	if(typeof(contenedor) === 'string') {
		        		qs(contenedor).innerHTML = ''
		        		//qs(contenedor).setAttribute('class', 'scroll')

	        			var section = document.createElement('section')
	        				section.setAttribute('class', 'historial-reportes scroll')

	        			var cabecera = document.createElement('section')
	        				cabecera.setAttribute('class', 'historial-cabecera')
	        				var span = document.createElement('span')
	        					span.insertAdjacentText('afterbegin', 'Documento')
	        				cabecera.appendChild(span)

	        				var span = document.createElement('span')
	        					span.insertAdjacentText('afterbegin', 'Acción')
	        				cabecera.appendChild(span)
	        			qs(contenedor).appendChild(cabecera)

	        			lista.forEach((e, i) => {
	        				var div = document.createElement('div')
			        			var a = document.createElement('a')
			        				a.setAttribute('href', e['ruta'])
			        				a.setAttribute('target', '_blank')
			        				a.insertAdjacentText('afterbegin', e['ruta'].substring(th.sub))

		        			div.appendChild(a)

		        				var span = document.createElement('span')
			        			var button = document.createElement('button')
			        				button.setAttribute('class', 'historial-eliminar')
			        				button.insertAdjacentText('afterbegin', 'X')
			        				button.setAttribute('id', e['ruta'])
			        				button.setAttribute('title', 'Eliminar reporte permanentemente')
			        				span.appendChild(button)
			        		div.appendChild(span)
			        		section.appendChild(div)
	        			})

	        			qs(contenedor).appendChild(section)
	        			if(th.alertas.historial.exito) {
	        				th.herramientas['mensaje'] = 'Reportes cargados'
							th.herramientas.mensajes(true)
	        			}

		        	} else {
		        		if(typeof(contenedor) === 'function') {
		        			contenedor(lista)
		        		} else {
		        			console.log('definir función de llegada en presentación personalizada')
		        		}
		        	}
	        	} else {
	        		if(th.alertas.historial.existencia) {
		        		th.herramientas['mensaje'] = 'No hay reportes generados'
						th.herramientas.mensajes(['#9e9e9e', '#fff'])
	        		}
	        	}
	        	window.procesar = true
	        }
	    };
	}

	imprimir (url, contenedor) {
		if(window.procesar) {
			this.herramientas['mensaje'] = 'Procesando...'
			this.herramientas.mensajes(['#ffc107', '#fff'])
			window.procesar = false
			var peticion = this.peticion({"url": url})

			peticion.onreadystatechange = function() {
		        if (this.readyState == 4 && this.status == 200) {
		        	var pagina = this.responseText
		        	var div = document.createElement('div')
		        		div.setAttribute('id', 'impresion')
		        		div.setAttribute('data-hide', '')
		        		div.insertAdjacentHTML('afterbegin', this.responseText)
		        	qs(contenedor).appendChild(div)

		        	qs('#impresion').removeAttribute('data-hide')
		        	window.print();
		        	setTimeout(e => {
		        		qs('#impresion').remove()
		        		window.procesar = true
		        	}, 1000)
		        }
		    };
		    
		} else {
			this.herramientas['mensaje'] = 'El repote ya se está generando'
			this.herramientas.mensajes(false)
		}
	}

	async imprimirPDF (url, funciones, datosPorSesion) {
		
		var th = this

		if(window.procesar) {

			window.procesar = false

			tools['mensaje'] = 'Procesando reporte...'
			tools.mensajes(['#0d6efd', '#fff']) 

			var iframe = this._printIframe;

			if(this.herramientas.esDOM(qs('#id-iframe'))) {
				qs('#id-iframe').remove()
			}

			if (datosPorSesion !== undefined) {

				var sesion = [
					{"sesion": 'datos_pdf', "parametros": JSON.stringify(datosPorSesion)}
				]

				await tools.fullAsyncQuery('index', 'modificar_sesion', sesion) //no puede ser PPAL una referencia directa por ser MODEL obligatorio para el MVC

			}

			iframe = th._printIframe = document.createElement('iframe');
			iframe.setAttribute('id', 'id-iframe')
			iframe.setAttribute('style', 'display:none; size: 420mm 594mm;margin: 10m')
			document.body.appendChild(iframe);

			iframe.onload = function() {
			  setTimeout(function() {
			    iframe.focus();
			    iframe.contentWindow.print();
			    setTimeout(e => {
	        		window.procesar = true

	        		if(typeof funciones !== 'undefined') {
						if(typeof funciones['procesado'] !== 'undefined') {
							funciones['procesado']()
						}
					}

	        	}, 3000)

			  }, 1);

			};

			iframe.src = url;

		} else {
			tools['mensaje'] = 'El panel ya se esta generando'
			tools.mensajes(false)
		}	
	}

	imprimirPeticion() {

		var xhr = new XMLHttpRequest();
	    xhr.open('GET', url, true);
	    xhr.type = 'arraybuffer';
	    xhr.onreadystatechange = function() {
	        if (xhr.readyState == 4 && xhr.status == 200){
	           var blobSrc = window.URL.createObjectURL(new Blob([this.response], { type: 'application/pdf' }));
	           // assign to your iframe or to window.open
	           yourIframe.src = blobSrc;
	        } 
	    }

	}

	imprimirPDFafterprint(url, marco) {
		if(window.procesar) {
			window.procesar = false
			this.herramientas['mensaje'] = 'Procesando reporte...'
			this.herramientas.mensajes(['#0d6efd', '#fff'])

			const iframe = qs(marco);
			iframe.src = url;

			// iframe.onload = () => {
			// 	iframe.contentWindow.addEventListener('afterprint', (evt) => {
			// 	    window.procesar = true

			// 		if(typeof funciones === 'object' && funciones !== null) {
			// 	     	Object.keys(funciones).forEach((el,i) => {
			// 	       		funciones[el]()
			// 	      	});
			// 	    }

			// 	    document.body.removeChild(iframe)
			// 	});

			// 	setTimeout(() => {
			// 		window.frames['print_pdf'].focus()
			// 		window.frames['print_pdf'].print()	
			// 	}, 1000)
				
			// }
			// document.body.appendChild(iframe)
		} else {
			this.herramientas['mensaje'] = 'El panel ya se esta generando'
			this.herramientas.mensajes(false)
		}
	}

	// imprimirPDF2 (url, funciones) {
	// 	if(window.procesar) {
	// 		window.procesar = false
	// 		this.herramientas['mensaje'] = 'Procesando reporte...'
	// 		this.herramientas.mensajes(['#0d6efd', '#fff']) 

	// 		var iframe = this._printIframe, th = this;

	// 		if (!this._printIframe) {

	// 			iframe = this._printIframe = document.createElement('iframe');
	// 			iframe.id = 'id-iframe';
 //                iframe.name = 'id-iframe';
 //                iframe.src = url;
	// 			iframe.setAttribute('style', 'display:none; size: 420mm 594mm;margin: 10m')

	// 			iframe.onload = function () {

	// 				iframe.contentWindow.addEventListener('afterprint', (evt) => {
	//                     window.procesar = true
	//                     th._printIframe  = false	

 //               			if(typeof funciones === 'object' && funciones !== null) {
	// 		             	Object.keys(funciones).forEach((el,i) => {
	// 		               		funciones[el]()
	// 		              	});
	// 		            }

	// 		            setTimeout(() => {document.body.removeChild(iframe)}, 50)
	// 				});

 //                    window.frames['id-iframe'].focus()
 //                    window.frames['id-iframe'].print()
					
	// 			}
	// 			document.body.appendChild(iframe);

	// 		} 

	// 	} else {

	// 		this.herramientas['mensaje'] = 'El panel ya se esta generando'
	// 		this.herramientas.mensajes(false)

	// 	}	
	// }

	// imprimirPDF3(url, funciones) {
	// 	if(window.procesar) {
	// 		window.procesar = false
	// 		this.herramientas['mensaje'] = 'Procesando reporte...'
	// 		this.herramientas.mensajes(['#0d6efd', '#fff'])

	// 		const iframe = document.createElement('iframe');
	// 		iframe.src = url;
	// 		iframe.id = 'id-iframe';
	// 		iframe.name = 'id-iframe';
	// 		iframe.setAttribute('style', 'display:none; size: 420mm 594mm;margin: 10m')

	// 		iframe.onload = () => {
	// 			iframe.contentWindow.addEventListener('afterprint', (evt) => {
	// 			    window.procesar = true

	// 				if(typeof funciones === 'object' && funciones !== null) {
	// 			     	Object.keys(funciones).forEach((el,i) => {
	// 			       		funciones[el]()
	// 			      	});
	// 			    }

	// 			    document.body.removeChild(iframe)
	// 			});

	// 			setTimeout(() => {
	// 				window.frames['print_pdf'].focus()
	// 				window.frames['print_pdf'].print()	
	// 			}, 1000)
				
	// 		}
	// 		document.body.appendChild(iframe)
	// 	} else {
	// 		this.herramientas['mensaje'] = 'El panel ya se esta generando'
	// 		this.herramientas.mensajes(false)
	// 	}
	// }

	// imprimirPDF4(url, funciones) {
	// 	if(window.procesar) {
	// 		window.procesar = false
	// 		this.herramientas['mensaje'] = 'Procesando reporte...'
	// 		this.herramientas.mensajes(['#0d6efd', '#fff'])
			
	// 		if(qs('#print-frame')) {qs('#print-frame').remove()}

	// 		const iframe = document.createElement('iframe');
	// 		iframe.id = 'print-frame';
	// 		iframe.src = url;//el problema esta en el tiempo de carga de la url, url que no tardan nada en generar el iframe funcionan
	// 		iframe.setAttribute('style', 'display:none; size: 420mm 594mm;margin: 10m')

	// 		iframe.onload = function () {
	// 		  var mediaQueryList = iframe.contentWindow.matchMedia('print');
	// 		  mediaQueryList.addListener(function (mql) {
	// 				if (!mql.matches) {
	// 					console.log('afterprint')
	// 			      	if(typeof funciones === 'object' && funciones !== null) {
	// 				     	Object.keys(funciones).forEach((el,i) => {
	// 				       		funciones[el]()
	// 				      	});
	// 				    }
	// 			    }
	// 		  });

	// 		  setTimeout(function () {
	// 		    iframe.contentWindow.print();
	// 		  }, 0);
	// 		}
	// 		document.body.appendChild(iframe);

	// 	} else {
	// 		this.herramientas['mensaje'] = 'El panel ya se esta generando'
	// 		this.herramientas.mensajes(false)
	// 	}
	// }

	previa (elemento, url) {
		elemento.setAttribute('src', url)
	}

	eventos() {
		function historial(contenedor) {
			qs(contenedor).addEventListener('click', e=> {
				if (e.target.tagName === 'A') {
					e.preventDefault()
					window.open(e.target.href, '_blank')
				}
			})
		}

		return {
			historial : historial
		}	
	}
}

export class Rellenar {
	constructor (grupo, marcador) {
		this.grupo = (typeof grupo !== 'undefined') ? grupo : 'valor';
		this.marcador = (typeof marcador !== 'undefined') ? marcador : 'X';
	}

	contenedores(lista, elementos, params, funciones) {
		var contenedores = qsa(elementos), th = this

		if (typeof(funciones) === 'object') {
			if(typeof(funciones['preprocesado']) !== 'undefined') {
				funciones['preprocesado']()
			}
		}

		if(typeof params === 'object') {
			if(typeof(params['id']) !== 'undefined' && typeof(params['elemento']) !== 'undefined') {
				if(params['id'] === 'value') {
					window.idSeleccionada = (!isNaN(params.elemento.value)) ? Number(params.elemento.value) : elemento.value;
				} else {
					window.idSeleccionada = (!isNaN(params.elemento.classList[params['id']])) ? Number(params.elemento.classList[params['id']]) : params.elemento.classList[params['id']];
				}
			}
		}

		for (var i = 0; i < contenedores.length; i++) {

			if (contenedores[i].tagName === 'INPUT') {

				if (contenedores[i].type === 'checkbox') {

					if (contenedores[i].getAttribute('value') !== null) {

						if(lista[contenedores[i].dataset[th.grupo]] === contenedores[i].value) {
							contenedores[i].checked = true
						} else {
							contenedores[i].checked = false
						}	

					} else {

						if(lista[contenedores[i].dataset[th.grupo]] === this.marcador) {
							contenedores[i].checked = true
						} else {
							contenedores[i].checked = false
						}	

					}

					/*} else if (contenedores[i].type === 'date') {

					if(lista[contenedores[i].dataset[th.grupo]] !== null && typeof lista[contenedores[i].dataset[th.grupo]] !== 'undefined') {

						contenedores[i].value = tools.dateToYMD(lista[contenedores[i].dataset[th.grupo]])
						contenedores[i].title = tools.dateToYMD(lista[contenedores[i].dataset[th.grupo]])

					}*/

				} else {

					if(lista[contenedores[i].dataset[th.grupo]] !== null && typeof lista[contenedores[i].dataset[th.grupo]] !== 'undefined') {


						if (contenedores[i].type !== 'file') {

							contenedores[i].value = lista[contenedores[i].dataset[th.grupo]]
							
							if (contenedores[i].title === '') {

								contenedores[i].title = lista[contenedores[i].dataset[th.grupo]]

							}

						}


					}
				}
			} else if (contenedores[i].tagName === 'SELECT') {

				var encontrado = false
				Array.from(contenedores[i]).forEach((el,index) => {
				    if (String(el.value).trim() === String(lista[contenedores[i].dataset[th.grupo]]).trim()) {
				      contenedores[i].selectedIndex = index
				      encontrado = true
				    }
				})

				if(!encontrado) {
					if(contenedores[i]['inicial']) {
						var inicial = contenedores[i]['inicial'].cloneNode(true)
						contenedores[i].innerHTML = ''
						contenedores[i].appendChild(inicial)
					}		
				}
				
			} else if (contenedores[i].tagName === 'SECTION' || contenedores[i].tagName === 'DIV') {
				
				if (contenedores[i].classList.contains('contenedor-consulta')) {

					if(contenedores[i].dataset[th.grupo] !== undefined) {

						if(typeof funciones['contenedorConsulta'] !== 'undefined') {
							
							funciones['contenedorConsulta'](JSON.parse(lista[contenedores[i].dataset[th.grupo]]), contenedores[i].id, contenedores[i])	
						
						} else if (typeof funciones['rellenarContenedor'] !== 'undefined') {
							
							funciones['rellenarContenedor'](JSON.parse(lista[contenedores[i].dataset[th.grupo]]), contenedores[i])	
						
						}

					}

				} else if (contenedores[i].classList.contains('contenedor-lista')) {

					//tengo que agregar posibilidad de leer lista asociativa retornar valor representado por una id
					var fr = new DocumentFragment(),
						valores = JSON.parse(lista[contenedores[i].dataset[th.grupo]])

					valores.forEach(elemento => {

						var div = document.createElement('div')
							div.innerHTML = `- ${String(elemento).toUpperCase()}`

						fr.appendChild(div)

					})

					if (valores.length === 0) {

						var div = document.createElement('div')
							div.setAttribute('class', 'lista-vacio')
							div.innerHTML = '---'

						fr.appendChild(div)

					}

					contenedores[i].setAttribute('data-informacion', valores)
					contenedores[i].innerHTML = ''
					contenedores[i].appendChild(fr)

				}

			} else {
				
				if (contenedores[i].classList.contains('contenedor-personalizable')) {

					if (typeof lista[contenedores[i].dataset[th.grupo]] === 'string') {

						var array = JSON.parse(lista[contenedores[i].dataset[th.grupo]])

					} else {

						var array = lista[contenedores[i].dataset[th.grupo]]

					}

					contenedores[i].value = ''
					contenedores[i].texto_base = ''
					contenedores[i].texto_html = ''

					contenedores[i].value = array.texto_base
					contenedores[i].texto_base = array.texto_base
					contenedores[i].texto_html = array.texto_html

					if (qs(`#${contenedores[i].dataset.previa}`)) {

						qs(`#${contenedores[i].dataset.previa}`).innerHTML = array.texto_html

					}
 
				} else if (lista[contenedores[i].dataset[th.grupo]] !== null && typeof lista[contenedores[i].dataset[th.grupo]] !== 'undefined') {

					if (contenedores[i].tagName === 'TEXTAREA') {

						var valores = '', array

					    try {
					        array = JSON.parse(lista[contenedores[i].dataset[th.grupo]]);

					        Object.keys(array).forEach(i => {

								valores = `${valores} ${array[i]} - `

							})

							contenedores[i].value = valores.slice(0, -2)

					    } catch(error) {

					    	contenedores[i].value = lista[contenedores[i].dataset[th.grupo]]

					    }

					} else {

						contenedores[i].value = lista[contenedores[i].dataset[th.grupo]]
					}

				}
			}
		}

		if (typeof(funciones) === 'object') {
			if(typeof(funciones['procesado']) !== 'undefined') {
				funciones['procesado']()
			}	
		}
	}

	//--------------------------------------------------------//if(!isNaN(Object.keys(lista).length)) { 
	//--------------------------------------------------------
	rellenarContenedor(contenedor, lista, posiciones, estandar) {
		var datos      = [], 
			incremento = 0,
			posicion   = 0,
			div        = (typeof contenedor === 'string') ? qs(contenedor) : contenedor,
			datasets   = false

		div['lista']  = []
		div.innerHTML = ''

		if (lista.length > 0) {

			if (typeof(lista[0]) === 'object' && lista[0] !== null) { //lista asociativa
			
				datasets = true

				lista.forEach(e => {

					var longitud = Object.keys(e).length; //longitud

					if (longitud < 2) {
						var d = {//datos
							'id': `temp${incremento}`,
							'value': e[posiciones[0]],
							'autoincremento': incremento,
							'datasets': []
						} 
					} else {
						var d = {//datos
							'id': e[posiciones[0]],
							'value': e[posiciones[1]],
							'autoincremento': incremento,
							'datasets': []
						}
					}

					Object.keys(e).forEach(el => {
						d['datasets'].push({"set": el, "valor":e[el]})
					})

					incremento = incremento + 1
					posicion = incremento
					datos.push(d)

				})

			} else if (typeof lista[0] === 'string') { //lista autoincremental

				lista.forEach(e => {

					var d = {//datos
						'id': `temp${incremento}`,
						'value': e,
						'autoincremento': incremento
					} 

					posicion = incremento
					datos.push(data)

				})


			} else {
				console.log('lista invalida')
			}

		}

		//esto se queda;
		for (var i = 0; i < datos.length; i++) {
			if(typeof(datos[i].value) !== 'number') {
				if (datos[i].value.trim() === "") {
					datos.splice(i, 1)
					posicion--
					i--
				}

				if(estandar) {
					if(i > -1) {
						datos[i].value = String(datos[i].value.trim().toUpperCase())
					}
				} else {
					if(i > -1) {
						datos[i].value = String(datos[i].value.trim())
					}
				}
			}		
		}

		datos.forEach((e,i) => {
			var id, color = '', fr = new DocumentFragment()

			var d = document.createElement('div')
				d.setAttribute('class', 'ccContenedor');

				(String(e.id).includes('temp')) ? color = 'ccId' : '';

				var s = document.createElement('span')
					s.insertAdjacentText('afterbegin', e.value)
					s.setAttribute('class', color)

				d.appendChild(s);

				var b = document.createElement('button')
					b.setAttribute('class','ccEliminar')
					b.setAttribute('data-id', e.id)
					b.setAttribute('data-value', e.value)
					b.setAttribute('data-autoincremento', i)
					b.insertAdjacentText('afterbegin', 'X')

					if(datasets) {

						e.datasets.forEach(el => {
							b.setAttribute(`data-${el['set']}`, el['valor'])
						})

						delete e['datasets']
					}

				d.appendChild(b)

			fr.appendChild(d)
			div.appendChild(fr)
		});

		div['autoincremento'] = posicion
		div['temporal'] = posicion
		div['lista'] = datos

	}
	//--------------------------------------------------------
	//--------------------------------------------------------
}

export class ARPropiedades { //añadir remover propiedades
	constructor(propiedades) {
		this.propiedades = (propiedades) ? propiedades : {"data-estilo": "focus"}
		this.elemento = document.createElement('button')
	}

	viejoElemento () {
		this.accion(false)
	}

	nuevoElemento (elemento) {	
		(typeof elemento === 'string') ? this.elemento = qs(elemento) : this.elemento = elemento;
		this.accion(true)
	}

	accion (modo) {
		if(modo) {
	
	   		Object.keys(this.propiedades).forEach((el,i) => {
	          this.elemento.setAttribute(el, this.propiedades[el])
	        });

		} else {

			Object.keys(this.propiedades).forEach((el,i) => {
	          this.elemento.removeAttribute(el, this.propiedades[el])
	        });

		}

	}

	ejecutar (elemento) {
		this.viejoElemento()
		this.nuevoElemento(elemento)	
	}

}

export class FormaContactos {
	constructor(elemento, enviar) {
		this.elemento = elemento;
		this.botonEnviar = document.querySelector(`#${enviar}`)
		this.correo;
		this.ecorreo;
		this.asunto = document.querySelector(`#${this.elemento}-asunto`);
		this.msg    = document.querySelector(`#${this.elemento}-mensaje`);
	}

	eventos() {
		var th = this
		this.botonEnviar.addEventListener('click', (e)=> {
			th.correoUsuario()
		})
	}

	correoUsuario() {
		var th = this;
		var tools = new Herramientas();
		this.botonEnviar.disabled = true;

		(document.querySelector(`#${this.elemento}-correo`)) ? 
			(this.correo = document.querySelector(`#${this.elemento}-correo`).value,
			 this.ecorreo = document.querySelector(`#${this.elemento}-correo`)) 
			: (this.correo = null,
			   this.ecorreo = null);

		$.ajax({
			url: '../clases/correos.class.php',
			type: 'POST',
			dataType: 'html',
			data: {
				correoEmpresa:window.ce,
				correoUsuario:this.correo,
				mensaje:this.msg.value,
				asunto:this.asunto.value,
				f:'usuarioEmpresa',
			}
		}).done((respuesta) => {
			if (respuesta === 'icorreo') {	
				tools['mensaje'] = 'Correo inválido';
				tools.mensajes(false);
			} else if (respuesta === 'fallido') {
				tools['mensaje'] = 'Envío fallido';
				tools.mensajes(false);
			} else {
				tools['mensaje'] = 'mensaje enviado';
				tools.mensajes(true);

				this.asunto.value = '';
				this.msg.value = '';
				if (this.ecorreo != null) {this.ecorreo.value = ''}
			}
			this.botonEnviar.disabled = false;		
		})
	}
}
/////////////////////////////////////////////////////////////////////////////////////////77//////
export class customDesplegable {
	constructor(desplegable, abrir, cerrar, evt, wh, desplegado) {
		this.desplegable = qs(desplegable);
		this.estado      = false;
		this.abrir       = (qs(abrir)) ? qs(abrir) : false;
		this.cerrar      = (qs(cerrar)) ? qs(cerrar) : false;
		this.seguir      = true;
		this.horientacion= 'H';
		this.eventosAbrirCerrar = (typeof evt !== 'undefined') ? evt : ['click', 'click'];
		this.estilo      = ''
		this.desplegado  = true//(typeof desplegado !== 'undefined') ? desplegado : true;
		this.tiempo      = 600
		this.wh		 = (wh) ? wh : '500px';
		this.procesar = true
		this.prevenir = false
	}

	async toggle(modo) {

		var th = this

		if (this.procesar) {

			this.procesar = false

			if(modo === 'H') {

				if (this.desplegado) {

					qs('body').setAttribute('data-noo', '')

					this.desplegable.setAttribute('style', `${this.estilo}; width: 0px; overflow: hidden;`)
					this.desplegado = false

					await setTimeout(() => {

						this.desplegable.setAttribute('style', `${this.estilo}; width: fit-content; overflow: hidden; display:none; top: ${window.pageYOffset + 55}px;`)
						this.procesar = true

					}, this.tiempo)


				} else {

					if (this.wh === 'fit-content') {

						this.desplegable.setAttribute('style', `${this.estilo}; width: ${this.wh}; visibility: hidden;`)
						var ancho = (this.desplegable.getBoundingClientRect().width).toFixed(2)+'px'
						this.desplegable.setAttribute('style', `${this.estilo}; width: 0px;`)

					} else {

						this.desplegable.setAttribute('style', `${this.estilo}; width: 0px;`)
					}

					await setTimeout(() => {
						qs('body').removeAttribute('data-noo', '')	
					}, this.tiempo)

					setTimeout(() => {

						if (this.wh === 'fit-content') {

							this.desplegable.setAttribute('style', `${this.estilo}; width: ${ancho}; overflow: hidden;`)
							
						} else {

							this.desplegable.setAttribute('style', `${this.estilo}; width: ${this.wh}; overflow: hidden;`)
						}

						this.desplegado = true
						this.procesar = true

					}, 5)

				}

			} else if (modo === 'V') {

				if (this.desplegado) {

					qs('body').setAttribute('data-noo', '')

					this.desplegable.setAttribute('style', `${this.estilo}; height: 0px; overflow: hidden;`)
					this.desplegado = false

					await setTimeout(() => {

						this.desplegable.setAttribute('style', `${this.estilo}; height: fit-content; overflow: hidden; display:none; top: ${window.pageYOffset + 55}px;`)
						this.procesar = true

					}, this.tiempo)


				} else {

					if (this.wh === 'fit-content') {

						this.desplegable.setAttribute('style', `${this.estilo}; height: ${this.wh}; visibility: hidden`)
						var alto = (this.desplegable.getBoundingClientRect().height).toFixed(2)+'px'
						this.desplegable.setAttribute('style', `${this.estilo}; height: 0px; overflow:hidden`)

					} else {

						this.desplegable.setAttribute('style', `${this.estilo}; height: 0px; overflow:hidden`)
					}

					await setTimeout(() => {
						qs('body').removeAttribute('data-noo', '')	
					}, this.tiempo)

					setTimeout(() => { //luego restauraré la animación por ahora que al menos funciones

						if (this.wh === 'fit-content') {

							this.desplegable.setAttribute('style', `${this.estilo}; height: ${alto}; overflow: hidden;`)
							
						} else {

							this.desplegable.setAttribute('style', `${this.estilo}; height: ${this.wh}; overflow: hidden;`)
						}

						this.desplegado = true
						this.procesar = true

					}, 10)				

				}

			}
		}

	}

	accionar(){
		var th = this;
		
		this.toggle(this.horientacion)

	    if (!this.estado) {
	    	setTimeout(function() {
				th.estado = true
			}, 500)	
	    } else {
	    	this.estado = false
	    }

	    if (this.estado) {

			if(this.seguir) {

				setTimeout(() => {

					var ancho = th.desplegable.getBoundingClientRect().width.toFixed(2)
					th.desplegable.setAttribute('style', `${th.estilo}; width:${ancho}px; top: ${window.pageYOffset + 55}px;`)
					
				}, 300)
	
			}
	    }
	};

	eventos () {
		var th = this

		this.desplegable.setAttribute('data-efecto', 'toggle')
		this.estilo = this.desplegable.getAttribute('style')

		if (this.estilo === null) {this.estilo = ''}

		th.accionar()
		setTimeout(function() {
			th.desplegable.classList.remove('desplegable-oculto');
		}, 1000);

		if (this.abrir) {
			this.abrir.addEventListener(this.eventosAbrirCerrar[0], () => {
				th.desplegable.classList.remove('desplegable-oculto');
				if (th.prevenir === false) {
					th.accionar()
				}
			})
		}
		
		if (this.cerrar) {
			if(this.eventosAbrirCerrar[1] !== 'click') {
				this.desplegable.addEventListener(this.eventosAbrirCerrar[1], () => {
					th.accionar()
				})	
			}
				
			this.cerrar.addEventListener('click', () => {
				th.accionar()
			})

		}

		if(this.seguir) {
			window.addEventListener('scroll', e => {
				if (!th.estado) {

					var ancho = th.desplegable.getBoundingClientRect().width.toFixed(2)

					th.desplegable.setAttribute('style', `${th.estilo}; width:${ancho}px; top: ${window.pageYOffset + 55}px;`)// left: ${window.pageXOffset + 55}px`)

				}	
			})
		}

		window.addEventListener('keyup', (e) => {
			if (e.keyCode === 27 && !th.estado) {
			  	th.accionar()
			}	
		})
	}
}

/////////////////////////////////////////////////////////////////////////////////////////////////
export class textoPersonalizable {
	constructor () {
		var th = this
		
		this.alerta = 'no se ha declarardo ningún elemento para procesar el texto'
		this.elementos = {}
		this.elementoActual = ''

		this.simbolos = [
			"\\*",
			"\\_",
			"\\~",
			"\\°",
			"\\n"
		]

		this.reemplazos = {
			"\\*": (condicion) => {
				return (condicion) ? '<b>': '</b>';
			},
			"\\_": (condicion) => {
				return (condicion) ? '<u>': '</u>';
			}, 	 
			"\\~": (condicion) => {
				return (condicion) ? '<i>': '</i>';
			}, 
			"\\°": (condicion) => {
				return (condicion) ? "<br><div style='width:100%;text-align:center'>" : "</div>";
			}, 
			"\\n": (condicion) => {
				return '<br>'
			}
		}

		this.selectorSimbolos = {
			"\\*": true,
			"\\_": true,
			"\\~": true,
			"\\°": true,
			"\\n": true
		}
	}

	actual(elemento) {

		this.elementoActual = elemento

	}

	//declarar elemento [OBLIGATORIO]
	declarar(elemento, previa) { 

		elemento = (document.querySelector(elemento)) ? document.querySelector(elemento) : '';
		previa   = (document.querySelector(previa)) ? document.querySelector(previa) : undefined;

		this.elementos[elemento.id] = {
			"elemento": elemento,
			"previa": previa
		}

		this.elementos[elemento.id].elemento.texto_base = ''
		this.elementos[elemento.id].elemento.texto_html = ''

	}

	logica(texto) {

		var th = this,
			longitud = 0,
			resultado = '',
			txt = texto

		this.simbolos.forEach(simbolo => {

			var regex = new RegExp(simbolo); //g es para todos
			var regexCount = new RegExp(simbolo, "g");
			resultado = texto.match(regexCount);
			
			if (resultado) {

				th.selectorSimbolos[simbolo] = true
				longitud = resultado.length
				txt = txt

				for (var i = 0; i < longitud; i++) {

					if (th.selectorSimbolos[simbolo]) {

						txt = txt.replace(regex, th.reemplazos[simbolo](th.selectorSimbolos[simbolo]))

						th.selectorSimbolos[simbolo] = false

					} else {

						txt = txt.replace(regex, th.reemplazos[simbolo](th.selectorSimbolos[simbolo]))

						th.selectorSimbolos[simbolo] = true

					}

				}

			} else {

				txt = txt

			}

		})

		this.elementos[this.elementoActual].elemento.texto_base = texto
		this.elementos[this.elementoActual].elemento.texto_html = txt

		this.elementos[this.elementoActual].previa.innerHTML  = txt

	}

	//genera los eventos de cada elemento
	eventos(objeto) {

		if (Object.keys(this.elementos).length > 0) {

			var th = this

			objeto.elemento.addEventListener('keyup', e => {

				th.elementoActual = objeto.elemento.id

			  	th.logica(e.target.value)

			})

			objeto.elemento.addEventListener('click', e => {

				th.elementoActual = objeto.elemento.id

			  	th.logica(e.target.value)

			})


		} else {

			console.log(this.alerta)

		}

	}

	//llama a todo a la vez en el orden adecuado
	init() { 

		if (Object.keys(this.elementos).length > 0) {

			var th = this

			Object.keys(this.elementos).forEach(obj => {

				th.eventos(th.elementos[obj])

			})

		} else {

			console.log(this.alerta)

		}

	}
}

/////////////////////////////////////////////////////////////////////////////////////////
export class InputsDecimales {
	constructor(inputs, separador, decimales) {
  
  	this._inputs    = document.querySelectorAll(`${inputs}`)
    this._separador = (separador) ? separador : '.';
    this._decimales = (decimales) ? decimales : 2;
  
  }
  
  replaceAll (find, replace) {
    var str = this;
    return str.replace(new RegExp(find.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&'), 'g'), replace);
  };
  
  comportamiento (valor) {
  
  	var linea = ''
  
  	valor = valor.replaceAll(this._separador, '');
   
   	if (valor.length === this._decimales) {

      linea = valor.substring(0, valor.length - 1) + this._separador + valor.substring(valor.length, valor.length - 1);
      
    } else if (valor.length > this._decimales) {

      linea = valor.substring(0, valor.length - this._decimales) + this._separador + valor.substring(valor.length, valor.length - this._decimales);
      
    } else {
    
    	linea = valor
    
    }
    
    return linea
  
  }
  
  init () {
  
  		var th = this
  	
    	this._inputs.forEach(input => {
      
      	input.addEventListener('keyup', el => {
        
        	el.target.value = th.comportamiento(el.target.value)
          
        })
      
      })
    
  }
  	
}

/////////////////////////////////////////////////////////////////////////////////////////
export class PaginacionContenedores {

	constructor(contenedor, botones, tabla, resaltar) {
		this.contenedor = (qs(contenedor)) ? qs(contenedor) : '';
		this.ultimoSeleccionado = ''
		this.controlador = botones
		this.resaltar = (resaltar) ? resaltar : false;
		this.tabla = tabla
	}

	ocultar() {
		this.contenedor.setAttribute('data-hidden', '')
	}

	mostrar() {
		this.contenedor.removeAttribute('data-hidden')
	}

	cambiarContenedor(nuevoSeleccionado) {

		//var button = (tools.esDOM(nuevoSeleccionado)) ? e : e.target;
		//
		if (window.procesar) {

			window.procesaar = false

			this.controlador[this.ultimoSeleccionado]['pop']()

			this.tabla.crud.customBodyEvents[nuevoSeleccionado](this.controlador[nuevoSeleccionado].boton)

			this.cambiarUltimoSeleccionado(nuevoSeleccionado)

			setTimeout(() => {
				qs('body').classList.add('no-scroll')
				window.procesaar = true
			}, 400)

		}

	}

	cambiarUltimoSeleccionado(seleccionado) {
		this.ultimoSeleccionado = seleccionado
	}

	actualizarFamiliaDeBotones(tr) {

		var th = this

		Object.keys(this.controlador).forEach(el => {

			th.controlador[el]['boton'] = tr.querySelector(`.${el}`)

		})

	}

	abrirContenedorRemoto(ref) {
		
		if (this.resaltar !== false) {

		}

		this.resaltar.ejecutar(`#${this.contenedor.id} .${ref}`)

		if (this.ultimoSeleccionado === '') {
			this.cambiarUltimoSeleccionado(ref)
		}

		if (this.tabla.tr !== '') {
			this.actualizarFamiliaDeBotones(this.tabla.tr)
		} else {
			this.actualizarFamiliaDeBotones(tools.pariente(qs(`#tabla-historias tbody tr .${ref}`), 'TR'))

		}

		this.cambiarContenedor(ref)
	}

}

/////////////////////////////////////////////////////////////////////////////////////////77//////
export default '';

/////////////////////////////////////////////////////////////////////////////////////////
document.querySelector('head').insertAdjacentHTML('afterbegin', '<link rel="stylesheet" type="text/css" href="../css/cdn.css" defer>')
/////////////////////////////////////////////////////////////////////////////////////////
window.sesiones = async function (nolog) {

	var params = `funcion=valor_sesion&clase=index&datos=[]`,
		resultado = null;

	var peticion = new XMLHttpRequest();
    	peticion.overrideMimeType("application/json");
    	peticion.open('POST', '../controladores/controlador.php', true);  
    	peticion.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    	peticion.send(params);

	await new Promise(resolve => {
		peticion.onreadystatechange = function() {
		     if (this.readyState == 4 && this.status == 200) {
	    		resolve(this.responseText)
	    	}
		};
	}).then(datos => {

	    resultado = datos;

	});
	
	if (typeof nolog === 'undefined') {

		console.log(JSON.parse(resultado))

	}

	return JSON.parse(resultado)
}
/////////////////////////////////////////////////////////////////////////////////////////
var sesiones = await window.sesiones(true)
/////////////////////////////////////////////////////////////////////////////////////////