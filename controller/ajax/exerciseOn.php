<?php

    require_once "../forms.controller.php";
    require_once "../../model/forms.models.php";

    $updateActiveExercise = FormsController::ctrUpdateActiveExercise($_POST['idExercise']);
    
	if ($updateActiveExercise == 'ok'){
		session_start();
		$ip = $_SERVER['REMOTE_ADDR'];
		FormsModels::mdlLog($_SESSION['idUser'], 'Activate exercise: '.$_POST['idExercise'], $ip);
	}
    echo json_encode($updateActiveExercise);