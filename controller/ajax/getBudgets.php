<?php

    require_once "../forms.controller.php";
    require_once "../../model/forms.models.php";

    $exercise = (isset($_POST['idExercise'])) ? $_POST['idExercise'] : null;

    $getBudgets = FormsController::ctrGetBudgets($exercise);
    echo json_encode($getBudgets);
