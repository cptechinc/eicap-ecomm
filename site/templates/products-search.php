<?php
	use Dplus\Content\PaginatorBootstrap4;

	$q = $input->get->text('q');
	$page->title = $input->get->q ? "Searching for '$q'" : "Search Products";

	// Processwire Selectors
	// https://processwire.com/api/selectors/
	$selector = "template=product|imitem, title|body|itemid|name1|name2%=$q";
	$limit = 10;
	$start = $input->pageNum > 1 ? $input->pageNum * $limit : 0;
	$selector .= ", limit=$limit, start=$start";
	$resultcount = $pages->count($selector);

	$items = $pages->find($selector);

	if ($input->get->ordn) {
		$page->formaction = "{$config->pages->orders}redir/";
		$page->ordn = $input->get->text('ordn');
		$page->action = "add-to-order";
	} else {
		$page->formaction = "{$config->pages->cart}redir/";
		$page->action = "add-to-cart";
		$page->ordn = false;
	}

	if ($input->get->page) {
		$returnurl = $input->get->text('page');
	} else {
		$returnurl = $page->url;
	}

	if ($config->ajax) {
		$ajax = 'data-loadinto=".modal-content" data-focus=".modal-content"';
		$paginator = new PaginatorBootstrap4($input->pageNum, $resultcount, $page->fullURL, $page->name, $ajax);

		$modal_id = 'item-search';
		// $page->body = $config->paths->content."products/search/results-ajax.php";
		$page->body = $config->twig->render('products/item-ajax.twig', ['page' => $page, 'pages' => $pages, 'items' => $items, 'modal_id' => $modal_id, 'returnurl' => $returnurl, 'paginator' => $paginator]);
		if ($config->modal) {
			// include('./_include-ajax-modal.php');
			include __DIR__ . "/_include-ajax-modal.php";
		}
	} else {
		$paginator = new PaginatorBootstrap4($input->pageNum, $resultcount, $page->fullURL, $page->name);
		$page->body = $config->twig->render('products/item-list.twig', ['page' => $page, 'items' => $items, 'q' => $q, 'paginator' => $paginator]);
		include __DIR__ . "/basic-page.php";
	}
