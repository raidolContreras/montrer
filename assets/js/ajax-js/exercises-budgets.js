    $(document).ready(function () {

        // Realiza la solicitud Ajax a exerciseOn.php con el idExercise
        $.ajax({
            type: "POST",
            url: "controller/ajax/getExercises.php",
            success: function (response) {
                // Parsea la respuesta JSON
                var exercises = JSON.parse(response);
                var buttonsHtml = '<div class="row">';

                // Crea botones personalizados para cada ejercicio
                exercises.forEach(function(exercise) {
                    buttonsHtml += `<div class="col-6 mb-3"><button class="exercise-btn" data-value="${exercise.idExercise}">${exercise.exerciseName}</button></div>`;
                });
                
                buttonsHtml += '<div class="col-12 mb-3"><button class="exercise-btn" data-value="all">Vista general</button></div></div>';
                showAlertBootstrap4('', 'Selecciona un ejercicio', 'inicio', buttonsHtml);

                // Agrega un evento de clic a los botones personalizados
                $('.exercise-btn').on('click', function() {
                    var selectedExerciseId = $(this).data('value');
                    window.location.href = `budgets&exercise=${selectedExerciseId}`;
                });
            },
            error: function (error) {
                console.log("Error en la solicitud Ajax:", error);
            }
        });
    });