function verComprobacion(idRequest){
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

            $.ajax({
                type: 'POST',
                url: 'controller/ajax/ajax.form.php', // URL actualizada si es necesario
                data: { getDocuments: idRequest },
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
                                case 'jpg':
                                case 'jpeg':
                                case 'png':
                                    colorClass = 'doc-image';
                                    iconClass = 'ri-image-line';
                                    break;
                                default:
                                    colorClass = 'doc-other';
                                    iconClass = 'ri-pages-line';
                                    break;
                            }
                        
                            $('#listaDocumentos').append(`
                                <a href="view/documents/${idRequest}/${documento}" target="_blank" class="mt-2 text-wrap">
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
                },
                error: function() {
                    $('#listaDocumentos').append(`<li class="list-group-item">Error al buscar documentos.</li>`);
                }
            });
        },
        error: function(xhr, status, error) {
            console.error("Error al obtener los datos:", error);
            // Manejo de errores, por ejemplo, mostrar un mensaje al usuario.
        }
    });
}
