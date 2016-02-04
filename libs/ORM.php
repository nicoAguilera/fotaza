<?php

require "Database.php";

class ORM{

	# modique la visibilidad de la variable $db de privada a publica
	public static $db;
	protected static $table;

	public function getDB(){
		return self::$db;
	}

	# modifique esta funcion de privada a publica para poder usarla en otras clases
	public static function getConnection(){
		self::$db = new Database(DB_TYPE,DB_HOST,DB_NAME,DB_USER,DB_PASS);
	}

	public static function cerrarConexion()
	{
		self::$db = null;
	}

	# Realiza una busqueda por un determinado campo ($field) y el valor correspondiente ($value)
	# En el minuto 18.15 de ORM basico se muestra como realizar una consulta compleja VER!!!
	public static function where($field, $value){
		self::getConnection();

		$sql = "SELECT * FROM ".static::$table." WHERE ".$field." = :".$field;
		$results = self::$db->select($sql, array(":".$field=>$value) );

		return $results;
		self::cerrarConexion();
	}

	# Devuelve todas las filas de la tabla
	public static function getAll(){
		self::getConnection();
		$sql = "SELECT * FROM ".static::$table.";";
		return $result = self::$db->select($sql,array());
		self::cerrarConexion();
	}

	# Actualiza una fila de una tabla
	public static function save(){
            
        self::getConnection();
                
		$values = get_object_vars($this);

		$has_many = self::checkRelationship("has_many",$values);

		$result = self::$db->update(static::$table,$values,"id = ".$values["id"]);

		if($result){
			$result = array('error'=>0,'message'=>'Objeto Actualizado');
		}else{
			$result = array('error'=>1,'message'=> self::$db->getError());
		}

		if($has_many){ 
			$rStatus = self::saveRelationships($has_many); 
			if($rStatus["error"]){
				Logger::alert("Error saving relationships",$rStatus["trace"],"save");
			}
		}
		Logger::debug("result",$result,"save");

		return $result;
	}

	# Crea una nueva fila en una tabla
	public function create(){
            
        self::getConnection();
		
		$values = get_object_vars($this);

		$has_many = self::checkRelationship("has_many",$values);
                
                //Logger::debug("db",self::$db);
		$result = self::$db->insert(static::$table,$values);

		if($result){
			$result = array('error'=>0,'getID'=> self::$db->getInsertedId(),'message'=>'Objeto Creado');
			$this->id = $result["getID"];
		}else{
			$result = array('error'=>1,'getID'=> null,'message'=> self::$db->getError());
		}

		if($has_many){ 
			$rStatus = self::saveRelationships($has_many); 
			if($rStatus["error"]){
				Logger::alert("Error saving relationships",$rStatus["trace"],"create");
			}
		}
		//Logger::debug("result",$result,"create");

		return $result;
	}
}

?>