<?php 

class FormsController {

	static public function ctrCreateUser($data){
		return FormsModels::mdlCreateUser($data);
	}

	static public function ctrGetUsers(){
		$getUser = FormsModels::mdlGetUsers();
    	return $getUser;
	}

	static public function ctrGetAreas(){
		$getAreas = FormsModels::mdlGetAreas();
    	return $getAreas;
	}

	static public function ctrGetCompanies(){
		$getCompanies = FormsModels::mdlGetCompanies();
    	return $getCompanies;
	}

	static public function ctrGetExercise(){
		$getExercise = FormsModels::mdlGetExercise();
    	return $getExercise;
	}

	static public function ctrAddCompany($data){
		$addCompany = FormsModels::mdlAddCompany($data);
    	return $addCompany;
	}

	static public function ctrAddLogo($data){
		$addLogo = FormsModels::mdlAddLogo($data);
    	return $addLogo;
	}

	static public function ctrAddExercise($data){
		$addExercise = FormsModels::mdlAddExercise($data);
    	return $addExercise;
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
			$changedPass = 0;
			$value = "ok";
		} else {
			$value = "error";
			$selectUser = "Error: datos incorrectos";
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
	
	static public function ctrAddArea($data){
	   $addArea = FormsModels::mdlAddArea($data);
	   return $addArea;
	}
}
