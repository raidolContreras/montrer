$(document).ready(function () {
    getAreas();
});

function getAreas() {
    var idUser = $('input[name="user"]').val();
    // Realiza la solicitud AJAX para obtener las áreas
    $.ajax({
        type: 'POST',
        url: 'controller/ajax/countArea.php',
        data: {idUser: idUser},
        dataType: 'json', // Asegúrate de indicar que esperas un objeto JSON
        success: function (response) {
            var comp = parseFloat(response.comp).toLocaleString('es-MX', {
                style: 'currency',
                currency: 'MXN'
            });

            var nocomp = parseFloat(response.nocomp).toLocaleString('es-MX', {
                style: 'currency',
                currency: 'MXN'
            });

            $('.comp').text(comp);

            $('.nocomp').text(nocomp);

            $('.budget-message-compr').text('Presupuesto comprobado en el ' + response.name + '.');
            $('.budget-message-no-compr').text('Presupuesto sin comprobar en el ' + response.name + '.');
        },
        error: function (error) {
            console.log('Error en la solicitud AJAX:', error);
        }
    });
}
