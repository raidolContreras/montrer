<?php

    require_once "../forms.controller.php";
    require_once "../../model/forms.models.php";
    $idArea = (isset($_POST['idArea']) ? $_POST['idArea'] : null);
    $getAccounts = FormsController::ctrSelectAccounts($idArea);
    echo json_encode($getAccounts);