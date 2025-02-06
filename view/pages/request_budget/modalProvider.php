
<div class="modal fade" id="modalAgregarProveedor" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalAgregarProveedorLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalAgregarProveedorLabel">Añadir proveedor</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="restartSelectProvider()"></button>
      </div>
      <div class="modal-body">

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
                    <input type="text" class="form-control" id="clabe" name="clabe">
                </div>
                <div class="col-md-6">
                    <label for="description" class="form-label">Describa el producto o servicio para este proveedor<span class="required"></span></label>
                    <input type="text" class="form-control" id="description" name="description">
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
                    <select id="currencyType" name="currencyType" class="form-select form-control">
                        <option value="" selected disabled>Seleccione una opción</option>
                        <option value="USD" data-icon="💵">💵 US$ - Dólar estadounidense</option>
                        <option value="CAD" data-icon="💵">💵 C$ - Dólar canadiense</option>
                        <option value="EUR" data-icon="💶">💶 € - Euro</option>
                        <option value="GBP" data-icon="💷">💷 £ - Libra esterlina</option>
                    </select>
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="restartSelectProvider()">Cancelar</button>
        <button type="button" class="btn btn-success" id="addProvider" onclick="sendForm()" >Aceptar</button>
      </div>
    </div>
  </div>
</div>
<script src="assets/js/ajax-js/get-nextIdProvider.js"></script>