<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    var $j = jQuery.noConflict();
</script>
<script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js"></script>
<style>
    option {
        background-color: white; 
    }
    .add-provider-option {
        background-color: #f0f0f0 !important; 
    }
</style>

<!-- Start Main Content Area -->
<main class="main-content-wrap">

    <div class="card-box-style">
        <center class="others-title">
            <h3>SOLICITUD DE PAGO</h3>
        </center>

        <div class="row">
            <div class="col-2">SOLICITANTE:</div>
            <div class="col-5"><?php echo $_SESSION['firstname'] . " " . $_SESSION['lastname'] ?></div>
            <div class="col-5">1000-001-005-007</div>
        </div>
        
        <div class="row">
            <div class="col-6">EMPRESA:</div>
            <div class="col-6">IMO</div>
        </div>
        
        <div class="row">
            <div class="col-2">ÁREA DE CARGO:</div>
            <div class="col-5">COORD LOGISTICA Y EVENTOS</div>
            <div class="col-5">5002-001-000-000-000</div>
        </div>

        <div class="row">
            <div class="col-2">CUENTA QUE SE AFECTA:</div>
            <div class="col-5">DESFILES</div>
            <div class="col-5">5002-001-001-000-000</div>
        </div>

        <div class="row">
            <div class="col-2">PARTIDA QUE SE AFECTA:</div>
            <div class="col-5">16-SEP</div>
            <div class="col-5">5002-001-001-001-000</div>
        </div>

        <div class="row">
            <div class="col-2">CONCEPTO:</div>
            <div class="col-5">UNIFORMES</div>
            <div class="col-5">5002-001-001-001-000</div>
        </div>
        
        <div class="row">
            <div class="col-2">IMPORTE SOLICITADO:</div>
            <div class="col-5">$70,000</div>
        </div>

        <div class="row">
            <div class="col-2">IMPORTE CON LETRA:</div>
            <div class="col-5">SETENTA MIL PESOS 00/100 M.N.</div>
        </div>

        <div class="row">
            <div class="col-2">FECHA COMPROMISO DE PAGO:</div>
            <div class="col-5">15/07/2024</div>
        </div>

        <div class="row">
            <div class="col-2">PROVEEDOR:</div>
            <div class="col-5">SUBURBIA S.A. DE C.V.</div>
        </div>

        <div class="row">
            <div class="col-2">CLAVE INTERBANCARIA:</div>
            <div class="col-5">XXXXXXXXXXXXXXXX</div>
        </div>

        <div class="row">
            <div class="col-2">BANCO:</div>
            <div class="col-5">SANTANDER</div>
        </div>

        <div class="row">
            <div class="col-2">CONCEPTO POLIZA CONTABLE:</div>
            <div class="col-5">Trnsf. Suburbia S.A. DE C.V. - DESFILES  - 16/09 - UNIFORMES</div>
        </div>

        <div class="row">
            <div class="col-2">ANEXA COMPROBANTE FISCAL:</div>
            <div class="col-5">SI (X)</div>
            <div class="col-5">NO ()</div>
        </div>

        <div class="row">
            <div class="col-2">ADJUNTA COMPROBANTE FISCAL:</div>
            <div class="col-10">
                <div class="dropzone" id="documentDropzone"></div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-3">ENVIAR SOLICITUD:</div>
            <div class="col-3">SE ENVIO SI (X) NO ()</div>
            <div class="col-3">FECHA DE ENVIO</div>
            <div class="col-3">12/12/2024</div>
        </div>
        
        <div class="row">
            <div class="col-2">FOLIO DE CONFIRMACIÓN DE ENVIO DE LA SOLICITUD:</div>
            <div class="col-5">XXXXX</div>
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
                    <select name="area" id="area" class="form-select form-control">
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
                
                <div class="col-12 mt-4">
                </div>
                
                <div class="col-12 mt-2 text-end">
                    <a class="btn btn-danger" id="cancelButton">Cancelar</a>
                    <button type="submit" class="btn btn-success">Aceptar</button>
                </div>
            </div>
            <input type="hidden" name="maxBudget">
            <input type="hidden" class="form-control" id="idBudget" name="idBudget" >
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