<div class="modal fade" id="completarModal" tabindex="-1" aria-labelledby="comprobarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="comprobarModalLabel">Completar presupuesto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                    <div class="card-box-style p-4 rounded shadow-sm bg-light">
                        <center class="others-title mb-4">
                            <h3 class="text-primary">SOLICITUD DE PAGO</h3>
                        </center>

                        <form class="account-wrap" id="budgetRequestForm">
                            <div class="row gy-3">

                                <!-- Solicitante -->
                                <div class="col-md-12 row mb-3" style="align-items: center;">
                                    <label for="solicitante" class="form-label col-2 fw-bold">Solicitante:<span class="required"></span></label>
                                    <div class="form-control d-flex justify-content-between align-items-center col bg-white border">
                                        <span id="solicitante_nombre"></span>
                                    </div>
                                    <input type="hidden" name="solicitante_nombre" value="">
                                    <input class="form-control col ms-2 auto-format" type="text" id="idEmployer" name="idEmployer" placeholder="1000-001-001-001" required>
                                </div>

                                <!-- Empresa -->
                                <div class="col-md-12 row mb-3" style="align-items: center;">
                                    <label for="empresa" class="form-label col-2 fw-bold">Empresa:<span class="required"></span></label>
                                    <input class="form-control col bg-white border" type="text" id="empresa" name="empresa" placeholder="" required>
                                </div>

                                <!-- Área de Cargo -->
                                <div class="col-md-12 row mb-3" style="align-items: center;">
                                    <label for="area" class="form-label col-2 fw-bold">Área de Cargo:<span class="required"></span></label>
                                    <input class="form-control col bg-white border" type="text" id="area" name="area" readonly>
                                    <input class="form-control col ms-2 auto-format2" type="text" id="idAreaCargo" name="idAreaCargo" placeholder="5000-001-000-000-000" required>
                                </div>

                                <!-- Cuenta que se afecta -->
                                <div class="col-md-12 row mb-3" style="align-items: center;">
                                    <label for="cuentaAfectada" class="form-label col-2 fw-bold">Cuenta que se afecta:<span class="required"></span></label>
                                    <input class="form-control col bg-white border" type="text" id="cuentaAfectada" name="cuentaAfectada" placeholder="Ejemplo: Ejemplo: Desfiles" required>
                                    <input class="form-control col ms-2 auto-format2" type="text" id="idCuentaAfectada" name="idCuentaAfectada" placeholder="5000-001-000-000-000" required>
                                </div>

                                <!-- Partida que se afecta -->
                                <div class="col-md-12 row mb-3" style="align-items: center;">
                                    <label for="partidaAfectada" class="form-label col-2 fw-bold">Partida que se afecta:<span class="required"></span></label>
                                    <input class="form-control col bg-white border" type="text" id="partidaAfectada" name="partidaAfectada" placeholder="Ejemplo: 16-sep" required>
                                    <input class="form-control col ms-2 auto-format2" type="text" id="idPartidaAfectada" name="idPartidaAfectada" placeholder="5000-001-000-000-000" required>
                                </div>

                                <!-- Concepto -->
                                <div class="col-md-12 row mb-3" style="align-items: center;">
                                    <label for="concepto" class="form-label col-2 fw-bold">Concepto:<span class="required"></span></label>
                                    <input class="form-control col bg-white border" type="text" id="concepto" name="concepto" placeholder="Ejemplo: Uniformes" required>
                                    <input class="form-control col ms-2 auto-format2" type="text" id="idConcepto" name="idConcepto" placeholder="5000-001-000-000-000" required>
                                </div>

                                <!-- Importe Solicitado -->
                                <div class="col-md-12 row mb-3" style="align-items: center;">
                                    <label for="requestedAmount" class="form-label col-2 fw-bold">Importe Solicitado ($):<span class="required"></span></label>
                                    <input type="text" id="requestedAmount" name="requestedAmount" class="form-control inputmask col bg-white border" data-inputmask="'alias': 'currency', 'prefix': '$ ', 'placeholder': '0', 'autoUnmask': true, 'removeMaskOnSubmit': true">
                                </div>

                                <!-- Importe con letra -->
                                <div class="col-md-12 row mb-3" style="align-items: center;">
                                    <label for="importeLetra" class="form-label col-2 fw-bold">Importe con letra:</label>
                                    <input type="text" id="importeLetra" name="importeLetra" class="form-control col bg-light border" required>
                                </div>

                                <!-- Fecha compromiso de pago -->
                                <div class="col-md-12 row mb-3" style="align-items: center;">
                                    <label for="fechaPago" class="form-label col-2 fw-bold">Fecha Compromiso de Pago:<span class="required"></span></label>
                                    <input class="form-control col bg-light border" type="date" id="fechaPago" name="fechaPago" required>
                                </div>

                                <!-- Proveedor -->
                                <div class="col-md-12 row mb-3" style="align-items: center;">
                                    <label for="provider" class="form-label col-2 fw-bold">Proveedor:<span class="required"></span></label>
                                    <select name="provider" id="provider" class="form-select form-control col" readonly>
                                        <option value="">Seleccionar proveedor</option>
                                    </select>
                                </div>

                                <!-- Clave interbancaria -->
                                <div class="col-md-12 row mb-3" style="align-items: center;">
                                    <label for="clabe" class="form-label col-2 fw-bold">Clave Interbancaria:</label>
                                    <input type="text" id="clabe" name="clabe" class="form-control col bg-light border" readonly>
                                </div>

                                <!-- Banco -->
                                <div class="col-md-12 row mb-3" style="align-items: center;">
                                    <label for="bank_name" class="form-label col-2 fw-bold">Banco:</label>
                                    <input type="text" id="bank_name" name="bank_name" class="form-control col bg-light border" readonly>
                                </div>

                                <!-- Numero de cuenta -->
                                <div class="col-md-12 row mb-3" style="align-items: center;">
                                    <label for="account_number" class="form-label col-2 fw-bold">Número de Cuenta:</label>
                                    <input type="text" id="account_number" name="account_number" class="form-control col bg-light border" readonly>
                                </div>

                                <div class="col-md-12 row mb-3 foreign-fields" style="display: none; align-items: center;">
                                    <label for="swiftCode" class="form-label col-2 fw-bold">Código ABA/SWIFT</label>
                                    <input type="text" class="form-control col bg-light border" id="swiftCode" name="swiftCode" readonly>
                                </div>
                                <div class="col-md-12 row mb-3 foreign-fields" style="display: none; align-items: center;">
                                    <label for="beneficiaryAddress" class="form-label col-2 fw-bold">Domicilio del beneficiario</label>
                                    <input type="text" class="form-control col bg-light border" id="beneficiaryAddress" name="beneficiaryAddress" readonly>
                                </div>
                                <div class="col-md-12 row mb-3 foreign-fields" style="display: none; align-items: center;">
                                    <label for="currencyType" class="form-label col-2 fw-bold">Tipo de divisa de la cuenta</label>
                                    <input type="text" class="form-control col bg-light border" id="currencyType" name="currencyType" readonly>
                                </div>

                                <!-- Concepto Póliza Contable -->
                                <div class="col-md-12 row mb-3" style="align-items: center;">
                                    <label for="conceptoPago" class="form-label col-2 fw-bold">Concepto de pago:<span class="required"></span></label>
                                    <input class="form-control col bg-white border" type="text" id="conceptoPago" name="conceptoPago" placeholder="Concepto de pago" required>
                                </div>

                                <!-- Folios consecutivos -->
                                <div class="col-md-12 row mb-3" style="align-items: center;">
                                    <label class="form-label col-2 fw-bold">Folio solicitud:</label>
                                    <span id="folio" class="form-control col bg-light border"></span>
                                    <input type="hidden" name="folio">
                                </div>
                                <input type="hidden" id="idRequest">
                                
                            </div>
                        </form>
                    </div>

                <div class="modal-footer marcar-footer">
                    <!-- Botones de Aceptar/Cancelar -->
                    <div class="col-md-12 row mt-4 text-end" style="align-items: center;">
                        <button class="btn btn-danger col-2 mx-3" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-success col-2 completeRequest">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

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