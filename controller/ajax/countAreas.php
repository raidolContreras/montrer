<?php

    require_once "../forms.controller.php";
    require_once "../../model/forms.models.php";

    $countAreas = FormsController::ctrCountAreas();
    echo json_encode($countAreas);