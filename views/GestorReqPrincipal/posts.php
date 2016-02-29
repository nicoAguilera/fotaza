<?php

    include "cabecera.php"; 

?>
<div class="container">
	<div class="row">
		<h1>Posts más recientes</h1>

		<ul class="posts col-md-12"></ul>
	<!-- Cambio el script en php por un script en javascript invocando mediante una peticion get el metodo posts -->
	<script type="text/javascript">
		$(document).ready(function(){
			$(".pagination").parent().css("text-align", "center");
			$.ajax({
				type: 'GET',
				url: "GestorReqPrincipal/posts/<?php echo $inicio; ?>",
				success: function(response){

					listaPosts = JSON.parse(response);
					var resultado = "";

					for(var i in listaPosts){
						resultado += '<li class="col-xs-12 col-sm-4 col-md-3 col-lg-2">'+
										'<a href="GestorReqPrincipal/mostrarPost/'+ listaPosts[i]['P_ID'] +'" class="thumbnail">'+
										'<div class="producto">'+
										'<figure class="row">'+
					                        '<div class="imagen col-xs-4 col-sm-3 col-md-10 galeria">';
					                        if(listaPosts[i]['P_ID_Video'] == null){
					                        	// Es un post de imagen
					                        	resultado += '<div class="sombra"><img src="publicaciones/'+ listaPosts[i]['P_ID'] +'.jpg" class="img-responsive" /></div>';
					                        }else{
					                        	// Es un post de video
					                        	resultado += '<img src="http://img.youtube.com/vi/'+ listaPosts[i]['P_ID_Video'] +'/default.jpg" class="img-responsive" alt="" />'+
									            '<div style="position: absolute; left: 28%; top: 15%;"  >'+
									            	'<img src="public/botonVideo.png" width="30%"alt="" />'+
									            '</div>';
					                        }
					                        
					                   resultado += '</div>'+
					                                    
					                        '<figcaption class="col-xs-3 col-sm-5 col-md-10 galeria">'+
					                            '<h3>'+ listaPosts[i]['P_Titulo'] +'</h3>'+
					                        '</figcaption>'+
					                    '</figure>'+
					                    '</div>'+
					                    '</a>'+
					                '</li>';
					}
					 $('.posts').html(resultado);
				}
			});
		});
	</script>
		<nav>
			<ul class="pagination">
				<?php
					include "paginacion.php";
				 ?>
			</ul>
		</nav>
		
	</div>
</div>
</body>
</html>