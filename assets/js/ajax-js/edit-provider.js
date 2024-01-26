$(document).ready(function () {
    $("form.account-wrap").submit(function (event) {
        event.preventDefault();

        // Recoge los valores del formulario del proveedor
        var providerKey = $("input[name='providerKey']").val();
        var fields = {
            updaterepresentativeName: $("input[name='representativeName']").val(),
            updatecontactPhone: $("input[name='contactPhone']").val(),
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
