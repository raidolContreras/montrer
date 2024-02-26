$(document).ready(function () {
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
				
				showAlertBootstrap('Error', 'Por favor, introduzca la información solicitada en todos lo campos señalados con un (*).');
				return false;
			}
			return true;
		}

		if (!validateField('businessName') ||
			!validateField('representativeName') ||
			!validateField('email') ||
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
					
					showAlertBootstrap3('Proveedor creado exitosamente.', '¿Agregar otro proveedor?', 'registerProvider' , 'provider');

				} else {
					
					showAlertBootstrap('Error', 'Error al crear el proveedor.');

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

		showAlertBootstrap2('Cancelar', '¿Seguro que deseas cancelar?', 'provider');

	});
});

function confirmExit(event, destination) {
	event.preventDefault();
	
	showAlertBootstrap2('¿Estás seguro?', 'Si sales del formulario, perderás los cambios no guardados.', destination);

}
