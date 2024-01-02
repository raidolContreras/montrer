$(document).ready(function () {
    moment.locale('es');
    $('#exercise').DataTable({
        ajax: {
            url: 'controller/ajax/getExercises.php', // Cambia el nombre del script PHP según tu estructura de archivos
            dataSrc: ''
        },
        columns: [
            { data: 'idExercise' },
            { 
                data: null,
                render: function(data, type, row) {
                    // Combina los campos de nombre y apellido en una sola columna y agrega un botón
                    return '<a href="">' + data.exerciseName + '</a>';
                }
            },
            { 
                data: 'initialDate',
                render: function(data, type, row) {
                    return moment(data).format('DD-MMM-YYYY');
                }
            },
            { 
                data: 'finalDate',
                render: function(data, type, row) {
                    return moment(data).format('DD-MMM-YYYY');
                }
            },
            {
                data: 'budget',
                render: function (data, type, row) {
                    // Formatea el número usando toLocaleString
                    var formattedBudget = parseFloat(data).toLocaleString('es-MX', {
                        style: 'currency',
                        currency: 'MXN'
                    });

                    return formattedBudget;
                }
            },
        ],
        language: {
            "paginate": {
                "first":      "<<",
                "last":       ">>",
                "next":       ">",
                "previous":   "<"
            },
            "search":         "Buscar:",
            "lengthMenu":     "Ver _MENU_ resultados",
            "loadingRecords": "Cargando...",
            "info":           "Mostrando _START_ de _END_ en _TOTAL_ resultados",
            "infoEmpty":      "Mostrando 0 resultados",
        }
    });
});
