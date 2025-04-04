<?php if ($level == 0 || $level == 1): ?>
    <?php if (isset($_GET['exercise'])): ?>
        <!-- Start Main Content Budget -->
        <main class="main-content-wrap">
                <div class="col-xl-12">
                    <div class="total-browse-content card-box-style single-features">
                        <div class="main-title d-flex justify-content-between align-items-center">
                            <h3>Lista de presupuestos asignados</h3>
                            <?php if ($level == 1): ?>
                                <a class="btn btn-primary" href="registerBudgets">Asignar presupuesto</a>
                            <?php endif ?>
                        </div>

                        <table class="table table-responsive" id="budgets">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Departamento</th>
                                    <th>Presupuesto autorizado</th>
                                    <th>Presupuesto solicitado</th>
                                    <th>Presupuesto comprobado</th>
                                    <th>Presupuesto sin comprobar</th>
                                    <th>Partidas</th>
                                    <th>Ejercicio</th>
                                    <th width="15%"></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

            </main>
            <!-- End Main Content Budget -->
        </div>


        <!-- Disable Budget Modal -->
        <div class="modal fade" id="disableBudgetModal" tabindex="-1" aria-labelledby="disableBudgetModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="disableBudgetModalLabel">Deshabilitar presupuesto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>¿Está seguro de que desea deshabilitar el presupuesto asignado a <strong id="disableBudgetName"></strong>?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-success" id="confirmDisableBudget">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enable Budget Modal -->
        <div class="modal fade" id="enableBudgetModal" tabindex="-1" aria-labelledby="enableBudgetModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="enableBudgetModalLabel">Habilitar departamento</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>¿Está seguro de que desea habilitar el departamento <strong id="enableBudgetName"></strong>?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-success" id="confirmEnableBudget">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Budget Modal -->
        <div class="modal fade" id="deleteBudgetModal" tabindex="-1" aria-labelledby="deleteBudgetModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteBudgetModalLabel">Eliminar departamento</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>¿Está seguro de que desea eliminar el departamento <strong id="deleteBudgetName"></strong>?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-success" data-bs-dismiss="modal" id="confirmDeleteBudget">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Budget Modal -->
        <div class="modal fade" id="deletePartidaBudgetModal" tabindex="-1" aria-labelledby="deletePartidaBudgetModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deletePartidaBudgetModalLabel">Eliminar departamento</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>¿Está seguro de que desea eliminar la partida <strong id="deletePartidaBudgetName"></strong>?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-success" data-bs-dismiss="modal" id="confirmDeletePartidaBudget">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" id="exercise" name="exercise" value="<?php echo $_GET['exercise'] ?>">

        <script src="assets/js/ajax-js/get-budgets.js"></script>

        
        
    <?php else: ?>

        <script src="assets/js/ajax-js/exercises-budgets.js"></script>
        
        
    <?php endif ?>

<?php else: ?>
	<script>
		window.location.href = 'inicio';
	</script>
<?php endif ?>