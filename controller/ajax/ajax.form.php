<?php

require_once "../forms.controller.php";
require_once "../../model/forms.models.php";

class AjaxForm
{

	static function CreateUser($data)
	{
		$createUser = FormsController::ctrCreateUser($data);
		if ($createUser != 'Error') {
			session_start();
			$ip = $_SERVER['REMOTE_ADDR'];
			FormsModels::mdlLog($_SESSION['idUser'], 'Create user: ' . $createUser, $ip);
		}
		return $createUser;
	}

	static function LoginUser($data)
	{
		$loginUser = FormsController::ctrLoginUser($data);
		return $loginUser;
	}

	static function ChangePassword($data)
	{
		$changePassword = FormsController::ctrChangePassword($data);
		if ($changePassword == 'ok') {
			session_start();
			$ip = $_SERVER['REMOTE_ADDR'];
			FormsModels::mdlLog($_SESSION['idUser'], 'Change password', $ip);
		}
		return $changePassword;
	}

	static function ChangeNewPassword($data)
	{
		$changePassword = FormsController::ctrChangeNewPassword($data);
		if ($changePassword == 'ok') {
			session_start();
			$ip = $_SERVER['REMOTE_ADDR'];
			FormsModels::mdlLog($_SESSION['idUser'], 'Change password', $ip);
		}
		return $changePassword;
	}

	static function AddArea($data)
	{
		$addArea = FormsController::ctrAddArea($data);
		if ($addArea != 'Error') {
			session_start();
			$ip = $_SERVER['REMOTE_ADDR'];
			FormsModels::mdlLog($_SESSION['idUser'], 'Add departament', $ip);
		}
		return $addArea;
	}

	static function AddCompany($data)
	{
		$addCompany = FormsController::ctrAddCompany($data);
		if ($addCompany == 'ok') {
			session_start();
			$ip = $_SERVER['REMOTE_ADDR'];
			FormsModels::mdlLog($_SESSION['idUser'], 'Add company', $ip);
		}
		return $addCompany;
	}

	static public function AddExercise($data)
	{
		$addExercise = FormsController::ctrAddExercise($data);
		if ($addExercise == 'ok') {
			session_start();
			$ip = $_SERVER['REMOTE_ADDR'];
			FormsModels::mdlLog($_SESSION['idUser'], 'Add exercise', $ip);
		}
		return $addExercise;
	}

	static public function AddBudgets($data)
	{
		$addBudgets = FormsController::ctrAddBudgets($data);
		if ($addBudgets == 'ok') {
			session_start();
			$ip = $_SERVER['REMOTE_ADDR'];
			FormsModels::mdlLog($_SESSION['idUser'], 'Add budget', $ip);
		}
		return $addBudgets;
	}

	static public function UpdateUser($data)
	{
		$updateUser = FormsController::ctrUpdateUser($data);
		if ($updateUser == 'ok') {
			session_start();
			$ip = $_SERVER['REMOTE_ADDR'];
			FormsModels::mdlLog($_SESSION['idUser'], 'Update user: ' . $data['email'], $ip);
		}
		return $updateUser;
	}

	static public function DeleteRegister($idUsers)
	{
		$deleteRegister = FormsController::ctrDeleteRegister($idUsers);
		if ($deleteRegister == 'ok') {
			session_start();
			$ip = $_SERVER['REMOTE_ADDR'];
			FormsModels::mdlLog($_SESSION['idUser'], 'Disable user: ' . $idUsers, $ip);
		}
		return $deleteRegister;
	}

	static public function EnableRegister($idUsers)
	{
		$enableRegister = FormsController::ctrEnableRegister($idUsers);
		if ($enableRegister == 'ok') {
			session_start();
			$ip = $_SERVER['REMOTE_ADDR'];
			FormsModels::mdlLog($_SESSION['idUser'], 'Enable user: ' . $idUsers, $ip);
		}
		return $enableRegister;
	}

	static public function DisableArea($idArea)
	{
		$disableArea = FormsController::ctrDisableArea($idArea);
		if ($disableArea == 'ok') {
			session_start();
			$ip = $_SERVER['REMOTE_ADDR'];
			FormsModels::mdlLog($_SESSION['idUser'], 'Disable departament: ' . $idArea, $ip);
		}
		return $disableArea;
	}

	static public function EnableArea($idArea)
	{
		$enableArea = FormsController::ctrEnableArea($idArea);
		if ($enableArea == 'ok') {
			session_start();
			$ip = $_SERVER['REMOTE_ADDR'];
			FormsModels::mdlLog($_SESSION['idUser'], 'Enable departament: ' . $idArea, $ip);
		}
		return $enableArea;
	}

	static public function UpdateArea($data)
	{
		$updateArea = FormsController::ctrUpdateArea($data);
		if ($updateArea == 'ok') {
			session_start();
			$ip = $_SERVER['REMOTE_ADDR'];
			FormsModels::mdlLog($_SESSION['idUser'], 'Update departament: ' . $data['idArea'], $ip);
		}
		return $updateArea;
	}

	static public function UpdateExercise($data)
	{
		$updateExercise = FormsController::ctrUpdateExercise($data);
		if ($updateExercise == 'ok') {
			session_start();
			$ip = $_SERVER['REMOTE_ADDR'];
			FormsModels::mdlLog($_SESSION['idUser'], 'Update exercise: ' . $data['idExercise'], $ip);
		}
		return $updateExercise;
	}

