<?php if ($level != 2): ?>

	<!-- Start Main Content Partidas -->
	<main class="main-content-wrap">
		<div class="col-xl-12">
			<div class="total-browse-content card-box-style single-features">
				<div class="main-title d-flex justify-content-between align-items-center">
					<h3>Lista de partidas</h3>
                    <?php if ($level == 1): ?>
                        <a class="btn btn-primary" href="registerPartida">Nueva partida</a>
                    <?php endif ?>
				</div>

				<table class="table table-responsive" id="partidas">
					<thead>
					</thead>
				</table>
			</div>
		</div>

	</main>
	<!-- End Main Content Partidas -->
</div>

<!-- Delete Partida Modal -->
<div class="modal fade" id="deletePartidaModal" tabindex="-1" aria-labelledby="deletePartidaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deletePartidaModalLabel">Eliminar partida</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Está seguro de que desea eliminar la partida <strong id="deletePartidaName"></strong>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success" data-bs-dismiss="modal" id="confirmDeletePartida">Aceptar</button>
            </div>
        </div>
    </div>
</div>

<script src="assets/js/ajax-js/get-partidas.js"></script>

<?php else: ?>
	<script>
		window.location.href = 'inicio';
	</script>
<?php endif ?>
