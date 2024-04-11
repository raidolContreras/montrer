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
						bandera = 0;
						$("input[name='areaName']").val('');
						$("input[name='areaDescription']").val('');
						$("select[name='user']").val('');
						$('.sidenav').removeAttr('onclick');

						showAlertBootstrap3('Departamento registrado', '¿Agregar otro ejercicio?', 'registerArea' , 'areas');

					} else {
						
						showAlertBootstrap('!Atención¡', 'Error al registrar el departamento.');

					}
				},
				error: function (error) {
					console.log("Error en la solicitud Ajax:", error);
				}
			});
		} else {

            showAlertBootstrap('¡Atención!', 'Por favor, introduzca la información solicitada en todos lo campos señalados con un (*).');
			
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
		showAlertBootstrap2('Cancelar', '¿Seguro que desea cancelar?', 'areas');

	});
});

function confirmExit(event, destination) {
	if (bandera == 1){
		event.preventDefault();
		showAlertBootstrap2('¿Está seguro?', 'Si sale del formulario, perderá los cambios no guardados.', destination);
	}
}
