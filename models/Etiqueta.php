<?php

/**
* Clase que alberga la información de las etiquetas
*/
class Etiqueta
{
	private $E_ID;
	private $E_Detalle;

	# arreglo de objetos de tipo publicación que tienen asociada la etiqueta
	private $publicaciones;

	function __construct($E_ID, $E_Detalle)
	{
		$this->E_ID = $E_ID;
		$this->E_Detalle = $E_Detalle;
	}

	# Función para agregar objetos de tipo publicación al arreglo $publicaciones
	public function agregarPublicacion(Publicacion $publicacion)
	{
		$this->publicaciones[] = $publicacion;
	}

	# getter
	public function getId()
	{
		return $this->E_ID;
	}

	public function getDetalle()
	{
		return $this->E_Detalle;
	}

	#setter
	public function setDetalle($detalle)
	{
		$this->E_Detalle = $detalle;
	}
}

?>