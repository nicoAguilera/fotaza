<?php

include "cabecera.php";

?>
	<div class="container">
		<div class="row">
			<?php
				# Si existe una sessión y corresponde al usuario que solicito ver el perfil se muestra el menu correspondiente
				if(Session::exist() && Session::getValue('U_ID') === $idUsuario){ ?>
					<!-- Menu secundario de navegación -->
					<div class="">
						<ul class="nav nav-tabs">
							<li role="presentation" class="active"><a href="">Biografía</a></li>
							<li role="presentation"><a href="<?php echo URL; ?>GestorReqPrincipal/mostrarPosts/imagenes/1/<?php echo $idUsuario; ?>">Imagenes</a></li>
							<li role="presentation"><a href="<?php echo URL; ?>GestorReqPrincipal/mostrarPosts/videos/1/<?php echo $idUsuario; ?>">Videos</a></li>
							<li role="presentation"><a href="<?php echo URL; ?>GestorReqPrincipal/mostrarInfoPerfil/<?php echo $idUsuario; ?>">Información</a></li>
						</ul>
					</div>
			<?php }else{
				# Redirijo a la seccion de mostrar posts de imagenes
				$gestorReqPrincipal = new GestorReqPrincipal;
				$gestorReqPrincipal->mostrarPosts('imagenes', 1, $idUsuario);
			?>

			<?php } ?>
			
			
			<!-- Contenido de la biografía del perfil -->
			<div class="main col-xs-12">
				<?php
					# Si existe una sessión y corresponde al usuario que solicito ver el perfil se muestra la opción de agregar un nuevo post
					if(Session::exist()){
						if(Session::getValue('U_ID') === $idUsuario){?>
				<!-- Opción para realizar un nuevo post (Imagen/Video)-->
				<h2 class="">Nuevo Post</h2>

				<!-- Agregar tooltips de bootstrap-->
				<form method="POST" enctype="multipart/form-data" action="<?php echo URL; ?>GestorReqPrincipal/publicarPost" onsubmit="return validar();" class="form-horizontal">
				<div class="col-md-offset-2">
					<!-- Titulo -->
					<div id="titulo" class="form-group row">
						<label class="control-label col-md-3">Título:</label>
						<div class="col-md-5">
							<input class="form-control" id="inputTitulo" type="text" name="titulo" data-toogle="tooltip" title="Introduzca el titulo del post. ¡Obligatorio!" data-placement="right" data-trigger="focus">
						</div>
					</div>

					<!-- Detalle -->
					<div id="detalle" class="form-group row">
						<label class="control-label col-md-3">Detalle:</label>
						<div class="col-md-5">
							<textarea class="form-control detalle" rows="2" cols="50" name="detalle" data-toogle="tooltip" title="Introduzca el detalle del post. ¡Obligatorio!" data-placement="right" data-trigger="focus"></textarea>
						</div>
					</div>


					<!-- Etiquetas -->
					<div id="etiqueta1" class="form-group row">
						<label class="control-label col-md-3">Etiqueta 1:</label>
						<div class="col-md-5">
							<input class="form-control etiqueta" type="text" name="etiqueta1" data-toogle="tooltip" title="Introduzca al menos un etiqueta sobre el contenido del post. ¡Obligatorio!" data-placement="right" data-trigger="focus">
							<!--input class="" type="text" id="etiqueta" name="etiqueta1" -->
						</div>
					</div>

					<div class="form-group row">
						<label class="control-label col-md-3">Etiqueta 2:</label>
						<div class="col-md-5">
							<input class="form-control etiqueta" type="text" name="etiqueta2">
						</div>
					</div>

					<div class="form-group row">
						<label class="control-label col-md-3">Etiqueta 3:</label>
						<div class="col-md-5">
							<input class="form-control etiqueta" type="text" name="etiqueta3">
						</div>
					</div>
					

					<!-- Tipo de visibilidad -->
					<div class="form-group row">
						<label class="control-label col-md-3">Tipo de visibilidad:</label>
						<div class="col-md-5">
							<select class="form-control">
								<option>Público</option>
								<option>Semi-Público</option>
								<option>Colaboradores</option>
								<option>Colaboradores+</option>
								<option>Privado</option>
							</select>
						</div>
					</div>

					<!-- Seleccionar una imagen o un video -->
					<div id="botones" class="form-group row">
						<div class="col-md-offset-3">
							<div class="col-md-6">
								<button class="btn btn-default" id="btnSelImg">Seleccionar Imagen</button>
								<button class="btn btn-default" id="btnSelVideo">Copiar URL de video</button>
							</div>
						</div>
					</div>
				
					<div class="imagen ocultarInput form-group row">
						<!--form method="POST" enctype="multipart/form-data" action="" id="inputImg"-->
							<label class="control-label col-md-3">Seleccionar imagen:</label>
							<div class="col-md-5">
								<input class="form-control" type="file" accept="image/jpeg" name="imagen">
							</div>
							<div class="col-md-2">
	                            <button class="btn btn-danger btnCancelar">Cancelar</button>
	                        </div>
	                        <input type="hidden" name="visibImg" value="0" id="visibImg">
                       	<!--/form-->
					</div>
				
					<div id="url" class="ocultarInput form-group row">
						<label class="control-label col-md-3">Copiar enlace de video:</label>
						<div class="col-md-5">
							<input class="form-control" type="text" name="video">
						</div>
						<div class="col-md-2">
                            <button class="btn btn-danger btnCancelar">Cancelar</button>
                        </div>
                        <input type="hidden" name="idVideo" value="" id="idVideo">
					</div>

					<div class="form-group">
						<input type="hidden" name="idUsuario" value="<?php echo $idUsuario; ?>">
					</div>

					<div class="form-group row">
						<div class="col-md-offset-7">
							<input class="btn btn-primary" id="btnPub" type="submit" name="subir" value="Publicar">
						</div>
					</div>
				</div>
				</form>
				<?php }}?>

			</div>
		</div>
	</div>

	<script src="<?php echo URL; ?>public/js/parse_str.js"></script>
	<script src="<?php echo URL; ?>public/js/parse_url.js"></script>
	<script src="<?php echo URL; ?>public/js/jquery-ui-1.10.4.custom.min.js"></script>

	<script>

		$(function(){

			//$('#inputTitulo').tooltip();
			//$('.detalle').tooltip();
			//$('#etiqueta').tooltip();

            $('#btnSelImg').click(function(){
                $("#botones").hide();
                $('.imagen').fadeToggle();
                $('#visibImg').val(1);
            });

            $("#btnSelVideo").click(function(){
                $("#botones").hide();
                $("#url").fadeToggle();
                $('#visibImg').val(0);
            });

            $(".btnCancelar").click(function(){
                $("#botones").show();
                $(this).parent().parent().hide();
                $('#visibImg').val(0);
            });

            $(".etiqueta").autocomplete({
			   minLength: 2,
			   source: "<?php echo URL; ?>GestorReqPrincipal/buscarCoincidenciasEtiquetas"
			});
                            
        });

		function validar(){

				var ok = true;

				var titulo = $('input[name=titulo]')[0].value;
                var etiqueta1 = $('input[name=etiqueta1]')[0].value;
                var etiqueta2 = $('input[name=etiqueta2]')[0].value;
                var etiqueta3 = $('input[name=etiqueta3]')[0].value;
                var detalle = $('.detalle')[0].value;
                var imagen = $('input[name=imagen]')[0].value;
                var url = $('input[name=video]')[0].value;

                	//Informo de los campos obligatorios que deben ser rellenados

                    if(titulo==""){
                        $('#titulo').addClass("has-error");
                        ok = false;
                    }else{
                    	$('#titulo').removeClass("has-error");
                    }
                    
                    if(etiqueta1=="" && etiqueta2=="" && etiqueta3==""){
                        $('#etiqueta1').addClass("has-error");
                        ok = false;
                    }else{
                    	$('#etiqueta1').removeClass("has-error");
                    }

                    if(detalle==""){
                        $('#detalle').addClass("has-error");
                        ok = false;
                    }else{
                    	$('#detalle').removeClass("has-error");
                    }

                    // Si no selecciono ninguna imagen o video retorno false
                    if(imagen=="" && url==""){
                    	ok = false;
                    }
                    if(imagen==""){
                    	$('.imagen').addClass("has-error");
                    }else{
                    	$('.imagen').removeClass("has-error");
                    }

                    if(url==""){
                        $('#url').addClass("has-error");
                    }else{
                    	//Separo la url
                		tube = parse_url(url);
                		if (tube["path"] == "/watch") {
                			var query = {};
						    parse_str(tube["query"], query);
						    //Obtengo el id del video de Youtube
						    idVideo = query["v"];
						    $('#idVideo').val(idVideo);
						    $('#url').removeClass("has-error");
						}else{
							//mantengo la clase de error y en el tooltip indico que no es un enlace valido
						}
                    }

                    return ok;
            }
	</script>
</body>
</html>