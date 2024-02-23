$(document).ready(function () {
    $("form.account-wrap").submit(function (event) {
        // Evitar el envío del formulario por defecto
        event.preventDefault();

        // Recoge los valores del formulario
        var area = $("select[name='area']").val();
        var AuthorizedAmount = $("input[name='AuthorizedAmount']").val();
        var exercise = $("select[name='exercise']").val();

        if (area == '' || AuthorizedAmount == '' || exercise == ''){
            
            showAlertBootstrap('Advertencia', 'Por favor, introduzca la información solicitada en todos lo campos señalados con un (*).');

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
                        $("select[name='area']").val('');
                        $("input[name='AuthorizedAmount']").val('');
                        $("select[name='exercise']").val('');
                        
	                    showAlertBootstrap3('Presupuesto asignado correctamente.', '¿Agregar otro presupuesto?', 'registerBudgets' , 'budgets');

                    } else if (response === 'Error: Presupuesto ya asignado') {
                        
	                    showAlertBootstrap3('Error', 'Presupuesto ya asignado a esta área.');

                    } else {
	                    showAlertBootstrap3('Error', 'Error al asignar el presupuesto.');
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

		showAlertBootstrap2('Cancelar', '¿Seguro que deseas cancelar?', 'budgets');
        
	});
});

function confirmExit(event, destination) {
    event.preventDefault();
    
	showAlertBootstrap2('¿Estás seguro?', 'Si sales del formulario, perderás los cambios no guardados.', destination);
    
}
