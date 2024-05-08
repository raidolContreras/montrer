<?php 

require_once __DIR__ . '/../assets/vendor/PHP/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\IOFactory;

// the below code fragment can be found in:
use PhpOffice\PhpSpreadsheet\Chart\Chart;
use PhpOffice\PhpSpreadsheet\Chart\DataSeries;
use PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues;
use PhpOffice\PhpSpreadsheet\Chart\PlotArea;
use PhpOffice\PhpSpreadsheet\Chart\Legend;
use PhpOffice\PhpSpreadsheet\Chart\Title;

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

	static public function ctrGetAreaByName($name){
		$getArea = FormsModels::mdlGetAreaByName($name);
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

	static public function ctrGetProviders($provider_idUser){
		$getProvider = FormsModels::mdlGetProviders($provider_idUser);
    	return $getProvider;
	}

	static public function ctrGetRequests($idUser){
		$user = FormsModels::mdlGetUser($idUser);
		if($user['level'] == 1 || $user['level'] == 0) {
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

	static public function ctrDenegateRequest($idRequest, $idAdmin, $comentRechazo){
		$result = FormsModels::mdlDenegateRequest($idRequest, $idAdmin, $comentRechazo);
    	return $result;
	}

	static public function ctrEnableRequest($idRequest, $idAdmin, $approvedAmount){
		$result = FormsModels::mdlEnableRequest($idRequest, $idAdmin, $approvedAmount);
		$request = FormsController::ctrGetRequest($idRequest);
		$user = FormsController::ctrGetUser($request['idUsers']);
		if ($result == 'ok') {
			// Mensaje del correo electrónico
			$message = array(
				0 => 'Estimados colaboradores:',
				1 => 'El estado del presupuesto con el siguiente folio ha sido actualizado:',
				2 => 'Folio del presupuesto: '.$request['folio'],
				3 => 'Monto aprobado: $'.$request['approvedAmount']
			);
	
			// Dirección de correo electrónico del destinatario
			$email = $user['email'];
	
			// Asunto del correo electrónico
			$subject = 'Actualización del estado del presupuesto';
	
			// Título del correo electrónico
			$title = 'Actualización del estado del presupuesto';
	
			// Subtítulo del correo electrónico
			$subtitle = 'Detalles del presupuesto actualizado';
	
			// Envío del correo electrónico
			FormsModels::mdlSendEmail($email, $message, $subject, $title, $subtitle);
		}
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

	static public function ctrGetProviderByName($rfc, $idUser){
		$getProvider = FormsModels::mdlGetProviderByName($rfc, $idUser);
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
        $result = FormsModels::mdlMarcarPago($idRequest,$idUser);
		
		$request = FormsController::ctrGetRequest($idRequest);
		$user = FormsController::ctrGetUser($request['idUsers']);
		if ($result == 'ok') {
			// Mensaje del correo electrónico
			$message = array(
				0 => 'Estimados colaboradores:',
				1 => 'El estado del presupuesto con el siguiente folio ha sido marcado como pagado:',
				2 => 'Folio del presupuesto: '.$request['folio'],
				3 => 'Monto pagado: $'.$request['approvedAmount']
			);
	
			// Dirección de correo electrónico del destinatario
			$email = $user['email'];
	
			// Asunto del correo electrónico
			$subject = 'Actualización del estado del presupuesto';
	
			// Título del correo electrónico
			$title = 'Actualización del estado del presupuesto';
	
			// Subtítulo del correo electrónico
			$subtitle = 'Detalles del presupuesto actualizado';
	
			// Envío del correo electrónico
			FormsModels::mdlSendEmail($email, $message, $subject, $title, $subtitle);
		}

		return $result;
    }
	
	static public function ctrSearchRequest($idRequest){
        return FormsModels::mdlSearchRequest($idRequest);
    }

	static public function ctrUpdateRequest($datos){
        return FormsModels::mdlUpdateRequest($datos);
    }

	static public function ctrMaxRequestBudgets(){
        return FormsModels::mdlMaxRequestBudgets();
    }

    static public function ctrDownloadProviders() {
		// Obtener los proveedores desde el modelo
		$providers = FormsModels::mdlGetProviders(null);
	
		// Crear un nuevo objeto Spreadsheet
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
	
		// Definir los encabezados de las columnas
		$columnHeaders = ['Clave del proveedor', 'Contacto', 'Teléfono', 'Email', 'Página web', 'Razón social', 'RFC', 'Dirección fiscal', 'Banco', 'Titular', 'N° cuenta', 'CLABE'];
	
		// Insertar los encabezados de las columnas y aplicar estilo
		$columnIndex = 65; // ASCII para 'A'
		foreach ($columnHeaders as $header) {
			$sheet->setCellValue(chr($columnIndex) . '1', $header);
			$sheet->getStyle(chr($columnIndex) . '1')->applyFromArray([
				'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
				'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '336699']],
			]);
			$columnIndex++;
		}
	
		// Iterar sobre los proveedores y agregar sus datos al archivo Excel
		$row = 2; // Empezar en la segunda fila
		foreach ($providers as $provider) {
			// Construir la dirección fiscal
			$fiscalAddress = "{$provider['fiscal_address_street']}, {$provider['fiscal_address_colonia']}, {$provider['fiscal_address_municipio']}, {$provider['fiscal_address_estado']}, {$provider['fiscal_address_cp']}";
	
			// Asignar valores a las celdas
			$sheet->setCellValue("A{$row}", $provider['provider_key']);
			$sheet->setCellValue("B{$row}", $provider['representative_name']);
			$sheet->setCellValue("C{$row}", $provider['contact_phone']);
			$sheet->setCellValue("D{$row}", $provider['email']);
			$sheet->setCellValue("E{$row}", $provider['website']);
			$sheet->setCellValue("F{$row}", $provider['business_name']);
			$sheet->setCellValue("G{$row}", $provider['rfc']);
			$sheet->setCellValue("H{$row}", $fiscalAddress);

			// Datos bancarios: títulos y valores
			$bankInfo = [
				'Banco' => $provider['bank_name'],
				'Titular' => $provider['account_holder'],
				'N° cuenta' => $provider['account_number'],
				'CLABE' => $provider['clabe']
			];
			$col = 'I';
			foreach ($bankInfo as $data) {
				$sheet->setCellValue($col . $row, $data); // Valores de los campos bancarios
				$col++;
			}

			// Ajustar el ancho de las columnas
			foreach (range('A', 'L') as $columnID) {
				$sheet->getColumnDimension($columnID)->setAutoSize(true);
			}
	
			$row++; // Moverse a la siguiente fila
		}
	
		// Ajustar el alto de las filas que contienen datos bancarios
		$highestRow = $sheet->getHighestRow();
		for ($r = 2; $r <= $highestRow; $r++) {
			$cellValue = $sheet->getCell("I{$r}")->getValue();
			if (strpos($cellValue, PHP_EOL) !== false) {
				$sheet->getRowDimension($r)->setRowHeight(-1);
			}
		}
	
		// Ajustar el ancho de las columnas
		foreach (range('A', 'I') as $columnID) {
			$sheet->getColumnDimension($columnID)->setAutoSize(true);
		}
	
		// Definir la ruta y el nombre del archivo de destino
		$directory = '../../assets/documents/';
		$filename = 'proveedores.xlsx';
	
		// Guardar el archivo Excel en la ruta especificada
		$writer = new Xlsx($spreadsheet);
		$writer->save($directory . $filename);
	
		// Devolver el nombre del archivo para su descarga
		return $filename;
	}

	static public function ctrDownloadProvidersPDF() {
		// Obtener los proveedores desde el modelo
		$providers = FormsModels::mdlGetProviders(null);
	
		// Crear un nuevo objeto TCPDF
		$pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);
	
		// Establecer información del documento
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetTitle('Proveedores');
		$pdf->SetHeaderData('', 0, '', '');
	
		// Agregar una página
		$pdf->AddPage();
	
		// Agregar logo en la parte superior
		$logo = __DIR__ . '/../assets/img/logo300px.png';
		$pdf->Image($logo, 10, 10, 30, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
	
		// Definir el contenido del PDF
		$content = '<h1 style="text-align: center; font-size: 20px; margin-bottom: 20px;">Proveedores</h1>';
	
		// Aplicar estilos CSS a la tabla
		$content .= '<style>';
		$content .= '.table { width: 100%; border-collapse: collapse; }';
		$content .= '.table th, .table td { padding: .75rem; vertical-align: top; border-top: 1px solid #dee2e6; }';
		$content .= '.table th { background-color: #f2f2f2; }';
		$content .= '.table tr { font-size:7px; }';
		$content .= '</style>';
	
		// Construir la tabla de proveedores
		$content .= '<table class="table">';
		$content .= '<thead>';
		$content .= '<tr>';
		$content .= '<th scope="col">Clave del proveedor</th>';
		$content .= '<th scope="col">Representante</th>';
		$content .= '<th scope="col">Teléfono</th>';
		$content .= '<th scope="col">Email</th>';
		$content .= '<th scope="col">Página web</th>';
		$content .= '<th scope="col">Razón social</th>';
		$content .= '<th scope="col">RFC</th>';
		$content .= '<th scope="col">Dirección fiscal</th>';
		$content .= '<th scope="col">Banco</th>';
		$content .= '<th scope="col">Titular</th>';
		$content .= '<th scope="col">N° cuenta</th>';
		$content .= '<th scope="col">CLABE</th>';
		$content .= '</tr>';
		$content .= '</thead>';
		$content .= '<tbody>';
	
		foreach ($providers as $provider) {
			$content .= '<tr>';
			$content .= '<td>' . $provider['provider_key'] . '</td>';
			$content .= '<td>' . $provider['representative_name'] . '</td>';
			$content .= '<td>' . $provider['contact_phone'] . '</td>';
			$content .= '<td>' . $provider['email'] . '</td>';
			$content .= '<td>' . $provider['website'] . '</td>';
			$content .= '<td>' . $provider['business_name'] . '</td>';
			$content .= '<td>' . $provider['rfc'] . '</td>';
			$content .= '<td>' . $provider['fiscal_address_street'] . ', ' . $provider['fiscal_address_colonia'] . ', ' . $provider['fiscal_address_municipio'] . ', ' . $provider['fiscal_address_estado'] . ', ' . $provider['fiscal_address_cp'] . '</td>';
			$content .= '<td>' . $provider['bank_name'] . '</td>';
			$content .= '<td>' . $provider['account_holder'] . '</td>';
			$content .= '<td>' . $provider['account_number'] . '</td>';
			$content .= '<td>' . $provider['clabe'] . '</td>';
			$content .= '</tr>';
		}
	
		$content .= '</tbody>';
		$content .= '</table>';
	
		// Escribir el contenido en el PDF
		$pdf->writeHTML($content, true, false, true, false, '');
	
		// Definir la ruta y el nombre del archivo de destino
		$directory = __DIR__ . '/../assets/documents/';
		$filename = 'proveedores.pdf';
	
		// Guardar el archivo PDF en la ruta especificada
		$pdf->Output($directory . $filename, 'F');
	
		// Devolver el nombre del archivo para su descarga
		return $filename;
	}

	static public function ctrGetAreaBycheckup($item,$value) {
		$area = FormsModels::mdlGetAreaBycheckup($item,$value);
        return $area;
	}

	static public function ctrGetAreaByUser($idUser) {
		$area = FormsModels::mdlGetAreaByUser($idUser);
        return $area;
	}

}
