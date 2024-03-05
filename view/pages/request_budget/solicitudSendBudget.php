<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
	var $j = jQuery.noConflict();
</script>
<script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js"></script>
<!-- Start Main Content Area -->
<main class="main-content-wrap">
	<div class="card-box-style">
		<div class="others-title">
			<h3>Justificación de Presupuesto</h3>
		</div>
		<form id="budgetRequestForm">
			<div class="row">
				<div class="col-12 mb-3 form-check">
					<input type="radio" class="form-check-input" name="adeudos" id="adeudosSI" value="SI">
					<label class="form-check-label" for="adeudosSI">TIENE ADEUDOS POR COMPROBAR CON MAS DE 8 DIAS</label>
				</div>

				<div class="col-md-6 mb-3">
					<label for="nombreCompleto" class="form-label">Nombre completo solicitante</label>
					<input type="text" class="form-control" id="nombreCompleto" name="nombreCompleto" value="<?php echo $_SESSION['firstname'].' '.$_SESSION['lastname'] ?>" readonly>
				</div>

				<div class="col-md-6 mb-3">
					<label for="fechaSolicitud" class="form-label">Fecha de solicitud</label>
					<input type="date" class="form-control" id="fechaSolicitud" name="fechaSolicitud" required>
				</div>

				<!-- Agregar más campos según tus necesidades -->

				<div class="col-md-6 mb-3">
					<label for="provider" class="form-label">PROVEEDOR</label>
					<select class="form-select" id="provider" name="provider">
					</select>
				</div>

				<div class="col-md-6 mb-3">
					<label for="area" class="form-label">AREA DE CARGO</label>
					<select class="form-select" id="area" name="area">
					</select>
				</div>

				<!-- Agregar más campos según tus necesidades -->

				<div class="col-md-6 mb-3">
					<label for="importeSolicitado" class="form-label">IMPORTE SOLICITADO</label>
					<input type="text" id="importeSolicitado" name="importeSolicitado" class="form-control inputmask" data-inputmask="'alias': 'currency', 'prefix': '$ ', 'placeholder': '0', 'autoUnmask': true, 'removeMaskOnSubmit': true"> 
				</div>

				<div class="col-md-6 mb-3">
					<label for="importeLetra" class="form-label">IMPORTE CON LETRA</label>
					<input type="text" class="form-control" id="importeLetra" name="importeLetra" required>
				</div>

				<!-- Agregar más campos según tus necesidades -->

				<div class="col-12 mb-3 form-check">
					<input type="checkbox" class="form-check-input" id="cheque" name="cheque">
					<label class="form-check-label" for="cheque">CHEQUE</label>
				</div>

				<div class="col-12 mb-3 form-check">
					<input type="checkbox" class="form-check-input" id="transferencia" name="transferencia">
					<label class="form-check-label" for="transferencia">TRANSFERENCIA</label>
				</div>

				<div class="col-md-6 mb-3">
					<label for="chequeNombre" class="form-label">CHEQUE A NOMBRE DE</label>
					<input type="text" class="form-control" id="chequeNombre" name="chequeNombre">
				</div>

				<div class="col-md-6 mb-3">
					<label for="titularCuenta" class="form-label">TITULAR DE LA CUENTA</label>
					<input type="text" class="form-control" id="titularCuenta" name="titularCuenta">
				</div>

				<div class="col-md-6 mb-3">
					<label for="entidadBancaria" class="form-label">ENTIDAD BANCARIA</label>
					<input type="text" class="form-control" id="entidadBancaria" name="entidadBancaria">
				</div>

				<!-- Agregar más campos según tus necesidades -->

				<div class="col-md-6 mb-3">
					<label for="conceptoPago" class="form-label">CONCEPTO DEL PAGO</label>
					<input type="text" class="form-control" id="conceptoPago" name="conceptoPago">
				</div>

				<div class="col-12 mb-3 form-check">
					<input type="radio" class="form-check-input" id="anexaComprobanteSI" name="anexaComprobante" value="SI">
					<label class="form-check-label" for="anexaComprobanteSI">ANEXA COMPROBANTE FISCAL</label>
				</div>

				<div class="col-md-6 mb-3">
					<label for="enviarSolicitud" class="form-label">ENVIAR SOLICITUD:</label>
					<select class="form-select" id="enviarSolicitud" name="enviarSolicitud">
						<option value="SE ENVIO">SE ENVIO</option>
						<option value="NO ENVIADO">NO ENVIADO</option>
					</select>
				</div>

				<div class="col-md-6 mb-3">
					<label for="fechaEnvio" class="form-label">FECHA DE ENVIO</label>
					<input type="date" class="form-control" id="fechaEnvio" name="fechaEnvio">
				</div>

				<div class="col-md-6 mb-3">
					<label for="folioConfirmacion" class="form-label">FOLIO DE CONFIRMACION DE ENVIO DE LA SOLICITUD</label>
					<input type="text" class="form-control" id="folioConfirmacion" name="folioConfirmacion">
				</div>

				<div class="col-12 mt-2 text-end">
					<a class="btn btn-danger" id="cancelButton">Cancelar</a>
					<button type="submit" class="btn btn-success">Aceptar</button>
				</div>
			</div>

		</form>
	</div>

