$(document).ready(function () {
	
	moment.locale('es');
	var exerciseTable = $('#exercise').DataTable({
		ajax: {
			url: 'controller/ajax/getExercises.php',
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
				render: function(data, type, row) {
					// Combina los campos de nombre y apellido en una sola columna y agrega un botón
					return data.exerciseName;
				}
			},
			{ 
				data: 'initialDate',
				render: function(data, type, row) {
					return moment(data).format('DD-MMM-YYYY');
				}
			},
			{ 
				data: 'finalDate',
				render: function(data, type, row) {
					return moment(data).format('DD-MMM-YYYY');
				}
			},
			{
				data: 'budget',
				render: function (data, type, row) {
					// Formatea el número usando toLocaleString
					var formattedBudget = parseFloat(data).toLocaleString('es-MX', {
						style: 'currency',
						currency: 'MXN'
					});

					return formattedBudget;
				}
			},
			{
				data: null,
				render: function(data) {
					return renderActionButtons(data.idExercise, data.status, data.active);
				}                
			}
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

	// Agrega un evento de clic al botón "Activar"
	$('#exercise').on('click', '.activate-btn', function () {
		
		var idExercise = $(this).data('id');
		var exerciseName = $(this).closest('tr').find('td:eq(1)').text(); // Obtener el nombre del ejercicio desde la fila

		// Mostrar el nombre del ejercicio en el modal
		$('#activateExerciseName').text(exerciseName);

		// Mostrar el modal de habilitar ejercicio
		$('#activateExerciseModal').modal('show');

		// Manejar el clic del botón "Habilitar" en el modal
		$('#confirmActivateExercise').on('click', function () {
			activateExercise(idExercise, 'activateExercise', 'No se pudo activar el ejercicio', 'Ejercicio activado con exito');
		});
	});

	function activateExercise(idExercise){

		// Realiza la solicitud Ajax a exerciseOn.php con el idExercise
		$.ajax({
			type: "POST",
			url: "controller/ajax/exerciseOn.php",
			data: { idExercise: idExercise },
			success: function (response) {
				showAlertBootstrap4('Operación realizada', 'Se activo de ejercicio exitosamente');
			},
			error: function (error) {
				console.log("Error en la solicitud Ajax:", error);
			}
		});

	}

	// Manejar el clic del botón de edición
	$('#exercise').on('click', '.edit-button', function() {
		var idExercise = $(this).data('id');
		sendForm('editExercise', idExercise);
	});
	
	function sendForm(action, idExercise) {
		// Crear un formulario oculto y agregar el idExercise como un campo oculto
		var form = $('<form action="' + action + '" method="post"></form>');
		form.append('<input type="hidden" name="register" value="' + idExercise + '">');

		// Adjuntar el formulario al cuerpo del documento y enviarlo
		$('body').append(form);
		form.submit();
	}

	function renderActionButtons(idExercise, status, active) {
		if (active == 1) {
			if (status == 1) {
				return `
					<center>
					<div class="btn-group" role="group">
						<button type="button" class="btn btn-success activate-btn-disable disabled" disabled>
							Activo
						</button>
						<button class="btn btn-primary edit-button" data-id="${idExercise}">
							<i class="ri-edit-line"></i> Editar
						</button>
						<button class="btn btn-warning disable-button" data-id="${idExercise}">
							<i class="ri-forbid-line"></i> Deshabilitar
						</button>
						<button class="btn btn-danger delete-button" data-id="${idExercise}">
							<i class="ri-delete-bin-6-line"></i> Eliminar
						</button>
					</div>
					</center>
				`;
			} else {
				return `
				<center>
				<div class="btn-group" role="group">
					<button class="btn btn-success activate-btn" data-exercise="${idExercise}" data-id="${idExercise}">
						Activar
					</button>
					<button class="btn btn-primary edit-button" data-id="${idExercise}">
						<i class="ri-edit-line"></i> Editar
					</button>
					<button class="btn btn-warning disable-button" data-id="${idExercise}">
						<i class="ri-forbid-line"></i> Deshabilitar
					</button>
					<button class="btn btn-danger delete-button" data-id="${idExercise}">
						<i class="ri-delete-bin-6-line"></i> Eliminar
					</button>
				</div>
				</center>
				`;
			}
		} else {
			return `
			<center>
			<div class="btn-group" role="group">
				<button class="btn btn-success activate-btn disabled" disabled>
					Activar
				</button>
				<button class="btn btn-primary edit-button" data-id="${idExercise}">
					<i class="ri-edit-line"></i> Editar
				</button>
				<button class="btn btn-success enable-button" data-id="${idExercise}">
					<i class="ri-checkbox-circle-line"></i> Habilitar
				</button>
				<button class="btn btn-danger delete-button" data-id="${idExercise}">
					<i class="ri-delete-bin-6-line"></i> Eliminar
				</button>
			</div>
			</center>
			`;
		}
	}


});

function showModalAndSetData(modalId, nameId, confirmButtonId, actionType, message) {
    $('#exercise').on('click', `.${actionType}-button`, function () {
        var idExercise = $(this).data('id');
        var exerciseName = $(this).closest('tr').find('td:eq(1) a').text();

        $(`#${nameId}`).text(exerciseName);
        $(`#${confirmButtonId}`).data('id', idExercise);

        $(`#${modalId}`).modal('show');
    });

    $(`#${confirmButtonId}`).on('click', function () {
        var idExercise = $(this).data('id');

        $.ajax({
            type: 'POST',
            url: 'controller/ajax/ajax.form.php',
            data: { [`${actionType}Exercise`]: idExercise },
            success: function (response) {
                handleResponse(response, actionType, message);
            },
            complete: function () {
                idExercise = 0;
                $(`#${modalId}`).modal('hide');
            }
        });
    });
}

function handleResponse(response, actionType, message) {
    if (response === 'ok') {
		showAlertBootstrap4('Operación realizada', `Ejercicio ${message} con éxito`);
    } else {
		showAlertBootstrap('Error', `No se pudo ${actionType.toLowerCase()} el ejercicio`);
    }
}

showModalAndSetData('disableExerciseModal', 'disableExerciseName', 'confirmDisableExercise', 'disable', 'deshabilitado');
showModalAndSetData('enableExerciseModal', 'enableExerciseName', 'confirmEnableExercise', 'enable', 'habilitado');
showModalAndSetData('deleteExerciseModal', 'deleteExerciseName', 'confirmDeleteExercise', 'delete', 'eliminado');
