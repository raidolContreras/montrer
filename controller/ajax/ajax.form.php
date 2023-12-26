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