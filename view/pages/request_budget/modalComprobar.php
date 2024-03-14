<div class="modal fade" id="comprobarModal" tabindex="-1" aria-labelledby="comprobarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="comprobarModalLabel">Comprobar presupuesto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="budgetRequestForm">
                    <div class="row p-3">

                        <div class="col-md-6 mb-3">
                            <label for="nombreCompleto" class="form-label">Nombre completo solicitante<span class="required"></span></label>
                            <input type="text" class="form-control" id="nombreCompleto" name="nombreCompleto" value="<?php echo $_SESSION['firstname'] . ' ' . $_SESSION['lastname'] ?>" readonly>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="fechaSolicitud" class="form-label">Fecha de solicitud<span class="required"></span></label>
                            <input type="date" class="form-control" id="fechaSolicitud" name="fechaSolicitud" readonly>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="provider" class="form-label">Proveedor<span class="required"></span></label>
                            <select class="form-select" id="provider" name="provider">
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="area" class="form-label">Area de cargo<span class="required"></span></label>
                            <select class="form-select" id="area" name="area">
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="importeSolicitado" class="form-label">Importe solicitado<span class="required"></span></label>
                            <input type="text" id="importeSolicitado" name="importeSolicitado" class="form-control inputmask" data-inputmask="'alias': 'currency', 'prefix': '$ ', 'placeholder': '0', 'autoUnmask': true, 'removeMaskOnSubmit': true" readonly>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="importeLetra" class="form-label">Importe con letra<span class="required"></span></label>
                            <input type="text" class="form-control" id="importeLetra" name="importeLetra" required>
                        </div>
                        <div class="card">
                            <label>Metodo de pago<span class="required"></span></label>
                            <div class="row mx-2 card-body">
                                <div class="col mb-3 form-check">
                                    <input type="radio" class="form-check-input" id="cheque" name="metodoDePago" value="cheque">
                                    <label class="form-check-label" for="cheque">Cheque</label>
                                </div>
                                <div class="col mb-3 form-check">
                                    <input type="radio" class="form-check-input" id="transferencia" name="metodoDePago" value="transferencia">
                                    <label class="form-check-label" for="transferencia">Transferencia</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="chequeNombre" class="form-label">Cheque a nombre de</label>
                            <input type="text" class="form-control" id="chequeNombre" name="chequeNombre" disabled>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="titularCuenta" class="form-label">Titular de la cuenta<span class="required"></span></label>
                            <input type="text" class="form-control" id="titularCuenta" name="titularCuenta">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="entidadBancaria" class="form-label">Entidad bancaria<span class="required"></span></label>
                            <input type="text" class="form-control" id="entidadBancaria" name="entidadBancaria">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="conceptoPago" class="form-label">Concepto del pago<span class="required"></span></label>
                            <input type="text" class="form-control" id="conceptoPago" name="conceptoPago">
                        </div>

                        <div class="col-12 my-3">
                            <label for="comprobanteDropzone" class="form-label">Anexar comprobante fiscal</label>
                            <div id="documentDropzone" class="dropzone"></div>
                        </div>

                        <div class="col-12 mt-2 text-end">
                            <a class="btn btn-danger" id="cancelButton">Cancelar</a>
                            <button type="submit" class="btn btn-success" onclick="enviarComprobante()">Aceptar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="assets/js/ajax-js/request_provider.js"></script>
<script src="assets/vendor/written-number/written-number.min.js"></script>

<!-- Incluye Dropzone -->
<link href="assets/vendor/dropzone/dropzone.css" rel="stylesheet">
<script src="assets/vendor/dropzone/dropzone-min.js"></script>
<script src="assets/js/ajax-js/add-comprovation.js"></script>
