//2022 © Luis Daniel Carvajal Chacón
//ldcch2016@gmail.com
window.qs    = document.querySelector.bind(document)
window.qsa   = document.querySelectorAll.bind(document)
window.gid = document.getElementById.bind(document)

export class Tabla {
  constructor(cabecera, tabla, buscador, limitador,anterior, siguiente, posicion, numeracion) {
    //-------------------------------------- //Propiedades
    this.cabecera = cabecera
    this.tabla    = tabla
    this.numerar  = numeracion
    this.buscador = (gid(buscador)) ? gid(buscador) : '';
    this.busqueda = ''
    this.anterior = (qs(`#${anterior}`)) ? qs(`#${anterior}`) : '';
    this.siguiente= (qs(`#${siguiente}`)) ? qs(`#${siguiente}`) : '';
    this.posicion = (qsa(`.${posicion}`).length > 0) ? Array.from(qsa(`.${posicion}`)) : '';
    this.nombPosi = posicion
    this.pagMin   = 0
    this.pagForce = limitador
    this.pagMax   = this.pagForce  
    this.pagPosi  = 1
    this.columna;
    this.lista      = []
    this.cuerpo     = []
    this.estructura = []
    this.inputLista = []
    this.checkLista = []
    this.resetLista = []
    this.fLista = [false, {
        meth: {},
        true: (ele) => { //ele son los tr de la tabla

          var meth = this.fLista[1].meth
            
          Object.keys(meth).forEach((el,i) => {
            meth[el](ele)
          });
        }, 
        false: (ele) => {return false}
      }
    ]
    this.inputHandler = [{"input": 0}, false]
    this.inputNavegar = false
    this.inputNavegarGenerar = true
    this.coordenadas = [0,0]
    this.desplazamientoActivo = [true, true, true , true]
    this.especificos = []
    this.filtro = 'parecido'
    this.limitador  = 0
    this.limitante  = 0
    this.btnBuscar  = ''
    this.eForzar    = false
    this.alternar   = [true,'#cccccc42', '#ffffff']
    this.ofv        = false
    this.ofvh       = '700px'
    this.funcion = ''
    this.clase   = ''
    this.sublistas = true
    this.excepciones = []
    this.customHeaderEvents = {}
    this.customBodyEvents = {}
    this.customWindowEvents = {}
    this.customBubblingEvents = {}
    this.customKeyEvents = {}
    this.parametrosBusqueda = []
    this.propiedadesTr = {}
    this.seleccionadoTr = ''
    this.autoBusqueda = false
    this.autoBusquedaPermitir = true
    this.peticionActual = ''
    this.introBusqueda = true
    this.retornarSiempre = true
    this.collator = new Intl.Collator(undefined, {  caseFirst: false , numeric: true, sensitivity: 'base' })
    //-------------------------------------- //Clones
    this.td = document.createElement('td')
    this.th = document.createElement('th')
    this.bt = document.createElement('button')
    this.a  = document.createElement('a')
    this.tr = document.createElement('tr')
    this.div = document.createElement('div')
    this.span = document.createElement('span')  
    this.input = document.createElement('input')
  }

  //-------------------------------------- // Fenerar fila
  
  generarColumnas(elemento, acciones, asignacion, claseGlobal, valor) {

    //elemento: El tipo de tag que se coloca en la columnas
    //acciones: Si hay un solo elemento determinar si el valor que se coloca en la columna es literal, o el valor de una lista / si hay mas de un elemento funciona como el valor de la lista ()los roles se invierten
    //asignacion: Lugar en donde se va a colocar el dato de la columna
    //claseGlobal
    //valor literal, lista o funcionalmente equivalente a "acciones" en el contexto de tener más de un elemento en la columna

    var th = this

    var domElements = {
      "gSpan": (el) => {th.gSpan(el[1], el[2])},
      "gBt"  : (el) => {th.gBt()}
    }

    this.columna = this.cuerpo.length

    this.cuerpo.push(
      [
        th.cuerpo.length, 
        [domElements[elemento[0]](elemento)],
        acciones,
        asignacion, 
        claseGlobal, 
        valor
      ]
    )

  }

  //-------------------------------------- //Elementos dentro de la tabla
  gTd (clases, html) {
    var td = this.td.cloneNode()
    
    if(this.estructura[this.columna] === undefined) {
      this.estructura[this.columna] = new DocumentFragment();
    }
    
    if (clases != null) {td.setAttribute('class', clases);}
    if (html   != null) {td.insertAdjacentText('afterbegin', html);}
    this.estructura[this.columna].appendChild(td);   
  }

  gSpan (clases, html) {
    var span = this.span.cloneNode()

    if(this.estructura[this.columna] === undefined) {
      this.estructura[this.columna] = new DocumentFragment();
    }
    
    if (clases != null) {span.setAttribute('class', clases);}
    if (html   != null) {span.insertAdjacentText('afterbegin', html);}
    this.estructura[this.columna].appendChild(span);   
  }
  
  gTh (clases, html) {
    var th = this.th.cloneNode()
    
    if(this.estructura[this.columna] === undefined) {
      this.estructura[this.columna] = new DocumentFragment();
    }
    
    if (clases != null) {th.setAttribute('class', clases)}
    if (html   != null) {th.insertAdjacentText('afterbegin', html)}
    this.estructura[this.columna].appendChild(th);  
  }
  
   gTa (clases, html) {
    var a = this.a.cloneNode()
    
    if(this.estructura[this.columna] === undefined) {
      this.estructura[this.columna] = new DocumentFragment();
    }
    
    if (clases != null) {a.setAttribute('class', clases)}
    if (html   != null) {a.insertAdjacentText('afterbegin', html)}
    this.estructura[this.columna].appendChild(a);  
  }
  
  gBt (clases, html) {
    var bt = this.bt.cloneNode()
    if(this.estructura[this.columna] === undefined) {
      this.estructura[this.columna] = new DocumentFragment();
    }

    if(typeof(clases) === 'object') {
      if (clases != null) {
        bt.setAttribute('class', clases[0])
        bt.setAttribute('title', clases[1])
        if(clases.length > 1) {
          bt.setAttribute('style', clases[2])
        }
      }
    } else {
      if (clases != null) {bt.setAttribute('class', clases)} 
    }

    if (html != null) {bt.insertAdjacentHTML('afterbegin', html)}
    this.estructura[this.columna].appendChild(bt);   
  }
  
  gDiv (clases, html) {
    var div = this.div.cloneNode()
    if(this.estructura[this.columna] === undefined) {
      this.estructura[this.columna] = new DocumentFragment();
    }
    if (clases != null) {div.setAttribute('class', clases)}
    if (html   != null) {div.insertAdjacentHTML('afterbegin', html)}
    this.estructura[this.columna].appendChild(div);   
  }

  gInp (clases, type, title, atributos, style) {
    var input = this.input.cloneNode()
    if(this.estructura[this.columna] === undefined) {
      this.estructura[this.columna] = new DocumentFragment();
    }
    if (clases != null) {input.setAttribute('class', clases)}
    if (type   != null) {input.setAttribute('type', type)} else {input.setAttribute('type', 'text')}
    if (title  != null) {input.setAttribute('title', title)}
    if (style  != null) {input.setAttribute('style', `${style}`)}

    if (atributos != null) {
      atributos.forEach((e,i) => {
        input.setAttribute(e['atributo'], e['valor'])
      });  
    }

    this.estructura[this.columna].appendChild(input);   
  }

  gCheck (clases, title, atributos, style, propiedades) {
    var input = this.input.cloneNode()
    if(this.estructura[this.columna] === undefined) {
      this.estructura[this.columna] = new DocumentFragment();
    }
    if (clases != null) {input.setAttribute('class', clases)}
    if (title  != null) {input.setAttribute('title', title)}
    if (style  != null) {input.setAttribute('style', `${style}`)}

    if (atributos != null) {
      atributos.forEach((e,i) => {
        input.setAttribute(e['atributo'], e['valor'])
      });  
    }

    input.setAttribute('type', 'checkbox')

    if(typeof(propiedades) !== 'undefined') {

      if(typeof(propiedades['clase']) !== 'undefined') {input.setAttribute('data-clase', propiedades['clase'])}

      if(typeof(propiedades['positivo']) !== 'undefined' || typeof(propiedades['negativo']) !== 'undefined') {
        input.setAttribute('data-positivo', propiedades['positivo'])
        input.setAttribute('data-negativo', propiedades['negativo'])
      } else {
        input.setAttribute('data-positivo', 1)
        input.setAttribute('data-negativo', 0)
      }

      if(typeof(propiedades['id']) !== 'undefined') {input.setAttribute('data-idcheck',  propiedades['id'])} else {
        console.log('requiere especificar ID')
      }

    } else {
      console.log('propiedades de checkbox indefinida')
    }

    this.estructura[this.columna].appendChild(input);   
  }

