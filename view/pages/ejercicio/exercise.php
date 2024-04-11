<?php if ($_SESSION['level']  == 1):?>
<?php
    $areas = FormsController::ctrGetAreas();
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/locale/es.js"></script>

	<!-- Start Main Content Exercise -->
	<main class="main-content-wrap">
		<div class="col-xl-12">
			<div class="total-browse-content card-box-style single-features">
				<div class="main-title d-flex justify-content-between align-items-center">
					<h3>Lista de ejercicios</h3>
					<a class="btn btn-primary" href="registerExercise">Nuevo ejercicio</a>
				</div>

				<table class="table table-responsive" id="exercise">
					<thead>
						<tr>
							<th>#</th>
							<th>Ejercicio</th>
							<th>Inicio del ejercicio</th>
							<th>Cierre del ejercicio</th>
							<th>Presupuesto</th>
							<th width="15%"></th>
						</tr>
					</thead>
				</table>
			</div>
		</div>

	</main>
	<!-- End Main Content Exercise -->
</div>

<!-- Disable Exercise Modal -->
<div class="modal fade" id="disableExerciseModal" tabindex="-1" aria-labelledby="disableExerciseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="disableExerciseModalLabel">Deshabilitar ejercicio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Está seguro de que desea deshabilitar el ejercicio <strong id="disableExerciseName"></strong>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success" data-bs-dismiss="modal" id="confirmDisableExercise">Aceptar</button>
            </div>
        </div>
    </div>
</div>

<!-- Enable Exercise Modal -->
<div class="modal fade" id="enableExerciseModal" tabindex="-1" aria-labelledby="enableExerciseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="enableExerciseModalLabel">Habilitar ejercicio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Está seguro de que desea habilitar el ejercicio <strong id="enableExerciseName"></strong>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success" data-bs-dismiss="modal" id="confirmEnableExercise">Aceptar</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Exercise Modal -->
<div class="modal fade" id="deleteExerciseModal" tabindex="-1" aria-labelledby="deleteExerciseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteExerciseModalLabel">Eliminar ejercicio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Está seguro de que desea eliminar el ejercicio <strong id="deleteExerciseName"></strong>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success" data-bs-dismiss="modal" id="confirmDeleteExercise">Aceptar</button>
            </div>
        </div>
    </div>
</div>

<!-- activate Exercise Modal -->
<div class="modal fade" id="activateExerciseModal" tabindex="-1" aria-labelledby="activateExerciseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="activateExerciseModalLabel">Eliminar ejercicio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Está seguro de que desea activar el ejercicio <strong id="activateExerciseName"></strong>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success" data-bs-dismiss="modal" id="confirmActivateExercise">Aceptar</button>
            </div>
        </div>
    </div>
</div>

<script src="assets/js/ajax-js/get-exercise.js"></script>

<?php else: ?>
	<script>
		window.location.href = 'inicio';
	</script>
<?php endif ?>