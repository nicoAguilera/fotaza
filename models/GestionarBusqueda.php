<?php 

/**
* Clase que gestiona el motor de busqueda de la aplicación
* puede buscar por nombre de autor, titulo de post y etiquetas
*/
class GestionarBusqueda extends ORM
{
	
	function __construct()
	{
		# code...
	}

	public function buscar($clave = FALSE){
		//sleep(1);
		self::getConnection();

		// join entre multitablas
		// JOin entre las tablas
		// parametros requeridos en la busqueda
		$sql = 'SELECT DISTINCT U_ID, U_Nombre, U_Apellido, P_ID, P_Titulo, P_ID_Video'
				. ' FROM usuario U inner join post P inner join tiene T inner join etiqueta E'
				. ' ON U.U_ID = P.U_ID_Publica AND T.P_ID_Tiene = P.P_ID AND T.E_ID_Tiene = E.E_ID'
				. ' WHERE U.U_Activo = 1 AND P.P_Visibilidad = 1 AND '
				. '(U.U_Nombre LIKE "%'.$clave.'%" OR U.U_Apellido LIKE "%'.$clave.'%" OR '
				. 'P.P_Titulo LIKE "%'.$clave.'%" OR E.E_Detalle LIKE "%'.$clave.'%")'; 
		# invoco al metodo select de database
		$result = self::$db->select($sql);

		return $result;

		self::cerrarConexion();
		/*if($num == 1){
			$sth = $this->objCon->prepare('SELECT * FROM books WHERE titleB LIKE "%'..'%" '
				. 'OR autorB LIKE "%'.$word.'%" OR descr LIKE "%'.$word.'%"');
			$sth->execute();
			return $sth->fetchAll();
		}else{
			$sth = $this->objCon->prepare('SELECT *, MATCH (titleB, autorB, descr)'
				. 'AGAINST (:words) FROM books WHERE MATCH (titleB, autorB, descr)'
				. 'AGAINST(:words)');
			$sth->execute(array(':words' => , $word) );
			return $sth->fetchAll();
		}*/
	}
}

 ?>