<?php
	include "cabecera.php";
			/*
			* Recupero una publicacion en particular con sus respectivos comentarios
			*
			* Utilizo el gestorReqPrincipal para obtener el autor de cada comentario
			*/

			$gestorReqPrincipal = new GestorReqPrincipal;

		?>
		<div class="container">
			<!-- Fila que contiene la imagen y el detalle del post-->
			<div class="row">
				<h1><?php echo $post->getTitulo(); ?></h1>
				<div class="col-md-8">
					<?php if($post->getIdVideo()==NULL){ ?>
						<img src="<?php echo URL; ?>publicaciones/<?php echo $post->getID(); ?>.jpg" class="img-responsive" />
					<?php }else{ ?>
					<div class="embed-responsive embed-responsive-16by9">
						<iframe class="embed-responsive-item" src=https://www.youtube.com/embed/<?php echo $post->getIdVideo(); ?> frameborder="0" allowfullscreen></iframe>
					</div>
					<?php } ?>
				</div>
				<div class="detallePost col-md-4">
					<!-- Nombre del autor que publico el post -->
					<h3><a href="<?php echo URL; ?>GestorReqPrincipal/mostrarPerfil/<?php echo $usuario->getIdUsuario(); ?>"><?php echo $usuario->getNombreCompleto(); ?></a></h3>

					<!-- Detalle de la descripción del post y las etiquetas que contiene-->
					<div class="alineacion">
						<div id="etiquetas" class="row">
							<?php foreach ($post->getEtiquetas() as $etiqueta) { ?>
								<a class="btn-lg btn-link" href="<?php echo URL; ?>GestorReqPrincipal/mostrarResultadoBusqueda/<?php echo $etiqueta->getDetalle(); ?>"><span class="glyphicon glyphicon-tag" aria-hidden="true"></span><?php echo $etiqueta->getDetalle(); ?></a>
							<?php }?>
						</div>


						<! DETALLE del post>
						<div id="detalle" class="row well well-sm">
                            <p class="col-md-12"><?php echo $post->getDetalle(); ?></p>
                            <?php if(Session::exist() && Session::getValue('U_ID')==$post->getIdUsuario() ){ ?>
	                            <div class="btnCambiar">
	                                <button class="btn btn-link" id="btnDetalle">Editar detalle post</button>
	                            </div>
                            <?php } ?>
                        </div>
                        <div class="ocultarInput detalle row">
                            <div class="col-md-12">
                            	<textarea class="form-control detalleNuevo" rows="2" cols="50" name="detalle"><?php echo $post->getDetalle(); ?></textarea>
                                <!--textarea class="form-control" name="detalle" type="text" value="<?php //echo $post->getDetalle(); ?>" placeholder="Detalle del post"/-->
                            </div>
                            <div class="col-md-4">
                                <button id="btnCambiarDetalle" class="btn btn-success">Guardar</button>
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-danger btnCancelar">Cancelar</button>
                            </div>
                        </div>
					</div>

					<!-- Comentarios del post ordenados por fecha -->
					<?php
					if($post->getComentarios()!=NULL){
						foreach ($post->getComentarios() as $comentario) { 
							$autorComentario = $gestorReqPrincipal->obtenerUsuario($comentario->getIdUsuario());
					?>
						
					<! Utilizar angular.js para cargar un nuevo comentario y luego almacenarlo en la base de datos con ajax para no tener que recargar la pagina>
					<!--div class="comentario row"-->
					<div class="panel panel-default">
						<div class="panel-heading">
							<div class="panel-title">
								<a href="<?php echo URL; ?>GestorReqPrincipal/mostrarPerfil/<?php echo $autorComentario->getIdUsuario(); ?>"><?php echo $autorComentario->getNombreCompleto(); ?></a>
							</div>
						</div>
					
						<div class="panel-body">
							<div class="col-md-12">
								<p class="detalleComentario"><?php echo $comentario->getDetalle(); ?></p>
							</div>
						</div>

						<div class="panel-footer">
							<!--div class="col-md-7"-->
								<?php echo $comentario->getFecha(); ?>
							<!--/div-->
							<?php if(Session::exist()){ 
									if(Session::getValue('U_ID')===$post->getIdUsuario()){ ?>
										<!--div class="col-md-5"-->
											<a class="btn btn-xs btn-danger" href="<?php echo URL; ?>GestorReqPrincipal/eliminarComentario/<?php echo $comentario->getID(); ?>/<?php echo $post->getID(); ?>">Eliminar</a>
										<!--/div-->
							<?php } } ?>
						</div>
						
					</div>
					<?php } }?>
					
					<!-- Si esta logueado y no es el administrador se muestra un campo para agregar un nuevo comentario -->
					<?php if(Session::exist() && Session::getValue('U_ID')!=1){ ?>
					<form name="formComent" method="POST">
						<div class="form-group">
							<label class="control-label"><?php echo Session::getValue('U_NOMBRE'); ?></label>
							<input name="comentario" class="form-control" type="text" placeholder="Escribe un comentario...">
						</div>
						<input class="btn btn-primary" type="submit" value="Comentar" id="agregarComent">
					</form>
					<?php } ?>
					
				</div>
			</div>

			<!-- Fila que contiene la opción de denunciar el post-->
			<div class="row">
				<!-- Opción para denunciar el post -->
					<?php if(Session::exist() && Session::getValue('U_ID')!=$post->getIdUsuario() && Session::getValue('U_ID')!=1){
						// Analizar si el usuario en cuestión ya denuncio el post para que en dicho caso se muestre la opción "POST DENUNCIADO"
						$resultado = $gestorReqPrincipal->buscarDenuncia(Session::getValue('U_ID'), $post->getID());
						if($resultado == TRUE){
							echo "<p>POST DENUNCIADO</p>";
						}else{?>
							<! Boton para denunciar el post>
							<div id="denuncia">
								<button id="btnAgregarDenuncia" class="btn btn-link">Denunciar post</button>
							</div>

							<div class="ocultarInput denuncia">
								<div class="form-group col-md-12">
									<label class="col-xs-5 col-md-12 control-label">Seleccione un motivo por el cual realiza la denuncia:</label>
									<div class="col-md-2">
										<select name="motivo" class="form-control">
											<option>Seleccionar</option>
											<option>Contenido vulgar</option>
											<option>Violento</option>
											<option>Infringe la ley</option>
											<option>Otro</option>
										</select>
									</div>
								</div>

	                            <div class="form-group col-md-12">
	                            	<label class="col-md-12 control-label">Escriba una breve argumentación:</label>
	                            	<div class="col-md-6">
	                            		<input class="form-control" name="argumento" type="text" value="" placeholder="Argumentación"/>
	                            	</div>
	                            </div>

	                            <div class="col-md-2">
	                                <button id="btnDenunciar" class="btn btn-warning">Denunciar</button>
	                            </div>
	                            <div class="col-md-10">
	                                <button class="btn btn-danger btnCancelar">Cancelar</button>
	                            </div>
	                        </div>
						<?php } 
					}elseif(Session::exist() && Session::getValue('U_ID')==1){ 
						//Si el administrador esta visualizando el post se muestra la opción de eliminar el mismo
					?>
						<br>
						<a href="#aviso" class="btn btn-danger" data-toggle="modal">Eliminar Post</a>
						<button class="btn btn-success" id="btnDesestimar">Desestimar denuncias</button>
						<div class="modal fade" id="aviso">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button tyle="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
										<h4 class="modal-title">Cuidado!</h4>
									</div>

									<div class="modal-body">
										Esta a punto de dar de baja a este post.
									</div>

									<div class="modal-footer">
										<button type="button" class="btn btn-warning"  id="btnEliminarPost">Dar de baja</button>
										<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
									</div>
								</div>
							</div>
						</div>

					<?php } ?>
			</div>
		</div>

		<script>
			$(document).ready(function(){
				$('#btnDetalle').click(function(){
	                $("#detalle").hide();
	                $('.detalle').fadeToggle();
	            });

	            $("#btnCambiarDetalle").click(actualizarDetalle);

	            $(".btnCancelar").click(function(){
	                location.reload();
	            });

				$('#agregarComent').click(function(e){
                     e.preventDefault();
                     agregarComentario();
                 });

				$('#btnAgregarDenuncia').click(function(){
	                $("#denuncia").hide();
	                $('.denuncia').fadeToggle();
	            });

	            $('#btnDenunciar').click(agregarDenuncia);

	            $('#btnEliminarPost').click(eliminarPost);

	            $('#btnDesestimar').click(desestimarDenuncia);
			});

			function actualizarDetalle(){
	            var dato = $('.detalleNuevo')[0].value;
	            if(dato!=""){
	                $.ajax({
	                    type: "POST",
	                    url: "<?php echo URL; ?>GestorReqPrincipal/actualizarPost",
	                    data: {idPost: <?php echo $post->getID(); ?>, columna:"P_Detalle", dato:dato}
	                }).done(function(response){
	                    location.reload();
	                });
	            }else{
	                //muestro un mensaje de error indicando que no puede ser vacio
	                $('.detalleNuevo').parent().addClass("has-error");
	            }
	        }

			function agregarComentario(){
				var comentario = $('form[name=formComent] input[name=comentario]')[0].value;
				var idPost = <?php echo $post->getID(); ?>;
				<?php if(Session::exist()){ ?>
					var idUsuarioGenera = <?php echo Session::getValue('U_ID'); ?>;
				<?php }else{ ?>
					var idUsuarioGenera = "";
				<?php } ?>

				if(comentario!=""){
					$.ajax({
						type: "POST",
						url: "<?php echo URL; ?>GestorReqPrincipal/agregarComentario",
						data: {comentario: comentario, idPost: idPost, idUsuarioGenera: idUsuarioGenera, idUsuarioRecibe: <?php echo $usuario->getIdUsuario(); ?>}
					}).done(function(response){
						location.href = "<?php echo URL; ?>GestorReqPrincipal/mostrarPost/"+idPost;
					});
				}
			}

			function agregarDenuncia(){
				var motivo = $('select[name=motivo]').val();
				var argumento = $('input[name=argumento]').val();
				<?php if(Session::exist()){ ?>
					var idUsuarioDenuncia = <?php echo Session::getValue('U_ID'); ?>;
				<?php }else{ ?>
					var idUsuarioDenuncia = "";
				<?php } ?>

				if(motivo!="Seleccionar" && argumento!=""){
					$.ajax({
						type: "POST",
						url: "<?php echo URL; ?>GestorReqPrincipal/denunciarPost",
						data: {motivo: motivo, argumento: argumento, idPost: <?php echo $post->getID(); ?>, idUsuarioDenuncia: idUsuarioDenuncia, idUsuarioDenunciado: <?php echo $usuario->getIdUsuario(); ?>}
					}).done(function(response){
						// si response es igual a 1 la denuncia fue realizada exitosamente y se recarga la pagina
						if(response==1){
							location.reload();
						}else{
							alert("Ocurrio un error al denunciar el post");
							location.reload();
						}
					});
				}
			}

			function eliminarPost(){
				// Muestra un mensaje de advertencia de que se va a eliminar el post definitivamente
				// Tiene la opción de confirmar la operación o de cancelarla
				// luego lo redirije automaticamente a la página de notificaciones
					$.ajax({
						type: "POST",
						url: "<?php echo URL; ?>GestorReqPrincipal/eliminarPost",
						data: {idPost: <?php echo $post->getID(); ?>}
					}).done(function(response){
						// si response es igual a 1 la eliminacion fue realizada exitosamente y se redirije a la pagina de notificaciones
						console.log(response);
						if(response==1){
							location.href = "<?php echo URL; ?>GestorReqPrincipal/mostrarPanelControl";
						}else{
							alert("Ocurrio un error al dar de baja el post");
							location.reload();
						}
					});
			}

			function desestimarDenuncia(){
				$.ajax({
						type: "POST",
						url: "<?php echo URL; ?>GestorReqPrincipal/eliminarDenuncia",
						data: {idPost: <?php echo $post->getID(); ?>}
					}).done(function(response){
						// si response es igual a 1 la eliminacion fue realizada exitosamente y se redirije a la pagina de notificaciones
						if(response==1){
							location.href = "<?php echo URL; ?>GestorReqPrincipal/mostrarPanelControl";
						}else{
							alert("Ocurrio un error al eliminar la/s denuncia/s");
							location.reload();
						}
					});
			}
		</script>
	</body>
</html>