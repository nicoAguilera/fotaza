<?php

include "cabecera.php";

 ?>
 	<div class="container">
 		<div class="row">

 			<!-- Menu secundario -->
 			<ul class="nav nav-tabs">
 				<li role="presentation" class="active"><a href="">Denuncias</a></li>
				<!--li role="presentation"><a href="">Usuarios</a></li-->
			</ul>

			<div class="main">
				<!--div class=""-->
				<?php
					$gestorReqPrincipal = new GestorReqPrincipal;
					if($notificaciones!=""){
						foreach ($notificaciones as $notificacion) {
							$post = $gestorReqPrincipal->obtenerPost($notificacion->getIdPost());
							$autor = $gestorReqPrincipal->obtenerUsuario($post->getIdUsuario());
						?>
							<div class="col-md-offset-2"><br>
								<!--div class="col-md-9"-->
								<div class="panel panel-danger">
							        <div class="panel-heading">
										<h4>El post <b><a href="<?php echo URL; ?>GestorReqPrincipal/mostrarPost/<?php echo $post->getID(); ?>"><?php echo $post->getTitulo(); ?></a></b> perteneciente a <b><a href="<?php echo URL; ?>GestorReqPrincipal/mostrarPerfil/<?php echo $autor->getIdUsuario(); ?>"><?php echo $autor->getNombreCompleto(); ?></a></b> supero el límite de denuncias</h4>
									</div>
							<?php
								$denuncias = $gestorReqPrincipal->obtenerDenuncias($post->getID());
								echo '<div class="panel-body">';
								foreach ($denuncias as $denuncia) { 
									$usuario = $gestorReqPrincipal->obtenerUsuario( $denuncia->getIdUsuarioDenuncia() );
								?>
									<!--FORMATO: El usuario "pepito" denuncio el post por contenido "motivo"("argumento") -->
									<p>El usuario <b><?php echo $usuario->getNombreCompleto(); ?></b> denuncio el post por contenido <?php echo $denuncia->getMotivo(); ?>(<?php echo $denuncia->getArgumento(); ?>)</p>
								<?php }
								echo '</div></div></div>';
						}
					}else{
						echo "<p>No tiene notificaciones</p>";
					}
				 ?>
				</div>
			</div>
 		</div>
 	</div>