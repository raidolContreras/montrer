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

            // Verifica si idUser existe y convierte la cadena JSON a un array
            if (response.idUser) {
                try {
                    const selectedUsers = JSON.parse(response.idUser); // Convierte "[66,67]" a [66,67]
                    // Limpia valores anteriores
                    $('#responsibleUser').val(null).trigger('change');
                    // Establece los valores y fuerza el renderizado de etiquetas
                    $('#responsibleUser').val(selectedUsers).trigger('change');
                } catch (error) {
                    console.error('Error al procesar idUser:', error);
                }
            }
        },
        error: function (error) {
            console.log('Error en la solicitud AJAX:', error);
        }
    });
}