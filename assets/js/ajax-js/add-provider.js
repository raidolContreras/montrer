var bandera = 0;
$(document).ready(function () {

    // Detectar cambios en cualquier campo del formulario y establecer la bandera a 1
    $("form.account-wrap input, form.account-wrap select").change(function() {
        bandera = 1;
    });
	
	$("form.account-wrap").submit(function (event) {
		event.preventDefault();

		var providerKey = $("input[name='providerKey']").val();
		var fields = {
			representativeName: $("input[name='representativeName']").val(),
			contactPhone: $("input[name='contactPhone']").val(),
			email: $("input[name='email']").val(),
			website: $("input[name='website']").val(),
			businessName: $("input[name='businessName']").val(),
			rfc: $("input[name='rfc']").val(),
			fiscalAddressStreet: $("input[name='fiscalAddressStreet']").val(),
			fiscalAddressColonia: $("input[name='fiscalAddressColonia']").val(),
			fiscalAddressMunicipio: $("input[name='fiscalAddressMunicipio']").val(),
			fiscalAddressEstado: $("input[name='fiscalAddressEstado']").val(),
			fiscalAddressCP: $("input[name='fiscalAddressCP']").val(),
			bankName: $("input[name='bankName']").val(),
			accountHolder: $("input[name='accountHolder']").val(),
			accountNumber: $("input[name='accountNumber']").val(),
			clabe: $("input[name='clabe']").val(),
		};
		var user = $("input[name='user']").val();

		function validateField(fieldName) {
			if (!fields[fieldName]) {
				
				showAlertBootstrap('¡Atención!', 'Por favor, introduzca la información solicitada en todos lo campos señalados con un (*).');
				return false;
			}
			return true;
		}

		if (!validateField('businessName') ||
			!validateField('representativeName') ||
			!validateField('rfc') ||
			!validateField('contactPhone') ||
			!validateField('fiscalAddressStreet') ||
			!validateField('fiscalAddressColonia') ||
			!validateField('fiscalAddressMunicipio') ||
			!validateField('fiscalAddressEstado') ||
			!validateField('fiscalAddressCP') ||
			!validateField('bankName') ||
			!validateField('accountHolder') ||
			!validateField('accountNumber')
		) {
			return;
		}

		$.ajax({
			type: "POST",
			url: "controller/ajax/ajax.form.php",
			data: {
				providerKey: providerKey,
				user: user,
				...fields
			},
			success: function (response) {
				if (response === 'ok') {
					
					bandera = 0;
					showAlertBootstrap3('Proveedor creado exitosamente.', '¿Agregar otro proveedor?', 'registerProvider' , 'provider');

				} else if (response == 'Error: RFC ya registrado') {
                
					showAlertBootstrap('!Atención¡', 'RFC ya registrado.');
	
				} else {
					
					showAlertBootstrap('!Atención¡', 'Error al crear el proveedor.');

				}
			},
			error: function (error) {
				console.log("Error en la solicitud Ajax:", error);
			}
		});
	});
});

document.addEventListener('DOMContentLoaded', function () {
	var cancelButton = document.getElementById('cancelButton');

	cancelButton.addEventListener('click', function (event) {

		showAlertBootstrap2('Cancelar', '¿Seguro que desea cancelar?', 'provider');

	});
});

function confirmExit(event, destination) {
	if (bandera == 1){
		event.preventDefault();
		showAlertBootstrap2('¿Está seguro?', 'Si sale del formulario, perderá los cambios no guardados.', destination);
	}
}