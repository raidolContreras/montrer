<?php

    require_once "../forms.controller.php";
    require_once "../../model/forms.models.php";

    $getAreas = FormsController::ctrGetAreas();
    echo json_encode($getAreas);
?>
