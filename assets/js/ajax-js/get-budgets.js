$(document).ready(function () {
    var budgetsData = $('#budgets').DataTable({
        ajax: {
            url: 'controller/ajax/getBudgets.php',
            dataSrc: ''
        },
        columns: [
            { data: 'idBudget' },
            { data: 'nameArea' },
            {
                data: 'AuthorizedAmount',
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
            { data: 'exerciseName' },
            {
                data: null,
                render: function (data) {
                    var idBudget = data.idBudget;
                    var status = data.status;
                    return renderActionButtons(idBudget, status);
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
    $('#budgets').on('click', '.edit-button', function() {
        var idBudget = $(this).data('id');
        sendForm('editBudgets', idBudget);
    });
    
    function sendForm(action, idBudget) {
        // Crear un formulario oculto y agregar el idBudget como un campo oculto
        var form = $('<form action="' + action + '" method="post"></form>');
        form.append('<input type="hidden" name="register" value="' + idBudget + '">');

        // Adjuntar el formulario al cuerpo del documento y enviarlo
        $('body').append(form);
        form.submit();
    }

    $('#budgets').on('click', '.disable-button', function () {
        var idBudget = $(this).data('id');
        var budgetName = $(this).closest('tr').find('td:eq(1)').text();

        $('#disableBudgetName').text(budgetName);
        $('#disableBudgetModal').modal('show');

        $('#confirmDisableBudget').off('click').on('click', function () {
            // Lógica para inhabilitar el presupuesto
            $.ajax({
                type: 'POST',
                url: 'controller/ajax/ajax.form.php',
                data: { 'disableBudget': idBudget },
                success: function (response) {
                    if (response === 'ok') {
                        console.log('presupuesto inhabilitado con éxito');
                        location.reload();
                    } else {
                        console.error('No se pudo inhabilitar el presupuesto');
                    }
                },
                complete: function () {
                    idBudget = 0;
                    $('#disableBudgetModal').modal('hide');
                }
            });
        });
    });

    $('#budgets').on('click', '.enable-button', function () {
        var idBudget = $(this).data('id');
        var budgetName = $(this).closest('tr').find('td:eq(1)').text();

        $('#enableBudgetName').text(budgetName);
        $('#enableBudgetModal').modal('show');

        $('#confirmEnableBudget').off('click').on('click', function () {
            // Lógica para habilitar el presupuesto
            $.ajax({
                type: 'POST',
                url: 'controller/ajax/ajax.form.php',
                data: { 'enableBudget': idBudget },
                success: function (response) {
                    if (response === 'ok') {
                        console.log('presupuesto habilitado con éxito');
                        location.reload();
                    } else {
                        console.error('No se pudo habilitar el presupuesto');
                    }
                },
                complete: function () {
                    idBudget = 0;
                    $('#enableBudgetModal').modal('hide');
                }
            });
        });
    });

    $('#budgets').on('click', '.delete-button', function () {
        var idBudget = $(this).data('id');
        var budgetName = $(this).closest('tr').find('td:eq(1)').text();

        $('#deleteBudgetName').text(budgetName);
        $('#deleteBudgetModal').modal('show');

        $('#confirmDeleteBudget').off('click').on('click', function () {
            // Lógica para habilitar el presupuesto
            $.ajax({
                type: 'POST',
                url: 'controller/ajax/ajax.form.php',
                data: { 'deleteBudget': idBudget },
                success: function (response) {
                    if (response === 'ok') {
                        console.log('presupuesto eliminado con éxito');
                        location.reload();
                    } else {
                        console.error('No se pudo eliminar el presupuesto');
                    }
                },
                complete: function () {
                    idBudget = 0;
                    $('#deleteBudgetModal').modal('hide');
                }
            });
        });
    });

    function renderActionButtons(idBudget, status) {
        if (status == 1) {
            return `
                <div class="d-grid gap-2 btn-group" role="group">
                        <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ri-more-fill"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <button class="dropdown-item btn btn-success edit-button" data-id="${idBudget}">
                                <i class="ri-edit-line"></i> Editar
                            </button>
                            <button class="dropdown-item btn btn-danger disable-button" data-id="${idBudget}">
                                <i class="ri-forbid-line"></i> Inhabilitar
                            </button>
                        </div>
                    </div>
            `;
        } else {
            return `
                <div class="d-grid gap-2 btn-group" role="group">
                        <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ri-more-fill"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <button class="dropdown-item btn btn-success edit-button" data-id="${idBudget}">
                                <i class="ri-edit-line"></i> Editar
                            </button>
                            <button class="dropdown-item btn btn-primary enable-button" data-id="${idBudget}">
                                <i class="ri-checkbox-circle-line"></i> Habilitar
                            </button>
                            <button class="dropdown-item btn btn-danger delete-button" data-id="${idBudget}">
                                <i class="ri-delete-bin-6-line"></i> Eliminar
                            </button>
                        </div>
                    </div>
            `;
        }
    }
    
});
