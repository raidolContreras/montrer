<?php
// test-mail.php

// 1. Autoload de Composer
require __DIR__ . '/controller/vendor/autoload.php';

// 2. Usos de las clases de PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// 3. (Opcional) Carga de variables de entorno con Dotenv
//    Si no usas .env, salta este paso y reemplaza las variables manualmente.
if (file_exists(__DIR__ . '/.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
}

// 4. Inicializamos algunas variables para el formulario
$mensajeExito = '';
$mensajeError = '';

// 5. Si se envía el formulario, procesamos la petición
if (isset($_POST['enviar_correo'])) {
    // Recibimos los datos del formulario
    $destinatario = $_POST['destinatario'] ?? '';
    $asunto       = $_POST['asunto'] ?? 'Correo de Prueba';
    $contenido    = $_POST['contenido'] ?? 'Este es un correo de prueba.';

    // Instanciamos PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Configuración SMTP
        $mail->isSMTP();
        $mail->Host       = $_ENV['HOST_MAIL'] ?? 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = $_ENV['USER_MAIL'] ?? 'tu-correo@gmail.com';
        $mail->Password   = $_ENV['PASS_MAIL'] ?? 'password';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = $_ENV['PORT_MAIL'] ?? 587;

        // Configuración del correo
        $mail->setFrom($mail->Username, 'Nombre Remitente');
        $mail->addAddress($destinatario);

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = $asunto;
        $mail->Body    = nl2br(htmlspecialchars($contenido));

        // Enviar correo
        $mail->send();
        $mensajeExito = "¡Correo enviado exitosamente a $destinatario!";
    } catch (Exception $e) {
        $mensajeError = "Error al enviar el correo: {$mail->ErrorInfo}";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Test Mail - PHPMailer</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 2rem; }
        .container { max-width: 600px; margin: 0 auto; }
        .success { color: green; }
        .error { color: red; }
        label { display: block; margin-top: 1rem; }
        input[type="text"], textarea {
            width: 100%;
            padding: 0.5rem;
            box-sizing: border-box;
        }
        button {
            margin-top: 1rem;
            padding: 0.5rem 1rem;
            cursor: pointer;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Enviar Correo de Prueba</h1>
    
    <!-- Mensajes de resultado -->
    <?php if ($mensajeExito): ?>
        <p class="success"><?= $mensajeExito ?></p>
    <?php endif; ?>
    <?php if ($mensajeError): ?>
        <p class="error"><?= $mensajeError ?></p>
    <?php endif; ?>

    <form method="POST" action="test-mail.php">
        <label for="destinatario">Correo destinatario:</label>
        <input type="text" name="destinatario" id="destinatario" placeholder="ejemplo@dominio.com" required>

        <label for="asunto">Asunto:</label>
        <input type="text" name="asunto" id="asunto" placeholder="Asunto del correo" value="Correo de prueba">

        <label for="contenido">Contenido:</label>
        <textarea name="contenido" id="contenido" rows="6">Este es un correo de prueba.</textarea>

        <button type="submit" name="enviar_correo">Enviar Correo</button>
    </form>
</div>
</body>
</html>
