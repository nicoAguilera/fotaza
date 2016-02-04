function eliminarCuenta(){
	$.ajax({
		type: "POST",
		url: "<?php echo URL; ?>GestorReqPrincipal/eliminarUsuario",
		data: {idUsuario: <?php echo $idUsuario; ?>}
	}).done(function(response){
		// si response es igual a 1 la eliminacion fue realizada exitosamente y se redirije a la pagina de notificaciones
		if(response==1){
			location.href = "<?php echo URL; ?>GestorReqPrincipal/mostrarPanelControl";
		}else{
			alert("Ocurrio un error al dar de baja la cuenta");
			location.reload();
		}
	});
}