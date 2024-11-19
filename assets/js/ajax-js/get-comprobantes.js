
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
            /* {
  "idPaymentRequest": 24,
  "nombreCompleto": "HN Gonzalez Garcia",
  "fechaSolicitud": "2024-11-18",
  "idProvider": 2,
  "idArea": 3,
  "importeSolicitado": 16500,
  "importeLetra": "Dieciséis mil quinientos pesos",
  "titularCuenta": "Héctor Noel González García",
  "entidadBancaria": "BBVA",
  "conceptoPago": "asdasd",
  "idRequest": 1,
  "idUser": 3,
  "fechaEnvio": "2024-11-18 17:30:19",
  "statusPayment": 1,
  "solicitante_nombre": "HN Gonzalez Garcia",
  "empresa": "colegios.pucp.net",
  "concepto": "rrr",
  "cuentaAfectada": "asd",
  "partidaAfectada": "eee",
  "idEmployer": "1111-111-111-111",
  "idAreaCargo": "2222-222-222-222-222",
  "idCuentaAfectada": "3333-333-333-333-333",
  "idPartidaAfectada": "4444-444-444-444-444",
  "idConcepto": "5555-555-555-555-555",
  "importe_solicitado": 16500,
  "importe_letra": "Dieciséis mil quinientos pesos",
  "fecha_pago": "2024-11-22",
  "clabe": "34567789996",
  "banco": "BBVA",
  "numero_cuenta": "58980398",
  "swift_code": "ABCDEFG",
  "beneficiario_direccion": "Casa de JUANICHI",
  "tipo_divisa": "DOLAR",
  "concepto_pago": "asdasd",
  "folio": "1BDG241114",
  "approvedAmount": 16500,
  "importe_letra_aprobado": null,
  "responseDate": "2024-11-18 11:20:25",
  "status": 5,
  "active": 0,
  "pagado": 1,
  "paymentDate": "2024-11-23",
  "comentarios": "Aceptado",
  "requestDate": "2024-11-14 22:29:37",
  "idAdmin": 3,
  "idBudget": 28,
  "cuentaAfectadaCount": "5002-001-002-003-033",
  "partidaAfectadaCount": "1002-102-501-110",
  "polizeType": "EG",
  "numberPolize": "10023",
  "cargo": 16500,
  "abono": 16500,
  "complete": 1,
  "nameArea": "Banda de guerra",
  "business_name": "Héctor Noel González García"
}
            */
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