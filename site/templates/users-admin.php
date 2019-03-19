<?php
	import_logmintoprocesswire();

	$appusers = $users->find('template=user, name!=guest|apache');
	$logmuser = new LogmUser();

	$programs = $modules->get('EicapPrograms')->get_programs();

	if ($user->is_admin()) {
		$page->body = $config->twig->render('user/users-admin.twig', ['page' => $page, 'appusers' => $appusers, 'programs' => $programs]);
	} else {
		$page->body = $config->twig->render('common/error-page.twig', ['title' => 'Error!', 'msg' => "You don't have permission to this function"]);
	}
	include __DIR__ . "/basic-page.php";
