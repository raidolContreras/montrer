$(document).ready(function () {
    $(document).ready(function(){
        // Definir las columnas que siempre se mostrarán
        let columnas = [
            { 
                data: null, 
                title: '#',
                render: function (data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            { data: 'cuenta', title: 'Cuenta' },
            { 
                data: null,
                title: 'Número de cuenta',
                render: function (data, type, row) {
                    return `<span class="badge bg-success" style="color: #fff;">${row.areaCode}-${row.numeroCuenta}-000-000</span>`;
                }
            },
            { data: 'nameArea', title: 'Departamento' }
        ];
    
        // Agregar la columna "Acciones" solo si el valor de #level es distinto de 0
        if ($('#level').val() != 0) {
            columnas.push({
                data: null,
                title: 'Acciones',
                render: function (data, type, row) {
                    return `
                        <div class="btn-group">
                            <button class="btn btn-primary edit-button col-2" data-id="${row.idCuenta}" data-cuenta="${row.cuenta}" data-numero="${row.numeroCuenta}" data-areaCode="${row.areaCode}" data-area="${row.idArea}" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar">
                                <i class="ri-edit-line"></i>
                            </button>
                            <button class="btn btn-danger delete-button col-2" data-id="${row.idCuenta}" data-cuenta="${row.cuenta}" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar">
                                <i class="ri-delete-bin-6-line"></i>
                            </button>
                        </div>
                    `;
                }
            });
        }
    
        // Inicializar DataTable con la configuración definida
        const accountsTable = $('#accounts').DataTable({
            ajax: {
                url: 'controller/ajax/getAccounts.php', // Ruta al backend que devuelve las cuentas
                method: 'GET',
                dataSrc: ''
            },
            columns: columnas,
            responsive: true,
            initComplete: function(settings, json) {
                // Inicializar tooltips tras cargar los datos
                $('[data-bs-toggle="tooltip"]').tooltip();
            },
            drawCallback: function(settings) {
                // Reinicializar tooltips en cada redraw (paginación, etc.)
                $('[data-bs-toggle="tooltip"]').tooltip();
            },
            language: {
                paginate: {
                    first: "<<",
                    last: ">>",
                    next: ">",
                    previous: "<"
                },
                search: "Buscar:",
                lengthMenu: "Ver _MENU_ resultados",
                loadingRecords: "Cargando...",
                info: "Mostrando _START_ de _END_ en _TOTAL_ resultados",
                infoEmpty: "Mostrando 0 resultados",
                emptyTable: "Ningún dato disponible en esta tabla"
            }
        });
    });
    

    // Manejar el clic en el botón "Eliminar cuenta"
    $('#accounts').on('click', '.delete-button', function () {
        const accountId = $(this).data('id');
        const accountName = $(this).data('cuenta');

        // Mostrar el modal de confirmación
        $('#deleteAccountName').text(accountName);
        $('#deleteAccountModal').modal('show');

        // Confirmar la eliminación
        $('#confirmDeleteAccount').off('click').on('click', function () {
            $.ajax({
                url: 'controller/ajax/ajax.form.php', // Ruta para eliminar cuentas
                method: 'POST',
                data: { deleteCuenta: accountId },
                success: function (response) {
                    if (response === 'ok') {
                        accountsTable.ajax.reload();
                        alert('Cuenta eliminada exitosamente.');
                    } else {
                        alert('Error al eliminar la cuenta.');
                    }
                },
                error: function () {
                    alert('Hubo un error al intentar eliminar la cuenta.');
                }
            });
        });
    });
    // Manejar el clic en el botón "Editar cuenta"
    $('#accounts').on('click', '.edit-button', function () {
        const accountId = $(this).data('id');
        const accountName = $(this).data('cuenta');
        const accountNumber = $(this).data('numero');
        const areaId = $(this).data('area');
        const areaCode = $(this).data('areacode');

        // Crear un formulario dinámico
        const form = $('<form>', {
            action: 'editCuenta', // URL donde se envían los datos
            method: 'POST'
        });

        // Agregar los datos al formulario como campos ocultos
        form.append($('<input>', { type: 'hidden', name: 'id', value: accountId }));
        form.append($('<input>', { type: 'hidden', name: 'cuenta', value: accountName }));
        form.append($('<input>', { type: 'hidden', name: 'numeroCuenta', value: accountNumber }));
        form.append($('<input>', { type: 'hidden', name: 'area', value: areaId }));
        form.append($('<input>', { type: 'hidden', name: 'areaCode', value: areaCode }));

        // Agregar el formulario al DOM y enviarlo
        $('body').append(form);
        form.submit();
    });

});
