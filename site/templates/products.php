<?php
	$products = $page;
	$item_categories = $products->children("template!=products-search");

	$page->body =  $config->twig->render('products/item-categories.twig', ['item_categories' => $item_categories, 'products' => $products]);
	include __DIR__ . "/basic-page.php";
