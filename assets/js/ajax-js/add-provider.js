$(document).ready(function () {
    $("form.account-wrap").submit(function (event) {
        event.preventDefault();

        // Recoge los valores del formulario del proveedor
        var providerKey = $("input[name='providerKey']").val();
        var fields = {
            representativeName: $("input[name='representativeName']").val(),
            contactPhone: $("input[name='contactPhone']").val(),
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
        if (!validateField('businessName') ||
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

        // Realizar la solicitud Ajax
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

                    // Mostrar mensaje de éxito
                    Swal.fire({
                        icon: "success",
                        title: 'Proveedor creado exitosamente',
                        icon: "success"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    });
                } else {
                    // Mostrar mensaje de error
                    Swal.fire({
                        icon: 'error',
                        title: 'Error al crear el proveedor',
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