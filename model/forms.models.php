<?php 
include "conection.php";

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
				return $data['email'];
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
}
