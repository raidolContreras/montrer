var bandera = 0;
$(document).ready(function () {

    var request = $('#request').val();
    var registerValue = $('#register-value').data('register');

    // Detectar cambios en cualquier campo del formulario y establecer la bandera a 1
    $("form.account-wrap input, form.account-wrap select").change(function() {
        bandera = 1;
    });

	$("form.account-wrap").submit(function (event) {

		event.preventDefault();

		var area = $("select[name='area']").val();
        var requestedAmount = parseFloat($("input[name='requestedAmount']").val());
		var description = $("textarea[name='description']").val();
		var provider = $("select[name='provider']").val();
        var eventDate = $("input[name='eventDate']").val();
		var maxBudget = parseFloat($("input[name='maxBudget']").val());
		var budget = $("input[name='budget']").val();
		var folio = $("input[name='folio']").val();

		if (area == '' || requestedAmount == '' || description == '' || event == '' || eventDate == '' || provider == ''){
            
            showAlertBootstrap('¡Atención!', 'Por favor, introduzca la información solicitada en todos lo campos señalados con un (*).');
            
		} else if (maxBudget >= requestedAmount) {

			$.ajax({
				type: "POST",
				url: "controller/ajax/ajax.form.php",
				data: {
					areaEdit: area,
					requestedAmountEdit: requestedAmount,
					descriptionEdit: description,
                    eventDateEdit: eventDate,
					budgetEdit: budget,
                    providerEdit: provider,
                    requestEdit: request
				},
				success: function (response) {				  
	
					if (response === 'ok') {
						
                        idPaymentRequestTemp = request;
                        myDropzone.processQueue();
						bandera = 0;
						$("select[name='area']").val('');
						$("input[name='requestedAmount']").val('');
						$("textarea[name='description']").val('');
                        $("input[name='eventDate']").val('');
                        $('.sidenav').removeAttr('onclick');

	                    showAlertBootstrap1('Operación realizada', 'Presupuesto actualizado correctamente', 'requestBudget');

					} else {
                        
	                    showAlertBootstrap('!Atención¡', 'Error al crear la solicitud.');
                        
					}
				},
				error: function (error) {
					console.log("Error en la solicitud Ajax:", error);
				}
			});

		} else {
            showAlertBootstrap('¡Atención!', 'La cantidad solicitada no debe de superar el monto disponible mensual.');
        }
        // Configuración del evento 'sending' del Dropzone
        myDropzone.on("sending", function(file, xhr, formData) {
            formData.append("idPaymentRequestTemp", idPaymentRequestTemp);
        });
	});

    restartSelectProvider(request);

    getArea(registerValue);
    
    // Manejador de eventos para el cambio en el select
    $('#provider').on('change', function() {
        // Verifica si la opción seleccionada es "Añadir proveedor"
        if ($(this).val() === "add_provider") {
            $('#modalAgregarProveedor').modal('show');
        }
    });

});

document.addEventListener('DOMContentLoaded', function () {
	var cancelButton = document.getElementById('cancelButton');

	cancelButton.addEventListener('click', function (event) {

		event.preventDefault();
		showAlertBootstrap2('Cancelar', '¿Seguro que desea cancelar?', 'requestBudget');

	});
});

function getArea(registerValue) {
    $.ajax({
        type: 'POST',
        url: 'controller/ajax/getAreasManager.php',
        data: {user: registerValue},
        dataType: 'json',
        success: function (response) {
            $('select[name="area"]').val(response.nameArea);

            // Llena el select de áreas
            fillAreaSelect('area', response, 'departamento');

        },
        error: function (error) {
            console.log('Error en la solicitud AJAX:', error);
        }
    });
}

function fillAreaSelect(select, datas, message) {
    var selectOption = $('#' + select);

    selectOption.empty();
    var init = 1;
    datas.forEach(function (data) {
        var option = $('<option>').val(data[0]).text(data[1]);
        selectOption.append(option);
        if (init == 1) {
            $.ajax({
                type: 'POST',
                url: 'controller/ajax/getAuthorizedAmount.php',
                data: { areaId: data[0] },
                dataType: 'json',
                success: function (response) {
                    updateMaxRequestedAmount(response);
                },
                error: function (error) {
                    console.log('Error en la solicitud AJAX:', error);
                }
            });
            init = 0;
        }
    });
}

