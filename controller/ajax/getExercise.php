<?php

    require_once "../forms.controller.php";
    require_once "../../model/forms.models.php";

    $getExercise = FormsController::ctrGetExercises($_POST['register']);
    echo json_encode($getExercise);