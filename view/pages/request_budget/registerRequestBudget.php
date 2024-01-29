<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    var $j = jQuery.noConflict();
</script>
<script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js"></script>
<!-- Start Main Content Area -->
<main class="main-content-wrap">

    <div class="card-box-style">
        <div class="others-title">
            <h3>Solicitud de Presupuesto</h3>
        </div>

        <form class="account-wrap" id="budgetRequestForm">
            <div class="row">

                <!-- Sección de Solicitud de Presupuesto -->
                <div class="col-12 mt-4">
                    <h4>Solicitud de Presupuesto</h4>
                </div>

                <input type="hidden" class="form-control" id="idBudget" name="idBudget" >

                <div class="col-md-6">
                    <label for="Area" class="form-label">Departamento</label>
                    <select name="area" id="area" class="form-select form-control">
                        <option value="">Seleccionar departamento</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="provider" class="form-label">Proveedor</label>
                    <select name="provider" id="provider" class="form-select form-control">
                        <option value="">Seleccionar proveedor</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="requestedAmount" class="form-label">Monto Solicitado ($)</label>
                    <input type="text" id="requestedAmount" name="requestedAmount" class="form-control inputmask" data-inputmask="'alias': 'currency', 'prefix': '$ ', 'placeholder': '0', 'autoUnmask': true, 'removeMaskOnSubmit': true"> 
                </div>

                <div class="col-md-6">
                    <label for="description" class="form-label">Descripción</label>
                    <textarea class="form-control" id="description" name="description"></textarea>
                </div>

                <div class="col-12 mt-2 text-end">
                    <button type="submit" class="btn btn-success">Enviar solicitud</button>
                    <a class="btn btn-danger" id="cancelButton">Cancelar</a>
                </div>
            </div>
        </form>
    </div>

</main>
<div id="register-value" data-register="<?php echo $_SESSION['idUser']; ?>"></div>
<!-- End Main Content Area -->
<script src="assets/js/ajax-js/add-budget-request.js"></script>
<script src="assets/js/sweetalert2.all.min.js"></script>

<script>
    $j(document).ready(function() {
        // Inicializa la máscara para el input con la clase 'inputmask'
        $j('.inputmask').inputmask();
    });
</script>
