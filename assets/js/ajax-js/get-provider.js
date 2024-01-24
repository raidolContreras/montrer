// En tu script JavaScript
$(document).ready(function () {
    // Obtén el valor de register desde el elemento HTML
    var registerValue = $('#register-value').data('register');

    // Llama a la función para obtener el usuario con el valor de register
    getProvider(registerValue);
});

function getProvider(registerValue) {
    // Realiza la solicitud AJAX para obtener las áreas
    $.ajax({
        type: 'POST',
        url: 'controller/ajax/getProvider.php',
        data: {'register': registerValue}, // Agrega el valor de register a la solicitud
        dataType: 'json',
        success: function (response) {
            console.log('Respuesta del servidor:', response);

            // Rellena el formulario con los datos obtenidos
            $('input[name="providerKey"]').val(response.provider_key);
            $('input[name="representativeName"]').val(response.representative_name);
            $('input[name="contactPhone"]').val(response.contact_phone);
            $('input[name="website"]').val(response.website);
            $('input[name="businessName"]').val(response.businessName);
            $('input[name="rfc"]').val(response.rfc);
            $('input[name="fiscalAddressStreet"]').val(response.fiscalAddressStreet);
            $('input[name="fiscalAddressColonia"]').val(response.fiscalAddressColonia);
            $('input[name="fiscalAddressMunicipio"]').val(response.fiscalAddressMunicipio);
            $('input[name="fiscalAddressEstado"]').val(response.fiscalAddressEstado);
            $('input[name="fiscalAddressCP"]').val(response.fiscalAddressCP);
            $('input[name="bankName"]').val(response.bankName);
            $('input[name="accountHolder"]').val(response.accountHolder);
            $('input[name="accountNumber"]').val(response.accountNumber);
            $('input[name="clabe"]').val(response.clabe);
        },
        error: function (error) {
            console.log('Error en la solicitud AJAX:', error);
        }
    });
}
