<?php

/**
* Comentarios sobre las publicaciones
*/
class Comentario
{
	# atributo necesario para identificar un comentario para eliminarlo
	private $Co_ID;

	private $Co_Detalle;
	private $Co_FechaCreacion;

	# por la navegación de la relación "Contiene" la clase Comentario no conoce objetos de la clase publicación
	//private $Pu_ID_Contiene;
	private $U_ID_Realiza;
	
	function __construct($Co_ID, $Co_Detalle, $Co_FechaCreacion, $U_ID_Realiza)
	{
		$this->Co_ID = $Co_ID;
		$this->Co_Detalle = $Co_Detalle;
		$this->Co_FechaCreacion = $Co_FechaCreacion;
		$this->U_ID_Realiza = $U_ID_Realiza;
	}

	#getter
	public function getID()
	{
		return $this->Co_ID;
	}

	public function getDetalle()
	{
		return $this->Co_Detalle;
	}

	public function getFecha()
	{
		return $this->Co_FechaCreacion;
	}

	public function getIdPublicacion()
	{
		return $this->Pu_ID_Sobre;
	}

	public function getIdUsuario()
	{
		return $this->U_ID_Realiza;
	}

	#setter
	public function setDetalle($detalle)
	{
		$this->Co_Detalle = $detalle;
	}

	public function setFecha($fecha)
	{
		$this->Co_FechaCreacion = $fecha;
	}

	public function setIdPublicacion($idPublicacion)
	{
		$this->Pu_ID_Sobre = $idPublicacion;
	}

	public function setIdUsuario($idUsuario)
	{
		$this->U_ID_Realiza = $idUsuario;
	}
}

?>