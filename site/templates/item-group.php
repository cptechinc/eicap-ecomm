<?php
	use Dplus\Content\PaginatorBootstrap4;

	$items = $page->children();
	$search = $pages->get('template=products-search');
	$formaction = "{$config->pages->cart}redir/";
	$action = "add-to-cart";

	if ($input->get->ordn) {
		$ordn = $input->get->ordn;
	}

	$resultcount = $page->numChildren();

	$limit = 10;
	$pagenbr = $input->pageNum;
	$start = $input->pageNum > 1 ? $input->pageNum * $limit : 0;

	$totalpages = ceil($resultcount/$limit);

	$paginator = new PaginatorBootstrap4($input->pageNum, $resultcount, $page->fullURL, $page->name);

	$page->body = $config->twig->render('products/item.twig', ['items' => $items, 'page' => $page, 'page_title' => $page->title, 'search' => $search, 'ordn' => $ordn, 'formaction' => $formaction, 'action' => $action, 'paginator' => $paginator]);
	include __DIR__ . "/basic-page.php";
