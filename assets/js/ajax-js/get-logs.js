$(document).ready(function () {
    var registerValue = $('#register-value').data('register');
	moment.locale('es');
    $('#Logs').DataTable({
        ajax: {
            type: 'POST',
            url: 'controller/ajax/getLogs.php',
            data: {'log': registerValue}, // Agrega el valor de register a la solicitud
            dataType: 'json',
            dataSrc: ''
        },
        columns: [
            {
				data: null,
                render: function (data, type, row, meta) {
                // Utilizando el contador proporcionado por DataTables
                return meta.row + 1;
				}
            },
            { 
                data: 'actionType'
            },
            { 
                data: 'ipAddress'
            },
            {
                data: 'timestamp',
				render: function (data) {
					return moment(data).format('DD/MM/YY, HH:mm');
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
            "infoEmpty":      "Sin resultados",
            "emptyTable":     " "
        },
        initComplete: function () {
            // Función ejecutada después de que DataTable se ha inicializado completamente
            var table = $('#Logs').DataTable();
            var data = table.rows().data(); // Obtener los datos de todas las filas
            
            // Iterar sobre los datos para obtener firstname y lastname
            data.each(function (row, index) {
                // Solo necesitas asignar el valor en la primera iteración
                if (index === 0) {
                    userName = row.firstname + ' ' + row.lastname;
                    $('.logs').html(`
                        <h3>Registro de eventos</h3>
                        <p>${userName}</p>
                    `);
                }
            });

        }
    });
});