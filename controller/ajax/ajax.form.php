<?php 

require_once "../forms.controller.php";
require_once "../../model/forms.models.php";

	class AjaxForm {

		static function CreateUser($data){

			$createUser = FormsController::ctrCreateUser($data);
			return $createUser;

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