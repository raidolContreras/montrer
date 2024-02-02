$(document).ready(function () {
    $("form.account-wrap").submit(function (event) {
        event.preventDefault();

        var actualPassword = $("input[name='actualPassword']").val();
        var newPassword = $("input[name='newPassword']").val();
        var confirmPassword = $("input[name='confirmPassword']").val();
        var user = $("input[name='user']").val();

        // Validar que la nueva contraseña sea igual a la confirmación
        if (newPassword !== confirmPassword) {
            // Mostrar un mensaje de error
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'La nueva contraseña y la confirmación no coinciden.',
                confirmButtonColor: '#026f35',
                confirmButtonText: 'Aceptar'
            });
            return;
        }

        // Validar los requisitos de la contraseña
        var passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*\W)[\w\W]{10,}$/;
        if (!passwordRegex.test(newPassword)) {
            console.log(passwordRegex.test('Paquelaquieres1+'));

            // Mostrar un mensaje de error
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'La contraseña debe contener 10 caracteres, de los cuáles obligatoriamente: 1 letra mayúscula, 1 letra minúscula, 1 número y 1 símbolo.',
                confirmButtonColor: '#026f35',
                confirmButtonText: 'Aceptar'
            });
            return;
        }

        // Realizar la solicitud Ajax
        $.ajax({
            type: "POST",
            url: "controller/ajax/ajax.form.php",
            data: {
                updateActualPassword: actualPassword,
                updateNewPassword: newPassword,
                updateConfirmPassword: confirmPassword,
                user: user,
            },
            success: function (response) {
                if (response === "Error: Contraseñas distintas") {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Las contraseñas no son iguales.',
                        confirmButtonColor: '#026f35',
                        confirmButtonText: 'Aceptar'
                    });
                } else if (response === "Error: Password") {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'La contraseña actual no es correcta.',
                        confirmButtonColor: '#026f35',
                        confirmButtonText: 'Aceptar'
                    });
                } else if (response === "Error: Inexistente") {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudo actualizar la contraseña, intentelo nuevamente.',
                        confirmButtonColor: '#026f35',
                        confirmButtonText: 'Aceptar'
                    });
                } else if (response === "ok") {
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: 'Contraseña actualizada correctamente.',
                        confirmButtonColor: '#026f35',
                        confirmButtonText: 'Aceptar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'inicio'; // Redirige al inicio
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'La nueva contraseña no puede ser igual a la antigua.',
                        confirmButtonColor: '#026f35',
                        confirmButtonText: 'Aceptar'
                    });
                }
            },
            error: function (error) {
                console.log("Error en la solicitud Ajax:", error);
            }
        });
    });
});
