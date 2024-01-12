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

    $('#budgets').on('click', '.disable-button', function () {
        var idBudget = $(this).data('id');
        var budgetName = $(this).closest('tr').find('td:eq(1)').text();

        $('#disableBudgetName').text(budgetName);
        $('#disableBudgetModal').modal('show');

        $('#confirmDisableBudget').off('click').on('click', function () {
            // Lógica para inhabilitar el área
            $.ajax({
                type: 'POST',
                url: 'controller/ajax/ajax.form.php',
                data: { 'disableBudget': idBudget },
                success: function (response) {
                    if (response === 'ok') {
                        console.log('Área inhabilitada con éxito');
                        budgetsData.ajax.reload();
                    } else {
                        console.error('No se pudo inhabilitar el área');
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
            // Lógica para habilitar el área
            $.ajax({
                type: 'POST',
                url: 'controller/ajax/ajax.form.php',
                data: { 'enableBudget': idBudget },
                success: function (response) {
                    if (response === 'ok') {
                        console.log('Área habilitada con éxito');
                        budgetsData.ajax.reload();
                    } else {
                        console.error('No se pudo habilitar el área');
                    }
                },
                complete: function () {
                    idBudget = 0;
                    $('#enableBudgetModal').modal('hide');
                }
            });
        });
    });

    function renderActionButtons(idBudget, status) {
        if (status == 1) {
            return `
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-success edit-button" data-id="${idBudget}">
                        <i class="ri-edit-line"></i> Editar
                    </button>
                    <button type="button" class="btn btn-danger disable-button" data-id="${idBudget}">
                        <i class="ri-delete-bin-6-line"></i> Eliminar
                    </button>
                </div>
            `;
        } else {
            return `
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-success disable edit-button" data-id="${idBudget}" disabled>
                        <i class="ri-edit-line"></i> Editar
                    </button>
                    <button type="button" class="btn btn-primary enable-button" data-id="${idBudget}">
                        <i class="ri-checkbox-circle-line"></i>Habilitar
                    </button>
                </div>
            `;
        }
    }
});
