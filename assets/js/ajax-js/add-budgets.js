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

        if (area == '' || AuthorizedAmount == '' || exercise == ''){
			Swal.fire({
				icon: 'warning',
				title: 'Advertencia',
				text: 'Por favor, complete correctamente todos los campos obligatorios (area, presupuesto asignado, ejercicio)',
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

// Esperar a que el documento esté listo
document.addEventListener('DOMContentLoaded', function () {
	// Obtener el botón de cancelar por su ID
	var cancelButton = document.getElementById('cancelButton');

	// Agregar un evento de clic al botón de cancelar
	cancelButton.addEventListener('click', function (event) {
		// Prevenir el comportamiento predeterminado del enlace
		event.preventDefault();

		// Mostrar un modal de confirmación con SweetAlert2
		Swal.fire({
			title: '¿Seguro que deseas cancelar?',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonText: 'Sí, cancelar',
			cancelButtonText: 'No, seguir aquí',
		}).then((result) => {
			// Si hacen clic en "Sí, cancelar", redirigir a "registers"
			if (result.isConfirmed) {
				window.location.href = "budgets";
			}
			// Si hacen clic en "No, seguir aquí", no hacer nada
		});
	});
});