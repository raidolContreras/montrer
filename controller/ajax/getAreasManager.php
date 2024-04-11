<?php

    require_once "../forms.controller.php";
    require_once "../../model/forms.models.php";

    $getAreaManager = FormsController::ctrGetAreaManager($_POST['user']);
    echo json_encode($getAreaManager);