<?php 

class FormsController {

	static public function ctrCreateUser($data){
		$createUser = FormsModels::mdlCreateUser($data);
		return $createUser;
	}

	static public function ctrGetUsers(){
		$getUser = FormsModels::mdlGetUsers();

    	return json_encode($getUser);
	}

	static public function ctrLoginUser($data){
		$selectUser = FormsModels::mdlSelectUser($data['email']);
		if (!empty($selectUser) && $selectUser['password'] == ''){
			$loginUser = FormsModels::mdlFirstLoginUser($selectUser['idUsers'], $data['password']);
			return "ok";
		} elseif (!empty($selectUser) && $selectUser['password'] == $data['password']) {
			$updateLog = FormsModels::mdlUpdateLog($selectUser['idUsers']);
			$_SESSION('Sesion') = 'ok';
			return "ok";
		} else {
			return "Error";
		}
	}
	
}
