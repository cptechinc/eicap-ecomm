<?php
	$item_category = $page;
	$items = $item_category->children();

	$page->body =  $config->twig->render('products/item.twig', ['items' => $items, 'item_category' => $item_category]);
	include __DIR__ . "/basic-page.php";
