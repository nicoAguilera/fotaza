<?php

/**
* Clase que gestiona el ciclo de vida de los objetos de tipo Comentario
*/
class GestorComentario extends ORM
{
	protected static $table = "comentario";
	private $comentarios;
	
	function __construct()
	{
		# code...
	}

	public function obtenerComentarios($idPost)
	{
		$data = self::where("P_ID_Contiene", $idPost);
		
		foreach ($data as $value) {
			$this->comentarios[] = new Comentario($value['Co_ID'], $value['Co_Detalle'], $value['Co_FechaCreacion'], $value['U_ID_Realiza']);
		}
	}

	public function crearComentario($detalle, $idPost, $idUsuario)
	{
		self::getConnection();

		date_default_timezone_set('America/Argentina/San_Luis');

		$values = array('Co_ID'=>NULL, 'Co_Detalle'=>$detalle, 'Co_FechaCreacion'=>date("Y-m-d H:i:s"), 'P_ID_Contiene'=>$idPost, 'U_ID_Realiza'=>$idUsuario);
		return self::$db->insert(static::$table,$values);

		self::cerrarConexion();
	}

	public function delete($idComentario)
	{
		self::getConnection();

		$where = 'Co_ID='.$idComentario;
		$result = self::$db->delete(static::$table, $where);

		self::cerrarConexion();
	}

	public function getComentarios()
	{
		return $this->comentarios;
	}
}

?>