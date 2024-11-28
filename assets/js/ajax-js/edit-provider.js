var bandera = 0;
$(document).ready(function () {

    // Detectar cambios en cualquier campo del formulario y establecer la bandera a 1
    $("form.account-wrap input, form.account-wrap select").change(function() {
        bandera = 1;
    });

    $("form.account-wrap").submit(function (event) {
        event.preventDefault();

        // Recoge los valores del formulario del proveedor
        var providerKey = $("input[name='providerKey']").val();
        //revisa si $('#foreignProvider') esta checkeado y si lo esta que envie #swiftCode si no lo envie nulo
        var foreignProvider = $('#foreignProvider').is(':checked');
        var swiftCode = foreignProvider? $("#swiftCode").val() : null;
        var beneficiaryAddress = foreignProvider? $("#beneficiaryAddress").val() : null;
        var currencyType = foreignProvider? $("#currencyType").val() : null;


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
            // updatedescription: $("input[name='description']").val(),
            updateswiftCode: swiftCode,
            updatebeneficiaryAddress: beneficiaryAddress,
            updatecurrencyType: currencyType,
            // id user
            idUser: $("#idUser").val()
        };

        // Función de validación
        function validateField(fieldName) {
            if (!fields[fieldName]) {
                showAlertBootstrap('¡Atención!', 'Por favor, introduzca la información solicitada en todos lo campos señalados con un (*).');
                return false;
            }
            return true;
        }

        // Validar campos requeridos
        if (!validateField('updatebusinessName') ||
            !validateField('updaterepresentativeName') ||
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
                    
					bandera = 0;
                    showAlertBootstrap1('Operación realizada', 'Proveedor actualizado exitosamente', 'provider');

                } else if (response == 'Error: RFC ya registrado') {
                
                    showAlertBootstrap('!Atención¡', 'RFC ya registrado.');
    
                } else {
                    showAlertBootstrap('!Atención¡', 'Error al actualizar el proveedor');
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

		showAlertBootstrap2('Cancelar', '¿Seguro que desea cancelar?', 'provider');
        
	});
});


function confirmExit(event, destination) {
	if (bandera == 1){
		event.preventDefault();
		showAlertBootstrap2('¿Está seguro?', 'Si sale del formulario, perderá los cambios no guardados.', destination);
	}
}
