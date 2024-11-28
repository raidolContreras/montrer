<script>
    window.addEventListener('DOMContentLoaded', (event) => {
        const printButton = document.getElementById('btnPrintModal');
        if (printButton) {
            printButton.addEventListener('click', function () {
                const printContents = document.getElementById('verComprovacion').innerHTML;
                const printWindow = window.open('', '', 'height=800,width=600');

                // Copiar todos los estilos CSS de la página principal
                let styles = '';
                for (const styleSheet of document.styleSheets) {
                    try {
                        for (const rule of styleSheet.cssRules) {
                            styles += rule.cssText;
                        }
                    } catch (e) {
                        // Ignorar los errores que vienen de estilos externos de diferentes dominios
                    }
                }

                printWindow.document.write('<html><head><title>Solicitud de Pago</title>');
                printWindow.document.write('<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/5.0.0/css/bootstrap.min.css">');
                printWindow.document.write('<style>' + styles + '</style>');
                printWindow.document.write('<style>');
                printWindow.document.write(`
                    @media print {
                        @page {
                            size: A4;
                            margin: 10mm;
                        }
                        body {
                            -webkit-print-color-adjust: exact;
                            font-size: 12px;
                        }
                        .modal-content {
                            max-width: 100%;
                            width: 100%;
                        }
                        .card-box-style {
                            padding: 0;
                        }
                        .container, .modal-body, .modal-footer, .modal-header {
                            margin: 0;
                            padding: 10px;
                        }
                        .table {
                            font-size: 10px;
                        }
                        .btn, .btn-close {
                            display: none;
                        }
                    }
                `);
                printWindow.document.write('</style></head><body >');
                printWindow.document.write(printContents);
                printWindow.document.write('</body></html>');

                printWindow.document.close();
                printWindow.print();
            });
        }
    });
</script>

