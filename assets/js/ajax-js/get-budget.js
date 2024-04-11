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
        url: 'controller/ajax/getBudget.php',
        data: {'register': registerValue}, // Agrega el valor de register a la solicitud
        dataType: 'json',
        success: function (response) {
            if (response == false) {
                window.location.href = "registers";
            }

            // Rellena el formulario con los datos obtenidos
            $('select[name="area"]').val(response.idArea);
            $('input[name="AuthorizedAmount"]').val(response.AuthorizedAmount);
            $('select[name="exercise"]').val(response.idExercise);
        },
        error: function (error) {
            console.log('Error en la solicitud AJAX:', error);
        }
    });
}