  //-------------------------------------- //Código reutilizado
  trozos(funcion, datos) { //abre las puertas a mucha compactacion de codigo
    var th = this
    var lista = {
      "pariente": function fn(params = datos) { //remover este poco a poco, primero en el crud, luego en donde lo utilizo por la de main
        var detener  = 1
        for (var i = 0; i < detener; i++) {      
          if(params.tagName !== 'TR') {
              params = params.parentElement
              detener++
          }     
          if(detener > 10) {i = 100000}
        }
        return params
      },
      "parientePreciso": function fn(elemento = datos[0], padre = datos[1], forzar = datos[2]) {
        var detener  = 1
        for (var i = 0; i < detener; i++) {      
          if(elemento.tagName !== padre) {
              elemento = elemento.parentElement
              detener++
          }     
          if(detener > forzar) {i = 100000}
        }
        return elemento
      }
    }

    if(lista[funcion]) {
      return lista[funcion]()
    }    
  }

  //--------------------------------------- //Funcionalidades extras
  ascDesc(titulo, accion) { 
    var array = this.busqueda
    if (array.length) {
      if (accion === 'ASC') {
        array.sort((a, b) => {
          return this.collator.compare(a[titulo], b[titulo]);
        });
      } else {
        array.sort((a, b) => {
          return this.collator.compare(b[titulo], a[titulo]);
        });
      }
      if (this.posicion.length > 0){

        if(this.posicion[0].tagName === 'INPUT') { this.posicion[0].value = 1 } else { this.posicion[0].innerHTML = 1 }  

        this.pagMin  = 0
        this.pagPosi = 1
      }
      this.busqueda = array
      qs(`#${this.tabla} tbody`).innerHTML = ''
      this.generar(true)
    }
  }
  
