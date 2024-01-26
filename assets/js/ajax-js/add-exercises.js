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

		if (exerciseName == ''){
			Swal.fire({
				icon: 'warning',
				title: 'Advertencia',
				text: 'Por favor, ingrese el nombre del ejercicio.',
			});
		} else if (initialDate == '') {
			Swal.fire({
				icon: 'warning',
				title: 'Advertencia',
				text: 'Por favor, seleccione la fecha de inicio del ejercicio.',
			});
		} else if (finalDate == '') {
			Swal.fire({
				icon: 'warning',
				title: 'Advertencia',
				text: 'Por favor, seleccione la fecha de finalización del ejercicio.',
			});
		} else if (budget == '') {
			Swal.fire({
				icon: 'warning',
				title: 'Advertencia',
				text: 'Por favor, ingrese el presupuesto asignado para el ejercicio.',
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
						  icon: "success"
						});
					} else {
						Swal.fire({
						  icon: 'error',
						  title: 'Error al crear el ejercicio',
						  icon: "error"
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
				window.location.href = "exercise";
			}
			// Si hacen clic en "No, seguir aquí", no hacer nada
		});
	});
});