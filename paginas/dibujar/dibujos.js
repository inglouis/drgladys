class Canvas {

    constructor(contenedor, seleccionado, remover, dibujar) {

        this._canvas = new fabric.Canvas(contenedor, {isDrawingMode: false});
        this._img = undefined
        this._resultado = undefined
        this._elementos = {}

        this._formato = {
            format: 'jpeg',
            width: 467,
            height: 272,
            quality: 1
        }

        this._texto = {
            left: 40,
            top: 40,
            objecttype: 'text',
            fontFamily: 'arial black',
            fill: 'black'
        }

        this._cuadrado = {
            left: 40,
            top: 40,
            width: 60,
            height: 60,
            fill: 'transparent',
            stroke: 'black',
            strokeWidth: 5
        }

        this._circulo = {
            left: 40,
            top: 40,
            radius: 60,
            fill: 'transparent',
            stroke: 'black',
            strokeWidth: 5
        }

        ///////////////////////////////////////////////////
        //genera el comportamiento del boton de seleccionar
        ///////////////////////////////////////////////////
        if (typeof seleccionado !== 'undefined') {

            document.querySelector(`#${seleccionado}`).addEventListener('click', e => {
                this._canvas.isDrawingMode = false;
            })

        } else {

            console.log('EL BOTÓN DE SELECCIONADO ES OBLIGATORIO')

        }

        ////////////////////////////////////////////////
        //genera el comportamiento del boton de eliminar
        ////////////////////////////////////////////////
        if (typeof remover !== 'undefined') {

            document.querySelector(`#${remover}`).addEventListener('click', e => {
                this._canvas.isDrawingMode = false;
                this._canvas.remove(this._canvas.getActiveObject());
            })

        } else {

            console.log('EL BOTÓN DE REMOVER ES OBLIGATORIO')

        }

        this._canvas.on('selection:created', function () {
            document.querySelector(`#${remover}`).disabled = false
        });

        this._canvas.on('selection:cleared', function () {
            document.querySelector(`#${remover}`).disabled = true
        });

        ////////////////////////////////////////////////
        //establece el modo por defecto del dibujado
        ////////////////////////////////////////////////
        if (dibujar) {
            this._canvas.isDrawingMode = true;
        } else {
            this._canvas.isDrawingMode = false;
        }

    }

    asignarImagen(img) {

        if (typeof img !== undefined) {

            this._img = img    

        }
        
        this._canvas.setBackgroundImage(this._img, this._canvas.renderAll.bind(this._canvas));

    }

    asignarDibujadoInicial(color, grosor) {
        this._canvas.freeDrawingBrush.color = color;
        this._canvas.freeDrawingBrush.width = grosor;
    }

    asignarDibujados(elementos) {

        var th = this

        document.querySelectorAll(elementos).forEach(btn => {

            btn.addEventListener('click', e => {

                th._canvas.isDrawingMode = true;
                
                if (typeof btn.dataset.color !== 'undefined') {

                    th._canvas.freeDrawingBrush.color = btn.dataset.color;

                } else {

                    th._canvas.freeDrawingBrush.color = 'black';
                    console.log('COLOR SIN ASIGNAR EN DATASET VALOR')

                }   
            })

        })

    }

    asignarGrosores(elementos) {

        var th = this

        document.querySelectorAll(elementos).forEach(btn => {

            btn.addEventListener('click', e => {

                if (typeof btn.value !== 'undefined' || btn.value !== '') {

                    th._canvas.freeDrawingBrush.width = Number(btn.value);

                } else {

                    th._canvas.freeDrawingBrush.width = 5;
                    console.log('VALOR SIN ASIGNAR EN VALUE')

                }   

            })

        })

    }

    asignarTexto(elemento) {

        var th = this

        this._elementos[elemento] = document.querySelector(`#${elemento}`)

        this._elementos[elemento].addEventListener('click', () => {
            th._canvas.isDrawingMode = false;
            const text = new fabric.IText('Texto...', th._texto);
            th._canvas.add(text);
        })

    }

    formaCuadrado(elemento) {

        var th = this

        this._elementos[elemento] = document.querySelector(`#${elemento}`)

        this._elementos[elemento].addEventListener('click', () => {
            th._canvas.isDrawingMode = false;
            const cuadrado = new fabric.Rect(th._cuadrado);
            th._canvas.add(cuadrado);
        })

    }
    
    formaCirculo(elemento) {

        var th = this

        this._elementos[elemento] = document.querySelector(`#${elemento}`)

        this._elementos[elemento].addEventListener('click', () => {
            th._canvas.isDrawingMode = false;
            const circulo = new fabric.Circle(th._circulo);
            th._canvas.add(circulo);
        })

    }

    formaPersonalizada(elemento, propiedades, patron) {

        var th = this

        this._elementos[elemento] = document.querySelector(`#${elemento}`)

        propiedades['fill'] = (typeof propiedades['fill'] !== 'undefined') ? propiedades['fill'] : 'transparent';
        propiedades['stroke'] = (typeof propiedades['stroke'] !== 'undefined') ? propiedades['stroke'] : 'black';
        propiedades['top']  = (typeof propiedades['top']  !== 'undefined') ? propiedades['top']  : 0;
        propiedades['left'] = (typeof propiedades['left'] !== 'undefined') ? propiedades['left'] : 20;

        this._elementos[elemento]['propiedades'] = propiedades
        this._elementos[elemento]['patron'] = patron

        this._elementos[elemento].addEventListener('click', () => {

            th._canvas.isDrawingMode = false;

            var path = new fabric.Path(th._elementos[elemento]['patron']);   
            var escala = 100 / path.width;
            var props = { 
                scaleX: escala, 
                scaleY: escala, 
                top: th._elementos[elemento].propiedades.top,
                left: th._elementos[elemento].propiedades.left,
                fill: th._elementos[elemento].propiedades.fill,
                stroke: th._elementos[elemento].propiedades.stroke
            }
   
            path.set(props);
            th._canvas.add(path);

        })

    }

    capturarImagen() {

        this._resultado = this._canvas.toDataURL(this._formato);

        return this._resultado

    }

    removerTeclado(evento) {
        if (evento.keyCode === 46) {
            this._canvas.remove(this._canvas.getActiveObject());
        }
    }

    seleccionarTeclado(evento) {
        if (evento.keyCode === 13) {
            this._canvas.isDrawingMode = false;
        }
    }

}

