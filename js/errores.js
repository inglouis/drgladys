import  {Tabla} from '../js/crud.js';
import  {PopUp, Acciones, Herramientas, ContenedoresEspeciales, paginaCargada} from '../js/main.js';

const tools = new Herramientas()

/////////////////////////////////////////////////////
window.qs    = document.querySelector.bind(document)
window.qsa   = document.querySelectorAll.bind(document)
/////////////////////////////////////////////////////
window.procesar = true;
window.idEliminar = 0
window.idSeleccionada = 0

window.cargar = new paginaCargada('#tabla-errores thead .ASC', 'existencia')
window.cargar.revision()

//---------------------------------------------------------------------------------//
//								ERRORES
//---------------------------------------------------------------------------------//

class Errores extends Acciones {
	constructor (crud) {
		super(crud)
		this.fila
		this.clase = 'erroes'
		this.funcion = 'buscarErrores'
		//-------------------------------
		this.alternar = ''
		this.especificos =  ['id_error', 'titulo', 'linea_error']
		this.limitante = 0
		this.boton = ''
		//-------------------------------
		this.div = document.createElement('div')
		this.contenido = qs('#errores-contenedor').content.querySelector('.contenido-error').cloneNode(true)
	}


}

window.errores = new Errores(new Tabla(
	[
		['Errores', true, 0],
		['Acciones', false, 0]
	],
	'tabla-errores','busqueda', 11,'izquierda','derecha','numeracion',true
))

errores['crud'].cuerpo.push([errores['crud'].columna = errores['crud'].cuerpo.length, [errores['crud'].gDiv(null,null)], [''], ['HTML'], 'errores-contenedor', ''])
errores['crud'].cuerpo.push([errores['crud'].columna = errores['crud'].cuerpo.length, [
	errores['crud'].gBt(['eliminar btn btn-danger', 'Eliminar error'], `X`)
], [false], ['VALUE'], 'crud-botones', 0])

errores['ofv'] = true
errores['ofvh'] = '100%'

errores['crud']['propiedadesTr'] = {
	"cargarContenido": (e) => {
				
		var fr = new DocumentFragment(), 
			th = errores, 
			contenedor = e.querySelector('.errores-contenedor'), 
			contenido = th.contenido.cloneNode(true)

		contenido.querySelector('.error-id').value = e.sublista.id_error

		contenido.querySelector('.error-mensaje').value  = e.sublista.mensaje_php
		contenido.querySelector('.error-codigo').value   = e.sublista.codigo_error
		contenido.querySelector('.error-linea').value    = e.sublista.linea_error
		contenido.querySelector('.error-ruta').value     = e.sublista.ruta_error
		contenido.querySelector('.error-personalizado').value  = e.sublista.mensaje_personalizado
		contenido.querySelector('.error-fecha').value    = e.sublista.fecha_error
		contenido.querySelector('.error-hora').value     = e.sublista.hora
		contenido.querySelector('.error-recorrido').value  = e.sublista.recorrido_error

		contenedor.appendChild(contenido)

	}
}

errores['crud'].inputEliminar ('eliminar', '', [
	async function fn(params) {

		//---------------------------------------------------------------------------
		var sublista = tools.pariente(params.target, 'TR').sublista
		await tools.fullAsyncQuery('errores', 'eliminarError', [sublista.id_error])
		
    },
    function fn(params) {
		tools['mensaje'] = 'Error eliminado'
        tools.mensajes(true)
    }
]);

(async () => {
	var resultado = await tools.fullAsyncQuery('errores', 'cargarErrores', [])
	errores.cargarTabla(JSON.parse(resultado))
	errores['crud'].botonBuscar('buscar', false) 	
})()

//----------------------------------------------------------------------------------------------------
//										E V E N T O S                                                
//----------------------------------------------------------------------------------------------------

/* -------------------------------------------------------------------------------------------------*/	
//                      eventos exclusivos de el archivo js
/* -------------------------------------------------------------------------------------------------*/
