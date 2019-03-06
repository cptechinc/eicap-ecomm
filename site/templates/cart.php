<?php
    use Dplus\Dpluso\Customer\CustomerIndex;
    use Dplus\Content\PaginatorBootstrap4;

    $cartdisplay = new Dplus\Dpluso\OrderDisplays\CartDisplay(session_id(), $page->fullURL, '#ajax-modal');
    $cart = $cartdisplay->get_cartquote();

	if (!empty($cart->custid) && $cart->custid != $config->defaultcustid) {
        $details = get_cartdetails(session_id());

        $page->formaction = $config->pages->root.'cart/redir/';
        $delete_line = $page->formaction. '?action=remove-line&line=';
        $create_salesorder = $page->formaction. '?action=create-sales-order';

		$page->title = "Cart for ".Customer::get_customernamefromid($cart->custid);

        $page->body = $config->twig->render('cart/cart-outline.twig', ['page' => $page, 'pages' => $pages, 'cartdisplay' => $cartdisplay, 'details' => $details, 'delete_line' => $delete_line, 'create_salesorder' => $create_salesorder, 'cart' => $cart]);
		include __DIR__ . "/basic-page.php";
	} else {
        $page->title = "Choose a Customer";
        $q = $input->get->text('q');
        $customersearch = $pages->get('/customers/')->url;
        $input->get->function = 'cart';

    	$pageurl = new Purl\Url($page->fullURL->getUrl());
    	$pageurl->path = $config->pages->customer;
    	$pageurl->query->set('function', 'cart');

    	$custindex = new CustomerIndex($pageurl, '#cust-index-search-form', '#cust-index-search-form');
    	$custindex->set_pagenbr($input->pageNum);
    	$resultscount = $custindex->count_searchcustindex($q);
    	$paginator = new PaginatorBootstrap4($custindex->pagenbr, $resultscount, $custindex->pageurl, 'customers', $custindex->ajaxdata);

		$page->body = $config->twig->render('customer/search-form.twig', ['page' => $page, 'customersearch' => $customersearch, 'resultscount' => $resultscount, 'custindex' => $custindex, 'input' => $q, 'function' => $input->get->function, 'paginator' => $paginator]);
        include __DIR__ . "/basic-page.php";
	}
?>
