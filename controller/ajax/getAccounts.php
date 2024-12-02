<?php

    require_once "../forms.controller.php";
    require_once "../../model/forms.models.php";

    $getAccounts = FormsController::ctrGetAccounts();
    echo json_encode($getAccounts);