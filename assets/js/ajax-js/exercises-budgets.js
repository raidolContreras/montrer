    $(document).ready(function () {
        const Toast = Swal.mixin({
            toast: true,
            position: "center",
            showConfirmButton: false,
            timerProgressBar: false,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });

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

                // Muestra un modal con los botones personalizados
                Swal.fire({
                    title: 'Selecciona un ejercicio',
                    html: buttonsHtml,
                    showCancelButton: true,
                    showCloseButton: false,
                    focusConfirm: false,
                    cancelButtonText: 'Cancelar',
                    cancelButtonColor: '#d33',
                    showConfirmButton: false,
                    allowOutsideClick: false, // Evita que se cierre haciendo clic fuera del marco
                    customClass: {
                        container: 'exercise-modal-container',
                    }
                }).then((result) => {
                    if (result.dismiss === Swal.DismissReason.cancel) {
                        window.location.href = 'inicio'; // Redirige a la página de inicio
                    }
                });

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