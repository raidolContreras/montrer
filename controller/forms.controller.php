<?php 

class FormsController {
	// Inicio de Contadores
	static public function ctrCountAreas(){
		return FormsModels::mdlCountAreas();
	}
	// Fin de Contadores

	static public function ctrActiveExercise(){
		return FormsModels::mdlActiveExercise();
	}

	static public function ctrUpdateActiveExercise($idExercise){
		return FormsModels::mdlUpdateActiveExercise($idExercise);
	}

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

	static public function ctrGetExercises($idExercise){
		$getExercise = FormsModels::mdlGetExercises($idExercise);
    	return $getExercise;
	}

	static public function ctrGetBudgets(){
		$getBudgets = FormsModels::mdlGetBudgets();
    	return $getBudgets;
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

	static public function ctrGetUser($register){
		$getUser = FormsModels::mdlGetUser($register);
    	return $getUser;
	}

	static public function ctrGetArea($register){
		$getArea = FormsModels::mdlGetArea($register);
    	return $getArea;
	}

	static public function ctrAddBudgets($data){
		$getBudgets = FormsModels::mdlGetBudgets();
		$value = true;
		foreach ($getBudgets as $budgets){
			if($budgets['idArea'] == $data['area'] && $budgets['idExercise'] == $data['exercise']){
				$value = false;
			}
		}
		if ($value){
			$addBudgets = FormsModels::mdlAddBudgets($data);
		} else {
			$addBudgets = 'Error: Presupuesto ya asignado';
		}
    	return $addBudgets;
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
				$selectUser['sesion'] = "ok";
				$selectUser['changedPass'] = $changedPass;
			} else {
				$changedPass = 0;
				$value = "Error";
				$selectUser = "Error: correo no existente";
			}
		} elseif (!empty($selectUser) && $selectUser['password'] == $cryptPassword && $selectUser['status'] == 1) {
			FormsModels::mdlUpdateLog($selectUser['idUsers']);
			$changedPass = 0;
			$selectUser['changedPass'] = $changedPass;
			$selectUser['sesion'] = "ok";
		} elseif ($selectUser['status'] == 0) {
			$changedPass = 0;
			$value = "status off";
			$selectUser['changedPass'] = $changedPass;
			$selectUser['sesion'] = $value;
		} else {
			$value = "error";
			$selectUser = "Error: datos incorrectos";
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

	static public function ctrUpdateUser($data){
		$updateUser = FormsModels::mdlUpdateUser($data);
		return $updateUser;
	}

	static public function ctrDeleteRegister($idUsers){
		$deleteRegister = FormsModels::mdlDeleteRegister($idUsers);
		return $deleteRegister;
	}

	static public function ctrEnableRegister($idUsers){
		$enableRegister = FormsModels::mdlEnableRegister($idUsers);
		return $enableRegister;
	}

	static public function ctrDisableArea($idArea){
		$disableArea = FormsModels::mdlDisableArea($idArea);
		return $disableArea;
	}

	static public function ctrEnableArea($idArea){
		$enableArea = FormsModels::mdlEnableArea($idArea);
		return $enableArea;
	}

	static public function ctrUpdateArea($data){
		$updateArea = FormsModels::mdlUpdateArea($data);
		return $updateArea;
	}

	static public function ctrUpdateExercise($data){
		$updateExercise = FormsModels::mdlUpdateExercise($data);
		return $updateExercise;
	}

	static public function ctrDisableExercise($idExercise){
		$disableExercise = FormsModels::mdlDisableExercise($idExercise);
		return $disableExercise;
	}

	static public function ctrEnableExercise($idExercise){
		$enableExercise = FormsModels::mdlEnableExercise($idExercise);
		return $enableExercise;
	}

	static public function ctrDeleteExercise($idExercise){
		$deleteExercise = FormsModels::mdlDeleteExercise($idExercise);
		return $deleteExercise;
	}

	static public function ctrDeleteUser($idUsers){
		$deleteUser = FormsModels::mdlDeleteUser($idUsers);
		return $deleteUser;
	}

	static public function ctrDeleteArea($idArea){
		$deleteArea = FormsModels::mdlDeleteArea($idArea);
		return $deleteArea;
	}

	static public function ctrDeleteBudget($idBudget){
		$deleteBudget = FormsModels::mdlDeleteBudget($idBudget);
		return $deleteBudget;
	}

	static public function ctrEnableBudget($idBudget){
		$enableBudget = FormsModels::mdlEnableBudget($idBudget);
		return $enableBudget;
	}

	static public function ctrDisableBudget($idBudget){
		$disableBudget = FormsModels::mdlDisableBudget($idBudget);
		return $disableBudget;
	}

	static public function ctrGetBudget($idBudget){
		$getBudget = FormsModels::mdlGetBudget($idBudget);
		return $getBudget;
	}

	static public function ctrUpdateBudget($data){
		$updateBudget = FormsModels::mdlUpdateBudget($data);
		return $updateBudget;
	}
}
