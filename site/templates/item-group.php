<?php
	$items = $page->children();

	$search = $pages->get('template=products-search');

	$formaction = "{$config->pages->cart}redir/";
	$action = "add-to-cart";

	if ($input->get->ordn) {
		$ordn = $input->get->ordn;
	}

	$page->body =  $config->twig->render('products/item.twig', ['items' => $items, 'page' => $page, 'page_title' => $page->title, 'search' => $search, 'ordn' => $ordn, 'formaction' => $formaction, 'action' => $action]);
	include __DIR__ . "/basic-page.php";
