$(document).ready(function () {
	$("form.account-wrap").submit(function (event) {
		// Evitar el envío del formulario por defecto
		event.preventDefault();

		// Recoge los valores del formulario
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

		  if (firstname == '' || lastname == '' || email == ''){
			Swal.fire({
			  icon: 'warning',
			  title: 'Error',
			  text: 'Por favor, complete correctamente todos los campos obligatorios ()',
			  icon: "warning"
			});
		} else {
			// Realiza la solicitud Ajax
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

// Esperar a que el documento esté listo
document.addEventListener('DOMContentLoaded', function () {
	// Obtener el botón de cancelar por su ID
	var cancelButton = document.getElementById('cancelButton');

	// Agregar un evento de clic al botón de cancelar
	cancelButton.addEventListener('click', function (event) {
		// Prevenir el comportamiento predeterminado del enlace
		event.preventDefault();

		// Mostrar un modal de confirmación con SweetAlert2
		Swal.fire({
			title: '¿Seguro que deseas cancelar?',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonText: 'Sí, cancelar',
			cancelButtonText: 'No, seguir aquí',
		}).then((result) => {
			// Si hacen clic en "Sí, cancelar", redirigir a "registers"
			if (result.isConfirmed) {
				window.location.href = "requestBudget";
			}
			// Si hacen clic en "No, seguir aquí", no hacer nada
		});
	});
});

$(document).ready(function () {
    // Obtén el valor de register desde el elemento HTML
    var registerValue = $('#register-value').data('register');

    // Llama a la función para obtener el usuario con el valor de register
    getArea(registerValue);
    getProviders();

});

function getArea(registerValue) {
    // Realiza la solicitud AJAX para obtener las áreas
    $.ajax({
        type: 'POST',
        url: 'controller/ajax/getAreasManager.php',
        data: {user: registerValue},
        dataType: 'json',
        success: function (response) {

            // Rellena el formulario con los datos obtenidos
            $('select[name="area"]').val(response.nameArea);

            // Llama a la función para llenar el select con las áreas
            fillSelect('area',response, 'departamento');
        },
        error: function (error) {
            console.log('Error en la solicitud AJAX:', error);
        }
    });
}

function getProviders() {
    // Realiza la solicitud AJAX para obtener las áreas
    $.ajax({
        type: 'POST',
        url: 'controller/ajax/getProviderON.php',
        dataType: 'json',
        success: function (response) {
            console.log('Respuesta del servidor:', response);

            // Rellena el formulario con los datos obtenidos
            $('select[name="provider"]').val(response.business_name);

            // Llama a la función para llenar el select con las áreas
            fillSelect('provider',response, 'proveedor');
        },
        error: function (error) {
            console.log('Error en la solicitud AJAX:', error);
        }
    });
}

// Función para llenar el select con las áreas
function fillSelect(select, datas, message) {
    var selectOption = $('#' + select);

    // Limpia el select antes de agregar nuevas opciones
    selectOption.empty();

    var option = $('<option>').val('').text('Seleccionar ' + message);
    selectOption.append(option);

    // Agrega una opción por cada área recibida
    datas.forEach(function (data) {
        // Accede a las propiedades utilizando la notación de corchetes
        var option = $('<option>').val(data[0]).text(data[1]);
        selectOption.append(option);
    });
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
