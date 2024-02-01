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
                data: 'nameArea',
                render: function(data) {
                    if (data == null) {
                        return 'Sin departamento asignado';
                    } else {
                        return data;
                    }
                }
            },
            {
                data: 'createDate',
                render: function (data) {
                    return moment(data).format('DD MMM YYYY, h:mm a');
                }
            },
            {
                data: 'lastConection',
                render: function (data) {
                    if ( data == '0000-00-00 00:00:00' ) {
                        return 'No ha accedido';
                    } else {
                        return moment(data).format('DD MMM YYYY, h:mm a');
                    }
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
                        <i class="ri-forbid-line"></i> Deshabilitar
                    </button>
                    <button type="button" class="btn btn-danger delete-button" data-id="${idUser}">
                        <i class="ri-delete-bin-6-line"></i> Eliminar
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
    
    function showModalAndSetData(modalId, nameId, confirmButtonId, actionType, successMessage) {
        $('#registers').on('click', `.${actionType}-button`, function () {
            var idUser = $(this).data('id');
            var UserName = $(this).closest('tr').find('td:eq(1)').text();
    
            $(`#${nameId}`).text(UserName);
            $(`#${confirmButtonId}`).data('id', idUser);
    
            $(`#${modalId}`).modal('show');
        });
    
        $(`#${confirmButtonId}`).off('click').on('click', function () {
            var idUser = $(this).data('id');
    
            $.ajax({
                type: 'POST',
                url: 'controller/ajax/ajax.form.php',
                data: { [`${actionType}User`]: idUser },
                success: function (response) {
                    handleResponse(response, actionType, successMessage);
                },
                complete: function () {
                    idUser = 0;
                    $(`#${modalId}`).modal('hide');
                }
            });
        });
    }
    
    function handleResponse(response, actionType, successMessage) {
        if (response === 'ok') {
            Swal.fire({
                icon: "success",
                title: `usuario ${successMessage} con éxito`
            }).then((result) => {
                if (result.isConfirmed) {
                    location.reload();
                }
            });
        } else {
            Swal.fire({
                icon: "error",
                title: 'Error',
                text: `No se pudo ${actionType.toLowerCase()} el usuario`
            });
        }
    }
    
    showModalAndSetData('disableModal', 'disableUserName', 'confirmDisable', 'disable', 'deshabilitado');
    showModalAndSetData('enableModal', 'enableUserName', 'confirmEnable', 'enable', 'habilitado');
    showModalAndSetData('deleteModal', 'deleteUserName', 'confirmDelete', 'delete', 'eliminado');
    
    function handlePasswordChange(idUser) {
        var newPassword = $("input[name='newPassword']").val();
        var confirmPassword = $("input[name='confirmPassword']").val();
    
        const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*\W)[\w\W]{10,}$/;
    
        if (!passwordRegex.test(newPassword)) {
            showError('La contraseña debe contener 10 caracteres, de los cuales obligatoriamente: 1 letra mayúscula, 1 letra minúscula, 1 número y 1 símbolo.');
            return;
        } else if (newPassword !== confirmPassword) {
            showError('Las contraseñas no coinciden.');
            return;
        }
    
        $.ajax({
            type: 'POST',
            url: 'controller/ajax/ajax.form.php',
            data: { idUsers: idUser, newPassword: newPassword },
            success: function (response) {
                handleResponse(response, 'Contraseña actualizada con éxito');
            },
            complete: function () {
                idUser = 0;
                $('#changePasswordModal').modal('hide');
            }
        });
    }
    
    function showModalPass(modalId, nameId, confirmButtonId, action) {
        $('#registers').on('click', `.${action}-button`, function () {
            var idUser = $(this).data('id');
            var userName = $(this).closest('tr').find('td:eq(1)').text();
    
            $(`#${nameId}`).text(userName);
            $(`#${modalId}`).modal('show');
    
            $(`#${confirmButtonId}`).off('click').on('click', function () {
                handlePasswordChange(idUser);
            });
        });
    }
    
    function showError(message) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: message,
        });
    }
    
    function handleResponse(response, successMessage) {
        if (response === 'ok') {
            Swal.fire({
                icon: "success",
                title: successMessage
            }).then((result) => {
                if (result.isConfirmed) {
                    location.reload();
                }
            });
        } else {
            showError('No se pudo actualizar la contraseña');
        }
    }
    
    showModalPass('changePasswordModal', 'changePasswordUserName', 'confirmChangePassword', 'change-password');
    
    
});
