import  {PopUp, Acciones, Herramientas, Menu, customDesplegable, MenuTree, Paginacion, ARPropiedades, Rellenar, Reportes} from '../js/main.js';
/////////////////////////////////////////////////////
const tools = new Herramientas()
const acciones = new Acciones()
/////////////////////////////////////////////////////
window.contactos = new customDesplegable('#desplegable-contactos', '#desplegable-abrir-contactos', '#desplegable-cerrar-contactos', undefined, '300px')
window.ediciones = new customDesplegable('#desplegable-ediciones', '#desplegable-abrir-ediciones', '#desplegable-cerrar-ediciones', undefined, '550px')
/////////////////////////////////////////////////////
contactos.eventos()
ediciones.eventos()
/////////////////////////////////////////////////////
window.qs    = document.querySelector.bind(document)
window.qsa   = document.querySelectorAll.bind(document)
/////////////////////////////////////////////////////
window.idSeleccionada = 0
/////////////////////////////////////////////////////
window.rellenar = new Rellenar()
window.reportes = new Reportes()
/////////////////////////////////////////////////////
window.procesar = true
////////////////////////////////////////////////////
var sesiones = await window.sesiones(true)
////////////////////////////////////////////////////
window.menu        = Number(sesiones['modo_menu'])
window.minimalista = Number(sesiones['modo_minimalista'])
window.resaltar    = Number(sesiones['modo_resaltado'])
window.noche       = Number(sesiones['modo_noche'])
////////////////////////////////////////////////////
const propiedadesBotones = new ARPropiedades({"data-estilo": "focus-3"});
////////////////////////////////////////////////////

class Monedas {
    constructor(contenedor, plantilla) {
        this.contenedor = qs(contenedor)
        this.plantilla = plantilla
        this.parametros = []
        this.invalidar = { 
            "undefined": (e) => {''},
            "function": (e, params) => {return e(params)},
            "$": (e) => {e.setAttribute('disabled', '')}
        }
        this.procesado = true
    }

    async datos() {
        this.procesado = false
        this.parametros = JSON.parse(await tools.fullAsyncQuery('index', 'monedas', []))
        this.generar()
    }

    generar() {  

        var fr = new DocumentFragment()

        for (var i = 0; i < this.parametros.length; i++) {

            var plantilla = this.plantilla.cloneNode(true)
            
            plantilla.querySelector('label').insertAdjacentHTML('afterbegin', `${this.parametros[i].nombre} ${this.parametros[i].unidad}`)
            plantilla.querySelector('input')['id_moneda'] = this.parametros[i].id_moneda
            plantilla.querySelector('input')['valorFijo'] = this.parametros[i].conver
            plantilla.querySelector('input').value = this.parametros[i].conver

            this.invalidar[typeof(this.invalidar[this.parametros[i].unidad])](this.invalidar[this.parametros[i].unidad], plantilla.querySelector('input'))

            fr.appendChild(plantilla)
        }

        this.contenedor.innerHTML = ''
        this.contenedor.appendChild(fr)

        this.procesado = true
    }
}

class Index {
	constructor () {
		this.contenedor = qs('#index-pagina')
        this.iframe = document.getElementById('index-pagina');
        this.listaExcepciones = ['phpinfo.php', 'dev.php']
	}

    async hardRefresh() {

        sesiones = JSON.parse(await tools.fullAsyncQuery('index', 'valor_sesion', []))

        if(this.iframe.src !== '' && !this.iframe.src.includes('#') && !this.iframe.src.includes('index.php')) {

            this.iframe.src = sesiones['refrescar']
            this.iframe.contentWindow.location.reload(true);

            let path = this.iframe.contentWindow.location.href.split('?')[0]

            var rand = Math.floor((Math.random()*1000000)+1);
            this.iframe.src = `${path}?rand=${rand}`;

            return true
        } else {
            return false
        }

    }

	generarPagina (URL) {
		var th = this
	    th.contenedor.setAttribute('src', URL)
	}

