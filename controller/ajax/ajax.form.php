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
		$_SESSION['sesion'] = $loginUser['sesion'];
		$_SESSION['idUser'] = $loginUser['idUsers'];
		$_SESSION['firstname'] = $loginUser['firstname'];
		$_SESSION['lastname'] = $loginUser['lastname'];
		$_SESSION['email'] = $loginUser['email'];
		$_SESSION['changedPass'] = $loginUser['changedPass'];

		echo $_SESSION['sesion'];
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
