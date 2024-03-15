<?php 
include "conection.php";


function generarPassword() {
	$caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
	$password = '';

	for ($i = 0; $i < 8; $i++) {
		$indice = rand(0, strlen($caracteres) - 1);
		$password .= $caracteres[$indice];
	}
	return $password;
}

class FormsModels {

	// Inicio de Contadores
	static public function mdlCountAreas(){
		$pdo = Conexion::conectar();
		$sql = "SELECT 
				(SELECT COUNT(*) FROM montrer_area WHERE status = 1) AS areas,
				(SELECT COUNT(*) FROM montrer_users u LEFT JOIN montrer_settings s ON s.idUser = u.idUsers WHERE s.status = 1) AS users,
				(SELECT exerciseName FROM montrer_exercise WHERE status = 1) AS name,
				COALESCE((SELECT SUM(AuthorizedAmount) FROM montrer_budgets b LEFT JOIN montrer_exercise e ON e.idExercise = b.idExercise WHERE e.status = 1 AND b.status = 1), 0) AS used,
				(SELECT budget FROM montrer_exercise WHERE status = 1) AS budget,
				((SELECT budget FROM montrer_exercise WHERE status = 1) - COALESCE((SELECT SUM(AuthorizedAmount)
				FROM montrer_budgets b LEFT JOIN montrer_exercise e ON e.idExercise = b.idExercise WHERE e.status = 1 AND b.status = 1), 0)) AS remaining;";
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetch();
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}
	// Fin de Contadores

	static public function mdlCreateUser($data){
		try {
			$pdo = Conexion::conectar();
			$sql = "INSERT INTO montrer_users(firstname, lastname, email) VALUES (:firstname, :lastname, :email)";

			$stmt = $pdo->prepare($sql);

			$stmt->bindParam(':firstname', $data['firstname'], PDO::PARAM_STR);
			$stmt->bindParam(':lastname', $data['lastname'], PDO::PARAM_STR);
			$stmt->bindParam(':email', $data['email'], PDO::PARAM_STR);
			
			if ($stmt->execute()) {
				$userId = $pdo->lastInsertId();
				$temporalPassword = FormsModels::mdlSendPassword($userId, generarPassword(), $data['firstname'], $data['lastname'], $data['email']);
				$settings = FormsModels::mdlSettingsUser($userId, $data['level'], 0);
				if ($data['area'] != '') {
					$area = FormsModels::mdlUpdateAreaUser($userId, $data['area']);
					if($temporalPassword == 'ok' && $settings == 'ok' && $area == 'ok'){
						return $data['email'];
					} else {
						return 'Error';
					}
				} else {
					if($temporalPassword == 'ok' && $settings == 'ok'){
						return $data['email'];
					} else {
						return 'Error';
					}
				}
			} else {
				return 'Error';
			}
		} catch (PDOException $e) {
			// Verifica si la excepción es por una violación de la restricción de integridad
			if ($e->getCode() == '23000') {
				// Violación de restricción de integridad (clave duplicada)
				return 'Error: Email duplicado';
			} else {
				// Otra excepción
				return 'Error';
			}
		} finally {
			// Asegúrate de cerrar la conexión en el bloque finally
			$stmt->closeCursor();
			$stmt = null;
		}
	}
	
	static public function mdlUpdateAreaUser($idUser, $idArea){
		$pdo = Conexion::conectar();
		$sql = "UPDATE montrer_area SET idUser = :idUser WHERE idArea = :idArea ";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
		$stmt->bindParam(':idArea', $idArea, PDO::PARAM_INT);
		if($stmt->execute()){
			return "ok";
		} else {
			print_r($pdo->errorInfo());
		}
		$stmt->closeCursor();
		$stmt = null;
	}
	
	static public function mdlRegisterPassword($userId, $cryptPassword){

		$pdo = Conexion::conectar();
		$sql = "INSERT INTO montrer_temporal_password(temporal_password, User_idUser) VALUES (:temporal_password, :User_idUser)";
		$stmt = $pdo->prepare($sql);
		
		$stmt->bindParam(':temporal_password', $cryptPassword, PDO::PARAM_STR);
		$stmt->bindParam(':User_idUser', $userId, PDO::PARAM_INT);
		
		if ($stmt->execute()){
			return 'ok';
		} else {
			print_r($pdo->errorInfo());
		}

	}
	
	static public function mdlSettingsUser($userId, $level, $root){

		$pdo = Conexion::conectar();
		$sql = "INSERT INTO montrer_settings(idUser, level, root) VALUES (:idUser, :level, :root)";
		$stmt = $pdo->prepare($sql);

		$stmt->bindParam(':idUser', $userId, PDO::PARAM_INT);
		$stmt->bindParam(':level', $level, PDO::PARAM_INT);
		$stmt->bindParam(':root', $root, PDO::PARAM_INT);
		
		if ($stmt->execute()){
			return 'ok';
		} else {
			print_r($pdo->errorInfo());
		}

	}
	
