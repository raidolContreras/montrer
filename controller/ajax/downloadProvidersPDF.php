<?php

    require_once "../forms.controller.php";
    require_once "../../model/forms.models.php";

    $downloadProvider = FormsController::ctrDownloadProvidersPDF();
    echo $downloadProvider;