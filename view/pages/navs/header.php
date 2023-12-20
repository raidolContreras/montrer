<?php

session_start();

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
                            <img src="assets/img/logo.png" width="70px" class="m-0" alt="main-logo">
                        </a>
                    </div>

                </div>
                <?php if (isset($_SESSION['sesion']) && $_SESSION['sesion'] == 'ok'): ?>
                    <a href="#" id='logout'>Cerrar sesión</a>
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