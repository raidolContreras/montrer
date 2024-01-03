<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/mdbassit/Coloris@latest/dist/coloris.min.css" />
<script src="https://cdn.jsdelivr.net/gh/mdbassit/Coloris@latest/dist/coloris.min.js"></script>
<!-- Start Main Content Area -->
<main class="main-content-wrap">

    <div class="card-box-style">
        <div class="others-title">
            <h3>Registrar Empresa</h3>
        </div>

        <form class="account-wrap" id="companyForm">
            <div class="row">
                <div class="col-md-6">
                    <label for="area" class="form-label">Area</label>
                    <select name="area" id="area">
                    </select>
                </div>
                
                <div class="col-md-6">
                    <label for="logo" class="form-label">Logo</label>
                    <div id="logoDropzone" class="dropzone"></div>
                    <input type="hidden" id="logo" name="logo" />
                </div>

                <div class="col-12">
                    <hr>
                </div>

                <div class="col-12 mt-2 text-end">
                    <button type="submit" class="btn btn-primary">Registrar Empresa</button>
                </div>
            </div>
        </form>
    </div>

</main>

<script src="assets/js/ajax-js/active-exercise.js"></script>
<script src="assets/js/ajax-js/areas.js"></script>
<script src="assets/js/sweetalert2.all.min.js"></script>