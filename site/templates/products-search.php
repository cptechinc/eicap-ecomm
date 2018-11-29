<?php 
	$q = $input->get->text('q');
	$page->title = $input->get->q ? "Searching for '$q'" : "Search Products";
	
	$selector = "template=product|imitem, title|body|itemid|name1|name2*=$q";
	
	if ($config->ajax) {
		$limit = 10;
		$start = $input->pageNum > 1 ? $input->pageNum * $limit : 0;
		$selector .= ", limit=$limit, start=$start";
	}
	
	$resultcount = $pages->count($selector);
	$products = $pages->find($selector);

	if ($config->ajax) {
		$page->body = $config->paths->content."products/search/results-ajax.php";
		if ($config->modal) {
			include('./_include-ajax-modal.php'); 
		}
	} else {
		$page->body = $config->paths->content."products/search/results.php";
		include('./_include-page.php'); 
	}
