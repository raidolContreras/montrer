$(document).ready(function () {
    moment.locale('es');
    $('#registers').DataTable({
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
            {
                data: 'createDate',
                render: function (data) {
                    return moment(data).format('DD MMM YYYY, h:mm a');
                }
            },
            {
                data: 'lastConection',
                render: function (data) {
                    return moment(data).format('DD MMM YYYY, h:mm a');
                }
            },
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
            handleUserAction(idUser, 'deleteUser', 'El usuario ha sido eliminado', 'No se pudo eliminar al usuario', 'El usuario pertenece a un departamento');
        });
    });

    $('#registers').on('click', '.change-password-button', function() {
        var idUser = $(this).data('id');
        var userName = $(this).closest('tr').find('td:eq(1)').text(); // Obtener el nombre del usuario desde la fila
        
        // Mostrar el nombre del usuario en el modal
        $('#changePasswordUserName').text(userName);
        
        // Mostrar el modal de cambiar contraseña
        $('#changePasswordModal').modal('show');
        
        // Manejar el clic del botón "Cambiar Contraseña" en el modal
        $('#confirmChangePassword').on('click', function() {
            var newPassword = $("input[name='newPassword']").val();
            var confirmPassword = $("input[name='confirmPassword']").val();
            changePassword(idUser, newPassword, confirmPassword);
        });
    });
    
    function handleUserAction(idUser, action, successMessage, errorMessage, errorText) {
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
                        title: errorMessage,
                        text: errorText
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

    function changePassword(idUser, newPassword, confirmPassword) {
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

        var passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*\W)[\w\W]{10,}$/;
        if (!passwordRegex.test(newPassword)) {
            console.log(passwordRegex.test('Paquelaquieres1+'));

            // Mostrar un mensaje de error
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'La contraseña debe contener 10 caracteres, de los cuáles obligatoriamente: 1 letra mayúscula, 1 letra minúscula, 1 número y 1 símbolo.',
            });
            return;
        } else if (newPassword !== confirmPassword) {
            // Mostrar un mensaje de error
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Las contraseñas no coinciden.',
            });
            return;
        } else {
            $.ajax({
                type: 'POST',
                url: 'controller/ajax/ajax.form.php', // Ajusta la URL según tu estructura
                data: { idUsers: idUser, newPassword: newPassword },
                success: function (response) {
                    if (response === 'ok'){
                        Swal.fire({
                            icon: "success",
                            title: 'Contraseña actualizada con exito'
                        });
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
        
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: 'Error',
                            text: 'Nose pudo actualizar la contraseña'
                        });
                    }
                },
                complete: function () {
                    // Ocultar el modal después de completar la solicitud
                    idUser = 0;
                    $('#changePasswordModal').modal('hide');
                }
            });
        }
    
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
        if (status == 1) {
            return `
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-primary edit-button" data-id="${idUser}">
                        <i class="ri-pencil-line"></i> Editar
                    </button>
                    <button type="button" class="btn btn-warning disable-button" data-id="${idUser}">
                        <i class="ri-forbid-line"></i> Inhabilitar
                    </button>
                    <button type="button" class="btn btn-secondary change-password-button" data-id="${idUser}">
                        <i class="ri-lock-password-line"></i> Cambiar Contraseña
                    </button>
                </div>
            `;
        } else {
            return `
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-primary edit-button" data-id="${idUser}">
                        <i class="ri-pencil-line"></i> Editar
                    </button>
                    <button type="button" class="btn btn-success enable-button" data-id="${idUser}">
                        <i class="ri-checkbox-circle-line"></i> Habilitar
                    </button>
                    <button type="button" class="btn btn-danger delete-button" data-id="${idUser}">
                        <i class="ri-delete-bin-6-line"></i> Eliminar
                    </button>
                    <button type="button" class="btn btn-secondary change-password-button" data-id="${idUser}">
                        <i class="ri-lock-password-line"></i> Cambiar Contraseña
                    </button>
                </div>
            `;
        }
    }
    
    
});
