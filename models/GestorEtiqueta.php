<?php

/**
* Clase que gestiona el ciclo de vida de los objetos de la clase Etiqueta
*/
class GestorEtiqueta extends ORM
{
	protected static $table = "etiqueta";
	private $etiquetas;

	function __construct()
	{
		# code...
	}

	public function crearEtiqueta($detalle, $idPost)
	{
		self::getConnection();

		$values = array("E_ID"=>NULL, "E_Detalle"=>$detalle);
		$resultado = self::$db->insert(static::$table, $values);

		if($resultado!=0){
			# si la etiqueta se inserto con exito en la tabla creo la relacion entre la etiqueta y el post
			$values = array("P_ID_Tiene"=>$idPost, "E_ID_Tiene"=>self::$db->getInsertedId());
			$resultado = self::$db->insert('tiene', $values);
		}

		self::cerrarConexion();
	}

	# obtiene todas las etiquetas asociadas a una publicación
	public function obtenerEtiquetas($idPublicacion)
	{
		/**
		* Busca en la tabla Tiene de la bd el id de todas las etiquetas que estan asociadas con el id de la publicacion y
		* luego recupera dichas etiquetas de la bd de la tabla Etiqueta creando instancias de la clase para las mismas
		*
		 Usar inner join para hacer una consulta entre la tabla Tiene y la tabla Etiqueta!!!!!! 
		*/
		self::getConnection();

		$sql = "SELECT * FROM tiene T inner join etiqueta E ON T.E_ID_Tiene = E.E_ID WHERE P_ID_Tiene = :P_ID_Tiene;";
		$result = self::$db->select($sql, array(":P_ID_Tiene"=>$idPublicacion));

		foreach ($result as $value) {
			$this->etiquetas[] = new Etiqueta($value['E_ID'], $value['E_Detalle']);
		}

		self::cerrarConexion();
	}

	# Busca coincidencias con las etiquetas almacenadas en la bd
	public function buscarEtiqueta($clave)
	{
		self::getConnection();

		$sql = "SELECT * FROM ".static::$table." WHERE E_Detalle LIKE '%".$clave."%';";
		$result = self::$db->select($sql);

		return $result;

		self::cerrarConexion();
	}

	# Realaciona una etiqueta existente con un post creado
	public function relacionarEtiqueta($idEtiqueta, $idPost)
	{
		self::getConnection();

		$values = array("P_ID_Tiene"=>$idPost, "E_ID_Tiene"=>$idEtiqueta);
		$resultado = self::$db->insert('tiene', $values);

		self::cerrarConexion();
	}

	# get
	public function getEtiquetas()
	{
		return $this->etiquetas;
	}
}

?>