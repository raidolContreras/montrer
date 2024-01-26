<?php if ($_SESSION['level']  == 1):?>
<?php
    $areas = FormsController::ctrGetAreas();
?>
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
							<input name="firstname" type="text" class="form-control" placeholder="Nombre(s)">
							<img src="assets/img/svg/user.svg">
						</div>
						<div class="form-group mb-24 icon">
							<input name="lastname" type="text" class="form-control" placeholder="Apellidos">
							<img src="assets/img/svg/seconduser.svg">
						</div>
						<div class="form-group mb-24 icon">
							<input name="email" type="email" class="form-control" placeholder="Email">
							<img src="assets/img/svg/sms.svg">
						</div>
						<div class="form-group mb-24 icon">
							<img src="assets/img/svg/level.svg">
							<select class="form-select form-control" name="level">
								<option value="2">Responsable de departamento</option>
								<option value="1">Administrador</option>
							</select>
						</div>
						<div class="input-group mb-3">
							<span class="input-group-text" id="basic-addon3">
								<button type="button" class="btn btn-primary btn-circle question-btn" id="questionBtn">?</button>
							</span>
							<select class="form-select form-control" name="area">
								<option value="">Seleccione el departamento</option>
								
								<?php foreach ($areas as $area): ?>
									<option value="<?php echo $area['idArea']; ?>"><?php echo $area['nameArea']; ?></option>
								<?php endforeach ?>
								
							</select>
						</div>
						<div class="d-grid gap-2 mb-3">
							<button type="submit" class="btn btn-primary" id="register">Registrar</button>
							<a class="btn btn-danger" id="cancelButton">Cancelar</a>
						</div>
					</form>

				</div>
			</div>
		</div>
	</div>
</div>
</main>
<!-- End Main Content Area -->
</div>
<!-- End Account Area -->
<script src="assets/js/ajax-js/add-users.js"></script>
<script src="assets/js/sweetalert2.all.min.js"></script>

<?php else: ?>
	<script>
		window.location.href = 'inicio';
	</script>
<?php endif ?>