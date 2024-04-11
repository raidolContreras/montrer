<?php

    require_once "../forms.controller.php";
    require_once "../../model/forms.models.php";

    $nextIdProvider = FormsController::ctrNextIdProvider();
    echo json_encode($nextIdProvider);