// Luego, agrega el evento change al select de áreas
$('#area').on('change', function() {
    var selectedAreaId = $(this).val();

    $.ajax({
        type: 'POST',
        url: 'controller/ajax/getAuthorizedAmount.php',
        data: { areaId: selectedAreaId },
        dataType: 'json',
        success: function (response) {
            updateMaxRequestedAmount(response);
        },
        error: function (error) {
            console.log('Error en la solicitud AJAX:', error);
        }
    });

});

function updateMaxRequestedAmount(datos) {
    if (!datos) {
        // Si authorizedAmount es falso (undefined, null, 0, '', false), deshabilita el campo de entrada y reinicia los valores
        $('#requestedAmount').prop('disabled', true);
        $('#requestedAmount').val('');
        $('.requestMax').text('En el presente ejercicio, no se ha asignado un presupuesto para el departamento correspondiente');
    } else {
            
        $.ajax({
            type: 'POST',
            url: 'controller/ajax/countAreaId.php',
            data: {idArea: datos[0].idArea },
            dataType: 'json', // Asegúrate de indicar que esperas un objeto JSON
            success: function (response) {

                var totalBudgetPendient = 0;

                $.ajax({
                    type: 'POST',
                    url: 'controller/ajax/getAmountPendient.php',
                    data: { areaId: datos[0].idArea },
                    dataType: 'json',
                    success: function (result) {
                        for (var i = 0; i < result.length; i++) {
                            // Obtenemos la cantidad de cada objeto y la sumamos al total
                            totalBudgetPendient += parseFloat(result[i].requestedAmount);
                        }
                        var pendient = totalBudgetPendient- $('#requestedAmount').val()
                        // Mostramos la suma total
                        totalAmountBudget = response.total - response.comp - pendient;

                        formattedSum = totalAmountBudget.toLocaleString('es-MX', {
                            style: 'currency',
                            currency: 'MXN',
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2,
                        });

                        // Aquí puedes colocar el código que depende de totalAmountBudget
                        var idBudget = datos[0].idBudget;
                        if(datos[0].approvedAmount !== 0){
                            $("input[name='budget']").val(idBudget);
                            $("input[name='maxBudget']").val(totalAmountBudget.toFixed(2));
                            // $('#requestedAmount').val(totalAmountBudget.toFixed(2));
                            $('.requestMax').text('Presupuesto maximo a solicitar es de: ' + formattedSum);
                        } else {
                            $('#requestedAmount').prop('disabled', true);
                            $('.requestMax').text('No se puede solicitar un nuevo presupuesto porque no se ha justificado uno anterior.');
                        }
                        
                    },
                    error: function (error) {
                        console.log('Error en la solicitud AJAX:', error);
                    }
                });

            }
        });
    }
}

function openAddProviderModal() {
    $('#addProviderModal').modal('show');
}

function confirmExit(event, destination) {
	if (bandera == 1){
		event.preventDefault();
		showAlertBootstrap2('¿Está seguro?', 'Si sale del formulario, perderá los cambios no guardados.', destination);
	}
}

