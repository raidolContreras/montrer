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
			}
		} elseif (!empty($selectUser) && $selectUser['password'] == $cryptPassword) {
			FormsModels::mdlUpdateLog($selectUser['idUsers']);
			$value = "ok";
		} else {
			$value = "Error: correo no existente";
		}

		if($value == "ok"){
			$_SESSION['Sesion'] = 'ok';
			$_SESSION['idUser'] = $selectUser['idUsers'];
			$_SESSION['firstname'] = $selectUser['firstname'];
			$_SESSION['lastname'] = $selectUser['lastname'];
			$_SESSION['email'] = $selectUser['email'];
			$_SESSION['changedPass'] = $changedPass;
		}
		
		return $value;
	}
	
}
