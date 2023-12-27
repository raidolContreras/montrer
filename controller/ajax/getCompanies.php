<?php

    require_once "../forms.controller.php";
    require_once "../../model/forms.models.php";

    $getCompanies = FormsController::ctrGetCompanies();
    echo json_encode($getCompanies);
?>
