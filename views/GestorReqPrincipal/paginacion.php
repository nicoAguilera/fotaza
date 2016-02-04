<?php
	//var_dump($totalPaginas);
	if($totalPaginas > 1){
		if($numPagina != 1){
			if(empty($idUsuario)){
				echo '<li><a href="'.URL.'GestorReqPrincipal/mostrarPosts/'.$pagina.'/'.($numPagina - 1).'">&laquo;</a></li>';
			}else{
				echo '<li><a href="'.URL.'GestorReqPrincipal/mostrarPosts/'.$pagina.'/'.($numPagina - 1).'/'.$idUsuario.'">&laquo;</a></li>';
			}
		}
		for($i=1; $i<=$totalPaginas; $i++){
			if($numPagina == $i){
				echo '<li class="active"><a href="">'.$i.'</a></li>';
			}else{
				if(empty($idUsuario)){
					echo '<li><a href="'.URL.'GestorReqPrincipal/mostrarPosts/'.$pagina.'/'.($i).'">'.$i.'</a></li>';
				}else{
					echo '<li><a href="'.URL.'GestorReqPrincipal/mostrarPosts/'.$pagina.'/'.($i).'/'.$idUsuario.'">'.$i.'</a></li>';
				}
			}
		}
		if($numPagina!=$totalPaginas){
			if(empty($idUsuario)){
				echo '<li><a href="'.URL.'GestorReqPrincipal/mostrarPosts/'.$pagina.'/'.($numPagina + 1).'">&raquo;</a></li>';
			}else{
				echo '<li><a href="'.URL.'GestorReqPrincipal/mostrarPosts/'.$pagina.'/'.($numPagina + 1).'/'.$idUsuario.'">&raquo;</a></li>';
			}
		}
	}
 ?>