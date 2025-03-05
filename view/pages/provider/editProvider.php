<!-- Start Main Content Area -->
<main class="main-content-wrap">

    <div class="card-box-style">
        <div class="others-title">
            <h3>Actualizar proveedor</h3>
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
                    <input type="text" class="form-control" id="clabe" name="clabe" placeholder="xxx xxx xxxxxxxxxxx x">
                </div>

                <!-- Checkbox para identificar si el proveedor es extranjero -->
                <div class="col-md-6 mt-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="foreignProvider" name="foreignProvider">
                        <label class="form-check-label" for="foreignProvider">
                            ¿Proveedor extranjero?
                        </label>
                    </div>
                </div>
                <!-- Campos adicionales para proveedor extranjero -->
                <div class="col-12 mt-4 foreign-fields" style="display: none;">
                    <h4>Datos adicionales para proveedores extranjeros</h4>
                </div>

                <div class="col-md-6 foreign-fields" style="display: none;">
                    <label for="swiftCode" class="form-label">Código ABA/SWIFT</label>
                    <input type="text" class="form-control" id="swiftCode" name="swiftCode">
                </div>
                <div class="col-md-6 foreign-fields" style="display: none;">
                    <label for="beneficiaryAddress" class="form-label">Domicilio del beneficiario</label>
                    <input type="text" class="form-control" id="beneficiaryAddress" name="beneficiaryAddress">
                </div>
                <div class="col-md-6 foreign-fields" style="display: none;">
                    <label for="currencyType" class="form-label">Tipo de divisa de la cuenta</label>
                    <!-- <input type="text" class="form-control" id="currencyType" name="currencyType"> -->
                    <select id="currencyType" name="currencyType" class="form-select form-control">
                        <option value="" selected disabled>Seleccione una opción</option>
                        <option value="USD" data-icon="💵">💵 US$ - Dólar estadounidense</option>
                        <option value="CAD" data-icon="💵">💵 C$ - Dólar canadiense</option>
                        <option value="EUR" data-icon="💶">💶 € - Euro</option>
                        <option value="GBP" data-icon="💷">💷 £ - Libra esterlina</option>
                    </select>
                </div>

                <div class="col-12 mt-2 text-end">
                    <a class="btn btn-danger" id="cancelButton">Cancelar</a>
                    <button type="submit" class="btn btn-success">Aceptar</button>
                </div>
            </div>
        </form>
    </div>

</main>
<div id="register-value" data-register="<?php echo $_POST['register']; ?>"></div>
<!-- End Main Content Area -->
<script src="assets/js/ajax-js/get-provider.js"></script>
<script src="assets/js/ajax-js/edit-provider.js"></script>
<script>
    $(document).ready(function() {
        $('#clabe').on('input', function() {
            // Elimina cualquier carácter que no sea número
            let digits = $(this).val().replace(/\D/g, '');

            // Limita la cadena a 18 dígitos
            if (digits.length > 18) {
                digits = digits.substring(0, 18);
            }

            // Alinea los dígitos a la derecha rellenando con 'x' a la izquierda
            let padded = digits.padStart(18, '-');

            // Separamos en grupos: 3 dígitos, 3 dígitos, 11 dígitos y 1 dígito
            let group1 = padded.substring(0, 3);
            let group2 = padded.substring(3, 6);
            let group3 = padded.substring(6, 17);
            let group4 = padded.substring(17, 18);

            // Formamos el resultado con espacios intermedios
            let formatted = group1 + ' ' + group2 + ' ' + group3 + ' ' + group4;

            // Actualiza el valor del input con la máscara aplicada
            $(this).val(formatted);
        });
    });
</script>