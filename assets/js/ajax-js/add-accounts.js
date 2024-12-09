var bandera = 0;
$(document).ready(function () {
    obtenerAreas();
    // Detectar cambios en cualquier campo del formulario y establecer la bandera a 1
    $("form.account-wrap input, form.account-wrap select").change(function() {
        bandera = 1;
    });
	
    // Manejar el evento submit del formulario
    $("#accountForm").submit(function (e) {
        e.preventDefault(); // Prevenir la recarga de la página

        // Obtener los valores de los campos
        const cuenta = $("#cuenta").val().trim();
        const numeroCuenta = $("#numeroCuenta").val().trim();
        const area = $("#area").val();

        // Validar los campos
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
            url: "controller/ajax/ajax.form.php", // Cambia esta URL según tu backend
            method: "POST",
            data: {
                cuenta: cuenta,
                numeroCuenta: numeroCuenta,
                area: area
            },
            success: function (response) {
                // Manejar la respuesta del servidor
                if (response == "ok") {
					showAlertBootstrap3('Cuenta creada exitosamente.', '¿Agregar otra cuenta?', 'registerCuenta' , 'cuentas');
                } else {
					showAlertBootstrap('!Atención¡', 'Error al crear la cuenta.');
                }
            },
            error: function () {
                showAlertBootstrap('!Error', 'Hubo un problema al registrar la cuenta. Inténtalo de nuevo.');
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

function confirmExit(event, destination) {
	if (bandera == 1){
		event.preventDefault();
		showAlertBootstrap2('¿Está seguro?', 'Si sale del formulario, perderá los cambios no guardados.', destination);
	}
}

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
