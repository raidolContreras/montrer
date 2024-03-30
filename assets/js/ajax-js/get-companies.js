$(document).ready(function () {
    $('#companies').DataTable({
        ajax: {
            url: 'controller/ajax/getCompanies.php', // Cambia el nombre del script PHP según tu estructura de archivos
            dataSrc: ''
        },
        columns: [
            { data: 'idCompany' },
            { 
                data: null,
                render: function(data, type, row) {
                    console.log(row);
                    return '<a href="">' + data.name + '</a>';
                }
            },
            { 
                data: null,
                render: function(data, type, row) {
                    console.log(row);
                    return '<div class="image-container" align="center" style="background-color: #ececec; display: inline-block; padding: 5px;">'+
                                '<img src="assets/img/companies/' + data.idCompany + '/' + data.logo + '" width="50px" style="display: block;">'+
                            '</div>';
                }
            },
            {
                data: 'colors',
                render: function (data, type, row) {
                    var colors = JSON.parse(data); // Parsea la cadena JSON

                    // Crea un contenedor para mostrar los colores
                    var colorContainer = '<div style="display: flex; justify-content: space-between;background-color: #ccc; padding: 5px;">';

                    // Agrega un cuadro de color para cada color
                    Object.keys(colors).forEach(function (key) {
                        colorContainer += '<div style="width: 20px; height: 20px; background-color: ' + colors[key] + '; margin-right: 5px;"></div>';
                    });

                    colorContainer += '</div>';

                    return colorContainer;
                }
            },
            { data: 'description' }
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
			"emptyTable":	  "Ningún dato disponible en esta tabla"
        }
    });
});
