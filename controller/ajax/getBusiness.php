<?php

    require_once "../forms.controller.php";
    require_once "../../model/forms.models.php";

    $idUser = (isset($_POST['idUser'])) ? $_POST['idUser'] : null;

    $getBusiness = FormsController::ctrGetBusiness($idUser);
    echo json_encode($getBusiness);
