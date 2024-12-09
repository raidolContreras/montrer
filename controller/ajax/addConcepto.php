<?php

    require_once "../forms.controller.php";
    require_once "../../model/forms.models.php";

    $getRequests = FormsController::ctrAddConcepto($_POST['idPartida'], $_POST['concepto'], $_POST['numeroConcepto']);
    echo json_encode($getRequests);