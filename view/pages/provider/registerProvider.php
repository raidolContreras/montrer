<!-- Start Main Content Area -->
<main class="main-content-wrap">

    <div class="card-box-style">
        <div class="others-title">
            <h3>Registrar ejercicio</h3>
        </div>

        <form class="account-wrap" id="companyForm">
            <div class="row">

                <!-- Sección de Proveedores -->
                <div class="col-12 mt-4">
                    <h4>Proveedor</h4>
                </div>

                <div class="col-md-6">
                    <label for="providerKey" class="form-label">Clave del proveedor</label>
                    <input type="text" class="form-control" id="providerKey" name="providerKey" readonly>
                </div>
                <div class="col-md-6">
                    <label for="representativeName" class="form-label">Nombre del representante del proveedor<span class="required"></span></label>
                    <input type="text" class="form-control" id="representativeName" name="representativeName">
                </div>
                <div class="col-md-6">
                    <label for="contactPhone" class="form-label">Teléfono de contacto<span class="required"></span></label>
                    <input type="tel" class="form-control" id="contactPhone" name="contactPhone">
                </div>
                <div class="col-md-6">
                    <label for="website" class="form-label">Página web</label>
                    <input type="url" class="form-control" id="website" name="website">
                </div>
                <div class="col-md-6">
                    <label for="businessName" class="form-label">Razón social del proveedor<span class="required"></span></label>
                    <input type="text" class="form-control" id="businessName" name="businessName">
                </div>
                <div class="col-md-6">
                    <label for="rfc" class="form-label">RFC<span class="required"></span></label>
                    <input type="text" class="form-control" id="rfc" name="rfc">
                </div>
                <div class="col-md-6">
                    <label for="fiscalAddress" class="form-label">Dirección fiscal: Calle<span class="required"></span></label>
                    <input type="text" class="form-control" id="fiscalAddress" name="fiscalAddress">
                </div>
                <!-- ... Otros campos de dirección fiscal ... -->

                <div class="col-12 mt-4">
                    <h4>Datos bancarios</h4>
                </div>
                <div class="col-md-6">
                    <label for="bankName" class="form-label">Nombre de entidad bancaria<span class="required"></span></label>
                    <input type="text" class="form-control" id="bankName" name="bankName">
                </div>
                <div class="col-md-6">
                    <label for="accountHolder" class="form-label">Titular de la cuenta<span class="required"></span></label>
                    <input type="text" class="form-control" id="accountHolder" name="accountHolder">
                </div>
                <div class="col-md-6">
                    <label for="accountNumber" class="form-label">Número de cuenta<span class="required"></span></label>
                    <input type="text" class="form-control" id="accountNumber" name="accountNumber">
                </div>
                <div class="col-md-6">
                    <label for="clabe" class="form-label">CLABE interbancaria</label>
                    <input type="text" class="form-control" id="clabe" name="clabe">
                </div>

                <!-- ... Otros campos existentes ... -->

                <div class="col-12 mt-2 text-end">
                    <a href="provider" class="btn btn-danger">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Registrar ejercicio</button>
                </div>
            </div>
        </form>
    </div>

</main>
<!-- End Main Content Area -->
<script src="assets/js/ajax-js/add-provider.js"></script>
<script src="assets/js/ajax-js/get-nextIdProvider.js"></script>
<script src="assets/js/sweetalert2.all.min.js"></script>