<?php
	$appusers = $users->find('template=user, name!=guest|apache');
	$logmuser = new LogmUser();

	$programs = $pages->get('/config/programs/')->children();

	$page->body = $config->twig->render('site-admin.twig', ['page' => $page, 'user' => $user, 'appusers' => $appusers, 'logmuser' => $logmuser, 'config' => $config, 'programs' => $programs]);
	include __DIR__ . "/basic-page.php";