    loopDom() {
        var iframe = document.getElementById('index-pagina');
        window.innerDoc = (iframe.contentDocument) ? iframe.contentDocument : iframe.contentWindow.document;

        //hacer esta busqueda con otra cosa que no sea el crud porque a veces no esta
        if(window.innerDoc.querySelector('#cargado') !== null) {
            window.innerDoc.querySelector('#cargado')
        }

        var existencia1 = setInterval(function() {
            var iframe = document.getElementById('index-pagina');
            window.innerDoc = (iframe.contentDocument) ? iframe.contentDocument : iframe.contentWindow.document;

            if (window.innerDoc.querySelector('#cargado')) {
                clearInterval(existencia1);

                if(qs('#cargar')) {
                    qs('#cargar').classList.add('ocultar')
                    setTimeout(() => {

                        if(typeof qs('#cargar') !== 'null') {
                            qs('#cargar').remove()
                        }

                    }, 200)
                }

                if(qs('header').classList.contains('hide')) {
                    window.innerDoc.querySelector('#contenido-contenedor').setAttribute('style', 'padding:0px') 
                } else {
                    window.innerDoc.querySelector('#contenido-contenedor').setAttribute('style', '') 
                }

                if(window.noche) {
                    window.innerDoc.querySelector('body').setAttribute('data-noche', '')
                } else {
                    window.innerDoc.querySelector('body').removeAttribute('data-noche', '')
                }

                if(window.resaltar) {
                    window.innerDoc.querySelector('body').setAttribute('data-resaltar', '')
                } else {
                    window.innerDoc.querySelector('body').removeAttribute('data-resaltar', '')
                }
            }
        }, 200);
    }

    excepciones (url) {

        var valido = true

        this.listaExcepciones.forEach(e => {

            if(url.includes(e)) {
                valido = false
            }

        })

        return valido
    }

    async redireccionLibre(url) {
        if(this.excepciones(String(url))) {
                
            var div = document.createElement('div')
            var img = document.createElement('img')

            div.setAttribute('id', 'cargar')
            img.src = '../imagenes/spinner.gif';
            img.setAttributeNS(null, 'style', `width: 6vh; height: 6vh; position: absolute; top: 50%; box-shadow: 0px 0px 0px 1px #fff; padding: 10px; box-sizing: content-box; left: 50%; filter: blur(0.8px); border-radius: 100px;`)

        }

        if (!url.includes('#')) {

            if(this.excepciones(String(url))) {

                if(!String(url).includes('inicio.php')) {
                    div.appendChild(img)
                    document.querySelector('body').appendChild(div)
                    qs('#cargar').classList.add('mostrar')
                }

            }

            await this.loopDom()

            if (url.slice(url.length - 1) !== '#') {
                this.generarPagina(url)
            }
        } else {
            if(qs('#cargar')) {
                setTimeout(() => {qs('#cargar').classList.add('ocultar')}, 1000)
                setTimeout(() => {qs('#cargar').remove()}, 1500)  
            }        
        }
 
    }
}

window.index = new Index()

if(document.getElementById('header-tope')) {		
	const desplegable = new Desplegable()
	desplegable.desplegableEventos()
}

//--------------------------------------------------------
//menu principal
//--------------------------------------------------------
const navegador = new Menu();

navegador['evento'] = 'index-menu'
navegador.cargarNav();
navegador.mostrarSmooth();
navegador.ocultar();

qs('#index-menu').addEventListener('click', e=> {
    e.preventDefault()
    if(e.target.tagName === 'A') {

        if (String(e.target.href).includes('inicio.php')) {

            document.querySelector('#index-pagina').src = ''

        } else if (String(e.target.href).includes('configuracion.php')) {

            window.location.href = e.target.href

        } else if (e.target.href.slice(e.target.href.length - 1) !== '#') {
            index.generarPagina(e.target.href)
        } 

    }  
})

var navegadores = [
    [qs('#index-navegador'), qs('#index-navegador')]
]

navegadores.forEach((el,i) => {
    el[0].addEventListener('click', e => {
        if(e.target.tagName === 'A') {

            if(index.excepciones(String(e.target.href))) {
                
                var div = document.createElement('div')
                var img = document.createElement('img')

                div.setAttribute('id', 'cargar')
                img.src = '../imagenes/spinner.gif';
                img.setAttributeNS(null, 'style', `width: 6vh; height: 6vh; position: absolute; top: 50%; box-shadow: 0px 0px 0px 1px #fff; padding: 10px; box-sizing: content-box; left: 50%; filter: blur(0.8px); border-radius: 100px;`)

            }

            if (!e.target.href.includes('#')) {

                if (String(e.target.href).includes('configuracion.php')) {

                    window.location.href = e.target.href

                } else if(index.excepciones(String(e.target.href))) {

                    if(!String(e.target.href).includes('inicio.php')) {
                        div.appendChild(img)
                        document.querySelector('body').appendChild(div)
                        qs('#cargar').classList.add('mostrar')
                    }

                }

                index.loopDom()

            } else {
                if(qs('#cargar')) {
                    setTimeout(() => {qs('#cargar').classList.add('ocultar')}, 1000)
                    setTimeout(() => {qs('#cargar').remove()}, 1500)  
                }        
            }
            
        }
    })

    el[1].addEventListener('click', e => {
       e.preventDefault()
        if(e.target.tagName === 'A') {
            if (e.target.href.slice(e.target.href.length - 1) !== '#') {
                index.generarPagina(e.target.href)
            } 
        }   
    })
})

