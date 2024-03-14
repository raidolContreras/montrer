
var myDropzone = new Dropzone("#documentDropzone", {
    parallelUploads: 10,
    maxFiles: 10,
    url: "controller/ajax/ajax.form.php",
    maxFilesize: 10,
    acceptedFiles: "image/jpeg, image/png, application/pdf",
    dictDefaultMessage: 'Arrastra y suelta el archivo aquí o haz clic para seleccionar uno <p class="subtitulo-sup">Tipos de archivo permitidos .pdf, .png, .jpg, .jpeg (Tamaño máximo 10 MB)</p>',
    autoProcessQueue: false,
});

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
                showAlert('Exito', 'Comprobante enviado');
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
    console.log(myDropzone);
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

function showAlert(title, message) {
    $('#modalLabel').text(title);
    $('.modal-body-extra').text(message);
    $('.modal-footer-extra').html('<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button><button type="button" class="btn btn-success" onclick="closeModals()">Aceptar</button>');
    $('#alertModal').modal('show');
}

function closeModals() {
    $('#alertModal').modal('hide');
    $('#comprobarModal').modal('hide');
}