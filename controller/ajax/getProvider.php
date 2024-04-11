<?php

    require_once "../forms.controller.php";
    require_once "../../model/forms.models.php";

    $getProvider = FormsController::ctrGetProvider($_POST['register']);
    echo json_encode($getProvider);