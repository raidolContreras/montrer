<?php

    require_once "../forms.controller.php";
    require_once "../../model/forms.models.php";

    $getProviders = FormsController::ctrGetProviderON();
    echo json_encode($getProviders);