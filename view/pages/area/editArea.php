<?php if ($level == 1):?>
<?php
    $areas = FormsController::ctrGetAreas();
?>
<?php
    $users = FormsController::ctrGetUsers();
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                    <label for="responsibleUser" class="form-label">Colaboradores responsables<span class="required"></span></label>
                    <select id="responsibleUser" name="users[]" class="form-select form-control required-field" multiple>
                        <?php foreach ($users as $user): ?>
                            <option value="<?php echo $user['idUsers']; ?>"><?php echo $user['firstname'] . " " . $user['lastname']; ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="areaCode" class="form-label">Código del departamento<span class="required"></span></label>
                    <div class="input-group">
                        <input class="form-control col auto-format" type="text" id="areaCode" name="areaCode" required>
                        <span class="input-group-text endCode">-000-000-000</span>
                    </div>
                </div>
                
                <div class="col-12">
                    <input type="hidden" name="user" value="<?php echo $_SESSION['idUser'] ?>">
                    <hr>
                </div>

                <div class="col-12 mt-2 text-end">
                    <a class="btn btn-danger" id="cancelButton">Cancelar</a>
                    <button type="submit" class="btn btn-success">Aceptar</button>
                </div>
            </div>
        </form>
    </div>
<div id="register-value" data-register="<?php echo $_POST['register']; ?>"></div>

</main>
<!-- End Main Content Area -->
<script src="assets/js/ajax-js/get-area.js"></script>
<script src="assets/js/ajax-js/edit-area.js"></script>

<?php else: ?>
	<script>
		window.location.href = 'inicio';
	</script>
<?php endif ?>