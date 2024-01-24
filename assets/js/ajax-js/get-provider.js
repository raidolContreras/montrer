// En tu script JavaScript
$(document).ready(function () {
    // Obtén el valor de register desde el elemento HTML
    var registerValue = $('#register-value').data('register');

    // Llama a la función para obtener el proveedor con el valor de register
    getProvider(registerValue);
});

function getProvider(registerValue) {
    // Realiza la solicitud AJAX para obtener el proveedor
    $.ajax({
        type: 'POST',
        url: 'controller/ajax/getProvider.php',
        data: {'register': registerValue},
        dataType: 'json',
        success: function (response) {
                
            $('input[name="providerKey"]').val(response.provider_key);
            $('input[name="representativeName"]').val(response.representative_name);
            $('input[name="contactPhone"]').val(response.contact_phone);
            $('input[name="website"]').val(response.website);
            $('input[name="businessName"]').val(response.business_name);
            $('input[name="rfc"]').val(response.rfc);
            $('input[name="fiscalAddressStreet"]').val(response.fiscal_address_street);
            $('input[name="fiscalAddressColonia"]').val(response.fiscal_address_colonia);
            $('input[name="fiscalAddressMunicipio"]').val(response.fiscal_address_municipio);
            $('input[name="fiscalAddressEstado"]').val(response.fiscal_address_estado);
            $('input[name="fiscalAddressCP"]').val(response.fiscal_address_cp);
            $('input[name="bankName"]').val(response.bank_name);
            $('input[name="accountHolder"]').val(response.account_holder);
            $('input[name="accountNumber"]').val(response.account_number);
            $('input[name="clabe"]').val(response.clabe);

        },
        error: function (error) {
            console.log('Error en la solicitud AJAX:', error);
        }
    });
}
