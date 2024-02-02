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
							confirmButtonColor: '#026f35',
							confirmButtonText: 'Aceptar'
						});
					} else {
						Swal.fire({
							icon: 'error',
							title: 'Error al registrar el departamento',
							confirmButtonColor: '#026f35',
							confirmButtonText: 'Aceptar'
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
				text: 'Por favor, introduzca la información solicitada en todos lo campos señalados con un (*).',
				confirmButtonColor: '#026f35',
				confirmButtonText: 'Aceptar'
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
		// Mostrar un modal de confirmación con SweetAlert2
		Swal.fire({
			title: '¿Seguro que deseas cancelar?',
			icon: 'warning',
			showCancelButton: true,
			cancelButtonColor: '#d33',
			confirmButtonColor: '#026f35',
			cancelButtonText: 'Cancelar',
			confirmButtonText: 'Aceptar',
			reverseButtons: true, // Esto coloca el botón de confirmación a la derecha
		}).then((result) => {
			if (result.isConfirmed) {
				window.location.href = "areas";
			}
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
			cancelButtonColor: '#d33',
			confirmButtonColor: '#026f35',
			cancelButtonText: 'Cancelar',
			confirmButtonText: 'Aceptar',
			reverseButtons: true,
		}).then((result) => {
			if (result.isConfirmed) {
				window.location.href = destination;
			}
		});
	}

	$(function () {
		$('[data-bs-toggle="tooltip"]').tooltip();
	});