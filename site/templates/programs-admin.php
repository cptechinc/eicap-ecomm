<?php
	$programs = $roles->find('name*=program-');

	$page->body = $config->twig->render('program/programs-admin.twig', ['page' => $page, 'pages' => $pages, 'programs' => $programs]);
	include __DIR__ . "/basic-page.php";
