<?php 

/**
* Clase que almacena la información correspondiente a las notificaciones
*/
class Notificacion
{
	private $N_ID;
	private $N_Fecha;
	private $N_Tipo;
	private $N_Visto;

	private $U_ID_Genera;
	private $U_ID_Recibe;
	private $P_ID_Sobre;
	
	function __construct($N_ID, $N_Fecha, $N_Tipo, $N_Visto, $U_ID_Recibe, $U_ID_Genera, $P_ID_Sobre)
	{
		$this->N_ID = $N_ID;
		$this->N_Fecha = $N_Fecha;
		$this->N_Tipo = $N_Tipo;
		$this->N_Visto = $N_Visto;
		$this->U_ID_Recibe = $U_ID_Recibe;
		$this->U_ID_Genera = $U_ID_Genera;
		$this->P_ID_Sobre = $P_ID_Sobre;
	}

	public function getFecha()
	{
		return $this->N_Fecha;
	}

	public function getTipo()
	{
		return $this->N_Tipo;
	}

	public function getIdUsuarioGenera()
	{
		return $this->U_ID_Genera;
	}

	public function getIdUsuarioRecibe()
	{
		return $this->U_ID_Recibe;
	}

	public function getIdPost()
	{
		return $this->P_ID_Sobre;
	}
}

?>