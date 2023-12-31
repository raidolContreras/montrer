$(document).ready(function () {
	$("form.account-wrap").submit(function (event) {
		// Evitar el envío del formulario por defecto
		event.preventDefault();

		// Recoge los valores del formulario
		var areaName = $("input[name='areaName']").val();
		var areaDescription = $("input[name='areaDescription']").val();
		var user = $("select[name='user']").val();

		// Realiza la solicitud Ajax
		$.ajax({
			type: "POST",
			url: "controller/ajax/ajax.form.php",
			data: {
				areaName: areaName,
				areaDescription: areaDescription,
				user: user
			},
			success: function (response) {

		    	const Toast = Swal.mixin({
				  toast: true,
				  position: "center",
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
					  title: 'Area registrada',
					  icon: "success"
					});
			    } else {
					Swal.fire({
			          icon: 'error',
					  title: 'Error al registrar el area',
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