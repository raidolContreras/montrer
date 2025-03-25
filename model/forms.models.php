<?php
include "conection.php";

function generarPassword()
{
	$caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
	$password = '';

	for ($i = 0; $i < 8; $i++) {
		$indice = rand(0, strlen($caracteres) - 1);
		$password .= $caracteres[$indice];
	}
	return $password;
}

class FormsModels
{

	// Action Logs
	static public function mdlLog($idUser, $action, $ip)
	{

		$pdo = Conexion::conectar();
		$sql = "INSERT INTO montrer_logs(idUser, actionType, ipAddress) VALUES (:idUser,:action,:ip)";
		$stmt = $pdo->prepare($sql);

		$stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
		$stmt->bindParam(':action', $action, PDO::PARAM_STR);
		$stmt->bindParam(':ip', $ip, PDO::PARAM_STR);

		if ($stmt->execute()) {
			$result = 'ok';
		} else {
			print_r($pdo->errorInfo());
		}
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	// Inicio de Contadores
	static public function mdlCountAreas()
	{
		$pdo = Conexion::conectar();
		$sql = "SELECT 
				(SELECT COUNT(*) FROM montrer_area WHERE status = 1) AS areas,
				(SELECT COUNT(*) 
				FROM montrer_users u 
					LEFT JOIN montrer_settings s ON s.idUser = u.idUsers 
				WHERE s.status = 1) AS users,
				(SELECT exerciseName FROM montrer_exercise WHERE status = 1) AS name,
				COALESCE(
				(SELECT SUM(AuthorizedAmount) 
				FROM montrer_budgets b 
					LEFT JOIN montrer_exercise e ON e.idExercise = b.idExercise 
				WHERE e.status = 1 AND b.status = 1), 0
				) AS used,
				COALESCE(
				(SELECT SUM(br.approvedAmount) 
				FROM montrer_budget_requests br
					LEFT JOIN montrer_budgets b ON b.idBudget = br.idBudget
					LEFT JOIN montrer_exercise e ON e.idExercise = b.idExercise
				WHERE br.status = 5 AND br.active = 0 AND e.status = 1), 0
				) AS comp,
				COALESCE(
				(SELECT SUM(approvedAmount) 
					FROM montrer_budget_requests 
				WHERE active = 1), 0
				) AS nocomp,
				(SELECT budget FROM montrer_exercise WHERE status = 1) AS budget,
				COALESCE(
				(SELECT SUM(approvedAmount) 
					FROM montrer_budget_requests 
				WHERE status IN (1, 2, 4, 5)), 0
				) AS spent,
				(
				(SELECT budget FROM montrer_exercise WHERE status = 1) - 
				COALESCE(
					(SELECT SUM(AuthorizedAmount) 
					FROM montrer_budgets b 
						LEFT JOIN montrer_exercise e ON e.idExercise = b.idExercise 
					WHERE e.status = 1 AND b.status = 1), 0
				)
				) AS remaining,
				(
				(SELECT budget FROM montrer_exercise WHERE status = 1) - 
				COALESCE(
					(SELECT SUM(approvedAmount) 
						FROM montrer_budget_requests 
					WHERE status IN (1, 2, 4, 5)), 0)
				) AS exercisable_budget;";
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetch();
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlCountArea($idUser)
	{
		$pdo = Conexion::conectar();
		$sql = "SELECT 
            CONCAT('{', GROUP_CONCAT(CONCAT('\"', a.idArea, '\":\"', a.nameArea, '\"')), '}') AS areas,
            CONCAT('{', GROUP_CONCAT(CONCAT('\"', b.idArea, '\":', b.AuthorizedAmount)), '}') AS budgets,
            (SELECT exerciseName FROM montrer_exercise WHERE status = 1 LIMIT 1) AS name,
            COALESCE((SELECT SUM(approvedAmount) FROM montrer_budget_requests WHERE status = 5 AND active = 0 AND idUser = :idUser), 0) AS comp,
            COALESCE((SELECT SUM(approvedAmount) FROM montrer_budget_requests WHERE idArea = a.idArea AND status <> 0 AND status <> 3), 0) AS amountUsed,
            COALESCE((SELECT SUM(approvedAmount) FROM montrer_budget_requests WHERE active = 1 AND idUser = :idUser), 0) AS nocomp
        FROM 
            montrer_area a
        LEFT JOIN montrer_users_to_areas ua ON ua.idArea = a.idArea
        LEFT JOIN montrer_budgets b ON b.idArea = ua.idArea
        WHERE 
            ua.idUser = :idUser;";

		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetch();
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlCountAreaId($idArea)
	{
		$pdo = Conexion::conectar();

		$sql = "SELECT nameArea, areaCode,
		COALESCE((SELECT SUM(r.approvedAmount) FROM montrer_budget_requests r
					LEFT JOIN montrer_budgets b ON b.idBudget = r.idBudget
					LEFT JOIN montrer_exercise e ON e.idExercise = b.idExercise
				WHERE e.status = 1 AND r.idArea = :idArea), 0) AS comp,

		COALESCE((SELECT SUM(r.approvedAmount) FROM montrer_budget_requests r
					LEFT JOIN montrer_budgets b ON b.idBudget = r.idBudget
					LEFT JOIN montrer_exercise e ON e.idExercise = b.idExercise
				WHERE e.status = 1 AND r.idArea = :idArea AND r.status = 5 AND r.active = 0), 0) AS compActive,

		(SELECT b.AuthorizedAmount FROM montrer_budgets b
					LEFT JOIN montrer_exercise e ON e.idExercise = b.idExercise
				WHERE e.status = 1 AND b.idArea = :idArea) AS total

        FROM 
            montrer_area 
        WHERE 
            idArea = :idArea;";

		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idArea', $idArea, PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetch();
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	// Fin de Contadores

	static public function mdlCreateUser($data)
	{
		try {
			$pdo = Conexion::conectar();
			$sql = "INSERT INTO montrer_users(firstname, lastname, email, employerCode) VALUES (:firstname, :lastname, :email, :employerCode)";

			$stmt = $pdo->prepare($sql);

			$stmt->bindParam(':firstname', $data['firstname'], PDO::PARAM_STR);
			$stmt->bindParam(':lastname', $data['lastname'], PDO::PARAM_STR);
			$stmt->bindParam(':email', $data['email'], PDO::PARAM_STR);
			$stmt->bindParam(':employerCode', $data['employerCode'], PDO::PARAM_STR);

			if ($stmt->execute()) {
				$userId = $pdo->lastInsertId();
				$temporalPassword = FormsController::ctrSendPassword($userId, generarPassword(), $data['firstname'], $data['lastname'], $data['email']);
				$settings = FormsModels::mdlSettingsUser($userId, $data['level'], 0);
				if ($data['area'] != '') {
					$area = FormsModels::mdlUpdateAreaUser($userId, $data['area']);
					if ($temporalPassword == 'ok' && $settings == 'ok' && $area == 'ok') {
						$result = $data['email'];
					} else {
						$result = 'Error';
					}
				} else {
					if ($temporalPassword == 'ok' && $settings == 'ok') {
						$result = $data['email'];
					} else {
						$result = 'Error al enviar el correo';
					}
				}
			} else {
				$result = 'Error';
			}
		} catch (PDOException $e) {
			// Verifica si la excepción es por una violación de la restricción de integridad
			if ($e->getCode() == '23000') {
				// Violación de restricción de integridad (clave duplicada)
				$result = 'Error: Email duplicado';
			} else {
				// Otra excepción
				$result = 'Error';
			}
		} finally {
			// Asegúrate de cerrar la conexión en el bloque finally
			$stmt->closeCursor();
			$stmt = null;
			return $result;
		}
	}

	static public function mdlUpdateAreaUser($idUser, $idArea)
	{
		$pdo = Conexion::conectar();
		$sql = "INSERT INTO montrer_users_to_areas(idUser, idArea) VALUES (:idUser, :idArea)";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
		$stmt->bindParam(':idArea', $idArea, PDO::PARAM_INT);
		if ($stmt->execute()) {
			$result = "ok";
		} else {
			print_r($pdo->errorInfo());
		}
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlRegisterPassword($userId, $cryptPassword)
	{

		$pdo = Conexion::conectar();
		$sql = "INSERT INTO montrer_temporal_password(temporal_password, User_idUser) VALUES (:temporal_password, :User_idUser)";
		$stmt = $pdo->prepare($sql);

		$stmt->bindParam(':temporal_password', $cryptPassword, PDO::PARAM_STR);
		$stmt->bindParam(':User_idUser', $userId, PDO::PARAM_INT);

		if ($stmt->execute()) {
			$result = 'ok';
		} else {
			print_r($pdo->errorInfo());
		}

		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlSettingsUser($userId, $level, $root)
	{

		$pdo = Conexion::conectar();
		$sql = "INSERT INTO montrer_settings(idUser, level, root) VALUES (:idUser, :level, :root)";
		$stmt = $pdo->prepare($sql);

		$stmt->bindParam(':idUser', $userId, PDO::PARAM_INT);
		$stmt->bindParam(':level', $level, PDO::PARAM_INT);
		$stmt->bindParam(':root', $root, PDO::PARAM_INT);

		if ($stmt->execute()) {
			$result = 'ok';
		} else {
			print_r($pdo->errorInfo());
		}

		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlGetUsers()
	{
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
					GROUP_CONCAT(DISTINCT a.nameArea SEPARATOR ', ') AS nameArea
				FROM 
					montrer_users u
				LEFT JOIN 
					montrer_settings s ON s.idUser = u.idUsers
				LEFT JOIN
					montrer_users_to_areas ua ON ua.idUser = u.idUsers
				LEFT JOIN 
					montrer_area a ON ua.idArea = a.idArea
				WHERE u.deleted = 0
				GROUP BY 
					u.idUsers;";
		$stmt = $pdo->prepare($sql);

		if ($stmt->execute()) {
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		} else {
			print_r($pdo->errorInfo());
		}

		// Asegúrate de cerrar la conexión en el bloque finally
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlSelectUser($email)
	{
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

	static public function mdlSelectPasswordUser($idUsers)
	{
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

	static public function mdlFirstLoginUser($idUsers)
	{
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

	static public function mdlUpdateLog($idUsers)
	{

		$pdo = Conexion::conectar();
		$sql = "UPDATE montrer_users SET lastConection = DATE_ADD(NOW(), INTERVAL -6 HOUR) WHERE idUsers = :idUsers";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idUsers', $idUsers, PDO::PARAM_INT);
		if ($stmt->execute()) {
			$result = "ok";
		} else {
			print_r($pdo->errorInfo());
		}
		// Asegúrate de cerrar la conexión en el bloque finally
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlDelTemporalPassword($data)
	{

		$pdo = Conexion::conectar();
		$sql = "DELETE FROM montrer_temporal_password WHERE User_idUser = :idUser AND temporal_password = :temporal_password";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idUser', $data['user'], PDO::PARAM_INT);
		$stmt->bindParam(':temporal_password', $data['actualPassword'], PDO::PARAM_STR);
		if ($stmt->execute()) {
			$result = true;
		} else {
			print_r($pdo->errorInfo());
		}
		// Asegúrate de cerrar la conexión en el bloque finally
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlUpdatePassword($data)
	{
		$pdo = Conexion::conectar();
		$sql = "UPDATE montrer_users SET password = :newPassword WHERE idUsers = :idUsers";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':newPassword', $data['newPassword'], PDO::PARAM_STR);
		$stmt->bindParam(':idUsers', $data['user'], PDO::PARAM_INT);
		if ($stmt->execute()) {
			$result = true;
		} else {
			print_r($pdo->errorInfo());
		}
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlAddArea($data)
	{
		$pdo = Conexion::conectar();
		$sql = "INSERT INTO montrer_area(nameArea, description, areaCode) VALUES (:nameArea, :description, :areaCode)";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':nameArea', $data['nameArea'], PDO::PARAM_STR);
		$stmt->bindParam(':description', $data['areaDescription'], PDO::PARAM_STR);
		$stmt->bindParam(':areaCode', $data['areaCode'], PDO::PARAM_STR);
		if ($stmt->execute()) {
			$result = $pdo->lastInsertId();
			// $result = FormsModels::mdlAddAreaUser($data['user'], $pdo->lastInsertId());
			// return $result;
		} else {
			$result = 'Error';
		}
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlGetAreas()
	{
		$pdo = Conexion::conectar();
		$sql = "SELECT 
					a.idArea, 
					a.nameArea, 
					a.areaCode,
					IFNULL(a.description, '') AS description, 
					IFNULL(GROUP_CONCAT(DISTINCT CONCAT(u.firstname, ' ', u.lastname) SEPARATOR ', '), '') AS usuarios, 
					IFNULL(CONCAT('[', GROUP_CONCAT(DISTINCT IF(ua.idUser IS NOT NULL, ua.idUser, NULL)), ']'), '[]') AS idUser, 
					a.status
				FROM 
					montrer_area a
				LEFT JOIN 
					montrer_users_to_areas ua ON a.idArea = ua.idArea
				LEFT JOIN 
					montrer_users u ON u.idUsers = ua.idUser
				WHERE 
					a.active = 1
				GROUP BY 
					a.idArea, a.nameArea, a.description, a.status;

				";
		$stmt = $pdo->prepare($sql);

		if ($stmt->execute()) {
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		} else {
			print_r($pdo->errorInfo());
		}
		// Asegúrate de cerrar la conexión en el bloque finally
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlGetExercise()
	{
		$pdo = Conexion::conectar();
		$sql = "SELECT * FROM montrer_exercise";
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll();
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlGetExercises($idExercise)
	{
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

	static public function mdlAddExercise($data)
	{
		$pdo = Conexion::conectar();
		$sql = "INSERT INTO montrer_exercise(exerciseName, initialDate, finalDate, budget, idRoot) VALUES (:exerciseName, :initialDate, :finalDate, :budget, :idRoot)";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':exerciseName', $data['exerciseName'], PDO::PARAM_STR);
		$stmt->bindParam(':initialDate', $data['initialDate'], PDO::PARAM_STR);
		$stmt->bindParam(':finalDate', $data['finalDate'], PDO::PARAM_STR);
		$stmt->bindParam(':budget', $data['budget'], PDO::PARAM_STR);
		$stmt->bindParam(':idRoot', $data['user'], PDO::PARAM_INT);
		if ($stmt->execute()) {
			$result = "ok";
		} else {
			$result = 'Error';
			print_r($pdo->errorInfo());
		}
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlGetBudgets($idExercise)
	{
		$pdo = Conexion::conectar();
		if ($idExercise  != 'all') {
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

	static public function mdlGetBudget($idBudget)
	{
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

	static public function mdlActiveExercise()
	{
		$pdo = Conexion::conectar();
		$sql = "SELECT budget, idExercise, exerciseName FROM montrer_exercise WHERE status = 1";
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetch();
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlUpdateActiveExercise($idExercise)
	{
		$pdo = Conexion::conectar();
		$sql = "UPDATE montrer_exercise SET status = 0 WHERE status = 1;";
		$sql .= "UPDATE montrer_exercise SET status = 1 WHERE idExercise = :idExercise ";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idExercise', $idExercise, PDO::PARAM_INT);
		if ($stmt->execute()) {
			$result = "ok";
		} else {
			print_r($pdo->errorInfo());
		}
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlAddBudgets($data)
	{
		$pdo = Conexion::conectar();
		$sql = "INSERT INTO montrer_budgets(idArea, AuthorizedAmount, idExercise) VALUES (:area, :AuthorizedAmount, :exercise);";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':area', $data['area'], PDO::PARAM_INT);
		$stmt->bindParam(':AuthorizedAmount', $data['AuthorizedAmount'], PDO::PARAM_STR);
		$stmt->bindParam(':exercise', $data['exercise'], PDO::PARAM_INT);
		if ($stmt->execute()) {
			$idBudget = $pdo->lastInsertId();
			$result = $idBudget;
		} else {
			$result = 'Error';
			print_r($pdo->errorInfo());
		}
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlAddBudgetsMonths($month, $data)
	{
		$pdo = Conexion::conectar();
		$sql = "INSERT INTO montrer_month_budget(month, budget_month, idBudget) VALUES (:month, :budget_month, :idBudget)";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':month', $month, PDO::PARAM_INT);
		$stmt->bindParam(':budget_month', $data['budget_month'], PDO::PARAM_STR);
		$stmt->bindParam(':idBudget', $data['idBudget'], PDO::PARAM_INT);
		if ($stmt->execute()) {
			$result = 'ok';
		} else {
			$result = 'Error';
			print_r($pdo->errorInfo());
		}
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlGetUser($register)
	{
		$pdo = Conexion::conectar();
		$sql = "SELECT u.idUsers, u.firstname, u.lastname, s.level, u.email, u.employerCode FROM montrer_users u
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

	static public function mdlGetArea($register)
	{
		$pdo = Conexion::conectar();
		$sql = "SELECT 
					a.idArea, 
					a.nameArea,
					a.areaCode,
					IFNULL(a.description, '') AS description, 
					IFNULL(GROUP_CONCAT(DISTINCT CONCAT(u.firstname, ' ', u.lastname) SEPARATOR ', '), '') AS usuarios, 
					CONCAT('[', GROUP_CONCAT(DISTINCT IF(ua.idUser IS NOT NULL, ua.idUser, NULL)), ']') AS idUser, 
					a.status
				FROM 
					montrer_area a
				LEFT JOIN 
					montrer_users_to_areas ua ON ua.idArea = a.idArea
				LEFT JOIN 
					montrer_users u ON u.idUsers = ua.idUser
				WHERE 
					a.idArea = :idArea";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idArea', $register, PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetch();
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlGetAreaByName($name)
	{
		$pdo = Conexion::conectar();
		$sql = "SELECT * FROM montrer_area a LEFT JOIN montrer_users u ON u.idUsers = a.idUser WHERE a.nameArea = :nameArea";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':nameArea', $name, PDO::PARAM_STR);
		$stmt->execute();
		$result = $stmt->fetch();
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlUpdateUser($data)
	{
		$pdo = Conexion::conectar();
		$sql = "UPDATE montrer_users SET firstname = :firstname, lastname = :lastname, email = :email, employerCode = :employerCode WHERE idUsers = :idUsers ";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':firstname', $data['firstname'], PDO::PARAM_STR);
		$stmt->bindParam(':lastname', $data['lastname'], PDO::PARAM_STR);
		$stmt->bindParam(':email', $data['email'], PDO::PARAM_STR);
		$stmt->bindParam(':idUsers', $data['user'], PDO::PARAM_STR);
		$stmt->bindParam(':employerCode', $data['employerCode'], PDO::PARAM_STR);
		if ($stmt->execute()) {
			$result = "ok";
		} else {
			print_r($pdo->errorInfo());
		}
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlUpdateLevelUser($data)
	{
		$pdo = Conexion::conectar();
		$sql = "UPDATE montrer_settings SET level = :level WHERE idUser = :idUsers ";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':level', $data['level'], PDO::PARAM_INT);
		$stmt->bindParam(':idUsers', $data['user'], PDO::PARAM_INT);
		if ($stmt->execute()) {
			$result = "ok";
		} else {
			print_r($pdo->errorInfo());
		}
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlDeleteRegister($idUsers)
	{
		$pdo = Conexion::conectar();
		$sql = "UPDATE montrer_settings SET status = 0 WHERE idUser = :idUser ";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idUser', $idUsers, PDO::PARAM_INT);
		if ($stmt->execute()) {
			$result = "ok";
		} else {
			print_r($pdo->errorInfo());
		}
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlEnableRegister($idUsers)
	{
		$pdo = Conexion::conectar();
		$sql = "UPDATE montrer_settings SET status = 1 WHERE idUser = :idUser ";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idUser', $idUsers, PDO::PARAM_INT);
		if ($stmt->execute()) {
			$result = "ok";
		} else {
			print_r($pdo->errorInfo());
		}
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlDisableArea($idArea)
	{
		$pdo = Conexion::conectar();
		$sql = "UPDATE montrer_area SET status = 0 WHERE idArea = :idArea ";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idArea', $idArea, PDO::PARAM_INT);
		if ($stmt->execute()) {
			$result = "ok";
		} else {
			print_r($pdo->errorInfo());
		}
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlEnableArea($idArea)
	{
		$pdo = Conexion::conectar();
		$sql = "UPDATE montrer_area SET status = 1 WHERE idArea = :idArea ";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idArea', $idArea, PDO::PARAM_INT);
		if ($stmt->execute()) {
			$result = "ok";
		} else {
			print_r($pdo->errorInfo());
		}
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlUpdateArea($data)
	{
		$pdo = Conexion::conectar();
		$sql = "UPDATE montrer_area SET nameArea = :nameArea, description = :description, areaCode = :areaCode WHERE idArea = :idArea ";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':nameArea', $data['nameArea'], PDO::PARAM_STR);
		$stmt->bindParam(':description', $data['description'], PDO::PARAM_STR);
		$stmt->bindParam(':idArea', $data['idArea'], PDO::PARAM_INT);
		$stmt->bindParam(':areaCode', $data['areaCode'], PDO::PARAM_STR);
		if ($stmt->execute()) {
			$result = "ok";
		} else {
			print_r($pdo->errorInfo());
		}
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlUpdateUsersArea($data)
	{
		try {
			$pdo = Conexion::conectar();

			// Construir el SQL dinámico para eliminar e insertar en un solo paso
			$values = [];
			foreach ($data['users'] as $idUser) {
				$values[] = "({$data['idArea']}, {$idUser})";
			}
			$valuesSQL = implode(", ", $values);

			$sql = "
				DELETE FROM montrer_users_to_areas WHERE idArea = :idArea;
				INSERT INTO montrer_users_to_areas (idArea, idUser) VALUES $valuesSQL;
			";

			$stmt = $pdo->prepare($sql);

			// Vincula los parámetros
			$stmt->bindParam(":idArea", $data['idArea'], PDO::PARAM_INT);

			// Ejecuta el SQL
			if ($stmt->execute()) {
				$result = "ok";
			} else {
				$result = "error: No se pudo actualizar el área.";
			}
		} catch (Exception $e) {
			$result = "error: " . $e->getMessage();
		} finally {
			$stmt = null;
			$pdo = null;
			return $result;
		}
	}

	static public function mdlUpdateExercise($data)
	{
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

		if ($stmt->execute()) {
			$result = "ok";
		} else {
			print_r($pdo->errorInfo());
		}
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlDisableExercise($idExercise)
	{
		$pdo = Conexion::conectar();
		$sql = "UPDATE montrer_exercise
				SET active = 0
				WHERE idExercise = :idExercise";

		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idExercise', $idExercise, PDO::PARAM_INT);

		if ($stmt->execute()) {
			$result = "ok";
		} else {
			print_r($pdo->errorInfo());
		}
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlEnableExercise($idExercise)
	{
		$pdo = Conexion::conectar();
		$sql = "UPDATE montrer_exercise
				SET active = 1
				WHERE idExercise = :idExercise";

		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idExercise', $idExercise, PDO::PARAM_INT);

		if ($stmt->execute()) {
			$result = "ok";
		} else {
			print_r($pdo->errorInfo());
		}
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlDeleteExercise($idExercise)
	{
		$pdo = Conexion::conectar();

		try {
			// Start a transaction
			$pdo->beginTransaction();

			// First, delete related records in montrer_budget_requests
			$sqlDeleteRequests = "DELETE FROM montrer_budget_requests WHERE idBudget IN (SELECT idBudget FROM montrer_budgets WHERE idExercise = :idExercise)";
			$stmtDeleteRequests = $pdo->prepare($sqlDeleteRequests);
			$stmtDeleteRequests->bindParam(':idExercise', $idExercise, PDO::PARAM_INT);
			$stmtDeleteRequests->execute();

			// Then, delete related records in montrer_budgets
			$sqlDeleteBudgets = "DELETE FROM montrer_budgets WHERE idExercise = :idExercise";
			$stmtDeleteBudgets = $pdo->prepare($sqlDeleteBudgets);
			$stmtDeleteBudgets->bindParam(':idExercise', $idExercise, PDO::PARAM_INT);
			$stmtDeleteBudgets->execute();

			// Finally, delete the exercise
			$sqlDeleteExercise = "DELETE FROM montrer_exercise WHERE idExercise = :idExercise";
			$stmtDeleteExercise = $pdo->prepare($sqlDeleteExercise);
			$stmtDeleteExercise->bindParam(':idExercise', $idExercise, PDO::PARAM_INT);
			$stmtDeleteExercise->execute();

			// Commit the transaction
			$pdo->commit();

			$result = "ok";
		} catch (PDOException $e) {
			// Rollback the transaction if an error occurred
			$pdo->rollBack();
			$result = "Error: " . $e->getMessage();
		} finally {
			// Close the connection
			$pdo = null;
			return $result;
		}
	}

	static public function mdlDeleteUser($idUsers)
	{
		$pdo = Conexion::conectar();
		$sql = "UPDATE montrer_users SET deleted = 1
				WHERE idUsers = :idUsers";

		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idUsers', $idUsers, PDO::PARAM_INT);

		if ($stmt->execute()) {
			$result = "ok";
		} else {
			print_r($pdo->errorInfo());
		}
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlSelectAreaUser($idUsers)
	{
		$pdo = Conexion::conectar();
		$sql = "SELECT * FROM montrer_area WHERE idUser = :idUser AND active = 1";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idUser', $idUsers, PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetchAll();
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlNullAreaUser($idArea)
	{
		$pdo = Conexion::conectar();
		$sql = "UPDATE montrer_area SET idUser = null WHERE idArea = :idArea ";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idArea', $idArea, PDO::PARAM_INT);
		if ($stmt->execute()) {
			$result = "ok";
		} else {
			print_r($pdo->errorInfo());
		}
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlDeleteArea($idArea)
	{
		$pdo = Conexion::conectar();
		$sql = "UPDATE montrer_area SET active = 0 WHERE idArea = :idArea ";

		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idArea', $idArea, PDO::PARAM_INT);

		if ($stmt->execute()) {
			$result = "ok";
		} else {
			print_r($pdo->errorInfo());
		}
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlDeleteBudget($idBudget)
	{
		$pdo = Conexion::conectar();
		$sql = "DELETE FROM montrer_budgets
				WHERE idBudget = :idBudget";

		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idBudget', $idBudget, PDO::PARAM_INT);

		if ($stmt->execute()) {
			$result = "ok";
		} else {
			print_r($pdo->errorInfo());
		}
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlEnableBudget($idBudget)
	{
		$pdo = Conexion::conectar();
		$sql = "UPDATE montrer_budgets
				SET status = 1
				WHERE idBudget = :idBudget";

		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idBudget', $idBudget, PDO::PARAM_INT);

		if ($stmt->execute()) {
			$result = "ok";
		} else {
			print_r($pdo->errorInfo());
		}
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlDisableBudget($idBudget)
	{
		$pdo = Conexion::conectar();
		$sql = "UPDATE montrer_budgets
				SET status = 0
				WHERE idBudget = :idBudget";

		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idBudget', $idBudget, PDO::PARAM_INT);

		if ($stmt->execute()) {
			$result = "ok";
		} else {
			print_r($pdo->errorInfo());
		}
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlUpdateBudget($data)
	{
		$pdo = Conexion::conectar();
		$sql = "UPDATE montrer_budgets
				SET AuthorizedAmount = :AuthorizedAmount, idArea = :idArea, idExercise = :idExercise
				WHERE idBudget = :idBudget";

		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':AuthorizedAmount', $data['AuthorizedAmount'], PDO::PARAM_INT);
		$stmt->bindParam(':idArea', $data['idArea'], PDO::PARAM_INT);
		$stmt->bindParam(':idExercise', $data['idExercise'], PDO::PARAM_INT);
		$stmt->bindParam(':idBudget', $data['idBudget'], PDO::PARAM_INT);

		if ($stmt->execute()) {
			$result = "ok";
		} else {
			print_r($pdo->errorInfo());
		}
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlGetProviders($provider_idUser)
	{
		$pdo = Conexion::conectar();
		if ($provider_idUser != null) {
			$sql = "SELECT * FROM montrer_providers WHERE provider_idUser = :provider_idUser";
			$stmt = $pdo->prepare($sql);
			$stmt->bindParam(':provider_idUser', $provider_idUser, PDO::PARAM_INT);
		} else {
			$pdo = Conexion::conectar();
			$sql = "SELECT * FROM montrer_providers";
			$stmt = $pdo->prepare($sql);
		}
		$stmt->execute();
		$result = $stmt->fetchAll();
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlGetProviderON()
	{
		$pdo = Conexion::conectar();
		$sql = "SELECT idProvider, CONCAT(representative_name,'(',provider_key,')') FROM montrer_providers WHERE status = 1;";
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetchAll();
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlRegisterProvider($data)
	{
		$pdo = Conexion::conectar();
		$sql = "INSERT INTO montrer_providers 
		(provider_key, representative_name, contact_phone, email, website, business_name, rfc, 
		fiscal_address_street, fiscal_address_colonia, fiscal_address_municipio, fiscal_address_estado, 
		fiscal_address_cp, bank_name, account_holder, account_number, clabe, description, created_at, updated_at, provider_idUser,
		extrangero, swiftCode, beneficiaryAddress, currencyType) 
		VALUES 
		(:providerKey, :representativeName, :contactPhone, :email, :website, :businessName, :rfc, 
		:fiscalAddressStreet, :fiscalAddressColonia, :fiscalAddressMunicipio, :fiscalAddressEstado, 
		:fiscalAddressCP, :bankName, :accountHolder, :accountNumber, :clabe, :description, NOW(), NOW(), :idUser,
		:extrangero, :swiftCode, :beneficiaryAddress, :currencyType)";

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
		$stmt->bindParam(':description', $data['description'], PDO::PARAM_STR);
		$stmt->bindParam(':idUser', $data['idUser'], PDO::PARAM_INT);
		$stmt->bindParam(':extrangero', $data['extrangero'], PDO::PARAM_INT);
		$stmt->bindParam(':swiftCode', $data['swiftCode'], PDO::PARAM_STR);
		$stmt->bindParam(':beneficiaryAddress', $data['beneficiaryAddress'], PDO::PARAM_STR);
		$stmt->bindParam(':currencyType', $data['currencyType'], PDO::PARAM_STR);

		if ($stmt->execute()) {
			$result = $pdo->lastInsertId();
		} else {
			$result = 'Error';
			print_r($pdo->errorInfo());
		}
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlUpdateProvider($data)
	{
		$pdo = Conexion::conectar();
		$sql = "UPDATE montrer_providers SET 
					representative_name = :representativeName,
					contact_phone = :contactPhone,
					email = :email,
					website = :website,
					business_name = :businessName,
					rfc = :rfc,
					fiscal_address_street = :fiscalAddressStreet,
					fiscal_address_colonia = :fiscalAddressColonia,
					fiscal_address_municipio = :fiscalAddressMunicipio,
					fiscal_address_estado = :fiscalAddressEstado,
					fiscal_address_cp = :fiscalAddressCP,
					bank_name = :bankName,
					account_holder = :accountHolder,
					account_number = :accountNumber,
					clabe = :clabe,
					swiftCode = :swiftCode,
					beneficiaryAddress = :beneficiaryAddress,
					currencyType = :currencyType
				WHERE provider_key = :providerKey";

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
		$stmt->bindParam(':swiftCode', $data['swiftCode'], PDO::PARAM_STR);
		$stmt->bindParam(':beneficiaryAddress', $data['beneficiaryAddress'], PDO::PARAM_STR);
		$stmt->bindParam(':currencyType', $data['currencyType'], PDO::PARAM_STR);

		if ($stmt->execute()) {
			$result = 'ok';
		} else {
			$result = 'Error';
			print_r($pdo->errorInfo());
		}
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlNextIdProvider()
	{
		$pdo = Conexion::conectar();
		$sql = "SELECT LPAD(IFNULL(MAX(idProvider), 0) + 1, 3, '0') AS nextIdProvider FROM montrer_providers;";
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetch();
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlDisableProvider($idProvider)
	{
		$pdo = Conexion::conectar();
		$sql = "UPDATE montrer_providers
				SET status = 0
				WHERE idProvider = :idProvider";

		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idProvider', $idProvider, PDO::PARAM_INT);

		if ($stmt->execute()) {
			$result = "ok";
		} else {
			print_r($pdo->errorInfo());
		}
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlEnableProvider($idProvider)
	{
		$pdo = Conexion::conectar();
		$sql = "UPDATE montrer_providers
				SET status = 1
				WHERE idProvider = :idProvider";

		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idProvider', $idProvider, PDO::PARAM_INT);

		if ($stmt->execute()) {
			$result = "ok";
		} else {
			print_r($pdo->errorInfo());
		}
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlDeleteProvider($idProvider)
	{
		$pdo = Conexion::conectar();
		$sql = "DELETE FROM montrer_providers
				WHERE idProvider = :idProvider";

		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idProvider', $idProvider, PDO::PARAM_INT);

		if ($stmt->execute()) {
			$result = "ok";
		} else {
			print_r($pdo->errorInfo());
		}
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlGetProvider($idProvider)
	{
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

	static public function mdlGetProviderByName($rfc, $idUser)
	{
		$pdo = Conexion::conectar();
		$sql = "SELECT * FROM montrer_providers WHERE rfc = :rfc AND provider_idUser = :idUser";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':rfc', $rfc, PDO::PARAM_STR);
		$stmt->bindParam(':idUser', $idUser, PDO::PARAM_STR);
		$stmt->execute();
		$result = $stmt->fetch();
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlGetAreaManager($idUser)
	{
		$pdo = Conexion::conectar();
		$sql = "SELECT DISTINCT 
					a.idArea, 
					a.nameArea, 
					b.AuthorizedAmount 
				FROM 
					montrer_exercise e
				LEFT JOIN 
					montrer_budgets b ON b.idExercise = e.idExercise
				LEFT JOIN 
					montrer_area a ON a.idArea = b.idArea
				LEFT JOIN 
					montrer_users_to_areas ua ON a.idArea = ua.idArea
				WHERE 
					b.status = 1 
					AND e.status = 1 
					AND ua.idUser = :idUser;				";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetchAll();
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlGetAuthorizedAmount($idArea)
	{
		$pdo = Conexion::conectar();
		$sql = "SELECT b.idBudget, a.idArea, m.month, m.budget_month, m.budget_used, m.total_used, m.idMensualBudget FROM montrer_budgets b
					RIGHT JOIN montrer_month_budget m ON m.idBudget = b.idBudget
					RIGHT JOIN montrer_area a ON a.idArea = b.idArea
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

	static public function mdlGetAmountPendient($idArea)
	{
		$pdo = Conexion::conectar();
		$sql = "SELECT r.importe_solicitado AS requestedAmount, r.idRequest FROM montrer_budget_requests r
					LEFT JOIN montrer_budgets b ON b.idArea = r.idArea
					LEFT JOIN montrer_exercise e ON e.idExercise = b.idExercise
				WHERE e.status = 1 AND r.status = 0 AND r.idArea = :idArea order by r.idRequest DESC;";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idArea', $idArea, PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetchAll();
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlGetRequests($idUser, $selection)
	{
		$pdo = Conexion::conectar();
		if ($selection == 1) {
			$sql = "SELECT a.idArea, r.idRequest, r.idBudget, r.importe_solicitado AS requestedAmount, r.approvedAmount,
							r.concepto_pago, r.requestDate, r.responseDate, r.status, r.folio, r.paymentDate, r.complete,
							a.nameArea, u.idUsers, u.firstname, u.lastname, r.pagado, e.exerciseName, e.idExercise
						FROM montrer_budget_requests r
							LEFT JOIN montrer_area a ON a.idArea = r.idArea
							LEFT JOIN montrer_users u ON u.idUsers = r.idUser
							LEFT JOIN montrer_budgets b ON b.idBudget = r.idBudget
							LEFT JOIN montrer_exercise e ON e.idExercise = b.idExercise
						WHERE a.status = 1 AND u.deleted = 0;";
			$stmt = $pdo->prepare($sql);
		} else {
			$sql = "SELECT a.idArea, r.idRequest, r.idBudget, r.importe_solicitado AS requestedAmount, r.approvedAmount,
							r.concepto_pago, r.requestDate, r.responseDate, r.status, r.folio, r.paymentDate, r.complete,
							a.nameArea, u.idUsers, u.firstname, u.lastname, r.pagado, e.exerciseName, e.idExercise
						FROM montrer_budget_requests r
							LEFT JOIN montrer_area a ON a.idArea = r.idArea
                            LEFT JOIN montrer_users_to_areas ua ON a.idArea = ua.idArea
							LEFT JOIN montrer_users u ON u.idUsers = ua.idUser
							LEFT JOIN montrer_budgets b ON b.idBudget = r.idBudget
							LEFT JOIN montrer_exercise e ON e.idExercise = b.idExercise
						WHERE a.status = 1 AND u.idUsers = :idUser AND u.deleted = 0;";
			$stmt = $pdo->prepare($sql);
			$stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
		}
		$stmt->execute();
		$result = $stmt->fetchAll();
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlRequestBudget($data)
	{
		$pdo = Conexion::conectar();

		// Calcula la fecha de pago (paymentDate) según la fecha de creación de la solicitud (requestDate)
		$requestDate = new DateTime(); // Suponiendo que requestDate sea la fecha actual
		$currentDay = $requestDate->format('N'); // Obtiene el día de la semana (1: lunes, 2: martes, ..., 7: domingo)
		$hour = $requestDate->format('H:i'); // Obtiene la hora de la solicitud

		// Si el día de la solicitud es lunes (1), martes (2) o miércoles (3) antes de las 16:00 (4:00 PM)
		if ($currentDay <= 3 && $hour < '16:00') {
			// Establece el día de pago (paymentDate) al viernes de la misma semana
			$paymentDate = $requestDate->modify('next friday');
		} else {
			// Establece el día de pago (paymentDate) al viernes de la siguiente semana
			$paymentDate = $requestDate->modify('next friday');
		}

		// Agrega la fecha de pago calculada a los datos
		$data['paymentDate'] = $paymentDate->format('Y-m-d');

		// Consulta SQL para insertar los datos en la tabla montrer_budget_requests
		$sql = "INSERT INTO montrer_budget_requests (
					solicitante_nombre,
					empresa,
					concepto,
					importe_solicitado,
					importe_letra,
					fecha_pago,
					clabe,
					banco,
					numero_cuenta,
					concepto_pago,
					cuentaAfectada,
					partidaAfectada,
					idUser,
					idArea,
					idBudget,
					idProvider,
					idEmployer,
					idAreaCargo,
					idCuentaAfectada,
					idPartidaAfectada,
					idConcepto,
					swift_code,
					beneficiario_direccion,
					tipo_divisa,
					folio,
					paymentDate
				) VALUES (
					:solicitante_nombre,
					:empresa,
					:concepto,
					:importe_solicitado,
					:importe_letra,
					:fecha_pago,
					:clabe,
					:banco,
					:numero_cuenta,
					:concepto_pago,
					:cuentaAfectada,
					:partidaAfectada,
					:idUser,
					:idArea,
					:idBudget,
					:idProvider,
					:idEmployer,
					:idAreaCargo,
					:idCuentaAfectada,
					:idPartidaAfectada,
					:idConcepto,
					:swift_code,
					:beneficiario_direccion,
					:tipo_divisa,
					:folio,
					:paymentDate
				)";

		$stmt = $pdo->prepare($sql);

		// Ejecutar la consulta
		if ($stmt->execute($data)) {
			$result = $pdo->lastInsertId();
		} else {
			$result = 'Error: ' . implode(" - ", $stmt->errorInfo());
		}

		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlDeleteRequest($idRequest)
	{
		$pdo = Conexion::conectar();
		$sql = "DELETE FROM montrer_budget_requests
				WHERE idRequest = :idRequest";

		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idRequest', $idRequest, PDO::PARAM_INT);

		if ($stmt->execute()) {
			$result = "ok";
		} else {
			print_r($pdo->errorInfo());
		}
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlGetRequest($idRequest)
	{
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

	static public function mdlDenegateRequest($idRequest, $idAdmin, $comentRechazo)
	{
		$pdo = Conexion::conectar();
		$sql = "UPDATE montrer_budget_requests SET idAdmin = :idAdmin, responseDate = DATE_ADD(NOW(), INTERVAL -6 HOUR), status = 3, comentarios = :comentRechazo where idRequest = :idRequest";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':comentRechazo', $comentRechazo, PDO::PARAM_STR);
		$stmt->bindParam(':idAdmin', $idAdmin, PDO::PARAM_INT);
		$stmt->bindParam(':idRequest', $idRequest, PDO::PARAM_INT);
		if ($stmt->execute()) {
			$result = 'ok';
		} else {
			print_r($pdo->errorInfo());
			$result = 'Error';
		}
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlEnableRequest($idRequest, $idAdmin, $approvedAmount)
	{
		$pdo = Conexion::conectar();
		$sql = "UPDATE montrer_budget_requests SET idAdmin = :idAdmin, responseDate = DATE_ADD(NOW(), INTERVAL -6 HOUR), status = 1, active = 1, approvedAmount = :approvedAmount where idRequest = :idRequest";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idAdmin', $idAdmin, PDO::PARAM_INT);
		$stmt->bindParam(':approvedAmount', $approvedAmount, PDO::PARAM_STR);
		$stmt->bindParam(':idRequest', $idRequest, PDO::PARAM_INT);
		if ($stmt->execute()) {
			$result = 'ok';
		} else {
			print_r($pdo->errorInfo());
			$result = 'Error';
		}
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlGetMonthBudget($idBudget)
	{
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

	static public function mdlFillBudgetMouth($idMensualBudget, $budget_used)
	{
		$pdo = Conexion::conectar();
		$sql = "UPDATE montrer_month_budget SET budget_used=:budget_used WHERE idMensualBudget = :idMensualBudget";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':budget_used', $budget_used, PDO::PARAM_STR);
		$stmt->bindParam(':idMensualBudget', $idMensualBudget, PDO::PARAM_INT);
		if ($stmt->execute()) {
			$result = 'ok';
		} else {
			print_r($pdo->errorInfo());
			$result = 'Error';
		}
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlGetRequestComprobar($idRequest)
	{
		$pdo = Conexion::conectar();
		$sql = "SELECT 
					br.idRequest,
					br.importe_solicitado AS requestedAmount,
					br.concepto_pago,
					br.approvedAmount,
					br.responseDate,
					br.requestDate,
					br.importe_letra,
					a.nameArea,
					p.business_name,
					br.idProvider,
                    p.representative_name,
                    p.bank_name,
					br.comentarios
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

	static public function mdlSendComprobation($data)
	{
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
		if ($stmt->execute()) {
			$result = $pdo->lastInsertId();
		} else {
			print_r($pdo->errorInfo());
			$result = 'Error';
		}
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}
	static public function mdlGetComprobante($idRequest)
	{
		$pdo = Conexion::conectar();
		$sql = "SELECT r.*, a.nameArea, p.business_name 
				FROM montrer_budget_requests r
					LEFT JOIN montrer_area a ON a.idArea = r.idArea
					LEFT JOIN montrer_providers p ON p.idProvider = r.idProvider
				WHERE r.idRequest = :idRequest
				ORDER BY r.idRequest DESC;";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idRequest', $idRequest, PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetch();
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlResponceRequest($idRequest, $responce, $comentario)
	{
		$active = ($responce == 5) ? ",active = 0" : "";
		$pdo = Conexion::conectar();
		$sql = "UPDATE montrer_budget_requests SET status = :status, comentarios = :comentario $active where idRequest = :idRequest";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idRequest', $idRequest, PDO::PARAM_INT);
		$stmt->bindParam(':status', $responce, PDO::PARAM_INT);
		$stmt->bindParam(':comentario', $comentario, PDO::PARAM_STR);
		if ($stmt->execute()) {
			$result = 'ok';
		} else {
			print_r($pdo->errorInfo());
			$result = 'Error';
		}
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlCommentsRequest($idRequest)
	{
		$pdo = Conexion::conectar();
		$sql = "SELECT comentarios
				FROM montrer_budget_requests
				WHERE idRequest = :idRequest";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idRequest', $idRequest, PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetch();
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlVerificacionArea($idUser)
	{
		$pdo = Conexion::conectar();
		$sql = "SELECT *
				FROM montrer_area a
                LEFT JOIN montrer_users_to_areas ua ON ua.idArea = a.idArea
				WHERE ua.idUser = :idUser";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetch();
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlVerificacionDeudas($idUser)
	{
		$pdo = Conexion::conectar();
		$sql = "SELECT *
				FROM montrer_budget_requests
				WHERE idUser = :idUser and active = 1";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetchAll();
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlGetLogs($idUser)
	{
		$pdo = Conexion::conectar();
		$sql = "SELECT l.*, u.firstname, u.lastname FROM montrer_logs l
				LEFT JOIN montrer_users u ON u.idUsers = l.idUser
				WHERE idUser = :idUser";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetchAll();
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlMarcarPago($idRequest, $idAdmin)
	{
		$pdo = Conexion::conectar();
		$sql = "UPDATE montrer_budget_requests SET idAdmin = :idAdmin, responseDate = DATE_ADD(NOW(), INTERVAL -6 HOUR), pagado = 1 where idRequest = :idRequest";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idAdmin', $idAdmin, PDO::PARAM_INT);
		$stmt->bindParam(':idRequest', $idRequest, PDO::PARAM_INT);
		if ($stmt->execute()) {
			$result = 'ok';
		} else {
			print_r($pdo->errorInfo());
			$result = 'Error';
		}
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlSearchRequest($idRequest)
	{
		$pdo = Conexion::conectar();
		$sql = "SELECT *
                FROM montrer_budget_requests
                WHERE idRequest = :idRequest";

		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idRequest', $idRequest, PDO::PARAM_INT);
		if ($stmt->execute()) {
			$result = $stmt->fetch();
		} else {
			print_r($pdo->errorInfo());
			$result = 'Error';
		}
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlUpdateRequest($datos)
	{
		$pdo = Conexion::conectar();

		$sql = "UPDATE montrer_budget_requests SET idProvider = :idProvider, requestedAmount = :requestedAmount, description = :description, eventDate = :eventDate where idRequest = :idRequest";

		$stmt = $pdo->prepare($sql);

		$stmt->bindParam(':idProvider', $datos['provider'], PDO::PARAM_INT);
		$stmt->bindParam(':requestedAmount', $datos['requestedAmount'], PDO::PARAM_STR);
		$stmt->bindParam(':description', $datos['description'], PDO::PARAM_STR);
		$stmt->bindParam(':eventDate', $datos['eventDate'], PDO::PARAM_STR);
		$stmt->bindParam(':idRequest', $datos['idRequest'], PDO::PARAM_INT);

		if ($stmt->execute()) {
			$result = 'ok';
		} else {
			print_r($pdo->errorInfo());
			$result = 'Error';
		}
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlMaxRequestBudgets()
	{
		$pdo = Conexion::conectar();
		$sql = "SELECT MAX(idRequest) as maxRequest FROM montrer_budget_requests";
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		$result = $stmt->fetch();
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlGetAreaBycheckup($item, $value)
	{
		$pdo = Conexion::conectar();
		$sql = "SELECT *
                FROM montrer_budget_requests
                WHERE $item = :$item AND active = 1";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(":$item", $value, PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetchAll();
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlGetAreaByUser($idUser)
	{
		$pdo = Conexion::conectar();
		$sql = "SELECT *
                FROM montrer_users_to_areas ua
				LEFT JOIN montrer_area a ON a.idArea = ua.idArea
                WHERE ua.idUser = :idUser AND a.active = 1";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
		$stmt->execute();
		$result = $stmt->fetchAll();
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static function mdlChangePaymentDate($idRequest, $paymentDate)
	{
		$pdo = Conexion::conectar();
		$sql = "UPDATE montrer_budget_requests SET paymentDate = :paymentDate WHERE idRequest = :idRequest";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idRequest', $idRequest, PDO::PARAM_INT);
		$stmt->bindParam(':paymentDate', $paymentDate, PDO::PARAM_STR);

		if ($stmt->execute()) {
			$result = 'ok';
		} else {
			print_r($pdo->errorInfo());
			$result = 'Error';
		}
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlCompleteRequest($data)
	{
		try {
			$pdo = Conexion::conectar();

			$stmt = $pdo->prepare("UPDATE montrer_budget_requests 
				SET 
					idEmployer = :idEmployer,
					empresa = :empresa,
					idAreaCargo = :idAreaCargo,
					cuentaAfectada = :cuentaAfectada,
					idCuentaAfectada = :idCuentaAfectada,
					partidaAfectada = :partidaAfectada,
					idPartidaAfectada = :idPartidaAfectada,
					concepto = :concepto,
					idConcepto = :idConcepto,
					importe_solicitado = :requestedAmount,
					importe_letra = :importeLetra,
					fecha_pago = :fechaPago,
					idProvider = :provider,
					clabe = :clabe,
					banco = :bank_name,
					numero_cuenta = :account_number,
					swift_code = :swiftCode,
					beneficiario_direccion = :beneficiaryAddress,
					tipo_divisa = :currencyType,
					concepto_pago = :conceptoPago,
					cuentaAfectadaCount = :cuentaAfectadaCount, -- Añadido
					partidaAfectadaCount = :partidaAfectadaCount, -- Añadido
					polizeType = :polizeType, -- Añadido
					numberPolize = :numberPolize, -- Añadido
					cargo = :cargo, -- Añadido
					abono = :abono, -- Añadido
					complete = 1
				WHERE idRequest = :idRequest");


			$stmt->bindParam(":idEmployer", $data['idEmployer'], PDO::PARAM_STR);
			$stmt->bindParam(":empresa", $data['empresa'], PDO::PARAM_STR);
			$stmt->bindParam(":idAreaCargo", $data['idAreaCargo'], PDO::PARAM_STR);
			$stmt->bindParam(":cuentaAfectada", $data['cuentaAfectada'], PDO::PARAM_STR);
			$stmt->bindParam(":idCuentaAfectada", $data['idCuentaAfectada'], PDO::PARAM_STR);
			$stmt->bindParam(":partidaAfectada", $data['partidaAfectada'], PDO::PARAM_STR);
			$stmt->bindParam(":idPartidaAfectada", $data['idPartidaAfectada'], PDO::PARAM_STR);
			$stmt->bindParam(":concepto", $data['concepto'], PDO::PARAM_STR);
			$stmt->bindParam(":idConcepto", $data['idConcepto'], PDO::PARAM_STR);
			$stmt->bindParam(":requestedAmount", $data['requestedAmount'], PDO::PARAM_STR);
			$stmt->bindParam(":importeLetra", $data['importeLetra'], PDO::PARAM_STR);
			$stmt->bindParam(":fechaPago", $data['fechaPago'], PDO::PARAM_STR);
			$stmt->bindParam(":provider", $data['provider'], PDO::PARAM_STR);
			$stmt->bindParam(":clabe", $data['clabe'], PDO::PARAM_STR);
			$stmt->bindParam(":bank_name", $data['bank_name'], PDO::PARAM_STR);
			$stmt->bindParam(":account_number", $data['account_number'], PDO::PARAM_STR);
			$stmt->bindParam(":swiftCode", $data['swiftCode'], PDO::PARAM_STR);
			$stmt->bindParam(":beneficiaryAddress", $data['beneficiaryAddress'], PDO::PARAM_STR);
			$stmt->bindParam(":currencyType", $data['currencyType'], PDO::PARAM_STR);
			$stmt->bindParam(":conceptoPago", $data['conceptoPago'], PDO::PARAM_STR);
			$stmt->bindParam(":idRequest", $data['idRequest'], PDO::PARAM_INT);
			$stmt->bindParam(":cuentaAfectadaCount", $data['cuentaAfectadaCount'], PDO::PARAM_STR);
			$stmt->bindParam(":partidaAfectadaCount", $data['partidaAfectadaCount'], PDO::PARAM_STR);
			$stmt->bindParam(":polizeType", $data['polizeType'], PDO::PARAM_STR);
			$stmt->bindParam(":numberPolize", $data['numberPolize'], PDO::PARAM_STR);
			$stmt->bindParam(":cargo", $data['cargo'], PDO::PARAM_STR);
			$stmt->bindParam(":abono", $data['abono'], PDO::PARAM_STR);

			if ($stmt->execute()) {
				$result = "success";
			} else {
				$result = "error";
			}
		} catch (PDOException $e) {
			$result = "error: " . $e->getMessage();
		}
		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlGetReports($startDate, $endDate, $context = null)
	{
		$pdo = Conexion::conectar();
		// Construir consulta básica
		$sql = "SELECT 
				br.*, 
				u.firstname, 
				u.lastname, 
				p.account_holder, 
				br.status AS statusBudgetRequest, 
				br.pagado AS pagado,
				CASE 
					WHEN br.pagado = 0 THEN 'Pendiente de Pago'
					WHEN br.pagado = 1 THEN 'Pagado'
					ELSE 'Rechazado'
				END AS estadoPago
				FROM montrer_budget_requests br
				LEFT JOIN montrer_users u ON br.idUser = u.idUsers
				LEFT JOIN montrer_providers p ON br.idProvider = p.idProvider
                LEFT JOIN montrer_area a ON a.idArea = br.idArea
				WHERE br.requestDate BETWEEN :startDate AND :endDate";

		// Agregar condición para el contexto si está definido
		if (!empty($context)) {
			$sql .= " AND (
					br.folio LIKE :context OR 
					CONCAT(u.firstname, ' ', u.lastname) LIKE :context OR 
					p.account_holder LIKE :context OR 
					br.concepto_pago LIKE :context OR 
					br.cargo LIKE :context OR 
					br.abono LIKE :context OR 
					br.requestDate LIKE :context OR 
					br.fecha_pago LIKE :context OR 
					br.paymentDate LIKE :context OR 
					br.banco LIKE :context OR 
					br.clabe LIKE :context OR 
					br.cuentaAfectada LIKE :context OR 
					br.partidaAfectada LIKE :context OR
					a.nameArea LIKE :context OR
					CASE 
						WHEN br.pagado = 0 THEN 'Pendiente de Pago'
						WHEN br.pagado = 1 THEN 'Pagado'
						ELSE 'Rechazado'
					END LIKE :context
				)";
		}


		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':startDate', $startDate, PDO::PARAM_STR);
		$stmt->bindParam(':endDate', $endDate, PDO::PARAM_STR);

		// Si hay contexto, bindear el parámetro con comodines
		if (!empty($context)) {
			$likeContext = "%$context%";
			$stmt->bindParam(':context', $likeContext, PDO::PARAM_STR);
		}

		$stmt->execute();
		$result = $stmt->fetchAll();

		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlIdPaymentRequest($idRequest)
	{
		$pdo = Conexion::conectar();
		$sql = "SELECT idPaymentRequest FROM montrer_payment_requests WHERE idRequest = :idRequest order by idPaymentRequest DESC LIMIT 1";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idRequest', $idRequest, PDO::PARAM_INT);
		$stmt->execute();

		$result = $stmt->fetch();

		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlCreateAccount($cuenta, $numeroCuenta, $idArea)
	{
		$pdo = Conexion::conectar();
		$sql = "INSERT INTO montrer_cuentas (cuenta, numeroCuenta, idArea) VALUES (:cuenta, :numeroCuenta, :idArea)";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':cuenta', $cuenta, PDO::PARAM_STR);
		$stmt->bindParam(':numeroCuenta', $numeroCuenta, PDO::PARAM_STR);
		$stmt->bindParam(':idArea', $idArea, PDO::PARAM_INT);

		if ($stmt->execute()) {
			$result = "ok";
		} else {
			$result = "error";
		}

		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlCreatePartida($partida, $numeroPartida, $idCuenta)
	{
		$pdo = Conexion::conectar();
		$sql = "INSERT INTO montrer_partidas (partida, numeroPartida, idCuenta) VALUES (:partida, :numeroPartida, :idCuenta)";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':partida', $partida, PDO::PARAM_STR);
		$stmt->bindParam(':numeroPartida', $numeroPartida, PDO::PARAM_STR);
		$stmt->bindParam(':idCuenta', $idCuenta, PDO::PARAM_INT);

		if ($stmt->execute()) {
			$result = "ok";
		} else {
			$result = "error";
		}

		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlGetAccounts()
	{
		$pdo = Conexion::conectar();
		$sql = "SELECT * FROM montrer_cuentas c LEFT JOIN montrer_area a ON c.idArea = a.idArea where c.status = 1";
		$stmt = $pdo->prepare($sql);
		$stmt->execute();

		$result = $stmt->fetchAll();

		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlGetPartidas($idPartida)
	{
		$pdo = Conexion::conectar();
		$sql = "SELECT * FROM montrer_partidas p 
					LEFT JOIN montrer_cuentas c ON c.idCuenta = p.idCuenta 
					LEFT JOIN montrer_area a ON c.idArea = a.idArea 
				where p.status = 1";
		if ($idPartida != null) {
			$sql .= " AND p.idPartida = :idPartida";
			$stmt = $pdo->prepare($sql);
			$stmt->bindParam(':idPartida', $idPartida, PDO::PARAM_INT);
			$stmt->execute();
			$result = $stmt->fetch();
		} else {
			$stmt = $pdo->prepare($sql);
			$stmt->execute();
			$result = $stmt->fetchAll();
		}

		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlDeleteAccount($idCuenta)
	{
		$pdo = Conexion::conectar();
		$sql = "UPDATE montrer_cuentas SET status = 0 WHERE idCuenta = :idCuenta";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idCuenta', $idCuenta, PDO::PARAM_INT);

		if ($stmt->execute()) {
			$result = "ok";
		} else {
			$result = "error";
		}

		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlDeletePartida($idPartida)
	{
		$pdo = Conexion::conectar();
		$sql = "UPDATE montrer_partidas SET status = 0 WHERE idPartida = :idPartida";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idPartida', $idPartida, PDO::PARAM_INT);

		if ($stmt->execute()) {
			$result = "ok";
		} else {
			$result = "error";
		}

		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlEditAccount($idCuenta, $cuenta, $numeroCuenta, $idArea)
	{
		$pdo = Conexion::conectar();
		$sql = "UPDATE montrer_cuentas SET cuenta = :cuenta, numeroCuenta = :numeroCuenta, idArea = :idArea WHERE idCuenta = :idCuenta";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idCuenta', $idCuenta, PDO::PARAM_INT);
		$stmt->bindParam(':cuenta', $cuenta, PDO::PARAM_STR);
		$stmt->bindParam(':numeroCuenta', $numeroCuenta, PDO::PARAM_STR);
		$stmt->bindParam(':idArea', $idArea, PDO::PARAM_INT);

		if ($stmt->execute()) {
			$result = "ok";
		} else {
			$result = "error";
		}

		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlEditPartida($idPartida, $partida, $numeroPartida, $idCuenta)
	{
		$pdo = Conexion::conectar();
		$sql = "UPDATE montrer_partidas SET partida = :partida, numeroPartida = :numeroPartida, idCuenta = :idCuenta WHERE idPartida = :idPartida";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idPartida', $idPartida, PDO::PARAM_INT);
		$stmt->bindParam(':partida', $partida, PDO::PARAM_STR);
		$stmt->bindParam(':numeroPartida', $numeroPartida, PDO::PARAM_STR);
		$stmt->bindParam(':idCuenta', $idCuenta, PDO::PARAM_INT);

		if ($stmt->execute()) {
			$result = "ok";
		} else {
			$result = "error";
		}

		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlGetConceptos($idPartida)
	{
		$pdo = Conexion::conectar();
		$sql = "SELECT * FROM montrer_conceptos WHERE idPartida = :idPartida";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idPartida', $idPartida, PDO::PARAM_INT);
		$stmt->execute();

		$result = $stmt->fetchAll();

		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlGetConcepto($idConcepto)
	{
		$pdo = Conexion::conectar();
		$sql = "SELECT * FROM montrer_conceptos WHERE idConcepto = :idConcepto";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idConcepto', $idConcepto, PDO::PARAM_INT);
		$stmt->execute();

		$result = $stmt->fetch();

		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlEditConcepto($idConcepto, $concepto, $numeroConcepto)
	{
		$pdo = Conexion::conectar();
		$sql = "UPDATE montrer_conceptos SET concepto = :concepto, numeroConcepto = :numeroConcepto WHERE idConcepto = :idConcepto";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idConcepto', $idConcepto, PDO::PARAM_INT);
		$stmt->bindParam(':concepto', $concepto, PDO::PARAM_STR);
		$stmt->bindParam(':numeroConcepto', $numeroConcepto, PDO::PARAM_STR);

		if ($stmt->execute()) {
			$result = ["success" => "ok"];
		} else {
			$result = ["error" => "Error al editar concepto"];
		}

		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlAddConcepto($idPartida, $concepto, $numeroConcepto)
	{
		$pdo = Conexion::conectar();
		$sql = "INSERT INTO montrer_conceptos (concepto, numeroConcepto, idPartida) VALUES (:concepto, :numeroConcepto, :idPartida)";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':concepto', $concepto, PDO::PARAM_STR);
		$stmt->bindParam(':numeroConcepto', $numeroConcepto, PDO::PARAM_STR);
		$stmt->bindParam(':idPartida', $idPartida, PDO::PARAM_INT);

		if ($stmt->execute()) {
			$result = ["success" => "ok", "id" => $pdo->lastInsertId()];
		} else {
			$result = ["error" => "Error al agregar concepto"];
		}

		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlDeleteConcepto($idConcepto)
	{
		$pdo = Conexion::conectar();
		$sql = "DELETE FROM montrer_conceptos WHERE idConcepto = :idConcepto";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idConcepto', $idConcepto, PDO::PARAM_INT);

		if ($stmt->execute()) {
			$result = ["success" => "ok"];
		} else {
			$result = ["error" => "Error al eliminar concepto"];
		}

		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlSelectAccounts($idArea)
	{
		$pdo = Conexion::conectar();
		if ($idArea == null) {
			$sql = "SELECT * FROM montrer_cuentas c LEFT JOIN montrer_area a ON c.idArea = a.idArea WHERE c.status = 1";
		} else {
			$sql = "SELECT * FROM montrer_cuentas c LEFT JOIN montrer_area a ON c.idArea = a.idArea WHERE c.idArea = :idArea AND c.status = 1";
		}
		$stmt = $pdo->prepare($sql);
		if ($idArea != null) {
			$stmt->bindParam(':idArea', $idArea, PDO::PARAM_INT);
		}
		$stmt->execute();

		$result = $stmt->fetchAll();

		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlSelectPartidas($idCuenta)
	{
		$pdo = Conexion::conectar();
		$sql = "SELECT * FROM montrer_partidas p LEFT JOIN montrer_cuentas c ON c.idCuenta = p.idCuenta LEFT JOIN montrer_area a ON c.idArea = a.idArea where p.idCuenta = :idCuenta AND p.status = 1";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':idCuenta', $idCuenta, PDO::PARAM_INT);
		$stmt->execute();

		$result = $stmt->fetchAll();

		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlAddSubpartida($nombre, $idArea) {
		$pdo = Conexion::conectar();
		$sql = 'INSERT INTO montrer_subpartidas (nombre, idArea) VALUES (:nombre, :idArea)';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':idArea', $idArea, PDO::PARAM_INT);
		
		if ($stmt->execute()) {
			$result = ["success" => "ok"];
		} else {
			$result = ["error" => "Error al eliminar concepto"];
		}

		$stmt->closeCursor();
		$stmt = null;
		return $result;
	}

	static public function mdlGetSubpartidas() {
		$pdo = Conexion::conectar();
		$sql = "";
	}
}
