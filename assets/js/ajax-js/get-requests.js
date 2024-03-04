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
        showAlertBootstrap('!Atención¡', `No se pudo ${errorMessage.toLowerCase()} el Presupuesto`);
    }
}

function renderActionButtons(idRequest, status, userRequest, user, level) {

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
                    <button class="btn btn-success edit-button col-2" data-id="${idRequest}" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar">
                        Aceptar
                    </button>
                    <button class="btn btn-danger denegate-button col-2" data-id="${idRequest}" data-bs-toggle="tooltip" data-bs-placement="top" title="Rechazar">
                        <i class="ri-delete-bin-6-line"></i>
                    </button>
                </div>
            </div>
        `;
    }
}
