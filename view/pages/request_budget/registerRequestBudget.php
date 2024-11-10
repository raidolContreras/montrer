<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    var $j = jQuery.noConflict();
</script>
<script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js"></script>
<style>
    .form-label {
        font-weight: bold;
    }
    .required::after {
        content: " *";
        color: red;
    }
    
    option {
        background-color: white; 
    }
    .add-provider-option {
        background-color: #f0f0f0 !important; 
    }
</style>

<main class="main-content-wrap">
    <div class="card-box-style">
        <center class="others-title">
            <h3>SOLICITUD DE PAGO</h3>
        </center>

        <form class="account-wrap" id="budgetRequestForm">
            <div class="row">

                <!-- Solicitante -->
                <div class="col-md-6">
                    <label for="solicitante" class="form-label">Solicitante</label>
                    <input class="form-control" type="text" id="solicitante" name="solicitante"
                        value="<?php echo $_SESSION['firstname'] . ' ' . $_SESSION['lastname']; ?>" readonly>
                </div>

                <!-- Empresa -->
                <div class="col-md-6" id="empresa-container">
                    <label for="empresa" class="form-label">Empresa<span class="required"></span></label>
                </div>

                <!--  Área de Cargo -->
                <div class="col-md-6">
                    <label for="area" class="form-label">Área de Cargo<span class="required"></span></label>
                    <select name="area" id="area" class="form-select form-control">
                        <option value="">Seleccionar un área</option>
                    </select>
                </div>

                <!-- Cuenta que se afecta -->
                <div class="col-md-6">
                    <label for="cuentaAfectada" class="form-label">Cuenta que se afecta<span class="required"></span></label>
                    <select name="cuentaAfectada" id="cuentaAfectada" class="form-select form-control">
                        <option value="">Seleccionar cuenta</option>
                    </select>
                </div>

                <!-- Partida que se afecta -->
                <div class="col-md-6">
                    <label for="partidaAfectada" class="form-label">Partida que se afecta<span class="required"></span></label>
                    <input class="form-control" type="text" id="partidaAfectada" name="partidaAfectada" placeholder="Por ejemplo: 16-sep">
                </div>

                <!-- Concepto -->
                <div class="col-md-6">
                    <label for="concepto" class="form-label">Concepto<span class="required"></span></label>
                    <input class="form-control" type="text" id="concepto" name="concepto" placeholder="Uniformes, Desfiles, etc.">
                </div>

                <!-- Importe Solicitado -->
                <div class="col-md-6">
                    <label for="requestedAmount" class="form-label">Importe Solicitado ($)<span class="required"></span></label>
                    <input type="text" id="requestedAmount" name="requestedAmount" class="form-control inputmask" data-inputmask="'alias': 'currency', 'prefix': '$ ', 'placeholder': '0', 'autoUnmask': true, 'removeMaskOnSubmit': true"> 
                    <label class="requestMax">Presupuesto disponible para este mes: <span id="maxBudgetDisplay"></span></label>
                </div>

                <!-- Importe con letra -->
                <div class="col-md-6">
                    <label for="importeLetra" class="form-label">Importe con letra</label>
                    <input type="text" id="importeLetra" name="importeLetra" class="form-control" readonly>
                </div>

                <!-- Fecha compromiso de pago -->
                <div class="col-md-6">
                    <label for="fechaPago" class="form-label">Fecha Compromiso de Pago<span class="required"></span></label>
                    <input class="form-control" type="date" id="fechaPago" name="fechaPago">
                </div>

                <!-- Proveedor -->
                <div class="col-md-6">
                    <label for="provider" class="form-label">Proveedor<span class="required"></span></label>
                    <select name="provider" id="provider" class="form-select form-control">
                        <option value="">Seleccionar proveedor</option>
                    </select>
                    <input type="checkbox" id="proveedorInternacional" name="proveedorInternacional">
                    <label for="proveedorInternacional">No es nacional (requiere otros datos)</label>
                </div>

                <!-- Concepto Póliza Contable -->
                <div class="col-md-6">
                    <label for="conceptoPoliza" class="form-label">Concepto Póliza Contable</label>
                    <input class="form-control" type="text" id="conceptoPoliza" name="conceptoPoliza" readonly>
                </div>

                <!-- Adjuntar Archivos -->
                <div class="row my-3">
                    <div class="col-2">Anexa Comprobante Fiscal (PDF/XML):</div>
                    <div class="col-10">
                        <div class="dropzone" id="documentDropzone"></div>
                    </div>
                </div>

                <!-- Enviar Solicitud -->
                <!-- <div class="col-md-6">
                    <label for="enviarSolicitud" class="form-label">Enviar Solicitud</label>
                    <input type="checkbox" id="enviarSolicitud" name="enviarSolicitud">
                    <label for="enviarSolicitud">Se envió</label>
                    <input class="form-control mt-2" type="date" id="fechaEnvio" name="fechaEnvio">
                </div> -->

                <!-- Folios consecutivos -->
                <div class="col-md-6">
                    <label for="folio" class="form-label">Folio de envío de la solicitud</label>
                    <input class="form-control" type="text" id="folio" name="folio" readonly>
                </div>

                <!-- Botones de Aceptar/Cancelar -->
                <div class="col-12 mt-4 text-end">
                    <a class="btn btn-danger" id="cancelButton">Cancelar</a>
                    <button type="submit" class="btn btn-success">Aceptar</button>
                </div>
            </div>

            <!-- Campos Ocultos -->
            <input type="hidden" name="maxBudget" id="maxBudget">
            <input type="hidden" class="form-control" id="idBudget" name="idBudget">
            <input type="hidden" name="budget">
        </form>
    </div>
</main>
<div id="register-value" data-register="<?php echo $_SESSION['idUser']; ?>"></div>

<!-- End Main Content Area -->
<!-- Incluye Dropzone -->
<link href="assets/vendor/dropzone/dropzone.css" rel="stylesheet">
<script src="assets/vendor/dropzone/dropzone-min.js"></script>

<script src="assets/js/ajax-js/add-budget-request.js"></script>
<script src="assets/js/ajax-js/request_provider.js"></script>
<script src="assets/js/ajax-js/add-provider2.js"></script>

<script>
    $j(document).ready(function() {
        $j('.inputmask').inputmask();
    });
</script>

<?php
include 'view/pages/request_budget/modalProvider.php';