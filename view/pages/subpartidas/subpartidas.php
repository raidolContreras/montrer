<?php
if ($level  == 0 || $level == 1):
    $departamentos = FormsController::ctrGetAreas();
?>

    <!-- Start Main Content Partidas -->
    <main class="main-content-wrap">
        <div class="col-xl-12">
            <div class="total-browse-content card-box-style single-features">
                <div class="main-title d-flex justify-content-between align-items-center">
                    <h3>Lista de subpartidas</h3>
                    <?php if ($level == 1): ?>
                        <!-- boton registro de subpartida -->

                        <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#registerSubPartidaModal">Nueva subpartida</a>
                    <?php endif ?>
                </div>

                <table class="table table-responsive" id="subpartidas">
                    <thead>
                    </thead>
                </table>
            </div>
        </div>

    </main>
    <!-- End Main Content Partidas -->
    </div>

    <!-- modal crear subpartida -->
    <div class="modal fade" id="registerSubPartidaModal" tabindex="-1" aria-labelledby="registerSubPartidaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registerSubPartidaModalLabel">Nueva subpartida</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="registerSubPartidaForm">
                        <div class="form-group mb-3">
                            <label for="nombreSubpartida">Nombre de la subpartida</label>
                            <input type="text" class="form-control" id="nombreSubpartida" required>
                        </div>
                        <div class="form-group">
                            <label for="departamento">Departamento</label>
                            <select class="form-select" id="departamento" required>
                                <option value="">Seleccione un departamento</option>
                                <?php foreach ($departamentos as $departamento): ?>
                                    <option value="<?php echo $departamento['idArea']; ?>"><?php echo $departamento['nameArea']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success">Aceptar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/ajax-js/subpartidas.js"></script>

<?php else: ?>
    <script>
        window.location.href = 'inicio';
    </script>
<?php endif ?>