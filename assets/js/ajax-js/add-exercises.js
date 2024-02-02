$(document).ready(function () {
	$("form.account-wrap").submit(function (event) {
		// Evitar el envío del formulario por defecto
		event.preventDefault();

		// Recoge los valores del formulario
		var exerciseName = $("input[name='exerciseName']").val();
		var initialDate = $("input[name='initialDate']").val();
		var finalDate = $("input[name='finalDate']").val();
		var budget = $("input[name='budget']").val();
		var user = $("input[name='user']").val();

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

		if (exerciseName == '' || initialDate == ''|| finalDate == '' || budget == ''){
			Swal.fire({
				icon: 'warning',
				title: 'Advertencia',
				text: 'Por favor, introduzca la información solicitada en todos lo campos señalados con un (*).',
				confirmButtonColor: '#026f35',
				confirmButtonText: 'Aceptar'
			});
		} else {
			// Realiza la solicitud Ajax
			$.ajax({
				type: "POST",
				url: "controller/ajax/ajax.form.php",
				data: {
					exerciseName: exerciseName,
					initialDate: initialDate,
					finalDate: finalDate,
					budget: budget,
					user: user
				},
				success: function (response) {
	
					if (response === 'ok') {
	
						$("input[name='exerciseName']").val('');
						$("input[name='initialDate']").val('');
						$("input[name='finalDate']").val('');
						$("input[name='budget']").val('');
	
						Swal.fire({
						  icon: "success",
						  title: 'Ejercicio creado exitosamente',
						  confirmButtonColor: '#026f35',
						  confirmButtonText: 'Aceptar'
						});
					} else {
						Swal.fire({
						  icon: 'error',
						  title: 'Error al crear el ejercicio',
						  confirmButtonColor: '#026f35',
						  confirmButtonText: 'Aceptar'
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
			cancelButtonColor: '#d33',
			confirmButtonColor: '#026f35',
			cancelButtonText: 'Cancelar',
			confirmButtonText: 'Aceptar',
			reverseButtons: true,
		}).then((result) => {
			// Si hacen clic en "Sí, cancelar", redirigir a "registers"
			if (result.isConfirmed) {
				window.location.href = "exercise";
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