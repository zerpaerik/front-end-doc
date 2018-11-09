<!DOCTYPE html>
<html>
    <head>
        <title>Acceso no Autorizado</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" rel="stylesheet" type="text/css" href="">
        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                color: #B0BEC5;
                display: table;
                font-weight: 100;
                font-family: 'Lato', sans-serif;
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 72px;
                margin-bottom: 40px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">
                    <center>
                        <div style="font-weight: bold">401</div>                        
                        <div style="font-size: 60px">Privilegios insuficientes para acceder a éste recurso.</div>
                    </center>
                </div>
                <center><a href="{{ url('/home') }}" class="btn btn-info" style="color: white; font-weight: bold">Inicio</a></center>
            </div>
        </div>
    </body>
</html>
