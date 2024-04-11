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
		var exerciseName = $("input[name='exerciseName']").val();
		var initialDate = $("input[name='initialDate']").val();
		var finalDate = $("input[name='finalDate']").val();
		var budget = $("input[name='budget']").val();
		var user = $("input[name='user']").val();

		if (exerciseName == '' || initialDate == ''|| finalDate == '' || budget == ''){
			
			showAlertBootstrap('¡Atención!', 'Por favor, introduzca la información solicitada en todos lo campos señalados con un (*).');

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
	
						$('.sidenav').removeAttr('onclick');
						
						showAlertBootstrap3('Ejercicio creado exitosamente', '¿Agregar otro ejercicio?', 'registerExercise' , 'exercise');
					} else {
						
						showAlertBootstrap('!Atención¡', 'Error al crear el ejercicio');
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

		showAlertBootstrap2('Cancelar', '¿Seguro que desea cancelar?', 'exercise');
		
	});
});

function confirmExit(event, destination) {
	if (bandera == 1){
		event.preventDefault();
		showAlertBootstrap2('¿Está seguro?', 'Si sale del formulario, perderá los cambios no guardados.', destination);
	}
}