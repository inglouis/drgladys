<?php 

	//iconos svg del menu
	//////////////////////////////////////////
	if (!isset($_SESSION['svgs'])) {

		$_SESSION['svgs'] = array(

			"index" => '
				<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="home" class="svg-inline--fa fa-home fa-w-18 remp_class" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="currentColor" d="M280.37 148.26L96 300.11V464a16 16 0 0 0 16 16l112.06-.29a16 16 0 0 0 15.92-16V368a16 16 0 0 1 16-16h64a16 16 0 0 1 16 16v95.64a16 16 0 0 0 16 16.05L464 480a16 16 0 0 0 16-16V300L295.67 148.26a12.19 12.19 0 0 0-15.3 0zM571.6 251.47L488 182.56V44.05a12 12 0 0 0-12-12h-56a12 12 0 0 0-12 12v72.61L318.47 43a48 48 0 0 0-61 0L4.34 251.47a12 12 0 0 0-1.6 16.9l25.5 31A12 12 0 0 0 45.15 301l235.22-193.74a12.19 12.19 0 0 1 15.3 0L530.9 301a12 12 0 0 0 16.9-1.6l25.5-31a12 12 0 0 0-1.7-16.93z"></path></svg>
			',
			"historias" => '
				<svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="address-book" class="svg-inline--fa fa-address-book fa-w-14 remp_class" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M436 160c6.6 0 12-5.4 12-12v-40c0-6.6-5.4-12-12-12h-20V48c0-26.5-21.5-48-48-48H48C21.5 0 0 21.5 0 48v416c0 26.5 21.5 48 48 48h320c26.5 0 48-21.5 48-48v-48h20c6.6 0 12-5.4 12-12v-40c0-6.6-5.4-12-12-12h-20v-64h20c6.6 0 12-5.4 12-12v-40c0-6.6-5.4-12-12-12h-20v-64h20zm-68 304H48V48h320v416zM208 256c35.3 0 64-28.7 64-64s-28.7-64-64-64-64 28.7-64 64 28.7 64 64 64zm-89.6 128h179.2c12.4 0 22.4-8.6 22.4-19.2v-19.2c0-31.8-30.1-57.6-67.2-57.6-10.8 0-18.7 8-44.8 8-26.9 0-33.4-8-44.8-8-37.1 0-67.2 25.8-67.2 57.6v19.2c0 10.6 10 19.2 22.4 19.2z"></path></svg>
			',
			"configuracion" => '
				<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="cog" class="svg-inline--fa fa-cog fa-w-16 remp_class" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M487.4 315.7l-42.6-24.6c4.3-23.2 4.3-47 0-70.2l42.6-24.6c4.9-2.8 7.1-8.6 5.5-14-11.1-35.6-30-67.8-54.7-94.6-3.8-4.1-10-5.1-14.8-2.3L380.8 110c-17.9-15.4-38.5-27.3-60.8-35.1V25.8c0-5.6-3.9-10.5-9.4-11.7-36.7-8.2-74.3-7.8-109.2 0-5.5 1.2-9.4 6.1-9.4 11.7V75c-22.2 7.9-42.8 19.8-60.8 35.1L88.7 85.5c-4.9-2.8-11-1.9-14.8 2.3-24.7 26.7-43.6 58.9-54.7 94.6-1.7 5.4.6 11.2 5.5 14L67.3 221c-4.3 23.2-4.3 47 0 70.2l-42.6 24.6c-4.9 2.8-7.1 8.6-5.5 14 11.1 35.6 30 67.8 54.7 94.6 3.8 4.1 10 5.1 14.8 2.3l42.6-24.6c17.9 15.4 38.5 27.3 60.8 35.1v49.2c0 5.6 3.9 10.5 9.4 11.7 36.7 8.2 74.3 7.8 109.2 0 5.5-1.2 9.4-6.1 9.4-11.7v-49.2c22.2-7.9 42.8-19.8 60.8-35.1l42.6 24.6c4.9 2.8 11 1.9 14.8-2.3 24.7-26.7 43.6-58.9 54.7-94.6 1.5-5.5-.7-11.3-5.6-14.1zM256 336c-44.1 0-80-35.9-80-80s35.9-80 80-80 80 35.9 80 80-35.9 80-80 80z"></path></svg>
			',
			"legado" => '
				<svg class="remp_class" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><path fill="currentColor" d="M464 256A208 208 0 1 1 48 256a208 208 0 1 1 416 0zM0 256a256 256 0 1 0 512 0A256 256 0 1 0 0 256zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z"/></svg>
			'
		);

	}

	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////

	//agregar sección de configuracion solo para PHP y errores

	$lista_menu = array();

	array_push($lista_menu, array(
		"ruta" => 'historias,bloquear',
		"nombre"=> 'historias',
		"bloquear" => 0, 
		"editable" => 1
	));


	array_push($lista_menu, array(
		"ruta" => 'historias,ul,lista,historias,bloquear',
		"nombre"=> 'historias',
		"bloquear" => 0, 
		"editable" => 1
	));

	array_push($lista_menu, array(
		"ruta" => 'historias,ul,lista,formularios,bloquear',
		"nombre"=> 'formularios',
		"bloquear" => 0, 
		"editable" => 1
	));

	array_push($lista_menu, array(
		"ruta" => 'historias,ul,lista,formularios,ul,lista,diagnosticos,bloquear',
		"nombre"=> 'diagnosticos',
		"bloquear" => 0, 
		"editable" => 1
	));

	array_push($lista_menu, array(
		"ruta" => 'historias,ul,lista,formularios,ul,lista,estado_civil,bloquear',
		"nombre"=> 'estado_civil',
		"bloquear" => 0, 
		"editable" => 1
	));

	array_push($lista_menu, array(
		"ruta" => 'historias,ul,lista,formularios,ul,lista,parentesco,bloquear',
		"nombre"=> 'parentesco',
		"bloquear" => 0, 
		"editable" => 1
	));

	array_push($lista_menu, array(
		"ruta" => 'historias,ul,lista,formularios,ul,lista,proveniencias,bloquear',
		"nombre"=> 'proveniencias',
		"bloquear" => 0, 
		"editable" => 1
	));

	array_push($lista_menu, array(
		"ruta" => 'historias,ul,lista,formularios,ul,lista,medicos,bloquear',
		"nombre"=> 'medicos',
		"bloquear" => 0, 
		"editable" => 1
	));

	array_push($lista_menu, array(
		"ruta" => 'historias,ul,lista,formularios,ul,lista,religion,bloquear',
		"nombre"=> 'religion',
		"bloquear" => 0, 
		"editable" => 1
	));

	array_push($lista_menu, array(
		"ruta" => 'historias,ul,lista,formularios,ul,lista,ocupaciones,bloquear',
		"nombre"=> 'ocupaciones',
		"bloquear" => 0, 
		"editable" => 1
	));

	array_push($lista_menu, array(
		"ruta" => 'configuracion,bloquear',
		"nombre"=> 'configuracion',
		"bloquear" => 0, 
		"editable" => 1
	));

	array_push($lista_menu, array(
		"ruta" => 'configuracion,ul,lista,errores,bloquear',
		"nombre"=> 'errores',
		"bloquear" => 0, 
		"editable" => 1
	));

	array_push($lista_menu, array(
		"ruta" => 'configuracion,ul,lista,phpinfo,bloquear',
		"nombre"=> 'phpinfo',
		"bloquear" => 0, 
		"editable" => 1
	));

	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////

	$lista_menu_hover = json_decode('
  	{
  		"index":  {
	  		"atributos": "",
	  		"span": {
				"atributos": "class=tooltip-general",
				"titulo": "Inicio"
			},
			"a": {
				"href": "inicio.php",
				"titulo": ["index", "iconos-menu", ""]
			},
			"ul": "",
			"bloquear": 0
	  	},

	  	"historias": {
	  		"atributos": "",
	  		"span": {
				"atributos": "class=tooltip-general",
				"titulo": "Historias"
			},
			"a": {
				"href": "historias.php",
				"titulo": ["historias", "iconos-menu", ""]
			},
			"ul": {
				"atributos": "",
				"lista": {

					"historias":  {
				  		"atributos": "",
				  		"span": "",
						"a": {
							"href": "historias.php",
							"titulo": "Historias"
						},
						"ul": "",
						"bloquear": 0
				  	},

				  	"formularios":  {
				  		"atributos": "",
				  		"span": "",
						"a": {
							"href": "#",
							"titulo": "Formularios"
						},
						"ul": {
							"atributos": "",
							"lista": {


							  	"diagnosticos":  {
							  		"atributos": "",
							  		"span": "",
									"a": {
										"href": "diagnosticos.php",
										"titulo": "Diagnósticos"
									},
									"ul": "",
									"bloquear": 0
							  	},
								"ocupaciones":  {
							  		"atributos": "",
							  		"span": "",
									"a": {
										"href": "ocupaciones.php",
										"titulo": "Ocupaciones"
									},
									"ul": "",
									"bloquear": 0
							  	},
							  	"estado_civil":  {
							  		"atributos": "",
							  		"span": "",
									"a": {
										"href": "estado_civil.php",
										"titulo": "Estados civiles"
									},
									"ul": "",
									"bloquear": 0
							  	},
							  	"parentesco":  {
							  		"atributos": "",
							  		"span": "",
									"a": {
										"href": "parentescos.php",
										"titulo": "Parentesco"
									},
									"ul": "",
									"bloquear": 0
							  	},
							  	"proveniencias":  {
							  		"atributos": "",
							  		"span": "",
									"a": {
										"href": "proveniencias.php",
										"titulo": "Proveniencias"
									},
									"ul": "",
									"bloquear": 0
							  	},
							  	"medicos":  {
							  		"atributos": "",
							  		"span": "",
									"a": {
										"href": "medicos.php",
										"titulo": "Médicos referidos"
									},
									"ul": "",
									"bloquear": 0
							  	},
							  	"religion":  {
							  		"atributos": "",
							  		"span": "",
									"a": {
										"href": "religiones.php",
										"titulo": "Religión"
									},
									"ul": "",
									"bloquear": 0
							  	}

							}
						},
						"bloquear": 0
				  	}

				}
			}
		},

		"configuracion":  {
	  		"atributos": "",
	  		"span": {
				"atributos": "class=tooltip-general",
				"titulo": "Configuración"
			},
			"a": {
				"href": "#",
				"titulo": ["configuracion", "iconos-menu", ""]
			},
			"ul": {
				"atributos": "",
				"lista": {

				  	"phpinfo":  {
				  		"atributos": "",
				  		"span": "",
						"a": {
							"href": "phpinfo.php",
							"titulo": "PHP"
						},
						"ul": "",
						"bloquear": 0
				  	},
				  	"errores":  {
				  		"atributos": "",
				  		"span": "",
						"a": {
							"href": "errores.php",
							"titulo": "Errores"
						},
						"ul": "",
						"bloquear": 0
				  	}

				}
			},
			"bloquear": 0
	  	}
  	}', true);
	
?>