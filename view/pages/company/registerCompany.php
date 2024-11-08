<?php if ($level  == 1):?>
<?php
    $areas = FormsController::ctrGetAreas();
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/mdbassit/Coloris@latest/dist/coloris.min.css" />
<script src="https://cdn.jsdelivr.net/gh/mdbassit/Coloris@latest/dist/coloris.min.js"></script>
<!-- Start Main Content Area -->
<main class="main-content-wrap">

    <div class="card-box-style">
        <div class="others-title">
            <h3>Registrar empresa</h3>
        </div>

        <form class="account-wrap" id="companyForm">
            <div class="row">
                <div class="col-md-6">
                    <label for="companyName" class="form-label">Nombre de la empresa</label>
                    <input type="text" class="form-control" id="companyName" name="companyName" placeholder="Nombre de la Empresa">
                </div>
                
                <div class="col-md-6">
                    <label for="areaDescription" class="form-label">Descripción de la empresa</label>
                    <input type="text" class="form-control" id="companyDescription" name="companyDescription" placeholder="Descripción de la empresa">
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
<script src="assets/js/ajax-js/add-companies.js"></script>

<?php else: ?>
	<script>
		window.location.href = 'inicio';
	</script>
<?php endif ?>