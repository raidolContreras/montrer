<!-- Start Main Content Area -->
<main class="main-content-wrap">

    <div class="card-box-style">
        <div class="others-title">
            <h3>Registrar proveedor</h3>
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
                    <label for="representativeName" class="form-label">Nombre del representante<span class="required"></span></label>
                    <input type="text" class="form-control" id="representativeName" name="representativeName">
                </div>
                <div class="col-md-6">
                    <label for="contactPhone" class="form-label">Teléfono de contacto<span class="required"></span></label>
                    <input type="tel" class="form-control" id="contactPhone" name="contactPhone">
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label">Email<span class="required"></span></label>
                    <input type="email" class="form-control" id="email" name="email">
                </div>
                <div class="col-md-6">
                    <label for="website" class="form-label">Página web</label>
                    <input type="url" class="form-control" id="website" name="website">
                </div>
                <div class="col-md-6">
                    <label for="description" class="form-label">Describa el producto o servicio para este proveedor<span class="required"></span></label>
                    <input type="text" class="form-control" id="description" name="description">
                </div>
                <div class="col-md-6">
                    <label for="businessName" class="form-label">Razón social<span class="required"></span></label>
                    <input type="text" class="form-control" id="businessName" name="businessName">
                </div>
                <div class="col-md-6">
                    <label for="rfc" class="form-label">RFC<span class="required"></span></label>
                    <input type="text" class="form-control" id="rfc" name="rfc">
                </div>

                <div class="col-12 mt-4">
                    <h4>Dirección fiscal</h4>
                </div>

                <div class="col-md-6">
                    <label for="fiscalAddressStreet" class="form-label">Calle<span class="required"></span></label>
                    <input type="text" class="form-control" id="fiscalAddressStreet" name="fiscalAddressStreet">
                </div>

                <div class="col-md-6">
                    <label for="fiscalAddressColonia" class="form-label">Colonia<span class="required"></span></label>
                    <input type="text" class="form-control" id="fiscalAddressColonia" name="fiscalAddressColonia">
                </div>

                <div class="col-md-6">
                    <label for="fiscalAddressMunicipio" class="form-label">Municipio<span class="required"></span></label>
                    <input type="text" class="form-control" id="fiscalAddressMunicipio" name="fiscalAddressMunicipio">
                </div>

                <div class="col-md-6">
                    <label for="fiscalAddressEstado" class="form-label">Estado<span class="required"></span></label>
                    <input type="text" class="form-control" id="fiscalAddressEstado" name="fiscalAddressEstado">
                </div>

                <div class="col-md-6">
                    <label for="fiscalAddressCP" class="form-label">Código Postal<span class="required"></span></label>
                    <input type="text" class="form-control" id="fiscalAddressCP" name="fiscalAddressCP">
                </div>

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
                
                <div class="col-md-6">
                    <label for="cedula" class="form-label">Cédula fiscal<span class="required"></span></label>
                    <div class="dropzone cedula"></div>
                </div>

                <div class="col-md-6">
                    <label for="caratula" class="form-label">Caratula del estado de cuenta<span class="required"></span></label>
                    <div class="dropzone caratula"></div>
                </div>


                <div class="col-12 mt-2 text-end">
                    <a class="btn btn-danger" id="cancelButton">Cancelar</a>
                    <button type="submit" class="btn btn-success accept" disabled>Aceptar</button>
                </div>
            </div>
        </form>
    </div>

</main>
<!-- Incluye Dropzone -->
<link href="assets/vendor/dropzone/dropzone.css" rel="stylesheet">
<script src="assets/vendor/dropzone/dropzone-min.js"></script>
<script src="assets/js/ajax-js/add-provider.js"></script>
<script src="assets/js/ajax-js/get-nextIdProvider.js"></script>
