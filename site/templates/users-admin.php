<?php
	import_logmintoprocesswire();

	$appusers = $users->find('template=user, name!=guest|apache');
	$logmuser = new LogmUser();

	$programs = $pages->get('/config/programs/')->children();

	if ($user->is_admin()) {
		$page->body = $config->twig->render('user/users-admin.twig', ['page' => $page, 'appusers' => $appusers, 'logmuser' => $logmuser, 'config' => $config, 'programs' => $programs]);
	} else {
		$page->body = $config->twig->render('common/error-page.twig', ['title' => 'Error!', 'msg' => "You don't have permission to this function"]);
	}
	include __DIR__ . "/basic-page.php";
