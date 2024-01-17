<?php

    require_once "../forms.controller.php";
    require_once "../../model/forms.models.php";

    $getBudget = FormsController::ctrGetBudget($_POST['register']);
    echo json_encode($getBudget);