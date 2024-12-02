var bandera = 0;


$(document).ready(function() {
    // Inicializa select2 antes de realizar cualquier operación
    $('#responsibleUser').select2({
        placeholder: "Selecciona los usuarios responsables",
        allowClear: true,
        width: '100%'
    });

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
		var areaCode = $("input[name='areaCode']").val();
		var users = $("select[name='users[]']").val(); // Recoge un array de IDs seleccionados
	
		if (areaName !== '' && users !== null && users.length > 0) {
			// Realiza la solicitud Ajax
			$.ajax({
				type: "POST",
				url: "controller/ajax/ajax.form.php",
				data: {
					areaName: areaName,
					areaDescription: areaDescription,
					areaCode: areaCode,
					users: users // Envía el array de IDs
				},
				success: function (response) {
					if (response === 'ok') {
						bandera = 0;
						$("input[name='areaName']").val('');
						$("input[name='areaDescription']").val('');
						$("input[name='areaCode']").val('');
						$("select[name='users[]']").val(null).trigger('change'); // Limpia el select
	
						showAlertBootstrap3(
							'Departamento registrado',
							'¿Agregar otro departamento?',
							'registerArea',
							'areas'
						);
	
					} else if (response === 'Error: El departamento ya existe') {
						showAlertBootstrap('¡Atención!', 'El departamento ya existe.');
					} else {
						showAlertBootstrap('¡Atención!', 'Error al registrar el departamento.');
					}
				},
				error: function (error) {
					console.log("Error en la solicitud Ajax:", error);
				}
			});
		} else {
			showAlertBootstrap(
				'¡Atención!',
				'Por favor, introduzca la información solicitada en todos los campos señalados con un (*).'
			);
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

$('.auto-format').on('input', function() {
    console.log('a');
    let input = $(this).val().replace(/\D/g, ''); // Elimina cualquier carácter no numérico
    let formatted = '';

    if (input.length > 4) {
        formatted += input.substring(0, 4) + '-';
        if (input.length > 7) {
            formatted += input.substring(4, 7);
        } else {
            formatted += input.substring(4);
        }
    } else {
        formatted = input;
    }

    $(this).val(formatted);
});