var level = $('#level').val();
$(document).ready(function () {
	moment.locale('es');
	$('#registers').DataTable({
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
			url: 'controller/ajax/getUsers.php',
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
				data: null,
				render: function(data) {
					return `
						<a href="logs&user=${data.idUsers}" >
						${data.firstname} ${data.lastname}
						</a>
					`;
				}
			},
			{ data: 'email' },
			{
				data: 'nameArea',
				render: function(data) {
					if (data == null) {
						return 'No asignado';
					} else {
						return data;
					}
				}
			},
			{
				data: 'createDate',
				render: function (data) {
					return moment(data).format('DD/MM/YY, HH:mm');
				}
			},
			{
				data: 'lastConection',
				render: function (data) {
					if ( data == '0000-00-00 00:00:00' ) {
						return 'No ha accedido';
					} else {
						return moment(data).format('DD/MM/YY, HH:mm');
					}
				}
			},
            {
                data: null,
                render: function(data) {
                    // Verificar si level es un número y es diferente de cero
                    if (!isNaN(level) && level != 0) {
                        var idUser = data.idUsers;
                        var status = data.status;
                        return renderActionButtons(idUser, status);
                    }
                    return ''; // Retornar una cadena vacía si no se renderizan los botones
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
				title: 'Usuarios', // Título personalizado para el archivo Excel
				exportOptions: {
					columns: ':not(:last-child)' // Exportar todas las columnas excepto la última
				}
			},
			{
				extend: 'pdfHtml5',
				text: 'Exportar a PDF',
                title: 'Usuarios',
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
						'<h1 style="text-align: center; font-size: 8pt; padding-top: 10px;">Usuarios</h1>'
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
				"first":      "<<",
				"last":       ">>",
				"next":       ">",
				"previous":   "<"
			},
			"search":         "Buscar:",
			"lengthMenu":     "Ver _MENU_ resultados",
			"loadingRecords": "Cargando...",
			"info":           "Mostrando _START_ de _END_ en _TOTAL_ resultados",
			"infoEmpty":      "Mostrando 0 resultados",
			"emptyTable":	  "Ningún dato disponible en esta tabla"
		}
	});

	// Manejar el clic del botón de edición
	$('#registers').on('click', '.edit-button', function() {
		var idUser = $(this).data('id');
		sendForm('editRegister', idUser);
	});

	function sendForm(action, idUser) {
		// Crear un formulario oculto y agregar el idUser como un campo oculto
		var form = $('<form action="' + action + '" method="post"></form>');
		form.append('<input type="hidden" name="register" value="' + idUser + '">');

		// Adjuntar el formulario al cuerpo del documento y enviarlo
		$('body').append(form);
		form.submit();
	}

	function renderActionButtons(idUser, status) {
		if (status == 1) {
			return `
				<div class="container">
					<div class="row btn-group" role="group" style="justify-content: center;">
						<button type="button" class="btn btn-primary edit-button col-2" data-id="${idUser}" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar">
							<i class="ri-pencil-line"></i>
						</button>
						<button type="button" class="btn btn-warning disable-button col-2" data-id="${idUser}" data-bs-toggle="tooltip" data-bs-placement="top" title="Deshabilitar">
							<i class="ri-forbid-line"></i>
						</button>
						<button type="button" class="btn btn-danger delete-button col-2" data-id="${idUser}" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar">
							<i class="ri-delete-bin-6-line"></i>
						</button>
						<button type="button" class="btn btn-secondary change-password-button col-2" data-id="${idUser}" data-bs-toggle="tooltip" data-bs-placement="top" title="Cambiar contraseña">
							<i class="ri-lock-password-line"></i>
						</button>
					</div>
				</div>
			`;
		} else {
			return `
				<div class="container">
					<div class="row btn-group" role="group" style="justify-content: center;">
					<button type="button" class="btn btn-primary edit-button col-2" data-id="${idUser}" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar">
							<i class="ri-pencil-line"></i>
						</button>
						<button type="button" class="btn btn-success enable-button col-2" data-id="${idUser}"data-bs-toggle="tooltip" data-bs-placement="top" title="Habilitar">
							<i class="ri-checkbox-circle-line"></i>
						</button>
						<button type="button" class="btn btn-danger delete-button col-2" data-id="${idUser}" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar">
							<i class="ri-delete-bin-6-line"></i>
						</button>
						<button type="button" class="btn btn-secondary change-password-button col-2" data-id="${idUser}" data-bs-toggle="tooltip" data-bs-placement="top" title="Cambiar contraseña">
							<i class="ri-lock-password-line"></i>
						</button>
					</div>
				</div>
			`;
		}
	}
	
	function showModalAndSetData(modalId, nameId, confirmButtonId, actionType, successMessage, errorMessage) {
		$('#registers').on('click', `.${actionType}-button`, function () {
			var idUser = $(this).data('id');
			var UserName = $(this).closest('tr').find('td:eq(1)').text();
	
			$(`#${nameId}`).text(UserName);
			$(`#${confirmButtonId}`).data('id', idUser);
	
			$(`#${modalId}`).modal('show');
		});
	
		$(`#${confirmButtonId}`).off('click').on('click', function () {
			var idUser = $(this).data('id');
	
			$.ajax({
				type: 'POST',
				url: 'controller/ajax/ajax.form.php',
				data: { [`${actionType}User`]: idUser },
				success: function (response) {
					idUser = 0;
					$(`#${modalId}`).modal('hide');
					handleResponse(response, successMessage, errorMessage, modalId);
				}
			});
		});
	}
	
	function handlePasswordChange(idUser) {
		var newPassword = $("input[name='newPassword']").val();
		var confirmPassword = $("input[name='confirmPassword']").val();
	
		const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*\W)[\w\W]{10,}$/;
	
		if (!passwordRegex.test(newPassword)) {
			showError('La contraseña debe contener 10 caracteres, de los cuales obligatoriamente: 1 letra mayúscula, 1 letra minúscula, 1 número y 1 símbolo.');
			newPassword = $("input[name='newPassword']").val('');
			newPassword = $("input[name='confirmPassword']").val('');
			return;
		} else if (newPassword !== confirmPassword) {
			showError('Las contraseñas no coinciden.');
			newPassword = $("input[name='newPassword']").val('');
			newPassword = $("input[name='confirmPassword']").val('');
			return;
		}
	
		$.ajax({
			type: 'POST',
			url: 'controller/ajax/ajax.form.php',
			data: { idUsers: idUser, newPassword: newPassword },
			success: function (response) {
				idUser = 0;
				$('#changePasswordModal').modal('hide');
				
				newPassword = $("input[name='newPassword']").val('');
				newPassword = $("input[name='confirmPassword']").val('');
				
				handleResponse(response, 'Contraseña actualizada con éxito');
			}
		});
	}
	
	function showModalPass(modalId, nameId, confirmButtonId, action) {
		$('#registers').on('click', `.${action}-button`, function () {
			var idUser = $(this).data('id');
			var userName = $(this).closest('tr').find('td:eq(1)').text();
			
			$(`#${nameId}`).text(userName);
			$(`#${modalId}`).modal('show');
	
			$(`#${confirmButtonId}`).off('click').on('click', function () {
				handlePasswordChange(idUser);
			});
		});
	}
	
	function showError(message) {
		showAlertBootstrap('!Atención¡', message);
	}
	
	function handleResponse(response, successMessage, errorMessage) {
		if (response === 'ok') {
			showAlertBootstrap4('Operación realizada', successMessage);
		} else if(response === 'Error: Presupuestos pendientes') {
			showAlertBootstrap('!Atención¡', `No es posible eliminar el usuario en este momento, ya que el usuario tiene presupuestos pendientes.`);
		}  else {
			showAlertBootstrap('!Atención¡', `No se pudo ${errorMessage.toLowerCase()} el usuario`);
		}
	}
	
	showModalAndSetData('disableModal', 'disableUserName', 'confirmDisable', 'disable', 'Usuario deshabilitado con éxito', 'deshabilitar');
	showModalAndSetData('enableModal', 'enableUserName', 'confirmEnable', 'enable', 'Usuario habilitado con éxito', 'habilitar');
	showModalAndSetData('deleteModal', 'deleteUserName', 'confirmDelete', 'delete', 'Usuario eliminado con éxito', 'eliminar');
	showModalPass('changePasswordModal', 'changePasswordUserName', 'confirmChangePassword', 'change-password');
	
});
