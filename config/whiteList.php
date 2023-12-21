<?php

	$pagina = $_GET['pagina'] ?? 'inicio';
	$navs = ['inicio', 'registers', 'register'];

	if (in_array($pagina, $navs)) {
		include "view/pages/navs/header.php";
		include "view/pages/navs/sidenav.php";
	}
	
	if (isset($_SESSION['sesion']) && $_GET["pagina"] != 'Login'){
		if ($pagina == 'register' || $pagina == 'registers') {
			include "view/pages/register/$pagina.php";
		} elseif ($pagina == 'inicio') {
			include "view/pages/$pagina.php";
		}else {
			include "view/pages/404.php";
		}
	} elseif ($pagina == 'login') {
		include "view/pages/login/$pagina.php";
	} 