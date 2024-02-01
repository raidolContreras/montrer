<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    var $j = jQuery.noConflict();
</script>
<script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js"></script>
<!-- Start Main Content Area -->
<main class="main-content-wrap">
<div class="card-box-style">
        <div class="others-title">
            <h3>Justificación de Presupuesto</h3>
        </div>
            <form id="budgetRequestForm">
            <div class="row">

                <!-- Agregar los campos del formulario aquí -->

                <div class="mb-3 form-check">
                    <input type="radio" class="form-check-input" name="adeudos" id="adeudosSI" value="SI">
                    <label class="form-check-label" for="adeudosSI">TIENE ADEUDOS POR COMPROBAR CON MAS DE 8 DIAS</label>
                </div>

                <div class="mb-3">
                    <label for="nombreCompleto" class="form-label">Nombre completo solicitante</label>
                    <input type="text" class="form-control" id="nombreCompleto" name="nombreCompleto" required>
                </div>

                <div class="mb-3">
                    <label for="fechaSolicitud" class="form-label">Fecha de solicitud</label>
                    <input type="date" class="form-control" id="fechaSolicitud" name="fechaSolicitud" required>
                </div>

                <!-- Agregar más campos según tus necesidades -->

                <div class="mb-3">
                    <label for="proveedor" class="form-label">PROVEEDOR</label>
                    <select class="form-select" id="proveedor" name="proveedor">
                        <!-- Opciones de proveedores -->
                    </select>
                </div>

                <div class="mb-3">
                    <label for="areaCargo" class="form-label">AREA DE CARGO</label>
                    <select class="form-select" id="areaCargo" name="areaCargo">
                        <!-- Opciones de departamentos -->
                    </select>
                </div>

                <!-- Agregar más campos según tus necesidades -->

                <div class="mb-3">
                    <label for="importeSolicitado" class="form-label">IMPORTE SOLICITADO</label>
                    <input type="text" class="form-control" id="importeSolicitado" name="importeSolicitado" required>
                </div>

                <div class="mb-3">
                    <label for="importeLetra" class="form-label">IMPORTE CON LETRA</label>
                    <input type="text" class="form-control" id="importeLetra" name="importeLetra" required>
                </div>

                <!-- Agregar más campos según tus necesidades -->

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="cheque" name="cheque">
                    <label class="form-check-label" for="cheque">CHEQUE</label>
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="transferencia" name="transferencia">
                    <label class="form-check-label" for="transferencia">TRANSFERENCIA</label>
                </div>

                <div class="mb-3">
                    <label for="chequeNombre" class="form-label">CHEQUE A NOMBRE DE</label>
                    <input type="text" class="form-control" id="chequeNombre" name="chequeNombre">
                </div>

                <div class="mb-3">
                    <label for="titularCuenta" class="form-label">TITULAR DE LA CUENTA</label>
                    <input type="text" class="form-control" id="titularCuenta" name="titularCuenta">
                </div>

                <div class="mb-3">
                    <label for="entidadBancaria" class="form-label">ENTIDAD BANCARIA</label>
                    <input type="text" class="form-control" id="entidadBancaria" name="entidadBancaria">
                </div>

                <!-- Agregar más campos según tus necesidades -->

                <div class="mb-3">
                    <label for="conceptoPago" class="form-label">CONCEPTO DEL PAGO</label>
                    <input type="text" class="form-control" id="conceptoPago" name="conceptoPago">
                </div>

                <div class="mb-3 form-check">
                    <input type="radio" class="form-check-input" id="anexaComprobanteSI" name="anexaComprobante" value="SI">
                    <label class="form-check-label" for="anexaComprobanteSI">ANEXA COMPROBANTE FISCAL</label>
                </div>

                <div class="mb-3">
                    <label for="enviarSolicitud" class="form-label">ENVIAR SOLICITUD:</label>
                    <select class="form-select" id="enviarSolicitud" name="enviarSolicitud">
                        <option value="SE ENVIO">SE ENVIO</option>
                        <option value="NO ENVIADO">NO ENVIADO</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="fechaEnvio" class="form-label">FECHA DE ENVIO</label>
                    <input type="date" class="form-control" id="fechaEnvio" name="fechaEnvio">
                </div>

                <div class="mb-3">
                    <label for="folioConfirmacion" class="form-label">FOLIO DE CONFIRMACION DE ENVIO DE LA SOLICITUD</label>
                    <input type="text" class="form-control" id="folioConfirmacion" name="folioConfirmacion">
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
        $j('.inputmask').inputmask();
    });
</script>
