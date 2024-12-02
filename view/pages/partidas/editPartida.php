<?php if ($level == 1): ?>
<!-- Start Main Content Area -->
<main class="main-content-wrap">

    <div class="card-box-style">
        <div class="others-title">
            <h3>Editar partida</h3>
        </div>

        <?php
        // Obtener los parámetros enviados por POST
        $partidaId = isset($_POST['id']) ? $_POST['id'] : '';
        $partidaName = isset($_POST['partida']) ? $_POST['partida'] : '';
        $codigoPartida = isset($_POST['codigoPartida']) ? $_POST['codigoPartida'] : '';
        ?>

        <form class="partida-wrap" id="editPartidaForm">
            <div class="row">
                <input type="hidden" id="partidaId" name="partidaId" value="<?php echo htmlspecialchars($partidaId); ?>">
                
                <div class="col-md-6">
                    <label for="partida" class="form-label">Nombre de la partida<span class="required"></span></label>
                    <input type="text" class="form-control" id="partida" name="partida" 
                           placeholder="Nombre de la partida" 
                           value="<?php echo htmlspecialchars($partidaName); ?>">
                </div>

                <div class="col-md-6">
                    <label for="codigoPartida" class="form-label">Código de la partida<span class="required"></span></label>
                    <input type="text" class="form-control auto-format" id="codigoPartida" name="codigoPartida" 
                           placeholder="Código de la partida" 
                           value="<?php echo htmlspecialchars($codigoPartida); ?>">
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
<script src="assets/js/ajax-js/edit-partida.js"></script>

<?php else: ?>
	<script>
		window.location.href = 'inicio';
	</script>
<?php endif ?>
