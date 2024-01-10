$(document).ready(function () {
    var areasData = $('#areas').DataTable({
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
                    return data.firstname + ' ' + data.lastname;
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

    // Manejar el clic del botón de edición de área
    $('#areas').on('click', '.edit-button', function () {
        var idArea = $(this).data('id');
        // Implementa la lógica para editar el área
    });

    // Manejar el clic del botón de inhabilitar área
    $('#areas').on('click', '.disable-button', function () {
        var idArea = $(this).data('id');
        var areaName = $(this).closest('tr').find('td:eq(1) a').text(); // Obtener el nombre del área desde la fila

        // Mostrar el nombre del área en el modal
        $('#disableAreaName').text(areaName);

        // Mostrar el modal de inhabilitar área
        $('#disableAreaModal').modal('show');
    });

    // Manejar el clic del botón "Inhabilitar" en el modal
    $('#confirmDisableArea').on('click', function () {
        $('#disableAreaModal').modal('hide');
    });

    // Manejar el clic del botón de inhabilitar área
    $('#areas').on('click', '.disable-button', function () {
        var idArea = $(this).data('id');
        var areaName = $(this).closest('tr').find('td:eq(1) a').text(); // Obtener el nombre del área desde la fila

        // Mostrar el nombre del área en el modal
        $('#disableAreaName').text(areaName);

        // Mostrar el modal de inhabilitar área
        $('#disableAreaModal').modal('show');

        // Manejar el clic del botón "Inhabilitar" en el modal
        $('#confirmDisableArea').on('click', function () {
            $.ajax({
                type: 'POST',
                url: 'controller/ajax/ajax.form.php', // Ajusta la URL según tu estructura
                data: { 'disableArea': idArea },
                success: function (response) {
                    if (response === 'ok') {
                        // Implementa acciones adicionales si es necesario
                        console.log('Área inhabilitada con éxito');
                        areasData.ajax.reload(); // Recargar datos de DataTable
                    } else {
                        console.error('No se pudo inhabilitar el área');
                    }
                },
                complete: function () {
                    // Ocultar el modal después de completar la solicitud
                    idArea = 0;
                    $('#disableAreaModal').modal('hide');
                }
            });
        });
    });

    // Manejar el clic del botón de habilitar área
    $('#areas').on('click', '.enable-button', function () {
        var idArea = $(this).data('id');
        var areaName = $(this).closest('tr').find('td:eq(1) a').text(); // Obtener el nombre del área desde la fila

        // Mostrar el nombre del área en el modal
        $('#enableAreaName').text(areaName);

        // Mostrar el modal de habilitar área
        $('#enableAreaModal').modal('show');

        // Manejar el clic del botón "Habilitar" en el modal
        $('#confirmEnableArea').on('click', function () {
            $.ajax({
                type: 'POST',
                url: 'controller/ajax/ajax.form.php', // Ajusta la URL según tu estructura
                data: { 'enableArea': idArea },
                success: function (response) {
                    if (response === 'ok') {
                        // Implementa acciones adicionales si es necesario
                        console.log('Área habilitada con éxito');
                        areasData.ajax.reload(); // Recargar datos de DataTable
                    } else {
                        console.error('No se pudo habilitar el área');
                    }
                },
                complete: function () {
                    // Ocultar el modal después de completar la solicitud
                    idArea = 0;
                    $('#enableAreaModal').modal('hide');
                }
            });
        });
    });


    function renderAreaActionButtons(idArea, status) {
        var editButtonClass = status === 1 ? 'btn-success' : 'btn-success disable';

        var disableButtonClass = status === 1 ? 'btn-danger disable-button' : 'btn-primary enable-button';

        var editButtonDisabled = status === 0 ? 'disabled' : '';

        return `<div class="btn-group" role="group">
                <button type="button" class="btn ${editButtonClass} edit-button" data-id="${idArea}" ${editButtonDisabled}>
                <i class="ri-edit-line"></i> Editar
                </button>
                <button type="button" class="btn ${disableButtonClass}" data-id="${idArea}">
                <i class=${status === 1 ? '"ri-forbid-line"></i> Inhabilitar' : '"ri-checkbox-circle-line"></i> Habilitar'}
                </button>
                </div>
                `;
    }

});