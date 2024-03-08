$(document).ready(function () {
    restartSelectProvider();
    // Manejador de eventos para el cambio en el select
    $('#provider').on('change', function() {
        // Verifica si la opción seleccionada es "Añadir proveedor"
        if ($(this).val() === "add_provider") {
            $('#modalAgregarProveedor').modal('show');
        }
    });
});

function restartSelectProvider() {

    // Realiza la solicitud Ajax a exerciseOn.php con el idExercise
    $.ajax({
        type: "POST",
        url: "controller/ajax/getProviders.php",
        success: function (response) {
            // Parsea la respuesta JSON
            var providers = JSON.parse(response);
            var selectOptionsHtml = `<option value="">Seleccionar proveedor</option>`;

            // Crea las opciones para el select
            providers.forEach(function(provider) {
                selectOptionsHtml += `<option value="${provider.idProvider}">${provider.representative_name}</option>`;
            });

            // Agrega la opción "Añadir proveedor"
            selectOptionsHtml += `<option value="add_provider">Añadir proveedor</option>`;
            
			$('#provider').html(selectOptionsHtml);

        },
        error: function (error) {
            console.log("Error en la solicitud Ajax:", error);
        }
    });

}

// Manejar la selección de "add_provider"
$('#provider').on('select2:select', function (e) {
    const selectedValue = e.params.data.id;
    if (selectedValue === 'add_provider') {
        $('#modalAgregarProveedor').modal('show');
    }
  });