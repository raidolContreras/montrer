$(document).ready(function () {
	$("form.account-wrap").submit(function (event) {
		// Evitar el envío del formulario por defecto
		event.preventDefault();

		// Recoge los valores del formulario
		var areaName = $("input[name='areaName']").val();
		var areaDescription = $("input[name='areaDescription']").val();
		var user = $("select[name='user']").val();
		var area = $('#register-value').data('register');

		// Realiza la solicitud Ajax
		$.ajax({
			type: "POST",
			url: "controller/ajax/ajax.form.php",
			data: {
				updateAreaName: areaName,
				updateAreaDescription: areaDescription,
				updateUser: user,
				updateArea: area
			},
			success: function (response) {
				
				const Toast = Swal.mixin({
					toast: true,
					position: "center",
					showConfirmButton: false,
					timer: 1000,
					timerProgressBar: true,
					didOpen: (toast) => {
					  toast.onmouseenter = Swal.stopTimer;
					  toast.onmouseleave = Swal.resumeTimer;
					}
				  });				  

			    if (response !== 'Error' && response !== 'Error: Email duplicado') {
					Swal.fire({
					  icon: "success",
					  title: 'Departamento actualizado exitosamente',
					  icon: "success"
					});
					setTimeout(function () {
						window.location.href = 'areas';
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
	});
});