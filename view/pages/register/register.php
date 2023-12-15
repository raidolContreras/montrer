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
								<option value="2">Encargado de area</option>
							</select>
						</div>
						<div class="form-group mb-24">
							<button type="submit" class="default-btn" id="register">Registrar</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- End Account Area -->
<script src="assets/js/ajax-js/add-users.js"></script>
<script src="assets/js/sweetalert2.all.min.js"></script>