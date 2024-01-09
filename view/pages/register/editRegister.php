<!-- Start Main Content Area -->
<main class="main-content-wrap">
<!-- Start Account Area -->
<div>
	<div class="d-table">
		<div class="d-table-cell">
			<div class="container">
				<div class="account-content single-features">
					<div class="account-header">
						<a href="inicio">
							<img src="assets/img/logo.png" alt="main-logo">
						</a>
						<h3>Registro de nuevos usuarios</h3>
					</div>

					<form class="account-wrap">
						<div class="form-group mb-24 icon">
							<input name="firstname" type="text" class="form-control" placeholder="Nombre(s)" required>
							<img src="assets/img/svg/user.svg">
						</div>
						<div class="form-group mb-24 icon">
							<input name="lastname" type="text" class="form-control" placeholder="Apellidos" required>
							<img src="assets/img/svg/seconduser.svg">
						</div>
						<div class="form-group mb-24 icon">
							<input name="email" type="email" class="form-control" placeholder="Email" required>
							<img src="assets/img/svg/sms.svg">
						</div>
						<div class="form-group mb-24 icon">
							<img src="assets/img/svg/level.svg">
							<select class="form-select form-control" name="level">
								<option value="1">Administrador</option>
								<option value="2">Responsable de departamento</option>
							</select>
						</div>
						<div class="form-group mb-24">
							<button type="submit" class="default-btn" id="register">Actualizar datos</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- En tu archivo PHP -->
<div id="register-value" data-register="<?php echo $_POST['register']; ?>"></div>

</main>
<!-- End Main Content Area -->
</div>
<!-- End Account Area -->
<script src="assets/js/ajax-js/get-user.js"></script>
<script src="assets/js/ajax-js/edit-user.js"></script>
<script src="assets/js/sweetalert2.all.min.js"></script>
