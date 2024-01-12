$(document).ready(function () {
    var value = 0;
    var registersData = $('#registers').DataTable({
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
                    var status = data.status;
                    if (value !== idUser){
                        value = idUser;
                        return renderActionButtons(idUser, status);
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

    // Manejar el clic del botón de edición
    $('#registers').on('click', '.edit-button', function() {
        var idUser = $(this).data('id');
        sendForm('editRegister', idUser);
    });

    $('#registers').on('click', '.disable-button', function() {
        var idUser = $(this).data('id');
        var userName = $(this).closest('tr').find('td:eq(1)').text(); // Obtener el nombre del usuario desde la fila

        // Mostrar el nombre del usuario en el modal
        $('#userName').text(userName);

        // Mostrar el modal de inhabilitar
        $('#disableModal').modal('show');

        // Manejar el clic del botón "Inhabilitar" en el modal
        $('#confirmDisable').on('click', function() {
            handleUserAction(idUser, 'disableUser', 'Usuario inhabilitado');
        });
    });

    $('#registers').on('click', '.enable-button', function() {
        var idUser = $(this).data('id');
        var userName = $(this).closest('tr').find('td:eq(1)').text(); // Obtener el nombre del usuario desde la fila

        // Mostrar el nombre del usuario en el modal
        $('#enableUserName').text(userName);

        // Mostrar el modal de habilitar
        $('#enableModal').modal('show');

        // Manejar el clic del botón "Habilitar" en el modal
        $('#confirmEnable').on('click', function() {
            handleUserAction(idUser, 'enableUser', 'Usuario habilitado');
        });
    });

    function handleUserAction(idUser, action, successMessage) {
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });

        $.ajax({
            type: 'POST',
            url: 'controller/ajax/ajax.form.php', // Ajusta la URL según tu estructura
            data: { [action]: idUser },
            success: function (response) {
                if (response === 'ok'){
                    Swal.fire({
                        icon: "success",
                        title: successMessage
                    });

                    registersData.ajax.reload();

                } else {
                    Swal.fire({
                        icon: "error",
                        title: `No se pudo ${successMessage.toLowerCase()} al usuario`
                    });
                }
            },
            complete: function () {
                // Ocultar el modal después de completar la solicitud
                idUser = 0;
                $('#disableModal, #enableModal').modal('hide');
            }
        });
    }

    function sendForm(action, idUser) {
        // Crear un formulario oculto y agregar el idUser como un campo oculto
        var form = $('<form action="' + action + '" method="post"></form>');
        form.append('<input type="hidden" name="register" value="' + idUser + '">');

        // Adjuntar el formulario al cuerpo del documento y enviarlo
        $('body').append(form);
        form.submit();
    }

    function renderActionButtons(idUser, status) {
        var editButtonClass = status === 1 ? 'btn-success' : 'btn-success disable';
        var disableButtonClass = status === 1 ? 'btn-danger disable-button' : 'btn-primary enable-button';
    
        var editButtonDisabled = status === 0 ? 'disabled' : ''; // Agregamos el atributo 'disabled' si status es 0
    
        var html = `
            <div class="btn-group" role="group">
                <button type="button" class="btn ${editButtonClass} edit-button" data-id="${idUser}" ${editButtonDisabled}>
                    <i class="ri-edit-line"></i> Editar
                </button>
                <button type="button" class="btn ${disableButtonClass}" data-id="${idUser}">
                    <i class=${status === 1 ? '"ri-forbid-line"></i> Inhabilitar' : '"ri-checkbox-circle-line"></i> Habilitar'}
                </button>
            </div>
        `;
    
        console.log(html); // Imprimir el HTML generado en la consola
    
        return html;
    }
    
});
