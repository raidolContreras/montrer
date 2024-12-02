<?php if ($level == 1): ?>
<!-- Start Main Content Area -->
<main class="main-content-wrap">

    <div class="card-box-style">
        <div class="others-title">
            <h3>Registrar partida</h3>
        </div>

        <form class="partida-wrap" id="partidaForm">
            <div class="row">
                <div class="col-md-6">
                    <label for="nombrePartida" class="form-label">Nombre de la partida<span class="required"></span></label>
                    <input type="text" class="form-control" id="nombrePartida" name="nombrePartida" placeholder="Nombre de la partida">
                </div>

                <div class="col-md-6">
                    <label for="codigoPartida" class="form-label">Código de la partida<span class="required"></span></label>
                    <input type="text" class="form-control auto-format" id="codigoPartida" name="codigoPartida" placeholder="Código de la partida">
                </div>

                <div class="col-12 mt-2 text-end">
                    <a class="btn btn-danger" id="cancelButton">Cancelar</a>
                    <button type="submit" class="btn btn-success">Aceptar</button>
                </div>
            </div>
        </form>
    </div>

</main>
<!-- End Main Content Area -->
<script src="assets/js/ajax-js/add-partidas.js"></script>

<?php else: ?>
    <script>
        window.location.href = 'inicio';
    </script>
<?php endif ?>
