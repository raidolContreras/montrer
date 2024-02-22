$(document).ready(function () {
	$("form.account-wrap").submit(function (event) {
		// Evitar el envío del formulario por defecto
		event.preventDefault();

		// Recoge los valores del formulario
		var areaName = $("input[name='areaName']").val();
		var areaDescription = $("input[name='areaDescription']").val();
		var user = $("select[name='user']").val();
		var area = $('#register-value').data('register');

        if (areaName == '' || user == null) {
            Swal.fire({
				icon: 'warning',
				title: 'Error',
				text: 'Por favor, introduzca la información solicitada en todos lo campos señalados con un (*).',
				confirmButtonColor: '#026f35',
				confirmButtonText: 'Aceptar'
			});
        } else {
			
			// Realiza la solicitud Ajax
			$.ajax({
				type: "POST",
				url: "controller/ajax/ajax.form.php",
				data: {
					updateAreaName: areaName,
					updateAreaDescription: areaDescription,
					updateUser: user,
					updateArea: area
				},
				success: function (response) {
					
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
	
					if (response !== 'Error' && response !== 'Error: Email duplicado') {
						Swal.fire({
						  icon: "success",
						  title: 'Departamento actualizado exitosamente',
						  confirmButtonColor: '#026f35',
						  confirmButtonText: 'Aceptar'
						}).then((result) => {
							if (result.isConfirmed) {
								window.location.href = 'areas';
							}
						});
					} else {
						Swal.fire({
						  icon: 'error',
						  title: 'Error al crear el departamento',
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

// Esperar a que el documento esté listo
document.addEventListener('DOMContentLoaded', function () {
	// Obtener el botón de cancelar por su ID
	var cancelButton = document.getElementById('cancelButton');

	// Agregar un evento de clic al botón de cancelar
	cancelButton.addEventListener('click', function (event) {
		// Prevenir el comportamiento predeterminado del enlace
		event.preventDefault();

		showAlertBootstrap2('Cancelar', '¿Seguro que deseas cancelar?', 'areas');
		
	});
});

function confirmExit(event, destination) {
	event.preventDefault();
	showAlertBootstrap2('¿Estás seguro?', 'Si sales del formulario, perderás los cambios no guardados.', destination);
}
