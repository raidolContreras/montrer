var numPDF = 0; // Contador para archivos PDF
var numXML = 0; // Contador para archivos XML

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
            // Incrementar contadores de archivos PDF y XML
            if (file.type === "application/pdf") {
                numPDF++;
            } else if (file.type === "application/xml" || file.type === "text/xml") { // Modificamos esta línea
                numXML++;
            }
            toggleSubmitButton(); // Actualizar estado del botón de enviar
            var removeButton = Dropzone.createElement('<button class="rounded-button">&times;</button>');
            var _this = this;
            removeButton.addEventListener("click", function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                if (file.type === "application/pdf") {
                    numPDF--;
                } else if (file.type === "application/xml" || file.type === "text/xml") { // Modificamos esta línea
                    numXML--;
                }

                _this.removeFile(file);
                toggleSubmitButton(); // Actualizar estado del botón de enviar
            });
            file.previewElement.appendChild(removeButton);
        });
    }
});

function toggleSubmitButton() {
    var submitButton = document.querySelector('.send-comprobante');
    if (numPDF >= 1 && numXML >= 1) {
        submitButton.disabled = false;
    } else {
        submitButton.disabled = true;
    }
}

function enviarComprobante() {
	event.preventDefault();
    var nombreCompleto = $("input[name='nombreCompleto']").val();
    var fechaSolicitud = $("input[name='fechaSolicitud']").val();
    var provider = $("select[name='provider']").val();
    var area = $("select[name='area']").val();
    var importeSolicitado = $("input[name='importeSolicitado']").val();
    var importeLetra = $("input[name='importeLetra']").val();
    var titularCuenta = $("input[name='titularCuenta']").val();
    var entidadBancaria = $("input[name='entidadBancaria']").val();
    var conceptoPago = $("input[name='conceptoPago']").val();
    var idUser = $("input[name='user']").val();
    var idRequest = $("input[name='request']").val();

    if (
        nombreCompleto === '' ||
        fechaSolicitud === '' ||
        provider === '' ||
        area === '' ||
        importeSolicitado === '' ||
        importeLetra === '' ||
        titularCuenta === '' ||
        entidadBancaria === '' ||
        conceptoPago === ''
    ) {
        showAlertBootstrap('¡Atención!', 'Por favor, introduzca la información solicitada en todos lo campos señalados con un (*).');
    } else {
        $.ajax({
            type: "POST",
            url: "controller/ajax/ajax.form.php",
            data: {
                nombreCompleto: nombreCompleto,
                fechaSolicitud: fechaSolicitud,
                provider: provider,
                area: area,
                importeSolicitado: importeSolicitado,
                importeLetra: importeLetra,
                titularCuenta: titularCuenta,
                entidadBancaria: entidadBancaria,
                conceptoPago: conceptoPago,
                idRequest: idRequest,
                idUser: idUser
            },
            success: function (response) {
                idPaymentRequest = response;
                showAlert2('Exito', 'Comprobante enviado');
                myDropzone.processQueue();
            },
            error: function (xhr, status, error) {
                console.error("Error al guardar los datos:", error);
                // Aquí puedes manejar el error de alguna manera, como mostrar un mensaje de error al usuario
            }
        });
    }
    
    // Configuración del evento 'sending' del Dropzone
    myDropzone.on("sending", function(file, xhr, formData) {
        formData.append("idPaymentRequest", idPaymentRequest);
    });
}

// Esperar a que el documento esté listo
document.addEventListener('DOMContentLoaded', function () {
	// Obtener el botón de cancelar por su ID
	var cancelButton = document.getElementById('cancelButton');

	// Agregar un evento de clic al botón de cancelar
	cancelButton.addEventListener('click', function (event) {
		// Prevenir el comportamiento predeterminado del enlace
		event.preventDefault();

		showAlert('Cancelar', '¿Seguro que desea cancelar?');
		
	});
});

function showAlert2(title, message) {
    $('#modalLabel').text(title);
    $('.modal-body-extra').text(message);
    $('.modal-footer-extra').html('<button type="button" class="btn btn-success" onclick="closeModals()">Aceptar</button>');
    $('#alertModal').modal('show');
}

function showAlert(title, message) {
    $('#modalLabel').text(title);
    $('.modal-body-extra').text(message);
    $('.modal-footer-extra').html('<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button><button type="button" class="btn btn-success" onclick="closeModals()">Aceptar</button>');
    $('#alertModal').modal('show');
}

function closeModals() {
    $('#alertModal').modal('hide');
    $('#comprobarModal').modal('hide');
    location.reload();
}