<?php
    $users = FormsController::ctrGetUsers();
?>
<!-- Start Main Content Area -->
<main class="main-content-wrap">

    <div class="card-box-style">
        <div class="others-title">
            <h3>Actualizar departamento</h3>
        </div>

        <form class="account-wrap">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="areaName" class="form-label">Nombre del departamento</label>
                    <input type="text" class="form-control" id="areaName" name="areaName" placeholder="Nombre del departamento">
                </div>
                <div class="col-md-6">
                    <label for="areaDescription" class="form-label">Descripción del departamento</label>
                    <input type="text" class="form-control" id="areaDescription" name="areaDescription">
                </div>
                <div class="col-md-6">
                    <label for="responsibleUser" class="form-label">Colaborador responsable</label>
                    <select id="responsibleUser" name="user" class="form-select form-control">
                        <option selected disabled>Seleccionar...</option>
                        <?php foreach ($users as $user): ?>
                            <option value="<?php echo $user['idUsers']; ?>"><?php echo $user['firstname']." ".$user['lastname']; ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Actualizar departamento</button>
                </div>
            </div>
        </form>
    </div>
<div id="register-value" data-register="<?php echo $_POST['register']; ?>"></div>

</main>
<!-- End Main Content Area -->
<script src="assets/js/ajax-js/get-area.js"></script>
<script src="assets/js/ajax-js/edit-area.js"></script>
<script src="assets/js/sweetalert2.all.min.js"></script>