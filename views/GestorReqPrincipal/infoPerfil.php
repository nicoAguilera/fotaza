<?php
    # evaluo que efectivamente existe una sesión y la misma coincide con el usuario que quiere modificar la información de perfil
    if(Session::exist() && Session::getValue('U_ID') === $usuario->getIdUsuario()){
	   include "cabecera.php";
?>
	<div class="container">
		<div class="row">
			<!-- Menu secundario superior de navegación -->
			<div class="">
				<ul class="nav nav-tabs">
					<li role="presentation"><a href="<?php echo URL; ?>GestorReqPrincipal/mostrarPerfil/<?php echo $usuario->getIdUsuario(); ?>">Biografía</a></li>
					<li role="presentation"><a href="<?php echo URL; ?>GestorReqPrincipal/mostrarPosts/imagenes/1/<?php echo $usuario->getIdUsuario(); ?>">Imagenes</a></li>
					<li role="presentation"><a href="<?php echo URL; ?>GestorReqPrincipal/mostrarPosts/videos/1/<?php echo $usuario->getIdUsuario(); ?>">Videos</a></li>
					<li role="presentation" class="active"><a href="">Información</a></li>
				</ul>
			</div>

			<!-- Información de perfil y posibilidad de actualizarlo -->
			<div class="main col-xs-12">
                <h2 class="col-xs-12 col-md-12">Información de Perfil</h2>

                        <!-- Cuando hago click en el boton cambiar desaparece el label y aparezca el input con el boton guardar -->
                        <div id="nombre">
                            <label for="nombre" class="col-xs-8 col-md-4">Nombre: <?php echo $usuario->getNombre(); ?></label>
                            <div class="btnCambiar col-xs-4 col-md-7">
                                <button class="btn btn-link" id="btnNombre">Cambiar</button>
                            </div>
                        </div>
                        <div class="ocultarInput nombre">
                            <div class="col-md-8">
                                <input class="form-control" name="nombre" type="text" value="<?php echo $usuario->getNombre(); ?>" placeholder="Nombre"/>
                            </div>
                            <div class="col-md-2">
                                <button id="btnCambiarNbre" class="btn btn-success">Guardar</button>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-danger btnCancelar">Cancelar</button>
                            </div>
                        </div>


                        <div id="apellido">
                            <label for="apellido" class="col-xs-8 col-md-4">Apellido: <?php echo $usuario->getApellido(); ?></label>
                            <div class="btnCambiar col-xs-4 col-md-8">
                                <button class="btn btn-link" id="btnAp">Cambiar</button>
                            </div>
                        </div>
                        <div class="ocultarInput apellido">
                            <div class="col-md-8">
                                <input class="form-control" name="apellido" type="text" value="<?php echo $usuario->getApellido(); ?>" placeholder="Apellido"/>
                            </div>
                            <div class="col-md-2">
                                <button id="btnCambiarAp" class="btn btn-success">Guardar</button>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-danger btnCancelar">Cancelar</button>
                            </div>
                        </div>

                        
                        <div id="domicilio">
                            <label for="domicilio" class="col-xs-8 col-md-4">Domicilio: <?php echo $usuario->getDomicilio(); ?></label>
                            <div class="btnCambiar col-xs-4 col-md-8">
                                <button class="btn btn-link" id="btnDom">Cambiar</a>
                            </div>
                        </div>
                        <div class="ocultarInput domicilio">
                            <div class="col-md-8">
                                <input class="form-control" name="domicilio" type="text" value="<?php echo $usuario->getDomicilio(); ?>" placeholder="Domicilio" />
                            </div>
                            <div class="col-md-2">
                                <button id="btnCambiarDom" class="btn btn-success">Guardar</button>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-danger btnCancelar">Cancelar</button>
                            </div>
                        </div>
                        

                        <div id="pass">
                            <label for="password" class="col-xs-5 col-md-2">Contraseña: </label>
                            <div class="btnCambiar col-xs-7 col-md-7">
                                <button class="btn btn-link" id="btnPass">Cambiar</button>
                            </div>
                        </div>
                        <div class="ocultarInput pass">
                            <div class="col-md-8">
                                <input class="form-control" name="passActual" type="password" placeholder="Contraseña actual" required/>
                            </div>
                            <div class="col-md-8">
                                <input class="form-control" name="passNuevo" type="password" placeholder="Contraseña nueva" required/>
                            </div>
                            <div class="col-md-2">
                                <button id="btnCambiarPass" class="btn btn-success">Guardar</button>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-danger btnCancelar">Cancelar</button>
                            </div>
                        </div>
            </div>
		</div>
	</div>
    <script>
        //$('#nombre').parent().hide();

        $(function(){
            $('#btnNombre').click(function(){
                $("#nombre").hide();
                $('.nombre').fadeToggle();
            });

            $("#btnAp").click(function(){
                $("#apellido").hide();
                $(".apellido").fadeToggle();
            });

            $("#btnDom").click(function(){
                $("#domicilio").hide();
                $(".domicilio").fadeToggle();
            });

            $("#btnPass").click(function(){
                $("#pass").hide();
                $(".pass").fadeToggle();
            });
            

            $("#btnCambiarNbre").click(actualizarNombre);
            $("#btnCambiarAp").click(actualizarApellido);
            $("#btnCambiarDom").click(actualizarDomicilio);
            $("#btnCambiarPass").click(actualizarPass);

            $(".btnCancelar").click(function(){
                location.reload();
            });
        });

        function actualizarNombre(){
            var dato = $('input[name=nombre]')[0].value;
            if(dato!=""){
                $.ajax({
                    type: "POST",
                    url: "<?php echo URL; ?>GestorReqPrincipal/actualizarUsuario",
                    data: {id: <?php echo $usuario->getIdUsuario(); ?>, columna: 'U_Nombre', dato: dato}
                }).done(function(response){
                    location.reload();
                });
            }else{
                //muestro un mensaje de error indicando que no puede ser vacio
            }
        }

        function actualizarApellido(){
            var dato = $('input[name=apellido]')[0].value;
            if(dato!=""){
                $.ajax({
                    type: "POST",
                    url: "<?php echo URL; ?>GestorReqPrincipal/actualizarUsuario",
                    data: {id: <?php echo $usuario->getIdUsuario(); ?>, columna: 'U_Apellido', dato: dato}
                }).done(function(response){
                    location.reload();
                });
            }else{
                //muestro un mensaje de error indicando que no puede ser vacio
            }
        }

        function actualizarDomicilio(){
            var dato = $('input[name=domicilio]')[0].value;

            $.ajax({
                type: "POST",
                url: "<?php echo URL; ?>GestorReqPrincipal/actualizarUsuario",
                data: {id: <?php echo $usuario->getIdUsuario(); ?>, columna: 'U_Domicilio', dato: dato}
            }).done(function(response){
                location.reload();
            });
        }

        function actualizarPass(){
            var passActual = $('input[name=passActual]')[0].value;
            var passNuevo = $('input[name=passNuevo]')[0].value;

            if(passActual!="" && passNuevo!=""){
                $.ajax({
                    type: "POST",
                    url: "<?php echo URL; ?>GestorReqPrincipal/actualizarPass",
                    data: {id: <?php echo $usuario->getIdUsuario(); ?>, passActual: passActual, passNuevo: passNuevo}
                }).done(function(response){
                    location.reload();
                });
            }
            else{
                //Muestro un mensaje de error indicando que no pueden ser vacios
            }
        }
    </script>
</body>
</html>
<?php }else{
    # redirijo a la página de inicio de sesión
    header('Location: '.URL.'GestorReqPrincipal/mostrarLogin');
} ?>