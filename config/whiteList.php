<?php

	$pagina = $_GET['pagina'] ?? 'inicio';
	$navs = ['inicio', 'registers', 'register', 'change_pass', 'registerArea', 'areas', 'company', 'registerCompany', 'exercise', 'registerExercise', 'budgets', 'registerBudgets', 'editRegister'];


	if (in_array($pagina, $navs)) {
		include "view/pages/navs/header.php";
		include "view/pages/navs/sidenav.php";
	}
	
	if (isset($_SESSION['sesion']) && $pagina != 'login'){
		if ($pagina == 'register' || $pagina == 'registers' || $pagina == 'editRegister') {
			include "view/pages/register/$pagina.php";
		} elseif ($pagina == 'inicio') {
			include "view/pages/$pagina.php";
		} elseif ($pagina == 'change_pass') {
			include "view/pages/login/$pagina.php";
		} elseif ($pagina == 'registerArea' || $pagina == 'areas') {
			include "view/pages/area/$pagina.php";
		} elseif ($pagina == 'company' || $pagina == 'registerCompany') {
			include "view/pages/company/$pagina.php";
		} elseif ($pagina == 'exercise' || $pagina == 'registerExercise') {
			include "view/pages/ejercicio/$pagina.php";
		} elseif ($pagina == 'budgets' || $pagina == 'registerBudgets') {
			include "view/pages/budgets/$pagina.php";
		} else {
			include "view/pages/404.php";
		}
	} elseif ($pagina == 'login') {
		include "view/pages/login/$pagina.php";
	} 