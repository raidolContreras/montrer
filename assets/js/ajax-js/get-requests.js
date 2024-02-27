$(document).ready(function () {
    var level = $("input[name='level']").val();
    var user = $("input[name='user']").val();

    moment.locale('es');
    $('#requests').DataTable({
        ajax: {
            url: 'controller/ajax/getRequests.php', // Ajusta la URL según tu estructura
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
                data: 'nameArea',
            },
            {
                data: 'requestedAmount',
                render: function (data, type, row) {
                    if (type === 'display' || type === 'filter') {
                        // Formatear como pesos
                        var formattedBudget = parseFloat(data).toLocaleString('es-MX', {
                            style: 'currency',
                            currency: 'MXN'
                        });
                        return formattedBudget;
                    }
                    return data;
                }
            },
            {
                data: null,
                render: function (data) {
                    return data.firstname + ' ' + data.lastname;
                }
            },
            {
                data: 'description'
            },
            {
                data: 'requestDate',
                render: function (data, type, row) {
                    return moment(data).format('DD-MMM-YYYY hh:mm A');
                }
            },
            {
                data: null,
                render: function (data) {
                    return renderActionButtons(data.idRequest, data.status, data.idUsers, user, level);
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

});

// Manejar el clic del botón de edición
$('#requests').on('click', '.edit-button', function() {
    var idRequest = $(this).data('id');
    sendForm('editRequest', idRequest);
});

function sendForm(action, idRequest) {
    // Crear un formulario oculto y agregar el idRequest como un campo oculto
    var form = $('<form action="' + action + '" method="post"></form>');
    form.append('<input type="hidden" name="register" value="' + idRequest + '">');

    // Adjuntar el formulario al cuerpo del documento y enviarlo
    $('body').append(form);
    form.submit();
}

showModalAndSetData('deleteModal', 'deleteRequestName', 'confirmDeleteRequest', 'delete', 'Presupuesto eliminado con éxito', 'eliminar');

function showModalAndSetData(modalId, nameId, confirmButtonId, actionType, successMessage, errorMessage) {
    $('#requests').on('click', `.${actionType}-button`, function () {
        var idRequest = $(this).data('id');
        var RequestName = $(this).closest('tr').find('td:eq(1)').text();

        $(`#${nameId}`).text(RequestName);
        $(`#${confirmButtonId}`).data('id', idRequest);

        $(`#${modalId}`).modal('show');
    });

    $(`#${confirmButtonId}`).off('click').on('click', function () {
        var idRequest = $(this).data('id');

        $.ajax({
            type: 'POST',
            url: 'controller/ajax/ajax.form.php',
            data: { [`${actionType}Request`]: idRequest },
            success: function (response) {
                handleResponse(response, successMessage, errorMessage);
            },
            complete: function () {
                idRequest = 0;
                $(`#${modalId}`).modal('hide');
            }
        });
    });
}

function handleResponse(response, successMessage, errorMessage) {
    if (response === 'ok') {
        showAlertBootstrap4('Operación realizada', successMessage);
    } else {
        showAlertBootstrap('Error', `No se pudo ${errorMessage.toLowerCase()} el Presupuesto`);
    }
}

function renderActionButtons(idRequest, status, userRequest, user, level) {

    if (status == 0 && userRequest == user){
        return `
            <center>
                <div class="btn-group" role="group">
                    <button class="btn btn-primary edit-button" data-id="${idRequest}">
                        <i class="ri-edit-line"></i> Editar
                    </button>
                    <button class="btn btn-danger delete-button" data-id="${idRequest}">
                        <i class="ri-delete-bin-6-line"></i> Eliminar
                    </button>
                </div>
            </center>
        `;
    } else if (status == 0 && level == 1 && userRequest != user) {
        return `
            <center>
                <div class="btn-group" role="group">
                    <button class="btn btn-success edit-button" data-id="${idRequest}">
                        Aceptar
                    </button>
                    <button class="btn btn-danger denegate-button" data-id="${idRequest}">
                        <i class="ri-delete-bin-6-line"></i> Denegar
                    </button>
                </div>
            </center>
        `;
    }
}
