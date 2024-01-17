<?php 

require_once "../forms.controller.php";
require_once "../../model/forms.models.php";

session_start();
	class AjaxForm {

		static function CreateUser($data){
			$createUser = FormsController::ctrCreateUser($data);
			return $createUser;
		}

		static function LoginUser($data){
			$loginUser = FormsController::ctrLoginUser($data);
			return $loginUser;
		}

		static function ChangePassword($data){
			$changePassword = FormsController::ctrChangePassword($data);
			return $changePassword;
		}

		static function AddArea($data){
			$addArea = FormsController::ctrAddArea($data);
			return $addArea;
		}

		static function AddCompany($data){
			$addCompany = FormsController::ctrAddCompany($data);
			return $addCompany;
		}

		static public function AddLogo($data){
			$addLogo = FormsController::ctrAddLogo($data);
			return $addLogo;
		}

		static public function AddExercise($data){
			$addExercise = FormsController::ctrAddExercise($data);
			return $addExercise;
		}

		static public function AddBudgets($data){
			$addBudgets = FormsController::ctrAddBudgets($data);
			return $addBudgets;
		}

		static public function UpdateUser($data){
			$updateUser = FormsController::ctrUpdateUser($data);
			return $updateUser;
		}

		static public function DeleteRegister($idUsers){
			$deleteRegister = FormsController::ctrDeleteRegister($idUsers);
			return $deleteRegister;
		}

		static public function EnableRegister($idUsers){
			$enableRegister = FormsController::ctrEnableRegister($idUsers);
			return $enableRegister;
		}

		static public function DisableArea($idArea){
			$disableArea = FormsController::ctrDisableArea($idArea);
			return $disableArea;
		}

		static public function EnableArea($idArea){
			$enableArea = FormsController::ctrEnableArea($idArea);
			return $enableArea;
		}

		static public function UpdateArea($data){
			$updateArea = FormsController::ctrUpdateArea($data);
			return $updateArea;
		}

		static public function UpdateExercise($data){
			$updateExercise = FormsController::ctrUpdateExercise($data);
			return $updateExercise;
		}

		static public function disableExercise($idExercise){
			$disableExercise = FormsController::ctrDisableExercise($idExercise);
			return $disableExercise;
		}

		static public function enableExercise($idExercise){
			$enableExercise = FormsController::ctrEnableExercise($idExercise);
			return $enableExercise;
		}

		static public function deleteExercise($idExercise){
			$deleteExercise = FormsController::ctrDeleteExercise($idExercise);
			return $deleteExercise;
		}

		static public function deleteUser($idUsers){
			$deleteUser = FormsController::ctrDeleteUser($idUsers);
			return $deleteUser;
		}

		static public function deleteArea($idArea){
			$deleteArea = FormsController::ctrDeleteArea($idArea);
			return $deleteArea;
		}

	}

if (isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['email']) && isset($_POST['level'])) {

	$data = array(
		'firstname' => $_POST['firstname'],
		'lastname' => $_POST['lastname'],
		'email' => $_POST['email'],
		'level' => $_POST['level']
	);

	$createUser = AjaxForm::CreateUser($data);
	echo $createUser;

}

if (isset($_POST['email']) && isset($_POST['password'])) {

	$data = array(
		'email' => $_POST['email'],
		'password' => $_POST['password']
	);

	$loginUser = AjaxForm::LoginUser($data);

	if (!isset($loginUser['sesion'])) {
		print_r( $loginUser);
	} else {
		if ($loginUser['sesion'] == 'ok'){
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

	$data = array(
		'actualPassword' => crypt($_POST['actualPassword'], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$'),
		'newPassword' => crypt($_POST['newPassword'], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$'),
		'user' => $_POST['user']
	);

	$changePassword = AjaxForm::ChangePassword($data);

	if ($changePassword == 'ok'){
		$_SESSION['changedPass'] = 0;
	}
	echo $changePassword;
}

if (isset($_POST['areaName']) && isset($_POST['areaDescription']) && isset($_POST['user'])) {
	
	$data = array(
		'nameArea' =>  $_POST['areaName'],
		'areaDescription' =>  $_POST['areaDescription'],
		'user' => $_POST['user']
	);
	$addArea = AjaxForm::AddArea($data);
	echo $addArea;
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
	$data = array (
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
	$data = array (
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

if (isset($_POST['enableExercise'])){
	$enableExercise = AjaxForm::enableExercise($_POST['enableExercise']);
	echo $enableExercise;
}

if (isset($_POST['disableExercise'])){
	$disableExercise = AjaxForm::disableExercise($_POST['disableExercise']);
	echo $disableExercise;
}

if (isset($_POST['deleteExercise'])){
	$deleteExercise = AjaxForm::deleteExercise($_POST['deleteExercise']);
	echo $deleteExercise;
}

if (isset($_POST['deleteUser'])){
	$deleteUser = AjaxForm::deleteUser($_POST['deleteUser']);
	echo $deleteUser;
}

if (isset($_POST['deleteArea'])){
	$deleteArea = AjaxForm::deleteArea($_POST['deleteArea']);
	echo $deleteArea;
}
