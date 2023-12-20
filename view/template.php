<?php
header('Content-Type: text/html; charset=utf-8');
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="utf-8">
    <!-- Required meta tags -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <?php include "css.php"; ?>

    <!-- Title -->
    <?php $title = isset($_GET['pagina']) ? "FinFlair - " . $_GET['pagina'] : "FinFlair - Presupuestos"; ?>
    <title><?php echo $title; ?></title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="assets/img/svg/favicon.svg">

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<body class="body-bg-f8faff">
    <!-- Start Preloader Area -->
    <div class="preloader">
        <img src="assets/img/logo.png" width="150px" alt="main-logo">
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
