$(document).ready(function () {
    var myDropzone = new Dropzone("#logoDropzone", {
        url: "controller/ajax/ajax.form.php",
        maxFiles: 1,
        paramName: "logo",
        maxFilesize: 10,
        acceptedFiles: "image/png",
        dictDefaultMessage: 'Arrastra y suelta el archivo aquí o haz clic para seleccionar uno <p class="subtitulo-sup">Tipos de archivo permitidos .png,.jpg,.jpeg (Tamaño máximo 10 MB)</p>',
        autoProcessQueue: false,
    });

    var idCompany;

    $("#companyForm").submit(function (event) {
        // Evitar el envío del formulario por defecto
        event.preventDefault();

        // Recoge los valores del formulario
        var companyName = $("#companyName").val();
        
        // Nuevos campos de colores
        var primaryColor = $("#primaryColor").val();
        var secondaryColor = $("#secondaryColor").val();
        var accentColor = $("#accentColor").val();
        var background1Color = $("#background1Color").val();
        var background2Color = $("#background2Color").val();
        // Agrega más campos según sea necesario

        var companyDescription = $("#companyDescription").val();

        // Construye el objeto JSON
        var colors = {
            primary: primaryColor,
            secondary: secondaryColor,
            accent: accentColor,
            background1: background1Color,
            background2: background2Color,
        };

        // Realiza la solicitud Ajax
        $.ajax({
            type: "POST",
            url: "controller/ajax/ajax.form.php",
            data: {
                companyName: companyName,
                colors: JSON.stringify(colors),
                companyDescription: companyDescription,
            },
            success: function (response) {

                if (response !== 'Error') {
                    
                    showAlertBootstrap('', 'Empresa '+companyName+' creada exitosamente.');

                    idCompany = response;
                    myDropzone.processQueue();

					// Vaciar los campos del formulario
					$("#companyName").val("");
					$("#companyDescription").val("");
					$("#primaryColor").val("#3498db");
					$("#secondaryColor").val("#e74c3c");
					$("#accentColor").val("#2ecc71");
					$("#background1Color").val("#ecf0f1");
					$("#background2Color").val("#ffffff");
                    
                    setTimeout(() => {
                        // Limpiar el Dropzone
                        myDropzone.removeAllFiles();
                    }, 1000);

                } else {
                    
                    showAlertBootstrap('Error', response);
                    
                }
            },
            error: function (error) {
                console.log("Error en la solicitud Ajax:", error);
            }
        });
    });

    // Configuración del evento 'sending' del Dropzone
	myDropzone.on("sending", function(file, xhr, formData) {
			formData.append("idCompany", idCompany);
	});
});