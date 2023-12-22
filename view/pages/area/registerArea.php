<!-- Start Main Content Area -->
<main class="main-content-wrap">

    <div class="card-box-style">
        <div class="others-title">
            <h3>Registrar Área</h3>
        </div>

        <form class="row g-3">
            <div class="col-12">
                <label for="areaName" class="form-label">Nombre del Área</label>
                <input type="text" class="form-control" id="areaName" placeholder="Nombre del área">
            </div>
            <div class="col-md-6">
                <label for="areaDescription" class="form-label">Descripción del Área</label>
                <input type="text" class="form-control" id="areaDescription">
            </div>
            <div class="col-md-6">
                <label for="responsibleUser" class="form-label">Usuario Encargado</label>
                <select id="responsibleUser" class="form-select form-control">
                    <option selected disabled>Seleccionar...</option>
                    <option value="user1">Usuario 1</option>
                    <option value="user2">Usuario 2</option>
                    <!-- Agrega más opciones según sea necesario -->
                </select>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Registrar Área</button>
            </div>
        </form>
    </div>

</main>
<!-- End Main Content Area -->
