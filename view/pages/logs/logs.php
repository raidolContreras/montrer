<?php if ($_SESSION['level']  == 1):?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/locale/es.js"></script>
<!-- Start Main Content Area -->
	<main class="main-content-wrap">
		<div class="col-xl-12">
			<div class="total-browse-content card-box-style single-features">
				<div class="main-title align-items-center logs">
				</div>

				<table class="table" id="Logs">
					<thead>
						<tr>
							<th>#</th>
							<th>Acción</th>
							<th>Dirección IP</th>
							<th>Hora</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>

	</main>
	<!-- End Main Content Area -->
</div>
<div id="register-value" data-register="<?php echo $_GET['user']; ?>"></div>

<script src="assets/js/ajax-js/get-logs.js"></script>
<?php else: ?>
	<script>
		window.location.href = 'registers';
	</script>
<?php endif ?>
