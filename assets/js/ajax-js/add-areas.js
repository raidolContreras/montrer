$(document).ready(function () {
	$("form.account-wrap").submit(function (event) {
		// Evitar el envío del formulario por defecto
		event.preventDefault();

		// Recoge los valores del formulario
		var areaName = $("input[name='areaName']").val();
		var areaDescription = $("input[name='areaDescription']").val();
		var user = $("select[name='user']").val();

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
						$('.sidenav').removeAttr('onclick');

						showAlertBootstrap('Exito', 'Departamento registrado.');

					} else {
						
						showAlertBootstrap('Error', 'Error al registrar el departamento.');

					}
				},
				error: function (error) {
					console.log("Error en la solicitud Ajax:", error);
				}
			});
		} else {

            showAlertBootstrap('Error', 'Por favor, introduzca la información solicitada en todos lo campos señalados con un (*).');
			
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
		showAlertBootstrap2('Cancelar', '¿Seguro que deseas cancelar?', 'areas');

	});
});

function confirmExit(event, destination) {
	event.preventDefault();
	showAlertBootstrap2('¿Estás seguro?', 'Si sales del formulario, perderás los cambios no guardados.', destination);
}
