$(document).ready(function () {
    $("form.account-wrap").submit(function (event) {
        event.preventDefault();

        var actualPassword = $("input[name='actualPassword']").val();
        var newPassword = $("input[name='newPassword']").val();
        var confirmPassword = $("input[name='confirmPassword']").val();
        var user = $("input[name='user']").val();

        // Validar que la nueva contraseña sea igual a la confirmación
        if (newPassword !== confirmPassword) {
            
            showAlertBootstrap('!Atención¡', 'La nueva contraseña y la confirmación no coinciden.');
            return;
        }

        // Validar los requisitos de la contraseña
        var passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*\W)[\w\W]{10,}$/;
        if (!passwordRegex.test(newPassword)) {
            showAlertBootstrap('!Atención¡', 'La contraseña debe contener 10 caracteres, de los cuáles obligatoriamente: 1 letra mayúscula, 1 letra minúscula, 1 número y 1 símbolo.');
            return;
        }

        // Realizar la solicitud Ajax
        $.ajax({
            type: "POST",
            url: "controller/ajax/ajax.form.php",
            data: {
                actualPassword: actualPassword,
                newPassword: newPassword,
                confirmPassword: confirmPassword,
                user: user,
            },
            success: function (response) {
                if (response === "Error: Inexistente") {
                    
                    showAlertBootstrap('!Atención¡', 'Error al actualizar la contraseña.');
                    
                } else if (response === "Error: Password") {
                    
                    showAlertBootstrap('!Atención¡', 'La contraseña actual no es correcta.');
                    
                } else {
                    
                    showAlertBootstrap1('Operación realizada', 'Contraseña actualizada correctamente.', 'inicio');
                    
                }
            },
            error: function (error) {
                console.log("Error en la solicitud Ajax:", error);
            }
        });
    });
});
