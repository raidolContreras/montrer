$(document).ready(function () {
    $("form.account-wrap").submit(function (event) {
        // Evitar el envío del formulario por defecto
        event.preventDefault();

        // Recoge los valores del formulario
        var areaName = $("input[name='areaName']").val();
        var areaDescription = $("input[name='areaDescription']").val();
        var user = $("select[name='user']").val();

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

        if (areaName !== '' && user !== null) {
            // Realiza la solicitud Ajax
            $.ajax({
                type: "POST",
                url: "controller/ajax/ajax.form.php",
                data: {
                    areaName: areaName,
                    areaDescription: areaDescription,
                    user: user
                },
                success: function (response) {

                    if (response === 'ok') {
                        $("input[name='areaName']").val('');
                        $("input[name='areaDescription']").val('');
                        $("select[name='user']").val('');

                        Swal.fire({
                            icon: "success",
                            title: 'Departamento registrado',
                            icon: "success"
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error al registrar el departamento',
                            icon: "error"
                        });
                    }
                },
                error: function (error) {
                    console.log("Error en la solicitud Ajax:", error);
                }
            });
        } else {

            Swal.fire({
				icon: 'warning',
				title: 'Error',
				text: 'Por favor, complete correctamente todos los campos obligatorios (nombre del departamento, colaborador responsable).',
				icon: "warning"
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
				window.location.href = "areas";
			}
			// Si hacen clic en "No, seguir aquí", no hacer nada
		});
	});
});

    function confirmExit(event, destination) {
        event.preventDefault();
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'Si sales del formulario, perderás los cambios no guardados.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, salir',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = destination;
            }
        });
    }

    $(function () {
        $('[data-bs-toggle="tooltip"]').tooltip();
    });