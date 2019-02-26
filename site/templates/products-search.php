<?php
	use Dplus\Content\PaginatorBootstrap4;

	$q = $input->get->text('q');
	$page->title = $input->get->q ? "Searching for '$q'" : "Search Products";

	// Processwire Selectors
	// https://processwire.com/api/selectors/
	$selector = "template=product|imitem, title|body|itemid|name1|name2%=$q";
	$search = $pages->get('template=products-search');
	$limit = 10;
	$start = $input->pageNum > 1 ? $input->pageNum * $limit : 0;
	$selector .= ", limit=$limit, start=$start";
	$resultcount = $pages->count($selector);

	$items = $pages->find($selector);

	if ($input->get->ordn) {
		$formaction = "{$config->pages->orders}redir/";
		$ordn = $input->get->ordn;
		$action = "add-to-order";
	} else {
		$formaction = "{$config->pages->cart}redir/";
		$action = "add-to-cart";
	}

	if ($config->ajax) {
		$ajax = 'data-loadinto=".modal-content" data-focus=".modal-content"';
		$paginator = new PaginatorBootstrap4($input->pageNum, $resultcount, $page->fullURL, $page->name, $ajax);

		$modal_id = 'item-search';
		// $page->body = $config->paths->content."products/search/results-ajax.php";
		$page->body = $config->twig->render('products/item-ajax.twig', ['page' => $page, 'page_title' => $page->title, 'items' => $items, 'search' => $search, 'ordn' => $ordn, 'formaction' => $formaction, 'action' => $action, 'modal_id' => $modal_id, 'paginator' => $paginator]);
		if ($config->modal) {
			// include('./_include-ajax-modal.php');
			include __DIR__ . "/_include-ajax-modal.php";
		}
	} else {
		$paginator = new PaginatorBootstrap4($input->pageNum, $resultcount, $page->fullURL, $page->name);
		$page->body = $config->twig->render('products/item.twig', ['page' => $page, 'page_title' => $page->title, 'items' => $items, 'search' => $search, 'q' => $q, 'ordn' => $ordn, 'formaction' => $formaction, 'action' => $action, 'paginator' => $paginator]);
		include __DIR__ . "/basic-page.php";
	}
