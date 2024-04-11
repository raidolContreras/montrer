
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

		<!-- Botones -->
		<script src="assets\vendor\DataTables\Buttons-2.4.2\js\buttons.bootstrap.min.js"></script>
		<script src="assets\vendor\DataTables\JSZip-3.10.1\jszip.min.js"></script>
		<script src="assets\vendor\DataTables\Buttons-2.4.2\js\buttons.html5.min.js"></script>
		<script src="assets\vendor\DataTables\Buttons-2.4.2\js\buttons.print.min.js"></script>

		<!-- PDFMake (para exportar a PDF) -->
		<script src="assets\vendor\DataTables\pdfmake-0.2.7\pdfmake.min.js"></script>
		<script src="assets\vendor\DataTables\pdfmake-0.2.7\vfs_fonts.js"></script>

		<script>
			
			$(function () {
				$('[data-bs-toggle="tooltip"]').tooltip();
			});

			function sustraerLetras(texto) {
				let palabras = texto.split(' ');
				let resultado = '';
				
				// Obtiene la fecha actual en formato 'dd/mm/yyyy'
				let fecha = new Date();
				let dia = ("0" + fecha.getDate()).slice(-2); // Agrega un cero inicial si es necesario
				let mes = ("0" + (fecha.getMonth() + 1)).slice(-2); // Agrega un cero inicial si es necesario
				let año = fecha.getFullYear().toString().substr(-2); // Obtiene los últimos dos dígitos del año
				
				let fechaActual = año + mes + dia;

				if (palabras.length === 1) {
					resultado = palabras[0].slice(0, 3).toUpperCase();
				} else {
					palabras.forEach(palabra => {
						resultado += palabra[0].toUpperCase();
					});
				}

				return resultado + fechaActual;
			}
			
			var modalFooter = $('.modal-footer-extra');
			
			function showAlertBootstrap(title, message) {
				$('#modalLabel').text(title);
				$('.modal-body-extra').html(message);
					modalFooter.html('<button type="button" class="btn btn-success" data-bs-dismiss="modal">Aceptar</button>');
				$('#alertModal').modal('show');
			}
			
			function showAlertBootstrap1(title, message, adress) {
				$('#modalLabel').text(title);
				$('.modal-body-extra').html(message);
					modalFooter.html('<button type="button" class="btn btn-success" onclick="window.location.href=\''+ adress +'\'">Aceptar</button>');
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
				$('.modal-header').html('Asignación de presupuesto');
				$('.modal-footer-extra').html(`
					<button type="button" class="btn btn-danger" onclick="window.location.href=\'inicio\'">Cancelar</button>
					<button class="btn btn-success"onclick="selectedExercise()">Aceptar</button>
				`);
				$('#alertModal').modal('show');
			}

			function logo64(){
				
				var logoBase64 = "data:image/png;base64,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";
				return logoBase64;
			}

		</script>