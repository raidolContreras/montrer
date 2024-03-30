<?php

    require_once "../forms.controller.php";
    require_once "../../model/forms.models.php";

    $getAmountPendient = FormsController::ctrGetAmountPendient($_POST['areaId']);
    echo json_encode($getAmountPendient);