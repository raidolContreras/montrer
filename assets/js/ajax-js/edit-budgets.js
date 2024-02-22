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
				text: 'Por favor, introduzca la información solicitada en todos lo campos señalados con un (*).',
				confirmButtonColor: '#026f35',
				confirmButtonText: 'Aceptar'
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
						  confirmButtonColor: '#026f35',
						  confirmButtonText: 'Aceptar'
						}).then((result) => {
							if (result.isConfirmed) {
								window.location.href = 'budgets';
							}
						});
					} else {
						Swal.fire({
						  icon: 'error',
						  title: 'Error al actualizar el presupuesto',
						  confirmButtonColor: '#026f35',
						  confirmButtonText: 'Aceptar'
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

// Esperar a que el documento esté listo
document.addEventListener('DOMContentLoaded', function () {
	// Obtener el botón de cancelar por su ID
	var cancelButton = document.getElementById('cancelButton');

	// Agregar un evento de clic al botón de cancelar
	cancelButton.addEventListener('click', function (event) {
		// Prevenir el comportamiento predeterminado del enlace
		event.preventDefault();

		// Mostrar un modal de confirmación con SweetAlert2
		Swal.fire({
			title: '¿Seguro que deseas cancelar?',
			icon: 'warning',
			showCancelButton: true,
			cancelButtonColor: '#d33',
			confirmButtonColor: '#026f35',
			cancelButtonText: 'Cancelar',
			confirmButtonText: 'Aceptar',
			reverseButtons: true,
		}).then((result) => {
			// Si hacen clic en "Sí, cancelar", redirigir a "registers"
			if (result.isConfirmed) {
				window.location.href = "budgets";
			}
			// Si hacen clic en "No, seguir aquí", no hacer nada
		});
	});
});

function confirmExit(event, destination) {
        event.preventDefault();
	$('#modalLabel').text('¿Estás seguro?');
    $('.modal-body').text('Si sales del formulario, perderás los cambios no guardados.');
    $('.modal-footer').html('<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button><button type="button" class="btn btn-success" onclick="window.location.href=\'' + destination + '\'">Aceptar</button>');
    $('#alertModal').modal('show');
}

$(function () {
	$('[data-bs-toggle="tooltip"]').tooltip();
});