<?php

    require_once "../forms.controller.php";
    require_once "../../model/forms.models.php";

    $getRequests = FormsController::ctrEditConcepto($_POST['idConcepto'], $_POST['concepto'], $_POST['numeroConcepto']);
    echo json_encode($getRequests);