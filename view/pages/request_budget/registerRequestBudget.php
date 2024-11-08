<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js"></script>
<style>
    .form-label {
        font-weight: bold;
    }
    .required::after {
        content: " *";
        color: red;
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
                <div class="col-md-6">
                    <label for="empresa" class="form-label">Empresa<span class="required"></span></label>
                    <select name="empresa" id="empresa" class="form-select form-control">
                        <!-- Empresas en las que trabaja el usuario -->
                        <option value="">Seleccionar empresa</option>
                    </select>
                </div>

                <!-- Área de Cargo -->
                <div class="col-md-6">
                    <label for="areaCargo" class="form-label">Área de Cargo<span class="required"></span></label>
                    <select name="areaCargo" id="areaCargo" class="form-select form-control">
                        <option value="">Seleccionar área de cargo</option>
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
                <div class="row">
                    <div class="col-2">Anexa Comprobante Fiscal (PDF/XML):</div>
                    <div class="col-10">
                        <div class="dropzone" id="documentDropzone"></div>
                    </div>
                </div>

                <!-- Enviar Solicitud -->
                <div class="col-md-6">
                    <label for="enviarSolicitud" class="form-label">Enviar Solicitud</label>
                    <input type="checkbox" id="enviarSolicitud" name="enviarSolicitud">
                    <label for="enviarSolicitud">Se envió</label>
                    <input class="form-control mt-2" type="date" id="fechaEnvio" name="fechaEnvio">
                </div>

                <!-- Folios consecutivos -->
                <div class="col-md-6">
                    <label for="folioConsecutivo" class="form-label">Folio de Confirmación de Envío de la Solicitud</label>
                    <input type="text" id="folioConsecutivo" name="folioConsecutivo" class="form-control" readonly>
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

<script>
    $(document).ready(function() {
        // Inicializar Input Mask para el campo de presupuesto
        $j('.inputmask').inputmask();

        // Presupuesto Disponible
        $('#requestedAmount').focus(function() {
            // Mostrar el presupuesto máximo disponible en un alert o en el label correspondiente
            let maxBudget = $('#maxBudget').val();
            alert("Presupuesto disponible para este mes: " + maxBudget);
        });

        // Conversión del Importe Solicitado a Letra
        $('#requestedAmount').change(function() {
            let importe = $(this).val();
            $('#importeLetra').val(convertirNumeroALetras(importe));
        });

        // Fecha de compromiso de pago: lógica según el día de la semana
        $('#fechaPago').change(function() {
            let selectedDate = new Date($(this).val());
            let day = selectedDate.getDay(); // 0 - Domingo, 6 - Sábado

            if (day === 1 || day === 2 || day === 3) {
                alert('El pago se realizará el viernes de esa misma semana.');
            } else if (day === 4 || day === 5) {
                alert('El pago se realizará el próximo viernes.');
            }
        });
    });

    // Función para convertir número a letras (simplificado para fines de demostración)
    function convertirNumeroALetras(numero) {
        // Aquí podrías implementar una función más completa para convertir números a letras
        return "Setenta mil pesos";
    }
</script>

<?php
include 'view/pages/request_budget/modalProvider.php';