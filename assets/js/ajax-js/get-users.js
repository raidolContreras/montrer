$(document).ready(function () {
    $('#registers').DataTable({
        ajax: {
            url: 'controller/ajax/getUsers.php', // Cambia el nombre del script PHP según tu estructura de archivos
            dataSrc: ''
        },
        columns: [
            { data: 'idUsers' },
            { 
                data: null,
                render: function(data, type, row) {
                    // Combina los campos de nombre y apellido en una sola columna
                    return data.firstname + ' ' + data.lastname;
                }
            },
            { data: 'email' },
            { data: 'createDate' },
            { data: 'lastConection' }
        ]
    });
});