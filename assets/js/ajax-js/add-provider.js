var bandera = 0;
var cedula = 0; // Contador para archivos PDF
var caratula = 0; // Contador para archivos PDF

$(document).ready(function () {

    // Detectar cambios en cualquier campo del formulario y establecer la bandera a 1
    $("form.account-wrap input, form.account-wrap select").change(function() {
        bandera = 1;
    });
	
	$("form.account-wrap").submit(function (event) {
		event.preventDefault();

		var providerKey = $("input[name='providerKey']").val();
		var fields = {
			representativeName: $("input[name='representativeName']").val(),
			contactPhone: $("input[name='contactPhone']").val(),
			email: $("input[name='email']").val(),
			website: $("input[name='website']").val(),
			businessName: $("input[name='businessName']").val(),
			rfc: $("input[name='rfc']").val(),
			fiscalAddressStreet: $("input[name='fiscalAddressStreet']").val(),
			fiscalAddressColonia: $("input[name='fiscalAddressColonia']").val(),
			fiscalAddressMunicipio: $("input[name='fiscalAddressMunicipio']").val(),
			fiscalAddressEstado: $("input[name='fiscalAddressEstado']").val(),
			fiscalAddressCP: $("input[name='fiscalAddressCP']").val(),
			bankName: $("input[name='bankName']").val(),
			accountHolder: $("input[name='accountHolder']").val(),
			accountNumber: $("input[name='accountNumber']").val(),
			clabe: $("input[name='clabe']").val(),
			description: $("input[name='description']").val(),
			idUser: document.getElementById("idUser").value

		};
		var user = $("input[name='user']").val();

		function validateField(fieldName) {
			if (!fields[fieldName]) {
				
				showAlertBootstrap('¡Atención!', 'Por favor, introduzca la información solicitada en todos lo campos señalados con un (*).');
				return false;
			}
			return true;
		}

		if (!validateField('businessName') ||
			!validateField('representativeName') ||
			!validateField('email') ||
			!validateField('rfc') ||
			!validateField('contactPhone') ||
			!validateField('fiscalAddressStreet') ||
			!validateField('fiscalAddressColonia') ||
			!validateField('fiscalAddressMunicipio') ||
			!validateField('fiscalAddressEstado') ||
			!validateField('fiscalAddressCP') ||
			!validateField('bankName') ||
			!validateField('accountHolder') ||
			!validateField('description') ||
			!validateField('accountNumber')
		) {
			return;
		}

		$.ajax({
			type: "POST",
			url: "controller/ajax/ajax.form.php",
			data: {
				providerKey: providerKey,
				user: user,
				...fields
			},
			success: function (response) {
				if (response !== 'Error: RFC ya registrado' || response !== 'Error') {
					idProvider = response;
					cedulaDropzone.processQueue();
					caratulaDropzone.processQueue();
					bandera = 0;
					showAlertBootstrap3('Proveedor creado exitosamente.', '¿Agregar otro proveedor?', 'registerProvider' , 'provider');

				} else if (response == 'Error: RFC ya registrado') {
                
					showAlertBootstrap('!Atención¡', 'El RFC ya se encuentra registrado.');
	
				} else {
					
					showAlertBootstrap('!Atención¡', 'Error al crear el proveedor.');

				}
			},
			error: function (error) {
				console.log("Error en la solicitud Ajax:", error);
			}
			
		});
		// Configuración del evento 'sending' del Dropzone
		cedulaDropzone.on("sending", function(file, xhr, formData) {
			formData.append("newProvider", idProvider);
			formData.append("document", 'cedula');
		});
		caratulaDropzone.on("sending", function(file, xhr, formData) {
			formData.append("newProvider", idProvider);
			formData.append("document", 'caratula');
		});
	});
});

document.addEventListener('DOMContentLoaded', function () {
	var cancelButton = document.getElementById('cancelButton');

	cancelButton.addEventListener('click', function (event) {

		showAlertBootstrap2('Cancelar', '¿Seguro que desea cancelar?', 'provider');

	});
});

function confirmExit(event, destination) {
	if (bandera == 1){
		event.preventDefault();
		showAlertBootstrap2('¿Está seguro?', 'Si sale del formulario, perderá los cambios no guardados.', destination);
	}
}


var cedulaDropzone = new Dropzone(".cedula", {
    maxFiles: 1,
    url: "controller/ajax/ajax.form.php",
    maxFilesize: 2,
    acceptedFiles: "application/pdf",
    dictDefaultMessage: 'Arrastra y suelta la cédula fiscal o haz clic para seleccionarla <p class="subtitulo-sup">Tipo de archivo permitido .pdf (Tamaño máximo 2 MB)</p>',
    autoProcessQueue: false,
    dictInvalidFileType: "Archivo no está permitido. Por favor, sube archivos en formato PDF.",
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
                cedula++;
            }
            toggleSubmitButton(); // Actualizar estado del botón de enviar
            var removeButton = Dropzone.createElement('<button class="rounded-button">&times;</button>');
            var _this = this;
            removeButton.addEventListener("click", function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                if (file.type === "application/pdf") {
                    cedula--;
                }

                _this.removeFile(file);
                toggleSubmitButton(); // Actualizar estado del botón de enviar
            });
            file.previewElement.appendChild(removeButton);
        });
    }
});

var caratulaDropzone = new Dropzone(".caratula", {
    maxFiles: 1,
    url: "controller/ajax/ajax.form.php",
    maxFilesize: 2,
    acceptedFiles: "application/pdf",
    dictDefaultMessage: 'Arrastra y suelta la caratula del estado de cuenta o haz clic para seleccionarla <p class="subtitulo-sup">Tipo de archivo permitido .pdf (Tamaño máximo 2 MB)</p>',
    autoProcessQueue: false,
    dictInvalidFileType: "Archivo no está permitido. Por favor, sube archivos en formato PDF.",
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
                caratula++;
            }
            toggleSubmitButton(); // Actualizar estado del botón de enviar
            var removeButton = Dropzone.createElement('<button class="rounded-button">&times;</button>');
            var _this = this;
            removeButton.addEventListener("click", function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                if (file.type === "application/pdf") {
                    caratula--;
                }

                _this.removeFile(file);
                toggleSubmitButton(); // Actualizar estado del botón de enviar
            });
            file.previewElement.appendChild(removeButton);
        });
    }
});


function toggleSubmitButton() {
    var submitButton = document.querySelector('.accept');
    if (cedula >= 1 && caratula >= 1) {
        submitButton.disabled = false;
    } else {
        submitButton.disabled = true;
    }
}