$(document).ready(function () {
    // Inicializar DataTable
    const partidasTable = $('#partidas').DataTable({
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
            url: 'controller/ajax/getPartidas.php', // Ruta al backend que devuelve las partidas
            method: 'POST',
            dataSrc: ''
        },
        columns: [
            { data: null, title: '#',
                render: function (data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            { data: 'Partida', title: 'Partida' },
            { 
                data: null, 
                title: 'Código de partida',
                render: function (data, type, row) {
                    return `${row.areaCode}-${row.numeroCuenta}-${row.numeroPartida}-000`;
                }
            },
            { data: 'cuenta', title: 'Cuenta'},
            { data: 'nameArea', title: 'Departamento'},
            {
                data: null,
                title: '',
                render: function (data, type, row) {
                    return `
                    <div class="btn-group">
                        <button class="btn btn-primary edit-button col-2" data-id="${row.idPartida}" data-partida="${row.Partida}" data-codigo="${row.numeroPartida}" data-areaCode="${row.areaCode}-${row.numeroCuenta}" data-cuenta="${row.idCuenta}" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar">
                            <i class="ri-edit-line"></i>
                        </button>
                        <button class="btn btn-danger delete-button col-2" data-id="${row.idPartida}" data-partida="${row.Partida}" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar">
                            <i class="ri-delete-bin-6-line"></i>
                        </button>
                        <button class="btn btn-info view-concepts-button col-2" data-id="${row.idPartida}" data-partida="${row.Partida}" data-areaCode="${row.areaCode}-${row.numeroCuenta}-${row.numeroPartida}" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver Conceptos">
                            <i class="ri-search-line"></i>
                        </button>
                    </div>
                    `;
                }
            }
        ],
        responsive: true,
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

    // Manejar el clic en el botón "Eliminar partida"
    $('#partidas').on('click', '.delete-button', function () {
        const partidaId = $(this).data('id');
        const partidaName = $(this).data('partida');

        // Mostrar el modal de confirmación
        $('#deletePartidaName').text(partidaName);
        $('#deletePartidaModal').modal('show');

        // Confirmar la eliminación
        $('#confirmDeletePartida').off('click').on('click', function () {
            $.ajax({
                url: 'controller/ajax/ajax.form.php', // Ruta para eliminar cuentas
                method: 'POST',
                data: { deletePartida: partidaId },
                success: function (response) {
                    if (response === 'ok') {
                        partidasTable.ajax.reload();
                        alert('Partida eliminada exitosamente.');
                    } else {
                        alert('Error al eliminar la partida.');
                    }
                },
                error: function () {
                    alert('Hubo un error al intentar eliminar la partida.');
                }
            });
        });
    });
    
    // Manejar el clic en el botón "Editar partida"
    $('#partidas').on('click', '.edit-button', function () {
        const partidaId = $(this).data('id');
        const partidaName = $(this).data('partida');
        const codigoPartida = $(this).data('codigo');
        const areaCode = $(this).data('areacode');
        const cuenta = $(this).data('cuenta');
        
        // Crear un formulario dinámico
        const form = $('<form>', {
            action: 'editPartida', // URL donde se enviarán los datos
            method: 'POST'
        });

        // Agregar los datos al formulario como campos ocultos
        form.append($('<input>', { type: 'hidden', name: 'id', value: partidaId }));
        form.append($('<input>', { type: 'hidden', name: 'partida', value: partidaName }));
        form.append($('<input>', { type: 'hidden', name: 'codigoPartida', value: codigoPartida }));
        form.append($('<input>', { type: 'hidden', name: 'areaCode', value: areaCode }));
        form.append($('<input>', { type: 'hidden', name: 'cuenta', value: cuenta }));

        // Agregar el formulario al DOM y enviarlo
        $('body').append(form);
        form.submit();
    });

// Manejar el clic en el botón "Ver conceptos"
$('#partidas').on('click', '.view-concepts-button', function () {
    const partidaId = $(this).data('id');
    const areacode = $(this).data('areacode');
    $('#partidaId').val(partidaId);
    $('#partidaCode').val(areacode);
    const partidaName = $(this).data('partida');

    // Mostrar el nombre de la partida en el modal
    $('#viewConceptsName').text(partidaName);
    $('#viewConceptsModal').modal('show');

    // Cargar la lista de conceptos en el modal
    $.ajax({
        url: 'controller/ajax/getConceptos.php', // Ruta al backend que devuelve los conceptos
        method: 'POST',
        data: { idPartida: partidaId },
        dataType: 'json',
        success: function (response) {
            $('#conceptosTableBody').empty(); // Limpiar la tabla
            if (response.length === 0) {
                // Mostrar mensaje si no hay conceptos
                $('#noConceptsMessage').show();
                $('#conceptosTable').hide();
                $('#conceptosContainer').hide();
            } else {
                $('#noConceptsMessage').hide();
                $('#conceptosTable').show();
                $('#conceptosContainer').show();

                // Agregar filas a la tabla con botones de editar y eliminar
                let tableRows = '';
                response.forEach(function (concepto) {
                    tableRows += `
                        <tr>
                            <td class="concept-name">${concepto.concepto}</td>
                            <td class="concept-number">${areacode}-${concepto.numeroConcepto}</td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-primary btn-sm edit-concept-button" data-id="${concepto.idConcepto}" data-concept="${concepto.concepto}" data-number="${concepto.numeroConcepto}"><i class="ri-edit-line"></i></button>
                                    <button class="btn btn-danger btn-sm delete-concept-button" data-id="${concepto.idConcepto}"><i class="ri-delete-bin-6-line"></i></button>
                                </div>
                            </td>
                        </tr>`;
                });
                $('#conceptosTableBody').html(tableRows);
            }
        },
        error: function () {
            alert('Hubo un error al intentar cargar la lista de conceptos.');
        }
    });
});

// Manejar el clic en el botón de editar concepto
$('#conceptosTableBody').on('click', '.edit-concept-button', function () {
    let partidaCode = $('#partidaCode').val();
    const conceptName = $(this).data('concept');
    const conceptNumber = $(this).data('number');

    // Obtener la fila actual
    const row = $(this).closest('tr');

    // Convertir los campos en inputs
    row.find('.concept-name').html(`<input type="text" class="form-control edit-concept-name" value="${conceptName}">`);
    row.find('.concept-number').html(`
                    <div class="input-group">
                        <span class="input-group-text">${partidaCode}</span>
                        <input type="text" class="form-control edit-concept-number auto-format" value="${conceptNumber}">
                    </div>
                    `);

    // Ocultar los botones de editar y eliminar, y agregar botones de aceptar y cancelar
    $(this).siblings('.delete-concept-button').hide();
    $(this).hide();
    row.find('td:last-child').append(`
                <div class="btn-group editGroup">
                    <button class="btn btn-success btn-sm accept-edit-button"><i class="ri-check-line"></i></button>
                    <button class="btn btn-danger btn-sm cancel-edit-button">&times</button>
                </div>
            `);
});

// Manejar el clic en el botón de aceptar edición
$('#conceptosTableBody').on('click', '.accept-edit-button', function () {
    const row = $(this).closest('tr');
    const conceptId = row.find('.edit-concept-button').data('id');
    const updatedName = row.find('.edit-concept-name').val();
    const updatedNumber = row.find('.edit-concept-number').val();
    
    let partidaCode = $('#partidaCode').val();

    // Realizar solicitud AJAX para actualizar los datos
    $.ajax({
        url: 'controller/ajax/updateConcepto.php', // Ruta al backend para actualizar el concepto
        method: 'POST',
        data: { idConcepto: conceptId, concepto: updatedName, numeroConcepto: updatedNumber },
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                // Actualizar la fila con los nuevos datos
                row.find('.concept-name').text(updatedName);
                row.find('.concept-number').text(partidaCode + '-' +updatedNumber);
                row.find('.accept-edit-button, .cancel-edit-button').remove();
                //eliminar .editGroup 
                row.find('.editGroup').remove();
                // Mostrar los botones de editar y eliminar
                row.find('.edit-concept-button, .delete-concept-button').show();
            } else {
                alert('Hubo un error al actualizar el concepto.');
            }
        },
        error: function () {
            alert('Hubo un error al intentar actualizar el concepto.');
        }
    });
});

// Manejar el clic en el botón de cancelar edición
$('#conceptosTableBody').on('click', '.cancel-edit-button', function () {
    const row = $(this).closest('tr');
    const conceptName = row.find('.edit-concept-button').data('concept');
    const conceptNumber = row.find('.edit-concept-button').data('number');
    let partidaCode = $('#partidaCode').val();

    // Restaurar los valores originales
    row.find('.concept-name').text(conceptName);
    row.find('.concept-number').text(partidaCode + '-' +conceptNumber);

    row.find('.editGroup').remove();

    row.find('.edit-concept-button, .delete-concept-button').show();
});

// Manejar el clic en el botón de eliminar concepto
$('#conceptosTableBody').on('click', '.delete-concept-button', function () {
    const row = $(this).closest('tr'); // Obtener la fila actual
    const conceptId = $(this).data('id'); // Obtener el ID del concepto

    // Confirmar eliminación
    if (confirm('¿Estás seguro de que deseas eliminar este concepto?')) {
        $.ajax({
            url: 'controller/ajax/deleteConcepto.php', // Ruta al backend para eliminar el concepto
            method: 'POST',
            data: { idConcepto: conceptId },
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    alert('Concepto eliminado correctamente.');
                    row.remove(); // Eliminar la fila actual de la tabla
                } else {
                    alert('Hubo un error al intentar eliminar el concepto.');
                }
            },
            error: function () {
                alert('Hubo un error al intentar eliminar el concepto.');
            }
        });
    }
});

// Manejar el clic en el botón "Agregar nuevo concepto"
$('#addConceptButton').on('click', function () {
    $('#conceptosContainer').show();
    $('#conceptosTable').show();
    $('#noConceptsMessage').hide();
    let partidaCode = $('#partidaCode').val();
    // Crear una nueva fila con dos campos de entrada
    const newRow = `
        <tr>
            <td>
                <input type="text" class="form-control new-concept-name" placeholder="Nombre del concepto">
            </td>
            <td>
                <div class="input-group">
                    <span class="input-group-text">${partidaCode}</span>
                    <input type="text" class="form-control new-concept-number auto-format" placeholder="Número del concepto">
                </div>
            </td>
            <td>
                <div class="btn-group">
                    <button class="btn btn-success btn-sm save-new-concept-button"><i class="ri-check-line"></i></button>
                    <button class="btn btn-danger btn-sm cancel-new-concept-button">&times</button>
                </div>
            </td>
        </tr>`;

    // Agregar la nueva fila al cuerpo de la tabla
    $('#conceptosTableBody').append(newRow);
});

// Manejar el clic en el botón "Guardar" para guardar el nuevo concepto
$('#conceptosTableBody').on('click', '.save-new-concept-button', function () {
    const row = $(this).closest('tr');
    const newName = row.find('.new-concept-name').val();
    let newNumber = row.find('.new-concept-number').val();
    newNumber = '000';

    if (!newName || !newNumber) {
        alert('Por favor, complete ambos campos antes de guardar.');
        return;
    }

    // Realizar solicitud AJAX para guardar el nuevo concepto
    $.ajax({
        url: 'controller/ajax/addConcepto.php', // Ruta al backend para guardar el concepto
        method: 'POST',
        data: { concepto: newName, numeroConcepto: newNumber, idPartida: $('#partidaId').val() },
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                let partidaCode = $('#partidaCode').val();
                // Actualizar la fila con los datos guardados
                row.html(`
                    <td class="concept-name">${newName}</td>
                    <td class="concept-number">${partidaCode}-${newNumber}</td>
                    <td>
                        <div class="btn-group">
                            <button class="btn btn-primary btn-sm edit-concept-button" data-id="${response.id}" data-concept="${newName}" data-number="${newNumber}"><i class="ri-edit-line"></i></button>
                            <button class="btn btn-danger btn-sm delete-concept-button" data-id="${response.id}"><i class="ri-delete-bin-6-line"></i></button>
                        </div>
                    </td>
                `);
            } else {
                alert('Hubo un error al intentar guardar el concepto.');
            }
        },
        error: function () {
            alert('Hubo un error al intentar guardar el concepto.');
        }
    });
});

// Manejar el clic en el botón "Cancelar" para eliminar la fila sin guardar
$('#conceptosTableBody').on('click', '.cancel-new-concept-button', function () {
    $(this).closest('tr').remove();
});


});

$(document).on('input', '.auto-format', function() {
    let input = $(this).val().replace(/\D/g, ''); // Elimina caracteres no numéricos
    let formatted = '';

    if (input.length > 3) {
        formatted += input.substring(0, 3);
    } else {
        formatted = input;
    }

    $(this).val(formatted);
});