//--------------------------------------------------------
//activar desactivar modo minimalista
//--------------------------------------------------------
qs('#boton-minimalista').addEventListener('click', async e => {

    (window.minimalista) ? window.minimalista = 0 : window.minimalista = 1;

    await tools.fullAsyncQuery('index', 'modificar_sesion', [{"sesion": 'modo_minimalista', "parametros": window.minimalista}])

    if(qs('header').classList.contains('header-minimalista')) {  
        qs('header').removeAttribute('class', 'header-minimalista')
        qs('body').setAttribute('style', '')
        qs('footer').removeAttribute('class', 'footer-minimalista')
    } else {
        qs('header').setAttribute('class', 'header-minimalista')
        qs('body').setAttribute('style', 'grid-template-rows: 1fr')
        qs('footer').setAttribute('class', 'footer-minimalista')
    }

    if(window.minimalista) {
        tools['mensaje'] = 'Modo minimalista activado'
        tools.mensajes(true)
    } else {
        tools['mensaje'] = 'Modo minimalista desactivado'
        tools.mensajes(false)
    }

    var iframe = document.getElementById('index-pagina');
    window.innerDoc = (iframe.contentDocument) ? iframe.contentDocument : iframe.contentWindow.document;

    if(window.innerDoc.querySelector('.paginas-contenedor') !== null) {
        if(window.minimalista) {
            window.innerDoc.querySelector('body').setAttribute('data-minimalista', '')
        } else {
            window.innerDoc.querySelector('body').removeAttribute('data-minimalista', '')
        }

        await tools.fullAsyncQuery('configuracion', 'actualizarGeneralUsuarios', ['minimalista', window.minimalista, 'modo_minimalista']) 
    }

})

//--------------------------------------------------------
//activar desactivar modo noche
//--------------------------------------------------------
qs('#boton-oscuro').addEventListener('click', async e => {

    (window.noche) ? window.noche = 0 : window.noche = 1

    await tools.fullAsyncQuery('index', 'modificar_sesion', [{"sesion": 'modo_noche', "parametros": window.noche}])

    if(window.noche) {
        tools['mensaje'] = 'Modo noche activado'
        tools.mensajes(['black', 'white'])
    } else {
        tools['mensaje'] = 'Modo noche desactivado'
        tools.mensajes(['white', 'black'])
    }

    var iframe = document.getElementById('index-pagina');
    window.innerDoc = (iframe.contentDocument) ? iframe.contentDocument : iframe.contentWindow.document;

    if(window.innerDoc.querySelector('.paginas-contenedor') !== null) {

        if(window.noche) {
            window.innerDoc.querySelector('body').setAttribute('data-noche', '')
        } else {
            window.innerDoc.querySelector('body').removeAttribute('data-noche', '')
        }

        await tools.fullAsyncQuery('configuracion', 'actualizarGeneralUsuarios', ['noche', window.noche, 'modo_noche'])
    }
})

//--------------------------------------------------------
//activar desactivar modo resaltado
//--------------------------------------------------------
qs('#boton-resaltar').addEventListener('click', async e => {
    (window.resaltar) ? window.resaltar = 0 : window.resaltar = 1;

    await tools.fullAsyncQuery('index', 'modificar_sesion', [{"sesion": 'modo_resaltado', "parametros": window.resaltar}])

    if(window.resaltar) {
        tools['mensaje'] = 'Modo resaltado activado'
        tools.mensajes(true)
    } else {
        tools['mensaje'] = 'Modo resaltado desactivado'
        tools.mensajes(false)
    }

    var iframe = document.getElementById('index-pagina');
    window.innerDoc = (iframe.contentDocument) ? iframe.contentDocument : iframe.contentWindow.document;

    if(window.innerDoc.querySelector('.paginas-contenedor') !== null) {
        if(window.resaltar) {
            window.innerDoc.querySelector('body').setAttribute('data-resaltar', '')
        } else {
            window.innerDoc.querySelector('body').removeAttribute('data-resaltar', '')
        }

        await tools.fullAsyncQuery('configuracion', 'actualizarGeneralUsuarios', ['resaltado', window.resaltar, 'modo_resaltado'])
    }
})

