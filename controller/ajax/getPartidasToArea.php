<?php

    require_once "../forms.controller.php";
    require_once "../../model/forms.models.php";

    $getPartidas = FormsController::ctrGetPartidasToArea($_POST['idArea']);
    echo json_encode($getPartidas);