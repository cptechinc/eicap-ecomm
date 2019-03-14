<?php
	$programs = $roles->find('name*=program-');

	if ($user->is_admin()) {
		$page->body = $config->twig->render('programs/programs-admin.twig', ['page' => $page, 'pages' => $pages, 'programs' => $programs]);
	} else {
		$page->body = $config->twig->render('common/error-page.twig', ['title' => 'Error!', 'msg' => "You don't have permission to this function"]);
	}

	include __DIR__ . "/basic-page.php";
