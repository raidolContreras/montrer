<?php

    require_once "../forms.controller.php";
    require_once "../../model/forms.models.php";

    $getRequests = FormsController::ctrGetRequest($_POST['idRequest']);
    echo json_encode($getRequests);