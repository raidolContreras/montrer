$(document).ready(function () {
    
    const Toast = Swal.mixin({
        toast: true,
        position: "center",
        showConfirmButton: false,
        timer: 1500,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
    });
    
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
        var idExercise = $(this).data('exercise');

        // Realiza la solicitud Ajax a exerciseOn.php con el idExercise
        $.ajax({
            type: "POST",
            url: "controller/ajax/exerciseOn.php",
            data: { idExercise: idExercise },
            success: function (response) {
                exerciseTable.ajax.reload();
                Swal.fire({
                icon: 'success',
                title: 'Se cambio de ejercicio exitosamente',
                });
            },
            error: function (error) {
                console.log("Error en la solicitud Ajax:", error);
            }
        });
    });

    // Manejar el clic del botón de inhabilitar ejercicio
    $('#exercise').on('click', '.disable-button', function () {
        var idExercise = $(this).data('id');
        var exerciseName = $(this).closest('tr').find('td:eq(1)').text();

        // Mostrar el nombre del ejercicio en el modal
        $('#disableExerciseName').text(exerciseName);

        // Mostrar el modal de inhabilitar ejercicio
        $('#disableExerciseModal').modal('show');

        // Manejar el clic del botón "Inhabilitar" en el modal
        $('#confirmDisableExercise').on('click', function () {
            handleUserAction(idExercise, 'disableExercise', 'No se pudo inhabilitar el ejercicio');
        });
    });

    // Manejar el clic del botón de habilitar ejercicio
    $('#exercise').on('click', '.enable-button', function () {
        var idExercise = $(this).data('id');
        var exerciseName = $(this).closest('tr').find('td:eq(1)').text(); // Obtener el nombre del ejercicio desde la fila

        // Mostrar el nombre del ejercicio en el modal
        $('#enableExerciseName').text(exerciseName);

        // Mostrar el modal de habilitar ejercicio
        $('#enableExerciseModal').modal('show');

        // Manejar el clic del botón "Habilitar" en el modal
        $('#confirmEnableExercise').on('click', function () {
            handleUserAction(idExercise, 'enableExercise', 'No se pudo habilitar el ejercicio');
        });
    });

    // Manejar el clic del botón de habilitar ejercicio
    $('#exercise').on('click', '.delete-button', function () {
        var idExercise = $(this).data('id');
        var exerciseName = $(this).closest('tr').find('td:eq(1)').text(); // Obtener el nombre del ejercicio desde la fila

        // Mostrar el nombre del ejercicio en el modal
        $('#deleteExerciseName').text(exerciseName);

        // Mostrar el modal de habilitar ejercicio
        $('#deleteExerciseModal').modal('show');

        // Manejar el clic del botón "Habilitar" en el modal
        $('#confirmDeleteExercise').on('click', function () {
            handleUserAction(idExercise, 'deleteExercise', 'No se pudo eliminar el ejercicio');
        });
    });

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
                        <button type="button" class="btn btn-success btn-block disabled" disabled>
                            Activo
                        </button>
                        <button class="btn btn-primary edit-button" data-id="${idExercise}">
                            <i class="ri-edit-line"></i> Editar
                        </button>
                        <button class="btn btn-warning disable-button" data-id="${idExercise}">
                            <i class="ri-forbid-line"></i> Inhabilitar
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
                        <i class="ri-forbid-line"></i> Inhabilitar
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
    

    function handleUserAction (idExercise, nameVariant, errorMessage){
        $.ajax({
            type: 'POST',
            url: 'controller/ajax/ajax.form.php', // Ajusta la URL según tu estructura
            data: { [nameVariant]: idExercise },
            success: function (response) {
                if (response === 'ok') {
                } else {
                    console.error(errorMessage);
                }
            },
            complete: function () {
                location.reload();
            }
        });
    }

});
