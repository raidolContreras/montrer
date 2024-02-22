$(document).ready(function () {
	$("form.account-wrap").submit(function (event) {

		event.preventDefault();

		var area = $("select[name='area']").val();
		var budget = $("input[name='budget']").val();
		var requestedAmount = $("input[name='requestedAmount']").val();
		var description = $("textarea[name='description']").val();

		  if (area == '' || requestedAmount == ''){
            
            showAlertBootstrap('Error', 'Por favor, introduzca la información solicitada en todos lo campos señalados con un (*).');
            
		} else {

			$.ajax({
				type: "POST",
				url: "controller/ajax/ajax.form.php",
				data: {
					area: area,
					budget: budget,
					requestedAmount: requestedAmount,
					description: description
				},
				success: function (response) {				  
	
					if (response === 'ok') {
						
						$("select[name='area']").val('');
						$("input[name='requestedAmount']").val('');
						$("textarea[name='description']").val('');
                        
	                    showAlertBootstrap3('Presupuesto solicitado correctamente', '¿Agregar otra solicitud?', 'registerRequestBudget', 'requestBudget');

					} else {
						Swal.fire({
						  icon: 'error',
						  title: 'Error al crear la solicitud',
                          confirmButtonColor: '#026f35',
                          confirmButtonText: 'Aceptar'
						});
					}
				},
				error: function (error) {
					console.log("Error en la solicitud Ajax:", error);
				}
			});

		}
	});
});

document.addEventListener('DOMContentLoaded', function () {
	var cancelButton = document.getElementById('cancelButton');

	cancelButton.addEventListener('click', function (event) {

		event.preventDefault();
		showAlertBootstrap2('Cancelar', '¿Seguro que deseas cancelar?', 'requestBudget');

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

            // Obtén el valor de AuthorizedAmount desde la respuesta
            var authorizedAmount = response.AuthorizedAmount;

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
        // Obtén el mes actual
        var today = new Date();
        var currentMonth = today.getMonth() + 1; // Los meses en JavaScript van de 0 a 11, por lo que sumamos 1.
    
        // Filtra los datos hasta el mes actual
        var datosHastaMesActual = datos.filter(function (dato) {
            return dato.month <= currentMonth;
        });
    
        // Suma los valores de budget_month hasta el mes actual
        var sumaBudgetMonth = datosHastaMesActual.reduce(function (total, dato) {
            var budgetMonth = parseFloat(dato.budget_month);
            var budgetUsed = parseFloat(dato.budget_used);
            
            // Verificar si los valores son números válidos
            if (!isNaN(budgetMonth) && !isNaN(budgetUsed)) {
                return total + (budgetMonth - budgetUsed);
            } else {
                return total; // No agregar nada si alguno de los valores no es un número válido
            }
        }, 0);

        // Obtiene el idBudget del primer elemento del array (puedes ajustar esto según tus necesidades)
        var idBudget = datos[0].idBudget;
        
        if(datos[0].approvedAmount !== 0){
            
            // Muestra la suma y el idBudget en los lugares deseados
            $("input[name='budget']").val(idBudget);
            $('#requestedAmount').val(sumaBudgetMonth.toFixed(2));
            $('.requestMax').text('La suma de los presupuestos hasta el mes actual es: ' + sumaBudgetMonth.toFixed(2));

        } else {
            $('#requestedAmount').prop('disabled', true);
            $('.requestMax').text('No se puede solicitar un nuevo presupuesto porque no se ha justificado uno anterior.');
        }
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
    event.preventDefault();
    
	showAlertBootstrap2('¿Estás seguro?', 'Si sales del formulario, perderás los cambios no guardados.', destination);
    
}


$(document).ready(function () {

    // Verificar si el día actual es de lunes a miércoles (días 1 a 3)
    var today = new Date();
    if (today.getDay() >= 1 && today.getDay() <= 3) {
    } else {
        Swal.fire({
            title: 'Atención',
            text: 'Las solicitudes recibidas después del miércoles se tramitarán la semana siguiente. Agradecemos su comprensión.',
            icon: 'warning',
            confirmButtonText: 'Aceptar'
        });
    }

});
