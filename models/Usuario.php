<?php

/**
* Clase que alberga los usuarios del sistema
*/
class Usuario
{
	private $U_ID;
	private $U_Email;
	private $U_Password;
	private $U_Nombre;
	private $U_Apellido;
	private $U_Domicilio;
	private $U_Activo;

	function __construct($U_ID, $U_Email, $U_Password, $U_Nombre, $U_Apellido, $U_Domicilio = "", $U_Activo = 1)
	{
		$this->U_ID = $U_ID;
		$this->U_Email = $U_Email;
		$this->U_Password = $U_Password;
		$this->U_Nombre = $U_Nombre;
		$this->U_Apellido = $U_Apellido;
		$this->U_Domicilio = $U_Domicilio;
		$this->U_Activo = $U_Activo;
	}

	# getter
	public function getIdUsuario()
	{
		return $this->U_ID;
	}

	public function getEmail()
	{
		return $this->U_Email;
	}

	public function getPassword()
	{
		return $this->U_Password;
	}

	public function getNombre()
	{
		return $this->U_Nombre;
	}

	public function getApellido()
	{
		return $this->U_Apellido;
	}

	public function getNombreCompleto()
	{
		return $this->U_Nombre." ".$this->U_Apellido;
	}

	public function getDomicilio()
	{
		return $this->U_Domicilio;
	}

	public function getEstadoCuenta()
	{
		return $this->U_Activo;
	}

	# setter
}

?>