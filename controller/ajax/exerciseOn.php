<?php

    require_once "../forms.controller.php";
    require_once "../../model/forms.models.php";

    $updateActiveExercise = FormsController::ctrUpdateActiveExercise($_POST['idExercise']);
    echo json_encode($updateActiveExercise);