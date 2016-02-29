<?php

/**
* Clase que alberga la información de las publicaciones
*/
class Post
{
	/*
	* Cambie la visibilidad de los atributos de privado a publico para poder convertir los objetos a formato JSON aunque esto
	* viola el concepto de POO. Esta es una solución provisoria.
	*/
	public $P_ID;
	public $P_Titulo;
	public $P_Detalle; 
	public $P_Fecha;
	public $P_Visibilidad;
	public $P_ID_Video;

	# arreglo de comentarios asociados a la publicación determinado por la relación "Sobre"
	private $comentarios;

	# id del usuario que realiza la publicación determinado por la relación "Publica"
	private $U_ID_Publica;

	# arreglo de etiquetas asociadas a la publicación determinado por la relación "Tiene" (minimo 1, maximo 3)
	private $etiquetas;

	/*
	* Los campos 'P_ID', 'P_Fecha', 'P_Nombre' y 'U_ID_Publica' son obligatorios
	* El campo 'etiquetas' es obligatorio y debe contener al menos una y como maximo 3, en dicho caso es un arreglo asociativo con E_ID=>E_Nombre
	* El campo 'comentarios' es opcional (una publicación puede no tener comentarios)
	*/
	function __construct($P_ID, $P_Titulo, $P_Detalle, $P_Fecha, $P_Visibilidad, $P_ID_Video, $U_ID_Publica)
	{
		$this->P_ID = $P_ID;
		$this->P_Titulo = $P_Titulo;
		$this->P_Detalle = $P_Detalle;
		$this->P_Fecha = $P_Fecha;
		$this->P_Visibilidad = $P_Visibilidad;
		$this->P_ID_Video = $P_ID_Video;

		$this->U_ID_Publica = $U_ID_Publica;
	}

	# getter
	public function getID()
	{
		return $this->P_ID;
	}

	public function getTitulo()
	{
		return $this->P_Titulo;
	}

	public function getDetalle()
	{
		return $this->P_Detalle;
	}

	public function getFecha()
	{
		return $this->P_Fecha;
	}

	public function getVisibilidad()
	{
		return $this->P_Visibilidad;
	}

	public function getIdVideo()
	{
		return $this->P_ID_Video;
	}

	public function getIdUsuario()
	{
		return $this->U_ID_Publica;
	}

	public function getEtiquetas()
	{
		return $this->etiquetas;
	}

	public function getComentarios()
	{
		return $this->comentarios;
	}

	#setter
	public function setComentarios($comentarios)
	{
		$this->comentarios = $comentarios;
	}

	public function setEtiquetas($etiquetas)
	{
		$this->etiquetas = $etiquetas;
	}
}

?>