</main>

<!-- Modal para agregar proveedor -->
<div class="modal fade" data-bs-backdrop="static" id="addProviderModal" tabindex="-1" aria-labelledby="addProviderModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xxl">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addProviderModalLabel">Registrar proveedor</h5>
				<button type="button" class="btn-close cancel-provider" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form class="account-wrap mx-5" id="companyForm">
					<div class="row">

						<div class="col-12 mt-4">
							<h4>Proveedor</h4>
						</div>

						<div class="col-md-6">
							<label for="providerKey" class="form-label">Clave del proveedor</label>
							<input type="text" class="form-control" id="providerKey" name="providerKey" readonly>
						</div>
						<div class="col-md-6">
							<label for="representativeName" class="form-label">Nombre del representante<span class="required"></span></label>
							<input type="text" class="form-control" id="representativeName" name="representativeName">
						</div>
						<div class="col-md-6">
							<label for="contactPhone" class="form-label">Teléfono de contacto<span class="required"></span></label>
							<input type="tel" class="form-control" id="contactPhone" name="contactPhone">
						</div>
						<div class="col-md-6">
							<label for="email" class="form-label">Email</label>
							<input type="email" class="form-control" id="email" name="email">
						</div>
						<div class="col-md-6">
							<label for="website" class="form-label">Página web</label>
							<input type="url" class="form-control" id="website" name="website">
						</div>
						<div class="col-md-6">
							<label for="businessName" class="form-label">Razón social<span class="required"></span></label>
							<input type="text" class="form-control" id="businessName" name="businessName">
						</div>
						<div class="col-md-6">
							<label for="rfc" class="form-label">RFC<span class="required"></span></label>
							<input type="text" class="form-control" id="rfc" name="rfc">
						</div>

						<div class="col-12 mt-4">
							<h4>Dirección fiscal</h4>
						</div>

						<div class="col-md-6">
							<label for="fiscalAddressStreet" class="form-label">Calle<span class="required"></span></label>
							<input type="text" class="form-control" id="fiscalAddressStreet" name="fiscalAddressStreet">
						</div>

						<div class="col-md-6">
							<label for="fiscalAddressColonia" class="form-label">Colonia<span class="required"></span></label>
							<input type="text" class="form-control" id="fiscalAddressColonia" name="fiscalAddressColonia">
						</div>

						<div class="col-md-6">
							<label for="fiscalAddressMunicipio" class="form-label">Municipio<span class="required"></span></label>
							<input type="text" class="form-control" id="fiscalAddressMunicipio" name="fiscalAddressMunicipio">
						</div>

						<div class="col-md-6">
							<label for="fiscalAddressEstado" class="form-label">Estado<span class="required"></span></label>
							<input type="text" class="form-control" id="fiscalAddressEstado" name="fiscalAddressEstado">
						</div>

						<div class="col-md-6">
							<label for="fiscalAddressCP" class="form-label">Código Postal<span class="required"></span></label>
							<input type="text" class="form-control" id="fiscalAddressCP" name="fiscalAddressCP">
						</div>

						<div class="col-12 mt-4">
							<h4>Datos bancarios</h4>
						</div>

						<div class="col-md-6">
							<label for="bankName" class="form-label">Nombre de entidad bancaria<span class="required"></span></label>
							<input type="text" class="form-control" id="bankName" name="bankName">
						</div>
						<div class="col-md-6">
							<label for="accountHolder" class="form-label">Titular de la cuenta<span class="required"></span></label>
							<input type="text" class="form-control" id="accountHolder" name="accountHolder">
						</div>
						<div class="col-md-6">
							<label for="accountNumber" class="form-label">Número de cuenta<span class="required"></span></label>
							<input type="text" class="form-control" id="accountNumber" name="accountNumber">
						</div>
						<div class="col-md-6">
							<label for="clabe" class="form-label">CLABE interbancaria</label>
							<input type="text" class="form-control" id="clabe" name="clabe">
						</div>

					</div>
				</form>
			</div>
			<div class="modal-footer">
				<div class="col-12 mt-2 text-end">
					<a class="btn btn-danger cancel-provider">Cancelar</a>
					<button type="submit" class="btn btn-success">Aceptar</button>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="register-value" data-register="<?php echo $_SESSION['idUser']; ?>"></div>
<!-- End Main Content Area -->
<script src="assets/js/ajax-js/add-budget-request.js"></script>


<script>
	$j(document).ready(function() {
		$j('.inputmask').inputmask();
	});
</script>