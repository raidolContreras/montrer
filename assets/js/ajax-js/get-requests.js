$(document).ready(function () {
    
	var level = $("input[name='level']").val();

    const Toast = Swal.mixin({
        toast: true,
        position: "center",
        showConfirmButton: false,
        timerProgressBar: false,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
    });

	moment.locale('es');
    $('#requests').DataTable({
        ajax: {
            url: 'controller/ajax/getRequests.php', // Ajusta la URL según tu estructura
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
                data: 'nameArea',
            },
            {
				data: 'requestedAmount',
				render: function (data, type, row) {
					if (type === 'display' || type === 'filter') {
						// Formatear como pesos
						var formattedBudget = parseFloat(data).toLocaleString('es-MX', {
							style: 'currency',
							currency: 'MXN'
						});
						return formattedBudget;
					}
					return data;
				}
            },
            {
                data: null,
                render: function (data){
                    return data.firstname + ' ' + data.lastname;
                }
            },
            {
                data: 'description'
            },
            {
                data: 'requestDate',
				render: function(data, type, row) {
					return moment(data).format('DD-MMM-YYYY hh:mm A');
				}
            },
            {
                data: null,
                render: function (data) {
                    return renderActionButtons(data.idRequest, data.status, data.user);
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

    $('#requests').on('click', '.delete-button', function () {
        var idRequest = $(this).data('id');
        var RequestName = $(this).closest('tr').find('td:eq(1) a').text();

        $('#deleteRequestName').text(RequestName);
        $('#confirmDeleteRequest').data('id', idRequest);
        $('#deleteModal').modal('show');
    });

    $('#confirmDeleteRequest').on('click', function () {
        var idRequest = $(this).data('id');

        $.ajax({
            type: 'POST',
            url: 'controller/ajax/ajax.form.php',
            data: { 'deleteRequest': idRequest },
            success: function (response) {
                if (response === 'ok') {
                    Swal.fire({
                        icon: "success",
                        title: 'Solicitud eliminada con éxito',
                        confirmButtonColor: '#026f35',
                        confirmButtonText: 'Aceptar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    });

                } else {
                    Swal.fire({
                        icon: "error",
                        title: 'Error',
                        text: 'No se pudo eliminar la solicitud',
                        confirmButtonColor: '#026f35',
                        confirmButtonText: 'Aceptar'
                    });
                }
            },
            complete: function () {
                idRequest = 0;
                $('#deleteModal').modal('hide');
            }
        });
    });

function renderActionButtons(idRequest, status, level) {

    if (status = 0 && level != 1){
        return `
            <center>
                <div class="btn-group" role="group">
                    <button class="btn btn-primary edit-button" data-id="${idRequest}">
                        <i class="ri-edit-line"></i> Editar
                    </button>
                    <button class="btn btn-danger delete-button" data-id="${idRequest}">
                        <i class="ri-delete-bin-6-line"></i> Eliminar
                    </button>
                </div>
            </center>
        `;
    } else {
        return `
            <center>
                <div class="btn-group" role="group">
                    <button class="btn btn-success edit-button" data-id="${idRequest}">
                        <i class="ri-forbid-line"></i> Aceptar
                    </button>
                    <button class="btn btn-danger delete-button" data-id="${idRequest}">
                        <i class="ri-delete-bin-6-line"></i> Denegar
                    </button>
                </div>
            </center>
        `;
    }
}