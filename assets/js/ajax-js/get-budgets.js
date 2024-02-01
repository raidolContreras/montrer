$(document).ready(function () {

	const Toast = Swal.mixin({
		toast: true,
		position: "center",
		showConfirmButton: false,
		timerProgressBar: false,
		didOpen: (toast) => {
			toast.onmouseenter = Swal.stopTimer;
			toast.onmouseleave = Swal.resumeTimer;
		}
	});

	var budgetsData = $('#budgets').DataTable({
		ajax: {
			url: 'controller/ajax/getBudgets.php',
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
			{ data: null,
				render: function () {
					return '0';
				}
			},
			{ data: null,
				render: function () {
					return '0';
				}
			},
			{ data: null,
				render: function () {
					return '0';
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

	function renderActionButtons(idBudget, status) {
		if (status == 1) {
			return `
			<center>
				<div class="btn-group" role="group">
					<button class="btn btn-primary edit-button" data-id="${idBudget}">
						<i class="ri-edit-line"></i> Editar
					</button>
					<button class="btn btn-warning disable-button" data-id="${idBudget}">
						<i class="ri-forbid-line"></i> Deshabilitar
					</button>
					<button class="btn btn-danger delete-button" data-id="${idBudget}">
						<i class="ri-delete-bin-6-line"></i> Eliminar
					</button>
				</div>
				
			</center>
			`;
		} else {
			return `
			<center>
				<div class="btn-group" role="group">
					<button class="btn btn-primary edit-button" data-id="${idBudget}">
						<i class="ri-edit-line"></i> Editar
					</button>
					<button class="btn btn-success enable-button" data-id="${idBudget}">
						<i class="ri-checkbox-circle-line"></i> Habilitar
					</button>
					<button class="btn btn-danger delete-button" data-id="${idBudget}">
						<i class="ri-delete-bin-6-line"></i> Eliminar
					</button>
				</div>
				</center>
			`;
		}
	}
	
});

function showModalAndSetData(modalId, nameId, confirmButtonId, actionType, successMessage) {
    $('#budgets').on('click', `.${actionType}-button`, function () {
        var idBudget = $(this).data('id');
        var budgetName = $(this).closest('tr').find('td:eq(1)').text();

        $(`#${nameId}`).text(budgetName);
        $(`#${confirmButtonId}`).data('id', idBudget);

        $(`#${modalId}`).modal('show');
    });

    $(`#${confirmButtonId}`).off('click').on('click', function () {
        var idBudget = $(this).data('id');

        $.ajax({
            type: 'POST',
            url: 'controller/ajax/ajax.form.php',
            data: { [`${actionType}Budget`]: idBudget },
            success: function (response) {
                handleResponse(response, actionType, successMessage);
            },
            complete: function () {
                idBudget = 0;
                $(`#${modalId}`).modal('hide');
            }
        });
    });
}

function handleResponse(response, actionType, successMessage) {
    if (response === 'ok') {
        Swal.fire({
            icon: "success",
            title: `Presupuesto ${successMessage} con éxito`
        }).then((result) => {
            if (result.isConfirmed) {
                location.reload();
            }
        });
    } else {
        Swal.fire({
            icon: "error",
            title: 'Error',
            text: `No se pudo ${actionType.toLowerCase()} el presupuesto`
        });
    }
}

showModalAndSetData('disableBudgetModal', 'disableBudgetName', 'confirmDisableBudget', 'disable', 'deshabilitado');
showModalAndSetData('enableBudgetModal', 'enableBudgetName', 'confirmEnableBudget', 'enable', 'habilitado');
showModalAndSetData('deleteBudgetModal', 'deleteBudgetName', 'confirmDeleteBudget', 'delete', 'eliminado');

