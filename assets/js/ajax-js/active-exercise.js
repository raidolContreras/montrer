$(document).ready(function () {
    $.ajax({
        url: 'controller/ajax/activeExercise.php',
        dataSrc: '',
        success: function (response) {
            // Parsea la respuesta JSON
            var parsedResponse = JSON.parse(response);

            if (parsedResponse === 'false') {

                showAlertBootstrap2('error', 'No se ha activado ningún ejercicio.', 'exercise');

            } else {
                var exerciseSelect = document.getElementById('exercise');

                // Deshabilita el select
                exerciseSelect.disabled = true;

                // Limpia cualquier opción existente en el select
                exerciseSelect.innerHTML = '';

                var option = document.createElement('option');
                option.value = parsedResponse.idExercise;
                option.text = parsedResponse.exerciseName;

                // Establece la opción como seleccionada
                option.selected = true;

                exerciseSelect.add(option);
            }
        },
        error: function (error) {
            console.log("Error en la solicitud Ajax:", error);
        }
    });
});