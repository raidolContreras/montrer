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
                        console.log('Departamento inhabilitada con éxito');
                        areasData.ajax.reload(); // Recargar datos de DataTable
                    } else {
                        console.error('No se pudo inhabilitar el departamento');
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
    
    // Manejar el clic del botón de edición
    $('#areas').on('click', '.edit-button', function() {
        var idArea = $(this).data('id');
        sendForm('editArea', idArea);
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
                        console.log('Departamento habilitado con éxito');
                        areasData.ajax.reload(); // Recargar datos de DataTable
                    } else {
                        console.error('No se pudo habilitar el departamento');
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

    // Manejar el clic del botón de eliminar área
    $('#areas').on('click', '.delete-button', function () {
        var idArea = $(this).data('id');
        var areaName = $(this).closest('tr').find('td:eq(1) a').text(); // Obtener el nombre del área desde la fila

        // Mostrar el nombre del área en el modal
        $('#deleteAreaName').text(areaName);

        // Mostrar el modal de eliminar área
        $('#deleteAreaModal').modal('show');

        // Manejar el clic del botón "eliminar" en el modal
        $('#confirmDeleteArea').on('click', function () {
            $.ajax({
                type: 'POST',
                url: 'controller/ajax/ajax.form.php', // Ajusta la URL según tu estructura
                data: { 'deleteArea': idArea },
                success: function (response) {
                    if (response === 'ok') {
                        location.reload();
                    } else {
                        console.error('No se pudo eliminar el departamento');
                    }
                },
                complete: function () {
                    // Ocultar el modal después de completar la solicitud
                    idArea = 0;
                    $('#deleteAreaModal').modal('hide');
                }
            });
        });
    });

    function sendForm(action, idUser) {
        // Crear un formulario oculto y agregar el idUser como un campo oculto
        var form = $('<form action="' + action + '" method="post"></form>');
        form.append('<input type="hidden" name="register" value="' + idUser + '">');

        // Adjuntar el formulario al cuerpo del documento y enviarlo
        $('body').append(form);
        form.submit();
    }
    
    function renderAreaActionButtons(idArea, status) {
        if (status == 1) {
            return `
            <div class="d-grid gap-2 btn-group" role="group">
                    <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="ri-more-fill"></i>
                    </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <button class="dropdown-item btn btn-success edit-button" data-id="${idArea}">
                                <i class="ri-edit-line"></i> Editar
                            </button>
                            <button class="dropdown-item btn btn-danger disable-button" data-id="${idArea}">
                                <i class="ri-forbid-line"></i> Inhabilitar
                            </button>
                        </div>
                    </div>
            `;
        } else {
            return `
            <div class="d-grid gap-2 btn-group" role="group">
                    <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="ri-more-fill"></i>
                    </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <button class="dropdown-item btn btn-success edit-button" data-id="${idArea}">
                                <i class="ri-edit-line"></i> Editar
                            </button>
                            <button class="dropdown-item btn btn-primary enable-button" data-id="${idArea}">
                                <i class="ri-checkbox-circle-line"></i> Habilitar
                            </button>
                            <button class="dropdown-item btn btn-danger delete-button" data-id="${idArea}">
                                <i class="ri-delete-bin-6-line"></i> Eliminar
                            </button>
                        </div>
                    </div>
            `;
        }
    }
    

});