
function sendForm() {

    var providerKey = $("input[name='providerKey']").val();
    var representativeName = $("input[name='representativeName']").val();
    var contactPhone = $("input[name='contactPhone']").val();
    var email = $("input[name='email']").val();
    var website = $("input[name='website']").val();
    var businessName = $("input[name='businessName']").val();
    var rfc = $("input[name='rfc']").val();
    var fiscalAddressStreet = $("input[name='fiscalAddressStreet']").val();
    var fiscalAddressColonia = $("input[name='fiscalAddressColonia']").val();
    var fiscalAddressMunicipio = $("input[name='fiscalAddressMunicipio']").val();
    var fiscalAddressEstado = $("input[name='fiscalAddressEstado']").val();
    var fiscalAddressCP = $("input[name='fiscalAddressCP']").val();
    var bankName = $("input[name='bankName']").val();
    var accountHolder = $("input[name='accountHolder']").val();
    var accountNumber = $("input[name='accountNumber']").val();
    var clabe = $("input[name='clabe']").val();
    var description = $("input[name='description']").val();
    var user = $("input[name='user']").val();

    if (!validateField(businessName) ||
        !validateField(representativeName) ||
        !validateField(email) ||
        !validateField(rfc) ||
        !validateField(contactPhone) ||
        !validateField(fiscalAddressStreet) ||
        !validateField(fiscalAddressColonia) ||
        !validateField(fiscalAddressMunicipio) ||
        !validateField(fiscalAddressEstado) ||
        !validateField(fiscalAddressCP) ||
        !validateField(bankName) ||
        !validateField(accountHolder) ||
        !validateField(description) ||
        !validateField(accountNumber)
    ) {
        return;
    }

    $.ajax({
        type: "POST",
        url: "controller/ajax/ajax.form.php",
        data: {
            providerKey: providerKey,
            representativeName: representativeName,
            contactPhone: contactPhone,
            email: email,
            website: website,
            businessName: businessName,
            rfc: rfc,
            fiscalAddressStreet: fiscalAddressStreet,
            fiscalAddressColonia: fiscalAddressColonia,
            fiscalAddressMunicipio: fiscalAddressMunicipio,
            fiscalAddressEstado: fiscalAddressEstado,
            fiscalAddressCP: fiscalAddressCP,
            bankName: bankName,
            accountHolder: accountHolder,
            accountNumber: accountNumber,
            clabe: clabe,
            description: description,
            user: user
        },
        success: function (response) {
            if (response === 'ok') {

                $('#modalAgregarProveedor').modal('hide');

                $("input[name='representativeName']").val('');
                $("input[name='contactPhone']").val('');
                $("input[name='email']").val('');
                $("input[name='website']").val('');
                $("input[name='businessName']").val('');
                $("input[name='rfc']").val('');
                $("input[name='fiscalAddressStreet']").val('');
                $("input[name='fiscalAddressColonia']").val('');
                $("input[name='fiscalAddressMunicipio']").val('');
                $("input[name='fiscalAddressEstado']").val('');
                $("input[name='fiscalAddressCP']").val('');
                $("input[name='bankName']").val('');
                $("input[name='accountHolder']").val('');
                $("input[name='accountNumber']").val('');
                $("input[name='clabe']").val('');
                $("input[name='description']").val('');

                getNextIdProvider();
                restartSelectProvider();

            } else if (response == 'Error: RFC ya registrado') {
                
                showAlertBootstrap('!Atención¡', 'RFC ya registrado.');

            } else {
                
                showAlertBootstrap('!Atención¡', 'Error al crear el proveedor.');

            }
        },
        error: function (error) {
            console.log("Error en la solicitud Ajax:", error);
        }
    });
};

function validateField(fieldName) {
    if (fieldName === '') {
        
        showAlertBootstrap('¡Atención!', 'Por favor, introduzca la información solicitada en todos lo campos señalados con un (*).');
        return false;
    }
    return true;
}