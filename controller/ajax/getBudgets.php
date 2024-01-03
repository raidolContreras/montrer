<?php

    require_once "../forms.controller.php";
    require_once "../../model/forms.models.php";

    $getBudgets = FormsController::ctrgetBudgets();
    echo json_encode($getBudgets);