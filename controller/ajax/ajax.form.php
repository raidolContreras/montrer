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
	
	$_SESSION['sesion'] = $loginUser['sesion'];
	$_SESSION['idUser'] = $loginUser['idUsers'];
	$_SESSION['firstname'] = $loginUser['firstname'];
	$_SESSION['lastname'] = $loginUser['lastname'];
	$_SESSION['email'] = $loginUser['email'];
	$_SESSION['changedPass'] = $loginUser['changedPass'];

	echo $_SESSION['sesion'];

}