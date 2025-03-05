// En tu script JavaScript
$(document).ready(function () {
    // Llama a la función para obtener el usuario con el valor de register
    getNextIdProvider();
});

function getNextIdProvider() {
    // Realiza la solicitud AJAX para obtener las áreas
    $.ajax({
        type: 'POST',
        url: 'controller/ajax/getNextIdProvider.php',
        dataType: 'json',
        success: function (response) {
            // var currentYear = new Date().getFullYear().toString().substr(2);
            providerKey = response.nextIdProvider;
            // providerKey += currentYear;
    
            $('#providerKey').val(providerKey);
        },
        error: function (error) {
            console.log('Error en la solicitud AJAX:', error);
        }
    });
}
