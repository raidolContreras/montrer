
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
                <?php if (isset($_SESSION['validarIngreso']) && $_SESSION['validarIngreso'] == 'ok'): ?>
                    <a href="logout">Cerrar sesión</a>
                <?php else: ?>
                    <a href="login">Iniciar sesión</a>
                <?php endif ?>

            </div>
        </div>
    </div>
</div>
<!-- End Header Area -->
