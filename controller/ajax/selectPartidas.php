<?php

    require_once "../forms.controller.php";
    require_once "../../model/forms.models.php";

    $getPartidas = FormsController::ctrSelectPartidas($_POST['idCuenta']);
    echo json_encode($getPartidas);