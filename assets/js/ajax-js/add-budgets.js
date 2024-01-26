$(document).ready(function () {
    $("form.account-wrap").submit(function (event) {
        // Evitar el envío del formulario por defecto
        event.preventDefault();

        // Recoge los valores del formulario
        var area = $("select[name='area']").val();
        var AuthorizedAmount = $("input[name='AuthorizedAmount']").val();
        var exercise = $("select[name='exercise']").val();

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

        if (area == ''){
            Swal.fire({
                icon: 'warning',
                title: 'Advertencia',
                text: 'Por favor, seleccione el departamento para asignar el presupuesto.',
            });
        } else if (AuthorizedAmount == '') {
            Swal.fire({
                icon: 'warning',
                title: 'Advertencia',
                text: 'Por favor, ingrese la cantidad autorizada para el presupuesto.',
            });
        } else if (exercise == '') {
            Swal.fire({
                icon: 'warning',
                title: 'Advertencia',
                text: 'Por favor, seleccione el ejercicio presupuestario.',
            });
        } else {
            // Realiza la solicitud Ajax
            $.ajax({
                type: "POST",
                url: "controller/ajax/ajax.form.php",
                data: {
                    area: area,
                    AuthorizedAmount: AuthorizedAmount,
                    exercise: exercise
                },
                success: function (response) {

                    if (response === 'ok') {
                        $("select[name='area']").val('');
                        $("input[name='AuthorizedAmount']").val('');
                        $("select[name='exercise']").val('');

                        Swal.fire({
                            icon: "success",
                            title: 'Presupuesto asignado correctamente.',
                        });
                    } else if (response === 'Error: Presupuesto ya asignado') {
                        Swal.fire({
                            icon: "error",
                            title: 'Error',
                            text: 'Presupuesto ya asignado a esta área.',
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error al asignar el presupuesto.',
                        });
                    }
                },
                error: function (error) {
                    console.log("Error en la solicitud Ajax:", error);
                }
            });
        }
    });
});
