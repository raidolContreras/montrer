var bandera = 0;
$(document).ready(function () {

    // Detectar cambios en cualquier campo del formulario y establecer la bandera a 1
    $("form.account-wrap input, form.account-wrap select").change(function() {
        bandera = 1;
    });

	$("form.account-wrap").submit(function (event) {
		event.preventDefault();
        // Collect form values
        var firstname = $("input[name='firstname']").val();
        var lastname = $("input[name='lastname']").val();
        var email = $("input[name='email']").val();
        var level = $("select[name='level']").val();
        var area = $("select[name='area']").val();
		
        if (firstname == '' || lastname == '' || email == '') {
            showAlertBootstrap('Error', 'Por favor, introduzca la información solicitada en todos lo campos señalados con un (*).');
        } else {
			$.ajax({
				type: "POST",
				url: "controller/ajax/ajax.form.php",
				data: {
					firstname: firstname,
					lastname: lastname,
					email: email,
					level: level,
					area: area
				},
				success: function (response) {				
					
					if (response !== 'Error' && response !== 'Error: Email duplicado') {

						bandera = 0;
						$("input[name='firstname']").val('');
						$("input[name='lastname']").val('');
						$("input[name='email']").val('');
						$("select[name='level']").val('2');
						$("select[name='area']").val('');

						showAlertBootstrap('Exito', response+' creado exitosamente');

					} else if (response === 'Error: Email duplicado') {

						showAlertBootstrap('Error', 'Dirección de correo electrónico ya registrada');

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

document.addEventListener('DOMContentLoaded', function () {
    var cancelButton = document.getElementById('cancelButton');

    cancelButton.addEventListener('click', function (event) {
        event.preventDefault();
		showAlertBootstrap2('Cancelar', '¿Seguro que deseas cancelar?', 'registers');
    });
});


function confirmExit(event, destination) {
	if (bandera == 1){
		event.preventDefault();
		showAlertBootstrap2('¿Está seguro?', 'Si sale del formulario, perderá los cambios no guardados.', destination);
	}
}
