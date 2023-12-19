<?php
	$pagina = $_GET['pagina'] ?? 'inicio';
	$navs = ['inicio', 'registers'];

	if (in_array($pagina, $navs)) {
		include "view/pages/navs/header.php";
		include "view/pages/navs/sidenav.php";
	}

	if ($pagina == 'register' || $pagina == 'registers') {
		include "view/pages/register/$pagina.php";
	} elseif ($pagina == 'inicio') {
		include "view/pages/$pagina.php";
	} else {
		include "view/pages/404.php";
	}