////////////////////////////////////////////////////////////////////////////////////////////////
//EJEMPLO
//////////////////////////////////////////////////////////////////////////////////////////////////

window.imgBio = new Canvas('contenedor', 'seleccionar', 'remover', true) //imagen biometria

imgBio.asignarImagen('/paginas/dibujar/bg.jpg')
imgBio.asignarDibujadoInicial('black', 5)
imgBio.asignarDibujados('.dibujar')
imgBio.asignarGrosores('.slider')
imgBio.asignarTexto('texto')
imgBio.formaCuadrado('cuadrado')
imgBio.formaCirculo('circulo')

imgBio.formaPersonalizada('corazon', {}, 'M 272.70141,238.71731 \
    C 206.46141,238.71731 152.70146,292.4773 152.70146,358.71731  \
    C 152.70146,493.47282 288.63461,528.80461 381.26391,662.02535 \
    C 468.83815,529.62199 609.82641,489.17075 609.82641,358.71731 \
    C 609.82641,292.47731 556.06651,238.7173 489.82641,238.71731  \
    C 441.77851,238.71731 400.42481,267.08774 381.26391,307.90481 \
    C 362.10311,267.08773 320.74941,238.7173 272.70141,238.71731  \
    z '
)

imgBio.formaPersonalizada('forma', {fill: 'transparent', stroke: 'black'}, `M120.8602,63.449056q-35.096527,12.657935,1.231457,16.110097c-33.733296,1.493948-24.361628,9.178024-19.13719,12.65793c5.954242,4.009143,8.235845,6.572201,19.137189,5.41465c15.917545,2.858628,10.301356,7.253808-10.467384,14.147614s9.150424,6.306059,24.002112,9.876084-6.940727,9.16262-24.002112,15.137051s6.463382,11.089412,54.223099,12.978716c29.557498-2.378651,26.944529-10.507104,0-18.735085-6.85772-4.456182,8.674524-10.753465,21.258366-19.832125c9.604973-14.443615-3.017407-16.348224-30.841146-13.572255-6.26459-5.41465,9.58278-3.113205,9.58278-18.07258-20.111397,7.916884-34.124788,8.305147-25.873841-2.301445c4.656984-5.986552,17.376705-3.438281,16.291061-16.110098q-.307863-10.356493-35.40439,2.301445Z`)

////////////////////////////////////////////////////////////////////////////////////////////////
document.querySelector('#valor').innerHTML = document.querySelector('#rango').value
////////////////////////////////////////////////////////////////////////////////////////////////
document.querySelector('#rango').addEventListener('input', e => {
    document.querySelector('#valor').innerHTML = e.target.value
})
////////////////////////////////////////////////////////////////////////////////////////////////

document.querySelector('#capturar').addEventListener('click', function () {
 
    console.log(imgBio.capturarImagen())
    //IMAGEN GUARDADA EN FORMATO BASE64 - ESTE FORMATO SE PUEDE ENVIAR A PHP PARA GENERAR LA IMAGEN Y GUARDARLA EN UNA RUTA
    document.querySelector('#imagen').src = imgBio._resultado;

});

////////////////////////////////////////////////////////////////////////////////////////////////
window.addEventListener('keyup', (e) => {
    imgBio.removerTeclado(e)
    imgBio.seleccionarTeclado(e)
})
