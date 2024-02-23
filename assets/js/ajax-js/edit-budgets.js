$(document).ready(function () {
	$("form.account-wrap").submit(function (event) {
		// Evitar el envío del formulario por defecto
		event.preventDefault();

		// Recoge los valores del formulario
		var AuthorizedAmount = $("input[name='AuthorizedAmount']").val();
		var area = $("select[name='area']").val();
		var exercise = $("select[name='exercise']").val();
		var budget = $('#register-value').data('register');

		if (area == '' || AuthorizedAmount == '' || exercise == ''){
			showAlertBootstrap('Advertencia', 'Por favor, introduzca la información solicitada en todos lo campos señalados con un (*).');
		} else {
			// Realiza la solicitud Ajax
			$.ajax({
				type: "POST",
				url: "controller/ajax/ajax.form.php",
				data: {
					updateAuthorizedAmount: AuthorizedAmount,
					updateArea: area,
					updateExercise: exercise,
					updateBudget: budget
				},
				success: function (response) {
	
					if (response === 'ok') {
						showAlertBootstrap2('Éxito', 'Presupuesto actualizado exitosamente' , 'budgets');
					} else {
						
						showAlertBootstrap('Error', 'Error al actualizar el presupuesto');
						
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

		showAlertBootstrap2('Cancelar', '¿Seguro que deseas cancelar?', 'budgets');
		
	});
});

function confirmExit(event, destination) {
	event.preventDefault();
	showAlertBootstrap2('¿Estás seguro?', 'Si sales del formulario, perderás los cambios no guardados.', destination);
}
