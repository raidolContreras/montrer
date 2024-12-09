<?php

    require_once "../forms.controller.php";
    require_once "../../model/forms.models.php";

    $getRequests = FormsController::ctrDeleteConcepto($_POST['idConcepto']);
    echo json_encode($getRequests);