	static public function disableExercise($idExercise)
	{
		$disableExercise = FormsController::ctrDisableExercise($idExercise);
		if ($disableExercise == 'ok') {
			session_start();
			$ip = $_SERVER['REMOTE_ADDR'];
			FormsModels::mdlLog($_SESSION['idUser'], 'Disable exercise: ' . $idExercise, $ip);
		}
		return $disableExercise;
	}

	static public function enableExercise($idExercise)
	{
		$enableExercise = FormsController::ctrEnableExercise($idExercise);
		if ($enableExercise == 'ok') {
			session_start();
			$ip = $_SERVER['REMOTE_ADDR'];
			FormsModels::mdlLog($_SESSION['idUser'], 'Enable exercise: ' . $idExercise, $ip);
		}
		return $enableExercise;
	}

	static public function deleteExercise($idExercise)
	{
		$deleteExercise = FormsController::ctrDeleteExercise($idExercise);
		if ($deleteExercise == 'ok') {
			session_start();
			$ip = $_SERVER['REMOTE_ADDR'];
			FormsModels::mdlLog($_SESSION['idUser'], 'Delete exercise: ' . $idExercise, $ip);
		}
		return $deleteExercise;
	}

	static public function deleteUser($idUsers)
	{
		$status = '';
		$area = '';
		$request = FormsController::ctrGetAreaByUser($idUsers);
		if (!empty($request)) {
			foreach ($request as $value) {
				$area = FormsController::ctrGetAreaBycheckup('idArea', $value['idArea']);
				if ($area == false) {
					$status = 'ok';
				} else {
					$status = 'Presupuestos pendientes';
					break;
				}
			}
        } else {
			$status = 'ok';
		}
		if ($status == 'ok') {
			$deleteUser = FormsController::ctrDeleteUser($idUsers);
			if ($deleteUser == 'ok') {
				session_start();
				$ip = $_SERVER['REMOTE_ADDR'];
				FormsModels::mdlLog($_SESSION['idUser'], 'Delete user: ' . $idUsers, $ip);
			}
			return $deleteUser;
		} else {
			return 'Error: Presupuestos ';
		}
	}

	static public function deleteArea($idArea)
	{
		$deleteArea = FormsController::ctrDeleteArea($idArea);
		if ($deleteArea == 'ok') {
			session_start();
			$ip = $_SERVER['REMOTE_ADDR'];
			FormsModels::mdlLog($_SESSION['idUser'], 'Delete departament: ' . $idArea, $ip);
		}
		return $deleteArea;
	}

	static public function deleteBudget($idBudget)
	{
		$deleteBudget = FormsController::ctrDeleteBudget($idBudget);
		if ($deleteBudget == 'ok') {
			session_start();
			$ip = $_SERVER['REMOTE_ADDR'];
			FormsModels::mdlLog($_SESSION['idUser'], 'Delete budget: ' . $idBudget, $ip);
		}
		return $deleteBudget;
	}

	static public function enableBudget($idBudget)
	{
		$enableBudget = FormsController::ctrEnableBudget($idBudget);
		if ($enableBudget == 'ok') {
			session_start();
			$ip = $_SERVER['REMOTE_ADDR'];
			FormsModels::mdlLog($_SESSION['idUser'], 'Enable budget: ' . $idBudget, $ip);
		}
		return $enableBudget;
	}

	static public function disableBudget($idBudget)
	{
		$disableBudget = FormsController::ctrDisableBudget($idBudget);
		if ($disableBudget == 'ok') {
			session_start();
			$ip = $_SERVER['REMOTE_ADDR'];
			FormsModels::mdlLog($_SESSION['idUser'], 'Disable budget: ' . $idBudget, $ip);
		}
		return $disableBudget;
	}

	static public function UpdateBudget($data)
	{
		$updateBudget = FormsController::ctrUpdateBudget($data);
		if ($updateBudget == 'ok') {
			session_start();
			$ip = $_SERVER['REMOTE_ADDR'];
			FormsModels::mdlLog($_SESSION['idUser'], 'Update budget: ' . $data['idBudget'], $ip);
		}
		return $updateBudget;
	}
}

if (isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['email']) && isset($_POST['level'])) {

	$data = array(
		'firstname' => $_POST['firstname'],
		'lastname' => $_POST['lastname'],
		'email' => $_POST['email'],
		'level' => $_POST['level'],
		'area' => $_POST['area']
	);

	$createUser = AjaxForm::CreateUser($data);
	echo $createUser;
}

if (isset($_POST['email']) && isset($_POST['password'])) {

	// Configurar el tiempo de vida de la sesión
	ini_set('session.gc_maxlifetime', 3600); // Tiempo de vida de la sesión en el servidor
	session_set_cookie_params(3600); // Tiempo de vida de la cookie de sesión en el cliente

	// Iniciar la sesión
	session_start();

	$data = array(
		'email' => $_POST['email'],
		'password' => $_POST['password']
	);

	$loginUser = AjaxForm::LoginUser($data);

	if (!isset($loginUser['sesion'])) {
		print_r($loginUser);
	} else {
		if ($loginUser['sesion'] == 'ok') {
			$_SESSION['sesion'] = $loginUser['sesion'];
			$_SESSION['idUser'] = $loginUser['idUsers'];
			$_SESSION['firstname'] = $loginUser['firstname'];
			$_SESSION['lastname'] = $loginUser['lastname'];
			$_SESSION['email'] = $loginUser['email'];
			$_SESSION['level'] = $loginUser['level'];
			$_SESSION['changedPass'] = $loginUser['changedPass'];
		}

		echo $loginUser['sesion'];
	}
}

