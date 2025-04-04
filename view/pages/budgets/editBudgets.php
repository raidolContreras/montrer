<?php if ($level == 1):
    $areas = FormsController::ctrGetAreas();
    $exercises = FormsController::ctrGetExercise();
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
                <h3>Actualizar presupuesto</h3>
            </div>
            <form class="account-wrap" id="companyForm">
                <div class="row">
                    <div class="col-md-3">
                        <label for="area" class="form-label">Departamento registrado<span class="required"></span></label>
                        <select name="area" id="area" class="form-select form-control">
                            <option value>Seleccione un departamento</option>
                            <?php foreach ($areas as $area): ?>
                                <?php if ($area['status'] == 1): ?>
                                    <option value="<?php echo $area['idArea'] ?>"><?php echo $area['nameArea'] ?></option>
                                <?php endif ?>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <!-- Partidas -->
                        <label for="partidas" class="form-label">Partida<span class="required"></span></label>
                        <select name="partidas" id="partidas" class="form-select form-control" disabled>
                            <option value="">Seleccione una partida</option>
                        </select>
                    </div>

                    <div class="col-3">
                        <label for="AuthorizedAmount" class="form-label">Presupuesto asignado<span class="required"></span></label>
                        <div class="input-group">
                            <input type="text" name="AuthorizedAmount" id="AuthorizedAmount" class="form-control inputmask" data-inputmask="'alias': 'currency', 'prefix': '$ ', 'placeholder': '0', 'autoUnmask': true, 'removeMaskOnSubmit': true">
                            <input type="hidden" id="Amount">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label for="exercise" class="form-label">Ejercicio<span class="required"></span></label>
                        <select name="exercise" id="exercise" class="form-select form-control" required>
                            <?php foreach ($exercises as $exercise): ?>
                                <?php if ($exercise['active'] == 1): ?>
                                    <option value="<?php echo $exercise['idExercise'] ?>"><?php echo $exercise['exerciseName'] ?></option>
                                <?php endif ?>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class="col-12 mt-2 text-end">
                        <a class="btn btn-danger" id="cancelButton">Cancelar</a>
                        <button type="submit" class="btn btn-success">Aceptar</button>
                    </div>
                </div>
            </form>
        </div>
        <div id="register-value" data-register="<?php echo $_POST['register']; ?>"></div>

    </main>

    <script src="assets/js/ajax-js/get-budget.js"></script>
    <script src="assets/js/ajax-js/edit-budgets.js"></script>

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