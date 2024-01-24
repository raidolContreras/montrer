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
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });

        // Función de validación
        function validateField(fieldName, errorMessage) {
            if (!fields[fieldName]) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Advertencia',
                    text: errorMessage,
                });
                return false;
            }
            return true;
        }

        // Validar campos requeridos
        if (!validateField('businessName', 'Por favor, ingrese la razón social del proveedor.') ||
            !validateField('rfc', 'Por favor, ingrese el RFC del proveedor.') ||
            !validateField('contactPhone', 'Por favor, ingrese el teléfono de contacto del proveedor.') ||
            !validateField('fiscalAddressStreet', 'Por favor, ingrese la calle de la dirección fiscal del proveedor.') ||
            !validateField('fiscalAddressColonia', 'Por favor, ingrese la colonia de la dirección fiscal del proveedor.') ||
            !validateField('fiscalAddressMunicipio', 'Por favor, ingrese el municipio de la dirección fiscal del proveedor.') ||
            !validateField('fiscalAddressEstado', 'Por favor, ingrese el estado de la dirección fiscal del proveedor.') ||
            !validateField('fiscalAddressCP', 'Por favor, ingrese el código postal de la dirección fiscal del proveedor.') ||
            !validateField('bankName', 'Por favor, ingrese el nombre de la entidad bancaria del proveedor.') ||
            !validateField('accountHolder', 'Por favor, ingrese el titular de la cuenta bancaria del proveedor.') ||
            !validateField('accountNumber', 'Por favor, ingrese el número de cuenta bancaria del proveedor.')
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
