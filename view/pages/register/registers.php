<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/locale/es.js"></script>
<?php if ($level == 1 || $level == 0):?>
<!-- Start Main Content Area -->
	<main class="main-content-wrap">
		<div class="col-xl-12">
			<div class="total-browse-content card-box-style single-features">
				<div class="main-title d-flex justify-content-between align-items-center">
					<h3>Lista de usuarios</h3>
					<?php if ($level == 1): ?>
						<a class="btn btn-primary" href="register">Nuevo usuario</a>
					<?php endif ?>
				</div>

				<table class="table" id="registers">
					<thead>
						<tr>
							<th>#</th>
							<th>Nombre colabolador</th>
							<th>Email</th>
							<th>Departamento</th>
							<th width="15%">Fecha de creación</th>
							<th width="15%">Última conexión</th>
							<?php if ($level != 0): ?>
								<th width="30%"></th>
							<?php endif ?>
						</tr>
					</thead>
				</table>
			</div>
		</div>

	</main>
	<!-- End Main Content Area -->
</div>
<!-- Disable Modal -->
<div class="modal fade" id="disableModal" tabindex="-1" role="dialog" data-bs-backdrop="static" aria-labelledby="disableModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
	<div class="modal-content">
	  <div class="modal-header">
		<h5 class="modal-title" id="disableModalLabel">Deshabilitar Usuario</h5>
	  </div>
	  <div class="modal-body">
		<p id="userInfo">¿Está seguro de que desea deshabilitar al usuario <strong id="userName"></strong>?</p>
	  </div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
		<button type="button" class="btn btn-success" id="confirmDisable">Aceptar</button>
	  </div>
	</div>
  </div>
</div>

<!-- Enable Modal -->
<div class="modal fade" id="enableModal" tabindex="-1" aria-labelledby="enableModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="enableModalLabel">Habilitar Usuario</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<p>¿Está seguro de que desea habilitar al usuario <strong id="enableUserName"></strong>?</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
				<button type="button" class="btn btn-success" id="confirmEnable">Aceptar</button>
			</div>
		</div>
	</div>
</div>

<!-- delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="deleteModalLabel">Eliminar Usuario</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
			  <p>¿Está seguro de que desea eliminar de forma permanente al usuario <strong id="deleteUserName"></strong>?</p>
			</div>
			<div class="modal-footer">
			  <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
			  <button type="button" class="btn btn-success" id="confirmDelete">Aceptar</button>
			</div>
		</div>
	</div>
</div>

<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="changePasswordModalLabel">Cambiar Contraseña: <span id="changePasswordUserName"></span></h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="form-group mb-24 icon">
					<input name="newPassword" type="password" class="form-control required-field" placeholder="Nueva Contraseña">
					<img src="assets/img/svg/lock.svg" alt="Icono de Contraseña">
				</div>
				<div class="form-group mb-24 icon">
					<input name="confirmPassword" type="password" class="form-control required-field" placeholder="Confirme la Contraseña">
					<img src="assets/img/svg/lock.svg" alt="Icono de Contraseña">
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
				<button type="button" class="btn btn-success" id="confirmChangePassword">Aceptar</button>
			</div>
		</div>
	</div>
</div>

<script src="assets/js/ajax-js/get-users.js"></script>
<?php else: ?>
	<script>
		window.location.href = 'inicio';
	</script>
<?php endif ?>
