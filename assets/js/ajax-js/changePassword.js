var bandera = 0;
$(document).ready(function () {

    // Detectar cambios en cualquier campo del formulario y establecer la bandera a 1
    $("form.account-wrap input, form.account-wrap select").change(function() {
        bandera = 1;
    });

    $("form.account-wrap").submit(function (event) {
        event.preventDefault();

        var actualPassword = $("input[name='actualPassword']").val();
        var newPassword = $("input[name='newPassword']").val();
        var confirmPassword = $("input[name='confirmPassword']").val();
        var user = $("input[name='user']").val();

        // Validar que la nueva contraseña sea igual a la confirmación
        if (newPassword !== confirmPassword) {
            
            showAlertBootstrap('Error', 'La nueva contraseña y la confirmación no coinciden.');
            
            return;
        }

        // Validar los requisitos de la contraseña
        var passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*\W)[\w\W]{10,}$/;
        if (!passwordRegex.test(newPassword)) {
            showAlertBootstrap('Error', 'La contraseña debe contener 10 caracteres, de los cuáles obligatoriamente: 1 letra mayúscula, 1 letra minúscula, 1 número y 1 símbolo.');
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
                    
                    showAlertBootstrap('Error', 'Las contraseñas no son iguales.');
                    
                } else if (response === "Error: Password") {
                    
                    showAlertBootstrap('Error', 'La contraseña actual no es correcta.');
                    
                } else if (response === "Error: Inexistente") {

                    showAlertBootstrap('Error', 'No se pudo actualizar la contraseña, intentelo nuevamente.');
                    
                } else if (response === "ok") {

                    bandera = 0;
                    
                    showAlertBootstrap2('Operación realizada', 'Contraseña actualizada correctamente.', 'inicio');

                } else {
                    
                    showAlertBootstrap('Error', 'La nueva contraseña no puede ser igual a la antigua.');

                }
            },
            error: function (error) {
                console.log("Error en la solicitud Ajax:", error);
            }
        });
    });
});
