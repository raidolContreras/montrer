<?php if ($level == 1): ?>
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
                <h3>Registrar presupuesto</h3>
            </div>

            <form class="account-wrap" id="companyForm">
                <div class="row">
                    <div class="col-md-3">
                        <label for="area" class="form-label">Departamentos registrados<span class="required"></span></label>
                        <select name="area" id="area" class="form-select form-control">
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
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label for="exercise" class="form-label">Ejercicio<span class="required"></span></label>
                        <select name="exercise" id="exercise" class="form-select form-control">
                        </select>
                    </div>

                    <div class="col-12 mt-2 text-end">
                        <a class="btn btn-danger" id="cancelButton">Cancelar</a>
                        <button type="submit" class="btn btn-success">Aceptar</button>
                    </div>
                </div>
            </form>
        </div>

    </main>

    <script src="assets/js/ajax-js/add-budgets.js"></script>
    <script src="assets/js/ajax-js/active-exercise.js"></script>
    <script src="assets/js/ajax-js/areas.js"></script>

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