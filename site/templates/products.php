<?php
	$products = $page;
	$item_categories = $products->children("template!=products-search");

	$search = $pages->get('template=products-search');

	if ($input->get->ordn) {
		$ordn = $input->get->ordn;
	}

	$page->body =  $config->twig->render('products/item-categories.twig', ['item_categories' => $item_categories, 'products' => $products, 'search' => $search, 'ordn' => $ordn]);
	include __DIR__ . "/basic-page.php";
