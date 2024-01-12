	<!-- Start Main Content Budget -->
	<main class="main-content-wrap">
		<div class="col-xl-12">
			<div class="total-browse-content card-box-style single-features">
				<div class="main-title d-flex justify-content-between align-items-center">
					<h3>Lista de presupuestos</h3>
					<a class="btn btn-primary" href="registerBudgets">Asignar presupuesto</a>
				</div>

				<table class="table table-responsive" id="budgets">
					<thead>
						<tr>
							<th>#</th>
							<th>Departamento</th>
							<th>Presupuesto autorizado</th>
							<th>Ejercicio</th>
							<th width="20%"></th>
						</tr>
					</thead>
				</table>
			</div>
		</div>

	</main>
	<!-- End Main Content Budget -->
</div>
<!-- Disable Budget Modal -->
<div class="modal fade" id="disableBudgetModal" tabindex="-1" aria-labelledby="disableBudgetModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="disableBudgetModalLabel">Eliminar Área</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Esta seguro de que desea Eliminar el presupuesto asignado a <strong id="disableBudgetName"></strong>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirmDisableBudget">Eliminar</button>
            </div>
        </div>
    </div>
</div>

<script src="assets/js/ajax-js/get-budgets.js"></script>