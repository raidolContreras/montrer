<script src="assets/js/ajax-js/get-comprobantes.js"></script>
<div class="modal fade" id="completarModal" tabindex="-1" aria-labelledby="comprobarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="comprobarModalLabel">Completar presupuesto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card-box-style p-4 rounded shadow-sm bg-light">
                    <center class="others-title mb-4">
                        <h3 class="text-primary">SOLICITUD DE PAGO</h3>
                    </center>

                    <form class="account-wrap" id="completeRequestForm">
                        <div class="row gy-3">

                            <!-- Solicitante -->
                            <div class="col-md-12 row mb-3" style="align-items: center;">
                                <label for="solicitante" class="form-label col-2 fw-bold">Solicitante:<span class="required"></span></label>
                                <div class="form-control d-flex justify-content-between align-items-center col bg-white border">
                                    <span id="solicitante_nombre"></span>
                                </div>
                                <input type="hidden" name="solicitante_nombre" value="">
                                <input class="form-control col ms-2 auto-format" type="text" id="idEmployer" name="idEmployer" placeholder="1000-001-001-001" required>
                            </div>

                            <!-- Empresa -->
                            <div class="col-md-12 row mb-3" style="align-items: center;">
                                <label for="empresa" class="form-label col-2 fw-bold">Empresa:<span class="required"></span></label>
                                <input class="form-control col bg-white border" type="text" id="empresa" name="empresa" placeholder="" required>
                            </div>

                            <!-- Área de Cargo -->
                            <div class="col-md-12 row mb-3" style="align-items: center;">
                                <label for="area" class="form-label col-2 fw-bold">Área de Cargo:<span class="required"></span></label>
                                <input class="form-control col bg-white border" type="text" id="area" name="area" readonly>
                                <input class="form-control col ms-2 auto-format2" type="text" id="idAreaCargo" name="idAreaCargo" placeholder="5000-001-000-000-000" required>
                            </div>

                            <!-- Cuenta que se afecta -->
                            <div class="col-md-12 row mb-3" style="align-items: center;">
                                <label for="cuentaAfectada" class="form-label col-2 fw-bold">Cuenta que se afecta:<span class="required"></span></label>
                                <input class="form-control col bg-white border" type="text" id="cuentaAfectada" name="cuentaAfectada" placeholder="Ejemplo: Ejemplo: Desfiles" required>
                                <input class="form-control col ms-2 auto-format2" type="text" id="idCuentaAfectada" name="idCuentaAfectada" placeholder="5000-001-000-000-000" required>
                            </div>

                            <!-- Partida que se afecta -->
                            <div class="col-md-12 row mb-3" style="align-items: center;">
                                <label for="partidaAfectada" class="form-label col-2 fw-bold">Partida que se afecta:<span class="required"></span></label>
                                <input class="form-control col bg-white border" type="text" id="partidaAfectada" name="partidaAfectada" placeholder="Ejemplo: 16-sep" required>
                                <input class="form-control col ms-2 auto-format2" type="text" id="idPartidaAfectada" name="idPartidaAfectada" placeholder="5000-001-000-000-000" required>
                            </div>

                            <!-- Concepto -->
                            <div class="col-md-12 row mb-3" style="align-items: center;">
                                <label for="concepto" class="form-label col-2 fw-bold">Concepto:<span class="required"></span></label>
                                <input class="form-control col bg-white border" type="text" id="concepto" name="concepto" placeholder="Ejemplo: Uniformes" required>
                                <input class="form-control col ms-2 auto-format2" type="text" id="idConcepto" name="idConcepto" placeholder="5000-001-000-000-000" required>
                            </div>

                            <!-- Importe Solicitado -->
                            <div class="col-md-12 row mb-3" style="align-items: center;">
                                <label for="requestedAmount" class="form-label col-2 fw-bold">Importe Solicitado ($):<span class="required"></span></label>
                                <input type="text" id="requestedAmount" name="requestedAmount" class="form-control inputmask col bg-white border" data-inputmask="'alias': 'currency', 'prefix': '$ ', 'placeholder': '0', 'autoUnmask': true, 'removeMaskOnSubmit': true">
                            </div>

                            <!-- Importe con letra -->
                            <div class="col-md-12 row mb-3" style="align-items: center;">
                                <label for="importeLetra" class="form-label col-2 fw-bold">Importe con letra:</label>
                                <input type="text" id="importeLetra" name="importeLetra" class="form-control col bg-light border" required>
                            </div>

                            <!-- Fecha compromiso de pago -->
                            <div class="col-md-12 row mb-3" style="align-items: center;">
                                <label for="fechaPago" class="form-label col-2 fw-bold">Fecha Compromiso de Pago:<span class="required"></span></label>
                                <input class="form-control col bg-light border" type="date" id="fechaPago" name="fechaPago" required>
                            </div>

                            <!-- Proveedor -->
                            <div class="col-md-12 row mb-3" style="align-items: center;">
                                <label for="provider" class="form-label col-2 fw-bold">Proveedor:<span class="required"></span></label>
                                <select name="provider" id="provider" class="form-select form-control col" readonly>
                                    <option value="">Seleccionar proveedor</option>
                                </select>
                            </div>

                            <!-- Clave interbancaria -->
                            <div class="col-md-12 row mb-3" style="align-items: center;">
                                <label for="clabe" class="form-label col-2 fw-bold">Clave Interbancaria:</label>
                                <input type="text" id="clabe" name="clabe" class="form-control col bg-light border" readonly>
                            </div>

                            <!-- Banco -->
                            <div class="col-md-12 row mb-3" style="align-items: center;">
                                <label for="bank_name" class="form-label col-2 fw-bold">Banco:</label>
                                <input type="text" id="bank_name" name="bank_name" class="form-control col bg-light border" readonly>
                            </div>

                            <!-- Numero de cuenta -->
                            <div class="col-md-12 row mb-3" style="align-items: center;">
                                <label for="account_number" class="form-label col-2 fw-bold">Número de Cuenta:</label>
                                <input type="text" id="account_number" name="account_number" class="form-control col bg-light border" readonly>
                            </div>

                            <div class="col-md-12 row mb-3 foreign-fields" style="display: none; align-items: center;">
                                <label for="swiftCode" class="form-label col-2 fw-bold">Código ABA/SWIFT</label>
                                <input type="text" class="form-control col bg-light border" id="swiftCode" name="swiftCode" readonly>
                            </div>
                            <div class="col-md-12 row mb-3 foreign-fields" style="display: none; align-items: center;">
                                <label for="beneficiaryAddress" class="form-label col-2 fw-bold">Domicilio del beneficiario</label>
                                <input type="text" class="form-control col bg-light border" id="beneficiaryAddress" name="beneficiaryAddress" readonly>
                            </div>
                            <div class="col-md-12 row mb-3 foreign-fields" style="display: none; align-items: center;">
                                <label for="currencyType" class="form-label col-2 fw-bold">Tipo de divisa de la cuenta</label>
                                <input type="text" class="form-control col bg-light border" id="currencyType" name="currencyType" readonly>
                            </div>

                            <!-- Concepto Póliza Contable -->
                            <div class="col-md-12 row mb-3" style="align-items: center;">
                                <label for="conceptoPago" class="form-label col-2 fw-bold">Concepto de pago:<span class="required"></span></label>
                                <input class="form-control col bg-white border" type="text" id="conceptoPago" name="conceptoPago" placeholder="Concepto de pago" required>
                            </div>

                            <!-- Folios consecutivos -->
                            <div class="col-md-12 row mb-3" style="align-items: center;">
                                <label class="form-label col-2 fw-bold">Folio solicitud:</label>
                                <span id="folio" class="form-control col bg-light border"></span>
                                <input type="hidden" name="folio">
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
                                                <th rowspan="2">TIPO DE PÓLIZA</th>
                                                <th rowspan="2">POLIZA NUMERO</th>
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
                                                    <input class="form-control col ms-2 auto-format2" type="text" id="cuentaAfectadaCount" name="cuentaAfectadaCount" placeholder="5000-001-000-000-000">
                                                </td>
                                                <td>
                                                    <input class="form-control col ms-2" type="text" id="polizeType" name="polizeType" placeholder="Tipo de póliza">
                                                </td>
                                                <td>
                                                    <input class="form-control col ms-2" type="text" id="numberPolize" name="numberPolize" placeholder="Número de póliza">
                                                </td>
                                                <td>
                                                    <input type="text" id="cargo" name="cargo" class="form-control inputmask col border" data-inputmask="'alias': 'currency', 'prefix': '$ ', 'placeholder': '0', 'autoUnmask': true, 'removeMaskOnSubmit': true">
                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input class="form-control col ms-2 auto-format" type="text" id="partidaAfectadaCount" name="partidaAfectadaCount" placeholder="1000-001-001-001">
                                                </td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>
                                                    <input type="text" id="abono" name="abono" class="form-control inputmask col border" data-inputmask="'alias': 'currency', 'prefix': '$ ', 'placeholder': '0', 'autoUnmask': true, 'removeMaskOnSubmit': true">
                                                </td>
                                            </tr>
                                            <tr style="background-color: #d9e2ec; font-weight: bold;">
                                                <td>
                                                    ESTATUS:
                                                </td>
                                                <td colspan="2">
                                                    <select id="estatus" name="estatus" class="form-select col border">
                                                        <option value="pendiente_de_pago">Pendiente de pago</option>
                                                        <option value="denegado">Denegado</option>
                                                        <option value="pagado">Pagado</option>
                                                    </select>
                                                </td>
                                                <td>FECHA DE CARGO</td>
                                                <td>
                                                    <input class="form-control col border" type="date" id="fechaCarga" name="fechaCarga">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <input type="hidden" id="idRequest">

                        </div>
                    </form>
                </div>

                <div class="modal-footer marcar-footer">
                    <!-- Botones de Aceptar/Cancelar -->
                    <div class="col-md-12 row mt-4 text-end" style="align-items: center;">
                        <button class="btn btn-danger col-2 mx-3" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-success col-2 completeRequest">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js"></script>
