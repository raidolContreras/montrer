$(document).ready(function () {
    $("form.account-wrap").submit(function (event) {
        event.preventDefault();

        // Recoge los valores del formulario del proveedor
        var providerKey = $("input[name='providerKey']").val();
        var fields = {
            updaterepresentativeName: $("input[name='representativeName']").val(),
            updatecontactPhone: $("input[name='contactPhone']").val(),
            updateemail: $("input[name='email']").val(),
            updatewebsite: $("input[name='website']").val(),
            updatebusinessName: $("input[name='businessName']").val(),
            updaterfc: $("input[name='rfc']").val(),
            updatefiscalAddressStreet: $("input[name='fiscalAddressStreet']").val(),
            updatefiscalAddressColonia: $("input[name='fiscalAddressColonia']").val(),
            updatefiscalAddressMunicipio: $("input[name='fiscalAddressMunicipio']").val(),
            updatefiscalAddressEstado: $("input[name='fiscalAddressEstado']").val(),
            updatefiscalAddressCP: $("input[name='fiscalAddressCP']").val(),
            updatebankName: $("input[name='bankName']").val(),
            updateaccountHolder: $("input[name='accountHolder']").val(),
            updateaccountNumber: $("input[name='accountNumber']").val(),
            updateclabe: $("input[name='clabe']").val(),
        };

        // Función de validación
        function validateField(fieldName) {
            if (!fields[fieldName]) {
                showAlertBootstrap('Advertencia', 'Por favor, introduzca la información solicitada en todos lo campos señalados con un (*).');
                return false;
            }
            return true;
        }

        // Validar campos requeridos
        if (!validateField('updatebusinessName') ||
            !validateField('updaterepresentativeName') ||
            !validateField('updateemail') ||
            !validateField('updaterfc') ||
            !validateField('updatecontactPhone') ||
            !validateField('updatefiscalAddressStreet') ||
            !validateField('updatefiscalAddressColonia') ||
            !validateField('updatefiscalAddressMunicipio') ||
            !validateField('updatefiscalAddressEstado') ||
            !validateField('updatefiscalAddressCP') ||
            !validateField('updatebankName') ||
            !validateField('updateaccountHolder') ||
            !validateField('updateaccountNumber')
        ) {
            return;
        }

        // Realizar la solicitud Ajax
        $.ajax({
            type: "POST",
            url: "controller/ajax/ajax.form.php",
            data: {
                providerKey: providerKey,
                ...fields
            },
            success: function (response) {
                if (response === 'ok') {
                    showAlertBootstrap2('Éxito', 'Proveedor actualizado exitosamente', 'provider');
                } else {
                    showAlertBootstrap('Error', 'Error al actualizar el proveedor');
                }
            },
            error: function (error) {
                console.log("Error en la solicitud Ajax:", error);
            }
        });
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

		showAlertBootstrap2('Cancelar', '¿Seguro que deseas cancelar?', 'provider');
        
	});
});

function confirmExit(event, destination) {
	event.preventDefault();
	showAlertBootstrap2('¿Estás seguro?', 'Si sales del formulario, perderás los cambios no guardados.', destination);
}
