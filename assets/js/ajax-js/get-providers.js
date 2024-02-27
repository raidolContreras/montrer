$(document).ready(function () {
    level = $("input[name='level']").val();


    $('#provider').DataTable({
		// tus otras opciones de configuración aquí...
		initComplete: function(settings, json) {
			// Esto inicializa los tooltips después de que DataTables ha terminado de cargar los datos por primera vez
			$('[data-bs-toggle="tooltip"]').tooltip();
		},
		drawCallback: function(settings) {
			// Esto reinicializa los tooltips cada vez que DataTables redibuja la tabla (ej., paginación)
			$('[data-bs-toggle="tooltip"]').tooltip();
		},
        ajax: {
            url: 'controller/ajax/getProviders.php', // Ajusta la URL según tu estructura
            dataSrc: ''
        },
        columns: [
            {
                data: 'provider_key',
            },
            {
                data: null,
                render: function (data) {
                    return `
                        <div style="white-space: nowrap;">
                            ${data.representative_name}
                        <div>
                    `;
                }
            },
            {
                data: null,
                render: function (data) {
                    return `
                    <div style="white-space: nowrap;">
                        Teléfono: ${data.contact_phone}<br>
                        Email: ${data.email}<br>
                        ${data.website ? `Página web: ${data.website}<br>` : ''}
                    </div>
                `;
                }
            },
            {
                data: 'rfc'
            },
            {
                data: null,
                render: function (data) {
                    // Combina los campos de la dirección fiscal en una sola columna
                    return `
                        <div style="white-space: nowrap;">
                            ${data.fiscal_address_street}, ${data.fiscal_address_colonia},<br>
                            ${data.fiscal_address_municipio}, ${data.fiscal_address_estado}, ${data.fiscal_address_cp}
                        </div>
                    `;
                }
            },
            {
                data: null,
                render: function (data) {
                    // Combina los campos de la dirección fiscal en una sola columna
                    return `
                        <div style="white-space: nowrap;">
                            Banco: ${data.bank_name}<br>
                            Titular: ${data.account_holder}<br>
                            N° cuenta: ${data.account_number}<br>
                            CLABE: ${data.clabe}
                        </div>
                    `;

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
		responsive: true,
        autoWidth: false, // Desactiva el ancho automático para permitir personalizaciones
        columnDefs: [
            { width: "150px", targets: -1 } // Asume que quieres 150px para la última columna
        ],
        scrollX: true,
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
   
    // Manejar el clic del botón de deshabilitar proveedor
    $('#provider').on('click', '.enable-button', function () {
        var idProvider = $(this).data('id');
        var ProviderName = $(this).closest('tr').find('td:eq(1) a').text(); // Obtener el nombre del proveedor desde la fila

        // Mostrar el nombre del proveedor en el modal
        $('#enableProviderName').text(ProviderName);

        // Establecer el id del proveedor en un atributo de datos del botón "Deshabilitar"
        $('#confirmEnableProvider').data('id', idProvider);

        // Mostrar el modal de deshabilitar proveedor
        $('#enableProviderModal').modal('show');
    });

    // Manejar el clic del botón "Deshabilitar" en el modal
    $('#confirmEnableProvider').on('click', function () {
        var idProvider = $(this).data('id');

        $.ajax({
            type: 'POST',
            url: 'controller/ajax/ajax.form.php', // Ajusta la URL según tu estructura
            data: { 'enableProvider': idProvider },
            success: function (response) {
                if (response === 'ok') {
                    showAlertBootstrap4('Éxito', 'Proveedor deshabilitado con éxito');
                } else {
                    showAlertBootstrap('Error', 'No se pudo deshabilitar el proveedor');
                }
            },
            complete: function () {
                // Ocultar el modal después de completar la solicitud
                idProvider = 0;
                $('#enableProviderModal').modal('hide');
            }
        });
    });

    // Manejar el clic del botón de deshabilitar proveedor
    $('#provider').on('click', '.disable-button', function () {
        var idProvider = $(this).data('id');
        var ProviderName = $(this).closest('tr').find('td:eq(1) a').text(); // Obtener el nombre del proveedor desde la fila

        // Mostrar el nombre del proveedor en el modal
        $('#disableProviderName').text(ProviderName);

        // Establecer el id del proveedor en un atributo de datos del botón "Deshabilitar"
        $('#confirmDisableProvider').data('id', idProvider);

        // Mostrar el modal de deshabilitar proveedor
        $('#disableProviderModal').modal('show');
    });

    // Manejar el clic del botón "Deshabilitar" en el modal
    $('#confirmDisableProvider').on('click', function () {
        var idProvider = $(this).data('id');

        $.ajax({
            type: 'POST',
            url: 'controller/ajax/ajax.form.php', // Ajusta la URL según tu estructura
            data: { 'disableProvider': idProvider },
            success: function (response) {
                if (response === 'ok') {
                    showAlertBootstrap4('Éxito', 'Proveedor deshabilitado con éxito');
                } else {
                    showAlertBootstrap('Error', 'No se pudo deshabilitar el proveedor');
                }
            },
            complete: function () {
                // Ocultar el modal después de completar la solicitud
                idProvider = 0;
                $('#disableProviderModal').modal('hide');
            }
        });
    });

    
    // Manejar el clic del botón de deshabilitar proveedor
    $('#provider').on('click', '.delete-button', function () {
        var idProvider = $(this).data('id');
        var ProviderName = $(this).closest('tr').find('td:eq(1) a').text(); // Obtener el nombre del proveedor desde la fila

        // Mostrar el nombre del proveedor en el modal
        $('#deleteProviderName').text(ProviderName);

        // Establecer el id del proveedor en un atributo de datos del botón "Deshabilitar"
        $('#confirmDeleteProvider').data('id', idProvider);

        // Mostrar el modal de deshabilitar proveedor
        $('#deleteProviderModal').modal('show');
    });
    
    // Manejar el clic del botón "Deshabilitar" en el modal
    $('#confirmDeleteProvider').on('click', function () {
        var idProvider = $(this).data('id');

        $.ajax({
            type: 'POST',
            url: 'controller/ajax/ajax.form.php', // Ajusta la URL según tu estructura
            data: { 'deleteProvider': idProvider },
            success: function (response) {
                if (response === 'ok') {
                    showAlertBootstrap4('Éxito', 'Proveedor deshabilitado con éxito');

                } else {
                    showAlertBootstrap('Error', 'No se pudo deshabilitar el proveedor');
                }
            },
            complete: function () {
                // Ocultar el modal después de completar la solicitud
                idProvider = 0;
                $('#deleteProviderModal').modal('hide');
            }
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
            <div class="container">
                <div class="row" style="justify-content: space-evenly; width: 200px">
                    <button class="btn btn-primary edit-button col-2" data-id="${idProvider}" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar">
                        <i class="ri-edit-line"></i>
                    </button>
                    <button class="btn btn-warning disable-button col-2" data-id="${idProvider}" data-bs-toggle="tooltip" data-bs-placement="top" title="Deshabilitar">
                        <i class="ri-forbid-line"></i>
                    </button>
                    <button class="btn btn-danger delete-button col-2" data-id="${idProvider}" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar">
                        <i class="ri-delete-bin-6-line"></i>
                    </button>
                </div>
            </div>
        `;
    } else {
        return `
            <div class="container">
                <div class="row" style="justify-content: space-evenly; width: 200px">
                    <button class="btn btn-primary edit-button col-2" data-id="${idProvider}" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar">
                        <i class="ri-edit-line"></i>
                    </button>
                    <button class="btn btn-success enable-button col-2" data-id="${idProvider}" data-bs-toggle="tooltip" data-bs-placement="top" title="Habilitar">
                        <i class="ri-forbid-line"></i>
                    </button>
                    <button class="btn btn-danger delete-button col-2" data-id="${idProvider}" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar">
                        <i class="ri-delete-bin-6-line"></i> 
                    </button>
                </div>
            </div>
        `;
    }

}