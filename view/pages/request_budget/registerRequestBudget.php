<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    var $j = jQuery.noConflict();
</script>
<script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js"></script>
<!-- Start Main Content Area -->
<main class="main-content-wrap">

    <div class="card-box-style">
        <div class="others-title">
            <h3>Solicitud de presupuesto</h3>
        </div>

        <form class="account-wrap" id="budgetRequestForm">
            <div class="row">

                <div class="col-md-3"></div>

                <div class="col-md-6">
                    <label for="fecha" class="form-label">Fecha de petición<span class="required"></span></label>
                    <input class="form-control" type="date" id="fecha" name="fecha" value="<?php echo date('Y-m-d'); ?>" readonly>
                </div>

                <div class="col-md-3"></div>

                <div class="col-md-6">
                    <label for="name" class="form-label">Nombre completo del solicitante</label>
                    <input class="form-control" type="text" name="name" id="name"
                        value="<?php echo $_SESSION['firstname'] . " " . $_SESSION['lastname'] ?>"
                    readonly>
                </div>

                <div class="col-md-6">
                    <label for="Area" class="form-label">Departamento<span class="required"></span></label>
                    <select name="area" id="area" class="form-select form-control">
                        <option value="">Seleccionar departamento</option>
                    </select>
                </div>
                
                <div class="col-md-6">
                    <label for="requestedAmount" class="form-label">Monto Solicitado ($)<span class="required"></span></label>
                    <input type="text" id="requestedAmount" name="requestedAmount" class="form-control inputmask" data-inputmask="'alias': 'currency', 'prefix': '$ ', 'placeholder': '0', 'autoUnmask': true, 'removeMaskOnSubmit': true"> 
                    <label class="requestMax"></label>
                </div>
                
                <div class="col-md-6">
                    <label for="description" class="form-label">Descripción<span class="required"></span></label>
                    <textarea class="form-control" id="description" name="description"></textarea>
                </div>

                <div class="col-md-4">
                    <label for="provider" class="form-label">Proveedor<span class="required"></span></label>
                    <select name="provider" id="provider" class="form-select form-control">
                    </select>
                </div>
                
                <div class="col-md-4">
                    <label for="event" class="form-label">Evento<span class="required"></span></label>
                    <input class="form-control" type="text" name="event" id="event">
                </div>

                <div class="col-md-4">
                    <label for="eventDate" class="form-label">Fecha del evento<span class="required"></span></label>
                    <input class="form-control" type="date" id="eventDate" name="eventDate">
                </div>
                
                <div class="col-12 mt-2 text-end">
                    <a class="btn btn-danger" id="cancelButton">Cancelar</a>
                    <button type="submit" class="btn btn-success">Aceptar</button>
                </div>
            </div>
            <input type="hidden" name="maxBudget">
            <input type="hidden" class="form-control" id="idBudget" name="idBudget" >
            <input type="hidden" name="budget">
        </form>
    </div>
</main>
<div id="register-value" data-register="<?php echo $_SESSION['idUser']; ?>"></div>
<!-- End Main Content Area -->
<script src="assets/js/ajax-js/add-budget-request.js"></script>
<script src="assets/js/ajax-js/request_provider.js"></script>


<script>
    $j(document).ready(function() {
        $j('.inputmask').inputmask();
    });
</script>

<div class="modal fade" id="modalAgregarProveedor" tabindex="-1" role="dialog" aria-labelledby="modalAgregarProveedorLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalAgregarProveedorLabel">Añadir proveedor</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Contenido del modal para añadir proveedor...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success">Aceptar</button>
      </div>
    </div>
  </div>
</div>
