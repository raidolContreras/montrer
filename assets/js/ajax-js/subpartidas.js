$(document).ready(function () {
    // Inicializar la DataTable con la configuración AJAX y columnas
    var table = $('#subpartidas').DataTable({
        ajax: {
            url: 'controller/ajax/ajax.form.php',
            type: 'POST',
            data: { action: 'listSubpartidas' },
            dataSrc: '' // Suponemos que el JSON devuelto es un array
        },
        columns: [
            { data: 'id' },
            { data: 'nombre' },
            { data: 'departamento' },
            { 
                data: null,
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    return `
                        <button class="btn btn-sm btn-primary editSubpartida" data-id="${row.id}" data-bs-toggle="tooltip" title="Editar">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-danger deleteSubpartida" data-id="${row.id}" data-bs-toggle="tooltip" title="Eliminar">
                            <i class="bi bi-trash"></i>
                        </button>
                    `;
                }
            }
        ],
        // Inicialización de tooltips luego de cargar la data
        initComplete: function(settings, json) {
            $('[data-bs-toggle="tooltip"]').tooltip();
        },
        // Reinicialización de tooltips al redibujar la tabla (paginación, búsqueda, etc.)
        drawCallback: function(settings) {
            $('[data-bs-toggle="tooltip"]').tooltip();
        }
    });

    // Manejo del submit del formulario para crear una nueva subpartida
    $('#registerSubPartidaForm').on('submit', function (e) {
        e.preventDefault();
        var nombreSubpartida = $('#nombreSubpartida').val().trim();
        var departamento = $('#departamento').val().trim();

        if (nombreSubpartida === '' || departamento === '') {
            showAlertBootstrap('¡Atención!', 'Por favor, rellena todos los campos.');
            return;
        }

        $.ajax({
            url: "controller/ajax/ajax.form.php",
            method: 'POST',
            data: {
                action: 'addSubpartida',
                subpartida: nombreSubpartida,
                idArea: departamento
            },
            dataType: 'json',
            success: function (response) {
                if (response.error) {
                    showAlertBootstrap('Error', response.error);
                } else {
                    showAlertBootstrap('Éxito', 'Subpartida registrada correctamente.');
                    // Limpiar los campos
                    $('#nombreSubpartida').val('');
                    $('#departamento').val('');
                    // Recargar la DataTable sin resetear la paginación
                    table.ajax.reload(null, false);
                }
            },
            error: function (xhr, status, error) {
                showAlertBootstrap('Error', 'Ha ocurrido un error al registrar la subpartida.');
            }
        });
    });

    // Eventos para los botones de editar y eliminar en la DataTable
    $('#subpartidasTable tbody').on('click', '.editSubpartida', function () {
        var id = $(this).data('id');
        // Aquí implementas la lógica para editar (por ejemplo, abrir un modal con el formulario de edición)
        console.log('Editar subpartida con ID: ' + id);
    });

    $('#subpartidasTable tbody').on('click', '.deleteSubpartida', function () {
        var id = $(this).data('id');
        // Aquí implementas la lógica para eliminar (mostrar confirmación y enviar el AJAX correspondiente)
        console.log('Eliminar subpartida con ID: ' + id);
    });
});
