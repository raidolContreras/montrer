var bandera = 0;

$(document).ready(function () {
    var $form = $("form.account-wrap");

    // Detecta cambios en cualquier input o select del formulario y marca bandera
    $form.find("input, select").on("change", function () {
        bandera = 1;
    });

    // Maneja el envío del formulario
    $form.on("submit", function (event) {
        event.preventDefault();

        var area = $form.find("select[name='area']").val();
        var partida = $form.find("select[name='partida']").val();
        var AuthorizedAmount = $form.find("input[name='AuthorizedAmount']").val();
        var exercise = $form.find("select[name='exercise']").val();

        if (area === "" || AuthorizedAmount === "" || exercise === "") {
            showAlertBootstrap('¡Atención!', 'Por favor, introduzca la información solicitada en todos los campos señalados con un (*).');
            return;
        }

        $.ajax({
            type: "POST",
            url: "controller/ajax/ajax.form.php",
            data: { area, AuthorizedAmount, exercise, partida },
            success: function (response) {
                if (response === 'ok') {
                    bandera = 0;
                    // Resetea los campos del formulario
                    $form.find("select[name='area'], input[name='AuthorizedAmount'], select[name='exercise']").val('');

                    var $partidaSelect = $('#partida');
                    $partidaSelect.empty().append($('<option>', {
                        value: '',
                        text: 'Selecciona un area primero'
                    })).prop('disabled', true);
                    
                    showAlertBootstrap3('Presupuesto asignado correctamente.', '¿Agregar otro presupuesto?', 'registerBudgets', 'budgets');
                } else if (response === 'Error: Presupuesto ya asignado') {
                    showAlertBootstrap('¡Atención!', 'Presupuesto ya asignado a esta área o partida.');
                } else {
                    showAlertBootstrap('¡Atención!', 'Error al asignar el presupuesto.');
                }
            },
            error: function (error) {
                console.log("Error en la solicitud Ajax:", error);
            }
        });
    });

    // Maneja el clic del botón de cancelar
    $("#cancelButton").on("click", function (event) {
        event.preventDefault();
        showAlertBootstrap2('Cancelar', '¿Seguro que desea cancelar?', 'budgets');
    });
});

// Función para prevenir la salida del formulario si hay cambios sin guardar
function confirmExit(event, destination) {
    if (bandera === 1) {
        event.preventDefault();
        showAlertBootstrap2('¿Está seguro?', 'Si sale del formulario, perderá los cambios no guardados.', destination);
    }
}
