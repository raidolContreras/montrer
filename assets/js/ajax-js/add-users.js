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
			    if (response !== 'Error' && response !== 'Error: Email duplicado') {
			        Swal.fire({
			            icon: 'success',
			            title: 'Good Job!',
			            text: 'Usuario '+response+' creado exitosamente',
			            showConfirmButton: true,
			        });
			    } else if (response === 'Error: Email duplicado') {
			        Swal.fire({
			            icon: 'error',
			            title: 'Error!',
			            text: response,
			            showConfirmButton: true,
			        });
			    } else {
			        Swal.fire({
			            icon: 'error',
			            title: 'Error!',
			            text: 'Error al crear el usuario',
			            showConfirmButton: true,
			        });
			    }
			},
			error: function (error) {
				console.log("Error en la solicitud Ajax:", error);
			}
		});
	});
});