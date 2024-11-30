<?php if ($level  == 1):?>
<?php
    $areas = FormsController::ctrGetAreas();
?>
<?php
    $users = FormsController::ctrGetUsers();
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- Start Main Content Area -->
<main class="main-content-wrap">

    <div class="card-box-style">
        <div class="others-title">
            <h3>Registrar departamento</h3>
        </div>

        <form class="account-wrap">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="areaName" class="form-label">Nombre del departamento<span class="required"></span></label>
                    <input type="text" class="form-control required-field" id="areaName" name="areaName" placeholder="Nombre del departamento">
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

</main>
<!-- End Main Content Area -->
<script src="assets/js/ajax-js/add-areas.js"></script>
<script>
    var $j = jQuery.noConflict();
    $j(document).ready(function() {
        $j('#responsibleUser').select2();
    });

</script>

<?php else: ?>
	<script>
		window.location.href = 'inicio';
	</script>
<?php endif ?>