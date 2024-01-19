<?php if ($_SESSION['level']  == 1):?>
<?php
    $areas = FormsController::ctrGetAreas();
?>
<!-- Start Main Content Area -->
<main class="main-content-wrap">

    <div class="card-box-style">
        <div class="others-title">
            <h3>Registrar presupuesto</h3>
        </div>

        <form class="account-wrap" id="companyForm">
            <div class="row">
                <div class="col-md-6">
                    <label for="area" class="form-label">Departamentos registrados</label>
                    <select name="area" id="area" class="form-select form-control">
                    </select>
                </div>

                <div class="col-3">
                    <label for="AuthorizedAmount" class="form-label">Asignar presupuesto</label>
                    <input type="number" step="any"  name="AuthorizedAmount" id="AuthorizedAmount"  class=" form-control">
                </div>
                
                <div class="col-md-3">
                    <label for="exercise" class="form-label">Ejercicio</label>
                    <select name="exercise" id="exercise" class="form-select form-control">
                    </select>
                </div>

                <div class="col-12 mt-2 text-end">
                    <a href="budgets" class="btn btn-danger">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Registrar presupuesto</button>
                </div>
            </div>
        </form>
    </div>

</main>

<script src="assets/js/ajax-js/add-budgets.js"></script>
<script src="assets/js/ajax-js/active-exercise.js"></script>
<script src="assets/js/ajax-js/areas.js"></script>
<script src="assets/js/sweetalert2.all.min.js"></script>
<?php else: ?>
	<script>
		window.location.href = 'inicio';
	</script>
<?php endif ?>