<?php

include "cabecera.php";

?>
	<div class="container">
		<div class="row">
			<?php
				# Si existe una sessión y corresponde al usuario que solicito ver los posts de imagenes se muestra el menu correspondiente
				if(Session::exist() && Session::getValue('U_ID') == $idUsuario){ ?>
					<!-- Menu secundario de navegación -->
					<div class="">
						<ul class="nav nav-tabs">
							<li role="presentation"><a href="<?php echo URL; ?>GestorReqPrincipal/mostrarPerfil/<?php echo $idUsuario; ?>">Biografía</a></li>
							<li role="presentation"><a href="<?php echo URL; ?>GestorReqPrincipal/mostrarPosts/imagenes/1/<?php echo $idUsuario; ?>">Imagenes</a></li>
							<li role="presentation" class="active"><a href="">Videos</a></li>
							<li role="presentation"><a href="<?php echo URL; ?>GestorReqPrincipal/mostrarInfoPerfil/<?php echo $idUsuario; ?>">Información</a></li>
						</ul>
					</div>
			<?php }else{ ?>
					<div class="">
						<ul class="nav nav-tabs">
							<li role="presentation"><a href="<?php echo URL; ?>GestorReqPrincipal/mostrarPosts/imagenes/1/<?php echo $idUsuario; ?>">Imagenes</a></li>
							<li role="presentation" class="active"><a href="">Videos</a></li>
						</ul>
					</div>
			<?php } ?>
			
			
			<!-- Contenido de la sección de videos del perfil -->
			<div class="main col-xs-12">

				<?php
					$gestorReqPrincipal = new GestorReqPrincipal;
					$usuario = $gestorReqPrincipal->obtenerUsuario($idUsuario);
					echo '<h2>Videos de '. $usuario->getNombreCompleto() .'</h2>';

					# Si el administrador esta viendo el perfil de usuario se muestra un boton para dar de baja la cuenta
					if(Session::exist() && Session::getValue('U_ID') == 1){
						echo '<a href="#avisoBaja" class="btn btn-danger" data-toggle="modal">Eliminar cuenta usuario</a>';
					}
				?>
					<!-- Ventana emergente para verificar la seguridad de la eliminacion de la cuenta -->
						<div class="modal fade" id="avisoBaja">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button tyle="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
										<h4 class="modal-title">Cuidado!</h4>
									</div>

									<div class="modal-body">
										Esta a punto de dar de baja la cuenta de este usuario.
									</div>

									<div class="modal-footer">
										<button type="button" class="btn btn-warning"  id="btnEliminarCuenta">Dar de baja</button>
										<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
									</div>
								</div>
							</div>
						</div>
			<?php	
			# listo las publicaciones de todos los usuarios
			if($publicaciones!=NULL){
				echo '<ul class="productos col-md-12">';
				//var_dump($publicaciones);
				foreach ($publicaciones as $publicacion) {

					echo '<li class="col-xs-12 col-sm-4 col-md-3 col-lg-2">
							<a href="'.URL.'GestorReqPrincipal/mostrarPost/'.$publicacion->getID().'" class="thumbnail">
							<div class="producto">
							<figure class="row">
		                        <div class="imagen col-xs-4 col-sm-3 col-md-10 galeria">
		                        	<img src="http://img.youtube.com/vi/'.$publicacion->getIdVideo().'/default.jpg" class="img-responsive" alt="" />
						            <div style="position: absolute; left: 28%; top: 15%;"  >
						            <img src="'.URL.'public/botonVideo.png" width="30%"alt="" />
		                   		</div>
		                                    
		                        <figcaption class="col-xs-3 col-sm-5 col-md-10 galeria">
		                            <h3>'.$publicacion->getTitulo().'</h3>
		                        </figcaption>
		                    </figure>
		                    </div>
		                    </a>
		                </li>';	
				}
				echo '</ul>';
			}else{ ?>
				<div class="alert alert-info" role="alert">
					<p>No tiene publicaciones de videos</p>
				</div>
			<?php }
			?>
				<nav>
					<ul class="pagination">
						<?php
							include "paginacion.php";
						 ?>
					</ul>
				</nav>
				
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#btnEliminarCuenta').click(eliminarCuenta);
		});
	</script>
	<script type="text/javascript" src="<?php echo URL; ?>public/js/eliminarCuenta.js"></script>
</body>
</html>