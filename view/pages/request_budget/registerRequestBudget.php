<style>
    .form-check-input {
        height: 1.6em;
        background-color: #dfdfdf;
        border: var(--bs-border-width) solid #5d5d5d;
    }
</style>
<main class="main-content-wrap">
    <div class="card-box-style p-4 rounded shadow-sm bg-light">
        <center class="others-title mb-4 row">
            <h3 class="text-primary col-9">SOLICITUD DE PAGO</h3>
                <!-- Fecha de solicitud -->
                <div class="col row mb-3" style="align-items: center;">
                    <input type="date" id="fechaSolicitud" name="fechaSolicitud" class="form-control col bg-light border" value="<?php echo date('Y-m-d'); ?>" readonly>
                </div>
        </center>

        <form class="account-wrap" id="budgetRequestForm">
            <div class="row gy-3">

                <!-- Solicitante -->
                <div class="col-md-12 row mb-3" style="align-items: center;">
                    <label for="solicitante" class="form-label col-2 fw-bold">Solicitante:<span class="required"></span></label>
                    <div class="form-control d-flex justify-content-between align-items-center col bg-white border">
                        <span><?php echo $_SESSION['firstname'] . ' ' . $_SESSION['lastname']; ?></span>
                    </div>
                    <input type="hidden" name="solicitante_nombre" value="<?php echo $_SESSION['firstname'] . ' ' . $_SESSION['lastname']; ?>">
                    <input class="form-control col" type="text" id="idEmployer" name="idEmployer" placeholder="1000-001-001-001" value="<?php echo $_SESSION['employerCode']; ?>" disabled>
                </div>

                <!-- Empresa -->
                <div class="col-md-12 row mb-3" style="align-items: center;">
                    <label for="empresa" class="form-label col-2 fw-bold">Empresa:</label>
                    <input class="form-control col" type="text" id="empresa" name="empresa" placeholder="" disabled>
                </div>

                <!-- Área de Cargo -->
                <div class="col-md-12 row mb-3" style="align-items: center;">
                    <label for="area" class="form-label col-2 fw-bold">Área de cargo:<span class="required"></span></label>
                    <select name="area" id="area" class="form-select form-control col" required>
                        <option value="">Seleccionar un área</option>
                    </select>
                    <input class="form-control col" type="text" id="idAreaCargo" name="idAreaCargo" placeholder="" disabled>
                </div>

                <!-- Cuenta que se afecta -->
                <div class="col-md-12 row mb-3" style="align-items: center;">
                    <label for="cuentaAfectada" class="form-label col-2 fw-bold">Cuenta que se afecta:<span class="required"></span></label>
                    <select id="cuentaAfectada" name="cuentaAfectada" class="form-select form-control col" disabled>
                        <option value="">Seleccionar cuenta</option>
                    </select>
                    <input class="form-control col" type="text" id="idCuentaAfectada" name="idCuentaAfectada" placeholder="" disabled>
                </div>

                <!-- Partida que se afecta -->
                <div class="col-md-12 row mb-3" style="align-items: center;">
                    <label for="partidaAfectada" class="form-label col-2 fw-bold">Partida que se afecta:<span class="required"></span></label>
                    <select id="partidaAfectada" name="partidaAfectada" class="form-select form-control col" disabled>
                        <option value="">Seleccionar partida</option>
                    </select>
                    <input class="form-control col" type="text" id="idPartidaAfectada" name="idPartidaAfectada" placeholder="" disabled>
                </div>

                <!-- Concepto -->
                <div class="col-md-12 row mb-3" style="align-items: center;">
                    <label for="concepto" class="form-label col-2 fw-bold">Concepto:></span></label>
                    <select id="concepto" name="concepto" class="form-select form-control col" disabled>
                        <option value="">Seleccionar concepto</option>
                    </select>
                    <input class="form-control col" type="text" id="idConcepto" name="idConcepto" placeholder="" disabled>
                </div>

                <!-- Proveedor -->
                <div class="col-md-12 row mb-3" style="align-items: center;">
                    <label for="provider" class="form-label col-2 fw-bold">Proveedor:<span class="required"></span></label>
                    <select name="provider" id="provider" class="form-select form-control col" required>
                        <option value="">Seleccionar proveedor</option>
                    </select>
                </div>

                <!-- Importe Solicitado -->
                <div class="col-md-12 row mb-3" style="align-items: center;">
                    <label for="requestedAmount" class="form-label col-2 fw-bold">
                        Importe solicitado (<span class="currency">$</span>):
                        <span class="required"></span>
                    </label>
                    <div class="input-group col px-0">
                        <span class="input-group-text bg-white border currency-symbol">$</span>
                        <input type="text" id="requestedAmount" name="requestedAmount" 
                            class="form-control inputmask bg-white border"
                            data-inputmask="'alias': 'currency', 'prefix': '', 'placeholder': '0', 'autoUnmask': true, 'removeMaskOnSubmit': true">
                    </div>
                </div>


                <!-- Importe con letra -->
                <div class="col-md-12 row mb-3" style="align-items: center;">
                    <label for="importeLetra" class="form-label col-2 fw-bold">Importe con letra:<span class="required"></span></label>
                    <input type="text" id="importeLetra" name="importeLetra" class="form-control col" disabled>
                </div>

                <!-- Favor de pagar en -->
                <div class="col-md-12 row mb-3" style="align-items: center;">
                    <label for="fechaPago" class="form-label col-2 fw-bold">Favor de pagar en:<span class="required"></span></label>
                    <input class="form-control col bg-white border" type="date" id="fechaPago" name="fechaPago" required>
                </div>


                <!-- Clave interbancaria -->
                 <div class="col-md-12 row mb-3 clabe" style="align-items: center;">
                    <label for="clabe" class="form-label col-2 fw-bold">Clabe interbancaria:</label>
                    <input type="text" id="clabe" name="clabe" class="form-control col border" disabled>
                </div>

                <!-- Banco -->
                 <div class="col-md-12 row mb-3" style="align-items: center;">
                    <label for="bank_name" class="form-label col-2 fw-bold">Banco:</label>
                    <input type="text" id="bank_name" name="bank_name" class="form-control col border" disabled>
                </div>

                <!-- Numero de cuenta -->
                <div class="col-md-12 row mb-3" style="align-items: center;">
                    <label for="account_number" class="form-label col-2 fw-bold">Número de cuenta:</label>
                    <input type="text" id="account_number" name="account_number" class="form-control col border" disabled>
                </div>

                <div class="col-md-12 row mb-3 foreign-fields" style="display: none; align-items: center;">
                    <label for="swiftCode" class="form-label col-2 fw-bold">Código ABA/SWIFT</label>
                    <input type="text" class="form-control col border" id="swiftCode" name="swiftCode" disabled>
                </div>
                <div class="col-md-12 row mb-3 foreign-fields" style="display: none; align-items: center;">
                    <label for="beneficiaryAddress" class="form-label col-2 fw-bold">Domicilio del beneficiario</label>
                    <input type="text" class="form-control col border" id="beneficiaryAddress" name="beneficiaryAddress" disabled>
                </div>
                <div class="col-md-12 row mb-3 foreign-fields" style="display: none; align-items: center;">
                    <label for="currencyType" class="form-label col-2 fw-bold">Tipo de divisa de la cuenta</label>
                    <input type="text" class="form-control col border" id="currencyType" name="currencyType" disabled>
                </div>

                <!-- Concepto Póliza Contable -->
                <div class="col-md-12 row mb-3" style="align-items: center;">
                    <label for="conceptoPago" class="form-label col-2 fw-bold">Concepto de pago:<span class="required"></span></label>
                    <input class="form-control col bg-white border" type="text" id="conceptoPago" name="conceptoPago" placeholder="Concepto de pago" required>
                </div>

                <!-- Adjuntar Comprobante Fiscal -->
                <div class="col-md-12 row mb-3" style="align-items: center;">
                    <label for="toggleDropzone" class="form-label col-2 fw-bold">Comprobante fiscal (PDF/XML):</label>
                    <input type="checkbox" id="toggleDropzone" class="form-check-input ms-2">
                </div>

                <!-- Adjuntar Archivos -->
                <div class="col-md-12 row mb-3" id="dropzoneContainer" style="display: none; align-items: center;">
                    <div class="col">
                        <div class="dropzone" id="documentDropzone"></div>
                    </div>
                </div>

                <!-- Folios consecutivos -->
                <div class="col-md-12 row mb-3" style="align-items: center;">
                    <label class="form-label col-2 fw-bold">Folio solicitud:</label>
                    <span id="folio" class="form-control col bg-light border"></span>
                    <input type="hidden" name="folio">
                </div>

                <div class="container my-5">
                    <div class="form-container">
                        <div class="form-header text-center">
                            SECCIÓN A CARGO DE CONTABILIDAD Y BANCOS:
                        </div>
                        <table class="table table-bordered text-center" style="border-collapse: separate; border-spacing: 0; width: 100%;">
                            <thead>
                                <!-- Encabezados agrupados -->
                                <tr style="background-color: #d9e2ec; font-weight: bold;">
                                    <th>CONTABILIZADO CON PÓLIZA</th>
                                    <th rowspan="2">DETALLES DE LA PÓLIZA</th>
                                    <th rowspan="2">TIPO DE PÓLIZA</th>
                                    <th rowspan="2">CARGO</th>
                                    <th rowspan="2">ABONO</th>
                                </tr>
                                <tr style="background-color: #d9e2ec; font-weight: bold;">
                                    <th>CUENTA QUE SE AFECTA</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <input class="form-control col" type="text" id="cuentaAfectadaCount" name="cuentaAfectadaCount" placeholder="5000-001-000-000-000" disabled>
                                    </td>
                                    <td>
                                        <input class="form-control col" type="text" id="polizeType" name="polizeType" placeholder="EG" disabled>
                                    </td>
                                    <td>
                                        <input class="form-control col" type="text" id="numberPolize" name="numberPolize" placeholder="Tipo de póliza" disabled>
                                    </td>
                                    <td>
                                        <div class="input-group col px-0">
                                            <span class="input-group-text bg-white border currency-symbol">$</span>
                                            <input type="text" id="cargo" name="cargo" class="form-control inputmask col border" data-inputmask="'alias': 'currency', 'prefix': '', 'placeholder': '0', 'autoUnmask': true, 'removeMaskOnSubmit': true" disabled>
                                        </div>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>
                                        <input class="form-control col" type="text" id="partidaAfectadaCount" name="partidaAfectadaCount" placeholder="1000-001-001-001" disabled>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <div class="input-group col px-0">
                                            <span class="input-group-text bg-white border currency-symbol">$</span>
                                            <input type="text" id="abono" name="abono" class="form-control inputmask col border" data-inputmask="'alias': 'currency', 'prefix': '', 'placeholder': '0', 'autoUnmask': true, 'removeMaskOnSubmit': true" disabled>
                                        </div>
                                    </td>
                                </tr>
                                <tr style="background-color: #d9e2ec; font-weight: bold;">
                                    <td>
                                        ESTATUS:
                                    </td>
                                        <td colspan="2">
                                            <select id="estatus" name="estatus" class="form-select col border" disabled>
                                                <option value="pendiente_de_pago">Pendiente de pago</option>
                                                <option value="denegado">Denegado</option>
                                                <option value="pagado">Pagado</option>
                                            </select>
                                    </td>
                                        <td>FECHA DE CARGO</td>
                                        <td>
                                        <input class="form-control col border" type="date" id="fechaCarga" name="fechaCarga" disabled>
                                        </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Botones de Aceptar/Cancelar -->
                <div class="col-md-12 row mt-4 text-end" style="align-items: center;">
                    <a class="btn btn-outline-danger col-2 me-2" id="cancelButton">Cancelar</a>
                    <button type="submit" class="btn btn-success col-2">Aceptar</button>
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


<!-- Modal de Presupuesto Disponible -->
<div class="modal fade" id="availableBudgetModal" tabindex="-1" aria-labelledby="availableBudgetModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary" id="availableBudgetModalLabel">Presupuesto disponible</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>El presupuesto disponible para este mes es:</p>
                <p class="fw-bold text-success" id="modalBudgetDisplay">$<span id="maxBudgetDisplay"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<?php
include 'view/pages/request_budget/modalProvider.php';
?>


<!-- End Main Content Area -->
<!-- Incluye Dropzone -->
<link href="assets/vendor/dropzone/dropzone.css" rel="stylesheet">
<script src="assets/vendor/dropzone/dropzone-min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    var $j = jQuery.noConflict();
</script>
<script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js"></script>
<script>
    $j(document).ready(function() {
        $j('.inputmask').inputmask();
    });
</script>
<script src="assets/js/ajax-js/add-budget-request.js"></script>
<script src="assets/js/ajax-js/request_provider.js"></script>
<script src="assets/js/ajax-js/add-provider2.js"></script>