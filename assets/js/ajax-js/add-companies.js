$(document).ready(function () {
    $("#companyForm").submit(function (event) {
        // Evitar el envío del formulario por defecto
        event.preventDefault();

        // Recoge los valores del formulario
        var companyName = $("#companyName").val();
        var logo = $("#logo").val();
        
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
            // Agrega más campos según sea necesario
        };

        // Realiza la solicitud Ajax
        $.ajax({
            type: "POST",
            url: "controller/ajax/ajax.form.php",
            data: {
                companyName: companyName,
                logo: logo,
                colors: JSON.stringify(colors), // Convierte el objeto a una cadena JSON
                companyDescription: companyDescription,
                // Asegúrate de agregar otros campos según sea necesario
            },
            success: function (response) {
                // ... (manejar la respuesta)
            },
            error: function (error) {
                console.log("Error en la solicitud Ajax:", error);
            }
        });
    });
});
$(document).ready(function () {
    var myDropzone = new Dropzone("#logoDropzone", {
        url: "controller/ajax/ajax.form.php", // Reemplaza con la URL de tu script de carga
        uploadMultiple: false,
        paramName: "logo",
        maxFilesize: 2,
        acceptedFiles: "image/png",
        dictDefaultMessage: "Arrastra y suelta el archivo aquí o haz clic para seleccionar uno",
        autoQueue: false,
        success: function (file, response) {
            var logoUrl = response.logoUrl;
            $("#logo").val(logoUrl);

            // Agrega el botón de eliminar al elemento del archivo
            var removeButton = Dropzone.createElement("<button class='btn btn-danger btn-sm mt-2' data-dz-remove>Eliminar</button>");

            removeButton.addEventListener("click", function (e) {
                e.preventDefault();
                e.stopPropagation();
                myDropzone.removeFile(file); // Elimina el archivo del Dropzone
                // También podrías hacer una solicitud Ajax aquí para eliminar el archivo en el lado del servidor
            });

            file.previewElement.appendChild(removeButton); // Agrega el botón al área de vista previa
        }
    });
});

$(document).ready(function () {
    $("#companyForm").submit(function (event) {
        // Evitar el envío del formulario por defecto
        event.preventDefault();

        // Resto del código para procesar el formulario...
    });
});


