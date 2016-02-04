<?php

/**
* Clase que gestiona las publicaciones
*/
class GestionarPost
{
	
	function __construct()
	{
		# code...
	}

	# función para subir una imagen a la aplicacion y publicarla
	public function subirImagen($titulo, $detalle, $etiqueta1, $etiqueta2, $etiqueta3, $tipo, $nombre, $nombreTempImg, $idUsuario)
	{
		# en primer lugar comprueba que sea una imagen jpeg
		if($tipo == "image/jpeg"){
			$gestorPost = new GestorPost;	
			$idPost = $gestorPost->crearPostImagen($titulo, $detalle, $nombre, $nombreTempImg, $idUsuario);

			if($idPost!=NULL){
				$gestorEtiqueta = new GestorEtiqueta;
				if($etiqueta1!=""){
					$resultado = $gestorEtiqueta->buscarEtiqueta($etiqueta1);
					if(!empty($resultado)){
						$gestorEtiqueta->relacionarEtiqueta($resultado[0]['E_ID'], $idPost);
					}else{
						$gestorEtiqueta->crearEtiqueta($etiqueta1, $idPost);
					}
				}
				if($etiqueta2!=""){
					$resultado2 = $gestorEtiqueta->buscarEtiqueta($etiqueta2);
					if(!empty($resultado2)){
						$gestorEtiqueta->relacionarEtiqueta($resultado2[0]['E_ID'], $idPost);
					}else{
						$gestorEtiqueta->crearEtiqueta($etiqueta2, $idPost);
					}
				}
				if($etiqueta3!=""){
					$resultado3 = $gestorEtiqueta->buscarEtiqueta($etiqueta3);
					if(!empty($resultado3)){
						$gestorEtiqueta->relacionarEtiqueta($resultado3[0]['E_ID'], $idPost);
					}else{
						$gestorEtiqueta->crearEtiqueta($etiqueta3, $idPost);
					}
				}

				return $idPost;
			}else{
				# ERROR! no se guardo la imagen
				return 0;
			}
		}else{
			# ERROR! no es una imagen
			return 0;
		}
	}

	/*
	* Verifico que la url suministrada pertenece a un video valido de youtube
	* Creo un nuevo post de video
	* Creo las etiquetas correspondientes
	*/
	public function subirVideo($titulo, $detalle, $etiqueta1, $etiqueta2, $etiqueta3, $idVideo, $idUsuario)
	{

		    $gestorPost = new GestorPost;	
			$idPost = $gestorPost->crearPostVideo($titulo, $detalle, $idVideo, $idUsuario);
			
			if($idPost!=""){
				$gestorEtiqueta = new GestorEtiqueta;
				if($etiqueta1!=""){
					$resultado = $gestorEtiqueta->buscarEtiqueta($etiqueta1);
					if(!empty($resultado)){
						$gestorEtiqueta->relacionarEtiqueta($resultado[0]['E_ID'], $idPost);
					}else{
						$gestorEtiqueta->crearEtiqueta($etiqueta1, $idPost);
					}
				}
				if($etiqueta2!=""){
					$resultado2 = $gestorEtiqueta->buscarEtiqueta($etiqueta2);
					if(!empty($resultado2)){
						$gestorEtiqueta->relacionarEtiqueta($resultado2[0]['E_ID'], $idPost);
					}else{
						$gestorEtiqueta->crearEtiqueta($etiqueta2, $idPost);
					}
				}
				if($etiqueta3!=""){
					$resultado3 = $gestorEtiqueta->buscarEtiqueta($etiqueta3);
					if(!empty($resultado3)){
						$gestorEtiqueta->relacionarEtiqueta($resultado3[0]['E_ID'], $idPost);
					}else{
						$gestorEtiqueta->crearEtiqueta($etiqueta3, $idPost);
					}
				}
				return $idPost;
			}else{
				# ERROR! no se guardo el enlace al video
				return 0;
			}	
	}

