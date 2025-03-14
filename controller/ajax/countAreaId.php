<?php

    require_once "../forms.controller.php";
    require_once "../../model/forms.models.php";

    $countArea = FormsController::ctrCountAreaId($_POST['idArea']);
    echo json_encode($countArea);