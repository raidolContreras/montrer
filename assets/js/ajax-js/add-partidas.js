var bandera = 0;
$(document).ready(function () {
    
    // Detectar cambios en cualquier campo del formulario y establecer la bandera a 1
    $("form.partida-wrap input, form.partida-wrap select").change(function() {
        bandera = 1;
    });
	
    // Manejar el evento submit del formulario
    $("#partidaForm").submit(function (e) {
        e.preventDefault(); // Prevenir la recarga de la página

        // Obtener los valores de los campos
        const partida = $("#nombrePartida").val().trim();
        const codigoPartida = $("#codigoPartida").val().trim();

        // Validar los campos
        if (partida === "") {
            alert("Por favor, ingresa el nombre de la partida.");
            $("#nombrePartida").focus();
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
            url: "controller/ajax/ajax.form.php", // Cambia esta URL según tu backend
            method: "POST",
            data: {
                partida: partida,
                codigoPartida: codigoPartida
            },
            success: function (response) {
                // Manejar la respuesta del servidor
                if (response == "ok") {
					showAlertBootstrap3('Partida creada exitosamente.', '¿Agregar otra partida?', 'registerPartida' , 'partidas');
                } else {
					showAlertBootstrap('!Atención¡', 'Error al crear la partida.');
                }
            },
            error: function () {
                showAlertBootstrap('!Error', 'Hubo un problema al registrar la partida. Inténtalo de nuevo.');
            },
            complete: function () {
                // Rehabilitar el botón y restaurar el texto
                submitButton.prop("disabled", false).text("Aceptar");
            }
        });
    });

    // Manejar el botón de cancelar
    $("#cancelButton").click(function () {
        if (confirm("¿Estás seguro de que deseas cancelar el registro?")) {
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

function confirmExit(event, destination) {
	if (bandera == 1){
		event.preventDefault();
		showAlertBootstrap2('¿Está seguro?', 'Si sale del formulario, perderá los cambios no guardados.', destination);
	}
}