//-----------------------------------------------------
//refrescar pagina
//-----------------------------------------------------

qs('#boton-recargar').addEventListener('click', e => {
    if(index.hardRefresh()) {
        tools['mensaje'] = 'Formulario refrescado'
        tools.mensajes(true)
    } else {
        tools['mensaje'] = 'Ningún formulario válido está siendo cargado'
        tools.mensajes(['#262626', '#fff'])
    }
   
})

//-----------------------------------------------------
//monedas
//-----------------------------------------------------
qs('#reiniciar-monedas').addEventListener('click', e => {
    qsa('.monedas-valores').forEach(e => {
        e.value = e.valorFijo

        tools['mensaje'] = 'Valores reestablecidos'
        tools.mensajes(true)
    })
})

//-----------------------------------------------------
//actualizar monedas de forma general
//-----------------------------------------------------
qs('#procesar-monedas').addEventListener('click', async e => {
    if (window.procesar) {

        window.procesar = false

        var datos = tools.procesar('', '', 'monedas-valores', tools)
        if (datos !== '') {

            qsa('.monedas-valores').forEach((el, i) => {
                datos[i] = {"id_moneda": el.id_moneda, "conver": datos[i]}
            })

            var resultado = await tools.fullAsyncQuery('index', 'editarMonedas', datos)

            if (resultado.trim() === 'exito') {

                window.monedas.datos()
                window.procesar = true

                if (index.hardRefresh()) {

                    tools['mensaje'] = 'Petición realizada con éxito'
                    tools.mensajes(true)

                }

            } else {
                tools['mensaje'] = 'Error al procesar la petición'
                tools.mensajes(false)
                console.log(resultado)
                window.procesar = true
            }

        } else {
            tools['mensaje'] = 'Campos vacíos'
            tools.mensajes(false)
        }
    } else {

        tools['mensaje'] = 'Procesando...'
        tools.mensajes(['#ffc107', '#fff'])

    }

    window.procesar = true
})

//-----------------------------------------------------
//insertar iva de forma general
//-----------------------------------------------------
qs('#iva-confirmar-nuevo').addEventListener('click', async e => {
    if (window.procesar === true) {

        window.procesar = false

        var datos = tools.procesar(e.target, '', 'iva-nuevo', tools)
        
        if (datos !== '') {

            var resultado = await tools.fullAsyncQuery('index', 'insertarIva', datos)
            if (resultado.trim() === 'exito') {

                window.monedas.datos()
                window.procesar = true

                qs('#iva-nuevo').value = ''

                tools['mensaje'] = 'Petición realizada con éxito'
                tools.mensajes(true)

                var procesado = setInterval(async function() {

                    if (window.monedas.procesado === true) {
                        clearInterval(procesado)

                        var url = qs('#index-pagina').src, div = document.createElement('div'), img = document.createElement('img')
                        var fr = new DocumentFragment()
                        window.ivas = JSON.parse(await tools.fullAsyncQuery('index', 'ivas', []))

                        window.ivas.forEach(e => {
                            var option = document.createElement('option')
                                option.insertAdjacentText('afterbegin', e.porcentaje)
                                option.value = e.id_iva

                            fr.appendChild(option)
                        })

                        qs('#iva-seleccionar').innerHTML = ''
                        qs('#iva-seleccionar').appendChild(fr)

                        index.hardRefresh()

                    }

                }, 1000)

            } else if (resultado.trim() === 'repetido') {

                tools['mensaje'] = 'Este registro ya existe'
                tools.mensajes(false)
                console.log(resultado)
                window.procesar = true

            } else {
                tools['mensaje'] = 'Error al procesar la petición'
                tools.mensajes(false)
                console.log(resultado)
                window.procesar = true
            }

        } else {
            tools['mensaje'] = 'Campos vacíos'
            tools.mensajes(false)
        }
    } else {

        tools['mensaje'] = 'Procesando...'
        tools.mensajes(['#ffc107', '#fff'])

    }
})

