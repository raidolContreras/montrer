<?php if ($_SESSION['level']  == 1):?>
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
                <!-- ... Otras partes del formulario ... -->

                <div class="col-md-6">
                    <label for="logo" class="form-label">Logo</label>
                    <div id="logoDropzone" class="dropzone"></div>
                    <input type="hidden" id="logo" name="logo" />
                </div>

                <!-- ... Otros campos del formulario ... -->

                <div class="col-12">
                    <hr>
                </div>

                <div class="col-md-6 row">
                    <label class="form-label">Colores</label>
                    <div class="col-md-4">
                        <label for="primaryColor" class="form-label">Primario</label>
                        <input type="text" class="form-control" id="primaryColor" name="primaryColor" value="#3498db" data-coloris> <!-- Ejemplo: Azul -->
                    </div>
                    <div class="col-md-4">
                        <label for="secondaryColor" class="form-label">Secundario</label>
                        <input type="text" class="form-control" id="secondaryColor" name="secondaryColor" value="#e74c3c" data-coloris> <!-- Ejemplo: Rojo -->
                    </div>
                    <div class="col-md-4">
                        <label for="accentColor" class="form-label">Acento</label>
                        <input type="text" class="form-control" id="accentColor" name="accentColor" value="#2ecc71" data-coloris> <!-- Ejemplo: Verde -->
                    </div>
                    <div class="col-md-4">
                        <label for="background1Color" class="form-label">Fondo</label>
                        <input type="text" class="form-control" id="background1Color" name="background1Color" value="#ecf0f1" data-coloris> <!-- Ejemplo: Gris claro -->
                    </div>
                    <div class="col-md-4">
                        <label for="background2Color" class="form-label">Fondo de los modulos</label>
                        <input type="text" class="form-control" id="background2Color" name="background2Color" value="#ffffff" data-coloris> <!-- Ejemplo: Blanco -->
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="areaDescription" class="form-label">Descripción de la empresa</label>
                    <input type="text" class="form-control" id="companyDescription" name="companyDescription" placeholder="Descripción de la empresa">
                </div>

                <div class="col-12 mt-2 text-end">
                    <button type="submit" class="btn btn-primary">Registrar empresa</button>
                </div>
            </div>
        </form>
    </div>

</main>
<!-- End Main Content Area -->
<script src="assets/js/ajax-js/add-companies.js"></script>
<script src="assets/js/sweetalert2.all.min.js"></script>
<?php else: ?>
	<script>
		window.location.href = 'inicio';
	</script>
<?php endif ?>