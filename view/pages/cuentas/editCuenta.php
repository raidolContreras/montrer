<?php if ($level == 1): ?>
<!-- Start Main Content Area -->
<main class="main-content-wrap">

    <div class="card-box-style">
        <div class="others-title">
            <h3>Editar cuenta</h3>
        </div>

        <?php
        // Obtener los parámetros enviados por POST
        $accountId = isset($_POST['id']) ? $_POST['id'] : '';
        $accountName = isset($_POST['cuenta']) ? $_POST['cuenta'] : '';
        $accountNumber = isset($_POST['numeroCuenta']) ? $_POST['numeroCuenta'] : '';
        ?>

        <form class="account-wrap" id="editAccountForm">
            <div class="row">
                <input type="hidden" id="accountId" name="accountId" value="<?php echo htmlspecialchars($accountId); ?>">
                
                <div class="col-md-6">
                    <label for="cuenta" class="form-label">Nombre de la cuenta<span class="required"></span></label>
                    <input type="text" class="form-control" id="cuenta" name="cuenta" 
                           placeholder="Nombre de la cuenta" 
                           value="<?php echo htmlspecialchars($accountName); ?>">
                </div>

                <div class="col-md-6">
                    <label for="numeroCuenta" class="form-label">Número de cuenta<span class="required"></span></label>
                    <input type="text" class="form-control auto-format" id="numeroCuenta" name="numeroCuenta" 
                           placeholder="Número de cuenta" 
                           value="<?php echo htmlspecialchars($accountNumber); ?>">
                </div>

                <div class="col-12 mt-2 text-end">
                    <a class="btn btn-danger" id="cancelButton">Cancelar</a>
                    <button type="submit" class="btn btn-success">Guardar cambios</button>
                </div>
            </div>
        </form>
    </div>

</main>
<!-- End Main Content Area -->
<script src="assets/js/ajax-js/edit-account.js"></script>

<?php else: ?>
	<script>
		window.location.href = 'inicio';
	</script>
<?php endif ?>