if (isset($_POST['actualPassword']) && isset($_POST['newPassword']) && isset($_POST['user'])) {

	session_start();
	$data = array(
		'actualPassword' => crypt($_POST['actualPassword'], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$'),
		'newPassword' => crypt($_POST['newPassword'], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$'),
		'user' => $_POST['user']
	);

	$changePassword = AjaxForm::ChangePassword($data);

	if ($changePassword == 'ok') {
		$_SESSION['changedPass'] = 0;
	}
	echo $changePassword;
}

if (isset($_POST['updateActualPassword']) && isset($_POST['updateNewPassword']) && isset($_POST['updateConfirmPassword']) && isset($_POST['user'])) {

	if ($_POST['updateNewPassword'] != $_POST['updateConfirmPassword']) {
		echo 'Error: Contraseñas distintas';
	} else {

		if ($_POST['updateActualPassword'] != $_POST['updateNewPassword']) {

			$data = array(
				'ActualPassword' => crypt($_POST['updateActualPassword'], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$'),
				'newPassword' => crypt($_POST['updateNewPassword'], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$'),
				'user' => $_POST['user']
			);

			$changePassword = AjaxForm::ChangeNewPassword($data);

			echo $changePassword;
		} else {
			echo 'Error: contraseñas';
		}
	}
}

if (isset($_POST['areaName']) && isset($_POST['areaDescription'])) {
    // Verifica si el área ya existe
    $require = FormsController::ctrGetAreaByName($_POST['areaName']);
    if ($require == false) {
        // Preparar datos para registrar el área
        $data = array(
            'nameArea' => $_POST['areaName'],
            'areaDescription' => $_POST['areaDescription']
        );

        // Registrar el área
        $addArea = AjaxForm::AddArea($data);

        if ($addArea != 'Error') {
            // Asociar colaboradores al área
            foreach ($_POST['users'] as $userId) {
				$idArea = $addArea;
                $assignUser = FormsModels::mdlUpdateAreaUser($userId, $idArea);
                if ($assignUser != 'ok') {
                    echo 'Error: No se pudo asignar el usuario con ID ' . $userId . ' al área.';
                    exit;
                }
            }
            echo 'ok';
        } else {
            echo 'Error: No se pudo registrar el área.';
        }
    } else {
        echo 'Error: El departamento ya existe';
    }
} else {
    echo 'Error: Faltan datos.';
}

if (isset($_POST['companyName']) && isset($_POST['companyDescription'])) {
	$data = array(
		'companyName' => $_POST['companyName'],
		'companyDescription' => $_POST['companyDescription'],
	);
	$addCompany = AjaxForm::AddCompany($data);
	echo $addCompany;
}

if (isset($_POST['exerciseName']) && isset($_POST['initialDate']) && isset($_POST['finalDate']) && isset($_POST['user']) && isset($_POST['budget'])) {

	$data = array(
		'exerciseName' =>  $_POST['exerciseName'],
		'initialDate' =>  $_POST['initialDate'],
		'finalDate' =>  $_POST['finalDate'],
		'budget' =>  $_POST['budget'],
		'user' => $_POST['user']
	);
	$addExercise = AjaxForm::AddExercise($data);
	echo $addExercise;
}

if (isset($_POST['area']) && isset($_POST['AuthorizedAmount']) && isset($_POST['exercise'])) {

	$data = array(
		'area' =>  $_POST['area'],
		'AuthorizedAmount' =>  $_POST['AuthorizedAmount'],
		'exercise' =>  $_POST['exercise']
	);
	$addBudgets = AjaxForm::AddBudgets($data);
	echo $addBudgets;
}

if (isset($_POST['updateFirstname']) && isset($_POST['updateLastname']) && isset($_POST['updateEmail']) && isset($_POST['updateLevel']) && isset($_POST['updateUser'])) {
	$data = array(
		'firstname' => $_POST['updateFirstname'],
		'lastname' => $_POST['updateLastname'],
		'email' => $_POST['updateEmail'],
		'level' => $_POST['updateLevel'],
		'user' => $_POST['updateUser'],
	);
	$updateUser = AjaxForm::UpdateUser($data);
	echo $updateUser;
}

if (isset($_POST['disableUser'])) {
	$deleteRegister = AjaxForm::DeleteRegister($_POST['disableUser']);
	echo $deleteRegister;
}

if (isset($_POST['enableUser'])) {
	$enableRegister = AjaxForm::EnableRegister($_POST['enableUser']);
	echo $enableRegister;
}

if (isset($_POST['disableArea'])) {
	$disableArea = AjaxForm::DisableArea($_POST['disableArea']);
	echo $disableArea;
}

if (isset($_POST['enableArea'])) {
	$enableArea = AjaxForm::EnableArea($_POST['enableArea']);
	echo $enableArea;
}

if (isset($_POST['updateAreaName']) && isset($_POST['updateAreaDescription']) && isset($_POST['updateUser']) && isset($_POST['updateArea'])) {
	$data = array(
		'nameArea' => $_POST['updateAreaName'],
		'description' => $_POST['updateAreaDescription'],
		'idUser' => $_POST['updateUser'],
		'idArea' => $_POST['updateArea'],
	);
	$updateArea = AjaxForm::UpdateArea($data);
	echo $updateArea;
}

if (
	isset($_POST['updateExerciseName']) &&
	isset($_POST['updateInitialDate']) &&
	isset($_POST['updateFinalDate']) &&
	isset($_POST['updateUser']) &&
	isset($_POST['updateBudget']) &&
	isset($_POST['updateExercise'])
) {
	$data = array(
		'exerciseName' => $_POST['updateExerciseName'],
		'initialDate' => $_POST['updateInitialDate'],
		'finalDate' => $_POST['updateFinalDate'],
		'budget' => $_POST['updateBudget'],
		'idUser' => $_POST['updateUser'],
		'idExercise' => $_POST['updateExercise']
	);
	$updateExercise = AjaxForm::UpdateExercise($data);
	echo $updateExercise;
}

if (isset($_POST['enableExercise'])) {
	$enableExercise = AjaxForm::enableExercise($_POST['enableExercise']);
	echo $enableExercise;
}

if (isset($_POST['disableExercise'])) {
	$disableExercise = AjaxForm::disableExercise($_POST['disableExercise']);
	echo $disableExercise;
}

if (isset($_POST['deleteExercise'])) {
	$deleteExercise = AjaxForm::deleteExercise($_POST['deleteExercise']);
	echo $deleteExercise;
}

if (isset($_POST['deleteUser'])) {
	$deleteUser = AjaxForm::deleteUser($_POST['deleteUser']);
	echo $deleteUser;
}

if (isset($_POST['deleteArea'])) {
	$request = FormsController::ctrGetAreaBycheckup('idArea', $_POST['deleteArea']);
	if ($request == false) {
		$deleteArea = AjaxForm::deleteArea($_POST['deleteArea']);
		echo $deleteArea;
	} else {
		echo 'Error: comprobaciones pendientes';
	}
}

if (isset($_POST['deleteBudget'])) {
	$deleteBudget = AjaxForm::deleteBudget($_POST['deleteBudget']);
	echo $deleteBudget;
}

if (isset($_POST['enableBudget'])) {
	$enableBudget = AjaxForm::enableBudget($_POST['enableBudget']);
	echo $enableBudget;
}

if (isset($_POST['disableBudget'])) {
	$disableBudget = AjaxForm::disableBudget($_POST['disableBudget']);
	echo $disableBudget;
}

if (
	isset($_POST['updateAuthorizedAmount']) &&
	isset($_POST['updateArea']) &&
	isset($_POST['updateExercise']) &&
	isset($_POST['updateBudget'])
) {
	$data = array(
		'AuthorizedAmount' => $_POST['updateAuthorizedAmount'],
		'idArea' => $_POST['updateArea'],
		'idExercise' => $_POST['updateExercise'],
		'idBudget' => $_POST['updateBudget']
	);
	$updateExercise = AjaxForm::UpdateBudget($data);
	echo $updateExercise;
}

if (isset($_POST['idUsers']) && isset($_POST['newPassword'])) {

	$data = array(
		'newPassword' => crypt($_POST['newPassword'], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$'),
		'user' => $_POST['idUsers']
	);

	$changePassword = FormsController::ctrChangePasswordAdmin($data);

	echo $changePassword;
}

if (
	isset($_POST['providerKey']) &&
	isset($_POST['representativeName']) &&
	isset($_POST['contactPhone']) &&
	isset($_POST['email']) &&
	isset($_POST['website']) &&
	isset($_POST['businessName']) &&
	isset($_POST['rfc']) &&
	isset($_POST['fiscalAddressStreet']) &&
	isset($_POST['fiscalAddressColonia']) &&
	isset($_POST['fiscalAddressMunicipio']) &&
	isset($_POST['fiscalAddressEstado']) &&
	isset($_POST['fiscalAddressCP']) &&
	isset($_POST['bankName']) &&
	isset($_POST['accountHolder']) &&
	isset($_POST['accountNumber']) &&
	isset($_POST['idUser']) &&
	isset($_POST['clabe'])
) {

	$extrangero = $_POST['extrangero'];
	if ($extrangero) {
		$extrangero = 1;
		$swiftCode = $_POST['swiftCode'];
		$beneficiaryAddress = $_POST['beneficiaryAddress'];
		$currencyType = $_POST['currencyType'];
	} else {
		$extrangero = 0;
		$swiftCode = '';
        $beneficiaryAddress = '';
        $currencyType = '';
	}

	$data = array(
		'providerKey' => $_POST['providerKey'],
		'representativeName' => $_POST['representativeName'],
		'contactPhone' => $_POST['contactPhone'],
		'email' => $_POST['email'],
		'website' => $_POST['website'],
		'businessName' => $_POST['businessName'],
		'rfc' => $_POST['rfc'],
		'fiscalAddressStreet' => $_POST['fiscalAddressStreet'],
		'fiscalAddressColonia' => $_POST['fiscalAddressColonia'],
		'fiscalAddressMunicipio' => $_POST['fiscalAddressMunicipio'],
		'fiscalAddressEstado' => $_POST['fiscalAddressEstado'],
		'fiscalAddressCP' => $_POST['fiscalAddressCP'],
		'bankName' => $_POST['bankName'],
		'accountHolder' => $_POST['accountHolder'],
		'accountNumber' => $_POST['accountNumber'],
		'clabe' => $_POST['clabe'],
		'idUser' => $_POST['idUser'],
		'description' => $_POST['description'],
		'swiftCode' => $swiftCode,
        'beneficiaryAddress' => $beneficiaryAddress,
        'currencyType' => $currencyType,
        'extrangero' => $extrangero
	);
	$response = FormsController::ctrGetProviderByName($_POST['rfc'], $_POST['idUser']);
	if ($response == false) {
		$registerProvider = FormsController::ctrRegisterProvider($data);
		
		if ($registerProvider == 'ok'){
			session_start();
			$ip = $_SERVER['REMOTE_ADDR'];
			FormsModels::mdlLog($_SESSION['idUser'], 'Register provider: '.$_POST['providerKey'], $ip);
		}
	
		echo $registerProvider;
	} else {
		echo 'Error: RFC ya registrado';
	}
}

if (
	isset($_POST['providerKey']) &&
	isset($_POST['updaterepresentativeName']) &&
	isset($_POST['updateemail']) &&
	isset($_POST['updatecontactPhone']) &&
	isset($_POST['updatewebsite']) &&
	isset($_POST['updatebusinessName']) &&
	isset($_POST['updaterfc']) &&
	isset($_POST['updatefiscalAddressStreet']) &&
	isset($_POST['updatefiscalAddressColonia']) &&
	isset($_POST['updatefiscalAddressMunicipio']) &&
	isset($_POST['updatefiscalAddressEstado']) &&
	isset($_POST['updatefiscalAddressCP']) &&
	isset($_POST['updatebankName']) &&
	isset($_POST['updateaccountHolder']) &&
	isset($_POST['updateaccountNumber']) &&
	isset($_POST['updateclabe'])
) {

	$data = array(
		'providerKey' => $_POST['providerKey'],
		'representativeName' => $_POST['updaterepresentativeName'],
		'contactPhone' => $_POST['updatecontactPhone'],
		'email' => $_POST['updateemail'],
		'website' => $_POST['updatewebsite'],
		'businessName' => $_POST['updatebusinessName'],
		'rfc' => $_POST['updaterfc'],
		'fiscalAddressStreet' => $_POST['updatefiscalAddressStreet'],
		'fiscalAddressColonia' => $_POST['updatefiscalAddressColonia'],
		'fiscalAddressMunicipio' => $_POST['updatefiscalAddressMunicipio'],
		'fiscalAddressEstado' => $_POST['updatefiscalAddressEstado'],
		'fiscalAddressCP' => $_POST['updatefiscalAddressCP'],
		'bankName' => $_POST['updatebankName'],
		'accountHolder' => $_POST['updateaccountHolder'],
		'accountNumber' => $_POST['updateaccountNumber'],
		'clabe' => $_POST['updateclabe'],
		'swiftCode' => ($_POST['updateswiftCode'] != '') ? $_POST['updateswiftCode'] : null,
		'beneficiaryAddress' => ($_POST['updatebeneficiaryAddress']!= '') ? $_POST['updatebeneficiaryAddress'] : null,
        'currencyType' => ($_POST['updatecurrencyType']!= '') ? $_POST['updatecurrencyType'] : null
	);

	$response = FormsController::ctrGetProviderByName($_POST['updaterfc'], $_POST['idUser']);
	if ($response == false || $response['provider_key'] == $_POST['providerKey']) {
		$registerProvider = FormsController::ctrUpdateProvider($data);
		
		if ($registerProvider == 'ok'){
			session_start();
			$ip = $_SERVER['REMOTE_ADDR'];
			FormsModels::mdlLog($_SESSION['idUser'], 'Update provider: '.$_POST['providerKey'], $ip);
		}

		echo $registerProvider;
	} else {
		echo 'Error: RFC ya registrado';
	}
}

if (isset($_POST['disableProvider'])) {
	$disableProvider = FormsController::ctrDisableProvider($_POST['disableProvider']);
	
	if ($disableProvider == 'ok'){
		session_start();
		$ip = $_SERVER['REMOTE_ADDR'];
		FormsModels::mdlLog($_SESSION['idUser'], 'Disable provider: '.$_POST['disableProvider'], $ip);
	}

	echo $disableProvider;
}
if (isset($_POST['enableProvider'])) {
	$enableProvider = FormsController::ctrEnableProvider($_POST['enableProvider']);
	
	if ($enableProvider == 'ok'){
		session_start();
		$ip = $_SERVER['REMOTE_ADDR'];
		FormsModels::mdlLog($_SESSION['idUser'], 'Enable provider: '.$_POST['enableProvider'], $ip);
	}

	echo $enableProvider;
}
if (isset($_POST['deleteProvider'])) {
	$deleteProvider = FormsController::ctrDeleteProvider($_POST['deleteProvider']);
	
	if ($deleteProvider == 'ok'){
		session_start();
		$ip = $_SERVER['REMOTE_ADDR'];
		FormsModels::mdlLog($_SESSION['idUser'], 'Delete provider: '.$_POST['deleteProvider'], $ip);
	}

	echo $deleteProvider;
}

if (isset($_POST['deleteRequest'])) {
	$deleteRequest = FormsController::ctrDeleteRequest($_POST['deleteRequest']);
	
	if ($deleteRequest == 'ok'){
		session_start();
		$ip = $_SERVER['REMOTE_ADDR'];
		FormsModels::mdlLog($_SESSION['idUser'], 'Delete request: '.$_POST['deleteRequest'], $ip);
	}

	echo $deleteRequest;
}

if (isset($_POST['area']) && isset($_POST['requestedAmount']) && isset($_POST['description']) && isset($_POST['budget'])) {

	session_start();
	$data =  array(
		'idUser' => $_SESSION['idUser'],
		'area' => $_POST['area'],
		'requestedAmount' => $_POST['requestedAmount'],
		'description' => $_POST['description'],
		'provider' => $_POST['provider'],
		'eventDate' => $_POST['eventDate'],
		'folio' => $_POST['folio'],
		'budget' => $_POST['budget']
	);
	$response = FormsController::ctrRequestBudget($data);
	
	if ($response != 'Error'){
		$ip = $_SERVER['REMOTE_ADDR'];
		FormsModels::mdlLog($_SESSION['idUser'], 'Create request: '.$_POST['requestedAmount'], $ip);
	}

	echo $response;
}

if (isset($_POST['denegateRequest'])) {
	$denegateRequest = FormsController::ctrDenegateRequest($_POST['denegateRequest'], $_POST['idAdmin'], $_POST['comentRechazo']);
	
	if ($denegateRequest == 'ok'){
		session_start();
		$ip = $_SERVER['REMOTE_ADDR'];
		FormsModels::mdlLog($_SESSION['idUser'], 'Denegate request: '.$_POST['denegateRequest'], $ip);
	}

	echo $denegateRequest;
}

if (isset($_POST['enableRequest'])) {
	$response = FormsController::ctrEnableRequest($_POST['enableRequest'], $_POST['idAdmin'], $_POST['approvedAmount']);
	if ($response == 'ok') {
		FormsController::ctrMonthBudget($_POST['idArea'], $_POST['idBudget'], $_POST['approvedAmount']);

		session_start();
		$ip = $_SERVER['REMOTE_ADDR'];
		FormsModels::mdlLog($_SESSION['idUser'], 'Enable request: '.$_POST['enableRequest'], $ip);
	}
	echo $response;
}

if (isset($_POST['searchRequest'])) {
	echo json_encode(FormsController::ctrGetRequestComprobar($_POST['searchRequest']));
}

if (
	isset($_POST['nombreCompleto']) &&
	isset($_POST['fechaSolicitud']) &&
	isset($_POST['provider']) &&
	isset($_POST['area']) &&
	isset($_POST['importeSolicitado']) &&
	isset($_POST['importeLetra']) &&
	isset($_POST['titularCuenta']) &&
	isset($_POST['entidadBancaria']) &&
	isset($_POST['conceptoPago']) &&
	isset($_POST['idRequest']) &&
	isset($_POST['idUser'])
) {
	$data = array(
		'nombreCompleto' => $_POST['nombreCompleto'],
		'fechaSolicitud' => $_POST['fechaSolicitud'],
		'provider' => $_POST['provider'],
		'area' => $_POST['area'],
		'importeSolicitado' => $_POST['importeSolicitado'],
		'importeLetra' => $_POST['importeLetra'],
		'titularCuenta' => $_POST['titularCuenta'],
		'entidadBancaria' => $_POST['entidadBancaria'],
		'conceptoPago' => $_POST['conceptoPago'],
		'idRequest' => $_POST['idRequest'],
		'idUser' => $_POST['idUser'],
	);
	$response = FormsController::ctrSendComprobation($data);
		session_start();
		$ip = $_SERVER['REMOTE_ADDR'];
		FormsModels::mdlLog($_SESSION['idUser'], 'Send comprobation: '.$_POST['idRequest'], $ip);
		
		$request = FormsController::ctrGetRequest($_POST['idRequest']);
		$user = FormsController::ctrGetUser($_POST['idUser']);
		// if ($response == 'ok') {
		// 	// Mensaje del correo electrónico
		// 	$message = array(
		// 		0 => 'Estimados colaboradores:',
		// 		1 => 'El sistema ha recibido la comprobación del presupuesto',
		// 		2 => 'Folio com´probado: '.$request['folio'],
		// 		3 => 'Monto comprobado: $'.$request['approvedAmount']
		// 	);
	
		// 	// Dirección de correo electrónico del destinatario
		// 	$email = $user['email'];
	
		// 	// Asunto del correo electrónico
		// 	$subject = 'Actualización del estado del presupuesto';
	
		// 	// Título del correo electrónico
		// 	$title = 'Actualización del estado del presupuesto';
	
		// 	// Subtítulo del correo electrónico
		// 	$subtitle = 'Detalles del presupuesto actualizado';
	
		// 	// Envío del correo electrónico
		// 	FormsModels::mdlSendEmail($email, $message, $subject, $title, $subtitle);
		// }

	echo $response;
}

if (isset($_POST['idPaymentRequest'])) {
    $data = array(
        'idPaymentRequest' => $_POST['idPaymentRequest'],
        'file' => $_FILES['file']['name']
    );
    $targetDir = "../../view/documents/requestTemp/" . $_POST['idRequest'] . "/";
    $fileName = basename($_FILES["file"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    $allowTypes = array('xml', 'pdf');
    if (in_array($fileType, $allowTypes)) {
        // Mover los nuevos archivos
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
            session_start();
            $ip = $_SERVER['REMOTE_ADDR'];
            FormsModels::mdlLog($_SESSION['idUser'], 'Send files comprobation: '.$fileName, $ip);
            
            // Obtener la ruta de la carpeta de archivos temporales existente
            $tempDir = "../../view/documents/requestTemp/" . $_POST['idRequest'] . "/";
            // Obtener la ruta de destino para los archivos existentes
            $newTargetDir = $targetDir;
            // Mover los archivos existentes a la nueva ubicación
            if (file_exists($tempDir)) {
                $files = glob($tempDir . "*");
                foreach ($files as $file) {
                    $newFilePath = $newTargetDir . basename($file);
                    rename($file, $newFilePath);
                }
                // Eliminar la carpeta de archivos temporales
                rmdir($tempDir);
            }
            
            echo 'ok';
        } else {
            echo 'Error';
        }
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'Solo se permiten archivos de imagen (.pdf, xml).'));
    }
    $idRequest = $_POST['idRequest'];
}

if (isset($_POST['idPaymentRequestTemp'])) {
	$data = array(
		'idPaymentRequestTemp' => $_POST['idPaymentRequestTemp'],
		'file' => $_FILES['file']['name']
	);
	$targetDir = "../../view/documents/requestTemp/" . $_POST['idPaymentRequestTemp'] . "/";
	$fileName = basename($_FILES["file"]["name"]);
	$targetFilePath = $targetDir . $fileName;
	$fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

	if (!file_exists($targetDir)) {
		mkdir($targetDir, 0777, true);
	}

	$allowTypes = array('xml', 'pdf');
	if (in_array($fileType, $allowTypes)) {
		if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {

			session_start();
			$ip = $_SERVER['REMOTE_ADDR'];
			FormsModels::mdlLog($_SESSION['idUser'], 'Send files comprobation: '.$fileName, $ip);
			
			echo 'ok';
		} else {
			echo 'Error';
		}
	} else {
		echo json_encode(array('status' => 'error', 'message' => 'Solo se permiten archivos de imagen (.pdf, xml).'));
	}
}

if (isset($_POST['newProvider'])) {
	$targetDir = "../../view/providers/" . $_POST['newProvider'] . "/";
	$fileName = basename($_POST['document'].'.pdf');
	$targetFilePath = $targetDir . $fileName;
	$fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

	if (!file_exists($targetDir)) {
		mkdir($targetDir, 0777, true);
	}

		if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {

			session_start();
			$ip = $_SERVER['REMOTE_ADDR'];
			FormsModels::mdlLog($_SESSION['idUser'], 'Send files providers: '.$fileName, $ip);
			
			echo 'ok';
		} else {
			echo 'Error';
		}
}

if (isset($_POST['searchComprobante'])) {
	echo json_encode(FormsController::ctrGetComprobante($_POST['searchComprobante']));
}

if (isset($_POST['getDocuments'])) {
	$idRequest = $_POST['getDocuments'];
	$directoryPath = "../../view/documents/requestTemp/" . $idRequest . "/";
	$files = [];

	// Comprobar si la carpeta existe
	if (file_exists($directoryPath)) {
		foreach (new DirectoryIterator($directoryPath) as $file) {
			if ($file->isFile()) {
				$files[] = $file->getFilename();
			}
		}

		// Devolver los nombres de los archivos en formato JSON
		echo json_encode($files);
	} else {
		// Carpeta no existe
		echo json_encode([]);
	}
}

if (isset($_POST['getDocumentsTemp'])) {
	$idRequest = $_POST['getDocumentsTemp'];
	$directoryPath = "../../view/documents/requestTemp/" . $idRequest . "/";
	$files = [];

	// Comprobar si la carpeta existe
	if (file_exists($directoryPath)) {
		foreach (new DirectoryIterator($directoryPath) as $file) {
			if ($file->isFile()) {
				$files[] = $file->getFilename();
			}
		}

		// Devolver los nombres de los archivos en formato JSON
		echo json_encode($files);
	} else {
		// Carpeta no existe
		echo json_encode([]);
	}
}

if (isset($_POST['denegateComprobante'])) {
	$response = FormsController::ctrResponceRequest($_POST['denegateComprobante'], 4, $_POST['comentario']);
	
	if ($response == 'ok'){
		session_start();
		$ip = $_SERVER['REMOTE_ADDR'];
		FormsModels::mdlLog($_SESSION['idUser'], 'Denegate comprobation: '.$_POST['denegateComprobante'], $ip);
	}

	echo $response;
}

if (isset($_POST['aceptComprobante'])) {
	$response = FormsController::ctrResponceRequest($_POST['aceptComprobante'], 5, $_POST['comentario']);
	
	if ($response == 'ok'){
		session_start();
		$ip = $_SERVER['REMOTE_ADDR'];
		FormsModels::mdlLog($_SESSION['idUser'], 'Acept comprobation: '.$_POST['aceptComprobante'], $ip);
	}
	echo $response;
}

if (isset($_POST['comments'])) {
	$response = FormsController::ctrCommentsRequest($_POST['comments']);
	
	if ($response == 'ok'){
		session_start();
		$ip = $_SERVER['REMOTE_ADDR'];
		FormsModels::mdlLog($_SESSION['idUser'], 'Comment comprobation: '.$_POST['comments'], $ip);
	}
	echo $response;
}

if (isset($_POST['verificacion'])) {
	$response = FormsController::ctrVerificacionArea($_POST['verificacion']);
	echo $response;
}

if (isset($_POST['verificacion2'])) {
	$response = FormsController::ctrVerificacionDeudas($_POST['verificacion2']);
	echo $response;
}

if (isset($_POST['marcarPago'])) {
	$response = FormsController::ctrMarcarPago($_POST['marcarPago'], $_POST['idUser']);
	echo $response;
}

if (isset($_POST['areaEdit']) && isset($_POST['requestedAmountEdit']) && isset($_POST['descriptionEdit']) && isset($_POST['eventDateEdit']) && isset($_POST['budgetEdit']) && isset($_POST['providerEdit'])) {

	$datos = array(
		'area' => $_POST['areaEdit'],
        'requestedAmount' => $_POST['requestedAmountEdit'],
        'description' => $_POST['descriptionEdit'],
        'event' => $_POST['eventEdit'],
        'eventDate' => $_POST['eventDateEdit'],
        'budget' => $_POST['budgetEdit'],
        'provider' => $_POST['providerEdit'],
		'idRequest' => $_POST['requestEdit']
	);

    $response = FormsController::ctrUpdateRequest($datos);
    echo $response;

}

if (isset($_POST['verRespuesta'])) {
    echo json_encode(FormsController::ctrGetRequest($_POST['verRespuesta']));
}

if (isset($_POST['changePaymentDate']) && isset($_POST['paymentDate'])) {
	$response = FormsController::ctrChangePaymentDate($_POST['changePaymentDate'], $_POST['paymentDate']);
    echo $response;
}

if (
	isset($_POST['solicitante_nombre']) &&
	isset($_POST['empresa']) &&
	isset($_POST['area']) &&
	isset($_POST['cuentaAfectada']) &&
	isset($_POST['partidaAfectada']) &&
	isset($_POST['concepto']) &&
	isset($_POST['requestedAmount']) &&
	isset($_POST['fechaPago']) &&
	isset($_POST['provider']) &&
	isset($_POST['conceptoPago']) &&
	isset($_POST['folio']) &&
	isset($_POST['idBudget']) &&
	isset($_POST['budget']) &&
	isset($_POST['idUser']) &&
	isset($_POST['idEmployer']) &&
	isset($_POST['idAreaCargo']) &&
	isset($_POST['idCuentaAfectada']) &&
	isset($_POST['idPartidaAfectada']) &&
	isset($_POST['idConcepto']) &&
	isset($_POST['importeLetra']) &&
	isset($_POST['clabe']) &&
	isset($_POST['bank_name']) &&
	isset($_POST['account_number']) &&
	isset($_POST['swiftCode']) &&
	isset($_POST['beneficiaryAddress']) &&
	isset($_POST['currencyType'])
) {
	$data = array(
		'solicitante_nombre' => $_POST['solicitante_nombre'],
		'empresa' => $_POST['empresa'],
		'concepto' => $_POST['concepto'],
		'importe_solicitado' => $_POST['requestedAmount'],
		'importe_letra' => $_POST['importeLetra'],
		'fecha_pago' => $_POST['fechaPago'],
		'clabe' => $_POST['clabe'],
		'banco' => $_POST['bank_name'],
		'numero_cuenta' => $_POST['account_number'],
		'concepto_pago' => $_POST['conceptoPago'],
		'cuentaAfectada' => $_POST['cuentaAfectada'],
		'partidaAfectada' => $_POST['partidaAfectada'],
		
		
		'idUser' => $_POST['idUser'],
		'idArea' => $_POST['area'],
		'idBudget' => $_POST['budget'],
		'idProvider' => $_POST['provider'],

		'idEmployer' => ($_POST['idEmployer'] == '') ? null : $_POST['idEmployer'],
		'idAreaCargo' => ($_POST['idAreaCargo'] == '') ? null : $_POST['idAreaCargo'],
		'idCuentaAfectada' => ($_POST['idCuentaAfectada'] == '') ? null : $_POST['idCuentaAfectada'],
		'idPartidaAfectada' => ($_POST['idPartidaAfectada'] == '') ? null : $_POST['idPartidaAfectada'],
		'idConcepto' => ($_POST['idConcepto'] == '') ? null : $_POST['idConcepto'],
		
		'swift_code' => ($_POST['swiftCode'] == '') ? null : $_POST['swiftCode'],
		'beneficiario_direccion' => ($_POST['beneficiaryAddress'] == '') ? null : $_POST['beneficiaryAddress'],
		'tipo_divisa' => ($_POST['currencyType'] == '') ? null : $_POST['currencyType'],
		'folio' => $_POST['folio'],
	);
	$response = FormsController::ctrRequestBudget($data);
	echo $response;
}
