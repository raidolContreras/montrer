$(document).ready(function () {
    $('#registers').DataTable({
        ajax: {
            url: 'controller/ajax/getUsers.php',
            dataSrc: ''
        },
        columns: [
            { data: 'idUsers' },
            { 
                data: null,
                render: function(data) {
                    return data.firstname + ' ' + data.lastname;
                }
            },
            { data: 'email' },
            { data: 'createDate' },
            { data: 'lastConection' },
            { 
                data: null,
                render: function(data){
                    var idUser = data.idUsers;
                    return '<div class="btn-group" role="group">' +
                           '<button type="button" class="btn btn-success edit-button" data-id="' + idUser + '"><i class="ri-edit-line"></i> Editar</button>' +
                           '<button type="button" class="btn btn-danger disable-button" data-id="' + idUser + '"><i class="ri-forbid-line"></i> Inhabilitar</button>' +
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

    // Manejar el clic del botón de edición
    $('#registers').on('click', '.edit-button', function() {
        var idUser = $(this).data('id');
        sendForm('editRegister', idUser);
    });

    // Manejar el clic del botón de inhabilitar
    $('#registers').on('click', '.disable-button', function() {
        var idUser = $(this).data('id');
        sendForm('disableUser', idUser);
    });

    function sendForm(action, idUser) {
        // Crear un formulario oculto y agregar el idUser como un campo oculto
        var form = $('<form action="' + action + '" method="post"></form>');
        form.append('<input type="hidden" name="register" value="' + idUser + '">');

        // Adjuntar el formulario al cuerpo del documento y enviarlo
        $('body').append(form);
        form.submit();
    }
});
