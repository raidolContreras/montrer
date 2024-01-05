$(document).ready(function () {
    $('#areas').DataTable({
        ajax: {
            url: 'controller/ajax/getAreas.php', // Cambia el nombre del script PHP según tu estructura de archivos
            dataSrc: ''
        },
        columns: [
            { data: 'idArea' },
            { 
                data: null,
                render: function(data, type, row) {
                    // Combina los campos de nombre y apellido en una sola columna y agrega un botón
                    return '<a href="">' + data.nameArea + '</a>';
                }
            },
            { data: 'description' },
            { 
                data: null,
                render: function(data, type, row) {
                    // Combina los campos de nombre y apellido en una sola columna y agrega un botón
                    return data.firstname + ' ' + data.lastname ;
                }
            },
            {
                data: null,
                render: function(data, type, row) {
                    var idArea = data.idArea;
                    return '<div class="btn-group" role="group">' +
                           '<button type="button" class="btn btn-success edit-button" data-id="' + idArea + '"><i class="ri-edit-line"></i> Editar</button>' +
                           '<button type="button" class="btn btn-danger disable-button" data-id="' + idArea + '"><i class="ri-forbid-line"></i> Inhabilitar</button>' +
                           '</div>';
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
});
