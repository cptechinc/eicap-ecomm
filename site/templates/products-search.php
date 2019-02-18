<?php
	$q = $input->get->text('q');
	$page->title = $input->get->q ? "Searching for '$q'" : "Search Products";

	// Processwire Selectors
	// https://processwire.com/api/selectors/
	$selector = "template=product|imitem, title|body|itemid|name1|name2%=$q";

	if ($config->ajax) {
		$limit = 10;
		$start = $input->pageNum > 1 ? $input->pageNum * $limit : 0;
		$selector .= ", limit=$limit, start=$start";
	}

	$resultcount = $pages->count($selector);
	$items = $pages->find($selector);

	if ($input->get->ordn) {
		$formaction = "{$config->pages->orders}redir/";
		$ordn = $input->get->ordn;
		$action = "add-to-order";
	} else {
		$formaction = "{$config->pages->cart}redir/";
		$action = "add-to-order";
	}

	if ($config->ajax) {
		$page->body = $config->paths->content."products/search/results-ajax.php";
		if ($config->modal) {
			include('./_include-ajax-modal.php');
		}
	} else {
		$page->body = $config->twig->render('products/item.twig', ['page' => $page, 'page_title' => $page->title, 'items' => $items, 'search' => $search, 'ordn' => $ordn, 'formaction' => $formaction, 'action' => $action]);
		include __DIR__ . "/basic-page.php";
	}
