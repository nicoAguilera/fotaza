<?php

/**
* Clase que gestiona el ciclo de vida de los objetos de tipo Usuario
*/

class GestorUsuario extends ORM
{
	protected static $table = "usuario";
	private $usuario;
	
	function __construct()
	{
		# code...
	}

	/*
	* Funcion para crear un nuevo usuario en el proceso de registro.
	* La operación se realiza en una transaccion para evitar incosistencias.
	*/
	public function crearNuevoUsuario($nombre, $apellido, $domicilio, $email, $password){
		self::getConnection();
		self::$db->beginTransaction();
		$values = array("U_ID"=>null, "U_Email"=>$email, "U_Password"=>$password, "U_Nombre"=> $nombre, "U_Apellido"=>$apellido, "U_Domicilio"=>$domicilio, "U_Activo"=>1);
		$result2 = self::$db->insert(static::$table,$values);
		if($result2!=0){
			$idUsuario = self::$db->getInsertedId();
			self::$db->commit();
			# si el usuario fue creado con exito, lo recupero de la base de datos
			$this->obtenerUsuario($idUsuario);
		}else{
			self::$db->rollBack();	
		}
		self::cerrarConexion();
	}

	public function obtenerUsuario($U_ID)
	{
        $data = self::where("U_ID", $U_ID);
        $this->usuario = new Usuario($data[0]["U_ID"], $data[0]["U_Email"], $data[0]["U_Password"], $data[0]["U_Nombre"], $data[0]["U_Apellido"], $data[0]["U_Domicilio"], $data[0]["U_Activo"]);
	}

	public function obtenerUsuarioPorEmail($U_Email)
	{
		$data = self::where("U_Email", $U_Email);
        $this->usuario = new Usuario($data[0]["U_ID"], $data[0]["U_Email"], $data[0]["U_Password"], $data[0]["U_Nombre"], $data[0]["U_Apellido"], $data[0]["U_Domicilio"], $data[0]["U_Activo"]);
	}

	public function actualizarUsuario($id, $columna, $dato)
	{
		self::getConnection();

		$values = array($columna=>$dato);
		$result = self::$db->update(static::$table,$values,"U_ID = ".$id);

		self::cerrarConexion();
	}

	public function getUsuario(){
		return $this->usuario;
	}
}

?>