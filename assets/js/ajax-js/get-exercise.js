$(document).ready(function () {
    moment.locale('es');
    var exerciseTable = $('#exercise').DataTable({
        ajax: {
            url: 'controller/ajax/getExercises.php',
            dataSrc: ''
        },
        columns: [
            { data: 'idExercise' },
            { 
                data: null,
                render: function(data, type, row) {
                    // Combina los campos de nombre y apellido en una sola columna y agrega un botón
                    return data.exerciseName;
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
            {
                data: null,
                render: function(data) {
                    if (data.status == 0) {
                        return '<div class="d-grid gap-2"><button data-exercise="' + data.idExercise + '" class="btn btn-success activate-btn mb-0 py-1 mx-3">Activar</button></div>';
                    } else {
                        console.log(data.exerciseName);
                        return '<div class="alert alert-success mb-0 py-1 mx-3" role="alert"><div class="d-flex justify-content-center"><i class="ri-check-line"></i><p>Activo</p></div></div>';
                    }
                }                
            }
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

    // Agrega un evento de clic al botón "Activar"
    $('#exercise').on('click', '.activate-btn', function () {
        var idExercise = $(this).data('exercise');

        // Realiza la solicitud Ajax a exerciseOn.php con el idExercise
        $.ajax({
            type: "POST",
            url: "controller/ajax/exerciseOn.php",
            data: { idExercise: idExercise },
            success: function (response) {
                exerciseTable.ajax.reload();
            },
            error: function (error) {
                console.log("Error en la solicitud Ajax:", error);
            }
        });
    });
});
