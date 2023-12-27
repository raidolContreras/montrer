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
			$subject = "Bienvenido a nuestro sitio web"; // el asunto del correo electrónico
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
						font-weight: bold;
					}
					.message {
						font-size: 16px;
						line-height: 1.5;
					}
					.password {
						font-size: 20px;
						font-weight: bold;
						color: #ff0000;
					}
					.link {
						font-size: 16px;
						text-decoration: none;
						color: #0000ff;
					}
				</style>
			</head>
			<body>
				<div class="container">
					<div class="header">
						<img src="https://tests.contreras-flota.click/FinFlair/assets/img/logo.png" alt="Logo" class="logo">
					</div>
					<div class="content">
						<p class="greeting">Hola '.$firstname.' '.$lastname.', Has sido registrado en nuestro sitio web FinFlair.</p>
						<p class="message">Para acceder a tu cuenta, necesitas una contraseña temporal que te hemos generado. Esta es tu contraseña temporal:</p>
						<p class="password">'.$password.'</p>
						<p class="message">Te recomendamos que iniciar sesión con esta contraseña lo antes posible. Para hacerlo, puedes seguir este enlace:</p>
						<p><a href="https://tests.contreras-flota.click/FinFlair/" class="link">Ingresar a la plataforma</a></p>
						<p class="message">Si tienes alguna duda o problema, no dudes en contactarnos. Estamos para ayudarte.</p>
					</div>
					<div class="footer">
						<p>© 2023 FinFlair. Todos los derechos reservados.</p>
					</div>
				</div>
			</body>
			</html>';

			// el encabezado De y el tipo de contenido
			$headers = "From: noreply@finflair.com\r\n";
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
	
}
