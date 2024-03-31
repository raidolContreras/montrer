<?php 

class FormsController {
	// Inicio de Contadores
	static public function ctrCountAreas(){
		return FormsModels::mdlCountAreas();
	}

	static public function ctrCountArea($idUser){
		return FormsModels::mdlCountArea($idUser);
	}

	static public function ctrCountAreaId($idArea){
		return FormsModels::mdlCountAreaId($idArea);
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

	static public function ctrGetBudgets($idExercise){
		$getBudgets = FormsModels::mdlGetBudgets($idExercise);
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

	static public function ctrGetAreaManager($register){
		$getArea = FormsModels::mdlGetAreaManager($register);
    	return $getArea;
	}

	static public function ctrGetAuthorizedAmount($register){
		$getAuthorizedAmount = FormsModels::mdlGetAuthorizedAmount($register);
    	return $getAuthorizedAmount;
	}

	static public function ctrGetAmountPendient($register){
		$getAuthorizedAmount = FormsModels::mdlGetAmountPendient($register);
    	return $getAuthorizedAmount;
	}

	static public function ctrGetProviders(){
		$getProvider = FormsModels::mdlGetProviders();
    	return $getProvider;
	}

	static public function ctrGetRequests($idUser){
		$user = FormsModels::mdlGetUser($idUser);
		if($user['level'] == 1) {
			$selection = 1;
		} else {
			$selection = 2;
		}
		$getRequests = FormsModels::mdlGetRequests($idUser, $selection);
    	return $getRequests;
	}
	
	static public function ctrGetRequestComprobar($idRequest){
		$getRequests = FormsModels::mdlGetRequestComprobar($idRequest);
    	return $getRequests;
	}

	static public function ctrGetProviderON(){
		$getProvider = FormsModels::mdlGetProviderON();
    	return $getProvider;
	}

	static public function ctrRegisterProvider($data){
		$registerProvider = FormsModels::mdlRegisterProvider($data);
    	return $registerProvider;
	}

	static public function ctrNextIdProvider(){
		$nextIdProvider = FormsModels::mdlNextIdProvider();
    	return $nextIdProvider;
	}

	static public function ctrUpdateProvider($data){
		$UpdateProvider = FormsModels::mdlUpdateProvider($data);
    	return $UpdateProvider;
	}

	static public function ctrDenegateRequest($idRequest, $idAdmin){
		$result = FormsModels::mdlDenegateRequest($idRequest, $idAdmin);
    	return $result;
	}

	static public function ctrEnableRequest($idRequest, $idAdmin, $approvedAmount){
		$result = FormsModels::mdlEnableRequest($idRequest, $idAdmin, $approvedAmount);
    	return $result;
	}

	static public function ctrGetRequest($idRequest){
		$result = FormsModels::mdlGetRequest($idRequest);
    	return $result;
	}

	static public function ctrAddBudgets($data){
		$getBudgets = FormsModels::mdlGetBudgets('all');
		$value = true;
		foreach ($getBudgets as $budgets){
			if($budgets['idArea'] == $data['area'] && $budgets['idExercise'] == $data['exercise']){
				$value = false;
			}
		}
		if ($value){
			$Budget = FormsModels::mdlAddBudgets($data);
			$exercise = FormsController::ctrGetExercises($data['exercise']);
			
			// Convertir las fechas a objetos DateTime para facilitar el cálculo
			$initialDate = new DateTime($exercise['initialDate']);
			$finalDate = new DateTime($exercise['finalDate']);
			
			$initialMonth = (int)$initialDate->format('n');
			$finalMonth = (int)$finalDate->format('n');
			$months = 0;
			for ($i = $initialMonth; $i <= $finalMonth; $i++) {
				$months++;
			}

			$budget_month = $data['AuthorizedAmount'] / $months;

			$budget_month_formatted = sprintf("%.2f", $budget_month);

			for ($i = $initialMonth; $i <= $finalMonth; $i++) {
				$datos = array(
					'budget_month' => $budget_month_formatted,
					'idBudget' => $Budget,
				);
				$addBudgetMonth = FormsModels::mdlAddBudgetsMonths($i, $datos);
			}

			if ($addBudgetMonth == 'ok'){
				return $addBudgetMonth;
			} else {
				$result = 'Error: Presupuesto ya asignado';
			}


		} else {
			$result = 'Error: Presupuesto ya asignado';
		}
    	return $result;
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

	static public function ctrChangePasswordAdmin($data){

		$temporal = FormsModels::mdlFirstLoginUser($data['user']);

		if (!empty($temporal)) {
			$dataTemp = array(
				'user' => $temporal['User_idUser'],
				'actualPassword' => $temporal['temporal_password'],
			);
			FormsModels::mdlDelTemporalPassword($dataTemp);
		}

		$updatePassword = FormsModels::mdlUpdatePassword($data);
		if ($updatePassword) {
			return "ok";
		} else {
			return "Error: Inexistente";
		}
	   
	}

	static public function ctrChangeNewPassword($data){

		$searchPassword = FormsModels::mdlSelectPasswordUser($data['user']);
		if ($searchPassword['password'] === $data['ActualPassword']){
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
		FormsModels::mdlUpdateLevelUser($data);
		
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
		$selectArea = FormsModels::mdlSelectAreaUser($idUsers);
		if (!empty($selectArea)) {
			foreach ($selectArea as $area) {
				FormsModels::mdlNullAreaUser($area['idArea']);
			}
		}
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

	static public function ctrDisableProvider($idProvider){
		$disableProvider = FormsModels::mdlDisableProvider($idProvider);
		return $disableProvider;
	}

	static public function ctrEnableProvider($idProvider){
		$enableProvider = FormsModels::mdlEnableProvider($idProvider);
		return $enableProvider;
	}

	static public function ctrDeleteProvider($idProvider){
		$deleteProvider = FormsModels::mdlDeleteProvider($idProvider);
		return $deleteProvider;
	}

	static public function ctrGetProvider($idProvider){
		$getProvider = FormsModels::mdlGetProvider($idProvider);
		return $getProvider;
	}

	static public function ctrRequestBudget($data){
		$requestBudget = FormsModels::mdlRequestBudget($data);
		return $requestBudget;
	}

	static public function ctrDeleteRequest($idRequests){
		$deleteRequest = FormsModels::mdlDeleteRequest($idRequests);
		return $deleteRequest;
	}

	static public function ctrMonthBudget($idArea, $idBudget, $approvedAmount){
		// Obtén el mes actual
		$currentMonth = date('n'); // n devuelve el número del mes sin ceros iniciales
	
		// Obtiene los datos de la base de datos
		$month_budgets = FormsModels::mdlGetMonthBudget($idBudget);
	
		// Inicializa la suma de los presupuestos hasta el mes actual
		$sumaBudgetMonth = 0;
		
		// Recorre los datos para calcular la suma de los presupuestos hasta el mes actual
		foreach ($month_budgets as $month_budget) {
			if ($month_budget['month'] <= $currentMonth) {
				$budgetMonth = floatval($month_budget['budget_month']);
				$budgetUsed = floatval($month_budget['budget_used']);
				
				$sumaBudgetMonth = ($budgetMonth - $budgetUsed);
				if($approvedAmount >= $sumaBudgetMonth) {
					$budget = FormsModels::mdlFillBudgetMouth($month_budget['idMensualBudget'], $month_budget['budget_month']);
					if($budget == 'ok') {
						$approvedAmount = $approvedAmount - $sumaBudgetMonth;
					}
				} elseif($approvedAmount < $sumaBudgetMonth) {
					$budget = FormsModels::mdlFillBudgetMouth($month_budget['idMensualBudget'], $approvedAmount);
					if($budget == 'ok') {
						$approvedAmount = 0;
					}
				}
			}
		}
	}

	static public function ctrSendComprobation($data){
        $sendComprobation = FormsModels::mdlSendComprobation($data);
        return $sendComprobation;
    }

	static public function ctrGetComprobante($idRequest){
        $getComprobante = FormsModels::mdlGetComprobante($idRequest);
        return $getComprobante;
    }

	static public function ctrResponceRequest($idRequest, $responce, $comentario){
        return FormsModels::mdlResponceRequest($idRequest, $responce, $comentario);
    }
	static public function ctrCommentsRequest($idRequest){
        return json_encode(FormsModels::mdlCommentsRequest($idRequest));
    }
	
	static public function ctrVerificacionArea($idUser){
        return json_encode(FormsModels::mdlVerificacionArea($idUser));
    }
	
	static public function ctrVerificacionDeudas($idUser){
        return json_encode(FormsModels::mdlVerificacionDeudas($idUser));
    }
	
	static public function ctrGetLogs($idUser){
        return FormsModels::mdlGetLogs($idUser);
    }
	
	static public function ctrMarcarPago($idRequest,$idUser){
        return FormsModels::mdlMarcarPago($idRequest,$idUser);
    }
	
	static public function ctrSearchRequest($idRequest){
        return FormsModels::mdlSearchRequest($idRequest);
    }

	static public function ctrUpdateRequest($datos){
        return FormsModels::mdlUpdateRequest($datos);
    }
}
