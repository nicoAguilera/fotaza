<?php 

	/**
	* Clase que gestiona el ciclo de vida de los objetos de la clase Notificacion
	*/
	class GestorNotificacion extends ORM
	{
		protected static $table = "notificacion";
		private $notificacion;
		
		function __construct()
		{
			# code...
		}

		public function crearNotificacion($tipo, $idUsuarioRecibe, $idUsuarioGenera, $idPost)
		{
			self::getConnection();

			date_default_timezone_set('America/Argentina/San_Luis');

			$values = array('N_ID'=>NULL, 'N_Fecha'=>date("Y-m-d H:i:s"), 'N_Tipo'=>$tipo, 'N_Visto'=>0, 'U_ID_Recibe'=>$idUsuarioRecibe, 'U_ID_Genera'=>$idUsuarioGenera, 'P_ID_Sobre'=>$idPost);
			return self::$db->insert(static::$table,$values);

			self::cerrarConexion();
		}

		public function obtenerNotificaciones($idUsuario)
		{
			self::getConnection();

			$sql = "SELECT * FROM ".static::$table." WHERE U_ID_Recibe = :U_ID_Recibe ORDER BY N_Fecha DESC";
			$data = self::$db->select($sql, array(':U_ID_Recibe'=>$idUsuario) );

			self::cerrarConexion();

			foreach ($data as $value) {
				$this->notificacion[] = new Notificacion($value['N_ID'], $value['N_Fecha'], $value['N_Tipo'], $value['N_Visto'], $value['U_ID_Recibe'], $value['U_ID_Genera'], $value['P_ID_Sobre']);
			}
		}

		public function eliminarNotificacion($idPost)
		{
			self::getConnection();

			$data = self::$db->delete(static::$table, 'P_ID_Sobre ='.$idPost. ' AND (N_Tipo="denuncia" OR N_Tipo="notificacionAdmin")', 10);

			self::cerrarConexion();
		}

		// averigua si existe una notificacion de denuncias acumuladas sobre el post al administrador
		public function obtenerNotAdmin($idPost)
		{
			self::getConnection();

			$sql = "SELECT * FROM ".static::$table." WHERE N_Tipo = :N_Tipo AND P_ID_Sobre = :P_ID_Sobre";
			$data = self::$db->select($sql, array(':N_Tipo'=>'notificacionAdmin', ':P_ID_Sobre'=>$idPost) );

			self::cerrarConexion();
			$resultado = array_shift($data);
			//var_dump($resultado);
			if($resultado!=""){
				return TRUE;
			}
			else{
				return FALSE;
			}
		}

		public function getNotificacion()
		{
			return $this->notificacion;
		}
	}

 ?>