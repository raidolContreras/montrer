$(document).ready(function () {
    $.ajax({
        url: 'controller/ajax/activeExercise.php',
        dataSrc: '',
        success: function (response) {
            // Parsea la respuesta JSON
            var parsedResponse = JSON.parse(response);

            if (parsedResponse === 'false') {
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timerProgressBar: false,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });

                Toast.fire({
                    icon: 'error',
                    title: 'No se ha activado ningún ejercicio',
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Aceptar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'exercise';
                    }
                });

            } else {
                var exerciseSelect = document.getElementById('exercise');

                // Deshabilita el select
                exerciseSelect.disabled = true;

                // Limpia cualquier opción existente en el select
                exerciseSelect.innerHTML = '';

                var option = document.createElement('option');
                option.value = parsedResponse.idExercise; // Ajusta esto según tu estructura de datos
                option.text = parsedResponse.exerciseName; // Ajusta esto según tu estructura de datos

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