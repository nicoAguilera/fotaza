<?php
    include "cabecera.php"; 
?>
            
            <div class="container">
                <form id="signInForm" action="" name="signIn" method="" class="form-inline col-md-offset-4">
                    <div id="emailSigIn" class="form-group">
                        <label for="email" class="control-label">Correo electrónico:</label>
                        <div>
                            <input id="email" class="form-control" name="email" type="text"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password" class="control-label">Contraseña:</label>
                        <div>
                            <input id="password" class="form-control" name="password" type="password"/>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label></label>
                        <div>
                            <input class="btn btn-primary" id="signInBtn" name="signInBtn" type="submit" value="Iniciar sesión"/>
                        </div>
                    </div>

                    <!--div class="form-group">
                        <a class="btn btn-link" href="">¿Olvidaste tu contraseña?</a>
                    </div-->
                </form>
            </div>
            <br><br>
            
            <div class="container">
                <form id="signUpForm" action="" name="signUp" method="post" class="form-horizontal">
                    <div class="form-group">
                        <label for="sigUpBtn" class="control-label col-md-7">¿No estás registrado?</label>
                    </div>

                    <div id="nombreSigUp" class="form-group">
                        <label for="nombre" class="control-label col-md-5">Nombre: *</label>
                        <div class="col-md-4">
                            <input class="form-control" name="nombre" type="text" placeholder="Nombre" required/>
                        </div>
                    </div>

                    <div id="apellidoSigUp" class="form-group">
                        <label for="apellido" class="control-label col-md-5">Apellido: *</label>
                        <div class="col-md-4">
                            <input class="form-control" name="apellido" type="text" placeholder="Apellido" required/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="domicilio" class="control-label col-md-5">Domicilio:</label>
                        <div class="col-md-4">
                            <input class="form-control" name="domicilio" type="text" placeholder="Domicilio"/>
                        </div>
                    </div>

                    <div id="emailSigUp" class="form-group">
                        <label for="email" class="control-label col-md-5">Dirección de correo electrónico: *</label>
                        <div class="col-md-4">
                            <input class="form-control" name="email" type="email" placeholder="pepito@perez.com" required/>
                        </div>
                    </div>

                    <div id="passwordSigUp" class="form-group">
                        <label for="password" class="control-label col-md-5">Contraseña: *</label>
                        <div class="col-md-4">
                            <input class="form-control" name="password" type="password" placeholder="Contraseña" required/>
                        </div>
                    </div>

                    <div class="form-group help-block">
                        <p class="col-md-offset-5">Los campos marcados con * son obligatorios</p>
                    </div>

                    <div class="form-group">
                        <div class="checkbox col-md-4 col-md-offset-5">
                            <label>
                                <input type="checkbox">Tenerme en cuenta como administrador
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-4 col-md-offset-5">
                            <input class="btn-lg btn-success" id="signUpBtn" name="signUpBtn" type="submit" value="Registrarte" required/>
                        </div>
                    </div>

                </form>
            </div>
        
        <script>
            $(function(){
                            
                $('#signUpBtn').click(function(e){
                     e.preventDefault();
                     signUp();
                 });
                            
                $('#signInBtn').click(function(e){
                    e.preventDefault();
                    signIn();
                });
            });
            
            //expresion regular para verificar que es una dirección de email valida
            var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;

            function signUp(){
                
                var nombre = $('form[name=signUp] input[name=nombre]')[0].value;
                var apellido = $('form[name=signUp] input[name=apellido]')[0].value;
                var domicilio = $('form[name=signUp] input[name=domicilio]')[0].value;
                var email = $('form[name=signUp] input[name=email]')[0].value;
                var password = $('form[name=signUp] input[name=password]')[0].value;
                
                if (nombre!="" && apellido!="" && regex.test(email) && password!="") {
                    $.ajax({
                        type: "POST",
                        url: "<?php echo URL; ?>GestorReqPrincipal/registrarNuevoUsuario",
                        data: {nombre: nombre, apellido: apellido, domicilio: domicilio, email: email, password: password}
                    }).done(function(response){
                        if(response != 0){
                            location.href = "<?php echo URL; ?>GestorReqPrincipal/mostrarPerfil/"+response;
                        }else{
                            $('#emailSigUp').addClass("has-error");
                            $('#emailSigUp').children('label').text("¡Correo Electrónico Duplicado!");
                        }
                    });
                }else{
                    if(nombre==""){
                        $('#nombreSigUp').addClass("has-error");
                    }
                    if(apellido==""){
                        $('#apellidoSigUp').addClass("has-error");
                    }
                    if(!regex.test(email)){
                        $('#emailSigUp').addClass("has-error");
                    }
                    if(password==""){
                        $('#passwordSigUp').addClass("has-error");
                    }
                }
            }
            
            function signIn(){

                var email = $('form[name=signIn] input[name=email]')[0].value;
                var password = $('form[name=signIn] input[name=password]')[0].value;
             
                //Se utiliza la funcion test() nativa de JavaScript
                if (regex.test(email)) {
                    $.ajax({
                        type: "POST",
                        url: "<?php echo URL; ?>GestorReqPrincipal/validarDatosUsuario",
                        data: {email: email, password: password}
                    }).done(function(response){
                        if(response == 1){
                            location.href = "<?php echo URL; ?>GestorReqPrincipal/mostrarPosts/posts/1";
                        }
                        else if(response == 2){
                            location.href = "<?php echo URL; ?>GestorReqPrincipal/mostrarPanelControl";
                        }
                        else if(response == 3){
                            alert("Su cuenta fue dada de baja");
                        }
                        else{
                            alert("Usuario o Password Incorrectos");
                        }
                    });
                }
                else {
                    $('#emailSigIn').addClass("has-error");
                    $('#emailSigIn').children('label').text("¡Correo Invalido!");
                }
            }
            
        </script>
    </body>
</html>