<script>
    var $j = jQuery.noConflict();
    
    $j(document).ready(function() {
        $j('.inputmask').inputmask();
    });
    
    $('.auto-format').on('input', function () {
        let input = $(this).val().replace(/\D/g, ''); // Elimina cualquier carácter no numérico
        let formatted = '';

        // Aplica el formato 1000-001-001-001
        if (input.length > 4) {
            formatted += input.substring(0, 4) + '-';
            if (input.length > 7) {
                formatted += input.substring(4, 7) + '-';
                if (input.length > 10) {
                    formatted += input.substring(7, 10) + '-';
                    formatted += input.substring(10, 13);
                } else {
                    formatted += input.substring(7);
                }
            } else {
                formatted += input.substring(4);
            }
        } else {
            formatted = input;
        }

        $(this).val(formatted);
    });

    $('.auto-format2').on('input', function () {
        console.log('a');
        let input = $(this).val().replace(/\D/g, ''); // Elimina cualquier carácter no numérico
        let formatted = '';

        // Aplica el formato 1000-001-001-001
        if (input.length > 4) {
            formatted += input.substring(0, 4) + '-';
            if (input.length > 7) {
                formatted += input.substring(4, 7) + '-';
                if (input.length > 10) {
                    formatted += input.substring(7, 10) + '-';
                    if (input.length > 13) {
                        formatted += input.substring(10, 13) + '-';
                        formatted += input.substring(13, 16);
                    } else {
                        formatted += input.substring(10);
                    }
                } else {
                    formatted += input.substring(7);
                }
            } else {
                formatted += input.substring(4);
            }
        } else {
            formatted = input;
        }

        $(this).val(formatted);
    });

    function numeroALetra(numero, status) {
        var unidades = ['', 'un', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete', 'ocho', 'nueve'];
        var especiales = ['diez', 'once', 'doce', 'trece', 'catorce', 'quince', 'dieciséis', 'diecisiete', 'dieciocho', 'diecinueve'];
        var decenas = ['', 'diez', 'veinte', 'treinta', 'cuarenta', 'cincuenta', 'sesenta', 'setenta', 'ochenta', 'noventa'];
        var centenas = ['', 'ciento', 'doscientos', 'trescientos', 'cuatrocientos', 'quinientos', 'seiscientos', 'setecientos', 'ochocientos', 'novecientos'];

        var texto = '';

        var entero = Math.floor(numero);
        var decimal = Math.round((numero - entero) * 100);

        if (entero === 0) {
            texto = 'cero';
        } else {
            // Parte entera
            if (entero >= 1000000) {
                let millones = Math.floor(entero / 1000000);
                texto += millones === 1 ? 'un millón ' : numeroALetra(millones, false) + ' millones ';
                entero %= 1000000;
            }

            if (entero >= 1000) {
                let miles = Math.floor(entero / 1000);
                texto += miles === 1 ? 'mil ' : numeroALetra(miles, false) + ' mil ';
                entero %= 1000;
            }

            if (entero >= 100) {
                texto += (entero === 100 ? 'cien' : centenas[Math.floor(entero / 100)]) + ' ';
                entero %= 100;
            }

            if (entero >= 20) {
                texto += decenas[Math.floor(entero / 10)];
                if (entero % 10 !== 0) {
                    texto += (entero >= 30 ? ' y ' : '') + unidades[entero % 10];
                }
                entero = 0; // Se procesó toda la parte de decenas
            }

            if (entero >= 10) {
                texto += especiales[entero - 10];
                entero = 0; // No hay centavos si el número es un número especial
            }

            if (entero > 0) {
                texto += unidades[entero];
            }
        }

        // Centavos
        if (decimal > 0) {
            texto += (texto ? ' ' : '') + (decimal === 1 ? 'pesos con un centavo' : 'pesos con ' + numeroALetra(decimal, false) + ' centavos');
        } else {
            if (status) {	
                texto += ' pesos';
            }
        }
        
        // Ajustes de formato final: eliminar espacios duplicados y capitalizar
        texto = texto.replace(/\s+/g, ' ').trim().replace(/^./, function(str) {
            return str.toUpperCase();
        });

        return texto;
    }

    $('.completeRequest').on('click', function() {

        // Capturamos todos los campos habilitados usando serialize()
        var formData = $('#completeRequestForm').serializeArray();

        // Añadir "idUser" del atributo "data-register" de #register-value
        formData.push({
            name: 'idRequest',
            value: $('#idRequest').val()
        });
        
        // Convertir a un objeto más fácil de manejar
        var formDataObject = formData.reduce(function (acc, field) {
            acc[field.name] = field.value;
            return acc;
        }, {});

        // Llamar a la función que envía la solicitud AJAX
        $.ajax({
            type: 'POST',
            url: 'controller/ajax/completeRequest.php',
            data: formDataObject,
            dataType: '',
            success: function (response) {
                if (response == 'success') {
                    // cerrar modal de completado
                    $('#completarModal').modal('hide');
                    showAlertBootstrap('¡Éxito!', 'Solicitud completada correctamente');
                    // reiniciar datatable
                    $('#requests').DataTable().ajax.reload();
                }
            }
        });

    });

    function completeRequest(idRequest) {
        $.ajax({
            type: 'POST',
            url: 'controller/ajax/getRequest.php',
            data: { idRequest: idRequest },
            dataType: 'json',
            success: function (response) {
                // Mostrar modal
                $('#completarModal').modal('show');
                
                // Llenar los campos del formulario con los datos de la respuesta
                $('#budgetRequestForm input[name="solicitante_nombre"]').val(response.solicitante_nombre || '');
                $('#solicitante_nombre').text(response.solicitante_nombre || '');
                $('#idEmployer').val(response.idEmployer || '');
                $('#empresa').val(response.empresa || '');
                $('#idAreaCargo').val(response.idAreaCargo || '');
                $('#cuentaAfectada').val(response.cuentaAfectada || '');
                $('#idCuentaAfectada').val(response.idCuentaAfectada || '');
                $('#partidaAfectada').val(response.partidaAfectada || '');
                $('#idPartidaAfectada').val(response.idPartidaAfectada || '');
                $('#concepto').val(response.concepto || '');
                $('#idConcepto').val(response.idConcepto || '');
                $('#requestedAmount').val(response.importe_solicitado || '');
                $('#importeLetra').val(response.importe_letra || '');
                $('#fechaPago').val(response.fecha_pago || '');
                $('#provider').val(response.idProvider || ''); // Ajusta según el value de los options
                $('#clabe').val(response.clabe || '');
                $('#bank_name').val(response.banco || '');
                $('#account_number').val(response.numero_cuenta || '');
                $('#swiftCode').val(response.swift_code || '');
                $('#beneficiaryAddress').val(response.beneficiario_direccion || '');
                $('#currencyType').val(response.tipo_divisa || '');
                $('#conceptoPago').val(response.concepto_pago || '');
                $('#folio').text(response.folio || '');
                $('#budgetRequestForm input[name="folio"]').val(response.folio || '');
                $('#idRequest').val(response.idRequest || '');
                console.log(response.paymentDate);
                $('#fechaCarga').val(response.paymentDate || '');

                //busca el area con un ajax
                $.ajax({
                    type: 'POST',
                    url: 'controller/ajax/getArea.php',
                    data: { register: response.idArea },
                    dataType: 'json',
                    success: function (response) {
                        $('#area').val(response.nameArea);
                    },
                    error: function (error) {
                        console.log('Error en la solicitud AJAX:', error);
                    }
                });

                // Manejar campos condicionales, como divisas extranjeras
                if (response.tipo_divisa) {
                    $('.foreign-fields').show();
                } else {
                    $('.foreign-fields').hide();
                }
            },
            error: function (error) {
                console.log('Error en la solicitud AJAX:', error);
            }
        });
    }

</script>