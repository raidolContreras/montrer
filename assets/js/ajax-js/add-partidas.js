var bandera = 0;
$(document).ready(function () {
    obtenerCuentas();
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
            url: "controller/ajax/ajax.form.php", // Cambia esta URL según tu backend
            method: "POST",
            data: {
                partida: partida,
                codigoPartida: codigoPartida,
                cuenta: cuenta
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
        formatted += input.substring(0, 3);
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

function obtenerCuentas() {
    $.ajax({
        type: 'POST',
        url: 'controller/ajax/getAccounts.php',
        success: function (response) {
            let accounts = JSON.parse(response);
            let select = $('#cuenta');
            select.empty(); // Limpia el select para volver a llenarlo
            select.append(`<option value="">Seleccione una cuenta</option>`); // Opción predeterminada

            // Asegúrate de que cada atributo se asigne correctamente
            accounts.forEach(account => {
                select.append(`<option value="${account.idCuenta}" data-areaCode="${account.areaCode}" data-accountCode="${account.numeroCuenta}">${account.nameArea} - ${account.cuenta}</option>`);
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
