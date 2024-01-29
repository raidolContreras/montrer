<!-- Start Main Content Area -->
<main class="main-content-wrap">

    <div class="card-box-style">
        <div class="others-title">
            <h3>Solicitud de Presupuesto</h3>
        </div>

        <form class="account-wrap" id="budgetRequestForm">
            <div class="row">

                <!-- Sección de Solicitud de Presupuesto -->
                <div class="col-12 mt-4">
                    <h4>Solicitud de Presupuesto</h4>
                </div>

                <input type="hidden" class="form-control" id="idBudget" name="idBudget" >

                <div class="col-md-6">
                    <label for="idArea" class="form-label">ID del Área</label>
                    <input type="text" class="form-control" id="idArea" name="idArea" readonly>
                </div>

                <div class="col-md-6">
                    <label for="idProvider" class="form-label">ID del Proveedor</label>
                    <input type="text" class="form-control" id="idProvider" name="idProvider">
                </div>

                <div class="col-md-6">
                    <label for="requestedAmount" class="form-label">Monto Solicitado ($)</label>
                    <input type="number" class="form-control" id="requestedAmount" name="requestedAmount"> 
                </div>

                <div class="col-md-12">
                    <label for="description" class="form-label">Descripción</label>
                    <textarea class="form-control" id="description" name="description"></textarea>
                </div>

                <div class="col-12 mt-2 text-end">
                    <button type="submit" class="btn btn-success">Enviar Solicitud</button>
                    <a class="btn btn-danger" id="cancelButton">Cancelar</a>
                </div>
            </div>
        </form>
    </div>

</main>
<!-- End Main Content Area -->
<script src="assets/js/ajax-js/add-budget-request.js"></script>
<script src="assets/js/ajax-js/get-nextIdBudgetRequest.js"></script>
<script src="assets/js/sweetalert2.all.min.js"></script>
