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
		.profile-name {
			font-size: 16px;
			margin-bottom: 0;
			font-weight: 600;
		}
		.profile-name-drop {
			display: block;
			color: #292d32;
			margin-bottom: 2px;
			font-size: 16px;
			font-weight: 600;
		}
		.profile-level {
			font-size: 12px;
		}
		.email {
			color: #686868;
    		font-size: 12px;
		}
		.profile-nav {
			padding: 0;
			list-style-type: none;
			margin-bottom: 0;
		}
		.nav-link {
			position: relative;
    		padding-left: 40px;
		}
		.nav-item {
			margin-left: 0;
    		margin-bottom: 5px;
		}
		.nav-item i {
			color: #292d32;
			transition: all ease 0.5s;
			position: absolute;
			left: 15px;
			top: 1px;
			transition: all ease 0.5s;
			font-size: 16px;
			font-weight: normal;
		}
		.nav-item span {
			font-size: 13px !important;
		}
		.nav-link {
			position: relative;
    		padding-left: 40px;
		}
		.nav-link :hover {
			color: #198754;
		}
		.dropdown-footer {
			margin: 10px -15px 0;
			padding: 10px 15px 0;
			border-top: 1px solid #eeeeee;
			background-color: transparent;
		}
		.dropdown-footer .profile-nav a {
			color: #4fcb8d;
			padding: 5px 15px 5px 38px;
			position: relative;
			font-size: 13px;
			font-weight: 500;
		}
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