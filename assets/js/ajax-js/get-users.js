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
		drawCallback: function(settings) {
			// Inicializa los tooltips para los elementos dentro de la DataTable.
			// Asegúrate de que este selector solo seleccione elementos dentro de la DataTable para evitar re-inicializaciones innecesarias.
			$('[data-bs-toggle="tooltip"]', this.api().table().container()).tooltip();
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
					return data.firstname + ' ' + data.lastname;
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
					return moment(data).format('DD MMM YYYY, HH:mm');
				}
			},
			{
				data: 'lastConection',
				render: function (data) {
					if ( data == '0000-00-00 00:00:00' ) {
						return 'No ha accedido';
					} else {
						return moment(data).format('DD MMM YYYY, HH:mm');
					}
				}
			},
			{ 
				data: null,
				render: function(data){
					var idUser = data.idUsers;
					var status = data.status;
					return renderActionButtons(idUser, status);
				}
			}
		],
		responsive: true,
		columnDefs: [
			{ responsivePriority: 6}
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
					<div class="row" style="justify-content: space-evenly;">
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
					<div class="row" style="justify-content: space-evenly;">
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
		showAlertBootstrap('Error', message);
	}
	
	function handleResponse(response, successMessage, errorMessage) {
		if (response === 'ok') {
			showAlertBootstrap4('Éxito', successMessage);
		} else {
			showAlertBootstrap('Error', `No se pudo ${errorMessage.toLowerCase()} el usuario`);
		}
	}
	
	showModalAndSetData('disableModal', 'disableUserName', 'confirmDisable', 'disable', 'Usuario deshabilitado con éxito', 'deshabilitar');
	showModalAndSetData('enableModal', 'enableUserName', 'confirmEnable', 'enable', 'Usuario habilitado con éxito', 'habilitar');
	showModalAndSetData('deleteModal', 'deleteUserName', 'confirmDelete', 'delete', 'Usuario eliminado con éxito', 'eliminar');
	showModalPass('changePasswordModal', 'changePasswordUserName', 'confirmChangePassword', 'change-password');
	
});
