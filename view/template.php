<?php
header('Content-Type: text/html; charset=utf-8');
?>

<?php
// Comenzar la sesión
session_start();

$level =  (isset($_SESSION['level'])) ? $_SESSION['level'] : '' ;
$idUser =  (isset($_SESSION['idUser'] )) ? $_SESSION['idUser']  : '' ;

// Obtener el agente de usuario
$user_agent = $_SERVER['HTTP_USER_AGENT'];

// Verificar si el agente de usuario indica un dispositivo móvil
$is_mobile = (bool) preg_match('/(android|iphone|ipad|ipod|blackberry|mobile|opera mini|windows phone|iemobile)/i', $user_agent);

// Verificar si ya se ha establecido la cookie
if (isset($_COOKIE['is_mobile'])) {
    // Si la cookie ya está establecida, usar su valor en lugar de detectar de nuevo
    $is_mobile = $_COOKIE['is_mobile'] === 'true';
} else {
    // Si la cookie no está establecida, detectar y guardar el resultado en una cookie
    setcookie('is_mobile', $is_mobile ? 'true' : 'false', time() + (86400 * 30), "/"); // 86400 = 1 día
}

// Si es un dispositivo móvil, redirigir o mostrar un mensaje
if ($is_mobile) {
    // Puedes redirigir a otra página o mostrar un mensaje de error
    header("Location: mobile-error.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="utf-8">
    <!-- Required meta tags -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no">

    <?php include "css.php"; ?>

    <!-- Title -->
    <?php $title = isset($_GET['pagina']) ? "UNIMO - " . $_GET['pagina'] : "UNIMO - Presupuestos"; ?>
    <title><?php echo $title; ?></title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="assets/img/svg/favicon.svg">

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <style>
        .btn-circle {
            width: 30px;
            height: 30px;
            padding: 6px 0px;
            border-radius: 15px;
            text-align: center;
            font-size: 12px;
            line-height: 1.42857;
        }

        .required-field:focus {
            border: 1px solid #dc3545;
            box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25);
        }

        .required::after {
            content: " *"; 
            color: #dc3545; 
        }

    </style>
</head>
    <input type="hidden" id="idUser" value="<?php echo $idUser?>">
    <input type="hidden" id="level" value="<?php echo $level ?>">

<!-- Bootstrap Modal for Alerts -->
<div class="modal fade modal2" id="alertModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Alert</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body modal-body-extra">
                Alert message.
            </div>
            <div class="modal-footer modal-footer-extra">
            </div>
        </div>
    </div>
</div>

<body class="body-bg-f8faff">
    <!-- Start Preloader Area -->
    <div class="preloader">
    </div>
    <!-- Start All Section Area -->
    <div class="all-section-area">
        <!-- End Preloader Area -->

        <?php include "config/whiteList.php"; ?>

        <div id="response"></div>

        <?php include "js.php"; ?>

    </div>
</body>

</html>
