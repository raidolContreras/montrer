

	<!-- Start Overview Area -->
	<div class="overview-area">
		<div class="container-fluid">
			<div class="row justify-content-center">
				<?php if ($level == 1): ?>
				<div class="col-lg-12">
					<div class="overview-content-wrap card-box-style">
						<div class="overview-content d-flex justify-content-between align-items-center">
							<div class="overview-title">
								<h3>Datos generales</h3>
							</div>
						</div>
							<div class="audience-content-wrap">
								<div class="row justify-content-center">
									<div class="col-lg-4 col-sm-6">
									<a href="registers" data-bs-toggle="tooltip" data-bs-placement="top" title="Registros">
										<div class="single-audience d-flex justify-content-between align-items-center">
											<div class="audience-content">
												<h5>Usuarios</h5>
												<h4 class="count-user"></h4>
											</div>
											<div class="icon">
												<img src="assets/img/svg/white-profile-2user.svg" alt="white-profile-2user">
											</div>
										</div>
									</a>
									</div>

									<div class="col-lg-4 col-sm-6">
									<a href="areas" data-bs-toggle="tooltip" data-bs-placement="top" title="Departamentos">
										<div class="single-audience d-flex justify-content-between align-items-center">
											<div class="audience-content">
												<h5>Departamentos</h5>
												<h4 class="count-area"></h4>
											</div>
											<div class="icon">
												<img src="assets/img/svg/area.svg" alt="eye" style="filter: brightness(100)">
											</div>
										</div>
									</a>
									</div>

									<div class="col-lg-4 col-sm-6">
									<a href="exercise" data-bs-toggle="tooltip" data-bs-placement="top" title="Ejercicios">
										<div class="single-audience d-flex justify-content-between align-items-center">
											<div class="audience-content color-style-fe5957">
												<h5>Ejercicio actual</h5>
												<h4 class="exercise"></h4>
											</div>
											<div class="icon">
												<img src="assets/img/svg/mask.svg" alt="mask">
											</div>
										</div>
									</a>
									</div>
								</div>

								<div class="audience-chart">
									<div id="overview_chart"></div>
								</div>
							</div>
						</div>
					</div>
				<?php endif ?>
				
<?php if ($level == 1): ?>
	<script src="assets/js/ajax-js/counts.js"></script>
<?php else: ?>
	<input type="hidden" name="user" value="<?php echo $_SESSION['idUser'] ?>">
	<script src="assets/js/ajax-js/count.js"></script>
<?php endif ?>