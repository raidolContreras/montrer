$(document).ready(function () {
    getAreas();
});

function getAreas() {
    // Realiza la solicitud AJAX para obtener las áreas
    $.ajax({
        type: 'GET',
        url: 'controller/ajax/getAreas.php',
        success: function (response) {
            // Imprime la respuesta en la consola para depuración
            console.log('Respuesta del servidor:', response);

            // Verifica que la respuesta sea válida y tenga datos
            if (response && Array.isArray(response) && response.length > 0) {
                // Obtén el elemento select por su ID
                var areaSelect = document.getElementById('area');

                // Limpia cualquier opción existente en el select
                areaSelect.innerHTML = '';

                // Accede directamente al primer elemento del array
                var area = response[0];

                // Crea una opción basada en los datos del primer elemento
                var option = document.createElement('option');
                option.value = area.idArea; // Ajusta esto según tu estructura de datos
                option.text = area.firstname; // Ajusta esto según tu estructura de datos

                // Agrega la opción al select
                areaSelect.add(option);
            } else {
                console.log('La respuesta del servidor no contiene áreas válidas.');
            }
        },
        error: function (error) {
            console.log('Error en la solicitud AJAX:', error);
        }
    });
}
