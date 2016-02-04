<?php 

/**
* Clase que gestiona el ciclo de vida de los objetos de la clase Denuncia
*/
class GestorDenuncia extends ORM
{
	protected static $table = "denuncia";
	private $denuncia;
	
	function __construct()
	{
		# code...
	}

	public function crearDenuncia($motivo, $argumento, $idUsuario, $idPost)
	{
		self::getConnection();

		$values = array('D_ID'=>NULL, 'D_Motivo'=>$motivo, 'D_Argumento'=>$argumento, 'U_ID_Hace'=>$idUsuario, 'P_ID_EnEl'=>$idPost);
		return self::$db->insert(static::$table,$values);

		self::cerrarConexion();
	}

	public function obtenerDenuncias($idPost)
	{
		$denuncia = self::where('P_ID_EnEl',$idPost);

		foreach ($denuncia as $value) {
			$this->denuncia[] = new Denuncia($value['D_ID'], $value['D_Motivo'], $value['D_Argumento'], $value['U_ID_Hace'], $value['P_ID_EnEl']);
		}

	}

	public function buscarDenuncia($idUsuario, $idPost)
	{
		self::getConnection();

		$sql = "SELECT * FROM ".static::$table." WHERE U_ID_Hace = :U_ID_Hace AND P_ID_EnEl = :P_ID_EnEl";
		$results = self::$db->select($sql, array(":U_ID_Hace"=>$idUsuario, ":P_ID_EnEl"=>$idPost) );

		if($results!= NULL){
			return 1;
		}else{
			return 0;
		}

		self::cerrarConexion();
	}

	# obtiene los datos de la denuncia para mostrarlos en la notificación de la misma
	public function obtenerDenuncia($idUsuarioHace, $idPost)
	{
		self::getConnection();

		$sql = "SELECT * FROM ".static::$table." WHERE U_ID_Hace = :U_ID_Hace AND P_ID_EnEl = :P_ID_EnEl";
		$value = self::$db->select($sql, array(":U_ID_Hace"=>$idUsuarioHace, ":P_ID_EnEl"=>$idPost) );

		$this->denuncia = new Denuncia($value[0]['D_ID'], $value[0]['D_Motivo'], $value[0]['D_Argumento'], $value[0]['U_ID_Hace'], $value[0]['P_ID_EnEl']);

		self::cerrarConexion();
	}

	public function eliminarDenuncia($idPost)
	{
		self::getConnection();

		$results = self::$db->delete(static::$table, 'P_ID_EnEl='.$idPost, 10);

		self::cerrarConexion();
	}

	# get
	public function getDenuncia()
	{
		return $this->denuncia;
	}
}

 ?>