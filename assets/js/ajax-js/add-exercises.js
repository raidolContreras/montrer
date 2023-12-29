$(document).ready(function () {
	$("form.account-wrap").submit(function (event) {
		// Evitar el envío del formulario por defecto
		event.preventDefault();

		// Recoge los valores del formulario
		var firstname = $("input[name='firstname']").val();
		var lastname = $("input[name='lastname']").val();
		var email = $("input[name='email']").val();
		var level = $("select[name='level']").val();

		// Realiza la solicitud Ajax
		$.ajax({
			type: "POST",
			url: "controller/ajax/ajax.form.php",
			data: {
				firstname: firstname,
				lastname: lastname,
				email: email,
				level: level
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

			    if (response !== 'Error' && response !== 'Error: Email duplicado') {
					Toast.fire({
					  icon: "success",
					  title: 'Usuario '+response+' creado exitosamente'
					});
			    } else if (response === 'Error: Email duplicado') {
					Toast.fire({
			          icon: 'error',
					  title: response
					});
			    } else {
					Toast.fire({
			          icon: 'error',
					  title: 'Error al crear el usuario'
					});
			    }
			},
			error: function (error) {
				console.log("Error en la solicitud Ajax:", error);
			}
		});
	});
});