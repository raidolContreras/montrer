// En tu script JavaScript
$(document).ready(function () {
    // Obtén el valor de register desde el elemento HTML
    var registerValue = $('#register-value').data('register');

    // Llama a la función para obtener el proveedor con el valor de register
    getProvider(registerValue);

    // Muestra u oculta los campos adicionales si el proveedor es extranjero
    $('#foreignProvider').change(function () {
        changeCheck();
    });
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
            $('input[name="email"]').val(response.email);
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
            $('input[name="description"]').val(response.description);

            if (isNaN(response.swiftCode)) {
                $('#swiftCode').val(response.swiftCode);
                $('#beneficiaryAddress').val(response.beneficiaryAddress);
                $('#currencyType').val(response.currencyType);
                // checkear $('#foreignProvider')
                $('#foreignProvider').prop('checked', true);
                changeCheck(); // Llama a la función para mostrar u ocultar los campos adicionales
            }

        },
        error: function (error) {
            console.log('Error en la solicitud AJAX:', error);
        }
    });
}

// funcion cambiar el check
function changeCheck() {
    if ($('#foreignProvider').is(':checked')) {
        $('.foreign-fields').show(); // Muestra los campos adicionales
        extrangero = true;
    } else {
        $('.foreign-fields').hide(); // Oculta los campos adicionales
        extrangero = false;
    }
}