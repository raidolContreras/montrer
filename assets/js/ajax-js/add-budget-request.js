$(document).ready(function () {
	$("form.account-wrap").submit(function (event) {

		event.preventDefault();

		var idBudget = $("input[name='idBudget']").val();
		var area = $("select[name='area']").val();
		var provider = $("select[name='provider']").val();
		var requestedAmount = $("input[name='requestedAmount']").val();
		var description = $("input[name='description']").val();
		
		const Toast = Swal.mixin({
			toast: true,
			position: "center",
			showConfirmButton: false,
			timerProgressBar: false,
			didOpen: (toast) => {
			  toast.onmouseenter = Swal.stopTimer;
			  toast.onmouseleave = Swal.resumeTimer;
			}
		  });

		  if (area == '' || provider == '' || requestedAmount == ''){
			Swal.fire({
			  icon: 'warning',
			  title: 'Error',
			  text: 'Por favor, complete correctamente todos los campos obligatorios (departamento, proveedor, y presupuesto solicitado)',
			  icon: "warning"
			});
		} else {

			$.ajax({
				type: "POST",
				url: "controller/ajax/ajax.form.php",
				data: {
					idBudget: idBudget,
					area: area,
					provider: provider,
					requestedAmount: requestedAmount,
					description: description
				},
				success: function (response) {				  
	
					if (response === 'ok') {
						
						$("input[name='idBudget']").val('');
						$("select[name='area']").val('');
						$("select[name='provider']").val('');
						$("input[name='requestedAmount']").val('2');
						$("input[name='description']").val('');
						Swal.fire({
						  icon: "success",
						  title: 'Solicitud creada con exito',
						  icon: "success"
						});
					} else {
						Swal.fire({
						  icon: 'error',
						  title: 'Error al crear la solicitud',
						  icon: "error"
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

		Swal.fire({
			title: '¿Seguro que deseas cancelar?',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonText: 'Sí, cancelar',
			cancelButtonText: 'No, seguir aquí',
		}).then((result) => {
			if (result.isConfirmed) {
				window.location.href = "requestBudget";
			}
		});
	});
});

$(document).ready(function () {
    var registerValue = $('#register-value').data('register');

    getArea(registerValue);
    getProviders();

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

    var option = $('<option>').val('').text('Seleccionar ' + message);
    selectOption.append(option);

    datas.forEach(function (data) {
        var option = $('<option>').val(data[0]).text(data[1]);
        selectOption.append(option);
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
            updateMaxRequestedAmount(response.AuthorizedAmount);
        },
        error: function (error) {
            console.log('Error en la solicitud AJAX:', error);
        }
    });
});

function updateMaxRequestedAmount(authorizedAmount) {
    var numberOfMonths = 12;
    var maxRequestedAmount = authorizedAmount / numberOfMonths;

    // Verifica si maxRequestedAmount es un número
    if (!isNaN(maxRequestedAmount)) {
        // Si es un número, habilita el campo de entrada y actualiza el texto de la etiqueta
        $('#requestedAmount').prop('disabled', false);
        var formattedBudget = parseFloat(maxRequestedAmount).toLocaleString('es-MX', {
            style: 'currency',
            currency: 'MXN'
        });
        $('.requestMax').text('Monto máximo disponible este mes: ' + formattedBudget);
    } else {
        // Si no es un número, deshabilita el campo de entrada y establece el texto en vacío
        $('#requestedAmount').prop('disabled', true).val('');
        $('.requestMax').text('');
    }
}

function getProviders() {
    $.ajax({
        type: 'POST',
        url: 'controller/ajax/getProviderON.php',
        dataType: 'json',
        success: function (response) {
            console.log('Respuesta del servidor: ', response);

            fillSelect('provider', response, 'proveedor');
        },
        error: function (error) {
            console.log('Error en la solicitud AJAX:', error);
        }
    });
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

    if (message == 'proveedor'){
        // Agregar el botón para agregar proveedor
        var addProviderOption = $('<option>').val('addProvider').text('Agregar Proveedor');
        selectOption.append(addProviderOption);

        // Configurar el evento click para el botón
        selectOption.change(function () {
            if ($(this).val() === 'addProvider') {
                openAddProviderModal();
            }
        });
    }

}

function openAddProviderModal() {
    $('#addProviderModal').modal('show');
}

function confirmExit(event, destination) {
    event.preventDefault();
    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Si sales del formulario, perderás los cambios no guardados.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, salir',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = destination;
        }
    });
}

$(document).on('click', '.cancel-provider', function () {
    $('#addProviderModal').modal('hide');
    $('select[name="provider"]').val('');
});