	static public function mdlSendPassword($userId, $password, $firstname, $lastname, $email){
		
			// enviar un correo electrónico al usuario creado
			$to = $email; // la dirección de correo electrónico del usuario
			$subject = "Bienvenido a la plataforma de presupuestos"; // el asunto del correo electrónico
			// el cuerpo del correo electrónico en HTML
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
					/* Estilos específicos */
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
						<img src="https://tests.hucco.com.mx/assets/img/logo.png" alt="Logo" class="logo">
					</div>
					<div class="content">
						<p class="greeting">Estimado(a) '.$firstname.' '.$lastname.', ha sido registrado(a) en la plataforma de asignación de presupuesto de Universidad Montrer.</p>
						<p class="message">Para acceder a la plataforma, de clic en el siguiente vinculo (<a href="https://tests.hucco.com.mx/" class="link">Ingresar a la plataforma</a>), su usuario es: '.$email.' y su contraseña temporal:
						<center><p class="password">'.$password.'</p></center>
						<p class="message">En el primer acceso, deberá cambiar su contraseña, respetando las siguientes condiciones: 10 caracteres (obligatorio: 1 letra mayúscula, 1 letra minúscula, 1 número y 1 símbolo).</p>
						<p Gracias.</p>
					</div>
					<div class="footer">
						<p>© 2024 UNIMO. Todos los derechos reservados.</p>
					</div>
				</div>
			</body>
			</html>';
			// Nombre personalizado
			$fromName = "UNIMO (no responder)";

			// el encabezado De y el tipo de contenido
			$headers = "From: $fromName <noreply@unimontrer.edu.mx>\r\n";
			$headers .= "Content-type: text/html\r\n";
			// llamar a la función mail ()
			mail ($to, $subject, $message, $headers);

			$cryptPassword = crypt($password, '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

			return FormsModels::mdlRegisterPassword($userId, $cryptPassword);

	}
	
	static public function mdlGetUsers(){
		$pdo = Conexion::conectar();
		$sql = "SELECT 
					u.idUsers,
					u.firstname,
					u.lastname,
					u.email,
					s.status,
					s.level,
					u.lastConection,
					u.createDate,
					GROUP_CONCAT(a.nameArea SEPARATOR ', ') AS nameArea
				FROM 
					montrer_users u
				LEFT JOIN 
					montrer_settings s ON s.idUser = u.idUsers
				LEFT JOIN 
					montrer_area a ON a.idUser = u.idUsers
				GROUP BY 
					u.idUsers;";
		$stmt = $pdo->prepare($sql);
		
		if ($stmt->execute()){
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		} else {
			print_r($pdo->errorInfo());
		}
		
		// Asegúrate de cerrar la conexión en el bloque finally
		$stmt->closeCursor();
		$stmt = null;
	}

	static public function mdlSelectUser($email){
		$pdo = Conexion::conectar();
		$sql = "SELECT * FROM montrer_users u LEFT JOIN montrer_settings s ON s.idUser = u.idUsers WHERE email = :email";
		$stmt = $pdo->prepare($sql);
		
		$stmt->bindParam(':email', $email, PDO::PARAM_STR);
		$stmt->execute();
		$result = $stmt->fetch();
		// Asegúrate de cerrar la conexión en el bloque finally
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlSelectPasswordUser($idUsers){
		$pdo = Conexion::conectar();
		$sql = "SELECT u.password FROM montrer_users u LEFT JOIN montrer_settings s ON s.idUser = u.idUsers WHERE u.idUsers = :idUsers";
		$stmt = $pdo->prepare($sql);
		
		$stmt->bindParam(':idUsers', $idUsers, PDO::PARAM_STR);
		$stmt->execute();
		$result = $stmt->fetch();
		// Asegúrate de cerrar la conexión en el bloque finally
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlFirstLoginUser($idUsers){
		$pdo = Conexion::conectar();
		$sql = "SELECT * FROM montrer_temporal_password WHERE User_idUser = :User_idUser";
		$stmt = $pdo->prepare($sql);
		
		$stmt->bindParam(':User_idUser', $idUsers, PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetch();
		// Asegúrate de cerrar la conexión en el bloque finally
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlUpdateLog($idUsers){

		$pdo = Conexion::conectar();
		$sql = "UPDATE montrer_users SET lastConection = DATE_ADD(NOW(), INTERVAL -6 HOUR) WHERE idUsers = :idUsers";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idUsers', $idUsers, PDO::PARAM_INT);
		if($stmt->execute()){
			return "ok";
		} else {
			print_r($pdo->errorInfo());
		}
		// Asegúrate de cerrar la conexión en el bloque finally
		$stmt->closeCursor();
		$stmt = null;
		
	}

	static public function mdlDelTemporalPassword($data){
		
		$pdo = Conexion::conectar();
		$sql = "DELETE FROM montrer_temporal_password WHERE User_idUser = :idUser AND temporal_password = :temporal_password";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idUser', $data['user'], PDO::PARAM_INT);
		$stmt->bindParam(':temporal_password', $data['actualPassword'], PDO::PARAM_STR);
		if($stmt->execute()){
			return true;
		} else {
			print_r($pdo->errorInfo());
		}
		// Asegúrate de cerrar la conexión en el bloque finally
		$stmt->closeCursor();
		$stmt = null;

	}

	static public function mdlUpdatePassword($data){
		$pdo = Conexion::conectar();
		$sql = "UPDATE montrer_users SET password = :newPassword WHERE idUsers = :idUsers";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':newPassword', $data['newPassword'], PDO::PARAM_STR);
		$stmt->bindParam(':idUsers', $data['user'], PDO::PARAM_INT);
	   if($stmt->execute()){
		return true;
	   } else {
		print_r($pdo->errorInfo());
	   }
		$stmt->closeCursor();
		$stmt = null;
	}
	
	static public function mdlAddArea($data){
	   $pdo = Conexion::conectar();
	   $sql = "INSERT INTO montrer_area(nameArea, description, idUser) VALUES (:nameArea, :description, :idUser)";
	   $stmt = $pdo->prepare($sql);
	   $stmt->bindParam(':nameArea', $data['nameArea'], PDO::PARAM_STR);
	   $stmt->bindParam(':description', $data['areaDescription'], PDO::PARAM_STR);
	   $stmt->bindParam(':idUser', $data['user'], PDO::PARAM_INT);
	   if($stmt->execute()){
		return "ok";
	   } else {
		print_r($pdo->errorInfo());
	   }
		$stmt->closeCursor();
		$stmt = null;
	}

	static public function mdlGetAreas(){
		$pdo = Conexion::conectar();
		$sql = "SELECT a.idArea, a.nameArea, a.description, u.firstname, u.lastname, a.status FROM montrer_area a
				LEFT JOIN montrer_users u ON u.idUsers = a.idUser;";
		$stmt = $pdo->prepare($sql);
		
		if ($stmt->execute()){
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		} else {
			print_r($pdo->errorInfo());
		}
		// Asegúrate de cerrar la conexión en el bloque finally
		$stmt->closeCursor();
		$stmt = null;
	}

	static public function mdlGetCompanies(){
	   $pdo = Conexion::conectar();
	   $sql = "SELECT * FROM montrer_company";
	   $stmt = $pdo->prepare($sql);
	   if ($stmt->execute()){
		   return $stmt->fetchAll(PDO::FETCH_ASSOC);
	   } else {
		   print_r($pdo->errorInfo());
	   }
	   // Asegúrate de cerrar la conexión en el bloque finally
	   $stmt->closeCursor();
	   $stmt = null;
	}

	static public function mdlAddCompany($data){
		$pdo = Conexion::conectar();
		$sql = "INSERT INTO montrer_company(name, colors, description) VALUES (:name, :colors, :description)";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':name', $data['companyName'], PDO::PARAM_STR);
		$stmt->bindParam(':colors', $data['colors'], PDO::PARAM_STR);
		$stmt->bindParam(':description', $data['companyDescription'], PDO::PARAM_STR);
		if($stmt->execute()){
			if (($pdo -> lastInsertId() != 0)){
				$idCompany = $pdo -> lastInsertId();
				return $idCompany;
			} else {
				return 'Error';
			}
		} else {
			print_r($pdo->errorInfo());
		}
		 $stmt->closeCursor();
		 $stmt = null;
	}
	
	static public function mdlAddLogo($data){
		$pdo = Conexion::conectar();
		$sql = "UPDATE montrer_company SET logo = :logo WHERE idCompany = :idCompany";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':logo', $data['logo'], PDO::PARAM_STR);
		$stmt->bindParam(':idCompany', $data['idCompany'], PDO::PARAM_INT);
		if($stmt->execute()){
			return "ok";
		} else {
			print_r($pdo->errorInfo());
		}
		$stmt->closeCursor();
		$stmt = null;
	}
	
	static public function mdlGetExercise(){
		$pdo = Conexion::conectar();
		$sql = "SELECT * FROM montrer_exercise";
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll();
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}
	
	static public function mdlGetExercises($idExercise){
		$pdo = Conexion::conectar();
		$sql = "SELECT * FROM montrer_exercise WHERE idExercise = :idExercise";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idExercise', $idExercise, PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetch();
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}
	
	static public function mdlAddExercise($data){
		$pdo = Conexion::conectar();
		$sql = "INSERT INTO montrer_exercise(exerciseName, initialDate, finalDate, budget, idRoot) VALUES (:exerciseName, :initialDate, :finalDate, :budget, :idRoot)";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':exerciseName', $data['exerciseName'], PDO::PARAM_STR);
		$stmt->bindParam(':initialDate', $data['initialDate'], PDO::PARAM_STR);
		$stmt->bindParam(':finalDate', $data['finalDate'], PDO::PARAM_STR);
		$stmt->bindParam(':budget', $data['budget'], PDO::PARAM_STR);
		$stmt->bindParam(':idRoot', $data['user'], PDO::PARAM_INT);
		if($stmt->execute()){
			$result = "ok";
		} else {
			$result = 'Error';
			print_r($pdo->errorInfo());
		}
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}
	
	static public function mdlGetBudgets($idExercise){
		$pdo = Conexion::conectar();
		if($idExercise  != 'all'){
			$sql = "SELECT b.idBudget, b.AuthorizedAmount, a.nameArea, a.idArea, e.exerciseName, e.budget, b.status, e.idExercise
					FROM montrer_budgets b
					LEFT JOIN montrer_area a ON a.idArea = b.idArea
					LEFT JOIN montrer_exercise e ON e.idExercise = b.idExercise
					WHERE e.idExercise = :idExercise
					Order By nameArea;";
			$stmt = $pdo->prepare($sql);
			$stmt->bindParam(':idExercise', $idExercise, PDO::PARAM_INT);
		} else {
			$sql = "SELECT b.idBudget, b.AuthorizedAmount, a.nameArea, a.idArea, e.exerciseName, e.budget, b.status, e.idExercise
					FROM montrer_budgets b
					LEFT JOIN montrer_area a ON a.idArea = b.idArea
					LEFT JOIN montrer_exercise e ON e.idExercise = b.idExercise
					Order By exerciseName;";
			$stmt = $pdo->prepare($sql);
		}
		$stmt->execute();
		$result = $stmt->fetchAll();
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}
	
	static public function mdlGetBudget($idBudget){
		$pdo = Conexion::conectar();
		$sql = "SELECT b.idBudget, b.AuthorizedAmount, a.nameArea, a.idArea, e.exerciseName, e.budget, b.status, e.idExercise
				FROM montrer_budgets b
				LEFT JOIN montrer_area a ON a.idArea = b.idArea
				LEFT JOIN montrer_exercise e ON e.idExercise = b.idExercise
				WHERE b.idBudget = :idBudget";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idBudget', $idBudget, PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetch();
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlActiveExercise(){
	   $pdo = Conexion::conectar();
	   $sql = "SELECT budget, idExercise, exerciseName FROM montrer_exercise WHERE status = 1";
	   $stmt = $pdo->prepare($sql);
	   $stmt->execute();
	   return $stmt->fetch();
	}

	static public function mdlUpdateActiveExercise($idExercise){
	   $pdo = Conexion::conectar();
	   $sql = "UPDATE montrer_exercise SET status = 0 WHERE status = 1;";
	   $sql .= "UPDATE montrer_exercise SET status = 1 WHERE idExercise = :idExercise ";
	   $stmt = $pdo->prepare($sql);
	   $stmt->bindParam(':idExercise', $idExercise, PDO::PARAM_INT);
	   if($stmt->execute()){
		return "ok";
	   } else {
		print_r($pdo->errorInfo());
	   }
	   $stmt->closeCursor();
	   $stmt = null;
	}
	
	static public function mdlAddBudgets($data){
		$pdo = Conexion::conectar();
		$sql = "INSERT INTO montrer_budgets(idArea, AuthorizedAmount, idExercise) VALUES (:area, :AuthorizedAmount, :exercise);";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':area', $data['area'], PDO::PARAM_INT);
		$stmt->bindParam(':AuthorizedAmount', $data['AuthorizedAmount'], PDO::PARAM_STR);
		$stmt->bindParam(':exercise', $data['exercise'], PDO::PARAM_INT);
		if($stmt->execute()){
			$idBudget = $pdo -> lastInsertId();
			$result = $idBudget;
		} else {
			$result = 'Error';
			print_r($pdo->errorInfo());
		}
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlAddBudgetsMonths($month, $data){
		$pdo = Conexion::conectar();
		$sql = "INSERT INTO montrer_month_budget(month, budget_month, idBudget) VALUES (:month, :budget_month, :idBudget)";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':month', $month, PDO::PARAM_INT);
		$stmt->bindParam(':budget_month', $data['budget_month'], PDO::PARAM_STR);
		$stmt->bindParam(':idBudget', $data['idBudget'], PDO::PARAM_INT);
		if($stmt->execute()){
			$result = 'ok';
		} else {
			$result = 'Error';
			print_r($pdo->errorInfo());
		}
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlGetUser($register){
		$pdo = Conexion::conectar();
		$sql = "SELECT u.idUsers, u.firstname, u.lastname, s.level, u.email FROM montrer_users u
				LEFT JOIN montrer_settings s ON s.idUser = u.idUsers
				WHERE u.idUsers = :idUsers";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idUsers', $register, PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetch();
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlGetArea($register){
		$pdo = Conexion::conectar();
		$sql = "SELECT * FROM montrer_area a LEFT JOIN montrer_users u ON u.idUsers = a.idUser WHERE idArea = :idArea";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idArea', $register, PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetch();
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlUpdateUser($data){
		$pdo = Conexion::conectar();
		$sql = "UPDATE montrer_users SET firstname = :firstname, lastname = :lastname, email = :email WHERE idUsers = :idUsers ";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':firstname', $data['firstname'], PDO::PARAM_STR);
		$stmt->bindParam(':lastname', $data['lastname'], PDO::PARAM_STR);
		$stmt->bindParam(':email', $data['email'], PDO::PARAM_STR);
		$stmt->bindParam(':idUsers', $data['user'], PDO::PARAM_STR);
		if($stmt->execute()){
			return "ok";
		} else {
			print_r($pdo->errorInfo());
		}
		$stmt->closeCursor();
		$stmt = null;
	}

	static public function mdlUpdateLevelUser($data){
		$pdo = Conexion::conectar();
		$sql = "UPDATE montrer_settings SET level = :level WHERE idUser = :idUsers ";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':level', $data['level'], PDO::PARAM_INT);
		$stmt->bindParam(':idUsers', $data['user'], PDO::PARAM_INT);
		if($stmt->execute()){
			return "ok";
		} else {
			print_r($pdo->errorInfo());
		}
		$stmt->closeCursor();
		$stmt = null;
	}

	static public function mdlDeleteRegister($idUsers){
		$pdo = Conexion::conectar();
		$sql = "UPDATE montrer_settings SET status = 0 WHERE idUser = :idUser ";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idUser', $idUsers, PDO::PARAM_INT);
		if($stmt->execute()){
			return "ok";
		} else {
			print_r($pdo->errorInfo());
		}
		$stmt->closeCursor();
		$stmt = null;
	}
	
	static public function mdlEnableRegister($idUsers){
		$pdo = Conexion::conectar();
		$sql = "UPDATE montrer_settings SET status = 1 WHERE idUser = :idUser ";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idUser', $idUsers, PDO::PARAM_INT);
		if($stmt->execute()){
			return "ok";
		} else {
			print_r($pdo->errorInfo());
		}
		$stmt->closeCursor();
		$stmt = null;
	}
	
	static public function mdlDisableArea($idArea){
		$pdo = Conexion::conectar();
		$sql = "UPDATE montrer_area SET status = 0 WHERE idArea = :idArea ";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idArea', $idArea, PDO::PARAM_INT);
		if($stmt->execute()){
			return "ok";
		} else {
			print_r($pdo->errorInfo());
		}
		$stmt->closeCursor();
		$stmt = null;
	}
	
	static public function mdlEnableArea($idArea){
		$pdo = Conexion::conectar();
		$sql = "UPDATE montrer_area SET status = 1 WHERE idArea = :idArea ";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idArea', $idArea, PDO::PARAM_INT);
		if($stmt->execute()){
			return "ok";
		} else {
			print_r($pdo->errorInfo());
		}
		$stmt->closeCursor();
		$stmt = null;
	}
	
	static public function mdlUpdateArea($data){
		$pdo = Conexion::conectar();
		$sql = "UPDATE montrer_area SET nameArea = :nameArea, description = :description, idUser = :idUser WHERE idArea = :idArea ";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':nameArea', $data['nameArea'], PDO::PARAM_STR);
		$stmt->bindParam(':description', $data['description'], PDO::PARAM_STR);
		$stmt->bindParam(':idUser', $data['idUser'], PDO::PARAM_INT);
		$stmt->bindParam(':idArea', $data['idArea'], PDO::PARAM_INT);
		if($stmt->execute()){
			return "ok";
		} else {
			print_r($pdo->errorInfo());
		}
		$stmt->closeCursor();
		$stmt = null;
	}

	static public function mdlUpdateExercise($data){
		$pdo = Conexion::conectar();
		$sql = "UPDATE montrer_exercise
				SET exerciseName = :exerciseName
				, initialDate = :initialDate
				, finalDate = :finalDate
				, budget = :budget
				, idRoot = :idRoot
				WHERE idExercise = :idExercise";

		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':exerciseName', $data['exerciseName'], PDO::PARAM_STR);
		$stmt->bindParam(':initialDate', $data['initialDate'], PDO::PARAM_STR);
		$stmt->bindParam(':finalDate', $data['finalDate'], PDO::PARAM_STR);
		$stmt->bindParam(':budget', $data['budget'], PDO::PARAM_STR);
		$stmt->bindParam(':idRoot', $data['idUser'], PDO::PARAM_INT);
		$stmt->bindParam(':idExercise', $data['idExercise'], PDO::PARAM_INT);
		
		if($stmt->execute()){
			return "ok";
		} else {
			print_r($pdo->errorInfo());
		}
		$stmt->closeCursor();
		$stmt = null;
	}

