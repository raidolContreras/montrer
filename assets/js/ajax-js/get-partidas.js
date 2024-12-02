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
            method: 'GET',
            dataSrc: ''
        },
        columns: [
            { data: null, title: '#',
                render: function (data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            { data: 'Partida', title: 'Partida' },
            { data: 'numeroPartida', title: 'Código de partida' },
            {
                data: null,
                title: '',
                render: function (data, type, row) {
                    return `
						<button class="btn btn-primary edit-button col-2" data-id="${row.idPartida}" data-partida="${row.Partida}" data-codigo="${row.numeroPartida}" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar">
							<i class="ri-edit-line"></i>
						</button>
						<button class="btn btn-danger delete-button col-2" data-id="${row.idPartida}" data-partida="${row.Partida}" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar">
							<i class="ri-delete-bin-6-line"></i>
						</button>
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

        // Crear un formulario dinámico
        const form = $('<form>', {
            action: 'editPartida', // URL donde se enviarán los datos
            method: 'POST'
        });

        // Agregar los datos al formulario como campos ocultos
        form.append($('<input>', { type: 'hidden', name: 'id', value: partidaId }));
        form.append($('<input>', { type: 'hidden', name: 'partida', value: partidaName }));
        form.append($('<input>', { type: 'hidden', name: 'codigoPartida', value: codigoPartida }));

        // Agregar el formulario al DOM y enviarlo
        $('body').append(form);
        form.submit();
    });

});
