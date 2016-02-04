<?php

class Database extends PDO{

	public function __construct($DB_TYPE,$DB_HOST,$DB_NAME,$DB_USER,$DB_PASS){
		parent::__construct($DB_TYPE.':host='.$DB_HOST.'; dbname='.$DB_NAME, $DB_USER, $DB_PASS);
	}

	/**
		Select
	*
	*	@param String $sql | Sentencia SQL
	*	@param array $array | Parametros para vincular
	*	@param constant $fetchMode | un Fetch Mode PDO
	*
	*	@return mixed
	*/
	public function select($sql, $array = array(), $fetchMode = PDO::FETCH_ASSOC){

		$sth = $this->prepare($sql);

		$sth->execute($array);

		return $sth->fetchAll($fetchMode);
	}

	/**
		Insert
	*	@param String $table | Tabla en donde se insertarán los datos
	*	@param String $data | Arreglo asociativo con los datos a insertar
	*	
	*	@return Boolean $sth->exceute | Resultado de la consulta
	*/
	public function insert($table,$data){
		# el metodo ksort ordena alfabeticamente el arreglo $data
		ksort($data);

		$fieldNames = implode('`,`',array_keys($data));
		$fieldValues = ':'.implode(', :', array_keys($data));

		//Logger::debug("fieldNames",$fieldNames);
		//Logger::debug("fieldValues",$fieldValues);

		$sth = $this->prepare("INSERT INTO $table (`$fieldNames`) VALUES ($fieldValues)");

		foreach ($data as $key => $value) {
			$sth->bindValue(":$key",$value);
		}

		return $sth->execute();
	}

	/**
		Update
	*	@param String $table | Tabla en donde se actualizarán los datos
	*	@param String $data | Arreglo asociativo con los datos a actualizar
	*	@param String $where | La parte de la sentencia WHERE
	*	
	*	@return Boolean $sth->exceute | Resultado de la consulta
	*/
	public function update($table, $data, $where){

		ksort($data);

		$fieldDetails = null;
		foreach ($data as $key => $value) {
			$fieldDetails .= "$key=:$key,";
		}

		$fieldDetails = rtrim($fieldDetails,',');
		//Logger::debug("fieldDetails",$fieldDetails,"update");

		$sth = $this->prepare("UPDATE $table SET $fieldDetails WHERE $where");

		foreach ($data as $key => $value) {
			$sth->bindValue(":$key",$value);
		}
		//Logger::debug("sth",$sth,"update");
		return $sth->execute();
	}

	/**
		Delete
	*	
	*	@param String $table | Tabla en donde se eliminaran los datos
	*	@param String $where | La parte de la sentencia WHERE
	*	@param int $limit | Limite
	*	
	*	@return Boolean $this->exc | Resultado de la consulta
	*/
	public function delete($table,$where,$limit = 1){
		return $this->exec("DELETE FROM $table WHERE $where LIMIT $limit");
	}

	public function getInsertedId(){
		return self::lastInsertId();
	}

	public function getError(){
		return self::errorInfo();
	}
}

?>