	static public function mdlDisableExercise($idExercise){
		$pdo = Conexion::conectar();
		$sql = "UPDATE montrer_exercise
				SET active = 0
				WHERE idExercise = :idExercise";

		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idExercise', $idExercise, PDO::PARAM_INT);

		if($stmt->execute()){
			return "ok";
		} else {
			print_r($pdo->errorInfo());
		}
		$stmt->closeCursor();
		$stmt = null;
	}

	static public function mdlEnableExercise($idExercise){
		$pdo = Conexion::conectar();
		$sql = "UPDATE montrer_exercise
				SET active = 1
				WHERE idExercise = :idExercise";

		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idExercise', $idExercise, PDO::PARAM_INT);

		if($stmt->execute()){
			return "ok";
		} else {
			print_r($pdo->errorInfo());
		}
		$stmt->closeCursor();
		$stmt = null;
	}

	static public function mdlDeleteExercise($idExercise){
		$pdo = Conexion::conectar();
		$sql = "DELETE FROM montrer_exercise
				WHERE idExercise = :idExercise";

		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idExercise', $idExercise, PDO::PARAM_INT);

		if($stmt->execute()){
			return "ok";
		} else {
			print_r($pdo->errorInfo());
		}
		$stmt->closeCursor();
		$stmt = null;
	}

