<!-- Start Features Area -->
<div class="features-area">
	<div class="container-fluid">
		<div class="row justify-content-center">
				<?php if ($_SESSION['level'] == 1): ?>
					<div class="col-lg-4 col-md-6">
						<a href="exercise" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Ejercicios">
						<div class="single-features">
							<div class="row align-items-center">
								<div class="col-xl-12">
									<div class="single-click-content">
										<span class="features-title">Presupuesto total</span>
										<h3 class="budget"></h3>
										<p class="budget-message"></p>
									</div>
								</div>
							</div>
						</div>
						</a>
					</div>

					<div class="col-lg-4 col-md-6">
						<a href="budgets" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Asignación de presupuestos">
						<div class="single-features">
							<div class="row align-items-center">
								<div class="col-xl-12">
									<div class="single-click-content">
										<span class="features-title">Presupuesto utilizado</span>
										<h3 class="total-use"></h3>
										<p class="budget-message-uses"></p>
									</div>
								</div>
							</div>
						</div>
						</a>
					</div>

					<div class="col-lg-4 col-md-6">
						<a href="exercise" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Ejercicios">
						<div class="single-features">
							<div class="row align-items-center">
								<div class="col-xl-12">
									<div class="single-click-content">
										<span class="features-title">Presupuesto restante</span>
										<h3 class="rest"></h3>
										<p class="budget-message-rest"></p>
									</div>
								</div>
							</div>
						</div>
						</a>
					</div>

					<div class="col-lg-6 col-md-6">
						<a href="budgets" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Asignación de presupuestos">
						<div class="single-features">
							<div class="row align-items-center">
								<div class="col-xl-12">
									<div class="single-click-content">
										<span class="features-title">Presupuesto comprobado</span>
										<h3 class="comp"></h3>
										<p class="budget-message-compr"></p>
									</div>
								</div>
							</div>
						</div>
						</a>
					</div>

					<div class="col-lg-6 col-md-6">
						<a href="budgets" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Asignación de presupuestos">
						<div class="single-features">
							<div class="row align-items-center">
								<div class="col-xl-12">
									<div class="single-click-content">
										<span class="features-title">Presupuesto sin comprobar</span>
										<h3 class="nocomp"></h3>
										<p class="budget-message-no-compr"></p>
									</div>
								</div>
							</div>
						</div>
						</a>
					</div>
				<?php else: ?>
					<div class="overview-area">
						<div class="container-fluid">
							<div class="overview-content-wrap card-box-style">
								<div class="row justify-content-center">
									<div class="overview-content d-flex justify-content-between align-items-center">
									<div class="overview-title">
										<h3>Departamentos asignados</h3>
									</div>
									</div>
								</div>
								<div class="features-area">
									<div class="container-fluid">
										<div class="row justify-content-center dashboard">
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php endif ?>
			</div>
		</div>
	</div>
	<!-- End Features Area -->