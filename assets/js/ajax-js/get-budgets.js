$(document).ready(function () {
    $('#budgets').DataTable({
        ajax: {
            url: 'controller/ajax/getBudgets.php',
            dataSrc: ''
        },
        columns: [
            { data: 'idBudget' },
            { data: 'nameArea' },
            { 
                data: 'AuthorizedAmount',
                render: function(data, type, row) {
                    
                
                    if (type === 'display' || type === 'filter') {
                        // Formatear como pesos
                        var formattedBudget = parseFloat(data).toLocaleString('es-MX', {
                            style: 'currency',
                            currency: 'MXN'
                        });
                        return formattedBudget; // Cambia 'es-MX' según tu localización
                    }
                    return data;
                }
            },
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
