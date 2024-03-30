var bandera = 0;
$(document).ready(function () {

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
					area: area,
					requestedAmount: requestedAmount,
					description: description,
                    event: event,
                    eventDate: eventDate,
					budget: budget,
                    provider: provider
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
            console.log('max: '+maxBudget)
            console.log('requestedAmount: '+requestedAmount)
            showAlertBootstrap('¡Atención!', 'La cantidad solicitada no debe de superar el monto disponible mensual.');
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
                for (var i = 0; i < response.length; i++) {
                    // Obtenemos la cantidad de cada objeto y la sumamos al total
                    totalAmountBudget += parseFloat(response[i].requestedAmount);
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
                    // $('#requestedAmount').val(sumaBudgetMonth.toFixed(2));
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

    // Verificar si el día actual es de lunes a miércoles (días 1 a 3)
    var today = new Date();
    if (today.getDay() >= 1 && today.getDay() <= 3) {
    } else {
        
	showAlertBootstrap('Atención', 'Las solicitudes recibidas después del miércoles se tramitarán la semana siguiente. Agradecemos su comprensión.');
    }

});
