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
        data: { 'register': registerValue }, // Agrega el valor de register a la solicitud
        dataType: 'json',
        success: function (response) {
            if (response == false) {
                window.location.href = "registers";
            }

            // Rellena el formulario con los datos obtenidos
            $('select[name="area"]').val(response.idArea);
            $('input[name="AuthorizedAmount"]').val(response.AuthorizedAmount);
            $('#Amount').val(response.AuthorizedAmount);
            $('select[name="exercise"]').val(response.idExercise);
            getPartidas(response.idArea, response.idPartida);
            
            //bloquear area y ejercicio 
            $('#area').prop('disabled', true);
            $('#exercise').prop('disabled', true);
        },
        error: function (error) {
            console.log('Error en la solicitud AJAX:', error);
        }
    });
}

function getPartidas(idArea, idPartida) {
    // Realiza la solicitud AJAX para obtener las partidas de un área
    $.ajax({
        type: 'POST',
        url: 'controller/ajax/ajax.form.php',
        data: { 'action': 'getPartidas', 'idAreaToPartidas': idArea }, // Agrega el id de área a la solicitud
        dataType: 'json',
        success: function (response) {
            // Rellena el select de partidas con los datos obtenidos
            var selectPartidas = $('#partidas');
            selectPartidas.empty();
            response.forEach(function (partida) {
                var option = $('<option>').val(partida.idPartida).text(partida.Partida);
                selectPartidas.append(option);
            });
            // seleccionar partida por defecto
            selectPartidas.val(idPartida);
        },
        error: function (error) {
            console.log('Error en la solicitud AJAX:', error);
        }
    });
}