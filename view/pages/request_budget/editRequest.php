<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    var $j = jQuery.noConflict();
</script>
<script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js"></script>
<!-- Start Main Content Area -->
<main class="main-content-wrap">

    <div class="card-box-style">
        <div class="others-title">
            <h3>Edición del presupuesto</h3>
        </div>

        <form class="account-wrap" id="budgetRequestForm">
            <div class="row">

                <div class="col-md-6">
                    <label for="folio" class="form-label">Folio</label>
                    <input class="form-control" type="text" id="folio" name="folio" readonly>
                </div>

                <div class="col-md-6">
                    <label for="fecha" class="form-label">Fecha de petición<span class="required"></span></label>
                    <input class="form-control" type="date" id="fecha" name="fecha" value="<?php echo date('Y-m-d'); ?>" readonly>
                </div>

                <div class="col-md-6">
                    <label for="provider" class="form-label">Proveedor<span class="required"></span></label>
                    <select name="provider" id="provider" class="form-select form-control">
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="name" class="form-label">Nombre completo del solicitante</label>
                    <input class="form-control" type="text" name="name" id="name"
                        value="<?php echo $_SESSION['firstname'] . " " . $_SESSION['lastname'] ?>"
                    readonly>
                </div>

                <div class="col-md-6">
                    <label for="Area" class="form-label">Departamento<span class="required"></span></label>
                    <select name="area" id="area" class="form-select form-control" disabled>
                        <option value="">Seleccionar departamento</option>
                    </select>
                </div>
                
                <div class="col-md-6">
                    <label for="requestedAmount" class="form-label">Monto Solicitado ($)<span class="required"></span></label>
                    <input type="text" id="requestedAmount" name="requestedAmount" class="form-control inputmask" data-inputmask="'alias': 'currency', 'prefix': '$ ', 'placeholder': '0', 'autoUnmask': true, 'removeMaskOnSubmit': true"> 
                    <label class="requestMax"></label>
                </div>
                
                <div class="col-md-6">
                    <label for="description" class="form-label">Descripción<span class="required"></span></label>
                    <textarea class="form-control" id="description" name="description"></textarea>
                </div>

                <div class="col-md-6">
                    <label for="eventDate" class="form-label">Fecha del evento<span class="required"></span></label>
                    <input class="form-control" type="date" id="eventDate" name="eventDate">
                </div>
                
                <div class="col-12 mt-2 text-end">
                    <a class="btn btn-danger" id="cancelButton">Cancelar</a>
                    <button type="submit" class="btn btn-success">Aceptar</button>
                </div>
            </div>
            <input type="hidden" name="maxBudget">
            <input type="hidden" class="form-control" id="idBudget" name="idBudget" >
            <input type="hidden" name="budget">
            <input type="hidden" name="request" id="request" value="<?php echo $_POST['register'] ?>">
        </form>
    </div>
</main>
<div id="register-value" data-register="<?php echo $_SESSION['idUser']; ?>"></div>


<input type="hidden" name="budget">

<script src="assets/js/ajax-js/add-provider2.js"></script>
<!-- End Main Content Area -->
<script src="assets/js/ajax-js/edit-budget-request.js"></script>


<script>
    $j(document).ready(function() {
        $j('.inputmask').inputmask();
    });
</script>

<?php
include 'view/pages/request_budget/modalProvider.php';