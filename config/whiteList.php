<?php

	$pagina = $_GET['pagina'] ?? 'inicio';
	$navs = [
		'inicio',
		'registers',
		'register',
		'change_pass',
		'registerArea',
		'areas',
		'company',
		'registerCompany',
		'exercise',
		'registerExercise',
		'budgets',
		'registerBudgets',
		'editRegister',
		'editArea',
		'editExercise',
		'editBudgets',
		'changePassword',
		'provider',
		'registerProvider',
		'editProvider',
		'requestBudget',
	];


	if (in_array($pagina, $navs)) {
		include "view/pages/navs/header.php";
		include "view/pages/navs/sidenav.php";
	}
	
	if (isset($_SESSION['sesion']) && $pagina != 'login'){
		if ($pagina == 'register' || $pagina == 'registers' || $pagina == 'editRegister') {
			include "view/pages/register/$pagina.php";
		} elseif ($pagina == 'inicio') {
			include "view/pages/$pagina.php";
		} elseif ($pagina == 'change_pass' || $pagina == 'changePassword') {
			include "view/pages/login/$pagina.php";
		} elseif ($pagina == 'registerArea' || $pagina == 'areas' || $pagina == 'editArea') {
			include "view/pages/area/$pagina.php";
		} elseif ($pagina == 'company' || $pagina == 'registerCompany') {
			include "view/pages/company/$pagina.php";
		} elseif ($pagina == 'exercise' || $pagina == 'registerExercise' || $pagina == 'editExercise') {
			include "view/pages/ejercicio/$pagina.php";
		} elseif ($pagina == 'budgets' || $pagina == 'registerBudgets' || $pagina == 'editBudgets') {
			include "view/pages/budgets/$pagina.php";
		} elseif ($pagina == 'provider' || $pagina == 'registerProvider' || $pagina == 'editProvider') {
			include "view/pages/provider/$pagina.php";
		} elseif ($pagina == 'requestBudget' || $pagina == 'registerRequestBudget' || $pagina == 'editRequestBudget') {
			include "view/pages/request_budget/$pagina.php";
		} else {
			include "view/pages/404.php";
		}
	} elseif ($pagina == 'login') {
		include "view/pages/login/$pagina.php";
	} 