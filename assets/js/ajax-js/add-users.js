$(document).ready(function () {
	$("form.account-wrap").submit(function (event) {
		// Evitar el envío del formulario por defecto
		event.preventDefault();

		// Recoge los valores del formulario
		var firstname = $("input[name='firstname']").val();
		var lastname = $("input[name='lastname']").val();
		var email = $("input[name='email']").val();
		var level = $("select[name='level']").val();
		var area = $("select[name='area']").val();
		
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

		if (firstname == ''){
			Swal.fire({
			  icon: 'warning',
			  title: 'Error',
			  text: 'Se requiere ingresar el nombre del usuario',
			  icon: "warning"
			});
		} else if ( lastname == '') {
			Swal.fire({
			  icon: 'warning',
			  title: 'Error',
			  text: 'Se requiere ingresar los apellidos del usuario',
			  icon: "warning"
			});
		} else if ( email == '') {
			Swal.fire({
			  icon: 'warning',
			  title: 'Error',
			  text: 'Se requiere ingresar una dirección de correo electrónico válida',
			  icon: "warning"
			});
		} else {
			// Realiza la solicitud Ajax
			$.ajax({
				type: "POST",
				url: "controller/ajax/ajax.form.php",
				data: {
					firstname: firstname,
					lastname: lastname,
					email: email,
					level: level,
					area: area
				},
				success: function (response) {				  
	
					if (response !== 'Error' && response !== 'Error: Email duplicado') {
						
						$("input[name='firstname']").val('');
						$("input[name='lastname']").val('');
						$("input[name='email']").val('');
						$("select[name='level']").val('2');
						$("select[name='area']").val('');
						Swal.fire({
						  icon: "success",
						  title: 'Usuario',
						  text: response+' creado exitosamente',
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

		}
	});
});

document.getElementById('questionBtn').addEventListener('click', function () {
	Swal.fire({
		icon: 'info',
		title: 'Seleccione el departamento',
		text: 'Si el departamento no está listado, deje el campo vacío.'
	});
});