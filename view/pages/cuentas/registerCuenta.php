<?php if ($level == 1): ?>
<!-- Start Main Content Area -->
<main class="main-content-wrap">

    <div class="card-box-style">
        <div class="others-title">
            <h3>Registrar cuenta</h3>
        </div>

        <form class="account-wrap" id="accountForm">
            <div class="row">
                <div class="col-md-6">
                    <label for="cuenta" class="form-label">Nombre de la cuenta<span class="required"></span></label>
                    <input type="text" class="form-control" id="cuenta" name="cuenta" placeholder="Nombre de la cuenta">
                </div>

                <div class="col-md-6">
                    <label for="numeroCuenta" class="form-label">Número de cuenta<span class="required"></span></label>
                    <input type="text" class="form-control auto-format" id="numeroCuenta" name="numeroCuenta" placeholder="Número de cuenta">
                </div>

                <div class="col-12 mt-2 text-end">
                    <a class="btn btn-danger" id="cancelButton">Cancelar</a>
                    <button type="submit" class="btn btn-success">Aceptar</button>
                </div>
            </div>
        </form>
    </div>

</main>
<!-- End Main Content Area -->
<script src="assets/js/ajax-js/add-accounts.js"></script>

<?php else: ?>
	<script>
		window.location.href = 'inicio';
	</script>
<?php endif ?>
