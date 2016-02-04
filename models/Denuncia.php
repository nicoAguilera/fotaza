<?php 

/**
* 
*/
class Denuncia
{
	private $D_ID;
	private $D_Motivo;
	private $D_Argumento;

	private $U_ID_Hace;
	private $P_ID_EnEl;

	function __construct($id, $motivo, $argumento, $idUsuario, $idPost)
	{
		$this->D_ID = $id;
		$this->D_Motivo = $motivo;
		$this->D_Argumento = $argumento;
		$this->U_ID_Hace = $idUsuario;
		$this->P_ID_EnEl = $idPost;
	}

	# getter
	public function getMotivo()
	{
		return $this->D_Motivo;
	}

	public function getArgumento()
	{
		return $this->D_Argumento;
	}

	public function getIdUsuarioDenuncia()
	{
		return $this->U_ID_Hace;
	}
}

 ?>