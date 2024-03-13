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
                            <label for="nombreCompleto" class="form-label">Nombre completo solicitante</label>
                            <input type="text" class="form-control" id="nombreCompleto" name="nombreCompleto" value="<?php echo $_SESSION['firstname'] . ' ' . $_SESSION['lastname'] ?>" readonly>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="fechaSolicitud" class="form-label">Fecha de solicitud</label>
                            <input type="date" class="form-control" id="fechaSolicitud" name="fechaSolicitud" readonly>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="provider" class="form-label">PROVEEDOR</label>
                            <select class="form-select" id="provider" name="provider">
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="area" class="form-label">AREA DE CARGO</label>
                            <select class="form-select" id="area" name="area">
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="importeSolicitado" class="form-label">IMPORTE SOLICITADO</label>
                            <input type="text" id="importeSolicitado" name="importeSolicitado" class="form-control inputmask" data-inputmask="'alias': 'currency', 'prefix': '$ ', 'placeholder': '0', 'autoUnmask': true, 'removeMaskOnSubmit': true">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="importeLetra" class="form-label">IMPORTE CON LETRA</label>
                            <input type="text" class="form-control" id="importeLetra" name="importeLetra" required>
                        </div>

                        <div class="col-12 mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="cheque" name="cheque">
                            <label class="form-check-label" for="cheque">CHEQUE</label>
                        </div>

                        <div class="col-12 mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="transferencia" name="transferencia">
                            <label class="form-check-label" for="transferencia">TRANSFERENCIA</label>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="chequeNombre" class="form-label">CHEQUE A NOMBRE DE</label>
                            <input type="text" class="form-control" id="chequeNombre" name="chequeNombre">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="titularCuenta" class="form-label">TITULAR DE LA CUENTA</label>
                            <input type="text" class="form-control" id="titularCuenta" name="titularCuenta">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="entidadBancaria" class="form-label">ENTIDAD BANCARIA</label>
                            <input type="text" class="form-control" id="entidadBancaria" name="entidadBancaria">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="conceptoPago" class="form-label">CONCEPTO DEL PAGO</label>
                            <input type="text" class="form-control" id="conceptoPago" name="conceptoPago">
                        </div>

                        <div class="col-12 mb-3 form-check">
                            <input type="radio" class="form-check-input" id="anexaComprobanteSI" name="anexaComprobante" value="SI">
                            <label class="form-check-label" for="anexaComprobanteSI">ANEXA COMPROBANTE FISCAL</label>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="enviarSolicitud" class="form-label">ENVIAR SOLICITUD:</label>
                            <select class="form-select" id="enviarSolicitud" name="enviarSolicitud">
                                <option value="SE ENVIO">SE ENVIO</option>
                                <option value="NO ENVIADO">NO ENVIADO</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="fechaEnvio" class="form-label">FECHA DE ENVIO</label>
                            <input type="date" class="form-control" id="fechaEnvio" name="fechaEnvio">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="folioConfirmacion" class="form-label">FOLIO DE CONFIRMACION DE ENVIO DE LA SOLICITUD</label>
                            <input type="text" class="form-control" id="folioConfirmacion" name="folioConfirmacion">
                        </div>

                        <div class="col-12 mt-2 text-end">
                            <a class="btn btn-danger" id="cancelButton">Cancelar</a>
                            <button type="submit" class="btn btn-success">Aceptar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
<script src="assets/js/ajax-js/request_provider.js"></script>