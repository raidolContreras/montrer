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

<!-- Modal para ver conceptos -->
<div class="modal fade" id="viewConceptsModal" tabindex="-1" aria-labelledby="viewConceptsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewConceptsModalLabel">Conceptos de la partida: <span id="viewConceptsName"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Botón para agregar nuevo concepto -->
                <button id="addConceptButton" class="btn btn-success w-100 mt-3">Agregar nuevo concepto</button>

                <!-- Mensaje cuando no hay conceptos -->
                <p id="noConceptsMessage" class="text-center text-muted" style="display: none;">No hay conceptos registrados para esta partida.</p>
                
                <!-- Tabla para mostrar conceptos -->
                <div id="conceptosContainer" style="display: none;">
                    <table class="table table-striped table-hover" id="conceptosTable">
                        <input type="hidden" name="partidaId" id="partidaId" >
                        <input type="hidden" name="partidaCode" id="partidaCode" >
                        <thead>
                            <tr>
                                <th>Concepto</th>
                                <th>Número de Concepto</th>
                            </tr>
                        </thead>
                        <tbody id="conceptosTableBody">
                            <!-- Contenido dinámico -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
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