	static public function mdlDeleteUser($idUsers){
		$pdo = Conexion::conectar();
		$sql = "DELETE FROM montrer_users
				WHERE idUsers = :idUsers";

		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idUsers', $idUsers, PDO::PARAM_INT);

		if($stmt->execute()){
			return "ok";
		} else {
			print_r($pdo->errorInfo());
		}
		$stmt->closeCursor();
		$stmt = null;
	}

	static public function mdlSelectAreaUser($idUsers){
	   $pdo = Conexion::conectar();
	   $sql = "SELECT * FROM montrer_area WHERE idUser = :idUser";
	   $stmt = $pdo->prepare($sql);
	   $stmt->bindParam(':idUser', $idUsers, PDO::PARAM_INT);
	   $stmt->execute();
	   $result = $stmt->fetchAll();
	   $stmt->closeCursor();
	   $stmt = null;
	   return $result;
	}

	static public function mdlNullAreaUser($idArea){
	   $pdo = Conexion::conectar();
	   $sql = "UPDATE montrer_area SET idUser = null WHERE idArea = :idArea ";
	   $stmt = $pdo->prepare($sql);
	   $stmt->bindParam(':idArea', $idArea, PDO::PARAM_INT);
	   if($stmt->execute()){
		return "ok";
	   } else {
		print_r($pdo->errorInfo());
	   }
	   $stmt->closeCursor();
	   $stmt = null;
	}

