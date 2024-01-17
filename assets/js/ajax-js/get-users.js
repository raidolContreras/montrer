$(document).ready(function () {
    var registersData = $('#registers').DataTable({
        ajax: {
            url: 'controller/ajax/getUsers.php',
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
                    return renderActionButtons(idUser, status);
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
            handleUserAction(idUser, 'disableUser', 'El usuario ha sido inhabilitado', 'No se pudo inhabilitar al usuario');
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
            handleUserAction(idUser, 'enableUser', 'El usuario ha sido habilitado', 'No se pudo habilitar al usuario');
        });
    });
    
    $('#registers').on('click', '.delete-button', function() {
        var idUser = $(this).data('id');
        var userName = $(this).closest('tr').find('td:eq(1)').text(); // Obtener el nombre del usuario desde la fila
    
        // Mostrar el nombre del usuario en el modal
        $('#deleteUserName').text(userName);
    
        // Mostrar el modal de eliminar
        $('#deleteModal').modal('show');
    
        // Manejar el clic del botón "Eliminar" en el modal
        $('#confirmDelete').on('click', function() {
            handleUserAction(idUser, 'deleteUser', 'El usuario ha sido eliminado', 'No se pudo eliminar al usuario');
        });
    });
    
    function handleUserAction(idUser, action, successMessage, errorMessage) {
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
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
    
                } else {
                    Swal.fire({
                        icon: "error",
                        title: errorMessage
                    });
                }
            },
            complete: function () {
                // Ocultar el modal después de completar la solicitud
                idUser = 0;
                $('#disableModal, #enableModal, #deleteModal').modal('hide');
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
        if (status == 1){

            return `
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-success edit-button" data-id="${idUser}">
                        <i class="ri-edit-line"></i> Editar
                    </button>
                    <button type="button" class="btn btn-danger disable-button" data-id="${idUser}">
                        <i class="ri-forbid-line"></i> Inhabilitar
                    </button>
                </div>
            `;

        } else {
            return `
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-success disable edit-button" data-id="${idUser}" disabled>
                        <i class="ri-edit-line"></i> Editar
                    </button>
                    <button type="button" class="btn btn-primary enable-button" data-id="${idUser}">
                        <i class="ri-checkbox-circle-line"></i> Habilitar
                    </button>
                    <button type="button" class="btn btn-danger delete-button" data-id="${idUser}">
                        <i class="ri-forbid-line"></i> Eliminar
                    </button>
                </div>
            `;
        }
    }
});
