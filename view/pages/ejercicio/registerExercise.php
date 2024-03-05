<?php if ($_SESSION['level']  == 1):?>
<?php
    $areas = FormsController::ctrGetAreas();
?>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    var $j = jQuery.noConflict();
</script>
<script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js"></script>
<!-- Start Main Content Area -->
<main class="main-content-wrap">

    <div class="card-box-style">
        <div class="others-title">
            <h3>Registrar ejercicio</h3>
        </div>

        <form class="account-wrap" id="companyForm">
            <div class="row">
                <div class="col-md-6">
                    <label for="exerciseName" class="form-label">Nombre del ejercicio<span class="required"></span></label>
                    <input type="text" class="form-control" id="exerciseName" name="exerciseName" placeholder="Nombre del ejercicio">
                </div>
                <div class="col-md-6">
                    <label for="initialDate" class="form-label">Fecha de inicio del ejercicio<span class="required"></span></label>
                    <input type="date" class="form-control" id="initialDate" name="initialDate">
                </div>
                <div class="col-md-6">
                    <label for="finalDate" class="form-label">Fecha de cierre del ejercicio<span class="required"></span></label>
                    <input type="date" class="form-control" id="finalDate" name="finalDate">
                </div>
                <div class="col-md-6">
                    <label for="budget" class="form-label">Presupuesto del ejercicio<span class="required"></span></label>
                    <div class="input-group">
                        <input type="text" class="form-control inputmask" id="budget" name="budget" data-inputmask="'alias': 'currency', 'prefix': '$ ', 'placeholder': '0', 'autoUnmask': true, 'removeMaskOnSubmit': true">
                    </div>
                </div>

                <div class="col-12">
                    <input type="hidden" name="user" value="<?php echo $_SESSION['idUser'] ?>">
                    <hr>
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
<script src="assets/js/ajax-js/add-exercises.js"></script>

<script>
    $j(document).ready(function() {
        // Inicializa la máscara para el input con la clase 'inputmask'
        $j('.inputmask').inputmask();
    });
</script>

<?php else: ?>
	<script>
		window.location.href = 'inicio';
	</script>
<?php endif ?>