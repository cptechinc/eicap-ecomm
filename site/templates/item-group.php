<?php
	use Dplus\Content\PaginatorBootstrap4;

	$limit = 10;
	$start = $input->pageNum > 1 ? $input->pageNum * $limit : 0;
	$selector = "limit=$limit, start=$start";

	$items = $page->children($selector);
	$search = $pages->get('template=products-search');
	$page->formaction = "{$config->pages->cart}redir/";
	$page->action = "add-to-cart";

	$page->ordn = ($input->get->ordn) ? $input->get->text('ordn') : false;

	$resultcount = $page->numChildren();

	$totalpages = ceil($resultcount/$limit);

	$paginator = new PaginatorBootstrap4($input->pageNum, $resultcount, $page->fullURL, $page->name);

	$page->body = $config->twig->render('products/item-list.twig', ['items' => $items, 'page' => $page, 'search' => $search, 'paginator' => $paginator]);
	include __DIR__ . "/basic-page.php";
