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