<?php if ($_SESSION['level']  == 1):?>
<?php
    $areas = FormsController::ctrGetAreas();
    $exercises = FormsController::ctrGetExercise();
?>
<!-- Start Main Content Area -->
<main class="main-content-wrap">

    <div class="card-box-style">
        <div class="others-title">
            <h3>Actualizar presupuesto</h3>
        </div>

        <form class="account-wrap" id="companyForm">
            <div class="row">
                <div class="col-md-6">
                    <label for="area" class="form-label">Departamentos registrados</label>
                    <select name="area" id="area" class="form-select form-control" required>
                        <option value>Seleccione un departamento</option>
                        <?php foreach ($areas as $area): ?>
                            <?php if ($area['status'] == 1): ?>
                                <option value="<?php echo $area['idArea'] ?>"><?php echo $area['nameArea'] ?></option>
                            <?php endif ?>
                        <?php endforeach ?>
                    </select>
                </div>

                <div class="col-3">
                    <label for="AuthorizedAmount" class="form-label">Presupuesto asignado</label>
                    <input type="number" step="any"  name="AuthorizedAmount" id="AuthorizedAmount"  class=" form-control">
                </div>
                
                <div class="col-md-3">
                    <label for="exercise" class="form-label">Ejercicio</label>
                    <select name="exercise" id="exercise" class="form-select form-control" required>
                        <?php foreach ($exercises as $exercise): ?>
                            <?php if ($exercise['active'] == 1): ?>
                                <option value="<?php echo $exercise['idExercise'] ?>"><?php echo $exercise['exerciseName'] ?></option>
                            <?php endif ?>
                        <?php endforeach ?>
                    </select>
                </div>

                <div class="col-12 mt-2 text-end">
                    <a href="budgets" class="btn btn-danger">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Actualizar presupuesto</button>
                </div>
            </div>
        </form>
    </div>
<div id="register-value" data-register="<?php echo $_POST['register']; ?>"></div>

</main>

<script src="assets/js/ajax-js/get-budget.js"></script>
<script src="assets/js/ajax-js/edit-budgets.js"></script>
<script src="assets/js/sweetalert2.all.min.js"></script>
<?php else: ?>
	<script>
		window.location.href = 'inicio';
	</script>
<?php endif ?>