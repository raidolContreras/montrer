
<?php
// Obtener el agente de usuario
$user_agent = $_SERVER['HTTP_USER_AGENT'];

// Verificar si el agente de usuario indica un dispositivo móvil
$is_mobile = (bool) preg_match('/(android|iphone|ipad|ipod|blackberry|mobile|opera mini|windows phone|iemobile)/i', $user_agent);

// Si es un dispositivo móvil, redirigir o mostrar un mensaje
if (!$is_mobile) {
    // Puedes redirigir a otra página o mostrar un mensaje de error
    header("Location: inicio");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <!-- Required meta tags -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no">

    <title>Error - Acceso desde Dispositivo Móvil</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="assets/img/svg/favicon.svg">

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8faff;
            text-align: center;
            padding: 50px;
        }

        h1 {
            color: #333;
        }

        p {
            color: #555;
        }

        img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>

<body>
    <h1>Error - Acceso desde dispositivo móvil</h1>
    <p>Lo sentimos, no se permite el acceso a esta plataforma, por medio de dispositivos móviles.</p>
    <img src="assets\img\logo.png" alt="">
</body>

</html>
