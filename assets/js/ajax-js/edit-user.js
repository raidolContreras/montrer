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
		var firstname = $("input[name='firstname']").val();
		var lastname = $("input[name='lastname']").val();
		var email = $("input[name='email']").val();
		var level = $("select[name='level']").val();
		var user = $('#register-value').data('register');

		if (firstname == '' || lastname == '' || email == ''){
			showAlertBootstrap('¡Atención!', 'Por favor, introduzca la información solicitada en todos lo campos señalados con un (*).');
		} else {
			// Realiza la solicitud Ajax
			$.ajax({
				type: "POST",
				url: "controller/ajax/ajax.form.php",
				data: {
					updateFirstname: firstname,
					updateLastname: lastname,
					updateEmail: email,
					updateLevel: level,
					updateUser: user
				},
				success: function (response) {			  
	
					bandera = 0;
					if (response !== 'Error' && response !== 'Error: Email duplicado') {
						showAlertBootstrap2('Operación realizada', 'Datos del usuario actualizados exitosamente', 'registers');
					} else if (response === 'Error: Email duplicado') {
						showAlertBootstrap('', response);
					} else {
						showAlertBootstrap('Error', 'Error al crear el usuario');
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
		event.preventDefault();
		showAlertBootstrap2('Cancelar', '¿Seguro que desea cancelar?', 'registers');
	});
});

function confirmExit(event, destination) {
	if (bandera == 1){
		event.preventDefault();
		showAlertBootstrap2('¿Está seguro?', 'Si sale del formulario, perderá los cambios no guardados.', destination);
	}
}
