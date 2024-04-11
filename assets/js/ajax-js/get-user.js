// En tu script JavaScript
$(document).ready(function () {
    // Obtén el valor de register desde el elemento HTML
    var registerValue = $('#register-value').data('register');

    // Llama a la función para obtener el usuario con el valor de register
    getUser(registerValue);
});

function getUser(registerValue) {
    // Realiza la solicitud AJAX para obtener las áreas
    $.ajax({
        type: 'POST',
        url: 'controller/ajax/getUser.php',
        data: {'register': registerValue}, // Agrega el valor de register a la solicitud
        dataType: 'json',
        success: function (response) {
            console.log('Respuesta del servidor:', response);
            if (response == false) {
                window.location.href = "registers";
            }

            // Rellena el formulario con los datos obtenidos
            $('input[name="firstname"]').val(response.firstname);
            $('input[name="lastname"]').val(response.lastname);
            $('input[name="email"]').val(response.email);
            $('select[name="level"]').val(response.level); // Asumiendo que el campo se llama "level"
        },
        error: function (error) {
            console.log('Error en la solicitud AJAX:', error);
        }
    });
}
