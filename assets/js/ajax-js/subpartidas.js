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
            {
                data: null,
                title: '#',
                render: function (data, type, row, meta) {
                    // Utilizando el contador proporcionado por DataTables
                    return meta.row + 1;
                }
            },
            {
                data: 'nombre',
                title: 'Subpartida'
            },
            {
                data: 'nameArea',
                title: 'Departamento'
            },
            {
                data: null,
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `
                    <div class="container">
                        <div class="row btn-group" role="group" style="justify-content: center;">
                            <button type="button" class="btn btn-primary edit-button col-2" data-subpartida="${row.nombre}" data-id="${data.idSubpartida}" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Editar" data-bs-original-title="Editar">
                                <i class="ri-pencil-line"></i>
                            </button>
                            <button type="button" class="btn btn-danger delete-button col-2" data-subpartida="${row.nombre}" data-id="${data.idSubpartida}" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Eliminar" data-bs-original-title="Eliminar">
                                <i class="ri-delete-bin-6-line"></i>
                            </button>
                        </div>
                    </div>
                    `;
                },
                title: 'Acciones'
            }
        ],
        // Inicialización de tooltips luego de cargar la data
        initComplete: function (settings, json) {
            $('[data-bs-toggle="tooltip"]').tooltip();
        },
        // Reinicialización de tooltips al redibujar la tabla (paginación, búsqueda, etc.)
        drawCallback: function (settings) {
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
    $('#subpartidas tbody').on('click', '.edit-button', function () {
        var id = $(this).data('id');
        $.ajax({
            url: 'controller/ajax/ajax.form.php',
            method: 'POST',
            data: {
                action: 'getSubpartida',
                idSubpartida: id
            },
            dataType: 'json',
            success: function (response) {
                if (response.error) {
                    showAlertBootstrap('Error', response.error);
                } else {
                    // abrir modal y editar la subpartida
                    $('#idSubpartida').val(response.idSubpartida);
                    $('#editNombreSubpartida').val(response.nombre);
                    $('#editDepartamento').val(response.idArea);

                    // Mostrar el modal de edición de subpartida
                    $('#editSubPartidaModal').modal('show');
                    // Manejar el submit del formulario para editar la subpartida
                    $('#editSubPartidaForm').on('submit', function (e) {
                        e.preventDefault();
                        var nombreSubpartida = $('#editNombreSubpartida').val().trim();
                        var departamento = $('#editDepartamento').val().trim();
                        var idSubpartida = $('#idSubpartida').val().trim();
                        if (nombreSubpartida === '' || departamento === '') {
                            showAlertBootstrap('¡Atención!', 'Por favor, rellena todos los campos.');
                            return;
                        } else {
                            $.ajax({
                                url: "controller/ajax/ajax.form.php",
                                method: 'POST',
                                data: {
                                    action: 'editSubpartida',
                                    idSubpartida: idSubpartida,
                                    nombre: nombreSubpartida,
                                    idArea: departamento
                                },
                                dataType: 'json',
                                success: function (response) {
                                    if (response.error) {
                                        showAlertBootstrap('Error', response.error);
                                    } else {
                                        showAlertBootstrap('Éxito', 'Subpartida editada correctamente.');
                                        // Cerrar el modal de edición
                                        $('#editSubPartidaModal').modal('hide');
                                        // Recargar la DataTable sin resetear la paginación
                                        table.ajax.reload(null, false);
                                    }
                                },
                            });
                        }

                    });
                }
            },
            error: function (xhr, status, error) {
                showAlertBootstrap('Error', 'Ha ocurrido un error al editar la subpartida.');
            }
        });
    });

    $('#subpartidas tbody').on('click', '.delete-button', function () {
        var id = $(this).data('id');
        var partidaName = $(this).data('subpartida');
        // pregunta primero abriendo el modal deleteSubPartidaModal

        $('#deleteSubPartidaName').text(partidaName);
        $('#deleteSubPartidaModal').modal('show');


        $('#confirmDeleteSubPartida').off('click').on('click', function () {
            $.ajax({
                url: 'controller/ajax/ajax.form.php',
                method: 'POST',
                data: {
                    action: 'deleteSubpartida',
                    idSubpartida: id
                },
                success: function (response) {
                    if (response.error) {
                        showAlertBootstrap('Error', response.error);
                    } else {
                        showAlertBootstrap('Éxito', 'Subpartida eliminada correctamente.');
                        // Recargar la DataTable sin resetear la paginación
                        table.ajax.reload(null, false);
                    }
                },
                error: function (xhr, status, error) {
                    showAlertBootstrap('Error', 'Ha ocurrido un error al eliminar la subpartida.');
                }
            });
        });
    });
});
