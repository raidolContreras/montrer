$(document).ready(function () {
    $('#companies').DataTable({
        ajax: {
            url: 'controller/ajax/getCompanies.php',
            dataSrc: '',
            dataType: 'json',
        },
        columns: [
            {
                data: null,
                render: function (data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            { 
                data: null,
                render: function(data, type, row) {
                    return `${data.name}`;
                }
            },
            { data: 'description' },
            {
                data: null,
                render: function(data) {
                    // Verificar si level es un número y es diferente de cero
                    var level = $('#level').val();
                    if (!isNaN(level) && level != 0) {
                        var idBusiness = data.idAridBusinessea;
                        var status = data.status;
                        return renderAreaActionButtons(idBusiness, status);
                    } else {
                        var status = (data.status == 1) ? 'Habilitado' : 'Deshabilitado';
                        return status;
                    }
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
            "infoEmpty":      "Sin resultados",
            "emptyTable":	  "Ningún dato disponible en esta tabla"
        }
    });
});

function renderAreaActionButtons(idBusiness, status) {
    if (status == 1) {
        return `
        <div class="container">
            <div class="row btn-group" role="group" style="justify-content: center;">
                <button class="btn btn-primary edit-button col-2" data-id="${idBusiness}" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar">
                    <i class="ri-edit-line"></i>
                </button>
                <button class="btn btn-warning disable-button col-2" data-id="${idBusiness}" data-bs-toggle="tooltip" data-bs-placement="top" title="Deshabilitar">
                    <i class="ri-forbid-line"></i>
                </button>
                <button class="btn btn-danger delete-button col-2" data-id="${idBusiness}" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar">
                    <i class="ri-delete-bin-6-line"></i>
                </button>
                <button class="btn btn-link users-button col-2" data-id="${idBusiness}" data-bs-toggle="tooltip" data-bs-placement="top" title="Asignar usuarios">
                    <i class="ri-team-fill"></i>
                </button>
            </div>
        </div>
        `;
    } else {
        return `
        <div class="container">
            <div class="row btn-group" role="group" style="justify-content: center;">
                <button class="btn btn-primary edit-button col-2" data-id="${idBusiness}" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar">
                    <i class="ri-edit-line"></i>
                </button>
                <button class="btn btn-success enable-button col-2" data-id="${idBusiness}" data-bs-toggle="tooltip" data-bs-placement="top" title="Habilitar">
                    <i class="ri-checkbox-circle-line"></i>
                </button>
                <button class="btn btn-danger delete-button col-2" data-id="${idBusiness}" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar">
                    <i class="ri-delete-bin-6-line"></i>
                </button>
                <button class="btn btn-link users-button col-2" data-id="${idBusiness}" data-bs-toggle="tooltip" data-bs-placement="top" title="Asignar usuarios">
                    <i class="ri-team-fill"></i>
                </button>
            </div>
        </div>
        `;
    }
}