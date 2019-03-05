<?php
	$page->body = $config->twig->render('home.twig', ['user' => $user, 'pages' => $pages]);
	include __DIR__ . "/basic-page.php";
