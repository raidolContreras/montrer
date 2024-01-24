$(document).ready(function () {
    level = $("input[name='level']").val();
    
    const Toast = Swal.mixin({
        toast: true,
        position: "center",
        showConfirmButton: false,
        timer: 1500,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
    });

    $('#provider').DataTable({
        ajax: {
            url: 'controller/ajax/getProviders.php', // Ajusta la URL según tu estructura
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
                data: 'provider_key',
            },
            {
                data: 'representative_name'
            },
            {
                data: 'contact_phone'
            },
            {
                data: 'rfc'
            },
            {
                data: null,
                render: function (data) {
                    // Combina los campos de la dirección fiscal en una sola columna
                    return `${data.fiscal_address_street}, ${data.fiscal_address_colonia}, ${data.fiscal_address_municipio}, ${data.fiscal_address_estado}, ${data.fiscal_address_cp}`;
                }
            },
            {
                data: null,
                render: function (data) {
                    // Combina los campos de la dirección fiscal en una sola columna
                    return `${data.bank_name}, ${data.account_holder}, ${data.account_number}, ${data.clabe}`;
                }
            },
            {
                data: null,
                visible: (level == 1), // Hace visible la columna solo si level es igual a 1
                render: function (data) {
                    return renderActionButtons(data.idProvider, data.status);
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
    $('#provider').on('click', '.edit-button', function() {
        var idProvider = $(this).data('id');
        sendForm('editProvider', idProvider);
    });

    // Manejar el clic del botón de habilitar área
    $('#provider').on('click', '.enable-button', function () {
        var idProvider = $(this).data('id');
        var ProviderName = $(this).closest('tr').find('td:eq(1) a').text(); // Obtener el nombre del área desde la fila

        // Mostrar el nombre del área en el modal
        $('#enableProviderName').text(ProviderName);

        // Mostrar el modal de habilitar área
        $('#enableProviderModal').modal('show');

        // Manejar el clic del botón "Habilitar" en el modal
        $('#confirmEnableProvider').on('click', function () {
            $.ajax({
                type: 'POST',
                url: 'controller/ajax/ajax.form.php', // Ajusta la URL según tu estructura
                data: { 'enableProvider': idProvider },
                success: function (response) {
                    if (response === 'ok') {
                        // Implementa acciones adicionales si es necesario
                        console.log('proveedor habilitado con éxito');
                        location.reload(); // Recargar datos de DataTable
                    } else {
                        console.error('No se pudo habilitar el proveedor');
                    }
                },
                complete: function () {
                    // Ocultar el modal después de completar la solicitud
                    idProvider = 0;
                    $('#enableProviderModal').modal('hide');
                }
            });
        });
    });

    // Manejar el clic del botón de habilitar área
    $('#provider').on('click', '.disable-button', function () {
        var idProvider = $(this).data('id');
        var ProviderName = $(this).closest('tr').find('td:eq(1) a').text(); // Obtener el nombre del área desde la fila

        // Mostrar el nombre del área en el modal
        $('#disableProviderName').text(ProviderName);

        // Mostrar el modal de habilitar área
        $('#disableProviderModal').modal('show');

        // Manejar el clic del botón "Habilitar" en el modal
        $('#confirmDisableProvider').on('click', function () {
            $.ajax({
                type: 'POST',
                url: 'controller/ajax/ajax.form.php', // Ajusta la URL según tu estructura
                data: { 'disableProvider': idProvider },
                success: function (response) {
                    if (response === 'ok') {
                        // Implementa acciones adicionales si es necesario
                        console.log('proveedor deshabilitado con éxito');
                        location.reload(); // Recargar datos de DataTable
                    } else {
                        console.error('No se pudo deshabilitar el proveedor');
                    }
                },
                complete: function () {
                    // Ocultar el modal después de completar la solicitud
                    idProvider = 0;
                    $('#disableProviderModal').modal('hide');
                }
            });
        });
    });

    // Manejar el clic del botón de eliminar área
    $('#provider').on('click', '.delete-button', function () {
        var idProvider = $(this).data('id');
        var ProviderName = $(this).closest('tr').find('td:eq(1) a').text(); // Obtener el nombre del área desde la fila

        // Mostrar el nombre del área en el modal
        $('#deleteProviderName').text(ProviderName);

        // Mostrar el modal de eliminar área
        $('#deleteProviderModal').modal('show');

        // Manejar el clic del botón "eliminar" en el modal
        $('#confirmDeleteProvider').on('click', function () {
            $.ajax({
                type: 'POST',
                url: 'controller/ajax/ajax.form.php', // Ajusta la URL según tu estructura
                data: { 'deleteProvider': idProvider },
                success: function (response) {
                    if (response === 'ok') {
                        location.reload();
                    } else {
                        console.error('No se pudo eliminar el proveedor');
                    }
                },
                complete: function () {
                    // Ocultar el modal después de completar la solicitud
                    idProvider = 0;
                    $('#deleteProviderModal').modal('hide');
                }
            });
        });
    });

    function sendForm(action, idProvider) {
        // Crear un formulario oculto y agregar el idProvider como un campo oculto
        var form = $('<form action="' + action + '" method="post"></form>');
        form.append('<input type="hidden" name="register" value="' + idProvider + '">');

        // Adjuntar el formulario al cuerpo del documento y enviarlo
        $('body').append(form);
        form.submit();
    }

function renderActionButtons(idProvider, status) {

    if (status == 1) {
        return `
            <center>
                <div class="btn-group" role="group">
                    <button class="btn btn-primary edit-button" data-id="${idProvider}">
                        <i class="ri-edit-line"></i> Editar
                    </button>
                    <button class="btn btn-warning disable-button" data-id="${idProvider}">
                        <i class="ri-forbid-line"></i> Inhabilitar
                    </button>
                    <button class="btn btn-danger delete-button" data-id="${idProvider}">
                        <i class="ri-delete-bin-6-line"></i> Eliminar
                    </button>
                </div>
            </center>
        `;
    } else {
        return `
            <center>
                <div class="btn-group" role="group">
                    <button class="btn btn-primary edit-button" data-id="${idProvider}">
                        <i class="ri-edit-line"></i> Editar
                    </button>
                    <button class="btn btn-success enable-button" data-id="${idProvider}">
                        <i class="ri-forbid-line"></i> habilitar
                    </button>
                    <button class="btn btn-danger delete-button" data-id="${idProvider}">
                        <i class="ri-delete-bin-6-line"></i> Eliminar
                    </button>
                </div>
            </center>
        `;
    }

}