//-----------------------------------------------------
//actualizar iva de forma general
//-----------------------------------------------------
qs('#iva-confirmar-seleccionado').addEventListener('click', async e => {
    if (window.procesar === true) {

        window.procesar = false

        var datos = tools.procesar(e.target, '', 'iva-seleccionar', tools)
        if (datos !== '') {

            var resultado = await tools.fullAsyncQuery('index', 'editarIva', datos)
            if (resultado.trim() === 'exito') {

                window.monedas.datos()
                window.procesar = true

                qs('#iva-nuevo').value = ''

                tools['mensaje'] = 'Petición realizada con éxito'
                tools.mensajes(true)

                var procesado = setInterval(async function() {
                    if (window.monedas.procesado === true) {
                        clearInterval(procesado)

                        var url = qs('#index-pagina').src, div = document.createElement('div'), img = document.createElement('img')
                        var fr = new DocumentFragment()
                        window.ivas = JSON.parse(await tools.fullAsyncQuery('index', 'ivas', []))

                        window.ivas.forEach(e => {
                            var option = document.createElement('option')
                                option.insertAdjacentText('afterbegin', e.porcentaje)
                                option.value = e.id_iva

                            fr.appendChild(option)
                        })

                        qs('#iva-seleccionar').innerHTML = ''
                        qs('#iva-seleccionar').appendChild(fr)

                        index.hardRefresh()   
                        
                    }
                }, 1000)

            } else if (resultado.trim() === 'repetido') {

                tools['mensaje'] = 'Este registro ya existe'
                tools.mensajes(false)
                console.log(resultado)
                window.procesar = true

            } else {
                tools['mensaje'] = 'Error al procesar la petición'
                tools.mensajes(false)
                console.log(resultado)
                window.procesar = true
            }

        } else {
            tools['mensaje'] = 'Campos vacíos'
            tools.mensajes(false)
        }
    } else {

        tools['mensaje'] = 'Procesando...'
        tools.mensajes(['#ffc107', '#fff'])

    }
});

//-----------------------------------------------------
// peticiones
//-----------------------------------------------------
(async () => {

    //carga los valores de las conversiones del día
    window.monedas = new Monedas('#monedas-contenedor', qs('#monedas-parametros-plantilla').content.querySelector('.columnas').cloneNode(true))
    window.monedas.datos()

    //cargar los ivas de la de la edición general
    var fr = new DocumentFragment()
    window.ivas = JSON.parse(await tools.fullAsyncQuery('index', 'ivas', []))

    window.ivas.forEach(e => {
        var option = document.createElement('option')
            option.insertAdjacentText('afterbegin', e.porcentaje)
            option.value = e.id_iva

        fr.appendChild(option)
    })

    qs('#iva-seleccionar').appendChild(fr)

})()

//-----------------------------------------------------
//          PAGINACION DE LOS PARAMETRO
//-----------------------------------------------------
window.paginacionParametros = new Paginacion(
    {"contenedores": ".contenedor-parametros" ,"familia": '[data-parametro]', "efecto": ['aparecer', 'aparecer'], "delay": 100},
    [
        {},
        {}
    ]
)

qs('#parametros-derecha').addEventListener('click', e=> {
    window.paginacionParametros.animacion(1)
})

qs('#parametros-izquierda').addEventListener('click', e=> {
    window.paginacionParametros.animacion(-1)
})

//------------------------------------------------
//              CERRAR SESION
//------------------------------------------------
qs('#boton-salir').addEventListener('click', async e => {

    tools['mensaje'] = 'CERRANDO SESIÓN'
    tools.mensajes(['#262626', '#fff'])

    var resultado = null

    setTimeout(async () => {

        var peticion = new XMLHttpRequest();
            peticion.overrideMimeType("application/json");
            peticion.open('POST', '../clases/logout.class.php', true);  
            peticion.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            peticion.send();

        await new Promise(resolve => {
            peticion.onreadystatechange = function() {
                 if (this.readyState == 4 && this.status == 200) {
                    resolve(this.responseText)
                }
            };
        }).then(datos => {

            resultado = datos

        })

        if (await resultado.includes('exito')) {

            window.location.href = '../paginas/login.php'

        }

    }, 2000);

})


//------------------------------------------------
//              COMPROBAR SESION ACTIVA
//------------------------------------------------
setInterval(async () => {

    if (!await tools.fullAsyncQuery('index', 'comprobar_sesion', [])) {

        window.location.href = '../paginas/login.php?sesion=vencida'

    }

}, 100000); //1min

//--------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------
//window.cambio = false

//BUSCAR OTRO PROVEEDOR DE MONTOS DEL BANCO CENTRAL
// setInterval(async () => {         
        
//     var peticion = new XMLHttpRequest();
//         peticion.responseType='';
//         peticion.open('GET', "https://s3.amazonaws.com/dolartoday/data.json");
//         peticion.send();

