<?php

require_once "../forms.controller.php";
require_once "../../model/forms.models.php";

$data = array(
    'idEmployer' => $_POST['idEmployer'],
    'empresa' => $_POST['empresa'],
    'idAreaCargo' => $_POST['idAreaCargo'],
    'cuentaAfectada' => $_POST['cuentaAfectada'],
    'idCuentaAfectada' => $_POST['idCuentaAfectada'],
    'partidaAfectada' => $_POST['partidaAfectada'],
    'idPartidaAfectada' => $_POST['idPartidaAfectada'],
    'concepto' => ($_POST['concepto'] != '') ? $_POST['concepto'] : $_POST['conceptoInput'],
    'idConcepto' => $_POST['idConcepto'],
    'requestedAmount' => $_POST['requestedAmount'],
    'importeLetra' => $_POST['importeLetra'],
    'fechaPago' => $_POST['fechaPago'],
    'provider' => $_POST['provider'],
    'clabe' => $_POST['clabe'],
    'bank_name' => $_POST['bank_name'],
    'account_number' => $_POST['account_number'],
    'swiftCode' => $_POST['swiftCode'],
    'beneficiaryAddress' => $_POST['beneficiaryAddress'],
    'currencyType' => $_POST['currencyType'],
    'conceptoPago' => $_POST['conceptoPago'],
    'idRequest' => $_POST['idRequest'],
    'cuentaAfectadaCount' => $_POST['cuentaAfectadaCount'], // Añadido
    'partidaAfectadaCount' => $_POST['partidaAfectadaCount'], // Añadido
    'polizeType' => $_POST['polizeType'], // Añadido
    'numberPolize' => $_POST['numberPolize'], // Añadido
    'cargo' => $_POST['cargo'], // Añadido
    'abono' => $_POST['abono'], // Añadido
    'estatus' => $_POST['estatus'], // Añadido
    'fechaCarga' => $_POST['fechaCarga'] // Añadido
);

$completeRequest = FormsController::ctrCompleteRequest($data);

echo $completeRequest;
