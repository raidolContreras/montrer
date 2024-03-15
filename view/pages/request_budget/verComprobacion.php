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
                            <input type="text" class="form-control" id="nombreCompletoGet" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="fechaSolicitudGet" class="form-label">Fecha de Solicitud</label>
                            <input type="text" class="form-control" id="fechaSolicitudGet" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="providerGet" class="form-label">Proveedor</label>
                            <input type="text" class="form-control" id="providerGet" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="areaGet" class="form-label">Departamento</label>
                            <input type="text" class="form-control" id="areaGet" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="importeSolicitadoGet" class="form-label">Importe Solicitado</label>
                            <input type="text" class="form-control" id="importeSolicitadoGet" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="importeLetraGet" class="form-label">Importe en Letra</label>
                            <input type="text" class="form-control" id="importeLetraGet" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="titularCuentaGet" class="form-label">Titular de la Cuenta</label>
                            <input type="text" class="form-control" id="titularCuentaGet" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="entidadBancariaGet" class="form-label">Entidad Bancaria</label>
                            <input type="text" class="form-control" id="entidadBancariaGet" readonly>
                        </div>
                        <div class="col-12">
                            <label for="conceptoPagoGet" class="form-label">Concepto de Pago</label>
                            <input type="text" class="form-control" id="conceptoPagoGet" readonly>
                        </div>
                        <!-- Apartado para documentos -->
                        <div class="col-12 mt-4">
                            <h5>Lista de documentos</h5>
                            <ul id="listaDocumentos" class="list-group-ul">
                                <!-- Los documentos se listarán aquí -->
                            </ul>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <a class="btn btn-danger" data-bs-dismiss="modal">Cancelar</a>
                <button type="submit" class="btn btn-success">Aceptar</button>
            </div>
        </div>
    </div>
</div>

<script src="assets/js/ajax-js/get-comprobantes.js"></script>
