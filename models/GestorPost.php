<?php
//include "GestorEtiqueta.php";
require '../../libs/ORM.php';
//require 'Post.php';

/**
* Clase que gestiona el ciclo de vida de la publicaciones (Imagenes y videos)
*/
class GestorPost extends ORM
{
	protected static $table = "post";

	/**
	Usar una unica variable definiendola como array en el caso de posts
	*/
	private $post;
	private $posts;
	
	function __construct()
	{
		# code...
	}

	public function crearPostImagen($titulo, $detalle, $nombre, $nombreTempImg, $idUsuario)
	{
		self::getConnection();

		# creo una arreglo asociativo con los campos y valores de la fila a insertar en la tabla publicaciones
		$values = array("P_ID"=>NULL, "P_Titulo"=>$titulo, "P_Detalle"=>$detalle, "P_Fecha"=>date("Y-m-d H:i:s"), "P_Visibilidad"=>1, "P_ID_Video"=>NULL, "U_ID_Publica"=>$idUsuario);
		$resultado = self::$db->insert(static::$table, $values);

		if($resultado!=0){

			# recupero el id generado para el post y se lo doy a la imagen que se va a copiar al servidor
			$idPost = self::$db->getInsertedId();
			$nombreImg = $idPost.".jpg";

			# copio el archivo al directorio destinado para guardar las publicaciones
			$destino =  DIR_PUB.$nombreImg;
			if (move_uploaded_file($nombreTempImg, $destino)) {
				$status = 1;
			} else {
				$status = 0;
			}

			return $idPost;
		}else{
			return NULL;
		}

		self::cerrarConexion();
	}

	public function crearPostVideo($titulo, $detalle, $idVideo, $idUsuario)
	{
		self::getConnection();

		$values = array("P_ID"=>NULL, "P_Titulo"=>$titulo, "P_Detalle"=>$detalle, "P_Fecha"=>date("Y-m-d H:i:s"), "P_Visibilidad"=>1, "P_ID_Video"=>$idVideo, "U_ID_Publica"=>$idUsuario);
		$resultado = self::$db->insert(static::$table, $values);
		if($resultado!=0){
			$idPost = self::$db->getInsertedId();
			return $idPost;	
		}else{
			return "";
		}

		self::cerrarConexion();
	}

	/*
	* Función que calcula la cantidad de post existentes y la retorna para determinar la cantidad de paginas para mostrarlos
	*/
	public function cantidadPosts($idUsuario, $tipoPost)
	{
		self::getConnection();

		if($idUsuario!=NULL && $tipoPost!=NULL){
			if($tipoPost == 'imagenes'){
				$sql = "SELECT COUNT(P_ID) FROM ".static::$table." WHERE P_Visibilidad=1 AND U_ID_Publica=:U_ID_Publica AND  P_ID_Video is NULL;";
			}else{
				$sql = "SELECT COUNT(P_ID) FROM ".static::$table." WHERE P_Visibilidad=1 AND U_ID_Publica=:U_ID_Publica AND  P_ID_Video IS NOT NULL;";
			}
			$cantPosts = self::$db->select($sql, array(':U_ID_Publica'=>$idUsuario));
		}else{
			$sql = "SELECT COUNT(P_ID) FROM ".static::$table." WHERE P_Visibilidad=1;";
			$cantPosts = self::$db->select($sql);
		}
		
		return $cantPosts[0]["COUNT(P_ID)"];

		self::cerrarConexion();
	}

	public function obtenerPosts($limite, $idUsuario, $tipo)
	{
		/*
		* recupero los 12 posts más recientes determinados por el limite inferior que corresponde a la paginación 
		* creo instancias para cada uno almacenandolos en el arreglo $posts
		* en el caso de recibir como parametro el id del usuario y el tipo (video o imagen) de posts
		* recupero segun ese criterio de la bd
		*/
		self::getConnection();

		if($idUsuario!=NULL && $tipo=="videos"){
			$sql = "SELECT * FROM ".static::$table." WHERE U_ID_Publica = :U_ID_Publica AND P_ID_Video IS NOT NULL AND P_Visibilidad=1 ORDER BY P_Fecha DESC LIMIT ".$limite.",".PAGINACION.";";
			$posts = self::$db->select($sql, array(":U_ID_Publica"=>$idUsuario) );
		}elseif($idUsuario!=NULL && $tipo=="imagenes"){
			$sql = "SELECT * FROM ".static::$table." WHERE U_ID_Publica = :U_ID_Publica AND P_ID_Video IS NULL AND P_Visibilidad=1 ORDER BY P_Fecha DESC LIMIT ".$limite.",".PAGINACION.";";
			$posts = self::$db->select($sql, array(":U_ID_Publica"=>$idUsuario) );
		}elseif($limite == NULL && $tipo == NULL && $idUsuario!=NULL){
			$sql = "SELECT * FROM ".static::$table." WHERE U_ID_Publica = :U_ID_Publica AND P_Visibilidad=1;";
			$posts = self::$db->select($sql, array(':U_ID_Publica' => $idUsuario) );
		}else{
			$sql = "SELECT * FROM ".static::$table." WHERE P_Visibilidad=1 ORDER BY P_Fecha DESC LIMIT ".$limite.",".PAGINACION.";";
			$posts = self::$db->select($sql);
		}

		self::cerrarConexion();
		
		foreach ($posts as $pub) {
			$this->posts[$pub['P_ID']] = new Post($pub['P_ID'], $pub['P_Titulo'], $pub['P_Detalle'], $pub['P_Fecha'], $pub['P_Visibilidad'], $pub['P_ID_Video'], $pub['U_ID_Publica']);
		}
	}

	public function obtenerPost($P_ID)
	{
		$pub = self::where("P_ID", $P_ID);
		$this->post = new Post($pub[0]['P_ID'], $pub[0]['P_Titulo'], $pub[0]['P_Detalle'], $pub[0]['P_Fecha'], $pub[0]['P_Visibilidad'], $pub[0]['P_ID_Video'], $pub[0]['U_ID_Publica']);
	}

	# modifica algun campo de la tabla post
	public function actualizarPost($idPost, $columna, $dato)
	{
		self::getConnection();

		$values = array($columna => $dato);
		$result = self::$db->update(static::$table, $values,"P_ID = ".$idPost);

		self::cerrarConexion();
	}

	# getter
	public function getPosts()
	{
		return $this->posts;
	}

	public function getPost()
	{
		return $this->post;
	}
}

?>