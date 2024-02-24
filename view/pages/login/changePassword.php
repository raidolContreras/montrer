<!-- Start Main Content Area -->
<main class="main-content-wrap">
    <!-- Start Account Area -->
    <div>
        <div class="d-table">
            <div class="d-table-cell">
                <div class="container">
                    <div class="account-content">
                        <div class="account-header">
                            <a href="inicio">
                                <img src="assets/img/logo.png" alt="main-logo">
                            </a>
                            <h3>Actualización de contraseña</h3>
                        </div>

                        <form class="account-wrap">
                            <div class="form-group mb-24 icon">
                                <input name="actualPassword" type="password" class="form-control" placeholder="Contraseña actual" required>
                                <img src="assets/img/svg/lock.svg">
                            </div>
                            <div class="form-group mb-24 icon">
                                <input name="newPassword" type="password" class="form-control" placeholder="Nueva contraseña" required>
                                <img src="assets/img/svg/lock.svg">
                            </div>
                            <div class="form-group mb-24 icon">
                                <input name="confirmPassword" type="password" class="form-control" placeholder="Confirmar contraseña" required>
                                <img src="assets/img/svg/lock.svg">
                                <input type="hidden" name="user" value="<?php echo $_SESSION['idUser'] ?>">
                            </div>
                            <div class="row" style="justify-content: space-around;">
                                <button type="submit" class="col-5 btn btn-danger" onclick="window.location.href = 'inicio'">Cancelar</button>
                                <button type="submit" class="col-5 btn btn-success" id="register">Aceptar</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Account Area -->
    <script src="assets/js/ajax-js/changePassword.js"></script>
</main>
