<?php
    $cartdisplay = new Dplus\Dpluso\OrderDisplays\CartDisplay(session_id(), $page->fullURL, '#ajax-modal');
    $cart = $cartdisplay->get_cartquote();

	if (!empty($cart->custid) && $cart->custid != $config->defaultcustid) {
        $details = get_cartdetails(session_id());

        $search = $pages->get('/products/search/');
        $customers = $pages->get('/customers/');

        $page->formaction = $config->pages->root.'cart/redir/';
        $delete_line = $formaction. '?action=remove-line&line=';
        $create_salesorder = $formaction. '?action=create-sales-order';

		$page->title = "Cart for ".Customer::get_customernamefromid($cart->custid);
        // $page->body = "{$config->paths->content}cart/cart-outline.php";
        $page->body = $config->twig->render('cart/cart-outline.twig', ['page' => $page, 'cartdisplay' => $cartdisplay, 'details' => $details, 'formaction' => $formaction, 'search' => $search, 'customers' => $customers, 'delete_line' => $delete_line, 'create_salesorder' => $create_salesorder, 'cart' => $cart]);
		include __DIR__ . "/basic-page.php";
	} else {
		$input->get->function = 'cart';
		$page->title = "Choose a Customer";
		$page->body = "{$config->paths->content}customer/index/search-form.php";
	}

	include('./_include-page.php');
?>
