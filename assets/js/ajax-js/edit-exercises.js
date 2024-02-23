$(document).ready(function () {
	$("form.account-wrap").submit(function (event) {
		// Evitar el envío del formulario por defecto
		event.preventDefault();

		// Recoge los valores del formulario
		var exerciseName = $("input[name='exerciseName']").val();
		var initialDate = $("input[name='initialDate']").val();
		var finalDate = $("input[name='finalDate']").val();
		var user = $("input[name='user']").val();
		var budget = $("input[name='budget']").val();
		var exercise = $('#register-value').data('register');

		
		if (exerciseName == '' || initialDate == ''|| finalDate == '' || budget == ''){
			showAlertBootstrap('Advertencia', 'Por favor, introduzca la información solicitada en todos lo campos señalados con un (*).');
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
						showAlertBootstrap2('Éxito', 'Ejercicio actualizado exitosamente', 'exercise');
					} else {
						showAlertBootstrap('Error', 'Error al actualizar el ejercicio');
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
		
		showAlertBootstrap2('Cancelar', '¿Seguro que deseas cancelar?', 'exercise');

	});
});

function confirmExit(event, destination) {
	event.preventDefault();
	showAlertBootstrap2('¿Estás seguro?', 'Si sales del formulario, perderás los cambios no guardados.', destination);
}
