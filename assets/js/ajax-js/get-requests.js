$(document).ready(function () {
	var level = $("input[name='level']").val();
	var user = $("input[name='user']").val();

	moment.locale('es');
	$('#requests').DataTable({
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
				data: null,
				render: function (data, type, row) {
					if (type === 'display' || type === 'filter') {
						var dataAmount;
						var color;
			
						if (data.approvedAmount != null) {
							dataAmount = data.approvedAmount;
							color = 'green';
						} else {
							dataAmount = data.requestedAmount;
							color = 'orange';
						}
			
						// Formatear como pesos
						var formattedBudget = parseFloat(dataAmount).toLocaleString('es-MX', {
							style: 'currency',
							currency: 'MXN'
						});
			
						// Construir el HTML con el texto y el color
						var html = '<span style="color: ' + color + ';">' + formattedBudget + '</span>';
						return html;
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
					return renderActionButtons(data.idRequest, data.status, data.idUsers, user, level, data.idBudget);
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
				title: 'Presupuestos', // Título personalizado para el archivo Excel
				exportOptions: {
					columns: ':not(:last-child)' // Exportar todas las columnas excepto la última
				}
			},
			{
				extend: 'pdfHtml5',
				text: 'Exportar a PDF',
				title: 'Presupuestos',
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
						'<h1 style="text-align: center; font-size: 8pt; padding-top: 10px;">Presupuestos</h1>'
					);

					$(win.document.body).css('font-size', '8pt');
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
showModalAndSetData('enableModal', 'enableRequestName', 'confirmEnableRequest', 'enable', 'Presupuesto aceptado con éxito', 'aceptar');
showModalAndSetData('denegateModal', 'denegateRequestName', 'confirmDenegateRequest', 'denegate', 'Presupuesto rechazado', 'rechazar');

function showModalAndSetData(modalId, nameId, confirmButtonId, actionType, successMessage, errorMessage) {
	$('#requests').on('click', `.${actionType}-button`, function () {
		var idRequest = $(this).data('id');
		var RequestName = $(this).closest('tr').find('td:eq(1)').text();
		
		$(`#${nameId}`).text(RequestName);
		$(`#${confirmButtonId}`).data('id', idRequest);
		
		if(modalId == 'enableModal'){
			var idBudget = $(this).data('budget');
			$("input[name='budget']").val(idBudget);
			$.ajax({
				type: 'POST',
				url: 'controller/ajax/getRequest.php',
				data: { idRequest: idRequest },
				dataType: 'json',
				success: function (response) {
					$("input[name='approvedAmount']").val(response.requestedAmount);
					$("input[name='area']").val(response.idArea);
					$.ajax({
						type: 'POST',
						url: 'controller/ajax/getAuthorizedAmount.php',
						data: { areaId: response.idArea },
						dataType: 'json',
						success: function (response) {
							updateMaxRequestedAmount(response);
						},
						error: function (error) {
							console.log('Error en la solicitud AJAX:', error);
						}
					});
				},
				error: function (error) {
					console.log('Error en la solicitud AJAX:', error);
				}
			});
		}

		$(`#${modalId}`).modal('show');
	});

	$(`#${confirmButtonId}`).off('click').on('click', function () {
		var idRequest = $(this).data('id');
		var user = $("input[name='user']").val();
		if(modalId == 'enableModal'){
			var approvedAmount = $('input[name="approvedAmount"]').val();
			var maxBudget = $('input[name="maxBudget"]').val();
			var idBudget = $('input[name="budget"]').val();
			var idArea = $('input[name="area"]').val();
			if(maxBudget >= approvedAmount){
				$.ajax({
					type: 'POST',
					url: 'controller/ajax/ajax.form.php',
					data: {
						enableRequest: idRequest,
						approvedAmount: approvedAmount,
						idArea: idArea,
						idBudget: idBudget,
						idAdmin: user
					},
					success: function (response) {
						handleResponse(response, successMessage, errorMessage);
					},
					complete: function () {
						idRequest = 0;
						$(`#${modalId}`).modal('hide');
					}
				});
			} else {
				showAlertBootstrap('¡Atención!', 'La cantidad por aprobar no debe de superar el monto disponible mensual.');
			}
		} else if(modalId == 'denegateModal') {
			$.ajax({
				type: 'POST',
				url: 'controller/ajax/ajax.form.php',
				data: { 
					denegateRequest: idRequest,
					idAdmin: user
				},
				success: function (response) {
					handleResponse(response, successMessage, errorMessage);
				},
				complete: function () {
					idRequest = 0;
					$(`#${modalId}`).modal('hide');
				}
			});
		} else {
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
		}
	});
}

function handleResponse(response, successMessage, errorMessage) {
	if (response === 'ok') {
		showAlertBootstrap4('Operación realizada', successMessage);
	} else {
		showAlertBootstrap('!Atención¡', `No se pudo ${errorMessage.toLowerCase()} el Presupuesto`);
	}
}

function renderActionButtons(idRequest, status, userRequest, user, level, idBudget) {

	if (status == 0 && userRequest == user){
		return `
			<div class="container">
				<div class="row" style="justify-content: space-evenly;">
					<button class="btn btn-primary edit-button col-2" data-id="${idRequest}" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar">
						<i class="ri-edit-line"></i>
					</button>
					<button class="btn btn-danger delete-button col-2" data-id="${idRequest}" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar">
						<i class="ri-delete-bin-6-line"></i>
					</button>
				</div>
			</div>
		`;
	} else if (status == 0 && level == 1 && userRequest != user) {
		return `
			<div class="container">
				<div class="row" style="justify-content: space-evenly;">
					<button class="btn btn-success enable-button col-2" data-id="${idRequest}" data-budget="${idBudget}" data-bs-toggle="tooltip" data-bs-placement="top" title="Aceptar">
						<i class="ri-check-line"></i>
					</button>
					<button class="btn btn-danger denegate-button col-2" data-id="${idRequest}" data-bs-toggle="tooltip" data-bs-placement="top" title="Rechazar">
						<i class="ri-close-line"></i>
					</button>
				</div>
			</div>
		`;
	} else if (status == 1) {
		html = `
			<div class="container">
		`;
		if(userRequest == user){
			html += `
			<center>
				<button class="btn btn-success btn-block check-budget-button col-2" data-id="${idRequest}" data-bs-toggle="tooltip" data-bs-placement="top" title="Comprobar presupuesto">
					<i class="ri-refund-2-line"></i>
				</button>
			</center>`;
		} else {
			html += `
				<button class="btn btn-warning btn-block pendiente-button col-2" data-id="${idRequest}">
					Pendiente de comprobación
				</button>
				`;
		}
		return html + `
			</div>
		`;
	} else {
		return `
			<div class="container">
				<div class="row" style="justify-content: space-evenly;">
					Rechazado
				</div>
			</div>
		`;
	}
}

function updateMaxRequestedAmount(datos) {
		// Obtén el mes actual
		var today = new Date();
		var currentMonth = today.getMonth() + 1; // Los meses en JavaScript van de 0 a 11, por lo que sumamos 1.
	
		// Filtra los datos hasta el mes actual
		var datosHastaMesActual = datos.filter(function (dato) {
			return dato.month <= currentMonth;
		});
	
		// Suma los valores de budget_month hasta el mes actual
		var sumaBudgetMonth = datosHastaMesActual.reduce(function (total, dato) {
			var budgetMonth = parseFloat(dato.budget_month);
			var budgetUsed = parseFloat(dato.budget_used);
			
			// Verificar si los valores son números válidos
			if (!isNaN(budgetMonth) && !isNaN(budgetUsed)) {
				return total + (budgetMonth - budgetUsed);
			} else {
				return total; // No agregar nada si alguno de los valores no es un número válido
			}
		}, 0);

		// Obtiene el idBudget del primer elemento del array (puedes ajustar esto según tus necesidades)
		var idBudget = datos[0].idBudget;

		let formattedSum = sumaBudgetMonth.toLocaleString('es-MX', {
			style: 'currency',
			currency: 'MXN',
			minimumFractionDigits: 2,
			maximumFractionDigits: 2,
		});
		
		if(datos[0].approvedAmount !== 0){
			
			$("input[name='budget']").val(idBudget);
			$("input[name='maxBudget']").val(sumaBudgetMonth.toFixed(2));
			$('#requestedAmount').val(sumaBudgetMonth.toFixed(2));
			$('.requestMax').text('La suma de los presupuestos hasta el mes actual es: ' + formattedSum);

		} else {
			$('#requestedAmount').prop('disabled', true);
			$('.requestMax').text('No se puede solicitar un nuevo presupuesto porque no se ha justificado uno anterior.');
		}
}