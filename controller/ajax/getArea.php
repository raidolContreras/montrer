<?php

    require_once "../forms.controller.php";
    require_once "../../model/forms.models.php";

    $getArea = FormsController::ctrGetArea($_POST['register']);
    echo json_encode($getArea);