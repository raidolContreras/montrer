$(document).ready(function () {
    // Inicializa el select de áreas y vincula el evento de cambio
    getAreas();
    $('#area').on('change', function () {
        getPartidas($(this).val());
    });
});

function getAreas() {
    $.ajax({
        type: 'GET',
        url: 'controller/ajax/getAreas.php',
        dataType: 'json',
        success: function (response) {
            var $areaSelect = $('#area');
            $areaSelect.empty().append($('<option>', {
                value: '',
                text: 'Selecciona un area'
            }));

            if (Array.isArray(response) && response.length > 0) {
                $.each(response, function (i, area) {
                    if (area.status == 1) {
                        $areaSelect.append($('<option>', {
                            value: area.idArea,
                            text: area.nameArea
                        }));
                    }
                });
            } else {
                console.log('La respuesta del servidor no contiene áreas válidas.');
            }
        },
        error: function (error) {
            console.log('Error en la solicitud AJAX:', error);
        }
    });
}

function getPartidas(idArea) {
    var $partidaSelect = $('#partida');
    if (!idArea) {
        $partidaSelect.empty().append($('<option>', {
            value: '',
            text: 'Selecciona un area primero'
        })).prop('disabled', true);
        return;
    }

    $.ajax({
        type: 'POST',
        url: 'controller/ajax/getPartidasToArea.php',
        data: { idArea: idArea },
        dataType: 'json',
        success: function (response) {
            $partidaSelect.empty();
            if (Array.isArray(response) && response.length > 0) {
                $partidaSelect.append($('<option>', {
                    value: '',
                    text: 'Selecciona una partida'
                })).prop('disabled', false);
                $.each(response, function (i, partida) {
                    if (partida.status == 1) {
                        $partidaSelect.append($('<option>', {
                            value: partida.idPartida,
                            text: partida.Partida
                        }));
                    }
                });
            } else {
                $partidaSelect.append($('<option>', {
                    value: '',
                    text: 'Selecciona un area primero'
                })).prop('disabled', true);
                showAlertBootstrap('¡Atención!', 'El departamento seleccionado no cuenta con partidas registradas');
            }
        }
    });
}
