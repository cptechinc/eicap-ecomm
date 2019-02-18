<?php
	$item_categories = $page->children("template!=products-search");

	$search = $pages->get('template=products-search');

	if ($input->get->ordn) {
		$ordn = $input->get->ordn;
	}

	$page->body = $config->twig->render('products/item-categories.twig', ['page' => $page, 'item_categories' => $item_categories, 'search' => $search, 'ordn' => $ordn]);
	include __DIR__ . "/basic-page.php";
