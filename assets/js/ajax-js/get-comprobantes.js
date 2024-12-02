function formatearfecha(date) {
    // Supongamos que response.requestDate tiene el formato '2024-11-18 22:46:36'
    let fechaCompleta = date;

    // Extraemos solo la parte de la fecha antes del espacio
    let soloFecha = fechaCompleta.split(' ')[0];

    // Dividimos la fecha en sus componentes (año, mes, día)
    let [year, month, day] = soloFecha.split('-');

    // Reorganizamos la fecha al formato 'día/mes/año'
    let fechaFormatoNuevo = `${day}/${month}/${year}`;
    return fechaFormatoNuevo;
}

function verComprobacion(idRequest, status){
    
    if(status == true){
        $('.comment').html(`
            <label for="comentario" class="form-label">Agrega un comentario</label>
            <input type="text" class="form-control" id="comentario">
        `);
    } else {
        $('.comment').html(`
            <label for="comentario" class="form-label">Comentario</label>
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
            // Supongamos que response.requestDate tiene el formato '2024-11-18 22:46:36'
            let requestdate;
            let paymentDate;

            if (response.pagado == 1) {
                requestdate = formatearfecha(response.requestDate);
                paymentDate = formatearfecha(response.paymentDate);
            }

            // Asignamos la fecha al elemento
            $('#fechaSolicitudGet').text(requestdate);

            $('#nombreCompletoGet').text(response.solicitante_nombre);
            $('#idEmployerGet').text(response.idEmployer);
            $('#empresaGet').text(response.empresa);
            $('#areaGet').text(response.nameArea);
            $('#idAreaCargoGet').text(response.idAreaCargo);
            $('#cuentaAfectadaGet').text(response.cuentaAfectada);
            $('#idCuentaAfectadaGet').text(response.idCuentaAfectada);
            $('#partidaAfectadaGet').text(response.partidaAfectada);
            $('#idPartidaAfectadaGet').text(response.idPartidaAfectada);
            $('#conceptoGet').text(response.concepto);
            $('#idConceptoGet').text(response.idConcepto);
            $('#requestedAmountGet').text(formatCurrency(response.importe_solicitado));
            $('#importeLetraGet').text(response.importe_letra);
            $('#fechaPagoGet').text(response.paymentDate);
            $('#providerGet').text(response.business_name);
            $('#clabeGet').text(response.clabe);
            $('#bank_nameGet').text(response.banco);
            $('#account_numberGet').text(response.numero_cuenta);
            $('#conceptoPagoGet').text(response.concepto_pago);
            $('#folioGet').text(response.folio);
            $('#cuentaAfectadaCountGet').text(response.cuentaAfectadaCount);
            $('#partidaAfectadaCountGet').text(response.partidaAfectadaCount);
            $('#polizeTypeGet').text(response.polizeType);
            $('#numberPolizeGet').text(response.numberPolize);
            // Asignar el formato a los elementos
            $('#cargoGet').text(formatCurrency(response.cargo));
            $('#abonoGet').text(formatCurrency(response.abono));
            $('#fechaCargaGet').text(paymentDate);
            
            if (response.pagado == 1) {
                $('#estatusGet').text('pagado');
            } else if (response.status == 2 && response.pagado == 0) {
                $('#estatusGet').text('pendiente');
            } else {
                $('#estatusGet').text('denegado');
            }

            if (response.swift_code !== '') {
                // Muestra los elementos ocultos con la clase 'foreign-fields'
                $('.foreign-fields').css('display', 'flex');
                $('.clabe').css('display', 'none');
            
                // Asigna valores a los campos dinámicos
                $('#swiftCodeGet').text(response.swift_code);
                $('#beneficiaryAddressGet').text(response.beneficiario_direccion || '');
                $('#currencyTypeGet').text(response.tipo_divisa || '');
            }    else {
                // Oculta los elementos ocultos con la clase 'foreign-fields'
                $('.foreign-fields').css('display', 'none');
                $('.clabe').css('display', 'flex');
                $('#swiftCodeGet').text('');
                $('#beneficiaryAddressGet').text('');
                $('#currencyTypeGet').text('');

            }         

            var idRequest = response.idRequest;

            $.ajax({
                type: 'POST',
                url: 'controller/ajax/ajax.form.php', // URL actualizada si es necesario
                data: { getDocuments: idRequest },
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
                                <a href="view/documents/requestTemp/${idRequest}/${documento}" download target="_blank" class="mt-2 text-wrap">
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
// Función para formatear como moneda
function formatCurrency(amount) {
    return new Intl.NumberFormat('es-MX', {
        style: 'currency',
        currency: 'MXN',
        minimumFractionDigits: 2
    }).format(amount);
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