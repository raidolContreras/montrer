var bandera = 0;
$(document).ready(function () {

    // Detectar cambios en cualquier campo del formulario y establecer la bandera a 1
    $("form.account-wrap input, form.account-wrap select").change(function() {
        bandera = 1;
    });

	$("form.account-wrap").submit(function (event) {
		// Evitar el envío del formulario por defecto
		event.preventDefault();

		// Recoge los valores del formulario
		var AuthorizedAmount = $("input[name='AuthorizedAmount']").val();
		var Amount = $('#Amount').val();
		var area = $("select[name='area']").val();
		var partidas = $("select[name='partidas']").val();
		var exercise = $("select[name='exercise']").val();
		var budget = $('#register-value').data('register');

		if (area == '' || AuthorizedAmount == '' || exercise == ''){
			showAlertBootstrap('¡Atención!', 'Por favor, introduzca la información solicitada en todos lo campos señalados con un (*).');
		} else {
			// Realiza la solicitud Ajax
			$.ajax({
				type: "POST",
				url: "controller/ajax/ajax.form.php",
				data: {
					updateAuthorizedAmount: AuthorizedAmount,
					ActualAmount: Amount,
					updateArea: area,
					updatePartidas: partidas,
					updateExercise: exercise,
					updateBudget: budget
				},
				success: function (response) {
	
					if (response === 'ok') {
						bandera = 0;
						showAlertBootstrap1('Operación realizada', 'Presupuesto actualizado exitosamente' , 'budgets');
					} else {
						
						showAlertBootstrap('!Atención¡', 'Error al actualizar el presupuesto');
						
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

		showAlertBootstrap2('Cancelar', '¿Seguro que desea cancelar?', 'budgets');
		
	});
});

function confirmExit(event, destination) {
	if (bandera == 1){
		event.preventDefault();
		showAlertBootstrap2('¿Está seguro?', 'Si sale del formulario, perderá los cambios no guardados.', destination);
	}
}
