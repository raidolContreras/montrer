$(document).ready(function () {

    // Realiza la solicitud Ajax a exerciseOn.php con el idExercise
    $.ajax({
        type: "POST",
        url: "controller/ajax/getExercises.php",
        success: function (response) {
            // Parsea la respuesta JSON
            var exercises = JSON.parse(response);
            var selectOptionsHtml = `<option>Selecciona un ejercicio</option>`;

            // Crea las opciones para el select
            exercises.forEach(function(exercise) {
                selectOptionsHtml += `<option value="${exercise.idExercise}">${exercise.exerciseName}</option>`;
            });
            
            var html = `<select class="form-select" id="exerciseSelect">${selectOptionsHtml}</select>`;
            showAlertBootstrap5('Selecciona un ejercicio', html);

            // Agrega un evento de cambio al select
            $('#exerciseSelect').on('change', function() {
                var selectedExerciseId = $(this).val();
                window.location.href = `budgets&exercise=${selectedExerciseId}`;
            });
        },
        error: function (error) {
            console.log("Error en la solicitud Ajax:", error);
        }
    });
});
