$(document).ready(function () {

    exercise = $("input[name='exercise']").val();	

	var budgetsData = $('#budgets').DataTable({
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
			type: 'POST',
			url: 'controller/ajax/getBudgets.php',
			data: {'idExercise': exercise},
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
		responsive: true,
		autoWidth: false,
		dom: 'Bfrtip', // Define la estructura del DOM para incluir botones
        buttons: [
			{
				extend: 'excelHtml5',
				text: 'Exportar a Excel',
				title: 'Presupuestos asignados', // Título personalizado para el archivo Excel
				exportOptions: {
					columns: ':not(:last-child)' // Exportar todas las columnas excepto la última
				}
			},
			{
				extend: 'pdfHtml5',
				text: 'Exportar a PDF',
                title: 'Presupuestos asignados',
				titleAttr: 'PDF',
				customize: function(doc) {
			
					// Añadir el logo en la parte superior
					doc.content.splice(1, 0, {
						image: logo64(), // Imagen en Base64
						width: 100, // Ancho del logo
						alignment: 'center' // Alineación del logo
					});
			
					// Eliminar cabeceras y pies de página por defecto
					delete doc['header']; // Eliminar la cabecera si existe
					delete doc['footer']; // Eliminar el pie de página si existe
			
					// Personalizaciones adicionales aquí
				},
				orientation: 'landscape', // Orientación del PDF
				pageSize: 'A4', // Tamaño de la página
				exportOptions: {
					columns: ':not(:last-child)' // Exportar todas las columnas excepto la última
				}
			},			
            {
				extend: 'print',
				text: 'Imprimir',
				title: '',
				customize: function(win) {
					// Añadir el logo
					$(win.document.body).prepend(
						'<img src="assets/img/logo.png" style="position:absolute; top:10px; left:10px; height:50px;" />'
					);
					$(win.document.body).prepend(
						'<h1 style="text-align: center; font-size: 8pt; padding-top: 10px;">Presupuestos asignados</h1>'
					);

					$(win.document.body).css('font-size', '5pt');
					$(win.document.body).css('margin', '10mm');
			
					$(win.document.body).find('table')
						.addClass('compact')
						.css('font-size', 'inherit');
			
					$(win.document.body).find('table').each(function(index, elem) {
						$(elem).width('100%');
					});

					var css = '@page { size: landscape; }',
						head = win.document.head || win.document.getElementsByTagName('head')[0],
						style = win.document.createElement('style');
			
					style.type = 'text/css';
					style.media = 'print';
			
					if (style.styleSheet){
						style.styleSheet.cssText = css;
					} else {
						style.appendChild(win.document.createTextNode(css));
					}
			
					head.appendChild(style);
				}
			},
			
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
            <div class="container">
                <div class="row" style="justify-content: space-evenly;">
					<button class="btn btn-primary edit-button col-2" data-id="${idBudget}" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar">
						<i class="ri-edit-line"></i>
					</button>
					<button class="btn btn-warning disable-button col-2" data-id="${idBudget}" data-bs-toggle="tooltip" data-bs-placement="top" title="Deshabilitar">
						<i class="ri-forbid-line"></i>
					</button>
					<button class="btn btn-danger delete-button col-2" data-id="${idBudget}" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar">
						<i class="ri-delete-bin-6-line"></i>
					</button>
				</div>
			</div>
			`;
		} else {
			return `
            <div class="container">
                <div class="row" style="justify-content: space-evenly;">
					<button class="btn btn-primary edit-button col-2" data-id="${idBudget}" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar">
						<i class="ri-edit-line"></i>
					</button>
					<button class="btn btn-success enable-button col-2" data-id="${idBudget}" data-bs-toggle="tooltip" data-bs-placement="top" title="Habilitar">
						<i class="ri-checkbox-circle-line"></i>
					</button>
					<button class="btn btn-danger delete-button col-2" data-id="${idBudget}" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar">
						<i class="ri-delete-bin-6-line"></i>
					</button>
				</div>
			</div>
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
		showAlertBootstrap4('Operación realizada', `Presupuesto ${successMessage} con éxito`);
    } else {
		showAlertBootstrap('!Atención¡', `No se pudo ${actionType.toLowerCase()} el presupuesto`);
    }
}

showModalAndSetData('disableBudgetModal', 'disableBudgetName', 'confirmDisableBudget', 'disable', 'deshabilitado');
showModalAndSetData('enableBudgetModal', 'enableBudgetName', 'confirmEnableBudget', 'enable', 'habilitado');
showModalAndSetData('deleteBudgetModal', 'deleteBudgetName', 'confirmDeleteBudget', 'delete', 'eliminado');

