var bandera = 0;
$(document).ready(function () {

    // Detectar cambios en cualquier campo del formulario y establecer la bandera a 1
    $("form.account-wrap input, form.account-wrap select").change(function() {
        bandera = 1;
    });

    $("#companyForm").submit(function (event) {
        // Evitar el envío del formulario por defecto
        event.preventDefault();

        // Recoge los valores del formulario
        var companyName = $("#companyName").val();
        var companyDescription = $("#companyDescription").val();

        // Realiza la solicitud Ajax
        $.ajax({
            type: "POST",
            url: "controller/ajax/ajax.form.php",
            data: {
                companyName: companyName,
                companyDescription: companyDescription,
            },
            success: function (response) {

                if (response !== 'Error') {
                    
                    showAlertBootstrap('', 'Empresa creada exitosamente.');

					// Vaciar los campos del formulario
					$("#companyName").val("");
					$("#companyDescription").val("");
                    bandera = 0;

                } else {
                    
                    showAlertBootstrap('!Atención¡', response);
                    
                }
            },
            error: function (error) {
                console.log("Error en la solicitud Ajax:", error);
            }
        });
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
		showAlertBootstrap2('Cancelar', '¿Seguro que desea cancelar?', 'company');

	});
});

function confirmExit(event, destination) {
	if (bandera == 1){
		event.preventDefault();
		showAlertBootstrap2('¿Está seguro?', 'Si sale del formulario, perderá los cambios no guardados.', 'company');
	}
}