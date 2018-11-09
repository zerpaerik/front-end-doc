@extends('layouts.login')
@section('content')
    <div>        

        <img alt="image" class="" height="120px" width="300px" src="{{ asset('img/FACTURAQ-logo.png')}} " />

        <div class="ibox-content">
            <p><h3>Inicio de sesion</h3></p>
            <form class="m-t" role="form" action="index.html">
                <div class="form-group">
                    <input id="email" type="email" class="form-control" placeholder="Email" required>
                </div>
                <div class="form-group">
                    <input id="password" type="password" class="form-control" placeholder="Password" required>
                </div>
                <button id="logIn" type="button" class="btn btn-primary block full-width m-b">Ingresar</button>
                <a href="#"><small>Olvide mi clave?</small></a>
            </form>
            <p class="m-t"> <small>Desarrollado por <a class="" href="http://www.quantum.ec/" target="_blank">Quantum</a> &copy; 2018</small> </p>
        </div>
    
    </div>

    <script>                

        $("#email").on('keypress', function (e) {
            if (e.keyCode == 13) {
                $("#logIn").click();
            }
        });

        $("#password").on('keypress', function (e) {
            if (e.keyCode == 13) {
                $("#logIn").click();
            }
        });

        $("#logIn").click(
            function(){
                let email       = $("#email").val();                
                let password    = $("#password").val();
                let datos       = {'email' : email, 'password' : password};
                
                if(email && password){
                    $.post( "{{env('APP_URL', NULL)}}/authenticate", datos, function() {                  
                    })
                    .done(function() {                                                                            
                        document.location.href = "/home";                   
                    })
                    .fail(function(data) {                                             
                        swal({
                          type  : 'error',
                          title : 'Error de Acceso',
                          text  : 'Usuario/Contraseña incorrectos',                      
                        }); 
                    });
                }
                else{
                    swal({
                      type  : 'warning',
                      title : 'Campos vacíos',
                      text  : 'Debe llenar los campos de usuario y contraseña',                      
                    });
                }
            }
        );
    </script>
@endsection
