<?php

    require_once "../forms.controller.php";
    require_once "../../model/forms.models.php";

    $getAccounts = FormsController::ctrSelectAccounts($_POST['idArea']);
    echo json_encode($getAccounts);