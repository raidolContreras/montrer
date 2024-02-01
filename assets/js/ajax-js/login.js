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
				  timerProgressBar: false,
				  didOpen: (toast) => {
				    toast.onmouseenter = Swal.stopTimer;
				    toast.onmouseleave = Swal.resumeTimer;
				  }
				});

			    if (response === 'ok') {
                    window.location.href = 'inicio';
			    }else if (response === 'status off') {
					Swal.fire({
						title: "Usuario deshabilitado",
						icon: "warning",
						text: 'Comuníquese con el administrador de la plataforma, para cualquier aclalaración.',
					});
			    }else {
					Swal.fire({
			          icon: 'error',
					  title: 'Error al iniciar sesión, verifique su correo o contraseña',
					  icon: "error"
					});
			    }
			},
			error: function (error) {
				console.log("Error en la solicitud Ajax:", error);
			}
		});
	});
});