//     peticion.onreadystatechange = async () =>{

//       if(peticion.status == 200 && peticion.readyState == 4) {

//         var cambios = JSON.parse(peticion.responseText);

//         if (Number(window.monedas.parametros[1].conver) !== cambios['USD']['promedio']) {
            
//             var resultado = await tools.fullAsyncQuery('index', 'actualizar_cambio_nuevo', cambios)

//             if (resultado.trim() === 'exito') {

//                 window.monedas.datos()

//                 qsa('.monedas-valores').forEach((el, i) => {

//                     if(el.id_moneda === 2) {

//                         el.value = cambios['USD']['promedio']

//                     }
      
//                 })


//                 if (index.iframe.src.includes('inicio.php')) {

//                     index.hardRefresh()

//                 }

//                 tools.tiempo = 4000
//                 tools['mensaje'] = 'Control cambiario actualizado'
//                 tools.mensajes(true)

//             } else {

//                 console.log('No pudo actualizarse la taza de cambio')
//                 console.log(resultado)

//             }


//         } else {

//             tools.fullAsyncQuery('index', 'actualizar_cambio_igual', [])

//         }

//       }

//     };

// }, 30000); //60000 * 5

/*setInterval(async () => {

    var resultado = await tools.fullAsyncQuery('index', 'test4', [])

}, 10000);*/



//iteracion que refresca el formularios después de un cambio de taza
//------------------------------------------------

// setInterval(async () => {         

//     var resultado = JSON.parse(await tools.fullAsyncQuery('index', 'monedas', []))

//     if (Number(window.monedas.parametros[1].conver) !== Number(resultado[1]['conver'])) {

//         window.monedas.datos()

//         qsa('.monedas-valores').forEach((el, i) => {

//             if (el.id_moneda === 2) {

//                 el.value = resultado[1]['conver']

//             }

//         })

//         var tiempo = 6;

//         var procesado = setInterval(async function() {

//             if (tiempo <= 1) {

//                 clearInterval(procesado)

//                 if (index.iframe.src.includes('inicio.php')) {

//                     index.hardRefresh()
                    
//                 }

//                 tools.tiempo = 15000
//                 tools['mensaje'] = 'EL BCV HA ACTUALIZADO LA TASA DE CAMBIO: REFRESCANDO FORMULARIO'
//                 tools.mensajes(['#009688', '#fff'], ';border: 3px dashed #3f51b5; border-radius: 0px; text-transform: uppercase; box-shadow: 1px 1px 7px 1px #262626;')    

//             } else  {

//                 tiempo = tiempo - 1

//                 tools['mensaje'] = `- ${tiempo} -`
//                 tools.mensajes(['#e91e63', '#fff'], ';width: fit-content; border-radius: 0px; box-shadow: 1px 1px 7px 1px #262626;')

//             }

//         }, 1000)
        
//     }

// }, 30000);//

/*setInterval(async () => {

    var resultado = await tools.fullAsyncQuery('index', 'test4dato', [])

    console.log(resultado)

}, 10000);*/

//------------------------------------------
//------------------------------------------
// dummy dumn things, like really dum dum
//------------------------------------------

function pollitoTime() {

    qs('#pollito').removeAttribute('data-hide')
    qs('#pollito img').src = '../imagenes/pollito.gif'
    qs('body').setAttribute('data-hoo', '')

    setTimeout(() => {

        qs('#pollito').setAttribute('class', 'pollito-in')

    }, 10)


    setTimeout(() => {

        qs('#pollito').removeAttribute('class')

        setTimeout(() => {
            qs('#pollito').setAttribute('data-hide', '')
            qs('body').removeAttribute('data-hoo')
            qs('#pollito img').src = ''
        }, 1000)

    }, 5000)

}

qs('#necesito-a-pollo').addEventListener('click', e => {
    pollitoTime()
})

qs('#hot-dog-stand').addEventListener('click', e => {

    if (qs('header').classList.contains('hot-dog-mustard')) {

        qs('header').classList.remove('hot-dog-mustard')
        qs('#index-navegador').classList.remove('hot-dog-tomatoe')
        qs('footer').classList.remove('hot-dog-mustard')
        qs('html').classList.remove('hot-dog-border')

    } else {

        qs('header').classList.add('hot-dog-mustard')
        qs('#index-navegador').classList.add('hot-dog-tomatoe')
        qs('footer').classList.add('hot-dog-mustard')
        qs('html').classList.add('hot-dog-border')

    }

})