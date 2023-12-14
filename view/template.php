<!doctype html>
<html lang="zxx">
	<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Link Of CSS --> 
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/owl.theme.default.min.css">
	<link rel="stylesheet" href="assets/css/owl.carousel.min.css">
	<link rel="stylesheet" href="assets/css/animate.min.css">
	<link rel="stylesheet" href="assets/css/remixicon.css">
	<link rel="stylesheet" href="assets/css/boxicons.min.css">
	<link rel="stylesheet" href="assets/css/iconsax.css">
	<link rel="stylesheet" href="assets/css/metismenu.min.css">
	<link rel="stylesheet" href="assets/css/simplebar.min.css">
	<link rel="stylesheet" href="assets/css/calendar.css">
	<link rel="stylesheet" href="assets/css/sweetalert2.min.css">
	<link rel="stylesheet" href="assets/css/jbox.all.min.css">
	<link rel="stylesheet" href="assets/css/editor.css">
	<link rel="stylesheet" href="assets/css/fontawesome.min.css">
	<link rel="stylesheet" href="assets/css/loaders.css">
	<link rel="stylesheet" href="assets/css/header.css">
	<link rel="stylesheet" href="assets/css/sidebar-menu.css">
	<link rel="stylesheet" href="assets/css/footer.css">
	<link rel="stylesheet" href="assets/css/style.css">
	<link rel="stylesheet" href="assets/css/dark-mode.css">
	<link rel="stylesheet" href="assets/css/responsive.css">
	
	<!-- Favicon -->
	<link rel="icon" type="image/png" href="assets/img/svg/favicon.svg">
	<!-- Title -->
	<title>FinFlair - Presupuestos</title>
	</head>

	<body class="body-bg-f8faff darkmode-body">
	<!-- Start Preloader Area -->
	<div class="preloader">
			<img src="assets/img/logo.png" width="150px" alt="main-logo">
		</div>
		<!-- Start All Section Area -->
<div class="all-section-area">
	<!-- End Preloader Area -->
<?php
	include "pages/navs/header.php";
	include "pages/navs/sidenav.php";
	if (!isset($_GET['pagina'])) {
		include "pages/inicio.php";
	} else{
		include "pages/".$_GET['pagina'].".php";
	}
?>

<!-- Jquery Min JS -->
<script src="assets/js/jquery.min.js"></script> 
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/owl.carousel.min.js"></script>
<script src="assets/js/metismenu.min.js"></script>
<script src="assets/js/simplebar.min.js"></script>
<script src="assets/js/apexcharts/apexcharts.min.js"></script>
<script src="assets/js/apexcharts/website-analytics.js"></script>
<script src="assets/js/geticons.js"></script>
<script src="assets/js/calendar.js"></script>
<script src="assets/js/editor.js"></script>
<script src="assets/js/form-validator.min.js"></script>
<script src="assets/js/contact-form-script.js"></script>
<script src="assets/js/ajaxchimp.min.js"></script>
<script src="assets/js/custom.js"></script>
</body>
</html>