<?php
	if (isset($_SESSION['sesion'])){
		header('Location: inicio');
    	exit();
	}
?>
<!-- Start Account Area -->
<div class="account-area">
	<div class="d-table">
		<div class="d-table-cell">
			<div class="container">
				<div class="account-content">
					<div class="account-header">
						<a href="inicio">
							<img src="assets/img/logo.png" alt="main-logo">
						</a>
						<h3>Bienvenido</h3>
					</div>

					<form class="account-wrap">
						<div class="form-group mb-24 icon">
							<input name="email" type="email" class="form-control" placeholder="Email" required>
							<img src="assets/img/svg/sms.svg">
						</div>
						<div class="form-group mb-24 icon">
							<input name="password" type="password" class="form-control" placeholder="Contraseña" required>
							<img src="assets/img/svg/lock.svg">
						</div>
						<div class="form-group mb-24">
							<button type="submit" class="default-btn" id="register">iniciar sesión</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- End Account Area -->
<script src="assets/js/ajax-js/login.js"></script>
<script src="assets/js/sweetalert2.all.min.js"></script>