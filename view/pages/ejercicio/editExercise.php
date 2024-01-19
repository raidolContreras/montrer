<?php if ($_SESSION['level']  == 1):?>
<?php
    $areas = FormsController::ctrGetAreas();
?>
<!-- Start Main Content Area -->
<main class="main-content-wrap">

    <div class="card-box-style">
        <div class="others-title">
            <h3>Registrar ejercicio</h3>
        </div>

        <form class="account-wrap" id="companyForm">
            <div class="row">
                <div class="col-md-6">
                    <label for="exerciseName" class="form-label">Nombre del ejercicio</label>
                    <input type="text" class="form-control" id="exerciseName" name="exerciseName" placeholder="Nombre del ejercicio">
                </div>
                <div class="col-md-6">
                    <label for="initialDate" class="form-label">Fecha de inicio del ejercicio</label>
                    <input type="date" class="form-control" id="initialDate" name="initialDate">
                </div>
                <div class="col-md-6">
                    <label for="finalDate" class="form-label">Fecha de cierre del ejercicio</label>
                    <input type="date" class="form-control" id="finalDate" name="finalDate">
                </div>
                <div class="col-md-6">
                    <label for="budget" class="form-label">Presupuesto del ejercicio</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" step="any" class="form-control" id="budget" name="budget">
                    </div>
                </div>

                <div class="col-12">
                    <input type="hidden" name="user" value="">
                    <hr>
                </div>

                <div class="col-12 mt-2 text-end">
                    <a href="exercise" class="btn btn-danger">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Registrar ejercicio</button>
                </div>
            </div>
        </form>
    </div>
<div id="register-value" data-register="<?php echo $_POST['register']; ?>"></div>

</main>
<!-- End Main Content Area -->
<script src="assets/js/ajax-js/get-exercises.js"></script>
<script src="assets/js/ajax-js/edit-exercises.js"></script>
<script src="assets/js/sweetalert2.all.min.js"></script>
<?php else: ?>
	<script>
		window.location.href = 'inicio';
	</script>
<?php endif ?>