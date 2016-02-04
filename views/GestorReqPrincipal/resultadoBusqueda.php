<?php 

	include "cabecera.php";

 ?>
 	<div class="container">
 		<div class="row main">
 			<div class="col-md-offset-3">
 				<h2>Resultados de la busqueda</h2>
 				
 				<div class="col-md-8">
	 			
	 			<?php if(empty($resultado)){ ?>
	 			<div id="resultados"></div>
	 			<?php }else{ ?>
	 			<div id="resultados">
	 				<?php
	 					foreach ($resultado as $value) {
	 					 	echo '<div class="media well">
	 					 			<div class="media-left">
	 					 				<a href="'.URL.'GestorReqPrincipal/mostrarPost/'. $value["P_ID"] .'">';
	 					 				if($value['P_ID_Video']==NULL){
	 					 					echo '<img class="media-object" src="'.URL.'publicaciones/'.$value["P_ID"].'.jpg" alt="..." width="120">';
	 					 				}else{
	 					 					echo '<img src="http://img.youtube.com/vi/'.$value["P_ID_Video"].'/default.jpg" class="media-object" alt="" />';
	 					 				}
									      
									echo '</a>
	 					 			</div>
							        <div class="media-body">
								        <h3 class="media-heading">Post: 
							        		<a href="'.URL.'GestorReqPrincipal/mostrarPost/'. $value["P_ID"] .'">' .
							        			$value["P_Titulo"] .
							        		'</a>
							        	</h3>
							        	<label>Autor:</label>
							        	<a href="'.URL.'GestorReqPrincipal/mostrarPerfil/'.$value["U_ID"].'">'.
							        		$value["U_Nombre"] .' '. $value["U_Apellido"] .'
							        	</a>
							        </div>
							    </div>';
	 					} 
	 				?>
	 			</div>
	 			<?php } ?>
	 			
	 			</div>
 			</div>
 		</div>	
 	</div>
</body>
</html>