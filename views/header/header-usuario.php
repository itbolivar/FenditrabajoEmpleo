<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?php echo constant('URL'); ?>public/css/fenditrabajo.css">
    <link rel="icon" href="<?php echo constant('URL'); ?>public/images/favicon.png" sizes="32x32">
</head>

<body>
    <header id="header" class="main-header">
        <div class="logito">
            <a href="#"><img src="<?php echo constant('URL'); ?>public/logos/logo.png" width="60%"></a>
        </div>

        <nav class="navbar navbar-expand-lg navbar-light text-dark ">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse text-center justify-content-center" id="navbarSupportedContent">
                <ul class="nav navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link link-m" href="<?php echo constant('URL'); ?>inicioPersona">
                            <ion-icon name="person-sharp"></ion-icon> PERFIL
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link link-m" href="<?php echo constant('URL'); ?>hojaVidaUsuario">
                            <ion-icon name="reader-sharp"></ion-icon> HOJA DE VIDA
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link link-m" href="<?php echo constant('URL'); ?>aplicacionOferta">
                            <ion-icon name="file-tray-full-sharp"></ion-icon> APLICACIONES
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link link-m" href="<?php echo constant('URL'); ?>loginPersona/cerrarSesion">
                            <ion-icon name="exit-sharp"></ion-icon> CERRAR SESIÓN
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <script src="https://kit.fontawesome.com/11638189dd.js" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"> </script>
</body>

</html>