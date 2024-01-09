<?php

    require_once "../forms.controller.php";
    require_once "../../model/forms.models.php";

    $getUser = FormsController::ctrGetUser($_POST['register']);
    echo json_encode($getUser);