<?php

    require_once "../forms.controller.php";
    require_once "../../model/forms.models.php";

    $result = FormsController::ctrGetLogs($_POST['log']);
    echo json_encode($result);