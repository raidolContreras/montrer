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

        const Toast = Swal.mixin({
            toast: true,
            position: "center",
            showConfirmButton: false,
            timerProgressBar: false,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });

        // Función de validación
        function validateField(fieldName) {
            if (!fields[fieldName]) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Advertencia',
                    text: 'Por favor, complete correctamente todos los campos obligatorios (*)',
                });
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

                    Swal.fire({
                        icon: "success",
                        title: 'Proveedor actualizado exitosamente',
                        icon: "success"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'provider';
                        }
                    });
                } else {
                    // Mostrar mensaje de error
                    Swal.fire({
                        icon: 'error',
                        title: 'Error al actualizar el proveedor',
                        icon: "error"
                    });
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

		// Mostrar un modal de confirmación con SweetAlert2
		Swal.fire({
			title: '¿Seguro que deseas cancelar?',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonText: 'Sí, cancelar',
			cancelButtonText: 'No, seguir aquí',
		}).then((result) => {
			// Si hacen clic en "Sí, cancelar", redirigir a "registers"
			if (result.isConfirmed) {
				window.location.href = "provider";
			}
			// Si hacen clic en "No, seguir aquí", no hacer nada
		});
	});
});

function confirmExit(event, destination) {
        event.preventDefault();
    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Si sales del formulario, perderás los cambios no guardados.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, salir',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = destination;
        }
    });
}

$(function () {
    $('[data-bs-toggle="tooltip"]').tooltip();
});