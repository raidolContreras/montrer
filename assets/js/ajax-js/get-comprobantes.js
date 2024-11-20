
function verComprobacion(idRequest, status){
    
    if(status == true){
        $('.comment').html(`
            <label for="comentario" class="form-label">Agrega un comentario</label>
            <input type="text" class="form-control" id="comentario">
        `);
    } else {
        $('.comment').html(`
            <label for="comentario" class="form-label">Agrega un comentario</label>
            <input type="text" class="form-control" id="comentario" disabled>
        `);
        $('.botones-modal').html('<button type="button" class="btn btn-success" data-bs-dismiss="modal">Aceptar</button>');
    }

    $('#verComprovacion').modal('show');
    $.ajax({
        type: 'POST',
        url: 'controller/ajax/ajax.form.php',
        data: { searchComprobante: idRequest },
        dataType: 'json',
        success: function (response) {
            let date = new Date(response.requestDate);
            console.log(date);
            let formattedDate = date.toISOString().split('T')[0];

            $('#fechaSolicitudGet').val(formattedDate);

            $('#nombreCompletoGet').text(response.nombreCompleto);
            $('#idEmployerGet').val(response.idEmployer);
            $('#empresaGet').val(response.empresa);
            $('#areaGet').val(response.nameArea);
            $('#idAreaCargoGet').val(response.idAreaCargo);
            $('#cuentaAfectadaGet').val(response.cuentaAfectada);
            $('#idCuentaAfectadaGet').val(response.idCuentaAfectada);
            $('#partidaAfectadaGet').val(response.partidaAfectada);
            $('#idPartidaAfectadaGet').val(response.idPartidaAfectada);
            $('#conceptoGet').val(response.concepto);
            $('#idConceptoGet').val(response.idConcepto);
            $('#requestedAmountGet').val(response.approvedAmount);
            $('#importeLetraGet').val(response.importe_letra);
            $('#fechaPagoGet').val(response.paymentDate);
            $('#providerGet').val(response.idProvider);
            $('#clabeGet').val(response.clabe);
            $('#bank_nameGet').val(response.banco);
            $('#account_numberGet').val(response.numero_cuenta);
            $('#conceptoPagoGet').val(response.concepto_pago);
            $('#folioGet').text(response.folio);
            $('#cuentaAfectadaCountGet').val(response.cuentaAfectadaCount);
            $('#partidaAfectadaCountGet').val(response.partidaAfectadaCount);
            $('#polizeTypeGet').val(response.polizeType);
            $('#numberPolizeGet').val(response.numberPolize);
            $('#cargoGet').val(response.cargo);
            $('#abonoGet').val(response.abono);
            $('#fechaCargaGet').val(response.paymentDate);
            
            if (response.pagado == 1) {
                $('#estatusGet').val('pagado');
            } else if (response.status == 2 && response.pagado == 0) {
                $('#estatusGet').val('pendiente');
            } else {
                $('#estatusGet').val('denegado');
            }

            if (response.swift_code !== '') {
                // Muestra los elementos ocultos con la clase 'foreign-fields'
                $('.foreign-fields').css('display', 'flex');
            
                // Asigna valores a los campos dinámicos
                $('#swiftCodeGet').val(response.swift_code);
                $('#beneficiaryAddressGet').val(response.beneficiario_direccion || '');
                $('#currencyTypeGet').val(response.tipo_divisa || '');
            }            

            var idPaymentRequest = response.idPaymentRequest;

            $.ajax({
                type: 'POST',
                url: 'controller/ajax/ajax.form.php', // URL actualizada si es necesario
                data: { getDocuments: idPaymentRequest },
                success: function(response) {
                    var documentos = JSON.parse(response);
                    $('#listaDocumentosRequest').empty(); // Limpiar la lista actual
        
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
                        
                            $('#listaDocumentosRequest').append(`
                                <a href="view/documents/${idPaymentRequest}/${documento}" download target="_blank" class="mt-2 text-wrap">
                                    <li class="list-group-item d-flex flex-column align-items-center justify-content-center p-3">
                                        <div class="document-icon ${colorClass}"><i class="${iconClass}"></i></div>
                                        ${documento}
                                    </li>
                                </a>
                            `);
                        });
                        
                    } else {
                        $('#listaDocumentosRequest').append(`<li class="list-group-item">No hay documentos asignados.</li>`);
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
                    $('#listaDocumentosRequest').append(`<li class="list-group-item">Error al buscar documentos.</li>`);
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