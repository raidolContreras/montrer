<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    var $j = jQuery.noConflict();
</script>
<script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js"></script>
<!-- Start Main Content Area -->
<main class="main-content-wrap">
    <div class="card-box-style p-4 rounded shadow-sm bg-light">
        <center class="others-title mb-4">
            <h3 class="text-primary">EDICIÓN DEL PRESUPUESTO</h3>
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
                    <input class="form-control col ms-2" type="text" id="idEmployer" name="idEmployer" placeholder="1000-001-001-001" disabled>
                </div>

                <!-- Empresa -->
                <div class="col-md-12 row mb-3" style="align-items: center;">
                    <label for="empresa" class="form-label col-2 fw-bold">Empresa:<span class="required"></span></label>
                    <input class="form-control col bg-white border" type="text" id="empresa" name="empresa" placeholder="" required>
                </div>

                <!-- Área de Cargo -->
                <div class="col-md-12 row mb-3" style="align-items: center;">
                    <label for="area" class="form-label col-2 fw-bold">Área de Cargo:<span class="required"></span></label>
                    <select name="area" id="area" class="form-select form-control col" required>
                        <option value="">Seleccionar un área</option>
                    </select>
                    <input class="form-control col ms-2" type="text" id="idAreaCargo" name="idAreaCargo" placeholder="5000-001-000-000-000" disabled>
                </div>

                <!-- Cuenta que se afecta -->
                <div class="col-md-12 row mb-3" style="align-items: center;">
                    <label for="cuentaAfectada" class="form-label col-2 fw-bold">Cuenta que se afecta:<span class="required"></span></label>
                    <input class="form-control col bg-white border" type="text" id="cuentaAfectada" name="cuentaAfectada" placeholder="Ejemplo: Desfiles" required>
                    <input class="form-control col ms-2" type="text" id="idCuentaAfectada" name="idCuentaAfectada" placeholder="5000-001-000-000-000" disabled>
                </div>

                <!-- Partida que se afecta -->
                <div class="col-md-12 row mb-3" style="align-items: center;">
                    <label for="partidaAfectada" class="form-label col-2 fw-bold">Partida que se afecta:<span class="required"></span></label>
                    <input class="form-control col bg-white border" type="text" id="partidaAfectada" name="partidaAfectada" placeholder="Ejemplo: 16-sep" required>
                    <input class="form-control col ms-2" type="text" id="idPartidaAfectada" name="idPartidaAfectada" placeholder="5000-001-000-000-000" disabled>
                </div>

                <!-- Concepto -->
                <div class="col-md-12 row mb-3" style="align-items: center;">
                    <label for="concepto" class="form-label col-2 fw-bold">Concepto:<span class="required"></span></label>
                    <input class="form-control col bg-white border" type="text" id="concepto" name="concepto" placeholder="Ejemplo: Uniformes" required>
                    <input class="form-control col ms-2" type="text" id="idConcepto" name="idConcepto" placeholder="5000-001-000-000-000" disabled>
                </div>

                <!-- Importe Solicitado -->
                <div class="col-md-12 row mb-3" style="align-items: center;">
                    <label for="requestedAmount" class="form-label col-2 fw-bold">Importe Solicitado ($):<span class="required"></span></label>
                    <input type="text" id="requestedAmount" name="requestedAmount" class="form-control inputmask col bg-white border" data-inputmask="'alias': 'currency', 'prefix': '$ ', 'placeholder': '0', 'autoUnmask': true, 'removeMaskOnSubmit': true">
                </div>

                <!-- Fecha compromiso de pago -->
                <div class="col-md-12 row mb-3" style="align-items: center;">
                    <label for="fechaPago" class="form-label col-2 fw-bold">Fecha Compromiso de Pago:<span class="required"></span></label>
                    <input class="form-control col bg-white border" type="date" id="fechaPago" name="fechaPago" required>
                </div>

                <!-- Proveedor -->
                <div class="col-md-12 row mb-3" style="align-items: center;">
                    <label for="provider" class="form-label col-2 fw-bold">Proveedor:<span class="required"></span></label>
                    <select name="provider" id="provider" class="form-select form-control col" required>
                        <option value="">Seleccionar proveedor</option>
                    </select>
                </div>

                <!-- Adjuntar Comprobante Fiscal -->
                <div class="col-md-12 row mb-3" style="align-items: center;">
                    <label for="toggleDropzone" class="form-label col-2 fw-bold">Comprobante Fiscal (PDF/XML):</label>
                    <input type="checkbox" id="toggleDropzone" class="form-check-input ms-2">
                </div>

                <!-- Adjuntar Archivos -->
                <div class="col-md-12 row mb-3" id="dropzoneContainer" style="align-items: center;">
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
                                        <input class="form-control col ms-2" type="text" id="cuentaAfectadaCount" name="cuentaAfectadaCount" placeholder="5000-001-000-000-000" disabled>
                                    </td>
                                    <td>
                                        <input class="form-control col ms-2" type="text" id="polizeType" name="polizeType" placeholder="EG" disabled>
                                    </td>
                                    <td>
                                        <input class="form-control col ms-2" type="text" id="numberPolize" name="numberPolize" placeholder="Tipo de póliza" disabled>
                                    </td>
                                    <td>
                                        <input type="text" id="cargo" name="cargo" class="form-control inputmask col border" data-inputmask="'alias': 'currency', 'prefix': '$ ', 'placeholder': '0', 'autoUnmask': true, 'removeMaskOnSubmit': true" disabled>
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>
                                        <input class="form-control col ms-2" type="text" id="partidaAfectadaCount" name="partidaAfectadaCount" placeholder="1000-001-001-001" disabled>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <input type="text" id="abono" name="abono" class="form-control inputmask col border" data-inputmask="'alias': 'currency', 'prefix': '$ ', 'placeholder': '0', 'autoUnmask': true, 'removeMaskOnSubmit': true" disabled>
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

                <!-- Botones -->
                <div class="col-md-12 row mt-4 text-end" style="align-items: center;">
                    <a class="btn btn-outline-danger col-2 me-2" id="cancelButton">Cancelar</a>
                    <button type="submit" class="btn btn-success col-2">Aceptar</button>
                </div>
            </div>

            <!-- Campos Ocultos -->
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