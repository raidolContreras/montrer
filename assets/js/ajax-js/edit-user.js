$(document).ready(function () {
	$("form.account-wrap").submit(function (event) {
		// Evitar el envío del formulario por defecto
		event.preventDefault();
	
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

		// Recoge los valores del formulario
		var firstname = $("input[name='firstname']").val();
		var lastname = $("input[name='lastname']").val();
		var email = $("input[name='email']").val();
		var level = $("select[name='level']").val();
		var user = $('#register-value').data('register');

		if (firstname == '' || lastname == '' || email == ''){
			Swal.fire({
			  icon: 'warning',
			  title: 'Error',
			  text: 'Por favor, complete correctamente todos los campos obligatorios (nombre(s), apellidos, email)',
			  icon: "warning"
			});
		} else {
			// Realiza la solicitud Ajax
			$.ajax({
				type: "POST",
				url: "controller/ajax/ajax.form.php",
				data: {
					updateFirstname: firstname,
					updateLastname: lastname,
					updateEmail: email,
					updateLevel: level,
					updateUser: user
				},
				success: function (response) {			  
	
					if (response !== 'Error' && response !== 'Error: Email duplicado') {
						Swal.fire({
						  icon: "success",
						  title: 'Datos del usuario actualizados exitosamente',
						  icon: "success"
						}).then((result) => {
							if (result.isConfirmed) {
								window.location.href = "registers";
							}
						});
					} else if (response === 'Error: Email duplicado') {
						Swal.fire({
						  icon: 'error',
						  title: response,
						  icon: "error"
						});
					} else {
						Swal.fire({
						  icon: 'error',
						  title: 'Error al crear el usuario',
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
				window.location.href = "registers";
			}
			// Si hacen clic en "No, seguir aquí", no hacer nada
		});
	});
});

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

$(function () {
	$('[data-bs-toggle="tooltip"]').tooltip();
});