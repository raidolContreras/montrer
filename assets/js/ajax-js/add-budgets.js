$(document).ready(function () {
	$("form.account-wrap").submit(function (event) {
		// Evitar el envío del formulario por defecto
		event.preventDefault();

		// Recoge los valores del formulario
		var area = $("select[name='area']").val();
		var AuthorizedAmount = $("input[name='AuthorizedAmount']").val();
		var exercise = $("select[name='exercise']").val();

		// Realiza la solicitud Ajax
		$.ajax({
			type: "POST",
			url: "controller/ajax/ajax.form.php",
			data: {
				area: area,
				AuthorizedAmount: AuthorizedAmount,
				exercise: exercise
			},
			success: function (response) {

		    	const Toast = Swal.mixin({
				  toast: true,
				  position: "top-end",
				  showConfirmButton: false,
				  timer: 1500,
				  timerProgressBar: true,
				  didOpen: (toast) => {
				    toast.onmouseenter = Swal.stopTimer;
				    toast.onmouseleave = Swal.resumeTimer;
				  }
				});

			    if (response === 'ok') {
					Swal.fire({
					  icon: "success",
					  title: 'Presupuesto asignado',
					  icon: "success"
					});
			    } else if (response === 'Error: Presupuesto ya asignado') {
					Swal.fire({
					  icon: "error",
					  title: 'Presupuesto ya asignado a esta area',
					  icon: "error"
					});
			    } else {
					Swal.fire({
			          icon: 'error',
					  title: 'Error al asignar el presupuesto',
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