$(document).ready(function () {
	$("form.account-wrap").submit(function (event) {
		// Evitar el envío del formulario por defecto
		event.preventDefault();

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
		
		// Recoge los valores del formulario
		var exerciseName = $("input[name='exerciseName']").val();
		var initialDate = $("input[name='initialDate']").val();
		var finalDate = $("input[name='finalDate']").val();
		var user = $("input[name='user']").val();
		var budget = $("input[name='budget']").val();
		var exercise = $('#register-value').data('register');

		
		if (exerciseName == '' || initialDate == ''|| finalDate == '' || budget == ''){
			Swal.fire({
				icon: 'warning',
				title: 'Advertencia',
				text: 'Por favor, complete correctamente todos los campos obligatorios (nombre del ejercicio, fecha de inicio, fecha de cierre, presupuesto)',
			});
		} else {
			// Realiza la solicitud Ajax
			$.ajax({
				type: "POST",
				url: "controller/ajax/ajax.form.php",
				data: {
					updateExerciseName: exerciseName,
					updateInitialDate: initialDate,
					updateFinalDate: finalDate,
					updateUser: user,
					updateBudget: budget,
					updateExercise: exercise
				},
				success: function (response) {			  
	
					if (response !== 'Error' && response !== 'Error: Email duplicado') {
						Swal.fire({
						  icon: "success",
						  title: 'Ejercicio actualizado exitosamente',
						  icon: "success"
						});
						setTimeout(function () {
							window.location.href = 'exercise';
						}, 1000);
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