$(document).ready(function () {
    obtenerCuentas();
    
    $("#editPartidaForm").submit(function (e) {
        e.preventDefault(); // Prevenir recarga de la página

        // Obtener los valores de los campos
        const partidaId = $("#partidaId").val();
        const partida = $("#partida").val().trim();
        const codigoPartida = $("#codigoPartida").val().trim();
        const cuenta = $("#cuenta").val().trim();

        // Validar los campos
        if (partida === "") {
            showAlertBootstrap('!Atención¡', 'Por favor, ingresa el nombre de la partida.');
            $("#nombrePartida").focus();
            return;
        }
        
        if (cuenta === "") {
            showAlertBootstrap('!Atención¡', 'Por favor, ingresa el nombre de la cuenta.');
            $("#cuenta").focus();
            return;
        }

        if (codigoPartida === "") {
            showAlertBootstrap('!Atención¡', 'Por favor, ingresa el código de la partida.');
            $("#codigoPartida").focus();
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
                editPartidaId: partidaId,
                editPartida: partida,
                editCodigoPartida: codigoPartida,
                editCuenta: cuenta
            },
            success: function (response) {
                if (response === "ok") {
                    showAlertBootstrap1('Operación realizada', 'Partida actualizada exitosamente', 'partidas');
                } else {
                    alert("Error al actualizar la partida.");
                }
            },
            error: function () {
                alert("Hubo un problema al actualizar la partida.");
            },
            complete: function () {
                submitButton.prop("disabled", false).text("Guardar cambios");
            }
        });
    });

    // Manejar el botón de cancelar
    $("#cancelButton").click(function () {
        if (confirm("¿Estás seguro de que deseas cancelar los cambios?")) {
            window.location.href = "listaPartidas"; // Cambia a la ruta de la lista de partidas
        }
    });
});


$('.auto-format').on('input', function() {
    console.log('a');
    let input = $(this).val().replace(/\D/g, ''); // Elimina cualquier carácter no numérico
    let formatted = '';

    if (input.length > 3) {
        formatted += input.substring(0, 3);
    } else {
        formatted = input;
    }

    $(this).val(formatted);
});


function obtenerCuentas() {
    $.ajax({
        type: 'POST',
        url: 'controller/ajax/getAccounts.php',
        success: function (response) {
            let accounts = JSON.parse(response);
            let select = $('#cuenta');
            let idCuenta = $('#idCuenta').val();
            select.empty(); // Limpia el select para volver a llenarlo
            select.append(`<option value="">Seleccione una cuenta</option>`); // Opción predeterminada

            // Asegúrate de que cada atributo se asigne correctamente
            accounts.forEach(account => {
                let selected = (idCuenta == account.idCuenta) ? 'selected' : '';
                select.append(`<option value="${account.idCuenta}" data-areaCode="${account.areaCode}" data-accountCode="${account.numeroCuenta}" ${selected}>${account.nameArea} - ${account.cuenta}</option>`);
            });
        },
        error: function () {
            showAlertBootstrap('!Error', 'Hubo un problema al obtener las áreas.');
        }
    });
}

// Evento para manejar el cambio de cuentas
$('#cuenta').on('change', function() {
    let selectedOption = $(this).find(':selected'); // Obtiene la opción seleccionada
    let selectedAccountId = selectedOption.val();
    let areaCode = selectedOption.attr('data-areaCode'); // Utiliza .attr() para acceder al atributo directamente
    let accountCode = selectedOption.attr('data-accountCode');
    let codigoPartida = $('#codigoPartida');

    if (selectedAccountId != "") {
        codigoPartida.prop("disabled", false);
        $('.areaCode').text(areaCode+'-'+accountCode+'-');
        $('.endCode').text('-000');
    } else {
        codigoPartida.prop("disabled", true);
        $('.areaCode').text('');
        $('.endCode').text('');
    }
});
