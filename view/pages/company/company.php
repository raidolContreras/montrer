<?php if ($level  == 1):?>
<?php
    $areas = FormsController::ctrGetAreas();
?>
<!-- Start Main Content Area -->
	<main class="main-content-wrap">
		<div class="col-xl-12">
			<div class="total-browse-content card-box-style single-features">
				<div class="main-title d-flex justify-content-between align-items-center">
					<h3>Lista de empresas</h3>
					<a class="btn btn-primary" href="registerCompany">Registrar empresa</a>
				</div>

				<table class="table table-responsive" id="companies">
					<thead>
						<tr>
							<th>#</th>
							<th>Nombre</th>
							<th>Descripción</th>
							<th></th>
						</tr>
					</thead>
				</table>
			</div>
		</div>

	</main>
	<!-- End Main Content Area -->
</div>

<script src="assets/js/ajax-js/get-companies.js"></script>
<?php else: ?>
	<script>
		window.location.href = 'inicio';
	</script>
<?php endif ?>