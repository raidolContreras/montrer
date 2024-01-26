$(document).ready(function () {
	$("form.account-wrap").submit(function (event) {
		// Evitar el envío del formulario por defecto
		event.preventDefault();

		// Recoge los valores del formulario
		var AuthorizedAmount = $("input[name='AuthorizedAmount']").val();
		var area = $("select[name='area']").val();
		var exercise = $("select[name='exercise']").val();
		var budget = $('#register-value').data('register');

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

		if (area == '' || AuthorizedAmount == '' || exercise == ''){
			Swal.fire({
				icon: 'warning',
				title: 'Advertencia',
				text: 'Por favor, complete correctamente todos los campos obligatorios (area, presupuesto asignado, ejercicio)',
			});
		} else {
			// Realiza la solicitud Ajax
			$.ajax({
				type: "POST",
				url: "controller/ajax/ajax.form.php",
				data: {
					updateAuthorizedAmount: AuthorizedAmount,
					updateArea: area,
					updateExercise: exercise,
					updateBudget: budget
				},
				success: function (response) {
	
					if (response === 'ok') {
						Swal.fire({
						  icon: "success",
						  title: 'Presupuesto actualizado exitosamente',
						  icon: "success"
						}).then((result) => {
							if (result.isConfirmed) {
								window.location.href = 'budgets';
							}
						});
					} else {
						Swal.fire({
						  icon: 'error',
						  title: 'Error al actualizar el presupuesto',
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