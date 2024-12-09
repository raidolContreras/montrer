<?php

    require_once "../forms.controller.php";
    require_once "../../model/forms.models.php";

    $getExercise = FormsController::ctrGetConceptos($_POST['idPartida']);
    echo json_encode($getExercise);