<div class="modal fade" id="verComprovacion" tabindex="-1" aria-labelledby="comprobarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
                <button type="button" class="btn btn-primary btn-sm" id="btnPrintModal">
                    <i class="bi bi-printer"></i> Imprimir
                </button>
            <div class="modal-header">
                <h5 class="modal-title" id="comprobarModalLabel">SOLICITUD DE PAGO</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="card-box-style p-4 rounded shadow-sm bg-light">
                <center class="others-title mb-4 row">
                        <h3 class="text-primary col-9">DETALLE DE SOLICITUD</h3>
                        <!-- Fecha de solicitud -->
                        <div class="col row mb-3" style="align-items: center;">
                            <span id="fechaSolicitudGet" style="height: 35px !important" class="form-control col bg-light border" readonly></span>
                        </div>
                </center>
                    <form class="account-wrap" id="budgetRequestForm">
                        <div class="row gy-3">
                            <!-- Solicitante -->
                            <div class="col-md-12 row mb-3" style="align-items: center;">
                                <label for="solicitante" class="form-label col-2 fw-bold">Solicitante:</label>
                                <div style="height: 35px !important" class="form-control d-flex justify-content-between align-items-center col border">
                                    <span id="nombreCompletoGet"></span>
                                </div>
                                <span style="height: 35px !important" class="form-control col" id="idEmployerGet"></span>
                            </div>

                            <!-- Empresa -->
                            <div class="col-md-12 row mb-3" style="align-items: center;">
                                <label for="empresa" class="form-label col-2 fw-bold">Empresa:</label>
                                <span style="height: 35px !important" class="form-control col border" id="empresaGet"></span>
                            </div>

                            <!-- Área de Cargo -->
                            <div class="col-md-12 row mb-3" style="align-items: center;">
                                <label for="area" class="form-label col-2 fw-bold">Área de cargo:</label>
                                <span style="height: 35px !important" class="form-control col border" id="areaGet"></span>
                                <span style="height: 35px !important" class="form-control col" id="idAreaCargoGet"></span>
                            </div>

                            <!-- Cuenta que se afecta -->
                            <div class="col-md-12 row mb-3" style="align-items: center;">
                                <label for="cuentaAfectada" class="form-label col-2 fw-bold">Cuenta que se afecta:</label>
                                <span style="height: 35px !important" class="form-control col border" id="cuentaAfectadaGet"></span>
                                <span style="height: 35px !important" class="form-control col" id="idCuentaAfectadaGet"></span>
                            </div>

                            <!-- Partida que se afecta -->
                            <div class="col-md-12 row mb-3" style="align-items: center;">
                                <label for="partidaAfectada" class="form-label col-2 fw-bold">Partida que se afecta:</label>
                                <span style="height: 35px !important" class="form-control col border" id="partidaAfectadaGet"></span>
                                <span style="height: 35px !important" class="form-control col" id="idPartidaAfectadaGet"></span>
                            </div>

                            <!-- Concepto -->
                            <div class="col-md-12 row mb-3" style="align-items: center;">
                                <label for="concepto" class="form-label col-2 fw-bold">Concepto:</label>
                                <span style="height: 35px !important" class="form-control col border" id="conceptoGet"></span>
                                <span style="height: 35px !important" class="form-control col" id="idConceptoGet"></span>
                            </div>

                            <!-- Importe Solicitado -->
                            <div class="col-md-12 row mb-3" style="align-items: center;">
                                <label for="requestedAmount" class="form-label col-2 fw-bold">Importe solicitado ($):</label>
                                <span id="requestedAmountGet" style="height: 35px !important" class="form-control inputmask col border"></span>
                            </div>

                            <!-- Importe con letra -->
                            <div class="col-md-12 row mb-3" style="align-items: center;">
                                <label for="importeLetra" class="form-label col-2 fw-bold">Importe con letra:</label>
                                <span id="importeLetraGet" style="height: 35px !important" class="form-control col border"></span>
                            </div>

                            <!-- Favor de pagar en -->
                            <div class="col-md-12 row mb-3" style="align-items: center;">
                                <label for="fechaPago" class="form-label col-2 fw-bold">Favor de pagar en:</label>
                                <span id="fechaPagoGet" style="height: 35px !important" class="form-control col border"></span>
                            </div>

                            <!-- Proveedor -->
                            <div class="col-md-12 row mb-3" style="align-items: center;">
                                <label for="providerGet" class="form-label col-2 fw-bold">Proveedor:</label>
                                <span id="providerGet" style="height: 35px !important" class="form-control col border"></span>
                            </div>

                            <!-- Clave interbancaria -->
                            <div class="col-md-12 row mb-3 clabe" style="align-items: center;">
                                <label for="clabe" class="form-label col-2 fw-bold">Clabe interbancaria:</label>
                                <span id="clabeGet" style="height: 35px !important" class="form-control col border"></span>
                            </div>

                            <!-- Banco -->
                            <div class="col-md-12 row mb-3" style="align-items: center;">
                                <label for="bank_name" class="form-label col-2 fw-bold">Banco:</label>
                                <span id="bank_nameGet" style="height: 35px !important" class="form-control col border"></span>
                            </div>

                            <!-- Número de cuenta -->
                            <div class="col-md-12 row mb-3" style="align-items: center;">
                                <label for="account_number" class="form-label col-2 fw-bold">Número de cuenta:</label>
                                <span id="account_numberGet" style="height: 35px !important" class="form-control col border"></span>
                            </div>

                            <!-- Concepto Póliza Contable -->
                            <div class="col-md-12 row mb-3" style="align-items: center;">
                                <label for="conceptoPago" class="form-label col-2 fw-bold">Concepto de pago:</label>
                                <span id="conceptoPagoGet" style="height: 35px !important" class="form-control col border"></span>
                            </div>

                            <div class="col-md-12 row mb-3 foreign-fields" style="display: none; align-items: center;">
                                <label for="swiftCode" class="form-label col-2 fw-bold">Código ABA/SWIFT</label>
                                <span id="swiftCodeGet" style="height: 35px !important" class="form-control col border"></span>
                            </div>

                            <div class="col-md-12 row mb-3 foreign-fields" style="display: none; align-items: center;">
                                <label for="beneficiaryAddress" class="form-label col-2 fw-bold">Domicilio del beneficiario</label>
                                <span id="beneficiaryAddressGet" style="height: 35px !important" class="form-control col border"></span>
                            </div>

                            <div class="col-md-12 row mb-3 foreign-fields" style="display: none; align-items: center;">
                                <label for="currencyType" class="form-label col-2 fw-bold">Tipo de divisa de la cuenta</label>
                                <span id="currencyTypeGet" style="height: 35px !important" class="form-control col border"></span>
                            </div>

                            <!-- Folios consecutivos -->
                            <div class="col-md-12 row mb-3" style="align-items: center;">
                                <label class="form-label col-2 fw-bold">Folio solicitud:</label>
                                <span id="folioGet" style="height: 35px !important" class="form-control col bg-light border"></span>
                            </div>
                            <div class="container my-5">
                                <div class="form-container">
                                    <div class="form-header text-center">
                                        SECCIÓN A CARGO DE CONTABILIDAD Y BANCOS:
                                    </div>
                                    <table class="table table-bordered text-center" style="border-collapse: separate; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <!-- Encabezados agrupados -->
                                            <tr style="background-color: #d9e2ec; font-weight: bold;">
                                                <th>CONTABILIZADO CON PÓLIZA</th>
                                                <th rowspan="2">DETALLES DE LA PÓLIZA</th>
                                                <th rowspan="2">TIPO DE PÓLIZA</th>
                                                <th rowspan="2">CARGO</th>
                                                <th rowspan="2">ABONO</th>
                                            </tr>
                                            <tr style="background-color: #d9e2ec; font-weight: bold;">
                                                <th>CUENTA QUE SE AFECTA</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <span id="cuentaAfectadaCountGet" style="height: 35px !important" class="form-control col"></span>
                                                </td>
                                                <td>
                                                    <span id="polizeTypeGet" style="height: 35px !important" class="form-control col"></span>
                                                </td>
                                                <td>
                                                    <span id="numberPolizeGet" style="height: 35px !important" class="form-control col"></span>
                                                </td>
                                                <td>
                                                    <span id="cargoGet" style="height: 35px !important" class="form-control inputmask col border"></span>
                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span id="partidaAfectadaCountGet" style="height: 35px !important" class="form-control col"></span>
                                                </td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>
                                                    <span id="abonoGet" style="height: 35px !important" class="form-control inputmask col border"></span>
                                                </td>
                                            </tr>
                                            <tr style="background-color: #d9e2ec; font-weight: bold;">
                                                <td>
                                                    ESTATUS:
                                                </td>
                                                <td colspan="2">
                                                    <span id="estatusGet" style="height: 35px !important" class="form-control col border"></span>
                                                </td>
                                                <td>FECHA DE CARGO</td>
                                                <td>
                                                    <span id="fechaCargaGet" style="height: 35px !important" class="form-control col border"></span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="comment mt-5">
                            </div>
                        </div>
                    </form>

                    <!-- Apartado para documentos -->
                    <div class="col-12 mt-4">
                        <h5>Lista de documentos</h5>
                        <ul id="listaDocumentosRequest" class="list-group-ul">
                            <!-- Los documentos se listarán aquí -->
                        </ul>
                    </div>
                </div>
                <div class="modal-footer botones-modal">
                    <a class="btn btn-danger" data-bs-dismiss="modal">Cancelar</a>
                    <button type="button" class="btn btn-warning denegar">Denegar</button>
                    <button type="button" class="btn btn-success aceptar">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
</div>
