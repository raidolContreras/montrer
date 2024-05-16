<div class="modal fade" id="verComprobacion" tabindex="-1" aria-labelledby="comprobarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="comprobarModalLabel">Comprobante de Presupuesto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="budgetRequestForm">
                    <div class="row g-3">
                        <!-- Campos de información -->
                        <div class="col-md-6">
                            <label for="nombreCompletoGet" class="form-label">Nombre Completo</label>
                            <input type="text" class="form-control" id="nombreCompletoGet" disabled>
                        </div>
                        <div class="col-md-6">
                            <label for="fechaSolicitudGet" class="form-label">Fecha de Solicitud</label>
                            <input type="text" class="form-control" id="fechaSolicitudGet" disabled>
                        </div>
                        <div class="col-md-6">
                            <label for="providerGet" class="form-label">Proveedor</label>
                            <input type="text" class="form-control" id="providerGet" disabled>
                        </div>
                        <div class="col-md-6">
                            <label for="areaGet" class="form-label">Departamento</label>
                            <input type="text" class="form-control" id="areaGet" disabled>
                        </div>
                        <div class="col-md-6">
                            <label for="importeSolicitadoGet" class="form-label">Importe Solicitado</label>
                            <input type="text" class="form-control" id="importeSolicitadoGet" disabled>
                        </div>
                        <div class="col-md-6">
                            <label for="importeLetraGet" class="form-label">Importe en Letra</label>
                            <input type="text" class="form-control" id="importeLetraGet" disabled>
                        </div>
                        <div class="col-md-6">
                            <label for="titularCuentaGet" class="form-label">Titular de la Cuenta</label>
                            <input type="text" class="form-control" id="titularCuentaGet" disabled>
                        </div>
                        <div class="col-md-6">
                            <label for="entidadBancariaGet" class="form-label">Entidad Bancaria</label>
                            <input type="text" class="form-control" id="entidadBancariaGet" disabled>
                        </div>
                        <div class="col-12">
                            <label for="conceptoPagoGet" class="form-label">Concepto de Pago</label>
                            <input type="text" class="form-control" id="conceptoPagoGet" disabled>
                        </div>
                        <div class="comment mt-5">
                        </div>
                        <!-- Apartado para documentos -->
                        <div class="col-12 mt-4">
                            <h5>Lista de documentos</h5>
                            <ul id="listaDocumentosRequest" class="list-group-ul">
                                <!-- Los documentos se listarán aquí -->
                            </ul>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer botones-modal">
                <a class="btn btn-danger" data-bs-dismiss="modal">Cancelar</a>
                <button type="button" class="btn btn-warning denegar">Denegar</button>
                <button type="button" class="btn btn-success aceptar">Aceptar</button>
            </div>
        </div>
    </div>
</div>

<script src="assets/js/ajax-js/get-comprobantes.js"></script>
