var myDropzone = new Dropzone("#documentDropzone", {
    parallelUploads: 20,
    maxFiles: 20,
    url: "controller/ajax/ajax.form.php",
    maxFilesize: 10,
    acceptedFiles: "application/pdf, application/xml, text/xml", // Modificamos esta línea
    dictDefaultMessage: 'Arrastra y suelta los archivos aquí o haz clic para seleccionarlos <p class="subtitulo-sup">Máximo 20 archivos, Tipos de archivo permitidos .pdf, .xml (Tamaño máximo 10 MB)</p>',
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

    let $comment = document.getElementById("requestedAmount")
    let timeout

    //El evento lo puedes reemplazar con keyup, keypress y el tiempo a tu necesidad
    $comment.addEventListener('keydown', () => {
        clearTimeout(timeout)
        timeout = setTimeout(() => {
            requestedAmount = $('#requestedAmount').val();
            var inputValue = requestedAmount.replace(/[^0-9.]/g, ''); // Eliminar todo excepto números y punto decimal
            var numero = parseFloat(inputValue);
            if (!isNaN(numero)) {
                var textoEnLetras = numeroALetra(numero, true);
                $('#importeLetra').val(textoEnLetras);
            } else {
                $('#importeLetra').val('');
            }
            clearTimeout(timeout)
        },500)
    });

    // Detectar cambios en cualquier campo del formulario y establecer la bandera a 1
    $("form.account-wrap input, form.account-wrap select").change(function() {
        bandera = 1;
    });

    $("form.account-wrap").submit(function (event) {
        event.preventDefault();
    
        // Recuperar valores de los campos del formulario
        var area = $("select[name='area']").val();
        var requestedAmount = parseFloat($("input[name='requestedAmount']").val());
        var importeLetra = $("input[name='importeLetra']").val();
        var conceptoPago = $("input[name='conceptoPago']").val();
        var cuentaAfectada = $("input[name='cuentaAfectada']").val();
        var partidaAfectada = $("input[name='partidaAfectada']").val();
        var concepto = $("input[name='concepto']").val();
        var provider = $("select[name='provider']").val();
        var clabe = $("input[name='clabe']").val();
        var bankName = $("input[name='bank_name']").val();
        var accountNumber = $("input[name='account_number']").val();
        var fechaPago = $("input[name='fechaPago']").val();
        var maxBudget = parseFloat($("input[name='maxBudget']").val());
        var folio = $("span#folio").text(); // folio se obtiene del span en lugar de un input
    
        // Verificar si todos los campos obligatorios están completos
        if (!area || !requestedAmount || !provider || !fechaPago || !cuentaAfectada || !conceptoPago) {
            showAlertBootstrap('¡Atención!', 'Por favor, introduzca la información solicitada en todos los campos señalados con un (*).');
            return;
        }
    
        // Verificar que el importe solicitado no exceda el presupuesto máximo disponible
        if (maxBudget >= requestedAmount) {
            // Hacer la solicitud AJAX si el monto es válido
            $.ajax({
                type: "POST",
                url: "controller/ajax/ajax.form.php",
                data: {
                    area: area,
                    requestedAmount: requestedAmount,
                    importeLetra: importeLetra,
                    conceptoPago: conceptoPago,
                    cuentaAfectada: cuentaAfectada,
                    partidaAfectada: partidaAfectada,
                    concepto: concepto,
                    provider: provider,
                    clabe: clabe,
                    bankName: bankName,
                    accountNumber: accountNumber,
                    fechaPago: fechaPago,
                    budget: maxBudget,
                    folio: folio
                },
                success: function (response) {
                    if (response !== 'Error') {
                        // Procesar la solicitud de subida de archivos si es necesario
                        myDropzone.processQueue();
                        bandera = 0;
    
                        // Limpiar el formulario después de enviar
                        $("form.account-wrap")[0].reset();
    
                        // Mostrar mensaje de éxito
                        showAlertBootstrap3('Presupuesto solicitado correctamente', '¿Agregar otra solicitud?', 'registerRequestBudget', 'requestBudget');
                    } else {
                        showAlertBootstrap('¡Atención!', 'Error al crear la solicitud.');
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
    
    // Variable de control para mostrar el modal solo una vez
    let hasModalShown = false;

    // Mostrar el modal una vez al hacer clic en requestedAmount
    $('#requestedAmount').on('click', function() {
        if (!hasModalShown) {
            $('#availableBudgetModal').modal('show'); // Muestra el modal
            hasModalShown = true; // Cambiar la variable para no mostrarlo nuevamente
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

// Manejador de eventos para el cambio en el select
$('#provider').on('change', function() {
    var selectedProviderId = $(this).val();
    var selectedProviderText = $(this).find('option:selected').text();

    // Verifica si se seleccionó un proveedor válido
    if (selectedProviderId && selectedProviderId !== "add_provider" && storedProviders) {
        // Busca el proveedor seleccionado en storedProviders
        var selectedProvider = storedProviders.find(provider => provider.idProvider == selectedProviderId);
        
        if (selectedProvider) {
            $('#clabe').val(selectedProvider.clabe);
            $('#bank_name').val(selectedProvider.bank_name);
            $('#account_number').val(selectedProvider.account_number);
            if (selectedProvider.extrangero == 1) {
                $('.foreign-fields').show(); 
                $('#swiftCode').val(selectedProvider.swiftCode);
                $('#beneficiaryAddress').val(selectedProvider.beneficiaryAddress);
                $('#currencyType').val(selectedProvider.currencyType);
            } else {
                $('.foreign-fields').hide();
                $('#swiftCode').val('');
                $('#beneficiaryAddress').val('');
                $('#currencyType').val('');
            }
        }
    } else {
        // Muestra u oculta los campos adicionales si el proveedor es extranjero
        $('#foreignProvider').change(function () {
            if ($(this).is(':checked')) {
                $('.foreign-fields').show(); // Muestra los campos adicionales
                extrangero = true;
            } else {
                $('.foreign-fields').hide(); // Oculta los campos adicionales
                extrangero = false;
            }
        });
    }
});

function updateMaxRequestedAmount(datos) {
    const fecha = new Date();
    const mesActual = fecha.getMonth();
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

                var totalBudget = 0;
                var totalBudgetUsed = 0;

                $.ajax({
                    type: 'POST',
                    url: 'controller/ajax/getAmountPendient.php',
                    data: { areaId: datos[0].idArea },
                    dataType: 'json',
                    success: function (result) {
                        // for (var i = 0; i < result.length; i++) {
                        //     // Obtenemos la cantidad de cada objeto y la sumamos al total
                            
                        //     totalBudgetPendient += parseFloat(result[i].requestedAmount);
                        // }

                        for (var i = 0; i < mesActual; i++) {
                            totalBudgetUsed += datos[i].budget_used;
                            totalBudget += datos[i].budget_month;
                        }
                        
                        // Mostramos la suma total
                        totalBudget = (totalBudget - totalBudgetUsed) - response.comp;

                        formattedSum = totalBudget.toLocaleString('es-MX', {
                            style: 'currency',
                            currency: 'MXN',
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2,
                        });

                        // Aquí puedes colocar el código que depende de totalBudget
                        var idBudget = datos[0].idBudget;
                        if(datos[0].approvedAmount !== 0){
                            $("input[name='budget']").val(idBudget);
                            $("input[name='maxBudget']").val(totalBudget.toFixed(2));
                            // $('#requestedAmount').val(totalBudget.toFixed(2));
                            // $('.requestMax').text('Presupuesto maximo a solicitar es de: ' + formattedSum);
                            $('#modalBudgetDisplay').text(formattedSum);
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
            if (response.maxRequest) {
                var folio = parseInt(response.maxRequest);
                folio = folio + 1;
            } else {
                var folio = 1;
            }
            var folioFin = folio + sustraerLetras(nameArea);

            $('#folio').text(folioFin);
        }
    });
}

// function getBusiness() {
//     var registerValue = $('#register-value').data('register');
    
//     $.ajax({
//         type: 'POST',
//         url: 'controller/ajax/getBusiness.php',
//         data: {'idUser': registerValue},
//         dataType: 'json',
//         success: function (response) {
//             var container = $('#empresa-container'); // Contenedor donde se colocará el input o select
//             container.find('input, select').remove(); // Limpiar el contenedor antes de agregar nuevos elementos

//             if (response.length === 0) {
//                 // Si no hay empresas registradas, mostrar mensaje de alerta
//                 showAlertBootstrap2(
//                     'No está registrado',
//                     'No está registrado en ninguna empresa.',
//                     'requestBudget'
//                 );
//             } else if (response.length === 1) {
//                 // Si solo hay un resultado, mostrar un input
//                 var input = $('<input>')
//                     .attr('type', 'text')
//                     .attr('name', 'bussinessName')
//                     .attr('id', 'bussinessName')
//                     .attr('data-value-bussiness', response[0].idBusiness)
//                     .attr('readonly', '')
//                     .addClass('form-control')
//                     .val(response[0].name); // Asignar el nombre de la empresa al input

//                 container.append(input);
//             } else if (response.length > 1) {
//                 // Si hay múltiples resultados, mostrar un select
//                 var select = $('<select>')
//                     .attr('name', 'empresa')
//                     .attr('id', 'empresa')
//                     .addClass('form-select form-control');
                
//                 response.forEach(function(item) {
//                     var option = $('<option>')
//                         .attr('value', item.idBusiness)
//                         .text(item.name); // Usar el nombre de la empresa para mostrar en el select
//                     select.append(option);
//                 });

//                 container.append(select);
//             }
//         }
//     });
// }

function formatBusinessUserId(id) {
    // Convierte el ID a una cadena para asegurarse de que pueda usar .substring()
    id = id.toString(); 

    // Divide el string en partes según el formato que deseas
    let part1 = id.substring(0, 4);
    let part2 = id.substring(4, 7);
    let part3 = id.substring(7, 10);
    let part4 = id.substring(10, 13);

    // Retorna el ID formateado con los guiones
    return `${part1}-${part2}-${part3}-${part4}`;
}

function numeroALetra(numero, status) {
    var unidades = ['', 'un', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete', 'ocho', 'nueve'];
    var especiales = ['diez', 'once', 'doce', 'trece', 'catorce', 'quince', 'dieciséis', 'diecisiete', 'dieciocho', 'diecinueve'];
    var decenas = ['', 'diez', 'veinte', 'treinta', 'cuarenta', 'cincuenta', 'sesenta', 'setenta', 'ochenta', 'noventa'];
    var centenas = ['', 'ciento', 'doscientos', 'trescientos', 'cuatrocientos', 'quinientos', 'seiscientos', 'setecientos', 'ochocientos', 'novecientos'];

    var texto = '';

    var entero = Math.floor(numero);
    var decimal = Math.round((numero - entero) * 100);

    if (entero === 0) {
        texto = 'cero';
    } else {
        // Parte entera
        if (entero >= 1000000) {
            let millones = Math.floor(entero / 1000000);
            texto += millones === 1 ? 'un millón ' : numeroALetra(millones, false) + ' millones ';
            entero %= 1000000;
        }

        if (entero >= 1000) {
            let miles = Math.floor(entero / 1000);
            texto += miles === 1 ? 'mil ' : numeroALetra(miles, false) + ' mil ';
            entero %= 1000;
        }

        if (entero >= 100) {
            texto += (entero === 100 ? 'cien' : centenas[Math.floor(entero / 100)]) + ' ';
            entero %= 100;
        }

        if (entero >= 20) {
            texto += decenas[Math.floor(entero / 10)];
            if (entero % 10 !== 0) {
                texto += (entero >= 30 ? ' y ' : '') + unidades[entero % 10];
            }
            entero = 0; // Se procesó toda la parte de decenas
        }

        if (entero >= 10) {
            texto += especiales[entero - 10];
            entero = 0; // No hay centavos si el número es un número especial
        }

        if (entero > 0) {
            texto += unidades[entero];
        }
    }

    // Centavos
    if (decimal > 0) {
        texto += (texto ? ' ' : '') + (decimal === 1 ? 'pesos con un centavo' : 'pesos con ' + numeroALetra(decimal, false) + ' centavos');
    } else {
        if (status) {	
            texto += ' pesos';
        }
    }
    
    // Ajustes de formato final: eliminar espacios duplicados y capitalizar
    texto = texto.replace(/\s+/g, ' ').trim().replace(/^./, function(str) {
        return str.toUpperCase();
    });

    return texto;
}

$('#toggleDropzone').on('change', function() {
    if ($(this).is(':checked')) {
        $('#dropzoneContainer').show();
    } else {
        $('#dropzoneContainer').hide();
    }
});
