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
                data: null,
                render: function (data, type, row) {
                    if (data.firstname == null) {
                        return '';
                    } else {
                        return data.firstname + ' ' + data.lastname;
                    }
                }
            },
            {
                data: null,
                render: function (data, type, row) {
                    var idArea = data.idArea;
                    var status = data.status;
                    return renderAreaActionButtons(idArea, status);
                }
            }
        ],
		responsive: true,
		autoWidth: false,
        buttons: [
			{
				extend: 'excelHtml5',
				text: 'Exportar a Excel',
				exportOptions: {
				}
			},
			{
				extend: 'pdfHtml5',
				text: 'Exportar a PDF',
                title: 'Departamentos',
				titleAttr: 'PDF',
				customize: function(doc) {
			
					doc.content.splice(1, 0, {
					});
			
			
				},
				exportOptions: {
				}
			},			
            {
				extend: 'print',
				text: 'Imprimir',
				title: '',
				customize: function(win) {
					$(win.document.body).prepend(
						'<img src="assets/img/logo.png" style="position:absolute; top:10px; left:10px; height:50px;" />'
					);
					$(win.document.body).prepend(
						'<h1 style="text-align: center; font-size: 8pt; padding-top: 10px;">Departamentos</h1>'
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
                <div class="row" style="justify-content: space-evenly;">
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
                <div class="row" style="justify-content: space-evenly;">
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
        } else {
            showAlertBootstrap('!Atención¡', `No se pudo ${actionType.toLowerCase()} el departamento`);
        }
    }
    
    showModalAndSetData('disableAreaModal', 'disableAreaName', 'confirmDisableArea', 'disable', 'deshabilitado');
    showModalAndSetData('enableAreaModal', 'enableAreaName', 'confirmEnableArea', 'enable', 'habilitado');
    showModalAndSetData('deleteAreaModal', 'deleteAreaName', 'confirmDeleteArea', 'delete', 'eliminado');

});
