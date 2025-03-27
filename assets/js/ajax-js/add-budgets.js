var bandera = 0;
$(document).ready(function () {

    // Detectar cambios en cualquier campo del formulario y establecer la bandera a 1
    $("form.account-wrap input, form.account-wrap select").change(function() {
        bandera = 1;
    });

    $("form.account-wrap").submit(function (event) {
        // Evitar el envío del formulario por defecto
        event.preventDefault();

        // Recoge los valores del formulario
        var area = $("select[name='area']").val();
        var AuthorizedAmount = $("input[name='AuthorizedAmount']").val();
        var exercise = $("select[name='exercise']").val();

        if (area == '' || AuthorizedAmount == '' || exercise == ''){
            
            showAlertBootstrap('¡Atención!', 'Por favor, introduzca la información solicitada en todos lo campos señalados con un (*).');

		} else {
            // Realiza la solicitud Ajax
            $.ajax({
                type: "POST",
                url: "controller/ajax/ajax.form.php",
                data: {
                    area: area,
                    AuthorizedAmount: AuthorizedAmount,
                    exercise: exercise
                },
                success: function (response) {

                    if (response === 'ok') {
                        
						bandera = 0;
                        $("select[name='area']").val('');
                        $("input[name='AuthorizedAmount']").val('');
                        $("select[name='exercise']").val('');
                        
	                    showAlertBootstrap3('Presupuesto asignado correctamente.', '¿Agregar otro presupuesto?', 'registerBudgets' , 'budgets');

                    } else if (response === 'Error: Presupuesto ya asignado') {
                        
	                    showAlertBootstrap3('!Atención¡', 'Presupuesto ya asignado a esta área.');

                    } else {
	                    showAlertBootstrap3('!Atención¡', 'Error al asignar el presupuesto.');
                    }
                },
                error: function (error) {
                    console.log("Error en la solicitud Ajax:", error);
                }
            });
        }
    });
});

// Esperar a que el documento esté listo
document.addEventListener('DOMContentLoaded', function () {
	// Obtener el botón de cancelar por su ID
	var cancelButton = document.getElementById('cancelButton');

	// Agregar un evento de clic al botón de cancelar
	cancelButton.addEventListener('click', function (event) {
		// Prevenir el comportamiento predeterminado del enlace
		event.preventDefault();

		showAlertBootstrap2('Cancelar', '¿Seguro que desea cancelar?', 'budgets');
        
	});
});

function confirmExit(event, destination) {
	if (bandera == 1){
		event.preventDefault();
		showAlertBootstrap2('¿Está seguro?', 'Si sale del formulario, perderá los cambios no guardados.', destination);
	}
}

// al cambiar el area que se carguen sus departamentos

$("#area").change(function () {
    var area = $(this).val();
    $.ajax({
        type: "POST",
        url: "controller/ajax/ajax.form.php",
        data: {
            action: 'getPartidas',
            idAreaToPartidas: area
        },
        dataType: "json",
        success: function (response) {
            //rellenar select de #partidas
            $("#partidas").empty();
            $.each(response, function (index, value) {
                $("#partidas").append('<option value="' + value.idPartida + '">' + value.Partida + '</option>');
            });
            $("#partidas").prop('disabled', false);
        },
        error: function (error) {
            console.log("Error en la solicitud Ajax:", error);
        }
    });
});