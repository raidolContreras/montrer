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
					position: "center",
					showConfirmButton: false,
					timer: 3000,
					timerProgressBar: true,
					didOpen: (toast) => {
					  toast.onmouseenter = Swal.stopTimer;
					  toast.onmouseleave = Swal.resumeTimer;
					}
				  });				  

			    if (response !== 'Error' && response !== 'Error: Email duplicado') {
					
					$("input[name='firstname']").val('');
					$("input[name='lastname']").val('');
					$("input[name='email']").val('');
					$("select[name='level']").val('');
					Swal.fire({
					  icon: "success",
					  title: 'Usuario '+response+' creado exitosamente',
					  icon: "success"
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
	});
});