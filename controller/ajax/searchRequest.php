<?php

    require_once "../forms.controller.php";
    require_once "../../model/forms.models.php";

    $getRequests = FormsController::ctrSearchRequest($_POST['idRequest']);
    echo json_encode($getRequests);