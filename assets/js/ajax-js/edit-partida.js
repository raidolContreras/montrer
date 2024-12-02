$(document).ready(function () {
    $("#editPartidaForm").submit(function (e) {
        e.preventDefault(); // Prevenir recarga de la página

        // Obtener los valores de los campos
        const partidaId = $("#partidaId").val();
        const partida = $("#partida").val().trim();
        const codigoPartida = $("#codigoPartida").val().trim();

        // Validar campos
        if (partida === "") {
            alert("Por favor, ingresa el nombre de la partida.");
            $("#partida").focus();
            return;
        }

        if (codigoPartida === "") {
            alert("Por favor, ingresa el código de la partida.");
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
                editCodigoPartida: codigoPartida
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
        formatted += input.substring(0, 3) + '-';
        if (input.length > 6) {
            formatted += input.substring(3, 6);
        } else {
            formatted += input.substring(3);
        }
    } else {
        formatted = input;
    }

    $(this).val(formatted);
});