	static public function mdlDeleteArea($idArea){
		$pdo = Conexion::conectar();
		$sql = "DELETE FROM montrer_area
				WHERE idArea = :idArea";

		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idArea', $idArea, PDO::PARAM_INT);

		if($stmt->execute()){
			return "ok";
		} else {
			print_r($pdo->errorInfo());
		}
		$stmt->closeCursor();
		$stmt = null;
	}

	static public function mdlDeleteBudget($idBudget){
		$pdo = Conexion::conectar();
		$sql = "DELETE FROM montrer_budgets
				WHERE idBudget = :idBudget";

		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idBudget', $idBudget, PDO::PARAM_INT);

		if($stmt->execute()){
			return "ok";
		} else {
			print_r($pdo->errorInfo());
		}
		$stmt->closeCursor();
		$stmt = null;
	}

	static public function mdlEnableBudget($idBudget){
		$pdo = Conexion::conectar();
		$sql = "UPDATE montrer_budgets
				SET status = 1
				WHERE idBudget = :idBudget";

		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idBudget', $idBudget, PDO::PARAM_INT);

		if($stmt->execute()){
			return "ok";
		} else {
			print_r($pdo->errorInfo());
		}
		$stmt->closeCursor();
		$stmt = null;
	}

	static public function mdlDisableBudget($idBudget){
		$pdo = Conexion::conectar();
		$sql = "UPDATE montrer_budgets
				SET status = 0
				WHERE idBudget = :idBudget";

		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idBudget', $idBudget, PDO::PARAM_INT);

		if($stmt->execute()){
			return "ok";
		} else {
			print_r($pdo->errorInfo());
		}
		$stmt->closeCursor();
		$stmt = null;
	}

