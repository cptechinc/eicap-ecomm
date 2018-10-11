<?php
    $cartdisplay = new CartDisplay(session_id(), $page->fullURL, '#ajax-modal');
    $cart = $cartdisplay->get_cartquote();
	
	if (!empty($cart->custid) && $cart->custid != $config->defaultcustid) {
		$page->title = "Cart for ".Customer::get_customernamefromid($cart->custid);
        $page->body = "{$config->paths->content}cart/cart-outline.php";
	} else {
		$input->get->function = 'cart';
		$page->title = "Choose a Customer";
		$page->body = "{$config->paths->content}customer/index/search-form.php";
	}
	
	include('./_include-page.php');
?>
