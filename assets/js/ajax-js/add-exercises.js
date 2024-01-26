$(document).ready(function () {
	$("form.account-wrap").submit(function (event) {
		// Evitar el envío del formulario por defecto
		event.preventDefault();

		// Recoge los valores del formulario
		var exerciseName = $("input[name='exerciseName']").val();
		var initialDate = $("input[name='initialDate']").val();
		var finalDate = $("input[name='finalDate']").val();
		var budget = $("input[name='budget']").val();
		var user = $("input[name='user']").val();

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

		if (exerciseName == ''){
			Swal.fire({
				icon: 'warning',
				title: 'Advertencia',
				text: 'Por favor, ingrese el nombre del ejercicio.',
			});
		} else if (initialDate == '') {
			Swal.fire({
				icon: 'warning',
				title: 'Advertencia',
				text: 'Por favor, seleccione la fecha de inicio del ejercicio.',
			});
		} else if (finalDate == '') {
			Swal.fire({
				icon: 'warning',
				title: 'Advertencia',
				text: 'Por favor, seleccione la fecha de finalización del ejercicio.',
			});
		} else if (budget == '') {
			Swal.fire({
				icon: 'warning',
				title: 'Advertencia',
				text: 'Por favor, ingrese el presupuesto asignado para el ejercicio.',
			});
		} else {
			// Realiza la solicitud Ajax
			$.ajax({
				type: "POST",
				url: "controller/ajax/ajax.form.php",
				data: {
					exerciseName: exerciseName,
					initialDate: initialDate,
					finalDate: finalDate,
					budget: budget,
					user: user
				},
				success: function (response) {
	
					if (response === 'ok') {
	
						$("input[name='exerciseName']").val('');
						$("input[name='initialDate']").val('');
						$("input[name='finalDate']").val('');
						$("input[name='budget']").val('');
	
						Swal.fire({
						  icon: "success",
						  title: 'Ejercicio creado exitosamente',
						  icon: "success"
						});
					} else {
						Swal.fire({
						  icon: 'error',
						  title: 'Error al crear el ejercicio',
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