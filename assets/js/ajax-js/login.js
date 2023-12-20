$(document).ready(function () {
	$("form.account-wrap").submit(function (event) {
		// Evitar el envío del formulario por defecto
		event.preventDefault();

		var email = $("input[name='email']").val();
		var password = $("input[name='password']").val();

		// Realiza la solicitud Ajax
		$.ajax({
			type: "POST",
			url: "controller/ajax/ajax.form.php",
			data: {
				email: email,
				password: password
			},
			success: function (response) {

		    	const Toast = Swal.mixin({
				  toast: true,
				  position: "top-end",
				  showConfirmButton: false,
				  timer: 3000,
				  timerProgressBar: true,
				  didOpen: (toast) => {
				    toast.onmouseenter = Swal.stopTimer;
				    toast.onmouseleave = Swal.resumeTimer;
				  }
				});

			    if (response === 'ok') {
					Toast.fire({
					  icon: "success",
					  title: 'Inicio de sesión exitoso'
					});
					// Redirigir a la página de inicio
					setTimeout(function () {
						window.location.href = 'inicio';
					}, 3000);
			    }else {
					Toast.fire({
			          icon: 'error',
					  title: 'Error al iniciar sesión, verifica tu correo o contraseña'
					});
			    }
			},
			error: function (error) {
				console.log("Error en la solicitud Ajax:", error);
			}
		});
	});
});