<?php

    require_once "../forms.controller.php";
    require_once "../../model/forms.models.php";

    $getAuthorizedAmount = FormsController::ctrGetAuthorizedAmount($_POST['areaId']);
    echo json_encode($getAuthorizedAmount);