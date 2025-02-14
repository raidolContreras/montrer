<?php 

require_once __DIR__ . '/../assets/vendor/PHP/autoload.php';
require_once __DIR__ . '/vendor/autoload.php';

// Asegúrate de incluir PHPMailer en tu proyecto
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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
		
		$user = FormsController::ctrGetUser($request['idUser']);
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
			// FormsModels::mdlSendEmail($email, $message, $subject, $title, $subtitle);
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
	static public function ctrUpdateUsersArea($data) {
		$updateUsersArea = FormsModels::mdlUpdateUsersArea($data);
        return $updateUsersArea;
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

	static public function ctrDeleteRequest($idRequests) {
		// Obtener la solicitud antes de eliminarla
		$request = FormsModels::mdlGetRequest($idRequests);
		
		// Intentar eliminar la solicitud
		$deleteRequest = FormsModels::mdlDeleteRequest($idRequests);
		
		// Si la solicitud se eliminó correctamente
		if ($deleteRequest == "ok") {
			// Datos del correo electrónico
			$emailRecipient = "acisneros@unimontrer.edu.mx";
			$emailSubject = "Cancelación de Solicitud de Pago";
			$emailBody = "La solicitud de pago con ID: $idRequests ha sido eliminada.";
	
			// Llamar a la función para enviar el correo
			self::sendCancellationEmail($emailRecipient, $emailSubject, $request);
		}
	
		return $deleteRequest;
	}

	// Función para enviar correos electrónicos
	static private function sendCancellationEmail($recipient, $subject, $requestData) {
		$mail = new PHPMailer(true);
		try {
			// Configuración del servidor SMTP
			$mail->isSMTP();            
			$mail->Host = 'smtp.hostinger.com'; // Cambia esto al servidor SMTP que estés usando
			$mail->SMTPAuth = true;
			$mail->Username = 'montrer@devosco.io'; // Cambia esto a tu dirección de correo electrónico real
			$mail->Password = 'Unimo2024$'; // Cambia esto a tu contraseña de correo electrónico real
			$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
			$mail->Port = 587;
			$mail->setFrom('montrer@devosco.io', 'UNIMO (no responder)');
			$mail->addAddress($recipient);
	
			// Título y diseño del correo
			$subject = utf8_decode("Cancelación de Solicitud de Pago - Folio {$requestData['folio']}");
			$mail->isHTML(true);
			$mail->Subject = $subject;
	
			// Cuerpo del correo
			$body = '
			<html>
			<head>
				<style>
					body {
						font-family: Arial, sans-serif;
						background-color: #f4f4f4;
						color: #333;
						padding: 20px;
					}
					.container {
						background-color: #fff;
						padding: 20px;
						border-radius: 5px;
						box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
					}
					.header {
						background-color: #01643d;
						color: #fff;
						padding: 10px;
						text-align: center;
						border-radius: 5px 5px 0 0;
					}
					.content {
						padding: 20px;
					}
					.footer {
						margin-top: 20px;
						text-align: center;
						font-size: 12px;
						color: #777;
					}
					table {
						width: 100%;
						border-collapse: collapse;
					}
					table th, table td {
						border: 1px solid #ddd;
						padding: 8px;
						text-align: left;
					}
					table th {
						background-color: #f2f2f2;
					}
				</style>
			</head>
			<body>
				<div class="container">
					<div class="header">
						<h1>Cancelación de solicitud de pago</h1>
					</div>
					<div class="content">
						<p>Se ha cancelado la siguiente solicitud de pago:</p>
						<table>
							<tr>
								<th>Folio</th>
								<td>' . htmlspecialchars($requestData['folio']) . '</td>
							</tr>
							<tr>
								<th>Solicitante</th>
								<td>' . htmlspecialchars($requestData['solicitante_nombre']) . '</td>
							</tr>
							<tr>
								<th>Empresa</th>
								<td>' . htmlspecialchars($requestData['empresa']) . '</td>
							</tr>
							<tr>
								<th>Concepto</th>
								<td>' . htmlspecialchars($requestData['concepto']) . '</td>
							</tr>
							<tr>
								<th>Cuenta afectada</th>
								<td>' . htmlspecialchars($requestData['cuentaAfectada']) . '</td>
							</tr>
							<tr>
								<th>Importe solicitado</th>
								<td>' . htmlspecialchars(number_format($requestData['importe_solicitado'], 2)) . '</td>
							</tr>
							<tr>
								<th>Importe en letra</th>
								<td>' . htmlspecialchars($requestData['importe_letra']) . '</td>
							</tr>
							<tr>
								<th>Fecha de solicitud</th>
								<td>' . htmlspecialchars(date("d/m/Y", strtotime($requestData['requestDate']))) . '</td>
							</tr>
						</table>
					</div>
					<div class="footer">
						<p>Universidad Montrer</p>
						<p>Este es un mensaje automático, por favor no respondas a este correo.</p>
					</div>
				</div>
			</body>
			</html>
			';
	
			// Asignar el cuerpo al correo
			$mail->Body = $body;
	
			// Enviar el correo
			$mail->send();
			return true;
		} catch (Exception $e) {
			// Manejo de errores
			error_log("Error al enviar el correo: {$mail->ErrorInfo}");
			return false;
		}
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
		$user = FormsController::ctrGetUser($request['idUser']);
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
			FormsController::ctrSendEmail($email, $message, $subject, $title, $subtitle);
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

	static public function ctrChangePaymentDate($idRequest, $paymentDate) {
		$response = FormsModels::mdlChangePaymentDate($idRequest,$paymentDate);
		return $response;
    }

	static public function ctrGetBusiness($idUser) {
		$business = FormsModels::mdlGetBusiness($idUser);
        return $business;
	}

	static public function ctrCompleteRequest($data) {
		$response = FormsModels::mdlCompleteRequest($data);
        return $response;
	}

	static public function ctrGetReports($startDate, $endDate, $context) {
		$reports = FormsModels::mdlGetReports($startDate, $endDate, $context);
        return $reports;
	}

	static public function ctrSendPassword($userId, $password, $firstname, $lastname, $email) {
		$mail = new PHPMailer(true);

		try {
			// Configuración del servidor SMTP
			$mail->isSMTP();            
			$mail->Host = 'smtp.hostinger.com'; // Cambia esto al servidor SMTP que estés usando
			$mail->SMTPAuth = true;
			$mail->Username = 'montrer@devosco.io'; // Cambia esto a tu dirección de correo electrónico real
			$mail->Password = 'Unimo2024$'; // Cambia esto a tu contraseña de correo electrónico real
			$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
			$mail->Port = 587;
            $mail->setFrom('montrer@devosco.io', 'UNIMO (no responder)');

			$mail->addAddress($email); // Destinatario

			// Asunto del correo
			$mail->Subject = "Bienvenido a la plataforma de presupuestos";

			// Crear el contenido del correo en HTML
			$message = '
			<html>
			<head>
				<style>
					/* Estilos generales */
					body {
						font-family: Arial, sans-serif;
						color: #333333;
						background-color: #f0f0f0;
					}
					.container {
						width: 600px;
						margin: 0 auto;
						background-color: #ffffff;
						border: 1px solid #cccccc;
					}
					.header {
						padding: 20px;
						text-align: center;
						background-color: #eeeeee;
						border-bottom: 1px solid #cccccc;
					}
					.content {
						padding: 20px;
					}
					.footer {
						padding: 20px;
						text-align: center;
						background-color: #eeeeee;
						border-top: 1px solid #cccccc;
					}
					.logo {
						width: 200px;
					}
					.greeting {
						font-size: 18px;
						text-align: justify;
					}
					.message {
						font-size: 18px;
						line-height: 1.5;
						text-align: justify;
					}
					.password {
						font-size: 20px;
						font-weight: bold;
						color: #ff0000;
					}
					.link {
						font-size: 18px;
						text-decoration: none;
						color: #0000ff;
					}
				</style>
			</head>
			<body>
				<div class="container">
					<div class="header">
						<img src="https://montrer.devosco.io/assets/img/logo.png" alt="Logo" class="logo">
					</div>
					<div class="content">
						<p class="greeting">Estimado(a) ' . htmlspecialchars($firstname) . ' ' . htmlspecialchars($lastname) . ', ha sido registrado(a) en la plataforma de asignación de presupuestos de Universidad Montrer.</p>
						<p class="message">Para acceder a la plataforma, de clic en el siguiente vinculo (<a href="https://montrer.devosco.io/" class="link">Ingresar a la plataforma</a>), su usuario es: ' . htmlspecialchars($email) . ' y su contraseña temporal:
						<center><p class="password">' . htmlspecialchars($password) . '</p></center>
						<p class="message">En el primer acceso, deberá cambiar su contraseña, respetando las siguientes condiciones: 10 caracteres (obligatorio: 1 letra mayúscula, 1 letra minúscula, 1 número y 1 símbolo).</p>
						<p>Gracias.</p>
					</div>
					<div class="footer">
						<p>© 2024 UNIMO. Todos los derechos reservados.</p>
					</div>
				</div>
			</body>
			</html>';

			// Configuración del contenido del correo
			$mail->isHTML(true);
			$mail->Body = $message;

			// Enviar el correo
			$mail->send();

			// Encriptar la contraseña
			$cryptPassword = crypt($password, '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

			// Guardar la contraseña en la base de datos
			return FormsModels::mdlRegisterPassword($userId, $cryptPassword);

		} catch (Exception $e) {
			// Manejo de errores
			error_log("Error al enviar el correo: {$mail->ErrorInfo}");
			return false;
		}
	}
	
	static public function ctrSendEmail($email, $message, $subject, $title, $subtitle) {
		$mail = new PHPMailer(true);
	
		try {
			// Configuración del servidor SMTP
			$mail->isSMTP();            
			$mail->Host = 'smtp.hostinger.com'; // Cambia esto al servidor SMTP que estés usando
			$mail->SMTPAuth = true;
			$mail->Username = 'montrer@devosco.io'; // Cambia esto a tu dirección de correo electrónico real
			$mail->Password = 'Unimo2024$'; // Cambia esto a tu contraseña de correo electrónico real
			$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
			$mail->Port = 587;
			$mail->setFrom('montrer@devosco.io', 'UNIMO (no responder)');
	
			$mail->addAddress($email); // Destinatario
	
			// Configuración del correo
			$mail->isHTML(true);
			$mail->Subject = $subject;
	
			// Crear el contenido del correo en HTML
			$templateHTML = '
			<!DOCTYPE html>
			<html lang="es">
			<head>
				<meta charset="UTF-8">
				<meta name="viewport" content="width=device-width, initial-scale=1.0">
				<title>Reporte de Estado de Presupuestos</title>
				<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
				<style>
					body {
						font-family: \'Segoe UI\', Tahoma, Geneva, Verdana, sans-serif;
						background-color: #f0f0f0;
						color: #333;
						line-height: 1.6;
						margin: 0;
						padding: 0;
					}
					.container {
						min-height: 100vh;
						display: flex;
						justify-content: center;
						align-items: center;
					}
					.logo img {
						width: 200px;
						max-width: 100%;
					}
					.card {
						border: none;
						border-radius: 10px;
						background-color: #fff;
						box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1);
						width: 100%;
						max-width: 600px;
						animation: fadeIn 1s ease-out;
					}
					.header {
						text-align: center;
						background-color: #026f35;
						color: #fff;
						padding: 20px;
						margin-bottom: 20px;
					}
					.header h1 {
						font-size: 28px;
						margin-bottom: 10px;
					}
					.header p {
						font-size: 16px;
						margin-bottom: 0;
					}
					.card-title {
						font-size: 24px;
						font-weight: bold;
						color: #026f35;
						margin-bottom: 20px;
					}
					.card-text {
						font-size: 18px;
						color: #555;
						margin-bottom: 20px;
					}
					.footer {
						text-align: center;
						background-color: #666666;
						padding-bottom: 10px;
						border-radius: 0 0 10px 10px;
						color: #fff;
					}
					.footer p {
						font-size: 16px;
						margin-bottom: 0;
					}
				</style>
			</head>
			<body>
				<div class="container">
					<div class="card">
						<div class="card-header logo text-center">
							<img src="https://portal.unimontrer.edu.mx/wp-content/uploads/2021/04/universidad-montrer-logotipo-promocional-recortao-01.png" alt="Logo de UNIMO">
						</div>
						<div class="header">
							<h1>' . htmlspecialchars($title) . '</h1>
							<p>' . htmlspecialchars($subtitle) . '</p>
						</div>
						<div class="card-body">
			';
			foreach ($message as $key => $val) {
				$templateHTML .= '<p class="card-text">' . htmlspecialchars($val) . '</p>';
			}
			$templateHTML .= '
						</div>
						<div class="footer">
							<div class="logo">
								<img src="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEiwYdc6JjvK8wto9xbuHcTAYFtzp0giLWm3pO6Gl6AlzUkVp2tM8E4ZGtbFUilQSJWACk_VAzzTpylpA-OleuC-Fs65QshR-Ud_Ua4gAWrxl00Ea1vDYA-mB2hovzOoC8t7tYQHBFUY0pEk5_JywC5y_Zg7HTtR8EN-NZfRztW9Gakn8yWjzHffaFkeeA/s1584/UNIMO-logotipo-2019-BLANCO.png" alt="Logo de UNIMO">
							</div>
							<p>© 2024 Universidad Montrer. Todos los derechos reservados.</p>
						</div>
					</div>
				</div>
			</body>
			</html>';
	
			// Asignar el cuerpo del correo
			$mail->Body = $templateHTML;
	
			// Enviar el correo
			$mail->send();
			return true;
	
		} catch (Exception $e) {
			// Manejo de errores
			error_log("Error al enviar el correo: {$mail->ErrorInfo}");
			return false;
		}
	}

	static public function ctrCreateAccount($cuenta, $numeroCuenta, $idArea) {
		$result = FormsModels::mdlCreateAccount($cuenta, $numeroCuenta, $idArea);
		return $result;
	}

	static public function ctrGetAccounts() {
		$result = FormsModels::mdlGetAccounts();
        return $result;
	}

	static public function ctrCreatePartida($partida, $numeroPartida, $idCuenta) {
		$result = FormsModels::mdlCreatePartida($partida, $numeroPartida, $idCuenta);
        return $result;
	}

	static public function ctrGetPartidas($idPartida) {
		$result = FormsModels::mdlGetPartidas($idPartida);
        return $result;
	}

	static public function ctrDeleteAccount($idCuenta) {
		$result = FormsModels::mdlDeleteAccount($idCuenta);
        return $result;
	}

	static public function ctrDeletePartida($idPartida) {
        $result = FormsModels::mdlDeletePartida($idPartida);
        return $result;
    }

	static public function ctrEditAccount($idCuenta, $cuenta, $numeroCuenta, $idArea) {
		$result = FormsModels::mdlEditAccount($idCuenta, $cuenta, $numeroCuenta, $idArea);
        return $result;
	}

	static public function ctrEditPartida($idPartida, $Partida, $codigoPartida, $idCuenta) {
		$result = FormsModels::mdlEditPartida($idPartida, $Partida, $codigoPartida, $idCuenta);
        return $result;
	}

	static public function ctrGetConceptos($idPartida) {
		$result = FormsModels::mdlGetConceptos($idPartida);
        return $result;
	}

	static public function ctrGetConcepto($idConcepto) {
		$result = FormsModels::mdlGetConcepto($idConcepto);
        return $result;
	}

	static public function ctrEditConcepto($idConcepto, $concepto, $numeroConcepto) {
		$result = FormsModels::mdlEditConcepto($idConcepto, $concepto, $numeroConcepto);
        return $result;
	}

	static public function ctrAddConcepto($idPartida, $concepto, $numeroConcepto) {
		$result = FormsModels::mdlAddConcepto($idPartida, $concepto, $numeroConcepto);
        return $result;
	}

	static public function ctrDeleteConcepto($idConcepto) {
		$result = FormsModels::mdlDeleteConcepto($idConcepto);
        return $result;
	}

	static public function ctrSelectAccounts($idArea) {
		$result = FormsModels::mdlSelectAccounts($idArea);
        return $result;
	}

	static public function ctrSelectPartidas($idCuenta) {
		$result = FormsModels::mdlSelectPartidas($idCuenta);
        return $result;
	}
}
