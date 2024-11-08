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

var bandera = 0;
$(document).ready(function () {
    
    $('#requestedAmount').on('input', function () {
        var inputValue = $(this).val().replace(/[^0-9.]/g, ''); // Eliminar todo excepto números y punto decimal
        if (inputValue) {
            var numero = parseFloat(inputValue);
            if (!isNaN(numero)) {
                var textoEnLetras = numeroALetra(numero, true);
                $('#importeLetra').val(textoEnLetras);
            } else {
                $('#importeLetra').val('');
            }
        } else {
            $('#importeLetra').val('');
        }
    });

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

		if (area == '' || requestedAmount == '' || description == '' || eventDate == '' || provider == ''){
            
            showAlertBootstrap('¡Atención!', 'Por favor, introduzca la información solicitada en todos lo campos señalados con un (*).');
            
		} else if (maxBudget >= requestedAmount) {

			$.ajax({
				type: "POST",
				url: "controller/ajax/ajax.form.php",
				data: {
					area: area,
					requestedAmount: requestedAmount,
					description: description,
                    eventDate: eventDate,
					budget: budget,
					folio: folio,
                    provider: provider
				},
				success: function (response) {				  
	
					if (response !== 'Error') {
                        
                        idPaymentRequestTemp = response;
						
                        myDropzone.processQueue();
						bandera = 0;
						$("select[name='area']").val('');
						$("input[name='requestedAmount']").val('');
						$("textarea[name='description']").val('');
                        $("input[name='event']").val('');
                        $("input[name='eventDate']").val('');
                        $('.sidenav').removeAttr('onclick');

	                    showAlertBootstrap3('Presupuesto solicitado correctamente', '¿Agregar otra solicitud?', 'registerRequestBudget', 'requestBudget');

					} else {
                        
	                    showAlertBootstrap('!Atención¡', 'Error al crear la solicitud.');
                        
					}
				},
				error: function (error) {
					console.log("Error en la solicitud Ajax:", error);
				}
			});

		} else {
            showAlertBootstrap('¡Atención!', 'La cantidad solicitada no debe de superar el monto disponible.');
        }
        
	});
    // Configuración del evento 'sending' del Dropzone
    myDropzone.on("sending", function(file, xhr, formData) {
        formData.append("idPaymentRequestTemp", idPaymentRequestTemp);
    });
});

document.addEventListener('DOMContentLoaded', function () {
	var cancelButton = document.getElementById('cancelButton');

	cancelButton.addEventListener('click', function (event) {

		event.preventDefault();
		showAlertBootstrap2('Cancelar', '¿Seguro que desea cancelar?', 'requestBudget');

	});
});

$(document).ready(function () {
    var registerValue = $('#register-value').data('register');

    getArea(registerValue);

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

    createFolio(datas[0][1]);

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
    var selectedAreaText = $(this).find('option:selected').text();
    
    createFolio(selectedAreaText);

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
                        
                        // Mostramos la suma total
                        totalAmountBudget = response.total - response.comp - totalBudgetPendient;

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

function fillSelect(select, datas, message) {

    var selectOption = $('#' + select);

    selectOption.empty();

    var option = $('<option>').val('').text('Seleccionar ' + message);
    selectOption.append(option);

    datas.forEach(function (data) {
        var option = $('<option>').val(data[0]).text(data[1]);
        selectOption.append(option);
    });

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

$(document).ready(function () {
    var today = new Date();
    // Verificar si hoy es miércoles y la hora actual es después de las 4pm (16:00)
    if (today.getDay() > 3 || (today.getDay() === 3 && today.getHours() >= 16)) {
        showAlertBootstrap('Atención', 'Las solicitudes recibidas después del miércoles a las 16 horas, se pagarán hasta el viernes de la semana siguiente. Agradecemos su comprensión.');
    }
});

function createFolio(nameArea) {
    $.ajax({
        url: 'controller/ajax/maxRequestBudgets.php',
        dataType: 'json',
        success: function (response) {
            var folio = parseInt(response.maxRequest);
            folio = folio + 1;
            
            var folioFin = folio + sustraerLetras(nameArea);

            $('input[name="folio"]').val(folioFin);
        }
    });
}

function numeroALetra(numero, status) {
    var unidades = ['', 'un', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete', 'ocho', 'nueve'];
    var especiales = ['diez', 'once', 'doce', 'trece', 'catorce', 'quince', 'dieciséis', 'diecisiete', 'dieciocho', 'diecinueve'];
    var decenas = ['','diez','veinte','treinta','cuarenta','cincuenta','sesenta','setenta','ochenta','noventa'];
    var centenas = ['','ciento','doscientos','trescientos','cuatrocientos','quinientos','seiscientos','setecientos','ochocientos','novecientos'];

    var texto = '';

    var entero = Math.floor(numero);
    var decimal = Math.round((numero - entero) * 100);

    if (entero === 0) {
        texto = 'cero';
    } else {
        // Parte entera
        if (entero >= 1000000) {
            texto += numeroALetra(Math.floor(entero / 1000000), false) + ' millón ';
            entero %= 1000000;
        }

        if (entero >= 1000) {
            texto += numeroALetra(Math.floor(entero / 1000), false) + ' mil ';
            entero %= 1000;
        }

        if (entero >= 100) {
            texto += centenas[Math.floor(entero / 100)] + ' ';
            entero %= 100;
        }

        if (entero >= 20) {
			if (entero > 20 && entero < 30 && status == true) {
				texto += 'veinti';
			} else if (entero != 30 && entero != 40 && entero != 50 && entero != 60 && entero != 70 && entero != 80 && entero != 90 && status == true) {
				texto += decenas[Math.floor(entero / 10)] + ' ';
				texto += 'y ';
			}else if (status == true) {
				texto += decenas[Math.floor(entero / 10)] + '';
				texto += '';
			} else {
				texto += decenas[Math.floor(entero / 10)] + ' ';
			}
            entero %= 10;
        }

        if (entero >= 10) {
            texto += especiales[entero - 10];
            decimal = 0; // No hay centavos si el número es un número especial
        } else if (entero > 0) {
            texto += unidades[entero];
        }
    }

    // Centavos
    if (decimal > 0) {
        texto += (entero > 0 ? ' ' : '') + (decimal === 1 ? 'pesos con un centavo' : 'pesos con ' + numeroALetra(decimal, false) + ' centavos');
    } else {
		if (status == true) {	
			texto += ' pesos'; 
		}
	}

    return texto.trim();
}