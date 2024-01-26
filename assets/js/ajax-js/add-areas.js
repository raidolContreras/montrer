$(document).ready(function () {
    $("form.account-wrap").submit(function (event) {
        // Evitar el envío del formulario por defecto
        event.preventDefault();

        // Recoge los valores del formulario
        var areaName = $("input[name='areaName']").val();
        var areaDescription = $("input[name='areaDescription']").val();
        var user = $("select[name='user']").val();

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

        if (areaName !== '' && user !== null) {
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

                    if (response === 'ok') {
                        $("input[name='areaName']").val('');
                        $("input[name='areaDescription']").val('');
                        $("select[name='user']").val('');

                        Swal.fire({
                            icon: "success",
                            title: 'Departamento registrado',
                            icon: "success"
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error al registrar el departamento',
                            icon: "error"
                        });
                    }
                },
                error: function (error) {
                    console.log("Error en la solicitud Ajax:", error);
                }
            });
        } else {

            Swal.fire({
				icon: 'warning',
				title: 'Error',
				text: 'Por favor, complete correctamente todos los campos obligatorios (nombre del departamento, colaborador responsable).',
				icon: "warning"
			});
			
        }
    });
});
