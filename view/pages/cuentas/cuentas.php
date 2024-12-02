<?php if ($level != 2): ?>
<?php
    $areas = FormsController::ctrGetAreas();
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/locale/es.js"></script>

	<!-- Start Main Content Cuentas -->
	<main class="main-content-wrap">
		<div class="col-xl-12">
			<div class="total-browse-content card-box-style single-features">
				<div class="main-title d-flex justify-content-between align-items-center">
					<h3>Lista de cuentas</h3>
                    <?php if ($level == 1): ?>
                        <a class="btn btn-primary" href="registerCuenta">Nueva cuenta</a>
                    <?php endif ?>
				</div>

				<table class="table table-responsive" id="accounts">
				</table>
			</div>
		</div>

	</main>
	<!-- End Main Content Cuentas -->
</div>

<!-- Delete Account Modal -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteAccountModalLabel">Eliminar cuenta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Está seguro de que desea eliminar la cuenta <strong id="deleteAccountName"></strong>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success" data-bs-dismiss="modal" id="confirmDeleteAccount">Aceptar</button>
            </div>
        </div>
    </div>
</div>

<script src="assets/js/ajax-js/get-accounts.js"></script>

<?php else: ?>
	<script>
		window.location.href = 'inicio';
	</script>
<?php endif ?>
