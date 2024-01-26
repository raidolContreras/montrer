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
		var exerciseName = $("input[name='exerciseName']").val();
		var initialDate = $("input[name='initialDate']").val();
		var finalDate = $("input[name='finalDate']").val();
		var user = $("input[name='user']").val();
		var budget = $("input[name='budget']").val();
		var exercise = $('#register-value').data('register');

		
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
					updateExerciseName: exerciseName,
					updateInitialDate: initialDate,
					updateFinalDate: finalDate,
					updateUser: user,
					updateBudget: budget,
					updateExercise: exercise
				},
				success: function (response) {			  
	
					if (response !== 'Error' && response !== 'Error: Email duplicado') {
						Swal.fire({
						  icon: "success",
						  title: 'Departamento actualizado exitosamente',
						  icon: "success"
						});
						setTimeout(function () {
							window.location.href = 'exercise';
						}, 1000);
					} else {
						Swal.fire({
						  icon: 'error',
						  title: 'Error al crear el departamento',
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