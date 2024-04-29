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
		if ($addArea == 'ok') {
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

	static public function AddLogo($data)
	{
		$addLogo = FormsController::ctrAddLogo($data);
		return $addLogo;
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
		$deleteUser = FormsController::ctrDeleteUser($idUsers);
		if ($deleteUser == 'ok') {
			session_start();
			$ip = $_SERVER['REMOTE_ADDR'];
			FormsModels::mdlLog($_SESSION['idUser'], 'Delete user: ' . $idUsers, $ip);
		}
		return $deleteUser;
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

if (isset($_POST['areaName']) && isset($_POST['areaDescription']) && isset($_POST['user'])) {
	$require = FormsController::ctrGetAreaByName($_POST['areaName']);
	if ($require == false) {
		$data = array(
			'nameArea' =>  $_POST['areaName'],
			'areaDescription' =>  $_POST['areaDescription'],
			'user' => $_POST['user']
		);
		$addArea = AjaxForm::AddArea($data);
		echo $addArea;
	} else {
		echo 'Error: El departamento ya existe';
	}
}

if (isset($_POST['companyName']) && isset($_POST['colors']) && isset($_POST['companyDescription'])) {
	$data = array(
		'companyName' => $_POST['companyName'],
		'colors' => $_POST['colors'],
		'companyDescription' => $_POST['companyDescription'],
	);
	$addCompany = AjaxForm::AddCompany($data);
	echo $addCompany;
}

if (isset($_POST['idCompany']) && isset($_FILES['logo'])) {
	$data = array(
		'idCompany' => $_POST['idCompany'],
		'logo' => $_FILES['logo']['name']
	);

	$addLogo = AjaxForm::AddLogo($data);

	if ($addLogo == 'ok') {
		$targetDir = "../../assets/img/companies/" . $_POST['idCompany'] . "/"; // Reemplaza con la ruta adecuada
		$fileName = basename($_FILES["logo"]["name"]);
		$targetFilePath = $targetDir . $fileName;
		$fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

		// Verifica si la carpeta existe, si no, la crea
		if (!file_exists($targetDir)) {
			mkdir($targetDir, 0777, true);
		}

		// Verificar si el archivo es una imagen
		$allowTypes = array('jpg', 'jpeg', 'png');
		if (in_array($fileType, $allowTypes)) {
			// Mover el archivo al directorio de destino
			if (move_uploaded_file($_FILES["logo"]["tmp_name"], $targetFilePath)) {
				echo json_encode(array('status' => 'success', 'logoUrl' => $targetFilePath));
			} else {
				echo json_encode(array('status' => 'error', 'message' => 'Error al cargar el archivo.'));
			}
		} else {
			echo json_encode(array('status' => 'error', 'message' => 'Solo se permiten archivos de imagen (jpg, jpeg, png).'));
		}
	}
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
	$deleteArea = AjaxForm::deleteArea($_POST['deleteArea']);
	echo $deleteArea;
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
	isset($_POST['clabe'])
) {

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
		'clabe' => $_POST['clabe']
	);

	$registerProvider = FormsController::ctrRegisterProvider($data);
	
	if ($registerProvider == 'ok'){
		session_start();
		$ip = $_SERVER['REMOTE_ADDR'];
		FormsModels::mdlLog($_SESSION['idUser'], 'Register provider: '.$_POST['providerKey'], $ip);
	}

	echo $registerProvider;
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
		'clabe' => $_POST['updateclabe']
	);

	$registerProvider = FormsController::ctrUpdateProvider($data);
	
	if ($registerProvider == 'ok'){
		session_start();
		$ip = $_SERVER['REMOTE_ADDR'];
		FormsModels::mdlLog($_SESSION['idUser'], 'Update provider: '.$_POST['providerKey'], $ip);
	}

	echo $registerProvider;
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
		'event' => $_POST['event'],
		'eventDate' => $_POST['eventDate'],
		'folio' => $_POST['folio'],
		'budget' => $_POST['budget']
	);
	$response = FormsController::ctrRequestBudget($data);
	
	if ($response == 'ok'){
		$ip = $_SERVER['REMOTE_ADDR'];
		FormsModels::mdlLog($_SESSION['idUser'], 'Create request: '.$_POST['requestedAmount'], $ip);
	}

	echo $response;
}

if (isset($_POST['denegateRequest'])) {
	$denegateRequest = FormsController::ctrDenegateRequest($_POST['denegateRequest'], $_POST['idAdmin']);
	
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
	if ($response == 'ok'){
		session_start();
		$ip = $_SERVER['REMOTE_ADDR'];
		FormsModels::mdlLog($_SESSION['idUser'], 'Send comprobation: '.$_POST['idRequest'], $ip);
	}
	echo $response;
}

if (isset($_POST['idPaymentRequest'])) {
	$data = array(
		'idPaymentRequest' => $_POST['idPaymentRequest'],
		'file' => $_FILES['file']['name']
	);
	$targetDir = "../../view/documents/" . $_POST['idPaymentRequest'] . "/";
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

if (isset($_POST['searchComprobante'])) {
	echo json_encode(FormsController::ctrGetComprobante($_POST['searchComprobante']));
}

if (isset($_POST['getDocuments'])) {
	$idRequest = $_POST['getDocuments'];
	$directoryPath = "../../view/documents/" . $idRequest . "/";
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

if (isset($_POST['areaEdit']) && isset($_POST['requestedAmountEdit']) && isset($_POST['descriptionEdit']) && isset($_POST['eventEdit']) && isset($_POST['eventDateEdit']) && isset($_POST['budgetEdit']) && isset($_POST['providerEdit'])) {

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