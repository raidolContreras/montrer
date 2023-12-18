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
				$temporalPassword = FormsModels::mdlSendPassword($userId, generarPassword(), $data['firstname'], $data['lastname']);
				if($temporalPassword == 'ok'){
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
	
	static public function mdlSendPassword($userId, $password, $firstname, $lastname){
		
			// enviar un correo electrónico al usuario creado
			$to = $createUser; // la dirección de correo electrónico del usuario
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
						<img src="logo.png" alt="Logo" class="logo">
					</div>
					<div class="content">
						<p class="greeting">Hola '.$firstname.' '.$lastname.', Has sido registrado en nuestro sitio web <strong>FinFlair</strong>.</p>
						<p class="message">Esperamos que disfrutes de nuestros servicios. Para acceder a tu cuenta, necesitas una contraseña temporal que te hemos generado. Esta es tu contraseña temporal:</p>
						<p class="password">'.$password.'</p>
						<p class="message">Te recomendamos que cambies esta contraseña lo antes posible por una de tu elección. Para hacerlo, puedes seguir este enlace:</p>
						<p><a href="https://tests.contreras-flota.click/FinFlair/" class="link">Cambiar contraseña</a></p>
						<p class="message">Si tienes alguna duda o problema, no dudes en contactarnos. Estamos para ayudarte.</p>
					</div>
					<div class="footer">
						<p>© 2023 FinFlair. Todos los derechos reservados.</p>
					</div>
				</div>
			</body>
			</html>
			';
			// el encabezado De y el tipo de contenido
			$headers = "From: noreply@finflair.com\r\n";
			$headers .= "Content-type: text/html\r\n";
			// llamar a la función mail ()
			mail ($to, $subject, $message, $headers);

			$cryptPassword = crypt($password, '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

			$temporalPassword = FormsModels::mdlRegisterPassword($userId, $cryptPassword);

			return $temporalPassword;

	}
}
