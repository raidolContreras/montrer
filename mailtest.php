<?php
// mailtest.php

require __DIR__ . '/controller/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Cargar variables de entorno si existe el archivo .env
if (file_exists(__DIR__ . '/.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
}

// Inicializamos variables de mensajes
$mensajeExito = '';
$mensajeError = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enviar_correo'])) {
    $destinatario = filter_var($_POST['destinatario'] ?? '', FILTER_VALIDATE_EMAIL);
    $asunto = trim($_POST['asunto'] ?? 'Correo de Prueba');
    $contenido = trim($_POST['contenido'] ?? 'Este es un correo de prueba.');

    if (!$destinatario) {
        $mensajeError = "El correo destinatario no es válido.";
    } elseif (empty($asunto) || empty($contenido)) {
        $mensajeError = "El asunto y el contenido del correo no pueden estar vacíos.";
    } else {
        $mail = new PHPMailer(true);
        try {
            // Configuración SMTP
            $mail->isSMTP();
            $mail->Host = $_ENV['HOST_MAIL'];
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['USER_MAIL'];
            $mail->Password = $_ENV['PASS_MAIL'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = $_ENV['PORT_MAIL'];

            // Configuración del correo
            $mail->setFrom($mail->Username, 'Montrer Devosco');
            $mail->addAddress($destinatario);
            $mail->isHTML(true);
            $mail->Subject = htmlspecialchars($asunto);
            $mail->Body = nl2br(htmlspecialchars($contenido));

            // Enviar correo
            $mail->send();
            $mensajeExito = "¡Correo enviado exitosamente a $destinatario!";
        } catch (Exception $e) {
            $mensajeError = "Error al enviar el correo: " . htmlspecialchars($mail->ErrorInfo);
        }
    }
}

function readEnvFile()
{
    $envPath = __DIR__ . '/.env';
    if (!file_exists($envPath)) return [];
    $envVars = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $envData = [];
    foreach ($envVars as $line) {
        if (strpos(trim($line), '#') === 0 || !strpos($line, '=')) continue;
        list($key, $value) = explode('=', $line, 2);
        $envData[trim($key)] = trim($value);
    }
    return $envData;
}
$envData = readEnvFile();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <meta charset="UTF-8">
    <title>Test Mail - PHPMailer</title>
</head>
<body>
    <div class="container mt-5">
        <div class="card shadow-lg p-4">
            <h2 class="mb-3 text-center">Enviar Correo de Prueba</h2>
            <?php if ($mensajeExito): ?>
                <div class="alert alert-success"> <?= htmlspecialchars($mensajeExito) ?> </div>
            <?php endif; ?>
            <?php if ($mensajeError): ?>
                <div class="alert alert-danger"> <?= htmlspecialchars($mensajeError) ?> </div>
            <?php endif; ?>
            <form method="POST" action="mailtest.php">
                <div class="mb-3">
                    <label for="destinatario" class="form-label">Correo destinatario:</label>
                    <input type="email" name="destinatario" id="destinatario" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="asunto" class="form-label">Asunto:</label>
                    <input type="text" name="asunto" id="asunto" class="form-control" value="Correo de prueba">
                </div>
                <div class="mb-3">
                    <label for="contenido" class="form-label">Contenido:</label>
                    <textarea name="contenido" id="contenido" class="form-control" rows="4">Este es un correo de prueba.</textarea>
                </div>
                <button type="submit" name="enviar_correo" class="btn btn-primary w-100">Enviar Correo</button>
            </form>
        </div>
        <div class="text-center mt-4">
            <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#envModal">Configurar .env</button>
        </div>
    </div>

    <div class="modal fade" id="envModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar archivo .env</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="envForm">
                        <div id="envInputs">
                            <?php foreach ($envData as $key => $value): ?>
                                <div class="mb-2 d-flex">
                                    <input type="text" class="form-control me-2 key-input" value="<?= htmlspecialchars($key) ?>" readonly>
                                    <input type="text" class="form-control value-input" value="<?= htmlspecialchars($value) ?>">
                                    <button type="button" class="btn btn-danger remove-input">X</button>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" class="btn btn-success mt-2" id="addEnvVariable">Agregar variable</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="saveEnv">Guardar</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#addEnvVariable').click(function () {
                $('#envInputs').append(`
                    <div class="mb-2 d-flex">
                        <input type="text" class="form-control me-2 key-input" placeholder="Nueva variable">
                        <input type="text" class="form-control value-input" placeholder="Valor">
                        <button type="button" class="btn btn-danger remove-input">X</button>
                    </div>
                `);
            });

            $(document).on('click', '.remove-input', function () {
                $(this).closest('.d-flex').remove();
            });

            $('#saveEnv').click(function () {
                let envData = [];
                $('.key-input').each(function (index) {
                    let key = $(this).val().trim();
                    let value = $('.value-input').eq(index).val().trim();
                    if (key !== '') {
                        envData.push(`${key}=${value}`);
                    }
                });

                $.post('save_env.php', {envData: JSON.stringify(envData)}, function(response) {
                    alert(response);
                    location.reload();
                }).fail(function () {
                    alert('Error al guardar el archivo .env');
                });
            });
        });
    </script>
</body>
</html>
