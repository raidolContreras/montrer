	<!-- Start Main Content Area -->
	<main class="main-content-wrap">
		<div class="col-xl-12">
			<div class="total-browse-content card-box-style single-features">
				<div class="main-title d-flex justify-content-between align-items-center">
					<h3>Lista de usuarios</h3>
					<a class="btn btn-primary" href="register">Nuevo usuario</a>
				</div>

				<table class="table table-responsive" id="registers">
					<thead>
						<tr>
							<th>#</th>
							<th>Nombre colabolador</th>
							<th>Email</th>
							<th>Fecha de creación</th>
							<th>Última conexión</th>
							<th>Acciones</th>
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
        <h5 class="modal-title" id="disableModalLabel">Inhabilitar Usuario</h5>
      </div>
      <div class="modal-body">
        <p id="userInfo">Esta seguro de que deseas inhabilitar al usuario <strong id="userName"></strong>?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-danger" id="confirmDisable">Inhabilitar</button>
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
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="confirmEnable">Habilitar</button>
            </div>
        </div>
    </div>
</div>



<script src="assets/js/ajax-js/get-users.js"></script>
<script src="assets/js/sweetalert2.all.min.js"></script>