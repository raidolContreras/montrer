<?php

    require_once "../forms.controller.php";
    require_once "../../model/forms.models.php";
    $provider_idUser = (isset($_POST['idUser'] ) && $_POST['idUser'] != 'NaN' ) ? $_POST['idUser'] : null;
    $getProviders = FormsController::ctrGetProviders($provider_idUser);
    echo json_encode($getProviders);