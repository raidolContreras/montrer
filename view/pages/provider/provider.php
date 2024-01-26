<!-- Start Main Content Providers -->
<main class="main-content-wrap">
    <div class="col-xl-12">
        <div class="total-browse-content card-box-style single-features">
            <div class="main-title d-flex justify-content-between align-items-center">
                <h3>Lista de proveedores</h3>
                <a class="btn btn-primary" href="registerProvider">Nuevo proveedor</a>
            </div>

            <table class="table table-responsive" id="provider">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Clave del proveedor</th>
                        <th>Representante</th>
                        <th>Contacto</th>
                        <th>Razón Social</th>
                        <th>Dirección Fiscal</th>
                        <th>Datos bancarios</th>
                        <th width="25%"></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</main>
<!-- End Main Content Providers -->
<!-- Disable Provider Modal -->
<div class="modal fade" id="disableProviderModal" tabindex="-1" aria-labelledby="disableProviderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="disableProviderModalLabel">Deshabilitar proveedor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Está seguro de que desea deshabilitar el proveedor <strong id="disableProviderName"></strong>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-warning" data-bs-dismiss="modal" id="confirmDisableProvider">Deshabilitar</button>
            </div>
        </div>
    </div>
</div>
<!-- Enable Provider Modal -->
<div class="modal fade" id="enableProviderModal" tabindex="-1" aria-labelledby="enableProviderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="enableProviderModalLabel">Habilitar proveedor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Está seguro de que desea habilitar el proveedor <strong id="enableProviderName"></strong>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success" data-bs-dismiss="modal" id="confirmEnableProvider">Habilitar</button>
            </div>
        </div>
    </div>
</div>
<!-- Delete Provider Modal -->
<div class="modal fade" id="deleteProviderModal" tabindex="-1" aria-labelledby="deleteProviderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteProviderModalLabel">Eliminar proveedor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Está seguro de que desea eliminar el proveedor <strong id="deleteProviderName"></strong>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="confirmDeleteProvider">Eliminar</button>
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="level" value="<?php echo $_SESSION['level'] ?>">
<script src="assets/js/ajax-js/get-providers.js"></script>
<script src="assets/js/sweetalert2.all.min.js"></script>
