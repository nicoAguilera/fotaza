<?php

    include "cabecera.php"; 

?>
<div class="container">
	<div class="row">
		<h1>Posts más recientes</h1>
	<?php
	# listo las publicaciones de todos los usuarios
		echo '<ul class="productos col-md-12">';
		//var_dump($publicaciones);
		foreach ($publicaciones as $publicacion) {
			echo '<li class="col-xs-12 col-sm-4 col-md-3 col-lg-2">
					<a href="'.URL.'GestorReqPrincipal/mostrarPost/'.$publicacion->getID().'" class="thumbnail">
					<div class="producto">
					<figure class="row">
                        <div class="imagen col-xs-4 col-sm-3 col-md-10 galeria">';
                        if($publicacion->getIdVideo()==NULL){
                        	# Es un post de imagen
                        	echo '<div class="sombra"><img src="'.URL.'publicaciones/'.$publicacion->getID().'.jpg" class="img-responsive" /></div>';
                        }else{
                        	# Es un post de video
                        	echo '<img src="http://img.youtube.com/vi/'.$publicacion->getIdVideo().'/default.jpg" class="img-responsive" alt="" />
				            <div style="position: absolute; left: 28%; top: 15%;"  >
				            	<img src="'.URL.'public/botonVideo.png" width="30%"alt="" />
				            </div>';
                        }
                        
                   echo '</div>
                                    
                        <figcaption class="col-xs-3 col-sm-5 col-md-10 galeria">
                            <h3>'.$publicacion->getTitulo().'</h3>
                        </figcaption>
                    </figure>
                    </div>
                    </a>
                </li>';	
		}
		echo '</ul>';
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
<script type="text/javascript">
	$(document).ready(function(){
		$(".pagination").parent().css("text-align", "center");
	});
</script>
</body>
</html>