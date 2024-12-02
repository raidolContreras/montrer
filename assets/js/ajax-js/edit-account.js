$(document).ready(function () {
    $("#editAccountForm").submit(function (e) {
        e.preventDefault(); // Prevenir recarga de la página

        // Obtener los valores de los campos
        const accountId = $("#accountId").val();
        const cuenta = $("#cuenta").val().trim();
        const numeroCuenta = $("#numeroCuenta").val().trim();

        // Validar campos
        if (cuenta === "") {
            alert("Por favor, ingresa el nombre de la cuenta.");
            $("#cuenta").focus();
            return;
        }

        if (numeroCuenta === "") {
            alert("Por favor, ingresa el número de cuenta.");
            $("#numeroCuenta").focus();
            return;
        }

        // Mostrar un mensaje de carga (opcional)
        const submitButton = $(this).find('button[type="submit"]');
        submitButton.prop("disabled", true).text("Guardando...");

        // Enviar los datos al backend usando AJAX
        $.ajax({
            url: "controller/ajax/ajax.form.php",
            method: "POST",
            data: {
                editAccountId: accountId,
                editCuenta: cuenta,
                editNumeroCuenta: numeroCuenta
            },
            success: function (response) {
                if (response === "ok") {
                    showAlertBootstrap1('Operación realizada', 'Cuenta actualizada exitosamente', 'cuentas');
                } else {
                    alert("Error al actualizar la cuenta.");
                }
            },
            error: function () {
                alert("Hubo un problema al actualizar la cuenta.");
            },
            complete: function () {
                submitButton.prop("disabled", false).text("Guardar cambios");
            }
        });
    });

    // Manejar el botón de cancelar
    $("#cancelButton").click(function () {
        if (confirm("¿Estás seguro de que deseas cancelar los cambios?")) {
            window.location.href = "listaCuentas"; // Cambia a la ruta de la lista de cuentas
        }
    });
});

$('.auto-format').on('input', function() {
    console.log('a');
    let input = $(this).val().replace(/\D/g, ''); // Elimina cualquier carácter no numérico
    let formatted = '';

    // Aplica el formato 1000-001-001-001
    if (input.length > 4) {
        formatted += input.substring(0, 4) + '-';
        if (input.length > 7) {
            formatted += input.substring(4, 7) + '-';
            if (input.length > 10) {
                formatted += input.substring(7, 10) + '-';
                if (input.length > 13) {
                    formatted += input.substring(10, 13) + '-';
                    formatted += input.substring(13, 16);
                } else {
                    formatted += input.substring(10);
                }
            } else {
                formatted += input.substring(7);
            }
        } else {
            formatted += input.substring(4);
        }
    } else {
        formatted = input;
    }

    $(this).val(formatted);
});