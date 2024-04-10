function verComprobacion(idRequest, status){
    
    if(status == true){
        $('.comment').html(`
            <label for="comentario" class="form-label">Agrega un comentario</label>
            <input type="text" class="form-control" id="comentario">
        `);
    } else {
        $('.comment').html('');
        $('.botones-modal').html('<button type="button" class="btn btn-success" data-bs-dismiss="modal">Aceptar</button>');
    }
    
    $('#verComprobacion').modal('show');
    $.ajax({
        type: 'POST',
        url: 'controller/ajax/ajax.form.php',
        data: { searchComprobante: idRequest },
        dataType: 'json',
        success: function (response) {

            $('#nombreCompletoGet').val(response.nombreCompleto);
            $('#fechaSolicitudGet').val(response.fechaSolicitud);
            $('#providerGet').val(response.business_name);
            $('#areaGet').val(response.nameArea);
            $('#importeSolicitadoGet').val(response.importeSolicitado);
            $('#importeLetraGet').val(response.importeLetra);
            $('#titularCuentaGet').val(response.titularCuenta);
            $('#entidadBancariaGet').val(response.entidadBancaria);
            $('#conceptoPagoGet').val(response.conceptoPago);
            var idPaymentRequest = response.idPaymentRequest;

            $.ajax({
                type: 'POST',
                url: 'controller/ajax/ajax.form.php', // URL actualizada si es necesario
                data: { getDocuments: idPaymentRequest },
                success: function(response) {
                    var documentos = JSON.parse(response);
                    $('#listaDocumentos').empty(); // Limpiar la lista actual
        
                    if(documentos.length > 0) {

                        documentos.forEach(function(documento) {
                            var extension = documento.split('.').pop().toLowerCase();
                            var colorClass = '';
                            var iconClass = '';
                            switch(extension) {
                                case 'pdf':
                                    colorClass = 'doc-pdf';
                                    iconClass = 'ri-file-pdf-line';
                                    break;
                                case 'xml':
                                    colorClass = 'doc-image';
                                    iconClass = 'ri-image-line';
                                    break;
                                default:
                                    colorClass = 'doc-other';
                                    iconClass = 'ri-pages-line';
                                    break;
                            }
                        
                            $('#listaDocumentos').append(`
                                <a href="view/documents/${idPaymentRequest}/${documento}" download target="_blank" class="mt-2 text-wrap">
                                    <li class="list-group-item d-flex flex-column align-items-center justify-content-center p-3">
                                        <div class="document-icon ${colorClass}"><i class="${iconClass}"></i></div>
                                        ${documento}
                                    </li>
                                </a>
                            `);
                        });
                        
                    } else {
                        $('#listaDocumentos').append(`<li class="list-group-item">No hay documentos asignados.</li>`);
                    }

                    comments(idRequest);
                    
                    $('.denegar').click(function(e){
                        denegate(idRequest);
                    });
                    
                    $('.aceptar').click(function(e){
                        acept(idRequest);
                    });

                },
                error: function() {
                    $('#listaDocumentos').append(`<li class="list-group-item">Error al buscar documentos.</li>`);
                }
            });
        },
        error: function(xhr, status, error) {
            console.error("Error al obtener los datos:", error);
        }
    });

}

function denegate(idRequest){
    var comentario = $('#comentario').val();
    $('#verComprobacion').modal('hide');
    $.ajax({
        type: 'POST',
        url: 'controller/ajax/ajax.form.php',
        data: {
            denegateComprobante: idRequest,
            comentario: comentario
        },
        success: function(response) {
            showAlertBootstrap4('Operación realizada', 'Comprobante denegado con éxito.');
        },
        error: function(xhr, status, error) {
            // Aquí manejas errores de la solicitud
            console.error("Error en la solicitud: ", error);
            alert('Ocurrió un error al denegar el elemento.');
        }
    });
}

function acept(idRequest){
    var comentario = $('#comentario').val();
    $('#verComprobacion').modal('hide');
    $.ajax({
        type: 'POST',
        url: 'controller/ajax/ajax.form.php',
        data: {
            aceptComprobante: idRequest,
            comentario: comentario
        },
        success: function(response) {
            showAlertBootstrap4('Operación realizada', 'Comprobante aprobado con éxito.');
        },
        error: function(xhr, status, error) {
            // Aquí manejas errores de la solicitud
            console.error("Error en la solicitud: ", error);
            alert('Ocurrió un error al denegar el elemento.');
        }
    });
}

function comments(idRequest) {
    $.ajax({
        type: 'POST',
        url: 'controller/ajax/ajax.form.php',
        data: {comments: idRequest},
        dataType: 'json',
        success: function (response) {
            $('input[id="comentario"]').val(response.comentarios);
        },
        error: function (error) {
            console.log('Error en la solicitud AJAX:', error);
        }
    });
}