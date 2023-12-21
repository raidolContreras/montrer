<?php 

class FormsController {

	static public function ctrCreateUser($data){
		return FormsModels::mdlCreateUser($data);
	}

	static public function ctrGetUsers(){
		$getUser = FormsModels::mdlGetUsers();
    	return json_encode($getUser);
	}

	static public function ctrLoginUser($data){
		$value = '';
		$selectUser = FormsModels::mdlSelectUser($data['email']);
		
		$cryptPassword = crypt($data['password'], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

		if (!empty($selectUser) && $selectUser['password'] == ''){
			$loginUser = FormsModels::mdlFirstLoginUser($selectUser['idUsers']);
			if($loginUser['temporal_password'] == $cryptPassword){
				$changedPass = 1;
				FormsModels::mdlUpdateLog($selectUser['idUsers']);
				$value = "ok";
			} else {
				$changedPass = 0;
				$value = "Error";
				$selectUser = "Error: correo no existente";
			}
		} elseif (!empty($selectUser) && $selectUser['password'] == $cryptPassword) {
			FormsModels::mdlUpdateLog($selectUser['idUsers']);
			$value = "ok";
		} else {
			$value = "error";
			$selectUser = "Error: correo no existente";
		}

		if($value == "ok"){
			$selectUser['changedPass'] = $changedPass;
			$selectUser['sesion'] = $value;
		}
		
		return $selectUser;
	}

	static public function ctrChangePassword($data){

		$searchPassword = FormsModels::mdlDelTemporalPassword($data);
		if ($searchPassword){
			$updatePassword = FormsModels::mdlUpdatePassword($data);
			if ($updatePassword) {
				return "ok";
			} else {
				return "Error: Inexistente";
			}
		} else {
			return "Error: Password";
		}
	   
	}
	
}
