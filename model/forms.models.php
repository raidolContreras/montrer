<?php 
include "conection.php";

class FormsModels {

	static public function mdlCreateUser($data){
		$pdo = Conexion::conectar();
		$sql = "INSERT INTO montrer_users(firstname, lastname, email) VALUES (:firstname, :lastname, :email)";

		$stmt = $pdo->prepare($sql);

		$stmt->bindParam(':firstname', $data['firstname'], PDO::PARAM_STR);
		$stmt->bindParam(':lastname', $data['lastname'], PDO::PARAM_STR);
		$stmt->bindParam(':email', $data['email'], PDO::PARAM_STR);
		if ($stmt->execute()) {
			return $data['email'];
		} else {
			print_r(Conexion::conectar()->errorInfo());
		}

		$stmt->close();
		$stmt = null;
	}
}