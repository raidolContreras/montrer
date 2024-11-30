$(document).ready(function () {
    var areasData = $('#areas').DataTable({
		initComplete: function(settings, json) {
			$('[data-bs-toggle="tooltip"]').tooltip();
		},
		drawCallback: function(settings) {
			$('[data-bs-toggle="tooltip"]').tooltip();
		},
        ajax: {
            url: 'controller/ajax/getAreas.php',
            dataSrc: ''
        },
        columns: [
            { data: 'idArea' },
            {
                data: null,
                render: function (data, type, row) {
                    return '<a href="">' + data.nameArea + '</a>';
                }
            },
            { data: 'description' },
            { 
                data: 'usuarios',
                render: function(data, type, row) {
                    if (data) {
                        // Convertir la cadena separada por comas a una lista
                        const usuarios = data.split(', ');
                        return '<ul>' + usuarios.map(usuario => `<li>${usuario}</li>`).join('') + '</ul>';
                    }
                    return '';
                }
            },
            {
                data: null,
                render: function(data) {
                    // Verificar si level es un número y es diferente de cero
                    var level = $('#level').val();
                    if (!isNaN(level) && level != 0) {
                        var idArea = data.idArea;
                        var status = data.status;
                        return renderAreaActionButtons(idArea, status);
                    } else {
                        var status = (data.status == 1) ? 'Habilitado' : 'Deshabilitado';
                        return status;
                    }
                }
            }
        ],
		responsive: true,
		dom: 'Bfrtip', // Define la estructura del DOM para incluir botones
        buttons: [
			{
				extend: 'excelHtml5',
				text: 'Exportar a Excel',
				title: 'Departamentos', // Título personalizado para el archivo Excel
				exportOptions: {
					columns: ':not(:last-child)' // Exportar todas las columnas excepto la última
				}
			},
			{
				extend: 'pdfHtml5',
				text: 'Exportar a PDF',
                title: 'Departamentos',
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
						'<h1 style="text-align: center; font-size: 8pt; padding-top: 10px;">Departamentos</h1>'
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
			"emptyTable":	  "Ningún dato disponible en esta tabla"
        }
    });
    
    $('#areas').on('click', '.edit-button', function() {
        var idArea = $(this).data('id');
        sendForm('editArea', idArea);
    });

    function sendForm(action, idUser) {
        var form = $('<form action="' + action + '" method="post"></form>');
        form.append('<input type="hidden" name="register" value="' + idUser + '">');

        $('body').append(form);
        form.submit();
    }
    
    function renderAreaActionButtons(idArea, status) {
        if (status == 1) {
            return `
            <div class="container">
                <div class="row btn-group" role="group" style="justify-content: center;">
                    <button class="btn btn-primary edit-button col-2" data-id="${idArea}" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar">
                        <i class="ri-edit-line"></i>
                    </button>
                    <button class="btn btn-warning disable-button col-2" data-id="${idArea}" data-bs-toggle="tooltip" data-bs-placement="top" title="Deshabilitar">
                        <i class="ri-forbid-line"></i>
                    </button>
                    <button class="btn btn-danger delete-button col-2" data-id="${idArea}" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar">
                        <i class="ri-delete-bin-6-line"></i>
                    </button>
                </div>
            </div>
            `;
        } else {
            return `
            <div class="container">
                <div class="row btn-group" role="group" style="justify-content: center;">
                    <button class="btn btn-primary edit-button col-2" data-id="${idArea}" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar">
                        <i class="ri-edit-line"></i>
                    </button>
                    <button class="btn btn-success enable-button col-2" data-id="${idArea}" data-bs-toggle="tooltip" data-bs-placement="top" title="Habilitar">
                        <i class="ri-checkbox-circle-line"></i>
                    </button>
                    <button class="btn btn-danger delete-button col-2" data-id="${idArea}" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar">
                        <i class="ri-delete-bin-6-line"></i>
                    </button>
                </div>
            </div>
            `;
        }
    }

    function showModalAndSetData(modalId, nameId, confirmButtonId, actionType, successMessage) {
        $('#areas').on('click', `.${actionType}-button`, function () {
            var idArea = $(this).data('id');
            var AreaName = $(this).closest('tr').find('td:eq(1)').text();
    
            $(`#${nameId}`).text(AreaName);
            $(`#${confirmButtonId}`).data('id', idArea);
    
            $(`#${modalId}`).modal('show');
        });
    
        $(`#${confirmButtonId}`).off('click').on('click', function () {
            var idArea = $(this).data('id');
    
            $.ajax({
                type: 'POST',
                url: 'controller/ajax/ajax.form.php',
                data: { [`${actionType}Area`]: idArea },
                success: function (response) {
                    if (response === 'ok') {
                        showAlertBootstrap4('Operación realizada', `Departamento ${successMessage} con éxito`);
                    } else {
                        showAlertBootstrap('!Atención¡', `No se pudo ${actionType.toLowerCase()} el departamento`);
                    }
                    handleResponse(response, actionType, successMessage);
                },
                complete: function () {
                    idArea = 0;
                    $(`#${modalId}`).modal('hide');
                }
            });
        });
    }
    
    function handleResponse(response, actionType, successMessage) {
        if (response === 'ok') {
            showAlertBootstrap4('Operación realizada', `Departamento ${successMessage} con éxito`);
        } else if(response === 'Error: comprobaciones pendientes') {
            showAlertBootstrap('!Atención¡', `No es posible eliminar el departamento en este momento, ya que el departamento tiene presupuestos pendientes.`);
        }  else {
            showAlertBootstrap('!Atención¡', `No se pudo ${actionType.toLowerCase()} el departamento`);
        }
    }
    
    showModalAndSetData('disableAreaModal', 'disableAreaName', 'confirmDisableArea', 'disable', 'deshabilitado');
    showModalAndSetData('enableAreaModal', 'enableAreaName', 'confirmEnableArea', 'enable', 'habilitado');
    showModalAndSetData('deleteAreaModal', 'deleteAreaName', 'confirmDeleteArea', 'delete', 'eliminado');

});
