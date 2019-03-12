<?php
	$item_categories = $page->children("template!=products-search");

	$search = $pages->get('template=products-search');

	$page->ordn = ($input->get->ordn) ? $input->get->text('ordn') : false;

	$page->body = $config->twig->render('products/item-categories.twig', ['page' => $page, 'pages' => $pages, 'item_categories' => $item_categories, 'search' => $search, 'ordn' => $ordn]);
	include __DIR__ . "/basic-page.php";
