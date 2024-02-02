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

        function validateField(fieldName) {
            if (!fields[fieldName]) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Advertencia',
                    text: 'Por favor, introduzca la información solicitada en todos lo campos señalados con un (*).',
                    confirmButtonColor: '#026f35',
                    confirmButtonText: 'Aceptar'
                });
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

                    Swal.fire({
                        icon: "success",
                        title: 'Proveedor creado exitosamente',
                        text: '¿Desea agregar otro proveedor?',
                        showCancelButton: true,
                        cancelButtonColor: '#d33',
                        confirmButtonColor: '#026f35',
                        cancelButtonText: 'Cancelar',
                        confirmButtonText: 'Aceptar',
                        reverseButtons: true,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        } else {
                            window.location.href = "provider";
                        }
                    });

                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error al crear el proveedor',
                        confirmButtonColor: '#026f35',
                        confirmButtonText: 'Aceptar'
                    });
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
        event.preventDefault();

        Swal.fire({
            title: '¿Seguro que deseas cancelar?',
            icon: 'warning',
			showCancelButton: true,
			cancelButtonColor: '#d33',
			confirmButtonColor: '#026f35',
			cancelButtonText: 'Cancelar',
			confirmButtonText: 'Aceptar',
			reverseButtons: true,
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "provider";
            }
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
        cancelButtonColor: '#d33',
        confirmButtonColor: '#026f35',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Aceptar',
        reverseButtons: true,
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = destination;
        }
    });
}

$(function () {
    $('[data-bs-toggle="tooltip"]').tooltip();
});