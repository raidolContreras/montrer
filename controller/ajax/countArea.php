<?php

    require_once "../forms.controller.php";
    require_once "../../model/forms.models.php";

    $countArea = FormsController::ctrCountArea($_POST['idUser']);
    echo json_encode($countArea);