<!-- Start Main Content Area -->
	<main class="main-content-wrap">
		<div class="col-xl-12">
			<div class="total-browse-content card-box-style single-features">
				<div class="main-title d-flex justify-content-between align-items-center">
					<h3>Solicitudes de presupuesto</h3>
					<a class="btn btn-primary" href="registerRequestBudget">Nueva solicitud</a>
				</div>

				<table class="table table-responsive" id="requests">
					<thead>
						<tr>
							<th>#</th>
							<th>Solicitud</th>
							<th>Presupuesto solicitado</th>
							<th width="30%"></th>
						</tr>
					</thead>
				</table>
			</div>
		</div>

	</main>
	<!-- End Main Content Area -->
</div>

<!-- delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Eliminar solicitud</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <p>¿Está seguro de que desea eliminar de forma permanente al solicitud <strong id="deleteRequestName"></strong>?</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancelar</button>
              <button type="button" class="btn btn-danger" id="confirmDelete">Eliminar</button>
            </div>
        </div>
    </div>
</div>

<script src="assets/js/ajax-js/get-requests.js"></script>
<script src="assets/js/sweetalert2.all.min.js"></script>