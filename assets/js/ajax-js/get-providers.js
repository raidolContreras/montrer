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

    var providerTable = $('#provider').DataTable({
        ajax: {
            url: 'controller/ajax/getProviders.php', // Ajusta la URL según tu estructura
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
                data: 'providerKey',
            },
            {
                data: 'representativeName'
            },
            {
                data: 'contactPhone'
            },
            {
                data: 'businessName'
            },
            {
                data: null,
                render: function (data) {
                    // Combina los campos de la dirección fiscal en una sola columna
                    return `${data.fiscalAddressStreet}, ${data.fiscalAddressColonia}, ${data.fiscalAddressMunicipio}, ${data.fiscalAddressEstado}, ${data.fiscalAddressCP}`;
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
                render: function (data) {
                    return renderActionButtons(data.idProvider, data.status);
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

});
function renderActionButtons(idProvider, status) {

    if (status == 1) {
        return `
            <center>
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-success btn-block disabled" disabled>
                        Activo
                    </button>
                    <button class="btn btn-primary edit-button" data-id="${idProvider}">
                        <i class="ri-edit-line"></i> Editar
                    </button>
                    <button class="btn btn-warning disable-button" data-id="${idProvider}">
                        <i class="ri-forbid-line"></i> Inhabilitar
                    </button>
                    <button class="btn btn-danger delete-button" data-id="${idProvider}">
                        <i class="ri-delete-bin-6-line"></i> Eliminar
                    </button>
                </div>
            </center>
        `;
    } else {
        return `
            <center>
                <div class="btn-group" role="group">
                    <button class="btn btn-success activate-btn" data-provider="${idProvider}" data-id="${idProvider}">
                        Activar
                    </button>
                    <button class="btn btn-primary edit-button" data-id="${idProvider}">
                        <i class="ri-edit-line"></i> Editar
                    </button>
                    <button class="btn btn-warning disable-button" data-id="${idProvider}">
                        <i class="ri-forbid-line"></i> Inhabilitar
                    </button>
                    <button class="btn btn-danger delete-button" data-id="${idProvider}">
                        <i class="ri-delete-bin-6-line"></i> Eliminar
                    </button>
                </div>
            </center>
        `;
    }

}