  filtrarPor(filtro, grupo, datos) {
    var th = this
    var lista = {
      "preciso": {
        "string": function fn() {
          if(datos[0] === datos[1]) { return [true, datos[1]] } else { return [false, null] }
        },
        "number": function fn() {
          if(datos[0] === datos[1]) { return [true, datos[1]] } else { return [false, null] }
        },
        "object": function fn() {
          if(datos[0] === datos[1]) { return [true, datos[1]] } else { return [false, null] }
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
      }
    }
    return lista[filtro][grupo]()
  }
  
  filtrar(arr, query) {
    var th = this
    if (this.limitador < this.limitante) {
      this.limitador = this.limitador + 1
    } else {

      //console.log(arr)

      //especificos (campo que contiene las columnas de filtros parecidos y precisos) se reinicia

      var detener = false
      var array = arr.filter(function(el) {
        for (var r = 0; r < Object.keys(el).length; r++) {//itera cada fila
          var respuesta = []
          for (var n = 0; n < th.especificos.length; n++) {//itera columnas espeficicas

            var resultado

            if (typeof(el[th.especificos[n]]) === 'string'){

              resultado = th.filtrarPor(th.filtro, 'string', [el[th.especificos[n]], query, el])
              detener   = resultado[0]
              respuesta = resultado[1] 

            } else if (typeof(el[th.especificos[n]]) === 'number') {

              var letras = '' + el[th.especificos[n]]
              resultado = th.filtrarPor(th.filtro, 'number', [letras, query, el])
              detener   = resultado[0]
              respuesta = resultado[1]  

            } else if (typeof(el[th.especificos[n]]) === 'object') {

              resultado = th.filtrarPor(th.filtro, 'object', [el[th.especificos[n]], query, el])
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

      if (this.posicion.length > 0) {

        if(this.posicion[0].tagName === 'INPUT') { this.posicion[0].value = 1 } else { this.posicion[0].innerHTML = 1 }  

        this.limitador = 0
        this.pagMin  = 0
        this.pagPosi = 1
      }

      //console.log(array)

      if(array.length < 1) {
        
        if (this.autoBusqueda && this.buscador) {

          this.autoBusquedaPermitir = false

          qs(`#${this.tabla} tbody`).innerHTML = ''

          var div = this.div.cloneNode('div')
              div.setAttribute('class', 'crud-mensaje-busqueda')
              div.insertAdjacentText('afterbegin', '')
              qs(`#${this.tabla} tbody`).appendChild(div)

          //valida la petición más reciente y cancela las anteriores para ahorrar recursos
          if (this.peticionActual !== '') {
            this.peticionActual.abort()
          }

          this.peticionActual = th.busquedaSql()
            this.peticionActual.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {

                //qs(`#${th.tabla} tbody`).innerHTML = ''
                th.limitador = th.limitante
                th.busqueda = JSON.parse(this.responseText)
                //th.lista = JSON.parse(this.responseText)

                if (th.busqueda.length > 0) {

                  th.generar(true)

                } else {

                  qs(`#${th.tabla} tbody`).innerHTML = ''

                  var div = th.div.cloneNode('div')
                      div.setAttribute('class', 'crud-mensaje-sin')
                      div.insertAdjacentText('afterbegin', '')
                      qs(`#${th.tabla} tbody`).appendChild(div)

                  setTimeout(() => {

                    if (th.retornarSiempre) {

                      th.busqueda = th.lista

                    } else {

                      th.busqueda = []

                    }

                    th.generar(true)  
                  }, 2500)

                }       
                
                th.autoBusquedaPermitir = true

              } else {

                th.autoBusquedaPermitir = true

              }

            }

        } else {
          th.busqueda = th.lista
          th.generar(true)
        }

      } else {

        //qs(`#${this.tabla} tbody`).innerHTML = '' //no deberia ser más necesario
        this.busqueda = array
        this.generar(true)

      }

    }
  }

  reposicionar(op, salto) {
    if(salto !== 'FIX') {
      if(!salto) {  

        (this.pagPosi + op < 1) ? this.pagPosi = 1 : this.pagPosi = this.pagPosi + op;   
        (this.pagPosi > Math.ceil(this.busqueda.length / this.pagForce)) ? this.pagPosi = Math.ceil(this.busqueda.length / this.pagForce) : '';

      } else {

        if(op > Math.ceil(this.busqueda.length / this.pagForce)) {op = Math.ceil(this.busqueda.length / this.pagForce)} 
        if (op < 1) {op = 1} 
        this.pagPosi = op

      }
           
      this.pagMin = this.pagPosi
      
      if(this.posicion.length > 0) {
        if(this.posicion[0].tagName === 'INPUT') { this.posicion[0].value = this.pagPosi } else { this.posicion[0].innerHTML = this.pagPosi }        
      }
      
      var base, min, max
          base = this.pagMin * this.pagForce
          min  = base - this.pagForce
          max  = this.pagMin * this.pagForce 
    } else {

      var base, min, max
          base = this.pagPosi * this.pagForce
          min  = base - this.pagForce
          max  = this.pagPosi * this.pagForce   
    }
    
    qs(`#${this.tabla} tbody`).innerHTML = ''
           
    this.pagMin = min
    this.pagMax = max
    this.generar(true) 
  }

  botonForzar() {
    //qs(`#${this.tabla} tbody`).innerHTML = ''
    this.limitador = this.limitante
    this.filtrar(this.lista, this.buscador.value)
  }

  botonBuscar(elemento, exclusivo) {
    var th = this
    if (qs(`#${elemento}`)) {

      this.btnBuscar = qs(`#${elemento}`)

      if(typeof this.btnBuscar['generado'] === 'undefined') {
        this.btnBuscar['generado'] = true
        if (exclusivo === true) {
          this.buscador.removeEventListener('input', this.buscador.fn)
        } 

        window.addEventListener('keyup', e => {
          if (e.keyCode === 13 && document.activeElement === th.buscador) {
            //qs(`#${th.tabla} tbody`).innerHTML = ''
            th.limitador = th.limitante
            th.filtrar(th.lista, this.buscador.value)
          }
        })

        if (this.clase === '' && this.funcion === '') {
          this.btnBuscar.addEventListener('click', e => {
              //qs(`#${th.tabla} tbody`).innerHTML = ''
              th.limitador = th.limitante
              th.filtrar(th.lista, this.buscador.value)

              if(typeof(th.btnBuscar.disparar) === 'function') {
                th.btnBuscar.disparar()
              } 
          })
        } else {
          this.btnBuscar.addEventListener('click', e => {
            var img = document.createElement('img');
            img.src = '../imagenes/spinner.gif';
            img.style = 'width: 5vh;height: 5vh;position: absolute;top: 48%;left: 46%;';
            qs(`#${th.tabla} tbody`).appendChild(img)

            var peticion = th.busquedaSql()
            peticion.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {
                //qs(`#${th.tabla} tbody`).innerHTML = ''
                th.limitador = th.limitante
                th.busqueda = JSON.parse(this.responseText)
                th.lista = JSON.parse(this.responseText)
                th.generar(true)

                if(typeof(th.btnBuscar.disparar) === 'function') {
                  th.btnBuscar.disparar()
                } 
              }
            };         
          })
        } 
      } else {
        console.log('btngenerado undefined')
      }  
    } else {
      console.log('no existe')
    }
  }

  botonModoBusqueda(elemento, opcion, especificos, funciones) {
    var th = this, 
        customFunciones,
        modo = {0: "preciso", 1: "parecido"},
        elemento = qs(elemento);

    (typeof funciones === 'undefined') ? customFunciones = {} : customFunciones = funciones;

    elemento['opcion'] = opcion
    elemento.classList.add('tooltip-principal')
    elemento.addEventListener('click', (e) => {
      (e.target.opcion === 0) ? e.target.opcion = 1 : e.target.opcion = 0;
      th.especificos = especificos[e.target.opcion]
      th.filtro = modo[e.target.opcion]

      Object.keys(customFunciones).forEach(el => {
          customFunciones[el](e)
      });
    })
  }
//---------------------------------------------Elementos especiales
  inputEliminar (comparacion, params, funciones) {
    var th = this

    qs(`#${th.tabla}`).addEventListener('click', e => {
      if(e.target.classList.contains(comparacion)) {
        funciones[0](e)

        var pariente = th.trozos('pariente', e.target.parentElement),
            listados = {
              "lista": false,
              "busqueda": false,
              "check": false,
              "input": false
            }

        var sublista = pariente.sublista,
            ejecutar = {
              "object": (el, datos, i, origen) => {

                if (String(sublista[el.target.dataset.columna]) === String(datos[i][el.target.dataset.columna]) && datos.length > 0) {
      
                  datos.splice(i, 1)
                  listados[origen] = true

                }

              },
              "undefined": () => {}
            }
            

        //DE MOMENTO NO QUITAR EL CODIGO COMENTADO
        //----------------------------------------
        for (var i = 0; i < th.lista.length; i++) {

          // if(String(pariente['sublista'][e.target.dataset.columna]) === String(th.lista[i][e.target.dataset.columna])) {
          //   th.lista.splice(i, 1)
          //   break;
          // }

          ejecutar[typeof th.lista[i]](e, th.lista, i, 'lista')
          ejecutar[typeof th.busqueda[i]](e, th.busqueda, i, 'busqueda')
          ejecutar[typeof th.checkLista[i]](e, th.checkLista, i, 'check')
          ejecutar[typeof th.inputLista[i]](e, th.inputLista, i, 'input')

          if (listados['lista']) {
            break;
          }

        }

        // for (var i = 0; i < th.busqueda.length; i++) {
        //   if(String(pariente['sublista'][e.target.dataset.columna]) === String(th.busqueda[i][e.target.dataset.columna])) {
        //     th.busqueda.splice(i, 1)
        //     break;
        //   }
        // }

        // for (var i = 0; i < th.inputLista.length; i++) {
        //   if(String(pariente['sublista'][e.target.dataset.columna]) === String(th.inputLista[i][e.target.dataset.columna])) {
        //     th.inputLista.splice(i, 1)
        //     break;
        //   }
        // }

        // for (var i = 0; i < th.checkLista.length; i++) {
        //   if(String(pariente['sublista'][e.target.dataset.columna]) === String(th.checkLista[i][e.target.dataset.columna])) {
        //     th.checkLista.splice(i, 1)
        //     break;
        //   }
        // }

        pariente.remove()
        funciones[1](e)

        qs(`#${th.tabla} tbody`).innerHTML = ''
        qs(`#${th.tabla} thead`).innerHTML = ''
        th.generarCabecera()
        th.reposicionar(th.pagPosi, 'FIX')
      }
    })  
  }

  inputAccion(tipo, boton, elementos, comparacion, params, funciones) {
    var th = this, editar = false

    if(typeof(params['pariente']) !== 'undefined') {
      qs(params['pariente'][0]).addEventListener('click', e => {
        if(e.target.classList.contains(params['pariente'][1])) {

          var pariente = th.trozos('pariente', e.target.parentElement),
              nuevo    = true

          qs(boton)['sublista'] = pariente['sublista']
        }
      })
    }

    qs(boton)['incremento'] = 0
    qs(boton).addEventListener('click', e => {

      var pariente = '', procesar = true, nuevo = true, detener = false, limite = 0, datos = {}, contenedores = qsa(elementos), posicion = '', posicionLista = '', posicionInputLista = ''

      if(typeof(funciones['inicio']) !== 'undefined') {funciones['inicio'](e)}
      if(typeof(params['modo']) !== 'undefined') {editar = params['modo']}

      if(typeof(funciones['procesando']) !== 'undefined') {
        funciones['procesando'](e)
      }

      //genera la lista a insertar y editar
      if(!editar) {

        datos[params['id']] = `t${qs(boton).incremento}`

      } else {

        datos[params['id']] = qs(boton)['sublista'][params['id']]//????
        pariente = qs(boton)['sublista']

      }

      if (tipo === 'indirecta') {

        if(typeof(funciones['listaPreprocesada']) !== 'undefined') {
          datos = funciones['listaPreprocesada'](e.target)
          if(datos === '') {
            procesar = false;
          }
        } else {
          contenedores.forEach((e,i) => {
            if(e.value === '' && e.classList.contains('lleno')) {
              procesar = false
              if(typeof(funciones['alerta']) !== 'undefined') {
                  funciones['alerta'](e)
              }
            } else {
              datos[e.dataset.name] = th.dataRevision(e)
            }
          })
        } 

        qs(boton).incremento++

        if(th.lista.length > 0) {
          var reorden  = Object.keys(th.lista[0])
          var ordenado = {}

          reorden.forEach(e => {
            ordenado[e] = datos[e]
          })
          datos = ordenado
        }

        if (procesar) {

          //compara la lista a insertar con la lista del crud
          for (var i = 0; i < th.lista.length; i++) {
            for (var ci = 0; ci < comparacion.length; ci++) {
              if (!isNaN(comparacion[ci])) {
                if (th.lista[i][Object.keys(th.lista[i])[comparacion[ci]]] === datos[Object.keys(datos)[comparacion[ci]]]) { posicion = i; nuevo = false; limite++} else { posicion = ''; nuevo = true; limite = 0; break}
              } else {
                if (th.lista[i][comparacion[ci]] === datos[comparacion[ci]]) { posicion = i; nuevo = false; limite++} else { posicion = ''; nuevo = true; limite = 0; break}
              }
              if (limite === comparacion.length) {detener = true}
            }
            if(detener) {break}
          }
          
          //inserta o actualiza los casos respecto a la comparacion
          if(!editar && nuevo) {

            th.lista.push(datos)
            th.inputLista.push(datos)

            if (th.busqueda.length !== th.lista.length) {
              th.busqueda.push(datos)
            }

            //th.busqueda = th.lista

            qs(`#${th.tabla} tbody`).innerHTML = ''
            qs(`#${th.tabla} thead`).innerHTML = ''
            th.generarCabecera()
            th.reposicionar(th.pagPosi, true)

            if(typeof(funciones['procesado']) !== 'undefined') {
              funciones['procesado'](e)
            }

          } else if (editar && !nuevo) {

            Object.keys(th.lista[posicion]).forEach((e, i) => {
              pariente[e] = datos[e]
              th.lista[posicion][e] = datos[e]
            })

            qs(`#${th.tabla} tbody`).innerHTML = ''
            qs(`#${th.tabla} thead`).innerHTML = ''
            th.generarCabecera()
            th.reposicionar(th.pagPosi, true)

            if(typeof(funciones['procesado']) !== 'undefined') {
                funciones['procesado'](e)
            }
            
          } else {
            if(typeof(funciones['alertaInsertar']) !== 'undefined') {
                funciones['alertaInsertar'](e)
            }    
          }
        } else {
          qs(boton).incremento--
        }
      } else if (tipo === 'directa') {

        //var procesar = true, nuevo = true, detener = false, limite = 0, datos = {}, contenedores = qsa(elementos), posicion = ''
        if(e.target.classList.contains(params['boton'])) {

          var datos = th.trozos('pariente', e.target.parentElement)['sublista']

          if(th.lista.length > 0) {
            var reorden  = Object.keys(th.lista[0])
            var ordenado = {}

            reorden.forEach(e => {
              ordenado[e] = datos[e]
            })

            datos = ordenado
          }

          for (var i = 0; i < th.lista.length; i++) {
      
            for (var ci = 0; ci < comparacion.length; ci++) {

              if (!isNaN(comparacion[ci])) {
                if (th.lista[i][Object.keys(th.lista[i])[comparacion[ci]]] === datos[Object.keys(datos)[comparacion[ci]]]) {

                  posicion = i; 
                  nuevo = false; 
                  limite++

                } else { 

                  posicion = ''; 
                  nuevo = true; 
                  limite = 0; 
                  break

                }
              } else {
                if (th.lista[i][comparacion[ci]] === datos[comparacion[ci]]) { posicion = i; nuevo = false; limite++} else { posicion = ''; nuevo = true; limite = 0; break}
              }

              if (limite === comparacion.length) {detener = true}
            }

            if(detener) {break}
          }

          if(!editar && nuevo) {

            th.lista.push(datos)
            th.inputLista.push(datos)
           
            if (th.busqueda.length !== th.lista.length) {
              th.busqueda.push(datos)
            }

            qs(`#${th.tabla} tbody`).innerHTML = ''
            qs(`#${th.tabla} thead`).innerHTML = ''
            th.generarCabecera()
            th.generar(true)

            if(typeof(funciones['procesado']) !== 'undefined') {
                funciones['procesado'](e)
            }

          } else if (editar && !nuevo) {

            Object.keys(th.lista[posicion]).forEach((e, i) => {
              pariente['sublista'][e] = datos[e]
              th.lista[posicion] = datos[e]
            })  
           
            qs(`#${th.tabla} tbody`).innerHTML = ''
            qs(`#${th.tabla} thead`).innerHTML = ''
            th.generarCabecera()
            th.generar(true)
            
          } else {
            if(typeof(funciones['duplicado']) !== 'undefined') {
                funciones['duplicado'](e)
            }           
          }
        }
      } else if (tipo === 'seleccion') {
        if(e.target.classList.contains(comparacion)) {
          lista.forEach((e, i) => {
            
          })
        }
      }
    })
  }

  //inputAccionD(boton, contenedor, comparacion, lista, params, funciones) 
  inputProcesar(comparacion) {
    var th = this

    qs(`#${this.tabla}`).addEventListener('change', qs(`#${this.tabla}`).inputActualizacionForzada = (e) => {
      var elemento
      if(typeof e.tagName === 'undefined') {elemento = e.target} else {elemento = e}

      if(elemento.tagName === 'INPUT') {
        if(typeof(comparacion['input']) !== 'undefined') {
          if(elemento.value !== elemento.dataset.value && elemento.type !== 'checkbox') {

            elemento.dataset.value = elemento.value

            var posicion = 0,
                pariente = th.trozos('pariente', elemento.parentElement),
                nuevo    = true 

            pariente['sublista'][elemento.dataset.columna] = elemento.value
            th.inputLista.filter((el, i) => {
              if(el[Object.keys(el)[comparacion['input']]] === pariente['sublista'][Object.keys(el)[comparacion['input']]]) {
                posicion = i
                nuevo = false
              }
            });
            (nuevo) ? th.inputLista.push(pariente['sublista']) : th.inputLista[posicion][elemento.dataset.columna] = elemento.value;

            qs(`#${th.tabla} tbody`).innerHTML = ''
            qs(`#${th.tabla} thead`).innerHTML = ''

            if(typeof th.inputHandler[0]['inputPreProcesado'] !== 'undefined') {
              th.inputHandler[0]['inputPreProcesado'](elemento)
            }

            th.generarCabecera()
            th.reposicionar(th.pagPosi, 'FIX')

            if(typeof th.inputHandler[0]['inputProcesado'] !== 'undefined') {
              th.inputHandler[0]['inputProcesado'](elemento)
            }
          }
        }

        if(typeof comparacion['checkbox'] !== 'undefined') {
          if(elemento.type === 'checkbox') {
            var posicion = 0,
                pariente = th.trozos('parientePreciso', [elemento, 'TR', 10]),
                checkboxes = pariente.querySelectorAll('[type="checkbox"]'),
                nuevo    = true,
                marcados = true,
                valor    = '',
                asociar  = Object.keys(pariente['sublista'])
                

            if(elemento.checked) {

              valor = elemento.dataset.positivo
              pariente['sublista'][elemento.dataset.columna] = valor

              //comparar si un checkbox dentro de la fila esta marcado, si lo esta si añade a checklista si no se quita fila de checklista
              checkboxes.forEach(el => {
                if(el.checked)  {
                  marcados = false
                }
              });

              th.checkLista.filter((el, i) => {
                if(el[Object.keys(el)[comparacion['checkbox']]] === pariente['sublista'][Object.keys(el)[comparacion['checkbox']]]) {
                    posicion = i
                    nuevo = false
                  }
              });

              if(nuevo) {
                th.checkLista.push(pariente['sublista'])
              } else if (marcados && !nuevo) {
                th.checkLista[posicion][elemento.dataset.columna] = pariente['sublista'];
              } else {
                th.checkLista[posicion][elemento.dataset.columna] = valor;
              }

            } else {

              valor = elemento.dataset.negativo
              pariente['sublista'][elemento.dataset.columna] = valor

              checkboxes.forEach(el => {
                if(el.checked)  {
                  marcados = false
                }
              });

              for (var i = 0; i < th.checkLista.length; i++) {

                if(marcados && th.checkLista[i][Object.keys(th.checkLista[i])[comparacion['checkbox']]] === pariente['sublista'][Object.keys(th.checkLista[i])[comparacion['checkbox']]]) {
                  th.checkLista.splice(i, 1)
                  break;
                }
              }
            }

            qs(`#${th.tabla} tbody`).innerHTML = ''
            qs(`#${th.tabla} thead`).innerHTML = ''

            if(typeof th.inputHandler[0]['checkPreProcesado'] !== 'undefined') {
              th.inputHandler[0]['checkPreProcesado'](elemento)
            }

            th.generarCabecera()
            th.reposicionar(th.pagPosi, 'FIX')

            if(typeof th.inputHandler[0]['checkProcesado'] !== 'undefined') {
              th.inputHandler[0]['checkProcesado'](elemento)
            }
          }
        }
      }

      if (qsa(`#${th.tabla} tbody tr`)[this.coordenadas[0]].children[this.coordenadas[1]].querySelector('input')) {
        qsa(`#${th.tabla} tbody tr`)[this.coordenadas[0]].children[this.coordenadas[1]].querySelector('input').select()
      }
    })
  }

  inputPeticion(boton, params, funciones, procesables) {
    var th = this

    qs(boton).addEventListener('click', e => {
      var listas = []
      var datos = {
        'inputLista': th.inputLista,
        'checkLista': th.checkLista,
        'lista': th.lista
      }

      if(funciones.length > 0) {
        if(typeof(funciones[0](e)) === 'function') {
          funciones[0](e)
        }
      }

      procesables.forEach((e, i) => {
        if(typeof(datos[e]) !== 'undefined') {
          listas.push(datos[e])
        }
      })

      var peticion = th.fullQuery(params[0], params[1], listas)
      peticion.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {

          console.log(this.responseText)

          if(this.responseText.trim() === 'exito') {
            if(funciones.length > 1) {
              if(typeof(funciones[1](e)) === 'function') {
                funciones[1](e)
              }
            }
          } else {
            if(funciones.length > 2) {
              if(typeof(funciones[2](e)) === 'function') {
                funciones[2](e)
              }
            }
          }
        } 
      }
    })
  }

  inputEnter() {
    var th = this
    if(this.buscador !== '') {
      this.buscador.addEventListener('keypress', e => {
        if(e.keyCode === 13) {
          th.filtrar(th.lista, this.buscador.value)
        }

        if(typeof(this.buscador.disparar) === 'function') {
          this.buscador.disparar()
        } 
      })
    }   
  }

  inputNavegacionRefocus() {
    var tabla = qsa(`#${this.tabla} tbody tr`)
    this.inputNavegacionTipo(tabla[this.coordenadas[0]].children[this.coordenadas[1]])
  }

  inputNavegacionTipo(e) {
    var accion = {
      "INPUT": () => {e.querySelector('input').select()},
      "BUTTON": () => {e.querySelector('button').focus()}
    } 

    if (e.querySelector('input')) {
      return accion[e.querySelector('input').tagName]()
    } else if(e.querySelector('button')) {
      return accion[e.querySelector('button').tagName]()
    }
  }

  inputNavegacion(e, desplazo, posicion) {
    if (e.which === 38 || e.which === 40) {
        e.preventDefault();
    }

    var th = this, 
        tr = this.trozos('parientePreciso', [e.target, 'TR', 10]),
        tabla = qsa(`#${this.tabla} tbody tr`)

    if(e.which === 40 && this.desplazamientoActivo[2]) {
      //abajo
      var actual = Number(tr.dataset.posicion),
          desplace = actual + 1, 
          filas = tabla.length,
          tablaActual

      if(desplace >= filas) {
        desplace = 0
      }

      tablaActual = Array.from(tabla[actual].children).indexOf(this.trozos('parientePreciso', [e.target, 'TD', 10]))
      if(desplace < filas && tablaActual !== -1) {

        //esta condicion no diferencia inputs the checkboxes. revisar (arriba/abajo)
        if (tabla[this.coordenadas[0]].children[this.coordenadas[1]].querySelector('input').getAttribute('disabled') !== null) {

          this.coordenadas[0] = this.coordenadas[0] + 1

          if (this.coordenadas[0] === tabla.length) {

            this.coordenadas[0] = 0

          }

          this.inputNavegacionTipo(tabla[this.coordenadas[0]].children[this.coordenadas[1]])

        } else {

          this.coordenadas[1] = tablaActual
          this.coordenadas[0] = desplace
          this.inputNavegacionTipo(tabla[this.coordenadas[0]].children[this.coordenadas[1]])
          //tabla[this.coordenadas[0]].children[this.coordenadas[1]].querySelector('input').select()

        }


      }

    } else if (e.which === 39 && this.desplazamientoActivo[3]) {
      //derecha
      if(qs(`#${this.tabla}`).lock) {
        var actual = (desplazo === undefined) ? Array.from(tabla[Number(tr.dataset.posicion)].children).indexOf(this.trozos('parientePreciso', [e.target, 'TD', 10])) : desplazo;
        var desplace = actual + 1, 
            columnas = this.estructura.length + 1

        if(desplace >= columnas) {
          desplace = 0
        }

        //if(desplace < columnas) {
          this.coordenadas[0] = (desplazo === undefined) ? Number(tr.dataset.posicion) : posicion;
          this.coordenadas[1] = desplace

          if(tabla[this.coordenadas[0]].children[this.coordenadas[1]].querySelector('input') !== null) {

            if(tabla[this.coordenadas[0]].children[this.coordenadas[1]].querySelector('input').disabled) {

              this.inputNavegacion(e, desplace, Number(tr.dataset.posicion))

            } else {

              setTimeout(function() {
                th.inputNavegacionTipo(tabla[th.coordenadas[0]].children[th.coordenadas[1]])
              }, 0);

            }

          } else {
            this.inputNavegacion(e, desplace, Number(tr.dataset.posicion))
          }   
        //}
      }
    } else if (e.which === 38 && this.desplazamientoActivo[0]) {
      //arriba
      var actual = Number(tr.dataset.posicion),
          desplace = actual - 1,
          filas = tabla.length,
          tablaActual

      if(desplace < 0) {
        desplace = filas - 1
      }

      tablaActual = Array.from(tabla[actual].children).indexOf(this.trozos('parientePreciso', [e.target, 'TD', 10]))
      
      if(desplace > -1 && tablaActual !== -1) {

        if (tabla[this.coordenadas[0]].children[this.coordenadas[1]].querySelector('input').getAttribute('disabled') !== null) {

          this.coordenadas[0] = this.coordenadas[0] - 1

          if (this.coordenadas[0] < 1) {

            this.coordenadas[0] = tabla.length - 1

          }

          this.inputNavegacionTipo(tabla[this.coordenadas[0]].children[this.coordenadas[1]])

        } else {
          this.coordenadas[1] = tablaActual
          this.coordenadas[0] = desplace
          
          this.inputNavegacionTipo(tabla[this.coordenadas[0]].children[this.coordenadas[1]])
        }

      }

    } else if (e.which === 37 && this.desplazamientoActivo[1]) {
      //izquierda
      if(qs(`#${this.tabla}`).lock) {
        var actual = (desplazo === undefined) ? Array.from(tabla[Number(tr.dataset.posicion)].children).indexOf(this.trozos('parientePreciso', [e.target, 'TD', 10])) : desplazo,
          desplace = actual - 1, 
          columnas = this.estructura.length + 1

        if(desplace < 0) {
          desplace = columnas - 1
        }  

        //if(desplace > -1) {
          this.coordenadas[0] = (desplazo === undefined) ? Number(tr.dataset.posicion) : posicion;
          this.coordenadas[1] = desplace

          if(tabla[this.coordenadas[0]].children[this.coordenadas[1]].querySelector('input') !== null) {

            if(tabla[this.coordenadas[0]].children[this.coordenadas[1]].querySelector('input').disabled) {
              this.inputNavegacion(e, desplace, Number(tr.dataset.posicion))
            } else {

              setTimeout(function() {
                th.inputNavegacionTipo(tabla[th.coordenadas[0]].children[th.coordenadas[1]])
              }, 0);
                     
            }

          } else {
            this.inputNavegacion(e, desplace, Number(tr.dataset.posicion))
          } 
        //}
      }
    }
  }

  //-----------------------------------------------Otros
  dataRevision (contenedor) {
    if (contenedor === 'number') {
      return Number(contenedores[i].value)
    } else if (contenedor.type === 'checkbox') {
      if(contenedor.checked) {
        return 'X'
      } else {
        return ''
      }
    } else {
      return contenedor.value
    } 
  }

  colorFilas (i, c1, c2) {
    if (i % 2 != 0) {return c1} else { return c2}
  }
  
  ordenLista() {
    if (this.busqueda !== '') {
      var lista = this.busqueda
    } else {
      var lista = this.lista
    }
    if (lista.length > 0) {
      console.table(Object.keys(lista[0]))
      var resulset = []
    } 
  }

  busquedaSql() {
    var datos = JSON.stringify([this.buscador.value, this.parametrosBusqueda])
      var params = `funcion=${this.funcion}&clase=${this.clase}&datos=${datos}`;

      if(this.excepciones.length > 0) {
        this.excepciones.forEach((e,i) => {
          params = params.replace(e[0], e[1]); //excepcion, reemplazo
        });
      }

      var peticion = new XMLHttpRequest();
        peticion.overrideMimeType("application/json");
        peticion.open('POST', '../controladores/controlador.php', true);  
        peticion.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        peticion.send(params);

      return peticion
  }

  fullQuery(clase, funcion, datos, excepciones) {
    var datos = JSON.stringify(datos)
      var params = `funcion=${funcion}&clase=${clase}&datos=${datos}`;

      if(typeof(excepciones) !== 'undefined') {
        excepciones.forEach((e,i) => {
          params = params.replace(e[0], e[1]);
        });
      }

      var peticion = new XMLHttpRequest();
          peticion.overrideMimeType("application/json");
        peticion.open('POST', '../controladores/controlador.php', true);  
        peticion.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        peticion.send(params);

      return peticion
  }
  
  //--------------------------------------
  generarCabecera () {
    var fr = new DocumentFragment();
    var ind = 0

    qs('#'+this.tabla+' thead').innerHTML = ''

    if(this.numerar === true) {
      var th = this.th.cloneNode()
          th.insertAdjacentText('afterbegin', '#')
          th.title = 'Numeración'
          fr.appendChild(th)
    }

    Array.from(this.cabecera).forEach((e,i) => {
      var e = this.th.cloneNode();
      var index

      if (this.cabecera[i][1] === true) {
        if (this.cabecera[i][2] === true) {
          if (this.lista.length > 0) {
            var index = Object.keys(this.lista[0])[ind]
          } 
        } else {
          if (this.lista.length > 0) {
            var index = Object.keys(this.lista[0])[this.cabecera[i][2]]
          }
        }
        
        ind = ind + 1

        if(typeof this.cabecera[i][0] === 'string') {
          e.insertAdjacentText('afterbegin', this.cabecera[i][0]+' ▼')   
        } else {
          e.insertAdjacentText('afterbegin', this.cabecera[i][0][0]+' ▼')
          e.setAttribute('title', this.cabecera[i][0][1])
        }
        
        e.setAttribute('class', index+' '+'ASC')
        fr.appendChild(e)
        e = ''
        
      } else {

        if(typeof this.cabecera[i][0] === 'string') {
          e.insertAdjacentText('afterbegin', this.cabecera[i][0])
        } else {
          e.insertAdjacentText('afterbegin', this.cabecera[i][0][0])
          e.setAttribute('title', this.cabecera[i][0][1])  
        }
        fr.appendChild(e)
        e = ''
      }
    })
    var tr = document.createElement('tr')
    tr.appendChild(fr)
    qs('#'+this.tabla+' thead').appendChild(tr)

    if (this.ofv === true) {
      qs(`#${this.tabla}`).parentElement.setAttribute('style', `overflow-y:scroll; height:${this.ofvh}`)
    } else {
      qs(`#${this.tabla}`).parentElement.setAttribute('style', '')
    }
  }

  //--------------------------------------
  generar(procesar) {
    qs(`#${this.tabla} tbody`).innerHTML = ''

    var plantilla = new DocumentFragment(), lista, posicion = 0, th = this;

    if (procesar === true) {

      if (this.busqueda !== '') {

        lista = this.busqueda

      } else {
        lista = this.lista
        this.busqueda = this.lista
      }     
    } else {
      lista = this.lista
      this.busqueda = this.lista
    }
    
    (lista.length < this.pagMax) ? this.pagMax = lista.length : this.pagMax = this.pagMax;
    
    if (lista.length !== 0) {

      if (this.pagForce === -1) {
        this.pagMin = 0
        this.pagMax = lista.length
      }

      for (var i = this.pagMin; i < (this.pagMax); i++) {
        var dsync = 0, 
            estado = false, 
            asociar = Object.keys(lista[0]),
            fragmento = new DocumentFragment();

            fragmento.appendChild(this.tr.cloneNode())

        if(this.sublistas === true) {
          fragmento.children[0]['sublista'] = lista[i]
        }

        if(this.alternar[0] === true) {
          var filaColor
              filaColor = this.colorFilas(i, this.alternar[1], this.alternar[2])
          fragmento.children[0].setAttribute("style", `background:${filaColor}`)
        }
        
        if(this.numerar === true) {
          var td = this.td.cloneNode()
              td.insertAdjacentText('afterbegin', i+1)
          fragmento.children[0].appendChild(td)
        }
                  
        for (var es = 0; es < (this.estructura.length); es++) {

          if (this.cuerpo[es][1].length < 2) {//UN SOLO ELEMENTO
            
            var elemento  = this.estructura[es].cloneNode(true),    
                ubicacion = this.cuerpo[es][3][0], //determina la posicion del dato de la lista o el dato enviado desde la instancia
                data      = this.cuerpo[es][2][0], //contiene la información a insertar, varía respecto a la ubicación 
                valorProcesado

            if (data === false || typeof(data) === 'string' && estado === false) {
              estado = true;
              dsync  = dsync + 1
            } 

            if(ubicacion === 'HTML') {
            
              if(data === true) {   
                elemento.children[0].insertAdjacentHTML('afterbegin', `${lista[i][[asociar[es-dsync]]]}`)
              } else if (data === false) {
                if (typeof(lista[i][[asociar[this.cuerpo[es][5]]]]) === 'object' && lista[i][[asociar[this.cuerpo[es][5]]]] !== null) {
                  
                  if(typeof lista[i][[asociar[this.cuerpo[es][5]]]].length === 'undefined') {
                    var nodo = lista[i][[asociar[this.cuerpo[es][5]]]].cloneNode(true)
                    elemento.children[0].appendChild(nodo)
                  } else {
                    elemento.children[0].innerHTML = lista[i][[asociar[this.cuerpo[es][5]]]]
                  }                 
                  
                } else {
                  elemento.children[0].insertAdjacentHTML('afterbegin', `${lista[i][[asociar[this.cuerpo[es][5]]]]}`)
                }
              } else {
                elemento.children[0].insertAdjacentHTML('afterbegin', `${data}`)             
              } 

              var td = this.td.cloneNode()
                td.appendChild(elemento)
              var elemento = td

              /*let columna
              if(typeof(asociar[this.cuerpo[es][5]]) !== 'undefined') {columna = asociar[this.cuerpo[es][5]]} else {columna = asociar[data]}
              if(elemento.children[0].getAttribute('title') === null) {elemento.children[0].setAttribute('title', columna)}
              if(!elemento.children[0].getAttribute('data-columna')) {elemento.children[0].setAttribute('data-columna', columna)}*/

              fragmento.children[0].appendChild(td); 

            } else if (ubicacion === 'VALUE') {
              
              if (data === true) {
                valorProcesado = lista[i][[asociar[es-dsync]]]
                elemento.children[0].setAttribute('value', valorProcesado) 
              } else if (data === false) {
                valorProcesado = lista[i][[asociar[this.cuerpo[es][5]]]]
                elemento.children[0].setAttribute('value', valorProcesado) 
              } else {
                valorProcesado = data
                elemento.children[0].setAttribute('value', valorProcesado)
              }

              let columna,  condicionColumna = {null: () => {elemento.children[e].setAttribute('title', columna)}}
              if(typeof(asociar[this.cuerpo[es][5]]) !== 'undefined') {columna = asociar[this.cuerpo[es][5]]} else {columna = asociar[data]} 
              if(!elemento.children[0].getAttribute('data-columna')) {elemento.children[0].setAttribute('data-columna', columna)}

              if (elemento.children[0].getAttribute('titulo') !== null) {

                if(valorProcesado.trim() !== '') {
                  elemento.children[0].setAttribute('title', valorProcesado)
                } else {
                  condicionColumna[elemento.children[0].getAttribute('title')]
                }

              } else {
                condicionColumna[elemento.children[0].getAttribute('title')]
              }

              if (elemento.children[0].tagName === 'BUTTON' || elemento.children[0].tagName === 'INPUT') {
                if(elemento.children[0].type === 'checkbox') {
                  if (elemento.children[0].dataset.positivo === elemento.children[0].value) {
                    elemento.children[0].checked = true
                  }
                }
                var td = this.td.cloneNode()
                    td.appendChild(elemento)
                var elemento = td
              }
              fragmento.children[0].appendChild(elemento);
              
            } else if (ubicacion === 'CLASE') {
          
              var preClases = "";
              if (elemento.children[0].getAttribute('class') != null) {
                preClases = elemento.children[0].getAttribute('class')+' ';
              }
              
              if(data === true) {
                elemento.children[0].setAttribute('class', preClases+`${lista[i][[asociar[es-dsync]]]}`)
              } else if (data === false) {
                elemento.children[0].setAttribute('class', preClases+`${lista[i][[asociar[this.cuerpo[es][5]]]]}`)
              } else {
                elemento.children[0].setAttribute('class', preClases+`${data}`)          
              } 

              let columna
              if(typeof(asociar[this.cuerpo[es][5]]) !== 'undefined') {columna = asociar[this.cuerpo[es][5]]} else {columna = asociar[data]}
              if(elemento.children[0].getAttribute('title') === null) {elemento.children[0].setAttribute('title', columna)}
              if(!elemento.children[0].getAttribute('data-columna')) {elemento.children[0].setAttribute('data-columna', columna)}

              if(elemento.children[0].tagName === 'BUTTON' || elemento.children[0].tagName === 'INPUT') {
                if(elemento.children[0].type === 'checkbox') {
                  let posicion = (typeof(elemento.children[0].dataset.clase) !== 'undefined') ? elemento.children[0].dataset.clase : 0;
                  if (elemento.children[0].dataset.positivo === elemento.children[0].classList[posicion]) {
                    elemento.children[0].checked = true
                  }
                }
                var td = this.td.cloneNode()
                    td.appendChild(elemento)
                var elemento = td
              }

              fragmento.children[0].appendChild(elemento) 

            } else if (ubicacion === 'MUL') {

              var datasets = data[0]
              for (var is = 0; is < datasets.length; is++) {
                if (data[0][is][2] === true) { 
                  elemento.children[0].setAttribute(`data-${datasets[is][0]}`, lista[i][[asociar[datasets[is][1]]]])}
                else { 
                  elemento.children[0].setAttribute(`data-${datasets[is][0]}`, datasets[is][1])}
              }

              if (data[1][0] === 'HTML') {

                if (data[1][2] === true) { elemento.children[0].insertAdjacentHTML('afterbegin', lista[i][[asociar[data[1][1]]]]) } else if
                   (data[1][2] === false){ elemento.children[0].insertAdjacentHTML('afterbegin', data[1][1]) }

              } else if (data[1][0] === 'CLASE') {

                var preClases = "";  
                if (elemento.children[0].getAttribute('class') != null) {preClases = elemento.children[0].getAttribute('class')+' '};       
                if (data[1][2] === true) { elemento.children[0].setAttribute('class', preClases+`${lista[i][[asociar[data[1][1]]]]}`) } else if
                   (data[1][2] === false){ elemento.children[0].setAttribute('class', preClases+`${data[1][1]}`) }

              } else if(data[1][0] === 'VALUE') {

                if (data[1][2] === true) { 
                  elemento.children[0].setAttribute('value', lista[i][[asociar[data[1][1]]]]) 
                } else if (data[1][2] === false) { 
                  elemento.children[0].setAttribute('value', data[1][1])
                }

              }

              let columna
              if(typeof(asociar[this.cuerpo[es][5]]) !== 'undefined') {columna = asociar[this.cuerpo[es][5]]} else {columna = asociar[data[1][1]]} 
              if(elemento.children[0].getAttribute('title') === null) {elemento.children[0].setAttribute('title', columna)}
              if(!elemento.children[0].getAttribute('data-columna')) {elemento.children[0].setAttribute('data-columna', columna)}
              
              if (elemento.children[0].tagName === 'BUTTON' || elemento.children[0].tagName === 'INPUT') {
                if(elemento.children[0].type === 'checkbox') {
                  let posicion = (typeof(elemento.children[0].dataset.clase) !== 'undefined') ? elemento.children[0].dataset.clase : 0;
                  let comparacion = (typeof(elemento.children[0].dataset.clase) !== 'undefined') ? elemento.children[0].dataset.clase : elemento.children.value;
                  if (
                      elemento.children[0].dataset.positivo === elemento.children[0].classList[posicion] || 
                      elemento.children[0].dataset.positivo === elemento.children[0].value
                    ) {
                    elemento.children[0].checked = true 
                  }
                }
                var td = this.td.cloneNode()
                    td.appendChild(elemento)
                var elemento = td
              }

              fragmento.children[0].appendChild(elemento);

            } else {
              console.log('opción inválida: posiblemente no se declaró explícitamente el valor o el tipo de campo que recibe el valor de un elemento dentro de una columna compleja')
            }

            if(this.cuerpo[es][4] !== '') {
              elemento.setAttribute('class', this.cuerpo[es][4])
            }

          } else { //VARIOS ELEMENTOS

            var elemento = this.estructura[es].cloneNode(true);              
            for (var e = 0 ; e < (this.cuerpo[es][1].length) ; e++) {
            
              var ubicacion = this.cuerpo[es][3][e] // sitio en donde se insertaran los datos
              var data = this.cuerpo[es][2][e] //datos para el crud, puede venir en multiples formas dependiendo de la ubicacion
              var subFragmento = new DocumentFragment(),
                  valorProcesado;
                  subFragmento.appendChild(document.createElement('td'))
                   
              if(ubicacion === 'HTML') { 

                if(data === true && this.cuerpo[es][5] === true) {
                  elemento.children[e].insertAdjacentHTML('afterbegin', `${lista[i][[asociar[es]]]}`)
                } else if (this.cuerpo[es][5] === false && typeof(data) === 'number') {
                  elemento.children[e].insertAdjacentHTML('afterbegin', `${lista[i][asociar[data]]}`)
                } else {
                  elemento.children[e].insertAdjacentHTML('afterbegin', `${data}`)
                } 

                /*let columna
                if(typeof(asociar[this.cuerpo[es][5]]) !== 'undefined') {columna = asociar[this.cuerpo[es][5]]} else {columna = asociar[data]}
                if(elemento.children[e].getAttribute('title') === null) {elemento.children[e].setAttribute('title', columna)} 
                if(!elemento.children[e].getAttribute('data-columna')) {elemento.children[e].setAttribute('data-columna', columna)}*/
                
              } else if (ubicacion === 'VALUE') {
              
                if(data === true && this.cuerpo[es][5] === true) { 
                  valorProcesado = lista[i][[asociar[es-dsync]]]
                  elemento.children[e].setAttribute('value', valorProcesado)
                } else if (this.cuerpo[es][5] === false && typeof(data) === 'number') {
                  valorProcesado = lista[i][asociar[data]]
                  elemento.children[e].setAttribute('value', valorProcesado) 
                } else {
                  valorProcesado = data
                  elemento.children[e].setAttribute('value', valorProcesado)       
                }

                let columna, condicionColumna = {null: () => {elemento.children[e].setAttribute('title', columna)}}
                if(typeof(asociar[this.cuerpo[es][5]]) !== 'undefined') {columna = asociar[this.cuerpo[es][5]]} else {columna = asociar[data]}
                if(!elemento.children[e].getAttribute('data-columna')) {elemento.children[e].setAttribute('data-columna', columna)}

                if (elemento.children[e].getAttribute('titulo') !== null) {

                  if(valorProcesado.trim() !== '') {
                    elemento.children[e].setAttribute('title', valorProcesado)
                  } else {
                    condicionColumna[elemento.children[e].getAttribute('title')]
                  }

                } else {
                  condicionColumna[elemento.children[e].getAttribute('title')]
                }

                if (elemento.children[e].tagName === 'BUTTON' || elemento.children[e].tagName === 'INPUT') {
                  if(elemento.children[e].type === 'checkbox') {
                    if (elemento.children[e].dataset.positivo === elemento.children[e].value) {
                      elemento.children[e].checked = true
                    }
                  }
                }
              } else if (ubicacion === 'CLASE') {
              
                var preClases = "";  
                if (elemento.children[e].getAttribute('class') != null) {       
                  preClases = elemento.children[e].getAttribute('class')+' ';
                }
                
                if(data === true && this.cuerpo[es][5] === true) { 
                  elemento.children[e].setAttribute('class', preClases+`${lista[i][[asociar[es]]]}`)   
                } else if (this.cuerpo[es][5] === false && typeof(data) === 'number') {
                  elemento.children[e].setAttribute('class', preClases+`${lista[i][asociar[data]]}`)
                } else {            
                  elemento.children[e].setAttribute('class', preClases+`${data}`)
                }

                let columna
                if(typeof(asociar[this.cuerpo[es][5]]) !== 'undefined') {columna = asociar[this.cuerpo[es][5]]} else {columna = asociar[data]}
                if(elemento.children[e].getAttribute('title') === null) {elemento.children[e].setAttribute('title', columna)}
                if(!elemento.children[e].getAttribute('data-columna')) {elemento.children[e].setAttribute('data-columna', columna)}

                if(elemento.children[e].tagName === 'BUTTON' || elemento.children[e].tagName === 'INPUT') {
                  if(elemento.children[e].type === 'checkbox') {
                    let posicion = (typeof(elemento.children[e].dataset.clase) !== 'undefined') ? elemento.children[e].dataset.clase : 0;
                    if (elemento.children[e].dataset.positivo === elemento.children[e].classList[posicion]) {
                      elemento.children[e].checked = true  
                    }
                  }
                }
              } else if (ubicacion === 'MUL') {

                var datasets = data[0]

                for (var is = 0; is < datasets.length; is++) {
                  if(datasets[is][2] === true) {
                    elemento.children[e].setAttribute(`data-${datasets[is][0]}`, lista[i][[asociar[datasets[is][1]]]])} else {
                    elemento.children[e].setAttribute(`data-${datasets[is][0]}`, datasets[is][1])
                  }
                }

                if (data.length > 1) {
                  if (data[1][0] === 'HTML') {

                    if(data[1][2] === true) {elemento.children[e].insertAdjacentHTML('afterbegin', `${lista[i][[asociar[data[1][1]]]]}`)} else if
                      (data[1][2] === false){elemento.children[e].insertAdjacentHTML('afterbegin', `${data[1][1]}`)
                    }

                  } else if (data[1][0] === 'CLASE') {

                    var preClases = "";  
                    if (elemento.children[e].getAttribute('class') != null) {preClases = elemento.children[e].getAttribute('class')+' '};
                    if (data[1][2] === true) {elemento.children[e].setAttribute('class', preClases+`${lista[i][[asociar[data[1][1]]]]}`)} else if 
                       (data[1][2] === false){elemento.children[e].setAttribute('class', preClases+`${data[1][1]}`)
                    }   
                  } else if(data[1][0] === 'VALUE') {

                    if (data[1][2] === true) { 
                      elemento.children[e].setAttribute('value', lista[i][[asociar[data[1][1]]]]) 
                    } else if (data[1][2] === false) { 
                      elemento.children[e].setAttribute('value', data[1][1])
                    }

                  }
                }

                let columna
                if(typeof(asociar[this.cuerpo[es][5]]) !== 'undefined') {columna = asociar[this.cuerpo[es][5]]} else {columna = asociar[data[1][1]]}
                if(elemento.children[e].getAttribute('title') === null) {elemento.children[e].setAttribute('title', columna)}
                if(!elemento.children[e].getAttribute('data-columna')) {elemento.children[e].setAttribute('data-columna', columna)}

                if (elemento.children[e].tagName === 'BUTTON' || elemento.children[e].tagName === 'INPUT') {
                  if(elemento.children[e].type === 'checkbox') {
                    let posicion = (typeof(elemento.children[e].dataset.clase) !== 'undefined') ? elemento.children[e].dataset.clase : 0;
                    let comparacion = (typeof(elemento.children[e].dataset.clase) !== 'undefined') ? elemento.children[e].dataset.clase : elemento.children.value;
                    if (
                        elemento.children[e].dataset.positivo === elemento.children[e].classList[posicion] || 
                        elemento.children[e].dataset.positivo === elemento.children[e].value
                      ) {
                      elemento.children[e].checked = true
                    }
                  }

                }
              } else {
                console.log('opción inválida: posiblemente no se declaró explícitamente el valor o el tipo de campo que recibe el valor de un elemento dentro de una columna compleja')
              }  
            }
            
            if (this.cuerpo[es][5] === false || typeof(data) === 'string' && estado === false) {
              estado = true;
              dsync  = dsync + 1
            }
                
            if(this.cuerpo[es][4] !== ''){
              subFragmento.children[0].setAttribute('class', this.cuerpo[es][4])
            }  
            
            subFragmento.children[0].appendChild(elemento);
            fragmento.children[0].appendChild(subFragmento);
          }    
          fragmento.children[0].setAttribute('id', `f${i}`)
          fragmento.children[0].setAttribute('data-posicion', posicion)
        }

        Object.keys(this.propiedadesTr).forEach((el,i) => {
          this.propiedadesTr[el](fragmento.children[0])
        });

        posicion++
        plantilla.appendChild(fragmento);
      }
    } else {

      var div = this.div.cloneNode('div')
          div.setAttribute('class', 'crud-mensaje')
          div.insertAdjacentText('afterbegin', '')
          plantilla.appendChild(div)
      
      if(qsa(`.${this.nombPosi}`).length > 0) {
        if(this.posicion[0].tagName === 'INPUT') { this.posicion[0].value = 1 } else { this.posicion[0].innerHTML = 1 }   
      }

    }
    
    qs('#'+this.tabla+' tbody').appendChild(plantilla)
    this.pagMax = this.pagForce
    this.pagMin = 0
    if (this.posicion.length > 0) {
      if (procesar === false) {

        if (lista.length > 0) {
          if(this.posicion[0].tagName === 'INPUT') { this.posicion[0].value = 1 } else { this.posicion[0].innerHTML = 1 }  
        } else {
          if(this.posicion[0].tagName === 'INPUT') { this.posicion[0].value = 1 } else { this.posicion[0].innerHTML = 1 }  
        }   

      } 
      
      if (lista.length > 0) {
        if(this.posicion[0].tagName === 'INPUT') { this.posicion[0].value = this.pagPosi } else { this.posicion[0].innerHTML = this.pagPosi }
        this.posicion[1].innerHTML = Math.ceil(lista.length / this.pagForce)
      } else {
        this.posicion[1].innerHTML = 1
      }
   
    }

    //acciones que se disparan al finalizar de generarse la lista
    this.fLista[1][this.fLista[0]](qs(`#${this.tabla} tbody`).querySelectorAll('tr'))

  }

  //----------------------------------------------------------------------------------------------------------------
  //----------------------------------------------------------------------------------------------------------------
  eventos() {
    var th = this
    if (this.eForzar === false) {

      qs(`#${this.tabla} thead`).addEventListener('click', (e) => {

        var btn = e.target

        if(btn.tagName === 'TH' && btn.classList.contains('ASC')) {

          this.ascDesc(btn.classList[0], btn.classList[1])
          btn.classList.remove(btn.classList[1])
          btn.classList.add('DESC')
          btn.innerHTML = (btn.innerHTML).substring(0, btn.innerHTML.length - 1)+'▲'

        } else if(btn.tagName === 'TH' && btn.classList.contains('DESC')) {

          this.ascDesc(btn.classList[0], btn.classList[1])
          btn.classList.remove(btn.classList[1])
          btn.classList.add('ASC')
          btn.innerHTML = (btn.innerHTML).substring(0, btn.innerHTML.length - 1)+'▼'

        }

        if(typeof(qs(`#${this.tabla} thead`).disparar) === 'function') {
          qs(`#${this.tabla} thead`).disparar()
        }

        if(typeof this.customHeaderEvents === 'object' && this.customHeaderEvents !== null) {
          Object.keys(this.customHeaderEvents).forEach((el,i) => {
            this.customHeaderEvents[el](e)
          });
        }

      })

      qs(`#${this.tabla}`).addEventListener('focusin', (e) => {
        if(typeof this.customBubblingEvents === 'object' && this.customBubblingEvents !== null) {
          Object.keys(this.customBubblingEvents).forEach((el,i) => {
            this.customBubblingEvents[el](e)
          });
        }
      })

      qs(`#${this.tabla}`).addEventListener('keydown', (e) => {
        if(typeof this.customKeyEvents === 'object' && this.customKeyEvents !== null) {
          Object.keys(this.customKeyEvents).forEach((el,i) => {
            this.customKeyEvents[el](e)
          });
        }
      })

      qs(`#${this.tabla} tbody`).addEventListener('click', (e) => {

        if(typeof this.customBodyEvents === 'object' && this.customBodyEvents !== null) {
          Object.keys(this.customBodyEvents).forEach((el,i) => {
            this.customBodyEvents[el](e)
          });
        }

        if (e.target.tagName === 'BUTTON') {
          this.seleccionadoTr = this.trozos('parientePreciso', [e.target, 'TR', 10])
        }

        if (e.target.tagName === 'INPUT') {

          var tabla = qsa(`#${this.tabla} tbody tr`)
          var cord1 = Number(this.trozos('parientePreciso', [e.target, 'TR', 10]).dataset.posicion)
          var cord2 = Array.from(tabla[cord1].children).indexOf(this.trozos('parientePreciso', [e.target, 'TD', 10]))

          this.coordenadas = [cord1, cord2]

          e.target.select()
        }

      })
      
      if (this.buscador) {
          this.buscador.addEventListener('input', this.buscador.fn = function fn(e) {
            th.filtrar(th.lista, e.target.value)
            if(typeof(this.disparar) === 'function') {
              this.disparar(e)
            }   
          })

          this.buscador.addEventListener('keydown', (e) => {
            if (e.key === 'Delete') {
              if(th.introBusqueda) {
                th.botonForzar()
              }
            }   
          })
      }
      
      if (this.anterior) {
        this.anterior.addEventListener('click', (e) => {
          this.reposicionar(-1, false)
          if(typeof(this.anterior.disparar) === 'function') {
            this.anterior.disparar(e)
          }  
        })
      }
      
      if (this.siguiente) {
        this.siguiente.addEventListener('click', (e) => {
          this.reposicionar(1, false)
          if(typeof(this.siguiente.disparar) === 'function') {
            this.siguiente.disparar(e)
          }  
        })
      }

      if(this.posicion) {
        if(this.posicion[0].tagName === 'INPUT') {
          this.posicion[0].addEventListener('keypress', e => {
            if(e.key === 'Enter') {
              th.reposicionar(Number(e.target.value), true)
            }
          })
        }
      }

      if(this.inputHandler[1]) {
        this.inputProcesar(this.inputHandler[0])
        this.inputNavegar = true
      }

      qs(`#${this.tabla}`)['control'] = 0
      qs(`#${this.tabla}`)['lock'] = true
      qs(`#${this.tabla}`).addEventListener('keydown', e => {

        if(this.inputNavegarGenerar) {

          if(e.key === 'Control' && qs(`#${this.tabla}`).control === 1 && !e.repeat) {

            //console.log('paso')

            if(qs(`#${th.tabla}`).lock) {
              qs(`#${th.tabla}`).lock = false
              qs(`#${th.tabla} tbody`).setAttribute('style', 'box-shadow: inset 3px 2px 0px 0px #ff4d64;')
              qs(`#${th.tabla} thead`).setAttribute('style', 'box-shadow: 0px 0px 0px 3px #ff4d64;')
            } else {
              qs(`#${th.tabla}`).lock = true
              qs(`#${th.tabla} tbody`).removeAttribute('style')
              qs(`#${th.tabla} thead`).removeAttribute('style')
            }
            qs(`#${this.tabla}`).control = 0
          } else if (e.key === 'Control') {
            qs(`#${this.tabla}`).control = 0
            qs(`#${this.tabla}`).control++
          } else {
            qs(`#${this.tabla}`).control = 0
          }

          if(this.inputNavegar) {
            this.inputNavegacion(e)
          }

          if(typeof this.customWindowEvents === 'object' && this.customWindowEvents !== null) {
            Object.keys(this.customWindowEvents).forEach((el,i) => {
              this.customWindowEvents[el](e)
            });
          }
        }
      })
    }

    if(this.especificos.length < 1) {
      if(this.lista.length > 0) {
        this.especificos = Object.keys(this.lista[0]);
      } 
    }

    this.eForzar = true
  }
}