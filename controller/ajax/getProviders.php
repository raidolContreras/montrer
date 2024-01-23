<?php

    require_once "../forms.controller.php";
    require_once "../../model/forms.models.php";

    $getProviders = FormsController::ctrGetProviders();
    echo json_encode($getProviders);