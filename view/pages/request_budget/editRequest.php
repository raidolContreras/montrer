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

                <div class="col-md-4 mb-3">
                    <label for="folio" class="form-label">Folio</label>
                    <input class="form-control" type="text" id="folio" name="folio" readonly>
                </div>

                <div class="col-md-4 mb-3">
                    <label for="fecha" class="form-label">Fecha de petición<span class="required"></span></label>
                    <input class="form-control" type="date" id="fecha" name="fecha" value="<?php echo date('Y-m-d'); ?>" readonly>
                </div>

                <div class="col-md-4 mb-3">
                    <label for="provider" class="form-label">Proveedor<span class="required"></span></label>
                    <select name="provider" id="provider" class="form-select form-control">
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label for="name" class="form-label">Nombre completo del solicitante</label>
                    <input class="form-control" type="text" name="name" id="name"
                        value="<?php echo $_SESSION['firstname'] . " " . $_SESSION['lastname'] ?>"
                    readonly>
                </div>

                <div class="col-md-4 mb-3">
                    <label for="Area" class="form-label">Departamento<span class="required"></span></label>
                    <select name="area" id="area" class="form-select form-control" disabled>
                        <option value="">Seleccionar departamento</option>
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label for="supPartida" class="form-label">Sub-partida<span class="required"></span></label>
                    <select name="supPartida" id="supPartida" class="form-select form-control">
                        <option value="">Seleccione una subpartida</option>
                        <option value="1">16/9</option>
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label for="description" class="form-label">Descripción<span class="required"></span></label>
                    <textarea class="form-control" id="description" name="description"></textarea>
                </div>
                
                <div class="col-md-4 mb-3">
                    <label for="requestedAmount" class="form-label">Monto Solicitado ($)<span class="required"></span></label>
                    <input type="text" id="requestedAmount" name="requestedAmount" class="form-control inputmask" data-inputmask="'alias': 'currency', 'prefix': '$ ', 'placeholder': '0', 'autoUnmask': true, 'removeMaskOnSubmit': true"> 
                    <label class="requestMax"></label>
                </div>

                <div class="col-md-4 mb-3">
                    <label for="pagoCon" class="form-label">Pago con<span class="required"></span></label>
                    <select class="form-select form-control" id="pagoCon" name="pagoCon">
                        <option value="">Selecciona un metodo de pago</option>
                        <option value="cheque">Cheque</option>
                        <option value="transferencia">Transferencia</option>
                    </select>
                </div>

                <div class="col-md-4 mb-3 cheque">
                    <label for="chequeNombre" class="form-label">Cheque a nombre de<span class="required"></span></label>
                    <input class="form-control" type="text" id="chequeNombre" name="chequeNombre">
                </div>

                <div class="col-md-4 mb-3">
                    <label for="titularCuenta" class="form-label">Titular de la cuenta</label>
                    <input class="form-control" disabled type="text" id="titularCuenta" name="titularCuenta">
                </div>

                <div class="col-md-4 mb-3">
                    <label for="entidadBancaria" class="form-label">Entidad bancaria</label>
                    <input class="form-control" type="text" id="entidadBancaria" name="entidadBancaria" disabled>
                </div>

                <div class="col-md-4 mb-3">
                    <label for="numCuenta" class="form-label">Número de cuenta</label>
                    <input class="form-control" disabled type="text" id="numCuenta" name="numCuenta">
                </div>

                <div class="col-md-4 mb-3">
                    <label for="clabe" class="form-label">CLABE</label>
                    <input class="form-control" disabled type="text" id="clabe" name="clabe">
                </div>

                <div class="col-md-4 mb-3">
                    <label for="conceptoPago" class="form-label">Concepto del pago<span class="required"></span></label>
                    <input type="text" class="form-control" id="conceptoPago" name="conceptoPago" readonly>
                </div>

                <div class="col-md-4 mb-3">
                    <label for="eventDate" class="form-label">Fecha del evento<span class="required"></span></label>
                    <input class="form-control" type="date" id="eventDate" name="eventDate">
                </div>

                <div class="col-12 mt-4">
                    <div class="dropzone" id="documentDropzone"></div>
                </div>

                <!-- Apartado para documentos -->
                <div class="col-12 mt-4">
                    <h5>Lista de documentos</h5>
                    <ul id="listaDocumentos" class="list-group-ul">
                        <!-- Los documentos se listarán aquí -->
                    </ul>
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

<!-- Incluye Dropzone -->
<link href="assets/vendor/dropzone/dropzone.css" rel="stylesheet">
<script src="assets/vendor/dropzone/dropzone-min.js"></script>

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