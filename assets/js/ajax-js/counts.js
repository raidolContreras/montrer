$(document).ready(function () {
    getAreas();
});

function getAreas() {
    // Realiza la solicitud AJAX para obtener las áreas
    $.ajax({
        type: 'GET',
        url: 'controller/ajax/countAreas.php',
        data: {},
        dataType: 'json', // Asegúrate de indicar que esperas un objeto JSON
        success: function (response) {
            // Verifica que la respuesta sea válida y tenga datos
            if (response && typeof response.areas !== 'undefined') {
                // Accede al campo "areas" y actualiza el contenido de la clase "count-area"
                $('.count-user').text(response.users);
                $('.count-area').text(response.areas);
                $('.exercise').text(response.name);

                var formattedBudget = parseFloat(response.budget).toLocaleString('es-MX', {
                    style: 'currency',
                    currency: 'MXN'
                });

                var formattedRest = parseFloat(response.remaining).toLocaleString('es-MX', {
                    style: 'currency',
                    currency: 'MXN'
                });

                var spent = parseFloat(response.spent).toLocaleString('es-MX', {
                    style: 'currency',
                    currency: 'MXN'
                });

                var exercisable_budget = parseFloat(response.exercisable_budget).toLocaleString('es-MX', {
                    style: 'currency',
                    currency: 'MXN'
                });

                var totalUse = parseFloat(response.budget - response.remaining);
                var percentageUsed = (totalUse / response.budget) * 100;
                var formattedPercentageUsed = percentageUsed.toLocaleString('es-MX', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });

                $('.budget').text(formattedBudget);

                $('.spent').text(spent);

                $('.exercisable_budget').text(exercisable_budget);
                
                $('.rest').html(formattedRest + ' <span>' + (100 - formattedPercentageUsed).toFixed(2) + '%</span>');

                $('.total-use').html(totalUse.toLocaleString('es-MX', {
                    style: 'currency',
                    currency: 'MXN'
                }) + ' <span>' + formattedPercentageUsed + '%</span>');

                $('.budget-message').text('Presupuesto aprobado ' + response.name + '.');
                $('.budget-message-uses').text('Presupuesto utilizado en el ' + response.name + '.');
                $('.budget-message-rest').text('Presupuesto restante en el ' + response.name + '.');
                $('.budget-message-soli').text('Presupuesto solicitado en el ' + response.name + '.');
                $('.budget-message-spent').text('Presupuesto ejercido en el ' + response.name + '.');
                $('.budget-message-exercisable-budget').text('Presupuesto por comprobar en el ' + response.name+ '.');
            } else {
                console.log('La respuesta del servidor no contiene respuestas válidas.');
            }
        },
        error: function (error) {
            console.log('Error en la solicitud AJAX:', error);
        }
    });
}
