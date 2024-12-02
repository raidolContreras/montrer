<?php

    require_once "../forms.controller.php";
    require_once "../../model/forms.models.php";

    $getPartidas = FormsController::ctrGetPartidas();
    echo json_encode($getPartidas);