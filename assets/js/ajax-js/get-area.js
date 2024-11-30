// En tu script JavaScript
$(document).ready(function () {
    // Obtén el valor de register desde el elemento HTML
    var registerValue = $('#register-value').data('register');

    // Llama a la función para obtener el usuario con el valor de register
    getArea(registerValue);
});

function getArea(registerValue) {
    // Realiza la solicitud AJAX para obtener las áreas
    $.ajax({
        type: 'POST',
        url: 'controller/ajax/getArea.php',
        data: { 'register': registerValue }, // Agrega el valor de register a la solicitud
        dataType: 'json',
        success: function (response) {
            console.log('Respuesta del servidor:', response);
            if (response == false) {
                window.location.href = "registers";
            }

            // Rellena el formulario con los datos obtenidos
            $('input[name="areaName"]').val(response.nameArea);
            $('input[name="areaDescription"]').val(response.description);

            // Establece los valores seleccionados en el select2
            if (response.idUsers) {
                const selectedUsers = response.idUsers; // Array de IDs de usuarios
                $('#responsibleUser').val(selectedUsers).trigger('change'); // Selecciona los valores
            }
        },
        error: function (error) {
            console.log('Error en la solicitud AJAX:', error);
        }
    });
}