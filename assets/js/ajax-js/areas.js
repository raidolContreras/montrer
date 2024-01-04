$(document).ready(function () {
    getAreas();
});

function getAreas() {
    // Realiza la solicitud AJAX para obtener las áreas
    $.ajax({
        type: 'GET',
        url: 'controller/ajax/getAreas.php',
        dataType: 'json', // Asegúrate de indicar que esperas un objeto JSON
        success: function (response) {

            // Verifica que la respuesta sea válida y tenga datos
            if (response && Array.isArray(response) && response.length > 0) {
                // Obtén el elemento select por su ID
                var areaSelect = document.getElementById('area');

                // Limpia cualquier opción existente en el select
                areaSelect.innerHTML = '';

                var option = document.createElement('option');
                option.value = '';
                option.text = 'Selecciona un area'; // Ajusta esto según tu estructura de datos
                areaSelect.add(option);
                // Recorre la lista de áreas y agrega cada una como una opción al select
                response.forEach(function (area) {
                    var option = document.createElement('option');
                    option.value = area.idArea; // Ajusta esto según tu estructura de datos
                    option.text = area.nameArea; // Ajusta esto según tu estructura de datos
                    areaSelect.add(option);
                });
            } else {
                console.log('La respuesta del servidor no contiene áreas válidas.');
            }
        },
        error: function (error) {
            console.log('Error en la solicitud AJAX:', error);
        }
    });
}