	/*
		* recupero la cantidad de posts y los 24 posts más recientes de la bd a partir del limite inferior
		* que se pasa como parametro determinado por la paginación
		*
		* recupero las etiquetas y los comentarios(si los hubiera) asociados a cada post y 
		* los agrego al arreglo de etiquetas y comentarios en el objeto post correspondiente
		*
		*/
	public function listarPosts($limite, $idUsuario, $tipo)
	{
		$gestorPost = new GestorPost;
		$gestorEtiqueta = new GestorEtiqueta;
		$gestorComentario = new GestorComentario;

		$gestorPost->obtenerPosts($limite, $idUsuario, $tipo);
		$posts = $gestorPost->getPosts();
		/**
			Optimizar esta consulta buscando las etiquetas y los comentarios solo cuando es necesario
		* Por ejemplo para mostrar los thumnails de videos o imagenes no es necesario saber los comentarios y etiquetas
		*/
		if($posts!=NULL){
			foreach ($posts as $idPost => $post) {
				$gestorEtiqueta->obtenerEtiquetas($idPost);
				$posts[$idPost]->setEtiquetas($gestorEtiqueta->getEtiquetas());

				$gestorComentario->obtenerComentarios($idPost);
				$posts[$idPost]->setComentarios($gestorComentario->getComentarios());
			}
		}

		return $posts;
	}


	# determina la cantidad de páginas de acuerdo a la cantidad de post para realizar la paginación y la retorna
	public function cantidadPaginas($idUsuario, $tipoPost)
	{
		$gestorPost = new GestorPost;
		$cantPosts = $gestorPost->cantidadPosts($idUsuario, $tipoPost);
		return $totalPaginas = ceil($cantPosts / PAGINACION);
	}

	# recupero un post en particular para mostrarlo en detalle
	public function obtenerPost($idPost)
	{
		$gestorPost = new GestorPost;
		$gestorPost->obtenerPost($idPost);

		# Compruebo si el post se encuentra activo
		if($gestorPost->getPost()->getVisibilidad() == 1){
			$gestorEtiqueta = new GestorEtiqueta;
			$gestorComentario = new GestorComentario;

			$gestorEtiqueta->obtenerEtiquetas($idPost);
			$gestorPost->getPost()->setEtiquetas($gestorEtiqueta->getEtiquetas());

			$gestorComentario->obtenerComentarios($idPost);
			$gestorPost->getPost()->setComentarios($gestorComentario->getComentarios());

			return $gestorPost->getPost();
		}else{
			return FALSE;
		}
	}

	public function denunciarPost($motivo, $argumento, $idPost, $idUsuarioDenuncia, $idUsuarioDenunciado)
	{
		/*
		* Se llama al GestorDenuncia para almacenar la denuncia en la bd
		*
		* Al realizar la denuncia se debe notificar al denunciado
		*
		* Posteriormente se revisa si hay por lo menos 3 denuncias acumuladas para notificar al administrador
		*
		* Por último se retorna a la vista desde la cual se realizo la denuncia informando que la misma se realizo con exito
		*/
		$gestorDenuncia = new GestorDenuncia;
		$resultado = $gestorDenuncia->crearDenuncia($motivo, $argumento, $idUsuarioDenuncia, $idPost);

		$gestorNotificacion = new GestorNotificacion;

		if($resultado == 1){
			// Si la denuncia se realizo correctamente se crea un objeto de tipo notificacion con el usuario afectado
			$result = $gestorNotificacion->crearNotificacion("denuncia", $idUsuarioDenunciado, $idUsuarioDenuncia, $idPost);

			// Recupero de la bd las denuncias realizadas sobre el post y si superan las 3 se notifica al administrador
			$gestorDenuncia->obtenerDenuncias($idPost);
			$denuncias = $gestorDenuncia->getDenuncia();
			$motivoDenunciaActual = 0;
			foreach ($denuncias as $denuncia) {
				/* 
				* Recorro el arreglo de denuncias buscando todas las denuncias con el motivo utilizado en la denuncia actual
				*/
				if($denuncia->getMotivo() === $motivo){
					$motivoDenunciaActual++;
				}
			}

			/*
			* Me fijo si el administrador ya fue notificado sobre kas denuncias sobre este post
			* en dicho caso le informo de la acumulacion de nuevas denuncias
			* caso contrario le informo por primera vez que llego al limite de denuncias permitidas
			*/
			if( $gestorNotificacion->obtenerNotAdmin($idPost) ){
				// Cambio el estado de visto a no de la notificacion para indicar que tiene nuevas denuncias

			}else{
				if(count($denuncias)>= 5 || $motivoDenunciaActual>=3){
					$result = $gestorNotificacion->crearNotificacion("notificacionAdmin", 1, NULL, $idPost);
				}
			}

			// devuelvo un 1 para informar que la denuncia se realizo correctamente
			echo 1;
		}else{
			// devuelvo un 0 para infomar que la denuncia NO se realizo
			echo 0;
		}
	}

