<?php
	$item_category = $page;
	$items = $item_category->children();

	$search = $pages->get('template=products-search');

	if ($input->get->ordn) {
		$ordn = $input->get->ordn;
	}

	$page->body =  $config->twig->render('products/item.twig', ['items' => $items, 'item_category' => $item_category, 'search' => $search, 'ordn' => $ordn]);
	include __DIR__ . "/basic-page.php";
