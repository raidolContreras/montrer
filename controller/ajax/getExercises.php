<?php

    require_once "../forms.controller.php";
    require_once "../../model/forms.models.php";

    $getExercises = FormsController::ctrGetExercise();
    echo json_encode($getExercises);
?>
