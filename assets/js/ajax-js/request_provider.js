// Variable global para almacenar los proveedores obtenidos
var storedProviders = null;

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
    var idUser = (level == 1) ? $("#idUser").val() : NaN;

    // Realiza la solicitud Ajax para obtener los proveedores
    $.ajax({
        type: "POST",
        url: "controller/ajax/getProviders.php",
        data: {idUser: idUser},
        dataSrc: '',
        success: function (response) {
            // Parsea y almacena la respuesta JSON en la variable global
            storedProviders = JSON.parse(response);

            // Genera las opciones del select con los proveedores almacenados
            var selectOptionsHtml = `<option value="">Seleccionar proveedor</option>`;
            storedProviders.forEach(function(provider) {
                if (provider.status === 1) {
                    selectOptionsHtml += `<option value="${provider.idProvider}">${provider.representative_name}</option>`;
                }
            });

            // Agrega la opción "Añadir proveedor" con un ícono de +
            selectOptionsHtml += `<option value="add_provider" class="add-provider-option">&#43; Añadir proveedor</option>`;
            
            $('#provider').html(selectOptionsHtml);
            $('#provider2').html(selectOptionsHtml);
            $('#providerGet').html(selectOptionsHtml);
        },
        error: function (error) {
            console.log("Error en la solicitud Ajax:", error);
        }
    });
}

// Manejar la selección de "add_provider" en el select (ejemplo adicional)
$('#provider').on('select2:select', function (e) {
    const selectedValue = e.params.data.id;
    if (selectedValue === 'add_provider') {
        $('#modalAgregarProveedor').modal('show');
    }
});

// Ejemplo de uso posterior de la variable storedProviders
function logProviders() {
    if (storedProviders) {
        console.log("Lista de proveedores almacenados:", storedProviders);
    } else {
        console.log("No se han cargado proveedores aún.");
    }
}