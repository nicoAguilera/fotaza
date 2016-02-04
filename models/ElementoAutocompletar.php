<?php 

/**
* Clase que genera los elementos que va a contener el arreglo con las coincidencias encontradas
*/
class ElementoAutocompletar
{
	//propiedades de los elementos
   	var $value;
   	var $label;


	//constructor que recibe los datos para inicializar los elementos
	function __construct($label, $value)
	{
		$this->label = $label;
      	$this->value = $value;
	}
}

 ?>