	public function guardarComentario($comentario, $idPost, $idUsuarioRecibe, $idUsuarioGenera)
	{
		$gestorComentario = new GestorComentario;
		$result = $gestorComentario->crearComentario($comentario, $idPost, $idUsuarioGenera);
		// Si el comentario se guardo correctamente y el comentario no pertenence al autor del post se notifica al creador
		if($result==1 && $idUsuarioRecibe!=$idUsuarioGenera){
			$gestorNotificacion = new GestorNotificacion;
			$gestorNotificacion->crearNotificacion('comentario', $idUsuarioRecibe, $idUsuarioGenera, $idPost);
		}
	}

	public function eliminarComentario($idComentario)
	{
		$gestorComentario = new GestorComentario;
		$gestorComentario->delete($idComentario);
	}

	public function obtenerNotificaciones($idUsuario)
	{
		$gestorNotificacion = new GestorNotificacion;
		$gestorNotificacion->obtenerNotificaciones($idUsuario);
		return $gestorNotificacion->getNotificacion();
	}
	/**
	en el video 4 empieza a explicar como buscar por ajax
	*/

	public function buscarDenuncia($idUsuario, $idPost)
	{
		$gestorDenuncia = new GestorDenuncia;
		return $gestorDenuncia->buscarDenuncia($idUsuario, $idPost);
	}

	public function obtenerDenuncias($idPost)
	{
		$gestorDenuncia = new GestorDenuncia;
		$gestorDenuncia->obtenerDenuncias($idPost);
		return $gestorDenuncia->getDenuncia();
	}

	public function obtenerDenuncia($idUsuario, $idPost)
	{
		$gestorDenuncia = new GestorDenuncia;
		$gestorDenuncia->obtenerDenuncia($idUsuario, $idPost);
		return $gestorDenuncia->getDenuncia();
	}

	public function darDeBaja($idPost)
	{
		/**
		Tengo que realizar esto en una transaccion corroborando que tanto el post, las notificaciones y las denuncias se eliminaron correctamente
		*/
		# Primero le doy una baja logica al post
		$gestorPost = new GestorPost;
		$gestorPost->ocultarPost($idPost);

		# Luego elimino las notificaciones de denuncia correspondiente al post
		$gestorNotificacion = new GestorNotificacion;
		$gestorNotificacion->eliminarNotificacion($idPost);

		#Por ultimo elimino las denuncias realizadas
		$gestorDenuncia = new GestorDenuncia;
		$gestorDenuncia->eliminarDenuncia($idPost);

		echo 1;
	}

	/* puedo usar la funcion actualizar post
	public function ocultarPost($idPost)
	{
		$gestorPost = new GestorPost;
		$gestorPost->ocultarPost($idPost);
	}*/

	public function desestimarDenuncia($idPost)
	{
		/**
		Tengo que realizar esto en una transaccion corroborando que tanto las notificaciones como las denuncias se eliminaron correctamente
		*/
		# Elimino las notificaciones sobre el post
		$gestorNotificacion = new GestorNotificacion;
		$gestorNotificacion->eliminarNotificacion($idPost);

		# Elimino las denuncias realizadas
		$gestorDenuncia = new GestorDenuncia;
		$gestorDenuncia->eliminarDenuncia($idPost);

		/*if($result1==1 && $result2==1){
			commit()*/
			echo 1;
		/*}else{
			rollback()
			echo 0;
		}*/
	}

	public function buscarCoincidenciaEtiqueta($clave)
	{
		$gestorEtiqueta = new GestorEtiqueta;
		$coincidencias = $gestorEtiqueta->buscarEtiqueta($clave);

		$arrayElementos = array();
		foreach ($coincidencias as $value) {
			$arrayElementos[] = new ElementoAutocompletar($value['E_Detalle'], $value['E_Detalle']);
		}

		return $arrayElementos;
	}

	public function actualizarPost($idPost, $columna, $dato)
	{
		$gestorPost = new GestorPost;
		$gestorPost->actualizarPost($idPost, $columna, $dato);
	}
}

?>