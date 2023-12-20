<?php
header('Content-Type: text/html; charset=utf-8');
?>

<!doctype html>
<html lang="zxx">
	<head>
		<meta charset="utf-8">
		<!-- Required meta tags -->
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

		<!-- Datatable -->
		<link href="assets/vendor/DataTables/datatables.min.css" rel="stylesheet">

		<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
		<!-- Favicon -->
		<link rel="icon" type="image/png" href="assets/img/svg/favicon.svg">
		<!-- Title -->
		<?php (isset($_GET['pagina'])) ?$title = "FinFlair - ".$_GET['pagina'] :$title = "FinFlair - Presupuestos"; ?>
		<title><?php echo $title; ?></title>
	</head>

	<style>
	</style>
	<body class="body-bg-f8faff">
		<!-- Start Preloader Area -->
		<div class="preloader">
			<img src="assets/img/logo.png" width="150px" alt="main-logo">
		</div>
		<!-- Start All Section Area -->
		<div class="all-section-area">
		<!-- End Preloader Area -->

		<?php
			include "config/whiteList.php";
		?>

		<div id="response"></div>

		<!-- Jquery Min JS -->
		<script src="assets/js/jquery.min.js"></script>
		<script src="assets/js/bootstrap.bundle.min.js"></script>
		<script src="assets/js/owl.carousel.min.js"></script>
		<script src="assets/js/metismenu.min.js"></script>
		<script src="assets/js/simplebar.min.js"></script>
		<script src="assets/js/geticons.js"></script>
		<script src="assets/js/calendar.js"></script>
		<script src="assets/js/editor.js"></script>
		<script src="assets/js/form-validator.min.js"></script>
		<script src="assets/js/contact-form-script.js"></script>
		<script src="assets/js/ajaxchimp.min.js"></script>
		<script src="assets/js/custom.js"></script>

		<!-- Datatable Script -->
		<script src="assets/vendor/DataTables/datatables.min.js"></script>

	</body>
</html>