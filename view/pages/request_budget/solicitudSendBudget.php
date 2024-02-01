<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    var $j = jQuery.noConflict();
</script>
<script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js"></script>
<!-- Start Main Content Area -->
<main class="main-content-wrap">

    <div class="card-box-style">
        <div class="others-title">
            <h3>Solicitud de Presupuesto</h3>
        </div>

        <form class="account-wrap" id="budgetRequestForm">
            <div class="row">

            <label for="adeudos">TIENE ADEUDOS POR COMPROBAR CON MAS DE 8 DIAS</label>
        <input type="radio" name="adeudos" value="SI"> SI
        <input type="radio" name="adeudos" value="NO"> NO

        <label for="nombreCompleto">Nombre completo solicitante</label>
        <input type="text" name="nombreCompleto" required>

        <label for="fechaSolicitud">Fecha de solicitud</label>
        <input type="date" name="fechaSolicitud" required>

        <label for="folioSolicitud">Folio de solicitud</label>
        <input type="text" name="folioSolicitud" required>

        <!-- Agrega más campos según tus necesidades -->

        <label for="proveedor">PROVEEDOR</label>
        <select name="proveedor">
            <!-- Opciones de proveedores -->
        </select>

        <label for="areaCargo">AREA DE CARGO</label>
        <select name="areaCargo">
            <!-- Opciones de departamentos -->
        </select>

        <!-- Agrega más campos según tus necesidades -->

        <label for="importeSolicitado">IMPORTE SOLICITADO</label>
        <input type="text" name="importeSolicitado" required>

        <label for="importeLetra">IMPORTE CON LETRA</label>
        <input type="text" name="importeLetra" required>

        <!-- Agrega más campos según tus necesidades -->

        <label for="formaPago">PAGO CON:</label>
        <input type="checkbox" name="cheque"> CHEQUE
        <input type="checkbox" name="transferencia"> TRANSFERENCIA

        <label for="chequeNombre">CHEQUE A NOMBRE DE</label>
        <input type="text" name="chequeNombre">

        <label for="titularCuenta">TITULAR DE LA CUENTA</label>
        <input type="text" name="titularCuenta">

        <label for="entidadBancaria">ENTIDAD BANCARIA</label>
        <input type="text" name="entidadBancaria">

        <!-- Agrega más campos según tus necesidades -->

        <label for="conceptoPago">CONCEPTO DEL PAGO</label>
        <input type="text" name="conceptoPago">

        <label for="anexaComprobante">ANEXA COMPROBANTE FISCAL</label>
        <input type="radio" name="anexaComprobante" value="SI"> SI
        <input type="radio" name="anexaComprobante" value="NO"> NO

        <!-- Agrega más campos según tus necesidades -->

        <label for="enviarSolicitud">ENVIAR SOLICITUD:</label>
        <select name="enviarSolicitud">
            <option value="SE ENVIO">SE ENVIO</option>
            <option value="NO ENVIADO">NO ENVIADO</option>
        </select>

        <label for="fechaEnvio">FECHA DE ENVIO</label>
        <input type="date" name="fechaEnvio">

        <label for="folioConfirmacion">FOLIO DE CONFIRMACION DE ENVIO DE LA SOLICITUD</label>
        <input type="text" name="folioConfirmacion">

        <input type="submit" value="Enviar Solicitud">
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
