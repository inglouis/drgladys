/////////////////////////////////////////////////////
import { Herramientas } from '../js/main.js';
const tools = new Herramientas()

/////////////////////////////////////////////////////
window.qs    = document.querySelector.bind(document)
window.qsa   = document.querySelectorAll.bind(document)
/////////////////////////////////////////////////////
window.procesar = true;
window.idEliminar = 0
window.idSeleccionada = 0
/////////////////////////////////////////////////////

/* -------------------------------------------------------------------------------------------------*/  
//                      eventos exclusivos de el archivo js
/* -------------------------------------------------------------------------------------------------*/
qs('#clinica-iniciar').addEventListener('click', qs('#clinica-iniciar').iniciarSesion = async function () {
	
    if (window.procesar) {

        tools['mensaje']  = 'Procesando...'
        tools.mensajes(['#ffc107', '#fff'])

        window.procesar = false
        
        var datos = tools.procesar('', '', 'login-valores', tools)

        if (datos !== '') {

            var resultado = await tools.fullAsyncQuery('login', 'iniciar', datos)

            if (resultado.includes('exito')) {

                tools['mensaje']  = 'SESIÓN INICIADA'
                tools.mensajes(true)

                setTimeout(() => {

                    window.location.href = '../paginas/index.php'

                }, 1500);


            } else if (resultado.trim() === 'usuario') {

                tools.alertaInput(qs("#usuario").parentElement)
                tools['mensaje']  = 'Usuario equivocado o inexistente'
                tools.mensajes(false)

            } else {

                tools['mensaje']  = 'Error al procesar la petición'
                tools.mensajes(false)
                console.log(resultado)
            }
            
            window.procesar = true

        }

    }

})

window.addEventListener('keyup', (e) => {

    if (e.key === 'Enter') {

        qs('#clinica-iniciar').iniciarSesion()

    }

})