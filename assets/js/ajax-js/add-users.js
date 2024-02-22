$(document).ready(function () {
	
    $("form.account-wrap").submit(function (event) {
        event.preventDefault();

        // Collect form values
        var firstname = $("input[name='firstname']").val();
        var lastname = $("input[name='lastname']").val();
        var email = $("input[name='email']").val();
        var level = $("select[name='level']").val();
        var area = $("select[name='area']").val();

        if (firstname == '' || lastname == '' || email == '') {
            showAlertBootstrap('Error', 'Por favor, introduzca la información solicitada en todos lo campos señalados con un (*).');
        } else {
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
						
						showAlertBootstrap('Exito', response+' creado exitosamente');

					} else if (response === 'Error: Email duplicado') {

						showAlertBootstrap('Error', response);

					} else {

						showAlertBootstrap('Error', 'Error al crear el usuario');
						
					}
				},
				error: function (error) {
					console.log("Error en la solicitud Ajax:", error);
				}
			});
        }
    });
});

var modalFooter = $('.modal-footer');

// Show Bootstrap Modal with a custom message
function showAlertBootstrap(title, message) {
    $('#modalLabel').text(title); // Set the title of the modal
    $('.modal-body').text(message); // Set the message of the modal
        modalFooter.html('<button type="button" class="btn btn-success" data-bs-dismiss="modal">Aceptar</button>');
    $('#alertModal').modal('show'); // Show the modal
}

// Initialize Bootstrap tooltips
$(function () {
    $('[data-bs-toggle="tooltip"]').tooltip();
});

document.addEventListener('DOMContentLoaded', function () {
    var cancelButton = document.getElementById('cancelButton');

    cancelButton.addEventListener('click', function (event) {
        event.preventDefault();

        $('#modalLabel').text('Cancelar registro');
        $('.modal-body').text('¿Seguro que deseas cancelar?');
        modalFooter.html('<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button><button type="button" class="btn btn-success" onclick="window.location.href=\'registers\'">Aceptar</button>');
        $('#alertModal').modal('show');
    });
});


function confirmExit(event, destination) {
    event.preventDefault();
    
    $('#modalLabel').text('¿Estás seguro?');
    $('.modal-body').text('Si sales del formulario, perderás los cambios no guardados.');
    $('.modal-footer').html('<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button><button type="button" class="btn btn-success" onclick="window.location.href=\'' + destination + '\'">Aceptar</button>');
    $('#alertModal').modal('show');
}
