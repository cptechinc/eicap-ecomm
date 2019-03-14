<?php
	include('./_head-blank.php');

	$errormsg = get_loginerrormsg(session_id());
	$date = date('Y');

	$config->twig->display('login.twig', ['user' => $user, 'pages' => $pages, 'site' => $site, 'errormsg' => $errormsg, 'date' => $date]);

	include('./_foot-blank.php'); ?>
