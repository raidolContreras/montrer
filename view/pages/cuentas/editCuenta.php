<?php if ($level == 1): ?>
<!-- Start Main Content Area -->
<main class="main-content-wrap">

    <div class="card-box-style">
        <div class="others-title">
            <h3>Editar cuenta</h3>
        </div>

        <?php
        // Obtener los parámetros enviados por POST
        $accountId = isset($_POST['id']) ? $_POST['id'] : '';
        $accountName = isset($_POST['cuenta']) ? $_POST['cuenta'] : '';
        $accountNumber = isset($_POST['numeroCuenta']) ? $_POST['numeroCuenta'] : '';
        $areaCode = isset($_POST['areaCode']) ? $_POST['areaCode'] : '';
        $area = isset($_POST['area']) ? $_POST['area'] : '';
        ?>

        <form class="account-wrap" id="editAccountForm">
            <div class="row">
                <input type="hidden" id="accountId" name="accountId" value="<?php echo htmlspecialchars($accountId); ?>">
                
                <div class="col-md-6">
                    <label for="cuenta" class="form-label">Nombre de la cuenta<span class="required"></span></label>
                    <input type="text" class="form-control" id="cuenta" name="cuenta" 
                           placeholder="Nombre de la cuenta" 
                           value="<?php echo htmlspecialchars($accountName); ?>">
                </div>
                
                <div class="col-md-6">
                    <label for="area" class="form-label">Departamento<span class="required"></span></label>
                    <select name="area" id="area" class="form-select form-control required-field"></select>
                    <input type="hidden" name="idAreaH" id="idAreaH" value="<?php echo $area ?>">
                </div>

                <div class="col-md-6">
                    <label for="numeroCuenta" class="form-label">Número de cuenta<span class="required"></span></label>
                    <!-- div de un grupo de /span /input /span -->
                    <div class="input-group">
                        <span class="input-group-text areaCode"><?php echo htmlspecialchars($areaCode); ?>-</span>
                        <input type="text" class="form-control auto-format" id="numeroCuenta" name="numeroCuenta" 
                            placeholder="Número de cuenta" 
                            value="<?php echo htmlspecialchars($accountNumber); ?>">
                        <span class="input-group-text endCode">-000-000</span>
                    </div>
                </div>

                <div class="col-12 mt-2 text-end">
                    <a class="btn btn-danger" id="cancelButton">Cancelar</a>
                    <button type="submit" class="btn btn-success">Guardar cambios</button>
                </div>
            </div>
        </form>
    </div>

</main>
<!-- End Main Content Area -->
<script src="assets/js/ajax-js/edit-account.js"></script>
<script>
    $(document).ready(function () {
        obtenerAreas(); // Llama a la función para obtener las áreas al cargar la página
    });
    
    function obtenerAreas() {
        $.ajax({
            type: 'POST',
            url: 'controller/ajax/getAreas.php',
            success: function (response) {
                let areas = JSON.parse(response);
                let select = $('#area');
                let idArea = $('#idAreaH').val();
                select.empty(); // Limpia el select para volver a llenarlo
                select.append(`<option value="">Seleccione un departamento</option>`); // Opción predeterminada

                // Asegúrate de que cada atributo se asigne correctamente
                areas.forEach(area => {
                    let selected = (idArea == area.idArea) ? 'selected' : '';
                    select.append(`<option value="${area.idArea}" data-areaCode="${area.areaCode}" ${selected}>${area.nameArea}</option>`);
                });
            },
            error: function () {
                showAlertBootstrap('!Error', 'Hubo un problema al obtener las áreas.');
            }
        });
    }

    // Evento para manejar el cambio de área
    $('#area').on('change', function() {
        let selectedOption = $(this).find(':selected'); // Obtiene la opción seleccionada
        let selectedAreaId = selectedOption.val();
        let areaCode = selectedOption.attr('data-areaCode'); // Utiliza .attr() para acceder al atributo directamente
        let numeroCuenta = $('#numeroCuenta');

        if (selectedAreaId != "") {
            numeroCuenta.prop("disabled", false);
            $('.areaCode').text(areaCode);
            $('.endCode').text('000-000');
        } else {
            numeroCuenta.prop("disabled", true);
            $('.areaCode').text('');
            $('.endCode').text('');
        }
    });

</script>

<?php else: ?>
	<script>
		window.location.href = 'inicio';
	</script>
<?php endif ?>
