<?php
// save_env.php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit("Método no permitido.");
}

if (!isset($_POST['envData'])) {
    http_response_code(400);
    exit("No se recibieron datos.");
}

$envPath = __DIR__ . '/.env';
$envData = json_decode($_POST['envData'], true);

if (!is_array($envData)) {
    http_response_code(400);
    exit("Formato de datos incorrecto.");
}

// Leer contenido actual del archivo .env
$existingEnv = [];
if (file_exists($envPath)) {
    $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0 || !strpos($line, '=')) continue;
        list($key, $value) = explode('=', $line, 2);
        $existingEnv[trim($key)] = trim($value);
    }
}

// Actualizar valores en el archivo .env
foreach ($envData as $line) {
    list($key, $value) = explode('=', $line, 2);
    $key = strtoupper(trim($key));
    $value = trim($value, "\""); // Elimina comillas si existen

    $existingEnv[$key] = "\"$value\""; // Asegura que los valores se guarden con comillas
}

// Construir nuevo contenido del .env
$envContent = "";
foreach ($existingEnv as $key => $value) {
    $envContent .= "$key=$value\n";
}

// Guardar el archivo
if (file_put_contents($envPath, $envContent) !== false) {
    echo "Archivo .env actualizado correctamente.";
} else {
    http_response_code(500);
    echo "Error al guardar el archivo .env.";
}
