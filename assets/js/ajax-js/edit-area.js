$(document).ready(function () {
	$("form.account-wrap").submit(function (event) {
		// Evitar el envío del formulario por defecto
		event.preventDefault();

		// Recoge los valores del formulario
		var areaName = $("input[name='areaName']").val();
		var areaDescription = $("input[name='areaDescription']").val();
		var user = $("select[name='user']").val();
		var area = $('#register-value').data('register');

        if (areaName == '' || user == null) {
            Swal.fire({
				icon: 'warning',
				title: 'Error',
				text: 'Por favor, complete correctamente todos los campos obligatorios (nombre del departamento, colaborador responsable).',
				icon: "warning"
			});
        } else {
			
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
						timerProgressBar: false,
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
						}).then((result) => {
							if (result.isConfirmed) {
								window.location.href = 'areas';
							}
						});
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