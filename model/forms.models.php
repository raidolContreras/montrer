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
				(SELECT exerciseName FROM montrer_exercise WHERE status = 1 ) AS name,
				(SELECT budget FROM montrer_exercise WHERE status = 1 ) AS budget,
				(SELECT bn.total_budget_net FROM montrer_budget_net bn LEFT JOIN montrer_exercise e ON e.idExercise = bn.Exercise_idExercise WHERE e.status = 1  ) AS rest";
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		return $stmt->fetch();
		$stmt->closeCursor();
		$stmt = null;
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
				if($temporalPassword == 'ok' && $settings == 'ok'){
					return $data['email'];
				} else {
					return 'Error';
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
						<p class="message">Para acceder a la plataforma, de clic en el siguiente vinculo (<a href="https://tests.hucco.com/" class="link">Ingresar a la plataforma</a>), su usuario es: '.$email.' y su contraseña temporal:
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
		$sql = "SELECT * FROM montrer_users";
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
		$sql = "SELECT * FROM montrer_users WHERE email = :email";
		$stmt = $pdo->prepare($sql);
		
		$stmt->bindParam(':email', $email, PDO::PARAM_STR);
		$stmt->execute();
		return $stmt->fetch();
		// Asegúrate de cerrar la conexión en el bloque finally
		$stmt->closeCursor();
		$stmt = null;
	}

	static public function mdlFirstLoginUser($idUsers){
		$pdo = Conexion::conectar();
		$sql = "SELECT * FROM montrer_temporal_password WHERE User_idUser = :User_idUser";
		$stmt = $pdo->prepare($sql);
		
		$stmt->bindParam(':User_idUser', $idUsers, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetch();
		// Asegúrate de cerrar la conexión en el bloque finally
		$stmt->closeCursor();
		$stmt = null;
	}

	static public function mdlUpdateLog($idUsers){

		$pdo = Conexion::conectar();
		$sql = "UPDATE montrer_users SET lastConection = NOW() WHERE idUsers = :idUsers";
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
		$sql = "SELECT a.idArea, a.nameArea, a.description, u.firstname, u.lastname FROM montrer_area a
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
		return $stmt->fetchAll();
		$stmt->closeCursor();
		$stmt = null;
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
			$idExercise = $pdo->lastInsertId();
			$montrer_budget_net = FormsModels::mdlAddBudgetNet($idExercise, $data['budget']);
			return $montrer_budget_net;
		} else {
			return 'Error';
			print_r($pdo->errorInfo());
		}
		$stmt->closeCursor();
		$stmt = null;  
	}

	static public function mdlAddBudgetNet($idExercise, $budget){
		$pdo = Conexion::conectar();
		$sql = "INSERT INTO montrer_budget_net(Exercise_idExercise, total_budget_net) VALUES (:Exercise_idExercise, :total_budget_net)";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':Exercise_idExercise', $idExercise, PDO::PARAM_INT);
		$stmt->bindParam(':total_budget_net', $budget, PDO::PARAM_STR);
		if($stmt->execute()){
			return "ok";
		} else {
			print_r($pdo->errorInfo());
		}
	}
	
	static public function mdlGetBudgets(){
		$pdo = Conexion::conectar();
		$sql = "SELECT b.idBudget, b.AuthorizedAmount, a.nameArea, a.idArea, e.exerciseName, e.budget, e.status, e.idExercise
				FROM montrer_budgets b
				LEFT JOIN montrer_area a ON a.idArea = b.idArea
				LEFT JOIN montrer_exercise e ON e.idExercise = b.idExercise;";
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll();
		$stmt->closeCursor();
		$stmt = null;
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
			return 'ok';
		} else {
			return 'Error';
			print_r($pdo->errorInfo());
		}
		$stmt->closeCursor();
		$stmt = null;  
	}
	
}
