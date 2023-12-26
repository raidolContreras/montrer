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
            }
        ]
    });
});
