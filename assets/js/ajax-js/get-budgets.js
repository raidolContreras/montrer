$(document).ready(function () {
    $('#budgets').DataTable({
        ajax: {
            url: 'controller/ajax/getBudgets.php',
            dataSrc: ''
        },
        columns: [
            { data: 'idBudget' },
            { data: 'nameArea' },
            { data: 'AuthorizedAmount' },
            { data: 'exerciseName' },
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
