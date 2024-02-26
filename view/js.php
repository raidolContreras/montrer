
		<!-- Jquery Min JS -->
		<script src="assets/js/jquery.min.js"></script>
		<script src="assets/js/bootstrap.bundle.min.js"></script>
		<script src="assets/js/owl.carousel.min.js"></script>
		<script src="assets/js/metismenu.min.js"></script>
		<script src="assets/js/simplebar.min.js"></script>
		<script src="assets/js/geticons.js"></script>
		<script src="assets/js/calendar.js"></script>
		<script src="assets/js/editor.js"></script>
		<script src="assets/js/form-validator.min.js"></script>
		<script src="assets/js/contact-form-script.js"></script>
		<script src="assets/js/ajaxchimp.min.js"></script>
		<script src="assets/js/custom.js"></script>

		<!-- Datatable Script -->
		<script src="assets/vendor/DataTables/datatables.min.js"></script>
		
		<!-- Dropzone Script -->
		<script src="assets/vendor/dropzone/dropzone-min.js"></script>
		<script>
			
			$(function () {
				$('[data-bs-toggle="tooltip"]').tooltip();
			});
			
			var modalFooter = $('.modal-footer-extra');
			
			function showAlertBootstrap(title, message) {
				$('#modalLabel').text(title);
				$('.modal-body-extra').text(message);
					modalFooter.html('<button type="button" class="btn btn-success" data-bs-dismiss="modal">Aceptar</button>');
				$('#alertModal').modal('show');
			}
			
			function showAlertBootstrap2(title, message, adress) {
				$('#modalLabel').text(title);
				$('.modal-body-extra').text(message);
				$('.modal-footer-extra').html('<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button><button type="button" class="btn btn-success" onclick="window.location.href=\''+ adress +'\'">Aceptar</button>');
				$('#alertModal').modal('show');
			}
			
			function showAlertBootstrap3(title, message, adress, cancel) {
				$('#modalLabel').text(title);
				$('.modal-body-extra').text(message);
				$('.modal-footer-extra').html('<button type="button" class="btn btn-danger" onclick="window.location.href=\''+ cancel +'\'">Cancelar</button><button type="button" class="btn btn-success" onclick="window.location.href=\''+ adress +'\'">Aceptar</button>');
				$('#alertModal').modal('show');
			}
			
			function showAlertBootstrap4(title, message, adress, cancel) {
				$('#modalLabel').text(title);
				$('.modal-body-extra').text(message);
				$('.modal-footer-extra').html('<button type="button" class="btn btn-success" onclick="location.reload()">Aceptar</button>');
				$('#alertModal').modal('show');
			}

			function showAlertBootstrap5(title, htmlText) {
				$('#modalLabel').text(title);
				$('.modal-body-extra').html(htmlText);
				$('.modal-header').html('');
				$('.modal-footer-extra').html(`
					<button type="button" class="btn btn-danger" onclick="window.location.href=\'inicio\'">Cancelar</button>
					<button class="btn btn-success"onclick="window.location.href=\'budgets&exercise=all\'">Vista general</button>
				`);
				$('#alertModal').modal('show');
			}

		</script>