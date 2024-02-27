$(document).ready(function () {
    var areasData = $('#areas').DataTable({
        ajax: {
            url: 'controller/ajax/getAreas.php',
            dataSrc: ''
        },
        columns: [
            { data: 'idArea' },
            {
                data: null,
                render: function (data, type, row) {
                    return '<a href="">' + data.nameArea + '</a>';
                }
            },
            { data: 'description' },
            {
                data: null,
                render: function (data, type, row) {
                    if (data.firstname == null) {
                        return '';
                    } else {
                        return data.firstname + ' ' + data.lastname;
                    }
                }
            },
            {
                data: null,
                render: function (data, type, row) {
                    var idArea = data.idArea;
                    var status = data.status;
                    return renderAreaActionButtons(idArea, status);
                }
            }
        ],
        language: {
            "paginate": {
                "first": "<<",
                "last": ">>",
                "next": ">",
                "previous": "<"
            },
            "search": "Buscar:",
            "lengthMenu": "Ver _MENU_ resultados",
            "loadingRecords": "Cargando...",
            "info": "Mostrando _START_ de _END_ en _TOTAL_ resultados",
            "infoEmpty": "Mostrando 0 resultados",
        }
    });
    
    // Manejar el clic del botón de edición
    $('#areas').on('click', '.edit-button', function() {
        var idArea = $(this).data('id');
        sendForm('editArea', idArea);
    });

    function sendForm(action, idUser) {
        // Crear un formulario oculto y agregar el idUser como un campo oculto
        var form = $('<form action="' + action + '" method="post"></form>');
        form.append('<input type="hidden" name="register" value="' + idUser + '">');

        // Adjuntar el formulario al cuerpo del documento y enviarlo
        $('body').append(form);
        form.submit();
    }
    
    function renderAreaActionButtons(idArea, status) {
        if (status == 1) {
            return `
            <center>
                <div class="btn-group" role="group">
                    <button class="btn btn-primary edit-button" data-id="${idArea}">
                        <i class="ri-edit-line"></i> Editar
                    </button>
                    <button class="btn btn-warning disable-button" data-id="${idArea}">
                        <i class="ri-forbid-line"></i> Deshabilitar
                    </button>
                    <button class="btn btn-danger delete-button" data-id="${idArea}">
                        <i class="ri-delete-bin-6-line"></i> Eliminar
                    </button>
                </div>
            </center>
            `;
        } else {
            return `
            <center>
            <div class="btn-group" role="group">
                <button class="btn btn-primary edit-button" data-id="${idArea}">
                    <i class="ri-edit-line"></i> Editar
                </button>
                <button class="btn btn-success enable-button" data-id="${idArea}">
                    <i class="ri-checkbox-circle-line"></i> Habilitar
                </button>
                <button class="btn btn-danger delete-button" data-id="${idArea}">
                    <i class="ri-delete-bin-6-line"></i> Eliminar
                </button>
            </div>
            </center>
            `;
        }
    }

    function showModalAndSetData(modalId, nameId, confirmButtonId, actionType, successMessage) {
        $('#areas').on('click', `.${actionType}-button`, function () {
            var idArea = $(this).data('id');
            var AreaName = $(this).closest('tr').find('td:eq(1)').text();
    
            $(`#${nameId}`).text(AreaName);
            $(`#${confirmButtonId}`).data('id', idArea);
    
            $(`#${modalId}`).modal('show');
        });
    
        $(`#${confirmButtonId}`).off('click').on('click', function () {
            var idArea = $(this).data('id');
    
            $.ajax({
                type: 'POST',
                url: 'controller/ajax/ajax.form.php',
                data: { [`${actionType}Area`]: idArea },
                success: function (response) {
                    handleResponse(response, actionType, successMessage);
                },
                complete: function () {
                    idArea = 0;
                    $(`#${modalId}`).modal('hide');
                }
            });
        });
    }
    
    function handleResponse(response, actionType, successMessage) {
        if (response === 'ok') {
            showAlertBootstrap4('Operación realizada', `Departamento ${successMessage} con éxito`);
        } else {
            showAlertBootstrap('Error', `No se pudo ${actionType.toLowerCase()} el departamento`);
        }
    }
    
    showModalAndSetData('disableAreaModal', 'disableAreaName', 'confirmDisableArea', 'disable', 'deshabilitado');
    showModalAndSetData('enableAreaModal', 'enableAreaName', 'confirmEnableArea', 'enable', 'habilitado');
    showModalAndSetData('deleteAreaModal', 'deleteAreaName', 'confirmDeleteArea', 'delete', 'eliminado');

});
