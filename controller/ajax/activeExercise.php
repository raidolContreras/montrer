<?php

    require_once "../forms.controller.php";
    require_once "../../model/forms.models.php";

    $activeExercise = FormsController::ctrActiveExercise();
    echo json_encode($activeExercise);