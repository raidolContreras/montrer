$(document).ready(function () {
    $("#editAccountForm").submit(function (e) {
        e.preventDefault(); // Prevenir recarga de la página

        // Obtener los valores de los campos
        const accountId = $("#accountId").val();
        const cuenta = $("#cuenta").val().trim();
        const numeroCuenta = $("#numeroCuenta").val().trim();
        const area = $("#area").val();

        // Validar campos
        if (cuenta === "") {
            showAlertBootstrap('!Atención¡', 'Por favor, ingresa el nombre de la cuenta.');
            $("#cuenta").focus();
            return;
        }
        
        if (area === "") {
            showAlertBootstrap('!Atención¡', 'Por favor, selecciona un área.');
            $("#area").focus();
            return;
        }

        if (numeroCuenta === "") {
            showAlertBootstrap('!Atención¡', 'Por favor, ingresa el número de cuenta.');
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
                editNumeroCuenta: numeroCuenta,
                editArea: area
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
    if (input.length > 3) {
        formatted += input.substring(0, 3);
    } else {
        formatted = input;
    }

    $(this).val(formatted);
});

function obtenerAreas() {
    $.ajax({
        type: 'POST',
        url: 'controller/ajax/getAreas.php',
        success: function (response) {
            let areas = JSON.parse(response);
            let select = $('#area');
            select.empty(); // Limpia el select para volver a llenarlo
            select.append(`<option value="">Seleccione un departamento</option>`); // Opción predeterminada

            // Asegúrate de que cada atributo se asigne correctamente
            areas.forEach(area => {
                select.append(`<option value="${area.idArea}" data-areaCode="${area.areaCode}">${area.nameArea}</option>`);
            });
        },
        error: function () {
            showAlertBootstrap('!Error', 'Hubo un problema al obtener las áreas.');
        }
    });
}

// Evento para manejar el cambio de área
$('#area').on('change', function() {
    let selectedOption = $(this).find(':selected'); // Obtiene la opción seleccionada
    let selectedAreaId = selectedOption.val();
    let areaCode = selectedOption.attr('data-areaCode'); // Utiliza .attr() para acceder al atributo directamente
    let numeroCuenta = $('#numeroCuenta');

    if (selectedAreaId != "") {
        numeroCuenta.prop("disabled", false);
        $('.areaCode').text(areaCode);
        $('.endCode').text('000-000');
    } else {
        numeroCuenta.prop("disabled", true);
        $('.areaCode').text('');
        $('.endCode').text('');
    }
});
