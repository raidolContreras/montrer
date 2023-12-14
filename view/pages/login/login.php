<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            max-width: 400px;
        }

        .rounded-circle {
            border: 2px solid #007bff;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-label {
            font-weight: bold;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .text-primary {
            color: #007bff;
        }

        .text-primary:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container my-5">
        <div class="text-center mb-4">
            <img src="logo.png" alt="Logo" class="rounded-circle" width="100" height="100">
        </div>
        <form>
            <div class="mb-3">
                <label for="email" class="form-label">Correo electrónico</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Ingresa tu correo electrónico" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Ingresa tu contraseña" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Iniciar sesión</button>
            <div class="text-center mt-3">
                <a href="#" class="text-decoration-none text-primary">¿Olvidaste tu contraseña?</a>
            </div>
            <div class="text-center mt-2">
                <a href="#" class="text-decoration-none text-primary">¿No tienes una cuenta? Regístrate</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
