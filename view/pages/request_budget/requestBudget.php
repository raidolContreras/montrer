<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/locale/es.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    var $j = jQuery.noConflict();
</script>
<style>
    .form-input {
        font-size: 11px;
        padding: 7px 19px;
        width: 100%;
        transition: all ease 0.5s;
        display: block;
        font-weight: 400;
        line-height: 1.5;
        color: var(--bs-body-color);
        background-color: var(--bs-body-bg);
        background-clip: padding-box;
        border: var(--bs-border-width) solid var(--bs-border-color);
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        border-radius: var(--bs-border-radius);
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    }

    .btn-report {
        font-weight: 200;
        font-size: 10px;
        border: none;
        padding: 8px 15px;
        background-color: var(--bs-primary);
        color: #fff;
        border-radius: 15px;
    }
    .btn-report:hover {
        background-color: #085f12;
    }

</style>
<script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js"></script>
<!-- Start Main Content Area -->
	<main class="main-content-wrap">
		<div class="col-xl-12">
			<div class="total-browse-content card-box-style single-features">
				<div class="main-title d-flex justify-content-between align-items-center solicitud">
					<h3>Solicitudes de presupuesto</h3>
                    <?php if ($level != 0): ?>
                        <a class="btn btn-primary" href="registerRequestBudget">Nueva solicitud</a>
                    <?php endif ?>
				</div>

				<table class="table table-responsive" id="requests">
					<thead>
						<tr>
							<th>Folio</th>
							<th>Departamento</th>
							<th>Presupuesto</th>
							<th>Solicitante</th>
							<th>Concepto de pago</th>
							<th>Fecha de la solicitud</th>
                            <th>Ejercicio</th>
                            <th>Estatus</th>
							<th width="15%"></th>
						</tr>
					</thead>
				</table>
			</div>
		</div>

	</main>
	<input type="hidden" name = "level" value="<?php echo $level ?>">
	<input type="hidden" name = "user" value="<?php echo $_SESSION['idUser'] ?>">
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
                <p>¿Está seguro de que desea eliminar de forma permanente la solicitud <strong id="deleteRequestName"></strong>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success" id="confirmDeleteRequest">Aceptar</button>
            </div>
        </div>
    </div>
</div>
<?php if($level == 1 || $level == 0): ?>
<!-- enable Modal -->
<div class="modal fade" id="enableModal" tabindex="-1" aria-labelledby="enableModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="enableModalLabel">Aprobar solicitud</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
				<div>
                    <label for="approvedAmount" class="form-label">Monto Solicitado ($)<span class="required"></span></label>
                    <input type="text" id="approvedAmount" name="approvedAmount" class="form-control inputmask" data-inputmask="'alias': 'currency', 'prefix': '$ ', 'placeholder': '0', 'autoUnmask': true, 'removeMaskOnSubmit': true"> 
                    <label class="requestMax"></label>
                    <input type="hidden" name="maxBudget">
                    <input type="hidden" name="area">
                    <input type="hidden" name="budget">
				</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success" id="confirmEnableRequest">Aceptar</button>
            </div>
        </div>
    </div>
</div>

<!-- denegate Modal -->
<div class="modal fade" id="denegateModal" tabindex="-1" aria-labelledby="denegateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="denegateModalLabel">Eliminar solicitud</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Está seguro de que desea denegar el presupuesto?</p>
            </div>
            <div class="px-3 my-2">
                <label for="comentarios">Motivo de rechazo</label>
                <input class="form-control" type="text" id="comentRechazo" >
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success" id="confirmDenegateRequest">Aceptar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="marcarModal" tabindex="-1" aria-labelledby="marcarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="marcarModalLabel">Marcar como pagado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Está seguro de que desea marcar como pagado el presupuesto?</p>
            </div>
            <div class="modal-footer marcar-footer">
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalChangePaymentDate" tabindex="-1" aria-labelledby="modalChangePaymentDate" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalChangePaymentDate">Cambiar la fecha de pago</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Está seguro de que desea cambiar la fecha de pago?</p>
                <input type="date" id="paymentDate" class="form-control">
            </div>
            <div class="modal-footer marcar-footer">
            </div>
        </div>
    </div>
</div>

<?php endif ?>
<div id="register-value" data-register="<?php echo $_SESSION['idUser']; ?>"></div>

<script>
    $j(document).ready(function() {
        $j('.inputmask').inputmask();
    });
</script>
<script src="assets/js/ajax-js/get-requests.js"></script>
<?php 
    include 'verComprobacion.php';
    include 'modalCompleteRequestBudget.php';
    include "modalComprobar.php";
    include "modalRespuesta.php";
    include 'modalProvider.php';
?>
