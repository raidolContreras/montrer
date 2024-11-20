<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>

<div class="modal fade" id="verComprovacion" tabindex="-1" aria-labelledby="comprobarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="comprobarModalLabel">SOLICITUD DE PAGO</h5>
                <button type="button" class="btn btn-primary btn-sm me-2" id="btnPrintModal">
                    <i class="bi bi-printer"></i> Imprimir
                </button>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="card-box-style p-4 rounded shadow-sm bg-light">
                <center class="others-title mb-4 row">
                        <h3 class="text-primary col-10">DETALLE DE SOLICITUD</h3>
                        <!-- Fecha de solicitud -->
                        <div class="col row mb-3" style="align-items: center;">
                            <input type="date" id="fechaSolicitudGet" name="fechaSolicitudGet" class="form-control col bg-light border" value="" readonly>
                        </div>
                </center>
                    <form class="account-wrap" id="budgetRequestForm">
                        <div class="row gy-3">
                            <!-- Solicitante -->
                            <div class="col-md-12 row mb-3" style="align-items: center;">
                                <label for="solicitante" class="form-label col-2 fw-bold">Solicitante:<span class="disabled"></span></label>
                                <div class="form-control d-flex justify-content-between align-items-center col border">
                                    <span id="nombreCompletoGet"></span>
                                </div>
                                <input class="form-control col ms-2" type="text" id="idEmployerGet" name="idEmployerGet" placeholder="1000-001-001-001" disabled>
                            </div>

                            <!-- Empresa -->
                            <div class="col-md-12 row mb-3" style="align-items: center;">
                                <label for="empresa" class="form-label col-2 fw-bold">Empresa:<span class="disabled"></span></label>
                                <input class="form-control col border" type="text" id="empresaGet" name="empresa" placeholder="" disabled>
                            </div>

                            <!-- Área de Cargo -->
                            <div class="col-md-12 row mb-3" style="align-items: center;">
                                <label for="area" class="form-label col-2 fw-bold">Área de cargo:<span class="disabled"></span></label>
                                <input class="form-control col border" type="text" id="areaGet" name="area" placeholder="" disabled>
                                <input class="form-control col ms-2" type="text" id="idAreaCargoGet" name="idAreaCargo" placeholder="5000-001-000-000-000" disabled>
                            </div>

                            <!-- Cuenta que se afecta -->
                            <div class="col-md-12 row mb-3" style="align-items: center;">
                                <label for="cuentaAfectada" class="form-label col-2 fw-bold">Cuenta que se afecta:<span class="disabled"></span></label>
                                <input class="form-control col border" type="text" id="cuentaAfectadaGet" name="cuentaAfectada" placeholder="Ejemplo: Desfiles" disabled>
                                <input class="form-control col ms-2" type="text" id="idCuentaAfectadaGet" name="idCuentaAfectada" placeholder="5000-001-000-000-000" disabled>
                            </div>

                            <!-- Partida que se afecta -->
                            <div class="col-md-12 row mb-3" style="align-items: center;">
                                <label for="partidaAfectada" class="form-label col-2 fw-bold">Partida que se afecta:<span class="disabled"></span></label>
                                <input class="form-control col border" type="text" id="partidaAfectadaGet" name="partidaAfectada" placeholder="Ejemplo: 16-sep" disabled>
                                <input class="form-control col ms-2" type="text" id="idPartidaAfectadaGet" name="idPartidaAfectada" placeholder="5000-001-000-000-000" disabled>
                            </div>

                            <!-- Concepto -->
                            <div class="col-md-12 row mb-3" style="align-items: center;">
                                <label for="concepto" class="form-label col-2 fw-bold">Concepto:<span class="disabled"></span></label>
                                <input class="form-control col border" type="text" id="conceptoGet" name="concepto" placeholder="Ejemplo: Uniformes" disabled>
                                <input class="form-control col ms-2" type="text" id="idConceptoGet" name="idConcepto" placeholder="5000-001-000-000-000" disabled>
                            </div>

                            <!-- Importe Solicitado -->
                            <div class="col-md-12 row mb-3" style="align-items: center;">
                                <label for="requestedAmount" class="form-label col-2 fw-bold">Importe solicitado ($):<span class="disabled"></span></label>
                                <input type="text" id="requestedAmountGet" name="requestedAmount" class="form-control inputmask col border" data-inputmask="'alias': 'currency', 'prefix': '$ ', 'placeholder': '0', 'autoUnmask': true, 'removeMaskOnSubmit': true" disabled>
                            </div>

                            <!-- Importe con letra -->
                            <div class="col-md-12 row mb-3" style="align-items: center;">
                                <label for="importeLetra" class="form-label col-2 fw-bold">Importe con letra:</label>
                                <input type="text" id="importeLetraGet" name="importeLetra" class="form-control col border" disabled>
                            </div>

                            <!-- Fecha compromiso de pago -->
                            <div class="col-md-12 row mb-3" style="align-items: center;">
                                <label for="fechaPago" class="form-label col-2 fw-bold">Fecha compromiso de pago:<span class="disabled"></span></label>
                                <input class="form-control col border" type="date" id="fechaPagoGet" name="fechaPago" disabled>
                            </div>

                            <!-- Proveedor -->
                            <div class="col-md-12 row mb-3" style="align-items: center;">
                                <label for="providerGet" class="form-label col-2 fw-bold">Proveedor:<span class="disabled"></span></label>
                                <select name="providerGet" id="providerGet" class="form-select form-control col" disabled>
                                    <option value="">Seleccionar proveedor</option>
                                </select>
                            </div>

                            <!-- Clave interbancaria -->
                            <div class="col-md-12 row mb-3 clabe" style="align-items: center;">
                                <label for="clabe" class="form-label col-2 fw-bold">Clabe interbancaria:</label>
                                <input type="text" id="clabeGet" name="clabe" class="form-control col border" disabled>
                            </div>

                            <!-- Banco -->
                            <div class="col-md-12 row mb-3" style="align-items: center;">
                                <label for="bank_name" class="form-label col-2 fw-bold">Banco:</label>
                                <input type="text" id="bank_nameGet" name="bank_name" class="form-control col border" disabled>
                            </div>

                            <!-- Número de cuenta -->
                            <div class="col-md-12 row mb-3" style="align-items: center;">
                                <label for="account_number" class="form-label col-2 fw-bold">Número de cuenta:</label>
                                <input type="text" id="account_numberGet" name="account_number" class="form-control col border" disabled>
                            </div>

                            <!-- Concepto Póliza Contable -->
                            <div class="col-md-12 row mb-3" style="align-items: center;">
                                <label for="conceptoPago" class="form-label col-2 fw-bold">Concepto de pago:<span class="disabled"></span></label>
                                <input class="form-control col border" type="text" id="conceptoPagoGet" name="conceptoPago" placeholder="Concepto de pago" disabled>
                            </div>

                            <div class="col-md-12 row mb-3 foreign-fields" style="display: none; align-items: center;">
                                <label for="swiftCode" class="form-label col-2 fw-bold">Código ABA/SWIFT</label>
                                <input type="text" class="form-control col border" id="swiftCodeGet" name="swiftCode" disabled>
                            </div>

                            <div class="col-md-12 row mb-3 foreign-fields" style="display: none; align-items: center;">
                                <label for="beneficiaryAddress" class="form-label col-2 fw-bold">Domicilio del beneficiario</label>
                                <input type="text" class="form-control col border" id="beneficiaryAddressGet" name="beneficiaryAddress" disabled>
                            </div>

                            <div class="col-md-12 row mb-3 foreign-fields" style="display: none; align-items: center;">
                                <label for="currencyType" class="form-label col-2 fw-bold">Tipo de divisa de la cuenta</label>
                                <input type="text" class="form-control col border" id="currencyTypeGet" name="currencyType" disabled>
                            </div>

                            <!-- Folios consecutivos -->
                            <div class="col-md-12 row mb-3" style="align-items: center;">
                                <label class="form-label col-2 fw-bold">Folio solicitud:</label>
                                <span id="folioGet" class="form-control col bg-light border"></span>
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
                                                    <input class="form-control col ms-2" type="text" id="cuentaAfectadaCountGet" name="cuentaAfectadaCount" placeholder="5000-001-000-000-000" disabled>
                                                </td>
                                                <td>
                                                    <input class="form-control col ms-2" type="text" id="polizeTypeGet" name="polizeType" placeholder="EG" disabled>
                                                </td>
                                                <td>
                                                    <input class="form-control col ms-2" type="text" id="numberPolizeGet" name="numberPolize" placeholder="Tipo de póliza" disabled>
                                                </td>
                                                <td>
                                                    <input type="text" id="cargoGet" name="cargo" class="form-control inputmask col border" data-inputmask="'alias': 'currency', 'prefix': '$ ', 'placeholder': '0', 'autoUnmask': true, 'removeMaskOnSubmit': true" disabled>
                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input class="form-control col ms-2" type="text" id="partidaAfectadaCountGet" name="partidaAfectadaCount" placeholder="1000-001-001-001" disabled>
                                                </td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>
                                                    <input type="text" id="abonoGet" name="abono" class="form-control inputmask col border" data-inputmask="'alias': 'currency', 'prefix': '$ ', 'placeholder': '0', 'autoUnmask': true, 'removeMaskOnSubmit': true" disabled>
                                                </td>
                                            </tr>
                                            <tr style="background-color: #d9e2ec; font-weight: bold;">
                                                <td>
                                                    ESTATUS:
                                                </td>
                                                <td colspan="2">
                                                    <select id="estatusGet" name="estatus" class="form-select col border" disabled>
                                                        <option value="pendiente_de_pago">Pendiente de pago</option>
                                                        <option value="denegado">Denegado</option>
                                                        <option value="pagado">Pagado</option>
                                                    </select>
                                                </td>
                                                <td>FECHA DE CARGO</td>
                                                <td>
                                                    <input class="form-control col border" type="date" id="fechaCargaGet" name="fechaCargaGet" disabled>
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
<script>
document.getElementById("btnPrintModal").addEventListener("click", function () {
    const modalContent = document.querySelector(".modal-content");

    if (!modalContent) {
        console.error("El elemento modal-content no existe en el DOM.");
        alert("No se encontró el contenido del modal.");
        return;
    }

    html2canvas(modalContent, {
        scale: 2,
        useCORS: true,
        allowTaint: true,
    })
        .then((canvas) => {
            const imgData = canvas.toDataURL("image/png");

            const pdf = new jspdf.jsPDF({
                orientation: "portrait",
                unit: "px",
                format: "a4",
            });

            const pdfWidth = pdf.internal.pageSize.getWidth();
            const pdfHeight = (canvas.height * pdfWidth) / canvas.width;

            pdf.addImage(imgData, "PNG", 0, 0, pdfWidth, pdfHeight);
            pdf.save("Solicitud_Pago.pdf");
        })
        .catch((error) => {
            console.error("Error generando el PDF:", error);
            alert("Ocurrió un error al generar el PDF. Verifica la consola para más detalles.");
        });
});
</script>