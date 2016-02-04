<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Fotaza</title>
	<script src="<?php echo URL; ?>public/js/jquery-1.11.0.min.js"></script>

	<!-- Latest compiled and minified CSS -->
	<!--link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"-->
	<link rel="stylesheet" href="<?php echo URL; ?>public/css/bootstrap.min.css">

	<!-- Latest compiled and minified JavaScript -->
	<script src="<?php echo URL; ?>public/js/bootstrap.min.js"></script>

	<link type="text/css" href="<?php echo URL; ?>public/css/jquery-ui-1.10.4.custom.min.css" rel="Stylesheet" />

	<link rel="stylesheet" type="text/css" href="<?php echo URL; ?>public/css/base.css">
</head>
<body>
	<div class="container">
		<header>
			<nav class="navbar navbar-default navbar-fixed-top">
		        <div class="container">
		          <div class="navbar-header">
		            <!--Boton de menu para dispositivo movil-->
		            <button type="button" id="posicion-menu-collapsed" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-1">
		              <span class="sr-only">Menu</span>
		              <span class="icon-bar"></span>
		              <span class="icon-bar"></span>
		              <span class="icon-bar"></span>
		            </button>

		            <!--Logo de Home del negocio-->
		            <a href="<?php echo URL; ?>GestorReqPrincipal/mostrarPosts/posts/1" class="navbar-brand">
		            	Fotaza
		              <!--img src="img/logo-CoolStyle-editado.svg" alt="CoolStyle"-->
		            </a>

		            <form action="" id="form_busqueda" class="alinearBarraVerticalmente navbar-form navbar-left" role="search">   <!-- La barra de busqueda desaparece de la barra de menu de pantallas menores a 992px -->
		            <!--Barra de busqueda-->
		              <div class="form-group">
		                <div class="input-group">
		                	<input type="text" class="form-control" placeholder="Buscar Post" id="buscar">
		                  	<span class="input-group-addon glyphicon glyphicon-search" aria-hidden="true"></span>
		                </div>
		              </div>
		            </form>
		            
		          </div>

		          <!--Menú principal de navegación-->
		          <div class="collapse navbar-collapse" id="navbar-1">
		            <ul class="nav navbar-nav navbar-right">
		              <?php
		              		/*
		              		* Si existe una sesión se muestra el nombre de usuario en un link con el cual puede acceder al perfil del mismo
							* ademas se muestra un link de notificaciones y otro para cerrar sesión
							* 
							* Caso contrario se muestra un link para ir a la página para iniciar sesión o registrarse
							*/
		              		if(Session::exist()){
		              			/*
		              			* Si estoy en la pagina del perfil muestro el link seleccionado
		              			*/
		              			if(isset($_GET['url']) && ($_GET['url']==='GestorReqPrincipal/mostrarPerfil/'.Session::getValue('U_ID') || $_GET['url']==='GestorReqPrincipal/mostrarInfoPerfil/'.Session::getValue('U_ID')) ){
		              				echo '<li class="active"><a href="'.URL.'GestorReqPrincipal/mostrarPerfil/'.Session::getValue('U_ID').'">'.Session::getValue('U_NOMBRE').'</a></li>';
		              			}elseif(Session::getValue('U_ID') == 1){
		              				// si es el administrador no se muestra la opción de ver el perfil porque no posee
		              			}else{
		              				echo '<li><a href="'.URL.'GestorReqPrincipal/mostrarPerfil/'.Session::getValue('U_ID').'">'.Session::getValue('U_NOMBRE').'</a></li>';
		              			}
		              			/*
		              			* Si estoy en la pagina de notificaciones muestro el link seleccionado
		              			*/
		              			if(isset($_GET['url']) && $_GET['url']==='GestorReqPrincipal/mostrarNotificacion/'.Session::getValue('U_ID') ) {
		              				echo '<li class="active"><a href="'.URL.'GestorReqPrincipal/mostrarNotificacion/'.Session::getValue('U_ID').'">Notificaciones</a></li>';
		              			}
		              			// Si es el usuario administrador y se encuentra en la seccion de las notificaciones, se muestra el enlace seleccionado
		              			elseif(isset($_GET['url']) && $_GET['url']==='GestorReqPrincipal/mostrarPanelControl'){
		              				echo '<li class="active"><a href="'.URL.'GestorReqPrincipal/mostrarPanelControl">Notificaciones</a></li>';
		              			}
		              			// Si es el usuario administrador y NO se encuentra en la sección de Notificaciones
		              			elseif(Session::getValue('U_ID') == 1){
		              				echo '<li><a href="'.URL.'GestorReqPrincipal/mostrarPanelControl">Notificaciones</a></li>';
		              			}
		              			// Es un usuario normal y se muestra el enlace a la pagina de notificaciones del usuario
		              			else{
		              				echo '<li><a href="'.URL.'GestorReqPrincipal/mostrarNotificacion/'.Session::getValue('U_ID').'">Notificaciones</a></li>';
		              			}
		              			echo '<li><a href="'.URL.'GestorReqPrincipal/destruirSession">Salir</a></li>';
		              		}
		              		else{
		              			if(isset($_GET['url']) && $_GET['url']==='GestorReqPrincipal/mostrarLogin'){
		              				/*
			              			* Si estoy en la pagina de login muestro el link seleccionado
			              			*/
			              			echo '<li class="active"><a href="'.URL.'GestorReqPrincipal/mostrarLogin">Iniciar Sesión</a></li>';
		              			}else{
		              				echo '<li><a href="'.URL.'GestorReqPrincipal/mostrarLogin">Iniciar Sesión</a></li>';
		              			}
		              		}
		              ?>
		            </ul>
		          </div>
		        </div>
		    </nav>
		</header>
		<script>
			$(document).ready(function(){
				$('#form_busqueda').submit(function(e){
					e.preventDefault();
				});

				// Determino el foco sobre la barra de busqueda con el valor ingresado
				<?php if(!empty($clave)){ ?>
					$('#buscar').focus().val('<?php echo $clave; ?>');
				<?php }else{
					$clave = "";
				} ?>

				$('#buscar').keyup(function(){

					var clave = $('#buscar').val();
					$('#resultados').text(clave);

					if(clave != ""){
						$('#resultados').text('Buscando');

						// Sino se encuntra en la pagina de resultados de busqueda se redirije a la misma
						if(window.location.pathname != '/PracticoMaquina/GestorReqPrincipal/mostrarResultadoBusqueda/<?php echo $clave; ?>'){
						    location.href = "<?php echo URL; ?>GestorReqPrincipal/mostrarResultadoBusqueda/"+clave;
						}else{
							// Caso contrario se realiza la busqueda y se vuelcan los resultados en la pagina
							$.ajax({
								type: 'POST',
								url: "<?php echo URL; ?>GestorReqPrincipal/buscadorPrincipal",
								data: {clave: clave},
								success: function(response){
									
									lista = JSON.parse(response);

									if(lista.length > 0){
										//Si encuentra resultados
										var resultado = "";
								        for(var i in lista){
								        	resultado += '<div class="media well">'+
								        					'<div class="media-left">'+
								        						'<a href="<?php echo URL; ?>GestorReqPrincipal/mostrarPost/'+ lista[i]["P_ID"] +'">';
								        							if(lista[i]['P_ID_Video']==null){
								 					 					resultado += '<img class="media-object" src="<?php echo URL; ?>publicaciones/'+ lista[i]["P_ID"] +'.jpg" alt="..." width="120">';
								 					 				}else{
								 					 					resultado += '<img src="http://img.youtube.com/vi/'+ lista[i]["P_ID_Video"] +'/default.jpg" class="media-object" alt="" />';
								 					 				}
								        		resultado +=	'</a>'+
								        					'</div>'+
								        					'<div class="media-body">' +
								        						'<h3 class="media-heading">Post: ' +
								        							'<a href="<?php echo URL; ?>GestorReqPrincipal/mostrarPost/'+ lista[i]["P_ID"] +'">' +
								        							 	lista[i]["P_Titulo"] + 
								        							'</a>' +
								        						'</h3>' +
								        						'<label>Autor:</label>' +
								        						'<a href="<?php echo URL; ?>GestorReqPrincipal/mostrarPerfil/'+ lista[i]["U_ID"] +'"> ' +
								        							lista[i]["U_Nombre"] + " " + lista[i]["U_Apellido"] +
								        						'</a>' +
								        					'</div>' +
								        				'</div>';
								        	
								        }
								        $('#resultados').html(resultado);
							    	}else{
							    		$('#resultados').html('<div class="alert alert-info" role="alert">No se encontraron resultados...</div>');
							    	}
								}
							});
						}
					}else{
						$('#resultados').html('<div class="alert alert-info" role="alert">Ingrese un parametro de busqueda</div>');
					}
				});
			});
		</script>
		
	</div>