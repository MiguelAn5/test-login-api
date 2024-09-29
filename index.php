<?php
// index.php

// Incluir archivo de configuración
include('config.php');

// Variable para almacenar el botón de inicio de sesión
$login_button = '';

// Verificar si se ha recibido un código de autorización en la URL
if (isset($_GET["code"])) {
    // Intentar obtener el token de acceso usando el código de autorización
    $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);

    // Verificar si no hubo un error al obtener el token
    if (!isset($token['error'])) {
        // Establecer el token de acceso para la API de Google
        $google_client->setAccessToken($token['access_token']);

        // Almacenar el token de acceso en la sesión
        $_SESSION['access_token'] = $token['access_token'];

        // Crear un objeto del servicio Google Oauth2
        $google_service = new Google_Service_Oauth2($google_client);

        // Obtener la información del usuario
        $data = $google_service->userinfo->get();

        // Almacenar la información obtenida en la sesión
        if (!empty($data['given_name'])) {
            $_SESSION['user_first_name'] = $data['given_name'];
        }

        if (!empty($data['family_name'])) {
            $_SESSION['user_last_name'] = $data['family_name'];
        }

        if (!empty($data['email'])) {
            $_SESSION['user_email_address'] = $data['email'];
        }

        if (!empty($data['gender'])) {
            $_SESSION['user_gender'] = $data['gender'];
        }

        if (!empty($data['picture'])) {
            $_SESSION['user_image'] = $data['picture'];
        }
    }
}

// Si el token de acceso no está establecido en la sesión, mostrar el botón de inicio de sesión
if (!isset($_SESSION['access_token'])) {
    $login_button = '<a href="' . $google_client->createAuthUrl() . '" class="btn btn-danger btn-lg btn-block"><i class="fab fa-google"></i> Iniciar sesión con Google</a>';
}
?>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>PHP Login usando Cuenta de Google</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }

        .card {
            margin-top: 50px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card img {
            border-radius: 50%;
            margin-bottom: 20px;
        }

        .welcome {
            text-align: center;
            padding: 20px;
        }

        .login-btn {
            display: flex;
            justify-content: center;
            margin-top: 30px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2 class="text-center">PHP Login usando Cuenta de Google</h2>
                        <hr>
                        <?php
                        if ($login_button == '') {
                            echo '<div class="welcome">';
                            echo '<img src="' . $_SESSION["user_image"] . '" class="img-fluid rounded-circle" width="120" />';
                            echo '<h3>Bienvenido, ' . $_SESSION['user_first_name'] . ' ' . $_SESSION['user_last_name'] . '</h3>';
                            echo '<p><b>Email:</b> ' . $_SESSION['user_email_address'] . '</p>';
                            echo '<a href="logout.php" class="btn btn-danger">Cerrar sesión</a>';
                            echo '</div>';
                        } else {
                            echo '<div class="login-btn">' . $login_button . '</div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>