function searchRequest(idRequest) {
    $.ajax({
        type: 'POST',
        url: 'controller/ajax/searchRequest.php',
        data: { idRequest: idRequest },
        dataType: 'json',
        success: function (response) {

            $.ajax({
                type: 'POST',
                url: 'controller/ajax/ajax.form.php', // URL actualizada si es necesario
                data: { getDocumentsTemp: idRequest },
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
                                <li class="list-group-item d-flex flex-column align-items-center justify-content-center p-3">
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger deleteButton" onclick="deleteDocument('${documento}', ${idRequest})">
                                        &times;
                                        <span class="visually-hidden">unread messages</span>
                                    </span>
                                    <div>
                                        <a href="view/documents/requestTemp/${idRequest}/${documento}" download target="_blank" class="mt-2 text-wrap">
                                            <div class="document-icon ${colorClass}">
                                                <i class="${iconClass}"></i>
                                            </div>
                                        </a>
                                    </div>
                                    ${documento}
                                </li>
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
            
            $('#requestedAmount').val(response.requestedAmount);
            $('#provider').val(response.idProvider);
            $('#area').val(response.idArea);
            $('#description').val(response.description);
            $('#event').val(response.event);
            $('#eventDate').val(response.eventDate);
            $('#folio').val(response.folio);
            
            var datetimeString = response.requestDate;
            var parts = datetimeString.split(' ');
            var dateString = parts[0];
            $('#fecha').val(dateString);
            
        },
        error: function (error) {
            console.log('Error en la solicitud AJAX:', error);
        }
    });
}

function restartSelectProvider(request) {

    // Realiza la solicitud Ajax a exerciseOn.php con el idExercise
    $.ajax({
        type: "POST",
        url: "controller/ajax/getProviders.php",
        success: function (response) {
            // Parsea la respuesta JSON
            var providers = JSON.parse(response);
            var selectOptionsHtml = `<option value="">Seleccionar proveedor</option>`;

            // Crea las opciones para el select
            providers.forEach(function(provider) {
                selectOptionsHtml += `<option value="${provider.idProvider}">${provider.representative_name}</option>`;
            });

            // Agrega la opción "Añadir proveedor" con un ícono de +
            selectOptionsHtml += `<option value="add_provider" class="add-provider-option">&#43; Añadir proveedor</option>`;
            
            $('#provider').html(selectOptionsHtml);
            
            searchRequest(request);
            
        },
        error: function (error) {
            console.log("Error en la solicitud Ajax:", error);
        }
    });

}

// Manejar la selección de "add_provider"
$('#provider').on('select2:select', function (e) {
    const selectedValue = e.params.data.id;
    if (selectedValue === 'add_provider') {
        $('#modalAgregarProveedor').modal('show');
    }
});

function deleteDocument(document, idRequest) {
    // Confirmar si el usuario desea eliminar el documento
    var confirmDelete = confirm("¿Estás seguro de que deseas eliminar este documento?");
    
    // Si el usuario confirma la eliminación
    if (confirmDelete) {
        $.ajax({
            type: 'POST',
            url: 'controller/ajax/deleteDocument.php',
            data: { document: document, idRequest: idRequest },
            dataType: 'json',
            success: function (response) {
                

            $.ajax({
                type: 'POST',
                url: 'controller/ajax/ajax.form.php', // URL actualizada si es necesario
                data: { getDocumentsTemp: idRequest },
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
                                <li class="list-group-item d-flex flex-column align-items-center justify-content-center p-3">
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger deleteButton" onclick="deleteDocument('${documento}', ${idRequest})">
                                        &times;
                                        <span class="visually-hidden">unread messages</span>
                                    </span>
                                    <div>
                                        <a href="view/documents/requestTemp/${idRequest}/${documento}" download target="_blank" class="mt-2 text-wrap">
                                            <div class="document-icon ${colorClass}">
                                                <i class="${iconClass}"></i>
                                            </div>
                                        </a>
                                    </div>
                                    ${documento}
                                </li>
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
            error: function (error) {
                console.log('Error en la solicitud AJAX:', error);
            }
        });
    }
}

var myDropzone = new Dropzone("#documentDropzone", {
    parallelUploads: 10,
    maxFiles: 10,
    url: "controller/ajax/ajax.form.php",
    maxFilesize: 10,
    acceptedFiles: "application/pdf, application/xml, text/xml", // Modificamos esta línea
    dictDefaultMessage: 'Arrastra y suelta el archivo aquí o haz clic para seleccionar uno <p class="subtitulo-sup">Tipos de archivo permitidos .pdf, .xml (Tamaño máximo 10 MB)</p>',
    autoProcessQueue: false,
    dictInvalidFileType: "Archivo no está permitido. Por favor, sube archivos en formato PDF o XML.",
    dictFileTooBig: "El archivo es demasiado grande ({{filesize}}MB). Tamaño máximo permitido: {{maxFilesize}}MB.",
    errorPlacement: function(error, element) {
        var $element = $(element),
            errContent = $(error).text();
        $element.attr('data-toggle', 'tooltip');
        $element.attr('title', errContent);
        $element.tooltip({
            placement: 'top'
        });
        $element.tooltip('show');

        // Agregar botón de eliminar archivo
        var removeButton = Dropzone.createElement('<button style="margin-top: 5px; cursor: pointer;">Eliminar archivo</button>');
        removeButton.addEventListener("click", function(e) {
            e.preventDefault();
            e.stopPropagation();
            myDropzone.removeFile(element);
        });
        $element.parent().append(removeButton); // Agregar el botón al contenedor del input
    },
    init: function() {
        this.on("addedfile", function(file) {
            var removeButton = Dropzone.createElement('<button class="rounded-button">&times;</button>');
            var _this = this;
            removeButton.addEventListener("click", function(e) {
                e.preventDefault();
                e.stopPropagation();

                _this.removeFile(file);
            });
            file.previewElement.appendChild(removeButton);
        });
    }
});