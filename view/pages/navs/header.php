<?php

	if (!isset($_SESSION['sesion']) && $_GET["pagina"] != 'Login') {
		header('Location: login');
    	exit();
	} elseif ($_SESSION['changedPass'] == 1 && $_GET["pagina"] != 'change_pass'){
		header('Location: change_pass');
    	exit();
	}
	$level = ($_SESSION['level'] == 1) ? 'Administrador' : 'Responsable';

?>
<!-- Start Header Area -->
<div class="header-area">
		<div class="container-fluid">
				<div class="header-content-wrapper">
						<div class="header-content d-flex justify-content-between align-items-center">
								<div class="header-left-content d-flex">
										<div class="responsive-burger-menu d-block d-lg-none">
												<span class="top-bar"></span>
												<span class="middle-bar"></span>
												<span class="bottom-bar"></span>
										</div>

										<div class="main-logo">
												<a href="inicio">
														<img src="assets/img/logo.png" width="150px" class="m-0" alt="main-logo">
												</a>
										</div>

								</div>
								<?php if (isset($_SESSION['sesion']) && $_SESSION['sesion'] == 'ok'): ?>
									<div class="header-right-option dropdown profile-nav-item pt-0 pb-0">
										<a class="dropdown-item dropdown-toggle avatar d-flex align-items-center show" href="#" id="navbarDropdown-4" role="button" data-bs-toggle="dropdown" aria-expanded="true">
												<div class="d-none d-lg-block d-md-block">
														<h3 class="profile-name"><?php echo $_SESSION['firstname']." ".$_SESSION['lastname'] ?></h3>
														<span class="profile-level"><?php echo $level ?></span>
												</div>
										</a>

										<div class="dropdown-menu" data-popper-placement="bottom-start" style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(0px, 50px);">
												<div class="dropdown-header d-flex flex-column align-items-center">
														<div class="info text-center">
																<span class="profile-name-drop"><?php echo $_SESSION['firstname']." ".$_SESSION['lastname'] ?></span>
																<p class="mb-3 email">
																		<a href="mailto:<?php echo $_SESSION['email'] ?>"><?php echo $_SESSION['email'] ?></a>
																</p>
														</div>
												</div>

												<div class="dropdown-wrap">
														<ul class="profile-nav p-0 pt-3">
																<li class="nav-item">
																		<a href="changePassword" class="nav-link">
																				<i class="ri-user-line"></i> 
																				<span>Cambiar contraseña</span>
																		</a>
																</li>

																<!-- <li class="nav-item">
																		<a href="inbox.html" class="nav-link">
																				<i class="ri-mail-send-line"></i> 
																				<span>Mis mensajes</span>
																		</a>
																</li> -->
														</ul>
												</div> 

												<div class="dropdown-footer">
														<ul class="profile-nav">
																<li class="nav-item">
																		<a href="" class="nav-link" id="logout">
																				<i class="ri-login-circle-line"></i> 
																				<span>Cerrar sesión</span>
																		</a>
																</li>
														</ul>
												</div>
										</div>
								</div>
								<?php else: ?>
										<a href="login">Iniciar sesión</a>
								<?php endif ?>

						</div>
				</div>
		</div>
</div>
<!-- End Header Area -->
<script>
	$(document).ready(function () {
		$("#logout").click(function (e) {
			e.preventDefault();

			// Realiza la solicitud Ajax para cerrar la sesión
			$.ajax({
				type: "POST",
				url: "controller/ajax/logout.php", // Cambia esto con la ruta correcta a tu script de logout
				success: function (response) {
					// Redirige a la página de inicio después de cerrar sesión
					window.location.href = 'inicio';
				},
				error: function (error) {
					console.log("Error en la solicitud Ajax:", error);
				}
			});
		});
	});
</script>