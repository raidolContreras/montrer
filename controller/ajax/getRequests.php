<?php

    require_once "../forms.controller.php";
    require_once "../../model/forms.models.php";

    $getRequests = FormsController::ctrGetRequests($_POST['user']);
    echo json_encode($getRequests);