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
        var event = $("input[name='event']").val();
        var eventDate = $("input[name='eventDate']").val();
		var maxBudget = parseFloat($("input[name='maxBudget']").val());
		var budget = $("input[name='budget']").val();

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
                    eventEdit: event,
                    eventDateEdit: eventDate,
					budgetEdit: budget,
                    providerEdit: provider,
                    requestEdit: request
				},
				success: function (response) {				  
	
					if (response === 'ok') {
						
						bandera = 0;
						$("select[name='area']").val('');
						$("input[name='requestedAmount']").val('');
						$("textarea[name='description']").val('');
                        $("input[name='event']").val('');
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
            console.log('max: '+maxBudget)
            console.log('requestedAmount: '+requestedAmount)
            showAlertBootstrap('¡Atención!', 'La cantidad solicitada no debe de superar el monto disponible mensual.');
        }
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

        // Variables para almacenar la suma de cantidades
        var totalAmountBudget = 0;
        var sumaBudgetMonth = 0;
        var formattedSum = "";

        // Obtén el mes actual
        var today = new Date();
        var currentMonth = today.getMonth() + 1; // Los meses en JavaScript van de 0 a 11, por lo que sumamos 1.
    
        // Filtra los datos hasta el mes actual
        var datosHastaMesActual = datos.filter(function (dato) {
            return dato.month <= currentMonth;
        });
        
        // Suma los valores de budget_month hasta el mes actual
        sumaBudgetMonth = datosHastaMesActual.reduce(function (total, dato) {
            var budgetMonth = parseFloat(dato.budget_month);
            var budgetUsed = parseFloat(dato.budget_used);
            
            // Verificar si los valores son números válidos
            if (!isNaN(budgetMonth) && !isNaN(budgetUsed)) {
                return total + budgetMonth - budgetUsed;
            } else {
                return total; // No agregar nada si alguno de los valores no es un número válido
            }
        }, 0);

        $.ajax({
            type: 'POST',
            url: 'controller/ajax/getAmountPendient.php',
            data: { areaId: datos[0].idArea },
            dataType: 'json',
            success: function (response) {
                var request = $('#request').val();
                for (var i = 0; i < response.length; i++) {
                    // Obtenemos la cantidad de cada objeto y la sumamos al total
                    if (request == response[i].idRequest) {
                        $('#requestedAmount').val(response[i].requestedAmount);
                    } else {
                        totalAmountBudget += parseFloat(response[i].requestedAmount);
                    }
                }
                
                // Mostramos la suma total
                sumaBudgetMonth = sumaBudgetMonth - totalAmountBudget;
                formattedSum = sumaBudgetMonth.toLocaleString('es-MX', {
                    style: 'currency',
                    currency: 'MXN',
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2,
                });

                // Aquí puedes colocar el código que depende de sumaBudgetMonth
                var idBudget = datos[0].idBudget;
                if(datos[0].approvedAmount !== 0){
                    $("input[name='budget']").val(idBudget);
                    $("input[name='maxBudget']").val(sumaBudgetMonth.toFixed(2));
                    $('.requestMax').text('La suma de los presupuestos hasta el mes actual es: ' + formattedSum);
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

            $('#provider').val(response.idProvider);
            $('#area').val(response.idArea);
            $('#description').val(response.description);
            $('#event').val(response.event);
            $('#eventDate').val(response.eventDate);
            
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