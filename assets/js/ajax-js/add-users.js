var bandera = 0;
$(document).ready(function () {
	selectArea();
    // Detectar cambios en cualquier campo del formulario y establecer la bandera a 1
    $("form.account-wrap input, form.account-wrap select").change(function() {
        bandera = 1;
    });

	$("form.account-wrap").submit(function (event) {
		event.preventDefault();
        // Collect form values
        var firstname = $("input[name='firstname']").val();
        var lastname = $("input[name='lastname']").val();
        var email = $("input[name='email']").val();
        var level = $("select[name='level']").val();
        var area = $("select[name='area']").val();
		
        if (firstname == '' || lastname == '' || email == '' || area == '') {
            showAlertBootstrap('¡Atención!', 'Por favor, introduzca la información solicitada en todos lo campos señalados con un (*).');
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

						bandera = 0;
						$("input[name='firstname']").val('');
						$("input[name='lastname']").val('');
						$("input[name='email']").val('');
						$("select[name='level']").val('2');
						$("select[name='area']").val('');

						showAlertBootstrap3(response+' creado exitosamente', '¿Agregar otro usuario?', 'register' , 'registers');

					} else if (response === 'Error: Email duplicado') {

						showAlertBootstrap('!Atención¡', 'Dirección de correo electrónico ya registrada');

					} else {

						showAlertBootstrap('!Atención¡', 'Error al crear el usuario');
						
					}
				},
				error: function (error) {
					console.log("Error en la solicitud Ajax:", error);
				}
			});
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {
    var cancelButton = document.getElementById('cancelButton');

    cancelButton.addEventListener('click', function (event) {
        event.preventDefault();
		showAlertBootstrap2('Cancelar', '¿Seguro que desea cancelar?', 'registers');
    });
});


function confirmExit(event, destination) {
	if (bandera == 1){
		event.preventDefault();
		showAlertBootstrap2('¿Está seguro?', 'Si sale del formulario, perderá los cambios no guardados.', destination);
	}
}

function selectArea() {
    $.ajax({
        type: "POST",
        url: "controller/ajax/getAreas.php",
        dataType: "json",
        success: function (response) {
            var html = `<option value="">Seleccione el departamento *</option>`;
            response.forEach(area => {
                html += `<option value="${area.idArea}" data-idUser="${area.idUser}">${area.nameArea}</option>`;
            });
            $("#area").html(html);

        },
        error: function (error) {
            console.log("Error en la solicitud Ajax:", error);
        }
    });
}


function showAlertBootstrap7(title, message) {
	$('#modalLabel').text(title);
	$('.modal-body-extra').text(message);
	$('.modal-footer-extra').html('<button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="selectDefault()">Cancelar</button><button type="button" class="btn btn-success" data-bs-dismiss="modal">Aceptar</button>');
	$('#alertModal').modal('show');
}

function selectDefault() {
	selectArea();
}