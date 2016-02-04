<?php
	include "cabecera.php";

	$gestorReqPrincipal = new GestorReqPrincipal;
	/*
	* Cuando hago un click en alguna de las notificaciones me redirije al post de donde procede la notificación
	* Luego cambia de color negro oscuro a gris para indicar que ya fue vista
	*/
?>
<div class="container">
	<div class="row col-md-offset-2">
		<?php
		if($notificaciones!=""){
			foreach ($notificaciones as $notificacion) {
				$usuario = $gestorReqPrincipal->obtenerUsuario($notificacion->getIdUsuarioGenera());
				$post = $gestorReqPrincipal->obtenerPost($notificacion->getIdPost());
				echo 	'<div class="alert alert-success col-md-9" role="alert">
							<a style="text-align: center;" href="'.URL.'GestorReqPrincipal/mostrarPost/'.$post->getID().'">';
								if($notificacion->getTipo()=="comentario"){
									# es una notificacion de comentario
									echo '<p><b>'.$usuario->getNombreCompleto().'</b> realizo un '.$notificacion->getTipo().' sobre el post <b>'.$post->getTitulo().'</b> el día '.$notificacion->getFecha().'</p>';
								}else{
									# es una notificacion de denuncia por lo que tengo que recuperar el tipo y el motivo
									$denuncia = $gestorReqPrincipal->obtenerDenuncia($notificacion->getIdUsuarioGenera(), $notificacion->getIdPost());
									echo '<p><b>'.$usuario->getNombreCompleto().'</b> realizo una '.$notificacion->getTipo().' sobre el post <b>'.$post->getTitulo().'</b> por '.$denuncia->getMotivo().' argumentado que contenia '.$denuncia->getArgumento().' el día '.$notificacion->getFecha().'</p>';
								}
							echo '</a>
						</div>';
			}
		}else{
			echo '<div class="alert alert-info col-md-8" role="alert"><h3 style="text-align: center;">No tiene notificaciones</h3></div>';
		} ?>
	</div>
</div>