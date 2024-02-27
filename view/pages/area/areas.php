<?php if ($_SESSION['level']  == 1):?>
<?php
    $areas = FormsController::ctrGetAreas();
?>
<!-- Start Main Content Area -->
	<main class="main-content-wrap">
		<div class="col-xl-12">
			<div class="total-browse-content card-box-style single-features">
				<div class="main-title d-flex justify-content-between align-items-center">
					<h3>Lista de departamentos</h3>
					<a class="btn btn-primary" href="registerArea">Nuevo departamento</a>
				</div>

				<table class="table table-responsive" id="areas">
					<thead>
						<tr>
							<th>#</th>
							<th>Departamento</th>
							<th>Descripción</th>
							<th>Encargado</th>
							<th width="15%"></th>
						</tr>
					</thead>
				</table>
			</div>
		</div>

	</main>
	<!-- End Main Content Area -->
</div>
<!-- Disable Area Modal -->
<div class="modal fade" id="disableAreaModal" tabindex="-1" aria-labelledby="disableAreaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="disableAreaModalLabel">Deshabilitar departamento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Está seguro de que desea deshabilitar el departamento de <strong id="disableAreaName"></strong>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success" id="confirmDisableArea">Aceptar</button>
            </div>
        </div>
    </div>
</div>

<!-- Enable Area Modal -->
<div class="modal fade" id="enableAreaModal" tabindex="-1" aria-labelledby="enableAreaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="enableAreaModalLabel">Habilitar departamento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Está seguro de que desea habilitar el departamento de <strong id="enableAreaName"></strong>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success" id="confirmEnableArea">Aceptar</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Area Modal -->
<div class="modal fade" id="deleteAreaModal" tabindex="-1" aria-labelledby="deleteAreaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteAreaModalLabel">Eliminar departamento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Está seguro de que desea eliminar el departamento de <strong id="deleteAreaName"></strong>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success" id="confirmDeleteArea">Aceptar</button>
            </div>
        </div>
    </div>
</div>

<script src="assets/js/ajax-js/get-areas.js"></script>

<?php else: ?>
	<script>
		window.location.href = 'inicio';
	</script>
<?php endif ?>