	static public function mdlUpdateBudget($data){
		$pdo = Conexion::conectar();
		$sql = "UPDATE montrer_budgets
				SET AuthorizedAmount = :AuthorizedAmount, idArea = :idArea, idExercise = :idExercise
				WHERE idBudget = :idBudget";

		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':AuthorizedAmount', $data['AuthorizedAmount'], PDO::PARAM_INT);
		$stmt->bindParam(':idArea', $data['idArea'], PDO::PARAM_INT);
		$stmt->bindParam(':idExercise', $data['idExercise'], PDO::PARAM_INT);
		$stmt->bindParam(':idBudget', $data['idBudget'], PDO::PARAM_INT);

		if($stmt->execute()){
			return "ok";
		} else {
			print_r($pdo->errorInfo());
		}
		$stmt->closeCursor();
		$stmt = null;
	}

	static public function mdlGetProviders(){
	   $pdo = Conexion::conectar();
	   $sql = "SELECT * FROM montrer_providers";
	   $stmt = $pdo->prepare($sql);
	   $stmt->execute();
	   $result = $stmt->fetchAll();
	   $stmt->closeCursor();
	   $stmt = null;
	   return $result;
	}

	static public function mdlGetProviderON(){
	   $pdo = Conexion::conectar();
	   $sql = "SELECT idProvider, CONCAT(representative_name,'(',provider_key,')') FROM montrer_providers WHERE status = 1;";
	   $stmt = $pdo->prepare($sql);
	   $stmt->execute();
	   $result = $stmt->fetchAll();
	   $stmt->closeCursor();
	   $stmt = null;
	   return $result;
	}

	static public function mdlRegisterProvider($data){
		$pdo = Conexion::conectar();
		$sql = "INSERT INTO montrer_providers 
		(provider_key, representative_name, contact_phone, email, website, business_name, rfc, 
		fiscal_address_street, fiscal_address_colonia, fiscal_address_municipio, fiscal_address_estado, 
		fiscal_address_cp, bank_name, account_holder, account_number, clabe, created_at, updated_at) 
		VALUES 
		(:providerKey, :representativeName, :contactPhone, :email, :website, :businessName, :rfc, 
		:fiscalAddressStreet, :fiscalAddressColonia, :fiscalAddressMunicipio, :fiscalAddressEstado, 
		:fiscalAddressCP, :bankName, :accountHolder, :accountNumber, :clabe, NOW(), NOW())";

		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':providerKey', $data['providerKey'], PDO::PARAM_STR);
		$stmt->bindParam(':representativeName', $data['representativeName'], PDO::PARAM_STR);
		$stmt->bindParam(':contactPhone', $data['contactPhone'], PDO::PARAM_STR);
		$stmt->bindParam(':email', $data['email'], PDO::PARAM_STR);
		$stmt->bindParam(':website', $data['website'], PDO::PARAM_STR);
		$stmt->bindParam(':businessName', $data['businessName'], PDO::PARAM_STR);
		$stmt->bindParam(':rfc', $data['rfc'], PDO::PARAM_STR);
		$stmt->bindParam(':fiscalAddressStreet', $data['fiscalAddressStreet'], PDO::PARAM_STR);
		$stmt->bindParam(':fiscalAddressColonia', $data['fiscalAddressColonia'], PDO::PARAM_STR);
		$stmt->bindParam(':fiscalAddressMunicipio', $data['fiscalAddressMunicipio'], PDO::PARAM_STR);
		$stmt->bindParam(':fiscalAddressEstado', $data['fiscalAddressEstado'], PDO::PARAM_STR);
		$stmt->bindParam(':fiscalAddressCP', $data['fiscalAddressCP'], PDO::PARAM_STR);
		$stmt->bindParam(':bankName', $data['bankName'], PDO::PARAM_STR);
		$stmt->bindParam(':accountHolder', $data['accountHolder'], PDO::PARAM_STR);
		$stmt->bindParam(':accountNumber', $data['accountNumber'], PDO::PARAM_STR);
		$stmt->bindParam(':clabe', $data['clabe'], PDO::PARAM_STR);

		if($stmt->execute()){
			$result = 'ok';
		} else {
			$result = 'Error';
			print_r($pdo->errorInfo());
		}
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlUpdateProvider($data){
		$pdo = Conexion::conectar();
		$sql = "UPDATE montrer_providers SET representative_name = :representativeName, contact_phone = :contactPhone, email = :email, website = :website, business_name = :businessName, rfc = :rfc, fiscal_address_street = :fiscalAddressStreet, fiscal_address_colonia = :fiscalAddressColonia, fiscal_address_municipio = :fiscalAddressMunicipio, fiscal_address_estado = :fiscalAddressEstado, fiscal_address_cp = :fiscalAddressCP, bank_name = :bankName, account_holder = :accountHolder, account_number = :accountNumber, clabe = :clabe WHERE provider_key = :providerKey";

		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':representativeName', $data['representativeName'], PDO::PARAM_STR);
		$stmt->bindParam(':contactPhone', $data['contactPhone'], PDO::PARAM_STR);
		$stmt->bindParam(':email', $data['email'], PDO::PARAM_STR);
		$stmt->bindParam(':website', $data['website'], PDO::PARAM_STR);
		$stmt->bindParam(':businessName', $data['businessName'], PDO::PARAM_STR);
		$stmt->bindParam(':rfc', $data['rfc'], PDO::PARAM_STR);
		$stmt->bindParam(':fiscalAddressStreet', $data['fiscalAddressStreet'], PDO::PARAM_STR);
		$stmt->bindParam(':fiscalAddressColonia', $data['fiscalAddressColonia'], PDO::PARAM_STR);
		$stmt->bindParam(':fiscalAddressMunicipio', $data['fiscalAddressMunicipio'], PDO::PARAM_STR);
		$stmt->bindParam(':fiscalAddressEstado', $data['fiscalAddressEstado'], PDO::PARAM_STR);
		$stmt->bindParam(':fiscalAddressCP', $data['fiscalAddressCP'], PDO::PARAM_STR);
		$stmt->bindParam(':bankName', $data['bankName'], PDO::PARAM_STR);
		$stmt->bindParam(':accountHolder', $data['accountHolder'], PDO::PARAM_STR);
		$stmt->bindParam(':accountNumber', $data['accountNumber'], PDO::PARAM_STR);
		$stmt->bindParam(':clabe', $data['clabe'], PDO::PARAM_STR);
		$stmt->bindParam(':providerKey', $data['providerKey'], PDO::PARAM_STR);

		if($stmt->execute()){
			$result = 'ok';
		} else {
			$result = 'Error';
			print_r($pdo->errorInfo());
		}
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlNextIdProvider(){
		$pdo = Conexion::conectar();
		$sql = "SELECT LPAD(IFNULL(MAX(idProvider), 0) + 1, 3, '0') AS nextIdProvider FROM montrer_providers;";
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetch();
		$stmt->closeCursor();
		$stmt = null; 
		return $result; 
	}

	static public function mdlDisableProvider($idProvider){
		$pdo = Conexion::conectar();
		$sql = "UPDATE montrer_providers
				SET status = 0
				WHERE idProvider = :idProvider";

		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idProvider', $idProvider, PDO::PARAM_INT);

		if($stmt->execute()){
			return "ok";
		} else {
			print_r($pdo->errorInfo());
		}
		$stmt->closeCursor();
		$stmt = null;
	}

	static public function mdlEnableProvider($idProvider){
		$pdo = Conexion::conectar();
		$sql = "UPDATE montrer_providers
				SET status = 1
				WHERE idProvider = :idProvider";

		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idProvider', $idProvider, PDO::PARAM_INT);

		if($stmt->execute()){
			return "ok";
		} else {
			print_r($pdo->errorInfo());
		}
		$stmt->closeCursor();
		$stmt = null;
	}

	static public function mdlDeleteProvider($idProvider){
		$pdo = Conexion::conectar();
		$sql = "DELETE FROM montrer_providers
				WHERE idProvider = :idProvider";

		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idProvider', $idProvider, PDO::PARAM_INT);

		if($stmt->execute()){
			return "ok";
		} else {
			print_r($pdo->errorInfo());
		}
		$stmt->closeCursor();
		$stmt = null;
	}
	
	static public function mdlGetProvider($idProvider){
		$pdo = Conexion::conectar();
		$sql = "SELECT * FROM montrer_providers WHERE idProvider = :idProvider";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idProvider', $idProvider, PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetch();
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}
	
	static public function mdlGetAreaManager($idUser){
		$pdo = Conexion::conectar();
		$sql = "SELECT a.idArea, a.nameArea, b.AuthorizedAmount FROM montrer_exercise e
				LEFT JOIN montrer_budgets b ON b.idExercise = e.idExercise
				LEFT JOIN montrer_area a ON a.idArea = b.idArea
				WHERE b.status = 1 AND e.status = 1 AND a.idUser = :idUser";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetchAll();
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}
	
	static public function mdlGetAuthorizedAmount($idArea){
		$pdo = Conexion::conectar();
		$sql = "SELECT b.idBudget, a.idArea, m.month, m.budget_month, m.budget_used, m.total_used, m.idMensualBudget,r.requestedAmount, r.approvedAmount FROM montrer_budgets b
				LEFT JOIN montrer_month_budget m ON m.idBudget = b.idBudget
				LEFT JOIN montrer_budget_requests r ON r.idBudget = b.idBudget
				LEFT JOIN montrer_area a ON a.idArea = b.idArea
				RIGHT JOIN montrer_exercise e ON e.idExercise = b.idExercise
				WHERE a.idArea = :idArea AND e.status = 1;";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idArea', $idArea, PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetchAll();
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlGetRequests(){
	   $pdo = Conexion::conectar();
	   $sql = "SELECT a.idArea, r.idRequest, r.idBudget, r.requestedAmount, r.approvedAmount,
					r.description, r.requestDate, r.responseDate, r.status,
					a.nameArea, u.idUsers, u.firstname, u.lastname
				FROM montrer_budget_requests r
					LEFT JOIN montrer_area a ON a.idArea = r.idArea
					LEFT JOIN montrer_users u ON u.idUsers = a.idUser
				WHERE a.status = 1;";
	   $stmt = $pdo->prepare($sql);
	   $stmt->execute();
	   $result = $stmt->fetchAll();
	   $stmt->closeCursor();
	   $stmt = null;
	   return $result;
	}

	static public function mdlRequestBudget($data){
		$pdo = Conexion::conectar();

		$sql = "INSERT INTO montrer_budget_requests
					(idArea, idBudget, idProvider, requestedAmount, description, idUser, event, eventDate, requestDate) 
				VALUES 
					(:idArea, :idBudget, :idProvider, :requestedAmount, :description, :idUser, :event, :eventDate, DATE_ADD(NOW(), INTERVAL -6 HOUR) )";

		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idArea', $data['area'], PDO::PARAM_INT);
		$stmt->bindParam(':idBudget', $data['budget'], PDO::PARAM_INT);
		$stmt->bindParam(':idProvider', $data['provider'], PDO::PARAM_INT);
		$stmt->bindParam(':requestedAmount', $data['requestedAmount'], PDO::PARAM_STR);
		$stmt->bindParam(':description', $data['description'], PDO::PARAM_STR);
		$stmt->bindParam(':idUser', $data['idUser'], PDO::PARAM_INT);
		$stmt->bindParam(':event', $data['event'], PDO::PARAM_STR);
		$stmt->bindParam(':eventDate', $data['eventDate'], PDO::PARAM_STR);

		if($stmt->execute()){
			$result = 'ok';
		} else {
			print_r($pdo->errorInfo());
			$result = 'Error';
		}
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlDeleteRequest($idRequest){
		$pdo = Conexion::conectar();
		$sql = "DELETE FROM montrer_budget_requests
				WHERE idRequest = :idRequest";

		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idRequest', $idRequest, PDO::PARAM_INT);

		if($stmt->execute()){
			return "ok";
		} else {
			print_r($pdo->errorInfo());
		}
		$stmt->closeCursor();
		$stmt = null;
	}
	
	static public function mdlGetRequest($idRequest){
		$pdo = Conexion::conectar();
		$sql = "SELECT * FROM montrer_budget_requests WHERE idRequest = :idRequest";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idRequest', $idRequest, PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetch();
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlDenegateRequest($idRequest, $idAdmin){
		$pdo = Conexion::conectar();
		$sql = "UPDATE montrer_budget_requests SET idAdmin = :idAdmin, responseDate = DATE_ADD(NOW(), INTERVAL -6 HOUR), status = 2 where idRequest = :idRequest";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idAdmin', $idAdmin, PDO::PARAM_INT);
		$stmt->bindParam(':idRequest', $idRequest, PDO::PARAM_INT);
		if($stmt->execute()){
			$result = 'ok';
		} else {
			print_r($pdo->errorInfo());
			$result = 'Error';
		}
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlEnableRequest($idRequest, $idAdmin, $approvedAmount){
		$pdo = Conexion::conectar();
		$sql = "UPDATE montrer_budget_requests SET idAdmin = :idAdmin, responseDate = DATE_ADD(NOW(), INTERVAL -6 HOUR), status = 1, approvedAmount = :approvedAmount where idRequest = :idRequest";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idAdmin', $idAdmin, PDO::PARAM_INT);
		$stmt->bindParam(':approvedAmount', $approvedAmount, PDO::PARAM_STR);
		$stmt->bindParam(':idRequest', $idRequest, PDO::PARAM_INT);
		if($stmt->execute()){
			$result = 'ok';
		} else {
			print_r($pdo->errorInfo());
			$result = 'Error';
		}
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}
	
	static public function mdlGetMonthBudget($idBudget){
		$pdo = Conexion::conectar();
		$sql = "SELECT * FROM montrer_month_budget WHERE idBudget = :idBudget";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idBudget', $idBudget, PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetchAll();
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}
	
	static public function mdlFillBudgetMouth($idMensualBudget, $budget_used)	{
		$pdo = Conexion::conectar();
		$sql = "UPDATE montrer_month_budget SET budget_used=:budget_used WHERE idMensualBudget = :idMensualBudget";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':budget_used', $budget_used, PDO::PARAM_STR);
		$stmt->bindParam(':idMensualBudget', $idMensualBudget, PDO::PARAM_INT);
		if($stmt->execute()){
			$result = 'ok';
		} else {
			print_r($pdo->errorInfo());
			$result = 'Error';
		}
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}
	
	static public function mdlGetRequestComprobar($idRequest){
		$pdo = Conexion::conectar();
		$sql = "SELECT 
					br.idRequest,
					br.requestedAmount,
					br.description,
					br.approvedAmount,
					br.responseDate,
					br.requestDate,
					br.event,
					br.eventDate,
					a.nameArea,
					p.business_name,
					br.idProvider
				FROM montrer_budget_requests br
					LEFT JOIN montrer_budgets b ON b.idBudget = br.idBudget
					LEFT JOIN montrer_area a ON a.idArea = br.idArea
					LEFT JOIN montrer_providers p ON p.idProvider = br.idProvider
				WHERE idRequest = :idRequest";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idRequest', $idRequest, PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetch();
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlSendComprobation($data){
		$pdo = Conexion::conectar();
		$sql = "INSERT INTO montrer_payment_requests(nombreCompleto, fechaSolicitud, idProvider, idArea, importeSolicitado, importeLetra, titularCuenta, entidadBancaria, conceptoPago, idRequest, idUser) VALUES (:nombreCompleto,:fechaSolicitud,:provider,:area,:importeSolicitado,:importeLetra,:titularCuenta,:entidadBancaria,:conceptoPago,:idRequest,:idUser);";
		$sql .= "UPDATE montrer_budget_requests set status = 2 WHERE idRequest = :idRequest;";
		
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':nombreCompleto', $data['nombreCompleto'], PDO::PARAM_STR);
		$stmt->bindParam(':fechaSolicitud', $data['fechaSolicitud'], PDO::PARAM_STR);
		$stmt->bindParam(':provider', $data['provider'], PDO::PARAM_INT);
		$stmt->bindParam(':area', $data['area'], PDO::PARAM_INT);
		$stmt->bindParam(':importeSolicitado', $data['importeSolicitado'], PDO::PARAM_STR);
		$stmt->bindParam(':importeLetra', $data['importeLetra'], PDO::PARAM_STR);
		$stmt->bindParam(':titularCuenta', $data['titularCuenta'], PDO::PARAM_STR);
		$stmt->bindParam(':entidadBancaria', $data['entidadBancaria'], PDO::PARAM_STR);
		$stmt->bindParam(':conceptoPago', $data['conceptoPago'], PDO::PARAM_STR);
		$stmt->bindParam(':idRequest', $data['idRequest'], PDO::PARAM_INT);
		$stmt->bindParam(':idUser', $data['idUser'], PDO::PARAM_INT);
		if($stmt->execute()){
			$result = $pdo->lastInsertId();
		} else {
			print_r($pdo->errorInfo());
			$result = 'Error';
		}
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}
	static public function mdlGetComprobante($idRequest){
		$pdo = Conexion::conectar();
        $sql = "SELECT r.*, a.nameArea, p.business_name FROM montrer_payment_requests r
					LEFT JOIN montrer_area a ON a.idArea = r.idArea
					LEFT JOIN montrer_providers p ON p.idProvider = r.idProvider
				WHERE idRequest = :idRequest";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':idRequest', $idRequest, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch();
        $stmt->closeCursor();
        $stmt = null;
        return $result;
	}
}
