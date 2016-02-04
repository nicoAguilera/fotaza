<?php

/**
* Gestiona el inicio de sesion de los usuarios registrados y el registro de nuevos usuarios
*/
class GestionarSesion
{
	
	function __construct()
	{
		# code...
	}

	/*
	* Valida el inicio de sesión de un usuario comparando el password ingreso con el que se encuentra almacenado en la base de datos.
	* Si es correcto se crea una sesión.
	*/
	public function validarSesion($email, $password)
	{
		$gestorUsuario = new GestorUsuario;
		$gestorUsuario->obtenerUsuarioPorEmail($email);

		if($gestorUsuario->getUsuario()->getEstadoCuenta() == 1 ){
			if($gestorUsuario->getUsuario()->getPassword() === $password){
				$this->createSession($gestorUsuario->getUsuario()->getEmail(), $gestorUsuario->getUsuario()->getIdUsuario(), $gestorUsuario->getUsuario()->getNombreCompleto());
				
				# compruebo si es el administrador para redireccionarlo al panel de control de la aplicacion
				if($gestorUsuario->getUsuario()->getEmail() === "admin@fotaza.com"){
					echo 2;
				}else{
					# si es un usuario comun
					echo 1;
				}
			}else{
				# si el password ingresado es incorrecto
				echo 0;
			}
		}else{
			// Si la cuenta fue dada de baja se le notifica al usuario
			echo 3;
		}
	}

	/*
	* Registra un nuevo usuario en el sistema controlando que ningun campo se encuentre vacio y que el email sea valido.
	* Si el proceso es exitoso se crea una sesión.
	*/
	public function nuevoUsuario($nombre, $apellido, $domicilio="", $email, $password)
	{
		# compruebo que los campos son correctos
		if($nombre!="" && $apellido!="" && $email!="" && $password!="" && filter_var($email, FILTER_VALIDATE_EMAIL)){
			$gestorUsuario = new GestorUsuario;
			$gestorUsuario->crearNuevoUsuario($nombre, $apellido, $domicilio, $email, $password);
			if($gestorUsuario->getUsuario() != null){
				$this->createSession($gestorUsuario->getUsuario()->getEmail(), $gestorUsuario->getUsuario()->getIdUsuario(), $gestorUsuario->getUsuario()->getNombreCompleto());
				echo $gestorUsuario->getUsuario()->getIdUsuario();
			}
			else{
				echo 0;
			}
		}else{
			echo 0;
		}
	}

	/*
	* Recupera los datos de un usuario
	*/
	public function obtenerUsuario($idUsuario)
	{
		$gestorUsuario = new GestorUsuario;
		$gestorUsuario->obtenerUsuario($idUsuario);
		return $gestorUsuario->getUsuario();
	}

	/* Actualiza un determinado campo de un usuario */
	public function actualizarUsuario($id, $columna, $dato)
	{
		$gestorUsuario = new GestorUsuario;
		$gestorUsuario->actualizarUsuario($id, $columna, $dato);
		if($columna==="U_NOMBRE" || $columna==="U_Apellido"){
			$gestorUsuario->obtenerUsuario($id);
			Session::setValue('U_NOMBRE', $gestorUsuario->getUsuario()->getNombreCompleto());
		}
	}

	/* 
	* Actualiza la contraseña 
	* Recupera el usuario de la bd
	* Verifica que la contraseñana actual ingresada corresponde con la que se encuentra guardada
	* Actualiza la contraseña llamando a la funcion actualizarUsuario
	*/
	public function actualizarPass($id, $passActual, $passNuevo)
	{
		$gestorUsuario = new GestorUsuario;
		$gestorUsuario->obtenerUsuario($id);
		if($gestorUsuario->getUsuario()->getPassword() === $passActual){
			$gestorUsuario->actualizarUsuario($id, 'U_Password', $passNuevo);
			# retorno un 1 para informar que la contraseña se actualizo correctamente
			//echo 1;	
		}else{
			# retorno un o para informar que la contraseña no se actualizo correctamente
			//echo 0;
		}
		
	}

	public function ocultarUsuario($idUsuario)
	{
		$gestorUsuario = new GestorUsuario;
		$gestorUsuario->actualizarUsuario($idUsuario, 'U_Activo', 0);
	}

	/*
	* Crea una sesión con las variables correspondientes
	*/
	public function createSession($email, $id, $nombreCompleto){
        Session::setValue('U_EMAIL', $email);
        Session::setValue('U_ID', $id);
        Session::setValue('U_NOMBRE', $nombreCompleto);
    }
     
    // Destruye una sesión   
    public function destroySession(){
        Session::destroy();
        header('location:'.URL.'GestorReqPrincipal/mostrarLogin');
    }
}

?>